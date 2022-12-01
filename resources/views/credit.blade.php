@extends('layouts.app')
@section('title')
    Credit
@endsection


@section('axtar')
    <!--SEARCH SYSTEMM SART-->
    <div class="col-auto">
        <form class="nav-link mt-2 mt-md-0 d-none d-lg-flex search" type="get" action="{{ url('/searchcredit') }}">
            @csrf
            <input type="search" name="query" class="form-control" placeholder="Search @yield('title')">
            <button class="btn btn-primary btn-sm " type="submit"><i class="mdi mdi-magnify"></i></button>

        </form>
    </div>
    <!--SEARCH SYSTEMM END-->
@endsection

@section('credit')
    <h1>Kredit</h1><br>
    <div id="netice"></div><br>

    <!--MESSAGES SYSTEMM START-->
    @isset($sildata)
        <span class="alert alert-success">Krediti Silməyə əminsinizmi?</span><br><br>
        <a href="{{ route('credit.delete', $sildata->id) }}"><button type="button"
                class="btn btn-primary btn-sm ">Bəli</button></a>
        <a href="{{ route('credit') }}"><button type="button" class="btn btn-danger btn-sm ">Xeyr</button></a><br><br>
    @endisset


    @if (Session::has('credit_add'))
        <script>
            swal("ƏLA!!", "{!! Session::get('credit_add') !!}", "success");
        </script>
    @endif

    @if (Session::has('credit_edit'))
        <script>
            swal("ƏLA!!", "{!! Session::get('credit_edit') !!}", "success");
        </script>
    @endif

    @if (Session::has('credit_meshul'))
        <script>
            swal("Zəhmət olmasa yenidən cəhd edin!!", "{!! Session::get('credit_meshul') !!}", "warning");
        </script>
    @endif

    @if (Session::has('credit_tesdiq'))
        <script>
            swal("ƏLA!!", "{!! Session::get('credit_tesdiq') !!}", "success");
        </script>
    @endif

    @if (Session::has('credit_odenis'))
        <script>
            swal("ƏLA!!", "{!! Session::get('credit_odenis') !!}", "success");
        </script>
    @endif

    @if (Session::has('credit_odenis_warning'))
        <script>
            swal("Zəhmət olmasa yenidən cəhd edin!!", "{!! Session::get('credit_odenis_warning') !!}", "warning");
        </script>
    @endif

    @if (Session::has('credit_mebleg_warning'))
        <script>
            swal("Zəhmət olmasa yenidən cəhd edin!!", "{!! Session::get('credit_mebleg_warning') !!}", "warning");
        </script>
    @endif

    @if (Session::has('credit_sil'))
        <script>
            swal("ƏLA!!", "{!! Session::get('credit_sil') !!}", "success");
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

    @isset($edit)



        <div class="card">
            <div class="card-body">
                <form method="post" action="{{ route('credit.update') }}">
                    <input type="hidden" name="id" value="{{ $edit->id }}">
                    @csrf
                    <label>Musteri</label>
                    <select class="form-control" name="brand_id">
                        @foreach ($data as $info)
                            <option value="{{ $info->cid }}">{{ $info->musteriad }} {{ $info->musterisoyad }}</option>
                        @endforeach

                    </select><br>
                    <label>Mehsul:</label>
                    <select name="product_id" class="form-control">
                        @foreach ($data as $info)
                            <option value="{{ $info->cid }}">{{ $info->mehsul }} ({{ $info->brand }}) Miqdar:
                                {{ $info->mehsulsayi }}</option>
                        @endforeach
                    </select><br>
                    <label>Sifariş Sayı:</label>
                    @foreach ($data as $info)
                        <input type="text" class="form-control" name="miqdar" value="{{ $info->sifarissayi }}"
                            placeholder="{{ $info->sifarissayi }}" autocomplete="off"><br>
                    @endforeach
                    <label>Muddet:</label>
                    @foreach ($data as $info)
                        <select name="muddet" class="form-control">
                            <option value="{{ $info->muddet }}">{{ $info->muddet }} Ay</option>
                            <option value="6">6 Ay</option>
                            <option value="12">12 Ay</option>
                            <option value="18">18 Ay</option>
                            <option value="24">24 Ay</option>

                        </select><br><br>
                    @endforeach
                    <label>Illik Faiz:</label>
                    <select name="faiz" class="form-control">
                        <option value="10">Illik Faiz</option>
                        <option value="10">10 %</option>
                    </select><br><br>
                    <label>Depozit:</label>
                    @foreach ($data as $info)
                        <input type="text" class="form-control" name="depozit" value="{{ $info->depozit }}"
                            placeholder="{{ $info->depozit }}" autocomplete="off"><br><br>
                    @endforeach
                    <button type="submit" class="btn btn-primary btn-sm insert" name="d">Yenile</button>

                </form>
            </div>
        </div>


    @endisset


    @isset($odenis)

        @foreach ($cdata as $cinfo)
            @if (($cinfo->satis * $cinfo->sifarissayi * $cinfo->faiz) / 100 +
                $cinfo->satis * $cinfo->sifarissayi -
                $cinfo->depozit !=
                0)
                <div class="card">
                    <div class="card-body">
                        <form method="post" action="{{ route('credit.pay') }}">
                            <input type="hidden" name="qaliqb"
                                value="{{ ($cinfo->satis * $cinfo->sifarissayi * $cinfo->faiz) / 100 + $cinfo->satis * $cinfo->sifarissayi - $cinfo->depozit }}">
                            @csrf
                            <label>Ad Soyad:</label>
                            <select class="form-control" name="client_id">

                                @foreach ($cdata as $info)
                                    <option value="{{ $info->cid }}">{{ $info->musteriad }} {{ $info->musterisoyad }}
                                    </option>
                                    <input type="hidden" name="cid" value="{{ $info->cid }}">
                                @endforeach

                            </select><br>
                            <label>Aylıq ödəniş:</label>

                            <select class="form-control" name="client_id">

                                @foreach ($cdata as $cinfo)
                                    <option value="">
                                        {{ number_format((($cinfo->satis * $cinfo->sifarissayi * $cinfo->faiz) / 100 + $cinfo->satis * $cinfo->sifarissayi - $cinfo->depozit) / ($cinfo->muddet - $cinfo->ay), 2, '.', '') }}
                                    </option>
                                    <input type="hidden" name="cid" value="{{ $cinfo->cid }}">
                                    <input type="hidden" name="credit_id" value="{{ $cinfo->Credits_id }}">
                                    <input type="hidden" name="client_id" value="{{ $cinfo->cid }}">
                                    <input type="hidden" name="product_id" value="{{ $cinfo->pid }}">
                                @endforeach

                            </select><br>
                            <label>Ödəyəcəyiniz Məbləğ</label>
                            <input type="text" class="form-control" name="mebleg" placeholder="Məbləğ daxil edin.."
                                autocomplete="off"><br>
                            <button type="submit" class="btn btn-primary btn-sm insert" name="d">Ödəniş et</button>

                        </form>
                    </div>
                </div><br>
            @else
                <span class="alert alert-success">Borcunuz bitmişdir</span><br><br>
            @endif
        @endforeach




        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Ödəniş Cədvəli</h4>
                <div class="table-responsive">
                    <table class="table">
                        <thead>

                            <tr>
                                <th>#</th>
                                <th>Kod</th>
                                <th>Müştəri</th>
                                <th>Brend</th>
                                <th>Məhsul</th>
                                <th>Ödənilmiş Məbləğ</th>

                                <th>Tarix</th>



                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($paydate as $i => $cinfo)
                                <tr id="">
                                    <td>
                                        {{ $i += 1 }}
                                    </td>
                                    <td>{{ $cinfo->kod }} </td>
                                    <td>{{ $cinfo->musteriad }} {{ $cinfo->musterisoyad }}</td>
                                    <td>{{ $cinfo->brand }}</td>
                                    <td>{{ $cinfo->mehsul }}</td>
                                    <td>{{ $cinfo->mebleg }}</td>

                                    <td>{{ $cinfo->tarix }}</td>
                                    <td></td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif

        @empty($odenis)
            @empty($edit)
                <div class="card">
                    <div class="card-body">
                        <form method="post" action="{{ route('credit.send') }}">
                            @csrf

                            <select name="client_id" class="form-control">
                                <option value="">Müştəri </option>

                                @foreach ($dataa as $info)
                                    <option value="{{ $info->id }}">{{ $info->ad }} {{ $info->soyad }}</option><br><br>
                                @endforeach

                            </select><br><br>

                            <select name="product_id" class="form-control">
                                <option value="">Məhsul</option>

                                @foreach ($bdata as $info)
                                    <option value="{{ $info->id }}">{{ $info->mehsul }} ({{ $info->brand }}) Miqdar:
                                        {{ $info->miqdar }}</option>
                                @endforeach

                            </select><br><br>

                            <input type="text" class="form-control" name="miqdar" placeholder="Miqdar" required
                                autocomplete="off"><br><br>

                            <select name="muddet" class="form-control">
                                <option value="">Muddet</option>

                                <option value="6">6 Ay</option>
                                <option value="12">12 Ay</option>
                                <option value="18">18 Ay</option>
                                <option value="24">24 Ay</option>

                            </select><br><br>

                            <select name="faiz" class="form-control">
                                <option value="">Illik Faiz</option>
                                <option value="10">10 %</option>
                            </select><br><br>
                            <input type="text" class="form-control" name="depozit" placeholder="Depozit" required
                                autocomplete="off"><br><br>
                            <input type="hidden" name="d">
                            <button type="submit" class="btn btn-primary btn-sm insert" name="d">Daxil et</button>

                        </form>
                    </div>
                </div>
            @endempty
        @endempty
        <br>



        @empty($odenis)
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Kredit Sifariş</h4>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>

                                <tr>
                                    <th>#</th>
                                    <th>Kod</th>
                                    <th>Müştəri</th>
                                    <th>Brend</th>
                                    <th>Məhsul</th>
                                    <th>Sifariş sayı</th>
                                    <th>Qiymət</th>
                                    <th>Faiz</th>
                                    <th>Toplam</th>
                                    <th>Qalıq</th>
                                    <th>Aylıq</th>
                                    <th>Depozit</th>
                                    <th>Müddət</th>
                                    <th>Tarix</th>



                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cdata as $i => $cinfo)
                                    <tr>
                                        <td>{{ $i += 1 }}
                    </div>
                    </td>
                    <td>{{ $cinfo->kod }} </td>
                    <td>{{ $cinfo->musteriad }} {{ $cinfo->musterisoyad }}</td>
                    <td>{{ $cinfo->brand }}</td>
                    <td>{{ $cinfo->mehsul }}</td>
                    <td>{{ $cinfo->sifarissayi }}</td>
                    <td>{{ number_format($cinfo->satis, 2, '.', '') }}</td>
                    <td>{{ $cinfo->faiz }}</td>
                    <td>
                        {{ number_format(($cinfo->satis * $cinfo->sifarissayi * $cinfo->faiz) / 100 + $cinfo->satis * $cinfo->sifarissayi, 2, '.', '') }}
                    </td>
                    <td>
                        {{ number_format(($cinfo->satis * $cinfo->sifarissayi * $cinfo->faiz) / 100 + $cinfo->satis * $cinfo->sifarissayi - $cinfo->depozit, 2, '.', '') }}
                    </td>

                    <td>
                        @if ($cinfo->muddet > $cinfo->ay)
                            {{ number_format((($cinfo->satis * $cinfo->sifarissayi * $cinfo->faiz) / 100 + $cinfo->satis * $cinfo->sifarissayi - $cinfo->depozit) / ($cinfo->muddet - $cinfo->ay), 2, '.', '') }}
                        @else
                            <i class="mdi mdi-check"></i>
                        @endif
                    </td>
                    <td>{{ number_format($cinfo->depozit, 2, '.', '') }}</td>
                    <td>{{ $cinfo->muddet }} / {{ $cinfo->ay }} Ay </td>
                    <td>{{ $cinfo->tarix }}</td>




                    <td>
                        @if ($cinfo->tesdiq == 0)
                            <form method="post" action="{{ route('credit.tesdiq') }}">
                                @csrf
                                <a href="{{ route('credit.edit', $cinfo->Credits_id) }}"><button type="button"
                                        class="btn btn-primary btn-sm "><i class="mdi mdi-border-color lg"></i></button></a>

                                <a href="{{ route('credit.sil', $cinfo->Credits_id) }}"><button type="button"
                                        class="btn btn-danger btn-sm "><i class="mdi mdi-delete"></i></button></a>



                                <input type="hidden" name="ayliq"
                                    value="{{ (($cinfo->satis * $cinfo->sifarissayi * $cinfo->faiz) / 100 + $cinfo->satis * $cinfo->sifarissayi - $cinfo->depozit) / $cinfo->muddet }}">
                                <input type="hidden" name="pmiqdar" value="{{ $cinfo->mehsulsayi }}">
                                <input type="hidden" name="smiqdar" value="{{ $cinfo->sifarissayi }}">
                                <input type="hidden" name="satis" value="{{ $cinfo->satis }}">
                                <input type="hidden" name="alis" value="{{ $cinfo->alis }}">
                                <input type="hidden" name="pid" value="{{ $cinfo->pid }}">
                                <input type="hidden" name="credit_id" value="{{ $cinfo->Credits_id }}">

                                <button type="submit" class="btn btn-primary btn-sm"><i class="mdi mdi-check"></i></button>

                            </form>
                        @elseif(($cinfo->satis * $cinfo->sifarissayi * $cinfo->faiz) / 100 +
                            $cinfo->satis * $cinfo->sifarissayi -
                            $cinfo->depozit !=
                            0)
                            <a href="{{ route('odenis', $cinfo->Credits_id) }}"><button type="submit"
                                    class="btn btn-primary btn-sm">Ödəniş</button></a>
                        @else
                            <a href="{{ route('odenis', $cinfo->Credits_id) }}"><button type="submit"
                                    class="btn btn-primary btn-sm">Ödəniş Cədvəli</button></a>
                    </td>
                    @endif

                    </tr>
                    @endforeach
                    </tbody>
                    </table>
                </div>
            </div>
            </div>
        @endempty
    @endsection
