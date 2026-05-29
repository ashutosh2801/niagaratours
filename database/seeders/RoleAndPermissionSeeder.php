<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class RoleAndPermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            ['name' => 'Dashboard', 'slug' => 'dashboard', 'group' => 'Content'],
            ['name' => 'Tours', 'slug' => 'tours', 'group' => 'Content'],
            ['name' => 'Categories', 'slug' => 'categories', 'group' => 'Content'],
            ['name' => 'Destinations', 'slug' => 'destinations', 'group' => 'Content'],
            ['name' => 'Orders', 'slug' => 'orders', 'group' => 'Content'],
            ['name' => 'Payments', 'slug' => 'payments', 'group' => 'Content'],
            ['name' => 'Pages', 'slug' => 'pages', 'group' => 'Content'],
            ['name' => 'Notifications', 'slug' => 'notifications', 'group' => 'Content'],
            ['name' => 'Reviews', 'slug' => 'reviews', 'group' => 'Content'],
            ['name' => 'Blog Posts', 'slug' => 'posts', 'group' => 'Content'],
            ['name' => 'Newsletter', 'slug' => 'newsletter', 'group' => 'Content'],
            ['name' => 'Media', 'slug' => 'media', 'group' => 'Appearance'],
            ['name' => 'Homepage Sections', 'slug' => 'sections', 'group' => 'Appearance'],
            ['name' => 'Menus', 'slug' => 'menus', 'group' => 'Appearance'],
            ['name' => 'Users', 'slug' => 'users', 'group' => 'System'],
            ['name' => 'Settings', 'slug' => 'settings', 'group' => 'System'],
            ['name' => 'Roles', 'slug' => 'roles', 'group' => 'System'],
            ['name' => 'Activity Log', 'slug' => 'activity-logs', 'group' => 'System'],
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['slug' => $perm['slug']], $perm);
        }

        $allPermissionSlugs = array_column($permissions, 'slug');

        // Administrator - all permissions
        $adminRole = Role::firstOrCreate(
            ['slug' => 'administrator'],
            ['name' => 'Administrator', 'description' => 'Full access to all modules'],
        );
        $adminRole->permissions()->sync(Permission::whereIn('slug', $allPermissionSlugs)->pluck('id'));

        // Admin - almost all except roles
        $roleAdmin = Role::firstOrCreate(
            ['slug' => 'admin'],
            ['name' => 'Admin', 'description' => 'Access to most modules except role management'],
        );
        $roleAdmin->permissions()->sync(Permission::whereIn('slug', [
            'dashboard', 'tours', 'categories', 'destinations', 'orders', 'payments',
            'pages', 'notifications', 'reviews', 'posts', 'newsletter',
            'media', 'sections', 'menus', 'users', 'settings', 'activity-logs',
        ])->pluck('id'));

        // Editor - content only
        $editorRole = Role::firstOrCreate(
            ['slug' => 'editor'],
            ['name' => 'Editor', 'description' => 'Access to content management modules'],
        );
        $editorRole->permissions()->sync(Permission::whereIn('slug', [
            'dashboard', 'tours', 'categories', 'destinations', 'orders',
            'pages', 'notifications', 'reviews', 'posts', 'media',
        ])->pluck('id'));

        // Customer - minimal access
        $customerRole = Role::firstOrCreate(
            ['slug' => 'customer'],
            ['name' => 'Customer', 'description' => 'Limited front-facing access'],
        );
        $customerRole->permissions()->sync(Permission::whereIn('slug', [
            'dashboard', 'orders',
        ])->pluck('id'));

        // Assign administrator role to existing admin users
        $adminUser = User::where('email', 'admin@niagaratours.com')->first();
        if ($adminUser) {
            $adminUser->roles()->sync([$adminRole->id]);
        }
    }
}
