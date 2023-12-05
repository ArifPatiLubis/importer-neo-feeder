@extends('layouts.master-front')

@section('title', 'Login')

@section('content')
<div class="container-fluid page-body-wrapper full-page-wrapper"
>
    {{-- <img class="bg-img" src="{{ url('image/usu-background.png') }}" alt="..."> --}}
    <div class="content-wrapper d-flex align-items-center auth px-0" 
         style="background-image: url({{url('image/usu-background.png')}});
                background-repeat: no-repeat; background-size: cover; width: auto; heightL auto;
                background-position: center center; background-attachment: fixed; ">
        <div class="row w-100 mx-0">
            <div class="col-xl-4 mx-auto">
                
            </div>
        </div>
    </div>
</div>
@endsection

@push('page-stylesheet')
@endpush

