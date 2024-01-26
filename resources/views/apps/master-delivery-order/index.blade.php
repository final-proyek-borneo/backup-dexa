@extends('partial.app')
@section('title', 'Daftar Surat Jalan')
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

        .nav-tabs .nav-item.show .nav-link,
        .nav-tabs .nav-link.active {
            background-color: #0A9447;
            border-color: transparent;
        }

        .nav-tabs .nav-item .nav-link.active {
            font-weight: bold;
            color: #FFFF;
        }

        .nav-tabs .nav-item .nav-link {
            color: #A5A5A5;
        }
    </style>
@endsection

@section('content')
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Data Surat Jalan</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active show" id="semua-tab" data-toggle="tab" href="#semua"
                                    role="tab" aria-controls="semua" aria-selected="true">Semua</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pengiriman-tab" data-toggle="tab" href="#pengiriman" role="tab"
                                    aria-controls="pengiriman" aria-selected="false">Pengiriman</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="diterima-tab" data-toggle="tab" href="#diterima" role="tab"
                                    aria-controls="diterima" aria-selected="false">Diterima</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="approval-tab" data-toggle="tab" href="#approval" role="tab"
                                    aria-controls="approval" aria-selected="false">Approval</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade active show" id="semua" role="tabpanel"
                                aria-labelledby="semua-tab">
                                <div class="table-responsive">
                                    <form id="exportForm" action="/apps/master-delivery-order/export-excel/all"
                                        method="POST" target="_blank">
                                        @csrf
                                        <div class="button text-right mb-3">
                                            <button type="submit" class="btn btn-primary"><i
                                                    class="fas fa-file-export"></i> Export Excel</button>
                                        </div>
                                    </form>
                                    <table class="table table-striped" id="tb_semua" width="100%">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="text-center">No</th>
                                                <th scope="col" class="text-center">No. Surat Jalan</th>
                                                <th scope="col" class="text-center">No. SO</th>
                                                <th scope="col" class="text-center">Tgl SJ</th>
                                                <th scope="col" class="text-center">Customer</th>
                                                <th scope="col" class="text-center">Item</th>
                                                <th scope="col" class="text-center">Status</th>
                                                <th scope="col" class="text-center">Invoice</th>
                                                <th scope="col" class="text-center" style="width: 22%">Actions</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pengiriman" role="tabpanel" aria-labelledby="pengiriman-tab">
                                <div class="table-responsive">
                                    <form id="exportForm" action="/apps/master-delivery-order/export-excel/kirim"
                                        method="POST" target="_blank">
                                        @csrf
                                        <div class="button text-right mb-3">
                                            <button type="submit" class="btn btn-primary"><i
                                                    class="fas fa-file-export"></i> Export Excel</button>
                                        </div>
                                    </form>
                                    <table class="table table-striped" id="tb_pengiriman" width="100%">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="text-center">No</th>
                                                <th scope="col" class="text-center">No. Surat Jalan</th>
                                                <th scope="col" class="text-center">No. SO</th>
                                                <th scope="col" class="text-center">Tgl SJ</th>
                                                <th scope="col" class="text-center">Customer</th>
                                                <th scope="col" class="text-center">Item</th>
                                                <th scope="col" class="text-center">Status</th>
                                                <th scope="col" class="text-center">Invoice</th>
                                                <th scope="col" class="text-center" style="width: 22%">Actions</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="diterima" role="tabpanel" aria-labelledby="diterima-tab">
                                <div class="table-responsive">
                                    <form id="exportForm" action="/apps/master-delivery-order/export-excel/diterima"
                                        method="POST" target="_blank">
                                        @csrf
                                        <div class="button text-right mb-3">
                                            <button type="submit" class="btn btn-primary"><i
                                                    class="fas fa-file-export"></i> Export Excel</button>
                                        </div>
                                    </form>
                                    <table class="table table-striped" id="tb_diterima" width="100%">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="text-center">No</th>
                                                <th scope="col" class="text-center">No. Surat Jalan</th>
                                                <th scope="col" class="text-center">No. SO</th>
                                                <th scope="col" class="text-center">Tgl SJ</th>
                                                <th scope="col" class="text-center">Customer</th>
                                                <th scope="col" class="text-center">Item</th>
                                                <th scope="col" class="text-center">Status</th>
                                                <th scope="col" class="text-center">Invoice</th>
                                                <th scope="col" class="text-center" style="width: 22%">Actions</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="approval" role="tabpanel" aria-labelledby="approval-tab">
                                <div class="table-responsive">
                                    <form id="exportForm" action="/apps/master-delivery-order/export-excel/approval"
                                        method="POST" target="_blank">
                                        @csrf
                                        <div class="button text-right mb-3">
                                            <button type="submit" class="btn btn-primary"><i
                                                    class="fas fa-file-export"></i> Export Excel</button>
                                        </div>
                                    </form>
                                    <table class="table table-striped" id="tb_approval" width="100%">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="text-center">No</th>
                                                <th scope="col" class="text-center">No. Surat Jalan</th>
                                                <th scope="col" class="text-center">No. SO</th>
                                                <th scope="col" class="text-center">Tgl SJ</th>
                                                <th scope="col" class="text-center">Customer</th>
                                                <th scope="col" class="text-center">Item</th>
                                                <th scope="col" class="text-center">Status</th>
                                                <th scope="col" class="text-center" style="width: 22%">Actions</th>
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

    @section('modal')
        <div class="modal fade" role="dialog" id="modal_invoice" data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header br">
                        <h5 class="modal-title">Penerbitan Invoice</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="form_submit" action="/apps/master-delivery-order/inv/publish" method="POST"
                        autocomplete="off">
                        @csrf
                        <input type="text" name="type" id="type" hidden>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-12 col-md-4 col-lg-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4>Informasi Umum</h4>
                                        </div>
                                        <input type="text" id="" value="" hidden>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-12 col-md-12 col-lg-6">
                                                    <div class="form-group">
                                                        <label>No. Surat Jalan :</label>
                                                        <span id="fc_dono"></span>
                                                        <input type="text" name="fc_dono" id="fc_dono_input" hidden>
                                                        <input type="text" name="fc_divisioncode"
                                                            id="fc_divisioncode_input" hidden>
                                                        <input type="text" name="fc_sono" id="fc_sono_input" hidden>
                                                        <input type="text" name="fc_branch" id="fc_branch_input"
                                                            hidden>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-12 col-lg-6">
                                                    <div class="form-group">
                                                        <label>Tanggal :</label>
                                                        <span id="fd_dodate"></span>
                                                    </div>
                                                    {{-- input --}}
                                                    <input type="text" id="fd_dodateinputuser_input"
                                                        name="fd_dodateinputuser" hidden>
                                                </div>
                                                <div class="col-12 col-md-12 col-lg-6">
                                                    <div class="form-group">
                                                        <label>NPWP</label>
                                                        <input type="text" class="form-control" id="fc_membernpwp_no"
                                                            readonly>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-6 col-lg-6">
                                                    <div class="form-group">
                                                        <label>Nama</label>
                                                        <input type="text" class="form-control" id="fc_membername1"
                                                            readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-12 col-lg-6 place_detail">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4>Calculation</h4>
                                        </div>
                                        <div class="card-body" style="height: 185px">
                                            <div class="d-flex">
                                                <div class="flex-row-item" style="margin-right: 30px">
                                                    <div class="d-flex" style="gap: 5px; white-space: pre">
                                                        <p class="text-secondary flex-row-item" style="font-size: medium">
                                                            Item</p>
                                                        <p class="text-success flex-row-item text-right"
                                                            style="font-size: medium" id="fn_dodetail">0,00</p>
                                                    </div>
                                                    <input type="text" name="fn_dodetail" id="fn_dodetail_input"
                                                        hidden>
                                                    <div class="d-flex">
                                                        <p class="flex-row-item"></p>
                                                        <p class="flex-row-item text-right"></p>
                                                    </div>
                                                    <div class="d-flex" style="gap: 5px; white-space: pre">
                                                        <p class="text-secondary flex-row-item" style="font-size: medium">
                                                            Disc. Total</p>
                                                        <p class="text-success flex-row-item text-right"
                                                            style="font-size: medium" id="fm_disctotal">0,00</p>
                                                    </div>
                                                    <input type="text" name="fm_disctotal" id="fm_disctotal_input"
                                                        hidden>
                                                    <div class="d-flex">
                                                        <p class="flex-row-item"></p>
                                                        <p class="flex-row-item text-right"></p>
                                                    </div>
                                                    <div class="d-flex" style="gap: 5px; white-space: pre">
                                                        <p class="text-secondary flex-row-item" style="font-size: medium">
                                                            Total</p>
                                                        <p class="text-success flex-row-item text-right"
                                                            style="font-size: medium" id="fm_netto">0,00</p>
                                                    </div>
                                                </div>
                                                <input type="text" name="fm_netto" id="fm_netto_input" hidden>
                                                <div class="flex-row-item">
                                                    <div class="d-flex" style="gap: 5px; white-space: pre">
                                                        <p class="text-secondary flex-row-item" style="font-size: medium">
                                                            Pelayanan</p>
                                                        <p class="text-success flex-row-item text-right"
                                                            style="font-size: medium" id="fm_servpay">0,00</p>
                                                    </div>
                                                    <input type="text" name="fm_servpay" id="fm_servpay_input" hidden>
                                                    <div class="d-flex">
                                                        <p class="flex-row-item"></p>
                                                        <p class="flex-row-item text-right"></p>
                                                    </div>
                                                    <div class="d-flex" style="gap: 5px; white-space: pre">
                                                        <p class="text-secondary flex-row-item" style="font-size: medium">
                                                            Pajak</p>
                                                        <p class="text-success flex-row-item text-right"
                                                            style="font-size: medium" id="fm_tax">0,00</p>
                                                    </div>
                                                    <input type="text" name="fm_tax" id="fm_tax_input" hidden>
                                                    <div class="d-flex">
                                                        <p class="flex-row-item"></p>
                                                        <p class="flex-row-item text-right"></p>
                                                    </div>
                                                    <div class="d-flex" style="gap: 5px; white-space: pre">
                                                        <p class="text-secondary flex-row-item"
                                                            style="font-weight: bold; font-size: medium">GRAND</p>
                                                        <p class="text-success flex-row-item text-right"
                                                            style="font-weight: bold; font-size:medium" id="fm_brutto">Rp.
                                                            0,00</p>
                                                    </div>
                                                    <input type="text" name="fm_brutto" id="fm_brutto_input" hidden>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-12 col-lg-4">
                                    <div class="form-group">
                                        <label>Tanggal Terbit</label>
                                        <div class="input-group" data-date-format="dd-mm-yyyy">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fas fa-calendar"></i>
                                                </div>
                                            </div>

                                            <input type="text" id="fd_inv_releasedate" class="form-control datepicker"
                                                name="fd_inv_releasedate" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-12 col-lg-4">
                                    <div class="form-group">
                                        <label>Masa</label>
                                        <div class="input-group" data-date-format="dd-mm-yyyy">
                                            <input type="number" id="fn_inv_agingday" class="form-control"
                                                name="fn_inv_agingday" required>
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    Hari
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-12 col-lg-4">
                                    <div class="form-group">
                                        <label>Tanggal Berakhir</label>
                                        <div class="input-group" data-date-format="dd-mm-yyyy">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fas fa-calendar"></i>
                                                </div>
                                            </div>

                                            <input type="text" id="fd_inv_agingdate" class="form-control datepicker"
                                                name="fd_inv_agingdate" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer bg-whitesmoke br">
                            <button type="submit" class="btn btn-success btn-submit">Terbitkan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" role="dialog" id="modal_nama" data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header br">
                        <h5 class="modal-title">Pilih Penanda Tangan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="form_submit_pdf" action="/apps/master-delivery-order/pdf" method="POST"
                        autocomplete="off">
                        @csrf
                        <input type="text" name="fc_dono" id="fc_dono_input_ttd" hidden>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-12 col-md-12 col-lg-12">
                                    <div class="form-group form_group_ttd">
                                        <label class="d-block">Nama</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="name_user"
                                                id="name_user" checked="">
                                            <label class="form-check-label" for="name_user">
                                                {{ auth()->user()->fc_username }}
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="name_user_lainnya"
                                                id="name_user_lainnya">
                                            <label class="form-check-label" for="name_user_lainnya">
                                                Lainnya
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer bg-whitesmoke br">
                            <button type="submit" class="btn btn-success btn-submit">Konfirmasi </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" role="dialog" id="modal_nama2" data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header br">
                        <h5 class="modal-title">Pilih Penanda Tangan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="form_submit_pdf2" action="/apps/master-delivery-order/pdf-sj" method="POST"
                        autocomplete="off">
                        @csrf
                        <input type="text" name="fc_dono" id="fc_dono_input_ttd2" hidden>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-12 col-md-12 col-lg-12">
                                    <div class="form-group form_group_ttd2">
                                        <label class="d-block">Nama</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="name_user2"
                                                id="name_user2" checked="">
                                            <label class="form-check-label" for="name_user2">
                                                {{ auth()->user()->fc_username }}
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="name_user_lainnya2"
                                                id="name_user_lainnya2">
                                            <label class="form-check-label" for="name_user_lainnya2">
                                                Lainnya
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer bg-whitesmoke br">
                            <button type="submit" class="btn btn-success btn-submit">Konfirmasi </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endsection

    @section('js')
        <script>
            $('#modal_invoice').css('overflow-y', 'auto');

            $(document).ready(function() {
                $('#form_submit').submit(function() {
                    $('#modal_invoice').modal('hide');
                });
                // $('.btn-submit').click(function() {
                //     $('#modal_invoice').modal('hide');
                // });

                var isNamePjShown = false;

                $('#name_user_lainnya').click(function() {
                    // Uncheck #name_user
                    $('#name_user').prop('checked', false);

                    // Show #form_pj
                    if (!isNamePjShown) {
                        $('.form_group_ttd').append(
                            '<div class="form-group" id="form_pj"><label>Nama PJ</label><input type="text" class="form-control" name="name_pj" id="name_pj"></div>'
                        );
                        isNamePjShown = true;
                    }
                });

                $('#name_user').click(function() {
                    // Uncheck #name_user_lainnya
                    $('#name_user_lainnya').prop('checked', false);

                    // Hide #form_pj
                    if (isNamePjShown) {
                        $('#form_pj').remove();
                        isNamePjShown = false;
                    }
                });

                $('#name_pj').focus(function() {
                    $('.form-group:last').toggle();
                });


                var isNamePjShown = false;

                $('#name_user_lainnya2').click(function() {
                    // Uncheck #name_user
                    $('#name_user2').prop('checked', false);

                    // Show #form_pj
                    if (!isNamePjShown) {
                        $('.form_group_ttd2').append(
                            '<div class="form-group" id="form_pj2"><label>Nama PJ</label><input type="text" class="form-control" name="name_pj2" id="name_pj2"></div>'
                        );
                        isNamePjShown = true;
                    }
                });

                $('#name_user2').click(function() {
                    // Uncheck #name_user_lainnya
                    $('#name_user_lainnya2').prop('checked', false);

                    // Hide #form_pj
                    if (isNamePjShown) {
                        $('#form_pj2').remove();
                        isNamePjShown = false;
                    }
                });

                $('#name_pj2').focus(function() {
                    $('.form-group:last').toggle();
                });
            });


            // untuk memunculkan nama penanggung jawab
            function click_modal_nama(fc_dono) {
                $('#fc_dono_input_ttd').val(fc_dono);
                $('#modal_nama').modal('show');
            };

            function click_modal_nama2(fc_dono) {
                $('#fc_dono_input_ttd2').val(fc_dono);
                $('#modal_nama2').modal('show');
            };

            function click_modal_invoice(fc_dono) {
                // tambahkan text pada label dengan id fc_dono
                $('#fc_dono').text(fc_dono);

                // tambahkan modal loading
                $('#modal_loading').modal('show');

                $.ajax({
                    url: '/apps/master-delivery-order/datatables/detail',
                    type: 'GET',
                    data: {
                        'fc_dono': fc_dono
                    },
                    success: function(data) {
                        // hilangkan modal loading
                        setTimeout(function() {
                            $('#modal_loading').modal('hide');
                        }, 500);

                        console.log(data);
                        // tampilkan modal_invoice
                        $('#modal_invoice').modal('show');

                        // set fc_dono
                        $('#fc_dono').text(data.fc_dono);
                        // set fc_dono input
                        $('#fc_dono_input').val(data.fc_dono);

                        // set fc_divisioncode input
                        $('#fc_divisioncode_input').val(data.fc_divisioncode);

                        // set fc_sono input
                        $('#fc_sono_input').val(data.fc_sono);

                        // set fc_branch input
                        $('#fc_branch_input').val(data.fc_branch);

                        // set fd_dodateinputuser
                        $('#fd_dodate').text(
                            moment(data.fd_dodate).format('D MMMM Y')
                        );
                        // set fd_dodateinputuser input
                        $('#fd_dodate_input').val(
                            moment(data.fd_dodate).format('D MMMM Y')
                        );
                        //set fc_membernpwp_no input value
                        $('#fc_membernpwp_no').val(data.somst.customer.fc_membernpwp_no);

                        // set fc_membername1 input value
                        $('#fc_membername1').val(data.somst.customer.fc_membername1);

                        // autofill fn_agingdate
                        $('#fn_inv_agingday').on('input', function() {
                            var fd_inv_releasedate = $('#fd_inv_releasedate').val();
                            var fn_inv_agingday = $('#fn_inv_agingday').val();
                            var fd_inv_agingdate = moment(fd_inv_releasedate, 'YYYY-MM-DD').add(
                                fn_inv_agingday, 'days').format('YYYY-MM-DD');
                            $('#fd_inv_agingdate').val(fd_inv_agingdate);
                        });

                        // set fn_dodetail
                        $('#fn_dodetail').html(data.fn_dodetail);
                        $("#fn_dodetail").trigger("change");
                        // set fn_dodetail_input
                        $('#fn_dodetail_input').val(data.fn_dodetail);

                        // set fm_disctotal
                        $('#fm_disctotal').html("Rp. " + fungsiRupiah(data.fm_disctotal));
                        $("#fm_disctotal").trigger("change");
                        // set fm_disctotal_input
                        $('#fm_disctotal_input').val(data.fm_disctotal);

                        // set fm_servpay
                        $('#fm_servpay').html("Rp. " + fungsiRupiah(data.fm_servpay));
                        $("#fm_servpay").trigger("change");
                        // set fm_servpay_input
                        $('#fm_servpay_input').val(data.fm_servpay);

                        // set fm_netto
                        $('#fm_netto').html("Rp. " + fungsiRupiah(data.fm_netto));
                        $("#fm_netto").trigger("change");
                        // set fm_netto_input
                        $('#fm_netto_input').val(data.fm_netto);

                        // set fm_tax
                        $('#fm_tax').html("Rp. " + fungsiRupiah(data.fm_tax));
                        $("#fm_tax").trigger("change");
                        // set fm_tax_input
                        $('#fm_tax_input').val(data.fm_tax);

                        // set fm_brutto
                        $('#fm_brutto').html("Rp. " + fungsiRupiah(data.fm_brutto));

                        $("#fm_brutto").trigger("change");
                        // set fm_brutto_input
                        $('#fm_brutto_input').val(data.fm_brutto);
                    },
                    error: function() {
                        // // hilangkan modal loading
                        // $('#modal_loading').modal('hide');

                        console.log('Error retrieving fd_dodate');
                    }
                });
            }

            function submitDO(fc_dono) {
                swal({
                    title: "Konfirmasi",
                    text: "Anda yakin ingin submit surat jalan ini?",
                    type: "warning",
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true,
                }).then((save) => {
                    if (save) {
                        $("#modal_loading").modal('show');
                        $.ajax({
                            url: '/apps/master-delivery-order/submit',
                            type: 'PUT',
                            data: {
                                fc_dostatus: 'D',
                                fc_dono: fc_dono
                            },
                            success: function(response) {
                                setTimeout(function() {
                                    $('#modal_loading').modal('hide');
                                }, 500);
                                if (response.status == 201) {
                                    swal(response.message, {
                                        icon: 'success',
                                    });
                                    $("#modal").modal('hide');
                                    tb.ajax.reload();
                                    tb_pengiriman.ajax.reload();
                                    tb_diterima.ajax.reload();
                                } else {
                                    swal(response.message, {
                                        icon: 'error',
                                    });
                                    $("#modal").modal('hide');
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

            function cancelDO(fc_dono) {
                swal({
                    title: "Konfirmasi",
                    text: "Anda yakin ingin cancel surat jalan ini?",
                    type: "warning",
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true,
                }).then((save) => {
                    if (save) {
                        $("#modal_loading").modal('show');
                        $.ajax({
                            url: '/apps/master-delivery-order/cancel',
                            type: 'PUT',
                            data: {
                                fc_dostatus: 'CC',
                                fc_dono: fc_dono
                            },
                            success: function(response) {
                                setTimeout(function() {
                                    $('#modal_loading').modal('hide');
                                }, 500);
                                if (response.status == 201) {
                                    swal(response.message, {
                                        icon: 'success',
                                    });
                                    $("#modal").modal('hide');
                                    tb.ajax.reload();
                                    tb_pengiriman.ajax.reload();
                                    tb_diterima.ajax.reload();
                                } else {
                                    swal(response.message, {
                                        icon: 'error',
                                    });
                                    $("#modal").modal('hide');
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

            var tb = $('#tb_semua').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 5,
                order: [
                    [3, 'desc']
                ],
                ajax: {
                    url: '/apps/master-delivery-order/datatables/ALL',
                    type: 'GET'
                },
                columnDefs: [{
                        className: 'text-center',
                        targets: [0, 6]
                    },
                    {
                        className: 'text-nowrap',
                        targets: [3, 8]
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
                        data: 'fc_dostatus'
                    },
                    {
                        data: 'fc_invstatus'
                    },
                    {
                        data: null
                    },
                ],
                rowCallback: function(row, data) {
                    var fc_dono = window.btoa(data.fc_dono);
                    $('td:eq(6)', row).html(`<i class="${data.fc_dostatus}"></i>`);
                    if (data['fc_dostatus'] == 'I') {
                        $(row).hide();
                    } else if (data['fc_dostatus'] == 'D') {
                        $('td:eq(6)', row).html('<span class="badge badge-primary">Pengiriman</span>');
                    } else if (data['fc_dostatus'] == 'P') {
                        $('td:eq(6)', row).html('<span class="badge badge-info">Terbayar</span>');
                    } else if (data['fc_dostatus'] == 'CC') {
                        $('td:eq(6)', row).html('<span class="badge badge-danger">Cancel</span>');
                    } else if (data['fc_dostatus'] == 'L') {
                        $('td:eq(6)', row).html('<span class="badge badge-danger">Lock</span>');
                    } else {
                        $('td:eq(6)', row).html('<span class="badge badge-success">Diterima</span>');
                    }

                    if (data['fc_invstatus'] == 'INV') {
                        $('td:eq(7)', row).html('<span class="badge badge-primary">Terbit</span>');
                    } else if (data['fc_invstatus'] == 'N') {
                        $('td:eq(7)', row).html('<span class="badge badge-danger">Belum Terbit</span>');
                    } else {
                        $('td:eq(7)', row).html('<span class="badge badge-success">Lunas</span>');
                    }

                    if (data['fc_dostatus'] == 'I' || data['fc_dostatus'] == 'NA' || data['fc_dostatus'] == 'AC' ||
                        data['fc_dostatus'] == 'RJ') {
                        $(row).hide();
                    } else if (data['fc_dostatus'] == 'D') {
                        $('td:eq(8)', row).html(
                            `
                        <button class="btn btn-warning btn-sm" onclick="click_modal_nama('${data.fc_dono}')"><i class="fa fa-file"></i> PDF</button>
                        <button class="btn btn-primary btn-sm ml-1" onclick="click_modal_nama2('${data.fc_dono}')"><i class="fa fa-truck"></i> Surat Jalan</button>
                        <button class="btn btn-danger btn-sm ml-1" onclick="cancelDO('${data.fc_dono}')"><i class="fa fa-times"></i> Cancel DO</button>`
                        );
                    } else {
                        $('td:eq(8)', row).html(
                            `
                        <button class="btn btn-warning btn-sm" onclick="click_modal_nama('${data.fc_dono}')"><i class="fa fa-file"></i> PDF</button>
                        <button class="btn btn-primary btn-sm ml-1" onclick="click_modal_nama2('${data.fc_dono}')"><i class="fa fa-truck"></i> Surat Jalan</button>`
                        );
                    }
                }
            });

            var tb_pengiriman = $('#tb_pengiriman').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 5,
                order: [
                    [3, 'desc']
                ],
                ajax: {
                    url: '/apps/master-delivery-order/datatables/D',
                    type: 'GET'
                },
                columnDefs: [{
                        className: 'text-center',
                        targets: [0, 6]
                    },
                    {
                        className: 'text-nowrap',
                        targets: [3, 8]
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
                        data: 'fc_dostatus'
                    },
                    {
                        data: 'fc_invstatus'
                    },
                    {
                        data: null
                    },
                ],
                rowCallback: function(row, data) {
                    var fc_dono = window.btoa(data.fc_dono);
                    $('td:eq(6)', row).html(`<i class="${data.fc_dostatus}"></i>`);
                    if (data['fc_dostatus'] == 'D') {
                        $('td:eq(6)', row).html('<span class="badge badge-primary">Pengiriman</span>');
                    } else {
                        $(row).hide();
                    }

                    if (data['fc_invstatus'] == 'R') {
                        $('td:eq(7)', row).html('<span class="badge badge-primary">Terbit</span>');
                    } else if (data['fc_invstatus'] == 'N') {
                        $('td:eq(7)', row).html('<span class="badge badge-danger">Belum Terbit</span>');
                    } else {
                        $('td:eq(7)', row).html('<span class="badge badge-success">Lunas</span>');
                    }

                    if (data['fc_dostatus'] == 'I') {
                        $(row).hide();
                    } else {
                        $('td:eq(8)', row).html(
                            `
                    <button class="btn btn-warning btn-sm mr-1" onclick="click_modal_nama('${data.fc_dono}')"><i class="fa fa-file"></i> PDF</button>
                    <button class="btn btn-primary btn-sm ml-1" onclick="click_modal_nama2('${data.fc_dono}')"><i class="fa fa-truck"></i> Surat Jalan</button>
                    <button class="btn btn-danger btn-sm ml-1" onclick="cancelDO('${data.fc_dono}')"><i class="fa fa-times"></i> Cancel DO</button>`
                        );
                    }
                }
            });

            var tb_diterima = $('#tb_diterima').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 5,
                order: [
                    [3, 'desc']
                ],
                ajax: {
                    url: '/apps/master-delivery-order/datatables/R',
                    type: 'GET'
                },
                columnDefs: [{
                        className: 'text-center',
                        targets: [0, 6]
                    },
                    {
                        className: 'text-nowrap',
                        targets: [3, 8]
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
                        data: 'fc_dostatus'
                    },
                    {
                        data: 'fc_invstatus'
                    },
                    {
                        data: null
                    },
                ],
                rowCallback: function(row, data) {
                    var fc_dono = window.btoa(data.fc_dono);
                    $('td:eq(6)', row).html(`<i class="${data.fc_dostatus}"></i>`);
                    if (data['fc_dostatus'] == 'R') {
                        $('td:eq(6)', row).html('<span class="badge badge-success">Diterima</span>');
                    } else {
                        $(row).hide();
                    }

                    if (data['fc_invstatus'] == 'R') {
                        $('td:eq(7)', row).html('<span class="badge badge-primary">Terbit</span>');
                    } else if (data['fc_invstatus'] == 'N') {
                        $('td:eq(7)', row).html('<span class="badge badge-danger">Belum Terbit</span>');
                    } else {
                        $('td:eq(7)', row).html('<span class="badge badge-success">Lunas</span>');
                    }

                    if (data['fc_dostatus'] == 'I') {
                        $(row).hide();
                    } else {
                        $('td:eq(8)', row).html(
                            `
                            <button class="btn btn-warning btn-sm mr-1" onclick="click_modal_nama('${data.fc_dono}')"><i class="fa fa-file"></i> PDF</button>
                            <button class="btn btn-primary btn-sm ml-1" onclick="click_modal_nama2('${data.fc_dono}')"><i class="fa fa-truck"></i> Surat Jalan</button>`
                        );
                    }
                }
            });

            var tb_approval = $('#tb_approval').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 5,
                order: [
                    [3, 'desc']
                ],
                ajax: {
                    url: '/apps/master-delivery-order/datatables/APR',
                    type: 'GET'
                },
                columnDefs: [{
                        className: 'text-center',
                        targets: [0, 3, 5, 6]
                    },
                    {
                        className: 'text-nowrap',
                        targets: [3, 7]
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
                        data: 'fc_dostatus'
                    },
                    {
                        data: null
                    },
                ],
                rowCallback: function(row, data) {
                    var fc_dono = window.btoa(data.fc_dono);
                    $('td:eq(6)', row).html(`<i class="${data.fc_dostatus}"></i>`);
                    if (data['fc_dostatus'] == 'NA') {
                        $('td:eq(6)', row).html('<span class="badge badge-warning">Menunggu Perizinan</span>');
                    } else if (data['fc_dostatus'] == 'AC') {
                        $('td:eq(6)', row).html('<span class="badge badge-success">Perizinan Diterima</span>');
                    } else {
                        $('td:eq(6)', row).html('<span class="badge badge-danger">Perizinan Ditolak</span>');
                    }

                    if ((data['fc_dostatus'] == 'NA' || data['fc_dostatus'] == 'AC' || data['fc_dostatus'] ==
                            'RJ')) {
                        $('td:eq(7)', row).html(`
                        <a href="/apps/master-delivery-order/detail/${fc_dono}"><button class="btn btn-primary btn-sm mr-1"><i class="fa fa-eye"></i> Detail</button></a>
                    `);
                        if (data['fc_dostatus'] == 'AC') {
                            $('td:eq(7)', row).append(`
                            <button class="btn btn-success btn-sm mr-1" onClick="submitDO('${fc_dono}')">Submit</button>
                        `);
                        }
                    } else {
                        $(row).hide();
                    }
                    //<a href="/apps/master-delivery-order/inv/${data.fc_dono}" target="_blank"><button class="btn btn-success btn-sm mr-1"><i class="fa fa-credit-card"></i> Invoice</button></a>`
                }
            });

            $('#form_submit_pdf2').on('submit', function(e) {
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
                    .then((save) => {
                        if (save) {
                            $("#modal_loading").modal('show');
                            $.ajax({
                                url: $('#form_submit_pdf2').attr('action'),
                                type: $('#form_submit_pdf2').attr('method'),
                                data: $('#form_submit_pdf2').serialize(),
                                success: function(response) {
                                    setTimeout(function() {
                                        $('#modal_loading').modal('hide');
                                    }, 500);
                                    if (response.status == 200) {
                                        swal(response.message, {
                                            icon: 'success',
                                        });
                                        $("#modal").modal('hide');
                                        $("#form_submit_pdf2")[0].reset();
                                        reset_all_select();
                                        tb.ajax.reload(null, false);
                                    } else if (response.status == 201) {
                                        swal(response.message, {
                                            icon: 'success',
                                        });
                                        $("#modal").modal('hide');
                                        $("#modal_pdf").modal('hide');
                                        //  location.href = response.link;
                                        window.open(
                                            response.link,
                                            '_blank' // <- This is what makes it open in a new window.
                                        );
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
                                    swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + jqXHR
                                        .responseText + ")", {
                                            icon: 'error',
                                        });
                                }
                            });
                        }
                    });
            });
        </script>
    @endsection
