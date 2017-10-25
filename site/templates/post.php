<?php snippet('header') ?>

<div id="page-content" class="post">
	<?php if ($cover = $page->cover()->toFile()): ?>
		<div class="post-cover">
			<img data-src="<?= $cover->width(3000)->url() ?>" class="lazy lazyload">
		</div>
	<?php endif ?>
	<div id="post-visuals"></div>
	<div id="post-content">
		<div id="post-header">
			<h1 class="title"><?= $page->title()->html() ?></h1>
			<a href="<?= $page->parent()->url() ?>" class="button rounded" data-target>
				<?= $page->parent()->title()->html() ?>
			</a>
		</div>
		
		<div id="post-text" class="serif">
			<?= $page->text()->kt() ?>
			<div class="end">
				<svg version="1.1" id="Calque_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 15.307 15.307" enable-background="new 0 0 15.307 15.307" xml:space="preserve">
				<g>
					<defs>
						<rect id="SVGID_1_" width="15.307" height="15.307"/>
					</defs>
					<clipPath id="SVGID_2_">
						<use xlink:href="#SVGID_1_"  overflow="visible"/>
					</clipPath>
					<path clip-path="url(#SVGID_2_)" d="M7.653,15.307c4.228,0,7.654-3.428,7.654-7.655C15.308,3.427,11.881,0,7.653,0
						C3.426,0,0,3.427,0,7.652C0,11.879,3.426,15.307,7.653,15.307"/>
				</g>
				</svg>
			</div>
		</div>
	</div>

</div>

<?php snippet('footer') ?>