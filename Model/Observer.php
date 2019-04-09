<?php

class Xtwocn_Debug_Model_Observer{
    public function debugBlock(Varien_Event_Observer $observer){
        $block=$observer->getEvent()->getBlock();
        $helper=Mage::helper('xtwocndebug');
        $app=Mage::app();
        if($helper->showLayoutXml()){
            if($block->getNameInLayout()=='root'){
                $layoutString=$app->getLayout()->getUpdate()->asString();
                echo ($helper->xmlToHtml($layoutString)) ; exit;
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
        if($helper->showActionDetail())
        {
            $action=$observer->getData('controller_action');
            $request=$action->getRequest();
            var_dump( array(
                "Module"=>$request->getControllerModule(),
                "module name"=> $request->getModuleName(),
                "action name"=>$request->getActionName(),
                "controller name"=>$request->getControllerName(),
                        ));
        }
    }
    public function showHandles(Varien_Event_Observer $observer)
    {
        $helper=Mage::helper('xtwocndebug');
        if($helper->showHandles())
        {
            $action=$observer->getData('controller_action');
            $handles = $action->getLayout()->getUpdate()->getHandles();
            echo "<hr>handles:";
            var_dump($handles);
        }

    }
}
