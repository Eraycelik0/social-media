<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Crypt;
use function Laravel\Prompts\error;

class Security
{
    public static function scriptStripper($input, $ck_editor = false)
    {


        if ($input != null){
            if($ck_editor != false){
                return $input;
            }elseif(gettype($input) == 'date'){
                return date('Y:m:d',strtotime($input));
            }
            return strip_tags($input);
        }if ($input==null){
        return null;
    }
        /* kullanımı
               $test= new Helper();
               $menu->name = $test->scriptStripper(Input::get('name2'));
       */
    }

    public static function isDocument($FileName)
    {
        $response = [
            'status' => 'error',
            'data' => ''
        ];
        $path_parts = pathinfo($FileName->getClientOriginalName());
        $validateFile = ['pdf','csv','xls','xlsx','xlsm','xlsb','doc','docx','PDF','XLS','XLSX','DOC','DOCX'];
        if (in_array($path_parts['extension'], $validateFile)) {
            $response = [
                'status' => 'ok',
                'data' => $path_parts
            ];
        }
        return $response;
    }

    public static function isImage($file)
    {
        $response = [
            'status' => 'error',
            'data' => ''
        ];

        $path_parts = $file['extension'];

        $validateFile = ['jpeg', 'bmp', 'png', 'jpg', 'JPEG', 'BMP', 'JPG', 'PNG', 'img', 'IMG', 'svg'];

        if (in_array($path_parts, $validateFile)) {
            $response = [
                'status' => 'ok',
                'data' => $path_parts
            ];
        }

        return $response;
    }

    public static function isVideo($FileName)
    {

        $response = [
            'status' => 'error',
            'data' => ''
        ];
        $path_parts = pathinfo($FileName->getClientOriginalName());
        $validateFile = ['mp4','MP4','AVI','avi'];

        if (in_array($path_parts['extension'], $validateFile)) {

            $response = [
                'status' => 'ok',
                'data' => $path_parts
            ];

        } else {
            $response = [
                'status' => 'error',
                'data' => ''
            ];
        }
        return $response;

    }

    public static function encryptInputs($inputs){
        $data = (serialize($inputs));
        $data = Crypt::encryptString($data);
        return $data;
    }


}
