<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenusSeeder extends Seeder
{
    public function run(): void
    {
        $dashboardId = DB::table('menus')->insertGetId([
            'id_level' => 1,
            'menu_name' => 'Dashboard',
            'menu_link' => '/admin/dashboard',
            'menu_icon' => 'icon-grid',
            'parent_id' => null,
            'create_by' => 'admin',
            'delete_mark' => 'N',
            'update_by' => 'admin',
        ]);

        $userManagementId = DB::table('menus')->insertGetId([
            'id_level' => 1,
            'menu_name' => 'User Management',
            'menu_link' => '#',
            'menu_icon' => 'icon-layout',
            'parent_id' => null,
            'create_by' => 'admin',
            'delete_mark' => 'N',
            'update_by' => 'admin',
        ]);

        // Submenus of User Management
        DB::table('menus')->insert([
            [
                'id_level' => 2,
                'menu_name' => 'Daftar User',
                'menu_link' => '/admin/user',
                'menu_icon' => ' ',
                'parent_id' => $userManagementId,
                'create_by' => 'admin',
                'delete_mark' => 'N',
                'update_by' => 'admin',
            ],
            [
                'id_level' => 2,
                'menu_name' => 'Activity',
                'menu_link' => '/admin/useractivity',
                'menu_icon' => ' ',
                'parent_id' => $userManagementId,
                'create_by' => 'admin',
                'delete_mark' => 'N',
                'update_by' => 'admin',
            ],
        ]);

        // Additional standalone menus
        DB::table('menus')->insert([
            [
                'id_level' => 1,
                'menu_name' => 'Add Role',
                'menu_link' => '/admin/role',
                'menu_icon' => 'icon-head',
                'parent_id' => null,
                'create_by' => 'admin',
                'delete_mark' => 'N',
                'update_by' => 'admin',
            ],
            [
                'id_level' => 1,
                'menu_name' => 'Add Menu',
                'menu_link' => '/admin/menu',
                'menu_icon' => 'icon-plus',
                'parent_id' => null,
                'create_by' => 'admin',
                'delete_mark' => 'N',
                'update_by' => 'admin',
            ],
        ]);
    }
}

