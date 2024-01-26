@extends('partial.app')
@section('title', 'Kas Bon')
@section('css')
    <style>
        .required label:after {
            color: #e32;
            content: ' *';
            display: inline;
        }
    </style>
@endsection
@section('content')
    {{-- @dd($data) --}}
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Daftar Kas Bon</h4>
                        <div class="card-header-action">
                            <button type="button" class="btn btn-success" onclick="add();">
                                <i class="fa fa-plus mr-1"></i> Tambah Kas Bon
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="tb" width="100%">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-center">No</th>
                                        <th scope="col" class="text-center">Pemohon</th>
                                        <th scope="col" class="text-center">Tanggal</th>
                                        <th scope="col" class="text-center">Keterangan</th>
                                        <th scope="col" class="text-center">Nominal</th>
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
    </div>
@endsection

@section('modal')
    <div class="modal fade" role="dialog" id="modal_create" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header br">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form_submit" action="/apps/kas-bon/store" method="POST" autocomplete="off">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12 col-md-12 col-lg-12">
                                <div class="form-group required">
                                    <label>Nama</label>
                                    <input type="text" class="form-control required-field" name="fc_userapplicant"
                                        required />
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group required">
                                    <label>Tanggal</label>
                                    <input type="date" class="form-control required-field" name="fd_kasbondate"
                                        required />
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group required">
                                    <label>Nominal</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                Rp.
                                            </div>
                                        </div>
                                        <input type="text" class="form-control" id="fm_nominal" name="fm_nominal"
                                            onkeyup="return onkeyupRupiah(this.id);" required />
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-12">
                                <div class="form-group required">
                                    <label>Keterangan</label>
                                    <textarea class="form-control required-filed" name="fv_description" style="height: 90px"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-whitesmoke br">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        function add() {
            $("#modal_create").modal('show');
            $(".modal-title").text('Tambah Kas Bon');
            $("#form_submit")[0].reset();
        }

        $("#form_submit").on("submit", function() {
            $("#modal_create").modal('hide');
        });

        var tb = $('#tb').DataTable({
            processing: true,
            serverSide: true,
            pageLength: 5,
            ajax: {
                url: '/apps/kas-bon/datatables',
                type: 'GET'
            },
            columnDefs: [{
                    className: 'text-center',
                    targets: [0, 1, 2, 4, 5, 6]
                },
                {
                    "width": "15%",
                    targets: [4]
                }
            ],
            columns: [{
                    data: 'fc_kasbonno',
                },
                {
                    data: 'fc_userapplicant'
                },
                {
                    data: 'fd_kasbondate',
                    render: function(data, type, row) {
                        return moment(data).format(
                            // format tanggal
                            'DD/MM/YYYY'
                        );
                    }
                },
                {
                    data: 'fv_description'
                },
                {
                    data: 'fm_nominal',
                    // render: $.fn.dataTable.render.number(',', '.', 0, 'Rp ')
                    render: function(data, type, row) {
                        return row.fm_nominal.toLocaleString('id-ID', {
                            style: 'currency',
                            currency: 'IDR'
                        })
                    }
                },
                {
                    data: 'fc_status'
                },
                {
                    data: null
                },
            ],
            rowCallback: function(row, data) {
                if (data['fc_status'] == 'J') {
                    $('td:eq(5)', row).html('<span class="badge badge-success">Journal</span>');
                } else if (data['fc_status'] == 'CC') {
                    $('td:eq(5)', row).html('<span class="badge badge-danger">Cancel</span>');
                } else {
                    $('td:eq(5)', row).html('<span class="badge badge-primary">Process</span>');
                }

                var kasbonno = window.btoa(data.fc_kasbonno);
                var url_update = "/apps/kas-bon/update/" + kasbonno;

                data['fc_status'] == 'F' ?
                    $('td:eq(6)', row).html(
                        `
                            <button class="btn btn-danger btn-sm mr-1" onclick="update('${url_update}', 'CC', 'Anda yakin ingin mencancel?')"><i class="fa fa-close"></i> Batal</button>
                            <button class="btn btn-success btn-sm" onclick="update('${url_update}', 'J', 'Anda yakin ingin menjurnal?')"><i class="fa fa-book-open"> </i> Jurnal</button>
                        `
                    ) :
                    $('td:eq(6)', row).html(
                        `
                            <strong><i>No Action Necessary</i></strong>
                        `
                    )
            }


        });

        function update(url, data, message) {
            swal({
                title: "Konfirmasi",
                text: message,
                type: "warning",
                icon: 'warning',
                buttons: true,
                dangerMode: true,
            }).then((save) => {
                if (save) {
                    $("#modal_loading").modal('show');
                    $.ajax({
                        url: url,
                        data: {
                            fc_status: data,
                        },
                        type: 'PUT',
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
