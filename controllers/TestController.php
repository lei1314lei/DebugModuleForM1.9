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
class Xtwocn_Debug_TestController extends Mage_Core_Controller_Front_Action
{
	public function indexAction()
	{
		$setComparatorClass= \Martin_Basics\Config::SET_COMPARATOR;
		var_dump(new $setComparatorClass());exit;
	}
}
