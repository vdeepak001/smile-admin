<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Crypt;

class PopulateEmailHashes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:populate-email-hashes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Populate email_hash for all existing users';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Populating email_hash for existing users...');

        // Get all users
        $users = \DB::table('users')->get();

        $count = 0;
        foreach ($users as $user) {
            if ($user->email) {
                $email = $user->email;
                
                // Check if email looks like it's encrypted (base64 encoded JSON)
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    // It's encrypted, decrypt it
                    try {
                        $email = Crypt::decryptString($email);
                        $this->line("Decrypted email for user ID {$user->id}: {$email}");
                    } catch (\Exception $e) {
                        $this->warn("Could not decrypt email for user ID {$user->id}: " . $e->getMessage());
                        continue;
                    }
                }

                // Generate and update email_hash
                $emailHash = hash('sha256', strtolower(trim($email)));
                \DB::table('users')->where('id', $user->id)->update(['email_hash' => $emailHash]);
                $count++;
                $this->info("Updated email_hash for user ID {$user->id}");
            }
        }

        $this->info("Successfully populated email_hash for {$count} users.");
        
        return Command::SUCCESS;
    }
}
