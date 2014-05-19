<?php

class Reinos_AdaptiveResize_Helper_Image extends Mage_Catalog_Helper_Image
{
    /**
     * Scheduled for adaptive resize image
     *
     * @var bool
     */
    protected $_scheduleAdaptiveResize = false;

    /**
     * Reset all previous data
     *
     * @return Mage_Catalog_Helper_Image
     */
    protected function _reset()
    {
        parent::_reset();
        $this->_scheduleAdaptiveResize = false;
        return $this;
    }

    /**
     * Schedule adaptive resize of the image
     * $width and $height must be set.
     *
     * @see Mage_Catalog_Model_Product_Image
     * @param int $width
     * @param int $height
     * @return Mage_Catalog_Helper_Image
     */
    public function adaptiveResize($width, $height)
    {
        $this->_getModel()
            ->setWidth($width)
            ->setHeight($height)
            ->setKeepAspectRatio(true)
            ->setKeepFrame(false)
            ->setConstrainOnly(false);
        $this->_scheduleAdaptiveResize = true;
        return $this;
    }

    /**
     * Return Image URL
     *
     * @return string
     */
    public function __toString()
    {
        try {
            $model = $this->_getModel();

        if ($this->getImageFile()) {
                $model->setBaseFile($this->getImageFile());
            } else {
                $model->setBaseFile($this->getProduct()->getData($model->getDestinationSubdir()));
            }

            if ($model->isCached()) {
                return $model->getUrl();
            } else {

                if ($this->_scheduleRotate) {
                    $model->rotate($this->getAngle());
                }

                if ($this->_scheduleResize) {
                    $model->resize();
                }

                if ($this->_scheduleAdaptiveResize) {
                    $model->adaptiveResize();
                }

                if ($this->getWatermark()) {
                    $model->setWatermark($this->getWatermark());
                }

                $url = $model->saveFile()->getUrl();
            }
        } catch (Exception $e) {
            Mage::log($e);
            $url = Mage::getDesign()->getSkinUrl($this->getPlaceholder());
        }
        return $url;
    }
}