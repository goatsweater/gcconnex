<?php
$user_guid = elgg_get_logged_in_user_guid();
$user = get_user($user_guid);

$work_guid = $user->work;
$work = get_entity($work_guid);

echo '<div class="gcconnex-profile-work-experience-display">';
echo '<div class="work-experience-dates">' . $work->startdate . ' - ' . $work->enddate . '</div>';
echo '<div class="work-experience-title">' . $work->title . '</div>';
echo '<div class="work-experience-organization">' . $work->organization . '</div>';
echo '<div class="work-experience-responsibilities">' . $work->responsibilities . '</div>';
echo '</div>';