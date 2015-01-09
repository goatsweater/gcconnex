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
    echo 'School Name: ' . elgg_view("input/text", array(
            'name' => 'education',
            'class' => 'gcconnex-education-school',
            'value' => $education->school));

    // enter start date
    echo '<br>Start Date: ' . elgg_view("input/text", array(
            'name' => 'startdate',
            'class' => 'gcconnex-education-startdate',
            'value' => $education->startdate));

    // enter end date
    echo 'End Date: ' . elgg_view("input/text", array(
            'name' => 'enddate',
            'class' => 'gcconnex-education-enddate',
            'value' => $education->enddate));

    // enter program
    echo '<br>Program: ' . elgg_view("input/text", array(
            'name' => 'program',
            'class' => 'gcconnex-education-program',
            'value' => $education->program));

    // enter field  of study
    echo '<br>Field of Study: ' . elgg_view("input/text", array(
            'name' => 'fieldofstudy',
            'class' => 'gcconnex-education-field',
            'value' => $education->field));

    // create a delete button for each education entry
    echo '<br><div class="elgg-button elgg-button-action btn" onclick="deleteEducation(this)">Delete this entry</div>';

echo '</div>'; // close div class="gcconnex-education-entry"