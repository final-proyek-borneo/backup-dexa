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
                <form id="form_submit" action="/apps/retur-barang/store-update" method="POST" autocomplete="off">
                    <div class="collapse show" id="mycard-collapse">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label>Tanggal : {{ \Carbon\Carbon::now()->format('d/m/Y') }}</label>
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
                                            <input type="text" class="form-control" id="fc_dono" name="fc_dono" readonly>
                                            <div class="input-group-append">
                                                <button class="btn btn-primary" onclick="click_modal_do()" type="button"><i class="fa fa-search"></i></button>
                                            </div>
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
                                            <input type="text" id="fd_returdate" class="form-control datepicker" name="fd_returdate" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-12 col-lg-12 text-right">
                                    <button type="submit" class="btn btn-success">Buat Retur</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
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
                <div class="collapse show" id="mycard-collapse2">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>NPWP</label>
                                    <input type="text" class="form-control" id="fc_membernpwp_no" name="fc_membernpwp_no" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Nama Customer</label>
                                    <input type="text" class="form-control" id="fc_membername1" name="fc_membername1" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Pajak</label>
                                    <input type="text" class="form-control" id="status_pkp" name="status_pkp" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Penerima</label>
                                    <input type="text" class="form-control" id="fc_custreceiver" name="fc_custreceiver" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Tanggal Kirim</label>
                                    <input type="text" class="form-control" id="fd_dodate" name="fd_dodate" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Tanggal Diterima</label>
                                    <input type="text" class="form-control" id="fd_doarivaldate" name="fd_doarivaldate" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-12">
                                <div class="form-group">
                                    <label>Alamat Pengiriman</label>
                                    <input type="text" class="form-control" id="fc_memberaddress_loading" name="fc_memberaddress_loading" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('modal')
<div class="modal fade" role="dialog" id="modal_do" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header br">
                <h5 class="modal-title">Pilih Surat Jalan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="tb" width="100%">
                        <thead>
                            <tr>
                                <th scope="col" class="text-center">No</th>
                                <th scope="col" class="text-center">No. Surat Jalan</th>
                                <th scope="col" class="text-center">No. SO</th>
                                <th scope="col" class="text-center">Tgl SJ</th>
                                <th scope="col" class="text-center">Customer</th>
                                <th scope="col" class="text-center">Item</th>
                                <th scope="col" class="text-center" style="width: 10%">Actions</th>
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
@endsection



@section('js')
<script>
    function click_modal_do() {
        $('#modal_do').modal('show');
        table_do();
    }

    function table_do() {
        if ($.fn.DataTable.isDataTable('#tb')) {
            $('#tb').DataTable().destroy();
        }
        var tb = $('#tb').DataTable({
            processing: true,
            serverSide: true,
            order: [
                [3, 'desc']
            ],
            ajax: {
                url: '/apps/master-delivery-order/datatables/R',
                type: 'GET'
            },
            columnDefs: [{
                    className: 'text-center',
                    targets: [0, 4, 5, 6]
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
                    data: 'fc_dono'
                },
                {
                    data: 'fc_sono'
                },
                {
                    data: 'fd_dodate',
                    render: formatTimestamp
                },
                {
                    data: 'somst.customer.fc_membername1'
                },
                {
                    data: 'fn_dodetail'
                },
                {
                    data: null
                },
            ],
            rowCallback: function(row, data) {
                var fc_dono = window.btoa(data.fc_dono);
                $('td:eq(6)', row).html(
                    `<button class="btn btn-warning btn-sm" onclick="detail_do('${data.fc_dono}')"><i class="fa fa-check"></i> Pilih</button></a>`
                );

            }
        });
    }

    function detail_do(fc_dono){
        // encode
        var fc_dono = window.btoa(fc_dono);
        console.log(fc_dono)
        $.ajax({
            url : "/apps/retur-barang/detail-delivery-order/" + fc_dono,
            type: "GET",
            dataType: "JSON",
            success: function(response){
                $("#modal_do").modal('hide');
                var data = response.data;
                $('#fc_dono').val(data.fc_dono);
                $('#fc_membernpwp_no').val(data.somst.customer.fc_membernpwp_no);
                $('#fc_membername1').val(data.somst.customer.fc_membername1);
                $('#fc_custreceiver').val(data.fc_custreceiver);
                $('#fd_doarivaldate').val(data.fd_doarivaldate);
                $('#fc_memberaddress_loading').val(data.fc_memberaddress_loading);
                $('#fd_dodate').val(data.fd_dodate);
                $('#status_pkp').val(data.somst.customer.member_tax_code.fv_description + " (" + data.somst.customer.member_tax_code.fc_action + "%" + ")");
                // $('#status_pkp').val(data.member_tax_code.fv_description + " (" + data.member_tax_code.fc_action + "%" + ")");
                

            },error: function (jqXHR, textStatus, errorThrown){
                swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + errorThrown + ")", {  icon: 'error', });
            }
        });
    }
</script>
@endsection