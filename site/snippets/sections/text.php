<section class="section-text">
	<?= $data->get("first")->kt() ?>
	<?php if (isset($isEnd) && $isEnd): ?>
		<div class="end">
			<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 15.307 15.307" enable-background="new 0 0 15.307 15.307" xml:space="preserve">
			<g>
				<defs>
					<rect id="SVGID_1_" width="15.307" height="15.307"/>
				</defs>
				<clipPath id="SVGID_2_">
					<use xlink:href="#SVGID_1_"  overflow="visible"/>
				</clipPath>
				<path clip-path="url(#SVGID_2_)" d="M7.653,15.307c4.228,0,7.654-3.428,7.654-7.655C15.308,3.427,11.881,0,7.653,0
					C3.426,0,0,3.427,0,7.652C0,11.879,3.426,15.307,7.653,15.307"/>
			</g>
			</svg>
		</div>
	<?php endif ?>
</section>