<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Email;
use App\Models\OauthAccessTokens;
use App\Models\User;
use App\Models\UserOtp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\RefreshToken;
use Laravel\Passport\Token;

class PassportAuthController extends Controller
{
    public function register(Request $request)
    {
        $is_exist = User::where('email', $request->email)->first();
        if (empty($is_exist)) {
            $user = new User([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'number' => $request->phone,
                'email' => $request->email,
                'password' => bcrypt($request->password)
            ]);
            $user->save();
            if (!empty($user)) {
                $user->createToken('LaravelAuthApp')->accessToken;
                $user_name = $user->first_name . " " . $user->last_name;
                $site_name = env("SITE_NAME", "UNIV SPORTA");
                $subject = "Welcome to $site_name";
                $email_sender_name = env("EMAIL_SENDER_NAME", "UNIV SPORTA");
                $email = $user->email;
                $message = "
                    <p>Dear $user_name,</p><br>
                    <p>Thank you for registering with us! We are thrilled to welcome you to our community and appreciate your interest
                    in our Univ.<br>Your registration has been successfully processed, and you are now a valued member of our platform.
                    <br>We are committed to providing you with the best possible user experience, and we will work diligently to ensure 
                    that you have access to all the resources you need.<br>Once again, thank you for registering with us.<br>We look forward 
                    to serving you and providing you with a seamless user experience.</p>
                    <p>Your Login Credentials are:<br>
                    email: $email<br>
                    password: $request->password<br>
                    </p>
                    <br>Best regards,
                    <br>$email_sender_name <br>
                    $site_name
                    ";
                $mailData = array("email" => $user->email, "first_name" => $user->first_name, "last_name" => $user->last_name, "subject" => $subject, "message" => $message);

                $sent = Email::sendEmail($mailData);
                return response()->json(['success' => true, 'email' => $sent], 200);
            } else {
                return response()->json(['error' => true, 'msg' => 'user not created'], 401);
            }
        } else {
            return response()->json(['error' => true, 'msg' => 'user already exist by this email'], 402);
        }
    }
    public function login(Request $request)
    {
        $data = [
            'email' => $request->email,
            'password' => $request->password
        ];
        $user = User::where('email', $data['email'])->first();
        if (!empty($user)) {
            if (Hash::check($request->password, $user['password'])) {
                $token = $user->createToken('LaravelAuthApp')->accessToken;
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
                return response()->json(['token' => $token, 'user' => $reg_user], 200);
            } else {
                return response()->json(['error' => 'Unauthorised'], 401);
            }
        } else {
            return response()->json(['error' => 'user email not registered'], 403);
        }
    }
    public function logout(Request $request)
    {
        $user = OauthAccessTokens::where('user_id', $request->user_id)->delete();
        if ($user) {
            return response()->json(['error' => true], 200);
        } else {
            return response()->json(['success' => true], 200);
        }
    }
    public function sendEmailOtp(Request $request)
    {
        $email = $request->email;
        if (!empty($email)) {
            $user = User::where('email', $email)->first();
            $user_otp = UserOtp::where('user_id', $user->id)->where('is_available', 1)->first();
            if (!empty($user) && empty($user_otp)) {
                $otp = rand(100000, 999999);
                $user_otp = new UserOtp();
                $user_otp->user_id = $user->id;
                $user_otp->otp = $otp;
                $user_otp->is_available = 1;
                $user_otp->source = 1;
                if ($user_otp->save()) {
                    $user_name = $user->first_name . " " . $user->last_name;
                    $site_name = env("SITE_NAME", "UNIV SPORTA");
                    $subject = "Forgot Password";
                    $email_sender_name = env("EMAIL_SENDER_NAME", "UNIV SPORTA");
                    $email = $user->email;
                    $message = "
                    <p>Dear $user_name,</p><br>
                    <p>Your OTP to reset password is $otp.<br> Please do not share this OTP with anyone.</p>
                    
                    <br>Best regards,
                    <br>$email_sender_name <br>
                    $site_name
                    ";
                    $mailData = array("email" => $user->email, "first_name" => $user->first_name, "last_name" => $user->last_name, "subject" => $subject, "message" => $message);

                    Email::sendEmail($mailData);
                    return response()->json(['success' => true, 'otp' => $otp, "Otp has been sent to email successfully"], 200);
                }
            } else if (!empty($user_otp)) {
                $user_name = $user->first_name . " " . $user->last_name;
                $site_name = env("SITE_NAME", "UNIV SPORTA");
                $subject = "Forgot Password";
                $email_sender_name = env("EMAIL_SENDER_NAME", "UNIV SPORTA");
                $email = $user->email;
                $message = "
                    <p>Dear $user_name,</p><br>
                    <p>Your OTP to reset password is $user_otp->otp.<br> Please do not share this OTP with anyone.</p>
                    
                    <br>Best regards,
                    <br>$email_sender_name <br>
                    $site_name
                    ";
                $mailData = array("email" => $user->email, "first_name" => $user->first_name, "last_name" => $user->last_name, "subject" => $subject, "message" => $message);

                Email::sendEmail($mailData);
                return response()->json(['success' => true, 'otp' => $user_otp->otp, "Otp has been sent to email successfully"], 200);
            } else {
                return response()->json(['error' => true, 'msg' => 'No user registered by this email'], 402);
            }
        } else {
            return response()->json(['error' => true, 'msg' => 'Email id missing'], 402);
        }
    }

    public function resetPassword(Request $request)
    {
        $email = $request->email;
        if (!empty($email)) {
            $user = User::where('email', $email)->first();
            $user_otp = UserOtp::where('user_id', $user->id)->where("otp", $request->otp)->where('is_available', 1)->first();
            if (!empty($user) && !empty($user_otp)) {
                $user->password = bcrypt($request->password);
                $user = $user->save();
                $user_otp->is_available = 0;
                $user_otp = $user_otp->save();
                if (!empty($user) && !empty($user_otp)) {
                    $user_name = $user->first_name . " " . $user->last_name;
                    $site_name = env("SITE_NAME", "UNIV SPORTA");
                    $subject = "Forgot Password";
                    $email_sender_name = env("EMAIL_SENDER_NAME", "UNIV SPORTA");
                    $email = $user->email;
                    $message = "
                    <p>Dear $user_name,</p><br>
                    <p>Your password has been reset successfully. If you haven't changed it, please contact us immediately</p>
                    
                    <br>Best regards,
                    <br>$email_sender_name <br>
                    $site_name
                    ";
                    $mailData = array("email" => $user->email, "first_name" => $user->first_name, "last_name" => $user->last_name, "subject" => $subject, "message" => $message);

                    Email::sendEmail($mailData);
                    return response()->json(['success' => true,  "password has been reset successfully"], 200);
                }
            } else {
                return response()->json(['error' => true,  "Invalid user or otp"], 200);
            }
        } else {
            return response()->json(['error' => true,  "missing email"], 200);
        }
    }
}
