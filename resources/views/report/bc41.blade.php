@extends('layouts.app')

@section('style.page.level.plugins')
<link href="{{ url('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('assets/global/plugins/bootstrap-markdown/css/bootstrap-markdown.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('assets/global/plugins/bootstrap-toastr/toastr.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('assets/global/plugins/sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css" />
@stop

@section('script.page.level.plugins')
<script src="{{ url('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/global/plugins/jquery-validation/js/jquery.validate.min.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/global/plugins/jquery-validation/js/additional-methods.min.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/global/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/global/plugins/sweetalert/sweetalert.min.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js') }}" type="text/javascript"></script>
@stop

@section('script.page.level')
{{-- <script src="{{ url('assets/pages/scripts/components-select2.js') }}" type="text/javascript"></script> --}}
<script src="{{ url('assets/pages/scripts/table-report-datatables-ajax.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/pages/scripts/form-validation.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/pages/scripts/ui-toastr.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/pages/scripts/components-date-time-pickers.js') }}" type="text/javascript"></script>
@stop



@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="note note-danger">
            <p> NOTE: The below datatable is not connected to a real database so the filter and sorting is just simulated for demo purposes only. </p>
        </div>
        <!-- Begin: life time stats -->
        <div class="portlet light portlet-fit portlet-datatable bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-folder font-dark"></i>
                    <span class="caption-subject font-dark sbold uppercase">BC 4.1</span>
                </div>
                <div class="actions">
                    {{-- <div class="btn-group">
                        <button id="add-new" class="btn sbold green"> Add New
                            <i class="fa fa-plus"></i>
                        </button>
                    </div>
                    <div class="btn-group">
                        <button id="btn-back" class="btn sbold default">Back To List
                        </button>
                    </div> --}}
                    <div class="btn-group">
                        <a class="btn red btn-outline" href="javascript:;" data-toggle="dropdown">
                            <i class="fa fa-share"></i>
                            <span class="hidden-xs"> Tools </span>
                            <i class="fa fa-angle-down"></i>
                        </a>
                        <ul class="dropdown-menu pull-right" id="datatable_ajax_tools">
                            <li>
                                <a href="javascript:;" data-action="0" class="tool-action">
                                    <i class="icon-printer"></i> Print</a>
                            </li>
                            <li>
                                <a href="javascript:;" data-action="1" class="tool-action">
                                    <i class="icon-check"></i> Copy</a>
                            </li>
                            <li>
                                <a href="javascript:;" data-action="2" class="tool-action">
                                    <i class="icon-doc"></i> PDF</a>
                            </li>
                            <li>
                                <a href="javascript:;" data-action="3" class="tool-action">
                                    <i class="icon-paper-clip"></i> Excel</a>
                            </li>
                            <li>
                                <a href="javascript:;" data-action="4" class="tool-action">
                                    <i class="icon-cloud-upload"></i> CSV</a>
                            </li>
                            <li class="divider"> </li>
                            <li>
                                <a href="javascript:;" data-action="5" class="tool-action">
                                    <i class="icon-refresh"></i> Reload</a>
                            </li>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-toolbar">
                    {{-- <div class="row">
                        <div class="col-md-6">
                            <div class="btn-group">
                                <button id="btn-table-filter" class="btn sbold white"> Filter
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div> --}}
                </div>
                <div class="table-container">
                    <div class="row margin-bottom-10">
                        <div class="col-md-6">
                            <div class="btn-group">
                                <button id="btn-table-filter" class="btn sbold white"> Filter
                                    <i class="fa fa-chevron-circle-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="row margin-bottom-20">
                        <div id="form_filter">
                            {{-- Begin Form --}}
                            {{ Form::open(array('url' => '', 'method' => 'POST', 'id'=>'', 'class'=>'', 'data-controller' => 'stock/1')) }}
                            {{-- {{ Form::create([‘method’ => ‘PUT’]) }} --}}
                            <div class="form-body">
                                <div class="form-group col-md-3">
                                     {{ Form::label('filter_no_transc', 'Code #', array('class'=>'control-label capitalize')) }}
                                     {{ Form::text('filter_no_transc', '' ,array('class'=>'form-control')) }}
                                </div>

                            </div>
                            <div class="form-actions">
                                <div class="col-md-12">
                                        {{ Form::button('Submit', array('class' => 'btn green table-filter-action-submit')) }}
                                        {{ Form::button('Reset', array('class' => 'btn default reset-form')) }}
                                </div>
                            </div>
                            
                            {{ Form::close() }}
                            {{-- End Form --}}
                        </div>
                    </div>
                
                    <div class="table-actions-wrapper">
                        <span> </span>
                        <select class="table-group-action-input form-control input-inline input-small input-sm select2">
                            <option value="">Select...</option>
                            <option value="delete">Delete</option>
                        </select>
                        <button class="btn btn-sm green table-group-action-submit">
                            <i class="fa fa-check"></i> Submit</button>
                    </div>
                    <table class="table table-striped table-bordered table-hover dt-responsive table-checkable" width="100%" id="datatable_ajax"  data-table="report/7">
                        <thead>
                            <tr role="row" class="heading">

                                <th class="all" width="10%">No BPB.</th>
                                <th class="desktop">Date Transc.</th>
                                <th class="min-tablet">No BC</th>
                                <th class="none">Date BC</th>
                                {{-- <th class="none">Type BC</th> --}}
                                <th class="desktop">Code Mat.</th>
                                <th class="desktop">Code Comp.</th>
                                <th class="none">Qty</th>
                                <th class="none">Unit</th>
                                <th class="none">Price</th>
                                <th class="none">Curr</th>
                                <th class="desktop">No Inv</th>
                                <th class="desktop">No PO</th>
                                <th class="desktop">No SO</th>
                                {{-- <th class="none">Type Transc.</th> --}}
                                {{-- <th class="all text-center"> Actions </th> --}}

                            </tr>
                            
                        </thead>
                        <tbody> </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- End: life time stats -->
    </div>
</div>
@stop