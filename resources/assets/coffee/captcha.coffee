$ '.captcha-refresh'
    .on 'click', () ->
        $ this
            .parents '.captcha-container'
            .find '.captcha-image-holder img'
            .attr 'src', '/captcha/image.jpg?' + Math.random()