<ul id="share-buttons">
	<li>
		<a href="#" target="blank">In</a>
	</li>
	<li>
		<a href="http://www.facebook.com/sharer.php?u=<?= rawurlencode($p->url()); ?>" target="blank" title="Share on Facebook">
			Fb
		</a>
	</li>
	<li>
		<a href="https://twitter.com/intent/tweet?source=webclient&text=<?= rawurlencode($site->title().' | '.$p->title()); ?>%20<?= rawurlencode($p->url()); ?>" target="blank" title="Tweet this">Tw</a>
	</li>
	<li>
		<a href="https://twitter.com/intent/tweet?source=webclient&text=<?= rawurlencode($site->title().' | '.$p->title()); ?>%20<?= rawurlencode($p->url()); ?>" target="blank" title="Tweet this">G+</a>
	</li>
</ul>
