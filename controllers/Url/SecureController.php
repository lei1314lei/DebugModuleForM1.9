<?php
class Martin_Debug_Url_SecureController extends Mage_Core_Controller_Front_Action{

    public function indexAction()
    {
        $path="wishlist/index/add";
        $path="catalog/product_compare/add";
        $url=Mage::getModel('core/url');
        $url->getUrl($path);
        $secureOrNot=Mage::getConfig()->shouldUrlBeSecure('/' . $url->getActionPath());
        var_dump($secureOrNot); exit;
    }
}