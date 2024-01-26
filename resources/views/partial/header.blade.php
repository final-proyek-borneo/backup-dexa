@php
    use App\Helpers\App;
    use Carbon\Carbon;

    $notifList = \App\Models\NotificationMaster::with('notifdtl')
    ->whereHas('notifdtl', function ($query) {
    $query->where('fc_userid', auth()->user()->fc_userid);
    //->whereNull('fd_watchingdate');
    })
    ->orderBy('fd_notifdate', 'DESC')
    ->limit(5)
    ->get();

    $notifHeader = \App\Models\NotificationMaster::with('notifdtl')
    ->whereHas('notifdtl', function ($query) {
    $query->where('fc_userid', auth()->user()->fc_userid);
    //->whereNull('fd_watchingdate');
    })
    ->orderBy('fd_notifdate', 'DESC')
    ->limit(5)
    ->count();

    $notifCount = \App\Models\NotificationDetail::whereHas('notifmst', function($query){
    $query->where('fc_status','=','R');
    })
    ->where('fc_userid', auth()->user()->fc_userid)
    ->whereNull('fd_watchingdate')
    ->count();

@endphp

<nav class="navbar navbar-expand-lg main-navbar">

  <form class="form-inline mr-auto">
    <ul class="navbar-nav mr-3">
      <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
    </ul>
    <!-- <div class="searchBox">
      <input class="searchInput" type="text" placeholder="Search">
      <a href="#">
        <button class="searchButton" type="submit" fdprocessedid="61zokb"><i class="fas fa-search" style="font-size: 16px;"></i></button>
      </a>
    </div> -->
  </form>
  <form class="form-inline ml-auto">
    <ul class="navbar-nav">
      <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="fas fa-search"></i></a></li>
    </ul>
    <div class="search-element">
      <input class="form-control" type="search" placeholder="Cari" aria-label="Cari" data-width="250" style="width: 250px;">
      <button class="btn" type="submit"><i class="fas fa-search" style="color: #0A9447"></i></button>
      <div class="search-backdrop"></div>
      <div class="search-result"></div>
    </div>
  </form>
  <ul class="navbar-nav navbar-right">

    <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown" class="notif nav-link notification-toggle nav-link-lg" aria-expanded="false">
        @if($notifCount != 0)
        <i class="far fa-bell" style="font-size: 20px;"></i>
        @if($notifCount >= 99)
        <span class="badge-notification bg-danger">99+</span></a>
      @else
      <span class="icon-badge bg-danger">{{ $notifCount }}</span></a>
      @endif
      @else
      <i class="far fa-bell" style="font-size: 20px;"></i></a>
      @endif
      <div class="dropdown-menu dropdown-list dropdown-menu-right">
        <div class="dropdown-header">Notifications
          <!-- <div class="float-right">
            <a href="#">Mark All As Read</a>
          </div> -->
        </div>
        @if($notifHeader != 0)
        <div class="dropdown-list-content dropdown-list-icons" style="overflow: hidden; outline: none;" tabindex="3">
          @foreach($notifList as $notif)
          @php
          $notifDetail = $notif->notifdtl->where('fc_userid', auth()->user()->fc_userid)->first();
          $status = $notifDetail && $notifDetail->fd_watchingdate === null ? 'Belum dibaca' : 'Telah dibaca';
          $icon = $notifDetail && $notifDetail->fd_watchingdate === null ? 'fa-book-open' : 'fa-check';
          $bgColorClass = $notifDetail && $notifDetail->fd_watchingdate === null ? 'bg-warning text-white' : 'bg-success text-white';
          @endphp
          @if ($status == 'Belum dibaca')
          <a href="{{ $notif->fv_link }}" class="dropdown-item dropdown-item-unread" data-notificationCode="{{ $notif->fc_notificationcode }}">
            <div class="dropdown-item-icon {{ $bgColorClass }}">
              <i class="fas {{ $icon }}"></i>
            </div>
            <div class="dropdown-item-desc">
              <b>{{ $notif->fc_tittle }}</b>
              <div class="time">{{ Carbon::parse($notif->fd_notifdate)->diffForHumans() }}</div>
            </div>
            <p><i>{{ $status }}</i></p>
          </a>
          @else
          <a href="{{ $notif->fv_link }}" class="dropdown-item item-read-notification" data-notificationCode="{{ $notif->fc_notificationcode }}">
            <div class="dropdown-item-icon {{ $bgColorClass }}">
              <i class="fas {{ $icon }}"></i>
            </div>
            <div class="dropdown-item-desc">
              <b>{{ $notif->fc_tittle }}</b>
              <div class="time">{{ Carbon::parse($notif->fd_notifdate)->diffForHumans() }}</div>
            </div>
            <p><i>{{ $status }}</i></p>
          </a>
          @endif
          @endforeach
          @else
          <div class="dropdown-list-content-2 dropdown-list-icons" style="overflow: hidden; outline: none;" tabindex="3">
            <div class="container" style="overflow: hidden; outline: none; height: 100px">
              <p class="text-center" style="padding: 30px 0; font-size:14px; color: #6c757d">Tidak ada notifikasi.</p>
            </div>
          </div>
          @endif
        </div>
        @if($notifHeader != 0)
        <div class="dropdown-footer text-center">
          <a href="/view-all-notif" style="text-decoration: none;">View All <i class="fas fa-chevron-right"></i></a>
        </div>
        <div id="ascrail2002" class="nicescroll-rails nicescroll-rails-vr" style="width: 9px; z-index: 1000; cursor: default; position: absolute; top: 57.9861px; left: 341px; height: 350px; opacity: 0.3; display: none;">
          <div class="nicescroll-cursors" style="position: relative; top: 44px; float: right; width: 7px; height: 305px; background-color: rgb(66, 66, 66); border: 1px solid rgb(255, 255, 255); background-clip: padding-box; border-radius: 5px;"></div>
        </div>
        <div id="ascrail2002-hr" class="nicescroll-rails nicescroll-rails-hr" style="height: 9px; z-index: 1000; top: 398.986px; left: 0px; position: absolute; cursor: default; display: none; width: 341px; opacity: 0.3;">
          <div class="nicescroll-cursors" style="position: absolute; top: 0px; height: 7px; width: 350px; background-color: rgb(66, 66, 66); border: 1px solid rgb(255, 255, 255); background-clip: padding-box; border-radius: 5px; left: 0px;"></div>
        </div>
        @else
        @endif
    </li>
    <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
        <img alt="image" src="{{asset('assets/img/avatar/avatar-1.png')}}" class="rounded-circle mr-1">
        <div class="d-sm-none d-lg-inline-block">Hi, {{ auth()->user()->fc_username }}</div>
      </a>
      <div class="dropdown-menu dropdown-menu-right">
        <a href="/change-password" class="dropdown-item has-icon">
          <i class="far fa-user"></i> Change Password
        </a>
        <div class="dropdown-divider"></div>
        <a href="/logout" class="dropdown-item has-icon text-danger">
          <i class="fas fa-sign-out-alt"></i> Logout
        </a>
      </div>
    </li>
  </ul>

  <style>
    .dropdown-list-content-2 {
      height: 100px;
    }

    .dropdown-list .dropdown-header {
      font-weight: bold;
    }
  </style>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>

    $(document).ready(function() {
      $('.item-read-notification').on('click', function(event) {
        event.preventDefault();

        var notificationCode = $(this).data('notificationcode');
        var url = $(this).attr('href');

        $.ajax({
          url: '/reading-notification-click',
          method: 'POST',
          data: {
            fc_notificationcode: notificationCode,
            fv_url: url
          },
          dataType: 'json',
          success: function(response) {
            if (response.status === 200) {
              window.location.href = response.link;
            } else {
              swal(response.message, {
                icon: 'error'
              });
            }
          },
          error: function() {
            swal('Terjadi kesalahan saat mengirim data', {
              icon: 'error'
            });
          }
        });
      });
});

  $(document).ready(function() {
    $('.search-element input').on('input', function() {
      var query = $(this).val();

      $.ajax({
        url: "{{ route('search-menu') }}",
        method: 'GET',
        data: { query: query },
        success: function(response) {
          var results = response.data; // response berupa array untuk key data

          var searchResults = $('.search-result');
          searchResults.empty();
          console.log(results.length);
          if (results.length > 0) {
            for (var i = 0; i < results.length; i++) {
              var result = results[i];
              var searchItem = $('<div class="search-item"></div>');
              var link = $('<a href="' + result.url + '">' + result.name + '</a>');
              var closeButton = $('<a href="#" class="search-close"><i class="fas fa-times"></i></a>');

              searchItem.append(link, closeButton);
              searchResults.append(searchItem);
            }
          } else {
            var noResultsItem = $('<div class="search-item">Tidak ada hasil pencarian.</div>');
           searchResults.append(noResultsItem);
          }
        },
        error: function() {
          console.log('Terjadi Kesalahan.');
        }
      });
    });
  });




  </script>
</nav>
<div class="main-sidebar">
  <aside id="sidebar-wrapper">
    <div class="sidebar-brand mb-4">
      {{-- <a href="/dashboard">DEXA</a> --}}
      <a href="/dashboard">
        <img src="{{ asset('/assets/img/logo-dexa.png') }}" alt="logo" width="160" class="mb-4 mt-3">
      </a>
    </div>
    <?php
    $url_menu = Request::segment(1);
    $url_submenu = Request::segment(2);
    $usr = Auth::guard('web')->user();
    ?>
    <ul class="sidebar-menu">
      <li class="menu-header">Dashboard</li>
      <li class="nav-item dropdown @if($url_menu == " dashboard") active @endif"><a href="/dashboard" class="nav-link"><i class="fas fa-home"></i><span>Dashboard</span></a></li>

      @foreach (App::get_master_menu() as $key => $parent)
      <li class="menu-header">{{ $key }}</li>
      @foreach ($parent as $item)
      @if (isset($item['submenu']))
      <li class="nav-item dropdown @if($url_menu == $item['menu']) active @endif">
        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="{{ $item['icon'] }}"></i></i> <span>{{ $item['nama'] }}</span></a>
        <ul class="dropdown-menu">
          @foreach ($item['submenu'] as $submenu)
          {{-- cek jika submenu['nama'] sama dengan nama permission maka jangan tampilkan --}}
          @if (isset($submenu['nama']) && $usr->can($submenu['nama']))
          <li class="@if($url_menu == $submenu['menu'] && $url_submenu == $submenu['submenu']) active @endif"><a class="nav-link" href="{{ $submenu['link'] }}">{{ $submenu['nama'] }}</a></li>
          @endif
          @endforeach
        </ul>
      </li>
      @else
      <li class="nav-item dropdown @if($url_menu == $item['menu'] && $url_submenu == $item['submenu_parent']) active @endif"><a href="{{ $item['link'] }}" class="nav-link"><i class="{{ $item['icon'] }}"></i><span>{{ $item['nama'] }}</span></a></li>
      @endif
      @endforeach
      @endforeach
    </ul>

  </aside>
</div>