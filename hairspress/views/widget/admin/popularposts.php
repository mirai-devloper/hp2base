<p>
	<label for="<?= $fields['id']; ?>"><?php _e('Title:'); ?></label>
	<input type="text" class="widefat" id="<?= $fields['id']; ?>" name="<?= $fields['name']; ?>" value="<?= esc_attr($instance['title']); ?>">
</p>