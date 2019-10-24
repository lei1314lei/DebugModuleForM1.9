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
        $this->_testSaveProduct();exit;

        $this->loadLayout();
//        $product=Mage::getModel('catalog/product')->load(554);
//        Mage::register('product', $product);
        $warehouse=Mage::getModel('warehouse/warehouse')->load(1);
        Mage::register('warehouse', $warehouse);
        
        $groupId=78;
        $group=Mage::getModel('eav/entity_attribute_group')->load($groupId);
        $attributes=Mage::getModel('eav/entity_attribute')->getCollection()
                ->setAttributeGroupFilter($groupId);
        $this->getLayout()->getBlock("test")->setGroup($group)
                            ->setGroupAttributes($attributes);
        
        
        
        $this->renderLayout();
    }
   
}
