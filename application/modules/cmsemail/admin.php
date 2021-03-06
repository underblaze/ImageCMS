<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Image CMS
 * Email Module Admin
 * @property Cache $cache
 */
class Admin extends BaseAdminController {

    /**
     * Object of Email class
     * @var Email
     */
    public $email;

    public function __construct() {
        parent::__construct();
        $this->load->language('email');
        $this->email = \cmsemail\email::getInstance();
    }

    public function index() {
        \CMSFactory\assetManager::create()
                ->setData('models', $this->email->getAllTemplates())
                ->renderAdmin('list');
    }

    public function settings() {
        \CMSFactory\assetManager::create()
                ->registerScript('email', TRUE)
                ->registerStyle('style')
                ->setData('settings', $this->email->getSettings())
                ->renderAdmin('settings');
    }

    public function create() {
        if ($_POST) {
            if ($this->email->create()) {

                showMessage(lang('Template_created'));
                if ($this->input->post('action') == 'tomain')
                    pjax('/admin/components/cp/cmsemail/index');

                if ($this->input->post('action') == 'save')
                    pjax('/admin/components/cp/cmsemail/edit/' . $this->db->insert_id());
            }
            else {
                showMessage($this->email->errors, '', 'r');
            }
        }
        else
            \CMSFactory\assetManager::create()
                    ->registerScript('email', TRUE)
                    ->setData('settings', $this->email->getSettings())
                    ->renderAdmin('create');
    }

    public function mailTest($config) {
        echo $this->email->mailTest();
    }

    public function delete() {
        $this->email->delete($_POST['ids']);
    }

    public function edit($id) {
        $model = $this->email->getTemplateById($id);
        if(!$model){
            $this->load->module('core');
            $this->core->error_404();
            exit;
        }
        $variables = unserialize($model['variables']);

        if ($_POST) {
            if ($this->email->edit($id)) {
                showMessage(lang('Template_edited'));

                if ($this->input->post('action') == 'tomain')
                    pjax('/admin/components/cp/cmsemail/index');
            }
            else {
                showMessage($this->email->errors, '', 'r');
            }
        }
        else
            \CMSFactory\assetManager::create()
                    ->setData('model', $model)
                    ->setData('variables', $variables)
                    ->registerScript('email', TRUE)
                    ->renderAdmin('edit');
    }

    /**
     * updare settings for email
     */
    public function update_settings() {
        if ($_POST) {
            $this->form_validation->set_rules('settings[admin_email]', lang('Admin_email'), 'required|xss_clean|valid_email');
            $this->form_validation->set_rules('settings[from_email]', lang('Sender_eamil'), 'required|xss_clean|valid_email');
            $this->form_validation->set_rules('settings[from]', lang('From'), 'required|xss_clean');
            $this->form_validation->set_rules('settings[theme]', lang('From_email'), 'xss_clean|required');

            if ($_POST['settings']['wraper_activ'])
                $this->form_validation->set_rules('settings[wraper]', lang('Wraper'), 'required|xss_clean|callback_wraper_check');
            else
                $this->form_validation->set_rules('settings[wraper]', lang('Wraper'), 'xss_clean');

            if ($this->form_validation->run($this) == FALSE) {
                showMessage(validation_errors(), lang('Message'), 'r');
            } else {
                if ($this->email->setSettings($_POST['settings']))
                    showMessage(lang('Settings_saved'), lang('Message'));
            }

            $this->cache->delete_all();
        }
    }

    public function wraper_check($wraper) {
        if (preg_match('/\$content/', htmlentities($wraper))) {
            return TRUE;
        } else {
            $this->form_validation->set_message('wraper_check', lang('Field') . ' %s ' . lang('must_contain_variable') . ' $content');
            return FALSE;
        }
    }

    public function deleteVariable() {
        $template_id = $this->input->post('template_id');
        $variable = $this->input->post('variable');

        return $this->email->deleteVariable($template_id, $variable);
    }

    public function updateVariable() {
        $template_id = $this->input->post('template_id');
        $variable = $this->input->post('variable');
        $variableNewValue = $this->input->post('variableValue');
        $oldVariable = $this->input->post('oldVariable');
        return $this->email->updateVariable($template_id, $variable, $variableNewValue, $oldVariable);
    }

    public function addVariable() {
        $template_id = $this->input->post('template_id');
        $variable = $this->input->post('variable');
        $variableValue = $this->input->post('variableValue');

        if ($this->email->addVariable($template_id, $variable, $variableValue)) {
            \CMSFactory\assetManager::create()
                    ->setData('template_id', $template_id)
                    ->setData('variable', $variable)
                    ->setData('variable_value', $variableValue)
                    ->render('newVariable', true);
        } else {
            return FALSE;
        }
    }

    public function getTemplateVariables() {
        $template_id = $this->input->post('template_id');
        $variables = $this->email->getTemplateVariables($template_id);
        if ($variables) {
            return \CMSFactory\assetManager::create()
                            ->setData('variables', $variables)
                            ->render('variablesSelectOptions', true);
        } else {
            return FALSE;
        }
    }

    /**
     * import templates from file
     */
    public function import_templates(){
        $this->db->where_in('id', array(1,2,3,4,5,6))->delete('mod_email_paterns');
        $file = $this->load->file(dirname(__FILE__) . '/models/paterns.sql', true);
        if($this->db->query($file)){
              redirect('/admin/components/cp/cmsemail/');
        }
    }

}