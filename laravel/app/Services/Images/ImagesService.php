<?php

namespace App\Services\Images;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ImagesService
{
    public function processImage(Request $request)
    {
        if ($request->hasFile('media_photo_url')) {
            $validator = Validator::make($request->all(), [
                'media_photo_url' => 'image|mimes:jpeg,png,jpg',
            ]);

            if ($validator->fails()) {
                return ['errors' => $validator->errors()->all()];
            }

            $image = $request->file('media_photo_url');
            $imageName = time() . rand(0, 100) . '.' . $image->getClientOriginalExtension();
            $imagePath = public_path('images/');
            $image->move($imagePath, $imageName);
            $imageURL = '/images/' . $imageName;

            return $imageURL;
        }

        return null;
    }

    public function processUpdateImage(Request $request)
    {

        if ($request->hasFile('media_photo_url')) {
            $validator = Validator::make($request->all(), [
                'media_photo_url' => 'image|mimes:jpeg,png,jpg',
            ]);

            if ($validator->fails()) {
                return ['errors' => $validator->errors()->all()];
            }

            $oldImage = public_path($request->image);
            if (file_exists($oldImage) && !is_null($request->image)) {
                unlink($oldImage);
            }

            $image = $request->file('media_photo_url');
            $imageName = time() . rand(0, 100) . '.' . $image->getClientOriginalExtension();
            $imagePath = public_path('images/');
            $image->move($imagePath, $imageName);
            $imageURL = '/images/' . $imageName;

            return $imageURL;
        }

        return null;
    }
}
