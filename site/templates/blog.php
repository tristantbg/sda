<?php snippet('header') ?>

<div id="page-content" class="blog">
	<?php $idx = 1 ?>
	<?php foreach ($posts as $key => $post): ?>

		<div class="post-item <?= $post->intendedTemplate() ?><?php e($idx > 3, ' small') ?>">

			<a href="<?= $post->url() ?>" class="link-overlay" data-target="post">
				<div class="item-title button rounded">
					<?php if ($post->intendedTemplate() == "news"): ?>
						News
					<?php else: ?>
						<?= $post->title()->html() ?>
					<?php endif ?>
				</div>
			</a>

			<div class="item-visual">
				<?php if($featured = $post->featured()->toFile()): ?>
					<img src="<?= $featured->width(1000)->url() ?>" class="lazy lazyload" width="100%" height="100%">
				<?php endif ?>
			</div>

			<div class="item-text serif bold">
				<?php if($post->intendedTemplate() == "news") echo $post->title()->html() ?>
				<?php if($post->quote()->isNotEmpty()) echo html("“".$post->quote()."”") ?>
			</div>
			
		</div>
		<?php if ($idx == 3): ?>
			<div class="row">			
		<?php endif ?>
		<?php $idx++ ?>
	<?php endforeach ?>
		<?php if ($idx > 4): ?>
			</div>
		<?php endif ?>

</div>

<?php snippet('footer') ?>