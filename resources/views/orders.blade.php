@extends('layouts.app')
@section('title')
    Orders
@endsection

@section('axtar')
    <!--SEARCH SYSTEMM SART-->
    <div class="col-auto">
        <form class="nav-link mt-2 mt-md-0 d-none d-lg-flex search" type="get" action="{{ url('/searchorders') }}">
            @csrf
            <input type="search" name="query" class="form-control" placeholder="Search @yield('title')">
            <button class="btn btn-primary btn-sm " type="submit"><i class="mdi mdi-magnify"></i></button>

        </form>
    </div>
    <!--SEARCH SYSTEMM END-->
@endsection

@section('orders')
    <h1>Sifarişlər </h1><br>

    <!--MESSAGES SYSTEMM START-->
    <div id="netice"></div>
    @isset($sildata)
        <span class="alert alert-success">Sifarişi Silməyə əminsinizmi?</span><br><br>
        <a href="{{ route('orders.delete', $sildata->id) }}"><button type="button"
                class="btn btn-primary btn-sm ">Bəli</button></a>
        <a href="{{ route('orders') }}"><button type="button" class="btn btn-danger btn-sm ">Xeyr</button></a><br><br>
    @endisset

    @if (Session::has('order_add'))
        <script>
            swal("ƏLA!!", "{!! Session::get('order_add') !!}", "success");
        </script>
    @endif

    @if (Session::has('order_edit'))
        <script>
            swal("ƏLA!!", "{!! Session::get('order_edit') !!}", "success");
        </script>
    @endif

    @if (Session::has('order_sil'))
        <script>
            swal("ƏLA!!", "{!! Session::get('order_sil') !!}", "success");
        </script>
    @endif

    @if (Session::has('order_mehsul'))
        <script>
            swal("Zəhmət olmasa yenidən cəhd edin!!", "{!! Session::get('order_mehsul') !!}", "warning");
        </script>
    @endif

    @if (Session::has('order_tesdiq'))
        <script>
            swal("ƏLA!!", "{!! Session::get('order_tesdiq') !!}", "success");
        </script>
    @endif

    @if (Session::has('order_legv'))
        <script>
            swal("ƏLA!!", "{!! Session::get('order_legv') !!}", "success");
        </script>
    @endif

    @if ($errors->any())
        @foreach ($errors->all() as $info)
            <script>
                swal("Zəhmət olmasa yenidən cəhd edin!!", "{{ $info }}", "error");
            </script>
        @endforeach
    @endif

    @isset($editdata)
        <div class="card">
            <div class="card-body">
                <form method="post" enctype="multipart/form-data" action="{{ route('orders.update') }}">
                    @csrf
                    Müştəri<br>
                    <input type="hidden" name="id" value="{{ $oid->id }}">
                    <select class="form-control" name="client_id">

                        @foreach ($cdata as $info)
                            <option value="">{{ $info->musteriad }} {{ $info->musterisoyad }}</option>
                            <option value="{{ $info->cid }}">{{ $info->musteriad }} {{ $info->musterisoyad }}</option>
                            <input type="hidden" name="cid" value="{{ $info->cid }}">
                        @endforeach
                    </select><br>
                    Məhsul<br>
                    <select class="form-control" name="brand_id">

                        @foreach ($bdata as $info)
                            <option value="">{{ $info->mehsul }} ({{ $info->brand }}) Mövcud say: {{ $info->miqdar }}
                            </option>;
                            <option value="{{ $info->pid }}">{{ $info->mehsul }} ({{ $info->brand }}) Mövcud say:
                                {{ $info->miqdar }} </option>
                        @endforeach
                    </select><br>

                    <input type="hidden" name="bid" value="">

                    Miqdar
                    @foreach ($cdata as $info)
                        <input type="text" class="form-control" name="miqdar" value="{{ $info->sifarissayi }}"><br>
                    @endforeach
                    <br>
                    <button type="submit" name="d" class="btn btn-primary btn-sm ">Yenile</button>
                    <a href="{{ route('orders') }}"><button type="button" class="btn btn-danger btn-sm ">Imtina</button></a>
                </form>
            </div>
        </div>
    @endisset


    @empty($editdata)
        <div class="card">
            <div class="card-body">
                <form method="post" action="{{ route('orders.gonder') }}">
                    @csrf

                    <select name="client_id" class="form-control">
                        <option value="">Müştəri </option>
                        @foreach ($dataa as $info)
                            <option value="{{ $info->id }}">{{ $info->ad }} {{ $info->soyad }}</option><br><br>
                        @endforeach
                    </select><br><br>

                    <select name="product_id" class="form-control">
                        <option value="">Məhsul</option>
                        @foreach ($bdata as $info)
                            <option value="{{ $info->id }}">{{ $info->mehsul }} ({{ $info->brand }}) Miqdar:
                                {{ $info->miqdar }}</option>
                        @endforeach
                    </select><br><br>

                    <input type="text" class="form-control" name="miqdar" placeholder="Miqdar" autocomplete="off"
                        required><br><br>
                    <input type="hidden" name="d">
                    <button type="submit" class="btn btn-primary btn-sm insert" name="d">Daxil et</button>

                </form>
            </div>
        </div>
    @endempty
    <br>


    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Sifarişlər </h4>
            <div class="table-responsive">
                <table class="table">
                    <thead>

                        <tr>
                            <th>
                                <div class="form-check form-check-muted m-0">
                                    <label class="form-check-label">
                                        <input type="checkbox" id="chkCheckAll" class="form-check-input">
                                        <i class="input-helper"></i>
                                    </label>
                                </div>
                            </th>
                            <th>Müştəri</th>
                            <th>Brend</th>
                            <th>Məhsul</th>
                            <th>Alış</th>
                            <th>Satış</th>
                            <th>Miqdar</th>
                            <th>Sifariş sayı</th>
                            <th>Ümumi Qazanc</th>
                            <th>Cari Qazanc</th>
                            <th>Tarix</th>

                            <th>
                                <a href="#" class="btn btn-danger" id="deleteAllSelectedrecord"> Seçimləri Sil</a>
                            </th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cdata as $i => $cinfo)
                            <tr id="sid{{ $cinfo->orders_id }}">
                                <td>
                                    <div class="form-check form-check-muted m-0">
                                        <label class="form-check-label">
                                            <input type="checkbox" name="ids" class="checkBoxClass"
                                                value="{{ $cinfo->orders_id }}"
                                                class="form-check-input">{{ $i += 1 }}
                                            <i class="input-helper"></i></label>
                                    </div>
                                </td>
                                <td>{{ $cinfo->musteriad }} {{ $cinfo->musterisoyad }}</td>
                                <td>{{ $cinfo->brand }}</td>
                                <td>{{ $cinfo->mehsul }}</td>
                                <td>{{ number_format($cinfo->alis, 2, '.', '') }}</td>
                                <td>{{ number_format($cinfo->satis, 2, '.', '') }}</td>
                                <td>{{ $cinfo->mehsulsayi }}</td>
                                <td>{{ $cinfo->sifarissayi }}</td>


                                <td>{{ number_format(($cinfo->satis - $cinfo->alis) * $cinfo->mehsulsayi + $cinfo->cqazanc, 2, '.', '') }}
                                </td>
                                <td>{{ number_format($cinfo->cqazanc, 2, '.', '') }} </td>



                                <td>{{ $cinfo->tarix }}</td>

                                @if ($cinfo->tesdiq == 0)
                                    <td>
                                        <form method="post" action="{{ route('orders.tesdiq') }}">
                                            <a href="{{ route('orders.edit', ['id' => $cinfo->orders_id]) }}"><button
                                                    type="button" class="btn btn-primary btn-sm "><i
                                                        class="mdi mdi-border-color lg"></i></button></a>

                                            <a href="{{ route('orders.sil', ['id' => $cinfo->orders_id]) }}"><button
                                                    type="button" class="btn btn-danger btn-sm "><i
                                                        class="mdi mdi-delete"></i></button></a>



                                            @csrf
                                            <input type="hidden" name="smiqdar" value="{{ $cinfo->sifarissayi }}">
                                            <input type="hidden" name="pmiqdar" value="{{ $cinfo->mehsulsayi }}">
                                            <input type="hidden" name="satis" value="{{ $cinfo->satis }}">
                                            <input type="hidden" name="alis" value="{{ $cinfo->alis }}">
                                            <input type="hidden" name="pid" value="{{ $cinfo->pid }}">
                                            <input type="hidden" name="id" value="{{ $cinfo->orders_id }}">

                                            <button type="submit" class="btn btn-primary btn-sm"><i
                                                    class="mdi mdi-check"></i></button>

                                        </form>
                                    @else
                                        <form method="post" action="{{ route('orders.legv') }}">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $cinfo->orders_id }}">
                                            <input type="hidden" name="smiqdar" value="{{ $cinfo->sifarissayi }}">
                                            <input type="hidden" name="pmiqdar" value="{{ $cinfo->mehsulsayi }}">
                                            <input type="hidden" name="satis" value="{{ $cinfo->satis }}">
                                            <input type="hidden" name="alis" value="{{ $cinfo->alis }}">
                                            <input type="hidden" name="pid" value="{{ $cinfo->pid }}">
                                    <td>
                                        <button type="submit" class="btn btn-danger btn-sm"><i
                                                class="mdi mdi-close"></i></button>
                                    </td>
                                    </form>
                                @endif

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>



    <script>
        $(function(e) {
            $("#chkCheckAll").click(function() {
                $(".checkBoxClass").prop('checked', $(this).prop('checked'));
            });

            $("#deleteAllSelectedrecord").click(function(e) {
                e.preventDefault();
                var allids = [];

                $("input:checkbox[name=ids]:checked").each(function() {
                    allids.push($(this).val());
                });

                $.ajax({
                    url: "{{ route('orders.secsil') }}",
                    type: "DELETE",
                    data: {
                        _token: $("input[name=_token]").val(),
                        ids: allids
                    },
                    success: function(response) {
                        $.each(allids, function(key, val) {
                            $("#sid" + val).remove();
                            $('#netice').html(response);
                        })
                    }
                });
            })
        });
    </script>
@endsection
