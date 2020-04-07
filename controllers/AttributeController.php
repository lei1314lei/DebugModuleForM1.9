<?php
class Martin_Debug_AttributeController extends Mage_Core_Controller_Front_Action{

    public function categoryAction()
    {
        //Mage_Eav_Model_Entity_Attribute
//        $eavEntityAttribute= Mage::getModel('eav/entity_attribute')->getCollection();

//        var_dump($eavEntityAttribute->count());exit;

           $categoryType=Mage::getModel('eav/entity_type')->load('catalog_category','entity_type_code');
           $setId=$categoryType->getDefaultAttributeSetId();
           $groups = Mage::getModel('eav/entity_attribute_group')
                ->getResourceCollection()
                ->setAttributeSetFilter($setId)
               ->addFieldToFilter('attribute_group_name','General Information')
                ->setSortOrder()
                ->load();
           $groupId=null;
           if(count($groups)==1)
           {
               foreach($groups as $group)
               {
                   $groupId = $group->getId();
               }

           }

        $eavAttribute = Mage::getModel('catalog/resource_eav_attribute');
        $categoryType=Mage::getModel('eav/entity_type')->load('catalog_category','entity_type_code');
        $code='is_root_of_b2b';
        $frontLabel='Is Root Category Of B2B';
        $backendType='int';
        $frontInput='select';
        $sourceModel='eav/entity_attribute_source_boolean';
        $data=[
            'entity_type_id'=>$categoryType->getId(),
            'attribute_code' => $code,
            'attribute_model' => null,
            'backend_model' => null,
            'backend_type' => $backendType,
            'backend_table' => null ,
            'frontend_model' => null,
            'frontend_input' => $frontInput,
            'frontend_label' => $frontLabel,
            'frontend_class' => null,
            'source_model' => $sourceModel,
            'is_required' => 0,
            'is_user_defined' => 0,
            'default_value' => 0,
            'is_unique' => 0,
            'note' => null,
            'external_api_id' => null,
            'frontend_input_renderer' => null,
            'is_global' => 1,
            'is_visible' => 1 ,
            'is_searchable' => 0,
            'is_filterable' => 0,
            'is_comparable' => 0,
            'is_visible_on_front' => 1,
            'is_html_allowed_on_front' => 0,
            'is_used_for_price_rules' => 0,
            'is_filterable_in_search' => 0,
            'used_in_product_listing' => 0,
            'used_for_sort_by' => 0,
            'is_configurable' => 1,
            'apply_to' => 0,
            'is_visible_in_advanced_search' => 0,
            'position' => 0,
            'is_wysiwyg_enabled' => 0,
            'is_used_for_promo_rules' => 0,
            'search_weight'

        ];
        $eavAttribute->setData($data);
       $eavAttribute->save();

       //select type , refer to Mage_Eav_Model_Resource_Entity_Attribute::_beforeSave(Mage_Core_Model_Abstract $object)
       $eavAttribute->setData('source_model',$sourceModel);
       $eavAttribute->save();

        if(isset($groupId))
        {
            $eavEntityAttribute= Mage::getModel('eav/entity_attribute');
            $eavEntityAttribute->setData([
                'entity_type_id' => $categoryType->getId(),
                'attribute_set_id' => $setId,
                'attribute_group_id' => $groupId ,
                'attribute_id' => $eavAttribute->getId() ,
            ]);
            $eavEntityAttribute->save();
//            $eavAttribute->setAttributeSetId($setId);
//            $eavAttribute ->setAttributeGroupId($groupId);

        }
       var_dump($eavAttribute->getId());
       exit;


       var_dump($model->getResource()->getMainTable()) ; exit;

        $collection=$model->getCollection();


        var_dump(count($collection),$collection);


        foreach($collection as $item)
        {
            var_dump($item->getData());
        }
        exit;

                $object=  new Varien_Object();
        $attributeCodes = Mage::getSingleton('eav/config')
            ->getEntityAttributeCodes("catalog_category", $object);
        var_dump($attributeCodes);exit;

        $eavAttribute = Mage::getModel('eav/entity_type')->load('catalog_category','entity_type_code');
         $attributes=$eavAttribute->getEntityAttributeCollection();
         var_dump(count($attributes));
         foreach($attributes as $attribute)
         {
             var_dump($attribute->getData());
         }
       var_dump($eavAttribute->getId(),get_class_methods($eavAttribute)) ;

        exit;

        $category=Mage::getModel('catalog/category');
        $attributes=$category->getAttributes();
        var_dump($attributes);
        var_dump(get_class_methods($category));
    }
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

