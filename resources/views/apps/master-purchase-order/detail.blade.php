@extends('partial.app')
@section('title', 'Detail Purchase Order')
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
                            <a data-collapse="#mycard-collapse" class="btn btn-icon btn-info" href="#"><i
                                    class="fas fa-minus"></i></a>
                        </div>
                    </div>
                    <div class="collapse show" id="mycard-collapse">
                        <input type="text" id="fc_branch" value="{{ auth()->user()->fc_branch }}" hidden>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label>No. PO : {{ $po_master->fc_pono }}
                                        </label>
                                    </div>
                                </div>
                                <div class="col-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label>Order : {{ date('d-m-Y', strtotime($po_master->fd_podateinputuser)) }}
                                        </label>
                                    </div>
                                </div>
                                <div class="col-12 col-md-12 col-lg-6" style="white-space: nowrap;">
                                    <div class="form-group">
                                        <label>Expired : {{ date('d-m-Y', strtotime($po_master->fd_poexpired)) }}
                                        </label>
                                    </div>
                                </div>
                                <div class="col-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label>Operator</label>
                                        <input type="text" class="form-control" value="{{ auth()->user()->fc_username }}"
                                            readonly>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label>PO Type</label>
                                        <input type="text" class="form-control" value="{{ $po_master->fc_potype }}"
                                            readonly>
                                    </div>
                                </div>
                                <div class="col-12 col-md-12 col-lg-12 text-right">
                                    <form id="form_cancel" action="/apps/master-purchase-order/cancel_po" method="PUT">
                                        @csrf
                                        <input type="hidden" name="fc_pono" value="{{ $po_master->fc_pono }}">
                                        @if (
                                            $po_master->fc_postatus == 'CL' ||
                                                $po_master->fc_postatus == 'C' ||
                                                $po_master->fc_postatus == 'CC' ||
                                                $po_master->fc_postatus == 'S')
                                            <button type="submit" class="btn btn-danger" hidden>Cancel PO</button>
                                        @else
                                            <button type="submit" class="btn btn-danger">Cancel PO</button>
                                        @endif
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-8 col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h4>Detail Supplier</h4>
                        <div class="card-header-action">
                            <a data-collapse="#mycard-collapse2" class="btn btn-icon btn-info" href="#"><i
                                    class="fas fa-minus"></i></a>
                        </div>
                    </div>
                    <div class="collapse show" id="mycard-collapse2">
                        <div class="card-body" style="height: 303px">
                            <div class="row">
                                <div class="col-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label>NPWP</label>
                                        <input type="text" class="form-control"
                                            value="{{ $po_master->supplier->fc_supplierNPWP }}" readonly>
                                    </div>
                                </div>
                                <div class="col-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label>Tipe Cabang</label>
                                        <input type="text" class="form-control"
                                            value="{{ $po_master->supplier->supplier_typebranch->fv_description }}"
                                            readonly>
                                    </div>
                                </div>
                                <div class="col-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label>Tipe Bisnis</label>
                                        <input type="text" class="form-control"
                                            value="{{ $po_master->supplier->supplier_type_business->fv_description }}"
                                            readonly>
                                    </div>
                                </div>
                                <div class="col-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label>Nama</label>
                                        <input type="text" class="form-control"
                                            value="{{ $po_master->supplier->fc_suppliername1 }}" readonly>
                                    </div>
                                </div>
                                <div class="col-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label>Telepon</label>
                                        <input type="text" class="form-control"
                                            value="{{ $po_master->supplier->fc_supplierphone1 }}" readonly>
                                    </div>
                                </div>
                                <div class="col-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label>Legal Status</label>
                                        <input type="text" class="form-control"
                                            value="{{ $po_master->supplier->supplier_legal_status->fv_description }}"
                                            readonly>
                                    </div>
                                </div>
                                <div class="col-4 col-md-4 col-lg-12">
                                    <div class="form-group">
                                        <label>Alamat</label>
                                        <input type="text" class="form-control"
                                            value="{{ $po_master->supplier->fc_supplier_npwpaddress1 }}" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Catatan</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-12 col-lg-12">
                                <textarea class="form-control" style="height: 70px;" readonly>{{ $po_master->fv_description ?? '-' }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- TABLE --}}
            <div class="col-12 col-md-12 col-lg-12 place_detail">
                <div class="card">
                    <div class="card-header">
                        <h4>Item Purchase Order</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="table-responsive">
                                <table class="table table-striped" id="po_detail" width="100%">
                                    <thead style="white-space: nowrap">
                                        <tr>
                                            <th scope="col" class="text-center">No</th>
                                            <th scope="col" class="text-center">Kode</th>
                                            <th scope="col" class="text-center">Nama Produk</th>
                                            <th scope="col" class="text-center">Unity</th>
                                            <th scope="col" class="text-center">Qty</th>
                                            <th scope="col" class="text-center">BPB</th>
                                            <th scope="col" class="text-center">Sisa</th>
                                            <th scope="col" class="text-center">Bonus</th>
                                            <th scope="col" class="text-center">Kedatangan</th>
                                            <th scope="col" class="text-center">Status</th>
                                            <th scope="col" class="text-center">Catatan</th>
                                            <th scope="col" class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- TABLE RO --}}
            <div class="col-12 col-md-12 col-lg-12 place_detail">
                <div class="card">
                    <div class="card-header">
                        <h4>BPB</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="table-responsive">
                                <table class="table table-striped" id="tb_ro" width="100%">
                                    <thead style="white-space: nowrap">
                                        <tr>
                                            <th scope="col" class="text-center">No.</th>
                                            <th scope="col" class="text-center">No. BPB</th>
                                            <th scope="col" class="text-center">Tgl BPB</th>
                                            <th scope="col" class="text-center">Item</th>
                                            <th scope="col" class="text-center">Status</th>
                                            <th scope="col" class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-right mb-4">
            <a href="/apps/master-purchase-order"><button type="button" class="btn btn-info">Back</button></a>
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
                <form id="form_submit_edit" action="/apps/master-receiving-order/pdf" method="POST" autocomplete="off">
                    @csrf
                    <input type="text" name="fc_rono" id="fc_rono_input_ttd" hidden>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12 col-md-12 col-lg-12">
                                <div class="form-group form_group_ttd">
                                    <label class="d-block">Nama</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="name_user" id="name_user"
                                            checked="">
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
                        <button type="submit" class="btn btn-success btn-submit">Konfirmasi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" role="dialog" id="modal_kedatangan" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header br">
                    <h5 class="modal-title">Ubah Kedatangan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form_edit" action="/apps/master-purchase-order/edit/kedatangan/{{ base64_encode($po_master->fc_pono) }}" method="POST" autocomplete="on">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label>Kedatangan</label>
                                    <div class="input-group" data-date-format="dd-mm-yyyy">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-calendar"></i>
                                            </div>
                                        </div>
                                        <input type="text" id="fd_stockarrived" class="form-control datepicker" name="fd_stockarrived">
                                        <input type="hidden" id="fn_porownum" name="fn_porownum">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-whitesmoke br">
                        <button type="submit" class="btn btn-success btn-submit">Konfirmasi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        // untuk form input nama penanggung jawab
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

        function click_modal_nama(fc_rono) {
            $('#fc_rono_input_ttd').val(fc_rono);
            $('#modal_nama').modal('show');
        };

        // function modal_kedatangan(fc_rono) {
        //     $('#modal_kedatangan').modal('show');
        // };
        function modal_kedatangan(button) {
            var id = $(button).data('rownum');
            var fcPono = $(button).data('pono');
            $('#fn_porownum').val(id);
            $('#fc_pono').val(fcPono);
            $('#modal_kedatangan').modal('show');
        }

        let encode_fc_pono = "{{ base64_encode($po_master->fc_pono) }}";
        // console.log(encode_fc_pono)
        var tb = $('#po_detail').DataTable({
            // apabila data kosong
            processing: true,
            serverSide: true,
            destroy: true,
            ajax: {
                url: "/apps/master-purchase-order/datatables/po_detail/" + encode_fc_pono,
                type: 'GET',
            },
            columnDefs: [{
                className: 'text-center',
                targets: [0, 3, 4, 5, 6, 7, 8, 9]
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
                    data: 'stock.fc_namelong'
                },
                {
                    data: 'namepack.fv_description'
                },
                {
                    data: 'fn_po_qty'
                },
                {
                    data: 'fn_ro_qty'
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        return row.fn_po_qty - row.fn_ro_qty;
                    }
                },
                {
                    data: 'fn_po_bonusqty'
                },
                {
                    //FIELD KEDATANGAN
                    data: 'fd_stockarrived',
                },
                {
                    data: 'fc_status'
                },
                {
                    data: 'fv_description',
                    defaultContent: '-',
                },
                {
                    data: null,
                    defaultContent: 'this is button',
                },
            ],
            rowCallback: function(row, data) {
                $('td:eq(9)', row).html(`<i class="${data.fc_status}"></i>`);
                if (data['fc_status'] == 'W') {
                    $('td:eq(9)', row).html(
                        '<h6><span class="badge badge-primary"><i class="fa fa-hourglass"></i> Menunggu</span></h6>'
                    );
                } else if (data['fc_status'] == 'P') {
                    $('td:eq(9)', row).html(
                        '<h6><span class="badge badge-warning"><i class="fa fa-spinner"></i> Pending</span></h6>'
                    );
                } else {
                    $('td:eq(9)', row).html(
                        '<h6><span class="badge badge-success"><i class="fa fa-check"></i> Selesai</span></h6>'
                    );
                }

                //BUTTON UBAH KEDATANGAN
                $('td:eq(11)', row).html(`
                    <button class="btn btn-warning btn-sm" onclick="modal_kedatangan(this)" data-rownum="${data.fn_porownum}" data-pono="${data.fc_pono}"><i class="fa fa-pen"></i> Ubah</button>
                `);
            }
        });

        var tb_ro = $('#tb_ro').DataTable({
            // apabila data kosong
            processing: true,
            serverSide: true,
            destroy: true,
            ajax: {
                url: "/apps/receiving-order/datatables/ro/" + encode_fc_pono,
                type: 'GET',
            },
            columnDefs: [{
                className: 'text-center',
                targets: [0, 1, 2, 3, 4, 5]
            }, ],
            columns: [{
                    data: 'DT_RowIndex',
                    searchable: false,
                    orderable: false
                },
                {
                    data: 'fc_rono',
                },
                {
                    data: 'fd_roarivaldate',
                    render: formatTimestamp
                },
                {
                    data: 'pomst.fn_podetail'
                },
                {
                    data: 'fc_rostatus'
                },
                {
                    data: null,
                },
            ],
            rowCallback: function(row, data) {
                var fc_rono = window.btoa(data.fc_rono);
                $('td:eq(4)', row).html(`<i class="${data.fc_rostatus}"></i>`);
                if (data['fc_rostatus'] == 'P') {
                    $('td:eq(4)', row).html('<span class="badge badge-primary">Terbayar</span>');
                } else {
                    $('td:eq(4)', row).html('<span class="badge badge-success">Diterima</span>');
                }

                $('td:eq(5)', row).html(`
            <button class="btn btn-warning btn-sm" onclick="click_modal_nama('${data.fc_rono}')"><i class="fa fa-eye"></i> Detail</button>
            `);
            },
        });

        $('#form_edit').on('submit', function(e) {
            e.preventDefault();

            var form_id = $(this).attr("id");
            var formData = new FormData($('#form_edit')[0]);
            // Menambahkan data tambahan jika diperlukan
            var imageInput = $('#customFile')[0];
            if (imageInput && imageInput.files.length > 0) {
                formData.append('image_file', imageInput.files[0]);
            }
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
                        url: $('#form_edit').attr('action'),
                        type: $('#form_edit').attr('method'),
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            setTimeout(function() {
                                $('#modal_loading').modal('hide');
                            }, 500);
                            if (response.status == 200) {
                                swal(response.message, {
                                icon: 'success',ﬁ
                                });
                                $("#modal_edit").modal('hide');
                                $("#form_edit")[0].reset();
                                reset_all_select();
                                tb.ajax.reload(null, false);
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
                            var errorMessage = "Mohon maaf masih ada data yang tidak sesuai";

                            // Khusus jika error di transaksi apabila coacode null
                            var responseObj = JSON.parse(jqXHR.responseText);
                            if (responseObj.message.includes("SQLSTATE[23000]: Integrity constraint violation")) {
                                var startIndex = responseObj.message.indexOf("SQLSTATE[23000]: Integrity constraint violation");
                                var endIndex = responseObj.message.indexOf("(SQL:");
                                // potong string yang sesuai dengan pesan dari object respon
                                var specificErrorMessage = responseObj.message.substring(startIndex, endIndex).trim();
                                if (specificErrorMessage == "SQLSTATE[23000]: Integrity constraint violation: 1048 Column 'fc_coacode' cannot be null") {
                                swal(errorMessage, {
                                    icon: 'error',
                                });
                                } else {
                                swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + jqXHR.responseText + ")", {
                                    icon: 'error',
                                });
                                }
                            } else {
                                swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + jqXHR.responseText + ")", {
                                icon: 'error',
                                });
                            }

                        }
                    });
                    }
                });
        });
    </script>
@endsection
