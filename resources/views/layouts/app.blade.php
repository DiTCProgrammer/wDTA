<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>DTA | Dharmniti Time Attendance</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.6 -->
        <link rel="stylesheet" href="{{url('assets/bootstrap/css/bootstrap.min.css')}}">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="{{url('assets/dist/css/AdminLTE.min.css')}}">
        <!-- AdminLTE Skins. Choose a skin from the css/skins
             folder instead of downloading all of them to reduce the load. -->
        <link rel="stylesheet" href="{{url('assets/dist/css/skins/_all-skins.min.css')}}"> 
        <!-- iCheck -->
        <link rel="stylesheet" href="{{url('assets/plugins/iCheck/flat/blue.css')}}">
        <!-- Morris chart -->
        <link rel="stylesheet" href="{{url('assets/plugins/morris/morris.css')}}">
        <!-- jvectormap -->
        <link rel="stylesheet" href="{{url('assets/plugins/jvectormap/jquery-jvectormap-1.2.2.css')}}">
        <!-- Date Picker -->
        <link rel="stylesheet" href="{{url('assets/plugins/datepicker/datepicker3.css')}}">
        <!-- Daterange picker -->
        <link rel="stylesheet" href="{{url('assets/plugins/daterangepicker/daterangepicker-bs3.css')}}">
        <!-- bootstrap wysihtml5 - text editor -->
        <link rel="stylesheet" href="{{url('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')}}">

        <link rel="stylesheet" href="{{url('assets/dist/css/dcta.css')}}">
        <link rel="stylesheet" href="{{url('assets/dist/css/sweetalert.css')}}">
        @yield('css')

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">

            <header class="main-header">
                <!-- Logo -->
                <a href="index2.html" class="logo hidden">
                    <!-- mini logo for sidebar mini 50x50 pixels -->
                    <span class="logo-mini"><b>D</b>TA</span>
                    <!-- logo for regular state and mobile devices -->
                    <span class="logo-lg"><b>Dharmniti Time Attendance</b> V.1.0.1</span>
                </a>
                <!-- Header Navbar: style can be found in header.less -->
                <nav class="navbar navbar-static-top">
                    <!-- Sidebar toggle button-->
                    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                        <span class="sr-only">Toggle navigation</span>
                    </a>

                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">

                            <!-- User Account: style can be found in dropdown.less -->
                            <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    @if (Session::has('myuser'))
                                    @if (Auth::user()->privilege == '100' || Auth::user()->privilege == '99')
                                    <img src="{{ url('images/admin.png') }}" class="user-image" alt="User Image">
                                    @elseif (Session::get('myuser')->picture != '')
                                    <img src="{{ url('file/'.Auth::user()->company_id.'/employee/'.Session::get('myuser')->picture) }}" class="user-image" alt="User Image">
                                    @else
                                    <img src="{{ url('images/no_img.png') }}" class="user-image" alt="User Image">
                                    @endif
                                    @endif
                                    <span class="hidden-xs">
                                        @if (Auth::user())
                                        {{ Auth::user()->name }}
                                        @else
                                        No Name
                                        @endif
                                    </span>
                                </a>
                                <ul class="dropdown-menu">
                                    <!-- User image -->
                                    <li class="user-header">
                                        @if (Session::has('myuser'))
                                        @if (Auth::user()->privilege == '100' || Auth::user()->privilege == '99')
                                        <img src="{{ url('images/admin.png') }}" class="user-image" alt="User Image">
                                        @elseif (Session::get('myuser')->picture != '')
                                        <img src="{{ url('file/'.Auth::user()->company_id.'/employee/'.Session::get('myuser')->picture) }}" class="user-image" alt="User Image">
                                        @else
                                        <img src="{{ url('images/no_img.png') }}" class="user-image" alt="User Image">
                                        @endif
                                        @endif

                                        <p>
                                            @if (Auth::user())

                                            {{ Auth::user()->name }}

                                            <br />

                                            @if (Auth::user()->privilege == 0)
                                            {{ trans('menu.priv_0') }}
                                            @elseif (Auth::user()->privilege == 1)
                                            {{ trans('menu.priv_1') }}
                                            @elseif (Auth::user()->privilege == 2)
                                            {{ trans('menu.priv_2').' '.Auth::user()->dept_name }}
                                            @elseif (Auth::user()->privilege == 3)
                                            {{ trans('menu.priv_3') }}
                                            @elseif (Auth::user()->privilege == 4)
                                            {{ trans('menu.priv_4') }}
                                            @elseif (Auth::user()->privilege == 99)
                                            {{ trans('menu.priv_99') }}
                                            @elseif (Auth::user()->privilege == 100)
                                            {{ trans('menu.priv_100') }}
                                            @endif

                                            @endif

                                            <small>
                                                @if (Auth::user())
                                                @if (Auth::user()->privilege == 99 || Auth::user()->privilege == 100 )
                                                {{ trans('menu.priv_99') }} 
                                                @else
                                                {{ Auth::user()->dept_name }} 
                                                @endif
                                                @endif
                                            </small>
                                        </p>
                                    </li>
                                    <li class="user-footer">
                                        <!--                                        <div class="pull-left">
                                                                                    <a href="#" class="btn btn-default btn-flat">{{ trans('menu.profile') }}</a>
                                                                                </div>-->
                                        <div class="pull-right">
                                            <a href="{{ url('/logout') }}" class="btn btn-default btn-flat">{{ trans('menu.logout') }}</a>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <!-- Languages -->
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle text-red" data-toggle="dropdown">
                                    {{ Config::get('languages')[App::getLocale()] }}
                                </a>
                                <ul class="dropdown-menu">
                                    @foreach (Config::get('languages') as $lang => $language)
                                    @if ($lang != App::getLocale())
                                    <li>
                                        <a href="{{ route('lang.switch', $lang) }}">{{$language}}</a>
                                    </li>
                                    @endif
                                    @endforeach
                                </ul>
                            </li>
                            <!-- Control Sidebar Toggle Button -->
                            <!--                            <li>
                                                            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                                                        </li>-->
                        </ul>
                    </div>
                </nav>
            </header>
            <!-- Left side column. contains the logo and sidebar -->
            <a href="../../../Users/Suphawet Fuangdang/AppData/Local/Temp/Dharmniti Time Attendance DHARMNITI Time Attendance V 2.0.URL"></a>
            <aside class="main-sidebar">

                <!-- Ditc Add Header Logo ---->  
                <section class="ditc_header_logo">
                    <div class="box_header_logo">
                        <a href="index.html" title="Dharmniti Time Attendance Version 2.0">
                            <div class="header_logo_img">
                                <img  src="{{url('assets/dist/img/DTA-Logo-3.png')}}" alt="Dharmniti Time Attendance">
                            </div>
                            <!--                            <div class="header_logo_name">
                                                            <span>DHARMNITI</span>
                                                            <span>Time Attendance</span>
                                                            <span>V 1.0</span>
                                                        </div>-->
                        </a>
                    </div>
                </section>

                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">

                    <!-- Sidebar user panel -->
                    <div class="user-panel">
                        <div class="pull-left image">
                            @if (Session::has('myuser'))
                            @if (Auth::user()->privilege == '100' || Auth::user()->privilege == '99')
                            <img src="{{ url('images/admin.png') }}" class="img-circle" alt="User Image">
                            @elseif (Session::get('myuser')->picture != '')
                            <img src="{{ url('file/'.Auth::user()->company_id.'/employee/'.Session::get('myuser')->picture) }}" class="img-circle" alt="User Image">
                            @else
                            <img src="{{ url('images/no_img.png') }}" class="img-circle" alt="User Image">
                            @endif
                            @endif
                        </div>
                        <div class="pull-left info">
                            <p>{{ trans('menu.welcome') }}</p>
                            <p>
                                @if (Auth::user())
                                {{ Auth::user()->name }}
                                @endif
                            </p>
                        </div>
                    </div>

                    <!--- Ditc Position -->
                    <div class="user_position">
                        <span>
                            @if (Auth::user())

                            @if (Auth::user()->privilege == 0)
                            {{ trans('menu.priv_0') }}
                            @elseif (Auth::user()->privilege == 1)
                            {{ trans('menu.priv_1') }}
                            @elseif (Auth::user()->privilege == 2)
                            {{ trans('menu.priv_2').' '.Auth::user()->dept_name }}
                            @elseif (Auth::user()->privilege == 3)
                            {{ trans('menu.priv_3') }}
                            @elseif (Auth::user()->privilege == 4)
                            {{ trans('menu.priv_4') }}
                            @elseif (Auth::user()->privilege == 99)
                            {{ trans('menu.priv_99') }}
                            @elseif (Auth::user()->privilege == 100)
                            {{ trans('menu.priv_100') }}
                            @endif

                            @endif

                        </span>
                    </div>



                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu">
                        <li class="home treeview">
                            <a href="{{url('')}}">
                                <i class="fa fa-dashboard"></i> <span>{{ trans('menu.home') }}</span>
                            </a>
                        </li>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-files-o"></i>
                                <span>{{ trans('menu.dataoverview') }}</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                @if (Auth::user()->privilege == 100 || Auth::user()->privilege == 99 || Auth::user()->privilege == 4 || Auth::user()->privilege == 3 || Auth::user()->privilege == 2)
                                <li><a href="{{ url('/dataoverview') }}">{{ trans('menu.persinformation') }}</a></li>
                                @endif
                                @if (Auth::user()->privilege == 100 || Auth::user()->privilege == 4 || Auth::user()->privilege == 3 || Auth::user()->privilege == 2 || Auth::user()->privilege == 1)
                                <li><a href="{{ url('/dataoverview/myinformation')}}">{{ trans('menu.myinformation') }}</a></li>
                                @endif
                            </ul>
                        </li>
                        <li class="persabsence treeview">
                            <a href="#">
                                <i class="fa fa-th"></i> 
                                <span>{{ trans('menu.absmanagement') }}</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                @if (Auth::user()->privilege == 100 || Auth::user()->privilege == 99 || Auth::user()->privilege == 4 || Auth::user()->privilege == 3 || Auth::user()->privilege == 2)
                                <li class="persabsence"><a href="{{ url('/persabsence') }}">{{ trans('menu.abshr') }}</a></li>
                                @endif
                                @if (Auth::user()->privilege == 100 || Auth::user()->privilege == 4 || Auth::user()->privilege == 3 || Auth::user()->privilege == 2 || Auth::user()->privilege == 1)
                                <li><a href="{{ url('/persabsence/myabsence') }}">{{ trans('menu.absmy') }}</a></li>
                                @endif
                            </ul>
                        </li>
                        @if (Auth::user()->privilege == 100 || Auth::user()->privilege == 99 || Auth::user()->privilege == 3)
                        <li class="delete upload treeview">
                            <a href="#">
                                <i class="fa fa-th"></i> 
                                <span>{{ trans('menu.attendencemanagement') }}</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="upload delete treeview-menu">
                                <li class="upload"><a href="{{ url('/upload') }}">{{ trans('menu.upload') }}</a></li>
                                <li class="delete"><a href="{{ url('/delete') }}">{{ trans('menu.delete') }}</a></li>
                            </ul>
                        </li>
                        @endif
                        
                        @if (Auth::user()->privilege == 100 || Auth::user()->privilege == 99 || Auth::user()->privilege == 3 || Auth::user()->privilege == 2)
                        <li class="employee holiday weekend absence scheduletime department company treeview">
                            <a href="#">
                                <i class="fa fa-pie-chart"></i>
                                <span>{{ trans('menu.setting') }}</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class=" treeview-menu">
                                @if (Auth::user()->privilege == 100 || Auth::user()->privilege == 99 || Auth::user()->privilege == 3)
                                <li class="employee"><a href="{{ url('/employee') }}">{{ trans('menu.employee') }}</a></li>
                                @endif
                                <li class="holiday"><a href="{{url('/holiday')}}">{{ trans('menu.holiday') }}</a></li>
                                <li class="weekend"><a href="{{ url('/weekend') }}">{{ trans('menu.weekend') }}</a></li>
                                @if (Auth::user()->privilege == 100 || Auth::user()->privilege == 99 || Auth::user()->privilege == 3)
                                <li class="absence"><a href="{{ url('/absence') }}">{{ trans('menu.abs') }}</a></li>
                                <li class="scheduletime"><a href="{{ url('/scheduletime') }}">{{ trans('menu.scheduletime') }}</a></li>
                                <li class="department"><a href="{{ url('/department') }}">{{ trans('menu.department') }}</a></li>
                                <li class="company"><a href="{{ url('/company') }}">{{ trans('menu.company') }}</a></li>
                                @endif
                            </ul>
                        </li>
                        @endif

                        <li class="export header">Report</li>
                        @if (Auth::user()->privilege == 100 || Auth::user()->privilege == 99 || Auth::user()->privilege == 4 || Auth::user()->privilege == 3 || Auth::user()->privilege == 2)
                        <li><a href="{{ url('/export') }}"><i class="fa fa-circle-o text-red"></i> <span>{{ trans('menu.expoertexcel') }}</span></a></li>
                        @endif
                    </ul>
                </section>
                <!-- /.sidebar -->

                <!---- aside Footer ---->
                <section class="contact_footer">
                    <!--                    <div class="tel">
                                            <a>{{ trans('menu.contactus') }} : 02-555-0999</a>
                                        </div>-->

                    <nav class="social ">
                        <ul>
                            <li><a href="" title="Facebook"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                            <li><a href="" title="Twitter"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                            <li><a href="" title="Instagram"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                            <li><a href="" title="Youtube"><i class="fa fa-youtube-play" aria-hidden="true"></i></a></li>
                        </ul>
                    </nav>
                </section>
            </aside>



            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <section class="content">

                    @yield('content')


                </section>

            </div>
            <!-- /.content-wrapper -->
            <footer class="main-footer">
                <div class="pull-right hidden-xs">
                    <b>Version</b> 1.0.1
                </div>
                <strong>Copyright &copy; 2016 <a href="http://ditc.co.th" target="_Blank">DHARMNITI Time & Attendance</a>.</strong> All rights
                reserved.
            </footer>

            <!-- Control Sidebar -->
            <aside class="control-sidebar control-sidebar-dark">
                <!-- Create the tabs -->
                <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
                    <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
                    <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content">
                    <!-- Home tab content -->
                    <div class="tab-pane" id="control-sidebar-home-tab">
                        <h3 class="control-sidebar-heading">Recent Activity</h3>
                        <ul class="control-sidebar-menu">
                            <li>
                                <a href="javascript:void(0)">
                                    <i class="menu-icon fa fa-birthday-cake bg-red"></i>

                                    <div class="menu-info">
                                        <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>

                                        <p>Will be 23 on April 24th</p>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0)">
                                    <i class="menu-icon fa fa-user bg-yellow"></i>

                                    <div class="menu-info">
                                        <h4 class="control-sidebar-subheading">Frodo Updated His Profile</h4>

                                        <p>New phone +1(800)555-1234</p>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0)">
                                    <i class="menu-icon fa fa-envelope-o bg-light-blue"></i>

                                    <div class="menu-info">
                                        <h4 class="control-sidebar-subheading">Nora Joined Mailing List</h4>

                                        <p>nora@example.com</p>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0)">
                                    <i class="menu-icon fa fa-file-code-o bg-green"></i>

                                    <div class="menu-info">
                                        <h4 class="control-sidebar-subheading">Cron Job 254 Executed</h4>

                                        <p>Execution time 5 seconds</p>
                                    </div>
                                </a>
                            </li>
                        </ul>
                        <!-- /.control-sidebar-menu -->

                        <h3 class="control-sidebar-heading">Tasks Progress</h3>
                        <ul class="control-sidebar-menu">
                            <li>
                                <a href="javascript:void(0)">
                                    <h4 class="control-sidebar-subheading">
                                        Custom Template Design
                                        <span class="label label-danger pull-right">70%</span>
                                    </h4>

                                    <div class="progress progress-xxs">
                                        <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0)">
                                    <h4 class="control-sidebar-subheading">
                                        Update Resume
                                        <span class="label label-success pull-right">95%</span>
                                    </h4>

                                    <div class="progress progress-xxs">
                                        <div class="progress-bar progress-bar-success" style="width: 95%"></div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0)">
                                    <h4 class="control-sidebar-subheading">
                                        Laravel Integration
                                        <span class="label label-warning pull-right">50%</span>
                                    </h4>

                                    <div class="progress progress-xxs">
                                        <div class="progress-bar progress-bar-warning" style="width: 50%"></div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0)">
                                    <h4 class="control-sidebar-subheading">
                                        Back End Framework
                                        <span class="label label-primary pull-right">68%</span>
                                    </h4>

                                    <div class="progress progress-xxs">
                                        <div class="progress-bar progress-bar-primary" style="width: 68%"></div>
                                    </div>
                                </a>
                            </li>
                        </ul>
                        <!-- /.control-sidebar-menu -->

                    </div>
                    <!-- /.tab-pane -->
                    <!-- Stats tab content -->
                    <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
                    <!-- /.tab-pane -->
                    <!-- Settings tab content -->
                    <div class="tab-pane" id="control-sidebar-settings-tab">
                        <form method="post">
                            <h3 class="control-sidebar-heading">General Settings</h3>

                            <div class="form-group">
                                <label class="control-sidebar-subheading">
                                    Report panel usage
                                    <input type="checkbox" class="pull-right" checked>
                                </label>

                                <p>
                                    Some information about this general settings option
                                </p>
                            </div>
                            <!-- /.form-group -->

                            <div class="form-group">
                                <label class="control-sidebar-subheading">
                                    Allow mail redirect
                                    <input type="checkbox" class="pull-right" checked>
                                </label>

                                <p>
                                    Other sets of options are available
                                </p>
                            </div>
                            <!-- /.form-group -->

                            <div class="form-group">
                                <label class="control-sidebar-subheading">
                                    Expose author name in posts
                                    <input type="checkbox" class="pull-right" checked>
                                </label>

                                <p>
                                    Allow the user to show his name in blog posts
                                </p>
                            </div>
                            <!-- /.form-group -->

                            <h3 class="control-sidebar-heading">Chat Settings</h3>

                            <div class="form-group">
                                <label class="control-sidebar-subheading">
                                    Show me as online
                                    <input type="checkbox" class="pull-right" checked>
                                </label>
                            </div>
                            <!-- /.form-group -->

                            <div class="form-group">
                                <label class="control-sidebar-subheading">
                                    Turn off notifications
                                    <input type="checkbox" class="pull-right">
                                </label>
                            </div>
                            <!-- /.form-group -->

                            <div class="form-group">
                                <label class="control-sidebar-subheading">
                                    Delete chat history
                                    <a href="javascript:void(0)" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
                                </label>
                            </div>
                            <!-- /.form-group -->
                        </form>
                    </div>
                    <!-- /.tab-pane -->
                </div>
            </aside>
            <!-- /.control-sidebar -->
            <!-- Add the sidebar's background. This div must be placed
                 immediately after the control sidebar -->
            <div class="control-sidebar-bg"></div>

        </div>
        @yield('popup')
        <!-- ./wrapper -->

        <!-- jQuery 2.2.0 -->
        <script src="{{url('assets/plugins/jQuery/jQuery-2.2.0.min.js')}}"></script>

        <!-- jQuery UI 1.11.4 -->
        <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
        <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
        <script>
$.widget.bridge('uibutton', $.ui.button);
$(function () {
    var pathArray = window.location.pathname.split('/');

    if (pathArray[3] != '') {
        $('.' + pathArray[3]).addClass('active');
    } else {
        $('.home').addClass('active');
    }
});
        </script>
        <!-- Bootstrap 3.3.6 -->
        <script src="{{url('assets/bootstrap/js/bootstrap.min.js')}}"></script>
        <!-- Morris.js charts -->
        <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>-->
        <!--<script src="{{url('assets/plugins/morris/morris.min.js')}}"></script>-->
        <!-- Sparkline -->
        <!--<script src="{{url('assets/plugins/sparkline/jquery.sparkline.min.js')}}"></script>-->
        <!-- jvectormap -->
        <!--<script src="{{url('assets/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js')}}"></script>-->
        <!--<script src="{{url('assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js')}}"></script>-->
        <!-- jQuery Knob Chart -->
        <!--<script src="{{url('assets/plugins/knob/jquery.knob.js')}}"></script>-->
        <!-- daterangepicker -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
        <script src="{{url('assets/plugins/daterangepicker/daterangepicker.js')}}"></script>
        <!-- datepicker -->
        <script src="{{url('assets/plugins/datepicker/bootstrap-datepicker.js')}}"></script>
        <!-- Bootstrap WYSIHTML5 -->
        <script src="{{url('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')}}"></script>
        <!-- Slimscroll -->
        <!--<script src="{{url('assets/plugins/slimScroll/jquery.slimscroll.min.js')}}"></script>-->
        <!-- FastClick -->
<!--        <script src="{{url('assets/plugins/fastclick/fastclick.js')}}"></script>-->
        <!-- AdminLTE App -->
        <script src="{{url('assets/dist/js/app.min.js')}}"></script>
        <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!--        <script src="{{url('assets/dist/js/pages/dashboard.js')}}"></script>-->
        <!-- AdminLTE for demo purposes -->
        <script src="{{url('assets/dist/js/demo.js')}}"></script>
        <script src="{{url('assets/dist/js/sweetalert.min.js')}}"></script>
        @yield('footer')
    </body>
</html>
