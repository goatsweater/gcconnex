<?php
/*
 * Author: Bryden Arndt
 * Date: 01/07/2015
 * Purpose: Display the about-me section of the current user's profile
 * Requires: extended_tinymce plugin, and requires us to load the extended_tinymce js files
 */
elgg_load_js('extended_tinymce');
elgg_load_js('elgg.extended_tinymce');


if (elgg_is_xhr()) {
    $user_guid = $_GET["guid"];
}
else {
    $user_guid = elgg_get_page_owner_guid();
}

$user = get_user($user_guid);

$sec = 'about-me'; // create a css friendly version of the section name

echo '<div class="gcconnex-profile-section-wrapper gcconnex-about-me">'; // create the profile section wrapper div for css styling
echo '<div class="gcconnex-profile-title">' . elgg_echo('gcconnex_profile:about_me') . '</div>'; // create the profile section title

if ($user->canEdit()) {
    // create the edit/save/cancel toggles for this section
    echo '<span class="gcconnex-profile-edit-controls">';
    echo '<span class="edit-control edit-about-me"><img src="' . elgg_get_site_url() . 'mod/b_extended_profile/img/edit.png">' . elgg_echo('gcconnex_profile:edit') . '</span>';
    echo '<span class="save-control save-about-me hidden"><img src="' . elgg_get_site_url() . 'mod/b_extended_profile/img/save.png">' . elgg_echo('gcconnex_profile:save') . '</span>';
    echo '<span class="cancel-control cancel-about-me hidden"><img src="' . elgg_get_site_url() . 'mod/b_extended_profile/img/cancel.png">' . elgg_echo('gcconnex_profile:cancel') . '</span>';
    echo '</span>';
}

// wrap the about-me field in a wrapper for css styling
echo '<div class="gcconnex-profile-about-me-display">';

if ($user->description == NULL || empty($user->description)) {
    echo elgg_echo('gcconnex_profile:about_me:empty');
}
else {
    echo $user->description;
}

echo '</div>'; // close div class="gcconnex-profile-about-me-display"

echo '</div>'; // close div class=gcconnex-profile-section-wrapper
