<?php

namespace Inoplate\Captcha;

use ReCaptcha\ReCaptcha;
use Illuminate\Http\Request;

class RecaptchaChallenge implements Challenge
{
    /**
     * @var Illuminate\Http\Request
     */
    protected $request;

    /**
     * @var array
     */
    protected $options;

    /**
     * Create new RecaptchaChallenge instance
     * 
     * @param Request   $request
     * @param array     $options
     */
    public function __construct(Request $request, array $options)
    {
        $this->request = $request;
        $this->options = $options;
    }

    /**
     * Render captcha
     * @return html
     */
    public function render()
    {
        return view($this->options['template'], ['options' => $this->options]);
    }

    /**
     * Check if answer is valid
     * 
     * @param  string $answer
     * @return boolean
     */
    public function check($answer)
    {
        $recaptcha = new ReCaptcha($this->options['secret']);

        return $recaptcha->verify($answer, $this->request->ip())->isSuccess();
    }
}