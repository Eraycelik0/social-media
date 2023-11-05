<?php

namespace App\Services\Videos;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VideoService
{
    public function processVideo(Request $request)
    {
        if ($request->hasFile('media_video_url')) {
            $validator = Validator::make($request->all(), [
                'media_video_url' => 'mimetypes:video/mp4,video/quicktime,video/webm',
            ]);

            if ($validator->fails()) {
                return ['errors' => $validator->errors()->all()];
            }

            $video = $request->file('media_video_url');
            $videoName = time() . rand(0, 100) . '.' . $video->getClientOriginalExtension();
            $videoPath = public_path('videos/');
            $video->move($videoPath, $videoName);
            $videoURL = '/videos/' . $videoName;

            return $videoURL;
        }

        return null;
    }

    public function processUpdateVideo(Request $request)
    {
        if ($request->hasFile('media_video_url')) {
            $validator = Validator::make($request->all(), [
                'media_video_url' => 'mimetypes:video/mp4,video/quicktime,video/webm',
            ]);

            if ($validator->fails()) {
                return ['errors' => $validator->errors()->all()];
            }

            $oldVideo = public_path($request->file('media_video_url'));
            if (file_exists($oldVideo) && !is_null($request->file('media_video_url'))) {
                unlink($oldVideo);
            }

            $video = $request->file('media_video_url');
            $videoName = time() . rand(0, 100) . '.' . $video->getClientOriginalExtension();
            $videoPath = public_path('videos/');
            $video->move($videoPath, $videoName);
            $videoURL = '/videos/' . $videoName;

            return $videoURL;
        }

        return null;
    }
}
