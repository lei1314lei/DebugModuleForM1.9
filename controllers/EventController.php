<?php
require_once Mage::getModuleDir('controllers', 'Martin_Debug').DS.'AbstractController.php';
class Martin_Debug_EventController extends Martin_Debug_AbstractController
{
    public function indexAction(){
       $observer =  Mage::getModel('strategy/secondHand_inventory_observer');
       $a='';
//       $ref = new \ReflectionClass($observer);
//       var_dump($ref->getFileName());
//       exit;
//       $observer->test();
       $observer ->revertQuoteInventory($a);
        exit;
        $cfg = Mage::app()->getConfig()->getNode('global/events/sales_model_service_quote_submit_failure');
        var_dump($cfg);
    }
}