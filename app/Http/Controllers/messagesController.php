<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\brands;
use App\Models\products;
use App\Models\clients;
use App\Models\orders;
use App\Models\user;
use App\Models\mesajlar;
use App\Models\Credits;
use App\Models\xerc;
use App\Models\Paydate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class messagesController extends Controller
{
  public  function index(Request $request)
  {
    $user_id = Auth::id();
    // $con = brands::get();
    $bsay = brands::where('user_id', '=', $user_id)->count();
    $psay = products::where('user_id', '=', $user_id)->count();
    $csay = clients::where('user_id', '=', $user_id)->count();
    $osay = orders::where('user_id', '=', $user_id)->count();
    $aktiv_mehsul = products::where('user_id', '=', $user_id)->where('miqdar', '>', 0)->count();
    $bitmis_mehsul = products::where('user_id', '=', $user_id)->where('miqdar', '=', 0)->count();
    $post = user::find($user_id);

    $messages = mesajlar::orderBy('seen_date')->get();

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
    $ksay = Credits::where('user_id', '=', $user_id)->count();
    return view(
      'messages',
      [
        'ksay' => $ksay,
        'aktiv_mehsul' => $aktiv_mehsul,
        'bitmis_mehsul' => $bitmis_mehsul,
        'umimicredit' => $umimicredit,
        'caricredit' => $caricredit,
        'carimehsul' => $carimehsul,
        'mehsul' => $mehsul,
        'xerc' => $cemxerc,
        'messages' => $messages,
        'bsay' => $bsay,
        'psay' => $psay,
        'csay' => $csay,
        'osay' => $osay,
        'user_id' => $user_id,
        'user' => $post,
      ]
    );
  }

  public function destroy($id)
  {
    $user_id = Auth::id();

    $bcount = products::where('user_id', '=', $user_id)->where('brand_id', '=', $id)->count();
    if ($bcount == 0) {
      $post = brands::where('user_id', '=', $user_id)->find($id);
      $pic = 'uploads/brands/' . $post->foto;
      unlink($pic);
      $post->delete();


      return redirect()->route('index')->with('message', 'Brend ugurla silindi');
    }
    return redirect()->route('index')->with('message', 'Bu brende aid aktiv mehsul movcuddur!!');
  }

  public function message($id)
  {
    $user_id = Auth::id();
    // $con = brands::get();
    $bsay = brands::where('user_id', '=', $user_id)->count();
    $psay = products::where('user_id', '=', $user_id)->count();
    $csay = clients::where('user_id', '=', $user_id)->count();
    $osay = orders::where('user_id', '=', $user_id)->count();
    $aktiv_mehsul = products::where('user_id', '=', $user_id)->where('miqdar', '>', 0)->count();
    $bitmis_mehsul = products::where('user_id', '=', $user_id)->where('miqdar', '=', 0)->count();
    $post = user::find($user_id);



    $message = mesajlar::findOrFail($id);

    if ($message->seen_date === null) {

      $message->seen_date = now();
      $message->save();
    }

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
    $ksay = Credits::where('user_id', '=', $user_id)->count();

    return view(
      'message',
      [
        'ksay' => $ksay,
        'aktiv_mehsul' => $aktiv_mehsul,
        'bitmis_mehsul' => $bitmis_mehsul,
        'umimicredit' => $umimicredit,
        'caricredit' => $caricredit,
        'carimehsul' => $carimehsul,
        'mehsul' => $mehsul,
        'xerc' => $cemxerc,
        'message' => $message,
        'bsay' => $bsay,
        'psay' => $psay,
        'csay' => $csay,
        'osay' => $osay,
        'user_id' => $user_id,
        'user' => $post,
      ]
    );
  }

  public function sil($id)
  {
    $user_id = Auth::id();
    // $con = brands::get();
    $bsay = brands::where('user_id', '=', $user_id)->count();
    $psay = products::where('user_id', '=', $user_id)->count();
    $csay = clients::where('user_id', '=', $user_id)->count();
    $osay = orders::where('user_id', '=', $user_id)->count();
    $aktiv_mehsul = products::where('user_id', '=', $user_id)->where('miqdar', '>', 0)->count();
    $bitmis_mehsul = products::where('user_id', '=', $user_id)->where('miqdar', '=', 0)->count();
    $post = user::find($user_id);
    $user = user::find($user_id);
    $messages = mesajlar::orderBy('seen_date')->get();
    $post1 = mesajlar::find($id);
    $con = brands::where('user_id', '=', $user_id)->orderBy('id', 'desc')->get();

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
    $ksay = Credits::where('user_id', '=', $user_id)->count();
    return view('messages', [
      'ksay' => $ksay,
      'aktiv_mehsul' => $aktiv_mehsul,
      'bitmis_mehsul' => $bitmis_mehsul,
      'umimicredit' => $umimicredit,
      'caricredit' => $caricredit,
      'carimehsul' => $carimehsul,
      'mehsul' => $mehsul,
      'xerc' => $cemxerc,
      'data' => $con,
      'messages' => $messages,
      'sildata' => $post1,
      'bsay' => $bsay,
      'psay' => $psay,
      'csay' => $csay,
      'osay' => $osay,
      'user' => $user,
      'user_id' => $user_id,
    ]);
  }

  public function silindi($id)
  {
    $message = mesajlar::find($id);
    $message->delete();
    return redirect()->route('messages')->with('message', 'Mesaj ugurla silindi');
  }

  public function send(Request $request)
  {
    //dd($request);
    $title = $request->title;
    $email = $request->email;
    $body = $request->body;
    Mail::send('messagesend', ['body' => $body], function ($message) use ($email, $title) {
      $message->to($email)->subject($title);
    });
    // return redirect()->route('message')->with('message','Mesaj ugurla silindi');
    return redirect()->route('messages')->with('message', 'Mesaj gonderildi');
  }


  public function search()
  {
    $user_id = Auth::id();
    // $con = brands::get();
    $bsay = brands::where('user_id', '=', $user_id)->count();
    $psay = products::where('user_id', '=', $user_id)->count();
    $csay = clients::where('user_id', '=', $user_id)->count();
    $osay = orders::where('user_id', '=', $user_id)->count();
    $aktiv_mehsul = products::where('user_id', '=', $user_id)->where('miqdar', '>', 0)->count();
    $bitmis_mehsul = products::where('user_id', '=', $user_id)->where('miqdar', '=', 0)->count();
    $post = user::find($user_id);
    $search_text = $_GET['query'];
    $user = user::find($user_id);
    $messages = mesajlar::where('email', 'LIKE', '%' . $search_text . '%')->orderBy('seen_date')->get();

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
    $ksay = Credits::where('user_id', '=', $user_id)->count();

    return view('messages', [
      'ksay' => $ksay,
      'aktiv_mehsul' => $aktiv_mehsul,
      'bitmis_mehsul' => $bitmis_mehsul,
      'umimicredit' => $umimicredit,
      'caricredit' => $caricredit,
      'carimehsul' => $carimehsul,
      'mehsul' => $mehsul,
      'xerc' => $cemxerc,
      'messages' => $messages,
      'bsay' => $bsay,
      'psay' => $psay,
      'csay' => $csay,
      'osay' => $osay,
      'user' => $user,
      'user_id' => $user_id,
    ]);
  }
}
