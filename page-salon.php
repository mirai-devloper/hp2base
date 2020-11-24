<?php
/*
Template Name: Access pages
*/
add_action('wp_enqueue_scripts', function() {
	wp_enqueue_script('google-map-api', '//maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&key=AIzaSyC2PVeXoLpOd7_52W1NuOsPMSE_UqUpT6A', array());
});

get_header();

get_template_part('templates/salon-page');

get_footer();
