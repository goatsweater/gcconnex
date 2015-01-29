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
            $delete = get_input('delete', '');
            $school = get_input('school', 'ERROR: Ask your admin to grep: 5FH13GAHHHS0002.');
            $startdate = get_input('startdate', 'ERROR: Ask your admin to grep: 5FH13GAHHHS0003.');
            $enddate = get_input('enddate', 'ERROR: Ask your admin to grep: 5FH13GAHHHS0004.');
            $program = get_input('program', 'ERROR: Ask your admin to grep: 5FH13GAHHHS0005.');
            $field = get_input('field', 'ERROR: Ask your admin to grep: 5FH13GAHHHS0006.');
            $access = get_input('access', 'ERROR: Ask your admin to grep: 5321GDS1111661353BB.');

            // create education object
            $education_guids = array();

            $education_list = $user->education;

            foreach ($delete as $delete_guid) {
                if ($delete_guid != NULL) {

                    if ($delete = get_entity($delete_guid)) {
                        $delete->delete();
                    }
                    if(($key = array_search($delete_guid, $education_list)) !== false) {
                        unset($education_list[$key]);
                    }
                }
            }

            $user->education = $education_list;

            //create new education entries
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
                $education->access_id = $access;

                if($v == "new") {
                    $education_guids[] = $education->save();
                }
                else {
                    $education->save();
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
                }

            }

            $user->education_access = $access;
            $user->save();

            break;
        case 'work-experience':

            $eguid = get_input('eguid', '');
            $delete = get_input('delete', '');

            $organization = get_input('organization', 'ERROR: Ask your admin to grep: 5FH13GAHHHS0011.');
            $startdate = get_input('startdate', 'ERROR: Ask your admin to grep: 5FH13GAHHHS0012.');
            $startyear = get_input('startyear', 'ERROR: Ask your admin to grep: 51325GASFDGGGGGGAA.');
            $enddate = get_input('enddate', 'ERROR: Ask your admin to grep: 5FH13GAHHHS0013.');
            $endyear = get_input('endyear', 'ERROR: Ask your admin to grep: 513ADGGGAFDLLLLAA.');
            $title = get_input('title', 'ERROR: Ask your admin to grep: 5FH13GAHHHS0014.');
            $responsibilities = get_input('responsibilities', 'ERROR: Ask your admin to grep: 5FH13GAHHHS0015.');
            $access = get_input('access', 'ERROR: Ask your admin to grep: 5321GDS1111661353BB.');

            // create work experience object
            $work_experience_guids = array();

            $experience_list = $user->work;

            if (!(is_array($delete))) { $delete = array($delete); }

            foreach ($delete as $delete_guid) {
                if ($delete_guid != NULL) {

                    if ($delete = get_entity($delete_guid)) {
                        $delete->delete();
                    }

                    if(($key = array_search($delete_guid, $experience_list)) !== false) {
                        unset($experience_list[$key]);
                    }
                }
            }

            $user->work = $experience_list;

            //create new work experience entries
            foreach ($eguid as $k => $v) {
                if ($v == "new") {
                    $experience = new ElggObject();
                    $experience->subtype = "experience";
                    $experience->owner_guid = $user_guid;
                }
                else {
                    $experience = get_entity($v);
                }

                $experience->title = $title[$k];
                $experience->description = $responsibilities[$k];

                $experience->organization = $organization[$k];
                $experience->title = $title[$k];
                $experience->startdate = $startdate[$k];
                $experience->startyear = $startyear[$k];
                $experience->enddate = $enddate[$k];
                $experience->endyear = $endyear[$k];
                $experience->responsibilities = $responsibilities[$k];
                $experience->access_id = $access;

                if($v == "new") {
                    $work_experience_guids[] = $experience->save();
                }
                else {
                    $experience->save();
                }
            }

            if ($user->work == NULL) {
                $user->work = $work_experience_guids;
            }
            else {
                $stack = $user->work;
                if (!(is_array($stack))) { $stack = array($stack); }

                if ($work_experience_guids != NULL) {
                    $user->work = array_merge($stack, $work_experience_guids);
                }
            }
            $user->work_access = $access;
            $user->save();
            break;

        case 'skill':
            $skillsToAdd = get_input('skillsadded', 'ERROR: Ask your admin to grep: 5FH13GAHHHS0021.');
            $skillsToRemove = get_input('skillsremoved', 'ERROR: Ask your admin to grep: 5FH13GAHHHS0022.');
            $access = ACCESS_LOGGED_IN;

            $skill_guids = array();

            foreach ($skillsToAdd as $new_skill) {
                $skill = new ElggObject();
                $skill->subtype = "MySkill";
                $skill->title = $new_skill;
                $skill->owner_guid = $user_guid;
                $skill->access_id = $access;
                $skill->endorsements = NULL;
                $skill_guids[] = $skill->save();
            }

            $skill_list = $user->gc_skills;

            if (!(is_array($skill_list))) { $skill_list = array($skill_list); }
            if (!(is_array($skillsToRemove))) { $skillsToRemove = array($skillsToRemove); }

            foreach ($skillsToRemove as $remove_guid) {
                if ($remove_guid != NULL) {

                    if ($remove = get_entity($remove_guid)) {
                        $remove->delete();
                    }

                    if (($key = array_search($remove_guid, $skill_list)) !== false) {
                        unset($skill_list[$key]);
                    }
                }
            }

            $user->gc_skills = $skill_list;

            if ($user->gc_skills == NULL) {
                $user->gc_skills = $skill_guids;
            }
            else {
                $stack = $user->gc_skills;
                if (!(is_array($stack))) { $stack = array($stack); }

                if ($skill_guids != NULL) {
                    $user->gc_skills = array_merge($stack, $skill_guids);
                }
            }

            //$user->gc_skills = null; // dev stuff... delete me
            //$user->skillsupgraded = NULL; // dev stuff.. delete me
            $user->save();
            
            break;
        case 'old-skills':
            $user->skillsupgraded = TRUE;
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
        if (filter_var($value, FILTER_VALIDATE_URL) == false) {
            $user->set($link, $value);
        }
    }

    $user->micro = get_input('micro');
    $user->save();

    system_message(elgg_echo("profile:saved"));

    forward($user->getURL());
}
?>