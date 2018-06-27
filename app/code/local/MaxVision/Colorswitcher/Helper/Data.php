<?php
/**
 * Colorswitcher - Magento Extension
 *
 * @category    MaxVision
 * @package     Colorswitcher
 * @copyright   Copyright (c) 2015 MaxVision <maxyvision@gmail.com>
 **/
class MaxVision_Colorswitcher_Helper_Data extends Mage_Core_Helper_Abstract
{
    const XML_PATH_IS_ENABLED        = 'maxvision_colorswitcher/colorswitcher_setting/enabled';

    public function isEnabled()
    {
        return Mage::getStoreConfig(self::XML_PATH_IS_ENABLED, Mage::app()->getStore()->getId());
    }

}