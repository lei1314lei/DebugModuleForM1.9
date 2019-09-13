<?php

class Martin_Debug_LocaleController extends Mage_Core_Controller_Front_Action{
    public function indexAction()
    {
                $localModel=Mage::getModel('core/locale');
        $value=$localModel->getLocale()->getTranslation('CN', 'country', 'zh-cn');
        var_dump($value,$localModel->getLocale());exit;
    }
}
