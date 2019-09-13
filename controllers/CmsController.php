<?php
require_once Mage::getModuleDir('controllers', 'Martin_Debug').DS.'AbstractController.php';
class Martin_Debug_CmsController extends Martin_Debug_AbstractController{
	
    public function popupAction()
    {
	    $this->loadLayout();
	    $this->renderLayout();
    }
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
        
        $product = Mage::getModel('catalog/product')->load(907) ;  
        foreach($product->getProductOptionsCollection() as $option)
        {
            var_dump($option->getData());
        }
        var_dump(get_class_methods($product)) ;
        
//        $block=$this->getLayout()->createBlock('martinwms/capabilityCalender')
//                ->setTemplate('wmstheme2/components/capabilityCalender.phtml');
//        var_dump($block->getCalender(false,10));
        exit;
        
        
        
//       // var_dump(Zend_Date(time(),'Y-M-d')->toString());exit;
//        $this->loadLayout();
//        $warehouse=Mage::getModel('warehouse/warehouse')->load(1);
//        $dateFrom=new Zend_Date(time());
//        $dateTo=clone $dateFrom;
//        $dateTo->addDay(5);
//        $spaceItems=\Martin_Wms\Client\HandlerBookedSpaceItem::getSpaceItemsNotExpired($warehouse);
//        $data= \Martin_Wms\Client\CapabilitysCalculator::AvailableRequiredCapabilityCalendar( $warehouse,  $dateFrom,  $dateTo, $spaceItems);
//        var_dump($data);
//        
//        $this->renderLayout();
    }
}

