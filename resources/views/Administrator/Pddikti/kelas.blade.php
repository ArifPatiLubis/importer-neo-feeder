@extends('layouts.master-dashboard')

@section('title', 'Kelas Perkuliahan PDDIKTI')

@section('content')
<div class="row" id='filter'>
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h3 style="font-family: 'Bebas Neue', sans-serif; color: #006633;
                        font-weight: bold; text-align: left; margin-bottom: 1rem">Pilih Program Studi dan Periode</h3>
                        <hr style="border: 1px solid #C0C0C0">
                <form action="#"  method="" enctype="multipart/form-data" id="FilterData">
                @csrf
                <div class="row">
                    <div class="form-group col-lg-6 @error('semester') has-danger @enderror">
                       <label><b>Program Studi</b></label>
                        <select class="form-control @error('program_studi_pengampu') form-control-danger @enderror"
                            name="program_studi_pengampu" data-display="static" id="prodi">
                            @foreach ($prodi['data'] as $prodilist)
                            <option name = 'id_prodi' value="{{ $prodilist['id_prodi'] }}" 
                            {{ old('program_studi_pengampu')==$prodilist['id_prodi'] ? 'selected' : '' }}>
                                {{ $prodilist['nama_jenjang_pendidikan'] }} {{ $prodilist['nama_program_studi'] }}
                            </option>
                            @endforeach
                        </select>
                        @error('program_studi_pengampu')
                        <label class="error mt-2 text-danger">{{ $message }}</label>
                        @enderror
                    </div>
                    <div class="form-group col-lg-6 @error('file') has-danger @enderror">
                        <label><b>Semester</b></label>
                        <select class="form-control @error('semester_pendidikan') form-control-danger @enderror"
                            name="semester_pendidikan" data-display="static" id="semester">
                            @foreach ($semester['data'] as $semester)
                            <option value="{{ $semester['id_semester'] }}" {{
                                old('semester_pendidikan')==$semester['id_semester'] ? 'selected' : '' }}>
                               {{ $semester['nama_semester'] }}
                            </option>
                            @endforeach
                        </select>
                        @error('program_studi_pengampu')
                        <label class="error mt-2 text-danger">{{ $message }}</label>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-lg-12 @error('semester') has-danger @enderror">
                        <button type="button" class="form-control btn-success" id="btnImport" onclick="updateTable()">Filter</button>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>
<div class="row" id="hasil" style="display: none">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h3 style="font-family: 'Bebas Neue', sans-serif; color: #006633;
                        font-weight: bold; text-align: left; margin-bottom: 1rem">Data Kelas Perkuliahan PDDIKTI</h3>
                        <hr style="border: 1px solid #C0C0C0">
                <div class="table-responsive">
                    <table id="refMahasiswa" class="display expandable-table table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Program Studi</th>
                                <th>Semester</th>
                                <th>Kode Mata Kuliah</th>
                                <th>Nama Mata Kuliah</th>
                                <th>Nama Kelas Kuliah</th>
                                <th>Total SKS</th>
                                <th>Nama Dosen</th>
                                <th>Jumlah Mahasiswa</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .sync {
    background-color: #DFF0D8; /* Ganti dengan warna latar belakang hijau yang diinginkan */
    padding: 5px; /* Atur ruang padding sesuai kebutuhan */
    border-radius: 5px; /* Tambahkan border-radius untuk sudut elemen */
    }

    /* Warna latar belakang merah untuk status yang belum sync */
    .notsync {
        background-color: #F2DEDE; /* Ganti dengan warna latar belakang merah yang diinginkan */
        padding: 5px; /* Atur ruang padding sesuai kebutuhan */
        border-radius: 5px; /* Tambahkan border-radius untuk sudut elemen */
    }
</style>
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
    $(document).ready(function () {
    var div2 = $('#hasil');
    var prodiSelect = $('#prodi');
    var semesterSelect = $('#semester');
    var refMahasiswaTable;

    function buildUrl() {
        var idProdi = prodiSelect.val();
        var idPeriode = semesterSelect.val();
        return '/Administrator/Data-Pddikti/Kelas-Perkuliahan/Cari?id_prodi=' + idProdi + '&id_semester=' + idPeriode;
    }

    function initializeDataTable() {
        refMahasiswaTable = $('#refMahasiswa').DataTable({
            
            ajax: {
                url: buildUrl(),
            },
            columns: [
                { data: null, orderable: false, searchable: false },
                { data: 'nama_program_studi' },
                { data: 'nama_semester' },
                { data: 'kode_mata_kuliah' },
                { data: 'nama_mata_kuliah' },
                { data: 'nama_kelas_kuliah' },
                { data: 'sks' },
                { data: 'nama_dosen' },
                { data: 'jumlah_mahasiswa' },
            ],
            dom: '<"container-fluid"<"row"<"col-2"l><"col-8"f><"col-2"B>>>tip',
            buttons: [
                {
                    extend: 'excelHtml5',
                    className: 'btn-success',
                }
            ],
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, 'Semua']
            ]
        });

        refMahasiswaTable.on('order.dt search.dt', function () {
            refMahasiswaTable.column(0, {search:'applied', order:'applied'}).nodes().each(function (cell, i) {
                cell.innerHTML = i + 1;
            });
        });
    }

    $('#btnImport').on('click', function () {
        div2.show();

        // Inisialisasi atau perbarui DataTable
        if ($.fn.DataTable.isDataTable('#refMahasiswa')) {
            // Hancurkan DataTable sebelum inisialisasi ulang
            $('#refMahasiswa').DataTable().destroy();
        }

        initializeDataTable();

        // Set URL Ajax dan muat ulang data tabel
        refMahasiswaTable.ajax.url(buildUrl()).load();
    });
});
</script>
@endpush
