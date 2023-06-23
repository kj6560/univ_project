<?php

namespace App\Http\Controllers\site;

use App\Exports\ExportEventUsers;
use App\Http\Controllers\Controller;
use App\Models\Email;
use App\Models\EmailTemplates;
use App\Models\Event;
use App\Models\EventGallery;
use App\Models\EventSlider;
use App\Models\SiteSettings;
use App\Models\Sports;
use App\Models\User;
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
    public function eventGalleryUploads(Request $request)
    {
        if (!$this->_access()) {
            return  redirect('/')->with('error', 'you are not authorized to access this page');
        }
        $eventGallery = EventGallery::join("events", "events.id", "=", "event_gallery.event_id")->paginate(10);
        return view('site.admin.eventGallery', ['gallery' => $eventGallery]);
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
        return view('site.admin.users', ['users' => $users,'filters'=>$reqData]);
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
            if($user){
                return  redirect()->back()->with('success', 'user deleted successfully');
            }else{
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
        return view('site.admin.userActivityLog', ['users' => $users,'filters'=>$reqData]);
    }
}
