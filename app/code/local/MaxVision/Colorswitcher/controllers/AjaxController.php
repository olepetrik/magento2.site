<?php
/**
 * Colorswitcher - Magento Extension
 *
 * @category    MaxVision
 * @package     Colorswitcher
 * @copyright   Copyright (c) 2015 MaxVision <maxyvision@gmail.com>
**/
class MaxVision_Colorswitcher_AjaxController extends Mage_Core_Controller_Front_Action {
	
	public function getImagesAction()
	{

        $helper = Mage::helper('shoppersettings/image');       // хелпер cloud zoom
        $helper_image = Mage::helper('catalog/image');         // хелпер галереї картинок
        $config = Mage::getStoreConfig('shoppersettings');     // одержуємо настройки cloud zoom

        list($imgX, $imgY) = $helper->getMainSize();
        if ( $imgX > 800 ) {
            $imgX = 800;
            $imgY = $helper->calculateHeight($imgX);
        }
        list($thumbX, $thumbY) = $helper->getThumbSize();

        $attributes = $this->getRequest()->getParam('super_attribute');
		
		$product_id = Mage::getModel('catalog/product')->load($this->getRequest()->getParam('product'));
		
		$childProduct = Mage::getModel('catalog/product_type_configurable')->getProductByAttributes($attributes, $product_id);
		
		$product = Mage::getModel('catalog/product')->load($childProduct->getId());
		$collection = $product->getMediaGalleryImages();
		
		$result = array();
		$result['price'] = Mage::helper('core')->currency($product->getPrice(), true, false);

        $result['images'] = '';
		if(count($collection) > 0) {
            $i = 1;
            foreach ($collection as $_image) {
                //Skip, if no image
        	    if ($_image->getFile() == NULL)
                    continue;
                $result['images'] .= "<li class='jcarousel-item jcarousel-item-" . $i . " jcarousel-item-placeholder' jcarouselindex='" . $i ."'>";
                $result['images'] .= "<a href='" . $helper_image->init($product, 'image', $_image->getFile())->resize($config['cloudzoom']['big_image_width'], $config['cloudzoom']['big_image_height'])."'";
                $result['images'] .= " class='cloud-zoom-gallery' title='". $_image->getLabel()."'";
                $result['images'] .= "rel=\"useZoom: 'cloud_zoom', smallImage: '" . $helper_image->init($product, 'image', $_image->getFile())->resize($imgX, $imgY) . "'\">";
                $result['images'] .= "<img src='" . $helper_image->init($product, 'thumbnail', $_image->getFile())->resize($thumbX, $thumbY) . "'";
                $result['images'] .= "data-srcX2='" . $helper_image->init($product, 'thumbnail', $_image->getFile())->resize($thumbX*2, $thumbY*2) . "'" ;
                $result['images'] .= "width=".$thumbX. " height=".$thumbY." alt=" . $_image->getLabel() . "/></a></li>";
                $i++;
			}
			
		}
        $result['href'] = (string)$helper_image->init($product, 'image')->resize($config['cloudzoom']['big_image_width'], $config['cloudzoom']['big_image_height']);
        $result['thumbnail'] = (string)$helper_image->init($product, 'thumbnail')->resize($imgX, $imgY);
		echo json_encode($result);
	}


	public function getPriceAction()
	{
		$attributes = $this->getRequest()->getParam('super_attribute');

		$product_id = Mage::getModel('catalog/product')->load($this->getRequest()->getParam('product'));

		$childProduct = Mage::getModel('catalog/product_type_configurable')
			->getProductByAttributes($attributes, $product_id);

		$product = Mage::getModel('catalog/product')->load($childProduct->getId());
		$result = Mage::helper('core')->currency($product->getPrice(), true, false);
		echo json_encode($result);
	}
	
}