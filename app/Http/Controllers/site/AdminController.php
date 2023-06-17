<?php

namespace App\Http\Controllers\site;

use App\Exports\ExportEventUsers;
use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Sports;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
class AdminController extends Controller
{
    //
    public function index(Request $request)
    {
        return view('site.admin.index');
    }
    public function createCategory(Request $request)
    {
        return view('site.admin.createCategory');
    }

    public function storeCategory(Request $request)
    {
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
        $Sports = Sports::all();
        return view('site.admin.categoryList', ['categories' => $Sports]);
    }
    public function deleteCategory(Request $request, $id)
    {
        $Sports = Sports::find($id);
        if (!empty($id) && Sports::destroy($id) && $this->deleteFile($Sports->icon, "category/images")) {
            return redirect()->back()->with('success', 'category deletion successfully');
        } else {
            return redirect()->back()->with('error', 'category deletion failed');
        }
    }

    public function eventsList(Request $request)
    {
        $events = Event::all();
        return view('site.admin.eventsList', ['events' => $events]);
    }

    public function editEvents(Request $request, $id)
    {
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
        $categories = Sports::all();
        return view('site.admin.createEvent', ['categories' => $categories]);
    }

    public function storeEvent(Request $request)
    {
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
        if (!empty($_FILES['image'])) {
            $upload = $this->uploadFile($_FILES['image'], "events/images");
            if (empty($upload['errors']) == true) {
                $event->event_image = $upload['file_name'];
                if ($event->save()) {
                    return redirect()->back()->with('success', 'event created successfully');
                } else {
                    return redirect()->back()->with('error', 'event creation failed');
                }
            } else {
                return redirect()->back()->with('error', $upload['errors']);
            }
        }
        return redirect()->back()->with('error', 'Some unhandled issue');
    }
    public function deleteEvent(Request $request, $id)
    {
        $Event = Event::find($id);
        if (!empty($id) && Event::destroy($id) && $this->deleteFile($Event->event_image, "events/images")) {
            return redirect()->back()->with('success', 'event deletion successfully');
        } else {
            return redirect()->back()->with('error', 'event deletion failed');
        }
    }

    public function eventUsers(Request $request)
    {
        $eventUsers = DB::table('event_users')
            ->Join("users", "users.id", "=", "event_users.user_id")
            ->Join("events", "events.id", "=", "event_users.event_id")
            ->select("event_users.*", "users.first_name", "users.last_name", "users.number", "users.email", "events.event_name")
            ->paginate(10);
        return view('site.admin.eventUsers', ['eventusers' => $eventUsers]);
    }

    public  function downloadEventUsers(Request $request)
    {
        
        return self::downloadEventUsersData();
    }
    public static function downloadEventUsersData()
    {
        
        return Excel::download(new ExportEventUsers, 'users.csv');
    }
}
