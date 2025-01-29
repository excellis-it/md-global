<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            'view_dashboard',
            'manage_account',
            'view_profile',
            'change_password',
            'manage_specialities',
            'view_specializations',
            'view_symptoms',
            'manage_users',
            'manage_patients',
            'manage_medical_staff',
            'manage_roles',
            'manage_service_centers',
            'view_clinics',
            'view_appointments',
            'manage_plans',
            'view_membership_plans',
            'manage_transactions',
            'view_membership_transactions',
            'manage_blogs',
            'view_blog_categories',
            'view_blog_details',
            'manage_contacts',
            'view_contact_us',
            'view_help_support',
            'view_newsletters',
            'send_notifications',
            'view_testimonials',
            'view_services',
            'manage_settings',
            'update_logo',
            'update_footer',
            'update_home_page_banners',
            'update_home_page_content',
            'update_telehealth_content',
            'update_qna_page',
            'update_contact_us_page',
            'update_terms_conditions',
            'update_privacy_policy',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
    }
}
