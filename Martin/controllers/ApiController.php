<?php

class Xtwocn_Debug_ApiController extends Mage_Core_Controller_Front_Action{
    public function indexAction()
    {
        $apiCfg=Mage::getSingleton('api/config');
        var_dump($apiCfg->getResourcesAlias());
        var_dump($apiCfg->getResources());
    }
}

