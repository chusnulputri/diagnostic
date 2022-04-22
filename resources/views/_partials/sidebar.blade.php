<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                    <div class="row" style="padding: 0px 0px 30px 10px; border-bottom: 2px solid var(--primary)">
                        <div class="col-md-12" style="text-align: left; padding: 2px 5px 0px 7px;">
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <table width="100%">
                                    <td width="28%">
                                        <img alt="image" class="img img-responsive" width="40px;"
                                            style="border-radius: 5px;"
                                            src="{{ asset('assets/default/user-female.png') }}" />
                                    </td>

                                    <td>
                                        <span class="font-bold" style="color: var(--primaryColor); font-size: 9pt;">
                                            {{ Auth::user()->name }}
                                        </span>
                                        <span class="text-muted block"
                                            style="color: rgba(255, 255, 255, 0.4) !important; margin-top: 3px; font-size: 8pt;">
                                            as ADMIN SISTEM
                                            <i class="fa fa-caret-down"></i>
                                        </span>
                                    </td>
                                </table>
                            </a>
                        </div>
                    </div>
                    <div class="logo-element">
                        PD
                    </div>
            </li>
            <li class="{{ Request::is('admin-area') ? 'active' : '' }}">
                <a href="{{url('/admin-area')}}">
                    <i class="fa fa-users fa-fw"></i>
                    <span class="nav-label">Data Pengunjung</span>
                </a>
            </li>
            <li class="{{ Request::is('admin-area/hasil-diagnosa') ? 'active' : '' }}">
                <a href="{{url('/admin-area/hasil-diagnosa')}}">
                    <i class="fa fa-laptop-medical fa-fw"></i>
                    <span class="nav-label">Data Hasil Diagnosa</span>
                </a>
            </li>
            <li class="{{ Request::is('admin-area/hasil-gejala') ? 'active' : '' }}">
                <a href="{{url('/admin-area/hasil-gejala')}}">
                    <i class="fa fa-book-medical fa-fw"></i>
                    <span class="nav-label">Data Gejala</span>
                </a>
            </li>
            <li class="{{ Request::is('admin-area/hasil-penyakit') ? 'active' : '' }}">
                <a href="{{url('/admin-area/hasil-penyakit')}}">
                    <i class="fa fa-file-medical fa-fw"></i>
                    <span class="nav-label">Data Penyakit</span>
                </a>
            </li>
             <li class="{{ Request::is('admin-area/hasil-rule') ? 'active' : '' }}">
                <a href="{{url('/admin-area/hasil-rule')}}">
                    <i class="fa fa-file-medical fa-fw"></i>
                    <span class="nav-label">Data Rule</span>
                </a>
            </li>
           <!-- <li class="{{ Request::is('admin-area/hasil-kasus') ? 'active' : '' }}">
                <a href="{{url('/admin-area/hasil-kasus')}}">
                    <i class="fa fa-heartbeat fa-fw"></i>
                    <span class="nav-label">Data Kasus</span>
                </a>
            </li> -->
        </ul>
    </div>
</nav>
