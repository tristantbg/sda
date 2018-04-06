<?php snippet('header') ?>


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
			<?php if($post->featuredImages()->isNotEmpty() && $post->featured()->toFile()): ?>
				<div class="thumbnail-slider">
					<?php snippet('blog-thumbnail', array('field' => $post->featured())) ?>
					<?php foreach ($post->featuredImages()->toStructure() as $key => $image): ?>
						<?php snippet('blog-thumbnail', array('field' => $image)) ?>
					<?php endforeach ?>
				</div>
			<?php elseif($post->featured()->toFile()): ?>
				<?php snippet('blog-thumbnail', array('field' => $post->featured())) ?>
			<?php endif ?>
		</div>

		<div class="item-text">
			<div>
			<?php
				// $postTitle = "";

				// if($post->intendedTemplate() == "news") {
				// 	if ($post->pretitle()->isNotEmpty()) $postTitle .= $post->pretitle()->html().'<br>';
				// 	$postTitle .= "“".$post->title()->html()."”";
				// } elseif($post->quote()->isNotEmpty()) {
				// 	$postTitle .= "“".$post->quote()."”";
				// }

				// echo $postTitle;

				if (strlen($post->date('F')) > 5) {
					$dateFormatted = $post->date('d M.');
				} else {
					$dateFormatted = $post->date('d F');
				}
				$dateFormatted .= '<br>'.$post->date('Y:');

				$date = new Brick('div');
				$date->attr('class', 'item-date');
				$date->append($dateFormatted);
				echo $date;

				if($post->intendedTemplate() == "news") {
					$postTitle = $post->title()->html();
					$itemTitle = new Brick('div');
					$itemTitle->attr('class', 'item-title');
					$itemTitle->append($postTitle);
					echo $itemTitle;
				} else {
					$itemSub = new Brick('div');
					$itemSub->attr('class', 'item-tags');
					if ($post->tags()->isNotEmpty()) {
						$tags = implode(' +&nbsp;', $post->tags()->split(','));
						$itemSub->append($tags);
					} else {
						// $itemSub->append($post->title());
					}
					echo $itemSub;
				}

			?>
			</div>
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


<?php snippet('footer') ?>