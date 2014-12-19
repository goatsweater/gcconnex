<?php
if (elgg_is_xhr()) {  //This is an Ajax call!

    $user_guid = get_input('guid');
    $user = get_user($user_guid);

    $section = get_input('section');

    switch ($section) {
        case 'about-me':
            $user->description = get_input('description', 'ERROR: Ask your admin to grep: 5FH13GAHHHS0001.');
            $user->save();
            break;
        case 'education':
            $eguid = get_input('eguid', '');
            $school = get_input('school', 'ERROR: Ask your admin to grep: 5FH13GAHHHS0002.');
            $startdate = get_input('startdate', 'ERROR: Ask your admin to grep: 5FH13GAHHHS0003.');
            $enddate = get_input('enddate', 'ERROR: Ask your admin to grep: 5FH13GAHHHS0004.');
            $program = get_input('program', 'ERROR: Ask your admin to grep: 5FH13GAHHHS0005.');
            $field = get_input('field', 'ERROR: Ask your admin to grep: 5FH13GAHHHS0006.');

            // create education object
            $education_guids = array();

            //if(!(is_array($eguid))) { $eguid = array($eguid); }

            foreach ($eguid as $k => $v) {
                if ($v == "new") {
                    $education = new ElggObject();
                    $education->subtype = "education";
                    $education->owner_guid = $user_guid;
                }
                else {
                    $education = get_entity($v);
                }

                $education->title = $school[$k];
                $education->description = $program[$k];

                $education->school = $school[$k];
                $education->startdate = $startdate[$k];
                $education->enddate = $enddate[$k];
                $education->program = $program[$k];
                $education->field = $field[$k];

                if($v == "new") {
                    $education_guids[] = $education->save();
                }
            }

            if ($user->education == NULL) {
                $user->education = $education_guids;
            }
            else {
                $stack = $user->education;
                if (!(is_array($stack))) { $stack = array($stack); }

                if ($education_guids != NULL) {
                    $user->education = array_merge($stack, $education_guids);
                    $user->stack = $stack;
                    $user->educ = $education_guids;
                }
                //$user->education = NULL; //for dev testing.. delete later
                //$user->stack = NULL;
                //$user->educ = NULL;
            }
            /*
            $education = new ElggObject();
            $education->subtype = "education";
            $education->title = $school;
            $education->description = $program;

            $education->owner_guid = $user_guid;
            $education->school = $school;
            $education->startdate = $startdate;
            $education->enddate = $enddate;
            $education->program = $program;
            $education->field = $field;

            $education_guids[] = $education->save();
*/
            //$user->__set('education', $education)

            $user->save();
            break;
        case 'work-experience':
            $organization = get_input('organization', 'ERROR: Ask your admin to grep: 5FH13GAHHHS0011.');
            $startdate = get_input('startdate', 'ERROR: Ask your admin to grep: 5FH13GAHHHS0012.');
            $enddate = get_input('enddate', 'ERROR: Ask your admin to grep: 5FH13GAHHHS0013.');
            $title = get_input('title', 'ERROR: Ask your admin to grep: 5FH13GAHHHS0014.');
            $responsibilities = get_input('responsibilities', 'ERROR: Ask your admin to grep: 5FH13GAHHHS0015.');

            // create work experience object
            $work = new ElggObject();
            $work->subtype = "work";
            $work->title = $title;
            $work->description = $responsibilities;

            $work->owner_guid = $user_guid;
            $work->organization = $organization;
            $work->startdate = $startdate;
            $work->enddate = $enddate;
            $work->title = $title;
            $work->responsibilities = $responsibilities;

            $work_guid = $work->save();

            $user->work = $work_guid;

            $user->save();
            break;
        case 'endorsements':
            $skillsToAdd = get_input('skillsadded', 'ERROR: Ask your admin to grep: 5FH13GAHHHS0021.');
            $skillsToRemove = get_input('skillsremoved', 'ERROR: Ask your admin to grep: 5FH13GAHHHS0022.');

            $skill_guids = array();

            foreach ($skillsToAdd as $new_skill) {
                $skill = new ElggObject();
                $skill->subtype = "MySkill";
                $skill->title = $new_skill;
                $skill->owner_guid = $user_guid;
                $skill_guids[] = $skill->save();
            }

            if ($user->skills == NULL) {
                $user->skills = $skill_guids;
            }
            else {
                $stack = $user->skills;
                $user->skills = array_merge($stack, $skill_guids);
            }

            $user->save();
            break;
        default:
            system_message(elgg_echo("profile:saved"));

    }

    system_message(elgg_echo("profile:saved"));

}
else {  // In case this view will be called via the elgg_view_form() action, then we know it's the basic profile only

    $user_guid = elgg_get_logged_in_user_guid(); //get_input('guid');
    $user = get_user($user_guid);

    $fields = array('name', 'title', 'department', 'phone', 'mobile', 'email');

    foreach ($fields as $field) {
        $value = get_input($field);
        $user->set($field, $value);
    }

    $weblink = array('website', 'facebook', 'google', 'github', 'twitter', 'linkedin', 'pinterest', 'tumblr', 'instagram', 'flickr', 'youtube');

    foreach ($weblink as $link) {
        $value = get_input($link);
        if (filter_var($value, FILTER_VALIDATE_URL) !== false) {
            $user->set($link, $value);
        }
    }

    $user->micro = get_input('micro');
    $user->save();

    system_message(elgg_echo("profile:saved"));

    forward($user->getURL());
}
?>