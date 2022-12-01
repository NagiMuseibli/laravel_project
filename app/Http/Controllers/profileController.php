<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\brands;
use App\Models\products;
use App\Models\clients;
use App\Models\orders;
use App\Models\Credits;
use App\Models\xerc;
use App\Models\Paydate;
use App\Models\user;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\profileRequest;

class profileController extends Controller
{
    public  function profile()
    {
        $user_id = Auth::id();
        // $con = brands::get();
        $bsay = brands::count();
        $psay = products::count();
        $csay = clients::count();
        $osay = orders::count();
        $ksay = Credits::where('user_id', '=', $user_id)->count();
        $aktiv_mehsul = products::where('user_id', '=', $user_id)->where('miqdar', '>', 0)->count();
        $bitmis_mehsul = products::where('user_id', '=', $user_id)->where('miqdar', '=', 0)->count();
        $post = user::find($user_id);

        $mehsul = products::where('user_id', '=', $user_id)->get();

        $carimehsul = orders::join('products', 'products.id', '=', 'orders.product_id')
            ->where('orders.user_id', '=', $user_id)
            ->where('orders.tesdiq', '=', 1)
            ->select('products.alis', 'products.satis', 'products.miqdar', 'orders.cqazanc')
            ->get();

        $umimicredit = Credits::join('products', 'products.id', '=', 'Credits.product_id')
            ->where('Credits.user_id', '=', $user_id)
            ->where('credits.tesdiq', '=', 1)
            ->select(

                'products.miqdar as mehsulsayi',
                'products.alis',
                'products.satis',
                'Credits.miqdar as sifarissayi',
                'Credits.faiz',
                'Credits.depozit',

            )->get();
        $cemxerc = xerc::where('user_id', '=', $user_id)->get();


        $caricredit = Paydate::where('user_id', '=', $user_id)->get();

        return view(
            'profile',
            [
                'ksay' => $ksay,
                'aktiv_mehsul' => $aktiv_mehsul,
                'bitmis_mehsul' => $bitmis_mehsul,
                'umimicredit' => $umimicredit,
                'caricredit' => $caricredit,
                'carimehsul' => $carimehsul,
                'mehsul' => $mehsul,
                'xerc' => $cemxerc,
                'bsay' => $bsay,
                'psay' => $psay,
                'csay' => $csay,
                'osay' => $osay,
                'user_id' => $user_id,
                'user' => $post,
            ]
        );
    }

    public  function update(Request $request)
    {
        //dd($request);
        $user_id = Auth::id();
        $post = user::find($user_id);
        if ($request->parol == $request->tparol) {

            if (Hash::check($request->cariparol, $post->password)) {
                $post->name = $request->ad;
                $post->surname = $request->soyad;
                $post->email = $request->email;
                $post->tel = $request->tel;
                if (!empty($request->parol)) {
                    $post->password = Hash::make($request->parol);
                } else {
                    $post->password = $post->password;
                }

                if (!empty($request->foto)) {
                    if ($request->hasfile('foto')) {
                        $pic = 'uploads/brands/' . $request->carifoto;
                        if ($request->carifoto != 'nopic.png') {
                            unlink($pic);
                        }

                        $file = $request->file('foto');
                        $extention = $file->getClientOriginalExtension();
                        $filename = time() . '.' . $extention;
                        $file->move('uploads/brands/', $filename);
                        $post->foto = $filename;
                    }
                } else {
                    $post->name = $request->ad;
                    $post->surname = $request->soyad;
                    $post->email = $request->email;
                    $post->tel = $request->tel;
                }



                $post->save();

                return redirect()->route('profile.index')->with('profile_edit', 'İstifadəçi uğurla yeniləndi');
            }
            return redirect()->route('profile.index')->with('profile_cari_error', 'Cari parol yalnışdır!!');
        }
        return redirect()->route('profile.index')->with('parol_dogrulama', 'Parol doğrulaması yalnışdır!!');
    }
}
