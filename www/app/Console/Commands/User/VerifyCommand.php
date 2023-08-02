<?php

namespace App\Console\Commands\User;

use App\Models\User;
use Illuminate\Console\Command;

class VerifyCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:verify {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'An easy way to verify a user through a console command';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $user = User::where('email', '=', $this->argument('email'))->first();
        if (!$user) {
            $this->error(__('auth.failed'));
            return false;
        }
        if ($user->status == User::STATUS_ACTIVE) {
            $this->info(__('auth.AlreadyVerified'));
        } else {
            $user->makeVerified();
            $this->info(__('auth.AdminVerify'));
        }
        
        return true;
    }
}
