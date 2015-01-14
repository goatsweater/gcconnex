<?php
$user_guid = elgg_get_page_owner_guid();
$user = get_user($user_guid);

$skill_guids = $user->skills;


echo '<div class="gcconnex-profile-endorsements-display">';
echo '<div class="gcconnex-endorsements-skills-list-wrapper">';

//$user->skills = NULL;
if(!(is_array($skill_guids))) {
    $skill_guids = array($skill_guids);
}

if (is_array($skill_guids)) {
    foreach($skill_guids as $skill_guid) {
        $skill = get_entity($skill_guid);
        $skill_class =  str_replace(' ', '-', strtolower($skill->title));
        echo '<div class="gcconnex-skill-entry" data-guid="' . $skill_guid . '">';
            echo '<div class="gcconnex-endorsements-count gcconnex-endorsements-count-' . $skill_class . '">' . count($skill->endorsements) . '</div><div class="gcconnex-endorsements-skill" data-type="skill">' . $skill->title . '</div>';

            if (elgg_get_page_owner_guid() != elgg_get_logged_in_user_guid()) {
                if($result = array_search(elgg_get_logged_in_user_guid(), $skill->endorsements) == true || $skill->endorsements == NULL) {
                    echo '<span class="gcconnex-endorsement-add add-endorsement-' . $skill_class . '" onclick="addEndorsement(this)" data-guid="' . $skill->guid . '" data-skill="' . $skill->title . '">+</span>';
                }
                else {
                    echo '<span class="gcconnex-endorsement-retract retract-endorsement-' . $skill_class . '" onclick="retractEndorsement(this)" data-guid="' . $skill->guid . '" data-skill="' . $skill->title . '">-</span>';
                }
            }
        // @todo: add the endorsing user's profile image to the list of endorsers for this skill
        echo '</div>'; // close div class=gcconnex-skill-entry


    }
}
else {
    $skill = get_entity($skill_guids);
//    $skillClass = str_replace(" ", "-", strtolower($skill->title));
    echo '<div class="gcconnex-skill-entry" data-guid="' . $skill_guids . '">';
        echo '<div class="gcconnex-endorsements-count">0</div><div class="gcconnex-endorsements-skill" data-type="skill">' . $skill->title . '</div>';
    echo '</div>';
}

echo '</div></div><div class="endorsements-message"></div>';
