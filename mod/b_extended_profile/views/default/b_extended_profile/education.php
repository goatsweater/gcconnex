<?php
$user_guid = elgg_get_logged_in_user_guid();
$user = get_user($user_guid);

$education_guid = $user->education;

echo '$education_guid: ';
var_dump($education_guid);
echo '<br>$user->education: ';
var_dump($user->education);
echo '<br>$user->stack: ';
var_dump($user->stack);
echo '<br>$user->educ: ';
var_dump($user->educ);

if (is_array($education_guid)) {

    foreach ($education_guid as $guid) {

        $education = get_entity($guid);

        echo '<div class="gcconnex-profile-education-display">';
        echo '<div class="gcconnex-profile-label education-dates">' . $education->startdate . ' - ' . $education->enddate . '</div>';

        echo '<div class="gcconnex-profile-label education-school">' . $education->school . '</div>';
        echo '<div class="gcconnex-profile-label education-degree"><ul><li>' . $education->program . '</li></ul></div>';
        echo '<div class="gcconnex-profile-label education-field">' . $education->field . '</div>';
        echo '</div>';
    }
}
else {

    $education = get_entity($education_guid);

    echo '<div class="gcconnex-profile-education-display">';
    echo '<div class="gcconnex-profile-label education-dates">' . $education->startdate . ' - ' . $education->enddate . '</div>';

    echo '<div class="gcconnex-profile-label education-school">' . $education->school . '</div>';
    echo '<div class="gcconnex-profile-label education-degree"><ul><li>' . $education->program . '</li></ul></div>';
    echo '<div class="gcconnex-profile-label education-field">' . $education->field . '</div>';
    echo '</div>';
}