$(document).ready(function () {
  // ZURB Foundation
  $(document).foundation();

  // FlashBag messages
  $('#notification-close').on('click', function() {
    $(this).parent().slideUp();
  });
});
