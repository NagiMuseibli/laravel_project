@extends('layouts.app')
@section('title')
    Brands
@endsection


@section('axtar')
    <!--SEARCH SYSTEMM SART-->
    <div class="col-auto">
        <form class="nav-link mt-2 mt-md-0 d-none d-lg-flex search" type="get" action="{{ url('/searchbrands') }}">
            @csrf
            <input type="search" name="query" class="form-control" placeholder="Search @yield('title')">
            <button class="btn btn-primary btn-sm " type="submit"><i class="mdi mdi-magnify"></i></button>

        </form>
    </div>
    <!--SEARCH SYSTEMM END-->
@endsection



<!--- MESSAGES START -->
@section('brands')
    <h1>Brendlər</h1><br>
    <div id="netice"></div>


    @if (Session::has('brand_add'))
        <script>
            swal("ƏLA", "{!! Session::get('brand_add') !!}", "success");
        </script>
    @endif

    @if (Session::has('brand_movcud'))
        <script>
            swal("Yenidən cəhd edin", "{!! Session::get('brand_movcud') !!}", "warning");
        </script>
    @endif

    @if (Session::has('brand_update'))
        <script>
            swal("ƏLA", "{!! Session::get('brand_update') !!}", "success");
        </script>
    @endif

    @if (Session::has('brandsil_danger'))
        <script>
            swal("Oops!!", "{!! Session::get('brandsil_danger') !!}", "error");
        </script>
    @endif

    @if (Session::has('brand_sil'))
        <script>
            swal("ƏLA", "{!! Session::get('brand_sil') !!}", "success");
        </script>
    @endif
    <!--- MESSAGES END -->

    @if ($errors->any())
        @foreach ($errors->all() as $info)
            <script>
                swal("Zəhmət olmasa yenidən cəhd edin!!", "{{ $info }}", "error");
            </script>
        @endforeach
    @endif


    @isset($sildata)
        <span class="alert alert-success">Brendi Silməyə əminsinizmi?</span><br><br>
        <a href="{{ route('brands.delete', $sildata->id) }}"><button type="button"
                class="btn btn-primary btn-sm ">Bəli</button></a>
        <a href="{{ route('index') }}"><button type="button" class="btn btn-danger btn-sm ">Xeyr</button></a><br><br>
    @endisset



    @isset($post)
        <div class="card">
            <div class="card-body">
                <form method="post" enctype="multipart/form-data" action="{{ route('brands.update') }}">
                    @csrf
                    Brendin adı:<br>
                    <input type="hidden" name="id" value="{{ $post->id }}">
                    <input type="text" name="ad" style="color: #FFF;" class="form-control"
                        value="{{ $post->ad }}"><br>
                    Loqo:<br>
                    <img style="width:65px; height:56px" src="{{ URL::to('uploads\brands', $post->foto) }}"><br>
                    <input type="file" name="foto" class="form-control"><br>
                    <input type="hidden" name="carifoto" value="{{ $post->foto }}">
                    <button type="submit" name="d" class="btn btn-primary btn-sm ">Yenile</button>
                    <a href="{{ route('index') }}"><button type="button" class="btn btn-danger btn-sm ">Imtina</button></a>
                </form>
            </div>
        </div>
    @endisset


    @empty($post)
        <div class="card">

            <div class="card-body">
                <form method="post" enctype="multipart/form-data" action="{{ route('brands.gonder') }}">
                    @csrf

                    <input type="text" name="ad" class="form-control" placeholder="Brendin adı" required><br>

                    <input type="file" name="foto" class="form-control"><br><br>
                    <input type="hidden" name="d">
                    <button type="submit" name="d" class="btn btn-primary btn-sm insert">Daxil et</button>
                </form>
            </div>
        </div>
    @endempty
    <br>



    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Brendlər</h4>
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
                                <td>{{ $info->ad }}</td>
                                <td>{{ $info->created_at }}</td>
                                <td>
                                    <a href="{{ route('brands.edit', ['id' => $info->id]) }}"><button type="button"
                                            class="btn btn-primary btn-sm "><i
                                                class="mdi mdi-border-color lg"></i></button></a>

                                    <a href="{{ route('brands.sil', ['id' => $info->id]) }}"><button type="button"
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
                    url: "{{ route('brands.secsil') }}",
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
