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
use App\Models\documents;
use App\Models\staff;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\staffRequest;

class staffController extends Controller
{
   //
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
      $con = staff::where('user_id', '=', $user_id)->orderBy('id', 'desc')->get();

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
         'staff',
         [
            'ksay' => $ksay,
            'aktiv_mehsul' => $aktiv_mehsul,
            'bitmis_mehsul' => $bitmis_mehsul,
            'umimicredit' => $umimicredit,
            'caricredit' => $caricredit,
            'carimehsul' => $carimehsul,
            'mehsul' => $mehsul,
            'xerc' => $cemxerc,
            'data' => $con,
            'bsay' => $bsay,
            'psay' => $psay,
            'csay' => $csay,
            'osay' => $osay,
            'user_id' => $user_id,
            'user' => $post,
         ]
      );
   }

   public function store(staffRequest $request)
   {
      $user_id = Auth::id();
      $staff = staff::where('user_id', '=', $user_id)->where('email', '=', $request->email)
         ->orwhere('user_id', '=', $user_id)
         ->where('tel', '=', $request->tel)
         ->count();
      if ($staff == 0) {

         $con = new staff();
         $con->user_id = $user_id;
         $con->ad = $request->ad;
         $con->soyad = $request->soyad;
         $con->tel = $request->tel;
         $con->email = $request->email;
         $con->vezife = $request->vezife;
         $con->maash = $request->maash;
         $con->hired = $request->hired;
         $con->save();

         return redirect()->route('staff')->with('staff_add', 'Staff uğurla əlavə edildi');
      }
      return redirect()->route('staff')->with('staff_movcud', 'Staff artıq mövcuddur!!');
   }


   public function edit($id)
   {
      //dd($id);
      $user_id = Auth::id();
      // $con = brands::get();
      $bsay = brands::where('user_id', '=', $user_id)->count();
      $psay = products::where('user_id', '=', $user_id)->count();
      $csay = clients::where('user_id', '=', $user_id)->count();
      $osay = orders::where('user_id', '=', $user_id)->count();
      $aktiv_mehsul = products::where('user_id', '=', $user_id)->where('miqdar', '>', 0)->count();
      $bitmis_mehsul = products::where('user_id', '=', $user_id)->where('miqdar', '=', 0)->count();
      $post = user::find($user_id);
      $editdata = staff::where('user_id', '=', $user_id)->find($id);
      $con = staff::where('user_id', '=', $user_id)->where('id', '=', $id)->orderBy('id', 'desc')->get();

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
         'staff',
         [
            'ksay' => $ksay,
            'aktiv_mehsul' => $aktiv_mehsul,
            'bitmis_mehsul' => $bitmis_mehsul,
            'umimicredit' => $umimicredit,
            'caricredit' => $caricredit,
            'carimehsul' => $carimehsul,
            'mehsul' => $mehsul,
            'xerc' => $cemxerc,
            'data' => $con,
            'editdata' => $editdata,
            'bsay' => $bsay,
            'psay' => $psay,
            'csay' => $csay,
            'osay' => $osay,
            'user_id' => $user_id,
            'user' => $post,
         ]
      );
   }


   public function update(staffRequest $request)
   {
      //dd($request);
      $post = staff::find($request->id);
      $post->ad = $request->ad;
      $post->soyad = $request->soyad;
      $post->tel = $request->tel;
      $post->email = $request->email;
      $post->vezife = $request->vezife;
      $post->maash = $request->maash;
      $post->hired = $request->hired;


      $post->save();

      return redirect()->route('staff')->with('staff_edit', 'Staff uğurla yeniləndi');
   }


   public function sil($id)
   {
      $user_id = Auth::id();
      $user = user::find($user_id);
      $bsay = brands::where('user_id', '=', $user_id)->count();
      $psay = products::where('user_id', '=', $user_id)->count();
      $csay = clients::where('user_id', '=', $user_id)->count();
      $osay = orders::where('user_id', '=', $user_id)->count();
      $aktiv_mehsul = products::where('user_id', '=', $user_id)->where('miqdar', '>', 0)->count();
      $bitmis_mehsul = products::where('user_id', '=', $user_id)->where('miqdar', '=', 0)->count();
      $post = staff::where('user_id', '=', $user_id)->find($id);
      $con = staff::where('user_id', '=', $user_id)->where('id', '=', $id)->orderBy('id', 'desc')->get();

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
      return view('staff', [
         'ksay' => $ksay,
         'aktiv_mehsul' => $aktiv_mehsul,
         'bitmis_mehsul' => $bitmis_mehsul,
         'umimicredit' => $umimicredit,
         'caricredit' => $caricredit,
         'carimehsul' => $carimehsul,
         'mehsul' => $mehsul,
         'xerc' => $cemxerc,
         'data' => $con,
         'sildata' => $post,
         'bsay' => $bsay,
         'psay' => $psay,
         'csay' => $csay,
         'osay' => $osay,
         'user' => $user,
         'user_id' => $user_id,
      ]);
   }

   public function destroy($id)
   {
      $user_id = Auth::id();
      $post = staff::where('user_id', '=', $user_id)->find($id);

      $post->delete();


      return redirect()->route('staff')->with('staff_sil', 'Staff uğurla silindi');
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

      $search_text = $_GET['query'];
      $post = user::find($user_id);
      $con = staff::join('documents', 'documents.staff_id', '=', 'staff.id')
         ->where('user_id', '=', $user_id)->where('staff.ad', 'LIKE', '%' . $search_text . '%')
         ->orWhere('staff.soyad', 'LIKE', '%' . $search_text . '%')
         ->orWhere('documents.title', 'LIKE', '%' . $search_text . '%')
         ->orWhere('staff.email', 'LIKE', '%' . $search_text . '%')
         ->orWhere('staff.vezife', 'LIKE', '%' . $search_text . '%')->get();

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
         'staff',
         [
            'ksay' => $ksay,
            'aktiv_mehsul' => $aktiv_mehsul,
            'bitmis_mehsul' => $bitmis_mehsul,
            'umimicredit' => $umimicredit,
            'caricredit' => $caricredit,
            'carimehsul' => $carimehsul,
            'mehsul' => $mehsul,
            'xerc' => $cemxerc,
            'data' => $con,
            'bsay' => $bsay,
            'psay' => $psay,
            'csay' => $csay,
            'osay' => $osay,
            'user_id' => $user_id,
            'user' => $post,
         ]
      );
   }
}
