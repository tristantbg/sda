<?php

return function ($site, $pages, $page) {
	$posts = $page->children()->visible()->sortBy('date', 'desc');

	return array(
	'posts' => $posts
	);
}

?>
