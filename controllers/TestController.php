<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TestController
 *
 * @author martin.tian
 */
class Martin_Debug_TestController extends Mage_Core_Controller_Front_Action
{
	public function indexAction()
	{
        $processId=6;
        $process = Mage::getModel('index/process')->load($processId);
        if ($process->getId() && $process->getIndexer()->isVisible()) {
               $process->reindexEverything();
            echo $process->getIndexer()->getName().' index was rebuilt.';
        }else{
            echo 'not to be done';
        }
	}
}
