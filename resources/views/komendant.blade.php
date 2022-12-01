@extends('layouts.app')
@section('title')
    Komendant
@endsection


@section('axtar')
    <!--SEARCH SYSTEMM SART-->
    <div class="col-auto">
        <form class="nav-link mt-2 mt-md-0 d-none d-lg-flex search" type="get" action="{{ url('/searchkomendant') }}">
            @csrf
            <input type="search" name="query" class="form-control" placeholder="Search @yield('title')">
            <button class="btn btn-primary btn-sm " type="submit"><i class="mdi mdi-magnify"></i></button>

        </form>
    </div>
    <!--SEARCH SYSTEMM END-->
@endsection

@section('komendant')
    @php
        $deaktiv = 0;
        $san = 0;
        $aktiv = 0;
        foreach ($dataa as $info) {
            $san = strtotime($info->tarix . ' ' . $info->saat) - time() < 0;
            $san++;
            $deaktiv = $deaktiv + $san;
            $aktiv = $toplam - $deaktiv;
        }
    @endphp
    <div class="row">
        <div class="col-md-3">
            <div class="alert alert-success">
                Toplam tapşırıq: {{ $toplam }} | Aktiv tapşırıq:{{ $aktiv }}| Bitmiş tapşırıq:
                {{ $deaktiv }}
            </div>
        </div>
    </div>
    <h1>Görüləsi işlər</h1><br>
    <div id="netice"></div>

    @if (Session::has('task_add'))
        <script>
            swal("ƏLA", "{!! Session::get('task_add') !!}", "success");
        </script>
    @endif
    @if (Session::has('task_update'))
        <script>
            swal("ƏLA", "{!! Session::get('task_update') !!}", "success");
        </script>
    @endif
    @if (Session::has('task_sil'))
        <script>
            swal("ƏLA", "{!! Session::get('task_sil') !!}", "success");
        </script>
    @endif

    @isset($sildata)
        <span class="alert alert-success">Tapşırığı Silməyə əminsinizmi?</span><br><br>
        <a href="{{ route('komendant.delete', $sildata->id) }}"><button type="button"
                class="btn btn-primary btn-sm ">Bəli</button></a>
        <a href="{{ route('komendant') }}"><button type="button" class="btn btn-danger btn-sm ">Xeyr</button></a><br><br>
    @endisset

    @isset($edit)
        <div class="card">
            <div class="card-body">
                <form method="post" action="{{ route('komendant.update') }}">
                    <input type="hidden" name="id" value="{{ $edit->id }}">
                    @csrf
                    <b>Tapşırıq:</b><br>
                    <input type="text" class="form-control" value="{{ $edit->tapsiriq }}" name="task"><br>
                    <b>Tarix:</b><br>
                    <input type="date" class="form-control" value="{{ $edit->tarix }}" name="tarix"><br>
                    <b>Saat:</b><br>
                    <input type="time" class="form-control" value="{{ $edit->saat }}" name="saat"><br><br>
                    <button type="submit" class="btn btn-success btn-sm">Yenilə</button>
                </form>
            </div>
        </div>
    @endisset

    @empty($edit)
        <div class="card">
            <div class="card-body">
                <form method="post" action="{{ route('komendant.store') }}">
                    @csrf
                    <b>Tapşırıq:</b><br>
                    <input type="text" class="form-control" name="task"><br>
                    <b>Tarix:</b><br>
                    <input type="date" class="form-control" name="tarix"><br>
                    <b>Saat:</b><br>
                    <input type="time" class="form-control" name="saat"><br><br>
                    <button type="submit" class="btn btn-success btn-sm">Daxil et</button>
                </form>
            </div>
        </div>
    @endempty
    <br>


    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Komandan</h4>
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
                            <th> Tapşırıq </th>
                            <th> Tarix </th>
                            <th> Saat </th>
                            <th> Qalıq </th>
                            <th> Yaradıldı </th>
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

                                <td>{{ $info->tapsiriq }}</td>
                                <td>{{ $info->tarix }}</td>
                                <td>{{ $info->saat }}</td>
                                <td>
                                    @php
                                        $t1 = strtotime($info->tarix . ' ' . $info->saat);
                                        $t2 = time();
                                        $san = $t1 - $t2;
                                        $deq = round($san / 60);
                                        $saat = round($deq / 60);
                                        $gun = round($saat / 24);
                                        
                                        if ($gun != 0) {
                                            $goster = $gun . ' Gün';
                                        } else {
                                            $goster = $saat . ' Saat';
                                        }
                                        
                                        if ($deq > 0) {
                                            if ($saat <= 1 && $deq < 60) {
                                                $goster = $deq . ' Dəqiqə';
                                            }
                                        } else {
                                            $goster = 'Bitib';
                                        }
                                        
                                    @endphp
                                    {{ $goster }}
                                </td>
                                <td>{{ $info->created_at }}</td>
                                <td>
                                    <a href="{{ route('komendant.edit', $info->id) }}"><button type="button"
                                            class="btn btn-primary btn-sm "><i
                                                class="mdi mdi-border-color lg"></i></button></a>

                                    <a href="{{ route('komendant.sil', $info->id) }}"><button type="button"
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
                    url: "{{ route('komendant.secsil') }}",
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
