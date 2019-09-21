<?php
class Martin_Debug_Cron_EventsController extends Mage_Core_Controller_Front_Action{
    public function indexAction()
    {
        $events=Mage::app()->getConfig()->getNode('crontab/events');
        if ($events) {
            $events = $events->children();
            foreach($events as $eName=> $event)
            {
                echo "<hr>";
                var_dump($eName,$event->asArray());
            }
        }

    }
}