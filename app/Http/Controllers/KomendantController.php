<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\brands;
use App\Models\products;
use App\Models\clients;
use App\Models\komendant;
use App\Models\orders;
use App\Models\user;
use App\Models\Credits;
use App\Models\xerc;
use App\Models\Paydate;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;
use mysqli;

class KomendantController extends Controller
{
    public  function index()
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
        $con = komendant::where('user_id', '=', $user_id)->orderBy('id', 'desc')->get();
        $conn = komendant::where('user_id', '=', $user_id)->orderBy('id', 'desc')->get();
        $toplam = komendant::where('user_id', '=', $user_id)->count();

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
            'komendant',
            [
                'ksay' => $ksay,
                'toplam' => $toplam,
                'aktiv_mehsul' => $aktiv_mehsul,
                'bitmis_mehsul' => $bitmis_mehsul,
                'umimicredit' => $umimicredit,
                'caricredit' => $caricredit,
                'carimehsul' => $carimehsul,
                'mehsul' => $mehsul,
                'xerc' => $cemxerc,
                'dataa' => $conn,
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
    public function store(Request $post)
    {
        $user_id = Auth::id();
        $con = new komendant();

        $con->user_id = $user_id;
        $con->tapsiriq = $post->task;
        $con->tarix = $post->tarix;
        $con->saat = $post->saat;

        $con->save();
        return redirect()->route('komendant')->with('task_add', 'Task uğurla  əlavə edildi');
    }

    public function edit($id)
    {
        $user_id = Auth::id();
        $bsay = brands::where('user_id', '=', $user_id)->count();
        $psay = products::where('user_id', '=', $user_id)->count();
        $csay = clients::where('user_id', '=', $user_id)->count();
        $osay = orders::where('user_id', '=', $user_id)->count();
        $aktiv_mehsul = products::where('user_id', '=', $user_id)->where('miqdar', '>', 0)->count();
        $bitmis_mehsul = products::where('user_id', '=', $user_id)->where('miqdar', '=', 0)->count();
        $edit = komendant::find($id);
        $user = user::find($user_id);
        $conn = komendant::where('user_id', '=', $user_id)->orderBy('id', 'desc')->get();
        $toplam = komendant::where('user_id', '=', $user_id)->count();
        $con = komendant::where('user_id', '=', $user_id)->where('id', '=', $id)->orderBy('id', 'desc')->get();

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
        return view('komendant', [
            'ksay' => $ksay,
            'aktiv_mehsul' => $aktiv_mehsul,
            'bitmis_mehsul' => $bitmis_mehsul,
            'umimicredit' => $umimicredit,
            'caricredit' => $caricredit,
            'carimehsul' => $carimehsul,
            'mehsul' => $mehsul,
            'xerc' => $cemxerc,
            'data' => $con,
            'dataa' => $conn,
            'toplam' => $toplam,
            'edit' => $edit,
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
        $post = komendant::where('user_id', '=', $user_id)->find($request->id);
        $post->tapsiriq = $request->task;
        $post->tarix = $request->tarix;
        $post->saat = $request->saat;
        $post->save();
        return redirect()->route('komendant')->with('task_update', 'Yenilənmə uğurla başa çatdı');
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
        $sildata = komendant::find($id);
        $conn = komendant::where('user_id', '=', $user_id)->orderBy('id', 'desc')->get();
        $toplam = komendant::where('user_id', '=', $user_id)->count();
        $con = komendant::where('user_id', '=', $user_id)->where('id', '=', $id)->orderBy('id', 'desc')->get();

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
        return view('komendant', [
            'ksay' => $ksay,
            'aktiv_mehsul' => $aktiv_mehsul,
            'bitmis_mehsul' => $bitmis_mehsul,
            'mehsul' => $mehsul,
            'carimehsul' => $carimehsul,
            'umimicredit' => $umimicredit,
            'xerc' => $cemxerc,
            'caricredit' => $caricredit,
            'data' => $con,
            'dataa' => $conn,
            'toplam' => $toplam,
            'sildata' => $sildata,
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
        $post = komendant::where('user_id', '=', $user_id)->find($id);
        $post->delete();
        return redirect()->route('komendant')->with('task_sil', 'Tapşırıq uğurla silindi');
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
        $conn = komendant::where('user_id', '=', $user_id)->orderBy('id', 'desc')->get();
        $toplam = komendant::where('user_id', '=', $user_id)->count();
        $post = user::find($user_id);
        $search_text = $_GET['query'];
        $post = user::find($user_id);
        $con = komendant::where('user_id', '=', $user_id)->where('tapsiriq', 'LIKE', '%' . $search_text . '%')->get();

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


        return view('komendant', [
            'ksay' => $ksay,
            'aktiv_mehsul' => $aktiv_mehsul,
            'bitmis_mehsul' => $bitmis_mehsul,
            'mehsul' => $mehsul,
            'carimehsul' => $carimehsul,
            'umimicredit' => $umimicredit,
            'xerc' => $cemxerc,
            'caricredit' => $caricredit,
            'bsay' => $bsay,
            'psay' => $psay,
            'data' => $con,
            'dataa' => $conn,
            'toplam' => $toplam,
            'csay' => $csay,
            'osay' => $osay,
            'user' => $post,
            'user_id' => $user_id,
        ]);
    }

    public function secsil(Request $request)
    {

        $ids = $request->ids;

        komendant::whereIn('id', $ids)->delete();

        return response()->json(['Silinme ugurla heyata kecirildi']);
    }
}
