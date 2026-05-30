#!/usr/bin/env python3
"""Scrape all tours from niagarafallstour.com and output as JSON for import."""

import json
import re
import sys
import time
from urllib.request import urlopen, Request
from urllib.parse import urljoin

BASE = 'https://www.niagarafallstour.com'


def fetch(url):
    req = Request(url, headers={'User-Agent': 'Mozilla/5.0'})
    with urlopen(req, timeout=30) as resp:
        return resp.read().decode('utf-8')


class DataExtractor:
    def __init__(self, html, url):
        self.html = html
        self.url = url
        self.data = {
            'source_url': url,
            'title': '',
            'slug': url.rstrip('/').rsplit('/', 1)[-1],
            'short_description': '',
            'description': '',
            'location': 'Niagara Falls, ON',
            'duration': 8,
            'duration_type': 'hours',
            'price': 0,
            'sale_price': None,
            'max_people': 50,
            'images': [],
            'featured_image': '',
            'highlights': [],
            'inclusions': [],
            'exclusions': [],
            'itinerary': [],
            'faqs': [],
            'is_featured': False,
            'is_active': True,
            'pricing': [],
            'meta_title': '',
            'meta_description': '',
        }

    def extract(self):
        self._extract_meta()
        self._extract_jsonld()
        self._extract_overview()
        self._extract_html_itinerary()
        self._extract_inclusions()
        self._extract_exclusions()
        self._extract_gallery()
        self._extract_faq()
        self._determine_price()
        self._cleanup()
        return self.data

    def _cleanup(self):
        self.data['title'] = self.data['title'].strip()
        self.data['short_description'] = self.data['short_description'].strip()
        self.data['description'] = self.data['description'].strip()

    def _extract_meta(self):
        m = re.search(r'<title>(.*?)</title>', self.html, re.DOTALL)
        if m:
            self.data['title'] = m.group(1).strip()
            for suffix in [' - Book Now! Niagara Falls Tour',
                           ' - Niagara Falls Tour',
                           ' | Niagara Falls Tour',
                           ' - Book Now!']:
                if suffix in self.data['title']:
                    self.data['title'] = self.data['title'].split(suffix)[0].strip()
        m = re.search(r'<meta\s+name=["\']description["\'][^>]*content=["\']([^"\']*)["\']', self.html)
        if m:
            desc = m.group(1).strip()
            self.data['short_description'] = desc
            self.data['meta_description'] = desc

    def _extract_jsonld(self):
        scripts = re.findall(
            r'<script[^>]*type=["\']application/ld\+json["\'][^>]*>(.*?)</script>',
            self.html, re.DOTALL
        )
        for script in scripts:
            try:
                obj = json.loads(script)
            except json.JSONDecodeError:
                continue
            self._process_jsonld(obj)

    def _process_jsonld(self, obj):
        if not isinstance(obj, dict):
            return
        ld_type = obj.get('@type', '')
        if ld_type == 'TouristTrip':
            if obj.get('name'):
                self.data['title'] = obj['name']
            if obj.get('description'):
                self.data['short_description'] = obj['description']
                self.data['meta_description'] = obj['description']
            if obj.get('image'):
                self.data['featured_image'] = self._abs_url(obj['image'])
            if obj.get('touristType'):
                if isinstance(obj['touristType'], list):
                    self.data['highlights'] = obj['touristType']
            offers = obj.get('offers', {})
            if offers and isinstance(offers, dict):
                price_str = offers.get('price', '').replace('$', '').replace(',', '').strip()
                try:
                    self.data['price'] = float(price_str)
                except ValueError:
                    pass
            desc = obj.get('description', '')
            m = re.search(
                r'Duration\s*[-:]\s*(\d+)\s*(Hours?|Days?|Weeks?)',
                desc, re.IGNORECASE
            )
            if m:
                self.data['duration'] = int(m.group(1))
                dur = m.group(2).lower()
                if dur.startswith('hour'):
                    self.data['duration_type'] = 'hours'
                elif dur.startswith('day'):
                    self.data['duration_type'] = 'days'
                else:
                    self.data['duration_type'] = 'weeks'
            m = re.search(r'Location\s*[-:]\s*([^,]+)', desc, re.IGNORECASE)
            if m:
                self.data['location'] = m.group(1).strip()
            itinerary = obj.get('itinerary', {})
            if itinerary and isinstance(itinerary, dict):
                items = itinerary.get('itemListElement', [])
                for item in items:
                    if isinstance(item, dict):
                        attraction = item.get('item', {})
                        if isinstance(attraction, dict):
                            name = attraction.get('name', '')
                            desc_text = attraction.get('description', '')
                            if name:
                                self.data['itinerary'].append({
                                    'title': name.strip(),
                                    'description': desc_text.strip(),
                                })
        # Don't extract price from LocalBusiness.priceRange — it's a range
        # like "$139 - $2,299" that doesn't represent the specific tour price.

    def _extract_overview(self):
        """Extract description from the schedule tab."""
        m = re.search(r'id="schedule"[^>]*>(.*?)(?:</div>\s*</div>)', self.html, re.DOTALL)
        if m:
            text = re.sub(r'<[^>]+>', '', m.group(1))
            text = re.sub(r'\s+', ' ', text).strip()
            self.data['description'] = text

    def _extract_html_itinerary(self):
        """Fallback: extract itinerary from HTML if JSON-LD didn't have it."""
        if self.data['itinerary']:
            return

        # Pattern 1: <ul class="schedule_list"> with <li><span>N.</span><h3>Title</h3><div>Desc</div>
        ul_m = re.search(
            r'<ul[^>]*class="schedule_list"[^>]*>(.*?)</ul>',
            self.html, re.DOTALL
        )
        if ul_m:
            items = re.findall(
                r'<li[^>]*>.*?<h3>(.*?)</h3>\s*<div[^>]*>(.*?)</div>',
                ul_m.group(1), re.DOTALL
            )
            for heading, desc_div in items:
                name = re.sub(r'<[^>]+>', '', heading).strip()
                desc = re.sub(r'<[^>]+>', '', desc_div).strip()
                desc = re.sub(r'\s+', ' ', desc)
                if name and len(name) > 3:
                    self.data['itinerary'].append({
                        'title': name,
                        'description': desc,
                    })
            if self.data['itinerary']:
                return

        # Pattern 2: h4 + div from schedule tab
        m = re.search(
            r'id="schedule"[^>]*>(.*?)(?:<h[1-6][^>]*>.*?Exclusion|</section>|</div>\s*<a)',
            self.html, re.DOTALL
        )
        if m:
            items = re.findall(
                r'<h4[^>]*>(.*?)</h4>\s*<div[^>]*>(.*?)</div>',
                m.group(1), re.DOTALL
            )
            for heading, desc_div in items:
                name = re.sub(r'<[^>]+>', '', heading).strip()
                desc = re.sub(r'<[^>]+>', '', desc_div).strip()
                desc = re.sub(r'\s+', ' ', desc)
                if name and len(name) > 3:
                    self.data['itinerary'].append({
                        'title': name,
                        'description': desc,
                    })

    def _extract_inclusions(self):
        """Extract the Inclusions list."""
        m = re.search(r'Inclusions\s*</h[1-6]>\s*(.*?)(?:</div>\s*<\w)', self.html, re.DOTALL | re.IGNORECASE)
        if m:
            items = re.findall(r'<li[^>]*>(.*?)</li>', m.group(1), re.DOTALL)
            if items:
                self.data['inclusions'] = [
                    re.sub(r'<[^>]+>', '', i).strip() for i in items if i.strip()
                ]
            else:
                text = re.sub(r'<[^>]+>', ' ', m.group(1))
                lines = [l.strip() for l in text.split('.') if l.strip()]
                self.data['inclusions'] = lines

    def _extract_exclusions(self):
        """Extract the Exclusions list."""
        m = re.search(r'Exclusions\s*</h[1-6]>\s*(.*?)(?:</div>\s*<\w)', self.html, re.DOTALL | re.IGNORECASE)
        if not m:
            m = re.search(r'class="[^"]*exclusion[^"]*"[^>]*>(.*?)(?:</div>\s*<)', self.html, re.DOTALL | re.IGNORECASE)
        if m:
            items = re.findall(r'<li[^>]*>(.*?)</li>', m.group(1), re.DOTALL)
            if items:
                self.data['exclusions'] = [
                    re.sub(r'<[^>]+>', '', i).strip() for i in items if i.strip()
                ]

    def _extract_gallery(self):
        """Extract gallery images from /uploads/tours/ paths."""
        imgs = re.findall(r'(/uploads/tours/[^"\'?\s]+)', self.html)
        seen = set()
        for img in imgs:
            full = urljoin(BASE, img)
            if full not in seen:
                seen.add(full)
                self.data['images'].append(full)
        # Keep both thumb and full — frontend handles display
        if not self.data['featured_image'] and self.data['images']:
            # Pick the first non-thumb image
            fulls = [i for i in self.data['images'] if '/thumb/' not in i]
            self.data['featured_image'] = fulls[0] if fulls else self.data['images'][0]

    def _extract_faq(self):
        """Extract FAQ items from accordion pattern on the whole page."""
        panels = re.findall(
            r'<div[^>]*class="panel panel-default"[^>]*>.*?</div>\s*</div>',
            self.html, re.DOTALL
        )
        for panel in panels:
            q_match = re.search(r'<a[^>]*class="[^"]*ing"[^>]*>(.*?)</a>', panel, re.DOTALL)
            a_match = re.search(
                r'<div[^>]*class="panel-body"[^>]*>(.*?)</div>', panel, re.DOTALL
            )
            if q_match and a_match:
                q = re.sub(r'<[^>]+>', '', q_match.group(1)).strip()
                a = re.sub(r'<[^>]+>', '', a_match.group(1)).strip()
                if q and a:
                    self.data['faqs'].append({'question': q, 'answer': a})

    def _determine_price(self):
        if self.data['price'] > 0:
            return
        # Try to find a price from any JSON-LD (Offer.price, etc.)
        scripts = re.findall(
            r'<script[^>]*type=["\']application/ld\+json["\'][^>]*>(.*?)</script>',
            self.html, re.DOTALL
        )
        for script in scripts:
            m = re.search(r'"price"\s*:\s*"\\?\$?\s*(\d+[\d,.]*)"', script)
            if m:
                try:
                    self.data['price'] = float(m.group(1).replace(',', ''))
                    return
                except ValueError:
                    pass
        # Look for "From $XXX" pattern (most specific to the tour price)
        m = re.search(r'\bFrom\s*:\s*\$\s*(\d[\d,]*)', self.html, re.IGNORECASE)
        if m:
            try:
                self.data['price'] = float(m.group(1).replace(',', ''))
                return
            except ValueError:
                pass
        m = re.search(r'\bFrom\s+\$\s*(\d[\d,]*)', self.html, re.IGNORECASE)
        if m:
            try:
                self.data['price'] = float(m.group(1).replace(',', ''))
                return
            except ValueError:
                pass
        # Check price range pattern
        m = re.search(r'\$\s*(\d[\d,]*)\s*[-–]\s*\$\s*(\d[\d,]*)', self.html)
        if m:
            try:
                low = float(m.group(1).replace(',', ''))
                high = float(m.group(2).replace(',', ''))
                self.data['price'] = low
                self.data['sale_price'] = high
                return
            except ValueError:
                pass
        # Look for price in a price-specific element
        m = re.search(r'<span[^>]*class="[^"]*price[^"]*"[^>]*>\s*\$(\d[\d,]*)', self.html)
        if m:
            try:
                self.data['price'] = float(m.group(1).replace(',', ''))
                return
            except ValueError:
                pass
        # Last resort: single dollar amount
        m = re.search(r'\$\s*(\d[\d,]*)', self.html)
        if m:
            try:
                self.data['price'] = float(m.group(1).replace(',', ''))
            except ValueError:
                pass

    def _abs_url(self, url):
        if url.startswith('http'):
            return url
        return urljoin(BASE, url)


def main():
    # Fetch homepage to get tour URLs
    print("Fetching homepage...", file=sys.stderr)
    listing_html = fetch(BASE)

    # Extract tour URLs from /canada/ paths
    tour_urls = re.findall(r'href="([^"]*/canada/[^"]*)"', listing_html)
    tour_urls = sorted(set(tour_urls))
    print(f"Found {len(tour_urls)} tours", file=sys.stderr)

    all_tours = []
    for i, url in enumerate(tour_urls, 1):
        print(f"[{i}/{len(tour_urls)}] {url}...", file=sys.stderr)
        try:
            html = fetch(url)
            extractor = DataExtractor(html, url)
            data = extractor.extract()
            all_tours.append(data)
            print(f"  -> {data['title'][:60]} (${data['price']})  itinerary:{len(data['itinerary'])} faqs:{len(data['faqs'])}", file=sys.stderr)
        except Exception as e:
            print(f"  ERROR: {e}", file=sys.stderr)
        time.sleep(1.5)

    print(json.dumps(all_tours, indent=2))


if __name__ == '__main__':
    main()
