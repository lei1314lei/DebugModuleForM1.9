<?php
class Martin_Debug_Cron_ScheduleController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {

    }
    public function generateAction()
    {
        //Mage::app()->saveCache(time(), self::CACHE_KEY_LAST_SCHEDULE_GENERATE_AT, array('crontab'), null);
        Mage::app()->removeCache(Mage_Cron_Model_Observer::CACHE_KEY_LAST_SCHEDULE_GENERATE_AT);
        Mage::getModel('cron/observer')->generate();
        echo 'ok';
    }

//$match = $this->matchCronExpression($e[0], $d['minutes'])
//&& $this->matchCronExpression($e[1], $d['hours'])
//&& $this->matchCronExpression($e[2], $d['mday'])
//&& $this->matchCronExpression($e[3], $d['mon'])
//&& $this->matchCronExpression($e[4], $d['wday']);
    public function tryAction()
    {
        $jobCode="test";
        $cronExpr="0 0 * * *";
        $schedule = Mage::getModel('cron/schedule');
        $schedule->setJobCode($jobCode)
            ->setCronExpr($cronExpr)
            ->setStatus(Mage_Cron_Model_Schedule::STATUS_PENDING);
    }

    public function matchAction()
    {
        $schedule = Mage::getModel('cron/schedule');

        $conditions=array(
            array("expr"=>"*","num"=>3),
            array("expr"=>"1,2,3","num"=>3 ),
            array("expr"=>"*/3","num"=>3 ),
            array("expr"=>"1-12/3","num"=>3),
            array("expr"=>"1-13/6","num"=>3),
            array("expr"=>"1-13/2","num"=>6),
            array("expr"=>"12/3","num"=>3),


        );

        foreach($conditions as $condition)
        {
            extract($condition);
            $isMatch=$schedule->matchCronExpression($expr,$num);

            echo "<hr>","expression '$expr'' ".($isMatch?" ":"not ")."match num '$num''";

        }
        exit;
    }
}