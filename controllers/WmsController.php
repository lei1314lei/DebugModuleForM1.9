<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of WmsController
 *
 * @author martin.tian
 */
class Martin_Debug_WmsController extends Mage_Core_Controller_Front_Action{
    protected function _getFormat($date)
    {
        if (is_string($date) && preg_match('#^\d{4,4}-\d{2,2}-\d{2,2} \d{2,2}:\d{2,2}:\d{2,2}$#', $date)) {
            return 'yyyy-MM-dd';
        }
        return null;
    }
    protected $_codeAndLabel=array();
    protected function _setLabelData($attrCode,$entityType,$entityObject)
    {
        $key="{$entityType}-{$attrCode}";
        if(!isset($this->_codeAndLabel[$key]))
        {
            $attribute=Mage::getSingleton('eav/config')->getCollectionAttribute($entityType,$attrCode);
            $label=$attribute->getData('frontend_label');
            
            if($label)
            {
                $entityObject->setData($label,$entityObject->getData($attrCode));
                var_dump($entityObject->getData());
            }
        }
    }
    
    public function testAction()
    {
        
        try{   
$supplierId=null;
            $collection=Mage::getModel('martinwms/bookedSpace')->getCollection()
                    ->addFieldToFilter('supplier_id',$supplierId);
            
            echo $collection->getSelect();
            
            var_dump($collection->getColumnValues('order_id'),get_class_methods($collection));exit;
            
            
            
            
            
            
            
             $order=Mage::getModel('sales/order')->load(246);
            // var_dump(get_class_methods($order));exit;
            foreach( $order->getAllItems() as $item)
            {
                var_dump($item->getOrder()->getCustomerId());exit;
                var_dump(get_class_methods($item),$item->getData()); exit;
            }
            echo 'breakpoint';exit;
            
             $supplier=Mage::getSingleton('supplier/session')->getUser();

             $warehouses=Mage::getModel('martinwms/bookedSpace')->getCollection()
                     ->addFieldToFilter('supplier_id',$supplier->getId());
             echo $warehouses->getSelect();
            foreach($warehouses as $warehouse)
            {
                 var_dump($warehouse->getData());
            }

             echo '<br>breakpoint';exit;
            
            $cacheKey = 'DIRECTORY_COUNTRY_SELECT_STORE_'.Mage::app()->getStore()->getCode();
            if (Mage::app()->useCache('config') && $cache = Mage::app()->loadCache($cacheKey)) {
                $options = unserialize($cache);
            } else {
                $collection = Mage::getModel('directory/country')->getResourceCollection()
                ->loadByStore();
                $options = $collection->toOptionArray();
                if (Mage::app()->useCache('config')) {
                    Mage::app()->saveCache(serialize($options), $cacheKey, array('config'));
                }
            }    
            var_dump($options);exit;
            
            
            
            
            
             $model=Mage::getModel('warehouse/warehouse');
             $attributes=$model->getResource()->getEntityType()->getAttributeCollection();
             $attributes->setOrder('sort_order','asc'); 
             $select=$attributes->getSelect();
             echo $select;
//             var_dump($select);
            foreach($attributes as $attribute)
            {
                var_dump($attribute->getData());
            }
             
             
             exit;
            
            
            
            
            
            
            
            
            
var_dump(Mage::getModel('warehouse/warehouse')->load(1)->getData()); exit;
       $warehouses=Mage::getModel('warehouse/warehouse')->getCollection()
               ->addFieldToFilter('supplier_id',$supplierId)
               ->addAttributeToSelect('sort_order');
       echo $warehouses->getSelect();
       exit;
            
            
            $quote=Mage::getModel('sales/quote')->load(777);
            $quoteItems=$quote->getAllItems();
            foreach($quoteItems as $quoteItem)
            {
                var_dump($quoteItem->getId());
                $factory=new \Martin_Wms\Client\FactoryBookingSpaceItem($quoteItem);
                $spaceItem=$factory->getSpaceItemInstance();
                $spaceItemHandler=$factory->getSpaceItemHandler();
                $action = new \Martin_Wms\Action\SaveSpaceItem($spaceItem, $spaceItemHandler);
                $action->execute();
            }
            echo 'ok' ;exit;
            
            
            
            
            
            
            
            
            
            
//            
//           $result=Mage::helper('eavAttribute/form')->getElesAndEntityData('warehouse',1);
//           var_dump($result);exit;
//            
            
            
            $warehouse=Mage::getModel('warehouse/warehouse')->load(1);
            var_dump($warehouse->getData());
$attributes=$warehouse->getResource()->getEntityType()->getAttributeCollection(); 
foreach($attributes as $attribute)
{
    var_dump($attribute->getData());
}
       exit;
            
            

            
            
            
            
            
//            $orderItemId=626;
//            $orderItem=Mage::getModel('sales/order_item')->load($orderItemId);
//            
//            
//            $quote=Mage::getModel('sales/quote')->load(771);
//            foreach($quote->getAllItems() as $item)
//            {
//                if($item->getId()==2663)
//                {
//                    $quoteItem=$item;
//                }
//            }
//
//            $spaceItemHandler= new \Martin_Wms\Client\HandlerBookingSpaceItem();    
//            $factory =  new \Martin_Wms\Client\FactoryBookingSpaceItem($quoteItem);
//            $bookingSpaceItem=$factory ->getSpaceItemInstance($spaceItemHandler);
//
//            
//            
//            
//
//            $bookedSpaceItemHandler=new \Martin_Wms\Client\HandlerBookedSpaceItem();
//            $factory=new \Martin_Wms\Client\FactoryBookedSpaceItem($orderItem);
//            $factory->setBookingSpaceItem($bookingSpaceItem);
//            $bookedSpaceItem=$factory->getSpaceItemInstance($bookedSpaceItemHandler);
//            $bookedSpaceItem->setRequiredCapabilitys($bookedSpaceItem->getRequiredCapabilitys());
//            $action =  new \Martin_Wms\Client\Action\TransformTypeFromBookingIntoBooked($factory->getBookingSpaceItem(), $bookedSpaceItem, $bookedSpaceItemHandler);
//            $action -> execute();

            
            
//            echo 'ok';exit;
//            
//            
//            
//            $warehouse=Mage::getModel('warehouse/warehouse')->load(2);
//            $dateFrom=new \Zend_Date("2019-04-01");
//            $dateTo=new \Zend_Date("2019-04-29");
//            $spaceItems=array();
//            $items=Mage::getModel('martinwms/bookedSpace')->getCollection();
//          
//             foreach($items as $item)
//             {
//                 $spaceItems[]=$item;
//             }
//             
//            $items=Mage::getModel('martinwms/bookingSpace')->getCollection();
//       
//             foreach($items as $item)
//             {
//                 $spaceItems[]=$item;
//             }
//            $time=time();
//             var_dump(Martin_Wms\Client\CapabilitysCalculator::RequiredCapabilityCalendar($dateFrom, $dateTo, $spaceItems));
//             var_dump(Martin_Wms\Client\CapabilitysCalculator::AvailableRequiredCapabilityCalendar($warehouse, $dateFrom, $dateTo, $spaceItems));
//             var_dump(time()-$time);
//             echo 'ok';exit;
           
            
            
//            $action = new Martin_Wms\Action\Installation\StateOfBeingToInstall();
//            $action->execute();
//            echo 'ok';

            
            echo 'breakpoint';exit;
        } catch (Exception $ex) {
            var_dump($ex);exit;
        }
        
        
        
        
        try{
            

            
            
            $action = new \Martin_Wms\Action\RemoveInvalidBookingItems();
            $action -> execute(); 
            
            
            $warehouse = Mage::getModel('warehouse/warehouse')->load(1);
            var_dump($warehouse->getData());exit;
            
            
            
            
            
            
            
            
            
            
            $warehouse=Mage::getModel('warehouse/warehouse')->load(1);
            echo Mage::helper('warehouse/url')->getWarehouseChooseUrl($warehouse);
            exit;
            
            
            
            
            
            
            
            
            
            
            
            
            
            $quoteItem=Mage::getModel('sales/quote_item')->load(2540);
            $action = new \Martin_Wms\Action\AddBookingSpace($quoteItem);
            $action->execute();
            echo 'ok';
            exit;
            
            
            
        //$date = $object->getData($attributeCode);
        $date='Feb 3, 2019';
//        var_dump(new Zend_Date(strtotime($date)) );      
//        exit;
//        var_dump(date("M d, y",$date));
//        var_dump($this->_getFormat($date));
//        $date=strtotime($date);
//        var_dump(date("Y-M-d",$date));
//        $zendDate = Mage::app()->getLocale()->storeDate(null, $date, true, "M d, y");
//       var_dump($zendDate->getIso());exit;
            
            
            
            
            
            $quoteItem=Mage::getModel('sales/quote_item')->load(2541);
            $time = \Martin_Wms\SpaceBooking::getToDateFromQuteoItem( $quoteItem )  ;

            
            var_dump($time);
            $dateStr='Feb 2, 2019';
            $dateStr=$time;
            $date=new Zend_Date($dateStr ,null );
            var_dump($date->toString()); exit;
            
//            $name="core_write";
//            $config=Mage::getConfig()->getResourceConnectionConfig($name);
//            var_dump($config);exit;
//            
//            $connections=Mage::getModel('core/resource')->getConnection("write");
//            var_dump($connections);exit;
//            
//            
            
            $action = new \Martin_Wms\Action\RemoveExpiredBookedSpaces();
            
            $action->execute();
            echo 'breakpoint';exit;
            
            $space=Mage::getModel('martinwms/bookingSpace');
            $space->setDateFrom("2019-1-30");
            $space->setDateTo("2019-2-5");
            $flag=\Martin_Wms\SpaceBooking::isBookingSpaceExpired ($space);
            var_dump($flag) ; 
            
            $space=Mage::getModel('martinwms/bookedSpace');
            $space->setDateFrom("2019-1-11");
            $space->setDateTo("2019-1-31");
            $flag=\Martin_Wms\SpaceBooking::isBookedSpaceExpired ($space);
            var_dump($flag) ; 
            exit;
            
            
//            $action = new \Martin_Wms\Action\RemoveExpiredBookingSpace();
//            $action ->execute(); 
            echo 'ok';
            exit;
            
            
            
            
            
            $warehouseId=2;
            $dateFrom="2019-02-01";
            $dateTo="2019-02-8";
            $warehouse=Mage::getModel('warehouse/warehouse')->load($warehouseId);

            $dateFrom= new Zend_Date($dateFrom);
            $dateTo =new Zend_Date($dateTo);
            $quantity=Martin_Wms\SpaceBooking::getMinAvailableQuantity($warehouse, $dateFrom, $dateTo);
            var_dump($quantity);exit;
            
//              Martin_Wms\SpaceBooking::getBookingSpaceByWarehouseId(4);
//              var_dump(get_class($collection));
//              foreach($collection as $item)
//              {
//                  var_dump($item->getData());
//              }
//              echo 'breakpoint';exit;
            
            
            
            $bookedSpace=Mage::getModel('martinwms/bookedSpace')->load(2);
            var_dump($bookedSpace->getData());
            $dateFrom=new Zend_Date($bookedSpace->getDateFrom());
            $dateTo=new Zend_Date($bookedSpace->getDateTo());
            Martin_Wms\SpaceBooking::checkDurationOfSpace($bookedSpace);
            var_dump($dateFrom->compare($dateTo));
            var_dump($dateFrom->addDay(2)->toString("Y-M-d"));
            echo 'breakpoint';exit;
            
//            $quoteItemId="2481";
//$bookingSpace=Mage::getModel('martinwms/bookingSpace')->load($quoteItemId,'quote_item_id');
//var_dump($bookingSpace->getData());exit;
            
//            $action= new \Martin_Wms\Action\Installation\CreateTableForBookingSpace();
//            $action->undo();
//            $action->execute();
//            $action= new \Martin_Wms\Action\Installation\CreateTableForBookedSpace();
//            $action->undo();
//            $action->execute();
//            echo 'ok';exit;
//            
//            
//            $quoteItem=Mage::getModel('sales/quote_item')->load(2477);
//
//            $action = new \Martin_Wms\Action\AddBookingSpace($quoteItem);
//
//            $action->execute(); 
            

            
//            $orderItem=Mage::getModel('sales/order_item')->load(597);
//            $action = new \Martin_Wms\Action\ChangeSpaceToBeBookedFromBooking($orderItem);
//            $action->execute(); 
            

        } catch (Exception $ex) {
             var_dump($ex) ;exit;
        }       

        echo 'ok';
        exit;
    }
    public function indexAction()
    {
        $curWarehouse= \Martin_Wms\SpaceBooking::getCurrentWarehouseChoosedByCustomer();
        $cureWarehouseId=$curWarehouse?$curWarehouse->getId():null;
        var_dump($cureWarehouseId);
        
        $warehosues=Mage::getModel('warehouse/warehouse')->getCollection();
//        $warehosueIds=array();
//        foreach($warehosues as $warehosue)
//        {
//            $warehosueIds[]=$warehosue->getId();
//        }
        
        $block=$this->getLayout()->createBlock('core/template')->setTemplate('wmstest/warehouseSwitcher.phtml');
        $block->setWarehouses($warehosues);
        var_dump($block->getTemplateFile());
        echo $block->toHtml();
            
    }
    
    public function chooseWarehouseAction()
    {
        //var_dump($this->getRequest()->getParams());
        $warehouseId=$this->getRequest()->getParam('warehouse');
        $warehouse=Mage::getModel('warehouse/warehouse')->load($warehouseId);
        var_dump($warehouse->getData());
        \Martin_Wms\SpaceBooking::setCurrentWarehouseChoosedByCustomer($warehouse);
        //Mage::getSingleton('martinwms/session')->setCurrentWarehouse($warehouse);
        //$this->_redirect("*/*/index");
    }
}
