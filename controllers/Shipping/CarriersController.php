<?php

class Martin_Debug_Shipping_CarriersController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        $storeId=1;
        $carriers = Mage::getStoreConfig('carriers', $storeId);
        var_dump($carriers);
        exit;
    }
}
