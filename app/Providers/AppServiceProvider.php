<?php

namespace App\Providers;

use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureDefaults();
    }

    /**
     * Configure default behaviors for production-ready applications.
     */
    protected function configureDefaults(): void
    {
        Date::use(CarbonImmutable::class);

        DB::prohibitDestructiveCommands(
            app()->isProduction(),
        );

        Password::defaults(fn (): ?Password => app()->isProduction()
            ? Password::min(12)
                ->mixedCase()
                ->letters()
                ->numbers()
                ->symbols()
                ->uncompromised()
            : null,
        );

        $this->configureStorage();
    }

    protected function configureStorage(): void
    {
        try {
            $disk = \App\Models\Setting::get('storage_disk', 'public');
            if ($disk === 's3') {
                config([
                    'filesystems.disks.s3.key' => \App\Models\Setting::get('aws_key') ?: config('filesystems.disks.s3.key'),
                    'filesystems.disks.s3.secret' => \App\Models\Setting::get('aws_secret') ?: config('filesystems.disks.s3.secret'),
                    'filesystems.disks.s3.region' => \App\Models\Setting::get('aws_region') ?: config('filesystems.disks.s3.region'),
                    'filesystems.disks.s3.bucket' => \App\Models\Setting::get('aws_bucket') ?: config('filesystems.disks.s3.bucket'),
                ]);
            }
        } catch (\Exception $e) {
            // Table may not exist during migrations
        }
    }
}
