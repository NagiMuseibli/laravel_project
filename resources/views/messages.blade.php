@extends('layouts.app')
@section('title')
    Mesajlar
@endsection


@section('axtar')
    <!--SEARCH SYSTEMM SART-->
    <div class="col-auto">
        <form class="nav-link mt-2 mt-md-0 d-none d-lg-flex search" type="get" action="{{ url('/searchmessage') }}">
            @csrf
            <input type="search" name="query" class="form-control" placeholder="Search @yield('title')">
            <button class="btn btn-primary btn-sm " type="submit"><i class="mdi mdi-magnify"></i></button>

        </form>
    </div>
    <!--SEARCH SYSTEMM END-->
@endsection

@section('messages')
    <h1>Mesajlar</h1><br>
    <div id="netice"></div>

    @isset($sildata)
        Melumati silmeye eminsinizmi?<br><br>
        <a href="{{ route('message.delete', $sildata->id) }}"><button type="button"
                class="btn btn-primary btn-sm ">Bəli</button></a>
        <a href="{{ route('messages') }}"><button type="button" class="btn btn-danger btn-sm ">Xeyr</button></a><br><br>
    @endisset
    @if (session('message'))
        {{ session('message') }}
    @endif

    @if ($errors->any())
        @foreach ($errors->all() as $info)
            <script>
                swal("Zəhmət olmasa yenidən cəhd edin!!", "{{ $info }}", "error");
            </script>
        @endforeach
    @endif





    <div class="container-fluid">


        <div class="card shadow mb-4">

            <div class="card-body">

                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Title</th>
                            <th scope="col">Email</th>
                            <th scope="col">Status</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="skills">

                        @foreach ($messages as $i => $message)
                            <tr>
                                <th scope="row"> {{ $i += 1 }}</th>
                                <td>{{ $message->title }}</td>
                                <td>{{ $message->email }}</td>
                                <td>{!! $message->seen_date === null
                                    ? '<span class="badge badge-pill badge-success">New Message</span>'
                                    : 'Read: ' . $message->seen_date !!}</td>
                                <td>
                                    <a href="{{ route('message', $message->id) }}" class="btn btn-sm btn-primary"><i
                                            class="mdi mdi-eye"></i></a>
                                    <a href="{{ route('message.sil', $message->id) }}" class="btn btn-sm btn-danger"><i
                                            class="mdi mdi-delete"></i></a>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>

            </div>
        </div>

    </div>
@endsection
