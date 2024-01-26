@extends('partial.app')
@section('title','Edit Role')
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
        margin-top: 25px;
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
</style>
@endsection
@section('content')

<div class="section-body">
    <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form id="form_submit" action="/data-master/master-role/update/{{ $role->id }}" method="POST">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label for="name">Nama Role</label>
                            <input type="text" class="form-control" id="name" value="{{ $role->name }}" name="name">
                        </div>

                        <div class="form-group">
                            <label for="name">Hak Akses</label>

                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="checkPermissionAll" value="1" {{ App\Models\User::roleHasPermissions($role, $all_permissions) ? 'checked' : '' }}>
                                <label class="form-check-label" for="checkPermissionAll">Semua</label>
                            </div>
                            <hr>
                            @php $i = 1; @endphp
                            @foreach ($permission_groups as $group)
                            <div class="row">
                                @php
                                $permissions = App\Models\User::getpermissionsByGroupName($group->name);
                                $j = 1;
                                @endphp

                                <div class="col-12 col-md-12 col-lg-3">
                                    <div class="form-check cbox">
                                        <input type="checkbox" class="form-check-input" id="{{ $i }}Management" value="{{ $group->name }}" onclick="checkPermissionByGroup('role-{{ $i }}-management-checkbox', this)" {{ App\Models\User::roleHasPermissions($role, $permissions) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="checkPermission">{{ $group->name }}</label>
                                    </div>
                                </div>

                                <div class="col-12 col-md-12 col-lg-9 role-{{ $i }}-management-checkbox" id="role">

                                    @foreach ($permissions as $permission)
                                    <div class="ks-cboxtags">
                                        <input type="checkbox" class="form-check-input" onclick="checkSinglePermission('role-{{ $i }}-management-checkbox', '{{ $i }}Management', count($permissions) )" name="permissions[]" {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }} id="checkPermission{{ $permission->id }}" value="{{ $permission->name }}">
                                        <label class="form-check-label" for="checkPermission{{ $permission->id }}">{{ $permission->name }}</label>
                                    </div>
                                    @php $j++; @endphp
                                    @endforeach
                                    <br>
                                </div>

                            </div>
                            @php $i++; @endphp
                            @endforeach
                        </div>
                        <div class="text-right">
                            <a href="/data-master/master-role"><button type="button" class="btn btn-danger mr-1">Cancel Edit</button></a>
                            <button type="submit" class="btn btn-primary">Update Role</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('js')
<script>
    $('.modal').css('overflow-y', 'auto');

    /**
     * Check all the permissions
     */
    $("#checkPermissionAll").click(function() {
        if ($(this).is(':checked')) {
            // check all the checkbox
            $('input[type=checkbox]').prop('checked', true);
        } else {
            // un check all the checkbox
            $('input[type=checkbox]').prop('checked', false);
        }
    });

    function checkPermissionByGroup(className, checkThis) {
        const groupIdName = $("#" + checkThis.id);
        const classCheckBox = $('.' + className + ' input');

        if (groupIdName.is(':checked')) {
            classCheckBox.prop('checked', true);
        } else {
            classCheckBox.prop('checked', false);
        }
        implementAllChecked();
    }

    function checkSinglePermission(groupClassName, groupID, countTotalPermission) {
        const classCheckbox = $('.' + groupClassName + ' input');
        const groupIDCheckBox = $("#" + groupID);

        // if there is any occurance where something is not selected then make selected = false
        if ($('.' + groupClassName + ' input:checked').length == countTotalPermission) {
            groupIDCheckBox.prop('checked', true);
        } else {
            groupIDCheckBox.prop('checked', false);
        }
        implementAllChecked();
    }

    function implementAllChecked() {
        const countPermissions = count($all_permissions)
        const countPermissionGroups = count($permission_groups)

        if ($('input[type="checkbox"]:checked').length >= (countPermissions + countPermissionGroups)) {
            $("#checkPermissionAll").prop('checked', true);
        } else {
            $("#checkPermissionAll").prop('checked', false);
        }
    }
</script>
@endsection