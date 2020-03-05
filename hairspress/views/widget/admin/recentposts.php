<p>
	<label for="<?= $field['id']; ?>"><?= __('PostType:'); ?></label>
	<select name="<?= $field['name']; ?>" id="<?= $field['id']; ?>">
		<?php foreach ($post_types as $type) : ?>
		<option value="<?= $type->name; ?>" <?php selected($instance, $type->name) ?>><?= $type->label; ?></option>
		<?php endforeach; ?>
	</select>
</p>
