<?php

class Martin_Debug_Adminhtml_Session_FormkeyController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $coreSession = Mage::getSingleton('core/session');
        $formkey=$coreSession->getFormKey();
        var_dump($formkey);
        exit;
    }
}