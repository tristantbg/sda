<?php snippet('header') ?>

<div class="button rounded huge"><?= $page->title()->html() ?></div>

<?php foreach ($page->links()->toStructure() as $key => $l): ?>
	<a class="button rounded huge" href="<?= $l->url() ?>"><?= $l->title()->html() ?></a>
<?php endforeach ?>

<?php foreach ($page->socials()->toStructure() as $key => $s): ?>
	<a class="social" href="<?= $s->url() ?>"><?= $s->title()->html() ?></a>
<?php endforeach ?>

<?php snippet('footer') ?>