<?php

namespace App\Console\Commands;

use App\Helpers\ActivityLogger;
use App\Models\Category;
use App\Models\Destination;
use App\Models\Tour;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class ImportTours extends Command
{
    protected $signature = 'tours:import {file : Path to the JSON file containing scraped tour data}';
    protected $description = 'Import scraped tour data from JSON file into the database';

    public function handle(): int
    {
        $path = $this->argument('file');

        if (!file_exists($path)) {
            $this->error("File not found: {$path}");
            return Command::FAILURE;
        }

        $json = file_get_contents($path);
        $tours = json_decode($json, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->error('Invalid JSON: ' . json_last_error_msg());
            return Command::FAILURE;
        }

        $categories = Category::pluck('id', 'slug');
        $destinations = Destination::pluck('id', 'slug');
        $existingSlugs = Tour::pluck('slug')->toArray();
        $imported = 0;
        $skipped = 0;

        foreach ($tours as $data) {
            $title = trim($data['title'] ?? '');

            if (empty($title)) {
                $this->warn('Skipping tour with empty title');
                $skipped++;
                continue;
            }

            $slug = $this->makeUniqueSlug($data['slug'] ?: Str::slug($title), $existingSlugs);

            $categoryId = $this->resolveCategory($data, $categories);
            $destinationId = $this->resolveDestination($data, $destinations);

            $maxPeople = $this->parseMaxPeople($data, $title);
            $duration = (int) ($data['duration'] ?? 8);
            $durationType = in_array($data['duration_type'] ?? 'hours', ['minutes', 'hours', 'days', 'weeks'])
                ? $data['duration_type'] : 'hours';

            $price = (float) ($data['price'] ?? 0);
            $salePrice = $data['sale_price'] ? (float) $data['sale_price'] : null;

            $pricing = [
                'type' => 'per_person',
                'categories' => [
                    [
                        'category' => 'adult',
                        'label' => 'Adult',
                        'price' => $price,
                        'sale_price' => $salePrice,
                        'min_qty' => 1,
                    ],
                ],
            ];

            $images = $this->normalizeUrls($data['images'] ?? []);
            $featuredImage = $this->normalizeUrl($data['featured_image'] ?? '');

            $highlights = $data['highlights'] ?? [];
            if (!is_array($highlights)) {
                $highlights = [];
            }

            $inclusions = $data['inclusions'] ?? [];
            if (!is_array($inclusions)) {
                $inclusions = [];
            }

            $exclusions = $data['exclusions'] ?? [];
            if (!is_array($exclusions)) {
                $exclusions = [];
            }

            $itinerary = $data['itinerary'] ?? [];
            $faqs = $this->cleanFaqs($data['faqs'] ?? []);

            $shortDesc = trim($data['short_description'] ?? '');
            $metaDesc = trim($data['meta_description'] ?? '') ?: $shortDesc;
            $metaTitle = trim($data['meta_title'] ?? '') ?: $title;

            Tour::create([
                'created_by' => 1,
                'title' => $title,
                'slug' => $slug,
                'category_id' => $categoryId,
                'destination_id' => $destinationId,
                'short_description' => $shortDesc,
                'description' => trim($data['description'] ?? ''),
                'location' => trim($data['location'] ?? 'Niagara Falls, ON'),
                'duration' => $duration,
                'duration_type' => $durationType,
                'price' => $price,
                'sale_price' => $salePrice,
                'max_people' => $maxPeople,
                'pricing' => $pricing,
                'images' => $images,
                'featured_image' => $featuredImage,
                'highlights' => $highlights,
                'inclusions' => $inclusions,
                'exclusions' => $exclusions,
                'itinerary' => $itinerary,
                'faqs' => $faqs,
                'is_featured' => false,
                'is_active' => true,
                'booking_type' => 'internal',
                'meta_title' => $metaTitle,
                'meta_description' => $metaDesc,
            ]);

            $existingSlugs[] = $slug;
            $imported++;
            $this->info("Imported: {$title} ({$slug})");
        }

        ActivityLogger::log('imported', 'Tour', "Imported {$imported} tours from {$path}");

        $this->newLine();
        $this->info("Import complete: {$imported} imported, {$skipped} skipped");

        return Command::SUCCESS;
    }

    private function makeUniqueSlug(string $base, array &$existing): string
    {
        $slug = $base;
        $i = 1;
        while (in_array($slug, $existing, true)) {
            $slug = $base . '-' . $i;
            $i++;
        }
        return $slug;
    }

    private function resolveCategory(array $data, $categories): ?int
    {
        $title = strtolower($data['title'] ?? '');

        if (str_contains($title, 'helicopter')) {
            return $categories['helicopter-tours'] ?? null;
        }
        if (str_contains($title, 'boat cruise') || str_contains($title, 'cruise') || str_contains($title, 'boat')) {
            return $categories['boat-cruises'] ?? null;
        }
        if (str_contains($title, 'wine')) {
            return $categories['wine-tours'] ?? null;
        }
        if (str_contains($title, 'walk')) {
            return $categories['walking-tours'] ?? null;
        }

        return $categories['adventure-tours'] ?? null;
    }

    private function resolveDestination(array $data, $destinations): ?int
    {
        $title = strtolower($data['title'] ?? '');
        $location = strtolower($data['location'] ?? '');

        if (str_contains($title, '1000 islands') || str_contains($location, '1000 islands')) {
            return null;
        }
        if (str_contains($title, 'blue mountain') || str_contains($location, 'blue mountain')) {
            return null;
        }
        if (str_contains($title, 'toronto') && !str_contains($title, 'niagara')) {
            return $destinations['toronto'] ?? null;
        }
        if (str_contains($title, 'niagara-on-the-lake') || str_contains($location, 'niagara-on-the-lake')) {
            return $destinations['niagara-on-the-lake'] ?? null;
        }
        if (str_contains($desc = strtolower($data['description'] ?? ''), 'wine country')) {
            return $destinations['wine-country'] ?? null;
        }

        return $destinations['niagara-falls'] ?? null;
    }

    private function parseMaxPeople(array $data, string $title): ?int
    {
        if (!empty($data['max_people']) && $data['max_people'] != 50) {
            return (int) $data['max_people'];
        }

        if (preg_match('/upto?\s*(\d+)\s*(?:people|passengers?|participants?)/i', $title, $m)) {
            return (int) $m[1];
        }

        if (preg_match('/\((\d+)\s*[-–]\s*(\d+)\s*(?:people|passengers?|Participants?)\)/i', $title, $m)) {
            return (int) $m[2];
        }

        if (preg_match('/\(1-(\d+)\s*(?:people|passengers?)\)/i', $title, $m)) {
            return (int) $m[1];
        }

        if (preg_match('/for\s+(\d+)\s*(?:people|passengers?)/i', $title, $m)) {
            return (int) $m[1];
        }

        return 50;
    }

    private function cleanFaqs(array $faqs): array
    {
        return array_map(function ($faq) {
            $question = trim($faq['question'] ?? '');
            $question = preg_replace('/^Q:\s*/i', '', $question);

            return [
                'question' => $question,
                'answer' => trim($faq['answer'] ?? ''),
            ];
        }, $faqs);
    }

    private function normalizeUrls(array $urls): array
    {
        return array_map([$this, 'normalizeUrl'], $urls);
    }

    private function normalizeUrl(string $url): string
    {
        $url = trim($url);
        if (str_starts_with($url, 'http://')) {
            $url = 'https://' . substr($url, 7);
        }
        return $url;
    }
}
