<?php
class Martin_Debug_ELS_SearchController extends Mage_Core_Controller_Front_Action
{


    public function queryBuildingAction()
    {
        $helper=Mage::helper('elasticsearch');
        $q="safety";
        $store=1;
        $typeName='product';
        $indexName="local_english_idx1";
        $client=$helper->getClient($store);
//        $index = new Wyomind_Elasticsearch_Index($client,$indexName);
        $index=$client->getStoreIndex($store);

        $indexer = $this->_indexer($typeName,$store);

        $type = new Wyomind_Elasticsearch_Type($index,$typeName);
        $type->setIndexProperties($indexer->getStoreIndexProperties($store));
        $type->setAdditionalFields($indexer->getAdditionalFields());

        $search = $client->getSearch2($type, $q);

        echo json_encode($search->getQuery()->toArray());exit;


        $result=$client->search2($q, $store );



    }
    protected function _indexer($type,$store=1)
    {
        $helper=Mage::helper('elasticsearch');
        $client=$helper->getClient($store);
        $indexer=$client->getIndexer($type);
        return $indexer;
    }
    public function mappingAction()
    {
        $helper=Mage::helper('elasticsearch');
        $store=1;
        $type='product';
        $client=$helper->getClient($store);
        $indexer=$client->getIndexer($type);
        $properties=$indexer->getStoreIndexProperties($store);
        var_dump($properties);
        exit;
    }

    public function testAction()
    {
        $query="2K1535";
        $engine = Mage::helper('catalogsearch')->getEngine();
        $search = $engine->search($query);
        $query=$search->getQuery();
        echo json_encode($query->toArray());

echo "<hr>";
        $search = $engine->search2($query);
        $query=$search->getQuery();

        exit;
    }
}