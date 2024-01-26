@extends('partial.app')
@section('title', 'Dashboard')
@section('content')
    @php
        use Carbon\Carbon;
        $notifList = \App\Models\NotificationMaster::with('notifdtl')
            ->whereHas('notifdtl', function ($query) {
                $query->where('fc_userid', auth()->user()->fc_userid)->whereNull('fd_watchingdate');
            })
            ->orderBy('fd_notifdate', 'DESC')
            ->limit(3)
            ->get();
        
        // $notifCount = \App\Models\NotificationMaster::where('fc_status', 'R')->count();
        $notifCount = \App\Models\NotificationDetail::whereHas('notifmst', function ($query) {
            $query->where('fc_status', '=', 'R');
        })
            ->where('fc_userid', auth()->user()->fc_userid)
            ->whereNull('fd_watchingdate')
            ->count();
        // @dd($notifCount)
    @endphp

    <div class="section-body">
        <!-- <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-12">
          <div class="card">
            <div class="card-body ">
              <div class="text-center mb-2 mt-2">
                <h3 class="text-primary">Welcome Back, {{ auth()->user()->fc_userid }}!</h3>
              </div>
            </div>
          </div>
        </div>
      </div>  -->
        <div class="row">
            <div class="col-12 col-md-12 col-lg-4">
                <div class="card card-statistic-1" onclick="click_modal_moq()" style="cursor: pointer;">
                    <div class="card-icon bg-icon">
                        <i class="fa fa-cube"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Minimum Available Quantity</h4>
                        </div>
                        <div class="card-body">
                            {{ $moqCount}}
                        </div>
                        <span class="fas fa-arrow-right"></span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-12 col-lg-4">
                <div class="card card-statistic-1" onclick="click_modal_maq()" style="cursor: pointer;">
                    <div class="card-icon bg-icon">
                        <i class="fa fa-cube"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Maximum Available Quantity</h4>
                        </div>
                        <div class="card-body">
                            {{ $maqCount }}
                        </div>
                        <span class="fas fa-arrow-right"></span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-12 col-lg-4">
                <div class="card card-statistic-1" onclick="click_modal_expired()" style="cursor: pointer;">
                    <div class="card-icon bg-icon">
                        <i class="fa fa-hourglass-end"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Expired Stock</h4>
                        </div>
                        <div class="card-body">
                            {{ $expiredDateCount }}
                        </div>
                        <span class="fas fa-arrow-right"></span>
                    </div>
                </div>
            </div>
            <!-- <div class="col-12 col-md-12 col-lg-4">
          <div class="card">
            <div class="card-body d-flex flex-wrap align-items-center justify-content-between">
              <div class="left-info">
                <span class="text-muted">Expired Stock</span>
                <div style="font-size: 18px; color: black;"><span><b>32</b></span></div>
              </div>
              <div class="right-icon">
                <i class="fa fa-hourglass-end" style="font-size: 24px; color: #0A9447;"></i>
              </div>
            </div>
          </div>
        </div> -->
            @if ($notifCount != 0)
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card card-hero">
                        <div class="card-header">
                            <div class="card-icon">
                                <i class="far fa-bell"></i>
                            </div>
                            @if ($notifCount >= 99)
                                <h4>99+ <span class="badge rounded-pill bg-danger">Unread</span></h4>
                            @else
                                <h4>{{ $notifCount }} <span class="badge rounded-pill bg-danger">Unread</span></h4>
                            @endif
                            <div class="card-description">Notifications</div>
                        </div>
                        <div class="card-body p-0">
                            <div class="tickets-list">
                                @foreach ($notifList as $notif)
                                    <a href="{{ $notif->fv_link }}" class="ticket-item handle-notification"
                                        data-notificationCode="{{ $notif->fc_notificationcode }}">
                                        <div class="ticket-title col-lg-12 col-md-12 col-sm-12 col-12">
                                            <h4>{{ $notif->fc_tittle }}</h4>
                                            <div class="text-dark">
                                                <p>{{ $notif->fc_message }}</p>
                                            </div>
                                        </div>
                                        <div class="ticket-info col-lg-12 col-md-12 col-sm-12 col-12">
                                            <div>{{ $notif->fc_notiftype }}</div>
                                            <div class="bullet"></div>
                                            <div class="text-primary">
                                                {{ Carbon::parse($notif->fd_notifdate)->diffForHumans() }}</div>
                                        </div>
                                    </a>
                                @endforeach
                                <a href="/view-all-notif" class="ticket-item ticket-more">
                                    View All <i class="fas fa-chevron-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card card-hero">
                        <div class="card-header">
                            <div class="card-icon">
                                <i class="far fa-bell"></i>
                            </div>
                            <h4>{{ $notifCount }}</h4>
                            <div class="card-description">Notifications</div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('modal')
    <div class="modal fade" role="dialog" id="modal_moq" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header br">
                    <h5 class="modal-title">Minimum Available Quantity</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="" autocomplete="off">
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="tb_moq" width="100%">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-center">No</th>
                                        <th scope="col" class="text-center">Kode Barang</th>
                                        <th scope="col" class="text-center">Nama Barang</th>
                                        <th scope="col" class="text-center">Brand</th>
                                        <th scope="col" class="text-center">Sub Group</th>
                                        <th scope="col" class="text-center">Tipe Stock</th>
                                        <th scope="col" class="text-center">Satuan</th>
                                        <th scope="col" class="text-center">Expired Date</th>
                                        <th scope="col" class="text-center">Batch</th>
                                        <th scope="col" class="text-center">Qty Reorder</th>
                                        <th scope="col" class="text-center">Qty</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </form>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" role="dialog" id="modal_maq" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header br">
                    <h5 class="modal-title">Maximum Available Quantity</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="" autocomplete="off">
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="tb_maq" width="100%">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-center">No</th>
                                        <th scope="col" class="text-center">Kode Barang</th>
                                        <th scope="col" class="text-center">Nama Barang</th>
                                        <th scope="col" class="text-center">Brand</th>
                                        <th scope="col" class="text-center">Sub Group</th>
                                        <th scope="col" class="text-center">Tipe Stock</th>
                                        <th scope="col" class="text-center">Satuan</th>
                                        <th scope="col" class="text-center">Expired Date</th>
                                        <th scope="col" class="text-center">Batch</th>
                                        <th scope="col" class="text-center">Qty Max On Hand</th>
                                        <th scope="col" class="text-center">Qty</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </form>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" role="dialog" id="modal_expired" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header br">
                    <h5 class="modal-title">Expired Stocks</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="" autocomplete="off">
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="tb_expired" width="100%">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-center">No</th>
                                        <th scope="col" class="text-center">Kode Barang</th>
                                        <th scope="col" class="text-center">Nama Barang</th>
                                        <th scope="col" class="text-center">Brand</th>
                                        <th scope="col" class="text-center">Sub Group</th>
                                        <th scope="col" class="text-center">Tipe Stock</th>
                                        <th scope="col" class="text-center">Satuan</th>
                                        <th scope="col" class="text-center">Expired Date</th>
                                        <th scope="col" class="text-center">Batch</th>
                                        <th scope="col" class="text-center">Qty</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </form>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

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

        .card .fas.fa-arrow-right {
            position: absolute;
            right: -20px;
            top: 10px;
            bottom: -100px;
            background-color: #0A9447;
            height: 40px;
            width: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            color: white;
            opacity: 0;
            transform: translateY(50%);
            transition: all 0.5s ease;
        }

        .card:hover .fas.fa-arrow-right {
            bottom: 0px;
            opacity: 1;
        }

        .bg-icon {
            background-color: #0000000d;
        }

        .fa.fa-cube,
        .fa.fa-hourglass-end {
            color: #0A9447;
            font-size: 24px;
        }

        .card:hover .bg-icon,
        .card:hover .fa.fa-cube,
        .card:hover .fa.fa-hourglass-end {
            color: white;
            background-color: #0A9447;
        }
    </style>
@endsection

@section('js')
    <script>
        function click_modal_expired() {
            $('#modal_expired').modal('show');
        }

        function click_modal_maq() {
            $('#modal_maq').modal('show');
        }

        function click_modal_moq() {
            $('#modal_moq').modal('show');
        }


        $(document).ready(function() {
            $('.handle-notification').click(function(event) {
                event.preventDefault();

                var notificationCode = $(this).data('notificationcode');
                var url = $(this).attr('href');

                $.ajax({
                    url: '/reading-notification-click',
                    type: 'POST',
                    data: {
                        fc_notificationcode: notificationCode,
                        fv_url: url
                    },
                    success: function(response) {
                        if (response.status == 200) {
                            // arahkan ke response.link
                            window.location = response.link;
                        } else {
                            swal(response.message, {
                                icon: 'error',
                            });
                        }
                    },
                    error: function(xhr) {
                        swal(response.message, {
                            icon: 'error',
                        });
                        console.log('Terjadi kesalahan saat mengirim data');
                    }
                });
            });
        });

        var tb_expired = $('#tb_expired').DataTable({
            processing: true,
            serverSide: true,
            pageLength: 5,
            ajax: {
                url: '/dashboard/datatable/expired',
                type: 'GET'
            },
            columnDefs: [{
                    className: 'text-center',
                    targets: [0, 7]
                },
                // {
                //     className: 'text-nowrap',
                //     targets: [11]
                // },
            ],
            columns: [{
                    data: 'DT_RowIndex',
                    searchable: false,
                    orderable: false
                },
                {
                    data: 'stock.fc_stockcode'
                },
                {
                    data: 'stock.fc_namelong'
                },
                {
                    data: 'stock.fc_brand'
                },
                {
                    data: 'stock.fc_subgroup'
                },
                {
                    data: 'stock.fc_typestock1'
                },
                {
                    data: 'stock.fc_namepack',
                },
                {
                    data: 'fd_expired'
                },
                {
                    data: 'fc_batch'
                },
                {
                    data: 'fn_quantity'
                },
            ],
        });

        var tb_moq = $('#tb_moq').DataTable({
            processing: true,
            serverSide: true,
            pageLength: 5,
            ajax: {
                url: '/dashboard/datatable/moq',
                type: 'GET'
            },
            columnDefs: [{
                    className: 'text-center',
                    targets: [0, 7]
                },
                // {
                //     className: 'text-nowrap',
                //     targets: [11]
                // },
            ],
            columns: [{
                    data: 'DT_RowIndex',
                    searchable: false,
                    orderable: false
                },
                {
                    data: 'stock.fc_stockcode'
                },
                {
                    data: 'stock.fc_namelong'
                },
                {
                    data: 'stock.fc_brand'
                },
                {
                    data: 'stock.fc_subgroup'
                },
                {
                    data: 'stock.fc_typestock1'
                },
                {
                    data: 'stock.fc_namepack',
                },
                {
                    data: 'fd_expired'
                },
                {
                    data: 'fc_batch'
                },
                {
                    data: 'fn_reorderlevel'
                },
                {
                    data: 'fn_quantity'
                },
            ],
        });

        var tb_maq = $('#tb_maq').DataTable({
            processing: true,
            serverSide: true,
            pageLength: 5,
            ajax: {
                url: '/dashboard/datatable/maq',
                type: 'GET'
            },
            columnDefs: [{
                    className: 'text-center',
                    targets: [0, 7]
                },
                // {
                //     className: 'text-nowrap',
                //     targets: [11]
                // },
            ],
            columns: [{
                    data: 'DT_RowIndex',
                    searchable: false,
                    orderable: false
                },
                {
                    data: 'stock.fc_stockcode'
                },
                {
                    data: 'stock.fc_namelong'
                },
                {
                    data: 'stock.fc_brand'
                },
                {
                    data: 'stock.fc_subgroup'
                },
                {
                    data: 'stock.fc_typestock1'
                },
                {
                    data: 'stock.fc_namepack',
                },
                {
                    data: 'fd_expired'
                },
                {
                    data: 'fc_batch'
                },
                {
                    data: 'fn_maxonhand'
                },
                {
                    data: 'fn_quantity'
                },
            ],
        });
    </script>
@endsection
