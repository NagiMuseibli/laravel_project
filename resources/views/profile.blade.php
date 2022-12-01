@extends('layouts.app')
@section('title')
    Profile
@endsection

@section('profile')
    <h1>Profil</h1><br>
    @if (Session::has('profile_edit'))
        <script>
            swal("ƏLA!!", "{!! Session::get('profile_edit') !!}", "success");
        </script>
    @endif

    @if (Session::has('profile_cari_error'))
        <script>
            swal("Zəhmət olmasa yenidən cəh edin!!", "{!! Session::get('profile_cari_error') !!}", "error");
        </script>
    @endif

    @if (Session::has('parol_dogrulama'))
        <script>
            swal("Zəhmət olmasa yenidən cəh edin!!", "{!! Session::get('parol_dogrulama') !!}", "error");
        </script>
    @endif

    @if ($errors->any())
        @foreach ($errors->all() as $info)
            <script>
                swal("Zəhmət olmasa yenidən cəhd edin!!", "{{ $info }}", "error");
            </script>
        @endforeach
    @endif
    <div class="card">

        <div class="card-body">
            <form method="post" enctype="multipart/form-data" action="{{ route('profile.update') }}">
                @csrf

                <input type="text" name="ad" class="form-control" value="{{ $user->name }}"><br>
                <input type="text" name="soyad" class="form-control" value="{{ $user->surname }}"><br>
                <input type="text" name="email" class="form-control" value="{{ $user->email }}"><br>
                <input type="text" name="tel" class="form-control" value="{{ $user->tel }}"><br>
                <input type="password" name="parol" class="form-control" placeholder="Parol:"><br>
                <input type="password" name="tparol" class="form-control" placeholder="Tparol:"><br>
                <input type="password" name="cariparol" class="form-control" placeholder="Cariparol:"><br>
                <input type="file" name="foto" class="form-control">
                <input type="hidden" name="carifoto" value="{{ $user->foto }}" class="form-control">
                <img style="width:65px; height:56px" src="{{ URL::to('uploads\brands', $user->foto) }}"><br><br>
                <button type="submit" name="d" class="btn btn-primary btn-sm insert">Yenilə</button>
            </form>
        </div>
    </div>
@endsection
