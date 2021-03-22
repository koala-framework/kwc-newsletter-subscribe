<?php
class KwcNewsletterSubscribe_Kwc_Subscribe_Component extends Kwc_Form_Component
{
    public static function getSettings($param = null)
    {
        $ret = parent::getSettings($param);
        $ret['componentName'] = trlKwfStatic('Newsletter subscribe');
        $ret['placeholder']['submitButton'] = trlKwfStatic('Subscribe the newsletter');
        $ret['generators']['child']['component']['success'] = 'KwcNewsletterSubscribe_Kwc_Subscribe_Success_Component';
        $ret['generators']['child']['component']['policyText'] = 'KwcNewsletterSubscribe_Kwc_Subscribe_PolicyText_Component';
        $ret['extConfig'] = 'Kwc_Abstract_Composite_ExtConfigForm';
        return $ret;
    }

    public static function validateSettings($settings, $componentClass)
    {
        parent::validateSettings($settings, $componentClass);

        if (!Kwf_Config::getValue('kwcNewsletterSubscribe.apiUrl')) {
            throw new Kwf_Exception("Config setting 'kwcNewsletterSubscribe.apiUrl' is required for '$componentClass'");
        }
    }

    public function getSubmitDataLayer()
    {
        $ret = parent::getSubmitDataLayer();
        $ret['event'] = 'form-submit';
        $ret['formType'] = 'Newsletter';
        return $ret;
    }

    protected function _initForm()
    {
        parent::_initForm();
        $policyTextComponent = $this->getData()->getChildComponent('-policyText');
        if (!$this->getData()->getBaseProperty('kwcNewsletterSubscribe.hidePolicyText') && $policyTextComponent->hasContent()) {
            $this->getForm()->fields->add(new Kwf_Form_Field_Checkbox('policyText'))
                ->setAllowBlank(false)
                ->setHideLabel(true);
        }
    }

    public function getTemplateVars(Kwf_Component_Renderer_Abstract $renderer)
    {
        $policyTextField = $this->getForm()->fields->getByName('policyText');
        if ($policyTextField) {
            $helper = new Kwf_Component_View_Helper_Component();
            $helper->setRenderer($renderer);
            $policyTextField
                ->setBoxLabel($helper->component($this->getData()->getChildComponent('-policyText')));
        }
        return parent::getTemplateVars($renderer);
    }

    public function insertSubscription(array $params)
    {
        $c = new Zend_Http_Client(Kwf_Config::getValue('kwcNewsletterSubscribe.apiUrl'));
        $c->setConfig(array(
            'timeout' => 30
        ));

        $params['ip'] = $_SERVER['REMOTE_ADDR'];

        if (!isset($params['source'])) {
            $params['source'] = $this->getData()->getAbsoluteUrl();
        }

        if ($country = $this->getData()->getBaseProperty('country')) {
            $params['country'] = strtoupper($country);
        }

        if ($this->_getCategoryId()) {
            $params['categoryId'] = $this->_getCategoryId();
        }

        $c->setHeaders(array(
            'Accept' => 'application/json'
        ));
        $c->setRawData(json_encode($params), 'application/json');
        $c->setMethod(Zend_Http_Client::POST);
        $response = $c->request();

        if (!$response->isSuccessful()) {
            $e = new Kwf_Exception('subscribe failed: ' . $response->getBody());
            $e->logOrThrow();

            throw new Kwf_Exception_Client($this->getData()->trlKwf('Please try again later.'));
        }
    }

    protected function _getCategoryId()
    {
        return null;
    }

    protected function _afterInsert(Kwf_Model_Row_Interface $row)
    {
        parent::_afterInsert($row);
        $params = array(
            'gender' => $row->gender,
            'title' => $row->title,
            'firstname' => $row->firstname,
            'lastname' => $row->lastname,
            'email' => $row->email
        );
        $this->insertSubscription($params);
    }
}
