<?php
/*
 * Author: Bryden Arndt
 * Date: 01/07/2015
 * Purpose: Display the about-me section of the current user's profile
 * Requires: extended_tinymce plugin, and requires us to load the extended_tinymce js files
 */

elgg_load_js('extended_tinymce');
elgg_load_js('elgg.extended_tinymce');

$user_guid = elgg_get_logged_in_user_guid();
$user = get_user($user_guid);

// wrap the about-me field in a wrapper for css styling
echo '<div class="gcconnex-profile-about-me-display">' . $user->description . '</div>';