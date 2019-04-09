<?php
class Xtwocn_Debug_AttributeController extends Mage_Core_Controller_Front_Action{
    
    public function indexAction(){
        try{
          $resourceModelClassType='supplier/attribute_collection'; //$entityType->getEntityAttributeCollection()
          $attributeSetId=0;
          $entityType=9;
          $storeId=1;
         $resourceModel = Mage::getResourceModel($resourceModelClassType);
         var_dump(get_class($resourceModel));
         $resourceModel       ->setEntityTypeFilter($entityType)
                ->setAttributeSetFilter($attributeSetId)
                ->addStoreLabel($storeId);
         echo $resourceModel->getSelect();
         var_dump(get_class_methods($resourceModel));
          var_dump($resourceModel    ->getData())  ;
        } catch (Exception $ex) {
                var_dump($ex);
        }
        exit;
        
    }
}

?>

