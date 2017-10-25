<?php snippet('header') ?>

<div id="page-content" class="medias">

	<?php if (param("tag")): ?>
	<div class="row center">
		<span class="button rounded">
			<?= param("tag") ?>
		</span>
	</div>
	<?php endif ?>

	<div id="medias">
		<?php foreach ($medias as $key => $media): ?>
			<?php if ($media->type() == 'image'): ?>
				<div class="media">
					<a href="<?= $media->page()->url() ?>" class="link-overlay" data-target>
						<span class="button rounded">
							<?= $media->page()->title()->html() ?>
						</span>
					</a>
					<img data-src="<?= $media->width(500)->url() ?>" class="lazy lazyload" width="100%" height="100%">
				</div>
			<?php endif ?>
		<?php endforeach ?>
	</div>

</div>

<?php snippet('footer') ?>