<?php

namespace App\Http\Controllers;

use App\Models\SiteSettings;
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
        } else {
            echo "file doesn't exist";
        }
        return $response;
    }

    public function get_client_ip()
    {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if (getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if (getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if (getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if (getenv('HTTP_FORWARDED'))
            $ipaddress = getenv('HTTP_FORWARDED');
        else if (getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }

    public function getSettings()
    {
        $settings = SiteSettings::all();
        $all_settings = array();
        foreach ($settings as $setting) {
            $all_settings[$setting['site_key']] = $setting['site_value'];
        }
        return $all_settings;
    }
    public function processFilter($data)
    {
        $return = "";
        if (!empty($data)) {
            $user_name = $data['user_name'];
            if (!empty($user_name)) {
                $user_name_arr = explode(' ', $user_name);
                if (!empty($user_name_arr[0])) {
                    $first_name = $user_name_arr[0];
                    $return .= "users.first_name like '".$first_name."%'";
                }

                if (!empty($user_name_arr[1])) {
                    $last_name = $user_name_arr[1];
                    if($return == "")
                        $return .= " users.last_name like '".$last_name."%'";
                    else
                    $return .= " AND users.last_name like '".$last_name."%'";
                }
            }

            if (!empty($data['user_email'])) {
                $email = $data['user_email'];
                if($return == "")
                    $return .= "users.email like '".$email."%'";
                else
                    $return .= "AND users.email like '".$email."%'";
            }

            if (!empty($data['number'])) {
                $number = $data['number'];
                if($return == "")
                    $return .= "users.number = '".$number."' ";
                else
                    $return .= "AND users.number = '".$number."' ";
            }
        }
        return $return;
    }
}
