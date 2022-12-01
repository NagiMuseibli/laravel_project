<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\clients;
use App\Models\brands;
use App\Models\products;
use App\Models\orders;
use App\Models\user;
use App\Models\Credits;
use App\Models\Paydate;
use App\Models\xerc;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ClientsRequest;

class clientsController extends Controller
{
    //
    public function clients()
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
        // $con = brands::get();
        $con = clients::where('user_id', '=', $user_id)->orderBy('id', 'desc')->get();


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
            'clients',
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
    public function store(ClientsRequest $post)
    {
        $user_id = Auth::id();
        $clients = clients::where('user_id', '=', $user_id)->where('tel', '=', $post->tel)
            ->orwhere('user_id', '=', $user_id)->where('email', '=', $post->email)->count();

        //$brand = brands::where('user_id','=',$user_id)->where('ad', '=', $post->ad)->count();

        if ($clients == 0) {
            $con = new clients();
            $con->user_id = $user_id;
            $con->ad = $post->ad;
            $con->soyad = $post->soyad;
            $con->tel = $post->tel;
            $con->email = $post->email;
            $con->sirket = $post->sirket;
            if ($post->hasfile('foto')) {
                $file = $post->file('foto');
                $extention = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extention;
                $file->move('uploads/brands/', $filename);
                $con->foto = $filename;
            }


            $con->save();

            return redirect()->route('clients')->with('client_add', 'Müştəri uğurla əlavə olundu');
        } else {
            return redirect()->route('clients')->with('client_movcud', 'Müştəri artıq mövcuddur!!');
        }
    }


    public function edit($id)
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
        $post = clients::find($id);
        $con = clients::orderBy('id', 'desc')->where('id', '=', $id)->get();

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
        return view('clients', [
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

    public function update(Request $request)
    {
        $post = clients::find($request->id);
        $post->ad = $request->ad;
        $post->soyad = $request->soyad;
        $post->tel = $request->tel;
        $post->email = $request->email;
        $post->sirket = $request->sirket;
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
            $post->soyad = $request->soyad;
            $post->tel = $request->tel;
            $post->email = $request->email;
            $post->sirket = $request->sirket;
        }



        $post->save();

        return redirect()->route('clients')->with('client_edit', 'Müştəri uğurla yeniləndi');
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
        $post = clients::find($id);
        $con = clients::orderBy('id', 'desc')->get();


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
        return view('clients', [
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
        $ccount = orders::where('client_id', '=', $id)->count();
        if ($ccount == 0) {
            $post = clients::find($id);
            $pic = 'uploads/brands/' . $post->foto;
            unlink($pic);
            $post->delete();
            return redirect()->route('clients')->with('client_sil', 'Müştəri uğurla silindi');
        }
        return redirect()->route('clients')->with('client_aktiv', 'Bu müştəriyə aid aktiv sifariş mövcuddur!!');
    }

    public function secsil(Request $request)
    {

        $ids = $request->ids;

        $user_id = Auth::id();

        $ccount = orders::where('client_id', '=', $ids)->count();
        if ($ccount == 0) {
            clients::whereIn('id', $ids)->delete();

            return response()->json(['Silinme ugurla heyata kecirildi']);
        } else {
            return response()->json(['Bu İstifadeciye aid aktiv Sifarish movcuddur']);
        }
    }

    public function search()
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
        // $con = brands::get();
        $search_text = $_GET['query'];
        $con = clients::where('user_id', '=', $user_id)->where('clients.ad', 'LIKE', '%' . $search_text . '%')->orWhere('user_id', '=', $user_id)->where('clients.soyad', 'LIKE', '%' . $search_text . '%')->orderBy('id', 'desc')->get();


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
            'clients',
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
