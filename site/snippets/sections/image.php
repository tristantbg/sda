<section class="section-image">
	<?php
		$file  = $data->get("first")->toFile();
		$caption = $file->caption();
		
		$image = new Brick('image');
		$image->attr('src', $file->url());
		$image->attr('alt', $caption);

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
		$tags .= "<a class='post-tag button rounded bump' href='".site()->language()->url().'/medias/colors:'.urlencode($tag)."' data-target><div>".$tag."</div></a>";
		}
		if($tags != '') {
		// $figure->append('<figcaption data-scroll="'.$file->name().'"><span class="button rounded">' . html($tags) . '</span></figcaption>');
		$figure->append('<figcaption data-scroll="'.$file->name().'">' . html($tags) . '</figcaption>');
		}
		else if(!empty($caption)) {
		$figure->append('<figcaption data-scroll="'.$file->name().'"><span class="post-tag button rounded bump">' . html($caption) . '</span></figcaption>');
		} else {
		$figure->append('<figcaption data-scroll="'.$file->name().'"><span class="post-tag button rounded bump">' . $file->name() . '</span></figcaption>');
		}
		echo $figure;
	?>
</section>