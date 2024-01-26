@extends('partial.app')
@section('title','Master Menu')
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
               <h4>Data Menu</h4>
               <div class="card-header-action">
                  <button type="button" class="btn btn-success" onclick="add();"><i class="fa fa-plus mr-1"></i> Tambah Menu</button>
               </div>
            </div>
            <div class="card-body">
               <div class="table-responsive">
                  <table class="table table-striped" id="tb" width="100%">
                     <thead>
                        <tr>
                           <th scope="col" class="text-center">No</th>
                           <th scope="col" class="text-center">Nama Menu</th>
                           <th scope="col" class="text-center">Icon</th>
                           <th scope="col" class="text-center">Type</th>
                           <th scope="col" class="text-center">Index</th>
                           <th scope="col" class="text-center">Url</th>
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
        <form id="form_submit" action="/data-master/master-menu/store-update" method="POST" autocomplete="off">
            <div class="modal-body">
            <div class="row">
                <div class="col-12 col-md-6 col-lg-6">
                    <div class="form-group required">
                        <label>Nama Menu</label>
                        <input type="text" hidden class="form-control" name="id" id="id">
                        <input type="text" hidden class="form-control" name="type" id="type">
                        <input type="text" class="form-control required-field" name="nama_menu" id="nama_menu" required>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="form-group required">
                        <label>Kategori</label>
                        <input type="text" class="form-control" name="kategori" id="kategori" required>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="form-group required">
                        <label>Icon</label>
                        <input type="text" class="form-control" name="icon" id="icon" required>
                    </div>
                </div>
                <div class="col-12 col-md-3 col-lg-3">
                    <div class="form-group">
                        <label>Index</label>
                        <input type="text" class="form-control" name="index" id="index">
                    </div>
                </div>
                <div class="col-12 col-md-3 col-lg-3">
                    <div class="form-group">
                        <label>Parent</label>
                        <input type="text" class="form-control" name="parent_id" id="parent_id">
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label>Menu</label>
                        <input type="text" class="form-control" name="menu" id="menu">
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label>Sub-Menu</label>
                        <input type="text" class="form-control" name="submenu" id="submenu">
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label>Url</label>
                        <input type="text" class="form-control" name="link" id="link">
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
      $(".modal-title").text('Tambah Menu');
      $("#form_submit")[0].reset();
      $('.file').each(function(){
         $(this).addClass("required-field");
      });
    }

   var tb = $('#tb').DataTable({
      processing: true,
      serverSide: true,
      pageLength : 5,
      ajax: {
         url: '/data-master/master-menu/datatables',
         type: 'GET'
      },
      columnDefs: [
         { className: 'text-center', targets: [0,2,3,4,6] },
      ],
      columns: [
         { data: 'DT_RowIndex',searchable: false, orderable: false},
         { data: 'nama' },
         { data: 'icon' },
         { data: 'status' },
         { data: 'index' },
         { data: 'link' },
         { data: 'DT_RowIndex' },
      ],
      rowCallback : function(row, data){
         $('td:eq(2)', row).html(`<i class="${data.icon}"></i>`);
         if(data['status'] == 'menu'){
            $('td:eq(3)', row).html('<span class="badge badge-warning">Menu</span>');
         }else{
            $('td:eq(3)', row).html('<span class="badge badge-primary">Sub-Menu</span>');
         }

         var url_edit   = "/data-master/master-menu/detail/" + data.id;
         var url_delete = "/data-master/master-menu/delete/" + data.id;

         $('td:eq(6)', row).html(`
            <button class="btn btn-info btn-sm mr-1" onclick="edit('${url_edit}')"><i class="fa fa-edit"></i> Edit</button>
            <button class="btn btn-danger btn-sm" onclick="delete_action('${url_delete}','${data.nama}')"><i class="fa fa-trash"> </i> Hapus</button>
         `);
      }
   });

   function edit(url){
      edit_action(url, 'Edit Menu');
      $("#type").val('update');
   }
</script>
@endsection
