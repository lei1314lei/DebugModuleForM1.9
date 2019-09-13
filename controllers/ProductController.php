<?php

class Martin_Debug_ProductController extends Mage_Core_Controller_Front_Action{
    public function indexAction()
    {
        $product = Mage::getModel('catalog/product')->load(907);
        $options = $product->getOptions();
        $option = $this->_getReactorOption($options, \Martin_Wms\SpaceBooking::CONDITION_DATE_FROM);
        $block=$this->getLayout()->createBlock('catalog/product_view_options');
        
        $block->addOptionRenderer("text","catalog/product_view_options_type_text","catalog/product/view/options/type/text.phtml");
        $block->addOptionRenderer("file","catalog/product_view_options_type_file","catalog/product/view/options/type/file.phtml");
        $block->addOptionRenderer("select","catalog/product_view_options_type_select","catalog/product/view/options/type/select.phtml");
        $block->addOptionRenderer("date","catalog/product_view_options_type_date","catalog/product/view/options/type/date.phtml");
       
        
        
        echo($block->getOptionHtml($option)) ;
        var_dump($option);
        exit;
    }
    protected function _getReactorOption($options,$flag)
    {
        foreach($options as $option)
        {
             if(trim($option->getTitle())==trim($flag))
             {
                 return $option;
             }
        }
        return null;
    }
}
