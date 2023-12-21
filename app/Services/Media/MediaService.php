<?php
namespace App\Services\Media;

use Illuminate\Support\Facades\Storage;


class MediaService {
    public function processFile($file) {
        if (in_array(strtolower($file->getClientOriginalExtension()), ['mp4', 'mov', 'avi', 'jpg', 'jpeg', 'png'])) {
            return Storage::url($file->store('public/media'));
        } else return null;
    }

    public static function processImage($file) {
        if (in_array(strtolower($file->getClientOriginalExtension()), ['jpg', 'jpeg', 'png'])) {
            return Storage::url($file->store('public/media'));
        } else return null;
    }

    public function deleteFile($file) {
        return Storage::delete($file);
    }
}
