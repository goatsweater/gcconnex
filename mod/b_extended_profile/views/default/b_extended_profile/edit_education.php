<?php

if (elgg_is_xhr()) {  //This is an Ajax call!

    //$user_guid = $_GET["user"];
    $user_guid = $_GET["guid"];
    $user = get_user($user_guid);

    //get the array of user education entities
    $education_guid = $user->education;

    echo '<div class="gcconnex-education-all">';

    if (is_array($education_guid)) {
        foreach ($education_guid as $guid) { // display the input/education view for each education entry
            echo elgg_view('input/education', array('guid' => $guid));
        }
    }
    else {
        echo elgg_view('input/education', array('guid' => $education_guid));
    }


    echo '</div>';

    echo '<br><div class="gcconnex-education-add-another" onclick="addMore()">+ add more education</div>';

    echo '<br>Allow education details to be viewable by: ';

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