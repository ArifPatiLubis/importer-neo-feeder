@extends('layouts.master-dashboard')

@section('title', 'Import Aktivitas Perkuliahan')

@section('content')
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h3 style="font-family: 'Bebas Neue', sans-serif; color: #006633;
                        font-weight: bold; text-align: left; margin-bottom: 1rem">Import Aktivitas Perkuliahan Mahasiswa</h3>
                        <hr style="border: 1px solid #C0C0C0">
                    <div class="card-description">
                        <p>Petunjuk :</p>
                        <ol class="list">
                            <li>Download file template excel <a
                                    href="{{ url('files/import-aktivitas-perkuliahan.xlsx') }}">disini</a></li>
                            <li>Isikan data aktivitas mahasiswa menggunakan file excel sesuai petunjuk</li>
                        </ol>
                    </div>
                    <form action="{{ url('/Administrator/Import/Aktivitas-Perkuliahan/Singkron') }}" 
                        method="post" enctype="multipart/form-data" id="formImport">
                        @csrf
                        <div class="row">
                            <div class="form-group col-lg-12 @error('file') has-danger @enderror">
                                <label>File</label>
                                <input type="file" name="file" class="file-upload-default">
                                <div class="input-group col-xs-12">
                                    <input type="text"
                                        class="form-control file-upload-info @error('file') form-control-danger @enderror"
                                        disabled>
                                    <span class="input-group-append">
                                        <button
                                            class="file-upload-browse btn btn-light @error('file') border-danger @enderror border"
                                            type="button">Pilih File</button>
                                    </span>
                                    <span class="input-group-append">
                                        <button type="submit" style="margin-left: 10px "
                                            class="btn btn-success" id="btnImport">Import</button>
                                    </span>
                                </div>
                                @error('file')
                                    <label class="error text-danger mt-2">{{ $message }}</label>
                                @enderror
                            </div>
                        </div>
                    </form>                    
                    <div id="progressBar"></div>
                    @if (session()->has('import-error'))
                        <div class="row mt-5">
                            <div class="col-12">
                                <div class="alert alert-danger" role="alert">
                                    <p>Gagal import file. Periksa kembali isian data berikut :</p>
                                    <ul>
                                        <li>
                                            Baris ke-{{ session()->get('import-error')->row() }}, nilai
                                            {{ session()->get('import-error')->values()[session()->get('import-error')->attribute()] }}
                                            pada kolom {{ strtolower(session()->get('import-error')->errors()[0]) }}
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="table-responsive">
                        <table id="logImport" class="display expandable-table table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Operator</th>
                                    <th>Action</th>
                                    <th>Status</th>
                                    <th>Keterangan</th>
                                    <th>Waktu</th>
                                </tr>
                            </thead>
                        </table>
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
<script>
    $(document).ready(function() {
        $('.file-upload-browse').on('click', function() {
            let file = $(this).parent().parent().parent().find('.file-upload-default');
            file.trigger('click');
        });
        $('.file-upload-default').on('change', function() {
            $(this).parent().find('.form-control').val($(this).val().replace(/C:\\fakepath\\/i, ''));
        });

        $('#formImport').submit(function (e) {
            $('#btnImport').attr('disabled', true);
            $('#btnImport').html('<i class="fa-solid fa-spinner fa-spin fa-fw mr-2"></i>Proses Import');
        });
    });
</script>
<script>
    $(document).ready(function() {
        let table = $('#logImport').DataTable({
            ajax: {
                url: '/Administrator/Import/Aktivitas-Perkuliahan',
                dataSrc: ''
            },
            columns: [
                { data: null, orderable: false, searchable: false },
                { data: 'nama_pengguna' },
                { data: 'act' },
                {
                    data: 'status',
                    render: function (data, type, row, meta) {
                        if(data == 'Sukses') {
                            return `<label class="badge badge-outline-success">`+data+`</label>`
                        } else {
                            return `<label class="badge badge-outline-danger">`+data+`</label>`
                        }
                    },
                    className: 'text-center'
                },
                { data: 'description' },
                { data: 'created_at' }
            ]
        });
        table.on('order.dt search.dt', function () {
            table.column(0, {search:'applied', order:'applied'}).nodes().each(function (cell, i) {
                cell.innerHTML = i+1;
            });
        });
    });
</script>
@endpush
