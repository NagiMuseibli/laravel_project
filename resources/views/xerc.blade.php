@extends('layouts.app')

@section('title')
    Xerc
@endsection


@section('axtar')
    <!--SEARCH SYSTEMM SART-->
    <div class="col-auto">
        <form class="nav-link mt-2 mt-md-0 d-none d-lg-flex search" type="get" action="{{ url('/searchxerc') }}">
            @csrf
            <input type="search" name="query" class="form-control" placeholder="Search @yield('title')">
            <button class="btn btn-primary btn-sm " type="submit"><i class="mdi mdi-magnify"></i></button>

        </form>
    </div>
    <!--SEARCH SYSTEMM END-->
@endsection




@section('xerc')
    <h1>Xərclər</h1><br>
    <div id="netice"></div>

    <!--MESSAGES SYSTEMM START-->
    @if (Session::has('xerc_add'))
        <script>
            swal("ƏLA!!", "{!! Session::get('xerc_add') !!}", "success");
        </script>
    @endif

    @if (Session::has('xerc_movcud'))
        <script>
            swal("Zəhmət olamsa yenidən cəhd edin!!", "{!! Session::get('xerc_movcud') !!}", "warning");
        </script>
    @endif

    @if (Session::has('xerc_warning'))
        <script>
            swal("Zəhmət olamsa yenidən cəhd edin!!", "{!! Session::get('xerc_warning') !!}", "warning");
        </script>
    @endif

    @if (Session::has('xerc_edit'))
        <script>
            swal("ƏLA!!", "{!! Session::get('xerc_edit') !!}", "success");
        </script>
    @endif

    @if (Session::has('xerc_sil'))
        <script>
            swal("ƏLA!!", "{!! Session::get('xerc_sil') !!}", "success");
        </script>
    @endif

    @if ($errors->any())
        @foreach ($errors->all() as $info)
            <script>
                swal("Zəhmət olmasa yenidən cəhd edin!!", "{{ $info }}", "error");
            </script>
        @endforeach
    @endif


    <!--MESSAGES SYSTEMM END-->


    @isset($sildata)
        <span class="alert alert-success">Xərci silməyə əminsinizmi?</span><br><br>
        <a href="{{ route('xerc.delete', $sildata->id) }}"><button type="button"
                class="btn btn-primary btn-sm ">Bəli</button></a>
        <a href="{{ route('xerc') }}"><button type="button" class="btn btn-danger btn-sm ">Xeyr</button></a><br><br>
    @endisset


    @isset($post)
        <form method="post" action="{{ route('xerc.update') }}">
            @csrf
            Teyinat<br>
            <input type="hidden" name="id" value="{{ $post->id }}">
            <input type="text" name="teyinat" class="form-control" value="{{ $post->teyinat }}"><br>
            Mebleg:<br>
            <input type="text" name="mebleg" class="form-control" value="{{ $post->mebleg }}"><br><br>
            <button type="submit" name="d" class="btn btn-primary btn-sm ">Yenile</button>
            <a href="{{ route('xerc') }}"><button type="button" class="btn btn-danger btn-sm ">Imtina</button></a>
        </form> <br><br>
    @endisset


    @empty($post)
        <div class="card">
            <div class="card-body">
                <form method="post" action="{{ route('gonder') }}">
                    @csrf
                    Teyinat<br>
                    <input type="text" class="form-control" name="teyinat" required><br>
                    Mebleg:<br>
                    <input type="text" class="form-control" name="mebleg" required><br><br>
                    <button type="submit" class="btn btn-primary btn-sm insert" name="d">Daxil et</button>
                </form>
            </div>
        </div>
    @endempty
    <br>
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Xərclər</h4>
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
                            <th> Təyinat </th>
                            <th> Məbləğ </th>
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
                                <td>{{ $info->teyinat }}</td>
                                <td>{{ $info->mebleg }}</td>
                                <td>{{ $info->created_at }}</td>
                                <td>
                                    <a href="{{ route('xerc.edit', ['id' => $info->id]) }}"><button type="button"
                                            class="btn btn-primary btn-sm "><i
                                                class="mdi mdi-border-color lg"></i></button></a>

                                    <a href="{{ route('xerc.sil', ['id' => $info->id]) }}"><button type="button"
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
                    url: "{{ route('xerc.secsil') }}",
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
