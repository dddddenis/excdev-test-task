<?php

namespace app\Console\Commands\UserBalance;

use App\Jobs\ProcessTransactionJob;
use Illuminate\Console\Command;

class ChangeUserBalanceCommand extends Command
{
    protected $signature = 'user:balance {email} {operation} {amount} {description?}';
    protected $description = 'Change the user balance by email. Operation can be "add" or "subtract".';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $email = $this->argument('email');
        $operation = $this->argument('operation');
        $amount = $this->argument('amount');
        $description = $this->argument('description');

        ProcessTransactionJob::dispatch($email, $operation, $amount, $description);

        $this->info("User balance update job dispatched!");
    }
}
