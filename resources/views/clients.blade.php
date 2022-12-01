@extends('layouts.app')
@section('title')
    Clients
@endsection



@section('axtar')
    <!--SEARCH SYSTEMM START-->
    <div class="col-auto">
        <form class="nav-link mt-2 mt-md-0 d-none d-lg-flex search" type="get" action="{{ url('/searchclients') }}">
            @csrf
            <input type="search" name="query" class="form-control" placeholder="Search @yield('title')">
            <button class="btn btn-primary btn-sm " type="submit"><i class="mdi mdi-magnify"></i></button>

        </form>
    </div>
    <!--SEARCH SYSTEMM END-->
@endsection



<!--MESSAGES SYSTEMM START-->
@section('clients')
    <h1>Müştərilər</h1><br>
    <div id="netice"></div>
    @if (Session::has('client_add'))
        <script>
            swal("ƏLA!!", "{!! Session::get('client_add') !!}", "success");
        </script>
    @endif

    @if (Session::has('client_movcud'))
        <script>
            swal("Zəhmət olmasa yenidən cəhd edin!!", "{!! Session::get('client_movcud') !!}", "warning");
        </script>
    @endif

    @if (Session::has('client_edit'))
        <script>
            swal("ƏLA!!", "{!! Session::get('client_edit') !!}", "success");
        </script>
    @endif

    @if (Session::has('client_sil'))
        <script>
            swal("ƏLA!!", "{!! Session::get('client_sil') !!}", "success");
        </script>
    @endif

    @if (Session::has('client_aktiv'))
        <script>
            swal("Silinmə mümkün olmadı!!", "{!! Session::get('client_aktiv') !!}", "error");
        </script>
    @endif

    @if ($errors->any())
        @foreach ($errors->all() as $info)
            <script>
                swal("Zəhmət olmasa yenidən cəhd edin!!", "{{ $info }}", "error");
            </script>
            <br>
        @endforeach
    @endif

    @isset($sildata)
        <span class="alert alert-success">Müştərini Silməyə əminsinizmi?</span><br><br>
        <a href="{{ route('clients.delete', $sildata->id) }}"><button type="button"
                class="btn btn-primary btn-sm ">Bəli</button></a>
        <a href="{{ route('clients') }}"><button type="button" class="btn btn-danger btn-sm ">Xeyr</button></a><br><br>
    @endisset

    @isset($post)
        <form method="post" enctype="multipart/form-data" action="{{ route('clients.update') }}">
            @csrf
            <div class="card">

                <div class="card-body">
                    <div class="form-group">
                        <label>Ad</label><br>
                        <input type="hidden" name="id" value="{{ $post->id }}">
                        <input type="text" name="ad" class="form-control" value="{{ $post->ad }}" required>
                    </div>
                    <div class="form-group">
                        <label>Soyad</label><br>
                        <input type="text" name="soyad" class="form-control" value="{{ $post->soyad }}" required>
                    </div>
                    <div class="form-group">
                        <label>Tel</label><br>
                        <input type="text" name="tel" class="form-control" value="{{ $post->tel }}" required>
                    </div>
                    <div class="form-group">
                        <label>Şirkət</label><br>
                        <input type="text" name="sirket" class="form-control" value="{{ $post->sirket }}" required>
                    </div>
                    <div class="form-group">
                        <label>E-mail</label><br>
                        <input type="text" name="email" class="form-control" value="{{ $post->email }}" required>
                    </div>
                    <div class="form-group">
                        <label>Şəkil</label><br>
                        <img style="width:65px; height:56px" src="{{ URL::to('uploads\brands', $post->foto) }}"><br>
                        <input type="file" name="foto" class="form-control" id="customFile">
                        <input type="hidden" name="carifoto" class="form-control" id="customFile" value="{{ $post->foto }}">
                        <br><button type="submit" class="btn btn-primary btn-sm">yenile</button>
                        <a href="{{ route('clients') }}"><button type="button"
                                class="btn btn-danger btn-sm ">Imtina</button></a>
                    </div>
                </div>

            </div>
        </form><br><br>
    @endisset

    @empty($post)
        <form method="post" enctype="multipart/form-data" action="{{ route('clients.gonder') }}">
            @csrf
            <div class="card">

                <div class="card-body">
                    <div class="form-group">
                        <label>Ad</label><br>
                        <input type="text" name="ad" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Soyad</label><br>
                        <input type="text" name="soyad" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Tel</label><br>
                        <input type="text" name="tel" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Şirkət</label><br>
                        <input type="text" name="sirket" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>E-mail</label><br>
                        <input type="text" name="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Şəkil</label><br>
                        <input type="file" name="foto" class="form-control" id="customFile" /><br>
                    </div>
                </div>
                <div class="card-footer">
                    <br><button type="submit" class="btn btn-primary btn-sm insert" name="daxilet">Daxil et</button>
                </div>
            </div>
        </form>
    @endempty
    <br>

    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Müştərilər</h4>
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
                            <th> Ad-Soyad </th>
                            <th>Telefon</th>
                            <th>Şirkət</th>
                            <th>E-mail</th>
                            <th>Tarix</th>

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
                                <td>{{ $info->ad }} {{ $info->soyad }}</td>
                                <td>{{ $info->tel }}</td>
                                <td>{{ $info->sirket }}</td>
                                <td>{{ $info->email }}</td>
                                <td>{{ $info->created_at }}</td>
                                <td>
                                    <a href="{{ route('clients.edit', ['id' => $info->id]) }}"><button type="button"
                                            class="btn btn-primary btn-sm "><i
                                                class="mdi mdi-border-color lg"></i></button></i></a>
                                    <a href="{{ route('clients.sil', ['id' => $info->id]) }}"><button type="button"
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
                    url: "{{ route('clients.secsil') }}",
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
