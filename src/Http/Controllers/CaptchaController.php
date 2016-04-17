<?php

namespace Inoplate\Captcha\Http\Controllers;

use Securimage;
use Securimage_Color;
use Illuminate\Contracts\Config\Repository as Config;
use Illuminate\Routing\Controller as BaseController;

class CaptchaController extends BaseController
{
    /**
     * @var Illuminate\Contracts\Config\Repository
     */
    protected $config;

    /**
     * Create new CaptchaController instance
     * 
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * Get image
     * 
     * @return image
     */
    public function getImage()
    {
        $image = $this->applyOptions( new Securimage,  $this->config->get('inoplate.captcha.drivers.image'));

        return $image->show();
    }

    /**
     * Apply options to Securimage
     * 
     * @param  Securimage $image
     * @param  array      $options
     * @return Securimage
     */
    protected function applyOptions(Securimage $image, $options)
    {
        $image->image_bg_color = new Securimage_Color($options['bg_color']);
        $image->text_color = new Securimage_Color($options['text_color']);
        $image->line_color = new Securimage_Color($options['line_color']);
        $image->perturbation = $options['perturbation'];
        $image->num_lines = $options['num_lines'];
        $image->image_width = $options['width'];
        $image->image_height = (int)($image->image_width * 0.35);
        $image->charset = $options['charset'];
        $image->code_length = $options['code_length'];
        $image->num_lines = $options['num_lines'];

        return $image;
    }
}