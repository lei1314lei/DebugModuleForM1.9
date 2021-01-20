<?php
class Martin_Debug_ImageController extends Mage_Core_Controller_Front_Action {
    public function indexAction(){
        $imgSrc='/media/origin.jp';
//        $refurbishedProduct=Mage::getModel('catalog/product')->load(10293);
//        echo Mage::helper('catalog/image')->init($refurbishedProduct, 'haha_test', $imgSrc)->resize(38, 50);


        //Toolots_Strategy_Model_SecondHand_ImageModel
        $imageHandler =  Mage::helper('strategy/image')->init("strategy/secondHand_imageModel",$imgSrc);
        echo $imageHandler -> resize(30, 40);
        exit;
    }
}