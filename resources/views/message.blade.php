@extends('layouts.app')

@section('title')
Message
@endsection
@section('brands')



<div class="container-fluid">


    <div class="row">

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('messages') }}" class="btn btn-primary btn-sm font-weight-bold text-light"> <i class="mdi mdi-arrow-left-bold"></i> Geri </a>
                </div>

                <div class="card-body">
                    <table class="table">

                        <tbody>
                            <tr>

                                <th scope="row">Title</th>
                                <td>{{$message->title}}</td>

                            </tr>
                            <tr>

                                <th scope="row">Email</th>
                                <td>{{$message->email}}</td>

                            </tr>
                            <tr>

                                <th scope="row">Tarix</th>
                                <td>{{$message->created_at}}</td>

                            </tr>
                            <tr>

                                <th scope="row">Messsage</th>
                                <td>{{$message->body}}</td>

                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Mesaja cavab:
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('message.send') }}" method="post">
                        @csrf
                        <div class="form-group">
                            Email:
                            <input type="email" name="email" class="form-control" value="{{$message->email}}" required>
                        </div>
                        <div class="form-group">
                            Başlıq:
                            <input type="text" name="title" class="form-control" value="" required>
                        </div>
                        <div class="form-group">
                            Mesaj:
                            <textarea name="body" class="form-control" rows="7" placeholder="Cavab..." required></textarea>
                        </div>

                        <button type="submit" class="btn btn-sm btn-success btn-block">Göndər</button>
                    </form>
                </div>
            </div>
        </div>


    </div>

</div>

@endsection