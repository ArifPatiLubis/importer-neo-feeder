@extends('layouts.master-dashboard')

@section('title', 'Beranda')

@section('content')
<div class="row">
    <div class="col-xl-12 grid-margin">
        <div class="row">
            <div class="col-md-12 mb-4 stretch-card" >
                <div class="card card-tale" style="padding: 10px 30px; background-color: transparent; color: black">
                    <div class="card-body" >
                            @foreach ($profil as $item)
                            <h2 style="font-family: 'Bebas Neue', sans-serif; color: #006633;
                            font-weight: bold; text-align: left; margin-bottom: 1rem">
                            {{ $item['nama_perguruan_tinggi'] }} | 
                            @if(Auth::user()->lembaga == 'Dirpp')
                            Dir. Pengembangan Pendidikan
                            @elseif(Auth::user()->role == '2')
                            PIC Universitas
                            @endif
                            </h2>
                            <hr style="border: 1px solid #C0C0C0">
                            @endforeach
                            <div class="container" style="align-items: flex-start; margin: 10px 0px; background: transparent">
                                <div class="row">
                                    <!-- Bagian kiri -->
                                    <div class="col-xl-5" >
                                                <img src="{{ url('image/student.svg') }}" alt="people" >

                                    </div>
                                    <!-- Bagian tengah -->
                                    <div class="col-1">
                                    </div>
                                    <!-- Bagian kanan -->
                                    <div class="col-xl-5" style="padding: 20px, margin-left: 1rem">
                                        <dl class="row">
                                            @foreach ($profil as $item)
                                            <dt class="col-sm-3">Kode PT</dt>
                                            <dd class="col-sm-9">{{ $item['kode_perguruan_tinggi'] }}</dd>
                                            <dt class="col-sm-3">Nama PT</dt>
                                            <dd class="col-sm-9">{{ $item['nama_perguruan_tinggi'] }}</dd>
                                            <dt class="col-sm-3">Telepon</dt>
                                            <dd class="col-sm-9">{{ $item['telepon'] }}</dd>
                                            <dt class="col-sm-3">Faximile</dt>
                                            <dd class="col-sm-9">{{ $item['faximile'] }}</dd>
                                            <dt class="col-sm-3">Email</dt>
                                            <dd class="col-sm-9">{{ $item['email'] }}</dd>
                                            <dt class="col-sm-3">Website</dt>
                                            <dd class="col-sm-9">{{ $item['website'] }}</dd>
                                            @endforeach
                                        </dl>
                                    </div>
                                </div>
                            </div>
                    </div>
                    <div class="row" style="margin-top: 50px">
                    <div class="col-sm-4 mb-4 stretch-card transparent">
                        <div class="card card-dark-blue" style="background-color: transparent; border: 2px solid #006633; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                            <div class="card-body" style="border: none">
                                <p class="mb-4" style="font-family: 'Bebas Neue', sans-serif; font-size: 18px; font-weight: light; color: black">Jumlah Prodi</p>
                                <p class="fs-30 counter" style="font-family: 'Bebas Neue', sans-serif; 
                                        font-size: 48px; font-weight: bold; color: #006633; text-align:center">
                                    {{ $count_prodi }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 mb-4 stretch-card transparent">
                        <div class="card card-dark-blue" style="background-color: transparent; border: 2px solid #006633;box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                            <div class="card-body" style="border: none">
                                <p class="mb-4" style="font-family: 'Bebas Neue', sans-serif; font-size: 18px; font-weight: light; color: black">Jumlah Dosen & Tendik</p>
                                <p class="fs-30 counter" style="font-family: 'Bebas Neue', sans-serif; 
                                        font-size: 48px; font-weight: bold; color: #006633; text-align:center">
                                    {{ $count_dosen }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 mb-4 stretch-card transparent">
                        <div class="card card-dark-blue" style="background-color: transparent; border: 2px solid #006633; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                            <div class="card-body" style="border: none">
                                <p class="mb-4" style="font-family: 'Bebas Neue', sans-serif; font-size: 18px; font-weight: light; color: black">Jumlah Mahasiswa</p>
                                <p class="fs-30 counter" style="font-family: 'Bebas Neue', sans-serif; 
                                        font-size: 48px; font-weight: bold; color: #006633; text-align:center">
                                    {{ $count_mahasiswa }}</p>
                            </div>
                        </div>
                    </div>
                </div>   
            </div>
        </div>
    </div>
</div>
@endsection

@push('page-stylesheet')
@endpush

@push('page-script')
<script>
    const month = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
    const weekday = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];

    let d = new Date();
    let day = weekday[d.getDay()];
    let date = d.getDate();
    let name = month[d.getMonth()];
    let year = d.getFullYear();

    let fullDate = `${day}, ${date} ${name} ${year}`;
    document.getElementById("tanggal").innerHTML = fullDate;

    $('.counter').each(function() {
        $(this).prop('Counter', 0).animate({
            Counter: $(this).text()
        }, {
            duration: 1000,
            easing: 'swing',
            step: function(now) {
                now = Number(Math.ceil(now)).toLocaleString('id');
                $(this).text(now);
            }
        });
    });
</script>
@endpush


