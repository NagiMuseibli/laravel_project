@extends('layouts.app')
@section('title')
    Products
@endsection


@section('axtar')
    <!--SEARCH SYSTEMM SART-->
    <div class="col-auto">
        <form class="nav-link mt-2 mt-md-0 d-none d-lg-flex search" type="get" action="{{ url('/searchproducts') }}">
            @csrf
            <input type="search" name="query" class="form-control" placeholder="Search @yield('title')">
            <button class="btn btn-primary btn-sm " type="submit"><i class="mdi mdi-magnify"></i></button>

        </form>
    </div>
    <!--SEARCH SYSTEMM END-->
@endsection




<!--MESSAGES SYSTEMM START-->
@section('products')
    <h1>Məhsullar</h1><br>
    <div id="netice"></div>
    @if (Session::has('product_add'))
        <script>
            swal("ƏLA!!", "{!! Session::get('product_add') !!}", "success");
        </script>
    @endif

    @if (Session::has('productd_add_info_min'))
        <script>
            swal("Yenidən cəhd edin!!", "{!! Session::get('productd_add_info_min') !!}", "warning");
        </script>
    @endif

    @if (Session::has('productd_add_info_sat_al'))
        <script>
            swal("Yenidən cəhd edin!!", "{!! Session::get('productd_add_info_sat_al') !!}", "warning");
        </script>
    @endif

    @if (Session::has('product_edit'))
        <script>
            swal("Əla!!", "{!! Session::get('product_edit') !!}", "success");
        </script>
    @endif

    @if (Session::has('product_sil'))
        <script>
            swal("Əla!!", "{!! Session::get('product_sil') !!}", "success");
        </script>
    @endif

    @if (Session::has('product_sil_error'))
        <script>
            swal("Silinmə mümkün olmadı!!", "{!! Session::get('product_sil_error') !!}", "error");
        </script>
    @endif

    @if ($errors->any())
        @foreach ($errors->all() as $info)
            <script>
                swal("Zəhmət olmasa yenidən cəhd edin!!", "{{ $info }}", "error");
            </script>
        @endforeach
    @endif
    <br><br>
    <!--MESSAGES SYSTEMM END-->


    @isset($editdata)
        <div class="card">
            <div class="card-body">
                <form method="post" enctype="multipart/form-data" action="{{ route('products.update') }}">

                    @csrf
                    Brendin adı:<br>

                    <select class="form-control" name="brand_id">
                        @foreach ($data as $product)
                            <option value="">{{ $product->brand }}</option>;
                            <option value="{{ $product->brand_id }}">{{ $product->brand }}</option>
                        @endforeach
                        <input type="hidden" name="bid" value="{{ $product->brand_id }}">
                    </select><br>
                    Mehsul
                    <input type="hidden" name="id" value="{{ $editdata->id }}">
                    <input type="text" class="form-control" name="ad" value="{{ $product->mehsul }}"><br>
                    Alis
                    <input type="text" class="form-control" name="alis" value="{{ $product->alis }}"><br>
                    Satis
                    <input type="text" class="form-control" name="satis" value="{{ $product->satis }}"><br>
                    Miqdar
                    <input type="text" class="form-control" name="miqdar" value="{{ $product->miqdar }}"><br>
                    <br>
                    Loqo:<br>
                    <img style="width:65px; height:56px" src="{{ URL::to('uploads\brands', $product->foto) }}"><br>
                    <input type="file" name="foto" class="form-control" id="customFile" value=""><br>
                    <input type="hidden" name="carifoto" value="{{ $product->foto }}"><br>

                    <button type="submit" name="d" class="btn btn-primary btn-sm ">Yenile</button>
                    <a href="{{ route('products') }}"><button type="button" class="btn btn-danger btn-sm ">Imtina</button></a>
                </form>
            </div>
        </div>
    @endisset


    @isset($sildata)
        <span class="alert alert-success">Məhsulu Silməyə əminsinizmi?</span><br><br>
        <a href="{{ route('products.delete', $sildata->id) }}"><button type="button"
                class="btn btn-primary btn-sm ">Bəli</button></a>
        <a href="{{ route('products') }}"><button type="button" class="btn btn-danger btn-sm ">Xeyr</button></a><br><br>
    @endisset

    @empty($editdata)
        <div class="card">
            <div class="card-body">
                <form method="post" enctype="multipart/form-data" action="{{ route('products.gonder') }}">
                    @csrf



                    <select class="form-control" name="brand_id">
                        <option value="">Brend seçin</option>;
                        @foreach ($bdata as $info)
                            <option value="{{ $info->id }}">{{ $info->ad }}</option>
                        @endforeach
                    </select><br><br>
                    <input type="text" class="form-control" name="ad" placeholder="Ad" autocomplete="off" required><br>
                    <input type="text" class="form-control" name="alis" placeholder="Alış" autocomplete="off"
                        required><br>
                    <input type="text" class="form-control" name="satis" placeholder="Satış" autocomplete="off"
                        required><br>
                    <input type="text" class="form-control" name="miqdar" placeholder="Miqdar" autocomplete="off"
                        required><br>
                    <input type="file" name="foto" class="form-control"><br><br>

                    <button type="submit" class="btn btn-primary btn-sm insert" name="d">Daxil et</button>
                </form>
            </div>
        </div>
    @endempty
    <br>
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Məhsullar</h4>
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
                            <th> Foto </th>
                            <th> Brend </th>
                            <th> Mehsul </th>
                            <th> Alis </th>
                            <th> Satis </th>
                            <th> Miqdar </th>
                            <th> Tarix </th>
                            <th>
                                <a href="#" class="btn btn-danger" id="deleteAllSelectedrecord"> Seçimləri Sil</a>
                            </th>



                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $i => $info)
                            <tr id="sid{{ $info->id }}">
                                <td>
                                    <div class="form-check form-check-muted m-0">
                                        <label class="form-check-label">
                                            <input type="checkbox" name="ids" class="checkBoxClass"
                                                value="{{ $info->id }}" class="form-check-input">{{ $i += 1 }}
                                            <i class="input-helper"></i></label>
                                    </div>
                                </td>
                                <td>
                                    <img style="width:65px; height:56px"
                                        src="{{ URL::to('uploads\brands', $info->foto) }}">

                                </td>
                                <td>{{ $info->brand }}</td>
                                <td>{{ $info->mehsul }}</td>
                                <td>{{ $info->alis }}</td>
                                <td>{{ $info->satis }}</td>
                                <td>{{ $info->miqdar }}</td>
                                <td>{{ $info->tarix }}</td>
                                <td>
                                    <a href="{{ route('products.edit', ['id' => $info->id]) }}"><button type="button"
                                            class="btn btn-primary btn-sm "><i
                                                class="mdi mdi-border-color lg"></i></button></i></a>

                                    <a href="{{ route('products.sil', ['id' => $info->id]) }}"><button type="button"
                                            class="btn btn-danger btn-sm "><i class="mdi mdi-delete"></i></button></a>
                                </td>

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
                    url: "{{ route('products.secsil') }}",
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
