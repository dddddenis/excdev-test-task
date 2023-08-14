<?php

namespace app\Console\Commands\User;

use App\Models\User;
use App\Models\UserBalance;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class AddUserCommand extends Command
{
    protected $signature = 'user:add {name} {email} {password}';
    protected $description = 'Add a new user';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {

        $name = $this->argument('name');
        $email = $this->argument('email');
        $password = $this->argument('password');

        if (User::where('email', $email)->exists()) {
            $this->error("User with email {$email} already exists!");
            return;
        }

        $user = new User();
        $user->name = $name;
        $user->email = $email;
        $user->password = Hash::make($password);
        $user->save();

        UserBalance::create([
            'user_id' => $user->id,
            'balance' => 0.00
        ]);

        $this->info("User {$name} created successfully!");
    }
}
