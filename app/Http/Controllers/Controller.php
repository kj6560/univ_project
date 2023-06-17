<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function uploadFile($file, $path)
    {
        $errors = array();
        $file_name = $file['name'];
        $file_size = $file['size'];
        $file_tmp = $file['tmp_name'];
        $file_ext = strtolower(explode('.', $file['name'])[1]);

        $extensions = array("jpeg", "jpg", "png");

        if (in_array($file_ext, $extensions) === false) {
            $errors[] = "extension not allowed, please choose a JPEG or PNG file.";
        }

        if ($file_size > 209715200) {
            $errors[] = 'File size must be excately 200 MB';
        }
        move_uploaded_file($file_tmp, "uploads/" . $path . "/" . $file_name);
        $response = array();
        $response['errors'] = $errors;
        $response['success'] = false;
        $response['file_name'] = $file_name;
        return $response;
    }
    public function deleteFile($filename, $path)
    {
        $response = array();
        $response['errors'] = false;
        $response['success'] = false;
        $response['file_name'] = $filename;
        echo "uploads/" . $path . "/" . $filename;
        if (file_exists("uploads/" . $path . "/" . $filename) && unlink("uploads/" . $path . "/" . $filename)) {
            $response['errors'] = true;
            $response['success'] = true;
            return $response;
        }else{
            echo "file doesn't exist";
        }
        return $response;
    }
}
