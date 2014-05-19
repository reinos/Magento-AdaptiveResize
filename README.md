Magento Adaptive Resize
=======================

Implements an adaptive resize function just like the phpthumbs library implementation

> What it does is resize the image to get as close as possible to the desired dimensions, then crops the image down to the proper size from the center.
> This is called adaptive resizing.
> [phpThumb](http://trac.gxdlabs.com/projects/phpthumb/wiki/Docs/BasicUsage#AdaptiveResizing)

How To Use
----------

- Simply download the source code here: [magento-adaptive-resize.zip](https://github.com/wearefarm/magento-adaptive-resize/zipball/master) and extract into your Magento install directory.
- Flush the Magento cache

Now where ever you can call the normal `resize()` method on an image you can call `adaptiveResize()` instead!

Example:

``` php
<img src="<?php echo $this->helper('catalog/image')->init($_product, 'thumbnail')->adaptiveResize(160, 213) ?>" width="160" height="213" alt="<?php echo $this->htmlEscape($_product->getName()); ?>" />
```