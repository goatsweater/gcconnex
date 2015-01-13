<?php
$user_guid = elgg_get_page_owner_guid();
$user = get_user($user_guid);

$education_guid = $user->education;


if (is_array($education_guid)) {

    foreach ($education_guid as $guid) {

        $education = get_entity($guid);

        echo '<div class="gcconnex-profile-education-display gcconnex-education-' . $education->guid . '">';
        echo '<div class="gcconnex-profile-label education-dates">' . $education->startdate . ' - ' . $education->enddate . '</div>';

        echo '<div class="gcconnex-profile-label education-school">' . $education->school . '</div>';
        echo '<div class="gcconnex-profile-label education-degree"><ul><li>' . $education->program . '</li></ul></div>';
        echo '<div class="gcconnex-profile-label education-field">' . $education->field . '</div>';
        echo '</div>';
    }
}
else if ($education_guid != NULL) {

    $education = get_entity($education_guid);

    echo '<div class="gcconnex-profile-education-display">';
    echo '<div class="gcconnex-profile-label education-dates">' . $education->startdate . ' - ' . $education->enddate . '</div>';

    echo '<div class="gcconnex-profile-label education-school">' . $education->school . '</div>';
    echo '<div class="gcconnex-profile-label education-degree"><ul><li>' . $education->program . '</li></ul></div>';
    echo '<div class="gcconnex-profile-label education-field">' . $education->field . '</div>';
    echo '</div>';
}