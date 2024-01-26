@extends('partial.app')
@section('title','Master CPRR')
@section('css')
<style>
    #tb_wrapper .row:nth-child(2){
        overflow-x: auto;
    }

    .required label:after {
        color: #e32;
        content: ' *';
        display:inline;
    }
</style>
@endsection
@section('content')

<div class="section-body">
   <div class="row">
      <div class="col-12 col-md-12 col-lg-12">
         <div class="card">
            <div class="card-header">
                <h4>Data Master CPRR</h4>
                <div class="card-header-action">
                    <button type="button" class="btn btn-success" onclick="add();"><i class="fa fa-plus mr-1"></i> Tambah Master CPRR</button>
                </div>
            </div>
            <div class="card-body">
               <div class="table-responsive">
                  <table class="table table-striped" id="tb" width="100%">
                     <thead style="white-space: nowrap">
                        <tr>
                           <th scope="col" class="text-center">No</th>
                           <th scope="col" class="text-center">Divisi</th>
                           <th scope="col" class="text-center">Cabang</th>
                           <th scope="col" class="text-center">Kode CPRR</th>
                           <th scope="col" class="text-center">Nama Pemeriksaan</th>
                           <th scope="col" class="text-center">Deskripsi</th>
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
            <form id="form_submit" action="/data-master/master-cprr/store-update" method="POST" autocomplete="off">
                <input type="text" name="type" id="type" hidden>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 col-md-3 col-lg-3" hidden>
                            <div class="form-group">
                                <label>Division Code</label>
                                <input type="text" class="form-control" name="fc_divisioncode" id="fc_divisioncode" value="{{ auth()->user()->fc_divisioncode }}" readonly>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group required">
                                <label>Cabang</label>
                                <select class="form-control select2" name="fc_branch" id="fc_branch"></select>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-9">
                            <div class="form-group required">
                                <label>Kode CPRR</label>
                                <input type="text" class="form-control required-field" name="fc_cprrcode" id="fc_cprrcode">
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-12">
                            <div class="form-group required">
                                <label>Nama Pemeriksaan</label>
                                <input type="text" class="form-control required-field" name="fc_cprrname" id="fc_cprrname">
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                <label>Deskripsi</label>
                                <textarea name="fv_description" id="fv_description" style="height: 50px" class="form-control"></textarea>
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

<!-- Modal -->
<div class="modal fade" role="dialog" id="modal_edit" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header br">
                <h5 class="modal-title">Edit Data Master CPRR</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <input type="text" class="form-control" name="fc_branch_view_edit" id="fc_branch_view_edit" value="{{ auth()->user()->fc_branch}}" readonly hidden>
            <form id="form_submit_cprr" action="/data-master/master-cprr/update" method="POST" autocomplete="off">
                @csrf
                @method('PUT')
                <input type="text" name="type" id="type" hidden>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 col-md-3 col-lg-3" hidden>
                            <div class="form-group">
                                <label>Division Code</label>
                                <input type="text" class="form-control" name="fc_divisioncode" id="fc_divisioncode" value="{{ auth()->user()->fc_divisioncode }}" readonly>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group required">
                                <label>Cabang</label>
                                <select class="form-control select2" name="fc_branch_edit" id="fc_branch_edit"></select>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-9">
                            <div class="form-group required">
                                <label>Kode CPRR</label>
                                <input type="text" class="form-control required-field" name="fc_cprrcode" id="fc_cprrcode_edit" readonly>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-12">
                            <div class="form-group required">
                                <label>Nama Pemeriksaan</label>
                                <input type="text" class="form-control required-field" name="fc_cprrname" id="fc_cprrname_edit">
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                <label>Deskripsi</label>
                                <textarea name="fv_description" id="fv_description_edit" style="height: 50px" class="form-control"></textarea>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('js')
<script>
    $(document).ready(function(){
        get_data_branch();
        get_data_branch_edit();
    })
    
    function edit(fc_cprrcode) {
        $('#modal_loading').modal('show');

        $.ajax({
            url: '/data-master/master-cprr/get-data/edit',
            type: 'GET',
            data: {
                fc_cprrcode: fc_cprrcode
            },
            success: function(response) {
                var data = response.data;

                if (response.status == 200) {
                    // modal_loading hide
                    setTimeout(function() {
                        $('#modal_loading').modal('hide');
                    }, 500);
                    $('#modal_edit').modal('show');

                    $('#fc_branch_edit').val(data.fc_branch);
                    $('#fc_cprrcode_edit').val(data.fc_cprrcode);
                    $('#fc_cprrname_edit').val(data.fc_cprrname);
                    $('#fv_description_edit').val(data.fv_description);
                }
            },
            error: function() {
                alert('Terjadi kesalahan pada server');
                $('#modal_loading').modal('hide');
            }
        });
    }

    function add(){
      $("#modal").modal('show');
      $(".modal-title").text('Tambah Master CPRR');
      $("#form_submit")[0].reset();
      document.getElementById("fc_cprrcode").readOnly = false;
    }

    function get_data_branch(){
        $("#modal_loading").modal('show');
        $.ajax({
            url : "/master/get-data-where-field-id-get/TransaksiType/fc_trx/BRANCH",
            type: "GET",
            dataType: "JSON",
            success: function(response){
                setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                if(response.status === 200){
                    var data = response.data;
                    $("#fc_branch").empty();
                    for (var i = 0; i < data.length; i++) {
                        if(data[i].fc_kode == $('#fc_branch_view').val()){
                            $("#fc_branch").append(`<option value="${data[i].fc_kode}" selected>${data[i].fv_description}</option>`);
                            $("#fc_branch").prop("disabled", true);
                        }else{
                            $("#fc_branch").append(`<option value="${data[i].fc_kode}">${data[i].fv_description}</option>`);
                        }
                    }
                }else{
                    iziToast.error({
                        title: 'Error!',
                        message: response.message,
                        position: 'topRight'
                    });
                }
            },error: function (jqXHR, textStatus, errorThrown){
                setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + errorThrown + ")", {  icon: 'error', });
            }
        });
    }

    function get_data_branch_edit(){
        $("#modal_loading").modal('show');
        $.ajax({
            url : "/master/get-data-where-field-id-get/TransaksiType/fc_trx/BRANCH",
            type: "GET",
            dataType: "JSON",
            success: function(response){
                setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                if(response.status === 200){
                    var data = response.data;
                    $("#fc_branch_edit").empty();
                    for (var i = 0; i < data.length; i++) {
                        if(data[i].fc_kode == $('#fc_branch_view_edit').val()){
                            $("#fc_branch_edit").append(`<option value="${data[i].fc_kode}" selected>${data[i].fv_description}</option>`);
                            $("#fc_branch_edit").prop("disabled", true);
                        }else{
                            $("#fc_branch_edit").append(`<option value="${data[i].fc_kode}">${data[i].fv_description}</option>`);
                        }
                    }
                }else{
                    iziToast.error({
                        title: 'Error!',
                        message: response.message,
                        position: 'topRight'
                    });
                }
            },error: function (jqXHR, textStatus, errorThrown){
                setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + errorThrown + ")", {  icon: 'error', });
            }
        });
    }

    var tb = $('#tb').DataTable({
      processing: true,
      serverSide: true,
      pageLength : 5,
      ajax: {
         url: '/data-master/master-cprr/datatables',
         type: 'GET'
      },
      columnDefs: [
         { className: 'text-center', targets: [0,2,3,4,6] },
      ],
      columns: [
         { data: 'DT_RowIndex',searchable: false, orderable: false},
         { data: 'fc_divisioncode' },
         { data: 'branch.fv_description' },
         { data: 'fc_cprrcode' },
         { data: 'fc_cprrname' },
         { data: 'fv_description' },
         { data: null },
      ],
      rowCallback : function(row, data){
         var url_delete = "/data-master/master-cprr/delete/" + data.fc_cprrcode;

         $('td:eq(6)', row).html(`
            <button class="btn btn-info btn-sm mr-1" onclick="edit('${data.fc_cprrcode}')"><i class="fa fa-edit"></i> Edit</button>
            <button class="btn btn-danger btn-sm" onclick="delete_action('${url_delete}','${data.fc_cprrcode}')"><i class="fa fa-trash"> </i> Hapus</button>
         `);
      }
   });

    $('.modal').css('overflow-y', 'auto');
</script>
@endsection
