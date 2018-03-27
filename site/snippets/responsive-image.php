<?php if($image = $field->toFile()): ?>

	<?php 
	$src = $image->width(1000)->url();
	$srcset = $image->width(500)->url() . ' 500w,';
	for ($i = 1000; $i <= 3000; $i += 1000) $srcset .= $image->width($i)->url() . ' ' . $i . 'w,';
	?>
	<img class="lazy lazyload" 
	<?php if (isset($placeholder) && $placeholder): ?>
	src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" 
	<?php endif ?>
	data-src="<?= $src ?>" 
	data-srcset="<?= $srcset ?>" 
	data-sizes="auto" 
	data-optimumx="1.5" 
	<?php if (isset($caption) && $caption): ?>
	alt="<?= $caption.' - © '.$site->title()->html() ?>" 
	<?php elseif ($image->caption()->isNotEmpty()): ?>
	alt="<?= $image->caption().' - © '.$site->title()->html() ?>" 
	<?php endif ?>
	width="100%" height="auto" />
	<noscript>
		<img src="<?= $image->width(1000)->url() ?>" 
		<?php if (isset($caption) && $caption): ?>
		alt="<?= $caption.' - © '.$site->title()->html() ?>" 
		<?php elseif ($image->caption()->isNotEmpty()): ?>
		alt="<?= $image->caption().' - © '.$site->title()->html() ?>" 
		<?php endif ?>
		width="100%" height="auto" />
	</noscript>

<?php endif ?>