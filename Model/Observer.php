<?php

class Martin_Debug_Model_Observer{
    protected function _exactMatch($bool,$q)
    {
        $fields=array("_categories^5","name");
        if (!empty($fields)) {
            $query = new \Elastica\Query\MultiMatch();
            $query->setQuery($q);
            $query->setType('phrase_prefix');
            $query->setFields($fields);
            $query->setParam("boost",1000);
            $bool->addShould($query);
        }
        $fields=array("tpin","upc_code","sku.keyword");
        if (!empty($fields)) {
            $query = new \Elastica\Query\MultiMatch();
            $query->setQuery($q);
            $query->setType('most_fields');
            $query->setFields($fields);
            $query->setParam("boost",1000);
            $query->setMinimumShouldMatch('100%');
            $bool->addShould($query);
        }
    }
    public function changeToBeSearchV3(Varien_Event_Observer $observer)
    {
        if(isset($_REQUEST['v3'])) {
            $search = $observer->getEvent()->getData('search');
            $q = $observer->getEvent()->getData('q');
            $query = $search->getQuery();

            $suggest = $query->getParam('suggest');
            $size = $query->getParam('size');


            $functionScoreQuery = $query->getQuery('query');
            $boolQuery = $functionScoreQuery->getParam('query');
            $this->_exactMatch($boolQuery, $q);

            $newFunctionScoreQuery = new \Elastica\Query\FunctionScore();

            $newFunctionScoreQuery->setQuery($boolQuery);
            $functionParams = array(
                "field" => "stock_status",
                "factor" => 2,
                "modifier" => "log2p",
                "missing" => 0
            );

            $newFunctionScoreQuery->addFunction("field_value_factor", $functionParams);

            $newFunctionScoreQuery->setBoostMode(\Elastica\Query\FunctionScore::BOOST_MODE_MULTIPLY);
            $search->setQuery($newFunctionScoreQuery);


            $search->getQuery()->setSize($size);
            $search->getQuery()->setSuggest($suggest);


//            echo json_encode($search->getQuery()->toArray());
//            exit;
        }
    }
    public function logLayoutFileMergingInfoes(Varien_Event_Observer $observer)
    {
	    $helper=Mage::helper('martindebug');
	    if($helper->debugTriggered())
	    {
		$infoes=$observer->getEvent()->getData('debugInfoes');
		Mage::log($infoes,null,Martin_Debug_Helper_Data::LOG_LAYOUT_MERGING);
	    }
    }
    public function logRouterMatchingInfoes(Varien_Event_Observer $observer)
    {
	    $helper=Mage::helper('martindebug');
	    if($helper->debugTriggered())
	    {
		$infoes=$observer->getEvent()->getData('routerMatchingInfoes');
		Mage::log($infoes,null,Martin_Debug_Helper_Data::LOG_ROUTER_MATCHING);
	    }
    }
    public function debugBlock(Varien_Event_Observer $observer){
        $block=$observer->getEvent()->getBlock();
        $helper=Mage::helper('martindebug');
        $app=Mage::app();
        //if($helper->showLayoutXml()){
	if($helper->debugTriggered()){
            if($block->getNameInLayout()=='root'){
                $layoutString=$app->getLayout()->getUpdate()->asString();
                //echo ($helper->xmlToHtml($layoutString)) ; exit;
		Mage::log($layoutString,null,Martin_Debug_Helper_Data::LOG_LAYOUT_XML);
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
        $helper=Mage::helper('martindebug/cron');
        $helper->filterJobs();
    }
    public function showAction(Varien_Event_Observer $observer)
    {
        $helper=Mage::helper('martindebug');
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
	    Mage::log($infoes,null,Martin_Debug_Helper_Data::LOG_REQUEST);
        }
    }
    public function showHandles(Varien_Event_Observer $observer)
    {
        $helper=Mage::helper('martindebug');
        if($helper->debugTriggered())
        {
            $action=$observer->getData('controller_action');
            $handles = $action->getLayout()->getUpdate()->getHandles();
            Mage::log($handles,null,Martin_Debug_Helper_Data::LOG_HANDLES);
        }

    }
}
