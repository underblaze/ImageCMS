{#
/**
* @file template file for creating drop-down login form uses imagecms.api.js for submiting and appending validation errors
*/
#}
<div class="drop-enter drop">
    <div class="icon-times-enter" data-closed="closed-js"></div>
    <div class="drop-content">
        <div class="header_title">
            {lang('lang_login_page')}
        </div>
        <div class="inside_padd">
            <div class="horizontal_form standart_form">
                <form method="post" id="login_form" class="submit_enter">
                    <label>
                        <span class="title">{lang('lang_email')}</span>
                        <span class="frame_form_field">
                            <span class="icon-email"></span>
                            <input type="text" name="email"/>
                            <div id="for_email" class="for_validations"></div>
                        </span>
                    </label>
                    <label>
                        <span class="title">{lang('lang_password')}</span>
                        <span class="frame_form_field">
                            <span class="icon-password"></span>
                            <input type="password" name="password"/>
                            <div id="for_password" class="for_validations"></div>
                        </span>
                    </label>
                    <!-- captcha block -->
                    <lable id="captcha_block">
                        
                    </lable>
                    <div class="frameLabel">
                        <span class="title">&nbsp;</span>
                        <span class="frame_form_field c_n">
                            <a href="/auth/forgot_password" class="f_l neigh_btn">{lang('lang_forgot_password')}</a>
                            <input type="button" value="Войти" class="btn btn_cart f_r" onclick="ImageCMSApi.formAction('/auth/authapi/login', 'login_form');
                                        return false;"/>
                        </span>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="drop-footer"></div>
</div>