<?php

if (elgg_is_xhr()) {  //This is an Ajax call!

    //$user_guid = $_GET["user"];
    $user_guid = $_GET["guid"];
    $user = get_user($user_guid);

    /*
    $education = array(
        'school' => $user->education[0]['school'],
        'startdate' => $user->education[0]['startdate'],
        'enddate' => $user->education[0]['enddate'],
        'program' => $user->education[0]['program'],
        'field' => $user->education[0]['field']
    );*/

    //$metadata = elgg_get_metadata(array('metadata_owner_guids' => $user_guid));

    //$value = $metadata[2]->name;

    $value = $user->education;
    var_dump($value);

    echo 'School Name: ' . $value;

    $params = array(
        'name' => 'education',
        'class' => 'gcconnex-education-school',
        'value' => $value,
    );

    echo elgg_view("input/text", $params);

    echo '<br>Start Date: ' . elgg_view("input/text", array('name' => 'startdate', 'class' => 'gcconnex-education-startdate', 'value' => $startdate));
    echo 'End Date: ' . elgg_view("input/text", array('name' => 'enddate', 'class' => 'gcconnex-education-enddate', 'value' => $enddate));
    echo '<br>Program: ' . elgg_view("input/text", array('name' => 'program', 'class' => 'gcconnex-education-program', 'value' => $program));
    echo '<br>Field of Study: ' . elgg_view("input/text", array('name' => 'fieldofstudy', 'class' => 'gcconnex-education-field', 'value' => $field));
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