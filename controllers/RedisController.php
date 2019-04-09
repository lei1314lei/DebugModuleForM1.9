<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RedisController
 *
 * @author martin.tian
 */
class Xtwocn_Debug_RedisController extends Mage_Core_Controller_Front_Action{
    protected $_redisClient;


    protected function _getRedisClient()
    {
        if(!$this->_redisClient)
        {
//            $host='127.0.0.1';
            $host='192.168.10.175';
            $this->_redisClient = new \Credis_Client($host);
            try{
                $this->_redisClient->connect();
            } catch (CredisException $ex) {
                 var_dump($ex); exit;
            }
            
        }
        return $this->_redisClient;
    }
    /**
     * @return Array array(
     *    'key'=>$dateStr,
     *    'value'=>$capability,
     *    'et'=>$expiredTime
     * )
     */
    protected function _recordOneRow($key,$value,$dateStr,$et=null)
    {
        echo "$key<br>";
        $result = $this->_getRedisClient()->zAdd($key, $value, $dateStr);
        var_dump($result);
    }
    protected function _addBookedItemToRecords($startDate,$endDate,$capability,$warehouseId,$orderId)
    {
        $keyForAllBookedItem="bookedItems:warehouse$warehouseId:order$orderId";
        $singleDate=clone $startDate;
        while($singleDate->compare($endDate)<=0)
        {
            $this->_recordOneRow($keyForAllBookedItem,$capability,$singleDate->get('Y-M-d'));
            $singleDate->addDay(1);
        }
    }


    public function indexAction()
    {
        $warehouseId=2;
        
        
        $startDate= new \Zend_Date("2019-04-01");
        $endDate=new \Zend_Date("2019-04-04");
        $capability=3;
        $orderId=1;
        $this->_addBookedItemToRecords($startDate, $endDate, $capability, $warehouseId, $orderId);
        
        
        $startDate= new \Zend_Date("2019-04-02");
        $endDate=new \Zend_Date("2019-04-03");
        $capability=1;
        $orderId=2;
        $this->_addBookedItemToRecords($startDate, $endDate, $capability, $warehouseId, $orderId);
        
        
        
        $keyForAllBookedItem="bookedItems:warehouse2";
        $this->_getRedisClient()->zunionstore($keyForAllBookedItem ,array("bookedItems:warehouse2:order1","bookedItems:warehouse2:order2" ));
        
        
       
        
        echo 'breakpoint';exit;
        
//        $redis->set("test", "good");
//        $time=microtime();
//        
//        var_dump($redis->get('test'));
//        echo microtime()-$time;
    }
}
