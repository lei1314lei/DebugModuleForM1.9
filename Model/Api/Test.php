<?php

class Martin_Debug_Model_Api_Test extends Mage_Api_Model_Resource_Abstract
{
    public function getData($parameter)
    {
        if(!$parameter)
        {
            $this->_fault('no_parameter');
        }
        return array('msg'=>"successful with $parameter");
    }
}
