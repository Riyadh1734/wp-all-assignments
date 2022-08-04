;(function ($) {

    $(document).ready(function() {

        $('#self_contact').submit(function(e) {
            e.preventDefault();

            // Form submision values
            let firstName = $('#cf-fname').val();
            let lastName  = $('#cf-lname').val();
            let email     = $('#cf-email').val();
            let message   = $('#cf-message').val();

            // Regular expresions
            let regExName = /^[a-z ,.'-]+$/i;
            let regExEmail = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

            // Validate values using regular expresion
            let validFname = regExName.test(firstName);
            let validLname = regExName.test(lastName);
            let validEmail = regExEmail.test(email);

            // Remove previousely shown status/messages
            $(".msg-error").remove();
            $('.submision-status').remove();

            // Throw error if first name validation failed
            let fNamePassed = false;
            if (firstName.length < 1) {
                $('#cf-fname').after('<p class="msg-error">First name is required</p>');
            } else if (!validFname) {
                $('#cf-fname').after('<p class="msg-error">Enter a valid first name</p>');
            } else {
                fNamePassed = true;
            }

            // Throw error if last name validation failed
            let lNamePassed = false;
            if (lastName.length < 1) {
                $('#cf-lname').after('<p class="msg-error">Last name is required</p>');
            } else if (!validLname) {
                $('#cf-lname').after('<p class="msg-error">Enter a valid last name</p>');
            } else {
                lNamePassed = true;
            }

            // Throw error if email validation failed
            let emailPassed = false;
            if (email.length < 1) {
                $('#cf-email').after('<p class="msg-error">Email is required</p>');
            } else if (!validEmail) {
                $('#cf-email').after('<p class="msg-error">Enter a valid email</p>');
            } else {
                emailPassed = true;
            }
            // Throw error if message validation failed
            let messagePassed = false;
            if(message.length > 255) {
                $('#cf-message').after('<p class="msg-error">Maximum 255 chracters allowed</p>');
            } else {
                messagePassed = true;
            }
            // Return if found any error
            if ( true !== fNamePassed || true !== lNamePassed || true !== emailPassed  || true !== messagePassed ) {
                return;
            }
            // Serialize form data for ajax request
            let formData = $(this).serialize();
            // Ajax request
            $.post(objContactEnquery.ajaxurl, formData, function(response) {
                if (response.success) {
                    $('#self_contact').prepend('<div class="submision-status status-success"><p class="msg-success">' + response.data.message + '</p></div>');
                } else {
                    $('#self_contact').prepend('<div class="submision-status status-error"><p class="msg-error">' + response.data.message + '</p></div>');
                }
            })
            .fail(function () {
                alert(objContactEnquery.error);
            });
        });
    });
})(jQuery);
