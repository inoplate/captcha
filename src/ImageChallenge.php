<?php

namespace Inoplate\Captcha;

use Securimage;

class ImageChallenge implements Challenge
{
    /**
     * @var array
     */
    protected $options;

    /**
     * Create new ImageChallenge instance
     * 
     * @param array $options
     */
    public function __construct(array $options)
    {
        $this->options = $options;
    }

    /**
     * Render captcha
     * 
     * @return html
     */
    public function render()
    {
        $imageUrl = '/captcha/image.jpg';

        return view($this->options['template'], compact('imageUrl'));
    }

    /**
     * Check if captcha is valid
     * 
     * @param  string $answer
     * @return boolean
     */
    public function check($answer)
    {
        $image = new Securimage();

        return $image->check($answer);
    }
}