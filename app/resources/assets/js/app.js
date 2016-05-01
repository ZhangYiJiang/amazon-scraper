var overlay = $('.overlay');

$('.book-list').on('show.bs.collapse', function (evt) {
  $(evt.target).prev().addClass('active');
  overlay.fadeIn();
}).on('hide.bs.collapse', function (evt) {
  overlay.fadeOut();
}).on('hidden.bs.collapse', function (evt) {
  $(evt.target).prev().removeClass('active');
});

overlay.click(function () {
  $('.book-info.collapse.in').collapse('hide');
});

