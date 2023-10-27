<?php

namespace App\Services\Images;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;

class ImagesService
{
    protected $imageService;

    public function __construct(ImagesService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function processMultipleImages(Request $request)
    {
        $imageURLs = [];

        if ($request->hasFile('images')) {
            $images = $request->file('images');

            foreach ($images as $image) {
                $imageURL = $this->imageService->processImage($image);
                if (is_array($imageURL) && array_key_exists('errors', $imageURL)) {
                    return $imageURL;
                }
                $imageURLs[] = $imageURL;
            }
        }

        return $imageURLs;
    }

    public function processImage($image)
    {
        $validator = Validator::make(['image' => $image], [
            'image' => 'image|mimes:jpeg,png,jpg',
        ]);

        if ($validator->fails()) {
            return ['errors' => $validator->errors()->all()];
        }

        $imageName = time() . rand(0, 100) . '.' . $image->getClientOriginalExtension();
        $imagePath = public_path('images/');
        $image->move($imagePath, $imageName);
        $imageURL = '/images/' . $imageName;

        return $imageURL;
    }
}
