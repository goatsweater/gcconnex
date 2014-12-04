<?php
$user_guid = elgg_get_logged_in_user_guid();
$user = get_user($user_guid);

$skills = $user->skills;

echo '<div class="gcconnex-profile-endorsements-display">';

if (is_array($skills)) {
    foreach($skills as $skill) {
        echo '<div class="gcconnex-endorsement-skills-list-wrapper">' . $skill . '</div>';
    }
}
else {
    echo '<div class="gcconnex-endorsement-skills-list-wrapper">' . $skills . '</div>';
}


echo '</div><div class="endorsements-message"></div>';
