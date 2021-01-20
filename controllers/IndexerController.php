<?php

class Martin_Debug_IndexerController extends Mage_Core_Controller_Front_Action{

    public function reindexChangedAction(){
        $talbe = Mage::helper('enterprise_index')->getIndexerConfigValue('catalog_product_price', 'index_table');
        $client = Mage::getModel('enterprise_mview/client');
        $client->init($talbe);
        $client->execute('enterprise_catalog/index_action_product_price_refresh_changelog');
        echo 'ok';
    }
    public function catalogsearchAction()
    {
        //Wyomind_Elasticsearch_Model_Indexer_Fulltext
        Mage::getModel('elasticsearch/Indexer_Fulltext')->reindexAll();
    }


    public function priceAction()
    {
        $helper = Mage::helper('enterprise_cataloginventory/index');
       $productIds=array(2636,2637,2638);
       // $productIds=array(2635);
        if ($helper->isLivePriceAndStockReindexEnabled()) {
            foreach($productIds as $productId)
            {
                //$productId = 2635;
                $client = Mage::getModel('enterprise_mview/client');
                $metadataTableName=$helper->getIndexerConfigValue('catalog_product_price', 'index_table');
                $client->init($metadataTableName);

                $arguments = array(
                    'value' => $productId,
                );
                $client->execute('enterprise_catalog/index_action_product_price_refresh_row', $arguments);
            }

        }
 echo 'haha';
        exit;





        $metadataTableName=Mage::helper('enterprise_index')->getIndexerConfigValue('catalog_product_price', 'index_table');
        $client = Mage::getModel('enterprise_mview/client');
        var_dump($metadataTableName);
        $client->init($metadataTableName);
        $client->execute('enterprise_catalog/index_action_product_price_refresh');
        echo 'here is ok';
        exit;
        //enterprise_index
        //Mage::helper('enterprise_index');


        //catalog_product_price
        $indexCode='catalog_product_price';
        $factory = new Mage_Core_Model_Factory();
        $indexer=$factory->getSingleton($factory->getIndexClassAlias());

        $processes=$indexer->getProcessesCollectionByCodes(array($indexCode));
        foreach($processes as $process)
        {
            $process->reindexEverything();
            $eventName=$process->getIndexerCode() . '_shell_reindex_after';
            var_dump($eventName) ;
            //catalog_product_price_shell_reindex_after
            //cataloginventory_stock_shell_reindex_after
            if('catalog_product_price_shell_reindex_after'==$eventName)
            {

            }else{

                Mage::dispatchEvent($eventName);
            }

        }

        echo 'ok';
    }


    public function testAction()
    {
        $helper=Mage::helper('martindebug/data_tree_backtrace');
        var_dump($helper->getTree());exit;
        //Mage_Catalog_Model_Resource_Category_Tree
        $catTree=Mage::getResourceModel('catalog/category_tree');
        $catTree->loadNode(5);
                //->loadChildren();
        var_dump($catTree);exit;
        
        
        $tree=new Varien_Data_Tree();
        $menu=new Varien_Data_Tree_Node(array(), 'root', $tree);
        
        
         $a=array(
             0=>array('function'=>'function_a','class_a'),
             1=>array('function'=>'function_1','class_1'),
             2=>array('function'=>'function_2','class_2')
         );
         $currentNode;
        foreach($a as $key=>$nodeData)
        {
            if(!$currentNode)
            {
                $node=new Varien_Data_Tree_Node($nodeData, $nodeData['function'], $tree);
                $tree->addNode($node);
                $currentNode=$node;
            }else{
                $node=new Varien_Data_Tree_Node($nodeData, $nodeData['function'], $tree);
                $currentNode->addChild($node);
                $currentNode=$node;
            }
        }
        $currentNode=null;
        
        
        

         $b=array(
           0=>array('function'=>'function_a','class_a'),  
           1=>array('function'=>'function_3','class_3'),
           2=>array('function'=>'function_4','class_4')
         );
        
        foreach($b as $key=>$nodeData)
        {
            if(!$currentNode)
            {
                $node=new Varien_Data_Tree_Node($nodeData, $nodeData['function'], $tree);
                $tree->addNode($node);
                $currentNode=$node;
            }else{
                $node=new Varien_Data_Tree_Node($nodeData, $nodeData['function'], $tree);
                $currentNode->addChild($node);
                $currentNode=$node;
            }
        }
        $currentNode=null;
        
        

         
         
         
        
        //Martin_Debug_Model_Resource_Product_Indexer_Price
        $indexerResource=Mage::getModel('catalog/product_indexer_price')->getResource();
        $indexerResource->reindexAll();exit;
        var_dump($indexerResource);exit;

    }
    public function priceTypeIndexersAction()
    {
        $priceIndexerResource=Mage::getModel('catalog/product_indexer_price')->getResource();
        $typesIndexers=$priceIndexerResource->getTypeIndexers();
        foreach($typesIndexers as $indexer)
        {
            var_dump(get_class($indexer));
        }
    }
    protected function _processses()
    {
        $indexerInterFace=Mage::getModel('index/indexer');
        return $indexerInterFace->getProcessesCollection();
    }
    public function processesAction()
    {
        foreach($this->_processses() as $process)
        {
            
            $processCode=$process->getData('indexer_code');
            echo $processCode,"  (Indexer:",get_class($process->getIndexer()),")","<br>";
//            echo get_class($indexerInterFace->getProcessByCode($processCode));
//            echo "&nbsp;";
            var_dump($process->debug());
        }
    }
//    public function stockIndexersAction()
//    {
//        $indexers=array();
//        $defaultIndexer='cataloginventory/indexer_stock_default';
//        $types = Mage::getSingleton('catalog/product_type')->getTypesByPriority();
//        
//           foreach ($types as $typeId => $typeInfo) {
//                if (isset($typeInfo['stock_indexer'])) {
//                    $modelName = $typeInfo['stock_indexer'];
//                } else {
//                    $modelName = $defaultIndexer;
//                }
//                $isComposite = !empty($typeInfo['composite']);
//                $indexer = Mage::getResourceModel($modelName)
//                    ->setTypeId($typeId)
//                    ->setIsComposite($isComposite);
//
//                $indexers[$typeId] = $indexer;
//                var_dump("stock indexer($typeId):".get_class($indexer));
//            }
//    }
    public function indexersAction()
    {
        try{
            foreach($this->_processses() as $process)
            {
                $code=$process->getData('indexer_code');
                $xmlPath = Mage_Index_Model_Process::XML_PATH_INDEXER_DATA . '/' . $code;
                $config = Mage::getConfig()->getNode($xmlPath);
                if (!$config || empty($config->model)) {
                    Mage::throwException(Mage::helper('index')->__('Indexer model is not defined.'));
                }
                $model = Mage::getModel((string)$config->model);
                
                
                if ($model instanceof Mage_Index_Model_Indexer_Abstract) {
                    echo "<hr>$code : <span style='color:red'> ".get_class($model)."</span><br><br>";
                    $reflection=new ReflectionClass (get_class($model));
                    echo "<br>parentClass:",$reflection->getParentClass()->getName() ,"<br>"; 
                  //  $this->_showMainTable($model);
                } else {
                    Mage::throwException(Mage::helper('index')->__('Indexer model should extend Mage_Index_Model_Indexer_Abstract.'));
                }
            } 
        } catch (Exception $ex) {
            var_dump($ex->getMessage());
        }
    }
    protected function _showUrlIndexerTable(Mage_Catalog_Model_Indexer_Url $model)
    {
           $resourceModel=Mage::getResourceModel('catalog/url');//Mage_Catalog_Model_Resource_Url;
            $attributeCode='url_key';
            $attribute = $resourceModel->getProductModel()->getResource()->getAttribute($attributeCode);
            echo "<br>table:".$attribute->getBackend()->getTable();
            $attributeCode='url_path';
            $attribute = $resourceModel->getProductModel()->getResource()->getAttribute($attributeCode);
            echo "<br>table:".$attribute->getBackend()->getTable();
    }
    protected function _showMainTable($model)
    {
        $sureSlogan="<br><span style='color:blue'>i'm sure mainTable is right</span>";
        if($model instanceof Mage_Catalog_Model_Indexer_Url)
        {
              echo $sureSlogan;
              $this->_showUrlIndexerTable($model);
            
        }elseif($model instanceof Mage_Catalog_Model_Product_Indexer_Flat){
            echo $sureSlogan;
            $resourceModel=Mage::getResourceModel('catalog/product_flat_indexer');
            foreach(Mage::app()->getStores() as $storeId=>$store)
            {
                echo "<br>".$resourceModel->getFlatTableName($storeId);
            }
        }elseif($model instanceof Mage_Catalog_Model_Category_Indexer_Flat)
        {
            echo $sureSlogan;
            $resourceModel=Mage::getResourceSingleton('catalog/category_flat');
            foreach(Mage::app()->getStores() as $storeId=>$store)
            {
                echo "<br>".$resourceModel->getMainStoreTable($storeId);
            }

        }
        elseif($model instanceof Bubble_Elasticsearch_Model_Indexer_Category)
        {

        }elseif($model instanceof Bubble_Elasticsearch_Model_Indexer_Cms)
        {

        }
        else{
            if($model instanceof  Mage_Catalog_Model_Product_Indexer_Price)
            {
                echo $sureSlogan;
            }elseif($model instanceof Mage_Catalog_Model_Category_Indexer_Product){
                echo $sureSlogan;
            }
            $resourceModel=$model->getResource();
            $mainTable=$resourceModel->getMainTable();
          //  echo "<br>indexer:".get_class($resourceModel);
            echo "<br><strong>mainTable</strong>:".$mainTable;
        }
    }
}
