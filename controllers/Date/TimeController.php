<?php
class Martin_Debug_Date_TimeController extends Mage_Core_Controller_Front_Action{
    public function zoneAction()
    {
        $action = Mage::getModel('toolots_report/actions_sendReport_weeklySalesOfShangHai');
        $action->execute();
        echo 'breakpoint';exit;




        $d = getdate(Mage::getSingleton('core/date')->timestamp(time()));
        var_dump($d);


//        $locale=Mage::app()->getLocale();
//        var_dump($locale->getLocaleCode(),get_class_methods($locale));
//        date_default_timezone_set(Mage_Core_Model_Locale::DEFAULT_TIMEZONE);
//        echo "<hr>";
        var_dump(time(),date('Y-m-d H:i:s'));
        var_dump(ini_get('date.timezone'));
        var_dump(time(),date('Y-m-d H:i:s'));
        ini_set('date.timezone','Asia/Shanghai');
        var_dump(ini_get('date.timezone'));
        var_dump(time(),date('Y-m-d H:i:s'));
        exit;
    }
}