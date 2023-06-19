<?php

namespace App\Http\Controllers\site;

use App\Exports\ExportEventUsers;
use App\Http\Controllers\Controller;
use App\Models\EmailTemplates;
use App\Models\Event;
use App\Models\EventGallery;
use App\Models\Sports;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class AdminController extends Controller
{
    public function _access(){
        $user = Auth::user();
        if(intval($user->user_role) != 2){
            return false;
        }
    }
    //
    public function index(Request $request)
    {
        if(!$this->_access()){
           return  redirect('/')->with('error', 'you are not authorized to access this page');
        }
        return view('site.admin.index');
    }
    public function createCategory(Request $request)
    {
        if(!$this->_access()){
           return  redirect('/')->with('error', 'you are not authorized to access this page');
        }
        return view('site.admin.createCategory');
    }

    public function storeCategory(Request $request)
    {
        if(!$this->_access()){
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
        if(!$this->_access()){
           return  redirect('/')->with('error', 'you are not authorized to access this page');
        }
        $Sports = Sports::all();
        return view('site.admin.categoryList', ['categories' => $Sports]);
    }
    public function deleteCategory(Request $request, $id)
    {
        if(!$this->_access()){
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
        if(!$this->_access()){
           return  redirect('/')->with('error', 'you are not authorized to access this page');
        }
        $events = Event::all();
        return view('site.admin.eventsList', ['events' => $events]);
    }

    public function editEvents(Request $request, $id)
    {
        if(!$this->_access()){
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
        if(!$this->_access()){
           return  redirect('/')->with('error', 'you are not authorized to access this page');
        }
        $categories = Sports::all();
        return view('site.admin.createEvent', ['categories' => $categories]);
    }

    public function storeEvent(Request $request)
    {
        if(!$this->_access()){
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
        if(!$this->_access()){
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
        if(!$this->_access()){
           return  redirect('/')->with('error', 'you are not authorized to access this page');
        }
        $eventUsers = DB::table('event_users')
            ->Join("users", "users.id", "=", "event_users.user_id")
            ->Join("events", "events.id", "=", "event_users.event_id")
            ->distinct()
            ->select("event_users.*", "users.first_name", "users.last_name", "users.number", "users.email", "events.event_name")
            ->orderBy('event_users.id', 'desc')
            ->paginate(10);
        return view('site.admin.eventUsers', ['eventusers' => $eventUsers]);
    }

    public  function downloadEventUsers(Request $request)
    {
        if(!$this->_access()){
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
        if(!$this->_access()){
           return  redirect('/')->with('error', 'you are not authorized to access this page');
        }
        $eventGallery = EventGallery::join("events", "events.id", "=", "event_gallery.event_id")->paginate(10);
        return view('site.admin.eventGallery', ['gallery' => $eventGallery]);
    }

    public function emailTemplates(Request $request)
    {
        if(!$this->_access()){
           return  redirect('/')->with('error', 'you are not authorized to access this page');
        }
        $templates = EmailTemplates::all();
        return view('site.admin.emailTemplates', ['templates' => $templates]);
    }

    public function createEmailTemplates(Request $request){
        if(!$this->_access()){
           return  redirect('/')->with('error', 'you are not authorized to access this page');
        }
        $templates = EmailTemplates::all();
        return view('site.admin.createEmailTemplates', ['templates' => $templates]);
    }

    public function storeEmailTemplates(Request $request){
        if(!$this->_access()){
           return  redirect('/')->with('error', 'you are not authorized to access this page');
        }
        print_r($request->all());
    }
}
