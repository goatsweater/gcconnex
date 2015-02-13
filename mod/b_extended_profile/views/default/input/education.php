<?php
/*
 * Author: Bryden Arndt
 * Date: 15/12/14
 * Time: 1:33 PM
 * Purpose: This is a collection of input fields that are grouped together to create an entry for education (designed to be entered for a user's profile).
 */


$education = get_entity($vars['guid']); // get the guid of the education entry that is being requested for display

$guid = ($education != NULL)? $vars['guid'] : "new"; // if the education guid isn't given, this must be a new entry

echo '<div class="gcconnex-education-entry" data-guid="' . $guid . '">'; // education entry wrapper for css styling

    // enter school name
    echo elgg_echo('gcconnex_profile:education:school') . elgg_view("input/text", array(
            'name' => 'education',
            'class' => 'gcconnex-education-school',
            'value' => $education->school));

    // enter start date
    echo '<br>' . elgg_echo('gcconnex_profile:education:start_month') . elgg_view("input/pulldown", array(
            'name' => 'startdate',
            'class' => 'gcconnex-education-startdate',
            'options' => array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'),
            'value' => $education->startdate));

    echo elgg_echo('gcconnex_profile:education:year') . elgg_view("input/text", array(
            'name' => 'start-year',
            'class' => 'gcconnex-education-start-year',
            'maxlength' => 4,
            'onkeypress' => "return isNumberKey(event)",
            'value' => $education->startyear));

    $params = array(
        'name' => 'enddate',
        'class' => 'gcconnex-education-enddate gcconnex-education-enddate-' . $education->guid,
        'options' => array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'),
        'value' => $education->enddate);
    if ($education->ongoing == 'true') {
        $params['disabled'] = 'true';
    }

    echo '<br>' . elgg_echo('gcconnex_profile:education:end_month') . elgg_view("input/pulldown", $params);

    unset($params);


    $params = array('name' => 'end-year',
        'class' => 'gcconnex-education-end-year gcconnex-education-end-year-' . $education->guid,
        'maxlength' => 4,
        'onkeypress' => "return isNumberKey(event)",
        'value' => $education->endyear);
    if ($education->ongoing == 'true') {
        $params['disabled'] = 'true';
    }

    echo elgg_echo('gcconnex_profile:education:year') .  elgg_view("input/text", $params);

    unset($params);

    $params = array(
        'name' => 'ongoing',
        'class' => 'gcconnex-education-ongoing',
        'onclick' => 'toggleEndDate(' . $education->guid . ', "education")',
    );
    if ($education->ongoing == 'true') {
        $params['checked'] = $education->ongoing;
    }

    echo  '<label>' . elgg_view('input/checkbox', $params);
    echo elgg_echo('gcconnex_profile:education:ongoing') . '</label>';




    // enter program
    echo '<br>' . elgg_echo('gcconnex_profile:education:program') . elgg_view("input/text", array(
            'name' => 'program',
            'class' => 'gcconnex-education-program',
            'value' => $education->program));

    // enter field  of study
    echo '<br>' . elgg_echo('gcconnex_profile:education:field') . elgg_view("input/text", array(
            'name' => 'fieldofstudy',
            'class' => 'gcconnex-education-field',
            'value' => $education->field));

    // create a delete button for each education entry
    echo '<br><div class="elgg-button elgg-button-action btn" onclick="deleteEntry(this)" data-type="education">' . elgg_echo('gcconnex_profile:education:delete') . '</div>';

echo '</div>'; // close div class="gcconnex-education-entry"