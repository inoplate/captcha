<div class="captcha-container">
    <div class="captcha-image-holder">
        <img src="{{ $imageUrl }}/" />
    </div>
    <input type="text" name="captcha_code" style="width:100%" placeholder="{{ trans('inoplate-captcha::labels.input_code') }}"  />
    <button class="btn btn-info btn-flat captcha-refresh" type="button">Refresh</i></button>
</div>

<script src="{{ asset('vendor/inoplate-captcha/js/captcha.js') }}"></script>