<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\site\SiteController;
use App\Models\Email;
use App\Models\EmailTemplates;
use App\Models\Event;
use App\Models\EventGallery;
use App\Models\EventPartners;
use App\Models\EventResult;
use App\Models\EventUsers;
use App\Models\SiteSettings;
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
                $personal_details = !empty($data['personal_details']) ? $data['personal_details'] : [];
                $first_name = !empty($personal_details['first_name']) ? $personal_details['first_name'] : "";
                $last_name = !empty($personal_details['last_name']) ? $personal_details['last_name'] : "";
                $number = !empty($personal_details['number']) ? $personal_details['number'] : "";
                $email = !empty($personal_details['email']) ? $personal_details['email'] : "";
                $about = !empty($personal_details['about']) ? $personal_details['about'] : "";
                $user = User::where('email', $email)->first();
                $user->first_name = $first_name;
                $user->last_name = $last_name;
                $user->number = $number;
                $user->save();

                $birthday = !empty($personal_details['birthday'])?trim($personal_details['birthday']):"";
                //$image = $image_path;
                $gender = !empty($personal_details['gender']) ? $personal_details['gender'] : 0;
                $married = !empty($personal_details['married']) ? $personal_details['married'] : 0;
                $height = !empty($personal_details['height']) ? $personal_details['height'] :0.0;
                $weight = !empty($personal_details['weight']) ? $personal_details['weight'] : 0.0;
                $birthday = !empty($birthday) ? date('Y:m:d', strtotime($birthday)) : "0000-00-00";
                if (UserPersonalDetails::where('user_id', $user->id)->count() == 0) {
                    UserPersonalDetails::create([
                        'user_id' => $user->id,
                        'birthday' => $birthday,
                        //'image' => $image?$image:null,
                        'gender' => $gender,
                        'married' => $married,
                        'height' => $height,
                        'weight' => $weight,
                        'about' => $about
                    ]);
                } else {
                    UserPersonalDetails::where('user_id', $user->id)->update([
                        'birthday' => $birthday,
                        'gender' => $gender,
                        'married' => $married,
                        'height' => $height,
                        'weight' => $weight,
                        'about' => $about
                    ]);
                }
                $user_personal_details = UserPersonalDetails::where('user_id', $user->id)->first();
            }

            if ($data['address_details']) {
                $address_details = !empty($data['address_details']) ? $data['address_details'] : [];
                if (UserAddressDetails::where('user_id', $user->id)->count() == 0) {
                    UserAddressDetails::create([
                        'user_id' => $user->id,
                        'address_line1' => !empty($address_details['address_line1']) ? $address_details['address_line1'] : "",
                        'city' => !empty($address_details['city']) ? $address_details['city'] : "",
                        'state' => !empty($address_details['state']) ? $address_details['state'] : "",
                        'pincode' => !empty($address_details['pincode']) ? $address_details['pincode'] : ""
                    ]);
                } else {
                    UserAddressDetails::where('user_id', $user->id)->update([
                        'user_id' => $user->id,
                        'address_line1' => !empty($address_details['address_line1']) ? $address_details['address_line1'] : "",
                        'city' => !empty($address_details['city']) ? $address_details['city'] : "",
                        'state' => !empty($address_details['state']) ? $address_details['state'] : "",
                        'pincode' => !empty($address_details['pincode']) ? $address_details['pincode'] : ""
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
                    'user_personal_details.about as about',
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
                ->where('file_type', $request->file_type)->orderBy('id', 'desc')->get();
        } else if (!empty($request->file_type)) {
            $data = UserFiles::where('file_type', $request->file_type)->orderBy('id', 'desc')->get();
        } else if (!empty($request->event_id)) {
            $data = UserFiles::orderBy('id', 'desc')->get();
        }

        return response()->json($data);
    }

    public function getUserPerformance(Request $request)
    {
        $data = [];
        if (!empty($request->user_id)) {
            $data = DB::table('event_result')
                ->select(['event_result.event_id', 'event_result.event_result_key', 'event_result.event_result_value', 'events.event_name', 'events.event_date', 'events.event_location'])
                ->join('events', 'events.id', '=', 'event_result.event_id')
                ->where('event_result.user_id', $request->user_id)
                ->get();

            $resp = [];
            foreach ($data as $key => $val) {
                $resp[$val->event_name][] = $val;
            }
        }

        return response()->json($resp);
    }

    public function getEventFiles(Request $request)
    {
        $data = [];
        if (!empty($request->event_id) && !empty($request->file_type)) {
            $data = EventGallery::where('event_id', $request->event_id)->get();
        } else if (!empty($request->file_type)) {
            $data = EventGallery::get();
        } else if (!empty($request->event_id)) {
            $data = EventGallery::get();
        }

        return response()->json($data);
    }
    public function uploadProfilePicture(Request $request)
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_id = $request->user_id;
            // Specify the directory where you want to save the uploaded images
            $uploadDir = 'uploads/profile/profileImage/';

            $filename = uniqid() . '.jpg';

            // Set the path of the uploaded file
            $uploadPath = $uploadDir . $filename;

            // Move the uploaded file to the specified path
            if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
                $userPersonalDetails = UserPersonalDetails::where('user_id', $user_id)->first();
                $userPersonalDetails->image = $filename;
                if ($userPersonalDetails->save()) {
                    return response()->json(['status' => 200, 'message' => 'Profile picture uploaded successfully.', 'image' => $filename]);
                } else {
                    return response()->json(['status' => 500, 'message' => 'Error uploading image.']);
                }
            } else {
                // Error uploading the file
                return response()->json(['status' => 500, 'message' => 'Error uploading image.']);
            }
        }
    }
    public function userImageUpload(Request $request)
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_id = $request->user_id;
            // Specify the directory where you want to save the uploaded images
            $uploadDir = 'uploads/users/docs/images/';

            $filename = uniqid() . '.jpg';

            // Set the path of the uploaded file
            $uploadPath = $uploadDir . $filename;

            // Move the uploaded file to the specified path
            if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
                $user_files = new UserFiles();
                $user_files->user_id = $user_id;
                $user_files->file_path = $filename;
                $user_files->file_type = 1;
                $user_files->title = " ";
                $user_files->description = " ";
                $user_files->tags = " ";
                if ($user_files->save()) {
                    return response()->json(['status' => 200, 'message' => 'user video uploaded successfully.']);
                } else {
                    return response()->json(['status' => 500, 'message' => 'Error uploading video.', 'error' => "not saved in db"]);
                }
            } else {
                // Error uploading the file
                return response()->json(['status' => 500, 'message' => 'Error uploading image.']);
            }
        }
    }
    public function uploadUserVideos(Request $request)
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_id = $request->user_id;
            // Specify the directory where you want to save the uploaded images
            $uploadDir = 'uploads/users/docs/images/';

            $filename = uniqid() . '.mp4';

            // Set the path of the uploaded file
            $uploadPath = $uploadDir . $filename;

            // Move the uploaded file to the specified path
            if (move_uploaded_file($_FILES['video_file']['tmp_name'], $uploadPath)) {
                $user_files = new UserFiles();
                $user_files->user_id = $user_id;
                $user_files->file_path = $filename;
                $user_files->file_type = 2;
                $user_files->title = $request->title;
                $user_files->description = $request->description;
                $user_files->tags = $request->tags;
                if ($user_files->save()) {
                    return response()->json(['status' => 200, 'message' => 'user video uploaded successfully.']);
                } else {
                    return response()->json(['status' => 500, 'message' => 'Error uploading video.', 'error' => "not saved in db"]);
                }
            } else {
                // Error uploading the file
                return response()->json(['status' => 500, 'message' => 'Error uploading video.', 'error' => $_FILES['video']['error']]);
            }
        }
    }
    public function getSiteSettings(Request $request)
    {
        return response()->json(SiteSettings::get());
    }

    public function registerNow(Request $request)
    {
        $post = $request->all();
        if (!empty($post)) {
            $user = User::where('email', $post['email'])->first();
            $eventUser = EventUsers::where(['event_id' => $post['event_id'], 'user_id' => $user['id']])->first();
            $event = Event::where('id', $post['event_id'])->first();
            if (!empty($eventUser)) {
                return response()->json(["error" => true, "message" => "You have already registered for this event."]);
            } else {
                if ($event->event_registration_available != 0) {
                    if ($user) {
                        $this->updateUserActivityLog($user->id, 3);
                        $event_user = EventUsers::create(['event_id' => $post['event_id'], 'user_id' => $user['id']]);
                        $time = strtotime($event->event_date);
                        $month = date("F", $time);
                        $date = date("d", $time);
                        $event_time = date("h:i A", $time);
                        if ($event_user) {
                            $user_name = $user->first_name . " " . $user->last_name;
                            $site_name = env("SITE_NAME", "UNIV SPORTA");
                            $subject = "Event Registration";
                            $email_sender_name = env("EMAIL_SENDER_NAME", "UNIV SPORTA");
                            $email = $post['email'];
                            $template = EmailTemplates::where('template_name', 'event_registration')->first();
                            $template_data = $template->template_data;
                            $template_data = str_replace("##user_name##", $user_name, $template_data);
                            $template_data = str_replace("##event_name##", $event->event_name, $template_data);
                            $message = $template_data;
                            $mailData = array("email" => $user->email, "first_name" => $user->first_name, "last_name" => $user->last_name, "subject" => $subject, "message" => $message);

                            $sent = Email::sendEmail($mailData);
                            if ($sent) {
                                return response()->json(["error" => false, "message" => "You have successfully registered for this event. Kindly check your email for details."]);
                            } else {
                                return response()->json(["error" => true, "message" => "There is some issue with email. plz check your email id and try again."]);
                            }
                        } else {
                            return response()->json(["error" => true, "message" => "There is some issue with email. plz check your email id and try again."]);
                        }
                    } else {
                        $credentials = $request->validate([
                            'first_name' => ['required', 'string'],
                            'last_name' => ['required', 'string'],
                            'number' => ['required', 'string'],
                            'email' => ['required', 'email']
                        ]);

                        if ($credentials) {
                            $user = User::where("email", $post['email'])->first();
                            if (empty($user)) {
                                $pass_plain = SiteController::getName(8);
                                $password = bcrypt($pass_plain);
                                $user = User::create([
                                    'first_name' => $post['first_name'],
                                    'last_name' => $post['last_name'],
                                    'number' => $post['number'],
                                    'email' => $post['email'],
                                    'email_verified_at' => now(),
                                    'password' => $password
                                ]);
                            }
                            $this->updateUserActivityLog($user->id, 3);
                            $registeredUser = EventUsers::where(['event_id' => $post['event_id'], 'user_id' => $user['id']])->first();
                            if (empty($registeredUser)) {
                                $event_user = EventUsers::create(['event_id' => $post['event_id'], 'user_id' => $user['id']]);
                                if ($event_user) {
                                    $user_name = $user->first_name . " " . $user->last_name;
                                    $site_name = env("SITE_NAME", "UNIV SPORTA");
                                    $subject = "Welcome to $site_name";
                                    $email_sender_name = env("EMAIL_SENDER_NAME", "UNIV SPORTA");
                                    $email = $post['email'];
                                    $message = "
                                    Dear $user_name,<br><br>
        
                                    Thank You for registering for IOA’S BHARAT IN PARIS and be a part of India's Olympic Movement.<br><br>
        
                                    We are happy to confirm your participation for the event:<br><br>
        
                                    Name of the event: IOA BHARAT IN PARIS<br><br>
        
                                    Date: 23 June<br><br>
        
                                    Venue: Jawaharlal Nehru Stadium, New Delhi<br><br>
        
                                    Reporting Time: 05:00 AM<br><br>
        
                                    BIB Collection for the Race Day:<br><br>
        
                                    Dates: 21st & 22nd June<br><br>
        
                                    Time: 11am - 6pm<br><br>
        
                                    Venue: Jawaharlal Nehru Stadium<br><br>
        
                                    Indian Olympic Association in partnership with UNIV Sportatech is committed to provide you with the best possible user experience.<br><br>
        
                                    For event flow, route and other relevant details please click the link below and login to fill other important fields:<br><br>
        
                                    Your Login Credentials are:email: $email     password: $pass_plain<br><br>
        
                                    https://univsportatech.com/login<br><br>
                                    Note: Kindly carry a Government Approved ID Card (Aadhaar/Driving License/Pan Card) on 21st & 22nd June for uploading on your registered profile and on 23rd June ID verification.<br><br>
        
                                    Thanking You<br><br>
        
                                    Best regards,<br><br>
        
                                    Administrator<br><br>
        
                                    UNIV SPORTATECH<br><br>
                                    ";
                                    $mailData = array("email" => $user->email, "first_name" => $user->first_name, "last_name" => $user->last_name, "subject" => $subject, "message" => $message);

                                    $sent = Email::sendEmail($mailData);
                                    if ($sent) {
                                        return response()->json(["error" => false, "message" => "You have successfully registered for this event. Kindly check your email for details."]);
                                    } else {
                                        return response()->json(["error" => true, "message" => "There is some issue with email. plz check your email id and try again."]);
                                    }
                                } else {
                                    return response()->json(["error" => true, "message" => "There is some issue with  registration process. plz try again later."]);
                                }
                            }
                        }
                    }
                } else {
                    return response()->json(["error" => true, "message" => "Registration process is closed for this event. Kindly check back later."]);
                }
            }
        }
    }
}
