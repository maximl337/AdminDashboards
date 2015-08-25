<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\PaypalDump;
use Carbon\Carbon;

class FirstTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test test';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
            PaypalDump::create([
                'dump' => "TESTING HEROKU SCHEDULER",
                'type'  =>  "TEST",
                'created_at' => Carbon::now()
            ]);
    }
}
