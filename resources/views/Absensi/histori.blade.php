@extends('layouts.absensi')
@section('header')
    <!-- App Header -->
    <div class="appHeader bg-success text-light">
        <div class="left">
            <a href="javascript:;" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Histori Absensi</div>
        <div class="right"></div>
    </div>
@endsection

@section('content')
    <div class="row" style="margin-top: 70px;">
        <div class="col">

            <div class="col-12">
                <div class="card">
                    <div class="card-body" style="padding: 12px 12px !important; line-height: 0.8rem;">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <button id="getdata" class="btn btn-primary"> <ion-icon name="search-outline"></ion-icon> Cari Data
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for=""> Bulan</label>
                            <select name="bulan" id="bulan" class="form-control">
                                @for ($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}" {{ date('m') == $i ? 'selected' : '' }}>
                                        {{ $namabulan[$i] }}</option>
                                @endfor
                            </select>
                        </div>

                        <div class="form-group">
                            <label for=""> Tahun</label>
                            <select name="tahun" id="tahun" class="form-control">
                                @php
                                    $tahunmulai = 2022;
                                    $tahunskrg = date('Y');
                                @endphp
                                @for ($tahun = $tahunmulai; $tahun <= $tahunskrg; $tahun++)
                                    <option value="{{ $tahun }}" {{ date('Y') == $tahun ? 'selected' : '' }}>
                                        {{ $tahun }}</option>
                                @endfor
                            </select>
                        </div>

                    </div>
                   
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col" id="showhistori"></div>
    </div>
    
@endsection

@push('myscript')
<script>
    $(function(){
        $("#getdata").click(function(e){
            var bulan = $("#bulan").val();
            var tahun = $("#tahun").val();
            // alert(bulan + "&" + tahun);
            $.ajax({
                type: 'POST',
                url:'/gethistori',
                data: {
                    _token: "{{ csrf_token() }}",
                    bulan: bulan,
                    tahun: tahun,
                },
                cache: false,
                success: function(respond){
                $("#showhistori").html(respond);
                }

            });
        });
    });
</script>
    
@endpush
