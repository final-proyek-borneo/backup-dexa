@extends('partial.app')
@section('title', 'Laporan Marketing')
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

        .required label:after {
            color: #e32;
            content: ' *';
            display: inline;
        }
    </style>
@endsection

@section('content')
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
            <form method="POST" action="/apps/marketing/export-pdf" target="_blank">
            @csrf
                <div class="card">
                    <div class="card-header">
                        <h4>Filter</h4>
                        <div class="card-header-action">
                            <a href="/apps/marketing/persediaan" class="btn btn-info"><i class="fa fa-eye"></i> Lihat Persediaan</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                        <input type="text" id="fc_branch" value="{{ auth()->user()->fc_branch }}" hidden>
                            <div class="col-12 col-md-6 col-lg-3">
                                <div class="form-group required">
                                    <label>Berdasarkan</label>
                                    <select class="form-control select2" name="fc_type" id="fc_type" required>
                                        <option value="" selected disabled>- Pilih -</option>
                                        <option value="CUSTOMER">Customer</option>
                                        <option value="STATUS">Status Progress Item</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-3" id="sales" hidden>
                                <div class="form-group required">
                                    <label>Sales</label>
                                    <select class="form-control select2 required-field" name="fc_salescode" id="fc_salescode"></select>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-3" id="customer-sales-biasa" hidden>
                                <div class="form-group required">
                                    <label>Customer</label>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" id="fc_membercode" name="fc_membercode" readonly>
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" onclick="pilih_customer_sales()" type="button"><i class="fa fa-search"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-3" id="customer-sales-admin" hidden>
                                <div class="form-group required">
                                    <label>Customer</label>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" id="fc_membercode2" name="fc_membercode2" readonly>
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" onclick="pilih_customer_sales()" type="button"><i class="fa fa-search"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-3" id="status" hidden>
                                <div class="form-group required">
                                    <label>Status Progress Item</label>
                                    <select class="form-control select2" name="fc_status" id="fc_status" required>
                                        <option value="" selected disabled> - Pilih - </option>
                                        <option value="BT">Belum Terkirim</option>
                                        <option value="P">Partial</option>
                                        <option value="F">Full</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-3">
                                <div class="form-group required">
                                    <label for="fd_sodatesysinput_start">Start Date:</label>
                                    {{-- <div class="input-group" data-date-format="dd-mm-yyyy"> --}}
                                        {{-- <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-calendar"></i>
                                            </div>
                                        </div> --}}
                                        <input type="date" id="fd_sodatesysinput_start" class="form-control" name="fd_sodatesysinput_start" required>
                                    {{-- </div> --}}
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-3">
                                <div class="form-group required">
                                    <label for="fd_sodatesysinput_end">End Date:</label>
                                    {{-- <div class="input-group" data-date-format="dd-mm-yyyy"> --}}
                                        {{-- <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-calendar"></i>
                                            </div>
                                        </div> --}}
                                        <input type="date" id="fd_sodatesysinput_end" class="form-control" name="fd_sodatesysinput_end" required>
                                    {{-- </div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="button text-right">
                    <button  type="button" class="btn btn-warning mr-2" onclick="show_preview()">Preview</button>
                    <button  type="submit" class="btn btn-success">Export</button>
                </div>
            </form>
            </div>
        </div>
    </div>
@endsection

@section('modal')
<div class="modal fade" role="dialog" id="modal_sales_customer" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
        <div class="modal-header br">
            <h5 class="modal-title">Pilih Customer</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="table-responsive">
                <table class="table table-striped" id="tb_sales_customer" width="100%">
                <thead>
                    <tr>
                        <th scope="col" class="text-center">No</th>
                        <th scope="col" class="text-center">Nama Customer</th>
                        <th scope="col" class="text-center">Kode Customer</th>
                        <th scope="col" class="text-center">Alamat</th>
                        <th scope="col" class="text-center">Tipe Bisnis</th>
                        <th scope="col" class="text-center">Status Cabang</th>
                        <th scope="col" class="text-center">Active</th>
                        <th scope="col" class="text-center">Actions</th>
                    </tr>
                </thead>
                </table>
            </div>
        </div>
        <div class="modal-footer bg-whitesmoke br">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
    </div>
    </div>
</div>

<div class="modal fade" role="dialog" id="modal_preview" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
        <div class="modal-header br">
            <h5 class="modal-title">Preview</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="table-responsive">
                <table class="table table-striped" id="tb_preview" width="100%">
                <thead>
                    <tr>
                        <th scope="col" class="text-center">No</th>
                        <th scope="col" class="text-center">Tipe SO</th>
                        <th scope="col" class="text-center">Tanggal SO</th>
                        <th scope="col" class="text-center">No. SO</th>
                        <th scope="col" class="text-center">Nama Barang</th>
                        <th scope="col" class="text-center">SO</th>
                        <th scope="col" class="text-center">DO</th>
                        <th scope="col" class="text-center">BAL</th>
                        <th scope="col" class="text-center">Ket. BAL</th>
                    </tr>
                </thead>
                </table>
            </div>
        </div>
        <div class="modal-footer bg-whitesmoke br">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
    </div>
    </div>
</div>
@endsection

@section('js')
    <script>
        let fc_userid = "{{ auth()->user()->fc_userid }}";
        var encodedUserid = btoa(fc_userid);

        $(document).ready(function(){
            var apiUrl = '/apps/marketing/get-role-sales/' + encodeURIComponent(btoa('{{ auth()->user()->fc_userid }}'));
            $.get(apiUrl, function(response) {
                if (response.status === 204) {
                    var selectElement = document.getElementById("fc_type");
                        var salesOption = selectElement.querySelector('option[value="SALES"]');
                        if (!salesOption) {
                            var newOption = document.createElement("option");
                            newOption.value = "SALES";
                            newOption.text = "Sales";
                            selectElement.add(newOption);
                        }
                }
                // console.log(response.status);
            });

            get_data_sales();
        })

        $("#fc_type").change(function() {
            if ($('#fc_type').val() === 'STATUS') {
                showStatusField();
            } else if ($('#fc_type').val() === 'CUSTOMER') {
                showCustomerField();
            } else if ($('#fc_type').val() === 'SALES') {
                showSalesField();
            } else {
                hideAllFields();
            }
        });

        // FILTER UNTUK SALES BIASA
        function hideAllFields() {
            $('#status').attr('hidden', true);
            $('#customer-sales-admin').attr('hidden', true);
            $('#customer-sales-biasa').attr('hidden', true);
            $('#sales').attr('hidden', true);
            $('input[id="fc_membercode"]').val("");
            $('#fc_salescode').val(null).trigger('change');
            $('#fc_status').val(null).trigger('change');
            $('#fc_status').prop('required', false); // Remove the 'required' attribute
        }

        function showCustomerField() {
            hideAllFields();
            // jika auth user fc_userid tidak ditemukan pada Sales pada field fc_salecode maka field customer-sales di hidden
            let fc_userid = "{{ auth()->user()->fc_userid }}";
            
            // console.log("ini userid" + fc_userid);
            let encodedfc_userid = btoa(fc_userid);

            // ambil data fc_salescode dari table Sales
            $.ajax({
                url : "/apps/marketing/get-role-sales/" + encodedfc_userid,
                type: "GET",
                dataType: "JSON",
                success: function(response){
                    // console.log(response);
                    if(response.status === 200){
                        $('#sales').attr('hidden', true);
                        $('#customer-sales-biasa').attr('hidden', false);
                        $('#customer-sales-admin').attr('hidden', true);
                        $('#tb_sales_customer').DataTable().destroy();
                        table_sales_customer(encodedselectedSales)
                    }else{
                        $('#sales').attr('hidden', false);
                        $('#customer-sales-biasa').attr('hidden', true);
                        $('#customer-sales-admin').attr('hidden', false);
                        $('#fc_salescode').on('change', function() {
                            if ($('#fc_salescode').val() === '') {
                                $('#customer-sales-admin').attr('hidden', true);
                            } else {
                                $('#customer-sales-admin').attr('hidden', false);
                                var selectedSales = $(this).val();
                                var encodedselectedSales = btoa(selectedSales);
                                // destroy datatable
                                $('#tb_sales_customer').DataTable().destroy();
                                table_sales_customer(encodedselectedSales)
                            }
                        });
                        $('input[id="fc_membercode2"]').val("");
                    }
                },error: function (jqXHR, textStatus, errorThrown){
                    swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + errorThrown + ")", {  icon: 'error', });
                }
            });
        }

        function showSalesField() {
            hideAllFields();
            // jika auth user fc_userid tidak ditemukan pada Sales pada field fc_salecode maka field customer-sales di hidden
            let fc_userid = "{{ auth()->user()->fc_userid }}";
            // console.log("ini userid" + fc_userid);
            let encodedfc_userid = btoa(fc_userid);
            // ambil data fc_salescode dari table Sales
            $.ajax({
                url : "/apps/marketing/get-role-sales/" + encodedfc_userid,
                type: "GET",
                dataType: "JSON",
                success: function(response){
                    // console.log(response);
                    if(response.status === 200){
                        $('#sales').attr('hidden', true);
                        $('#customer-sales-biasa').attr('hidden', false);
                        $('#customer-sales-admin').attr('hidden', true);
                    }else{
                        $('#sales').attr('hidden', false);
                        $('#customer-sales-biasa').attr('hidden', true);
                        $('#customer-sales-admin').attr('hidden', false);
                        $('input[id="fc_membercode2"]').val("");
                    }
                },error: function (jqXHR, textStatus, errorThrown){
                    swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + errorThrown + ")", {  icon: 'error', });
                }
            });

            $('input[id="fc_membercode"]').val("");
            $('#fc_salescode').val(null).trigger('change');
            $('#fc_status').val(null).trigger('change');
            $('#fc_status').prop('required', false); // Remove the 'required' attribute
        }

        function showStatusField() {
            hideAllFields();
            $('#status').attr('hidden', false);
            $('#fc_status').prop('required', true); // Add the 'required' attribute

            // jika auth user fc_userid tidak ditemukan pada Sales pada field fc_salecode maka field customer-sales di hidden
            let fc_userid = "{{ auth()->user()->fc_userid }}";
            
            // console.log("ini userid" + fc_userid);
            let encodedfc_userid = btoa(fc_userid);

            // ambil data fc_salescode dari table Sales
            $.ajax({
                url : "/apps/marketing/get-role-sales/" + encodedfc_userid,
                type: "GET",
                dataType: "JSON",
                success: function(response){
                    console.log(response);
                    if(response.status === 200){
                        $('#sales').attr('hidden', true);
                        $('#customer-sales-biasa').attr('hidden', false);
                        $('#customer-sales-admin').attr('hidden', true);
                    }else{
                        $('#sales').attr('hidden', false);
                        $('#customer-sales-biasa').attr('hidden', true);
                        $('#customer-sales-admin').attr('hidden', false);
                        $('#fc_salescode').on('change', function() {
                            if ($('#fc_salescode').val() === '') {
                                $('#customer-sales-admin').attr('hidden', true);
                            } else {
                                $('#customer-sales-admin').attr('hidden', false);
                            }
                        });
                        $('input[id="fc_membercode2"]').val("");
                    }
                },error: function (jqXHR, textStatus, errorThrown){
                    swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + errorThrown + ")", {  icon: 'error', });
                }
            });
        }

        function pilih_customer_sales(){
            $('#modal_sales_customer').modal('show');
            table_sales_customer();
        }

        function show_preview() {
            let fc_type = $('#fc_type').val();
            let fc_salescode = $('#fc_salescode').val();
            let fc_membercode = $('#fc_membercode').val();
            let fc_membercode2 = $('#fc_membercode2').val();
            let fc_status = $('#fc_status').val();
            let fd_sodatesysinput_start = $('#fd_sodatesysinput_start').val();
            let fd_sodatesysinput_end = $('#fd_sodatesysinput_end').val();
            
            let requestData = {
                fc_type: fc_type,
                fc_salescode: fc_salescode,
                fc_membercode: fc_membercode,
                fc_membercode2: fc_membercode2,
                fc_status: fc_status,
                fd_sodatesysinput_start: fd_sodatesysinput_start,
                fd_sodatesysinput_end: fd_sodatesysinput_end
            };
                    if ($.fn.DataTable.isDataTable('#tb_preview')) {
                        $('#tb_preview').DataTable().destroy();
                    }

                    let tb_preview = $('#tb_preview').DataTable({
                        destroy: true,
                        processing: true,
                        serverSide: true,
                        pageLength: 6, 
                        ajax: {
                            url: '/apps/marketing/datatable-preview-marketing?' + $.param(requestData),
                            type: 'GET'
                        },
                        columns: [
                            {
                                data: 'DT_RowIndex',
                                searchable: false,
                                orderable: false
                            },
                            {
                                data: 'fc_sotype',
                                defaultContent: '',
                            },
                            {
                                data: 'fd_sodatesysinput',
                                render: function(data) {
                                    return moment(data).format('DD-MM-YYYY');
                                },
                                defaultContent: '',
                            },
                            {
                                data: 'fc_sono',
                                defaultContent: '',
                            },
                            {
                                data: 'fc_namelong',
                                defaultContent: '',
                            },
                            {
                                data: 'fn_so_qty',
                                defaultContent: '',
                            },
                            {
                                data: 'fn_do_qty',
                                defaultContent: '',
                            },
                            {
                                data: 'status_so', 
                                defaultContent: '',
                            },
                            {
                                data: 'status_qty', 
                                defaultContent: '',
                            },
                        ],
                    });

                    // Show the modal
                    $('#modal_preview').modal('show');
               
        }

        function table_sales_customer(encodedselectedSales){
            var selectedSales = $('#fc_salescode').val();
            var encodedselectedSales = btoa(selectedSales);
            // jika auth user fc_userid tidak ditemukan pada Sales pada field fc_salecode maka field customer-sales di hidden
            let fc_userid = "{{ auth()->user()->fc_userid }}";
            // console.log("ini userid" + fc_userid);
            let encodedfc_userid = btoa(fc_userid);
            // ambil data fc_salescode dari table Sales
            $.ajax({
                url : "/apps/marketing/get-role-sales/" + encodedfc_userid,
                type: "GET",
                dataType: "JSON",
                success: function(response){
                    if(response.status === 200){
                        var tb_sales_customer = $('#tb_sales_customer').DataTable({
                            destroy: true,
                            processing: true,
                            serverSide: true,
                            pageLength: 6,
                            ajax: {
                                url: '/apps/marketing/datatables-sales-customer/' + encodedfc_userid,
                                type: 'GET' 
                            },
                            columnDefs: [{
                                    className: 'text-center',
                                    targets: [0, 4, 5, 6, 7]
                                },
                                {
                                    visible: false,
                                    searchable: true,
                                    targets: [2]
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
                                    data: 'customer.fc_membercode',
                                    defaultContent: '',
                                },
                                {
                                    data: 'customer.fc_memberaddress1'
                                },
                                {
                                    data: 'customer.fc_membertypebusiness'
                                },
                                {
                                    data: 'customer.fc_member_branchtype',
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
                                if (data.fl_active == 'T') {
                                    $('td:eq(5)', row).html(`<span class="badge badge-success">YES</span>`);
                                } else {
                                    $('td:eq(5)', row).html(`<span class="badge badge-danger">NO</span>`);
                                }

                                $('td:eq(6)', row).html(`
                                <button type="button" class="btn btn-warning btn-sm mr-1" onclick="get_sales_customer('${data.fc_membercode}')"><i class="fa fa-check"></i> Pilih</button>
                            `);
                            }
                        });
                    }else{
                        var tb_sales_customer = $('#tb_sales_customer').DataTable({
                            destroy: true,
                            processing: true,
                            serverSide: true,
                            pageLength: 6,
                            ajax: {
                                url: '/apps/marketing/datatables-sales-customer/' + encodedselectedSales,
                                type: 'GET' 
                            },
                            columnDefs: [{
                                    className: 'text-center',
                                    targets: [0, 4, 5, 6, 7]
                                },
                                {
                                    visible: false,
                                    searchable: true,
                                    targets: [2]
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
                                    data: 'customer.fc_membercode',
                                    defaultContent: '',
                                },
                                {
                                    data: 'customer.fc_memberaddress1'
                                },
                                {
                                    data: 'customer.fc_membertypebusiness'
                                },
                                {
                                    data: 'customer.fc_member_branchtype',
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
                                if (data.fl_active == 'T') {
                                    $('td:eq(5)', row).html(`<span class="badge badge-success">YES</span>`);
                                } else {
                                    $('td:eq(5)', row).html(`<span class="badge badge-danger">NO</span>`);
                                }

                                $('td:eq(6)', row).html(`
                                <button type="button" class="btn btn-warning btn-sm mr-1" onclick="get_sales_customer2('${data.fc_membercode}')"><i class="fa fa-check"></i> Pilih</button>
                            `);
                            }
                        });
                    }
                },error: function (jqXHR, textStatus, errorThrown){
                    swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + errorThrown + ")", {  icon: 'error', });
                }
            });
        }

        function get_data_sales(){
            $.ajax({
                url : "/master/get-data-where-field-id-get/Sales/fc_branch/" + $('#fc_branch').val(),
                type: "GET",
                dataType: "JSON",
                success: function(response){
                    if(response.status === 200){
                        var data = response.data;
                        $("#fc_salescode").empty();
                        $("#fc_salescode").append(`<option value="" selected disabled> - Pilih - </option>`);
                        for (var i = 0; i < data.length; i++) {
                            $("#fc_salescode").append(`<option value="${data[i].fc_salescode}">${data[i].fc_salesname1}</option>`);
                        }
                    }else{
                        iziToast.error({
                            title: 'Error!',
                            message: response.message,
                            position: 'topRight'
                        });
                    }
                },error: function (jqXHR, textStatus, errorThrown){
                    swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + errorThrown + ")", {  icon: 'error', });
                }
            });
        }

        function get_sales_customer($fc_membercode) {
            $('#fc_membercode').val($fc_membercode);
            $('#modal_sales_customer').modal('hide');
        }

        function get_sales_customer2($fc_membercode) {
            $('#fc_membercode2').val($fc_membercode);
            $('#modal_sales_customer').modal('hide');
        }

        var tb = $('#tb').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 6,
        ajax: {
            url: '/apps/marketing/datatables-filter-customer',
            type: 'GET'
        },
        columnDefs: [{
                className: 'text-center',
                targets: [0, 4, 5, 6, 7]
            },
            {
                visible: false,
                searchable: true,
                targets: [2]
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
                data: 'customer.fc_membercode',
                defaultContent: '',
            },
            {
                data: 'customer.fc_memberaddress1'
            },
            {
                data: 'customer.fc_membertypebusiness'
            },
            {
                data: 'customer.fc_member_branchtype',
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
            if (data.fl_active == 'T') {
                $('td:eq(5)', row).html(`<span class="badge badge-success">YES</span>`);
            } else {
                $('td:eq(5)', row).html(`<span class="badge badge-danger">NO</span>`);
            }

            $('td:eq(6)', row).html(`
            <button type="button" class="btn btn-warning btn-sm mr-1" onclick="get_customer('${data.fc_membercode}')"><i class="fa fa-check"></i> Pilih</button>
         `);
        }
    });

 
   
    </script>
@endsection