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
            $school = get_input('school', 'ERROR: Ask your admin to grep: 5FH13GAHHHS0002.');
            $startdate = get_input('startdate', 'ERROR: Ask your admin to grep: 5FH13GAHHHS0003.');
            $enddate = get_input('enddate', 'ERROR: Ask your admin to grep: 5FH13GAHHHS0004.');
            $program = get_input('program', 'ERROR: Ask your admin to grep: 5FH13GAHHHS0005.');
            $field = get_input('field', 'ERROR: Ask your admin to grep: 5FH13GAHHHS0006.');

            // create education object
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

            $education_guid = $education->save();

            //$user->__set('education', $education)
            $user->education = $education_guid;

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
                $skill_guids[] = $skill->save();
            }

            if ($user->skills == NULL) {
                $user->skills = $skill_guids;
            }
            else {
                $stack = $user->skills;
                array_merge($stack, $skill_guids);
                $user->skills = $stack;
            }
            /*
            else {
                if(is_array($user->skills)) {
                    $temp = $user->skills;
                    $user->skills = array_merge($skillsToAdd, $temp);
                }
                else {
                    $user->skills = array($skillsToAdd, $user->skills);
                    //$user->skills += $skillsToAdd;
                }
            }*/


            $user->save();
            break;
        default:
    }

    system_message(elgg_echo("profile:saved"));

}
else {  // In case this view will be called via elgg_view()
    system_message('An error has occurred. Please ask the system administrator to grep: FMBKRL267KVD');
}
?>