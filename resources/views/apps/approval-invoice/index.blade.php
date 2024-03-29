@extends('partial.app')
@section('title', 'Approval Invoice')
@section('css')
<style>
    .required label:after {
        color: #e32;
        content: ' *';
        display: inline;
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
                    <h4>Data Request Approval Invoice</h4>
                </div>
                <div class="card-body">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active show" id="berkasku-tab" data-toggle="tab" href="#berkasku" role="tab" aria-controls="berkasku" aria-selected="true">Berkasku</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="perizinan-tab" data-toggle="tab" href="#perizinan" role="tab" aria-controls="perizinan" aria-selected="false">Perizinan</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade active show" id="berkasku" role="tabpanel" aria-labelledby="berkasku-tab">
                            <div class="table-responsive">
                                <table class="table table-striped" id="tb_applicant" width="100%">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="text-center text-nowrap">No. Approval</th>
                                            <th scope="col" class="text-center text-nowrap">No. Invoice</th>
                                            <th scope="col" class="text-center">Tanggal</th>
                                            <th scope="col" class="text-center">Status</th>
                                            <th scope="col" class="text-center">Penggunaan</th>
                                            <th scope="col" class="text-center">Keterangan</th>
                                            <th scope="col" class="text-center" style="width: 20%">Actions</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="perizinan" role="tabpanel" aria-labelledby="perizinan-tab">
                            <div class="table-responsive">
                                <table class="table table-striped" id="tb_accessor" width="100%">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="text-center">No.</th>
                                            <th scope="col" class="text-center text-nowrap">No. Approval</th>
                                            <th scope="col" class="text-center">Pemohon</th>
                                            <th scope="col" class="text-center">Referensi Dok.</th>
                                            <th scope="col" class="text-center">Tanggal</th>
                                            <th scope="col" class="text-center">Status</th>
                                            <th scope="col" class="text-center">Keterangan</th>
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
    </div>
</div>
@endsection

@section('modal')
<div class="modal fade" role="dialog" id="modal_cancel" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header br">
                <h5 class="modal-title">Cancel Approval</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_submit_cancel" action="/apps/approval-invoice/cancel-approval" method="PUT" autocomplete="off">
                <input type="text" class="form-control" name="fc_branch" id="fc_branch" value="{{ auth()->user()->fc_branch}}" readonly hidden>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-8">
                            <div class="form-group">
                                <label>No. Approval</label>
                                <input name="fc_approvalno_cancel" id="fc_approvalno_cancel" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="form-group">
                                <label>Pemohon</label>
                                <input name="fc_applicantid" id="fc_applicantid" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-12">
                            <div class="form-group required">
                                <label>Alasan</label>
                                <input name="fv_description" id="fv_description" type="text" class="form-control" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" role="dialog" id="modal_detail" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header br">
                <h5 class="modal-title">Detail Approval</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-8">
                        <div class="form-group">
                            <label>No. Approval</label>
                            <input name="fc_approvalno_detail" id="fc_approvalno_detail" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-group">
                            <label>Pemohon</label>
                            <input name="fc_applicantid_detail" id="fc_applicantid_detail" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-12">
                        <div class="form-group">
                            <label>Alasan</label>
                            <input name="fv_description_detail" id="fv_description_detail" class="form-control" readonly>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" role="dialog" id="modal_reject" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header br">
                <h5 class="modal-title">Reject Approval</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_submit_reject" action="/apps/approval-invoice/reject" method="POST" autocomplete="off">
                <input type="text" class="form-control" name="fc_branch" id="fc_branch" value="{{ auth()->user()->fc_branch}}" readonly hidden>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-8">
                            <div class="form-group">
                                <label>No. Approval</label>
                                <input name="fc_approvalno_reject" id="fc_approvalno_reject" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="form-group">
                                <label>Pemohon</label>
                                <input name="fc_applicantid_reject" id="fc_applicantid_reject" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-12">
                            <div class="form-group required">
                                <label>Keterangan</label>
                                <input name="fd_accessorrespon_reject" id="fd_accessorrespon_reject" type="text" class="form-control" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" role="dialog" id="modal_accept" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header br">
                <h5 class="modal-title">Accept Approval</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_submit_accept" action="/apps/approval-invoice/accept" method="POST" autocomplete="off">
                <input type="text" class="form-control" name="fc_branch" id="fc_branch" value="{{ auth()->user()->fc_branch}}" readonly hidden>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-8">
                            <div class="form-group">
                                <label>No. Approval</label>
                                <input name="fc_approvalno_accept" id="fc_approvalno_accept" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="form-group">
                                <label>Pemohon</label>
                                <input name="fc_applicantid_accept" id="fc_applicantid_accept" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-12">
                            <div class="form-group required">
                                <label>Keterangan</label>
                                <input name="fd_accessorrespon_accept" id="fd_accessorrespon_accept" type="text" class="form-control" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" role="dialog" id="modal_approvdetail" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header br">
                <h5 class="modal-title">Detail Approval</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-8">
                        <div class="form-group">
                            <label>No. Approval</label>
                            <input name="fc_approvalno" id="fc_approvalno_dtl" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-group">
                            <label>Pemberi Akses</label>
                            <input name="fc_accessorid" id="fc_accessorid_dtl" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-12">
                        <div class="form-group">
                            <label>Tanggal Approval</label>
                            <div class="input-group date">
                                <input name="fd_userinput" id="fd_userinput_dtl" class="form-control" readonly>
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fas fa-calendar"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-12">
                        <div class="form-group">
                            <label>Catatan</label>
                            <input name="fd_accessorrespon" id="fd_accessorrespon_dtl" class="form-control" readonly>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" role="dialog" id="modal_pdf" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header br">
                <h5 class="modal-title">Penanda Tangan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_submit_pdf" action="/apps/approval-invoice/pdf" method="POST" autocomplete="off">
                @csrf
                <input type="text" name="fc_docno" id="fc_docno_input" hidden>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                <label>Nama</label>
                                <input name="fc_accessorid" id="fc_accessorid_pdf" class="form-control" readonly>
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
    function cancel(fc_approvalno) {
        $("#modal_cancel").modal('show');
        get(fc_approvalno);
    }

    function reject(fc_approvalno) {
        $("#modal_reject").modal('show');
        get(fc_approvalno);
    }

    function accept(fc_approvalno) {
        $("#modal_accept").modal('show');
        get(fc_approvalno);
    }

    function detail_applicant(fc_approvalno) {
        $("#modal_detail").modal('show');
        get_detail(fc_approvalno);
    }

    function detail_approval(fc_approvalno) {
        $("#modal_approvdetail").modal('show');
        get_detail(fc_approvalno);
    }

    function click_modal_pdf(fc_approvalno) {
        $('#modal_pdf').modal('show');
        get_detail(fc_approvalno);
    };

    var tb_applicant = $('#tb_applicant').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        pageLength: 5,
        ajax: {
            url: "/apps/approval-invoice/datatables-applicant",
            type: 'GET',
        },
        columnDefs: [{
            className: 'text-center',
            targets: [0, 1, 2, 3, 4, 5]
        }, {
            className: 'text-nowrap',
            targets: [6]
        }],
        columns: [{
                data: 'fc_approvalno'
            },
            {
                data: 'fc_docno'
            },
            {
                data: 'fd_userinput',
                render: formatTimestamp
            },
            {
                data: 'fc_approvalstatus'
            },
            {
                data: 'fc_approvalused'
            },
            {
                data: 'fc_annotation'
            },
            {
                data: null,
            },
        ],

        rowCallback: function(row, data) {
            var fc_docno = window.btoa(data.fc_docno);
            // var url_lanjutkan = "/apps/daftar-transaksi/pdf/" + fc_trxno;

            if (data['fc_approvalstatus'] == 'W') {
                $('td:eq(3)', row).html('<span class="badge badge-primary">Menunggu</span>');
            } else if (data['fc_approvalstatus'] == 'R') {
                $('td:eq(3)', row).html('<span class="badge badge-danger">Ditolak</span>');
            } else if (data['fc_approvalstatus'] == 'C') {
                $('td:eq(3)', row).html('<span class="badge badge-danger">Cancel</span>');
            } else {
                $('td:eq(3)', row).html('<span class="badge badge-success">Diterima</span>');
            }

            if (data['fc_approvalused'] == 'F') {
                $('td:eq(4)', row).html('<span class="badge badge-danger">Belum Digunakan</span>');
            } else {
                $('td:eq(4)', row).html('<span class="badge badge-success">Telah Digunakan</span>');
            }

            if (data['fc_approvalstatus'] == 'W') {
                $('td:eq(6)', row).html(`
                    <button class="btn btn-danger btn-sm" onclick="cancel('${data.fc_approvalno}')"><i class="fas fa-ban"></i> Cancel</button>
                `);
            } else if (data['fc_approvalstatus'] == 'C') {
                $('td:eq(6)', row).html(`
                    <button class="btn btn-primary btn-sm" onclick="detail_applicant('${data.fc_approvalno}')"><i class="fas fa-eye"></i> Detail</button>
                `);
            } else if (data['fc_approvalstatus'] == 'R') {
                $('td:eq(6)', row).html(`
                <button class="btn btn-primary btn-sm mr-1" onclick="detail_approval('${data.fc_approvalno}')"><i class="fas fa-eye"></i> Detail</button>
                `);
            } else if (data['fc_approvalstatus'] == 'A' && data['fc_approvalused'] == 'T') {
                $('td:eq(6)', row).html(`
                <button class="btn btn-primary btn-sm mr-1" onclick="detail_approval('${data.fc_approvalno}')"><i class="fas fa-eye"></i> Detail</button>
                `);
            } else {
                $('td:eq(6)', row).html(`
                    <button class="btn btn-primary btn-sm mr-1" onclick="detail_approval('${data.fc_approvalno}')"><i class="fas fa-eye"></i> Detail</button>
                    <button class="btn btn-warning btn-sm mr-1" onclick="click_modal_pdf('${data.fc_approvalno}')"><i class="fa fa-file"></i> PDF</button>
                `);
            }
        },
    });

    var tb_accessor = $('#tb_accessor').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        pageLength: 5,
        ajax: {
            url: "/apps/approval-invoice/datatables-accessor",
            type: 'GET',
        },
        columnDefs: [{
            className: 'text-center',
            targets: [0, 1, 2, 3, 4, 5, 6]
        }, {
            className: 'text-nowrap',
            targets: [7]
        }],
        columns: [{
                data: 'DT_RowIndex',
                searchable: false,
                orderable: false
            },
            {
                data: 'fc_approvalno'
            },
            {
                data: 'fc_applicantid'
            },
            {
                data: 'fc_docno'
            },
            {
                data: 'fd_userinput',
                render: formatTimestamp
            },
            {
                data: 'fc_approvalstatus'
            },
            {
                data: 'fc_annotation'
            },
            {
                data: null,
            },
        ],

        rowCallback: function(row, data) {
            var fc_approvalno = window.btoa(data.fc_approvalno);

            if (data['fc_approvalstatus'] == 'W') {
                $('td:eq(5)', row).html('<span class="badge badge-primary">Menunggu</span>');
            } else if (data['fc_approvalstatus'] == 'R') {
                $('td:eq(5)', row).html('<span class="badge badge-danger">Ditolak</span>');
            } else if (data['fc_approvalstatus'] == 'C') {
                $('td:eq(5)', row).html('<span class="badge badge-danger">Cancel</span>');
            } else {
                $('td:eq(5)', row).html('<span class="badge badge-success">Diterima</span>');
            }

            if (data['fc_approvalstatus'] == 'C') {
                $('td:eq(7)', row).html(`
                    <button class="btn btn-primary btn-sm" onclick="detail_applicant('${data.fc_approvalno}')"><i class="fas fa-eye"></i> Detail</button>
                `);
            } else if (data['fc_approvalstatus'] == 'W') {
                $('td:eq(7)', row).html(`
                    <button class="btn btn-danger btn-sm mr-1" onclick="reject('${data.fc_approvalno}')"><i class="fas fa-x mr-1"></i> Reject</button>
                    <button class="btn btn-success btn-sm" onclick="accept('${data.fc_approvalno}')"><i class="fas fa-check mr-1"></i> Accept</button>
                `);
            } else {
                $('td:eq(7)', row).html(`
                    <button class="btn btn-primary btn-sm" onclick="detail_approval('${data.fc_approvalno}')"><i class="fas fa-eye"></i> Detail</button>
                `);
            }
        },
    });

    function get(fc_approvalno) {
        var approvalno = window.btoa(fc_approvalno);

        $.ajax({
            url: "/apps/approval-invoice/get/" + approvalno,
            type: 'GET',
            dataType: 'JSON',
            success: function(response) {
                var data = response.data;
                setTimeout(function() {}, 500);

                if (response.status == 200) {
                    // console.log(data);
                    $('#fc_approvalno_cancel').val(data.fc_approvalno);
                    $('#fc_applicantid').val(data.fc_applicantid);

                    $('#fc_approvalno_reject').val(data.fc_approvalno);
                    $('#fc_applicantid_reject').val(data.fc_applicantid);

                    $('#fc_approvalno_accept').val(data.fc_approvalno);
                    $('#fc_applicantid_accept').val(data.fc_applicantid);
                } else {
                    iziToast.error({
                        title: 'Error!',
                        message: response.message,
                        position: 'topRight'
                    });
                }

            },
            error: function(jqXHR, textStatus, errorThrown) {
                setTimeout(function() {
                    $('#modal_loading').modal('hide');
                }, 500);
                swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + errorThrown + ")", {
                    icon: 'error',
                });
            }
        })
    }

    function get_detail(fc_approvalno) {
        var approvalno = window.btoa(fc_approvalno);

        $.ajax({
            url: "/apps/approval-invoice/get-detail/" + approvalno,
            type: 'GET',
            dataType: 'JSON',
            success: function(response) {
                var data = response.data;
                setTimeout(function() {}, 500);

                if (response.status == 200) {
                    console.log(data);
                    $('#fc_approvalno_detail').val(data.fc_approvalno);
                    $('#fc_applicantid_detail').val(data.fc_applicantid);
                    $('#fv_description_detail').val(data.fv_description);

                    $('#fc_approvalno_dtl').val(data.fc_approvalno);
                    $('#fd_accessorrespon_dtl').val(data.fd_accessorrespon);
                    $('#fd_userinput_dtl').val(data.fd_userinput);
                    $('#fc_accessorid_dtl').val(data.fc_accessorid);

                    $('#fc_docno_input').val(data.fc_docno);
                    $('#fc_accessorid_pdf').val(data.fc_accessorid);
                } else {
                    iziToast.error({
                        title: 'Error!',
                        message: response.message,
                        position: 'topRight'
                    });
                }

            },
            error: function(jqXHR, textStatus, errorThrown) {
                setTimeout(function() {
                    $('#modal_loading').modal('hide');
                }, 500);
                swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + errorThrown + ")", {
                    icon: 'error',
                });
            }
        })
    }

    $('.modal').css('overflow-y', 'auto');
</script>

@endsection