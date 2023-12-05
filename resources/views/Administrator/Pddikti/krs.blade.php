@extends('layouts.master-dashboard')

@section('title', 'KRS Mahasiswa PDDIKTI')

@section('content')
<div class="row" id='filter'>
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h3 style="font-family: 'Bebas Neue', sans-serif; color: #006633;
                        font-weight: bold; text-align: left; margin-bottom: 1rem">Cari Data Mahasiswa</h3>
                        <hr style="border: 1px solid #C0C0C0">
                <form action="#"  method="" enctype="multipart/form-data" id="FilterData">
                    <div class="row">
                        <div class="form-group col-lg-8 d-flex align-items-center">
                            <label style="display: inline-block; width: 40%; text-align: center"><b>Nomor Induk Mahasiswa</b></label>
                            <input type="text" class="form-control ml-2" name="nim" id="nimSelect">
                        </div>
                        <div class="form-group col-lg-4 d-flex align-items-center">
                            <button type="button" class="form-control btn-success" id="btnImport">Cari Mahasiswa</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="row" id="hasil1" style="display: none">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h3 style="font-family: 'Bebas Neue', sans-serif; color: #006633;
                        font-weight: bold; text-align: left; margin-bottom: 1rem">Data Mahasiswa</h3>
                <hr style="border: 1px solid #C0C0C0">
                <form action="#"  method="" enctype="multipart/form-data" id="FilterData">
                    @csrf
                    <div class="row">
                        <div class="form-group col-lg-6 align-items-center">
                            <label><b>Nama Mahasiswa</b></label>
                            <span class="form-control" id="namaMahasiswa"></span>
                        </div>
                        <div class="form-group col-lg-6 align-items-center">
                            <label><b>Nomor Induk Mahasiswa</b></label>
                            <span class="form-control" id="nimMahasiswa"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-lg-6 align-items-center">
                            <label><b>Program Studi</b></label>
                            <span class="form-control" id="prodiMahasiswa"></span>
                        </div>
                        <div class="form-group col-lg-6 align-items-center">
                            <label><b>Angkatan</b></label>
                            <span class="form-control" id="angkatanMahasiswa"></span>
                        </div>
                    </div>
                </form>  
            </div>
        </div>
    </div>
</div>
<div class="row" id="hasil2" style="display: none">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h3 style="font-family: 'Bebas Neue', sans-serif; color: #006633;
                        font-weight: bold; text-align: left; margin-bottom: 1rem">KRS Mahasiswa</h3>
                <hr style="border: 1px solid #C0C0C0">
                <form action="#"  method="" enctype="multipart/form-data" id="FilterData">
                    @csrf
                    <div class="row">
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
                        <div class="form-group col-lg-12">
                            <button type="button" class="form-control btn-success" id="btnImportKrs" onclick="updateTable()">Tampilkan KRS</button>
                        </div>
                    </div>
                </form>
                <div class="table-responsive">
                    <table id="refMahasiswa" class="display expandable-table table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Kelas</th>
                                <th>Kode Mata Kuliah</th>
                                <th>Nama Mata Kuliah</th>
                                <th>SKS Mata Kuliah</th>
                            </tr>
                        </thead>
                    </table>
                </div> 
            </div>
        </div>
    </div>
</div>
<div class="row" id="hasil3" style="display: none">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h3 style="font-family: 'Bebas Neue', sans-serif; color: #006633;
                        font-weight: bold; text-align: left; margin-bottom: 1rem">Aktivitas Kuliah Mahasiswa</h3>
                <hr style="border: 1px solid #C0C0C0">
                <div class="table-responsive">
                    <table id="refMahasiswaAKM" class="display expandable-table table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Semester</th>
                                <th>Status Mahasiswa</th>
                                <th>IPS</th>
                                <th>IPK</th>
                                <th>SKS Semester</th>
                                <th>SKS Total</th>
                                <th>UKT</th>
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
    var div1 = $('#hasil1');
    var div2 = $('#hasil2');
    var div3 = $('#hasil3');
    var nimSelect = $('#nimSelect');
    var semesterSelect = $('#semester');
    var semesterAKMSelect = $('#semesterAKM');
    var refMahasiswaTable;
    var refMahasiswaTableAKM;

    function buildUrlKRS() {
        var nim = nimSelect.val();
        var idPeriode = semesterSelect.val();
        return '/Administrator/Data-Pddikti/KRS/Cari-KRS?nim=' + nim + '&id_periode=' + idPeriode;
    }

    function buildUrlAKM() {
        var nim = nimSelect.val();
        var idPeriodeAKM = semesterAKMSelect.val();
        return '/Administrator/Data-Pddikti/KRS/Cari-AKM?nim=' + nim;
    }

    function initializeDataTableKRS() {
        refMahasiswaTable = $('#refMahasiswa').DataTable({
            
            ajax: {
                url: buildUrlKRS(),
            },
            columns: [
                { data: null, orderable: false, searchable: false },
                { data: 'nama_kelas_kuliah' },
                { data: 'kode_mata_kuliah' },
                { data: 'nama_mata_kuliah' },
                { data: 'sks_mata_kuliah' },
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

    function initializeDataTableAKM() {
        refMahasiswaTableAKM = $('#refMahasiswaAKM').DataTable({
            
            ajax: {
                url: buildUrlAKM(),
            },
            columns: [
                { data: null, orderable: false, searchable: false },
                { data: 'nama_semester' },
                { data: 'nama_status_mahasiswa' },
                { data: 'ips' },
                { data: 'ipk' },
                { data: 'sks_semester' },
                { data: 'sks_total' },
                { data: 'biaya_kuliah_smt' },
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

        refMahasiswaTableAKM.on('order.dt search.dt', function () {
            refMahasiswaTableAKM.column(0, {search:'applied', order:'applied'}).nodes().each(function (cell, i) {
                cell.innerHTML = i + 1;
            });
        });
    }

    $('#btnImport').on('click', function() {
        var nim = nimSelect.val(); // Mengambil nilai terkini dari elemen nimSelect setiap kali tombol diklik

        $.ajax({
            url: '/Administrator/Data-Pddikti/KRS/Cari?nim=' + nim, // URL endpoint yang sesuai untuk mengirim permintaan
            method: 'GET',
            data: {
                // Data yang Anda kirim (jika diperlukan)
            },
            success: function(response) {
                console.log('Response:', response);
                // Menampilkan hasil respons ke dalam elemen <p> dengan ID yang sesuai
                    $('#namaMahasiswa').html(`<p style="font-size: 32">${response['data'][0].nama_mahasiswa}</p>`);
                    $('#nimMahasiswa').html(`<p style="font-size: 32">${response['data'][0].nim}</p>`);
                    $('#prodiMahasiswa').html(`<p style="font-size: 32">${response['data'][0].nama_program_studi}</p>`);
                    $('#angkatanMahasiswa').html(`<p style="font-size: 32">${response['data'][0].nama_periode_masuk}</p>`);
            },
            error: function(error) {
                console.error('Terjadi kesalahan:', error);
            }
        });

        div1.show(); // Menampilkan elemen dengan ID 'hasil'
        div2.show(); // Menampilkan elemen dengan ID 'hasil'
        div3.show(); // Menampilkan elemen dengan ID 'hasil'

        
        // Inisialisasi atau perbarui DataTable
        if ($.fn.DataTable.isDataTable('#refMahasiswa')) {
            // Hancurkan DataTable sebelum inisialisasi ulang
            $('#refMahasiswa').DataTable().destroy();
        }

        initializeDataTableKRS();
        initializeDataTableAKM();

        // Set URL Ajax dan muat ulang data tabel
        refMahasiswaTable.ajax.url(buildUrl()).load();
    });

    $('#btnImportKrs').on('click', function() {
        var nim = nimSelect.val(); // Mengambil nilai terkini dari elemen nimSelect setiap kali tombol diklik
        
        div1.show(); // Menampilkan elemen dengan ID 'hasil'
        div2.show(); // Menampilkan elemen dengan ID 'hasil'
        div3.show(); // Menampilkan elemen dengan ID 'hasil'

        // Inisialisasi atau perbarui DataTable
        if ($.fn.DataTable.isDataTable('#refMahasiswa')) {
            // Hancurkan DataTable sebelum inisialisasi ulang
            $('#refMahasiswa').DataTable().destroy();
        }

        initializeDataTableKRS();

        // Set URL Ajax dan muat ulang data tabel
        refMahasiswaTable.ajax.url(buildUrl()).load();
    });

    $('#btnImportAkm').on('click', function() {
        var nim = nimSelect.val(); // Mengambil nilai terkini dari elemen nimSelect setiap kali tombol diklik
        
        div1.show(); // Menampilkan elemen dengan ID 'hasil'
        div2.show(); // Menampilkan elemen dengan ID 'hasil'
        div3.show(); // Menampilkan elemen dengan ID 'hasil'

        // Inisialisasi atau perbarui DataTable
        if ($.fn.DataTable.isDataTable('#refMahasiswaAKM')) {
            // Hancurkan DataTable sebelum inisialisasi ulang
            $('#refMahasiswaAKM').DataTable().destroy();
        }

        initializeDataTableAKM();

        // Set URL Ajax dan muat ulang data tabel
        refMahasiswaTableAKM.ajax.url(buildUrl()).load();
    });
});

</script>
@endpush
