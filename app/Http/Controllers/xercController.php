<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\xerc;
use App\Models\brands;
use App\Models\products;
use App\Models\clients;
use App\Models\orders;
use App\Models\user;
use App\Models\Credits;
use App\Models\Paydate;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\xercRequest;

class xercController extends Controller
{
   //
   public  function xerc()
   {
      $user_id = Auth::id();
      $user = user::find($user_id);
      $user_id = Auth::id();
      $bsay = brands::where('user_id', '=', $user_id)->count();
      $psay = products::where('user_id', '=', $user_id)->count();
      $csay = clients::where('user_id', '=', $user_id)->count();
      $osay = orders::where('user_id', '=', $user_id)->count();
      $aktiv_mehsul = products::where('user_id', '=', $user_id)->where('miqdar', '>', 0)->count();
      $bitmis_mehsul = products::where('user_id', '=', $user_id)->where('miqdar', '=', 0)->count();
      // $con = brands::get();
      $con = xerc::where('user_id', '=', $user_id)->orderBy('id', 'desc')->get();

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
         'xerc',
         [
            'ksay' => $ksay,
            'aktiv_mehsul' => $aktiv_mehsul,
            'bitmis_mehsul' => $bitmis_mehsul,
            'mehsul' => $mehsul,
            'carimehsul' => $carimehsul,
            'umimicredit' => $umimicredit,
            'xerc' => $cemxerc,
            'caricredit' => $caricredit,
            'data' => $con,
            'bsay' => $bsay,
            'psay' => $psay,
            'csay' => $csay,
            'osay' => $osay,
            'user_id' => $user_id,
            'user' => $user,
         ]
      );
   }
   public  function store(xercRequest $post)
   {
      $user_id = Auth::id();
      $xerc = xerc::where('user_id', '=', $user_id)->where('teyinat', '=', $post->input('teyinat'))->first();

      if ($post->mebleg > 0) {
         if ($xerc === null) {
            // xerc movcud deyilse
            $con = new xerc();
            $con->teyinat = $post->teyinat;
            $con->user_id = $user_id;
            $con->mebleg = $post->mebleg;

            $con->save();

            return redirect()->route('xerc')->with('xerc_add', 'Xərc uğurla əlavə edildi');
         } else {
            // xerc movcuddursa
            return redirect()->route('xerc')->with('xerc_movcud', 'Xərc artıq mövcuddur!!');
         }
      }
      return redirect()->route('xerc')->with('xerc_warning', 'Məbləğ 0-dan böyük olmalıdır!!');
   }

   public function edit($id)
   {
      $user_id = Auth::id();
      $user = user::find($user_id);
      $bsay = brands::where('user_id', '=', $user_id)->count();
      $psay = products::where('user_id', '=', $user_id)->count();
      $csay = clients::where('user_id', '=', $user_id)->count();
      $osay = orders::where('user_id', '=', $user_id)->count();
      $aktiv_mehsul = products::where('user_id', '=', $user_id)->where('miqdar', '>', 0)->count();
      $bitmis_mehsul = products::where('user_id', '=', $user_id)->where('miqdar', '=', 0)->count();
      $post = xerc::find($id);
      $con = xerc::orderBy('id', 'desc')->where('id', '=', $id)->get();

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
      return view('xerc', [
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
         'user_id' => $user_id,
         'user' => $user,
      ]);
   }



   public function update(xercRequest $request)
   {
      // dd($request);
      $post = xerc::find($request->id);
      $post->teyinat = $request->teyinat;
      $post->mebleg = $request->mebleg;

      $post->update();
      return redirect()->route('xerc')->with('xerc_edit', 'Xərc uğurla yeniləndi');
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
      $post = xerc::find($id);
      $con = xerc::orderBy('id', 'desc')->get();

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
      return view('xerc', [
         'ksay' => $ksay,
         'aktiv_mehsul' => $aktiv_mehsul,
         'bitmis_mehsul' => $bitmis_mehsul,
         'mehsul' => $mehsul,
         'carimehsul' => $carimehsul,
         'umimicredit' => $umimicredit,
         'xerc' => $cemxerc,
         'caricredit' => $caricredit,
         'data' => $con,
         'sildata' => $post,
         'bsay' => $bsay,
         'psay' => $psay,
         'csay' => $csay,
         'osay' => $osay,
         'user_id' => $user_id,
         'user' => $user,
      ]);
   }

   public function destroy($id)
   {

      $post = xerc::find($id);

      $post->delete();
      return redirect()->route('xerc')->with('xerc_sil', 'Xərc uğurla silindi');
   }

   public function secsil(Request $request)
   {

      $ids = $request->ids;
      xerc::whereIn('id', $ids)->delete();

      return response()->json(['Silinme ugurla heyata kecirildi']);
   }

   public function search()
   {

      $user_id = Auth::id();
      $user = user::find($user_id);
      $user_id = Auth::id();
      $bsay = brands::where('user_id', '=', $user_id)->count();
      $psay = products::where('user_id', '=', $user_id)->count();
      $csay = clients::where('user_id', '=', $user_id)->count();
      $osay = orders::where('user_id', '=', $user_id)->count();
      $aktiv_mehsul = products::where('user_id', '=', $user_id)->where('miqdar', '>', 0)->count();
      $bitmis_mehsul = products::where('user_id', '=', $user_id)->where('miqdar', '=', 0)->count();
      // $con = brands::get();
      $search_text = $_GET['query'];
      $con = xerc::where('user_id', '=', $user_id)->where('teyinat', 'LIKE', '%' . $search_text . '%')->orderBy('id', 'desc')->get();

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
         'xerc',
         [
            'ksay' => $ksay,
            'aktiv_mehsul' => $aktiv_mehsul,
            'bitmis_mehsul' => $bitmis_mehsul,
            'mehsul' => $mehsul,
            'carimehsul' => $carimehsul,
            'umimicredit' => $umimicredit,
            'xerc' => $cemxerc,
            'caricredit' => $caricredit,
            'data' => $con,
            'bsay' => $bsay,
            'psay' => $psay,
            'csay' => $csay,
            'osay' => $osay,
            'user_id' => $user_id,
            'user' => $user,
         ]
      );
   }
}
