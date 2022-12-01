@extends('layouts.app')
@section('title')
    Staff
@endsection


@section('axtar')
    <!--SEARCH SYSTEMM SART-->
    <div class="col-auto">
        <form class="nav-link mt-2 mt-md-0 d-none d-lg-flex search" type="get" action="{{ url('/searchstaff') }}">
            @csrf
            <input type="search" name="query" class="form-control" placeholder="Search @yield('title')">
            <button class="btn btn-primary btn-sm " type="submit"><i class="mdi mdi-magnify"></i></button>

        </form>
    </div>
    <!--SEARCH SYSTEMM END-->
@endsection

@section('staff')
    <h1>Staff</h1><br>

    <div id="netice"></div>

    <!--MESSAGES SYSTEMM START-->
    @if (Session::has('staff_add'))
        <script>
            swal("ƏLA!!", "{!! Session::get('staff_add') !!}", "success");
        </script>
    @endif

    @if (Session::has('staff_movcud'))
        <script>
            swal("Zəhmət olmasa yenidən cəhd edin!!", "{!! Session::get('staff_movcud') !!}", "warning");
        </script>
    @endif

    @if (Session::has('staff_edit'))
        <script>
            swal("ƏLA!!", "{!! Session::get('staff_edit') !!}", "success");
        </script>
    @endif

    @if (Session::has('staff_sil'))
        <script>
            swal("ƏLA!!", "{!! Session::get('staff_sil') !!}", "success");
        </script>
    @endif

    <!--MESSAGES SYSTEMM END-->

    @if ($errors->any())
        @foreach ($errors->all() as $info)
            <script>
                swal("Zəhmət olmasa yenidən cəhd edin!!", "{{ $info }}", "error");
            </script>
        @endforeach

    @endif

    @isset($sildata)
        <span class="alert alert-success">Məlumatı Silməyə əminsinizmi?</span><br><br>
        <a href="{{ route('staff.delete', $sildata->id) }}"><button type="button"
                class="btn btn-primary btn-sm ">Bəli</button></a>
        <a href="{{ route('staff') }}"><button type="button" class="btn btn-danger btn-sm ">Xeyr</button></a><br><br>
    @endisset


    @isset($editdata)

        <form method="post" action="{{ route('staff.update') }}">
            @csrf
            <div class="card">

                <div class="card-body">
                    <div class="form-group">
                        <label>Ad</label><br>
                        <input type="text" name="ad" class="form-control" value="{{ $editdata->ad }}">
                    </div>
                    <div class="form-group">
                        <label>Soyad</label><br>
                        <input type="text" name="soyad" class="form-control" value="{{ $editdata->soyad }}">
                    </div>
                    <div class="form-group">
                        <label>Tel</label><br>
                        <input type="text" name="tel" class="form-control" value="{{ $editdata->tel }}">
                    </div>
                    <div class="form-group">
                        <label>E-Mail</label><br>
                        <input type="text" name="email" class="form-control" value="{{ $editdata->email }}">
                    </div>
                    <div class="form-group">
                        <label>Vəzifə</label><br>
                        <input type="text" name="vezife" class="form-control" value="{{ $editdata->vezife }}">
                    </div>
                    <div class="form-group">
                        <label>Maaş</label><br>
                        <input type="text" name="maash" class="form-control" value="{{ $editdata->maash }}">
                    </div>
                    <div class="form-group">
                        <label>Hired</label><br>
                        <input type="date" name="hired" class="form-control" value="{{ $editdata->hired }}">
                    </div>

                    <input type="hidden" name="id" value="{{ $editdata->id }}">

                </div>
                <div class="card-footer">
                    <br><button type="submit" class="btn btn-primary btn-sm insert" name="daxilet">yenilə</button>
                </div>
            </div>
        </form>


        @endif


        @empty($editdata)
            <form method="post" enctype="multipart/form-data" action="{{ route('staff.gonder') }}">
                @csrf
                <div class="card">

                    <div class="card-body">
                        <div class="form-group">
                            <label>Ad</label><br>
                            <input type="text" name="ad" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Soyad</label><br>
                            <input type="text" name="soyad" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Tel</label><br>
                            <input type="text" name="tel" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>E-Mail</label><br>
                            <input type="text" name="email" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Vəzifə</label><br>
                            <input type="text" name="vezife" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Maaş</label><br>
                            <input type="text" name="maash" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Hired</label><br>
                            <input type="date" name="hired" class="form-control">
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
                <h4 class="card-title">Staff</h4>
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

                                <th> Ad-Soyad </th>
                                <th>Telefon</th>
                                <th>E-mail</th>
                                <th>Vəzifə</th>
                                <th>Maaş</th>
                                <th>Hired</th>

                                <th>
                                    <a href="#" class="btn btn-danger" id="deleteAllSelectedrecord"> Seçimləri Sil</a>
                                </th>



                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $info)
                                <tr>
                                    <td>
                                        <div class="form-check form-check-muted m-0">
                                            <label class="form-check-label">
                                                <input type="checkbox" name="ids" class="checkBoxClass" value=""
                                                    class="form-check-input">
                                                <i class="input-helper"></i></label>
                                        </div>
                                    </td>
                                    <td>{{ $info->ad }} {{ $info->soyad }}</td>
                                    <td>{{ $info->tel }}</td>
                                    <td>{{ $info->email }}</td>
                                    <td>{{ $info->vezife }}</td>
                                    <td>{{ $info->maash }}</td>
                                    <td>{{ $info->hired }}</td>
                                    <td>
                                        <a href="{{ route('document', $info->id) }}"><button type="button"
                                                class="btn btn-primary btn-sm "><i
                                                    class="mdi mdi-file-document"></i></button></a>
                                        <a href="{{ route('staff.edit', ['id' => $info->id]) }}"><button type="button"
                                                class="btn btn-primary btn-sm "><i
                                                    class="mdi mdi-border-color lg"></i></button></a>
                                        <a href="{{ route('staff.sil', ['id' => $info->id]) }}"><button type="button"
                                                class="btn btn-danger btn-sm "><i class="mdi mdi-delete"></i></button></a>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endsection
