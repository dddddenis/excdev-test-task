<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $balance = $user->balance; // предполагая, что у вас есть связь с моделью balance
        $transactions = $user->transactions()
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        if (request()->ajax()) {
            return response()->json([
                'balance' => $balance->balance,
                'transactions' => $transactions
            ]);
        }


        return view('dashboard.index', compact('balance', 'transactions'));
    }
}
