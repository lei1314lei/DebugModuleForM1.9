<?php
class Martin_Debug_Actions_AddBooleanAttributeForCategory
{
    private $attrCode;
    private $attrTitle;
    /**
     * @var string
     */
    private $groupName;

    public function __construct(string $attrCode, string $attrTitle, string $groupName)
    {

        $this->attrCode = $attrCode;
        $this->attrTitle = $attrTitle;
        $this->groupName = $groupName;
    }
    public function execute()
    {
        $this->doExecute();
    }

    protected function doExecute()
    {
        $categoryType=Mage::getModel('eav/entity_type')->load('catalog_category','entity_type_code');
        $setId=$categoryType->getDefaultAttributeSetId();
        $groups = Mage::getModel('eav/entity_attribute_group')
            ->getResourceCollection()
            ->setAttributeSetFilter($setId)
            ->addFieldToFilter('attribute_group_name',$this->groupName)
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
        $code=$this->attrCode;
        $frontLabel=$this->attrTitle;
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
    }
}
