@extends('partial.app')
@section('title','Chart Of Account')
@section('css')
<style>
    #tb_wrapper .row:nth-child(2) {
        overflow-x: auto;
    }

    .required label:after {
        color: #e32;
        content: ' *';
        display: inline;
    }

    .required-select #label-select:after {
        color: #e32;
        content: ' *';
        display: inline;
    }
</style>
@endsection
@section('content')

<div class="section-body">
    <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4>Data COA</h4>
                    <div class="card-header-action">
                        <button type="button" class="btn btn-warning" onclick=""><i class="fas fa-file-export mr-1"></i> Export Excel</button>
                        <button type="button" class="btn btn-success" onclick="add();"><i class="fa fa-plus"></i> Tambah Data COA</button>
                    </div>
                </div>
                <div class="card-body">
                    <div id="accordion0">
                        {!! $formattedData !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('modal')
<!-- Modal -->
<div class="modal fade" role="dialog" id="modal" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header br">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <input type="text" class="form-control" name="fc_branch_view" id="fc_branch_view" value="{{ auth()->user()->fc_branch}}" readonly hidden>
            <form id="form_submit" action="/apps/master-coa/store-update" method="POST" autocomplete="off">
                <input type="text" name="type" id="type" hidden>
                <input type="text" name="fc_parentcode" id="fc_parentcode_hidden" hidden>
                <input type="text" name="fc_group" id="fc_group_hidden" hidden>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 col-md-3 col-lg-3" hidden>
                            <div class="form-group">
                                <label>Divisi</label>
                                <input type="text" class="form-control" name="fc_divisioncode" id="fc_divisioncode" value="{{ auth()->user()->fc_divisioncode }}" readonly>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="form-group required">
                                <label>Cabang</label>
                                <select type="text" class="form-control" name="fc_branch" id="fc_branch"></select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="form-group required">
                                <label>Layer</label>
                                <input type="number" min="0" class="form-control required-field" onchange="get_parent()" name="fn_layer" id="fn_layer">
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="form-group required">
                                <label>COA Induk</label>
                                <select name="fc_parentcode" id="fc_parentcode" class="select2 required-field"></select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-3">
                            <div class="form-group required">
                                <label>Kode COA</label>
                                <input type="text" class="form-control required-field" name="fc_coacode" id="fc_coacode">
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-9">
                            <div class="form-group required">
                                <label>Nama COA</label>
                                <input type="text" class="form-control required-field" name="fc_coaname" id="fc_coaname">
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="form-group required-select">
                                <label id="label-select">Direct Payment</label>
                                <div class="selectgroup w-100">
                                    <label class="selectgroup-item" style="margin: 0!important">
                                        <input type="radio" name="fc_directpayment" id="fc_directpayment" value="T" class="selectgroup-input">
                                        <span class="selectgroup-button">YA</span>
                                    </label>
                                    <label class="selectgroup-item" style="margin: 0!important">
                                        <input type="radio" name="fc_directpayment" id="fc_directpayment" value="F" class="selectgroup-input" checked="">
                                        <span class="selectgroup-button">TIDAK</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="form-group required-select">
                                <label id="label-select">Status Neraca</label>
                                <div class="selectgroup w-100">
                                    <label class="selectgroup-item" style="margin: 0!important">
                                        <input type="radio" name="fc_balancestatus" id="fc_balancestatus" value="C" class="selectgroup-input">
                                        <span class="selectgroup-button">KREDIT</span>
                                    </label>
                                    <label class="selectgroup-item" style="margin: 0!important">
                                        <input type="radio" name="fc_balancestatus" id="fc_balancestatus" value="D" class="selectgroup-input" checked="">
                                        <span class="selectgroup-button">DEBIT</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="form-group required">
                                <label>Group</label>
                                <select name="fc_group" id="fc_group" class="select2 required-field"></select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-12">
                            <div class="form-group">
                                <label>Catatan</label>
                                <input type="text" class="form-control" name="fv_description" id="fv_description">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        get_data_branch();
        get_data_grup()
    })

    function add() {
        $("#modal").modal('show');
        $(".modal-title").text('Tambah Data COA');
        $("#form_submit")[0].reset();
        $('#fc_parentcode').empty();
        $('#fc_parentcode_hidden').empty();
        $('#fc_coacode').prop('readonly', false);
        $('#fn_layer').prop('readonly', true);
        $('#fn_layer').val(0);
        $('#fc_parentcode').append(`<option value="0" selected>COA INDUK</option>`)
        $('#fc_parentcode').prop('disabled', true);
        $('#fc_parentcode').val(0);
        $('#fc_parentcode_hidden').val(0);
    }

    function add_child(fn_layer,fc_coacode,fc_coaname) {
        $("#modal").modal('show');
        $(".modal-title").text('Tambah Data Child COA');
        $("#form_submit")[0].reset();
        $('#fc_parentcode').empty();
        $('#fc_parentcode_hidden').empty();
        $('#fn_layer').val(fn_layer);
        const coaIndukOption = $('<option>', {
            value: fc_coacode,
            text: fc_coaname
        });
        $('#fc_parentcode').prop('disabled', false);
        $('#fc_parentcode').val(fc_coaname);
        $('#fc_parentcode').append(coaIndukOption);
        $('#fc_coacode').prop('readonly', false);
        $('#fc_coaname').prop('readonly', false);
        $('#fn_layer').prop('readonly', true);
    }

    function edit(fc_coacode) {
        $("#modal").modal('show');
        $(".modal-title").text('Update Data COA');
        $("#type").val('update');
        get_detail(fc_coacode);
    }

    function get_data_grup() {
        $.ajax({
            url: "/master/get-data-where-field-id-get/TransaksiType/fc_trx/JOURNALGRP",
            type: "GET",
            dataType: "JSON",
            success: function(response) {
                if (response.status === 200) {
                    var data = response.data;
                    $("#fc_group").empty();
                    $("#fc_group").append(`<option value="" selected disabled> - Pilih - </option>`);
                    for (var i = 0; i < data.length; i++) {
                        $("#fc_group").append(`<option value="${data[i].fc_kode}">${data[i].fv_description}</option>`);
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

    function get_detail(fc_coacode) {
        $('#modal_loading').modal('show');
        var coacode = window.btoa(fc_coacode);

        $.ajax({
            url: "/apps/master-coa/detail/" + coacode,
            type: 'GET',
            dataType: 'JSON',
            success: function(response) {
                var data = response.data;
                setTimeout(function() {
                    $('#modal_loading').modal('hide');
                }, 500);

                if (response.status == 200) {
                    var value = data.fc_directpayment;
                    $("input[name=fc_directpayment][value=" + value + "]").prop('checked', true);
                    var value2 = data. fc_balancestatus;
                    $("input[name= fc_balancestatus][value=" + value2 + "]").prop('checked', true);
                    $('#fc_coacode').val(data.fc_coacode);
                    $('#fc_coacode').prop('readonly', true);
                    $('#fc_coaname').val(data.fc_coaname);
                    $('#fn_layer').val(data.fn_layer);
                    $('#fn_layer').prop('readonly', true);
                    // $('#fc_directpayment').val(data.fc_directpayment).prop('checked', true);

                    if (data.fc_parentcode == 0) {
                        $('#fc_parentcode').append(`<option value="0" selected>COA INDUK</option>`)
                        $('#fc_parentcode').prop('disabled', true);
                        $('#fc_parentcode_hidden').val(0);
                    } else {
                        $('#fc_parentcode').append(`<option value="${data.parent.fc_coacode}" selected>${data.parent.fc_coaname}</option>`);
                        $('#fc_parentcode').prop('disabled', true);
                        $('#fc_parentcode_hidden').val(data.parent.fc_coacode);
                    }
                    if(data.transaksitype != null){
                        $('#fc_group').append(`<option value="${data.fc_group}" selected>${data.transaksitype.fv_description}</option>`);
                        $('#fc_group').prop('disabled', true);
                        $('#fc_group_hidden').val(data.fc_group);
                    }
                    $('#fv_description').val(data.fv_description);
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

    function get_parent() {
        $('#modal_loading').modal('show');
        var fn_layer = window.btoa($('#fn_layer').val());
        $.ajax({
            url: "/apps/master-coa/" + fn_layer,
            type: 'GET',
            dataType: 'JSON',
            success: function(response) {
                var data = response.data;
                setTimeout(function() {
                    $('#modal_loading').modal('hide');
                }, 500);
                if (response.status == 200) {
                    $("#fc_parentcode").empty();
                    $('#fc_parentcode').prop('disabled', false);
                    if ($('#fn_layer').val() == 0) {
                        $('#fc_parentcode').append(`<option value="0" selected>COA INDUK</option>`);
                        $('#fc_parentcode').prop('disabled', true);
                        $('#fc_parentcode').val(0);
                        $('#fc_parentcode_hidden').val(0);
                    } else {
                        $("#fc_parentcode").append(`<option selected disabled>- Pilih -</option>`);
                        for (var i = 0; i < data.length; i++) {
                            $("#fc_parentcode").append(`<option value="${data[i].fc_coacode}">${data[i].fc_coaname}</option>`);
                        }
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
                setTimeout(function() {
                    $('#modal_loading').modal('hide');
                }, 500);
                swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + errorThrown + ")", {
                    icon: 'error',
                });
            }
        })
    }

    function get_data_branch() {
        $("#modal_loading").modal('show');
        $.ajax({
            url: "/master/get-data-where-field-id-get/TransaksiType/fc_trx/BRANCH",
            type: "GET",
            dataType: "JSON",
            success: function(response) {
                setTimeout(function() {
                    $('#modal_loading').modal('hide');
                }, 500);
                if (response.status === 200) {
                    var data = response.data;
                    $("#fc_branch").empty();
                    for (var i = 0; i < data.length; i++) {
                        if (data[i].fc_kode == $('#fc_branch_view').val()) {
                            $("#fc_branch").append(`<option value="${data[i].fc_kode}" selected>${data[i].fv_description}</option>`);
                            $("#fc_branch").prop("disabled", true);
                        } else {
                            $("#fc_branch").append(`<option value="${data[i].fc_kode}">${data[i].fv_description}</option>`);
                        }
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
                setTimeout(function() {
                    $('#modal_loading').modal('hide');
                }, 500);
                swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + errorThrown + ")", {
                    icon: 'error',
                });
            }
        });
    }


    function click_delete(url, nama) {
        swal({
                title: 'Warning!',
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

    $('.modal').css('overflow-y', 'auto');
</script>
@endsection