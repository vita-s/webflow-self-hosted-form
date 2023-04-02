// === Custom Form Handling ===

// unbind webflow form handling
$(document).off('submit');

// new form handling
$('[data-local="form"]').each(function () {
    $(this).submit(function(e) {
        e.preventDefault();

        var $form = $(this);

        var $submit = $form.find('input[type="submit"]');
        var submitVal = $submit.val();
        var submitWait = $submit.data('wait');
        $submit.val(submitWait).prop('disabled', true);
        
        var $successMessage = $form.parent().find('.w-form-done').hide();
        var $errorMessage = $form.parent().find('.w-form-fail').hide();

        $.ajax({
            type: "POST",
            url: 'local-mail/email.php',
            data: $(this).serialize(),
            success: function (data) {
                console.log(data);
                $form.hide();
                $errorMessage.hide();
                $successMessage.show();
            },
            error: function () {
                $errorMessage.show();
            },
            complete: function () {
                $submit.val(submitVal).prop('disabled', false);
            }
        });
    });
});