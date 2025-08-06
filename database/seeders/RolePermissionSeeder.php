<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            // Dashboard & Admin Access
            'access_admin_panel',
            'view_dashboard',
            
            // User Management
            'view_users',
            'create_users',
            'edit_users',
            'delete_users',
            'manage_user_roles',
            
            // Product Management
            'view_products',
            'create_products',
            'edit_products',
            'delete_products',
            'publish_products',
            
            // Category Management
            'view_categories',
            'create_categories',
            'edit_categories',
            'delete_categories',
            
            // Order Management
            'view_orders',
            'create_orders',
            'edit_orders',
            'delete_orders',
            'process_orders',
            
            // Page Management
            'view_pages',
            'create_pages',
            'edit_pages',
            'delete_pages',
            'publish_pages',
            
            // Content Management
            'manage_sliders',
            'manage_youtube_videos',
            'manage_settings',
            
            // Reports & Analytics
            'view_reports',
            'export_data',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles and assign permissions
        
        // 1. Administrator - Full access
        $adminRole = Role::create(['name' => 'administrator']);
        $adminRole->givePermissionTo(Permission::all());

        // 2. Editor - Content management
        $editorRole = Role::create(['name' => 'editor']);
        $editorRole->givePermissionTo([
            'access_admin_panel',
            'view_dashboard',
            'view_products',
            'create_products',
            'edit_products',
            'publish_products',
            'view_categories',
            'create_categories',
            'edit_categories',
            'view_pages',
            'create_pages',
            'edit_pages',
            'publish_pages',
            'manage_sliders',
            'manage_youtube_videos',
            'view_orders',
            'edit_orders',
            'process_orders',
        ]);

        // 3. Author - Limited content creation
        $authorRole = Role::create(['name' => 'author']);
        $authorRole->givePermissionTo([
            'access_admin_panel',
            'view_dashboard',
            'view_products',
            'create_products',
            'edit_products',
            'view_categories',
            'view_pages',
            'create_pages',
            'edit_pages',
            'view_orders',
        ]);

        // 4. Subscriber - Customer role (no admin access)
        $subscriberRole = Role::create(['name' => 'subscriber']);
        // Subscribers don't get admin panel access - they are regular customers
    }
}
