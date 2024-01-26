@extends('partial.app')
@section('title','Details Sales Customer')
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

    .modal {
        overflow-y: auto;
    }
</style>
@endsection
@section('content')

<div class="section-body">
    <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{$data->fc_salesname1 ?? $nama}}</h4>
                    <div class="card-header-action">
                        <button type="button" class="btn btn-success" onclick="add();"><i class="fa fa-plus mr-1"></i> Tambah Customer</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="tb" width="100%">
                            <thead style="white-space: nowrap">
                                <tr>
                                    <th scope="col" class="text-center">No</th>
                                    <th scope="col" class="text-center">Nama Customer</th>
                                    <th scope="col" class="text-center">Alamat</th>
                                    <th scope="col" class="text-center">Type Bisnis</th>
                                    <th scope="col" class="text-center">Status Cabang</th>
                                    <th scope="col" class="text-center">Active</th>
                                    <th scope="col" class="text-center">Actions</th>
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

<!-- Modal -->
<div class="modal fade" role="dialog" id="modal_edit" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-xs" role="document">
        <div class="modal-content">
            <div class="modal-header br">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- <input type="text" class="form-control" name="fc_branch_view" id="fc_branch_view" value="{{ auth()->user()->fc_branch}}" readonly hidden> -->
            <form id="form_submit_edit" action="/data-master/sales-customer/create-customer/{{ $data->fc_salescode }}" method="POST" autocomplete="off">
                <input type="text" name="type" id="type" hidden>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-12" hidden>
                            <div class="form-group">
                                <label>Division Code</label>
                                <input type="text" class="form-control required-field" name="fc_divisioncode" value="{{ $data->fc_divisioncode }}" id="fc_divisioncode" readonly>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                <label>Sales Code</label>
                                <input type="text" class="form-control required-field" name="fc_salescode" value="{{ $data->fc_salescode }}" id="fc_salescode" readonly>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="form-group required">
                                <label>Cabang</label>
                                <input type="text" class="form-control required-field" name="fc_branch" value="{{ $data->fc_branch }}" id="fc_branch" readonly>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="form-group required">
                                <label>Nama Customer</label>
                                <select class="form-control select2 required-field" name="fc_membercode" id="fc_membercode"></select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Member Join Date</label>
                                <input type="text" class="form-control datepicker" name="fd_memberjoindate" id="fd_memberjoindate">
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Status</label>
                                <div class="selectgroup w-100">
                                    <label class="selectgroup-item" style="margin: 0!important">
                                        <input type="radio" name="fl_active" value="T" class="selectgroup-input" checked="">
                                        <span class="selectgroup-button">Active</span>
                                    </label>
                                    <label class="selectgroup-item" style="margin: 0!important">
                                        <input type="radio" name="fl_active" value="F" class="selectgroup-input">
                                        <span class="selectgroup-button">Non Active</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                <label>Sales Customer Description</label>
                                <textarea name="fv_salescustomerdescription" id="fv_salescustomerdescription" style="height: 90px" class="form-control"></textarea>
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
    var userCustomer = "{{ $fc_salescode }}";
    var encode_userCustomer = window.btoa(userCustomer)
    $(document).ready(function() {
        get_data_member_code();
    })

    function add() {
        $("#modal_edit").modal('show');
        $(".modal-title").text('Tambah Customer');
        $("#form_submit")[0].reset();
        $("#modal_edit").modal('hide');
    }

    var tb = $('#tb').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 6,
        ajax: {
            url: '/data-master/sales-customer/datatables/customer/' + encode_userCustomer,
            type: 'GET'
        },
        columnDefs: [{
                className: 'text-center',
                targets: [0]
            },
            {
                className: 'text-nowrap',
                targets: [6]
            },
        ],
        columns: [{
                data: 'DT_RowIndex',
                searchable: false,
                orderable: false
            },
            {
                data: 'customer.fc_membername1',
                defaultContent: '',
            },
            {
                data: 'customer.fc_memberaddress1'
            },
            {
                data: 'typeBisnis'
            },
            {
                data: 'statusCabang',
                defaultContent: '',
            },
            {
                data: 'fl_active',
                defaultContent: '',
            },
            {
                data: '',
                defaultContent: '',
            },
        ],
        rowCallback: function(row, data) {
            var url_delete = "/data-master/sales-customer/delete/customer/" + data.fc_membercode + '/' + data.fc_salescode;
            var url_edit = "/data-master/sales-customer/detail/" + data.fc_divisioncode + '/' + data.fc_branch + '/' + data.fc_salescode + "/" + data.fc_membercode;

            if (data.fl_active == 'T') {
                $('td:eq(5)', row).html(`<span class="badge badge-success">YES</span>`);
            } else {
                $('td:eq(5)', row).html(`<span class="badge badge-danger">NO</span>`);
            }

            $('td:eq(6)', row).html(`
            <button class="btn btn-danger btn-sm" onclick="delete_action('${url_delete}')"><i class="fa fa-trash"> </i> Hapus</button>
            <button class="btn btn-info btn-sm mr-1" onclick="edit('${url_edit}')"><i class="fa fa-edit"></i> Edit</button>
         `);
        }
    });
    function edit(url) {
        edit_action_sales_customer(url, 'Edit Data Sales Customer');
        $("#type").val('update');
    }
    

    function get_data_member_code() {
        $("#modal_loading").modal('show');
        $.ajax({
            url: "/master/get-data-all/Customer",
            type: "GET",
            dataType: "JSON",
            success: function(response) {
                setTimeout(function() {
                    $('#modal_loading').modal('hide');
                }, 500);
                if (response.status === 200) {
                    var data = response.data;
                    $("#fc_membercode").empty();
                    $("#fc_membercode").append(`<option value="" selected readonly> - Pilih - </option>`);
                    for (var i = 0; i < data.length; i++) {
                        $("#fc_membercode").append(`<option value="${data[i].fc_membercode}">${data[i].fc_membername1}</option>`);
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

    $('#form_submit_edit').on('submit', function(e) {
      e.preventDefault();

      var form_id = $(this).attr("id");
      var formData = new FormData($('#form_submit_edit')[0]);
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
                  url: $('#form_submit_edit').attr('action'),
                  type: $('#form_submit_edit').attr('method'),
                  data: formData,
                  contentType: false,
                   processData: false,
                  success: function(response) {
                     setTimeout(function() {
                        $('#modal_loading').modal('hide');
                     }, 500);
                     if (response.status == 200) {
                        swal(response.message, {
                           icon: 'success',
                        });
                        $("#modal_edit").modal('hide');
                        $("#form_submit_edit")[0].reset();
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