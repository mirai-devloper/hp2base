<p>
	<label for="<?= $post_type['field']['id']; ?>"><?= __('PostType:'); ?></label>
	<select name="<?= $post_type['field']['name']; ?>" id="<?= $post_type['field']['id']; ?>">
		<?php foreach ($post_type['post_types'] as $type) : ?>
		<option value="<?= $type->name; ?>" <?php selected($post_type['instance'], $type->name) ?>><?= $type->label; ?></option>
		<?php endforeach; ?>
	</select>
</p>
<p>
	<label for="<?= $thumbnail['field']['id']; ?>"><?= __('Thumbnail:'); ?></label>
	<label><input type="checkbox" name="<?= $thumbnail['field']['name']; ?>" id="<?= $thumbnail['field']['id']; ?>" <?php checked($thumbnail['instance']); ?>>サムネイルを表示する</label>
</p>