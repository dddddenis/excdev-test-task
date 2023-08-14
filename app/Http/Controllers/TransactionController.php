<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::query();

        if ($request->get('description')) {
            $query->where('description', 'like', '%' . $request->get('description') . '%');
        }

        $transactions = $query->orderBy('created_at', $request->get('sort', 'desc'))->paginate(10);

        return view('transactions.index', compact('transactions'));
    }
}
