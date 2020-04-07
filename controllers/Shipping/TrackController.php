<?php
class Martin_Debug_Shipping_TrackController extends Mage_Core_Controller_Front_Action
{
    public function hashByTrackAction()
    {
        $trackNo='403934084723025';
        $helper=Mage::helper('shipping');
        $url = $helper->getTrackingPopUpUrlByTrackId($trackNo);
        var_dump($url);
        exit;
    }
    public function hashByShipmentAction()
    {
        $shipmentId="";
        $helper=Mage::helper('shipping');
        $url = $helper->getTrackingPopUpUrlByShipId("");
        var_dump($url);
        exit;
    }

    public function trackingUrlByShipIdAction()
    {
        $shipmentId='1679';
        $helper=Mage::helper('shipping');
        $url = $helper->getTrackingPopUpUrlByShipId($shipmentId);
        var_dump($url);
    }
    public function trackingUrlByOrderIdAction()
    {
        $orderId="1885";
        $helper=Mage::helper('shipping');
        $url = $helper->getTrackingPopUpUrlByOrderId($orderId);
        var_dump($url);
    }
    public function hashAction()
    {
        //c2hpcF9pZDoxNTE2OmJlMTNkZA,,
        $hash="c2hpcF9pZDoxNTE2OmJlMTNkZA,,";
        $helper = Mage::helper('shipping');
        $data = $helper->decodeTrackingHash($hash);
        var_dump($data);exit;
    }

    public function addFakeTrackForFedExAction()
    {

        // 取一个有shipment的order
        $order=Mage::getModel('sales/order')->load(1702);
        $shipments=$order->getShipmentsCollection();
        foreach($shipments as $shipment)
        {
            //create a testing track record for $shipment
            $trackNo='403934084723025';  //a testing track number for FedEx
            $carrierCode="fedex";
            $shipmentId=$shipment->getId();
            $orderId=$shipment->getOrderId();
            $orderTrack=Mage::getModel('sales/order_shipment_track') ;
            $orderTrack->setTrackNumber($trackNo)
                ->setOrderId($orderId)
                ->setCarrierCode($carrierCode)
                ->setParentId($shipmentId);
            $orderTrack->save();

            //generate tracking url
            $shipmentId=$shipment->getId();
            $helper=Mage::helper('shipping');
            $url = $helper->getTrackingPopUpUrlByShipId($shipmentId);
            var_dump($url);
            break;
        }
        exit;
    }




    public function fedExAction()
    {
        //
        $carrierCode='fedex';
        $trackNo='403934084723025';
        $track = Mage::getModel('sales/order_shipment_track');
        $track->setCarrierCode($carrierCode);
        $track->setNumber($trackNo);
        $trackingInfo = array(array($track->getNumberDetail()));
        Mage::register('current_shipping_info',new Varien_Object(array('tracking_info'=>$trackingInfo)));
        //Mage_Shipping_Block_Tracking_Popup
        $block=$this->getLayout()->createBlock('shipping/tracking_popup');
        $block->setTemplate('shipping/tracking/popup.phtml');
        echo $block->toHtml();exit;
    }

    public function hashByOrderAction()
    {
        $orderId="";
        $helper=Mage::helper('shipping');
        $url = $helper->getTrackingPopUpUrlByOrderId("");
        var_dump($url);
        exit;
    }


    public function infoAction()
    {

//        //UPS_XML
//         Mage::getStoreConfig($path, $this->getStore());

        $carrierCode='ups';
        $path = 'carriers/'.$carrierCode.'/'.'type';
        $type='UPS_XML';
        Mage::app()->getStore()->setConfig($path,$type);

        $trackNo='1Z5RF9320338806757';
        $track = Mage::getModel('sales/order_shipment_track');
        $track->setCarrierCode($carrierCode);
        $track->setNumber($trackNo);
        $trackingInfo = array(array($track->getNumberDetail()));


        Mage::register('current_shipping_info',new Varien_Object(array('tracking_info'=>$trackingInfo)));
        //Mage_Shipping_Block_Tracking_Popup
        $block=$this->getLayout()->createBlock('shipping/tracking_popup');
        $block->setTemplate('shipping/tracking/popup.phtml');
        echo $block->toHtml();exit;

        var_dump($trackingInfo);exit;
        return $trackingInfo;
    }


}