<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use App\Role;
use Log;
use Hash;

class MakeAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:make {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make a user with the email an admin';

    /**
     * Email to give admin access
     * 
     * @var string
     */
    protected $email;


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
        $this->email = $this->argument('email');

        $password = $this->secret('What is the Password?');

        if( Hash::check( $password, env('ADMIN_MANAGER_PASSWORD') ) ) {

            $role = Role::where('name', 'admin')->first();
           
            $user = User::where('email', $this->email)->first();

            $user->roles()->save($role);

            Log::info('New Admin created!', ['email' => $this->email]);

            $this->info($user->first_name . ' now has admin access!');    

        } else {

            Log::info('Failed to make admin due to wrong password', ['email' => $this->email]);
           
            $this->error('Incorrect Password!');
        }

        
    }
}
