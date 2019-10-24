<?php

class Martin_Debug_Session_FormkeyController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        $coreSession = Mage::getSingleton('core/session');
        $formkey=$coreSession->getFormKey();
        var_dump($formkey);
        exit;
    }
}