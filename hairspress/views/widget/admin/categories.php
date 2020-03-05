<p>
	<label for="<?= $field['id']; ?>"><?= __('Taxonomy:'); ?></label>
	<select name="<?= $field['name']; ?>" id="<?= $field['id']; ?>">
		<?php foreach ($taxonomies as $tax) : ?>
		<option value="<?= $tax->name; ?>" <?php selected($instance, $tax->name) ?>><?= $tax->label; ?>:<?= $tax->name; ?></option>
		<?php endforeach; ?>
	</select>
</p>