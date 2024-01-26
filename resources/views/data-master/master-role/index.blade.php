@extends('partial.app')
@section('title','Master Role')
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

    .form-check-label {
        text-transform: capitalize;
    }

    .cbox{
        margin-top: 20px;
    }

    .ks-cboxtags {        
        list-style: none;
    }

    .ks-cboxtags {
        display: inline;
    }

    .ks-cboxtags label {
        display: inline-block;
        background-color: rgba(255, 255, 255, .9);
        border: 2px solid rgba(139, 139, 139, .3);
        color: #adadad;
        border-radius: 25px;
        white-space: nowrap;
        margin: 3px 0px;
        -webkit-touch-callout: none;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        -webkit-tap-highlight-color: transparent;
        transition: all .2s;
    }

    .ks-cboxtags label {
        padding: 8px 12px;
        cursor: pointer;
    }

    .ks-cboxtags label::before {
        display: inline-block;
        font-style: normal;
        font-variant: normal;
        text-rendering: auto;
        -webkit-font-smoothing: antialiased;
        font-family: "Font Awesome 5 Free";
        font-weight: 900;
        font-size: 12px;
        padding: 2px 6px 2px 2px;
        content: "\f067";
        transition: transform .3s ease-in-out;
    }

    .ks-cboxtags input[type="checkbox"]:checked+label::before {
        content: "\f00c";
        transform: rotate(-360deg);
        transition: transform .3s ease-in-out;
    }

    .ks-cboxtags input[type="checkbox"]:checked+label {
        border: 2px solid #0d6efd;
        background-color: #0464d4;
        color: #fff;
        transition: all .2s;
    }

    .ks-cboxtags input[type="checkbox"] {
        display: absolute;
    }

    .ks-cboxtags input[type="checkbox"] {
        position: absolute;
        opacity: 0;
    }

    .ks-cboxtags input[type="checkbox"]:focus+label {
        border: 2px solid #e9a1ff;
    }

    #role{
        margin-top: 10px;
    }

    .badge {
        display: inline-block;
        padding: 0.25em 0.4em;
        font-size: 75%;
        font-weight: 600;
        line-height: 1;
        text-align: center;
        white-space: nowrap;
        vertical-align: baseline;
        border-radius: 0.25rem;
        background-color: #0464d4;
        color: #fff;
    }
</style>
@endsection
@section('content')

<div class="section-body">
    <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4>Data Role</h4>
                    <div class="card-header-action">
                        <button type="button" class="btn btn-success" onclick="add();"><i class="fa fa-plus mr-1"></i> Tambah Role</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="tb" width="100%">
                            <thead style="white-space: nowrap">
                                <tr>
                                    <th class="text-center" width="5%">No</th>
                                    <th class="text-center" width="10%">Nama Role</th>
                                    <th class="text-center" width="10%">Role ID</th>
                                    <th class="text-center" width="50%">Hak Akses</th>
                                    <th class="text-center" width="15%">Actions</th>
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
            <form id="form_submit" action="/data-master/master-role/create" method="POST" autocomplete="off">
                <input type="text" name="type" id="type" hidden>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Nama Role</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan nama role">
                    </div>

                    <div class="form-group">
                        <label for="name">Hak Akses</label>

                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="checkPermissionAll" value="1">
                            <label class="form-check-label" for="checkPermissionAll">Semua</label>
                        </div>
                        <hr>
                        @php $i = 1; @endphp
                        @foreach ($permission_groups as $group)
                        <div class="row">
                            <div class="col-12 col-md-12 col-lg-3">
                                <div class="form-check cbox">
                                    <input type="checkbox" class="form-check-input" id="{{ $i }}Management" value="{{ $group->name }}" onclick="checkPermissionByGroup('role-{{ $i }}-management-checkbox', this)">
                                    <label class="form-check-label" for="checkPermission">{{ $group->name }}</label>
                                </div>
                            </div>

                            <div class="col-12 col-md-12 col-lg-9 role-{{ $i }}-management-checkbox" id="role">
                                @php
                                    $permissions = App\Models\User::getpermissionsByGroupName($group->name);
                                    $j = 1;
                                @endphp
                                @foreach ($permissions as $permission)
                                    <div class="ks-cboxtags">
                                        <input type="checkbox" class="form-check-input" name="permissions[]" id="checkPermission{{ $permission->id }}" value="{{ $permission->name }}">
                                        <label class="form-check-label" for="checkPermission{{ $permission->id }}">{{ $permission->name }}</label>
                                    </div>
                                    @php  $j++; @endphp
                                @endforeach
                                <br>
                            </div>
                        </div>
                        @php  $i++; @endphp
                        @endforeach
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
    function add() {
        $("#modal").modal('show');
        $(".modal-title").text('Tambah Role');
        $("#form_submit")[0].reset();
    }

    $('.modal').css('overflow-y', 'auto');

     /**
         * Check all the permissions
         */
         $("#checkPermissionAll").click(function(){
             if($(this).is(':checked')){
                 // check all the checkbox
                 $('input[type=checkbox]').prop('checked', true);
             }else{
                 // un check all the checkbox
                 $('input[type=checkbox]').prop('checked', false);
             }
         });

         function checkPermissionByGroup(className, checkThis){
            const groupIdName = $("#"+checkThis.id);
            const classCheckBox = $('.'+className+' input');

            if(groupIdName.is(':checked')){
                 classCheckBox.prop('checked', true);
             }else{
                 classCheckBox.prop('checked', false);
             }
            implementAllChecked();
         }

         function checkSinglePermission(groupClassName, groupID, countTotalPermission) {
            const classCheckbox = $('.'+groupClassName+ ' input');
            const groupIDCheckBox = $("#"+groupID);

            // if there is any occurance where something is not selected then make selected = false
            if($('.'+groupClassName+ ' input:checked').length == countTotalPermission){
                groupIDCheckBox.prop('checked', true);
            }else{
                groupIDCheckBox.prop('checked', false);
            }
            implementAllChecked();
         }

         function implementAllChecked() {
             const countPermissions = {{ count($all_permissions) }};
             const countPermissionGroups = {{ count($permission_groups) }};

            //  console.log((countPermissions + countPermissionGroups));
            //  console.log($('input[type="checkbox"]:checked').length);

             if($('input[type="checkbox"]:checked').length >= (countPermissions + countPermissionGroups)){
                $("#checkPermissionAll").prop('checked', true);
            }else{
                $("#checkPermissionAll").prop('checked', false);
            }
         }



         var tb = $('#tb').DataTable({
            processing: true,
            serverSide: true,
            pageLength : 5,
            ajax: {
                url: '/data-master/master-role/datatable',
                type: 'GET'
            },
            columnDefs: [{
                    className: 'text-center',
                    targets: [0, 1, 2, 3]
                },
                {
                    className: 'text-nowrap',
                    targets: [0]
                },
            ],
            columns: [{
                    data: 'DT_RowIndex',
                    searchable: false,
                    orderable: false
                },
                {
                    data: 'name'
                },
                {
                    data: 'id'
                },
                {
                    data: 'permissions',
                    render: function(data) {
                        var permissions = data.map(function(permission) {
                            return `<span class="badge mr-1">${permission.name}</span>`;
                        });
                        return permissions.join('');
                    },
                },
                {
                    data: null
                },
            ],
            rowCallback: function(row, data) {
                var url_delete = "/data-master/master-role/destroy/" + data.id;
                var url_edit = "/data-master/master-role/edit/" + data.id;
                $('td:eq(4)', row).html(`
                <a href="${url_edit}" class="btn btn-info btn-sm mr-1"><i class="fa fa-edit"></i> Edit</a>
                    <button class="btn btn-danger btn-sm" onclick="delete_action('${url_delete}','${data.name}')" ><i class="fa fa-trash"> </i> Hapus</button>
                `);
            }
        });
</script>
@endsection
{{-- @section('scripts')
     @include('data-master.master-role.partials.scripts')
@endsection --}}