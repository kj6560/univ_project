<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Jobs\UploadResults;

class upload extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    public $processed;
    protected $signature = 'command:name';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->handle();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $queuedUploads = DB::table('jobs')->where('status', 0)->limit(3)->get();
        foreach ($queuedUploads as $queuedUpload) {
            $className = "App\Jobs\Upload" . $queuedUpload->model;
            if ($className != "App\Jobs\Upload") {

                $upload = new $className;
                $upload->params = json_decode($queuedUpload->params);
                $upload->file = $queuedUpload->file;
                if ($upload->handle()) {
                    $this->processed[] = $queuedUpload->id;
                    DB::table('jobs')->where('id', $queuedUpload->id)->update(['status' => 1]);
                }
            }
        }
        return true;
    }
}
