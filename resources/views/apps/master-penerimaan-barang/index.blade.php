@extends('partial.app')
@section('title', 'Daftar Transit Barang')
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

    .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active {
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
                    <h4>Data Transit Barang</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="tb" width="100%">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">No</th>
                                    <th scope="col" class="text-center">GR NO</th>
                                    <th scope="col" class="text-center">Supplier</th>
                                    <th scope="col" class="text-center">Tgl Penerimaan</th>
                                    <th scope="col" class="text-center">Jumlah</th>
                                    <th scope="col" class="text-center">Satuan</th>
                                    <th scope="col" class="text-center">Penerima</th>
                                    <th scope="col" class="text-center">Status</th>
                                    <th scope="col" class="text-center" style="width: 20%">Actions</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection

    @section('modal')
    <div class="modal fade" role="dialog" id="modal_nama" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header br">
                    <h5 class="modal-title">Pilih Penanda Tangan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form_submit_pdf" action="/apps/master-penerimaan-barang/pdf" method="POST" autocomplete="off">
                    @csrf
                    <input type="text" name="fc_grno" id="fc_grno_input_ttd" hidden>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12 col-md-12 col-lg-12">
                                <div class="form-group form_group_ttd">
                                    <label class="d-block">Nama</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="name_user" id="name_user" checked="">
                                        <label class="form-check-label" for="name_user">
                                            {{ auth()->user()->fc_username }}
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="name_user_lainnya" id="name_user_lainnya">
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
    @endsection

    @section('js')
    <script>
        $(document).ready(function() {
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
        });


        // untuk memunculkan nama penanggung jawab
        function click_modal_nama(fc_grno) {
            // console.log(fc_dono);
            $('#fc_grno_input_ttd').val(fc_grno);
            $('#modal_nama').modal('show');
        };
        var tb = $('#tb').DataTable({
            processing: true,
            serverSide: true,
            destroy: true,
            pageLength : 5,
            order: [
                [1, 'desc']
            ],
            ajax: {
                url: "/apps/master-penerimaan-barang/datatables/master-transit",
                type: 'GET',
            },
            columnDefs: [{
                className: 'text-center',
                targets: [0, 2, 3, 4, 5, 6, 7]
            }, {
                className: 'text-nowrap',
                targets: [8]
            }],
            columns: [{
                    data: 'DT_RowIndex',
                    searchable: false,
                    orderable: false
                },
                {
                    data: 'fc_grno'
                },
                {
                    data: 'supplier.fc_suppliername1'
                },
                {
                    data: 'fd_arrivaldate',
                    render: formatTimestamp
                },
                {
                    data: 'fn_qtyitem'
                },
                {
                    data: 'fc_unit',
                },
                {
                    data: 'fc_recipient'
                },
                {
                    data: 'fc_status',
                },
                {
                    data: null,
                },
            ],

            rowCallback: function(row, data) {
                var fc_grno = window.btoa(data.fc_grno);
                var count = window.btoa(data.fn_qtyitem);

                $('td:eq(7)', row).html(`<i class="${data.fc_status}"></i>`);
                    if (data['fc_status'] == 'R') {
                        $('td:eq(7)', row).html('<span class="badge badge-primary">Terbit</span>');
                    } else if (data['fc_status'] == 'C') {
                        $('td:eq(7)', row).html('<span class="badge badge-success">Tuntas</span>');
                    }
                
                if (data['fc_status'] == 'C'){
                    $('td:eq(8)', row).html(`
                    <button class="btn btn-warning btn-sm mr-1" onclick="click_modal_nama('${data.fc_grno}')"><i class="fa fa-file"></i> PDF</button>
                    <a href="/apps/master-penerimaan-barang/doc/${fc_grno}/${count}" target="_blank" class="btn btn-primary btn-sm"><i class="fa fa-print"></i> Plakat</a>
                    `);
                } else {
                    $('td:eq(8)', row).html(`
                    <button class="btn btn-warning btn-sm mr-1" onclick="click_modal_nama('${data.fc_grno}')"><i class="fa fa-file"></i> PDF</button>
                    <a href="/apps/master-penerimaan-barang/doc/${fc_grno}/${count}" target="_blank" class="btn btn-primary btn-sm"><i class="fa fa-print"></i> Plakat</a>
                    <button class="btn btn-info btn-sm ml-1" onclick="tuntaskan_gr('${data.fc_grno}')"><i class="fa fa-check"></i> Tuntaskan</button>
                    `);
                }
                // <a href="/apps/master-receiving-order/pdf/${fc_rono}" target="_blank"><button class="btn btn-warning btn-sm mr-1"><i class="fa fa-eye"></i> Detail</button></a>
                // BUTTON PDF LAMA
                // <button class="btn btn-warning btn-sm mr-1" onclick="click_modal_nama('${data.fc_grno}')"><i class="fa fa-file"></i> PDF</button>
            },
        });
        

        function tuntaskan_gr(fc_grno) {
            swal({
                title: "Konfirmasi",
                text: "Anda yakin ingin menuntaskan penerimaan barang ini?",
                type: "warning",
                icon: 'warning',
                buttons: true,
                dangerMode: true,
            }).then((save) => {
                if (save) {
                    $("#modal_loading").modal('show');
                    $.ajax({
                        url: '/apps/master-penerimaan-barang/clear',
                        type: 'PUT',
                        data: {
                            fc_status: 'C',
                            fc_grno: fc_grno
                        },
                        success: function(response) {
                            setTimeout(function() {
                                $('#modal_loading').modal('hide');
                            }, 500);
                            if (response.status == 200) {
                                swal(response.message, {
                                    icon: 'success',
                                });
                                $("#modal").modal('hide');
                                tb.ajax.reload();
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

    </script>
    @endsection