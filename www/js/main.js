$(document).ready(function(){
    $.validator.setDefaults({
        highlight: function(element) {
            $(element).closest('.form-group').addClass('has-error');
        },
        unhighlight: function(element) {
            $(element).closest('.form-group').removeClass('has-error');
        },
        errorElement: 'span',
        errorClass: 'help-block error',
        errorPlacement: function(error, element) {
            if(element.parent('.input-group').length) {
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }
        }
    });

    $('#login').validate({
        rules: {
            login: {
                minlength: 3,
                maxlength: 15,
                required: true
            },
            password: {
                minlength: 3,
                maxlength: 15,
                required: true
            }
        }
    });


    $('#register').validate({
        rules: {
            name: {
                minlength: 3,
                maxlength: 15,
                required: true
            },
            login: {
                minlength: 3,
                maxlength: 15,
                required: true,
                email: true
            },
            password: {
                minlength: 3,
                maxlength: 15,
                required: true
            },
            password_again: {
                equalTo: '#password',
                minlength: 3,
                maxlength: 15,
                required: true
            }
        }
    });

});