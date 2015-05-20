<?php

if (elgg_is_xhr()) {
    $user_guid = $_GET["guid"];
}
else {
    $user_guid = elgg_get_page_owner_guid();
}

$user = get_user($user_guid);
$education_guid = $user->education;

echo '<div class="gcconnex-profile-education-display">';

if ($user->canEdit() && ($education_guid == NULL || empty($education_guid))) {
    echo elgg_echo('gcconnex_profile:education:empty');
}
else {
    if (!(is_array($education_guid))) {
        $education_guid = array($education_guid);
    }
    usort($education_guid, "sortDate");

    foreach ($education_guid as $guid) {

        if ($education = get_entity($guid)) {

            echo '<div class="gcconnex-profile-education-display gcconnex-education-' . $education->guid . '">';
            echo '<div class="gcconnex-profile-label education-dates">' . $education->startdate . ', ' . $education->startyear . ' - ';

            if ($education->ongoing == 'true') {
                echo elgg_echo('gcconnex_profile:education:present');
            } else {
                echo $education->enddate . ', ' . $education->endyear;
            }
            echo '</div>';

            echo '<div class="gcconnex-profile-label education-school">' . $education->school . '</div>';
            echo '<div class="gcconnex-profile-label education-degree"><ul><li>' . $education->degree . '</li></ul></div>';
            //echo '<div class="gcconnex-profile-label education-program"><ul><li>' . $education->program . '</li></ul></div>';
            echo '<div class="gcconnex-profile-label education-field">' . $education->field . '</div>';
            echo '</div>';
        }
    }
}

echo '</div>'; // close div class="gcconnex-profile-education-display"
//echo '</div>'; // close div class="gcconnex-profile-section-wrapper"