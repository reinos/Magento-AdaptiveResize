Magento Adaptive Resize
=======================

Implements an adaptive resize function

> What it does is resize the image to get as close as possible to the desired dimensions, then crops the image down to the proper size from the center.
> This is called adaptive resizing.
> [phpThumb](http://trac.gxdlabs.com/projects/phpthumb/wiki/Docs/BasicUsage#AdaptiveResizing)

How To Use for the products
----------

- Simply download the source code and extract into your Magento install directory.
- Flush the Magento cache

Now where ever you can call the normal `resize()` method on an image you can call `adaptiveResize()` instead!

Example:

``` php
<img src="<?php echo $this->helper('catalog/image')->init($_product, 'thumbnail')->adaptiveResize(160, 213) ?>" width="160" height="213" alt="<?php echo $this->htmlEscape($_product->getName()); ?>" />
```

## How to use this with Categories?

	/*
	 * You can pass width and height and much more, see helper for details.
	 * echo $this->helper('adaptiveResize')->init($_category->getImageUrl())->resize(null, 120)
	 * echo $this->helper('adaptiveResize')->init($_category->getImageUrl())->resize(120, null)
	 * echo $this->helper('adaptiveResize')->init($_category->getImageUrl())->resize(120, 120)
	 */
	<div class="product-image">
		<a href="<?php echo $_category->getURL() ?>" title="<?php echo $this->htmlEscape($_category->getName()) ?>">
			<img src="<?php echo $this->helper('adaptiveResize')->init($_category->getImageUrl())->resize(null, 120) ?>" alt="<?php echo $this->htmlEscape($_category->getName()) ?>"/>
		</a>
	</div>
	
# How to crop image for categories?
You can init image helper with path to image, then  you must pass width and height to crop image. After image is cropped its saved and ready to be resized using cropped image as source image to be resized. See example code below.

```PHP
<img src="<?php 
	echo $this->helper('adaptiveResize')
			  ->init($_category->getImageUrl())
			  ->setWidth(230)
			  ->setHeight(200)
			  ->crop()
			  ->resize() 
	?>" alt="alt text"/>
```