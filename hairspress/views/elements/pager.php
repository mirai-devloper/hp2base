<div class="pagination">
	<div class="pagination__inner">
		<?php // if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href=\"".get_pagenum_link(1)."\">&laquo;</a>"; ?>
		<?php if($paged > 1 /*&& $showitems < $pages*/) : ?>
			<a href="<?= get_pagenum_link($paged - 1); ?>" class="prev"><i class="fa fa-angle-left"></i><span>前へ</span></a>
		<?php else : ?>
			<span class="prev not"><i class="fa fa-angle-left"></i><span>前へ</span></span>
		<?php endif; ?>
		<?php for ($i=1; $i <= $pages; $i++) : ?>
			<?php if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems )) : ?>
				<?php if ($paged == $i) : ?>
					<span class="current num f-aleg_sc"><?= $i; ?></span>
				<?php else : ?>
					<a href="<?= get_pagenum_link($i); ?>" class="inactive num f-aleg_sc" ><?= $i; ?></a>
				<?php endif; ?>
			<?php endif; ?>
		<?php endfor; ?>
		<?php if ($paged < $pages /*&& $showitems < $pages*/) : ?>
			<a href="<?= get_pagenum_link($paged + 1); ?>" class="next"><span>次へ</span><i class="fa fa-angle-right"></i></a>
		<?php else : ?>
			<span class="next not"><span>次へ</span><i class="fa fa-angle-right"></i></span>
		<?php endif; ?>
		<?php // if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a href=\"".get_pagenum_link($pages)."\">&raquo;</a>"; ?>
	</div>
</div>