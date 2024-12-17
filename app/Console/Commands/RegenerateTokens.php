<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class RegenerateTokens extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tokens:regenerate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Regenerate access and refresh tokens for all users';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info("Regenerating tokens for all users...");

        $users = User::all();

        foreach ($users as $user) {
            $tokenResult = $user->createToken('API Token');
            
            $this->info("Token created for user: {$user->email}");
            $this->line("Access Token: {$tokenResult->accessToken}");
            $this->line("Refresh Token ID: {$tokenResult->token->id}");
        }

        $this->info("Token regeneration complete!");
    }
}
