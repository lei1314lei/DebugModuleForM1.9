<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Martin_Debug_Adminhtml_IndexController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
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
