<?php

namespace App\Console\Commands;

use App\Models\Tour;
use Illuminate\Console\Command;

class ImportTourImages extends Command
{
    protected $signature = 'tours:import-images';
    protected $description = 'Replace remote image URLs in tours with local featured_image';

    public function handle(): int
    {
        $tours = Tour::where('images', 'like', '%niagarafallstour.com%')->get();

        if ($tours->isEmpty()) {
            $this->info('No tours with remote images found.');
            return Command::SUCCESS;
        }

        $this->info("Found {$tours->count()} tours with remote images.");
        $updated = 0;

        foreach ($tours as $tour) {
            $local = $tour->featured_image;
            if (!$local || str_contains($local, 'niagarafallstour.com')) {
                $this->warn("  Skipped (no local featured_image): {$tour->title}");
                continue;
            }

            $tour->updateQuietly(['images' => [$local]]);
            $updated++;
            $this->info("  {$tour->title}");
        }

        $this->newLine();
        $this->info("Done. Updated: {$updated}");

        return Command::SUCCESS;
    }
}
