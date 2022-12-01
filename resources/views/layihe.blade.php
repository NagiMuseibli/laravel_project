@extends('layouts.app')
@section('title')
    layihe
@endsection

@section('axtar')
    <!--SEARCH SYSTEMM SART-->
    <div class="col-auto">
        <form class="nav-link mt-2 mt-md-0 d-none d-lg-flex search" type="get" action="{{ url('/searchlayihe') }}">
            @csrf
            <input type="search" name="query" class="form-control" placeholder="Search @yield('title')">
            <button class="btn btn-primary btn-sm " type="submit"><i class="mdi mdi-magnify"></i></button>

        </form>
    </div>
    <!--SEARCH SYSTEMM END-->
@endsection

@section('layihe')
    <h1>Layihələr</h1><br>

    @if (Session::has('layihe_add'))
        <script>
            swal("ƏLA", "{!! Session::get('layihe_add') !!}", "success");
        </script>
    @endif

    @if (Session::has('layihe_update'))
        <script>
            swal("ƏLA", "{!! Session::get('layihe_update') !!}", "success");
        </script>
    @endif
    @if (Session::has('layihe_sil'))
        <script>
            swal("ƏLA", "{!! Session::get('layihe_sil') !!}", "success");
        </script>
    @endif

    @isset($sildata)
        <span class="alert alert-success">Tapşırığı Silməyə əminsinizmi?</span><br><br>
        <a href="{{ route('layihe.delete', $sildata->id) }}"><button type="button"
                class="btn btn-primary btn-sm ">Bəli</button></a>
        <a href="{{ route('layihe') }}"><button type="button" class="btn btn-danger btn-sm ">Xeyr</button></a><br><br>
    @endisset
    @isset($edit)
        <div class="card">
            <div class="card-body">
                <form method="post" action="{{ route('layihe.update') }}">
                    <input type="hidden" name="id" value="{{ $edit->id }}">
                    @csrf
                    <b>Tapşırıq:</b><br>
                    <input type="text" class="form-control" name="task" value="{{ $edit->tapsiriq }}"><br>
                    <b>Başlanğıc tarix:</b><br>
                    <input type="date" class="form-control" name="bastarix" value="{{ $edit->bastarix }}"><br>
                    <b>Başlanğıc Saat:</b><br>
                    <input type="time" class="form-control" name="bassaat" value="{{ $edit->bassaat }}"><br>
                    <b>Bitmə tarixi:</b><br>
                    <input type="date" class="form-control" name="bittarix" value="{{ $edit->bittarix }}"><br>
                    <b>Bitmə Saatı:</b><br>
                    <input type="time" class="form-control" name="bitsaat" value="{{ $edit->bitsaat }}"><br><br>
                    <button type="submit" class="btn btn-primary btn-sm">Yenilə</button>
                </form>
            </div>
        </div>
    @endisset

    @empty($edit)
        <div class="card">
            <div class="card-body">
                <form method="post" action="{{ route('layihe.store') }}">
                    @csrf
                    <b>Tapşırıq:</b><br>
                    <input type="text" class="form-control" name="task"><br>

                    <b>Başlanğıc tarix:</b><br>
                    <input type="date" class="form-control" name="bastarix"><br>
                    <b>Başlanğıc Saat:</b><br>
                    <input type="time" class="form-control" name="bassaat"><br>
                    <b>Bitmə tarixi:</b><br>
                    <input type="date" class="form-control" name="bittarix"><br>
                    <b>Bitmə Saatı:</b><br>
                    <input type="time" class="form-control" name="bitsaat"><br><br>
                    <button type="submit" class="btn btn-success btn-sm">Daxil et</button>
                </form>
            </div>
        </div>
    @endempty
    <br>


    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Layihə</h4>
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
                            <th> Başlanğıc Tarix </th>
                            <th> Başlanğıc Saat </th>
                            <th> Bitmə Tarix </th>
                            <th> Bitmə Saatı </th>
                            <th> Qalıq </th>
                            <th> Yaradıldı </th>
                            <th>
                                <a href="#" class="btn btn-danger" id="deleteAllSelectedrecord"> Seçimləri Sil</a>

                            </th>
                        </tr>

                    </thead>
                    <tbody>
                        @foreach ($data as $info)
                            <tr id="sid">
                                <td>
                                    <div class="form-check form-check-muted m-0">
                                        <label class="form-check-label">
                                            <input type="checkbox" name="ids" class="checkBoxClass" value=""
                                                class="form-check-input">
                                            <i class="input-helper"></i></label>
                                    </div>
                                </td>

                                <td>{{ $info->tapsiriq }}</td>
                                <td>{{ $info->bastarix }}</td>
                                <td>{{ $info->bassaat }}</td>
                                <td>{{ $info->bittarix }}</td>
                                <td>{{ $info->bitsaat }}</td>
                                <td>
                                    @php
                                        $t1 = strtotime($info->bastarix . ' ' . $info->bassaat);
                                        $t2 = strtotime($info->bittarix . ' ' . $info->bitsaat);
                                        $san = $t2 - $t1;
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
                                    <a href="{{ route('layihe.edit', $info->id) }}"><button type="button"
                                            class="btn btn-primary btn-sm "><i
                                                class="mdi mdi-border-color lg"></i></button></a>

                                    <a href="{{ route('layihe.sil', $info->id) }}"><button type="button"
                                            class="btn btn-danger btn-sm "><i class="mdi mdi-delete"></i></button></a>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
@endsection
