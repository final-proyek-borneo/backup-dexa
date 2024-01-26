@extends('partial.app')
@section('title', 'Retur Barang')
@section('css')
<style>
    #tb_wrapper .row:nth-child(2) {
        overflow-x: auto;
    }

    .d-flex .flex-row-item {
        flex: 1 1 30%;
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

    .required label:after {
        color: #e32;
        content: ' *';
        display: inline;
    }
</style>
@endsection
@section('content')

<div class="section-body">
    <div class="row">
        <div class="col-12 col-md-4 col-lg-5">
            <div class="card">
                <div class="card-header">
                    <h4>Informasi Umum</h4>
                    <div class="card-header-action">
                        <a data-collapse="#mycard-collapse" class="btn btn-icon btn-info" href="#"><i class="fas fa-minus"></i></a>
                    </div>
                </div>
                <input type="text" id="fc_branch" value="{{ auth()->user()->fc_branch }}" hidden>
                <div class="collapse" id="mycard-collapse">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label>Tanggal :
                                        {{ \Carbon\Carbon::parse($data->created_at)->format('d/m/Y') }}</label>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-6">
                                <div class="form-group">
                                    <label>Operator</label>
                                    <input type="text" class="form-control" name="" id="" value="{{ auth()->user()->fc_username }}" readonly>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group required">
                                    <label>No. Surat Jalan</label>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" value="{{ $data->fc_dono }}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-12">
                                <div class="form-group required">
                                    <label>Tanggal Retur</label>
                                    <div class="input-group" data-date-format="dd-mm-yyyy">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-calendar"></i>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control" value="{{ \Carbon\Carbon::parse($data->fd_returdate)->format('d/m/Y') }}" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-8 col-lg-7">
            <div class="card">
                <div class="card-header">
                    <h4>Detail Surat Jalan</h4>
                    <div class="card-header-action">
                        <a data-collapse="#mycard-collapse2" class="btn btn-icon btn-info" href="#"><i class="fas fa-minus"></i></a>
                    </div>
                </div>
                <div class="collapse" id="mycard-collapse2">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>NPWP</label>
                                    <input type="text" class="form-control" value="{{ $data->domst->somst->customer->fc_membernpwp_no }}" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Nama Customer</label>
                                    <input type="text" class="form-control" value="{{ $data->domst->somst->customer->fc_membername1 }}" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Pajak</label>
                                    <input type="text" class="form-control" value="{{ $data->domst->somst->customer->member_tax_code->fv_description }} ({{ $data->domst->somst->customer->member_tax_code->fc_action }}%)" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Penerima</label>
                                    <input type="text" class="form-control" value="{{ $data->domst->fc_custreceiver }}" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Tanggal Kirim</label>
                                    <input type="text" class="form-control" value="{{ \Carbon\Carbon::parse($data->domst->fd_dodate)->format('d/m/Y') }}" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Tanggal Diterima</label>
                                    <input type="text" class="form-control" value="{{ \Carbon\Carbon::parse($data->domst->fd_doarivaldate)->format('d/m/Y') }}" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-12">
                                <div class="form-group">
                                    <label>Alamat Pengiriman</label>
                                    <input type="text" class="form-control" value="{{ $data->domst->fc_memberaddress_loading }}" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-12 col-lg-6 place_detail">
            <div class="card">
                <div class="card-body" style="padding-top: 30px!important;">
                    <form id="form_submit_noconfirm" action="/apps/retur-barang/detail/store-update" method="POST" autocomplete="off">
                        <div class="row">
                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group required">
                                    <label>Kode Barang</label>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" id="fc_barcode" name="fc_barcode" readonly hidden>
                                        <input type="text" class="form-control" id="fc_batch" name="fc_batch" readonly hidden>
                                        <input type="text" class="form-control" id="fc_namepack" name="fc_namepack" readonly hidden>
                                        <input type="text" class="form-control" id="fc_catnumber" name="fc_catnumber" readonly hidden>
                                        <input type="text" class="form-control" id="fd_expired" name="fd_expired" readonly hidden>
                                        <input type="text" class="form-control" id="fn_price" name="fn_price" readonly hidden>
                                        <input type="text" class="form-control" id="fn_disc" name="fn_disc" readonly hidden>
                                        <input type="text" class="form-control" id="fn_value" name="fn_value" readonly hidden>
                                        <input type="text" class="form-control" id="fc_status" name="fc_status" readonly hidden>
                                        <input type="text" class="form-control" id="fc_stockcode" name="fc_stockcode" readonly>
                                        <input type="text" class="form-control" id="fn_qty_do" name="fn_qty_do" hidden>
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button" onclick="click_modal_do_dtl()"><i class="fa fa-search"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group required">
                                    <label>Qty</label>
                                    <input type="number" min="0" oninput="this.value = !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null" class="form-control" name="fn_returqty" id="fn_returqty" required>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-5">
                                <div class="form-group required">
                                    <label>Harga</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                Rp.
                                            </div>
                                        </div>
                                        <input type="text" class="form-control format-rp" name="fn_price_edit" id="fn_price_edit" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-7">
                                <div class="form-group">
                                    <label>Catatan</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" fdprocessedid="hgh1fp" name="fv_description" id="fv_description">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-12 text-right">
                                <button type="submit" class="btn btn-success ml-1">Tambahkan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-12 col-lg-6 place_detail">
            <div class="card">
                <div class="card-header">
                    <h4>Calculation</h4>
                </div>
                <div class="card-body" style="height: 190px">
                    <div class="d-flex">
                        <div class="flex-row-item" style="margin-right: 30px">
                            <div class="d-flex" style="gap: 5px; white-space: pre">
                                <p class="text-secondary flex-row-item" style="font-size: medium">Item</p>
                                <p class="text-success flex-row-item text-right" style="font-size: medium" id="count_item">0,00</p>
                            </div>
                            <div class="d-flex">
                                <p class="flex-row-item"></p>
                                <p class="flex-row-item text-right"></p>
                            </div>
                            <div class="d-flex" style="gap: 5px; white-space: pre">
                                <p class="text-secondary flex-row-item" style="font-size: medium">Disc. Total</p>
                                <p class="text-success flex-row-item text-right" style="font-size: medium" id="fm_so_disc">0,00</p>
                            </div>
                            <div class="d-flex">
                                <p class="flex-row-item"></p>
                                <p class="flex-row-item text-right"></p>
                            </div>
                            <div class="d-flex" style="gap: 5px; white-space: pre">
                                <p class="text-secondary flex-row-item" style="font-size: medium">Total</p>
                                <p class="text-success flex-row-item text-right" style="font-size: medium" id="total_harga">0,00</p>
                            </div>
                        </div>
                        <div class="flex-row-item">
                            <div class="d-flex" style="gap: 5px; white-space: pre">
                                <p class="text-secondary flex-row-item" style="font-size: medium">Pelayanan</p>
                                <p class="text-success flex-row-item text-right" style="font-size: medium" id="fm_servpay">0,00</p>
                            </div>
                            <div class="d-flex">
                                <p class="flex-row-item"></p>
                                <p class="flex-row-item text-right"></p>
                            </div>
                            <div class="d-flex" style="gap: 5px; white-space: pre">
                                <p class="text-secondary flex-row-item" style="font-size: medium">Pajak</p>
                                <p class="text-success flex-row-item text-right" style="font-size: medium" id="fm_tax">0,00</p>
                            </div>
                            <div class="d-flex">
                                <p class="flex-row-item"></p>
                                <p class="flex-row-item text-right"></p>
                            </div>
                            <div class="d-flex" style="gap: 5px; white-space: pre">
                                <p class="text-secondary flex-row-item" style="font-weight: bold; font-size: medium">GRAND</p>
                                <p class="text-success flex-row-item text-right" style="font-weight: bold; font-size:medium" id="grand_total">Rp. 0,00</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- RETUR ITEM --}}
        <div class="col-12 col-md-12 col-lg-12 place_detail">
            <div class="card">
                <div class="card-header">
                    <h4>Item yang Diretur</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table table-striped" id="tb" width="100%">
                                <thead style="white-space: nowrap">
                                    <tr>
                                        <th scope="col" class="text-center">No</th>
                                        <th scope="col" class="text-center">Kode Barang</th>
                                        <th scope="col" class="text-center">Nama Barang</th>
                                        <th scope="col" class="text-center">Satuan</th>
                                        <th scope="col" class="text-center">Batch</th>
                                        <th scope="col" class="text-center">Exp.</th>
                                        <th scope="col" class="text-center">CAT.</th>
                                        <th scope="col" class="text-center">Qty Retur</th>
                                        <th scope="col" class="text-center">Harga</th>
                                        <th scope="col" class="text-center">Catatan</th>
                                        <th scope="col" class="text-center" style="width: 20%">Actions</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="button text-right mb-4">
        <form id="form_submit_edit" action="/apps/retur-barang/detail/submit" method="post">
            <button type="button" onclick="click_cancel()" class="btn btn-danger mr-1">Cancel</button>
            @csrf
            @method('put')
            <button type="submit" class="btn btn-success">Submit Retur</button>
        </form>
    </div>
</div>
@endsection

@section('modal')
<div class="modal fade" role="dialog" id="modal_do_dtl" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header br">
                <h5 class="modal-title">Pilih Stock</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_ttd" autocomplete="off">
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="tb_do_dtl" width="100%">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">No</th>
                                    <th scope="col" class="text-center">Kode Barang</th>
                                    <th scope="col" class="text-center">Nama Barang</th>
                                    <th scope="col" class="text-center">Satuan</th>
                                    <th scope="col" class="text-center">Qty</th>
                                    <th scope="col" class="text-center">Qty Retur</th>
                                    <th scope="col" class="text-center">Exp. Date</th>
                                    <th scope="col" class="text-center">Batch</th>
                                    <th scope="col" class="text-center">Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </form>
            <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    var dono = "{{ $data->fc_dono }}";
    var encode_dono = window.btoa(dono);
    // console.log(encode_dono)

    function click_modal_do_dtl() {
        $('#modal_do_dtl').modal('show');
        table_do_dtl();
    }

    function table_do_dtl() {
        var tb_do_dtl = $('#tb_do_dtl').DataTable({
            // apabila data kosong
            processing: true,
            serverSide: true,
            destroy: true,
            ajax: {
                url: "/apps/retur-barang/detail/datatables-do-detail/" + encode_dono,
                type: 'GET',
            },
            columnDefs: [{
                className: 'text-center',
                targets: [0, 1, 2, 3, 4, 5, 6, 7, 8]
            }, ],
            columns: [{
                    data: 'DT_RowIndex',
                    searchable: false,
                    orderable: false
                },
                {
                    data: 'invstore.stock.fc_stockcode'
                },
                {
                    data: 'invstore.stock.fc_namelong'
                },
                {
                    data: 'invstore.stock.fc_namepack'
                },
                {
                    data: 'fn_qty_do'
                },
                {
                    data: 'fn_qty_retur'
                },
                {
                    data: 'fd_expired',
                    render: formatTimestamp
                },
                {
                    data: 'fc_batch'
                },
                {
                    data: null
                },
            ],
            rowCallback: function(row, data) {
                $('td:eq(8)', row).html(`
                    <button type="button" class="btn btn-warning btn-sm" onclick="detail_stock_barang('${data.fc_barcode}','${data.invstore.stock.fc_stockcode}')"><i class="fa fa-check"> </i> Pilih</button>
                `);
            },
        });
    }

    var tb = $('#tb').DataTable({
        // apabila data kosongs
        processing: true,
        serverSide: true,
        destroy: true,
        ajax: {
            url: "/apps/retur-barang/detail/datatables",
            type: 'GET',
        },
        columnDefs: [{
                className: 'text-center',
                targets: [0, 3, 4, 5, 6, 7, 8, 9, 10]
            },
            {
                className: 'text-nowrap',
                targets: [10]
            },
            {
                targets: -1,
                data: null,
                defaultContent: '<button class="btn btn-danger btn-sm delete-btn"><i class="fa fa-trash"></i> Hapus Item</button>'
            }
        ],
        columns: [{
                data: 'DT_RowIndex',
                searchable: false,
                orderable: false
            },
            {
                data: 'fc_barcode'
            },
            {
                data: 'invstore.stock.fc_namelong'
            },
            {
                data: 'fc_namepack'
            },
            {
                data: 'fc_batch'
            },
            {
                data: 'fd_expired',
                "render": function(data, type, row) {
                    return moment(data).format(
                        // format tanggal
                        'DD MMMM YYYY'
                    );
                }
            },
            {
                data: 'fc_catnumber'
            },
            {
                data: 'fn_returqty'
            },
            {
                data: 'fn_price',
                render: $.fn.dataTable.render.number(',', '.', 0, 'Rp')
            },
            {
                data: 'fv_description',
                defaultContent: '-'
            },
            {
                data: null
            }

        ],
        rowCallback: function(row, data) {
            const item_barcode = data.fc_barcode;
            const item_row = data.fn_rownum;
            // kirim 2 parameter di data-id di button hapus
            $('td:eq(10)', row).html(`
                    <button class="btn btn-danger btn-sm delete-btn" data-id="${item_barcode}" data-row="${item_row}"><i class="fa fa-trash"></i> Hapus Item</button>
                `);
        },
        footerCallback: function(row, data, start, end, display) {
            if (data.length != 0) {
                $('#fm_servpay_calculate').html("Rp. " + fungsiRupiah(data[0].returmst.fm_servpay));
                $("#fm_servpay_calculate").trigger("change");
                $('#fm_tax').html("Rp. " + fungsiRupiah(data[0].returmst.fm_tax));
                $("#fm_tax").trigger("change");
                $('#grand_total').html("Rp. " + fungsiRupiah(data[0].returmst.fm_brutto));
                $("#grand_total").trigger("change");
                $('#total_harga').html("Rp. " + fungsiRupiah(data[0].returmst.fm_netto));
                $("#total_harga").trigger("change");
                $('#fm_disctotal').html("Rp. " + fungsiRupiah(data[0].returmst.fm_disctotal));
                $("#fm_disctotal").trigger("change");
                $('#count_item').html(data[0].returmst.fn_invdetail);
                $("#count_item").trigger("change");
            }
        },
        initComplete: function() {
            $('table').on('click', '.delete-btn', function(e) {
                e.preventDefault();
                var barcode = $(this).data('id');
                // data row
                var row = $(this).data('row');
                // console.log(barcode);
                swal({
                        title: "Anda yakin ingin menghapus item ini?",
                        icon: "warning",
                        buttons: ["Batal", "Hapus"],
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        // modal loading
                        $('#modal_loading').modal('show');
                        if (willDelete) {
                            $.ajax({
                                url: '/apps/retur-barang/detail/delete-item/' + barcode +
                                    '/' + row,
                                type: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                        'content')
                                },
                                success: function(response) {
                                    // tutup modal loading
                                    console.log(response.status)
                                    if (response.status == 200) {
                                        setTimeout(function() {
                                            $('#modal_loading').modal(
                                                'hide');
                                        }, 500);
                                        // deliver_item.ajax.reload();
                                        tb.ajax.reload();
                                        swal("Item telah dihapus!", {
                                            icon: "success",
                                        });
                                    } else if (response.status == 201) {
                                        setTimeout(function() {
                                            $('#modal_loading').modal(
                                                'hide');
                                        }, 500);
                                        // deliver_item.ajax.reload();
                                        tb.ajax.reload();
                                        swal("Item telah dihapus!", {
                                            icon: "success",
                                        });
                                        location.href = response.link;
                                    }
                                },
                                error: function(xhr) {
                                    $('#modal_loading').modal('hide');
                                    swal("Oops!",
                                        "Terjadi kesalahan saat menghapus item.",
                                        "error");
                                }
                            });
                        } else {
                            setTimeout(function() {
                                $('#modal_loading').modal(
                                    'hide');
                            }, 500);
                        }
                    });
            });
        },
    });

    function detail_stock_barang($id, fc_stockcode) {
        var fc_barcode = window.btoa($id)
        // console.log(fc_barcode)
        $.ajax({
            url: "/master/get-data-where-field-id-first/DoDetail/fc_barcode/" + fc_barcode,
            type: "GET",
            dataType: "JSON",
            success: function(response) {
                $("#modal_do_dtl").modal('hide');
                var data = response.data;
                // $('#fn_price').val(fungsiRupiah(data.fn_price))
                $('#fc_stockcode').val(fc_stockcode);
                $('#fc_barcode').val($id);
                $('#fc_batch').val(data.fc_batch);
                $('#fc_namepack').val(data.fc_namepack);
                $('#fc_catnumber').val(data.fc_catnumber);
                $('#fd_expired').val(data.fd_expired);
                $('#fn_price').val(data.fn_price);
                $('#fn_disc').val(data.fn_disc);
                $('#fn_value').val(data.fn_value);
                $('#fc_status').val(data.fc_status);
                $('#fn_qty_do').val(data.fn_qty_do);
                $('#fn_price_edit').val(data.fn_price);
                $('#fn_returqty').val(data.fn_qty_do);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                setTimeout(function() {
                    $('#modal_loading').modal('hide');
                }, 500);
                swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + errorThrown + ")", {
                    icon: 'error',
                });
            }
        });
    }

    function click_cancel() {
        swal({
                title: 'Apakah anda yakin?',
                text: 'Apakah anda yakin akan mengcancel Retur Barang ini?',
                icon: 'warning',
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $("#modal_loading").modal('show');
                    $.ajax({
                        url: '/apps/retur-barang/cancel',
                        type: "DELETE",
                        dataType: "JSON",
                        success: function(response) {
                            setTimeout(function() {
                                $('#modal_loading').modal('hide');
                            }, 500);
                            if (response.status === 201) {
                                $("#modal").modal('hide');
                                iziToast.success({
                                    title: 'Success!',
                                    message: response.message,
                                    position: 'topRight'
                                });
                                window.location.href = response.link;
                            } else {
                                swal(response.message, {
                                    icon: 'error',
                                });
                            }

                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            setTimeout(function() {
                                $('#modal_loading').modal('hide');
                            }, 500);
                            swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + jqXHR
                                .responseText + ")", {
                                    icon: 'error',
                                });
                        }
                    });
                }
            });
    }

    $('#form_submit_noconfirm').on('submit', function(e) {
        e.preventDefault();

        var form_id = $(this).attr("id");
        if (check_required(form_id) === false) {
            swal("Oops! Mohon isi field yang kosong", {
                icon: 'warning',
            });
            return;
        }

        $("#modal_loading").modal('show');
        $.ajax({
            url: $('#form_submit_noconfirm').attr('action'),
            type: $('#form_submit_noconfirm').attr('method'),
            data: $('#form_submit_noconfirm').serialize(),
            success: function(response) {

                setTimeout(function() {
                    $('#modal_loading').modal('hide');
                }, 500);
                if (response.status == 200) {
                    // swal(response.message, { icon: 'success', });
                    $("#modal").modal('hide');
                    $("#form_submit_noconfirm")[0].reset();
                    reset_all_select();
                    tb.ajax.reload(null, false);
                    if (response.total < 1) {
                        window.location.href = response.link;
                    }
                } else if (response.status == 201) {
                    swal(response.message, {
                        icon: 'success',
                    });
                    $("#modal").modal('hide');
                    tb.ajax.reload(null, false);
                    location.href = location.href;
                } else if (response.status == 203) {
                    swal(response.message, {
                        icon: 'success',
                    });
                    $("#modal").modal('hide');
                    tb.ajax.reload(null, false);
                } else if (response.status == 300) {
                    swal(response.message, {
                        icon: 'error',
                    });
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                setTimeout(function() {
                    $('#modal_loading').modal('hide');
                }, 500);
                swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + jqXHR.responseText + ")", {
                    icon: 'error',
                });
            }
        });
    });
</script>
@endsection