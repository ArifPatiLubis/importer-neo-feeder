@extends('layouts.master-front')

@section('title', 'Login')

@section('content')
<style>
   
</style>
<div class="container-fluid page-body-wrapper full-page-wrapper" style="background-image: url({{url('image/usu-background.png')}});
background-repeat: no-repeat; background-size: cover; width: auto; heightL auto;
background-position: center center; background-attachment: fixed; ">
    {{-- <img class="bg-img" src="{{ url('image/usu-background.png') }}" alt="..."> --}}
    <div class="content-wrapper d-flex align-items-center auth px-0" style="background: transparent">
        <div class="row w-100 mx-0">
            <div class="col-xl-4 mx-auto">
                <div class="auth-form-light text-left py-4 px-3 px-sm-4" style="border-radius: 25px;">
                    <div class="brand-logo">
                        <img src="{{ url('image/Logo_usu_mini.png') }}" alt="logo" class="mx-auto d-block"
                             style="width: 50px; height: 50px">
                    </div>
                    <h3 style="font-family: 'Bebas Neue', sans-serif; color: green; text-outlined;
                                font-weight: bold; text-align: center; margin: 1rem auto">FEEDER IMPORTER</h3>
                    <hr style="border: 1px solid #E5E4E2;">

                    <form action="" class="py-1" method="post">
                        @csrf
                        <div class="form-group row @error('nama_pengguna') has-danger @enderror">
                            <div class="col-sm-12">
                                <label><b>Nama Pengguna</b></label>
                                <input type="text" class="form-control form-control-danger" name="nama_pengguna" 
                                    value="{{ old('nama_pengguna') }}" id="nama_pengguna">
                                {{-- @error('nama_pengguna')
                                <label class="error text-danger">{{ $message }}</label>
                                @enderror --}}
                            </div>
                        </div>
                        <div class="form-group row @error('password') has-danger @enderror">
                            <div class="col-sm-12">
                                <label><b>Kata Sandi</b></label>
                                <input type="password" class="form-control form-control-danger" name="password"
                                    id="password">
                                <span toggle="#password"
                                    class="text-muted fa-solid fa-eye fa-fw fa-xs field-icon toggle-password"></span>
                                {{-- @error('password')
                                <label class="error text-danger">{{ $message }}</label>
                                @enderror --}}
                            </div>
                        </div>
                        @if($errors->any())
                        <ul> 
                            @foreach ($errors->all() as $item)
                            <li class="error text-danger">{{ $item }}</li>
                            @endforeach
                        </ul>
                        @endif
                        <small class="form-text text-muted">Lupa kata sandi? <b>Hubungi PIC Universitas</b></small>
                        <button type="submit" class="btn btn-primary" style="width:80%; margin: 1.5rem auto; display: block">Login</button>
                    </form>
                    <p style="font-family: 'Bebas Neue', sans-serif; font-weight: light; text-align: center">
                        &copy; Direktorat Pengembangan Pendidikan | 2023</p>
                    
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
    $(".toggle-password").click(function() {
        $(this).toggleClass("fa-eye fa-eye-slash");
        var input = $($(this).attr("toggle"));
        if (input.attr("type") == "password") {
            input.attr("type", "text");
        } else {
            input.attr("type", "password");
        }
    });
</script>
@endpush
