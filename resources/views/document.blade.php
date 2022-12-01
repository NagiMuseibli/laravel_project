@extends('layouts.app')
@section('title')
    Document
@endsection


@section('axtar')
    <!--SEARCH SYSTEMM SART-->
    <div class="col-auto">
        <form class="nav-link mt-2 mt-md-0 d-none d-lg-flex search" type="get" action="{{ url('/searchsdocument') }}">
            @csrf
            <input type="search" name="query" class="form-control" placeholder="Search @yield('title')">
            <button class="btn btn-primary btn-sm " type="submit"><i class="mdi mdi-magnify"></i></button>

        </form>
    </div>
    <!--SEARCH SYSTEMM END-->
@endsection

@section('document')
    <h1>Document

        @php
            if (isset($edit) or isset($sildata)) {
                foreach ($data as $info) {
                    $ad = $info->ad;
                    $soyad = $info->soyad;
                }
            } else {
                $ad = $name->ad;
                $soyad = $name->soyad;
            }
            
        @endphp
        <div class="row">
            <div class="col-md-3">
                <div class="alert alert-success">
                    {{ $ad }} {{ $soyad }}
                </div>
            </div>
        </div>
    </h1><br>
    <div id="netice"></div>
    @if (Session::has('document_add'))
        <script>
            swal("ƏLA", "{!! Session::get('document_add') !!}", "success");
        </script>
    @endif

    @if (Session::has('docuument_sil'))
        <script>
            swal("ƏLA", "{!! Session::get('docuument_sil') !!}", "success");
        </script>
    @endif

    @isset($sildata)
        <span class="alert alert-success">Documenti Silməyə əminsinizmi?</span><br><br>
        <a href="{{ route('document.delete', $sildata->id) }}"><button type="button"
                class="btn btn-primary btn-sm ">Bəli</button></a>
        <a href="{{ route('document', $sildata->staff_id) }}"><button type="button"
                class="btn btn-danger btn-sm ">Xeyr</button></a><br><br>
    @endisset

    @if ($errors->any())
        @foreach ($errors->all() as $info)
            <script>
                swal("Zəhmət olmasa yenidən cəhd edin!!", "{{ $info }}", "error");
            </script>
        @endforeach
    @endif

    @isset($edit)
        <form method="post" enctype="multipart/form-data" action="{{ route('document.update') }}">
            @csrf
            <input type="hidden" name="staff_id" value="{{ $edit->staff_id }}">
            <input type="hidden" name="document_id" value="{{ $edit->id }}">
            <div class="card">

                <div class="card-body">
                    <div class="form-group">
                        <label>Title</label><br>
                        <input type="text" name="title" value="{{ $edit->title }}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Scan</label><br>
                        <input type="hidden" name="carifoto" value="{{ $edit->scan }}">
                        <input type="file" name="scan" class="form-control" value="" id="customFile">
                        <img style="width:65px; height:56px" src="{{ URL::to('uploads\brands', $edit->scan) }}"><br>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary btn-sm insert" name="daxilet">Yenilə</button>

                </div>
            </div>
        </form>
    @endisset


    @empty($edit)
        <form method="post" enctype="multipart/form-data" action="{{ route('document.gonder') }}">
            @csrf
            <input type="hidden" name="staff_id" value="{{ $id }}">
            <div class="card">

                <div class="card-body">
                    <div class="form-group">
                        <label>Title</label><br>
                        <input type="text" name="title" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Scan</label><br>
                        <input type="file" name="scan" class="form-control" id="customFile">
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary btn-sm insert" name="daxilet">Daxil et</button>

                </div>
            </div>
        </form>
    @endempty
    <br>




    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Staff </h4>
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
                            <th>Foto</th>
                            <th>E-mail</th>
                            <th>Title</th>
                            <th>Tarix</th>


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
                                <td>
                                    <div class="pic">
                                        <img style="width:130px; height:110px"
                                            src="{{ URL::to('uploads\brands', $info->scan) }}">
                                    </div>
                                </td>
                                <td>{{ $info->email }}</td>
                                <td>{{ $info->title }}</td>
                                <td>{{ $info->tarix }}</td>
                                <td>

                                    <a href="{{ route('document.edit', $info->document_id) }}"><button type="button"
                                            class="btn btn-primary btn-sm "><i
                                                class="mdi mdi-border-color lg"></i></button></a>
                                    <a href="{{ route('document.sil', $info->document_id) }}"><button type="button"
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
