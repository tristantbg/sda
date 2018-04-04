<?php if($image = $field->toFile()): ?>

	<?php 
	$src = $image->width(1000)->url();
	$srcset = $image->width(500)->url() . ' 500w,';
	for ($i = 1000; $i <= 3000; $i += 1000) $srcset .= $image->width($i)->url() . ' ' . $i . 'w,';
	?>
	<img class="lazy<?= e(isset($imagePlaceholder) && $imagePlaceholder, ' image-placeholder') ?> lazyload" 
	<?php if (isset($placeholder) && $placeholder): ?>
	src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" 
	<?php endif ?>
	<?php if (isset($imagePlaceholder) && $imagePlaceholder): ?>
	src="<?= $image->width(500)->url() ?>" 
	<?php endif ?>
	data-src="<?= $src ?>" 
	data-srcset="<?= $srcset ?>" 
	data-sizes="auto" 
	data-optimumx="1.5" 
	<?php if (isset($caption) && $caption): ?>
	alt="<?= $caption.' - © '.$site->title()->html() ?>" 
	<?php elseif ($image->caption()->isNotEmpty()): ?>
	alt="<?= $image->caption()->escape().' - © '.$site->title()->html() ?>" 
	<?php else: ?>
	alt="<?= $image->page()->title()->html().' - © '.$site->title()->html() ?>" 
	<?php endif ?>
	<?php if ($image->credits()->isNotEmpty()): ?>
	data-credits="<?= $image->credits()->kt()->escape() ?>" 
	<?php endif ?>
	width="100%" height="auto" />
	<noscript>
		<img src="<?= $image->width(1000)->url() ?>" 
		<?php if (isset($caption) && $caption): ?>
		alt="<?= $caption.' - © '.$site->title()->html() ?>" 
		<?php elseif ($image->caption()->isNotEmpty()): ?>
		alt="<?= $image->caption()->escape().' - © '.$site->title()->html() ?>" 
		<?php endif ?>
		width="100%" height="auto" />
	</noscript>

<?php endif ?>