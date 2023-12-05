@extends('layouts.master-dashboard')

@section('title', 'Daftar Pengguna')

@section('content')
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h3 style="font-family: 'Bebas Neue', sans-serif; color: #006633;
                        font-weight: bold; text-align: left; margin-bottom: 1rem">Daftar Pengguna</h3>
                        <hr style="border: 1px solid #C0C0C0">
                    <div class="table-responsive">
                        <table id="logImport" class="display expandable-table table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Operator</th>
                                    <th>Lembaga/Fakultas</th>
                                    <th>Role</th>
                                    <th>Status</th>
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
                url: '/Administrator/Pengaturan/Daftar-Pengguna',
                dataSrc: ''
            },
            columns: [
                { data: null, orderable: false, searchable: false },
                { data: 'nama_pengguna' },
                { data: 'lembaga',
                    render: function (data, type, row, meta) {
                            if(data == 'Dirpp') {
                                return '<p class="mb-0" style="font-size: 12px;">Dir. Pengembangan Pendidikan</p>'
                            } 
                        },
                        className: 'text-center'
                },
                { data: 'role',
                    render: function (data, type, row, meta) {
                            if(data === 1) {
                                return '<p class="mb-0" style="font-size: 12px;">Administrator</p>'
                            }  if(data === 2) {
                                return '<p class="mb-0" style="font-size: 12px;">PIC Universitas</p>'
                            } 
                        },
                        className: 'text-center'
                },
                { data: 'status_id', 
                    render: function (data, type, row, meta) {
                        if(data === 1) {
                            return '<i class="ace-icon fa fa-circle text-success" style="font-size: 16px;"></i><p class="mb-0" style="font-size: 12px;">Online</p>'
                        } else {
                            return '<i class="ace-icon fa fa-circle text-danger" style="font-size: 16px;"></i><p class="mb-0" style="font-size: 12px;">Offline</p>'
                        }
                    },
                    className: 'text-center'
                },
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
