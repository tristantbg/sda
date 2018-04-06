<?php snippet('header') ?>

<?php if ($page->infoLink()->isNotEmpty()): ?>
	<a class="button rounded huge" href="<?= $page->infoLink() ?>">
<?php else: ?>
	<div class="button rounded huge">
<?php endif ?>
	<?= $page->title()->html() ?>
<?php if ($page->infoLink()->isNotEmpty()): ?>
	</a>
<?php else: ?>
	</div>
<?php endif ?>

<?php foreach ($page->links()->toStructure() as $key => $l): ?>
	<a class="button rounded huge" href="<?= $l->url() ?>"><?= $l->title()->html() ?></a>
<?php endforeach ?>

<?php foreach ($page->socials()->toStructure() as $key => $s): ?>
	<a class="social" href="<?= $s->url() ?>"><?= $s->title()->html() ?></a>
<?php endforeach ?>

<div id="credits">
	Concept &amp;&nbsp;design: <a href="http://dualroom.ch/">Emmanuel&nbsp;Crivelli, Dual&nbsp;Room</a>
	<br>Programming: <a href="https://www.tristanbagot.com">Tristan&nbsp;Bagot</a>
</div>

<?php snippet('footer') ?>