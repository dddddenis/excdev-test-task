<?php

namespace App\Jobs;

use App\Models\Transaction;
use App\Models\User;
use App\Models\UserBalance;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class ProcessTransactionJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    protected $email;
    protected $operation;
    protected $amount;
    protected $description;

    public function __construct($email, $operation, $amount, $description = null)
    {
        $this->email = $email;
        $this->operation = $operation;
        $this->amount = $amount;
        $this->description = $description;
    }

    public function handle()
    {
        if ($this->description === null) {
            $this->description = sprintf("%s %.2f units", $this->operation, $this->amount);
        }

        $user = User::where('email', $this->email)->first();

        if (!$user) {
            return;
        }

        if ($this->operation !== 'add' && $this->operation !== 'subtract') {
            return;
        }

        DB::transaction(function () use ($user) {
            $balance = UserBalance::lockForUpdate()->where('user_id', $user->id)->first();

            if ($this->operation === 'subtract' && $balance->balance - $this->amount < 0) {
                throw new \Exception("Operation denied! This will lead to negative balance.");
            }

            if ($this->operation === 'add') {
                $balance->balance += $this->amount;
            } else {
                $balance->balance -= $this->amount;
            }

            $balance->save();

            Transaction::create([
                'user_id' => $user->id,
                'amount' => $this->operation === 'add' ? $this->amount : -$this->amount,
                'description' => $this->description
            ]);
        });
    }
}
