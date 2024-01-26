@extends('partial.app')
@section('title', 'New Invoice Incoming')
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
                    <form id="form_submit" action="/apps/receiving-order/create/store-update" method="POST" autocomplete="off">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label>PO No : {{ $ro_mst->fc_pono }}
                                        </label>
                                        <input type="text" name="fc_pono" value="{{ $ro_mst->fc_pono }}" hidden>
                                    </div>
                                </div>
                                <div class="col-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label>RO No: {{ $ro_mst->fc_rono }}
                                        </label>
                                        <input type="text" name="fc_rono" value="{{ $ro_mst->fc_rono }}" hidden>
                                    </div>
                                </div>
                                <div class="col-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label>Operator</label>
                                        <input name="fc_userid" id="fc_userid" type="text" class="form-control" value="{{ auth()->user()->fc_username }}" readonly>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label>Status PKP</label>
                                        <input name="" type="text" value="{{ $ro_mst->pomst->supplier->supplier_tax_code->fv_description }}" id="" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="col-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label>Tgl Terbit</label>
                                        <div class="input-group" data-date-format="dd-mm-yyyy">
                                            <input type="text" class="form-control datepicker" name="fd_inv_releasedate" id="fd_inv_releasedate" value="{{ $inv_mst->fd_inv_releasedate }}" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label>Tgl Berakhir</label>
                                        <div class="input-group" data-date-format="dd-mm-yyyy">
                                            <input type="text" id="fd_inv_agingdate" class="form-control datepicker" name="fd_inv_agingdate" value="{{ $inv_mst->fd_inv_agingdate }}" readonly>
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
                                    <input type="text" class="form-control" value="{{ $ro_mst->pomst->supplier->fc_supplierNPWP }}" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Tipe Cabang</label>
                                    <input type="text" class="form-control" value="{{ $tipe_cabang->pomst->supplier->supplier_typebranch->fv_description }}" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Tipe Bisnis</label>
                                    <input type="text" class="form-control" value="{{ $tipe_cabang->pomst->supplier->supplier_type_business->fv_description }}" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Nama</label>
                                    <input type="text" class="form-control" value="{{ $ro_mst->pomst->supplier->fc_suppliername1 }}" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Telepon</label>
                                    <input type="text" class="form-control" value="{{ $ro_mst->pomst->supplier->fc_supplierphone1 }}" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Masa Hutang</label>
                                    <input type="text" class="form-control" value="{{ $legal_status->pomst->supplier->fn_supplierAgingAR }}" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Legal Status</label>
                                    <input type="text" class="form-control" value="{{ $legal_status->pomst->supplier->supplier_legal_status->fv_description }}" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Alamat</label>
                                    <input type="text" class="form-control" value="{{ $ro_mst->pomst->supplier->fc_supplier_npwpaddress1 }}" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Hutang</label>
                                    <input type="text" class="form-control" value="{{ $ro_mst->pomst->supplier->fm_supplierAR }}" readonly>
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
                <div class="card-header">
                    <h4>Item Receiving</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table table-striped" id="ro_detail" width="100%">
                                <thead style="white-space: nowrap">
                                    <tr>
                                        <th scope="col" class="text-center">No</th>
                                        <th scope="col" class="text-center">Kode Barang</th>
                                        <th scope="col" class="text-center">Nama Barang</th>
                                        <th scope="col" class="text-center">Unity</th>
                                        <th scope="col" class="text-center">Batch</th>
                                        <th scope="col" class="text-center">Exp. Date</th>
                                        <th scope="col" class="text-center">Harga</th>
                                        <th scope="col" class="text-center">Disc.</th>
                                        <th scope="col" class="text-center">Qty</th>
                                        <th scope="col" class="text-center">Total</th>
                                        <th scope="col" class="text-center">Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-12 col-lg-6">
            <div class="card">
                <div class="card-body">
                    <form id="form_submit_edit" action="/apps/master-invoice/create/deliver-update" method="POST" autocomplete="off">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Transport</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="fc_potransport" id="fc_potransport" value="{{ $ro_mst->fc_potransport }}" readonly>
                                        <input type="text" class="form-control" name="fc_invno" value="{{ $inv_mst->fc_invno }}" id="fc_invno" hidden>
                                        <input type="text" class="form-control" name="fc_rono" value="{{ $ro_mst->fc_rono }}" id="fc_rono" hidden>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Biaya</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                Rp.
                                            </div>
                                        </div>
                                        <input type="text" class="form-control format-rp" name="fm_servpay" id="fm_servpay" value="{{ $inv_mst->fm_servpay }}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-12">
                                <div class="form-group">
                                    <label>Alamat Pengiriman</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="fc_address_loading" id="fc_address_loading" value="{{ $ro_mst->fc_address_loading }}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-12 text-right">
                                @if ($inv_mst->fm_servpay == 0)
                                <button type="submit" class="btn btn-success">Save</button>
                                @elseif ($inv_mst->fc_status === 'R')
                                {{-- hapus button --}}
                                <button type="submit" class="btn btn-secondary" disabled>Edit</button>
                                @else
                                <button type="submit" class="btn btn-warning">Edit</button>
                                @endif
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
                <div class="card-body" style="height: 180px">
                    <div class="d-flex">
                        <div class="flex-row-item" style="margin-right: 30px">
                            <div class="d-flex" style="gap: 5px; white-space: pre">
                                <p class="text-secondary flex-row-item" style="font-size: medium">Item</p>
                                <p class="text-success flex-row-item text-right" style="font-size: medium" id="fn_invdetail">0,00</p>
                            </div>
                            <div class="d-flex">
                                <p class="flex-row-item"></p>
                                <p class="flex-row-item text-right"></p>
                            </div>
                            <div class="d-flex" style="gap: 5px; white-space: pre">
                                <p class="text-secondary flex-row-item" style="font-size: medium">Disc. Total</p>
                                <p class="text-success flex-row-item text-right" style="font-size: medium" id="fm_disctotal">0,00</p>
                            </div>
                            <div class="d-flex">
                                <p class="flex-row-item"></p>
                                <p class="flex-row-item text-right"></p>
                            </div>
                            <div class="d-flex" style="gap: 5px; white-space: pre">
                                <p class="text-secondary flex-row-item" style="font-size: medium">Total</p>
                                <p class="text-success flex-row-item text-right" style="font-size: medium" id="fm_netto">0,00</p>
                            </div>
                        </div>
                        <div class="flex-row-item">
                            <div class="d-flex" style="gap: 5px; white-space: pre">
                                <p class="text-secondary flex-row-item" style="font-size: medium">Pelayanan</p>
                                <p class="text-success flex-row-item text-right" style="font-size: medium" id="fm_servpay_calculate">0,00</p>
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
                                <p class="text-success flex-row-item text-right" style="font-weight: bold; font-size:medium" id="fm_brutto">Rp. 0,00</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex d-flex inline justify-content-end mb-4">
        @if ($inv_mst->fc_status === 'I')
        <button type="button" onclick="delete_action('/apps/master-invoice/delete/{{ base64_encode($inv_mst->fc_invno) }}','Invoice')" class="btn btn-danger mr-2">Cancel INV</button>
        @endif
        @if ($inv_mst->fc_status === 'I')
        <form id="form_submit_custom" action="/apps/master-invoice/create/submit-invoice" method="POST">
            @csrf
            @method('PUT')
            <input type="text" name="fc_invno" value="{{ $inv_mst->fc_invno }}" hidden>
            <button type="submit" class="btn btn-success">Submit</button>
        </form>
        @endif
    </div>
</div>
@endsection

@section('js')
<script>
    var tb = $('#ro_detail').DataTable({
        // apabila data kosong
        processing: true,
        serverSide: true,
        destroy: true,
        ajax: {
            url: "/apps/master-invoice/create/datatables/ro-detail/" + "{{ base64_encode($ro_mst->fc_rono) }}",
            type: 'GET',
        },
        columnDefs: [{
            className: 'text-center',
            targets: [0, 3, 4, 5, 6, 7, 10]
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
                data: 'invstore.stock.fc_nameshort'
            },
            {
                data: 'invstore.stock.fc_namepack'
            },
            {
                data: 'fc_batch'
            },
            {
                data: 'fd_expired_date'
            },
            {
                data: null,
                render: function(data, type, full, meta) {
                    return `<input type="number" id="" min="0" class="form-control" value="${data.fn_price}">`;
                }
            },
            {
                data: null,
                render: function(data, type, full, meta) {
                    return `<input type="number" id="" min="0" class="form-control" value="${data.fn_disc}">`;
                }
            },
            {
                data: 'fn_qty_ro'
            },
            {
                data: 'fn_value',
                render: $.fn.dataTable.render.number(',', '.', 0, 'Rp ')
            },
            {
                data: null
            },
        ],
        rowCallback: function(row, data) {
            // console.log(data.romst.fc_invstatus);
            if (data.fn_price == 0 && data.fn_disc == 0) {
                $('td:eq(10)', row).html(`
                    <button type="submit" class="btn btn-success">Save</button>`);
            } else if (data.romst.fc_invstatus === 'R') {
                $('td:eq(10)', row).html(`
                    <button type="submit" class="btn btn-secondary" disabled>Edit</button>`);
            } else {
                $('td:eq(10)', row).html(`
                    <button type="submit" class="btn btn-warning">Edit</button>`);
            }

            $('#fn_invdetail').html(data.romst.invmst.fn_invdetail);
            $('#fn_invdetail').trigger('change');
            $('#fm_disctotal').html("Rp. " + fungsiRupiah(data.romst.invmst.fm_disctotal));
            $('#fm_disctotal').trigger('change');
            $('#fm_netto').html("Rp. " + fungsiRupiah(data.romst.invmst.fm_netto));
            $('#fm_netto').trigger('change');
            $('#fm_servpay_calculate').html("Rp. " + fungsiRupiah(data.romst.invmst.fm_servpay));
            $('#fm_servpay_calculate').trigger('change');
            $('#fm_tax').html("Rp. " + fungsiRupiah(data.romst.invmst.fm_tax));
            $('#fm_tax').trigger('change');
            $('#fm_brutto').html("Rp. " + fungsiRupiah(data.romst.invmst.fm_brutto));
            $('#fm_brutto').trigger('change');

        },
        error: function(xhr, status, error) {
            // ketika response error
            $("#modal_loading").modal('hide');
            swal(xhr.responseJSON.message, {
                icon: 'error',
            });
        }
    });

    $('#ro_detail tbody').on('click', 'button', function() {
        var data = tb.row($(this).parents('tr')).data();
        var price = $(this).parents('tr').find('input:eq(0)').val();
        var disc = $(this).parents('tr').find('input:eq(1)').val();
        // console.log(data.fc_rono);

        // modal loading
        $("#modal_loading").modal('show');

        $.ajax({
            url: '/apps/master-invoice/create/edit/incoming-edit-ro-detail',
            method: 'PUT',
            data: {
                fc_rono: data.fc_rono,
                fn_rownum: data.fn_rownum,
                fc_stockcode: data.fc_stockcode,
                fn_price: price,
                fn_disc: disc
            },
            success: function(response) {
                // ketika response sukses
                if (response.status == 200) {

                    setTimeout(function() {
                        $('#modal_loading').modal('hide');
                    }, 500);

                    swal(response.message, {
                        icon: 'success',
                    });
                    // reload table
                    tb.ajax.reload(null, false);
                }
            },
            error: function(xhr, status, error) {
                // ketika response error
                $("#modal_loading").modal('hide');
                swal(xhr.responseJSON.message, {
                    icon: 'error',
                });
            }
        });
    });
</script>
@endsection