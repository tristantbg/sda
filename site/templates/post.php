<?php snippet('header') ?>

<?php if ($cover = $page->cover()->toFile()): ?>
	<div id="post-cover">
		<?php snippet('responsive-image', array('field' => $page->cover(), 'caption' => $page->title()->html(), 'imagePlaceholder' => true)) ?>
	</div>
<?php endif ?>
<div id="post-content">
	<div id="close">
		<a href="<?= $page->parent()->url() ?>" data-target="back">X</a>
	</div>
	<?php snippet("sharebuttons", array('p' => $page)) ?>
	<div id="post-date"><?= $page->date('d F Y') ?></div>
	<div id="post-header">
		<h1 class="title"><?= $page->title()->html() ?></h1>
		<a href="<?= $page->parent()->url() ?>" class="post-tag button rounded black" data-target>
			<div class="inner"><?= $page->parent()->title()->html() ?></div>
		</a>
	</div>
	
	<div id="post-text" class="serif">
		<?php $page->text()->kt() ?>
		<div id="post-sections" class="row">
			<?php $sections = $page->sections()->toStructure() ?>
			<?php foreach($sections as $key => $section): ?>
				<?php snippet('sections/' . $section->_fieldset(), array('data' => $section)) ?>
			<?php endforeach ?>
		</div>
	</div>
</div>
<div id="post-visuals" image-index="1"></div>

<?php snippet('footer') ?>