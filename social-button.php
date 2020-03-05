
<!-- Social Button --><?php //box_count ?>
<ul class="list-inline social-button-list">
	<li>
		<div class="fb-like" data-href="<?php the_permalink(); ?>" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false"></div>
	</li>
	<li>
		<a href="https://twitter.com/share" class="twitter-share-button"{count} data-lang="ja">ツイート</a>
		<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
	</li>
	<li>
		<div class="line-it-button" data-lang="ja" data-type="share-a" data-url="<?php the_permalink(); ?>" style="display: none;"></div>
		<script src="https://d.line-scdn.net/r/web/social-plugin/js/thirdparty/loader.min.js" async="async" defer="defer"></script>
	</li>
</ul>
<!-- ここまで - Social Button -->
