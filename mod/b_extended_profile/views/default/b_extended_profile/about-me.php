<?php
elgg_load_js('extended_tinymce');
elgg_load_js('elgg.extended_tinymce');

$user_guid = elgg_get_logged_in_user_guid();
$user = get_user($user_guid);

echo '<div class="gcconnex-profile-about-me-display">' . $user->description . '</div>';