<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\user;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\registerRequest;

class registerController extends Controller
{
    public function index()
    {
        return view('register');
    }

    public function register(registerRequest $request)
    {
        if ($request->password == $request->tpassword) {
            $users = User::where('email', '=', $request->email)->orwhere('tel', '=', $request->tel)->count();
            // dd($request);
            if ($users == 0) {
                $con = new User();
                $con->name = $request->ad;
                $con->surname = $request->soyad;
                $con->email = $request->email;
                $con->password = Hash::make($request->password);
                $con->tel = $request->tel;
                $con->foto = 'nopic.png';
                $con->tesdiq = 1;

                $con->save();
                return redirect()->route('register')->with('message', 'Istifadeci ugurla elave edildi');
            }
            return redirect()->route('register')->with('message', 'Istifadeci artiq movcuddur!!');
        }
        return redirect()->route('register')->with('message', 'Parol dogrulamasi yalnishdir!!');
    }
}
