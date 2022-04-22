<nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0;">
    <div class="navbar-header">
        <a class="navbar-minimalize minimalize-styl-2 btn" style="background: #9b00db; color: var(--sidebarActiveBg)"
            href="#"><i class="fa fa-bars"></i> </a>
        <!-- <form role="search" class="navbar-form-custom" action="search_results.html" style="float: right; width: 300px; padding-top: 10px;">
            <div class="form-group">
                <input style="background: #eee; height: 40px; font-size: 10pt; border-radius: 5px;" type="text" placeholder="Sedang mencari sesuatu ... " class="form-control" name="top-search" id="top-search">
            </div>
        </form> -->
        <span style="padding: 20px; display: inline-block;font-weight: bold;">
            DIAGNOSTIC APP
        </span>
    </div>

    <ul class="nav navbar-top-links navbar-right" style="padding-right: 20px;">
        <li class="dropdown">
            <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#"
                style="color: var(--sidebarActiveBg) !important;">
                <i class="fa fa-bell"></i> <span class="label label-danger" id="notification-count-text"
                    style="color: #ffff;border-radius:100px;">0</span>
            </a>
            <ul class="dropdown-menu dropdown-messages dropdown-menu-right">
                <div id="notification-body-nav">
                    <div id="empty-notification-nav"
                        class="d-flex align-items-center justify-content-center flex-column">
                        <img src="{{asset('assets/img/notification.png')}}" width="50px" class="mt-2 mb-3">
                        <div style="font-size:13px" class="pb-3">Tidak Ada Notifikasi</div>
                    </div>
                </div>
                <li class="d-none" id="more-nav-notification">
                    <div class="text-center link-block">
                        <a href="" class="dropdown-item">
                            <strong>Lihat Semua</strong>
                        </a>
                    </div>
                </li>
            </ul>
        </li>

        <li>
            <form id="logout-form" action="{{ route('auth.logout') }}" method="POST" class="">
                @csrf
                <a onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn btn-sm btn-light text-danger" href="{{ route('auth.logout') }}" style="font-weight:bold;">
                    Log Out &nbsp; <i class="fa fa-sign-out-alt"></i>
                </a>
            </form>
        </li>
    </ul>
</nav>
