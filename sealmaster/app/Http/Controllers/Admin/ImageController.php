<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TemporaryUpload;
use Illuminate\Http\JsonResponse;
// use \Spatie\MediaLibrary\ResponsiveImages\ResponsiveImageGenerator;
use App\Services\NonOptimizedResponsiveImageGenerator;

class ImageController extends Controller
{
    public function store(): JsonResponse
    {
        $upload = TemporaryUpload::create();

        $mediaItems = $upload->addMediaFromRequest('upload')
            ->toMediaCollection('ck-images');

        $newUrls = [];
        $newUrls['default'] = $mediaItems->getUrl();

        $responsiveImageGenerator = app(NonOptimizedResponsiveImageGenerator::class);
        $responsiveImageGenerator->generateResponsiveImages($mediaItems);

        $srcSet = explode(', ', $mediaItems->getSrcset());
        array_pop($srcSet);

        foreach ($srcSet as $url) {
            preg_match('/(.*)\s(\d+)w/', $url, $matches);
            $newUrls[$matches[2]] = $matches[1];
        }

        return response()->json([
            'urls' => $newUrls,
        ]);
    }
}
