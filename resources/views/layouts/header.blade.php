<header class="page-header">
    <nav class="navbar mega-menu" role="navigation">
        <div class="container-fluid">
            <div class="clearfix navbar-fixed-top">
                <!-- Brand and toggle get grouped for better mobile display -->
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="toggle-icon">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </span>
                </button>
                <!-- End Toggle Button -->
                <!-- BEGIN LOGO -->
                <a id="index" class="page-logo" href="index.html">
                    <img src="{{ url('assets/layouts/layout5/img/logo.png') }}" alt="Logo"> </a>
                <!-- END LOGO -->
                <!-- BEGIN SEARCH -->
                {{-- <form class="search" action="extra_search.html" method="GET">
                    <input type="name" class="form-control" name="query" placeholder="Search...">
                    <a href="javascript:;" class="btn submit md-skip">
                        <i class="fa fa-search"></i>
                    </a>
                </form> --}}
                <!-- END SEARCH -->
                <!-- BEGIN TOPBAR ACTIONS -->
                <div class="topbar-actions">
                    <!-- BEGIN GROUP NOTIFICATION -->
                    {{-- <div class="btn-group-notification btn-group" id="header_notification_bar">
                        <button type="button" class="btn btn-sm md-skip dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                            <i class="icon-bell"></i>
                            <span class="badge">7</span>
                        </button>
                        <ul class="dropdown-menu-v2">
                            <li class="external">
                                <h3>
                                    <span class="bold">12 pending</span> notifications</h3>
                                <a href="#">view all</a>
                            </li>
                            <li>
                                <ul class="dropdown-menu-list scroller" style="height: 250px; padding: 0;" data-handle-color="#637283">
                                    <li>
                                        <a href="javascript:;">
                                            <span class="details">
                                                <span class="label label-sm label-icon label-success md-skip">
                                                    <i class="fa fa-plus"></i>
                                                </span> New user registered. </span>
                                            <span class="time">just now</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                            <span class="details">
                                                <span class="label label-sm label-icon label-danger md-skip">
                                                    <i class="fa fa-bolt"></i>
                                                </span> Server #12 overloaded. </span>
                                            <span class="time">3 mins</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                            <span class="details">
                                                <span class="label label-sm label-icon label-warning md-skip">
                                                    <i class="fa fa-bell-o"></i>
                                                </span> Server #2 not responding. </span>
                                            <span class="time">10 mins</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                            <span class="details">
                                                <span class="label label-sm label-icon label-info md-skip">
                                                    <i class="fa fa-bullhorn"></i>
                                                </span> Application error. </span>
                                            <span class="time">14 hrs</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                            <span class="details">
                                                <span class="label label-sm label-icon label-danger md-skip">
                                                    <i class="fa fa-bolt"></i>
                                                </span> Database overloaded 68%. </span>
                                            <span class="time">2 days</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                            <span class="details">
                                                <span class="label label-sm label-icon label-danger md-skip">
                                                    <i class="fa fa-bolt"></i>
                                                </span> A user IP blocked. </span>
                                            <span class="time">3 days</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                            <span class="details">
                                                <span class="label label-sm label-icon label-warning md-skip">
                                                    <i class="fa fa-bell-o"></i>
                                                </span> Storage Server #4 not responding dfdfdfd. </span>
                                            <span class="time">4 days</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                            <span class="details">
                                                <span class="label label-sm label-icon label-info md-skip">
                                                    <i class="fa fa-bullhorn"></i>
                                                </span> System Error. </span>
                                            <span class="time">5 days</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                            <span class="details">
                                                <span class="label label-sm label-icon label-danger md-skip">
                                                    <i class="fa fa-bolt"></i>
                                                </span> Storage server failed. </span>
                                            <span class="time">9 days</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div> --}}
                    <!-- END GROUP NOTIFICATION -->
                    <!-- BEGIN GROUP INFORMATION -->
                    {{-- <div class="btn-group-red btn-group">
                        <button type="button" class="btn btn-sm md-skip dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                            <i class="fa fa-plus"></i>
                        </button>
                        <ul class="dropdown-menu-v2" role="menu">
                            <li class="active">
                                <a href="#">New Post</a>
                            </li>
                            <li>
                                <a href="#">New Comment</a>
                            </li>
                            <li>
                                <a href="#">Share</a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="#">Comments
                                    <span class="badge badge-success">4</span>
                                </a>
                            </li>
                            <li>
                                <a href="#">Feedbacks
                                    <span class="badge badge-danger">2</span>
                                </a>
                            </li>
                        </ul>
                    </div> --}}
                    <!-- END GROUP INFORMATION -->
                    <!-- BEGIN USER PROFILE -->
                    @include('layouts.userProfile')
                    <!-- END USER PROFILE -->
                    <!-- BEGIN QUICK SIDEBAR TOGGLER -->
                    {{-- <button type="button" class="quick-sidebar-toggler md-skip" data-toggle="collapse">
                        <span class="sr-only">Toggle Quick Sidebar</span>
                        <i class="icon-logout"></i>
                    </button> --}}
                    <!-- END QUICK SIDEBAR TOGGLER -->
                </div>
                <!-- END TOPBAR ACTIONS -->
            </div>
            <!-- BEGIN HEADER MENU -->
            @include('layouts.menu')
            <!-- END HEADER MENU -->
        </div>
        <!--/container-->
    </nav>
</header>