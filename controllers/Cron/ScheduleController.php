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
       $html=<<<ELO
          <h1> I assume that you are trying to match \$expr with \$num ,here are several situations and variables (\$expr,\$from,\$to,\$mod)
           <br>you need figure out what they really are </h1>
          <ul>
               <li>
                    <span>situation 1: if the \$expr is '* '</span>
                    <p> always be treated as ture</p>
               </li>
               <li>
                    <span>situation 2: if the \$expr is like '\d,\d,\d' </span>
                    <p> every single number(\d) will be used to match \$num , this situation will be treated as ture if there is any one of them equal to \$num</p>
               </li>
               <li>
                    <p>
                         situation 3: '\$expr' means to be '\$form-\$to/\$mod '
                         <br>In this situation : the rule of matching will to be '(\$num>=\$from) && (\$num<=\$to) && (\$num%\$mod===0);' 
                         <br>Next, I'll tell how to figure out what \$form/\$to/\$mod is by \$expr
                    
                    </p>
                    <ul>
                        <li>
                             <p>For \$mod ,there are two situations.
                                <br>If \$epxr doesn't contain '/' , then \$mod will be 1 ; 
                                <br>If \$epxr can be separated by '/' into two parts  ,then the second part will be tread as \$mod
                                <br> For some instances: <br>
                                    \$mod will be 1 in those \$expr '*' or '12' or '20-30' 
                                <br> \$mod will be 3  in the \$expr '*/3' or '12/3' or '20-30/3' 
                             </p>
                        </li>
                        <li>
                             <p>For \$from and \$to , there are several situations.
                                <br>If \$expr is  '*' or '*/\$mod' , then \$form is 0 and \$to is 60
                                <br>If \$expr is  '12' or '12/\$mod' , then \$form is 12 and \$to is 12
                                <br>If \$expr is  '20-30/\$mod' or '20-30/\$mod' , then \$form is 20 and \$to is 30
                             </p>
                        </li>
                    </ul>
               </li>
          </ul>
ELO;
       echo $html;



        $schedule = Mage::getModel('cron/schedule');

        $conditions=array(
            array("expr"=>"*","num"=>3,"explanation"=>"num is 3; from is 0 ; to is 60; mod is 1"),
            array("expr"=>"1,2,3","num"=>3 , "explanation"=>"num is 3; from is 0 ; to is 60; mod is 1"),
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



//        // handle ALL match
//        if ($expr==='*') {
//            return true;
//        }
//
//        // handle multiple options
//        if (strpos($expr,',')!==false) {
//            foreach (explode(',',$expr) as $e) {
//                if ($this->matchCronExpression($e, $num)) {
//                    return true;
//                }
//            }
//            return false;
//        }
//
//        // handle modulus
//        if (strpos($expr,'/')!==false) {
//            $e = explode('/', $expr);
//            if (sizeof($e)!==2) {
//                throw Mage::exception('Mage_Cron', "Invalid cron expression, expecting 'match/modulus': ".$expr);
//            }
//            if (!is_numeric($e[1])) {
//                throw Mage::exception('Mage_Cron', "Invalid cron expression, expecting numeric modulus: ".$expr);
//            }
//            $expr = $e[0];
//            $mod = $e[1];
//        } else {
//            $mod = 1;
//        }
//
//        // handle all match by modulus
//        if ($expr==='*') {
//            $from = 0;
//            $to = 60;
//        }
//        // handle range
//        elseif (strpos($expr,'-')!==false) {
//            $e = explode('-', $expr);
//            if (sizeof($e)!==2) {
//                throw Mage::exception('Mage_Cron', "Invalid cron expression, expecting 'from-to' structure: ".$expr);
//            }
//
//            $from = $this->getNumeric($e[0]);
//            $to = $this->getNumeric($e[1]);
//        }
//        // handle regular token
//        else {
//            $from = $this->getNumeric($expr);
//            $to = $from;
//        }
//
//        if ($from===false || $to===false) {
//            throw Mage::exception('Mage_Cron', "Invalid cron expression: ".$expr);
//        }
//
//        return ($num>=$from) && ($num<=$to) && ($num%$mod===0);


        exit;
    }
}