<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/




Route::group(['middleware' => 'notelogin'], function () {


    Route::get('/messages', 'App\Http\Controllers\messagesController@index')->name('messages');
    Route::get('/message/{id}', 'App\Http\Controllers\messagesController@message')->name('message');
    Route::get('/message-sil/{id}', 'App\Http\Controllers\messagesController@sil')->name('message.sil');
    Route::get('/message-delete/{id}', 'App\Http\Controllers\messagesController@silindi')->name('message.delete');
    Route::post('/message-send', 'App\Http\Controllers\messagesController@send')->name('message.send');

    //Messages SEARCH
    Route::get('/searchmessage',  'App\Http\Controllers\messagesController@search');

    //Profile
    Route::get('/admin', 'App\Http\Controllers\adminController@admin')->name('admin.index');

    //Staff
    Route::get('/staff', 'App\Http\Controllers\staffController@index')->name('staff');
    Route::post('/staff-gonder', 'App\Http\Controllers\staffController@store')->name('staff.gonder');

    //Staff Edit
    Route::get('/staff-edit/{id}', 'App\Http\Controllers\staffController@edit')->name('staff.edit');
    Route::post('/staff-edit', 'App\Http\Controllers\staffController@update')->name('staff.update');

    //Staff DELETE
    Route::get('/staff-sil/{id}', 'App\Http\Controllers\staffController@sil')->name('staff.sil');
    Route::get('/staff-delete/{id}', 'App\Http\Controllers\staffController@destroy')->name('staff.delete');

    //Staff SEARCH
    Route::get('/searchstaff',  'App\Http\Controllers\staffController@search');

    //Documents
    Route::get('/document/{id}', 'App\Http\Controllers\documentController@index')->name('document');
    Route::post('/document-store', 'App\Http\Controllers\documentController@store')->name('document.gonder');

    Route::get('/document-edit/{id}', 'App\Http\Controllers\documentController@edit')->name('document.edit');
    Route::post('/document-edit', 'App\Http\Controllers\documentController@update')->name('document.update');

    Route::get('/document-sil/{id}', 'App\Http\Controllers\documentController@sil')->name('document.sil');
    Route::get('/document-delete/{id}', 'App\Http\Controllers\documentController@destroy')->name('document.delete');


    //Document SEARCH
    Route::get('/searchsdocument',  'App\Http\Controllers\documentController@search');

    //Profile
    Route::get('/profile', 'App\Http\Controllers\profileController@profile')->name('profile.index');
    Route::post('/profile-update', 'App\Http\Controllers\profileController@update')->name('profile.update');

    //Brands create
    Route::post('/brands-gonder', 'App\Http\Controllers\brandsController@store')->name('brands.gonder');
    Route::get('/', 'App\Http\Controllers\brandsController@index')->name('index');
    //Brands EDIT
    Route::get('/brands-edit/{id}', 'App\Http\Controllers\brandsController@edit')->name('brands.edit');
    Route::post('/brands-edit', 'App\Http\Controllers\brandsController@update')->name('brands.update');
    //Brands DELETE
    Route::get('/brands-sil/{id}', 'App\Http\Controllers\brandsController@sil')->name('brands.sil');
    Route::get('/brands-delete/{id}', 'App\Http\Controllers\brandsController@destroy')->name('brands.delete');

    //Brands SEARCH
    Route::get('/searchbrands',  'App\Http\Controllers\brandsController@search');
    //Brands SECSIL
    Route::delete('/brands-secsil', 'App\Http\Controllers\brandsController@secsil')->name('brands.secsil');




    //Products create
    Route::get('/products', 'App\Http\Controllers\productsController@product')->name('products');
    Route::post('/products-gonder', 'App\Http\Controllers\productsController@prstore')->name('products.gonder');
    //Products Edit
    Route::get('/products-edit/{id}', 'App\Http\Controllers\productsController@edit')->name('products.edit');
    Route::post('/products-edit', 'App\Http\Controllers\productsController@update')->name('products.update');
    //Products DELETE
    Route::get('/products-sil/{id}', 'App\Http\Controllers\productsController@sil')->name('products.sil');
    Route::get('/products-delete/{id}', 'App\Http\Controllers\productsController@destroy')->name('products.delete');
    //PRODUCTS  SECSIL
    Route::delete('/products-secsil', 'App\Http\Controllers\productsController@secsil')->name('products.secsil');

    //Products SEARCH
    Route::get('/searchproducts',  'App\Http\Controllers\productsController@search');

    //Clients create
    Route::get('/clients', 'App\Http\Controllers\clientsController@clients')->name('clients');
    Route::post('/clients-gonder', 'App\Http\Controllers\clientsController@store')->name('clients.gonder');
    //Clients Edit
    Route::get('/clients-edit/{id}', 'App\Http\Controllers\clientsController@edit')->name('clients.edit');
    Route::post('/clients-edit', 'App\Http\Controllers\clientsController@update')->name('clients.update');
    //Clients Delete
    Route::get('/clients-sil/{id}', 'App\Http\Controllers\clientsController@sil')->name('clients.sil');
    Route::get('/clients-delete/{id}', 'App\Http\Controllers\clientsController@destroy')->name('clients.delete');

    //CLİENTS SECSIL
    Route::delete('/clients-secsil', 'App\Http\Controllers\clientsController@secsil')->name('clients.secsil');

    //CLIENTS SEARCH
    Route::get('/searchclients',  'App\Http\Controllers\clientsController@search');

    //Xerc craete   
    Route::get('/xerc', 'App\Http\Controllers\xercController@xerc')->name('xerc');
    Route::post('/gonder', 'App\Http\Controllers\xercController@store')->name('gonder');
    //Xerc edit
    Route::get('/xerc-edit/{id}', 'App\Http\Controllers\xercController@edit')->name('xerc.edit');
    Route::post('/xerc-edit', 'App\Http\Controllers\xercController@update')->name('xerc.update');
    //Xerc Delete
    Route::get('/xerc-sil/{id}', 'App\Http\Controllers\xercController@sil')->name('xerc.sil');
    Route::get('/xerc-delete/{id}', 'App\Http\Controllers\xercController@destroy')->name('xerc.delete');

    //XERC SECSIL
    Route::delete('/xerc-secsil', 'App\Http\Controllers\xercController@secsil')->name('xerc.secsil');

    //XERC SEARCH
    Route::get('/searchxerc',  'App\Http\Controllers\xercController@search');


    //Orders Create
    Route::get('/orders', 'App\Http\Controllers\ordersController@orders')->name('orders');
    Route::post('/orders-gonder', 'App\Http\Controllers\ordersController@store')->name('orders.gonder');

    //Orders Edit
    Route::get('/orders-edit/{id}', 'App\Http\Controllers\ordersController@edit')->name('orders.edit');
    Route::post('/orders-edit', 'App\Http\Controllers\ordersController@update')->name('orders.update');

    //Orders Delete
    Route::get('/orders-sil/{id}', 'App\Http\Controllers\ordersController@sil')->name('orders.sil');
    Route::get('/orders-delete/{id}', 'App\Http\Controllers\ordersController@destroy')->name('orders.delete');

    //ORDERS SECSIL
    Route::delete('/orders-secsil', 'App\Http\Controllers\ordersController@secsil')->name('orders.secsil');

    //Orders Tesdiq
    Route::post('/orders-tesdiq', 'App\Http\Controllers\ordersController@tesdiq')->name('orders.tesdiq');
    Route::post('/orders-legv', 'App\Http\Controllers\ordersController@legv')->name('orders.legv');

    //Credit
    Route::get('/credit', 'App\Http\Controllers\creditController@index')->name('credit');
    Route::post('/credit-send', 'App\Http\Controllers\creditController@store')->name('credit.send');

    Route::get('/credit-edit/{id}', 'App\Http\Controllers\creditController@edit')->name('credit.edit');
    Route::post('/credit-edit', 'App\Http\Controllers\creditController@update')->name('credit.update');

    Route::get('/credit-sil/{id}', 'App\Http\Controllers\creditController@sil')->name('credit.sil');
    Route::get('/credit-delete/{id}', 'App\Http\Controllers\creditController@destroy')->name('credit.delete');

    Route::post('/credit-tesdiq', 'App\Http\Controllers\creditController@tesdiq')->name('credit.tesdiq');
    Route::get('/odenis/{id}', 'App\Http\Controllers\creditController@odenis')->name('odenis');
    Route::post('/odenis', 'App\Http\Controllers\creditController@pay')->name('credit.pay');
    //CREDIT SEARCH
    Route::get('/searchcredit',  'App\Http\Controllers\creditController@search');

    Route::get('/test', function () {
        return view('test');
    })->name('test');
    Route::get('/logout', 'App\Http\Controllers\loginController@logout')->name('cixis');

    Route::post('/admin-tesdiq', 'App\Http\Controllers\adminController@tesdiq')->name('tesdiq');
    Route::post('/admin-blok', 'App\Http\Controllers\adminController@blok')->name('blok');


    //ORDERS SEARCH
    Route::get('/searchorders',  'App\Http\Controllers\ordersController@search');

    //KOMENDANNT
    Route::get('/komendant', 'App\Http\Controllers\KomendantController@index')->name('komendant');
    Route::post('/komendant', 'App\Http\Controllers\KomendantController@store')->name('komendant.store');
    Route::get('/komendant-edit/{id}', 'App\Http\Controllers\KomendantController@edit')->name('komendant.edit');
    Route::post('/komendant-edit', 'App\Http\Controllers\KomendantController@update')->name('komendant.update');
    Route::get('/komendant-sil/{id}', 'App\Http\Controllers\KomendantController@sil')->name('komendant.sil');
    Route::get('/komendant-delete/{id}', 'App\Http\Controllers\KomendantController@destroy')->name('komendant.delete');
    Route::get('/searchkomendant',  'App\Http\Controllers\KomendantController@search');
    Route::delete('/komendant-secsil', 'App\Http\Controllers\KomendantController@secsil')->name('komendant.secsil');

    //LAYİHƏ
    Route::get('/layihe', 'App\Http\Controllers\LayiheController@index')->name('layihe');
    Route::post('/layihe', 'App\Http\Controllers\LayiheController@store')->name('layihe.store');
    Route::get('/layihe-edit/{id}', 'App\Http\Controllers\LayiheController@edit')->name('layihe.edit');
    Route::post('/layihe-edit', 'App\Http\Controllers\LayiheController@update')->name('layihe.update');
    Route::get('/layihe-sil/{id}', 'App\Http\Controllers\LayiheController@sil')->name('layihe.sil');
    Route::get('/layihe-delete/{id}', 'App\Http\Controllers\LayiheController@destroy')->name('layihe.delete');
    Route::get('/searchlayihe',  'App\Http\Controllers\LayiheController@search');
});





Route::group(['middleware' => 'islogin'], function () {



    Route::get('/login', 'App\Http\Controllers\loginController@index')->name('login');
    Route::post('/login', 'App\Http\Controllers\loginController@login')->name('login.submit');
    Route::get('/aktiv', 'App\Http\Controllers\aktivController@aktiv')->name('aktiv');
    Route::post('/aktiv', 'App\Http\Controllers\aktivController@gonder')->name('aktiv.gonder');


    Route::get('/register', 'App\Http\Controllers\registerController@index')->name('register');
    Route::post('/register', 'App\Http\Controllers\registerController@register')->name('register.submit');



    //LOgout


});
