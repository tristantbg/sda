<?php

return function ($site, $pages, $page) {
	$title = $page->title()->html();
	$medias = site()->index()->files();

	if ($tag = param('tag')) {
		$medias = $medias->filterBy('tags', $tag, ',');
	}

	return array(
	'title' => $title,
	'medias' => $medias,
	);
}

?>
