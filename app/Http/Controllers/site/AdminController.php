<?php

namespace App\Http\Controllers\site;

use App\Exports\ExportEventUsers;
use App\Http\Controllers\Controller;
use App\Models\Email;
use App\Models\EmailTemplates;
use App\Models\EmergencyContactDetails;
use App\Models\Event;
use App\Models\EventGallery;
use App\Models\EventSlider;
use App\Models\SiteGallery;
use App\Models\SiteSettings;
use App\Models\Sports;
use App\Models\User;
use App\Models\UserAddressDetails;
use App\Models\UserPersonalDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class AdminController extends Controller
{
    public function _access()
    {
        $user = Auth::user();
        if (intval($user->user_role) != 3) {
            return false;
        } else {
            return true;
        }
    }

    public function index(Request $request)
    {
        if (!$this->_access()) {
            return  redirect('/')->with('error', 'you are not authorized to access this page');
        }
        return view('site.admin.index');
    }
    public function createCategory(Request $request)
    {
        if (!$this->_access()) {
            return  redirect('/')->with('error', 'you are not authorized to access this page');
        }
        return view('site.admin.createCategory');
    }

    public function storeCategory(Request $request)
    {
        if (!$this->_access()) {
            return  redirect('/')->with('error', 'you are not authorized to access this page');
        }
        $data = $request->all();
        if (!empty($data)) {
            $validatedData = $request->validate([
                'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',

            ]);
            if ($validatedData) {
                if (!empty($_FILES['image'])) {

                    $upload = $this->uploadFile($_FILES['image'], "category/images");
                    if (empty($upload['errors']) == true) {
                        $category = new Sports();
                        $category->name = $data['name'];
                        $category->icon = $upload['file_name'];
                        $category->description = $data['description'];
                        if ($category->save()) {
                            return redirect()->back()->with('success', 'category created successfully');
                        } else {
                            return redirect()->back()->with('error', 'category creation failed');
                        }
                    } else {
                        return redirect()->back()->with('error', $upload['errors']);
                    }
                } else {
                    return redirect()->back()->with('error', 'please select icon');
                }
            }
        } else {
            return redirect()->back()->with('error', 'please fill all fields');
        }
    }
    public function categoryList(Request $request)
    {
        if (!$this->_access()) {
            return  redirect('/')->with('error', 'you are not authorized to access this page');
        }
        $Sports = Sports::all();
        return view('site.admin.categoryList', ['categories' => $Sports]);
    }
    public function deleteCategory(Request $request, $id)
    {
        if (!$this->_access()) {
            return  redirect('/')->with('error', 'you are not authorized to access this page');
        }
        $Sports = Sports::find($id);
        if (!empty($id) && Sports::destroy($id) && $this->deleteFile($Sports->icon, "category/images")) {
            return redirect()->back()->with('success', 'category deletion successfully');
        } else {
            return redirect()->back()->with('error', 'category deletion failed');
        }
    }

    public function eventsList(Request $request)
    {
        if (!$this->_access()) {
            return  redirect('/')->with('error', 'you are not authorized to access this page');
        }
        $events = Event::all();
        return view('site.admin.eventsList', ['events' => $events]);
    }

    public function editEvents(Request $request, $id)
    {
        if (!$this->_access()) {
            return  redirect('/')->with('error', 'you are not authorized to access this page');
        }
        if (!empty($id)) {
            $event = Event::find($id);
        } else {
            return redirect()->back()->with('error', 'event id not available');
        }
        $categories = Sports::all();
        return view('site.admin.createEvent', ['event' => $event, 'categories' => $categories]);
    }

    public function createEvents(Request $request)
    {
        if (!$this->_access()) {
            return  redirect('/')->with('error', 'you are not authorized to access this page');
        }
        $categories = Sports::all();
        return view('site.admin.createEvent', ['categories' => $categories]);
    }

    public function storeEvent(Request $request)
    {
        if (!$this->_access()) {
            return  redirect('/')->with('error', 'you are not authorized to access this page');
        }
        $data = $request->all();
        if (!empty($data['event_id'])) {
            //update
            $event = Event::find($data['event_id']);
        } else {
            //create
            $event = new Event();
        }
        $event->event_name = $data['event_name'];
        $event->event_bio = $data['event_bio'];
        $event->event_date = $data['event_date'];
        $event->event_location = $data['event_location'];
        $event->event_objective = $data['event_objective'];
        $event->event_category = $data['event_category'];
        $event->event_live_link = $data['event_live_link'];
        $event->event_registration_available = $data['event_registration_available'];
        if ($_FILES['image']['size'] > 0) {
            $upload = $this->uploadFile($_FILES['image'], "events/images");
            if (empty($upload['errors']) == true) {
                $event->event_image = $upload['file_name'];
            } else {
                return redirect()->back()->with('error', $upload['errors']);
            }
        }

        if ($_FILES['event_detail_header']['size'] > 0) {
            $upload_header = $this->uploadFile($_FILES['event_detail_header'], "events/images");
            if (empty($upload_header['errors']) == true) {
                $event->event_detail_header = $upload_header['file_name'];
            } else {
                return redirect()->back()->with('error', $upload_header['errors']);
            }
        }

        if ($event->save()) {
            return redirect()->back()->with('success', 'event created successfully');
        } else {
            return redirect()->back()->with('error', 'event creation failed');
        }
        return redirect()->back()->with('error', 'Some unhandled issue');
    }
    public function deleteEvent(Request $request, $id)
    {
        if (!$this->_access()) {
            return  redirect('/')->with('error', 'you are not authorized to access this page');
        }
        $Event = Event::find($id);
        if (!empty($id) && Event::destroy($id) && $this->deleteFile($Event->event_image, "events/images")) {
            return redirect()->back()->with('success', 'event deletion successfully');
        } else {
            return redirect()->back()->with('error', 'event deletion failed');
        }
    }

    public function eventUsers(Request $request)
    {
        if (!$this->_access()) {
            return  redirect('/')->with('error', 'you are not authorized to access this page');
        }
        $eventUsers = DB::table('event_users')
            ->Join("users", "users.id", "=", "event_users.user_id")
            ->Join("events", "events.id", "=", "event_users.event_id")
            ->leftJoin("user_address_details", "user_address_details.user_id", "=", "users.id")
            ->leftJoin("user_personal_details", "user_personal_details.user_id", "=", "users.id")
            ->leftJoin("emergency_contact_details", "emergency_contact_details.user_id", "=", "users.id")
            ->distinct()
            ->select(
                "event_users.*",
                "user_address_details.*",
                "user_personal_details.*",
                "emergency_contact_details.*",
                "users.id",
                "users.first_name",
                "users.last_name",
                "users.number",
                "users.email",
                "events.event_name"
            )
            ->orderBy('event_users.id', 'desc');

        $reqData = $request->all();
        unset($reqData['_token']);
        if (!empty($reqData) && empty($reqData['page']) && empty($reqData['sort'])) {
            $filter = $this->processFilter($reqData);
            $eventUsers = $eventUsers->whereRaw($filter);
            $eventUsers = $eventUsers->get();
        } else {
            $eventUsers = $eventUsers->paginate(50);
        }
        return view('site.admin.eventUsers', ['eventusers' => $eventUsers, 'filters' => $reqData]);
    }

    public  function downloadEventUsers(Request $request)
    {
        if (!$this->_access()) {
            return  redirect('/')->with('error', 'you are not authorized to access this page');
        }
        return self::downloadEventUsersData();
    }
    public static function downloadEventUsersData()
    {

        return Excel::download(new ExportEventUsers, 'users.csv');
    }
    public function siteGallery(Request $request)
    {
        if (!$this->_access()) {
            return  redirect('/')->with('error', 'you are not authorized to access this page');
        }
        $siteGallery = SiteGallery::paginate(10);
        return view('site.admin.siteGallery', ['gallery' => $siteGallery]);
    }

    public function emailTemplates(Request $request)
    {
        if (!$this->_access()) {
            return  redirect('/')->with('error', 'you are not authorized to access this page');
        }
        $templates = EmailTemplates::all();
        return view('site.admin.emailTemplates', ['templates' => $templates]);
    }

    public function createEmailTemplates(Request $request)
    {
        if (!$this->_access()) {
            return  redirect('/')->with('error', 'you are not authorized to access this page');
        }
        $templates = EmailTemplates::all();
        return view('site.admin.createEmailTemplates', ['templates' => $templates]);
    }

    public function editEmailTemplates(Request $request, $id)
    {
        if (!$this->_access()) {
            return  redirect('/')->with('error', 'you are not authorized to access this page');
        }
        $templates = EmailTemplates::where("id", $id)->first();
        return view('site.admin.createEmailTemplates', ['template' => $templates]);
    }

    public function storeEmailTemplates(Request $request)
    {
        if (!$this->_access()) {
            return  redirect('/')->with('error', 'you are not authorized to access this page');
        }
        $data = $request->all();
        unset($data['_token']);
        if (!empty($data)) {
            if (!empty($data['id'])) {
                $template = EmailTemplates::where("id", $data['id'])->first();
            } else {
                $template = new EmailTemplates();
            }

            $template->template_name = $data['template_name'];
            $template->template_data = $data['template_data'];
            if ($template->save()) {
                return  redirect()->back()->with('success', 'Email template updated successfully');
            } else {
                return  redirect()->back()->with('error', 'Email template update failed');
            }
        }
    }
    public function deleteEmailTemplates(Request $request, $id)
    {
        if (!$this->_access()) {
            return  redirect('/')->with('error', 'you are not authorized to access this page');
        }
        if (!empty($id)) {
            $template = EmailTemplates::destroy($id);
            if ($template) {
                return redirect()->back()->with('success', 'template deletion successfully');
            } else {
                return redirect()->back()->with('error', 'template deletion successfully');
            }
        } else {
            return redirect()->back()->with('error', 'settings deletion successfully');
        }
    }
    public function siteSettingsList(Request $request)
    {
        if (!$this->_access()) {
            return  redirect('/')->with('error', 'you are not authorized to access this page');
        }
        $settings = SiteSettings::all();
        return view('site.admin.siteSettingsList', ['settings' => $settings]);
    }
    public function createSettings(Request $request)
    {
        if (!$this->_access()) {
            return  redirect('/')->with('error', 'you are not authorized to access this page');
        }
        $data = $request->all();
        if (!empty($data['id'])) {
            $settings = SiteSettings::where("id", $data['id'])->first();
        } else {
            $settings = new SiteSettings();
        }

        return view('site.admin.createSettings', ['settings' => $settings]);
    }

    public function storeSettings(Request $request)
    {
        $data = $request->all();
        unset($data['_token']);
        if (!empty($data)) {
            if (!empty($data['id'])) {
                $settings = SiteSettings::where("id", $data['id'])->first();
                $settings->site_key = $data['site_key'];
                $settings->site_value = $data['site_value'];
                if ($settings->save()) {
                    return back()->with('success', 'Settings updated successfully');
                }
            } else {
                $settings = new SiteSettings();
                $settings->site_key = $data['site_key'];
                $settings->site_value = $data['site_value'];

                if ($settings->save()) {
                    return back()->with('success', 'Settings updated successfully');
                } else {
                    return back()->with('error', 'Settings update failed');
                }
            }
        } else {
            return back()->with('error', 'Settings update failed');
        }
    }
    public function editSettings(Request $request, $id)
    {
        if (!$this->_access()) {
            return  redirect('/')->with('error', 'you are not authorized to access this page');
        }
        if (!empty($id)) {
            $settings = SiteSettings::where("id", $id)->first();
        }

        return view('site.admin.createSettings', ['settings' => $settings]);
    }
    public function deleteSettings(Request $request, $id)
    {
        if (!$this->_access()) {
            return  redirect('/')->with('error', 'you are not authorized to access this page');
        }
        if (!empty($id)) {
            $settings = SiteSettings::destroy($id);
            if ($settings) {
                return redirect()->back()->with('success', 'settings deletion successfully');
            } else {
                return redirect()->back()->with('error', 'settings deletion successfully');
            }
        } else {
            return redirect()->back()->with('error', 'settings deletion successfully');
        }
    }
    public function eventSliders(Request $request)
    {
        if (!$this->_access()) {
            return  redirect('/')->with('error', 'you are not authorized to access this page');
        }
        $sliders = EventSlider::join("events", "events.id", "=", "event_slider.event_id")
            ->select("event_slider.*", "events.event_name")
            ->orderBy('event_slider.id', 'desc')
            ->paginate(10);
        return view('site.admin.eventSliders', ['sliders' => $sliders]);
    }

    public function createSlider(Request $request)
    {
        if (!$this->_access()) {
            return  redirect('/')->with('error', 'you are not authorized to access this page');
        }
        $events = Event::all();
        return view('site.admin.createSlider', ['events' => $events]);
    }

    public function storeSlider(Request $request)
    {
        if (!$this->_access()) {
            return  redirect('/')->with('error', 'you are not authorized to access this page');
        }
        $data = $request->all();
        if (!empty($data['slider_id'])) {
            //update
            $slider = EventSlider::find($data['slider_id']);
        } else {
            //create
            $slider = new EventSlider();
        }
        $slider->event_id = $data['event_id'];
        if ($_FILES['image']['size'] > 0) {
            $upload = $this->uploadFile($_FILES['image'], "events/images");
            if (empty($upload['errors']) == true) {
                $slider->image = $upload['file_name'];
            } else {
                return redirect()->back()->with('error', $upload['errors']);
            }
        }


        if ($slider->save()) {
            return redirect()->back()->with('success', 'slider created successfully');
        } else {
            return redirect()->back()->with('error', 'slider creation failed');
        }
        return redirect()->back()->with('error', 'Some unhandled issue');
    }
    public function deleteSlider(Request $request, $id)
    {
        if (!$this->_access()) {
            return  redirect('/')->with('error', 'you are not authorized to access this page');
        }
        if (!empty($id)) {
            $slider = EventSlider::destroy($id);
            if ($slider) {
                return redirect()->back()->with('success', 'slider deletion successfully');
            } else {
                return redirect()->back()->with('error', 'slider deletion successfully');
            }
        } else {
            return redirect()->back()->with('error', 'slider deletion successfully');
        }
    }

    public function users(Request $request)
    {
        if (!$this->_access()) {
            return  redirect('/')->with('error', 'you are not authorized to access this page');
        }
        $users = DB::table('users')
            ->distinct()
            ->orderBy('id', 'desc');
        $reqData = $request->all();
        unset($reqData['_token']);

        if (!empty($reqData) && empty($reqData['page']) && empty($reqData['sort'])) {
            $filter = $this->processFilter($reqData);
            $users = $users->whereRaw($filter);
            $users = $users->get();
        } else {
            $users = $users->paginate(50);
        }
        return view('site.admin.users', ['users' => $users, 'filters' => $reqData]);
    }

    public function editUser(Request $request, $id)
    {
        if (!$this->_access()) {
            return  redirect('/')->with('error', 'you are not authorized to access this page');
        }
        $user = User::find($id);
        return view('site.admin.editUser', ['user' => $user]);
    }
    public function storeUser(Request $request)
    {
        if (!$this->_access()) {
            return  redirect('/')->with('error', 'you are not authorized to access this page');
        }
        $data = $request->all();
        if (!empty($data['id'])) {
            $user = User::find($data['id']);
            $user->first_name = $data['first_name'];
            $user->last_name = $data['last_name'];
            $user->email = $data['email'];
            $user->number = $data['number'];
            $user->user_role = $data['user_role'];
            if (!empty($data['password'])) {
                $pass_plain = $data['password'];
                $password = bcrypt($pass_plain);
                $user->password = $password;
            }
            if ($user->save()) {
                return  redirect()->back()->with('success', 'user updated successfully');
            } else {
                return  redirect()->back()->with('error', 'user update failed');
            }
        }
    }
    public function deleteUser(Request $request, $id)
    {
        if (!$this->_access()) {
            return  redirect('/')->with('error', 'you are not authorized to access this page');
        }
        if (!empty($id)) {
            $user = User::destroy($id);
            if ($user) {
                return  redirect()->back()->with('success', 'user deleted successfully');
            } else {
                return  redirect()->back()->with('error', 'user deletion failed');
            }
        }
    }

    public function userActivityLog(Request $request)
    {
        if (!$this->_access()) {
            return  redirect('/')->with('error', 'you are not authorized to access this page');
        }
        $users = DB::table('user_activity_log')
            ->join('users', 'users.id', '=', 'user_activity_log.user_id')
            ->join('activity', 'activity.id', '=', 'user_activity_log.activity_id')
            ->select('user_activity_log.*', 'users.first_name', 'users.last_name', 'users.number', 'users.email', 'activity.activity_name')
            ->distinct()
            ->orderBy('user_activity_log.id', 'desc');
        $reqData = $request->all();
        unset($reqData['_token']);

        if (!empty($reqData) && empty($reqData['page']) && empty($reqData['sort'])) {
            $filter = $this->processFilter($reqData);
            $users = $users->whereRaw($filter);
            $users = $users->get();
        } else {
            $users = $users->paginate(50);
        }
        return view('site.admin.userActivityLog', ['users' => $users, 'filters' => $reqData]);
    }
    public function userPersonalDetails(Request $request)
    {
        if (!$this->_access()) {
            return  redirect('/')->with('error', 'you are not authorized to access this page');
        }
        $users = DB::table('user_personal_details')
            ->join('users', 'users.id', '=', 'user_personal_details.user_id')
            ->select('user_personal_details.*', 'users.first_name', 'users.last_name', 'users.number', 'users.email')
            ->distinct()
            ->orderBy('user_personal_details.id', 'desc');
        $reqData = $request->all();
        unset($reqData['_token']);

        if (!empty($reqData) && empty($reqData['page']) && empty($reqData['sort'])) {
            $filter = $this->processFilter($reqData);
            $users = $users->whereRaw($filter);
            $users = $users->get();
        } else {
            $users = $users->paginate(50);
        }
        return view('site.admin.userPersonalDetails', ['users' => $users, 'filters' => $reqData]);
    }
    public function userAddressDetails(Request $request)
    {
        if (!$this->_access()) {
            return  redirect('/')->with('error', 'you are not authorized to access this page');
        }
        $users = DB::table('user_address_details')
            ->join('users', 'users.id', '=', 'user_address_details.user_id')
            ->select('user_address_details.*', 'users.first_name', 'users.last_name', 'users.number', 'users.email')
            ->distinct()
            ->orderBy('user_address_details.id', 'desc');
        $reqData = $request->all();
        unset($reqData['_token']);

        if (!empty($reqData) && empty($reqData['page']) && empty($reqData['sort'])) {
            $filter = $this->processFilter($reqData);
            $users = $users->whereRaw($filter);
            $users = $users->get();
        } else {
            $users = $users->paginate(50);
        }
        return view('site.admin.userAddressDetails', ['users' => $users, 'filters' => $reqData]);
    }

    public function userEmergencyDetails(Request $request)
    {
        if (!$this->_access()) {
            return  redirect('/')->with('error', 'you are not authorized to access this page');
        }
        $users = DB::table('emergency_contact_details')
            ->join('users', 'users.id', '=', 'emergency_contact_details.user_id')
            ->select('emergency_contact_details.*', 'users.first_name', 'users.last_name', 'users.number', 'users.email')
            ->distinct()
            ->orderBy('emergency_contact_details.id', 'desc');
        $reqData = $request->all();
        unset($reqData['_token']);

        if (!empty($reqData) && empty($reqData['page']) && empty($reqData['sort'])) {
            $filter = $this->processFilter($reqData);
            $users = $users->whereRaw($filter);
            $users = $users->get();
        } else {
            $users = $users->paginate(50);
        }
        return view('site.admin.userEmergencyDetails', ['users' => $users, 'filters' => $reqData]);
    }
    public function editUserPersonalDetails(Request $request, $id)
    {
        if (!$this->_access()) {
            return  redirect('/')->with('error', 'you are not authorized to access this page');
        }
        $user = UserPersonalDetails::find($id);
        return view('site.admin.editUserPersonalDetails', ['user' => $user]);
    }

    public function storeUserPersonalDetails(Request $request)
    {
        if (!$this->_access()) {
            return  redirect('/')->with('error', 'you are not authorized to access this page');
        }
        $data = $request->all();
        unset($data['_token']);
        if (!empty($data['user_id'])) {
            $userPersonalDetails = UserPersonalDetails::where('user_id', $data['user_id'])->first();
        } else {
            $userPersonalDetails = new UserPersonalDetails();
            $userPersonalDetails->user_id = $data['user_id'];
        }
        $userPersonalDetails->gender = $data['gender'];
        $userPersonalDetails->birthday = $data['birthday'];
        $userPersonalDetails->height = $data['height'];
        $userPersonalDetails->weight = $data['weight'];
        $userPersonalDetails->age = $data['age'];
        $userPersonalDetails->married = $data['married'];
        if (isset($_FILES['profile_image']) && $_FILES['profile_image']['size'] > 0) {
            $upload = $this->uploadFile($_FILES['profile_image'], "users/profile_pics");
            if (empty($upload['errors']) == true) {
                $userPersonalDetails->image = $upload['file_name'];
            } else {
                return redirect()->back()->with('error', $upload['errors']);
            }
        }

        if (isset($_FILES['user_doc']) && $_FILES['user_doc']['size'] > 0) {
            $upload = $this->uploadFile($_FILES['user_doc'], "users/docs/images");
            if (empty($upload['errors']) == true) {
                $userPersonalDetails->user_doc = $upload['file_name'];
            } else {
                return redirect()->back()->with('error', $upload['errors']);
            }
        }

        if ($userPersonalDetails->save()) {
            return  redirect()->back()->with('success', 'user personal details updated successfully');
        } else {
            return  redirect()->back()->with('error', 'user personal details update failed');
        }
    }

    public function deleteUserPersonalDetails(Request $request, $id)
    {
        if (!$this->_access()) {
            return  redirect('/')->with('error', 'you are not authorized to access this page');
        }
        if (!empty($id)) {
            $user = UserPersonalDetails::destroy($id);
            if ($user) {
                return  redirect()->back()->with('success', 'user personal details deleted successfully');
            } else {
                return  redirect()->back()->with('error', 'user personal details deletion failed');
            }
        }
    }

    public function editUserAddressDetails(Request $request, $id)
    {
        if (!$this->_access()) {
            return  redirect('/')->with('error', 'you are not authorized to access this page');
        }
        $user = UserAddressDetails::find($id);
        return view('site.admin.editUserAddressDetails', ['user' => $user]);
    }

    public function storeUserAddressDetails(Request $request)
    {
        if (!$this->_access()) {
            return  redirect('/')->with('error', 'you are not authorized to access this page');
        }
        $data = $request->all();
        unset($data['_token']);
        if (!empty($data['user_id'])) {
            $userAddressDetails = UserAddressDetails::where('user_id', $data['user_id'])->first();
        } else {
            $userAddressDetails = new UserAddressDetails();
            $userAddressDetails->user_id = $data['user_id'];
        }
        $userAddressDetails->address_line1 = $data['address_line1'];
        $userAddressDetails->city = $data['city'];
        $userAddressDetails->state = $data['state'];
        $userAddressDetails->pincode = $data['pincode'];

        if ($userAddressDetails->save()) {
            return  redirect()->back()->with('success', 'user address details updated successfully');
        } else {
            return  redirect()->back()->with('error', 'user address details update failed');
        }
    }

    public function deleteUserAddressDetails(Request $request, $id)
    {
        if (!$this->_access()) {
            return  redirect('/')->with('error', 'you are not authorized to access this page');
        }
        if (!empty($id)) {
            $user = UserAddressDetails::destroy($id);
            if ($user) {
                return  redirect()->back()->with('success', 'user Address details deleted successfully');
            } else {
                return  redirect()->back()->with('error', 'user Address details deletion failed');
            }
        }
    }

    public function editUserEmergencyDetails(Request $request, $id)
    {
        if (!$this->_access()) {
            return  redirect('/')->with('error', 'you are not authorized to access this page');
        }
        $user = EmergencyContactDetails::find($id);
        return view('site.admin.editUserEmergencyDetails', ['user' => $user]);
    }

    public function storeUserEmergencyDetails(Request $request)
    {
        if (!$this->_access()) {
            return  redirect('/')->with('error', 'you are not authorized to access this page');
        }
        $data = $request->all();
        unset($data['_token']);
        if (!empty($data['user_id'])) {
            $emergencyContactDetails = EmergencyContactDetails::where('user_id', $data['user_id'])->first();
        } else {
            $emergencyContactDetails = new EmergencyContactDetails();
            $emergencyContactDetails->user_id = $data['user_id'];
        }
        $emergencyContactDetails->blood_group = $data['blood_group'];
        $emergencyContactDetails->emergency_contact_name = $data['emergency_contact_name'];
        $emergencyContactDetails->emergency_contact_number = $data['emergency_contact_number'];

        if ($emergencyContactDetails->save()) {
            return  redirect()->back()->with('success', 'user emergency details updated successfully');
        } else {
            return  redirect()->back()->with('error', 'user emergency details update failed');
        }
    }

    public function deleteUserEmergencyDetails(Request $request, $id)
    {
        if (!$this->_access()) {
            return  redirect('/')->with('error', 'you are not authorized to access this page');
        }
        if (!empty($id)) {
            $user = EmergencyContactDetails::destroy($id);
            if ($user) {
                return  redirect()->back()->with('success', 'user emergency details deleted successfully');
            } else {
                return  redirect()->back()->with('error', 'user emergency details deletion failed');
            }
        }
    }

    public function eventGallery(Request $request)
    {
        if (!$this->_access()) {
            return  redirect('/')->with('error', 'you are not authorized to access this page');
        }
    }

    public function addGallery(Request $request)
    {
        if (!$this->_access()) {
            return  redirect('/')->with('error', 'you are not authorized to access this page');
        }
        return view('site.admin.addGallery');
    }
    public function storeGallery(Request $request)
    {
        if (!$this->_access()) {
            return  redirect('/')->with('error', 'you are not authorized to access this page');
        }
        $data = $request->all();
        unset($data['_token']);
        if (!empty($data)) {
            $siteGallery = new SiteGallery();
            if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
                $upload = $this->uploadFile($_FILES['image'], "events/images");
                if (empty($upload['errors']) == true) {

                    $siteGallery->image = $upload['file_name'];
                } else {
                    return redirect()->back()->with('error', $upload['errors']);
                }
            }
            if (!empty($data['image_priority'])) {
                $siteGallery->image_priority = $data['image_priority'];
                $currentImagesWithPriority = SiteGallery::whereRaw("image_priority > 0")->orderBy('image_priority', 'ASC')->get();
                if (!empty($currentImagesWithPriority[0])) {
                    if ($this->adjustPriority($currentImagesWithPriority, $data['image_priority'], $siteGallery->image)) {
                        if ($siteGallery->save()) {
                            return redirect()->back()->with('success', 'gallery image added successfully');
                        } else {
                            return redirect()->back()->with('error', 'gallery image add failed');
                        }
                    } else {
                        return redirect()->back()->with('error', 'gallery image add failed');
                    }
                } else {
                    if ($siteGallery->save()) {
                        return redirect()->back()->with('success', 'gallery image added successfully');
                    } else {
                        return redirect()->back()->with('error', 'gallery image add failed');
                    }
                }
            } else {
                $siteGallery->image_priority = DB::table("site_gallery")->selectRaw("max(image_priority) as max")->first()->max + 1;
                if ($siteGallery->save()) {
                    return redirect()->back()->with('success', 'gallery image added successfully');
                } else {
                    return redirect()->back()->with('error', 'gallery image add failed');
                }
            }
        }
    }
}
