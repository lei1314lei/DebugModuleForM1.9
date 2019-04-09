<?php

class Xtwocn_Debug_ConfigurationController extends Mage_Core_Controller_Front_Action
{
    public function showAction()
    { 
        $nodePath=$this->getRequest()->getParam('node');
        if($nodePath)
        {
            $toShow=Mage::getConfig()->getNode($nodePath);
            echo "<pre>";
            echo ($toShow->asNiceXml()) ;
            echo "</pre>";
        }else{
            $toShow=Mage::getConfig();
            echo "<pre>";
            echo $toShow->getXmlString();
            echo "</pre>";
        }
        
       // var_dump(get_class($toShow), get_class_methods($toShow));

    }
}
