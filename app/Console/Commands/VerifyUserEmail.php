<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class VerifyUserEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:verify-email {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verify email for a user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        
        $user = User::where('email', $email)->first();
        
        if (!$user) {
            $this->error("User with email '{$email}' not found.");
            return 1;
        }
        
        if ($user->email_verified_at) {
            $this->info("Email for '{$email}' is already verified at: {$user->email_verified_at}");
            $this->info("Force updating anyway...");
        }
        
        $user->email_verified_at = now();
        $user->save();
        
        // Refresh to ensure it's saved
        $user->refresh();
        
        $this->info("✓ Email verified successfully for: {$email}");
        $this->info("User: {$user->name}");
        $this->info("Verified at: {$user->email_verified_at}");
        
        return 0;
    }
}
