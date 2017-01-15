var TableDatatablesResponsive = function () {

    var handleRecords = function () {
        var grid = new Datatable();
        var ajaxURL = ajax+$("#datatable_ajax").attr('data-table');

        var objFilter = {};
        var formFilter = $('#form_filter');

        var caption = $('.portlet-datatable .portlet-title .caption span.caption-subject').text();
        var titleExport = caption.toUpperCase()+' '+moment().format('D MMM, YYYY');
        
        // $.fn.dataTable.TableTools.defaults.aButtons = ;

        grid.init({
            src: $("#datatable_ajax"),
            onSuccess: function (grid, response) {
                // grid:        grid object
                // response:    json object of server side ajax response
                // execute some code after table records loaded
            },
            onError: function (grid) {
                // execute some code on network or other general error  
            },
            onDataLoad: function(grid) {
                // execute some code on ajax data load
            },
            loadingMessage: 'Loading...',
            dataTable: { // here you can define a typical datatable settings from http://datatables.net/usage/options 

                "language": {
                    "aria": {
                        "sortAscending": ": activate to sort column ascending",
                        "sortDescending": ": activate to sort column descending"
                    },
                    "emptyTable": "No data available in table",
                    "info": "Showing _START_ to _END_ of _TOTAL_ entries",
                    "infoEmpty": "No entries found",
                    "infoFiltered": "(filtered from _MAX_ total entries)",
                    "lengthMenu": "_MENU_ entries",
                    "search": "Search:",
                    "zeroRecords": "No matching records found"
                },

                // Uncomment below line("dom" parameter) to fix the dropdown overflow issue in the datatable cells. The default datatable layout
                // setup uses scrollable div(table-scrollable) with overflow:auto to enable vertical scroll(see: assets/global/scripts/datatable.js). 
                // So when dropdowns used the scrollable div should be removed. 
                
                // "dom": "<'row'<'col-md-8 col-sm-12'pli><'col-md-4 col-sm-12'<'table-group-actions pull-right'>>r>t<'row'<'col-md-8 col-sm-12'pli><'col-md-4 col-sm-12'>>",
                
                "bStateSave": true, // save datatable state(pagination, sort, etc) in cookie.

                "lengthMenu": [
                    [10, 20, 50, 100, 150, -1],
                    [10, 20, 50, 100, 150, "All"] // change per page values here
                ],
                "pageLength": 10, // default record count per page
                "ajax": {
                    "method": "GET",
                    "url": ajaxURL, // ajax source
                    // "data": objFilter,
                },
                "order": [
                    [1, "asc"]
                ],// set first column as a default sort by asc
            
                // Or you can use remote translation file
                //"language": {
                //   url: '//cdn.datatables.net/plug-ins/3cfcc339e89/i18n/Portuguese.json'
                //},

                responsive: {
                    details: {
                        renderer: function ( api, rowIdx ) {
                            // Select hidden columns for the given row
                            var data = api.cells( rowIdx, ':hidden' ).eq(0).map( function ( cell ) {
                                var header = $( api.column( cell.column ).header() );
                                // console.log(header);
                                if(header === undefined) {   // hidden columns
                                    return '';
                                } else {
                                    return '<li data-dtr-index="'+cell.column+'">'+
                                            '<span class="dtr-title">'+header.text()+':</span>'+
                                            '<span class="dtr-data">'+api.cell( cell ).data()+'</span>'+
                                            '</li>';
                                };
                            } ).toArray().join('');
              
                            return data ?
                                $('<ul/>').append( data ) :
                                false;
                        },
                        type: 'column',
                        target: '.detail-datatable'
                    }
                },
                columnDefs: [ {
                    "targets": [ 0, -1 ],
                    "orderable": false
                } ],

                buttons: [
                    { 
                        extend: 'print',
                        title : titleExport,
                        autoPrint: false,
                        exportOptions: {
                            columns: ':not(.sorting_disabled)',
                        },
                        customize: function ( win ) {
                            $(win.document.body).css({
                                background: 'none',
                                'font-size': '10pt'
                            });
                            $(win.document.body).find( 'table' )
                                .addClass( 'compact' )
                                .css( 'font-size', 'inherit' );
                            }

                    },
                    { 
                        extend: 'copy', 
                        exportOptions: {
                            columns: ':not(.sorting_disabled)',
                        }
                    },
                    { 
                        extend: 'pdf', 
                        download: 'open',
                        title: titleExport,
                        exportOptions: {
                            columns: ':not(.sorting_disabled)',
                        }
                    },
                    { 
                        extend: 'excel',
                        filename:  titleExport,
                        exportOptions: {
                            columns: ':not(.sorting_disabled)',
                        }, 
                    },
                    { 
                        extend: 'csv', 
                        filename:  titleExport,
                        exportOptions: {
                            columns: ':not(.sorting_disabled)',
                        }, 
                    },
                    {
                        text: 'Reload',
                        className: 'btn default',
                        action: function ( e, dt, node, config ) {
                            dt.ajax.reload();
                            // alert('Datatable reloaded!');
                        }
                    }
                ],

                "fnDrawCallback": function(oSetting) {
                    confirmButton();
                    getData();

                },

                "pagingType": 'bootstrap_extended', // pagination type

                "dom": "<'row margin-bottom-10'<'col-md-5 col-sm-12'l><'col-md-7 col-sm-12'<'table-group-actions pull-right'>>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>", // datatable layout

                // "dom": "<'row' <'col-md-12'>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>", // horizobtal scrollable datatable


            }
        });

        // console.log(grid);
        /*grid.init.on( 'responsive-display', function ( e, datatable, row, showHide, update ) {
            console.log( 'Details for row '+row.index()+' '+(showHide ? 'shown' : 'hidden') );
        } );*/

        $('.table-container').on('click', '.table-filter-action-submit', function(event) {
            /* Act on the event */
            grid.setAjaxParam("customActionType", "filter_action");
            grid.setAjaxParam("customActionName", "filter");
            $('input.form-control, select.form-control, textarea.form-control',formFilter).each(function(index, el) {
                grid.setAjaxParam($(this).attr('name'), $(this).val());
            });
            grid.getDataTable().ajax.reload();
            grid.clearAjaxParams();
        });

        // console.log(grid.getTableWrapper());

        // handle group actionsubmit button click
        grid.getTableWrapper().on('click', '.table-group-action-submit', function (e) {
            e.preventDefault();
            var action = $(".table-group-action-input", grid.getTableWrapper());
            if (action.val() != "" && grid.getSelectedRowsCount() > 0) {
                
                
                swal({
                    title: "Are you sure?",   
                    text: "You will not be able to recover this imaginary file!",   
                    type: "warning",   
                    showCancelButton: true,   
                    confirmButtonColor: "#DD6B55",   
                    confirmButtonText: "Yes, delete it!",   
                    closeOnConfirm: true 
                }, function(){   
                    grid.setAjaxParam("customActionType", "group_action");
                    grid.setAjaxParam("customActionName", action.val());
                    grid.setAjaxParam("id", grid.getSelectedRows());
                    grid.getDataTable().ajax.reload();
                    grid.clearAjaxParams();
                });
                
                

            } else if (action.val() == "") {
                App.alert({
                    type: 'danger',
                    icon: 'warning',
                    message: 'Please select an action',
                    container: grid.getTableWrapper(),
                    place: 'prepend'
                });
            } else if (grid.getSelectedRowsCount() === 0) {
                App.alert({
                    type: 'danger',
                    icon: 'warning',
                    message: 'No record selected',
                    container: grid.getTableWrapper(),
                    place: 'prepend'
                });
            }
        });

        //grid.setAjaxParam("customActionType", "group_action");
        //grid.getDataTable().ajax.reload();
        //grid.clearAjaxParams();

        // handle datatable custom tools
        $('#datatable_ajax_tools > li > a.tool-action').on('click', function() {
            var action = $(this).attr('data-action');
            grid.getDataTable().button(action).trigger();
        });

        $('button#btn-back').click(function(event) {
            /* Act on the event */
            // grid.setAjaxParam("customActionType", "group_action");
            grid.getDataTable().ajax.reload();
            // grid.clearAjaxParams();
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
                headers: {
                    'X-CSRF-TOKEN': token
                },
                type: 'GET',
                dataType: 'json',
                data: obj,
            })
            .done(function(data) {

                var inputForm = $('input.form-control, select.form-control, textarea.form-control',$('form#form_sample_2'));
                var arr = Object.keys(data).map(function(key) { return data[key] });
                var i = 0;


                inputForm.each(function(index, el) {

                    if ($(this).hasClass('select2')) {

                        var data = arr[i++];

                        // console.log(data);
                        // console.log($(this));

                        // $(this).append('<option value='+data+'>'+data+'</option>');
                        // $(this).append("<option value="+data+">"+data.replace(/\'/g,"")+"</option>");
                        // $(this).trigger('change');
                        // $(this).select2('val', data, true);

                        // console.log($(this).select2())
                        var option = new Option(data,data);
                        option.selected = true;

                        $(this).append(option);
                        $(this).trigger('change');
                        

                    }else{
                        $(this).val( arr[i++] );
                    }
                    
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

        /*console.log(data.parent().parent().parent());
        return false;*/

        var controller = data.attr('data-controller');
        var action = data.attr('data-action');
        var code = data.attr('data-code');
        var tr = data.parent().parent().parent();
        // var tr = data.parent().parent();

        // console.log(data.parent().parent());

        // console.log(host+'/api/'+controller+'/'+action+'/'+code);

        $.ajax({
            url: ajax+controller+'/'+code,
            headers: {
                'X-CSRF-TOKEN': token
            },
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

        $('.delete-datatable').click(function(event) {
            /* Act on the event */
            var data = $(this);
            swal({
                title: "Are you sure?",   
                text: "You will not be able to recover this imaginary file!",   
                type: "warning",   
                showCancelButton: true,   
                confirmButtonColor: "#DD6B55",   
                confirmButtonText: "Yes, delete it!",   
                closeOnConfirm: true 
            }, function(){   
                // swal("Deleted!", "Your imaginary file has been deleted.", "success"); 
                deleteData(data);
            });
        });
        // $('[data-toggle="confirmation"]').confirmation();
        /*$('.delete-datatable').confirmation({ btnOkClass: 'btn btn-sm btn-success', btnCancelClass: 'btn btn-sm btn-danger'});
        $('.delete-datatable').on('confirmed.bs.confirmation', function () {
            // alert('You confirmed action #1');
            // console.log($(this));

            deleteData($(this));
            $('button#btn-back').click();
        });*/

        
        /*swal({
            title: "Are you sure?",   
            text: "You will not be able to recover this imaginary file!",   
            type: "warning",   
            showCancelButton: true,   
            confirmButtonColor: "#DD6B55",   
            confirmButtonText: "Yes, delete it!",   
            closeOnConfirm: false 
        }, function(){   
            swal("Deleted!", "Your imaginary file has been deleted.", "success"); 
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

    

    return {

        //main function to initiate the module
        init: function () {

            if (!jQuery().dataTable) {
                return;
            }
            // initTable2();
            handleRecords();
        }

    };

}();

jQuery(document).ready(function() {
    TableDatatablesResponsive.init();
});