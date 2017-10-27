<?php snippet('header') ?>

<div id="page-content" class="medias">

	<form id="search" action="<?= page("search")->url() ?>">
	<input type="search" placeholder="search" name="q" value="<?php if(isset($query)) echo esc($query) ?>" autocomplete="off" />
	<!-- <input type="submit" value="Search"> -->
	</form>
	<div id="close">
		<a href="<?= $site->url() ?>" data-target="back">X</a>
	</div>
<?php if ($results && $results->count() > 0): ?>
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
<?php else: ?>
<div id="medias">
	<?php if ($results && $results->count() < 1): ?>
		<div class="row center">
			<span class="button rounded">
				Nothing found
			</span>
		</div>
	<?php endif ?>
	<?php snippet('search') ?>
</div>
<?php endif ?>


</div>

<?php snippet('footer') ?>