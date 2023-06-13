<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roleAdmin = Role::where('title', 'admin')->first()->id;
        $roleEditor = Role::where('title', 'editor')->first()->id;
        $roleManager = Role::where('title', 'manager')->first()->id;

        $admin = User::factory()->create([
            'email' => 'odmen@odmen.com',
        ]);
        $admin->roles()->attach([$roleAdmin, $roleEditor, $roleManager]);

        $editor = User::factory()->create([
            'email' => 'editor@editor.com',
        ]);
        $editor->roles()->attach($roleEditor);

        $manager = User::factory()->create([
            'email' => 'manager@namager.com',
        ]);
        $manager->roles()->attach($roleManager);

        User::factory()
            ->count(10)
            ->create()
            ->each(function ($user) use ($roleEditor) {
                $user->roles()->attach([$roleEditor]);
        });
    }
}
