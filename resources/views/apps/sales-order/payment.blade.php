@extends('partial.app')
@section('title', 'Payment')
@section('css')
    <style>
        #tb_wrapper .row:nth-child(2) {
            overflow-x: auto;
        }

        .text-secondary {
            color: #969DA4 !important;
        }

        .text-success {
            color: #28a745 !important;
        }

        .btn-secondary {
            background-color: #A5A5A5 !important;
        }

        @media (min-width: 992px) and (max-width: 1200px) {
            .flex-row-item {
                font-size: 12px;
            }

            .grand-text {
                font-size: .9rem;
            }
        }
    </style>
@endsection
@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- flash message container --}}
    <div id="alert-bayar"></div>


    <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form action="">
                        <div class="form-row">
                            <div class="col-6 col-md-3 col-lg-3">
                                <div class="form-group mr-3">
                                    <label>Date Order</label>
                                    <div class="input-group date" data-date-format="dd-mm-yyyy">
                                        <input type="text" id="fd_sodateinputuser" class="form-control"
                                            fdprocessedid="8ovz8a" onchange="saveFormInput(this)" required>
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-calendar"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-md-3 col-lg-3">
                                <div class="form-group mr-3">
                                    <label>Date Expired</label>
                                    <div class="input-group date" data-date-format="dd-mm-yyyy">
                                        <input type="text" id="fd_soexpired" onchange="saveFormInput(this)"
                                            class="form-control" fdprocessedid="8ovz8a" required>
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-calendar"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-3 col-lg-2">
                                <div class="form-group d-flex-row">
                                    <label>Total</label>
                                    <div class="text mt-2">
                                        <h5 class="text-success" style="font-weight: bold; font-size:large" value=" "
                                            id="grand_total" name="grand_total">Rp. 0,00</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-3 col-lg-2">
                                <div class="form-group d-flex-row">
                                    <label id="label_kekurangan">Kekurangan</label>
                                    <div class="text mt-2">
                                        <h5 class="text-danger" style="font-weight: bold; font-size:large" id="kekurangan">
                                            Rp. 0,00</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-3 col-lg-2">
                                <div class="form-group d-flex-row">
                                    <label>Hutang</label>
                                    <div class="text mt-2">
                                        <h5 class="text-muted" style="font-weight: bold; font-size:large" id="">Rp.
                                            0,00</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-12 col-lg-4">
            <div class="card">
                <div class="card-body" style="padding-top: 30px!important;">
                    <form id="form_submit" action="/apps/sales-order/detail/payment/store-update/{{ $data->fc_sono }}"
                        method="POST" autocomplete="off">
                        @csrf
                        @method('PUT')
                        <div class="col-12 col-md-12 col-lg-12 pr-0 pl-0">
                            <div class="form-group">
                                <label>Transport</label>
                                @if (empty($data->fc_sotransport))
                                    <select class="form-control select2" name="fc_sotransport" id="fc_sotransport">
                                        <option value="" selected disabled>- Pilih Transport -</option>
                                        <option value="By Dexa">By Dexa</option>
                                        <option value="By Paket">By Paket</option>
                                        <option value="By Customer">By Customer</option>
                                    </select>
                                @else
                                    <select class="form-control select2" name="fc_sotransport" id="fc_sotransport">
                                        <option value="{{ $data->fc_sotransport }}" selected>
                                           -- {{ $data->fc_sotransport }} --
                                        </option>
                                        <option value="By Dexa">By Dexa</option>
                                        <option value="By Paket">By Paket</option>
                                        <option value="By Customer">By Customer</option>
                                    </select>
                                @endif
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-12 pr-0 pl-0">
                            <div class="form-group">
                                <label>Pelayanan</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            Rp.
                                        </div>
                                    </div>
                                    @if ($data->fm_servpay == 0)
                                        <input type="text" class="form-control format-rp" name="fm_servpay"
                                            id="fm_servpay" value="0" fdprocessedid="hgh1fp"
                                            onkeyup="return onkeyupRupiah(this.id);" required>
                                    @else
                                        <input type="text" class="form-control format-rp" name="fm_servpay"
                                            id="fm_servpay" onkeyup="return onkeyupRupiah(this.id);"
                                            value="{{ number_format($data->fm_servpay,0,',','.') }}">
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-12 pr-0 pl-0">
                            <div class="form-group">
                                <label>Alamat Tujuan</label>
                                <textarea type="text" name="fc_memberaddress_loading1" class="form-control" id="fc_memberaddress_loading1"
                                    data-height="100" readonly><?php echo $data->customer->fc_memberaddress_loading1; ?></textarea>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-12 text-right">
                            @if ($data->fm_servpay == 0 && empty($data->fc_sotransport))
                                <button type="submit" class="btn btn-success">Save</button>
                            @else
                                <button type="submit" class="btn btn-warning">Edit</button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-12 col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h4>Metode Pembayaran</h4>
                    <div class="card-header-action">
                        <button type="button" class="btn btn-success" data-toggle="modal"
                            data-target="#modal_payment"><i class="fa fa-plus mr-1"></i>Tambah Metode</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table table-striped" id="tb" width="100%">
                                <thead style="white-space: nowrap">
                                    <tr>
                                        <th scope="col" class="text-center">Kode Metode Pembayaran</th>
                                        <th scope="col" class="text-center">Deskripsi Metode</th>
                                        <th scope="col" class="text-center">Nominal</th>
                                        <th scope="col" class="text-center">Tanggal</th>
                                        <th scope="col" class="text-center">Keterangan</th>
                                        <th scope="col" class="text-center" style="width: 10%">Actions</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="button text-right mb-4">

                <a href="/apps/sales-order"><button type="button" class="btn btn-info mr-2">Back</button></a>
                <a href="/apps/sales-order/detail/payment/pdf" target="_blank"><button id="preview_button"
                        class="btn btn-primary mr-2">Preview SO</button></a>

                @if ($data->fc_sostatus === 'F')
                    <button id="submit_button" class="btn btn-success" disabled>Submit</button>
                @else
                    <button id="submit_button" class="btn btn-success">Submit</button>
                @endif

            </div>
        </div>
    </div>
    </div>
@endsection

@section('modal')
    <div class="modal fade" role="dialog" id="modal_payment" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-m" role="document">
            <div class="modal-content">
                <div class="modal-header br">
                    <h5 class="modal-title">Pilih Metode</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form_submit" action="/apps/sales-order/detail/payment/create" method="POST"
                    autocomplete="off">
                    @csrf
                    <input type="text" name="type" id="type" hidden>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label>Kode Metode Pembayaran</label>
                                    <select class="form-control select2 " name="fc_kode" id="fc_kode" required>
                                        <option value="">-- Pilih Kode Bayar --</option>
                                        @foreach ($kode_bayar as $kode)
                                            <option value="{{ $kode->fc_kode }}">{{ $kode->fc_kode }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-12">
                                <div id="fv_description" class="form-group">
                                    <label>Deskripsi Metode</label>
                                    <input type="text" class="form-control " name="fc_description" readonly>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label>Nominal</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                Rp.
                                            </div>
                                        </div>
                                        <input type="text" class="form-control format-rp" name="fm_valuepayment"
                                            id="fm_valuepayment" onkeyup="return onkeyupRupiah(this.id);" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label>Tanggal</label>
                                    <div class="input-group" data-date-format="dd-mm-yyyy">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-calendar"></i>
                                            </div>
                                        </div>
                                        {{-- input waktu sekarang format timestamp tipe hidden --}}
                                        <input type="hidden" class="form-control" name="fd_sodatesysinput"
                                            id="fd_sodatesysinput" value="{{ date('d-m-Y') }}">

                                        <input type="text" id="fd_paymentdate2" class="form-control datepicker"
                                            name="fd_paymentdate" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label>Keterangan</label>
                                    <textarea name="fv_keterangan" id="" style="height: 70px" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-whitesmoke br">
                        <button type="submit" class="btn btn-success">Konfirmasi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('alert')
    <div class="section-body">
        <div class="modal" id="alertModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Pemberitahuan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p id="alert-message">{{ session('error') }}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @section('js')
        <script>
            // setting ajax csrf
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            function get_date_order() {
                var input1 = document.getElementById("fd_paymentdate").value;
                document.getElementById("fd_paymentdate2").value = input1;
            }

            $(document).ready(function() {
                $('#fc_kode').on('change', function() {
                    var option_id = $(this).val();
                    $('#fv_description').empty();
                    if (option_id != "") {
                        $.ajax({
                            url: "{{ url('/apps/sales-order/detail/payment/getdata') }}/" + option_id,
                            type: "GET",
                            dataType: "json",
                            success: function(fc_kode) {
                                $.each(fc_kode, function(key, value) {

                                    $('#fv_description').append(
                                        '<label>Deskripsi Bayar</label><input type="text" value="' +
                                        value['fv_description'] +
                                        '" class="form-control " name="fc_description" id="fv_description" readonly>'
                                    );

                                });
                            }
                        });
                    } else {
                        $('#fv_description').empty();
                    }
                });
            });

            $("#submit_button").click(function() {
                swal({
                        title: 'Apakah anda yakin?',
                        text: 'Apakah anda yakin akan menyimpan data SO ini?',
                        icon: 'warning',
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((save) => {
                        if (save) {
                            $("#modal_loading").modal('show');
                            var data = {
                                'fd_sodateinputuser': $('#fd_sodateinputuser').val(),
                                'fd_soexpired': $('#fd_soexpired').val()
                            };
                            $.ajax({
                                type: 'POST',
                                url: '/apps/sales-order/detail/payment/submit',
                                data: data,
                                success: function(response) {
                                    // tampilkan modal section alert
                                    if (response.status == 300 || response.status == 301) {
                                        // hide loading
                                        setTimeout(function() {
                                            $('#modal_loading').modal('hide');
                                        }, 500);
                                        $('#alert-message').html(response.message);
                                        $('#alertModal').modal('show');
                                    } else {
                                        setTimeout(function() {
                                            $('#modal_loading').modal('hide');
                                        }, 500);
                                        // tampilkan flas message bootstrap id alert-bayar
                                        $('#alert-bayar').append(
                                            '<div class="alert alert-success alert-dismissible show fade"><div class="alert-body"><button class="close" data-dismiss="alert"><span>&times;</span></button>' +
                                            response.message + '</div></div>');
                                        // redirect ke halaman sales order
                                        // hapus local storage
                                        localStorage.removeItem('fd_sodateinputuser');
                                        localStorage.removeItem('fd_soexpired');
                                        window.location.href = "/apps/sales-order";


                                    }
                                }
                            });
                        }
                    });


            });


            // alert modal error
            var error = "{{ session('error') }}";
            $(document).ready(function() {
                if (error) {
                    $('#alertModal').modal('show');
                }
            });

            $('document').ready(function() {
                $('.input-group.date').datepicker({
                    changeMonth: true,
                    changeYear: true,
                });
            });
            // ajax tanpa datatable untuk get data dari apps/sales-order/detail/datatables
            $.ajax({
                url: "{{ url('apps/sales-order/detail/datatables') }}",
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    let count_quantity = 0;
                    let total_harga = 0;
                    let grand_total = 0;

                    for (var i = 0; i < data.data.length; i++) {
                        count_quantity += parseFloat(data.data[i].fn_so_qty);
                        total_harga += parseFloat(data.data[i].total_harga);
                        grand_total += parseFloat(data.data[i].total_harga);
                    }

                    var total_kurang = data.data[0].tempsomst.fm_brutto -
                        data.data[0].nominal == data.data[0].tempsomst.fm_brutto ? data.data[0].tempsomst
                        .fm_brutto :
                        data.data[0].tempsomst.fm_brutto - data.data[0].nominal;

                    // console.log(data.data[0].nominal);
                    // console.log(data.data[0].tempsomst.fm_brutto);

                    // $('#grand_total').html("Rp. " + fungsiRupiah(parseFloat(grand_total + data.data[0].tempsomst
                    //     .fm_servpay)));
                    $('#grand_total').html("Rp. " + fungsiRupiah(parseFloat(data.data[0].tempsomst.fm_brutto)));
                    if (data.data[0].nominal > data.data[0].tempsomst.fm_brutto) {
                        // ubah label_kekurangan htmlnya menjadi "kelebihan"
                        $('#label_kekurangan').html('<b>Kelebihan Pembayaran</b>');
                        $('#kekurangan').html("Rp. " + fungsiRupiah(parseFloat(data.data[0].nominal - data.data[0]
                            .tempsomst.fm_brutto)));
                    } else {
                        $('#label_kekurangan').html('<b>Kekurangan</b>');
                        $('#kekurangan').html("Rp. " + fungsiRupiah(parseFloat(total_kurang)));
                    }
                    // console.log(grand_total + data.data[0].tempsomst.fm_servpay);
                    if (data.data[0].nominal - data.data[0].tempsomst.fm_brutto != 0) {
                        $('#fm_valuepayment').val(fungsiRupiah(parseFloat(data.data[0].nominal - data.data[0]
                            .tempsomst.fm_brutto)));
                    } else {
                        $('#fm_valuepayment').val(fungsiRupiah(parseFloat(data.data[0].tempsomst.fm_brutto)));
                    }

                }
            });

            // function get_date_order() {
            //     var input1 = document.getElementById("fd_paymentdate").value;
            //     document.getElementById("fd_paymentdate2").value = input1;
            // }

            function formatTimestamp(timestamp) {
                var date = new Date(timestamp);
                var day = date.getDate();
                var month = date.getMonth() + 1;
                var year = date.getFullYear();
                return day + '-' + month + '-' + year;
            }

            // datatable
            var tb = $('#tb').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('get_datatables') }}",
                columns: [{
                        data: 'fc_sopaymentcode',
                        name: 'Kode Metode Pembayaran'
                    },
                    {
                        data: 'fc_description',
                        name: 'Deskripsi Metode'
                    },
                    {
                        data: 'fm_valuepayment',
                        render: $.fn.dataTable.render.number(',', '.', 0, 'Rp'),
                        name: 'Nominal'
                    },
                    {
                        data: "fd_paymentdate",
                        render: formatTimestamp
                    },
                    {
                        data: 'fv_keterangan',
                        name: 'Keterangan'
                    },
                    // render tombol delete

                    {
                        data: null,
                        orderable: false,
                        searchable: false
                    }
                ],
                rowCallback: function(row, data) {
                    var url_delete = "/apps/sales-order/detail/payment/delete/" + data.fc_sono + '/' + data
                        .fn_sopayrownum;

                    $('td:eq(5)', row).html(`
                <button class="btn btn-danger btn-sm" onclick="delete_action('${url_delete}','SO Payment')"><i class="fa fa-trash"> </i> Hapus</button>
            `);
                },
            });

            // date expired dan date order
            function saveFormInput(element) {
                localStorage.setItem(element.id, element.value);
            }

            window.onload = function() {
                let fd_sodateinputuser = document.getElementById("fd_sodateinputuser");
                let fd_soexpired = document.getElementById("fd_soexpired");

                if (localStorage.getItem("fd_sodateinputuser")) {
                    fd_sodateinputuser.value = localStorage.getItem("fd_sodateinputuser");
                }

                if (localStorage.getItem("fd_soexpired")) {
                    fd_soexpired.value = localStorage.getItem("fd_soexpired");
                }
            };
        </script>
    @endsection

    {{-- @php
    var_dump($data->fc_sono)
@endphp --}}
