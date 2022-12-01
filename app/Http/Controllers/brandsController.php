<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\brands;
use App\Models\products;
use App\Models\clients;
use App\Models\orders;
use App\Models\user;
use App\Models\xerc;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\brandsRequest;
use App\Models\Credits;
use App\Models\Paydate;

class brandsController extends Controller
{


   public  function index(Request $request)
   {
      $user_id = Auth::id();
      // $con = brands::get();
      $bsay = brands::where('user_id', '=', $user_id)->count();
      $psay = products::where('user_id', '=', $user_id)->count();
      $csay = clients::where('user_id', '=', $user_id)->count();
      $osay = orders::where('user_id', '=', $user_id)->count();
      $ksay = Credits::where('user_id', '=', $user_id)->count();
      $aktiv_mehsul = products::where('user_id', '=', $user_id)->where('miqdar', '>', 0)->count();
      $bitmis_mehsul = products::where('user_id', '=', $user_id)->where('miqdar', '=', 0)->count();
      $post = user::find($user_id);
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


      return view(
         'brands',
         [
            'ksay' => $ksay,
            'umimicredit' => $umimicredit,
            'caricredit' => $caricredit,
            'carimehsul' => $carimehsul,
            'mehsul' => $mehsul,
            'xerc' => $cemxerc,
            'aktiv_mehsul' => $aktiv_mehsul,
            'bitmis_mehsul' => $bitmis_mehsul,
            'data' => $con,
            'bsay' => $bsay,
            'psay' => $psay,
            'csay' => $csay,
            'osay' => $osay,
            'user_id' => $user_id,
            'user' => $post,
         ]
      )->with('data', $con);
   }


   public  function store(brandsRequest $post)
   {
      //dd($post);
      $user_id = Auth::id();
      $brand = brands::where('user_id', '=', $user_id)->where('ad', '=', $post->ad)->count();
      if ($brand == 0) {
         //Brend movcud deyilse
         $con = new brands();
         $con->ad = $post->ad;
         $con->user_id = $user_id;
         if ($post->hasfile('foto')) {
            $file = $post->file('foto');
            $extention = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extention;
            $file->move('uploads/brands/', $filename);
            $con->foto = $filename;
         }
         $con->save();

         return redirect()->route('index')->with('brand_add', 'Brend uğurla  əlavə edildi');
      }
      return redirect()->route('index')->with('brand_movcud', 'Brend artıq mövcuddur!!');
   }

   public function edit($id)
   {
      $user_id = Auth::id();
      $bsay = brands::where('user_id', '=', $user_id)->count();
      $psay = products::where('user_id', '=', $user_id)->count();
      $csay = clients::where('user_id', '=', $user_id)->count();
      $osay = orders::where('user_id', '=', $user_id)->count();
      $ksay = Credits::where('user_id', '=', $user_id)->count();
      $aktiv_mehsul = products::where('user_id', '=', $user_id)->where('miqdar', '>', 0)->count();
      $bitmis_mehsul = products::where('user_id', '=', $user_id)->where('miqdar', '=', 0)->count();
      $post = brands::find($id);
      $user = user::find($user_id);
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
      return view('brands', [
         'ksay' => $ksay,
         'aktiv_mehsul' => $aktiv_mehsul,
         'bitmis_mehsul' => $bitmis_mehsul,
         'mehsul' => $mehsul,
         'carimehsul' => $carimehsul,
         'umimicredit' => $umimicredit,
         'xerc' => $cemxerc,
         'caricredit' => $caricredit,
         'data' => $con,
         'post' => $post,
         'bsay' => $bsay,
         'psay' => $psay,
         'csay' => $csay,
         'osay' => $osay,
         'user' => $user,
         'user_id' => $user_id,
      ]);
   }



   public function update(Request $request)
   {
      $user_id = Auth::id();
      //dd($request);
      $post = brands::where('user_id', '=', $user_id)->find($request->id);
      $post->ad = $request->ad;
      $post->user_id = $user_id;
      if (!empty($request->foto)) {
         if ($request->hasfile('foto')) {
            $pic = 'uploads/brands/' . $request->carifoto;
            unlink($pic);
            $file = $request->file('foto');
            $extention = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extention;
            $file->move('uploads/brands/', $filename);
            $post->foto = $filename;
         }
      } else {
         $post->ad = $request->ad;
      }

      $post->save();

      return redirect()->route('index')->with('brand_update', 'Yenilənmə uğurla başa çatdı');
   }


   public function sil($id)
   {
      $user_id = Auth::id();
      $user = user::find($user_id);
      $bsay = brands::where('user_id', '=', $user_id)->count();
      $psay = products::where('user_id', '=', $user_id)->count();
      $csay = clients::where('user_id', '=', $user_id)->count();
      $osay = orders::where('user_id', '=', $user_id)->count();
      $ksay = Credits::where('user_id', '=', $user_id)->count();
      $aktiv_mehsul = products::where('user_id', '=', $user_id)->where('miqdar', '>', 0)->count();
      $bitmis_mehsul = products::where('user_id', '=', $user_id)->where('miqdar', '=', 0)->count();
      $post = brands::find($id);
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
      return view('brands', [
         'ksay' => $ksay,
         'mehsul' => $mehsul,
         'carimehsul' => $carimehsul,
         'umimicredit' => $umimicredit,
         'xerc' => $cemxerc,
         'caricredit' => $caricredit,
         'aktiv_mehsul' => $aktiv_mehsul,
         'bitmis_mehsul' => $bitmis_mehsul,
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

      $bcount = products::where('user_id', '=', $user_id)->where('brand_id', '=', $id)->count();
      if ($bcount == 0) {
         $post = brands::where('user_id', '=', $user_id)->find($id);
         $pic = 'uploads/brands/' . $post->foto;
         unlink($pic);
         $post->delete();


         return redirect()->route('index')->with('brand_sil', 'Brend uğurla silindi');
      }
      return redirect()->route('index')->with('brandsil_danger', 'Bu brendə aid aktiv məhsul mövcuddur!!');
   }



   public function secsil(Request $request)
   {

      $ids = $request->ids;

      $user_id = Auth::id();

      $bcount = products::where('user_id', '=', $user_id)->where('brand_id', '=', $ids)->count();
      if ($bcount == 0) {

         brands::whereIn('id', $ids)->delete();

         return response()->json(['Silinme ugurla heyata kecirildi']);
      } else {
         return response()->json(['Bu brende aid aktiv mehsul movcuddur']);
      }
   }

   public function search()
   {
      $user_id = Auth::id();
      // $con = brands::get();
      $bsay = brands::where('user_id', '=', $user_id)->count();
      $psay = products::where('user_id', '=', $user_id)->count();
      $csay = clients::where('user_id', '=', $user_id)->count();
      $osay = orders::where('user_id', '=', $user_id)->count();
      $ksay = Credits::where('user_id', '=', $user_id)->count();
      $aktiv_mehsul = products::where('user_id', '=', $user_id)->where('miqdar', '>', 0)->count();
      $bitmis_mehsul = products::where('user_id', '=', $user_id)->where('miqdar', '=', 0)->count();
      $post = user::find($user_id);
      $search_text = $_GET['query'];
      $data = brands::where('user_id', '=', $user_id)->where('ad', 'LIKE', '%' . $search_text . '%')->get();
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


      return view('brands', [
         'ksay' => $ksay,
         'mehsul' => $mehsul,
         'carimehsul' => $carimehsul,
         'umimicredit' => $umimicredit,
         'xerc' => $cemxerc,
         'caricredit' => $caricredit,
         'aktiv_mehsul' => $aktiv_mehsul,
         'bitmis_mehsul' => $bitmis_mehsul,
         'bsay' => $bsay,
         'psay' => $psay,
         'data' => $data,
         'csay' => $csay,
         'osay' => $osay,
         'user' => $post,
         'user_id' => $user_id,
      ]);
   }
}
