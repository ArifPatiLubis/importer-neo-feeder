@extends('layouts.master-dashboard')

@section('title', 'Referensi Pembiayaan')

@section('content')
<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h3 style="font-family: 'Bebas Neue', sans-serif; color: #006633;
                        font-weight: bold; text-align: left; margin-bottom: 1rem">Referensi Pembiayaan</h3>
                        <hr style="border: 1px solid #C0C0C0; margin-bottom: 2rem">
                <div class="table-responsive">
                    <table id="refPembiayaan" class="display expandable-table table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID Pembiayaan</th>
                                <th>Nama Pembiayaan</th>
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
        $('#refPembiayaan').DataTable({
            ajax: {
                url: '/Administrator/Referensi/Pembiayaan'
            },
            columns: [
                { data: 'id_pembiayaan' },
                { data: 'nama_pembiayaan' }
            ]
        });
    });
</script>
@endpush
