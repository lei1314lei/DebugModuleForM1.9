<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Xtwocn_Debug_Adminhtml_IndexController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $categoryId=66;
        $storeId=2;

        $heroRule=Mage::getModel('hero/rule_merchandiser_hero');
        $heroRule->apply($categoryId,$storeId);
        if($heroRule->getException())
        {
            var_dump($heroRule->getException());
        }
        exit;
        
        $storeId=2;
        $category=Mage::getModel('catalog/category')->load(66);
        
        $category->setStoreId($storeId);
        $prodPosArr=$category->getProductsPosition();
        asort($prodPosArr);
        $allAssociatedProdIds=array_keys($prodPosArr);
        var_dump($prodPosArr,$allAssociatedProdIds);exit;
        
        $newProdIds=array(2,3,8,9);
        $products=Mage::getModel('catalog/product')->getCollection()
                ->addFieldToFilter('entity_id',array('in'=>$newProdIds));
        var_dump($newProdIds,count($products));exit;
                
        $category=Mage::getModel('catalog/category')->load(70);
        $storeId=2;
        $store=Mage::getModel('core/store')->load($storeId);
        if($store->getId())
        {
            $webId=$store->getWebsiteId();
        }
        $customerGroupId = Mage::getSingleton('customer/session')->getCustomerGroupId();
      $productCollection=Mage::getModel('catalog/product')->getCollection()
                ->addStoreFilter(2)
              ->addCategoryFilter($category)
              ->addAttributeToSort('position','desc');
        //      ->addPriceData($customerGroupId,$webId);
      echo $productCollection->getSelect(),"<hr>";
      foreach($productCollection as $product)
      {
         var_dump($product->getId(),$product->getData());
      }
        
              

       exit;

//            $productCollection=Mage::getModel('catalog/product')->getCollection()
//              //  ->addStoreFilter($storeId)
//                ->addCategoryFilter($category);
//            echo $productCollection->getSelect(),"<hr>";
//            var_dump(count($productCollection));
//            foreach($productCollection as $product)
//            {
//                $product->save();
//            }
//            echo 'ok';
//            $select=$productCollection->getSelect()
//                    ->reset(Zend_Db_Select::COLUMNS)
//                     ->columns("MAX(position) as max_pos");
//                    echo $select;
      
    }
}
