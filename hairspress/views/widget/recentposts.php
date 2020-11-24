<ul>
	<?php if ($posts->have_posts()) : ?>
		<?php while ( $posts->have_posts() ) : $posts->the_post();  ?>
		<?php
			$post_title = get_the_title( get_the_ID() );
			$title      = ( ! empty( $post_title ) ) ? $post_title : __( '(no title)' );
		?>
		<li>
			<a href="<?php the_permalink( get_the_ID() ); ?>" class="widget_recent_entries__link">
				<?php if ($thumbnail) : ?>
					<div class="widget_recent_entries__thumbnail">
						<div class="thumb">
							<?php mio_get_thumbnail('square'); ?>
						</div>
					</div>
				<?php endif; ?>
				<div class="widget_recent_entries__content">
					<div class="title"><?= $title ; ?></div>
					<?php if ($show_date) : ?>
					<div class="datetime"><time><?= get_the_time('Y.m.d', get_the_ID()); ?></time></div>
					<?php endif; ?>
				</div>
			</a>
		</li>
		<?php endwhile; ?>
	<?php else : ?>
		<li>投稿がありません。</li>
	<?php endif; ?>
</ul>
<?php wp_reset_postdata() ?>