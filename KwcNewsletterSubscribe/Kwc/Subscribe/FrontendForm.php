<?php
class KwcNewsletterSubscribe_Kwc_Subscribe_FrontendForm extends Kwf_Form
{
    protected $_modelName = 'Kwf_Model_FnF';

    protected function _initFields()
    {
        parent::_initFields();
        $this->add(new Kwf_Form_Field_Radio('gender', trlKwfStatic('Salutation')))
            ->setAllowBlank(false)
            ->setValues(array(
                'female' => trlKwfStatic('Ms'),
                'male' => trlKwfStatic('Mr')
            ));

        $this->add(new Kwf_Form_Field_TextField('title', trlKwfStatic('Title')))
            ->setAllowBlank(true);

        $this->add(new Kwf_Form_Field_TextField('firstname', trlKwfStatic('Firstname')))
            ->setAllowBlank(false);

        $this->add(new Kwf_Form_Field_TextField('lastname', trlKwfStatic('Lastname')))
            ->setAllowBlank(false);

        $this->add(new Kwf_Form_Field_EMailField('email', trlKwfStatic('E-Mail')))
            ->setAllowBlank(false);
    }
}
