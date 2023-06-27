<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;
use App\Jobs\UploadResults;
use App\Models\Email;
use App\Models\EmailTemplates;
use App\Models\EmergencyContactDetails;
use App\Models\Event;
use App\Models\EventGallery;
use App\Models\EventResult;
use App\Models\EventSlider;
use App\Models\EventUsers;
use App\Models\SiteGallery;
use App\Models\Team;
use App\Models\User;
use App\Models\UserAddressDetails;
use App\Models\UserPersonalDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class SiteController extends Controller
{
    public function index(Request $request)
    {
        $events = Event::limit(2)->orderBy('id', 'DESC')->get();

        return view('site.index', ['events' => $events, 'settings' => $this->getSettings()]);
    }
    public function login(Request $request)
    {
        return view('site.login');
    }

    public function loginAuthentication(Request $request)
    {
        $data = $request->all();
        if (!empty($data) && $data['email'] && $data['password']) {
            $attemptData = array("email" => $data['email'], "password" => $data['password']);
            if (Auth::attempt($attemptData)) {
                $request->session()->regenerate();
                $this->updateUserActivityLog(Auth::user()->id, 1);
                if (intval(Auth::user()->user_role) == 3) {
                    return redirect('/dashboard');
                } else {
                    return redirect('/userProfile');
                }
            } else {
                return back()->withErrors([
                    'errors' => 'user authentication failed.',
                ]);
            }
        } else if (!empty($data) && $data['email']) {
            return back()->withErrors([
                'email' => 'plz enter valid email and password.',
            ])->onlyInput('email');
        }
    }
    public function register(Request $request)
    {
        return view('site.register');
    }

    public function createUser(Request $request)
    {
        $data = $request->all();
        if (!empty($data) && $data['email']) {

            $credentials = $request->validate([
                'first_name' => ['required', 'string'],
                'last_name' => ['required', 'string'],
                'number' => ['required', 'string'],
                'email' => ['required', 'email']
            ]);
            if (str_contains($data['number'], '+91-')) {
                $data['number'] = str_replace('+91-', '', $data['number']);
            }
            if (str_contains($data['number'], '+91')) {
                $data['number'] = str_replace('+91', '', $data['number']);
            }

            if ($credentials) {
                $user = User::where("email", $data['email'])->first();
                if (empty($user)) {
                    $pass_plain = SiteController::getName(8);
                    $password = bcrypt($pass_plain);
                    $user = User::create([
                        'first_name' => $data['first_name'],
                        'last_name' => $data['last_name'],
                        'number' => $data['number'],
                        'email' => $data['email'],
                        'email_verified_at' => now(),
                        'password' => $password
                    ]);
                } else {
                    return redirect()->back()->with('error', 'Email already exists. Please login ');
                }

                if ($user) {
                    $user_name = $user->first_name . " " . $user->last_name;
                    $site_name = env("SITE_NAME", "UNIV SPORTA");
                    $subject = "Welcome to $site_name";
                    $email = $data['email'];
                    $template = EmailTemplates::where('template_name', 'user_registration')->first();
                    $template_data = $template->template_data;
                    $template_data = str_replace("##user_name##", $user_name, $template_data);
                    $template_data = str_replace("##email##", $email, $template_data);
                    $template_data = str_replace("##pass_plain##", $pass_plain, $template_data);
                    $message = $template_data;
                    $mailData = array("email" => $user->email, "first_name" => $user->first_name, "last_name" => $user->last_name, "subject" => $subject, "message" => $message);

                    $sent = Email::sendEmail($mailData);
                    if ($sent) {
                        return redirect()->back()->with('success', 'You have been successfully registered and your password is sent on your registered email id. Please login with the password in the email id.In case you have not recieved email in the inbox, please check your spam or junk folder ');
                    }
                } else
                    return back()->withErrors([
                        'email' => 'user already exists.',
                    ])->onlyInput('email');
                if ($user)
                    return redirect("login");
            }
        } else {
            echo "not post";
        }
    }
    public static function getName($n)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';

        for ($i = 0; $i < $n; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }

        return $randomString;
    }
    public function logout(Request $request)
    {
        $this->updateUserActivityLog(Auth::user()->id, 6);
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
    public function forgot(Request $request)
    {
        return view('site.forgot');
    }
    public function forgotPasswordUser(Request $request)
    {
        $data = $request->all();
        $email = $data['email'];
        if (!empty($email)) {
            $user = User::where("email", $email)->first();
            if ($user) {
                $user_name = $user->first_name . " " . $user->last_name;
                $payload = "email=" . $email;
                $payload = Crypt::encryptString($payload);
                $link = env("APP_URL", "") . "/reset?t=" . $payload;
                $subject = "Reset Your Password";
                $site_phone = env("PHONE", "9599362404");
                $site_name = env("SITE_NAME", "UNIV SPORTATECH");
                $email_sender_name = env("EMAIL_SENDER_NAME", "UNIV SPORTATECH");
                $template = EmailTemplates::where('template_name', 'forgot_password')->first();
                $template_data = $template->template_data;
                $template_data = str_replace("##user_name##", $user_name, $template_data);
                $template_data = str_replace("##link##", $link, $template_data);
                $template_data = str_replace("##site_phone##", $site_phone, $template_data);
                $template_data = str_replace("##site_name##", $site_name, $template_data);
                $template_data = str_replace("##email_sender_name##", $email_sender_name, $template_data);
                $message = $template_data;
                $mailData = array("email" => $email, "first_name" => $user->first_name, "last_name" => $user->last_name, "subject" => $subject, "message" => $message);
                $sent = Email::sendEmail($mailData);
                if ($sent) {
                    $this->updateUserActivityLog($user->id, 5);
                    return redirect()->back()->with('success', 'Email sent to your registered email id. please check your email and follow the instructions.Please check your spam or junk folder if not received in primary email.');
                }
            } else {
                echo "user not found";
            }
        } else {
        }
    }
    public function resetPassword(Request $request)
    {
        $data = $request->all();
        $t = $data['t'];
        $payload = Crypt::decryptString($t);
        $email = "";
        if (!empty(explode("=", $payload)[1]) && filter_var(explode("=", $payload)[1], FILTER_VALIDATE_EMAIL)) {
            $email = $t;
        }
        return view('site.resetPassword', ["email" => $email]);
    }
    public function resetPasswordUser(Request $request)
    {
        $data = $request->all();
        $email = "";
        if (!empty($data['email']) && !empty($data['password1']) && !empty($data['password2'])) {
            $email = Crypt::decryptString($data['email']);
            $email = explode("=", $email)[1];
            $password1 = $data['password1'];
            $password2 = $data['password2'];
            if (strcmp($password1, $password2) == 0) {
                $user = User::where(["email" => $email])->first();
                if ($user) {
                    $user->password = Hash::make($data['password1']);
                    if ($user->save()) {
                        return redirect()->back()->with('success', 'Your Password has been updated succcessfully. Please continue to login.');
                    } else {
                        return redirect()->back()->with('error', 'Something went wrong');
                    }
                } else {
                    return redirect()->back()->with('error', 'No user found with the given email ' . $email);
                }
            } else {
                return redirect()->back()->with('error', 'Passwords donot match');
            }
        } else {
            return redirect()->back()->with('error', 'Please enter both passwords');
        }
    }
    public function subscribe(Request $request)
    {
        $data = $request->all();
        $email = $data['email'];
        if (empty($email)) {
            return redirect()->back()->with('error', 'plz enter email');
        }

        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $subject = "Subscribe for Updates";
            $site_name = env("SITE_NAME", "UNIV SPORTA");
            $email_sender_name = env("EMAIL_SENDER_NAME", "UNIV SPORTA");
            $message = "
                <p>Dear Subscriber,</p><br>
 
                <p>I am writing this email to express my gratitude for subscribing to our updates email. We appreciate your interest in our UNIV SPORTA TECH, and we are committed to keeping you informed about our latest developments.</p>
                <p>As a subscriber, you will receive regular updates on our events. We value your privacy, and we will never share your information with third parties.</p>
                <p>We understand that your time is valuable, and we will make sure that the emails you receive from us are informative and useful. We welcome your feedback and suggestions and are always looking for ways to improve our communication with our subscribers.</p>
                <p>If you ever want to unsubscribe or update your email preferences, you can do so by clicking on the \"unsubscribe\" link at the bottom of any of our emails.</p>
                <p>Once again, thank you for subscribing to our updates email. We look forward to sharing our news and offerings with you.</p>

                <br>Best regards,
                 
                <br>$email_sender_name <br>
                $site_name
            ";
            $mailData = array("email" => $email, "first_name" => "subscriber", "last_name" => "", "subject" => $subject, "message" => $message);
            $sent = Email::sendEmail($mailData);
            if ($sent) {
                return redirect()->back()->with('success', 'You have successfully subscribed to our updates email. Please check your email regularly and stay updated. Please check your spam or junk folder if not received in primary email.');
            } else {
                return redirect()->back()->with('error', 'There is some issue with email. plz check your email id and try again.');
            }
        } else {
            return redirect()->back()->with('error', 'Please enter valid email');
        }
    }

    public function about(Request $request)
    {
        return view('site.about', ['teams' => Team::get(), 'settings' => $this->getSettings()]);
    }

    public function teamInfo(Request $request, $id)
    {
        $teams = Team::where('id', Crypt::decryptString($id))->first();
        return view('site.teamInfo', ['teams' => $teams, 'settings' => $this->getSettings()]);
    }

    public function event(Request $request)
    {
        $event_gallery_images = DB::table('event_gallery')->limit(30)->orderBy('image_priority', 'asc')->get();
        $events = Event::orderBy('id', 'DESC')->get();
        return view('site.event', ['events' => $events, 'settings' => $this->getSettings(), 'event_gallery' => $event_gallery_images]);
    }

    public function eventDetails(Request $request, $id)
    {
        $event = Event::where('id', Crypt::decryptString($id))->first();
        $events = Event::limit(3)->orderBy('id', 'DESC')->get();
        $event_sliders = EventSlider::where("event_id", $event->id)->get();
        return view('site.eventDetails', ['event' => $event, 'settings' => $this->getSettings(), 'events' => $events, 'sliders' => $event_sliders]);
    }

    public function gallery(Request $request)
    {
        $gallery = SiteGallery::orderBy("image_priority", "asc")->paginate(20);
        return view('site.gallery', ['gallery' => $gallery, 'settings' => $this->getSettings()]);
    }

    public function contactus(Request $request)
    {
        return view('site.contactus', ['settings' => $this->getSettings()]);
    }

    public function registerNow(Request $request)
    {
        $post = $request->all();
        if (!empty($post)) {
            $user = User::where('email', $post['email'])->first();
            $eventUser = EventUsers::where(['event_id' => $post['event_id'], 'user_id' => $user['id']])->first();
            $event = Event::where('id', $post['event_id'])->first();
            if (!empty($eventUser)) {
                return redirect()->back()->with('error', 'You have already registered for this event.');
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
                                return redirect()->back()->with('success', 'You have successfully registered for this event. Kindly check your email for details.');
                            } else {
                                return redirect()->back()->with('error', 'There is some issue with email. plz check your email id and try again.');
                            }
                        } else {
                            return redirect()->back()->with('error', 'Plz try again later.');
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
                                        return redirect()->back()->with('success', 'You have successfully registered for this event. Kindly check your email for details.');
                                    } else {
                                        return redirect()->back()->with('error', 'There is some issue with email. plz check your email id and try again.');
                                    }
                                } else {
                                    return redirect()->back()->with('error', 'There is some issue registration process. plz try again later.');
                                }
                            }
                        }
                    }
                } else {
                    return redirect()->back()->with('error', 'Registration process is closed for this event. Kindly check back later.');
                }
            }
        }
    }
    public function userProfile(Request $request)
    {
        $user = Auth::user();
        $userPersonalDetails = UserPersonalDetails::where('user_id', $user->id)->first();
        $userAddressDetails = UserAddressDetails::where('user_id', $user->id)->first();
        $emergencyContactDetails = EmergencyContactDetails::where('user_id', $user->id)->first();
        $eventResult = EventResult::where("user_id", $user->id)->first();
        return view('site.userProfile', ['user' => $user, 'settings' => $this->getSettings(), 'userPersonalDetails' => $userPersonalDetails, 'userAddressDetails' => $userAddressDetails, 'emergencyContactDetails' => $emergencyContactDetails, 'eventResults' => $eventResult]);
    }

    public function updateContactDetails(Request $request)
    {
        $data = $request->all();
        if ($data) {
            $user = User::find($data['user_id']);
            $this->updateUserActivityLog($user->id, 7);
            if ($user) {
                $user->first_name = $data['first_name'];
                $user->last_name = $data['last_name'];
                $user->number = $data['number'];
                $user_saved = $user->save();
                $user_address_details = UserAddressDetails::where('user_id', $user->id)->first();
                if (empty($user_address_details)) {
                    $user_address_details = new UserAddressDetails();
                    $user_address_details->user_id = $user->id;
                }
                $user_address_details->address_line1 = $data['address_line1'];
                $user_address_details->city = $data['city'];
                $user_address_details->state = $data['state'];
                $user_address_details->pincode = $data['pincode'];
                $address_saved = $user_address_details->save();
                if ($user_saved && $address_saved) {
                    return redirect()->back()->with('success', 'Profile updated successfully.');
                } else {
                    return redirect()->back()->with('error', 'Profile updation failed. Please try again');
                }
            }
        }
    }

    public function userUpdateProfilePic(Request $request)
    {
        $data = $request->all();
        if ($data) {
            $user = User::find($data['user_id']);
            $this->updateUserActivityLog($user->id, 2);
            if ($user) {
                $user_personal_details = UserPersonalDetails::where('user_id', $user->id)->first();
                if (empty($user_personal_details)) {
                    $user_personal_details = new UserPersonalDetails();
                    $user_personal_details->user_id = $user->id;
                }
                if ($_FILES['file']['size'] > 0) {
                    $upload = $this->uploadFile($_FILES['file'], "users/profile_pics");
                    if (empty($upload['errors']) == true) {
                        $user_personal_details->image = $upload['file_name'];
                    } else {
                        return redirect()->back()->with('error', $upload['errors']);
                    }
                }
                $user_personal_details = $user_personal_details->save();
                if ($user_personal_details) {
                    return redirect()->back()->with('success', 'Profile updated successfully.');
                } else {
                    return redirect()->back()->with('error', 'Profile updation failed. Please try again');
                }
            }
        }
    }

    public function userUpdatePersonalDetails(Request $request)
    {
        $data = $request->all();
        if ($data) {
            $user = User::find($data['user_id']);
            $this->updateUserActivityLog($user->id, 2);
            if ($user) {
                $user_personal_details = UserPersonalDetails::where('user_id', $user->id)->first();
                if (empty($user_personal_details)) {
                    $user_personal_details = new UserPersonalDetails();
                    $user_personal_details->user_id = $user->id;
                }
                $user_personal_details->gender = !empty($data['gender']) && $data['gender'] > 0 ? $data['gender'] : 1;
                $user_personal_details->height = $data['height'];
                $user_personal_details->weight = $data['weight'];
                $user_personal_details->age = $data['age'];
                if ($_FILES['doc_image']['size'] > 0) {
                    $upload = $this->uploadFile($_FILES['doc_image'], "users/docs/images");
                    if (empty($upload['errors']) == true) {
                        $user_personal_details->user_doc = $upload['file_name'];
                    } else {
                        return redirect()->back()->with('error', $upload['errors']);
                    }
                }
                $user_personal_details = $user_personal_details->save();
                if ($user_personal_details) {
                    return redirect()->back()->with('success', 'Profile updated successfully.');
                } else {
                    return redirect()->back()->with('error', 'Profile updation failed. Please try again');
                }
            }
        }
    }

    public function userUpdateEmergencyDetails(Request $request)
    {
        $data = $request->all();
        if ($data) {
            $user = User::find($data['user_id']);
            $this->updateUserActivityLog($user->id, 8);
            if ($user) {
                $emergencyContactDetails = EmergencyContactDetails::where('user_id', $user->id)->first();
                if (empty($emergencyContactDetails)) {
                    $emergencyContactDetails = new EmergencyContactDetails();
                    $emergencyContactDetails->user_id = $user->id;
                }
                $emergencyContactDetails->blood_group = $data['blood_group'];
                $emergencyContactDetails->emergency_contact_name = $data['emergency_contact_name'];
                $emergencyContactDetails->emergency_contact_number = $data['emergency_contact_number'];
                $emergency_saved = $emergencyContactDetails->save();
                if ($emergency_saved) {
                    return redirect()->back()->with('success', 'Profile updated successfully.');
                } else {
                    return redirect()->back()->with('error', 'Profile updation failed. Please try again');
                }
            }
        }
    }
}
