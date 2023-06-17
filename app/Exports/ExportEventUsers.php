<?php

namespace App\Exports;

use App\Models\EventUsers;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportEventUsers implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return  DB::table('event_users')
        ->Join("users", "users.id", "=", "event_users.user_id")
        ->Join("events", "events.id", "=", "event_users.event_id")
        ->select("users.first_name", "users.last_name", "users.number", "users.email", "events.event_name")
        ->get();
    }
    public function download(){
        return DB::table('event_users')
        ->Join("users", "users.id", "=", "event_users.user_id")
        ->Join("events", "events.id", "=", "event_users.event_id")
        ->select("users.first_name", "users.last_name", "users.number", "users.email", "events.event_name")
        ->get();
    }
    public function headings(): array
    {
        return ["First Name", "Last Name", "Phone Number","Email","Event Name"];
    }
}
