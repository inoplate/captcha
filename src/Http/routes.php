<?php

$router->get('captcha/image.jpg', ['uses' => 'CaptchaController@getImage']);