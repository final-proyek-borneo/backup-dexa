@extends('partial.app')
@section('title', 'Daftar Penerimaan')
@section('css')
<style>
    .required label:after {
        color: #e32;
        content: ' *';
        display: inline;
    }

    table.dataTable tbody tr td {
        word-wrap: break-word;
        word-break: break-all;
    }

    table.dataTable>tbody>tr>.selected {
        background-color: transparent;
        color: black
    }

    table.dataTable>tbody>tr>td.select-checkbox,
    table.dataTable>tbody>tr>th.select-checkbox {
        position: relative
    }

    table.dataTable>tbody>tr>td.select-checkbox:before,
    table.dataTable>tbody>tr>td.select-checkbox:after,
    table.dataTable>tbody>tr>th.select-checkbox:before,
    table.dataTable>tbody>tr>th.select-checkbox:after {
        display: block;
        position: absolute;
        top: 50%;
        left: 50%;
        width: 12px;
        height: 12px;
        box-sizing: border-box;
        color: #0a9447;
    }

    table.dataTable tbody>tr.selected,
    table.dataTable tbody>tr>.selected {
        background: transparent;
        color: black;
    }

    table.dataTable>tbody>tr>td.select-checkbox:before,
    table.dataTable>tbody>tr>th.select-checkbox:before {
        content: " ";
        margin-top: -6px;
        margin-left: -6px;
        border: 1px solid black;
        border-radius: 3px
    }

    table.dataTable>tbody>tr.selected>td.select-checkbox:before,
    table.dataTable>tbody>tr.selected>th.select-checkbox:before {
        border: 1px solid black
    }

    table.dataTable>tbody>tr.selected>td.select-checkbox:after,
    table.dataTable>tbody>tr.selected>th.select-checkbox:after {
        content: "✓";
        font-size: 14px;
        margin-top: -12px;
        margin-left: -5px;
        text-align: center;
        color: black;

    }

    table.dataTable.compact>tbody>tr>td.select-checkbox:before,
    table.dataTable.compact>tbody>tr>th.select-checkbox:before {
        margin-top: -12px
    }

    table.dataTable.compact>tbody>tr.selected>td.select-checkbox:after,
    table.dataTable.compact>tbody>tr.selected>th.select-checkbox:after {
        margin-top: -16px;
        color: black;
    }

    div.dataTables_wrapper span.select-info,
    div.dataTables_wrapper span.select-item {
        margin-left: .5em
    }

    html.dark table.dataTable>tbody>tr>td.select-checkbox:before,
    html.dark table.dataTable>tbody>tr>th.select-checkbox:before,
    html[data-bs-theme=dark] table.dataTable>tbody>tr>td.select-checkbox:before,
    html[data-bs-theme=dark] table.dataTable>tbody>tr>th.select-checkbox:before {
        border: 1px solid rgba(255, 255, 255, 0.6)
    }

    @media screen and (max-width: 640px) {

        div.dataTables_wrapper span.select-info,
        div.dataTables_wrapper span.select-item {
            margin-left: 0;
            display: block
        }
    }
</style>
@endsection
@section('content')
<div class="section-body">
    <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4>Data BPB</h4>
                    <div class="card-header-action">
                        <button type="button" class="btn btn-success" onclick="add_multi();"><i class="fa fa-plus"></i> Multi BPB</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="tb" width="100%">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">No</th>
                                    <th scope="col" class="text-center">No. BPB</th>
                                    <th scope="col" class="text-center">No. PO</th>
                                    <th scope="col" class="text-center text-nowrap">Nama Supplier</th>
                                    <th scope="col" class="text-center text-nowrap">Tgl Diterima</th>
                                    <th scope="col" class="text-center">Item</th>
                                    <th scope="col" class="text-center">Total Belanja</th>
                                    <th scope="col" class="text-center" style="width: 15%">Actions</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('modal')
<div class="modal fade" role="dialog" id="modal_multi" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header br">
                <h5 class="modal-title">Multi BPB</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_submit" action="/apps/invoice-pembelian/create/store-invoice-multi-bpb" method="POST" autocomplete="off">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-12">
                            <div class="form-group required">
                                <label>Supplier</label>
                                <select name="fc_suppliercode" id="fc_suppliercode" class="form-control select2" required></select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-12">
                            <div class="form-group required">
                                <label>Purchase Order</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="fc_pono" name="fc_pono" readonly>
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" onclick="click_modal_po()" type="button"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-12" id="rono" hidden>
                            <div class="form-group required">
                                <label>BPB Performa</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="fc_rono" name="fc_rono" readonly>
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" onclick="click_modal_bpb()" type="button"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-6">
                            <div class="form-group required">
                                <label>Tanggal Terbit</label>
                                <div class="input-group" data-date-format="dd-mm-yyyy">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-calendar"></i>
                                        </div>
                                    </div>
                                    <input type="text" id="fd_inv_releasedate" data-provide="datepicker" class="form-control" name="fd_inv_releasedate" required>
                                    {{-- <input type="hidden" id="fc_suppdocno" class="form-control" value="{{ $do_mst->somst->fc_sono }}" name="fc_suppdocno" required>
                                    <input type="hidden" id="fc_child_suppdocno" class="form-control" value="{{ $do_mst->fc_dono }}" name="fc_child_suppdocno" required>
                                    <input type="hidden" id="fc_entitycode" class="form-control" value="{{ $do_mst->somst->customer->fc_membercode }}" name="fc_entitycode" required> --}}
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-6">
                            <div class="form-group required">
                                <label>Masa Jatuh Tempo</label>
                                <div class="input-group" data-date-format="dd-mm-yyyy">
                                    <input type="number" id="fn_inv_agingday" class="form-control" name="fn_inv_agingday" required>
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            Hari
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                <label>Estimasi Jatuh Tempo</label>
                                <div class="input-group" data-date-format="dd-mm-yyyy">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-calendar"></i>
                                        </div>
                                    </div>
                                    <input type="text" id="fd_inv_agingdate" class="form-control" name="fd_inv_agingdate" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="submit" class="btn btn-success">Buat Invoice</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" role="dialog" id="modal_po" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header br">
                <h5 class="modal-title">Pilih Purchase Order</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="tb_po" width="100%">
                        <thead>
                            <tr>
                                <th scope="col" class="text-center">No</th>
                                <th scope="col" class="text-center">No. PO</th>
                                <th scope="col" class="text-center">Tanggal</th>
                                <th scope="col" class="text-center">Expired</th>
                                <th scope="col" class="text-center">Tipe</th>
                                <th scope="col" class="text-center">Operator</th>
                                <th scope="col" class="text-center">Supplier</th>
                                <th scope="col" class="text-center">Item</th>
                                <th scope="col" class="text-center">Total</th>
                                <th scope="col" class="text-center" style="width: 20%">Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" role="dialog" id="modal_bpb" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header br">
                <h5 class="modal-title">Pilih BPB Performa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="tb_bpb" width="100%">
                        <thead>
                            <tr>
                                <th scope="col" class="text-center">No.</th>
                                <th scope="col" class="text-center">No. BPB</th>
                                <th scope="col" class="text-center">Tanggal</th>
                                <th scope="col" class="text-center">Netto</th>
                                <th scope="col" class="text-center">Tax</th>
                                <th scope="col" class="text-center">Brutto</th>
                                <th scope="col" class="text-center">Operator</th>
                                <th scope="col" class="text-center">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-primary" id="save">Simpan</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        get_data_supplier();
        $('#fc_suppliercode').select2({
            closeOnSelect: true
        });
    })

    $('#fn_inv_agingday').on('input', function() {
        var fd_inv_releasedate = $('#fd_inv_releasedate').val();
        var fn_inv_agingday = parseInt($('#fn_inv_agingday').val());

        if (moment(fd_inv_releasedate, 'MM/DD/YYYY').isValid()) {
            var fd_inv_agingdate = moment(fd_inv_releasedate, 'MM/DD/YYYY').add(fn_inv_agingday, 'days').format('MM/DD/YYYY');
            $('#fd_inv_agingdate').val(fd_inv_agingdate);
        }
    });

    function add_multi() {
        $('#modal_multi').modal('show');
    }

    function click_modal_po() {
        $('#modal_po').modal('show');
    }

    function click_modal_bpb() {
        $('#modal_bpb').modal('show');
    }

    function get_data_supplier() {
        $.ajax({
            url: "/apps/invoice-pembelian/data-supplier",
            type: "GET",
            dataType: "JSON",
            success: function(response) {
                if (response.status === 200) {
                    var data = response.data;
                    // console.log(data);
                    $("#fc_suppliercode").empty();
                    $("#fc_suppliercode").append(`<option value="" selected disabled> - Pilih - </option>`);
                    for (var i = 0; i < data.length; i++) {
                        $("#fc_suppliercode").append(`<option value="${data[i].fc_suppliercode}">${data[i].fc_suppliername1}</option>`);
                    }
                } else {
                    iziToast.error({
                        title: 'Error!',
                        message: response.message,
                        position: 'topRight'
                    });
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + errorThrown + ")", {
                    icon: 'error',
                });
            }
        });
    }

    var tb = $('#tb').DataTable({
        processing: true,
        serverSide: true,
        order: [
            [4, 'desc']
        ],
        ajax: {
            url: '/apps/invoice-pembelian/datatables',
            type: 'GET'
        },
        columnDefs: [{
                className: 'text-center',
                targets: [0, 4, 5, 6, 7]
            },
            {
                className: 'text-nowrap',
                targets: [3]
            },
        ],
        columns: [{
                data: 'DT_RowIndex',
                searchable: false,
                orderable: false
            },
            {
                data: 'fc_rono'
            },
            {
                data: 'fc_pono'
            },
            {
                data: 'pomst.supplier.fc_suppliername1'
            },
            {
                data: 'fd_roarivaldate',
                render: formatTimestamp
            },
            {
                data: 'fn_rodetail'
            },
            {
                data: 'fm_brutto',
                defaultContent: 'Rp 0',
                render: $.fn.dataTable.render.number(',', '.', 0, 'Rp')
            },
            {
                data: null
            },
        ],
        rowCallback: function(row, data) {
            var fc_rono = window.btoa(data.fc_rono);
            $('td:eq(7)', row).html(
                `<a href="/apps/invoice-pembelian/detail/${fc_rono}"><button class="btn btn-warning btn-sm"><i class="fa fa-check"></i> Pilih</button></a>`
            );

        }
    });

    var defaultSupplier = 'all';
    var encodedDefaultSupplier = btoa(defaultSupplier);
    var tb_po = $('#tb_po').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 5,
        order: [
            [2, 'desc']
        ],
        ajax: {
            url: '/apps/invoice-pembelian/datatables-po/' + encodedDefaultSupplier,
            type: 'GET'
        },
        columnDefs: [{
                className: 'text-center',
                targets: [0, 5, 6, 7, 9]
            },
            {
                className: 'text-nowrap',
                targets: [3]
            },
        ],
        columns: [{
                data: 'DT_RowIndex',
                searchable: false,
                orderable: false
            },
            {
                data: 'fc_pono'
            },
            {
                data: 'fd_podatesysinput',
                render: formatTimestamp
            },
            {
                data: 'fd_poexpired',
                render: formatTimestamp
            },
            {
                data: 'fc_potype'
            },
            {
                data: 'fc_userid'
            },
            {
                data: 'supplier.fc_suppliername1'
            },
            {
                data: 'fn_podetail'
            },
            {
                data: 'fm_brutto',
                render: $.fn.dataTable.render.number(',', '.', 0, 'Rp')
            },
            {
                data: null
            },
        ],

        rowCallback: function(row, data) {
            var fc_pono = window.btoa(data.fc_pono);
            // console.log(fc_sono);

            $('td:eq(9)', row).html(`
            <button class="btn btn-warning btn-sm mr-1" onclick="get_supp('${data.fc_pono}')"><i class="fa fa-check"></i> Pilih</button>
         `);
        }
    });

    $('#fc_suppliercode').on('change', function() {
        $('#fc_pono').val('');
        var selectedSupplier = $(this).val();
        var encodedselectedSupplier = btoa(selectedSupplier);
        updateDataTable(encodedselectedSupplier);
    });

    function updateDataTable(encodedSelectedSupplier) {
        tb_po.ajax.url('/apps/invoice-pembelian/datatables-po/' + encodedSelectedSupplier).load();
    }

    function get_supp($fc_pono) {
        $('#fc_pono').val($fc_pono);
        $('#modal_po').modal('hide');

        if ($('#fc_sono').val() === '') {
            $('#rono').attr('hidden', true);
        } else {
            $('#rono').attr('hidden', false);
        }

        if ($('#fc_pono').val() !== '') {
            var fc_pono = $('#fc_pono').val();
            var encode_pono = window.btoa(fc_pono);
            updateDataTablePono(encode_pono);
        }
    }

    var tb_bpb = $('#tb_bpb').DataTable({
        processing: true,
        serverSide: true,
        order: [
            [2, 'desc']
        ],
        ajax: {
            url: '/apps/invoice-pembelian/datatables-bpb/YWxs',
            type: 'GET'
        },
        columnDefs: [{
                className: 'text-center',
                targets: [0, 1, 2, 3, 4, 5, 6]
            },
            {
                className: 'text-nowrap',
                targets: [3]
            },
            {
                targets: 7,
                orderable: false,
                defaultContent: '',
                className: 'select-checkbox'
            }
        ],
        select: {
            style: 'multi',
            selector: 'td:last-child'
        },
        columns: [{
                data: 'DT_RowIndex',
                searchable: false,
                orderable: false
            },
            {
                data: 'fc_rono'
            },
            {
                data: 'fd_roarivaldate',
                render: formatTimestamp
            },
            {
                data: 'fm_netto',
                render: function(data, type, row) {
                    return row.fm_netto.toLocaleString('id-ID', {
                        style: 'currency',
                        currency: 'IDR'
                    })
                }
            },
            {
                data: 'fm_tax',
                render: function(data, type, row) {
                    return row.fm_tax.toLocaleString('id-ID', {
                        style: 'currency',
                        currency: 'IDR'
                    })
                }
            },
            {
                data: 'fm_brutto',
                render: function(data, type, row) {
                    return row.fm_brutto.toLocaleString('id-ID', {
                        style: 'currency',
                        currency: 'IDR'
                    })
                }
            },
            {
                data: 'fc_userid'
            },
            {

            },
        ],
        rowCallback: function(row, data) {}
    });

    function updateDataTablePono(encode_pono) {
        tb_bpb.ajax.url('/apps/invoice-pembelian/datatables-bpb/' + encode_pono).load();
    }


    $('#save').on('click', function () {
                // Dapatkan baris yang dipilih dari DataTable telah dicheck
                var selectedRows = tb_bpb.rows({ selected: true }).data();

                var selectedBPB = [];

                $.each(selectedRows, function (index, row) {
                    selectedBPB.push(row.fc_rono);
                });

                if (selectedBPB.length > 0) {
                    $('#fc_rono').val(selectedBPB);
                    $('#modal_bpb').modal('hide');
                } else {
                    iziToast.warning({
                        title: 'Warning',
                        message: 'Pilih setidaknya satu BPB Performa.',
                        position: 'topRight',
                        timeout: 3000, 
                    });
                }
    });
</script>
@endsection