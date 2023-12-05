@extends('layouts.master-dashboard')

@section('title', 'Program Studi')

@section('content')
<div class="row">
    <div class="col-xl-12 grid-margin">
        <div class="row">
            <div class="col-md-12 mb-4 stretch-card" >
                <div class="card card-tale">
                    <div class="card-body">
                        <h3 style="font-family: 'Bebas Neue', sans-serif; color: #006633;
                        font-weight: bold; text-align: left; margin-bottom: 1rem">Daftar Program Studi</h3>
                        <hr style="border: 1px solid #C0C0C0">
                        <div class="table-responsive">
                            <table id="refProdi" class="display expandable-table table-hover" style="width:100%; color:black">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Kode Program Studi</th>
                                        <th>Nama Program Studi</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                            </table>
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
<script>
    $(document).ready(function() {
        let table = $('#refProdi').DataTable({
            ajax: {
                url: '/Administrator/Beranda/Program-Studi'
            },
            columns: [
                { data: null, orderable: false, searchable: false },
                { data: 'kode_program_studi' },
                { data: null,
                    render: function(data, type, full, meta){
                    return full["nama_jenjang_pendidikan"] + " " + full["nama_program_studi"];
                }},
                { data: 'status' }
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


