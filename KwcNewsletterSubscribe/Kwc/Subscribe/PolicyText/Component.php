<?php
class KwcNewsletterSubscribe_Kwc_Subscribe_PolicyText_Component extends Kwc_Basic_Text_Component
{
    public static function getSettings($param = null)
    {
        $ret = parent::getSettings($param);
        $ret['componentName'] = trlKwfStatic('Policy-Text');
        $ret['defaultText'] = '';
        return $ret;
    }
}
