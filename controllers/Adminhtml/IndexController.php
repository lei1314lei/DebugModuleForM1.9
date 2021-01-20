<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Martin_Debug_Adminhtml_IndexController extends Mage_Adminhtml_Controller_Action
{
    public function _testSaveProduct()
    {
        //10290
        $product=Mage::getModel('catalog/product')->load(10290);
        if($product->getId())
        {

            $product->setData('status',1);
//            $product->setStatus(1);
//            $product->setUrlKey('testasaeas');
            $product->save();
        }

        var_dump($product->getStatus());exit;
    }

    public function indexAction()
    {
        $quoteId=7529;
        $quote = Mage::getModel('sales/quote')->load($quoteId);
        var_dump('b',$quoteId,$quote->getData());
        exit;
    }
   
}
