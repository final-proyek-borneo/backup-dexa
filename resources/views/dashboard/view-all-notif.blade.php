@extends('partial.app')
@section('title', 'Notifications')
@php
    use App\Helpers\App;
    use Carbon\Carbon;
    
    $dateRecent = \Carbon\Carbon::now()
        ->subDays(1)
        ->toDateTimeString();
    $notifListRecent = \App\Models\NotificationMaster::with('notifdtl')
        ->whereHas('notifdtl', function ($query) {
            $query->where('fc_userid', auth()->user()->fc_userid);
            // ->whereNull('fd_watchingdate');
        })
        ->where('fd_notifdate', '>=', $dateRecent)
        ->orderBy('fd_notifdate', 'DESC')
        //->limit(5)
        ->get();
    
    $notifRecentCount = \App\Models\NotificationMaster::with('notifdtl')
        ->whereHas('notifdtl', function ($query) {
            $query->where('fc_userid', auth()->user()->fc_userid)->whereNull('fd_watchingdate');
        })
        ->where('fd_notifdate', '>=', $dateRecent)
        ->orderBy('fd_notifdate', 'DESC')
        ->count();
    
    // $dateEarlier = \Carbon\Carbon::today()->subDays(7);
    $dateEarlier = \Carbon\Carbon::now()
        ->subDays(1)
        ->toDateTimeString();
    $notifListEarlier = \App\Models\NotificationMaster::with('notifdtl')
        ->whereHas('notifdtl', function ($query) {
            $query->where('fc_userid', auth()->user()->fc_userid);
            // ->whereNull('fd_watchingdate');
        })
        ->where('fd_notifdate', '<=', $dateEarlier)
        ->orderBy('fd_notifdate', 'DESC')
        ->get();
    
    $notifEarlierCount = \App\Models\NotificationMaster::with('notifdtl')
        ->whereHas('notifdtl', function ($query) {
            $query->where('fc_userid', auth()->user()->fc_userid)->whereNull('fd_watchingdate');
        })
        ->where('fd_notifdate', '<=', $dateEarlier)
        ->orderBy('fd_notifdate', 'DESC')
        ->count();
    
@endphp

@section('css')
    <style>
        .card.card-statistic-1 .card-icon {
            width: 100px;
            height: 100px;
        }

        .card.card-statistic-1 .card-header {
            padding-top: 20px;
        }

        .left-icon {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .d-flex {
            gap: 20px;
        }

        .notif-content:hover {
            text-decoration: none;
        }

        .card .card-body:hover {
            background-color: #f8f4fc;
        }

        .card .card-header h4 {
            color: black;
        }
    </style>
@endsection

@section('content')
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Baru</h4> <span class="badge rounded-pill bg-danger text-white">{{ $notifRecentCount }}</span>
                    </div>
                    @foreach ($notifListRecent as $notif)
                        @php
                            $status = $icon = $notif->notifdtl->where('fc_userid', auth()->user()->fc_userid)->first()->fd_watchingdate === null ? 'Belum dibaca' : 'Telah dibaca';
                            $icon = $notif->notifdtl->where('fc_userid', auth()->user()->fc_userid)->first()->fd_watchingdate === null ? 'fa-book-open' : 'fa-check';
                            $bgColorClass = $notif->notifdtl->where('fc_userid', auth()->user()->fc_userid)->first()->fd_watchingdate === null ? 'bg-warning text-white' : 'bg-success text-white';
                        @endphp
                        <a href="{{ $notif->fv_link }}" class="notif-content handle-notification"
                            data-notificationCode="{{ $notif->fc_notificationcode }}">
                            <div class="card-body d-flex flex-wrap align-items-center">
                                <div class="left-icon {{ $bgColorClass }}">
                                    <i class="fas {{ $icon }}" style="font-size: 18px;"></i>
                                </div>
                                <div class="right-info">
                                    <b style="font-size: 16px; color:black;">{{ $notif->fc_tittle }}</b>
                                    <div class="notification" style="font-size: 14px; font-weight:500; color:black">
                                        {{ $notif->fc_message }}</div>
                                    <div class="text-muted" style="font-size: 12px; margin-top: 5px; font-weight:500">
                                        {{ Carbon::parse($notif->fd_notifdate)->diffForHumans() }}
                                        <div class="bullet"></div> <i>{{ $status }}</i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Terdahulu</h4> <span
                            class="badge rounded-pill bg-danger text-white">{{ $notifEarlierCount }}</span>
                    </div>
                    @foreach ($notifListEarlier as $notif)
                        @php
                            $status = $icon = $notif->notifdtl->where('fc_userid', auth()->user()->fc_userid)->first()->fd_watchingdate === null ? 'Belum dibaca' : 'Telah dibaca';
                            $icon = $notif->notifdtl->where('fc_userid', auth()->user()->fc_userid)->first()->fd_watchingdate === null ? 'fa-book-open' : 'fa-check';
                            $bgColorClass = $notif->notifdtl->where('fc_userid', auth()->user()->fc_userid)->first()->fd_watchingdate === null ? 'bg-warning text-white' : 'bg-success text-white';
                        @endphp
                        <a href="{{ $notif->fv_link }}" class="notif-content handle-notification"
                            data-notificationCode="{{ $notif->fc_notificationcode }}">
                            <div class="card-body d-flex flex-wrap align-items-center">
                                <div class="left-icon {{ $bgColorClass }}">
                                    <i class="fas {{ $icon }}" style="font-size: 18px;"></i>
                                </div>
                                <div class="right-info">
                                    <b style="font-size: 16px; color:black;">{{ $notif->fc_tittle }}</b>
                                    <div class="notification" style="font-size: 14px; font-weight:500; color:black">
                                        {{ $notif->fc_message }}</div>
                                    <div class="text-muted" style="font-size: 12px; margin-top: 5px; font-weight:500">
                                        {{ Carbon::parse($notif->fd_notifdate)->diffForHumans() }}
                                        <div class="bullet"></div> <i>{{ $status }}</i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modal')

@endsection

@section('js')
    <script>
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
    </script>
@endsection
