<?php if($image = $field->toFile()): ?>

	<?php 
	$src = $image->crop(1000)->url();
	$srcset = $image->crop(500)->url() . ' 500w,';
	for ($i = 1000; $i <= 3000; $i += 1000) $srcset .= $image->crop($i)->url() . ' ' . $i . 'w,';
	?>
	<img class="lazy lazyload" 
	<?php if (isset($flickity) && $flickity): ?>
	data-flickity-lazyload-src="<?= $src ?>" 
	data-flickity-lazyload-srcset="<?= $srcset ?>" 
	<?php else: ?>
	data-src="<?= $src ?>" 
	data-srcset="<?= $srcset ?>" 
	data-sizes="auto" 
	data-optimumx="1.5" 
	<?php endif ?>
	width="100%" height="100%" />

<?php endif ?>