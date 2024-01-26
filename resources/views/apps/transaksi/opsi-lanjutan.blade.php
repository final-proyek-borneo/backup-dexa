@extends('partial.app')
@section('title', 'Transaksi Accounting')
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
</style>
@endsection

@section('content')
<div class="section-body">
    <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="form-row">
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group d-flex-row">
                                <label>Debit</label>
                                <div class="text mt-2">
                                    <h5 class="text-success" style="font-weight: bold; font-size:large" id="debit" name="debit"></h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group d-flex-row">
                                <label id="label_kekurangan">Kredit</label>
                                <div class="text mt-2">
                                    <h5 class="text-danger" style="font-weight: bold; font-size:large" id="kredit" name="kredit"></h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group d-flex-row">
                                <label>Balance</label>
                                <div class="text mt-2">
                                    <h5 class="text-muted" style="font-weight: bold; font-size:large" id="balance" name="balance"></h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group d-flex-row">
                                <label>{{ $coa->coamst->fc_coaname }}</label>
                                <div class="text mt-2">
                                    <h5 class="text-info" style="font-weight: bold; font-size:large" id="nominal_coa" name="nominal_coa"></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Opsi Lanjutan --}}
        <div class="col-12 col-md-12 col-lg-12 place_detail">
            <div class="card">
                <div class="card-header">
                    <h4>Opsi Lanjutan</h4>
                    <div class="card-header-action">
                        <button type="button" class="btn btn-success" onclick="add_opsi();"><i class="fa fa-plus"></i> Tambah Opsi</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table table-striped" id="tb_opsi" width="100%">
                                <thead style="white-space: nowrap">
                                    <tr>
                                        <th scope="col" class="text-center">No</th>
                                        <th scope="col" class="text-center">Kode COA</th>
                                        <th scope="col" class="text-center">Nama COA</th>
                                        <th scope="col" class="text-center">Nominal</th>
                                        <th scope="col" class="text-center">Metode Pembayaran</th>
                                        <th scope="col" class="text-center">No. Giro</th>
                                        <th scope="col" class="text-center">Jatuh Tempo</th>
                                        <th scope="col" class="text-center">Keterangan</th>
                                        <th scope="col" class="text-center" style="width: 10%">Actions</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-12 col-lg-12">
            <form id="form_submit_edit" action="/apps/transaksi/detail/submit_transaksi" method="post">
                @csrf
                @method('put')
                <div class="button text-right mb-4">
                    <input type="text" name="status_balance" id="status_balance" hidden>
                    <input type="text" name="jumlah_balance" id="jumlah_balance" hidden>
                    <input type="text" name="tipe_jurnal" id="tipe_jurnal" value="{{ $data->transaksitype->fv_description }}" hidden>
                    <button type="button" onclick="click_cancel()" class="btn btn-danger mr-1">Cancel</button>
                    <button type="button" onclick="click_pending()" class="btn btn-warning mr-1">Pending</button>
                    <button type="submit" class="btn btn-success">Submit Transaksi</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('modal')
<div class="modal fade" role="dialog" id="modal_opsi" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header br">
                <h5 class="modal-title">Tambah Opsi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_submit_opsi" action="/apps/transaksi/store-opsi" method="POST" autocomplete="off">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-12">
                            <div class="form-group required">
                                <label>Kode COA</label>
                                <select name="fc_coacode" id="fc_coacode" onchange="get_detail_coa()" class="select2" required></select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label id="label-select">Direct Payment</label>
                                <div class="selectgroup w-100">
                                    <label class="selectgroup-item" style="margin: 0!important">
                                        <input type="radio" name="fc_directpayment" id="fc_directpayment" value="T" class="selectgroup-input" disabled>
                                        <input type="text" name="fc_balancerelation" value="{{ $data->mapping->fc_balancerelation }}" hidden>
                                        <span class="selectgroup-button">YA</span>
                                    </label>
                                    <label class="selectgroup-item" style="margin: 0!important">
                                        <input type="radio" name="fc_directpayment" id="fc_directpayment" value="F" class="selectgroup-input" checked="" disabled>
                                        <span class="selectgroup-button">TIDAK</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label id="label-select">Status Neraca</label>
                                <div class="selectgroup w-100">
                                    <label class="selectgroup-item" style="margin: 0!important">
                                        <input type="radio" name="fc_balancestatus" id="fc_balancestatus" value="C" class="selectgroup-input" disabled>
                                        <span class="selectgroup-button">KREDIT</span>
                                    </label>
                                    <label class="selectgroup-item" style="margin: 0!important">
                                        <input type="radio" name="fc_balancestatus" id="fc_balancestatus" value="D" class="selectgroup-input" checked="" disabled>
                                        <span class="selectgroup-button">DEBIT</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-12">
                            <div class="form-group ">
                                <label>Group</label>
                                <select name="fc_group" id="fc_group" class="select2" disabled></select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-12">
                            <div class="form-group required">
                                <label>Metode Pembayaran</label>
                                <input name="fc_paymentmethod" id="fc_paymentmethod_hidden" type="text" hidden>
                                <select name="fc_paymentmethod" id="fc_paymentmethod" class="form-control" required></select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6" id="no_giro" hidden>
                            <div class="form-group required">
                                <label>No. Giro</label>
                                <input name="fc_refno" id="fc_refno" class="form-control">
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6" id="tgl_giro" hidden>
                            <div class="form-group required">
                                <label>Jatuh Tempo</label>
                                <div class="input-group" data-date-format="dd-mm-yyyy">
                                    <input type="text" id="fd_agingref" class="form-control datepicker" name="fd_agingref">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-calendar"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="submit" class="btn btn-primary">Tambahkan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    var fc_balancerelation = "{{ $data->mapping->fc_balancerelation }}";
    var balancerelation_encode = window.btoa(fc_balancerelation);

    var nominalDebit = "{{ $data->fm_debitvalue }}";
    var nominalKredit = "{{ $data->fm_creditvalue }}";
    var nominalBalance = "{{ $data->fm_balance }}";
    var nominalCoa = "{{ $coa->fm_nominal }}";

    $('#debit').html(fungsiRupiahSystem(parseFloat(nominalDebit)));
    $('#kredit').html(fungsiRupiahSystem(parseFloat(nominalKredit)));
    $('#balance').html(fungsiRupiahSystem(parseFloat(nominalBalance)));
    $('#nominal_coa').html(fungsiRupiahSystem(parseFloat(nominalCoa)));

    if(nominalDebit - nominalKredit === 0){
        $('#status_balance').val("true");
        $('#jumlah_balance').val(nominalBalance);
    }else{
        $('#status_balance').val("false");
    }

    $(document).ready(function() {
        get_data_coa();
        get_data_payment();
    })

    function add_opsi() {
        $('#fc_paymentmethod').prop('disabled', false);
        $('#fc_paymentmethod_hidden').empty();
        $('#modal_opsi').modal('show');
    }

    function get_data_coa() {
        $('#modal_loading').modal('show');
        // console.log(fc_coacode);
        $.ajax({
            url: "/master/get-data-where-field-id-get/TransaksiType/fc_trx/SUPPTRXACC",
            type: "GET",
            dataType: "JSON",
            success: function(response) {
                setTimeout(function() {
                    $('#modal_loading').modal('hide');
                }, 500);
                if (response.status === 200) {
                    var data = response.data;
                    // console.log(data);
                    $("#fc_coacode").empty();
                    $("#fc_coacode").append(`<option value="" selected disabled> - Pilih - </option>`);
                    for (var i = 0; i < data.length; i++) {
                        $("#fc_coacode").append(`<option value="${data[i].fc_kode}">${data[i].fv_description}</option>`);
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

    function get_data_payment() {
        $.ajax({
            url: "/master/get-data-where-field-id-get/TransaksiType/fc_trx/PAYMENTACC",
            type: "GET",
            dataType: "JSON",
            success: function(response) {
                if (response.status === 200) {
                    var data = response.data;
                    $("#fc_paymentmethod").empty();
                    $("#fc_paymentmethod").append(`<option value="" selected disabled> - Pilih - </option>`);
                    for (var i = 0; i < data.length; i++) {
                        $("#fc_paymentmethod").append(`<option value="${data[i].fc_kode}">${data[i].fv_description}</option>`);
                    }

                    $("#fc_paymentmethod").change(function() {
                        if ($('#fc_paymentmethod').val() === "GIRO") {
                            $('#no_giro').attr('hidden', false);
                            $('#tgl_giro').attr('hidden', false);
                            $('#fc_refno').attr('required', true);
                            $('#fd_agingref').attr('required', true);
                        } else {
                            $('#no_giro').attr('hidden', true);
                            $('#tgl_giro').attr('hidden', true);
                            $('#fc_refno').attr('required', false);
                            $('#fd_agingref').attr('required', false);
                            $('input[id="fc_refno"]').val("");
                            $('input[id="fd_agingref"]').val("");
                        }
                    });
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

    function get_detail_coa() {
        $('#modal_loading').modal('show');
        var fc_coacode = window.btoa($('#fc_coacode').val());
        // console.log(fc_coacode);
        $.ajax({
            url: "/apps/transaksi/detail/" + fc_coacode,
            type: "GET",
            dataType: "JSON",
            success: function(response) {
                setTimeout(function() {
                    $('#modal_loading').modal('hide');
                }, 500);
                if (response.status === 200) {
                    var data = response.data;
                    // console.log(data);
                    if (data.length) {
                        var value = data[0].mst_coa.fc_directpayment;
                        $("input[name=fc_directpayment][value=" + value + "]").prop('checked', true);
                        if (value == "F") {
                            $('#fc_paymentmethod').append(`<option value="NON" selected>NON DIRECT PAYMENT</option>`);
                            $('#fc_paymentmethod').prop('disabled', true);
                            $('#fc_paymentmethod_hidden').val("NON");
                        }
                        var value2 = data[0].mst_coa.fc_balancestatus;
                        $("input[name=fc_balancestatus][value=" + value2 + "]").prop('checked', true);
                        if (data[0].mst_coa.transaksitype == null) {
                            $('#fc_group').append(`<option value="" selected>-</option>`);
                        }
                        $('#fc_group').append(`<option value="${data[0].mst_coa.fc_group}" selected>${data[0].mst_coa.transaksitype.fv_description}</option>`);
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

    var tb_opsi = $('#tb_opsi').DataTable({
        autoWidth: false,
        processing: true,
        serverSide: true,
        destroy: true,
        pageLength: 5,
        order: [
            [0, 'desc']
        ],
        ajax: {
            url: "/apps/transaksi/datatables-opsi",
            type: 'GET',
        },
        columnDefs: [{
            className: 'text-center',
            targets: [0, 1, 2, 3, 4, 5, 6, 7, 8]
        }, {
            className: 'text-nowrap',
            targets: []
        }],
        columns: [{
                data: 'DT_RowIndex',
                searchable: false,
                orderable: false
            },
            {
                data: 'fc_coacode',
                "width": "20px"
            },
            {
                data: 'coamst.fc_coaname'
            },
            {
                data: null,
                render: function(data, type, full, meta) {
                    return `<input type="text" id="fm_nominal_${data.fn_rownum}" onkeyup="return onkeyupRupiah(this.id);" min="0" class="form-control format-rp" value="${fungsiRupiahSystem(data.fm_nominal)}">`;
                },
                "width": "200px"
            },
            {
                data: 'payment.fv_description',
                defaultContent: '-'
            },
            {
                data: 'fc_refno',
                defaultContent: '-'
            },
            {
                data: 'fd_agingref',
                defaultContent: '-',
            },
            {
                data: null,
                render: function(data, type, full, meta) {
                    if (data.fv_description == null) {
                        return `<input type="text" id="fv_description_${data.fn_rownum}" value="" class="form-control">`;
                    } else {
                        return `<input type="text" id="fv_description_${data.fn_rownum}" value="${data.fv_description}" class="form-control">`;
                    }
                }
            },
            {
                data: null,
            },
        ],

        rowCallback: function(row, data) {
            var url_delete = "/apps/transaksi/delete-opsi/" + data.fc_trxno + "/" + data.fn_rownum;
            var fc_coacode = window.btoa(data.fc_coacode);

            $('td:eq(8)', row).html(`
                <button type="submit" class="btn btn-warning btn-sm mr-1" data-rownum="${data.fn_rownum}" data-nominal="${data.fm_nominal}" data-description="${data.fv_description}" onclick="editDetailTransaksi(this)"><i class="fas fa-edit"> </i></button>
                <button class="btn btn-danger btn-sm" onclick="click_delete('${url_delete}','${data.coamst.fc_coaname}')"><i class="fa fa-trash"> </i></button>
            `);
        },
    });

    function editDetailTransaksi(button) {
        var rownum = $(button).data('rownum');
        var nominal = $(button).data('nominal');
        var description = $(button).data('description');
        var newnominal = $(`#fm_nominal_${rownum}`).val().toString().replace('.', '');
        var newdescription = $(`#fv_description_${rownum}`).val();
        var fc_mappingcode = "{{ $data->fc_mappingcode }}";
        var encode_mappingcode = btoa(fc_mappingcode);

        swal({
            title: "Konfirmasi",
            text: "Apakah kamu yakin ingin update data tersebut?",
            icon: "warning",
            buttons: ["Cancel", "Update"],
            dangerMode: true,
        }).then(function(confirm) {
            if (confirm) {
                updateOpsiTransaksi(rownum, newnominal, newdescription, encode_mappingcode);
            }
        });
    }

    function updateOpsiTransaksi(rownum, nominal, description, encode_mappingcode) {
        $("#modal_loading").modal('show');
        $.ajax({
            url: '/apps/transaksi/update-opsi',
            type: 'PUT',
            data: {
                fn_rownum: rownum,
                fm_nominal: nominal,
                fv_description: description,
                fc_balancerelation: fc_balancerelation,
                fc_mappingcode: encode_mappingcode
            },
            success: function(response) {
                if (response.status == 200) {
                    swal(response.message, {
                        icon: 'success',
                    });
                    $("#modal_loading").modal('hide');
                    window.location.href = window.location.href;
                    tb_opsi.ajax.reload();
                } else {
                    swal(response.message, {
                        icon: 'error',
                    });
                    setTimeout(function() {
                        $('#modal_loading').modal('hide');
                    }, 500);
                }
            },
            error: function(xhr, status, error) {
                $("#modal_loading").modal('hide');
                setTimeout(function() {
                    $('#modal_loading').modal('hide');
                }, 500);
                swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + jqXHR.responseText + ")", {
                    icon: 'error',
                });
            }
        });
    }

    function click_pending() {
        swal({
            title: 'Konfirmasi',
            text: 'Apakah anda yakin akan Pending Transaksi Accounting ini?',
            icon: 'warning',
            buttons: true,
            dangerMode: true,
        }).then((save) => {
            if (save) {
                $("#modal_loading").modal('show');
                $.ajax({
                    url: '/apps/transaksi/pending',
                    type: 'PUT',
                    data: {
                        fv_description: $('#fv_description').val(),
                    },
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
                            $("#modal").modal('hide');
                            location.href = response.link;
                        } else {
                            iziToast.error({
                                title: 'Gagal!',
                                message: response.message,
                                position: 'topRight'
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

    function click_cancel() {
        swal({
                title: 'Konfirmasi',
                text: 'Apakah anda yakin akan cancel Transaksi Accounting?',
                icon: 'warning',
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $("#modal_loading").modal('show');
                    $.ajax({
                        url: '/apps/transaksi/cancel_transaksi',
                        type: "DELETE",
                        dataType: "JSON",
                        success: function(response) {
                            setTimeout(function() {
                                $('#modal_loading').modal('hide');
                            }, 500);
                            if (response.status === 200) {

                                $("#modal").modal('hide');
                                iziToast.success({
                                    title: 'Success!',
                                    message: response.message,
                                    position: 'topRight'
                                });

                                tb.ajax.reload(null, false);
                            } else if (response.status === 201) {
                                $("#modal").modal('hide');
                                iziToast.success({
                                    title: 'Success!',
                                    message: response.message,
                                    position: 'topRight'
                                });
                                // arahkan ke link
                                location.href = response.link;
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

    function click_delete(url, nama) {
        swal({
                title: 'Konfirmasi?',
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
                            //  tb.ajax.reload(null, false);
                            //  console.log(response.status);
                            if (response.status == 200) {
                                swal(response.message, {
                                    icon: 'success',
                                });
                                $("#modal").modal('hide');
                                tb_opsi.ajax.reload(null, false);
                            } else if (response.status == 201) {
                                swal(response.message, {
                                    icon: 'success',
                                });
                                $("#modal").modal('hide');
                                tb_opsi.ajax.reload(null, false);
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
                            swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + jqXHR.responseText + ")", {
                                icon: 'error',
                            });
                        }
                    });
                }
            });
    }

    $('#form_submit_opsi').on('submit', function(e) {
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
                        url: $('#form_submit_opsi').attr('action'),
                        type: $('#form_submit_opsi').attr('method'),
                        data: $('#form_submit_opsi').serialize(),
                        success: function(response) {
                            setTimeout(function() {
                                $('#modal_loading').modal('hide');
                            }, 500);
                            if (response.status == 200) {
                                swal(response.message, {
                                    icon: 'success',
                                });
                                tb_opsi.ajax.reload(null, false);
                                $("#modal_opsi").modal('hide');
                                $("#form_submit_opsi")[0].reset();
                                $('#fc_paymentmethod').val(null).trigger('change');
                                $('#fc_group').val(null).trigger('change');
                                reset_all_select();

                            } else if (response.status == 201) {
                                swal(response.message, {
                                    icon: 'success',
                                });
                                $("#modal").modal('hide');
                                location.href = response.link;
                            } else if (response.status == 203) {
                                swal(response.message, {
                                    icon: 'success',
                                });
                                $("#modal").modal('hide');
                                tb_opsi.ajax.reload(null, false);
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
                }
            });
    });


    $('.modal').css('overflow-y', 'auto');
</script>

@endsection