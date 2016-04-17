(function() {
  $('.captcha-refresh').on('click', function() {
    return $(this).parents('.captcha-container').find('.captcha-image-holder img').attr('src', '/captcha/image.jpg?' + Math.random());
  });

}).call(this);

//# sourceMappingURL=captcha.js.map
