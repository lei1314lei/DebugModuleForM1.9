<?php

class Martin_Debug_Cron_JobsController extends Mage_Core_Controller_Front_Action{

    public function indexAction()
    {
       // var_dump( Mage::getStoreConfig('payment/wrcd_alipayxborder/interval_time_to_cancel'));exit;
        $config = Mage::getConfig()->getNode('crontab/jobs');
        if ($config instanceof Mage_Core_Model_Config_Element) {
            foreach($config->children() as $jobCode=>$jobConfig)
            {
                $cronExpr = Mage::getStoreConfig((string)$jobConfig->schedule->config_path);
                echo "<hr>";
                var_dump($jobCode,$jobConfig->schedule->config_path,$cronExpr);
            }
        }
    }
}
