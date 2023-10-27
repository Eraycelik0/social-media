<?php

namespace App\Services\MediaShare;

use App\Helpers\Security;
use App\Models\MediaShare;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;

class MediaShareService
{
    public function createMediaShare($mediaRequest)
    {
        $media = json_decode(json_encode($mediaRequest));

        $mediaURLs = [];

        if ($media->media->type === 'Photo') {
            $validator = Validator::make($mediaRequest, [
                'media.user_id' => 'required|integer',
                'media.type' => 'required|in:Photo,Video',
                'media.media_url' => 'required|image|mimes:jpeg,png,jpg|max:10000',
            ]);

            if ($validator->fails()) {
                return ['errors' => $validator->errors()->all()];
            }
            foreach ($media->media->media_url as $url) {
                $path_parts = pathinfo($url);
                $is_image = Security::isImage($url);
                if ($is_image['status'] === 'ok') {
                    $mediaName = time() . rand(0, 100) . '.' . $path_parts['extension'];
                    $mediaPath = public_path('images/');
                    copy($url, $mediaPath . $mediaName);
                    $mediaURLs[] = '/images/' . $mediaName;

                    MediaShare::create([
                        'user_id' => $media->media->user_id,
                        'media_type' => $media->media->type,
                        'media_url' => $mediaName,
                    ]);
                }
            }

        }

        else {
            $validator = Validator::make($mediaRequest, [
                'media.user_id' => 'required|integer',
                'media.type' => 'required|in:Photo,Video',
                'media.media_url' => 'required|file|mimes:mp4|max:10000',
            ]);

            if ($validator->fails()) {
                return ['errors' => $validator->errors()->all()];
            }

            foreach ($media->media->media_url as $url) {
                $path_parts = pathinfo($url);

                if ($media->media->type === 'Video') {
                    $is_video = Security::isVideo($url);
                    if ($is_video['status'] === 'ok') {
                        $mediaName = time() . rand(0, 100) . '.' . $path_parts['extension'];
                        $mediaPath = public_path('videos/');
                        copy($url, $mediaPath . $mediaName);
                        $mediaURLs[] = '/videos/' . $mediaName;

                        MediaShare::create([
                            'user_id' => $media->media->user_id,
                            'media_type' => $media->media->type,
                            'media_url' => $mediaName,
                        ]);
                    }
                }
            }
        }

        return ['media' => $mediaURLs];
    }

    public function updateMediaShare(Request $request, $mediaShareId)
    {
        $mediaShare = MediaShare::find($mediaShareId);

        if (!$mediaShare) {
            return ['errors' => ['Media share not found']];
        }

        $validator = Validator::make($request->all(), [
            'user_id' => 'integer',
            'media_type' => 'in:Photo,Video',
            'media_url' => 'string',
        ]);

        if ($validator->fails()) {
            return ['errors' => $validator->errors()->all()];
        }

        if ($request->has('user_id')) {
            $mediaShare->user_id = $request->user_id;
        }
        if ($request->has('media_type')) {
            $mediaShare->media_type = $request->media_type;
        }
        if ($request->has('media_url')) {
            $mediaShare->media_url = $request->media_url;
        }

        $mediaShare->save();

        return ['media_share' => $mediaShare];
    }
}
