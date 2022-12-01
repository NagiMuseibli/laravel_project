<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\brands;
use App\Models\products;
use App\Models\clients;
use App\Models\orders;
use App\Models\user;
use App\Models\documents;
use App\Models\Credits;
use App\Models\xerc;
use App\Models\Paydate;
use App\Models\staff;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\documentRequest;

class documentController extends Controller
{
    //
    public  function index($id)
    {
        $user_id = Auth::id();
        $bsay = brands::where('user_id', '=', $user_id)->count();
        $psay = products::where('user_id', '=', $user_id)->count();
        $csay = clients::where('user_id', '=', $user_id)->count();
        $osay = orders::where('user_id', '=', $user_id)->count();
        $ksay = Credits::where('user_id', '=', $user_id)->count();
        $aktiv_mehsul = products::where('user_id', '=', $user_id)->where('miqdar', '>', 0)->count();
        $bitmis_mehsul = products::where('user_id', '=', $user_id)->where('miqdar', '=', 0)->count();
        $post = user::find($user_id);


        $name = staff::find($id);
        $con = documents::join('staff', 'staff.id', '=', 'documents.staff_id')
            ->where('documents.staff_id', '=', $id)
            ->select('staff.ad', 'staff.soyad', 'staff.email', 'documents.title', 'documents.scan', 'documents.created_at as tarix', 'documents.id as document_id')
            ->orderBy('documents.id', 'desc')
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

        return view(
            'document',
            [
                'name' => $name,
                'ksay' => $ksay,
                'aktiv_mehsul' => $aktiv_mehsul,
                'bitmis_mehsul' => $bitmis_mehsul,
                'umimicredit' => $umimicredit,
                'caricredit' => $caricredit,
                'carimehsul' => $carimehsul,
                'mehsul' => $mehsul,
                'xerc' => $cemxerc,
                'data' => $con,
                // 'sid'=>$id,
                'bsay' => $bsay,
                'psay' => $psay,
                'csay' => $csay,
                'osay' => $osay,
                'user_id' => $user_id,
                'user' => $post,
                'id' => $id,
            ]
        );
    }

    public function store(documentRequest $request)
    {
        //dd($request);

        //Brend movcud deyilse
        $con = new documents();
        $con->title = $request->title;
        $con->staff_id = $request->staff_id;
        if ($request->hasfile('scan')) {
            $file = $request->file('scan');
            $extention = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extention;
            $file->move('uploads/brands/', $filename);
            $con->scan = $filename;
        }
        $con->save();

        return redirect()->route('document', $request->staff_id)->with('document_add', 'Document uğurla əlavə edildi');
    }

    public  function edit($id)
    {
        $user_id = Auth::id();
        $bsay = brands::where('user_id', '=', $user_id)->count();
        $psay = products::where('user_id', '=', $user_id)->count();
        $csay = clients::where('user_id', '=', $user_id)->count();
        $osay = orders::where('user_id', '=', $user_id)->count();
        $aktiv_mehsul = products::where('user_id', '=', $user_id)->where('miqdar', '>', 0)->count();
        $bitmis_mehsul = products::where('user_id', '=', $user_id)->where('miqdar', '=', 0)->count();
        $post = user::find($user_id);
        $con = documents::join('staff', 'staff.id', '=', 'documents.staff_id')
            ->where('documents.id', '=', $id)
            ->select('staff.ad', 'staff.soyad', 'staff.email', 'documents.title', 'documents.scan', 'documents.created_at as tarix', 'documents.id as document_id')
            ->orderBy('documents.id', 'desc')
            ->get();
        $edit = documents::find($id);

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
            'document',
            [
                'ksay' => $ksay,
                'aktiv_mehsul' => $aktiv_mehsul,
                'bitmis_mehsul' => $bitmis_mehsul,
                'umimicredit' => $umimicredit,
                'caricredit' => $caricredit,
                'carimehsul' => $carimehsul,
                'mehsul' => $mehsul,
                'xerc' => $cemxerc,
                'edit' => $edit,
                'data' => $con,
                // 'sid'=>$id,
                'bsay' => $bsay,
                'psay' => $psay,
                'csay' => $csay,
                'osay' => $osay,
                'user_id' => $user_id,
                'user' => $post,
                'id' => $id,
            ]
        );
    }

    public function update(Request $request)
    {
        //dd($request);

        //Brend movcud deyilse
        $con = documents::find($request->document_id);
        $con->title = $request->title;
        if (!empty($request->scan)) {
            if ($request->hasfile('scan')) {
                $pic = 'uploads/brands/' . $request->carifoto;
                unlink($pic);
                $file = $request->file('scan');
                $extention = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extention;
                $file->move('uploads/brands/', $filename);
                $con->scan = $filename;
            }
        } else {
            $con->title = $request->title;
        }

        $con->save();

        return redirect()->route('document', $request->staff_id)->with('document_add', 'Document uğurla yenilendi');
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

    public function sil($id)
    {
        $user_id = Auth::id();
        $bsay = brands::where('user_id', '=', $user_id)->count();
        $psay = products::where('user_id', '=', $user_id)->count();
        $csay = clients::where('user_id', '=', $user_id)->count();
        $osay = orders::where('user_id', '=', $user_id)->count();
        $aktiv_mehsul = products::where('user_id', '=', $user_id)->where('miqdar', '>', 0)->count();
        $bitmis_mehsul = products::where('user_id', '=', $user_id)->where('miqdar', '=', 0)->count();
        $post = user::find($user_id);

        $con = documents::join('staff', 'staff.id', '=', 'documents.staff_id')
            ->where('documents.id', '=', $id)
            ->select('staff.ad', 'staff.soyad', 'staff.email', 'documents.title', 'documents.scan', 'documents.created_at as tarix', 'documents.id as document_id')
            ->orderBy('documents.id', 'desc')
            ->get();
        $sildata = documents::find($id);

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
            'document',
            [
                'ksay' => $ksay,
                'sildata' => $sildata,
                'aktiv_mehsul' => $aktiv_mehsul,
                'bitmis_mehsul' => $bitmis_mehsul,
                'umimicredit' => $umimicredit,
                'caricredit' => $caricredit,
                'carimehsul' => $carimehsul,
                'mehsul' => $mehsul,
                'xerc' => $cemxerc,
                'data' => $con,
                // 'sid'=>$id,
                'bsay' => $bsay,
                'psay' => $psay,
                'csay' => $csay,
                'osay' => $osay,
                'user_id' => $user_id,
                'user' => $post,
                'id' => $id,
            ]
        );
    }

    public function destroy($id)
    {
        // dd($request);
        $post = documents::find($id);
        $pic = 'uploads/brands/' . $post->scan;
        unlink($pic);
        $staff_id = $post->staff_id;

        $post->delete();
        return redirect()->route('document', $staff_id)->with('docuument_sil', 'document uğurla silindi');
    }
}
