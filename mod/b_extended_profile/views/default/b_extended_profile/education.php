<?php

if (elgg_is_xhr()) {
    $user_guid = $_GET["guid"];
}
else {
    $user_guid = elgg_get_page_owner_guid();
}

$user = get_user($user_guid);
$education_guid = $user->education;




echo '<div class="gcconnex-profile-section-wrapper gcconnex-education">'; // create the profile section wrapper div for css styling
echo '<div class="gcconnex-profile-title">' . elgg_echo('gcconnex_profile:education') . '</div>'; // create the profile section title

if ($user->canEdit()) {
    // create the edit/save/cancel toggles for this section
    echo '<span class="gcconnex-profile-edit-controls">';
    echo '<span class="edit-control edit-education"><img src="' . elgg_get_site_url() . 'mod/b_extended_profile/img/edit.png">' . elgg_echo('gcconnex_profile:edit') . '</span>';
    echo '<span class="save-control save-education hidden"><img src="' . elgg_get_site_url() . 'mod/b_extended_profile/img/save.png">' . elgg_echo('gcconnex_profile:save') . '</span>';
    echo '<span class="cancel-control cancel-education hidden"><img src="' . elgg_get_site_url() . 'mod/b_extended_profile/img/cancel.png">' . elgg_echo('gcconnex_profile:cancel') . '</span>';
    echo '</span>';
}

if ($education_guid == NULL || empty($education_guid)) {
    echo elgg_echo('gcconnex_profile:education:empty');
}
else {
    if (!(is_array($education_guid))) {
        $education_guid = array($education_guid);
    }
    usort($education_guid, "sortDate");

    foreach ($education_guid as $guid) {

        $education = get_entity($guid);

        echo '<div class="gcconnex-profile-education-display gcconnex-education-' . $education->guid . '">';
        echo '<div class="gcconnex-profile-label education-dates">' . $education->startdate . ', ' . $education->startyear . ' - ';
        if ($education->ongoing == 'true') {
            echo elgg_echo('gcconnex_profile:education:present');
        }
        else {
            echo $education->enddate . ', ' . $education->endyear;
        }
        echo '</div>';

        echo '<div class="gcconnex-profile-label education-school">' . $education->school . '</div>';
        echo '<div class="gcconnex-profile-label education-degree"><ul><li>' . $education->program . '</li></ul></div>';
        echo '<div class="gcconnex-profile-label education-field">' . $education->field . '</div>';
        echo '</div>';
    }
}

echo '</div>'; // close div class=gcconnex-profile-section-wrapper