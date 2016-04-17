<?php

namespace Inoplate\Captcha;

interface Challenge
{
    /**
     * Render captcha
     * 
     * @return html
     */
    public function render();

    /**
     * Check if captcha is valid
     * 
     * @param  string $answer
     * @return boolean
     */
    public function check($answer);
}
