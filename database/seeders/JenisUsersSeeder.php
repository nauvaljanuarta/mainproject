<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JenisUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('jenis_users')->insert([
            [
                'jenis_user' => 'Admin',
                'create_by' => 'system',
                'delete_mark' => 'N',
                'update_by' => 'system',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'jenis_user' => 'User',
                'create_by' => 'system',
                'delete_mark' => 'N',
                'update_by' => 'system',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'jenis_user' => 'Penerbit',
                'create_by' => 'system',
                'delete_mark' => 'N',
                'update_by' => 'system',
                'created_at' => now(),
                'updated_at' => now(),
            ]

        ]);
    }
}
