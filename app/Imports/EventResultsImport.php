<?php

namespace App\Imports;

use App\Models\EventResult;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\HeadingRowImport;

class EventResultsImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public $headings;
    public $event_id;
    public function __construct($headings, $event_id)
    {
        $this->headings = $headings;
        $this->event_id = $event_id;
    }
    public function model(array $row)
    {
        try {
            $headings = $this->headings;
            if ($row[0] != 'Participant Name') {
                $name = !empty($row[0]) ? explode(' ', $row[0]) : null;
                $first_name = !empty($name[0]) ? $name[0] : '';
                $last_name = !empty($name[1]) ? $name[1] : '';
                $number = !empty($row[3]) ? $row[3] : '';
                $email = !empty($row[2]) ? $row[2] : '';
                $user = DB::table('users');
                if (!empty($first_name))
                    $user = $user->whereRaw("LOWER(first_name) LIKE '" . $first_name . "%' ");
                if (!empty($last_name))
                    $user = $user->whereRaw("LOWER(last_name) LIKE '" . $last_name . "%'");
                if (!empty($number))
                    $user = $user->whereRaw("number like '" . $number . "%'");
                if (!empty($email))
                    $user = $user->where('email', $email);

                $user = $user->select('id');
                $user = $user->first();
                if (!empty($user->id)) {
                    $user_id = $user->id;
                    $event_id = $this->event_id;
                    $insert_data = [];
                    for ($i = 4; $i < count($row); $i++) {
                        $data = [
                            'user_id' => $user_id,
                            'event_id' => $event_id,
                            'event_result_key' => $headings[$i],
                            'event_result_value' => $row[$i]
                        ];
                        $insert_data[] = $data;
                    }
                    $insert_data = collect($insert_data); 
                    $chunks = $insert_data->chunk(500);
                    foreach ($chunks as $chunk) {
                        DB::table('event_result')->insert($chunk->toArray());
                    }
                }
            }
        } catch (Exception $e) {
            print_r($e->getMessage());
        }
    }
}
