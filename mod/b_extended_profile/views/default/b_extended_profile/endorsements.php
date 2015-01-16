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

if (is_array($skill_guids) && elgg_is_logged_in()) {
    foreach($skill_guids as $skill_guid) {
        $skill = get_entity($skill_guid);
        $skill_class =  str_replace(' ', '-', strtolower($skill->title));
        echo '<div class="gcconnex-skill-entry" data-guid="' . $skill_guid . '">';
            echo '<div class="gcconnex-endorsements-count gcconnex-endorsements-count-' . $skill_class . '">' . count($skill->endorsements) . '</div><div class="gcconnex-endorsements-skill" data-type="skill">' . $skill->title . '</div>';

        $endorsements = $skill->endorsements;
        if(!(is_array($endorsements))) { $endorsements = array($endorsements); }

            if (elgg_get_page_owner_guid() != elgg_get_logged_in_user_guid()) {
                if(in_array(elgg_get_logged_in_user_guid(), $endorsements) == false || empty($endorsements)) {
                    // user has not yet endorsed this skill for this user.. present the option to endorse
                    error_log('SKILL: ' . $skill->title);
                    error_log('Logged in user: ' . elgg_get_logged_in_user_guid());
                    error_log('Endorsements: ' . $endorsements);
                    error_log('Search result: ' . in_array(elgg_get_logged_in_user_guid(), $endorsements));

                    echo '<span class="gcconnex-endorsement-add add-endorsement-' . $skill_class . '" onclick="addEndorsement(this)" data-guid="' . $skill->guid . '" data-skill="' . $skill->title . '">+</span>';
                }
                else {
                    // user has endorsed this skill for this user.. present the option to retract endorsement
                    echo '<span class="gcconnex-endorsement-retract retract-endorsement-' . $skill_class . '" onclick="retractEndorsement(this)" data-guid="' . $skill->guid . '" data-skill="' . $skill->title . '">-</span>';
                    error_log('SKILL: ' . $skill->title);
                    error_log('Logged in user: ' . elgg_get_logged_in_user_guid());
                    error_log('Endorsements: ' . $endorsements);
                    error_log('Search result: ' . in_array(elgg_get_logged_in_user_guid(), $endorsements));
                }
            }
        // @todo: add the endorsing user's profile image to the list of endorsers for this skill
        echo '</div>'; // close div class=gcconnex-skill-entry


    }
}
else {


    /*

    $skill = get_entity($skill_guids);
//    $skillClass = str_replace(" ", "-", strtolower($skill->title));
    echo '<div class="gcconnex-skill-entry" data-guid="' . $skill_guids . '">';
        echo '<div class="gcconnex-endorsements-count">0</div><div class="gcconnex-endorsements-skill" data-type="skill">' . $skill->title . '</div>';
    echo '</div>';
    */
}

echo '</div></div><div class="endorsements-message"></div>';
