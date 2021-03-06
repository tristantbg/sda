<?php snippet('header') ?>

<?php if(isset($query) && $query): ?>
	<div id="results-bar">
		<span class="button rounded black"><?= $query ?></span>
		<?php foreach ($categories as $key => $cat): ?>
			<span class="button rounded" data-filter="<?= $cat->uid() ?>"><span><?= $cat->title()->html() ?></span></span>
		<?php endforeach ?>
			<span id="toggle-filters"></span>
			<span id="clear-filters"></span>
	</div>
<?php else: ?>
	<div id="results-bar">
		<?php foreach (param() as $key => $tag): ?>
			<?php if ($key == "colors"): ?>
			<span class="button rounded color" style="background-color: <?= $tag ?>"></span>
			<?php elseif ($key != "page"): ?>
			<span class="button rounded black"><?= $tag ?></span>
			<?php endif ?>
		<?php endforeach ?>
		<?php foreach ($categories as $key => $cat): ?>
			<span class="button rounded" data-filter="<?= $cat->uid() ?>"><span><?= $cat->title()->html() ?></span></span>
		<?php endforeach ?>
			<span id="toggle-filters"></span>
			<span id="clear-filters"></span>
	</div>
<?php endif ?>

<div id="medias">
	<?php if ($results && $results->count() > 0): ?>
		<?php foreach ($results as $key => $media): ?>
			<?php if ($media->type() == 'image'): ?>
				<?php $mediaCategory = $media->page()->parent() ?>
				<div class="media" data-filter="<?= $mediaCategory->uid() ?>">
					<?php 
					$src = $media->crop(1000,1000)->url();
					$srcset = $media->crop(500,500)->url() . ' 500w,';
					for ($i = 1000; $i <= 2000; $i += 1000) $srcset .= $media->crop($i,$i)->url() . ' ' . $i . 'w,';
					?>
					<img class="lazy lazyload" 
					src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" 
					data-src="<?= $src ?>" 
					data-srcset="<?= $srcset ?>" 
					data-sizes="auto" 
					data-optimumx="1.5" 
					width="100%" height="auto" />
					<a href="<?= $media->page()->url() ?>" class="link-overlay" data-target>
						<span class="button rounded">
							<?= $media->page()->title()->html() ?>
						</span>
						<span class="button rounded black">
							<?= $mediaCategory->title()->html() ?>
						</span>
					</a>
				</div>
			<?php endif ?>
		<?php endforeach ?>
		<?php if($results->pagination() && $results->pagination()->hasPages() && $results->pagination()->hasNextPage()): ?>
		<!-- pagination -->
		<nav id="pagination">

		<?php if($results->pagination()->hasNextPage()): ?>
		<a class="next button black rounded" href="<?php echo $results->pagination()->nextPageURL() ?>"><h2>Next</h2></a>
		<?php endif ?>

		<?php if($results->pagination()->hasPrevPage()): ?>
		<a class="prev button black rounded" href="<?php echo $results->pagination()->prevPageURL() ?>"><h2>Previous</h2></a>
		<?php endif ?>

		</nav>
		<!-- <div class="ajax-loading"><div class="button rounded infinite-scroll-request">Loading</div></div> -->
		<?php endif ?>
	<?php else: ?>
		<div class="row">
			<span class="button rounded">Nothing found</span>
		</div>
	<?php endif ?>
</div>

<?php snippet('footer') ?>