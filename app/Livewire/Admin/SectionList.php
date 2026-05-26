<?php

namespace App\Livewire\Admin;

use App\Models\Destination;
use App\Models\HomepageSection;
use App\Models\Tour;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Title('Homepage')]
#[Layout('layouts.admin')]
class SectionList extends Component
{
    public $editId = null;
    public $editKey;
    public $pendingSlideIndex = null;

    protected $listeners = ['mediaSelected' => 'setHeroImage'];

    public $heroSlides = [];
    public $whyTitle;
    public $whySubtitle;
    public $whyFeatures = [];
    public $ctaTitle;
    public $ctaDescription;
    public $ctaButtonText;
    public $ctaButtonLink;
    public $ctaBgImage;
    public $popTitle;
    public $popSubtitle;
    public $selectedTours = [];
    public $popToursTitle;
    public $popToursSubtitle;
    public $selectedPopularTours = [];
    public $browseTitle;
    public $browseSubtitle;

    // Features (Icon Grid)
    public $featuresTitle;
    public $featuresSubtitle;
    public $featuresItems = [];

    // Destinations
    public $destinationsTitle;
    public $destinationsSubtitle;
    public $selectedDestinations = [];

    // Policies
    public $policiesTitle;
    public $policiesItems = [];

    // FAQ
    public $faqBadgeText;
    public $faqTitle;
    public $faqItems = [];

    // Reviews
    public $reviewBadge;
    public $reviewTitle;
    public $reviewSubtitle;

    // Featured Promo
    public $promoBadge;
    public $promoTitle;
    public $promoDescription;
    public $promoButtonText;
    public $promoButtonLink;
    public $promoBgImage;

    // Blog
    public $blogBadge;
    public $blogTitle;
    public $blogViewAllLink;

    public function mount()
    {
        $this->loadSections();
    }

    public function loadSections()
    {
        $sections = HomepageSection::all()->keyBy('key');

        if ($hero = $sections->get('hero')) {
            $this->heroSlides = $hero->settings['slides'] ?? [
                ['image' => '', 'title' => '', 'description' => '', 'link_type' => 'tour', 'link_value' => null],
            ];
        }

        if ($why = $sections->get('why_choose_us')) {
            $this->whyTitle = $why->settings['title'] ?? 'Why Choose Us';
            $this->whySubtitle = $why->settings['subtitle'] ?? '';
            $this->whyFeatures = $why->settings['features'] ?? [
                ['title' => '', 'description' => ''],
            ];
        }

        if ($cta = $sections->get('cta')) {
            $this->ctaTitle = $cta->settings['title'] ?? '';
            $this->ctaDescription = $cta->settings['description'] ?? '';
            $this->ctaButtonText = $cta->settings['button_text'] ?? '';
            $this->ctaButtonLink = $cta->settings['button_link'] ?? '';
            $this->ctaBgImage = $cta->settings['background_image'] ?? '';
        }

        if ($pop = $sections->get('popular_destinations')) {
            $this->popTitle = $pop->settings['title'] ?? 'Popular Destinations';
            $this->popSubtitle = $pop->settings['subtitle'] ?? '';
            $this->selectedTours = $pop->settings['tour_ids'] ?? [];
        }

        if ($bc = $sections->get('browse_categories')) {
            $this->browseTitle = $bc->settings['title'] ?? 'Browse by Category';
            $this->browseSubtitle = $bc->settings['subtitle'] ?? '';
        }

        if ($pt = $sections->get('popular_tours')) {
            $this->popToursTitle = $pt->settings['title'] ?? 'Popular Tours';
            $this->popToursSubtitle = $pt->settings['subtitle'] ?? '';
            $this->selectedPopularTours = $pt->settings['tour_ids'] ?? [];
        }

        if ($feat = $sections->get('features')) {
            $this->featuresTitle = $feat->settings['title'] ?? 'Why Choose Niagara Tours';
            $this->featuresSubtitle = $feat->settings['subtitle'] ?? '';
            $this->featuresItems = $feat->settings['features'] ?? [
                ['icon' => '', 'title' => '', 'description' => ''],
            ];
        }

        if ($dest = $sections->get('destinations')) {
            $this->destinationsTitle = $dest->settings['title'] ?? 'Destinations Around the World';
            $this->destinationsSubtitle = $dest->settings['subtitle'] ?? '';
            $this->selectedDestinations = $dest->settings['destination_ids'] ?? [];
        }

        if ($pol = $sections->get('policies')) {
            $this->policiesTitle = $pol->settings['title'] ?? '';
            $this->policiesItems = $pol->settings['items'] ?? [
                ['image' => '', 'badge' => '', 'title' => '', 'description' => '', 'overlay_from' => '', 'overlay_to' => ''],
            ];
        }

        if ($faq = $sections->get('faq')) {
            $this->faqBadgeText = $faq->settings['badge_text'] ?? 'All Tasting Fees Are Included!';
            $this->faqTitle = $faq->settings['title'] ?? 'FREQUENTLY ASKED QUESTIONS?';
            $this->faqItems = $faq->settings['faqs'] ?? [
                ['question' => '', 'answer' => ''],
            ];
        }

        if ($review = $sections->get('reviews')) {
            $this->reviewBadge = $review->settings['badge'] ?? 'WHAT PEOPLE ARE SAYING';
            $this->reviewTitle = $review->settings['title'] ?? '5 Star Niagara Tours';
            $this->reviewSubtitle = $review->settings['subtitle'] ?? '';
        }

        if ($promo = $sections->get('featured_promo')) {
            $this->promoBadge = $promo->settings['badge'] ?? 'Now Featuring';
            $this->promoTitle = $promo->settings['title'] ?? 'Elevate Your Senses';
            $this->promoDescription = $promo->settings['description'] ?? '';
            $this->promoButtonText = $promo->settings['button_text'] ?? 'Learn More';
            $this->promoButtonLink = $promo->settings['button_link'] ?? '/tours';
            $this->promoBgImage = $promo->settings['background_image'] ?? '';
        }

        if ($blog = $sections->get('blog')) {
            $this->blogBadge = $blog->settings['badge'] ?? 'LATEST NEWS & TRENDS';
            $this->blogTitle = $blog->settings['title'] ?? 'From Our Blog';
            $this->blogViewAllLink = $blog->settings['view_all_link'] ?? '#';
        }
    }

    public function toggle($id)
    {
        $section = HomepageSection::findOrFail($id);
        $section->update(['is_enabled' => !$section->is_enabled]);
    }

    public function edit($id)
    {
        $section = HomepageSection::findOrFail($id);
        $this->editId = $id;
        $this->editKey = $section->key;
        $this->loadSections();
    }

    public function cancelEdit()
    {
        $this->editId = null;
        $this->editKey = null;
    }

    public function openMediaPickerForHero($slideIndex)
    {
        session()->put('mediaPicker_target', 'hero_slide');
        session()->put('hero_slide_index', $slideIndex);
    }

    public function openMediaPickerForCta()
    {
        session()->put('mediaPicker_target', 'cta_bg');
    }

    public function openMediaPickerForPromo()
    {
        session()->put('mediaPicker_target', 'promo_bg');
    }

    public function setHeroImage($urls)
    {
        $url = is_array($urls) ? ($urls[0] ?? null) : $urls;
        if (!$url) return;

        $target = session()->get('mediaPicker_target');

        if ($target === 'cta_bg') {
            $this->ctaBgImage = $url;
        } elseif ($target === 'promo_bg') {
            $this->promoBgImage = $url;
        } elseif ($target === 'features_icon') {
            $index = session()->get('features_icon_index');
            if ($index !== null && isset($this->featuresItems[$index])) {
                $this->featuresItems[$index]['icon'] = $url;
            }
        } elseif ($target === 'policies_image') {
            $index = session()->get('policies_image_index');
            if ($index !== null && isset($this->policiesItems[$index])) {
                $this->policiesItems[$index]['image'] = $url;
            }
        } else {
            $index = session()->get('hero_slide_index');
            if ($index !== null && isset($this->heroSlides[$index])) {
                $this->heroSlides[$index]['image'] = $url;
            }
        }

        session()->forget(['mediaPicker_target', 'hero_slide_index', 'features_icon_index', 'policies_image_index']);
    }

    public function addHeroSlide()
    {
        $this->heroSlides[] = ['image' => '', 'title' => '', 'description' => '', 'link_type' => 'tour', 'link_value' => null];
    }

    public function removeHeroSlide($index)
    {
        array_splice($this->heroSlides, $index, 1);
    }

    public function addWhyFeature()
    {
        $this->whyFeatures[] = ['title' => '', 'description' => ''];
    }

    public function removeWhyFeature($index)
    {
        array_splice($this->whyFeatures, $index, 1);
    }

    public function addFeatureItem()
    {
        $this->featuresItems[] = ['icon' => '', 'title' => '', 'description' => ''];
    }

    public function removeFeatureItem($index)
    {
        array_splice($this->featuresItems, $index, 1);
    }

    public function openMediaPickerForFeatures($index)
    {
        session()->put('mediaPicker_target', 'features_icon');
        session()->put('features_icon_index', $index);
    }

    public function openMediaPickerForPolicies($index)
    {
        session()->put('mediaPicker_target', 'policies_image');
        session()->put('policies_image_index', $index);
    }

    public function addFaqItem()
    {
        $this->faqItems[] = ['question' => '', 'answer' => ''];
    }

    public function removeFaqItem($index)
    {
        array_splice($this->faqItems, $index, 1);
    }

    public function save()
    {
        $section = HomepageSection::findOrFail($this->editId);

        $settings = match ($section->key) {
            'hero' => ['slides' => $this->heroSlides],
            'why_choose_us' => [
                'title' => $this->whyTitle,
                'subtitle' => $this->whySubtitle,
                'features' => $this->whyFeatures,
            ],
            'cta' => [
                'title' => $this->ctaTitle,
                'description' => $this->ctaDescription,
                'button_text' => $this->ctaButtonText,
                'button_link' => $this->ctaButtonLink,
                'background_image' => $this->ctaBgImage,
            ],
            'popular_destinations' => [
                'title' => $this->popTitle,
                'subtitle' => $this->popSubtitle,
                'tour_ids' => array_map('intval', $this->selectedTours),
            ],
            'popular_tours' => [
                'title' => $this->popToursTitle,
                'subtitle' => $this->popToursSubtitle,
                'tour_ids' => array_map('intval', $this->selectedPopularTours),
            ],
            'browse_categories' => [
                'title' => $this->browseTitle,
                'subtitle' => $this->browseSubtitle,
            ],
            'features' => [
                'title' => $this->featuresTitle,
                'subtitle' => $this->featuresSubtitle,
                'features' => $this->featuresItems,
            ],
            'destinations' => [
                'title' => $this->destinationsTitle,
                'subtitle' => $this->destinationsSubtitle,
                'destination_ids' => array_map('intval', $this->selectedDestinations),
            ],
            'policies' => [
                'title' => $this->policiesTitle,
                'items' => $this->policiesItems,
            ],
            'faq' => [
                'badge_text' => $this->faqBadgeText,
                'title' => $this->faqTitle,
                'faqs' => $this->faqItems,
            ],
            'reviews' => [
                'badge' => $this->reviewBadge,
                'title' => $this->reviewTitle,
                'subtitle' => $this->reviewSubtitle,
            ],
            'featured_promo' => [
                'badge' => $this->promoBadge,
                'title' => $this->promoTitle,
                'description' => $this->promoDescription,
                'button_text' => $this->promoButtonText,
                'button_link' => $this->promoButtonLink,
                'background_image' => $this->promoBgImage,
            ],
            'blog' => [
                'badge' => $this->blogBadge,
                'title' => $this->blogTitle,
                'view_all_link' => $this->blogViewAllLink,
            ],
            default => [],
        };

        $section->update(['settings' => $settings]);
        $this->cancelEdit();
        session()->flash('message', 'Section settings saved successfully.');
    }

    public function reorderSections($ids)
    {
        $ids = json_decode($ids, true);
        if (!is_array($ids)) return;

        foreach (array_values($ids) as $index => $id) {
            HomepageSection::where('id', $id)->update(['sort_order' => $index + 1]);
        }
    }

    public function render()
    {
        $sections = HomepageSection::orderBy('sort_order')->get();
        $tours = Tour::where('is_active', true)->orderBy('title')->get();
        $destinations = Destination::where('is_active', true)->orderBy('sort_order')->get();
        return view('components.admin.section-list', compact('sections', 'tours', 'destinations'));
    }
}
