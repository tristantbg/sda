<?php

return function ($site, $pages, $page) {
	$posts = $page->grandChildren()->visible()->sortBy('date', 'desc');

	return array(
	'posts' => $posts
	);
}

?>
