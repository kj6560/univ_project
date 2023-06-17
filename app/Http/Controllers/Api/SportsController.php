<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Sports;
use Illuminate\Http\Request;

class SportsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sports = Sports::all();
        $events = Event::all();
        $user = auth()->user();
        return response()->json($sports);
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
     * @param  \App\Models\Sports  $sports
     * @return \Illuminate\Http\Response
     */
    public function show(Sports $sports)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sports  $sports
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sports $sports)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sports  $sports
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sports $sports)
    {
        //
    }
}
