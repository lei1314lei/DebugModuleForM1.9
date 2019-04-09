<?php

class Xtwocn_Debug_CmsController extends Mage_Core_Controller_Front_Action{
    public function updateBlocksByFileSourcesAction()
    {
        try{
            
            $strategyForBlockItemsUpdation= new \Martin_Cms\StrategyForBlocksUpdation();
            $action = new \Martin_Data\Action\UpdateItemsInSystem($strategyForBlockItemsUpdation);
            
            $action->execute();
            echo 'ok' ;exit;
        } catch (Exception $ex) {
            var_dump($ex);exit;
        }
    }

    public function indexAction()
    {

        $this->loadLayout();
        
        $this->renderLayout();
    }
    public function testAction()
    {
        $this->getLayout()->getUpdate()->getHandles();
    }
}

