<?php
$user_guid = elgg_get_page_owner_guid();
$user = get_user($user_guid);

$work_experience_guid = $user->work;


if (is_array($work_experience_guid)) {

    foreach ($work_experience_guid as $guid) {

        $experience = get_entity($guid);

        echo '<div class="gcconnex-profile-work-experience-display gcconnex-work-experience-' . $experience->guid . '">';
        echo '<div class="gcconnex-profile-label work-experience-dates">' . $experience->startdate . ' - ' . $experience->enddate . '</div>';
        echo '<div class="gcconnex-profile-label work-experience-title">' . $experience->title . '</div>';
        echo '<div class="gcconnex-profile-label work-experience-organization">' . $experience->organization . '</div>';
        echo '<div class="gcconnex-profile-label work-experience-responsibilities">' . $experience->responsibilities . '</div>';
        echo '</div>';
    }
}
else if ($work_experience_guid != NULL) {

    $experience = get_entity($work_experience_guid);

    echo '<div class="gcconnex-profile-work-experience-display gcconnex-work-experience-' . $experience->guid . '">';
    echo '<div class="gcconnex-profile-label work-experience-dates">' . $experience->startdate . ' - ' . $experience->enddate . '</div>';
    echo '<div class="gcconnex-profile-label work-experience-title">' . $experience->title . '</div>';
    echo '<div class="gcconnex-profile-label work-experience-organization">' . $experience->organization . '</div>';
    echo '<div class="gcconnex-profile-label work-experience-responsibilities">' . $experience->responsibilities . '</div>';
    echo '</div>';
}


?>

<?php /*
$user_guid = elgg_get_logged_in_user_guid();
$user = get_user($user_guid);

$work_guid = $user->work;
$work = get_entity($work_guid);

echo '<div class="gcconnex-profile-work-experience-display">';
echo '<div class="work-experience-dates">' . $work->startdate . ' - ' . $work->enddate . '</div>';
echo '<div class="work-experience-title">' . $work->title . '</div>';
echo '<div class="work-experience-organization">' . $work->organization . '</div>';
echo '<div class="work-experience-responsibilities">' . $work->responsibilities . '</div>';
echo '</div>';*/ ?>