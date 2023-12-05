@extends('layouts.master-dashboard')

@section('title', 'Profil')

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin">
        <div class="row">
            <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                <h3 class="font-weight-bold">Halo, Admin {{ session('nama') }}</h3>
            </div>
            <div class="col-12 col-xl-4">
                <div class="justify-content-end d-flex">
                    <div class="dropdown flex-md-grow-1 flex-xl-grow-0">
                        <button class="btn btn-sm btn-light bg-white" type="button">
                            <span id="tanggal"></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xl-4 grid-margin stretch-card d-none d-xl-block">
        <div class="card tale-bg">
            <div class="card-people mt-auto">
                <img src="{{ url('images/student.svg') }}" alt="people">
            </div>
        </div>
    </div>
</div>
@endsection

@push('page-stylesheet')
@endpush

