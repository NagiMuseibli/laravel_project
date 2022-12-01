@extends('layouts.app')
@section('title')
Admin
@endsection

@section('admin')
<h1>Admin</h1><br>
@if(session('message'))
{{session('message')}}
@endif

@if($errors->any())
@foreach($errors->all() as $info)
{{$info}}<br>
@endforeach
@endif

<div class="card">
  <div class="card-body">
    <h4 class="card-title">{{ $usay }} Users</h4>
    <div class="table-responsive">
      <table class="table">
        <thead>

          <tr>
            <th>#</th>
            <th> Foto </th>
            <th> Ad-Soyad </th>
            <th> Tel </th>
            <th> E-Mail </th>
            <th> Tarix </th>
            <th> blok/Aktiv </th>

          </tr>


        </thead>
        <tbody>
          @foreach($post as $i=>$info)
          <tr>
            <td>{{$i+=1}}</td>
            <td>
              <img style="width:65px; height:56px" src="{{URL::to('uploads\brands',$info->foto)}}">

            </td>
            <td>{{ $info->name }} {{ $info->surname }}</td>
            <td>{{ $info->tel }}</td>
            <td>{{ $info->email }}</td>
            <td>{{ $info->created_at }}</td>
            <td>
              @if($info->id==1)
              ADMIN

              @elseif($info->tesdiq==1)
              <form method="post" action="{{route('blok')}}">
                @csrf
                <input type="hidden" name="id" value="{{$info->id}}">
                <button type="submit" class="btn btn-danger btn-sm blok" name="blok" value="'.$info['id'].'" id="'.$info['id'].'" title="blok et"><i class="mdi mdi-close"></i></button></button>
            </td>
            </form>
            @else
            <form method="post" action="{{route('tesdiq')}}">
              @csrf
              <input type="hidden" name="id" value="{{$info->id}}">
              <button type="submit" class="btn btn-success btn-sm tesdiq" name="tesdiq" value="'.$info['id'].'" id="'.$info['id'].'" title="Təsdiq et"><i class="mdi mdi-check"></i>
            </form>
            @endif



          </tr>
          @endforeach

        </tbody>
      </table>
    </div>
  </div>
</div>



@endsection