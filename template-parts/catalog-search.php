<div id="catalogSearchBox" class="catalog-search-wrapper">
	<form name="csForm" id="catalogSearchForm" method="get" action="<?= get_post_type_archive_link('catalog'); ?>">

		<?php
			/*
			* スタイリストのラジオボタン作成
			*/
			if( taxonomy_exists('com_category') ) :
		?>
			<?php
				$stylist_args = array(
					'hide_empty' => 1
				);
				$stylist_terms = get_terms('com_category', $stylist_args);
			?>
			<?php if ( !empty($stylist_terms) ) : ?>
				<div class="catalog_search searchStylist">
					<div class="head">スタイリスト別</div>
					<div class="radio">
						<span class="cr">
							<input id="stylistAll" class="stylistAll" type="radio" name="stylist[]" value=""><label for="stylistAll">全て</label>
						</span>
						<?php foreach( $stylist_terms as $item ) : ?>
							<span class="cr">
								<input id="<?= $item->slug; ?>" class="<?= $item->slug; ?>" type="radio" name="stylist[]" value="<?= $item->term_id; ?>"><label for="<?= $item->slug; ?>"><?= $item->name; ?></label>
							</span>
						<?php endforeach; ?>
					</div>
				</div>
			<?php endif; ?>
		<?php endif; ?>


		<?php
			/*
			* レングスのラジオボタン作成
			*/
			if( taxonomy_exists('catalog_length') ) :
		?>
			<?php
				$length_args = array(
					'hide_empty' => 1
				);
				$length_terms = get_terms('catalog_length', $length_args);
			?>

			<?php if ( !empty($length_terms) ) : ?>
				<div class="catalog_search searchLength">
					<div class="head">レングス別</div>
					<div class="radio">
						<span class="cr">
							<input id="lengthAll" class="lengthAll" type="radio" name="length[]" value=""><label for="lengthAll">全て</label>
						</span>
						<?php foreach( $length_terms as $item ) : ?>
							<span class="cr">
								<input id="<?= $item->slug; ?>" class="<?= $item->slug; ?>" type="radio" name="length[]" value="<?= $item->term_id; ?>"><label for="<?= $item->slug; ?>"><?= $item->name; ?></label>
							</span>
						<?php endforeach; ?>
					</div>
				</div>
			<?php endif; ?>
		<?php endif; ?>

		<?php
			/*
			* タグのラジオボタン生成
			*/
			if( taxonomy_exists('catalog_tag') ) :
		?>
			<?php
				$tag_args = array(
					'hide_empty' => 1
				);
				$tag_terms = get_terms('catalog_tag', $tag_args);
			?>

			<?php if ( !empty($tag_terms) ) : ?>
				<div class="catalog_search searchTag">
					<div class="head">イメージ別</div>
					<div id="searchTagCheckbox" class="radio">
						<span class="cr">
							<input id="tagAll" class="tagAll" type="checkbox" name="catalog_tag[]" value=""><label for="tagAll">全て</label>
						</span>
						<?php foreach( $tag_terms as $item ) : ?>
							<span class="cr">
								<input id="tag<?= $item->term_id; ?>" type="checkbox" name="catalog_tag[]" value="<?= $item->term_id; ?>"><label for="tag<?= $item->term_id; ?>"><?= $item->name; ?></label>
							</span>
						<?php endforeach; ?>
					</div>
				</div>
			<?php endif; ?>
		<?php endif; ?>
		<div class="cs_submit">
			<input type="submit" id="ls" value="検索する" class="btn btn-primary btn-lm">
		</div>
	</form>
</div>