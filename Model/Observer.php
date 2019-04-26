<?php

class Xtwocn_Debug_Model_Observer{
	
    public function logLayoutFileMergingInfoes(Varien_Event_Observer $observer)
    {
	    $helper=Mage::helper('xtwocndebug');
	    if($helper->debugTriggered())
	    {
		$infoes=$observer->getEvent()->getData('debugInfoes');
		Mage::log($infoes,null,Xtwocn_Debug_Helper_Data::LOG_LAYOUT_MERGING);
	    }
    }
    public function logRouterMatchingInfoes(Varien_Event_Observer $observer)
    {
	    $helper=Mage::helper('xtwocndebug');
	    if($helper->debugTriggered())
	    {
		$infoes=$observer->getEvent()->getData('routerMatchingInfoes');
		Mage::log($infoes,null,Xtwocn_Debug_Helper_Data::LOG_ROUTER_MATCHING);
	    }
    }
    public function debugBlock(Varien_Event_Observer $observer){
        $block=$observer->getEvent()->getBlock();
        $helper=Mage::helper('xtwocndebug');
        $app=Mage::app();
        //if($helper->showLayoutXml()){
	if($helper->debugTriggered()){
            if($block->getNameInLayout()=='root'){
                $layoutString=$app->getLayout()->getUpdate()->asString();
                //echo ($helper->xmlToHtml($layoutString)) ; exit;
		Mage::log($layoutString,null,Xtwocn_Debug_Helper_Data::LOG_LAYOUT_XML);
            }
        }
        if($helper->hintTemplate()){
            if($block instanceof Mage_Core_Block_Template){
                $app->getStore()->setConfig(Mage_Core_Block_Template::XML_PATH_DEBUG_TEMPLATE_HINTS,1);
                $app->getStore()->setConfig(Mage_Core_Block_Template::XML_PATH_DEBUG_TEMPLATE_HINTS_BLOCKS,1);
            }
        }
    }
    public function filterJobs(Varien_Event_Observer $observer)
    {
        $helper=Mage::helper('xtwocndebug/cron');
        $helper->filterJobs();
    }
    public function showAction(Varien_Event_Observer $observer)
    {
        $helper=Mage::helper('xtwocndebug');
        if($helper->debugTriggered())
        {
            $action=$observer->getData('controller_action');
            $request=$action->getRequest();
            $infoes=array(
                "Module"=>$request->getControllerModule(),
                "module name"=> $request->getModuleName(),
                "action name"=>$request->getActionName(),
                "controller name"=>$request->getControllerName(),
                        );
	    Mage::log($infoes,null,Xtwocn_Debug_Helper_Data::LOG_REQUEST);
        }
    }
    public function showHandles(Varien_Event_Observer $observer)
    {
        $helper=Mage::helper('xtwocndebug');
        if($helper->debugTriggered())
        {
            $action=$observer->getData('controller_action');
            $handles = $action->getLayout()->getUpdate()->getHandles();
            Mage::log($handles,null,Xtwocn_Debug_Helper_Data::LOG_HANDLES);
        }

    }
}
