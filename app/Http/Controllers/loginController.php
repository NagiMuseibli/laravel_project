<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class loginController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function login(Request $request)
    {

        //dd($user_id);
        $this->validate($request, [
            'password' => 'required',
            'email' => 'email|required',
        ]);
        //dd($request);
        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->back()->with('message', 'Email ve ya parol yalnishdir!!');
        }

        $user_id = Auth::id();
        $users = User::find($user_id);

        if ($users->tesdiq == 1) {
            return redirect()->route('orders');
        } else {
            auth()->logout();
            return redirect()->back()->with('aktiv', 'Siz admin terefinden blok olunmusunuz!!
            Hesabinizi yeniden aktiv etmek isteyirsinizse,
            
            ');
        }
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->route('login');
    }
}
