<?php
if (elgg_is_xhr()) {  //This is an Ajax call!

    $user_guid = get_input('guid');
    $user = get_user($user_guid);

    $section = get_input('section');

    switch ($section) {
        case 'aboutme':
            $user->description = get_input('description');
            $user->save();
            break;
        case 'education':
            $school = get_input('school', 'default school');
            $startdate = get_input('startdate', 'Error');
            $enddate = get_input('enddate');
            $program = get_input('program');
            $field = get_input('field');

            // create education object
            $education = new ElggObject();
            $education->subtype = "education";
            $education->title = "edu title";
            $education->description ="edu description";

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
        default:
    }



    system_message(elgg_echo("profile:saved"));

}
else {  // In case this view will be called via elgg_view()
    echo 'An error has occurred. Please ask the system administrator to grep: FMBKRL267KVD';

}
?>