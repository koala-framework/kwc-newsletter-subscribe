<?php
class KwcNewsletterSubscribe_Kwc_Subscribe_Success_Component extends Kwc_Form_Success_Component
{
    public static function getSettings($param = null)
    {
        $ret = parent::getSettings($param);
        $ret['placeholder']['success'] = trlKwfStatic('Thank you for your subscription. If you have not been added to our newsletter-distributor yet, you will shortly receive an email with your activation link. Please click on the link to confirm your subscription.');
        return $ret;
    }
}
