<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\brands;
use App\Models\products;
use App\Models\clients;
use App\Models\orders;
use App\Models\user;
use App\Models\Credits;
use App\Models\xerc;
use App\Models\staff;
use App\Models\Paydate;
use App\Models\Layihe;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;

class LayiheController extends Controller
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

        $con = Layihe::where('user_id', '=', $user_id)->orderBy('id', 'desc')->get();

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
        $istirakci = staff::where('user_id', '=', $user_id)->get();

        return view(
            'layihe',
            [
                'istirakci' => $istirakci,
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
                'user' => $post,
            ]
        )->with('data', $con);
    }

    public function store(Request $post)
    {
        $user_id = Auth::id();
        $con = new Layihe();

        $con->user_id = $user_id;
        $con->tapsiriq = $post->task;
        $con->bastarix = $post->bastarix;
        $con->bassaat = $post->bassaat;
        $con->bittarix = $post->bittarix;
        $con->bitsaat = $post->bitsaat;

        $con->save();
        return redirect()->route('layihe')->with('layihe_add', 'Layihə uğurla  əlavə edildi');
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
        $edit = Layihe::find($id);
        $user = user::find($user_id);
        $con = Layihe::where('user_id', '=', $user_id)->where('id', '=', $id)->orderBy('id', 'desc')->get();

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

        return view('layihe', [
            'ksay' => $ksay,
            'aktiv_mehsul' => $aktiv_mehsul,
            'bitmis_mehsul' => $bitmis_mehsul,
            'mehsul' => $mehsul,
            'carimehsul' => $carimehsul,
            'umimicredit' => $umimicredit,
            'xerc' => $cemxerc,
            'caricredit' => $caricredit,
            'data' => $con,
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
        $post = Layihe::where('user_id', '=', $user_id)->find($request->id);
        $post->tapsiriq = $request->task;
        $post->bastarix = $request->bastarix;
        $post->bassaat = $request->bassaat;
        $post->bittarix = $request->bittarix;
        $post->bitsaat = $request->bitsaat;
        $post->save();
        return redirect()->route('layihe')->with('layihe_update', 'Yenilənmə uğurla başa çatdı');
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
        $sildata = Layihe::find($id);
        $con = Layihe::where('user_id', '=', $user_id)->where('id', '=', $id)->orderBy('id', 'desc')->get();

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

        return view('layihe', [
            'ksay' => $ksay,
            'aktiv_mehsul' => $aktiv_mehsul,
            'bitmis_mehsul' => $bitmis_mehsul,
            'mehsul' => $mehsul,
            'carimehsul' => $carimehsul,
            'umimicredit' => $umimicredit,
            'xerc' => $cemxerc,
            'caricredit' => $caricredit,
            'data' => $con,
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
        $post = Layihe::where('user_id', '=', $user_id)->find($id);
        $post->delete();
        return redirect()->route('layihe')->with('layihe_sil', 'Tapşırıq uğurla silindi');
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
        $post = user::find($user_id);
        $data = Layihe::where('user_id', '=', $user_id)->where('tapsiriq', 'LIKE', '%' . $search_text . '%')->get();

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

        return view('layihe', [
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
            'data' => $data,
            'csay' => $csay,
            'osay' => $osay,
            'user' => $post,
            'user_id' => $user_id,
        ]);
    }
}
