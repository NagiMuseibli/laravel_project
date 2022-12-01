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
use Illuminate\Support\Facades\Auth;

class adminController extends Controller
{
  //
  public  function admin()
  {
    $user_id = Auth::id();
    $user = user::find($user_id);
    // $con = brands::get();
    $bsay = brands::count();
    $psay = products::count();
    $csay = clients::count();
    $osay = orders::count();
    $ksay = Credits::where('user_id', '=', $user_id)->count();
    $aktiv_mehsul = products::where('user_id', '=', $user_id)->where('miqdar', '>', 0)->count();
    $bitmis_mehsul = products::where('user_id', '=', $user_id)->where('miqdar', '=', 0)->count();
    $usay = user::count();
    $post = user::orderBy('id', 'asc')->get();

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
      'admin',
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
        'usay' => $usay,
        'user_id' => $user_id,
        'user' => $user,
        'post' => $post,
        //'user'=>$post,
      ]
    );
  }

  public function tesdiq(Request $request)
  {
    $con = user::find($request->id);

    $con->tesdiq = 1;
    $con->save();
    return redirect()->route('admin.index')->with('message', 'Ugurla tesdiq olundu');
  }

  public function blok(Request $request)
  {
    //dd($request);
    $con = user::find($request->id);

    $con->tesdiq = 0;
    $con->save();

    return redirect()->route('admin.index')->with('message', 'Ugurla blok olundu');
  }
}
