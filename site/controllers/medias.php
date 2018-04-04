<?php

return function ($site, $pages, $page) {
	$title = $page->title()->html();
	$posts = $site->index()->visible()->filterBy('intendedTemplate', 'in', ['post', 'news'])->sortBy('date', 'desc');
	$query = get('q');

	// Get all medias
	$medias = new Collection();
	foreach ($posts as $p) {
		foreach ($p->sections()->toStructure() as $s) {
			if ($s->_fieldset() == "image" && $s->get("first")->toFile()) {
				$medias->data[] = $s->get("first")->toFile();
			}
		}
	}

	// Create menu
	$designers = $posts->filterBy('intendedTemplate', 'post')->sortBy('title');

	$themes = [];
	$technics = [];
	$materials = [];
	$colors = [];

	foreach ($medias as $key => $media) {
		$themes = array_merge($themes, $media->themes()->split(','));
		$technics = array_merge($technics, $media->technics()->split(','));
		$materials = array_merge($materials, $media->materials()->split(','));
		$colors = array_merge($colors, $media->colors()->split(','));
	}

	$themes = array_unique($themes);
	asort($themes);
	$technics = array_unique($technics);
	asort($technics);
	$materials = array_unique($materials);
	asort($materials);
	$colors = array_unique($colors);
	asort($colors);

	// Search
	if ($query) {
		$postsFilteredByQuery = $posts->search($query, 'title|text|sections|quote|pretitle');

		// Get all medias filtered
		$mediasFilteredByQuery = new Collection();
		foreach ($postsFilteredByQuery as $p) {
			foreach ($p->sections()->toStructure() as $s) {
				if ($s->_fieldset() == "image" && $s->get("first")->toFile()) {
					$mediasFilteredByQuery->data[] = $s->get("first")->toFile();
				}
			}
		}
		$results = searchMedias($medias, $query, ['themes','technics','materials','colors']);

		// add filtered medias by query
		foreach ($mediasFilteredByQuery as $key => $m) {
			$results->data[] = $m;
		}
	} else {
		$results = $medias;
	}

	if (count(param()) > 0 ) {
		foreach (param() as $key => $tag) {
			$results = $results->filterBy($key, $tag, ',');
		}
	}

	return array(
	'title' => $title,
	'categories' => $site->homePage()->children()->visible(),
	'query' => $query,
	'medias' => $medias,
	'results' => $results->sortBy('sort', 'asc'),
	'designers' => $designers,
	'themes' => $themes,
	'technics' => $technics,
	'materials' => $materials,
	'colors' => $colors,
	);
}

?>
