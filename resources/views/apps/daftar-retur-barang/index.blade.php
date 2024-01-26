@extends('partial.app')
@section('title', 'Daftar Retur Barang')
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
                    <h4>Data Retur Barang</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <form id="exportForm" action="/apps/daftar-retur-barang/export-excel" method="POST" target="_blank">
                            @csrf
                            <div class="button text-right mb-3">
                                <button type="submit" class="btn btn-primary"><i class="fas fa-file-export"></i> Export Excel</button>
                            </div>
                        </form>
                        <table class="table table-striped" id="tb" width="100%">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">No</th>
                                    <th scope="col" class="text-center">No. Retur</th>
                                    <th scope="col" class="text-center">No. Surat Jalan</th>
                                    <th scope="col" class="text-center">Tgl Retur</th>
                                    <th scope="col" class="text-center">Item</th>
                                    <th scope="col" class="text-center">Nominal</th>
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
                <form id="form_submit_pdf" action="/apps/daftar-retur-barang/pdf" method="POST" autocomplete="off">
                    @csrf
                    <input type="text" name="fc_returno" id="fc_returno_input_ttd" hidden>
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
        function click_modal_nama(fc_returno) {
            // console.log(fc_dono);
            $('#fc_returno_input_ttd').val(fc_returno);
            $('#modal_nama').modal('show');
        };
        var tb = $('#tb').DataTable({
            processing: true,
            serverSide: true,
            destroy: true,
            pageLength: 5,
            order: [
                [1, 'desc']
            ],
            ajax: {
                url: "/apps/daftar-retur-barang/datatables",
                type: 'GET',
            },
            columnDefs: [{
                className: 'text-center',
                targets: [0, 2, 3, 4, 5, 6]
            }, {
                className: 'text-nowrap',
                targets: [6]
            }],
            columns: [{
                    data: 'DT_RowIndex',
                    searchable: false,
                    orderable: false
                },
                {
                    data: 'fc_returno'
                },
                {
                    data: 'fc_dono'
                },
                {
                    data: 'fd_returdate',
                    render: formatTimestamp
                },
                {
                    data: 'fn_returdetail'
                },
                {
                    data: 'fm_brutto',
                    render: $.fn.dataTable.render.number(',', '.', 0, 'Rp')
                },
                {
                    data: null,
                },
            ],

            rowCallback: function(row, data) {
                var fc_returno = window.btoa(data.fc_returno);

                // $('td:eq(7)', row).html(`<i class="${data.fc_status}"></i>`);
                // if (data['fc_status'] == 'R') {
                //     $('td:eq(7)', row).html('<span class="badge badge-primary">Terbit</span>');
                // } else if (data['fc_status'] == 'C') {
                //     $('td:eq(7)', row).html('<span class="badge badge-success">Tuntas</span>');
                // }

                $('td:eq(6)', row).html(`
                    <a href="/apps/daftar-retur-barang/detail/${fc_returno}"><button class="btn btn-primary btn-sm mr-1"><i class="fa fa-eye"></i> Detail</button></a>
                    <button class="btn btn-warning btn-sm mr-1" onclick="click_modal_nama('${data.fc_returno}')"><i class="fa fa-file"></i> PDF</button>
                `);
            },
        });
    </script>
    @endsection