$(document).ready(function () {
    // ZURB Foundation
    $(document).foundation();

    // FlashBag messages
    $('#notification-close').on('click', function () {
        $(this).parent().slideUp();
    });

    // Display group field when editing user only when necessary
    $('#signup_form_role_id').change(function (e) {
        var roleId = this.value;
        var groupLabel = $("label[for='signup_form_group_id']");
        var groupField = $('#signup_form_group_id');

        if (roleId === "1" || roleId === "2") {
            groupLabel.hide();
            groupField.hide().removeAttr('required');
        } else {
            groupLabel.show();
            groupField.show().attr('required', 'required');
        }
    }).trigger('change');
});
