<?php
class Martin_Debug_Cache_IndexController extends Mage_Core_Controller_Front_Action
{
    public function isOnAction()
    {
        $useCache=Mage::app()->useCache(Mage_Core_Block_Abstract::CACHE_GROUP);
        var_dump($useCache);
        exit;
    }
}