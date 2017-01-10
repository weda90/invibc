var FormValidation = function () {

    var handleForm = function() {
        $('form#form_sample_2').hide();
        $('#form_filter').hide();
        $('button#btn-back').hide();

        $('button#add-new').click(function(event) {
            /* Act on the event */

            $(this).hide();
            // $('button#btn-table-filter').hide();
            $('button#btn-back').show();
            $('.table-container').slideUp();
            $('form#form_sample_2').slideDown();
            
        });
        $('button#btn-back').click(function(event) {
            /* Act on the event */
            $(this).hide();
            // $('button#btn-table-filter').show();
            $('button#add-new').show();
            $('.table-container').slideDown();
            $('form#form_sample_2').slideUp();
            $('.alert button.close').click();
            clearValidation('form#form_sample_2');
        });

        $('button#btn-table-filter').click(function(event) {
            // $('#form_filter').slideDown();
            $('#form_filter').slideToggle();
            $("i", this).toggleClass("fa-chevron-circle-right fa-chevron-circle-down");

        });;

        $('.reset-form').click(function(event) {
            /* Act on the event */
            $('button#btn-back').click();
        });
    }

    // validation using icons
    var handleValidation2 = function() {
        // for more info visit the official plugin documentation: 
            // http://docs.jquery.com/Plugins/Validation

            var form2 = $('#form_sample_2');
            var error2 = $('.alert-danger', form2);
            var success2 = $('.alert-success', form2);

            form2.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block help-block-error', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: "",  // validate all fields including form hidden input
                /*rules: {
                    code: {
                        minlength: 2,
                        required: true
                    },
                    name: {
                        required: true
                    },
                    size: {
                        number: true
                    },
                    type: {
                        required: true
                    }
                },*/

                invalidHandler: function (event, validator) { //display error alert on form submit              
                    success2.hide();
                    error2.show();
                    App.scrollTo(error2, -200);
                },

                errorPlacement: function (error, element) { // render error placement for each input type
                    var icon = $(element).parent('.input-icon').children('i');
                    icon.removeClass('fa-check').addClass("fa-warning");  
                    icon.attr("data-original-title", error.text()).tooltip({'container': 'body'});
                },

                highlight: function (element) { // hightlight error inputs
                    $(element)
                        .closest('.form-group').removeClass("has-success").addClass('has-error'); // set error class to the control group 
                },

                unhighlight: function (element) { // revert the change done by hightlight
                    
                },

                success: function (label, element) {
                    var icon = $(element).parent('.input-icon').children('i');
                    $(element).closest('.form-group').removeClass('has-error').addClass('has-success'); // set success class to the control group
                    icon.removeClass("fa-warning").addClass("fa-check");
                },

                submitHandler: function (form) {
                    ajaxData(form,success2,error2);
                    return false;
                }
            });


    }

    var handleSelect2 = function() {

        $.fn.select2.defaults.set("theme", "bootstrap");
        $.fn.select2.defaults.set("placeholder", "Select...");
        var placeholder = "Select a State";


        $(".select2[name=code_mat]").select2({
            // placeholder: placeholder,
            width: null,
            ajax: {
                url: ajax+'material',
                headers: {
                    'X-CSRF-TOKEN': token
                },
                dataType: 'json',
                delay: 250,
                processResults: function(data, page) {
                    // parse the results into the format expected by Select2.
                    // since we are using custom formatting functions we do not need to
                    // alter the remote JSON data
                    return {
                        results: data.items
                    };
                },
                cache: true

            },
            escapeMarkup: function(markup) {
                return markup;
            }, // let our custom formatter work
            minimumInputLength: 3
        });

        $(".select2[name=code_comp]").select2({
            // placeholder: "Select... ",
            width: null,
            ajax: {
                url: ajax+'company',
                dataType: 'json',
                delay: 250,
                processResults: function(data, page) {
                    // parse the results into the format expected by Select2.
                    // since we are using custom formatting functions we do not need to
                    // alter the remote JSON data
                    return {
                        results: data.items
                    };
                },
                cache: true

            },
            escapeMarkup: function(markup) {
                return markup;
            }, // let our custom formatter work
            minimumInputLength: 3
        });
    }

    var handleMask = function(){
        $(".mask_decimal").inputmask("decimal", { 
            radixPoint: ",", 
            autoGroup: true, 
            groupSeparator: ".", 
            groupSize: 3, 
            autoUnmask: true
        });
    }


    function ajaxData(form, success2, error2){

        var code;
        var obj = {};
        var controller = $(form).attr('data-controller');
        // var action = $(form).find('input[type=submit]').attr('data-action');
        var method = $(form).attr('method');
        
        $('input.form-control, select.form-control, textarea.form-control',$(form)).each(function(index, el) {
                obj[$(this).attr('name')] = $(this).val();
        });

        // console.log(obj.Object.keys(obj)[0]);
        // console.log(obj[Object.keys(obj)[0]]);

        if ($(form).attr('method') === 'PUT') {
            // URL = ajax+controller+'/'+obj.code;
            URL = ajax+controller+'/'+obj[Object.keys(obj)[0]];
        } else {
            URL = ajax+controller;
        }


        $.ajax({
            url: URL,
            type: method,
            headers: {
                'X-CSRF-TOKEN': token
            },
            dataType: 'json',
            data: obj,
        })
        .done(function(data) {
            if (data.status === 1) {
                success2.show();
                error2.hide();

                if (method.toUpperCase() === 'POST') {
                    clearValidation(form);
                }
                
            } else {
                success2.hide();
                error2.show();
            }
        })
        .fail(function(jqXHR, textStatus, error) {
            // console.log("error");
        })
        .always(function() {
            // console.log("complete");
        });
        

        // console.log(host+'/api/'+controller+'/'+action);
        
    }

    function clearValidation(form){
        $('.form-group, .form-group',$(form)).removeClass('has-success has-error').find('i.fa').removeClass('fa-check fa-warning');
        $('input.form-control, select.form-control',$(form)).first().removeAttr('disabled');
        $('input.form-control, select.form-control, textarea.form-control',$(form)).val('');
        // $('.select2').next('option').remove();
        $(".select2 option").empty().trigger('change')
        $('button[type=submit]',$(form)).attr('data-action','post');
        $(form).attr('method','POST');
       
    }

    return {
        //main function to initiate the module
        init: function () {

            // handleWysihtml5();
            // handleValidation1();
            handleValidation2();
            handleForm();
            handleSelect2();
            handleMask();
            // handleValidation3();

        }

    };

}();

jQuery(document).ready(function() {
    FormValidation.init();
});