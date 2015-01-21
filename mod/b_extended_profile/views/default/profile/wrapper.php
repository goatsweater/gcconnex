<?php
/*
 * Author: Bryden Arndt
 * Date: 01/07/2015
 * Purpose: Wrap the user profile details in divs for css styling and for jQuery elements (edit/save/cancel controls below)
 * Requires: Sections must be pre-populated in the $sections array below. The view for that section must be registered in start.php, and the file has
 * to be in lowercases, named the same as what you populate $sections with, but replacing spaces with dashes.
 * IE: "About Me" becomes "about-me.php"
 */

elgg_load_js('gcconnex-profile'); // js file for handling the edit/save/cancel toggles
elgg_load_css('gcconnex-css'); // main css styling sheet
elgg_load_css('font-awesome'); // font-awesome icons for social media and some of the basic profile fields

?>

<div class="profile elgg-col-3of3">
    <div class="elgg-inner clearfix">
        <?php echo elgg_view('profile/owner_block'); ?>
        <?php echo elgg_view('profile/details'); ?>
    </div>
    <div class="b_extended_profile">
        <?php
            // pre-populate the sections so that we can build the profile
            $sections = array('About Me', 'Education', 'Work Experience', 'Endorsements');

            // create the div wrappers and edit/save/cancel toggles for each profile section
            foreach($sections as $section) {
                $sec = str_replace(' ', '-', $section); // create a css friendly version of the section name
                $sec = strtolower($sec); // finish making it css friendly...

                echo '<div class="gcconnex-profile-section-wrapper gcconnex-' . $sec . '">'; // create the profile section wrapper div for css styling
                echo '<div class="gcconnex-profile-title">' . $section . '</div>'; // create the profile section title

                if (elgg_get_logged_in_user_entity() == elgg_get_page_owner_entity()) {
                    // create the edit/save/cancel toggles for this section
                    echo '<span class="gcconnex-profile-edit-controls">';
                    echo '<span class="edit-control edit-' . $sec . '"><img src="' . elgg_get_site_url() . 'mod/b_extended_profile/img/edit.png">Edit</span>';
                    echo '<span class="save-control save-' . $sec . ' hidden"><img src="' . elgg_get_site_url() . 'mod/b_extended_profile/img/save.png">Save</span>';
                    echo '<span class="cancel-control cancel-' . $sec . ' hidden"><img src="' . elgg_get_site_url() . 'mod/b_extended_profile/img/cancel.png">Cancel</span>';
                    echo '</span>';
                }

                echo elgg_view('b_extended_profile/' . $sec); // call the proper view for the section

                echo '</div>'; // close div class=gcconnex-profile-secction-wrapper
            }
        ?>
    </div>
</div>