<?php
/**
 * Colorswitcher - Magento Extension
 *
 * @category    MaxVision
 * @package     Colorswitcher
 * @copyright   Copyright (c) 2015 MaxVision <maxyvision@gmail.com>
**/
class MaxVision_Colorswitcher_Block_Product_View_Type_Configurable extends Mage_Catalog_Block_Product_View_Type_Configurable
{
    /** @var MaxVision_Colorswitcher_Helper_Data */
    protected $_helper;

    /**
     * Retrieve extension helper
     *
     * @return MaxVision_Colorswitcher_Helper_Data
     */
    public function getLocalHelper()
    {
        if (is_null($this->_helper)) {
            $this->_helper = Mage::helper('colorswitcher');
        }
        return $this->_helper;
    }

    /**
     * @return MaxVision_Colorswitcher_Block_Product_View_Media
     */
    protected function _beforeToHtml(){
        if ($this->getLocalHelper()->isEnabled()) {
            $this->setTemplate("colorswitcher/catalog/product/view/type/options/configurable.phtml");
        } else {
            $this->setTemplate("catalog/product/view/type/options/configurable.phtml");
        }
        return $this;
    }
}
