<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\aktivRequest;
use App\Models\User;
use App\Models\mesajlar;
use Illuminate\Support\Facades\Auth;

class aktivController extends Controller
{
    public function aktiv()
    {
        return view('aktiv');
    }


    public function gonder(aktivRequest $request)
    {

        $users = User::where('email', '=', $request->email)->where('tesdiq', '=', 0)->count();
        if ($users == 0) {
            return redirect()->route('aktiv')->with('message', 'Daxil etdiyiniz Mail movcud deyil!!');
        } else {
            $con = new mesajlar();
            $con->title = $request->title;
            $con->body = $request->body;
            $con->email = $request->email;
            $con->save();
            return redirect()->route('aktiv')->with('message', 'Mesaj ugurla gonderildi. Tezlikle cavab alacaqsiniz');
        }
    }
}
