<?php

namespace Database\Seeders;

use App\Models\Attribute;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $attributes = [
            ['title' => 'Преимущества', 'type' => 'text'],
            ['title' => 'Область применения', 'type' => 'text'],
            ['title' => 'Материал', 'type' => 'text'],
            ['title' => 'Давление (макс), БАР', 'type' => 'text'],
            ['title' => 'Температура (макс), °C', 'type' => 'text'],
            ['title' => 'Скорость скольжения (макс), м/с', 'type' => 'text'],
            ['title' => 'Скорость скольжения (макс), м/с', 'type' => 'text'],
            ['title' => 'Чертеж', 'type' => 'image'],
        ];

        foreach ($attributes as $attribute) {
            Attribute::updateOrCreate($attribute);
        }
    }
}
