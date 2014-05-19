<?php
/**
 * Adaptive image resize extension for Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade
 * the Bolevar AdaptiveResize module to newer versions in the future.
 * If you wish to customize the Bolevar AdaptiveResize module for your needs
 * please refer to http://www.magentocommerce.com for more information.
 *
 * @category   Reinos
 * @package    Reinos_AdaptiveResize
 * @copyright  Copyright (C) 2014 Reinos.nl Internet Media (http://reinos.nl/)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Rewrites Product Image Module to Add Resize
 *
 * @category   Reinos
 * @package    Reinos_AdaptiveResize
 * @subpackage Model
 * @author     Rein de Vries <info@reinos.nl>
 */
class Reinos_AdaptiveResize_Model_Product_Image extends Mage_Catalog_Model_Product_Image
{
    const POSTION_TOP     = 'top';
    const POSITION_BOTTOM = 'bottom';
    const POSITION_CENTER = 'center';

    /**
     * @see Varien_Image_Adapter_Abstract
     * @return Mage_Catalog_Model_Product_Image
     */
    /*public function adaptiveResize() {

        if (is_null($this->getWidth()) && is_null($this->getHeight()))
        {
            return $this;
        }

        $processor = $this->getImageProcessor();

        $current_ratio = $processor->getOriginalWidth() / $processor->getOriginalHeight();
        $target_ratio = $this->getWidth() / $this->getHeight();

        if ($target_ratio > $current_ratio) {
            $processor->resize($this->getWidth(), null);
        } else {
            $processor->resize(null, $this->getHeight());
        }

        $diff_width = $processor->getOriginalWidth() - $this->getWidth();
        $diff_height = $processor->getOriginalHeight() - $this->getHeight();

        $processor->crop(
            floor($diff_height / 2),
            floor($diff_width / 2),
            ceil($diff_width / 2),
            ceil($diff_height / 2)
        );

        return $this;

    }*/
    /**
     * Crop position from top
     *
     * @var float
     */
    protected $_topRate = 0.5;

    /**
     * Crop position from bootom
     *
     * @var float
     */
    protected $_bottomRate = 0.5;

    /**
     * Adaptive Resize
     *
     * @return Reinos_AdaptiveResize_Model_Product_Image
     */
    public function adaptiveResize()
    {
        if (is_null($this->getWidth())) {
            return $this;
        }

        if (is_null($this->getHeight())) {
            $this->setHeight($this->getWidth());
        }

        $processor = $this->getImageProcessor();

        $currentRatio = $processor->getOriginalWidth() / $processor->getOriginalHeight();
        $targetRatio = $this->getWidth() / $this->getHeight();

        if ($targetRatio > $currentRatio) {
            $processor->resize($this->getWidth(), null);
        } else {
            $processor->resize(null, $this->getHeight());
        }

        $diffWidth  = $processor->getOriginalWidth() - $this->getWidth();
        $diffHeight = $processor->getOriginalHeight() - $this->getHeight();

        $processor->crop(
            floor($diffHeight * $this->_topRate),
            floor($diffWidth / 2),
            ceil($diffWidth / 2),
            ceil($diffHeight * $this->_bottomRate)
        );

        return $this;
    }

    /**
     * Set crop position
     *
     * @param string $position top, bottom or center
     *
     * @return Bolevar_AdaptiveResize_Model_Product_Image
     */
    public function setCropPosition($position)
    {
        switch ($position) {
            case self::POSTION_TOP:
                $this->_topRate    = 0;
                $this->_bottomRate = 1;
                break;
            case self::POSITION_BOTTOM:
                $this->_topRate    = 1;
                $this->_bottomRate = 0;
                break;
            default:
                $this->_topRate    = 0.5;
                $this->_bottomRate = 0.5;
        }
        return $this;
    }
}
