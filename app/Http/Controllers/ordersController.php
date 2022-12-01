<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\OrdersRequest;
use App\Models\clients;
use App\Models\products;
use App\Models\orders;
use App\Models\brands;
use App\Models\user;
use App\Models\Credits;
use App\Models\Paydate;
use App\Models\xerc;
use Illuminate\Support\Facades\Auth;

class ordersController extends Controller
{
    public function orders()
    {
        $user_id = Auth::id();
        $user = user::find($user_id);
        $bsay = brands::where('user_id', '=', $user_id)->count();
        $psay = products::where('user_id', '=', $user_id)->count();
        $csay = clients::where('user_id', '=', $user_id)->count();
        $osay = orders::where('user_id', '=', $user_id)->count();
        $aktiv_mehsul = products::where('user_id', '=', $user_id)->where('miqdar', '>', 0)->count();
        $bitmis_mehsul = products::where('user_id', '=', $user_id)->where('miqdar', '=', 0)->count();
        $user_id = Auth::id();
        $bcon = products::join('brands', 'brands.id', '=', 'products.brand_id')->where('products.user_id', '=', $user_id)
            //->join('clients','clients.id','=','orders.')
            ->select('products.id', 'products.ad as mehsul', 'products.miqdar', 'brands.ad as brand')
            ->get();

        $ccon = orders::join('clients', 'clients.id', '=', 'orders.client_id')
            ->join('products', 'products.id', '=', 'orders.product_id')
            ->join('brands', 'brands.id', '=', 'products.brand_id')->where('orders.user_id', '=', $user_id)
            ->select(
                'clients.id',
                'clients.ad as musteriad',
                'clients.soyad as musterisoyad',
                'products.id as pid',
                'products.ad as mehsul',
                'products.miqdar as mehsulsayi',
                'products.alis',
                'products.satis',
                'brands.ad as brand',
                'orders.miqdar as sifarissayi',
                'orders.created_at as tarix',
                'orders.tesdiq',
                'orders.id as orders_id',
                'orders.cqazanc'
            )
            ->orderBy('tesdiq', 'asc')->get();



        $con = clients::where('user_id', '=', $user_id)->orderBy('ad', 'asc')->get();
        $conn = orders::orderBy('id', 'asc')->get();

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
        $cqazancc = '0';
        $ksay = Credits::where('user_id', '=', $user_id)->count();
        return view('orders', [
            'ksay' => $ksay,
            'aktiv_mehsul' => $aktiv_mehsul,
            'bitmis_mehsul' => $bitmis_mehsul,
            'mehsul' => $mehsul,
            'carimehsul' => $carimehsul,
            'umimicredit' => $umimicredit,
            'xerc' => $cemxerc,
            'caricredit' => $caricredit,
            'data' => $conn,
            'dataa' => $con,
            'bdata' => $bcon,
            'cdata' => $ccon,
            'bsay' => $bsay,
            'psay' => $psay,
            'csay' => $csay,
            'osay' => $osay,
            'user_id' => $user_id,
            'user' => $user,
            'user_id' => $user_id,
            'cqazancc' => $cqazancc,


        ]);
        // $cqazanc ='0';
        $qazanc = ((($ccon->satis) - ($ccon->alis)) * $ccon->mehsulsayi);
    }


    public function store(OrdersRequest $post)
    {
        $user_id = Auth::id();
        $con = new orders();
        $con->user_id = $user_id;
        $con->client_id = $post->client_id;
        $con->product_id = $post->product_id;
        $con->miqdar = $post->miqdar;
        $con->tesdiq = '0';
        $con->cqazanc = '0';
        $con->save();

        return redirect()->route('orders')->with('order_add', 'Sifariş uğurla əlavə edili');
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
        $user_id = Auth::id();
        $oid = orders::find($id);
        $bcon = products::join('brands', 'brands.id', '=', 'products.brand_id')
            ->join('orders', 'products.id', '=', 'orders.product_id')->where('orders.id', '=', $id)
            ->select('products.id as pid', 'products.ad as mehsul', 'products.miqdar', 'brands.ad as brand')
            ->get();

        $ccon = orders::join('clients', 'clients.id', '=', 'orders.client_id')
            ->join('products', 'products.id', '=', 'orders.product_id')
            ->join('brands', 'brands.id', '=', 'products.brand_id')->where('orders.id', '=', $id)
            ->select(
                'clients.id as cid',
                'clients.ad as musteriad',
                'clients.soyad as musterisoyad',
                'products.id as pid',
                'products.ad as mehsul',
                'products.miqdar as mehsulsayi',
                'products.alis',
                'products.satis',
                'brands.ad as brand',
                'orders.miqdar as sifarissayi',
                'orders.created_at as tarix',
                'orders.tesdiq',
                'orders.id as orders_id',
                'orders.cqazanc'
            )
            ->get();

        //$con = clients::where('user_id','=',$user_id)->orderBy('ad','asc')->get();
        $conn = orders::orderBy('id', 'asc')->get();
        $post1 = orders::find($id);

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
        $cqazancc = '0';
        $ksay = Credits::where('user_id', '=', $user_id)->count();
        return view('orders', [
            'ksay' => $ksay,
            'aktiv_mehsul' => $aktiv_mehsul,
            'bitmis_mehsul' => $bitmis_mehsul,
            'mehsul' => $mehsul,
            'carimehsul' => $carimehsul,
            'umimicredit' => $umimicredit,
            'xerc' => $cemxerc,
            'caricredit' => $caricredit,
            'data' => $conn,
            //'dataa'=>$con,
            'editdata' => $post1,
            'bdata' => $bcon,
            'cdata' => $ccon,
            'bsay' => $bsay,
            'psay' => $psay,
            'csay' => $csay,
            'oid' => $oid,
            'osay' => $osay,
            'user_id' => $user_id,
            'user' => $user,
            'user_id' => $user_id,
            'cqazancc' => $cqazancc,

        ]);
    }

    public function update(Request $request)
    {
        $user_id = Auth::id();
        $post = orders::where('user_id', '=', $user_id)->find($request->id);
        //dd($request);
        $post->client_id = $request->cid;
        $post->miqdar = $request->miqdar;

        $post->save();

        return redirect()->route('orders')->with('order_edit', 'Sifariş uğurla yeniləndi');
    }


    public function sil($id)
    {
        $user_id = Auth::id();
        $user = user::find($user_id);
        $cconn = clients::orderBy('ad', 'asc')->get();
        $bsay = brands::where('user_id', '=', $user_id)->count();
        $psay = products::where('user_id', '=', $user_id)->count();
        $csay = clients::where('user_id', '=', $user_id)->count();
        $osay = orders::where('user_id', '=', $user_id)->count();
        $aktiv_mehsul = products::where('user_id', '=', $user_id)->where('miqdar', '>', 0)->count();
        $bitmis_mehsul = products::where('user_id', '=', $user_id)->where('miqdar', '=', 0)->count();
        $post = orders::find($id);
        $bcon = products::join('brands', 'brands.id', '=', 'products.brand_id')
            //->join('clients','clients.id','=','orders.')
            ->select('products.id', 'products.ad as mehsul', 'products.miqdar', 'brands.ad as brand')
            ->get();
        $con = orders::orderBy('id', 'desc')->get();
        $ccon = orders::join('clients', 'clients.id', '=', 'orders.client_id')
            ->join('products', 'products.id', '=', 'orders.product_id')
            ->join('brands', 'brands.id', '=', 'products.brand_id')
            ->select(
                'clients.id',
                'clients.ad as musteriad',
                'clients.soyad as musterisoyad',
                'products.id as pid',
                'products.ad as mehsul',
                'products.miqdar as mehsulsayi',
                'products.alis',
                'products.satis',
                'brands.ad as brand',
                'orders.miqdar as sifarissayi',
                'orders.created_at as tarix',
                'orders.tesdiq',
                'orders.id as orders_id',
                'orders.cqazanc'
            )->get();

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
        return view('orders', [
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
            'bdata' => $bcon,
            'dataa' => $cconn,
            'cdata' => $ccon,
            'cdata' => $ccon,
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

        $post = orders::find($id);

        $post->delete();
        return redirect()->route('orders')->with('order_sil', 'Sifariş uğurla silindi');
    }


    public function tesdiq(Request $request)
    {
        //dd($request);

        $sifaris = $request->smiqdar;
        $mehsul = $request->pmiqdar;
        if ($sifaris > $mehsul) {
            return redirect()->route('orders')->with('order_mehsul', 'Anbarda kifayət qədər məhsul yoxdur');
        } else {

            $con = orders::find($request->id);
            $con->tesdiq = '1';
            $con->cqazanc = ($request->satis - $request->alis) * $request->smiqdar;
            $con->save();

            $post = products::find($request->pid);
            $post->miqdar = $request->pmiqdar - $request->smiqdar;
            $post->save();

            return redirect()->route('orders')->with('order_tesdiq', 'Təsdiq uğurla həyata keçirildi');
        }
    }

    public function legv(Request $request)
    {
        //dd($request);
        $con = orders::find($request->id);
        $con->tesdiq = '0';
        $con->cqazanc = '0';
        $con->save();

        $post = products::find($request->pid);
        $post->miqdar = $request->pmiqdar + $request->smiqdar;
        $post->save();

        return redirect()->route('orders')->with('order_legv', 'Ləğv uğurla həyata keçirildi');
    }


    public function secsil(Request $request)
    {
        // dd($request);
        $ids = $request->ids;

        orders::whereIn('id', $ids)->delete();

        return response()->json(['Silinme ugurla heyata kecirildi']);
    }

    public function search()
    {
        $user_id = Auth::id();
        $user = user::find($user_id);
        $bsay = brands::where('user_id', '=', $user_id)->count();
        $psay = products::where('user_id', '=', $user_id)->count();
        $csay = clients::where('user_id', '=', $user_id)->count();
        $osay = orders::where('user_id', '=', $user_id)->count();
        $aktiv_mehsul = products::where('user_id', '=', $user_id)->where('miqdar', '>', 0)->count();
        $bitmis_mehsul = products::where('user_id', '=', $user_id)->where('miqdar', '=', 0)->count();
        $user_id = Auth::id();
        $bcon = products::join('brands', 'brands.id', '=', 'products.brand_id')
            //->join('clients','clients.id','=','orders.')
            ->select('products.id', 'products.ad as mehsul', 'products.miqdar', 'brands.ad as brand')
            ->get();
        $search_text = $_GET['query'];
        $ccon = orders::join('clients', 'clients.id', '=', 'orders.client_id')
            ->join('products', 'products.id', '=', 'orders.product_id')
            ->join('brands', 'brands.id', '=', 'products.brand_id')
            ->where('clients.ad', 'LIKE', '%' . $search_text . '%')
            ->where('orders.user_id', '=', $user_id)
            ->orWhere('products.ad', 'LIKE', '%' . $search_text . '%')
            ->where('orders.user_id', '=', $user_id)
            ->orWhere('brands.ad', 'LIKE', '%' . $search_text . '%')
            ->where('orders.user_id', '=', $user_id)
            ->select(
                'clients.id',
                'clients.ad as musteriad',
                'clients.soyad as musterisoyad',
                'products.id as pid',
                'products.ad as mehsul',
                'products.miqdar as mehsulsayi',
                'products.alis',
                'products.satis',
                'brands.ad as brand',
                'orders.miqdar as sifarissayi',
                'orders.created_at as tarix',
                'orders.tesdiq',
                'orders.id as orders_id',
                'orders.cqazanc'
            )
            ->get();

        $con = clients::where('user_id', '=', $user_id)->orderBy('ad', 'asc')->get();
        $conn = orders::orderBy('id', 'asc')->get();

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
        $cqazancc = '0';
        $ksay = Credits::where('user_id', '=', $user_id)->count();
        return view('orders', [
            'ksay' => $ksay,
            'aktiv_mehsul' => $aktiv_mehsul,
            'bitmis_mehsul' => $bitmis_mehsul,
            'mehsul' => $mehsul,
            'carimehsul' => $carimehsul,
            'umimicredit' => $umimicredit,
            'xerc' => $cemxerc,
            'caricredit' => $caricredit,
            'data' => $conn,
            'dataa' => $con,
            'bdata' => $bcon,
            'cdata' => $ccon,
            'bsay' => $bsay,
            'psay' => $psay,
            'csay' => $csay,
            'osay' => $osay,
            'user_id' => $user_id,
            'user' => $user,
            'user_id' => $user_id,
            'cqazancc' => $cqazancc,


        ]);
        // $cqazanc ='0';
        $qazanc = ((($ccon->satis) - ($ccon->alis)) * $ccon->mehsulsayi);
    }
}
