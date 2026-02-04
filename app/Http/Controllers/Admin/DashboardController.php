<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gift;
use App\Models\Guest;
use App\Models\Transaction;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $data['totalGuests'] = Guest::sum('max_guests');
        $data['confirmed'] = Guest::where('is_confirmed', true)->sum('confirmed_count');
        $data['pending'] = $data['totalGuests'] - $data['confirmed'];

        $data['totalGifts'] = Gift::count();
        $data['receivedAmount'] = Transaction::where('status', 'paid')->sum('amount');

        return view('dashboard', $data);
    }
}
