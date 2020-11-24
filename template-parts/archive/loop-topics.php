<!-- ここから - コンテンツ -->
<div id="topics" class="c-wrap">
	<div class="container">
		<h2 class="c-title-page"><span class="en">Information</span><span class="jp">お知らせ</span></h2>

		<div class="row">
			<div class="col-xs-12 col-md-9">
				<?php //var_dump($wp_query); ?>
				<?php hp_search_found(); ?>
				<?php if( have_posts() ) : ?>
					<?php while( have_posts() ) : the_post(); ?>
						<article class="topics-archive">
							<div class="topics-content clearfix">
								<time class="datetime" datetime="<?php the_time('c'); ?>"><?php the_time('Y.m.d'); ?></time>
								<div class="topics-header">
									<h3 class="title"><a href="<?php the_permalink(); ?>"><?php the_title_attribute(); ?></a></h3>
									<div class="content"><?php the_excerpt(); ?></div>
									<a href="<?php the_permalink(); ?>" class="btn btn-default btn-sl"><i class="fa fa-angle-right"></i><span>続きを読む</span></a>
								</div>
							</div>
						</article>
					<?php endwhile; ?>
					<?php pagination(); ?>
				<?php endif; ?>
			</div>

			<div class="col-xs-12 col-md-3">
				<?php get_sidebar('topics'); ?>
			</div>
		</div>
	</div>
</div>
<!-- /#topics -->
