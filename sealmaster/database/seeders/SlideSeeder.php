<?php

namespace Database\Seeders;

use App\Models\Slide;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use \Spatie\MediaLibrary\ResponsiveImages\ResponsiveImageGenerator;

class SlideSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $slides = [
            [
                'title' => 'ТОЧИМ МАНЖЕТЫ И УПЛОТНЕНИЯ В КАРАГАНДЕ',
                'description' => 'Штучное изготовление манжет методом точения на современном австрийском станке с числовым программным управлением DMH-500. Изготовим любой нестандартный профиль по Вашим чертежам в течение часа.',
                'position' => 1,
                'thumb' => 'slides/001.png',
            ],
            [
                'title' => 'РЕМОНТ И ПРОИЗВОДСТВО ГИДРОЦИЛИНДРОВ',
                'description' => 'Мы предлагаем профессиональный ремонт гидроцилиндров и пневмоцилиндров с диаметром гильзы до 260 мм и длиной до 8 м. Замер и диагностика гидросистем. Изготовление новых гидроцилиндров на замену по образцам или чертежам.',
                'position' => 2,
                'thumb' => 'slides/002.jpg',
            ],
            [
                'title' => 'ГИДРАВЛИЧЕСКИЕ УПЛОТНЕНИЯ KASTAS',
                'description' => 'Всегда в наличии широкий ассортимент уплотнительных элементов для гидравлического и пневматического оборудования турецкой компании KASTAS',
                'position' => 3,
                'thumb' => 'slides/003.jpg',
            ],
        ];

        foreach ($slides as $slide) {
            if (isset($slide['thumb'])) {
                $mediaPath = storage_path("app/public/uploads/images/" . $slide['thumb']);
            } else {
                $mediaPath = null;
            }

            unset($slide['thumb']);

            $s = Slide::create($slide);
            $mediaItems = $s->addMedia($mediaPath)->preservingOriginal()->toMediaCollection('slides');

            $responsiveImageGenerator = app(ResponsiveImageGenerator::class);
            $responsiveImageGenerator->generateResponsiveImages($mediaItems);
        }
    }
}
