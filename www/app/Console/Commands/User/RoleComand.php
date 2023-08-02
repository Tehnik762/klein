<?php

namespace App\Console\Commands\User;

use App\Models\User;
use Illuminate\Console\Command;

class RoleComand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:role {email} {role}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Switch user to another role by email';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $email = $this->argument('email');
        $role = $this->argument('role');

        if (!$user = User::where('email', $email)->first()) {
            $this->error(__('auth.failed'));
            return false;
        } 

        $user->changeRole($role);
        $this->info(__('auth.RoleChanged'));
        return Command::SUCCESS;
    }
}
