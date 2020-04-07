<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TestController
 *
 * @author martin.tian
 */
class Martin_Debug_TestController extends Mage_Core_Controller_Front_Action
{
    public function orderAction()
    {
        $storeId=Mage::app()->getStore()->getStoreId();
        $entityType = Mage::getSingleton('eav/config')
            ->getEntityType('order');
        $incrementId=  $entityType->fetchNewIncrementId($storeId);
        var_dump($incrementId);exit;
    }

    protected function _findOutEndPaths(Array $paths)
    {
        $count=count($paths);
        $timer=0;
        while($timer<$count && $cPath=array_shift($paths))
        {
            $timer++;
            $isEndNote=true;
            foreach($paths as $path)
            {
                if(strpos($path,$cPath)!==false)
                {
                    $isEndNote=false;
                }
            }
            if($isEndNote)
            {
                array_push($paths,$cPath);
            }
        }
        return $paths;
    }

    protected function _findOutOneOfAvailableDeepestCategoryId($product)
    {

        $categoryCollection=$product->getCategoryCollection();
        foreach($categoryCollection as $category)
        {

            $categoryId=$category->getId();
            $path=$category->getPath();
            $pathsAndCategoryId[$path]=$categoryId;
        }
        $endPaths=$this->_findOutEndPaths(array_keys($pathsAndCategoryId));
        $activeCategories=$product->getAvailableInCategories();
        foreach($endPaths as $path)
        {
            $categoryId=$pathsAndCategoryId[$path];
            if(in_array($categoryId,$activeCategories))
            {
                return $categoryId;
            }
        }
    }

	public function indexAction()
	{
	    $product=Mage::getModel('catalog/product')->load(10293);


	    $product->setPrice(111);

        $product->save();

        exit;

//        $serializedId="s_id_1";
//        $secondHandProduct=Toolots_Strategy_Model_SecondHand_Factory_Product::factory($serializedId);
        Mage::getModel('catalog/product')->load(10291);
       return ;



        $config=Mage::getSingleton('enterprise_logging/config');

        var_dump($config->isActive("api_v2_soap_index"));
        //
        var_dump($config->isActive("adminhtml_catalog_product_edit"));
        exit;







        $collection=Mage::getModel('catalog/product')->getCollection();
        $collection->addCanShowInCategoryFilter();
        echo $collection->getSelect();
        var_dump($collection);
        exit;




        $collection=Mage::getResourceModel('reports/order_collection');
        var_dump($collection);


        ;exit;

        var_dump(Mage::helper( 'adminhtml/dashboard'));exit;
	    var_dump(Mage::helper('adminhtml/dashboard_order'));exit;
        $orderCollection=Mage::getResourceSingleton('reports/order_collection');
        var_dump($orderCollection);exit;




//	    $arr=array(
//	        "1/2",
//            "1/2/35",
//            "1/26/28",
//            "1/2/35/42",
//            "1/26"
//        );
        $arr=array(
            '1/2',
            '1/2/836/870/890',
            '1/2/836/870/370',
            '1/2/402',
            '1/2/836',
            '1/2/402/413',
//            '1/2/836/870',
            '1/2/836/870/370/42'
        );

//        $endPaths=$this->_findOutEndPaths($arr);
//        var_dump($endPaths);
//        exit;


        $product=Mage::getModel('catalog/product')->load(3187);

        $categoryId=Mage::helper('strategy/OtherModelsLikeThisProduct')->findOutOneOfAvailableDeepestCategoryId($product);
        var_dump('ok',$categoryId);

//        $categoryId=$this->_findOutOneOfAvailableDeepestCategoryId($product);





exit;






        $ebayOrder = Mage::getModel('M2ePro/Ebay_Order_Builder');
        $ebayOrder->process();

        exit;



        $ebayOrder = Mage::getModel('M2ePro/Ebay_Order_Builder');
        var_dump($ebayOrder);
        exit;

        $existOrders = Mage::helper('M2ePro/Component_Ebay')
            ->getCollection('Order')
            ->addFieldToFilter('account_id', 5)
            ->addFieldToFilter('ebay_order_id', 3)
            ->setOrder('id', Varien_Data_Collection_Db::SORT_ORDER_DESC);

        var_dump(get_class($existOrders->getNewEmptyItem()));
        echo $existOrders->getSelect(),"<hr>";




        $itemsCollection = Mage::helper('M2ePro/Component')
            ->getComponentCollection("ebay", 'Order_Item')
            ->addFieldToFilter('order_id', 1);
        echo $itemsCollection->getSelect();

        exit;


	    //Ess_M2ePro_Model_Cron_Task_Ebay_Channel_SynchronizeChanges
        $task=Mage::getModel('M2ePro/Cron_Task_Ebay_Channel_SynchronizeChanges');

        $accountId=5;
        $lockItemManager = Mage::getModel(
            'M2ePro/Lock_Item_Manager', array('nick' => "CreateFailed".$accountId)
        );



        $task->setLockItemManager($lockItemManager);
        $task->process();
        exit;


	    //Ess_M2ePro_Model_Cron_Task_Ebay_Order_Update

        $task=Mage::getModel('M2ePro/Cron_Task_Ebay_Order_Update');

        $accountId=5;
        $lockItemManager = Mage::getModel(
            'M2ePro/Lock_Item_Manager', array('nick' => "CreateFailed".$accountId)
        );



        $task->setLockItemManager($lockItemManager);
        $task->process();
        exit;




	    //Ess_M2ePro_Model_Cron_Task_Ebay_Order_CreateFailed
        $task=Mage::getModel('M2ePro/Cron_Task_Ebay_Order_CreateFailed');

        $accountId=5;
        $lockItemManager = Mage::getModel(
            'M2ePro/Lock_Item_Manager', array('nick' => "CreateFailed".$accountId)
        );



        $task->setLockItemManager($lockItemManager);
        $task->process();
        exit;


        $authKey = Mage::helper('M2ePro/Module')->getConfig()
            ->getGroupValue('/cron/service/', 'auth_key');
        $cronRunner=Mage::getModel('M2ePro/Cron_Runner_Service');
        $authKey && $cronRunner->setRequestAuthKey($authKey);

        $cronRunner->setRequestConnectionId("12345");
	    //Ess_M2ePro_Model_Cron_Runner_Service

        $cronRunner->process();
        echo 'ok';
        exit;


        $accounts = Mage::getModel('M2ePro/Account')->getCollection()
            ->addFieldToFilter('component_mode', Ess_M2ePro_Helper_Component_Ebay::NICK);
echo $accounts->getSelect();
        foreach ($accounts as $account) {
            var_dump($account->getId());
            continue;

            if ($account->getChildObject()->isPickupStoreEnabled()) {
                return $account;
            }
        }
        exit;



        $isDevelopmentEnvironment=Mage::helper('M2ePro/Module')->isDevelopmentEnvironment();
        var_dump($isDevelopmentEnvironment);exit;

        $listingId=1;
        $listing = Mage::helper('M2ePro/Component_Ebay')->getCachedObject('Listing', $listingId);
        var_dump($listing->getSettings('additional_data'));exit;

        $productAddIds= Mage::helper('M2ePro')->jsonEncode(array());
        var_dump($productAddIds);exit;


        $imgSrc='333-201911/24814_20235248.jpg';
//        $refurbishedProduct=Mage::getModel('catalog/product')->load(10293);
//        echo Mage::helper('catalog/image')->init($refurbishedProduct, 'haha_test', $imgSrc)->resize(38, 50);


        //Toolots_Strategy_Model_SecondHand_ImageModel
        echo Mage::helper('strategy/image')->init("strategy/secondHand_imageModel",$imgSrc)->resize(30, 40);
        exit;


	}
}
