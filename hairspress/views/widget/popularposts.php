<?php
	$pop_count = 0;
?>
<ul>
	<?php if ($popular->have_posts()) : ?>
		<?php while ( $popular->have_posts() ) : $popular->the_post(); ?>
			<?php if ($pop_count > 3) break; ?>
			<li>
				<a href="<?php the_permalink( get_the_ID() ); ?>" class="widget_recent_entries__link">
					<div class="widget_recent_entries__thumbnail">
						<div class="thumb">
							<?php mio_get_thumbnail('square'); ?>
						</div>
					</div>
					<div class="widget_recent_entries__content">
						<div class="title"><?php the_title(); ?></div>
						<div class="datetime"><time><?= get_the_time('Y.m.d', get_the_ID()); ?></time></div>
						<span class="pop_view">Views: <?= get_post_meta(get_the_ID(), 'post_views_count', true) ?></span>
					</div>
				</a>
			</li>
			<?php ++$pop_count; ?>
		<?php endwhile; ?>
	<?php else : ?>
		<li>
			<p style="font-size:14px;text-align:center;">集計中</p>
		</li>
	<?php endif; ?>
</ul>