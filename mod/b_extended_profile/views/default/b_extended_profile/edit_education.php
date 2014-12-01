<?php

if (elgg_is_xhr()) {  //This is an Ajax call!

    //$user_guid = $_GET["user"];
    $user_guid = $_GET["guid"];
    $user = get_user($user_guid);

    $education_guid = $user->education;
    $education = get_entity($education_guid);

    echo 'School Name: ' . elgg_view("input/text", array('name' => 'education', 'class' => 'gcconnex-education-school', 'value' => $education->school,));
    echo '<br>Start Date: ' . elgg_view("input/text", array('name' => 'startdate', 'class' => 'gcconnex-education-startdate', 'value' => $education->startdate));
    echo 'End Date: ' . elgg_view("input/text", array('name' => 'enddate', 'class' => 'gcconnex-education-enddate', 'value' => $education->enddate));
    echo '<br>Program: ' . elgg_view("input/text", array('name' => 'program', 'class' => 'gcconnex-education-program', 'value' => $education->program));
    echo '<br>Field of Study: ' . elgg_view("input/text", array('name' => 'fieldofstudy', 'class' => 'gcconnex-education-field', 'value' => $education->field));
    echo '<br>';

    $access_id = ACCESS_DEFAULT;
    $params = array(
        'name' => "accesslevel['education']",
        'value' => $access_id,
    );

    echo elgg_view('input/access', $params);
}

else {  // In case this view will be called via elgg_view()
    echo 'An error has occurred. Please ask the system administrator to grep: DZZZNSJ662277';
}
?>