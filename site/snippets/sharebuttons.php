<ul id="share-buttons">
	<li>
		<a href="http://www.facebook.com/sharer.php?u=<?= rawurlencode($p->url()); ?>" title="Share on Facebook">
			Fb
		</a>
	</li>
	<li>
		<a href="https://twitter.com/intent/tweet?source=webclient&text=<?= rawurlencode($site->title().' | '.$p->title()); ?>%20<?= rawurlencode($p->url()); ?>" title="Tweet this">Tw</a>
	</li>
	<li>
		<a href="https://plus.google.com/share?url=<?= rawurlencode($p->url()); ?>" title="Share on Google+">G+</a>
	</li>
	<li>
		<a href="https://www.linkedin.com/shareArticle?mini=true&url=<?= rawurlencode($page->url()); ?>&title=<?= rawurlencode(site()->title().' | '.$page->title()); ?>&summary=<?= rawurlencode ($page->text()); ?>&source=" target="blank" title="Share on Linkedin">In</a>
	</li>
</ul>
