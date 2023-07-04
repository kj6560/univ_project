<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventGallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class EventsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $events = DB::table('events')
            ->join('sports', 'sports.id', '=', 'events.event_category')
            ->select('events.*', 'sports.name as name','sports.description as description','sports.icon as icon');
        if (!empty($request->id)) {
            $events = $events->where('events.id', $request->id);
            $events = $events->first();
        }else{
            $events = $events->orderByDesc('events.id')->get();
        }

        

        return response()->json($events);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Event  $Event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $Event)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Event  $Event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $Event)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Event  $Event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $Event)
    {
        //
    }
}
