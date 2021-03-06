<section class="mini-layout">
    <div class="frame_title clearfix">
        <div class="pull-left">
            <span class="help-inline"></span>
            <span class="title">Настройки обновлений</span>
        </div>
        <div class="pull-right">
            <div class="d-i_b">
                <a href="{$BASE_URL}admin/sys_update"
                   class="t-d_n m-r_15 pjax">
                    <span class="f-s_14">←</span>
                    <span class="t-d_u">{lang('a_back')}</span>
                </a>
                <button type="button"
                        class="btn btn-small btn-primary action_on formSubmit"
                        data-form="#sys_form"
                        data-action="tomain">
                    <i class="icon-ok"></i>{lang('a_save')}
                </button>
            </div>
        </div>
    </div>
    <form method="post" action="{$BASE_URL}admin/sys_update/properties" class="form-horizontal" id="sys_form">
        <table class="table table-striped table-bordered table-hover table-condensed">
            <thead>
                <tr>
                    <th colspan="6">
                        Настройки
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="6">
                        <div class="inside_padd">
                            <div class="control-group">
                                <label class="control-label" for="zip">Ваш ключ для обновлений:</label>
                                <div class="controls">
                                    <textarea name="careKey" rows="10">{echo $careKey}</textarea>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </form>
</section>