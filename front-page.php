<?php
	global $wphp;

  get_header();

	$concept = $wphp->hp_salon_concept;
	do_action('hairspress_concept', $concept);


	if ($wphp->options_topics_name === 'up') {
		get_template_part('template-parts/front/news');
	}

  get_template_part('template-parts/front/space');
  get_template_part('template-parts/front/blog');
  get_template_part('template-parts/front/catalog');

	// Social
	if (!empty($wphp->hp_salon_social_facebook) or !empty($wphp->hp_salon_social_instagram)) {
		get_template_part('template-parts/front/social');
	}

	if ($wphp->options_topics_name === 'down') {
		get_template_part('template-parts/front/news');
	}

  get_footer();