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
        var groupField = $("#signup_form_group_id, label[for='signup_form_group_id']");

        if (roleId === "1" || roleId === "2") {
            groupField.hide();
        } else {
            groupField.show();
        }
    }).trigger('change');
});
