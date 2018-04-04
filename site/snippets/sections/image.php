<section class="section-image">
<?php if ($file = $data->get('first')->toFile()): ?>
	<?php
		$file  = $data->get('first')->toFile();
		
		$image = snippet('responsive-image', array("field" => $data->get('first'), 'imagePlaceholder' => true), true);

		$figure = new Brick('figure');
		$figure->attr('data-scroll', $file->name());
		$figure->append($image);
		$tags = '';

		foreach ($file->themes()->split(',') as $key => $tag) {
			$tags .= "<a class='post-tag button rounded bump' href='".site()->language()->url().'/medias/themes:'.urlencode($tag)."' data-target><div>".$tag."</div></a>";
		}
		foreach ($file->technics()->split(',') as $key => $tag) {
			$tags .= "<a class='post-tag button rounded bump' href='".site()->language()->url().'/medias/technics:'.urlencode($tag)."' data-target><div>".$tag."</div></a>";
		}
		foreach ($file->materials()->split(',') as $key => $tag) {
			$tags .= "<a class='post-tag button rounded bump' href='".site()->language()->url().'/medias/materials:'.urlencode($tag)."' data-target><div>".$tag."</div></a>";
		}
		foreach ($file->colors()->split(',') as $key => $tag) {
			// $tags .= "<a class='post-tag button color rounded bump' href='".site()->language()->url().'/medias/colors:'.urlencode($tag)."' style='background-color: ".$tag."' data-target></a>";
			$tags .= "<a class='post-tag button rounded bump' href='".site()->language()->url().'/medias/colors:'.urlencode($tag)."' data-target><div>".$tag."</div></a>";
		}
		if($tags != '') {
			// $figure->append('<figcaption data-scroll="'.$file->name().'"><span class="button rounded">' . html($tags) . '</span></figcaption>');
			$figcaption = new Brick('figcaption');
			$figcaption->attr('data-scroll', $file->name());
			$tags = html($tags);

			$figcaption->append($tags);
			$figure->append($figcaption);
		}
		else {
			$figcaption = new Brick('figcaption');
			$figcaption->attr('data-scroll', $file->name());

			if ($file->imageName()->isNotEmpty()) {
				$default = $file->imageName();
			} else {
				$default = $file->name();
			}

			$span = new Brick('span');
			$span->attr('class', 'post-tag button rounded bump');
			$span->append('<span>'.$default.'</span>');

			$figcaption->append($span);
			$figure->append($figcaption);
		}
		echo $figure;
	?>
<?php else: ?>
	<span class="post-tag button rounded">Image error</span>
<?php endif ?>
</section>