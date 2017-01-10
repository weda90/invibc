var TableDatatablesAjax = function () {

    var initPickers = function () {
        //init date pickers
        $('.date-picker').datepicker({
            rtl: App.isRTL(),
            autoclose: true
        });
    }

    var handleRecords = function () {
        var table = $('#datatable_ajax');
        var ajaxURL = ajax+table.attr('data-table');

        var oTable = table.dataTable({
            // Internationalisation. For more info refer to http://datatables.net/manual/i18n
            "language": {
                "aria": {
                    "sortAscending": ": activate to sort column ascending",
                    "sortDescending": ": activate to sort column descending"
                },
                "emptyTable": "No data available in table",
                "info": "Showing _START_ to _END_ of _TOTAL_ entries",
                "infoEmpty": "No entries found",
                "infoFiltered": "(filtered1 from _MAX_ total entries)",
                "lengthMenu": "_MENU_ entries",
                "search": "Search:",
                "zeroRecords": "No matching records found",
                "metronicAjaxRequestGeneralError": "Could not complete request. Please check your internet connection",
            },

            // Or you can use remote translation file
            //"language": {
            //   url: '//cdn.datatables.net/plug-ins/3cfcc339e89/i18n/Portuguese.json'
            //},

            serverSide: true,

            "ajax": {
                "type": "GET",
                "url": ajaxURL, // ajax source
                "error": function() { // handle general connection errors
                    /*if (tableOptions.onError) {
                        tableOptions.onError.call(undefined, the);
                    }*/

                    // console.log(oTable.fnSettings().oLanguage.metronicAjaxRequestGeneralError);

                    App.alert({
                        type: 'danger',
                        icon: 'warning',
                        message: oTable.fnSettings().oLanguage.metronicAjaxRequestGeneralError,
                        container: tableWrapper,
                        place: 'prepend'
                    });

                    App.unblockUI(tableContainer);

                    // console.log('error');
                }
            },

            // setup buttons extension: http://datatables.net/extensions/buttons/
            

             buttons: [
                    { extend: 'print', className: 'btn default' },
                    { extend: 'copy', className: 'btn default' },
                    { extend: 'pdf', className: 'btn default' },
                    { extend: 'excel', className: 'btn default' },
                    { extend: 'csv', className: 'btn default' },
                    {
                        text: 'Reload',
                        className: 'btn default',
                        action: function ( e, dt, node, config ) {
                            dt.ajax.reload();
                            alert('Datatable reloaded!');
                        }
                    }
                ],

            // setup responsive extension: http://datatables.net/extensions/responsive/
            responsive: true,


            // scroller extension: http://datatables.net/extensions/scroller/
            // scrollY:        300,
            // deferRender:    true,
            // scroller:       true,
            // deferRender:    true,
            // scrollX:        true,
            // scrollCollapse: true,        

            stateSave:      true,

            /*fixedColumns:   {
                leftColumns: 1,
                rightColumns: 1
            },*/

            "orderCellsTop": true,

            "pagingType": "bootstrap_extended",

            "order": [
                [0, 'asc']
            ],
            
            "lengthMenu": [
                [10, 15, 20, -1],
                [10, 15, 20, "All"] // change per page values here
            ],
            // set the initial value
            "pageLength": 10,

            "dom": "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12 text-right'p>>", // horizobtal scrollable datatable

            // Uncomment below line("dom" parameter) to fix the dropdown overflow issue in the datatable cells. The default datatable layout
            // setup uses scrollable div(table-scrollable) with overflow:auto to enable vertical scroll(see: assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js). 
            // So when dropdowns used the scrollable div should be removed. 
            //"dom": "<'row' <'col-md-12'T>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r>t<'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",
        });

        // get table wrapper
        tableWrapper = table.parents('.dataTables_wrapper');
        tableContainer = table.parents(".table-container");

        oTable.DataTable().button().container().hide();

         // handle datatable custom tools
        $('#datatable_ajax_tools > li > a.tool-action').on('click', function() {
            var action = $(this).attr('data-action');
            oTable.DataTable().button(action).trigger();
        });
        
    }

    function getData(){
        $('a.edit-datatable').click(function(event) {
            /* Act on the event */
            $('button#add-new').hide();
            $('button#btn-back').show();
            $('.table-container').slideUp();
            $('form#form_sample_2').slideDown();
            $('input[name=code]',$('form#form_sample_2')).val($(this).attr('data-put'));

            $('form#form_sample_2').attr('method','PUT');

            var obj = {};
            var controller = $(this).attr('data-controller');
            var action = $(this).attr('data-action');
            var code = $(this).attr('data-code');

            $.ajax({
                url: ajax+controller+'/'+code,
                type: 'GET',
                dataType: 'json',
                data: obj,
            })
            .done(function(data) {

                var inputForm = $('input.form-control, select.form-control, textarea.form-control',$('form#form_sample_2'));
                var arr = Object.keys(data).map(function(key) { return data[key] });
                var i = 0;
                inputForm.each(function(index, el) {
                    $(this).val( arr[i++] );
                });

                inputForm.first().attr('disabled',true);
                $('button[type=submit]',$('form#form_sample_2')).attr('data-action','put');
                // console.log($('button[type=submit]',$('form#form_sample_2')));

                
            })
            .fail(function(jqXHR, textStatus, error) {
                // console.log("error");
            })
            .always(function() {
                // console.log("complete");
            });

        });
    }

    function deleteData(data){


        var controller = data.attr('data-controller');
        var action = data.attr('data-action');
        var code = data.attr('data-code');
        var tr = data.parent().parent();

        // console.log(data.parent().parent());

        // console.log(host+'/api/'+controller+'/'+action+'/'+code);

        $.ajax({
            url: ajax+controller+'/'+code,
            type: 'DELETE',
            dataType: 'json',
        })
        .done(function(data) {

            var arr = Object.keys(data).map(function(key) { return data[key] });

            if (arr[0] === 1) {
                tr.remove();
            }
            
        })
        .fail(function(jqXHR, textStatus, error) {
            /*console.log(jqXHR);
            console.log(textStatus);
            console.log(error);*/
        })
        .always(function(data) {

            if (data.toastr !== undefined) {
                toastrNotif(data.toastr);
            }

        });
    }

    function confirmButton(){

        // $('[data-toggle="confirmation"]').confirmation();
        $('.delete-datatable').confirmation();
        $('.delete-datatable').on('confirmed.bs.confirmation', function () {
            // alert('You confirmed action #1');
            // console.log($(this));

            deleteData($(this));
            $('button#btn-back').click();
        });/*

        $('.delete-datatable').on('canceled.bs.confirmation', function () {
            alert('You canceled action #1');
        });*/
    }

    function toastrNotif(data){

        toastr.options = {
              "closeButton": true,
              "debug": false,
              "positionClass": "toast-top-right",
              "onclick": null,
              "showDuration": "1000",
              "hideDuration": "1000",
              "timeOut": "5000",
              "extendedTimeOut": "1000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
            }

        toastr[data.type](data.message);
    }

    var initTable3 = function () {
        var table = $('#sample_3');

        // var dataURL = ajax+$("#sample_3").attr('data-table');

        var oTable = table.dataTable({

            // Internationalisation. For more info refer to http://datatables.net/manual/i18n
            "language": {
                "aria": {
                    "sortAscending": ": activate to sort column ascending",
                    "sortDescending": ": activate to sort column descending"
                },
                "emptyTable": "No data available in table",
                "info": "Showing _START_ to _END_ of _TOTAL_ entries",
                "infoEmpty": "No entries found",
                "infoFiltered": "(filtered1 from _MAX_ total entries)",
                "lengthMenu": "_MENU_ entries",
                "search": "Search:",
                "zeroRecords": "No matching records found",
                "metronicAjaxRequestGeneralError": "Could not complete request. Please check your internet connection",
            },

            // Or you can use remote translation file
            //"language": {
            //   url: '//cdn.datatables.net/plug-ins/3cfcc339e89/i18n/Portuguese.json'
            //},

            serverSide: true,

            "ajax": {
                "type": "GET",
                "url": host+'/api/compan', // ajax source
                "error": function() { // handle general connection errors
                    /*if (tableOptions.onError) {
                        tableOptions.onError.call(undefined, the);
                    }*/

                    // console.log(oTable.fnSettings().oLanguage.metronicAjaxRequestGeneralError);

                    App.alert({
                        type: 'danger',
                        icon: 'warning',
                        message: oTable.fnSettings().oLanguage.metronicAjaxRequestGeneralError,
                        container: tableWrapper,
                        place: 'prepend'
                    });

                    App.unblockUI(tableContainer);

                    // console.log('error');
                }
            },

            // setup buttons extension: http://datatables.net/extensions/buttons/
            

             buttons: [
                    { extend: 'print', className: 'btn default' },
                    { extend: 'copy', className: 'btn default' },
                    { extend: 'pdf', className: 'btn default' },
                    { extend: 'excel', className: 'btn default' },
                    { extend: 'csv', className: 'btn default' },
                    {
                        text: 'Reload',
                        className: 'btn default',
                        action: function ( e, dt, node, config ) {
                            dt.ajax.reload();
                            alert('Datatable reloaded!');
                        }
                    }
                ],

            // setup responsive extension: http://datatables.net/extensions/responsive/
            // responsive: true,


            // scroller extension: http://datatables.net/extensions/scroller/
            // scrollY:        300,
            // deferRender:    true,
            // scroller:       true,
            deferRender:    true,
            scrollX:        true,
            scrollCollapse: true,        

            stateSave:      true,

            fixedColumns:   {
                leftColumns: 1,
                rightColumns: 1
            },

            "orderCellsTop": true,

            "pagingType": "bootstrap_extended",

            "order": [
                [0, 'asc']
            ],
            
            "lengthMenu": [
                [10, 15, 20, -1],
                [10, 15, 20, "All"] // change per page values here
            ],
            // set the initial value
            "pageLength": 10,

            "dom": "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12 text-right'p>>", // horizobtal scrollable datatable

            // Uncomment below line("dom" parameter) to fix the dropdown overflow issue in the datatable cells. The default datatable layout
            // setup uses scrollable div(table-scrollable) with overflow:auto to enable vertical scroll(see: assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js). 
            // So when dropdowns used the scrollable div should be removed. 
            //"dom": "<'row' <'col-md-12'T>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r>t<'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",
        });

        // get table wrapper
        tableWrapper = table.parents('.dataTables_wrapper');
        tableContainer = table.parents(".table-container");

        oTable.DataTable().button().container().hide();

        // oTable.DataTable().button().disable();

        // console.log(oTable.DataTable().button().container());

         // handle datatable custom tools
        $('#datatable_ajax_tools > li > a.tool-action').on('click', function() {
            var action = $(this).attr('data-action');
            oTable.DataTable().button(action).trigger();
        });
    }

    var initTable = function(){
        var table = $('#sample_3');

    }

    

    return {

        //main function to initiate the module
        init: function () {

            initPickers();
            handleRecords();
            initTable3();
            
        }

    };

}();

jQuery(document).ready(function() {
    TableDatatablesAjax.init();
});