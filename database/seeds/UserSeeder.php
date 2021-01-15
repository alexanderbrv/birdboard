<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\User::class)->create(['email' => 'admin@example.org']);
        factory(\App\Models\User::class, 2)->create();
    }
}
