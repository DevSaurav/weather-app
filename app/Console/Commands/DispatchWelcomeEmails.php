<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Notifications\WelcomeNotification;
use Illuminate\Console\Command;

class DispatchWelcomeEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:dispatch-welcome-emails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'For testing purpose only';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        User::all()->each(function ($user) {
            $user->notify(new WelcomeNotification($user->name));
        });
    }

}
