<?php

namespace App\Http\Controllers;

use App\Models\Gift;
use App\Models\Guest;
use Illuminate\Http\Request;

class InvitationController extends Controller
{
    public function show($code){
        $guest = Guest::where('invite_code',$code)->firstOrFail();
        $gifts = Gift::where('is_active',true)->get();
        return view('guest.show', compact('guest', 'gifts'));
    }

    public function confirm(Request $request, $code){
        $guest = Guest::where('invite_code', $code)->firstOrFail();
        $request->validate([
           'confirmed_count'=>"required|integer|min:1|max:{$guest->max_guests}"
        ]);

        $guest->update([
            'confirmed_count'=>$request->confirmed_count,
            'status'=>true
        ]);

        return redirect()->back()->with('success', "Presença confirmada com sucesso!");
    }
}
