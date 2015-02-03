<style>
    body {
        font-family: arial;
    }
    .c_table {
        border:1px solid #ccc;
        background-color: orangered;
        width: 600px;
    }

    h1 {
        padding: 0px;
        margin: 0px;
        color: #3c698e;
    }

    .basic-profile-label {
        margin: 5px;
        float: left;
        text-align: right;
        width: 120px;
    }

    .social-media-label {
        float: inherit;
        text-align: left;
    }

    .basic-profile-field {
        margin: 3px;
    }

    .table th,td {
        padding:10px;
    }


    .c_table {
        border: 1px solid;
        margin: 5px 0px;
        padding:0px 10px 0px 10px;
        width: 100%;
        background-repeat: no-repeat;
        background-position: 10px center;
        color: #00529B;
        background-color: #BDE5F8;
        background-image: url('info.png');
    }

    .input-group-addon {
        padding: 6px 12px;
        font-size: 14px;
        font-weight: 400;
        line-height: 1;
        color: #555;
        text-align: center;
        background-color: #EEE;
        border: 1px solid #CCC;
        border-top-left-radius: 4px;
        border-bottom-left-radius: 4px;
        display: table-cell;
        white-space: nowrap;
        vertical-align: middle;
        float: left;
    }

    .input-group {
        border-collapse: separate;
    }

    .basic-profile {
        width: 100%;
        height: 100%;
    }

    .basic-profile-standard-field-wrapper,
    .basic-profile-social-media-wrapper,
    .basic-profile-micro-assignments {
        width: 375px;
        float: left;
    }

    .social-media-field-wrapper {
    }

    .gcconnex-basic-field {
        width: 150px;
        height: 28px;
        margin-left: -1px;
        border: 1px solid lightgray;
        border-top-right-radius: 3px;
        border-bottom-right-radius: 3px;
    }
    .submit-basic-profile {
        width: 100%;
    }

</style>


<?php


$guid = elgg_get_logged_in_user_guid();
$user = get_user($guid);

// pre-populate which fields to display on the "edit basic profile" overlay
$fields = array('Name', 'Title', 'Department', 'Phone', 'Mobile', 'Email', 'Website');

echo '<h1>' . elgg_echo('gcconnex_profile:basic:header') . '</h1>';
echo '<div class="basic-profile">'; // outer container for all content (except the form title above) for css styling
echo '<div class="basic-profile-standard-field-wrapper">'; // container for css styling, used to group profile content and display them seperately from other fields


foreach ($fields as $field) { // create a label and input box for each field on the basic profile (see $fields above)

    echo '<div class="basic-profile-field-wrapper">'; // field wrapper for css styling

        $field = strtolower($field);
        echo '<br><div class="basic-profile-label ' . $field . '-label">' . elgg_echo('gcconnex_profile:basic:' . $field) . 'x</div>'; // field label

        $value = $user->get($field);

        // setup the input for this field
        $params = array(
            'name' => $field,
            'class' => 'gcconnex-basic-' . $field,
            'value' => $value,
        );

        echo '<div class="basic-profile-field">'; // field wrapper for css styling
            echo elgg_view("input/text", $params); // input field
        echo '</div>'; //close div class = basic-profile-field

    echo '</div>'; //close div class = basic-profile-field-wrapper
}

echo '</div>';

echo '<div class="basic-profile-social-media-wrapper">'; // container for css styling, used to group profile content and display them seperately from other fields

// pre-populate the social media fields and their prepended link for user profiles
$fields = array('Facebook' => "http://www.facebook.com/",
    'Google Plus' => "http://www.google.com/",
    'GitHub' => "https://github.com/",
    'Twitter' => "https://twitter.com/",
    'Linkedin' => "http://ca.linkedin.com/in/",
    'Pinterest' => "http://www.pinterest.com/",
    'Tumblr' => "https://www.tumblr.com/blog/",
    'Instagram' => "http://instagram.com/",
    'Flickr' => "http://flickr.com/",
    'Youtube' => "http://www.youtube.com/");

foreach ($fields as $field => $field_link) { // create a label and input box for each social media field on the basic profile

    echo '<div class="basic-profile-field-wrapper social-media-field-wrapper">'; //field wrapper for css styling

        echo '<br><div class="basic-profile-label social-media-label ' . $field . '-label">' . $field . ': </div>';
       $field = str_replace(' ', '-', $field); // create a css friendly version of the section name

        $field = strtolower($field);
        $value = $user->get($field);

        echo '<div class="input-group">'; // input wrapper for prepended link and input box, excludes the input label

            echo '<span class="input-group-addon">' . $field_link . "</span>"; // prepended link

            // setup the input for this field
            $placeholder = "test";
            if ($field == "facebook") { $placeholder = "User.Name"; }
            if ($field == "google-plus") { $placeholder = "############"; }
            if ($field == "github") { $placeholder = "User"; }
            if ($field == "twitter") { $placeholder = "@user"; }
            if ($field == "linkedin") { $placeholder = "CustomURL"; }
            if ($field == "pinterest") { $placeholder = "Username"; }
            if ($field == "tumblr") { $placeholder = "Username"; }
            if ($field == "instagram") { $placeholder = "@user"; }
            if ($field == "flickr") { $placeholder = "Username"; }
            if ($field == "youtube") { $placeholder = "Username"; }

            $params = array(
                'name' => $field,
                'class' => 'form-control gcconnex-basic-field gcconnex-basic-' . $field,
                'placeholder' => $placeholder,
                'value' => $value
            );

            echo elgg_view("input/text", $params); // input field

        echo '</div>'; // close div class="input-group"

    echo '</div>'; // close div class = basic-profile-field-wrapper
}

echo '</div>'; // close div class="basic-profile-social-media-wrapper"

echo '<div class="basic-profile-micro-assignments">'; // container for css styling, used to group profile content and display them seperately from other fields

echo 'Micro-assignments are short-duration assignments that are posted on GCconnex and available to all public servants regardless of department.' .
    ' They are short in duration and scope. <p>In order to opt-in for micro-assignments, you must have your manager\'s approval prior to clicking' .
    ' the checkbox below.<p>';

echo elgg_view('input/checkbox', array(
    'name' => 'micro',
    'checked' => ($user->micro == "on") ? "on" : FALSE)); // elgg has a hard time saving checkbox status natively, so check the string value instead
echo 'I would like to opt-in to micro-assignments';
echo '</div>'; // close div class="basic-profile-micro-assignments

echo '<div class="submit-basic-profile">'; // container for css styling, used to group profile content and display them seperately from other fields

// create the save button for saving user profile
echo elgg_view('input/button', array(
    'type' => 'submit',
    'value' => 'Save'));

echo '</div>'; // close div class="submit-basic-profile"
echo '</div>'; // close div class="basic-profile"