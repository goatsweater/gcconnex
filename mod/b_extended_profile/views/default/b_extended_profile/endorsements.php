<?php
$user_guid = elgg_get_logged_in_user_guid();
$user = get_user($user_guid);

$skill_guids = $user->skills;


echo '<div class="gcconnex-profile-endorsements-display">';
echo '<div class="gcconnex-endorsements-skills-list-wrapper">';

//$user->skills = NULL;

if (is_array($skill_guids)) {
    foreach($skill_guids as $skill_guid) {
        $skill = get_entity($skill_guid);
        echo '<div class="gcconnex-endorsements-count">0</div><div class="gcconnex-endorsements-skill">' . $skill->title . '</div><br>';
    }
}
else {
    $skill = get_entity($skill_guids);
    echo '<div class="gcconnex-endorsements-count">0</div><div class="gcconnex-endorsements-skill">' . $skill->title . '</div>';
}

echo '</div></div><div class="endorsements-message"></div>';
