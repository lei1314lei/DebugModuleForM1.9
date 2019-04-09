<?php

class Xtwocn_Debug_AddressController extends Mage_Core_Controller_Front_Action{
    public function indexAction()
    {
        $id=391091886;
        $address=Mage::getModel('sales/quote_address')->load($id);
        $city=$address->getCity()?trim($address->getCity()):null;
        $lastname=$address->getLastname()?trim($address->getLastname()):null;
        $firstname=empty($address->getFirstname())?trim($address->getFirstname()):null;
         var_dump($address->getStreet());exit;
        $street=$address->getStreet()?trim($address->getStreet()):null;
        $postcode=$address->getPostcode()?trim($address->getPostcode()):null;
    }
    
    public function testAction()
    {
        $model= Mage::getModel('warehouse/warehouse');
        $model->load(1);
        var_dump($model->getData());exit;
        
//        
        //Martin_Warehouse_Helper_Country
//        $country=Mage::helper('warehouse/country')->getCountryNameById('CN');
//        var_dump($country);exit;
          $test=Mage::getModel('warehouse/attribute_source_country');
          var_dump($test->getAllOptions());exit;
        
                $collection = Mage::getModel('warehouse/city')->getResourceCollection();
                $options = $collection->toOptionArray();
                var_dump($options);
                EXIT;
        
        
        $data=Mage::getModel('warehouse/warehouse')->load(1)->getData();
        
        var_dump($data);exit;
            $collection = Mage::getModel('directory/country')->getResourceCollection()
                ->loadByStore();
                $options = $collection->toOptionArray('please select');
                var_dump($options);
    }
}
