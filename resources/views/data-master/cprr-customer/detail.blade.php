@extends('partial.app')
@section('title','CPRR ' . $data->fc_membername1)
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
</style>
@endsection

@section('content')

<div class="section-body">
    <input type="text" id="fc_membercode" value="{{$data->fc_membercode}}" hidden>
    <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4>Detail Pemeriksaan CPRR</h4>
                    <div class="card-header-action">
                        <button type="button" class="btn btn-success" onclick="add();"><i class="fa fa-plus mr-1"></i> Tambah Data CPRR</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="tb" width="100%">
                            <thead style="white-space: nowrap">
                                <tr>
                                    <th scope="col" class="text-center">No</th>
                                    <th scope="col" class="text-center">Kode CPRR</th>
                                    <th scope="col" class="text-center">Nama Pemeriksaan</th>
                                    <th scope="col" class="text-center">Harga</th>
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
<div class="modal fade" role="dialog" id="modal" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-md" role="document">
       <div class="modal-content">
          <div class="modal-header br">
             <h5 class="modal-title">Edit CPRR</h5>
             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
             <span aria-hidden="true">&times;</span>
             </button>
          </div>
            <form id="form_submit" action="/data-master/cprr-customer/store-update" method="POST" autocomplete="off">
                <input type="text" name="type" id="type" hidden>
                <input type="number" name="id" id="id" hidden>
                <input type="text" id="fc_membercode" name="fc_membercode" value="{{$data->fc_membercode}}" hidden>
                <div class="modal-body">
                    <div class="row">  
                        <div class="col-12 col-md-12 col-lg-12 form-group required">
                            <label>Cabang</label>
                            <input class="form-control" name="fc_branch" id="fc_branch" value="{{auth()->user()->fc_branch}}" required readonly>
                        </div>
                        <div class="col-12 col-md-12 col-lg-12 form-group required">
                            <label>Nama Pemeriksaan</label>
                            <select class="form-control select2 required-field" name="fc_cprrname" id="fc_cprrname" onchange="getCprrCode()"></select>
                        </div>
                        <div class="col-6 col-md-6 col-lg-6 rm-group required">
                            <label>Kode Pemeriksaan</label>
                            <input type="text" class="form-control required-field" name="fc_cprrcode" id="fc_cprrcode" readonly>
                        </div>
                        <div class="col-6 col-md-6 col-lg-6">
                            <div class="form-group required">
                                <label>Harga</label>
                                <input class="form-control required-field" name="fm_price" id="fm_price">
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="form-group required">
                                <label>Deskripsi</label>
                                <input type="text" class="form-control" name="fv_description" id="fv_description">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
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
    $(document).ready(function(){
        get_data_cprr();
    })

    var fc_membercode = document.getElementById("fc_membercode").value;
    var membercodeEncode = window.btoa(fc_membercode);


    function add(){
        $("#fc_cprrname").removeAttr("disabled");
        $("#form_submit")[0].reset();
        $("#fc_membercode").val(fc_membercode);
        reset_all_select();
        $("#modal").modal('show');
        $(".modal-title").text('Tambah CPRR');
    }

    function getCprrCode(){
        $('#modal_loading').modal('show');
        $.ajax({
                url: "/data-master/cprr-customer/getall",
                type: "GET",
                dataType: "JSON",
                success: function(response){
                    setTimeout(function(){
                        $('#modal_loading').modal('hide');
                    }, 500);
                    if(response.status === 200){
                        var data = response.data;

                        $("#fc_cprrcode").empty();
                        for(var i = 0; i < data.length; i++){
                            if(data[i].fc_cprrname == $("#fc_cprrname").val()){
                                $("#fc_cprrcode").val(data[i].fc_cprrcode)
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
    
    function get_data_cprr(){
        $("#modal_loading").modal("show");
        $.ajax({
            url: "/data-master/cprr-customer/getall",
            type: "GET",
            dataType: "JSON",
            success: function(response){
                setTimeout(function(){
                    $('#modal_loading').modal('hide');
                }, 500);
                if(response.status === 200){
                    var data = response.data;

                    $("#fc_cprrname").empty();
                    $("#fc_cprrname").append(`<option value="" selected disabled> - Pilih - </option>`);
                    
                    for(var i = 0; i < data.length; i++){
                        $("#fc_cprrname").append(`<option value="${data[i].fc_cprrname}">${data[i].fc_cprrname}</option>`);
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
    
    var tb = $('#tb').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        pageLength : 5,
        ajax: {
            url: '/data-master/cprr-customer/datatables/'+ membercodeEncode,
            type: 'GET'
        },
        columnDefs: [{
                className: 'text-center',
                targets: [0,1,2,3,4]
            },
            {
                className: 'text-nowrap',
                targets: [4]
            },
        ],
        columns: [{
                data: 'DT_RowIndex',
                searchable: false,
                orderable: false
            },
            {
                data: 'fc_cprrcode',
                defaultContent: '-',
            },
            {
                data: 'cospertes.fc_cprrname',
            },
            {
                data: 'fm_price',
                render: function(data, type, row){
                    return row.fm_price.toLocaleString('id-ID', {
                        style: 'currency',
                        currency: 'IDR'
                    });
                }
            },
            {
                data: null
            },
        ],
        rowCallback: function(row, data) {
            var idCprr = window.btoa(data.id)
            var url_edit = "/data-master/cprr-customer/" + idCprr;
            var url_delete = "/data-master/cprr-customer/delete/" + idCprr;
        
            $('td:eq(4)', row).html(`
                <button class="btn btn-info btn-sm mr-1" onclick="edit('${url_edit}', '${data.id}')"><i class="fa fa-edit"></i> Edit</button>
                <button class="btn btn-danger btn-sm mr-1" onclick="delete_action('${url_delete}','${data.cospertes.fc_cprrname}')"><i class="fa fa-trash"></i> Hapus</button>
            `);
        }

    });

    function edit(url, id) {
        edit_action_custom(url, 'Edit Data CPRR Customer');
        $("#fc_membercode").val(membercodeEncode);
        $("#type").val('update');
        $("#id").val(id);
    }

    function edit_action_custom(url, modal_text){
        $("#modal").modal('show');
        $("#form_submit")[0].reset();
        reset_all_select();
        $(".modal-title").text(modal_text);
        $("#modal_loading").modal('show');
        $.ajax({
            url : url,
            type: "GET",
            dataType: "JSON",
            success: function(response){
                setTimeout(function () {  $('#modal_loading').modal('hide');}, 600);
                if(response.status === 200){
                    var data = response.data;

                    $("#fc_cprrname").val(data.cospertes.fc_cprrname).trigger('change');
                    $("#fc_cprrname").prop("disabled","true");
                    $("#fc_cprrcode").val(data.fc_cprrcode);
                    $("#fm_price").val(data.fm_price);
                    $("#fv_description").val(data.fv_description);
                } else {
                    iziToast.error({
                        title: 'Error!',
                        message: response.message,
                        position: 'topRight'
                    });
                }
            },
            error: function (jqXHR, textStatus, errorThrown){
                setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + jqXHR.responseText + ")", {  icon: 'error', });
            }
        });
    }
</script>
@endsection