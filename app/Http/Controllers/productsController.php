<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\brands;
use App\Models\clients;
use App\Models\products;
use App\Models\orders;
use App\Models\Paydate;
use App\Models\xerc;
use App\Models\Credits;
use App\Models\user;

use Illuminate\Support\Facades\Auth;

class productsController extends Controller
{
    public function product()
    {
        $user_id = Auth::id();
        $user = user::find($user_id);
        $aktiv_mehsul = products::where('user_id', '=', $user_id)->where('miqdar', '>', 0)->count();
        $bitmis_mehsul = products::where('user_id', '=', $user_id)->where('miqdar', '=', 0)->count();
        $bsay = brands::where('user_id', '=', $user_id)->count();
        $psay = products::where('user_id', '=', $user_id)->count();
        $csay = clients::where('user_id', '=', $user_id)->count();
        $osay = orders::where('user_id', '=', $user_id)->count();
        $con = products::join('brands', 'brands.id', '=', 'products.brand_id')
            ->where('products.user_id', '=', $user_id)
            ->select('products.id', 'products.ad as mehsul', 'products.alis', 'products.satis', 'products.miqdar', 'products.foto', 'products.created_at', 'brands.ad as brand', 'products.created_at as tarix')
            ->get();


        $bcon = brands::where('user_id', '=', $user_id)->orderBy('ad', 'asc')->get();


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
        return view('products', [
            'ksay' => $ksay,
            'aktiv_mehsul' => $aktiv_mehsul,
            'bitmis_mehsul' => $bitmis_mehsul,
            'carimehsul' => $carimehsul,
            'mehsul' => $mehsul,
            'umimicredit' => $umimicredit,
            'caricredit' => $caricredit,
            'xerc' => $cemxerc,
            'data' => $con,
            'bdata' => $bcon,
            'data' => $con,
            'bsay' => $bsay,
            'psay' => $psay,
            'csay' => $csay,
            'osay' => $osay,
            'user_id' => $user_id,
            'user' => $user,
            // 'x'=>$x

        ]);

        $say1 = products::orderBy('ad', 'desc')->get();
        return view(
            'test',
            ['dataa' => $say1]
        );
    }



    public function prstore(Request $post)
    {
        $user_id = Auth::id();
        $con = new products();

        if ($post->satis >= $post->alis) {
            if ($post->miqdar > 0) {
                $con->ad = $post->ad;
                $con->user_id = $user_id;
                $con->brand_id = $post->brand_id;

                $con->alis = $post->alis;
                $con->satis = $post->satis;
                $con->miqdar = $post->miqdar;
                if ($post->hasfile('foto')) {
                    $file = $post->file('foto');
                    $extention = $file->getClientOriginalExtension();
                    $filename = time() . '.' . $extention;
                    $file->move('uploads/brands/', $filename);
                    $con->foto = $filename;
                }


                $con->save();

                return redirect()->route('products')->with('product_add', 'Məhsul uğurla əlavə edildi');
            }
            return redirect()->route('products')->with('productd_add_info_min', 'Məhsulun sayı minimum 1 olmalıdır!!');
        }
        return redirect()->route('products')->with('productd_add_info_sat_al', 'Satış qiyməti alış qiymətindən az olmamalıdır!!');
    }

    public function edit($id)
    {
        $user_id = Auth::id();
        $user = user::find($user_id);
        $bcon = brands::orderBy('ad', 'asc')->get();
        $bsay = brands::where('user_id', '=', $user_id)->count();
        $psay = products::where('user_id', '=', $user_id)->count();
        $csay = clients::where('user_id', '=', $user_id)->count();
        $osay = orders::where('user_id', '=', $user_id)->count();
        $aktiv_mehsul = products::where('user_id', '=', $user_id)->where('miqdar', '>', 0)->count();
        $bitmis_mehsul = products::where('user_id', '=', $user_id)->where('miqdar', '=', 0)->count();
        $post1 = products::find($id);
        $post = products::orderBy('id', 'asc')->get();
        $con = products::join('brands', 'brands.id', '=', 'products.brand_id')->where('products.id', '=', $id)

            //->join('clients'....)
            ->select('products.id', 'products.ad as mehsul', 'products.alis', 'products.satis', 'products.miqdar', 'products.foto', 'products.created_at', 'brands.ad as brand', 'brands.id as brand_id', 'products.created_at as tarix')
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
        return view('products', [
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
            'editdata' => $post1,
            'bsay' => $bsay,
            'psay' => $psay,
            'csay' => $csay,
            'osay' => $osay,
            'user_id' => $user_id,
            'user' => $user,
            'bdata' => $bcon,

        ]);
    }


    public function update(Request $request)
    {
        $user_id = Auth::id();
        $post = products::where('user_id', '=', $user_id)->find($request->id);
        //dd($request);
        $post->ad = $request->ad;
        $post->brand_id = $request->bid;

        $post->alis = $request->alis;
        $post->satis = $request->satis;
        $post->miqdar = $request->miqdar;
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
            $post->alis = $request->alis;
            $post->satis = $request->satis;
            $post->miqdar = $request->miqdar;
        }

        $post->save();

        return redirect()->route('products')->with('product_edit', 'Məhsul uğurla yeniləndi');
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
        $post = products::find($id);
        $bcon = brands::orderBy('ad', 'asc')->get();
        $con = products::orderBy('id', 'desc')->get();


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
        return view('products', [
            'ksay' => $ksay,
            'bitmis_mehsul' => $bitmis_mehsul,
            'aktiv_mehsul' => $aktiv_mehsul,
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
            'bdata' => $bcon,
        ]);
    }

    public function destroy($id)
    {
        $pcount = orders::where('product_id', '=', $id)->count();
        if ($pcount == 0) {
            $post = products::find($id);
            $pic = 'uploads/brands/' . $post->foto;
            unlink($pic);
            $post->delete();
            return redirect()->route('products')->with('product_sil', 'Məhsul uğurla silindi');
        }
        return redirect()->route('products')->with('product_sil_error', 'Bu məhsula aid aktiv sifariş mövcuddur!!');
    }

    public function secsil(Request $request)
    {
        $ids = $request->ids;

        $pcount = orders::where('product_id', '=', $ids)->count();
        if ($pcount == 0) {
            products::whereIn('id', $ids)->delete();

            return response()->json(['Silinme ugurla heyata kecirildi']);
        } else {
            return response()->json(['Bu mehsula aid aktiv Sifarish movcuddur']);
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
        $aktiv_mehsul = products::where('user_id', '=', $user_id)->where('miqdar', '>', 0)->count();
        $bitmis_mehsul = products::where('user_id', '=', $user_id)->where('miqdar', '=', 0)->count();
        $search_text = $_GET['query'];
        $con = products::join('brands', 'brands.id', '=', 'products.brand_id')
            ->where('products.ad', 'LIKE', '%' . $search_text . '%')
            ->where('products.user_id', '=', $user_id)
            ->orWhere('brands.ad', 'LIKE', '%' . $search_text . '%')
            ->where('products.user_id', '=', $user_id)
            ->select('products.id', 'products.ad as mehsul', 'products.alis', 'products.satis', 'products.miqdar', 'products.foto', 'products.created_at', 'brands.ad as brand', 'products.created_at as tarix')
            ->get();
        $bcon = brands::where('user_id', '=', $user_id)->orderBy('ad', 'asc')->get();


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
        return view('products', [
            'ksay' => $ksay,
            'aktiv_mehsul' => $aktiv_mehsul,
            'bitmis_mehsul' => $bitmis_mehsul,
            'mehsul' => $mehsul,
            'carimehsul' => $carimehsul,
            'umimicredit' => $umimicredit,
            'xerc' => $cemxerc,
            'caricredit' => $caricredit,
            'data' => $con,
            'bdata' => $bcon,
            'data' => $con,
            'bsay' => $bsay,
            'psay' => $psay,
            'csay' => $csay,
            'osay' => $osay,
            'user_id' => $user_id,
            'user' => $user,
            // 'x'=>$x

        ]);
    }
}
