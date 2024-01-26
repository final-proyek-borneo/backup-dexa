@extends('partial.app')
@section('title', 'BPB Performa')
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
        display:inline;
    }
</style>
@endsection
@section('content')

<div class="section-body">
    <div class="row">
        <div class="col-12 col-md-4 col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h4>Informasi Umum</h4>
                    <div class="card-header-action">
                        <a data-collapse="#mycard-collapse" class="btn btn-icon btn-info" href="#"><i class="fas fa-minus"></i></a>
                    </div>
                </div>
                <div class="collapse" id="mycard-collapse">
                    <input type="text" id="fc_branch" value="{{ auth()->user()->fc_branch }}" hidden>
                    <form id="form_submit" action="/apps/purchase-order/store-update" method="POST" autocomplete="off">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label>Order : {{ date('d-m-Y', strtotime($data->fd_podateinputuser)) }}
                                        </label>
                                    </div>
                                </div>
                                <div class="col-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label>No. PO : {{ $data->fc_pono }}
                                        </label>
                                    </div>
                                </div>
                                <div class="col-12 col-md-12 col-lg-6" style="white-space: nowrap;">
                                    <div class="form-group">
                                        <label>Tipe : {{ $data->fc_potype }}
                                        </label>
                                    </div>
                                </div>
                                <div class="col-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label>Operator</label>
                                        <input type="text" class="form-control" value="{{ auth()->user()->fc_username }}" readonly>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label>No. Surat Jalan</label>
                                        <input type="text" value="{{ $ro_master->fc_sjno }}" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="col-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label>Penerima</label>
                                        <input type="text" value="{{ $ro_master->fc_receiver }}" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="col-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label>Tanggal Diterima</label>
                                        <div class="input-group" data-date-format="dd-mm-yyyy">
                                            <input type="text" id="" class="form-control datepicker" name="fd_roarivaldate" value="{{ date('d-m-Y', strtotime ($ro_master->fd_roarivaldate)) }}" required readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-8 col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h4>Detail Supplier</h4>
                    <div class="card-header-action">
                        <a data-collapse="#mycard-collapse2" class="btn btn-icon btn-info" href="#"><i class="fas fa-minus"></i></a>
                    </div>
                </div>
                <div class="collapse" id="mycard-collapse2">
                    <div class="card-body" style="height: 303px">
                        <div class="row">
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>NPWP</label>
                                    <input type="text" class="form-control" value="{{ $data->supplier->fc_supplierNPWP }}" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Tipe Cabang</label>
                                    <input type="text" class="form-control" value="{{ $data->supplier->supplier_typebranch->fv_description }}" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Tipe Bisnis</label>
                                    <input type="text" class="form-control" value="{{ $data->supplier->supplier_type_business->fv_description }}" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Nama</label>
                                    <input type="text" class="form-control" value="{{ $data->supplier->fc_suppliername1 }}" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Telepon</label>
                                    <input type="text" class="form-control" value="{{ $data->supplier->fc_supplierphone1 }}" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Legal Status</label>
                                    <input type="text" class="form-control" value="{{ $data->supplier->supplier_legal_status->fv_description }}" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-12">
                                <div class="form-group">
                                    <label>Alamat</label>
                                    <input type="text" class="form-control" value="{{ $data->supplier->fc_supplier_npwpaddress1 }}" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- TABLE --}}
        <div class="col-12 col-md-12 col-lg-12 place_detail">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table table-striped" id="po_detail" width="100%">
                                <thead style="white-space: nowrap">
                                    <tr>
                                        <th scope="col" class="text-center">No</th>
                                        <th scope="col" class="text-center">Kode Barang</th>
                                        <th scope="col" class="text-center">Nama Barang</th>
                                        <th scope="col" class="text-center">Satuan</th>
                                        <th scope="col" class="text-center">Qty</th>
                                        <th scope="col" class="text-center">Qty BPB</th>
                                        <th scope="col" class="text-center">Bonus</th>
                                        <th scope="col" class="text-center">Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- TABLE Item Receiving --}}
        <div class="col-12 col-md-12 col-lg-12 place_detail">
            <div class="card">
                <div class="card-header">
                    <h4>Item yang Diterima</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table table-striped" id="tb_ro" width="100%">
                                <thead style="white-space: nowrap">
                                    <tr>
                                        <th scope="col" class="text-center">No.</th>
                                        <th scope="col" class="text-center">Kode Barang</th>
                                        <th scope="col" class="text-center">Nama Barang</th>
                                        <th scope="col" class="text-center">Satuan</th>
                                        <th scope="col" class="text-center">Qty</th>
                                        <th scope="col" class="text-center">Batch</th>
                                        <th scope="col" class="text-center">Expired Date</th>
                                        <th scope="col" class="text-center">Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-12 col-lg-12 place_detail">
            <form id="form_submit_edit" action="/apps/receiving-order/create/submit-ro" method="POST" autocomplete="off">
                @csrf
                @method('put')
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-12 col-lg-3">
                                <div class="form-group required">
                                    <label>Transport</label>
                                    <select class="form-control select2" name="fc_potransport" id="fc_potransport" required>
                                        <option value="" selected disabled>- Pilih Transport -</option>
                                        <option value="By Dexa">By Dexa</option>
                                        <option value="By Paket">By Paket</option>
                                        <option value="By Supplier">By Supplier</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-4">
                                <div class="form-group required">
                                    <label>Tanggal Surat Jalan</label>
                                    <div class="input-group" data-date-format="dd-mm-yyyy">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-calendar"></i>
                                            </div>
                                        </div>
                                        <!-- {{-- input waktu sekarang format timestamp tipe hidden --}} -->
                                        <!-- <input type="hidden" class="form-control" name="fd_sodatesysinput"
                                                                id="fd_sodatesysinput" value="{{ date('d-m-Y') }}"> -->
                                        <input type="text" id="fd_rosjdate" class="form-control datepicker" name="fd_rosjdate" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-5">
                                <div class="form-group required">
                                    <label>Alamat</label>
                                    <input type="text" name="fc_address_loading" class="form-control" value="{{ $data->fc_address_loading1 }}" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-right mb-4">
                    <button type="button" onclick="delete_action('/apps/receiving-order/cancel_ro/{{ base64_encode($data->fc_pono) }}', 'BPB')" class="btn btn-danger mr-2">Cancel BPB</button>
                    <button class="btn btn-success mr-2">Submit</button>
                </div>
            </form>
        </div>
    </div>
    @endsection

    @section('modal')
    <div class="modal fade" role="dialog" id="modal_select" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header br">
                    <h5 class="modal-title">Detail Item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form_submit_item" action="/apps/receiving-order/create/insert-item" method="post" autocomplete="off">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12 col-md-12 col-lg-6">
                                <div class="form-group">
                                    <label>Stock Code</label>
                                    <div class="input-group">
                                        <input type="text" id="fc_barcode" class="form-control" name="fc_barcode" readonly hidden>
                                        <input type="text" id="fc_stockcode" class="form-control" name="fc_stockcode" readonly>
                                        <input type="text" id="fc_pono" class="form-control" name="fc_pono" hidden>
                                        <input type="text" id="fc_namepack" class="form-control" name="fc_namepack" hidden>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-6">
                                <div class="form-group">
                                    <label>Nama Produk</label>
                                    <div class="input-group">
                                        <input type="text" id="fc_nameshort" class="form-control" name="fc_nameshort" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-6">
                                <div class="form-group required">
                                    <label>Batch</label>
                                    <input type="text" id="fc_batch" class="form-control" name="fc_batch" required>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-6">
                                <div class="form-group required">
                                    <label>Qty</label>
                                    <input type="number" min="0" class="form-control" name="fn_qty_ro" id="fn_qty_ro" required>
                                    <input type="number" min="0" class="form-control" name="fn_qty_po" id="fn_qty_po" hidden>
                                    <input  min="0" class="form-control" name="fn_price" id="fn_price" hidden>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-12">
                                <div class="form-group required">
                                    <label>Expired Date</label>
                                    <div class="input-group" data-date-format="dd-mm-yyyy">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-calendar"></i>
                                            </div>
                                        </div>
                                        <input type="text" id="fd_expired_date" class="form-control datepicker" name="fd_expired_date" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-whitesmoke br">
                        <button type="submit" class="btn btn-success btn-submit">Konfirmasi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endsection

    @section('js')
    <script>
        let encode_fc_pono = "{{ base64_encode($data->fc_pono) }}";
        // jika ada form submit
        $('#form_submit_item').on('submit', function(e) {
            e.preventDefault();

            var form_id = $(this).attr("id");
            if (check_required(form_id) === false) {
                swal("Oops! Mohon isi field yang kosong", {
                    icon: 'warning',
                });
                return;
            }
            swal({
                    title: 'Yakin?',
                    text: 'Apakah anda yakin akan menyimpan data ini?',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true,
                })
                .then((willSubmit) => {
                    if (willSubmit) {
                        $("#modal_loading").modal('show');
                        $.ajax({
                            url: $('#form_submit_item').attr('action'),
                            type: $('#form_submit_item').attr('method'),
                            data: $('#form_submit_item').serialize(),
                            success: function(response) {
                                setTimeout(function() {
                                    $('#modal_loading').modal('hide');
                                }, 500);
                                if (response.status == 200) {
                                    iziToast.success({
                                        title: 'Success!',
                                        message: response.message,
                                        position: 'topRight'
                                    });
                                    $("#modal_select").modal('hide');
                                    $("#form_submit_item")[0].reset();
                                    reset_all_select();
                                    tb_ro.ajax.reload(null, false);
                                    tb.ajax.reload(null, false);
                                } else if (response.status == 201) {
                                    iziToast.success({
                                        title: 'Success!',
                                        message: response.message,
                                        position: 'topRight'
                                    });
                                    $("#modal_select").modal('hide');
                                    location.href = response.link;
                                } else if (response.status == 203) {
                                    iziToast.success({
                                        title: 'Success!',
                                        message: response.message,
                                        position: 'topRight'
                                    });
                                    $("#modal_select").modal('hide');
                                    tb.ajax.reload(null, false);
                                } else if (response.status == 300) {
                                    iziToast.error({
                                        title: 'Gagal!',
                                        message: response.message,
                                        position: 'topRight'
                                    });
                                }
                            },
                            error: function(xhr, status, error) {
                                setTimeout(function() {
                                    $('#modal_loading').modal('hide');
                                }, 500);
                                swal("Oops! Terjadi kesalahan saat menyimpan data.", {
                                    icon: 'error',
                                });
                            }
                        });
                    }
                });
        });

        function delete_item(url, nama) {
            swal({
                    title: 'Apakah anda yakin?',
                    text: 'Apakah anda yakin akan menghapus data ' + nama + "?",
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $("#modal_loading").modal('show');
                        $.ajax({
                            url: url,
                            type: "DELETE",
                            dataType: "JSON",
                            success: function(response) {
                                setTimeout(function() {
                                    $('#modal_loading').modal('hide');
                                }, 500);

                                if (response.status === 200) {
                                    swal(response.message, {
                                        icon: 'success',
                                    });
                                    $("#modal").modal('hide');
                                    tb.ajax.reload(null, false);
                                    tb_ro.ajax.reload(null, false);
                                    //  location.href = location.href;
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

        function click_modal_select(data) {
            var stockcode = window.btoa($(data).data('stockcode'));
            var barcode = $(data).data('barcode');

            // encode stockcode
            
            // pono
            var pono = window.btoa($(data).data('pono'));
            // console.log(pono)
            // console.log(stockcode)

            $('#fc_catnumber').val('');
            $('#fc_batch').val('');

            // modal_loading show
            $('#modal_loading').modal('show');

            // value id fc_stockcode
            $('#fc_stockcode').val($(data).data('stockcode'));
            $('#fc_barcode').val(barcode);

            $.ajax({
                url: '/apps/receiving-order/create/detail-item/' + stockcode + '/' + pono,
                type: "GET",

                success: function(data) {
                    var qty = data.fn_po_qty - data.fn_ro_qty

                    $('#fc_nameshort').val(data.stock.fc_nameshort);
                    $('#fc_nameshort').trigger('change');

                    // fc_namepack
                    $('#fc_namepack').val(data.stock.fc_namepack);

                    $('#fc_pono').val(data.fc_pono);

                    $('#fn_qty_ro').val(qty);

                    $('#fn_price').val(data.fm_po_price);

                    $('#fn_qty_po').val(data.fn_po_qty);
                    $('#fn_qty_po').trigger('change');

                    // modal_loading hide
                    setTimeout(function() {
                        $('#modal_loading').modal('hide');
                    }, 500);
                    $('#modal_select').modal('show');
                },

                error: function(data) {
                    setTimeout(function() {
                        $('#modal_loading').modal('hide');
                    }, 500);
                    console.log('Error:', data);
                }
            });
        }

        var tb = $('#po_detail').DataTable({
            // apabila data kosong
            processing: true,
            serverSide: true,
            destroy: true,
            ajax: {
                url: "/apps/receiving-order/datatables/po_detail/" + encode_fc_pono,
                type: 'GET',
            },
            columnDefs: [{
                className: 'text-center',
                targets: [0, 3, 4, 5, 6, 7]
            }, ],
            columns: [{
                    data: 'DT_RowIndex',
                    searchable: false,
                    orderable: false
                },
                {
                    data: 'fc_stockcode'
                },
                {
                    data: 'stock.fc_namelong'
                },
                {
                    data: 'namepack.fv_description'
                },
                {
                    data: 'fn_po_qty'
                },
                {
                    data: 'fn_ro_qty'
                },
                {
                    data: 'fn_po_bonusqty'
                },
                {
                    data: null
                },
            ],
            rowCallback: function(row, data) {
                if (data.fn_po_qty > data.fn_ro_qty || data.fn_po_bonusqty > data.fn_po_bonusqty) {
                    $('td:eq(7)', row).html(`
                        <button class="btn btn-warning btn-sm" data-pono="${data.fc_pono}" data-stockcode="${data.fc_stockcode}" data-barcode="${data.fc_barcode}" onclick="click_modal_select(this)"><i class="fa fa-search"></i> Pilih Item</button>`);
                } else {
                    $('td:eq(7)', row).html(`
                        <button class="btn btn-success btn-sm"><i class="fa fa-check"></i></button>`);
                }
            },
        });

        var tb_ro = $('#tb_ro').DataTable({
            // apabila data kosong
            processing: true,
            serverSide: true,
            destroy: true,
            ajax: {
                url: "/apps/receiving-order/create/datatables/temprodetail/" + "{{ base64_encode($data->fc_pono) }}",
                type: 'GET',
            },
            columnDefs: [{
                className: 'text-center',
                targets: [0, 1, 2, 3, 4, 5, 6]
            }, ],
            columns: [{
                    data: 'DT_RowIndex',
                    searchable: false,
                    orderable: false
                },
                {
                    data: 'fc_stockcode',
                },
                {
                    data: 'stock.fc_namelong',
                },
                {
                    data: 'fc_namepack',
                },
                {
                    data: 'fn_qty_ro',
                },
                {
                    data: 'fc_batch',
                },
                {
                    data: 'fd_expired_date',
                    render: formatTimestamp
                },
                {
                    data: null
                }
            ],

            rowCallback: function(row, data) {
                var url_delete = '/apps/receiving-order/create/delete/temprodetail/' + data.fn_rownum;
                $('td:eq(7)', row).html(`
                <button class="btn btn-danger btn-sm"  onclick="delete_item(
                    '${url_delete}','Item yang Diterima')"><i class="fa fa-trash"></i> Hapus Item</button>
                `);
            },
        });

        $('.modal').css('overflow-y', 'auto');
    </script>
    @endsection