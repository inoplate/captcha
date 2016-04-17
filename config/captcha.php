<?php

return [
    'challenge' => 'image',
    'drivers' => [
        'recaptcha' => [
            'driver'    => 'recaptcha',
            'key'       => env('RECAPTCHA_KEY', 'your recaptcha key'),
            'secret'    => env('RECAPTCHA_SECRET', 'your recaptcha secret'),
            'template'  => 'captcha::partials.recaptcha',
            'input'     => 'g-recaptcha-response'
        ],
        'image' => [
            'driver'        => 'image',
            'bg_color'      => '#3388FF',
            'text_color'    => '#525252',
            'line_color'    => '#525252',
            'width'         => '320',
            'charset'       => 'abcdefghijklmneopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ',
            'code_length'   => rand(4, 6),
            'perturbation'  => 0.75, // 0 - 1
            'num_lines'     => 10,
            'template'      => 'inoplate-captcha::partials.image',
            'input'         => 'captcha_code'
        ]
    ],
];