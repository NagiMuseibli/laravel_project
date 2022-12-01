<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreditRequest;
use App\Models\brands;
use App\Models\products;
use App\Models\clients;
use App\Models\orders;
use App\Models\Credits;
use App\Models\user;
use App\Models\xerc;
use App\Models\Paydate;
use Illuminate\Support\Facades\Auth;

class CreditController extends Controller
{
    public function index()
    {
        $user_id = Auth::id();
        $user = user::find($user_id);
        $bsay = brands::where('user_id', '=', $user_id)->count();
        $psay = products::where('user_id', '=', $user_id)->count();
        $csay = clients::where('user_id', '=', $user_id)->count();
        $creditsay = Credits::where('user_id', '=', $user_id)->count();
        $osay = orders::where('user_id', '=', $user_id)->count();
        $ksay = Credits::where('user_id', '=', $user_id)->count();
        $aktiv_mehsul = products::where('user_id', '=', $user_id)->where('miqdar', '>', 0)->count();
        $bitmis_mehsul = products::where('user_id', '=', $user_id)->where('miqdar', '=', 0)->count();


        $bcon = products::join('brands', 'brands.id', '=', 'products.brand_id')->where('products.user_id', '=', $user_id)
            //->join('clients','clients.id','=','orders.')
            ->select('products.id', 'products.ad as mehsul', 'products.miqdar', 'brands.ad as brand')
            ->get();

        $ccon = Credits::join('clients', 'clients.id', '=', 'Credits.client_id')
            ->join('products', 'products.id', '=', 'Credits.product_id')

            ->join('brands', 'brands.id', '=', 'products.brand_id')->where('Credits.user_id', '=', $user_id)
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
                'Credits.miqdar as sifarissayi',
                'Credits.created_at as tarix',
                'Credits.tesdiq',
                'Credits.id as Credits_id',
                'Credits.kod',
                'Credits.ay',
                'Credits.faiz',
                'Credits.depozit',
                'Credits.muddet',
                'Credits.miqdar as sifarissayi'
            )->orderBy('Credits.created_at', 'desc')
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

        return view('credit', [
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
            'creditsay' => $creditsay,
            'bdata' => $bcon,
            'cdata' => $ccon,
            'bsay' => $bsay,
            'psay' => $psay,
            'csay' => $csay,
            'osay' => $osay,
            'user_id' => $user_id,
            'user' => $user,
            'user_id' => $user_id,
        ]);
        // $cqazanc ='0';
        $qazanc = ((($ccon->satis) - ($ccon->alis)) * $ccon->mehsulsayi);
    }


    public function store(creditRequest $post)
    {
        //dd($post);


        $user_id = Auth::id();
        $con = new Credits();

        $con->kod = $kod = rand(10000000, 99999999);
        $con->user_id = $user_id;
        $con->client_id = $post->client_id;
        $con->product_id = $post->product_id;
        $con->miqdar = $post->miqdar;
        $con->depozit = $post->depozit;
        $con->muddet = $post->muddet;
        $con->faiz = $post->faiz;
        $con->tesdiq = 0;
        $con->ay = 0;
        $con->save();

        return redirect()->route('credit')->with('credit_add', 'Sifariş uğurla əlavə edildi');
    }

    public function edit($id)
    {
        $user_id = Auth::id();
        $user = user::find($user_id);
        $bsay = brands::where('user_id', '=', $user_id)->count();
        $psay = products::where('user_id', '=', $user_id)->count();
        $csay = clients::where('user_id', '=', $user_id)->count();
        $creditsay = Credits::where('user_id', '=', $user_id)->count();
        $osay = orders::where('user_id', '=', $user_id)->count();
        $ksay = Credits::where('user_id', '=', $user_id)->count();
        $aktiv_mehsul = products::where('user_id', '=', $user_id)->where('miqdar', '>', 0)->count();
        $bitmis_mehsul = products::where('user_id', '=', $user_id)->where('miqdar', '=', 0)->count();

        $bcon = products::join('brands', 'brands.id', '=', 'products.brand_id')->where('products.user_id', '=', $user_id)
            //->join('clients','clients.id','=','orders.')
            ->select('products.id', 'products.ad as mehsul', 'products.miqdar', 'brands.ad as brand')
            ->get();

        $ccon = Credits::join('clients', 'clients.id', '=', 'Credits.client_id')
            ->join('products', 'products.id', '=', 'Credits.product_id')
            ->join('brands', 'brands.id', '=', 'products.brand_id')
            ->where('Credits.user_id', '=', $user_id)
            ->where('Credits.id', '=', $id)
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
                'Credits.miqdar as sifarissayi',
                'Credits.created_at as tarix',
                'Credits.tesdiq',
                'Credits.id as Credits_id',
                'Credits.kod',
                'Credits.faiz',
                'Credits.depozit',
                'Credits.muddet',
                'Credits.miqdar as sifarissayi'
            )
            ->get();


        $con = clients::where('user_id', '=', $user_id)->orderBy('ad', 'asc')->get();
        $edit = Credits::find($id);
        $client = Credits::join('clients', 'clients.id', '=', 'Credits.client_id')->where('Credits.id', '=', $id)
            ->select('Credits.id', 'clients.ad as mad', 'clients.soyad as msad', 'clients.id as client_id')
            ->get();

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

        return view('credit', [
            'ksay' => $ksay,
            'aktiv_mehsul' => $aktiv_mehsul,
            'bitmis_mehsul' => $bitmis_mehsul,
            'mehsul' => $mehsul,
            'carimehsul' => $carimehsul,
            'umimicredit' => $umimicredit,
            'xerc' => $cemxerc,
            'caricredit' => $caricredit,
            'data' => $ccon,
            'edit' => $edit,
            'dataa' => $con,
            'creditsay' => $creditsay,
            'bdata' => $bcon,
            'cdata' => $ccon,
            'bsay' => $bsay,
            'psay' => $psay,
            'csay' => $csay,
            'osay' => $osay,
            'user_id' => $user_id,
            'user' => $user,
            'user_id' => $user_id,

        ]);
    }

    public function update(Request $post)
    {

        //dd($post);
        $user_id = Auth::id();
        $con = Credits::where('user_id', '=', $user_id)->find($post->id);

        $con->miqdar = $post->miqdar;
        $con->depozit = $post->depozit;
        $con->muddet = $post->muddet;
        $con->save();

        return redirect()->route('credit')->with('credit_edit', 'Sifariş uğurla yeniləndi');
    }

    public function tesdiq(Request $request)
    {
        //dd($request);

        $sifaris = $request->smiqdar;
        $mehsul = $request->pmiqdar;
        if ($sifaris > $mehsul) {
            return redirect()->route('credit')->with('credit_meshul', 'Anbarda kifayət qədər məhsul yoxdur');
        } else {

            $con = Credits::find($request->credit_id);
            $con->tesdiq = 1;
            $con->save();

            $post = products::find($request->pid);

            $post->miqdar = $mehsul - $sifaris;
            $post->save();

            return redirect()->route('credit')->with('credit_tesdiq', 'Təsdiq uğurla həyata keçirildi');
        }
    }

    public function odenis($id)
    {
        $user_id = Auth::id();
        $user = user::find($user_id);
        $bsay = brands::where('user_id', '=', $user_id)->count();
        $psay = products::where('user_id', '=', $user_id)->count();
        $csay = clients::where('user_id', '=', $user_id)->count();
        $creditsay = Credits::where('user_id', '=', $user_id)->count();
        $osay = orders::where('user_id', '=', $user_id)->count();
        $ksay = Credits::where('user_id', '=', $user_id)->count();
        $aktiv_mehsul = products::where('user_id', '=', $user_id)->where('miqdar', '>', 0)->count();
        $bitmis_mehsul = products::where('user_id', '=', $user_id)->where('miqdar', '=', 0)->count();
        $user_id = Auth::id();



        $ccon = Credits::join('clients', 'clients.id', '=', 'Credits.client_id')
            ->join('products', 'products.id', '=', 'Credits.product_id')
            ->join('brands', 'brands.id', '=', 'products.brand_id')->where('Credits.id', '=', $id)
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
                'Credits.miqdar as sifarissayi',
                'Credits.created_at as tarix',
                'Credits.tesdiq',
                'Credits.id as Credits_id',
                'Credits.kod',
                'Credits.ay',
                'Credits.faiz',
                'Credits.depozit',
                'Credits.muddet',
                'Credits.miqdar as sifarissayi'
            )->get();


        $paydate = Credits::join('clients', 'clients.id', '=', 'Credits.client_id')
            ->join('products', 'products.id', '=', 'Credits.product_id')
            ->join('Paydates', 'credit_id', '=', 'Credits.id')
            ->join('brands', 'brands.id', '=', 'products.brand_id')->where('Credits.id', '=', $id)
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
                'Credits.miqdar as sifarissayi',
                'Paydates.created_at as tarix',
                'Credits.tesdiq',
                'Credits.id as Credits_id',
                'Credits.kod',
                'Credits.faiz',
                'Credits.depozit',
                'Paydates.mebleg',
                'Credits.miqdar as sifarissayi'
            )
            ->get();

        $con = clients::where('user_id', '=', $user_id)->orderBy('ad', 'asc')->get();
        $conn = orders::orderBy('id', 'asc')->get();
        $odenis = Credits::find($id);

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
        //$ayliq = $ccon->sifarissayi;
        return view('credit', [
            'ksay' => $ksay,
            'aktiv_mehsul' => $aktiv_mehsul,
            'bitmis_mehsul' => $bitmis_mehsul,
            'mehsul' => $mehsul,
            'carimehsul' => $carimehsul,
            'umimicredit' => $umimicredit,
            'xerc' => $cemxerc,
            'caricredit' => $caricredit,
            'data' => $conn,
            'paydate' => $paydate,
            'odenis' => $odenis,
            'dataa' => $con,
            'creditsay' => $creditsay,

            'cdata' => $ccon,
            'bsay' => $bsay,
            'psay' => $psay,
            'csay' => $csay,
            'osay' => $osay,
            'user_id' => $user_id,
            'user' => $user,
            'user_id' => $user_id,


        ]);
    }

    public function pay(Request $request)
    {
        //dd($request);


        $user_id = Auth::id();
        $user = user::find($user_id);
        $bsay = brands::where('user_id', '=', $user_id)->count();
        $psay = products::where('user_id', '=', $user_id)->count();
        $csay = clients::where('user_id', '=', $user_id)->count();
        $creditsay = Credits::where('user_id', '=', $user_id)->count();
        $osay = orders::where('user_id', '=', $user_id)->count();
        $ksay = Credits::where('user_id', '=', $user_id)->count();
        $aktiv_mehsul = products::where('user_id', '=', $user_id)->where('miqdar', '>', 0)->count();
        $bitmis_mehsul = products::where('user_id', '=', $user_id)->where('miqdar', '=', 0)->count();
        $user_id = Auth::id();

        $bcon = products::join('brands', 'brands.id', '=', 'products.brand_id')->where('products.user_id', '=', $user_id)
            //->join('clients','clients.id','=','orders.')
            ->select('products.id', 'products.ad as mehsul', 'products.miqdar', 'brands.ad as brand')
            ->get();

        $ccon = Credits::join('clients', 'clients.id', '=', 'Credits.client_id')
            ->join('products', 'products.id', '=', 'Credits.product_id')
            ->join('brands', 'brands.id', '=', 'products.brand_id')->where('Credits.user_id', '=', $user_id)
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
                'Credits.miqdar as sifarissayi',
                'Credits.created_at as tarix',
                'Credits.tesdiq',
                'Credits.id as Credits_id',
                'Credits.kod',
                'Credits.faiz',
                'Credits.depozit',
                'Credits.muddet',
                'Credits.miqdar as sifarissayi'
            )
            ->get();

        $con = clients::where('user_id', '=', $user_id)->orderBy('ad', 'asc')->get();
        $conn = orders::orderBy('id', 'asc')->get();



        if ($request->mebleg > 0) {
            if ($request->mebleg <= $request->qaliqb) {
                $post = new Paydate();
                $post->user_id = $user_id;
                $post->credit_id = $request->credit_id;
                $post->client_id = $request->client_id;
                $post->product_id = $request->product_id;
                $post->mebleg = $request->mebleg;
                $post->save();
                $con = Credits::find($request->credit_id);
                $con->depozit = $con->depozit + $request->mebleg;
                $con->ay = $con->ay + 1;
                $con->save();

                return redirect()->route('credit')->with('credit_odenis', 'Ödəniş uğurla edildi');
            } else {
                return redirect()->route('credit')->with('credit_odenis_warning', 'Ödəyəcəyiniz Məbləğ qalıq borcdan çox ola bilməz!!!');
            }
        } else {
            return redirect()->route('credit')->with('credit_mebleg_warning', 'Ödəyəcəyiniz Məbləğ minimum 1 AZN ola biler!!');
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


        return view('credit', [
            'ksay' => $ksay,
            'aktiv_mehsul' => $aktiv_mehsul,
            'bitmis_mehsul' => $bitmis_mehsul,
            'mehsul' => $mehsul,
            'carimehsul' => $carimehsul,
            'umimicredit' => $umimicredit,
            'xerc' => $cemxerc,
            'caricredit' => $caricredit,
            'data' => $conn,
            'bdata' => $bcon,
            'dataa' => $con,
            'creditsay' => $creditsay,

            'cdata' => $ccon,
            'bsay' => $bsay,
            'psay' => $psay,
            'csay' => $csay,
            'osay' => $osay,
            'user_id' => $user_id,
            'user' => $user,
            'user_id' => $user_id,


        ]);
    }

    public function sil($id)
    {
        $user_id = Auth::id();
        $user = user::find($user_id);
        $bsay = brands::where('user_id', '=', $user_id)->count();
        $psay = products::where('user_id', '=', $user_id)->count();
        $csay = clients::where('user_id', '=', $user_id)->count();
        $creditsay = Credits::where('user_id', '=', $user_id)->count();
        $osay = orders::where('user_id', '=', $user_id)->count();
        $ksay = Credits::where('user_id', '=', $user_id)->count();
        $aktiv_mehsul = products::where('user_id', '=', $user_id)->where('miqdar', '>', 0)->count();
        $bitmis_mehsul = products::where('user_id', '=', $user_id)->where('miqdar', '=', 0)->count();
        $con = clients::where('user_id', '=', $user_id)->orderBy('ad', 'asc')->get();
        $bcon = products::join('brands', 'brands.id', '=', 'products.brand_id')->where('products.user_id', '=', $user_id)
            //->join('clients','clients.id','=','orders.')
            ->select('products.id', 'products.ad as mehsul', 'products.miqdar', 'brands.ad as brand')
            ->get();

        $ccon = Credits::join('clients', 'clients.id', '=', 'Credits.client_id')
            ->join('products', 'products.id', '=', 'Credits.product_id')
            ->join('brands', 'brands.id', '=', 'products.brand_id')
            ->where('Credits.user_id', '=', $user_id)
            ->where('Credits.id', '=', $id)
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
                'Credits.miqdar as sifarissayi',
                'Credits.created_at as tarix',
                'Credits.tesdiq',
                'Credits.id as Credits_id',
                'Credits.kod',
                'Credits.faiz',
                'Credits.depozit',
                'Credits.muddet',
                'Credits.miqdar as sifarissayi'
            )
            ->get();

        $sildata = Credits::find($id);

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
        return view('credit', [
            'ksay' => $ksay,
            'aktiv_mehsul' => $aktiv_mehsul,
            'bitmis_mehsul' => $bitmis_mehsul,
            'mehsul' => $mehsul,
            'carimehsul' => $carimehsul,
            'umimicredit' => $umimicredit,
            'xerc' => $cemxerc,
            'caricredit' => $caricredit,
            'data' => $ccon,
            'sildata' => $sildata,
            'dataa' => $con,
            'creditsay' => $creditsay,
            'bdata' => $bcon,
            'cdata' => $ccon,
            'bsay' => $bsay,
            'psay' => $psay,
            'csay' => $csay,
            'osay' => $osay,
            'user_id' => $user_id,
            'user' => $user,
            'user_id' => $user_id,

        ]);
    }

    public function destroy($id)
    {
        $post = credits::find($id);
        $post->delete();
        return redirect()->route('credit')->with('credit_sil', 'Sifariş uğurla silindi');
    }

    public function search()
    {
        $user_id = Auth::id();
        $con = clients::where('user_id', '=', $user_id)->orderBy('ad', 'asc')->get();
        $user_id = Auth::id();
        $user = user::find($user_id);
        $bsay = brands::where('user_id', '=', $user_id)->count();
        $psay = products::where('user_id', '=', $user_id)->count();
        $csay = clients::where('user_id', '=', $user_id)->count();
        $creditsay = Credits::where('user_id', '=', $user_id)->count();
        $osay = orders::where('user_id', '=', $user_id)->count();
        $aktiv_mehsul = products::where('user_id', '=', $user_id)->where('miqdar', '>', 0)->count();
        $bitmis_mehsul = products::where('user_id', '=', $user_id)->where('miqdar', '=', 0)->count();
        $search_text = $_GET['query'];

        $bcon = products::join('brands', 'brands.id', '=', 'products.brand_id')->where('products.user_id', '=', $user_id)
            //->join('clients','clients.id','=','orders.')
            ->select('products.id', 'products.ad as mehsul', 'products.miqdar', 'brands.ad as brand')
            ->get();

        $ccon = Credits::join('clients', 'clients.id', '=', 'Credits.client_id')
            ->join('products', 'products.id', '=', 'Credits.product_id')
            ->join('brands', 'brands.id', '=', 'products.brand_id')
            ->where('clients.ad', 'LIKE', '%' . $search_text . '%')
            ->where('Credits.user_id', '=', $user_id)
            ->orWhere('clients.soyad', 'LIKE', '%' . $search_text . '%')
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
                'Credits.miqdar as sifarissayi',
                'Credits.created_at as tarix',
                'Credits.tesdiq',
                'Credits.id as Credits_id',
                'Credits.kod',
                'Credits.faiz',
                'Credits.depozit',
                'Credits.muddet',
                'Credits.miqdar as sifarissayi'
            )->orderBy('Credits.id', 'desc')
            ->get();

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
        return view('credit', [
            'ksay' => $ksay,
            'aktiv_mehsul' => $aktiv_mehsul,
            'bitmis_mehsul' => $bitmis_mehsul,
            'mehsul' => $mehsul,
            'carimehsul' => $carimehsul,
            'umimicredit' => $umimicredit,
            'xerc' => $cemxerc,
            'caricredit' => $caricredit,
            'dataa' => $con,
            'creditsay' => $creditsay,
            'bdata' => $bcon,
            'cdata' => $ccon,
            'bsay' => $bsay,
            'psay' => $psay,
            'csay' => $csay,
            'osay' => $osay,
            'user_id' => $user_id,
            'user' => $user,
            'user_id' => $user_id,
        ]);
    }
}
