@extends('layouts.app')


@section('style.page.level.plugins')
{{-- <link href="{{ url('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" /> --}}
{{-- <link href="{{ url('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css') }}" rel="stylesheet" type="text/css" /> --}}
{{-- <link href="{{ url('assets/global/plugins/morris/morris.css') }}" rel="stylesheet" type="text/css" /> --}}
<link href="{{ url('assets/global/plugins/fullcalendar/fullcalendar.min.css') }}" rel="stylesheet" type="text/css" />
{{-- <link href="{{ url('assets/global/plugins/jqvmap/jqvmap/jqvmap.css') }}" rel="stylesheet" type="text/css" /> --}}
@stop

@section('script.page.level.plugins')
{{-- <script src="{{ url('assets/global/scripts/datatable.js') }}" type="text/javascript"></script> --}}
<script src="{{ url('assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/global/plugins/counterup/jquery.waypoints.min.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/global/plugins/counterup/jquery.counterup.min.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/global/plugins/fullcalendar/fullcalendar.min.js') }}" type="text/javascript"></script>

<script src="{{ url('assets/global/plugins/flot/jquery.flot.min.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/global/plugins/flot/jquery.flot.resize.min.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/global/plugins/flot/jquery.flot.categories.min.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/global/plugins/flot/jquery.flot.pie.min.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/global/plugins/flot/jquery.flot.stack.min.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/global/plugins/flot/jquery.flot.crosshair.min.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/global/plugins/flot/jquery.flot.axislabels.js') }}" type="text/javascript"></script>

@stop

@section('script.page.level')
{{-- <script src="{{ url('assets/pages/scripts/components-select2.js') }}" type="text/javascript"></script> --}}
{{-- <script src="{{ url('assets/pages/scripts/table-report-datatables-ajax.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/pages/scripts/form-validation.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/pages/scripts/ui-toastr.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/pages/scripts/components-date-time-pickers.js') }}" type="text/javascript"></script> --}}
<script src="{{ url('assets/pages/scripts/dashboard.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/pages/scripts/charts-flotcharts.js') }}" type="text/javascript"></script>


@stop



@section('content')
    <div class="note note-info">
        <p> A black page template with a minimal dependency assets to use as a base for any custom page you create </p>
    </div>
    {{-- {{ dump(Config::get('database')) }} --}}
    {{-- {{ var_dump( get_class_methods(new Config)) }} --}}
    <!-- BEGIN DASHBOARD STATS 1-->
    {{-- {{ dump($stock_stat) }} --}}
    <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 blue" href="#">
                <div class="visual">
                    <i class="fa fa-comments"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="{{ $stock_stat['receiving'] }}">0</span>
                    </div>
                    <div class="desc"> Total Receiving </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 red" href="#">
                <div class="visual">
                    <i class="fa fa-bar-chart-o"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="{{ $stock_stat['outgoing'] }}">0</span></div>
                    <div class="desc"> Total Outgoing </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 green" href="#">
                <div class="visual">
                    <i class="fa fa-shopping-cart"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="{{ $stock_stat['balancing'] }}">0</span>
                    </div>
                    <div class="desc"> Total Balancing </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            {{-- <a class="dashboard-stat dashboard-stat-v2 purple" href="#">
                <div class="visual">
                    <i class="fa fa-globe"></i>
                </div>
                <div class="details">
                    <div class="number"> +
                        <span data-counter="counterup" data-value="89"></span>% </div>
                    <div class="desc"> Total Balancing </div>
                </div>
            </a> --}}
        </div>
    </div>
    <div class="clearfix"></div>
    <!-- END DASHBOARD STATS 1-->
    <div class="row">
        {{-- <div class="col-md-6 col-sm-6">
            <!-- BEGIN PORTLET-->
            <div class="portlet light calendar bordered">
                <div class="portlet-title ">
                    <div class="caption">
                        <i class="icon-calendar font-dark hide"></i>
                        <span class="caption-subject font-dark bold uppercase">Feeds</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <div id="calendar"> </div>
                </div>
            </div>
            <!-- END PORTLET-->
        </div> --}}
        <div class="col-md-12 col-sm-12">
            <!-- BEGIN STACK CHART CONTROLS PORTLET-->
            <div class="portlet light portlet-fit bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class=" icon-layers font-green"></i>
                        <span class="caption-subject font-green bold uppercase">Stack Chart Controls</span>
                    </div>
                    {{-- <div class="actions">
                        <a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">
                            <i class="icon-cloud-upload"></i>
                        </a>
                        <a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">
                            <i class="icon-wrench"></i>
                        </a>
                        <a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">
                            <i class="icon-trash"></i>
                        </a>
                    </div> --}}
                </div>
                <div class="portlet-body">
                    <div id="chart_5" style="height:350px;"> </div>
                    <div class="btn-toolbar margin-top-20 margin-bottom-20">
                        <div class="btn-group stackControls">
                            <input type="button" class="btn blue btn-outline" value="With stacking" />
                            <input type="button" class="btn red btn-outline" value="Without stacking" /> </div>
                        <div class="space5"> </div>
                        <div class="btn-group graphControls">
                            <input type="button" class="btn dark btn-outline" value="Bars" />
                            <input type="button" class="btn dark btn-outline" value="Lines" />
                            <input type="button" class="btn dark btn-outline" value="Lines with steps" /> </div>
                    </div>
                </div>
            </div>
            <!-- END STACK CHART CONTROLS PORTLET-->
        </div>
    </div>
@endsection
