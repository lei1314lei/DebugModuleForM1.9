<?php
class Martin_Debug_Cache_IndexController extends Mage_Core_Controller_Front_Action
{
    public function fullPageCacheIdAction()
    {
        $processor = Mage::getModel('enterprise_pagecache/processor');
        $categoryProcessor =Mage::getModel('enterprise_pagecache/processor_category');
        $cacheId = $processor->prepareCacheId($categoryProcessor->getPageIdInApp($processor));

    }
    public function isOnAction()
    {
        $useCache=Mage::app()->useCache(Mage_Core_Block_Abstract::CACHE_GROUP);
        var_dump($useCache);
        exit;
    }
    public function testAction()
    {
//        $cacheBackend = new Cm_Cache_Backend_Redis([
//            'server'=>'192.168.10.11',
//            'port'=>6379,
//        ]);
//        var_dump($cacheBackend);
//        exit;
        $data='for testing:adsfawerawerqwer';
        $cacheKey='for-testing';
        $tags=['a','b'];
        $lifetime=120;
        $cacheInstance=Mage::app()->getCache(); //cache frontend
        var_dump(get_class($cacheInstance->getBackend()));
        $data = $cacheInstance->load('REQEST_aca22446ed47cc110f7c5d7baf70c6bf');
        var_dump($data);
        exit;
        $result = $cacheInstance->save($data, $cacheKey, $tags, $lifetime);
        var_dump('qiguai',$result);
        echo "<hr>";
        var_dump($cacheInstance->load($cacheKey));
//        exit;
    }
}