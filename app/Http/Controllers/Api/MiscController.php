<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\EventGallery;
use App\Models\EventPartners;
use App\Models\EventResult;
use App\Models\User;
use App\Models\UserAddressDetails;
use App\Models\UserFiles;
use App\Models\UserPersonalDetails;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MiscController extends Controller
{

    public function getSliders(Request $request)
    {
        $data = EventGallery::select('image')->orderby('id', 'desc')->get();
        return response()->json($data);
    }

    public function setProfile(Request $request)
    {
        $data = $request->all();
        $user = auth()->user();
        //$image_path = $request->file('image')->store('image', 'public/uploads/profile/profileImage');


        if ($data) {
            if ($data['personal_details']) {
                $personal_details = $data['personal_details'];
                $first_name = $personal_details['first_name'];
                $last_name = $personal_details['last_name'];
                $number = $personal_details['number'];
                $email = $personal_details['email'];
                $user = User::where('email', $email)->first();
                $user->first_name = $first_name;
                $user->last_name = $last_name;
                $user->number = $number;
                $user->save();

                $birthday = trim($personal_details['birthday']);
                //$image = $image_path;
                $gender = $personal_details['gender'];
                $married = $personal_details['married'];
                $height = $personal_details['height'];
                $weight = $personal_details['weight'];
                $birthday = DateTime::createFromFormat('Y-m-d', $birthday);
                if (UserPersonalDetails::where('user_id', $user->id)->count() == 0) {
                    UserPersonalDetails::create([
                        'user_id' => $user->id,
                        'birthday' => $birthday->format('Y-m-d'),
                        //'image' => $image?$image:null,
                        'gender' => $gender,
                        'married' => $married,
                        'height' => $height,
                        'weight' => $weight
                    ]);
                } else {
                    UserPersonalDetails::where('user_id', $user->id)->update([
                        'birthday' => $birthday->format('Y-m-d'),
                        'gender' => $gender,
                        'married' => $married,
                        'height' => $height,
                        'weight' => $weight,
                    ]);
                }
                $user_personal_details = UserPersonalDetails::where('user_id', $user->id)->first();
            }

            if ($data['address_details']) {
                $address_details = $data['address_details'];
                if (UserAddressDetails::where('user_id', $user->id)->count() == 0) {
                    UserAddressDetails::create([
                        'user_id' => $user->id,
                        'address_line1' => $address_details['address_line1'],
                        'city' => $address_details['city'],
                        'state' => $address_details['state'],
                        'pincode' => $address_details['pincode']
                    ]);
                } else {
                    UserAddressDetails::where('user_id', $user->id)->update([
                        'user_id' => $user->id,
                        'address_line1' => $address_details['address_line1'],
                        'city' => $address_details['city'],
                        'state' => $address_details['state'],
                        'pincode' => $address_details['pincode']
                    ]);
                }
                $address_details = UserAddressDetails::where('user_id', $user->id)->first();
            }
            $reg_user = DB::table('users')
                ->select(
                    'users.id as id',
                    'users.first_name as first_name',
                    'users.last_name as last_name',
                    'users.email as email',
                    'users.number as number',
                    'users.user_role as user_role',
                    'user_personal_details.image as image',
                    'user_personal_details.gender as gender',
                    'user_personal_details.married as married',
                    'user_personal_details.height as height',
                    'user_personal_details.weight as weight',
                    'user_personal_details.age as age',
                    'user_personal_details.user_doc as user_doc',
                    'user_personal_details.birthday as birthday',
                    'user_address_details.address_line1 as address_line1',
                    'user_address_details.city as city',
                    'user_address_details.state as state',
                    'user_address_details.pincode as pincode'
                )
                ->leftJoin("user_personal_details", "user_personal_details.user_id", "=", "users.id")
                ->leftJoin("user_address_details", "user_address_details.user_id", "=", "users.id")
                ->where("users.id", $user->id)->first();
        }
        return response()->json(['user' => $reg_user]);
    }

    public function getEventPartners(Request $request)
    {
        if (!empty($request->event_id)) {
            $data = EventPartners::where('event_id', $request->event_id)->get();
        } else {
            $data = EventPartners::all();
        }

        return response()->json($data);
    }

    public function getUserFiles(Request $request)
    {
        $data = [];
        if (!empty($request->user_id) && !empty($request->file_type)) {
            $data = UserFiles::where('user_id', $request->user_id)
                ->where('file_type', $request->file_type)->get();
        }else if(!empty($request->file_type)){
            $data = UserFiles::where('file_type', $request->file_type)->get();
        }

        return response()->json($data);
    }

    public function getUserPerformance(Request $request)
    {
        $data = [];
        if (!empty($request->user_id)) {
            $data = DB::table('event_result')
            ->select(['event_result.event_id','event_result.event_result_key','event_result.event_result_value','events.event_name','events.event_date','events.event_location'])
                ->join('events', 'events.id', '=', 'event_result.event_id')
                ->where('event_result.user_id', $request->user_id)
                ->get();
        }

        return response()->json($data);
    }
}
