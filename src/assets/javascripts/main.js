$(document).ready(function () {
  $('#notification-close').on('click', function() {
    $(this).parent().slideUp();
  });
});
