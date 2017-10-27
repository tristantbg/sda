<?php snippet('header') ?>

<div id="page-content" class="medias">

	<?php if (param()): ?>
	<div class="row center">
			<?php foreach (param() as $key => $tag): ?>
			<span class="button rounded"><?= $tag ?></span>
			<?php endforeach ?>
	</div>
	<?php endif ?>

	<div id="medias">
		<?php foreach ($results as $key => $media): ?>
			<?php if ($media->type() == 'image'): ?>
				<div class="media">
					<a href="<?= $media->page()->url() ?>" class="link-overlay" data-target>
						<span class="button rounded">
							<?= $media->page()->title()->html() ?>
						</span>
						<span class="button rounded">
							<?= $media->page()->parent()->title()->html() ?>
						</span>
					</a>
					<img data-src="<?= $media->width(500)->url() ?>" class="lazy lazyload" width="100%" height="100%">
				</div>
			<?php endif ?>
		<?php endforeach ?>
	</div>


</div>

<?php snippet('footer') ?>