<?php

class Martin_Debug_LayoutController extends Mage_Core_Controller_Front_Action{
    protected function _cmsBlock($id)
    {
        $layout=$this->getLayout();
        $block=$layout->createBlock('cms/block')->setBlockId($id);
        return $block;
    }
    public function indexAction()
    {
        $block=$this->_cmsBlock('home_sections');
        var_dump($block->toHtml());
        echo 'ok';
        exit;
    }
}
