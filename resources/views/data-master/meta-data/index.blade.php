@extends('partial.app')
@section('title','Meta Data')
@section('css')
<style>
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
                <h4>Data Meta Data</h4>
                <div class="card-header-action">
                    <button type="button" class="btn btn-success" onclick="add();"><i class="fa fa-plus mr-1"></i> Tambah Meta Data</button>
                </div>
            </div>
            <div class="card-body">
               <div class="table-responsive">
                  <table class="table table-striped" id="tb" width="100%">
                     <thead>
                        <tr>
                           <th scope="col" class="text-center">No</th>
                           <th scope="col" class="text-center">Type</th>
                           <th scope="col" class="text-center">Kode</th>
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
    <div class="modal-dialog modal-xs" role="document">
       <div class="modal-content">
          <div class="modal-header br">
             <h5 class="modal-title"></h5>
             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
             <span aria-hidden="true">&times;</span>
             </button>
          </div>
            <form id="form_submit" action="/data-master/meta-data/store-transaksi" method="POST" autocomplete="off">
                <input type="text" name="type" id="type" hidden>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="form-group required">
                                <label>TRX</label>
                                <input type="text" class="form-control required-field" name="fc_trx" id="fc_trx">
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="form-group required">
                                <label>Kode</label>
                                <input type="text" class="form-control required-field" name="fc_kode" id="fc_kode">
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="form-group required">
                                <label>Deskipsi</label>
                                <textarea class="form-control required-field" name="fv_description" id="fv_description" style="height: 100px"></textarea>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                <label>Action</label>
                                <textarea class="form-control" name="fc_action" id="fc_action" style="height: 70px"></textarea>
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
           <form id="form_submit_edit" action="/data-master/meta-data/store-update" method="POST" autocomplete="off">
             @csrf
               @method('PUT')
               <input type="text" name="type" id="type" hidden>
               <div class="modal-body">
                   <div class="row">
                       <div class="col-12 col-md-12 col-lg-12">
                           <div class="form-group">
                               <label>TRX</label>
                               <input type="text" class="form-control required-field" name="fc_trx" id="fc_trx" readonly>
                           </div>
                       </div>
                       <div class="col-12 col-md-12 col-lg-12">
                           <div class="form-group">
                               <label>Kode</label>
                               <input type="text" class="form-control required-field" name="fc_kode" id="fc_kode" readonly>
                           </div>
                       </div>
                       <div class="col-12 col-md-12 col-lg-12">
                           <div class="form-group">
                               <label>Deskipsi</label>
                               <textarea class="form-control required-field" name="fv_description" id="fv_description" style="height: 100px"></textarea>
                           </div>
                       </div>
                       <div class="col-12 col-md-12 col-lg-12">
                           <div class="form-group">
                               <label>Action</label>
                               <textarea class="form-control" name="fc_action" id="fc_action" style="height: 70px"></textarea>
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

    function add(){
      $("#modal").modal('show');
      $(".modal-title").text('Tambah User');
      $("#form_submit")[0].reset();
    }

   var tb = $('#tb').DataTable({
      processing: true,
      serverSide: true,
      pageLength : 5,
      ajax: {
         url: '/data-master/meta-data/datatables',
         type: 'GET'
      },
      columnDefs: [
         { className: 'text-center', targets: [0,4] },
      ],
      columns: [
         { data: 'DT_RowIndex',searchable: false, orderable: false},
         { data: 'fc_trx' },
         { data: 'fc_kode' },
         { data: 'fv_description' },
         { data: 'fc_kode' },
      ],
      rowCallback : function(row, data){
         var url_edit   = "/data-master/meta-data/detail/" + data.fc_trx + "/" + data.fc_kode;
         var url_delete = "/data-master/meta-data/delete/" + data.fc_kode;

         $('td:eq(4)', row).html(`
            <button class="btn btn-info btn-sm mr-1" onclick="edit('${url_edit}')"><i class="fa fa-edit"></i> Edit</button>
            <button class="btn btn-danger btn-sm" onclick="delete_action('${url_delete}','${data.fv_description}')"><i class="fa fa-trash"> </i> Hapus</button>
         `);
      }
   });

   function edit(url){
      edit_action2(url, 'Edit Data Meta Data');
      $("#type").val('update');
   }
</script>
@endsection
