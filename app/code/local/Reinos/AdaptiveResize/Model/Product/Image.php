<?php

    class Reinos_AdaptiveResize_Model_Product_Image extends Mage_Catalog_Model_Product_Image
    {
        /**
         * @see Varien_Image_Adapter_Abstract
         * @return Mage_Catalog_Model_Product_Image
         */
        public function adaptiveResize() {

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

        }
    }
