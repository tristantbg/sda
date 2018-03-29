<?php snippet('header') ?>

<div class="button rounded huge"><?= $page->title()->html() ?></div>

<?php foreach ($page->socials()->toStructure() as $key => $s): ?>
	<a class="social" href="<?= $s->url() ?>"><?= $s->title()->html() ?></a>
<?php endforeach ?>

<?php snippet('footer') ?>