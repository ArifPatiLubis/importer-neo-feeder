@extends('layouts.master-dashboard')

@section('title', 'Referensi Wilayah')

@section('content')
<div class="row">
    <div class="col-xl-12 grid-margin">
        <div class="row">
            <div class="col-md-12 mb-4 stretch-card" >
                <div class="card card-tale" style="padding: 10px 30px; background-color: white; color: black">
                    <div class="card-body">
                        <h3 style="font-family: 'Bebas Neue', sans-serif; color: #006633;
                        font-weight: bold; text-align: left; margin-bottom: 1rem">Referensi Kode Wilayah</h3>
                        <hr style="border: 1px solid #C0C0C0">
                        <form>
                            <div class="row">
                                <div class="form-group col-lg-3" id="level1">
                                    <label>Negara</label>
                                    <select class="form-control" id="negara" name="negara">
                                        <option value="ID">Indonesia</option>
                                        @foreach ($negara['data'] as $negara)
                                        <option value="{{ $negara['id_wilayah'] }}">
                                            {{ $negara['nama_wilayah'] }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-lg-3" id="level2">
                                    <label>Provinsi</label>
                                    <select class="form-control" id="provinsi" name="provinsi">
                                    </select>
                                </div>
                                <div class="form-group col-lg-3" id="level3">
                                    <label>Kota/Kabupaten</label>
                                    <select class="form-control" id="kota" name="kota">
                                    </select>
                                </div>
                                <div class="form-group col-lg-3" id="level4">
                                    <label>Kecamatan</label>
                                    <select class="form-control" id="kecamatan" name="kecamatan">
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="mb-4" style="font-family: 'Bebas Neue', sans-serif; color: #006633;
                                            font-weight: light; text-align: left; margin-bottom: 1rem">ID Wilayah</h5>
                                            <h4 class="fs-30" id="wilayah" style="font-family: 'Bebas Neue', sans-serif; color: #006633;
                                            font-weight: bold; text-align: left; margin-left: 1rem">
                                            <h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
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
        $('#level2').hide();
        $('#level3').hide();
        $('#level4').hide();

        $('#negara').on('change', function() {
            $('#wilayah').html('');

            let negara = $(this).val();

            if(negara == 'ID') {
                $('#level2').show();

                $.ajax({
                    type: 'get',
                    url: '/Administrator/Referensi/Wilayah-Provinsi',
                    dataType: 'json',
                    beforeSend: function () {
                        $('#provinsi').html('');
                    },
                    success: function(response) {
                        $('#level2').show('');
                        $.each(response.data, function(i, val) {
                            $('#provinsi').append(
                                `
                                <option value="${val.id_wilayah}">${val.nama_wilayah}</option>
                                `
                            );
                        });
                        $('#provinsi').selectpicker('refresh');
                        $('#provinsi').selectpicker('render');
                    }
                });
            } else {
                $('#provinsi').html('');
                $('#level2').hide();
                $('#level3').hide();
                $('#level4').hide();
                $('#wilayah').html(negara);
            }
        });

        $('#provinsi').on('change', function() {
            let data = {
                provinsi: $(this).val(),
            }

            $.ajax({
                type: 'get',
                url: '/Administrator/Referensi/Wilayah-Provinsi-Kota',
                data: data,
                dataType: 'json',
                beforeSend: function () {
                    $('#kota').html('');
                    $('#wilayah').html('');
                    $('#level4').hide();
                },
                success: function(response) {
                    $('#level3').show('');
                    $.each(response.data, function(i, val) {
                        $('#kota').append(
                            `
                            <option value="${val.id_wilayah}">${val.nama_wilayah}</option>
                            `
                        );
                    });
                    $('#kota').selectpicker('refresh');
                    $('#kota').selectpicker('render');
                }
            });
        });

        $('#kota').on('change', function() {
            let data = {
                kota: $(this).val(),
            }

            $.ajax({
                type: 'get',
                url: '/Administrator/Referensi/Wilayah-Provinsi-Kota-Kecamatan',
                data: data,
                dataType: 'json',
                beforeSend: function () {
                    $('#kecamatan').html('');
                    $('#wilayah').html('');
                },
                success: function(response) {
                    $('#level4').show('');
                    $.each(response.data, function(i, val) {
                        $('#kecamatan').append(
                            `
                            <option value="${val.id_wilayah}">${val.nama_wilayah}</option>
                            `
                        );
                    });
                    $('#kecamatan').selectpicker('refresh');
                    $('#kecamatan').selectpicker('render');
                }
            });
        });

        $('#kecamatan').on('change', function() {
            let data = {
                kecamatan: $(this).val(),
            }

            $('#wilayah').html(data.kecamatan);
        });
    });
</script>
@endpush


