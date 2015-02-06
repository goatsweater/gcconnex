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
        //@todo: only show sections if they have content

        // pre-populate the sections that are not empty so that we can build the profile
        $sections = array();

        if ($user = get_user(elgg_get_page_owner_guid()))
        {
            if ($user->get("description") != null || elgg_get_page_owner_guid() == elgg_get_logged_in_user_guid()) {
                    $sections[] = elgg_echo('gcconnex_profile:about_me');
                }
            if ($user->get("education") != null || elgg_get_page_owner_guid() == elgg_get_logged_in_user_guid()) {
                $sections[] = elgg_echo('gcconnex_profile:education');
            }
            if ($user->get("work") != null || elgg_get_page_owner_guid() == elgg_get_logged_in_user_guid()) {
                $sections[] = elgg_echo('gcconnex_profile:experience');
            }
            if ($user->get("gc_skills") != null || elgg_get_page_owner_guid() == elgg_get_logged_in_user_guid()) {
                $sections[] = elgg_echo('gcconnex_profile:gc_skills');
            }
        }
            // create the div wrappers and edit/save/cancel toggles for each profile section
            foreach ($sections as $section) {
                $sec = str_replace(' ', '-', $section); // create a css friendly version of the section name
                $sec = strtolower($sec); // finish making it css friendly...

                echo '<div class="gcconnex-profile-section-wrapper gcconnex-' . $sec . '">'; // create the profile section wrapper div for css styling
                echo '<div class="gcconnex-profile-title">' . $section . '</div>'; // create the profile section title

                if (elgg_get_logged_in_user_entity() == elgg_get_page_owner_entity()) {
                    // create the edit/save/cancel toggles for this section
                    echo '<span class="gcconnex-profile-edit-controls">';
                    echo '<span class="edit-control edit-' . $sec . '"><img src="' . elgg_get_site_url() . 'mod/b_extended_profile/img/edit.png">' . elgg_echo('gcconnex_profile:edit') . '</span>';
                    echo '<span class="save-control save-' . $sec . ' hidden"><img src="' . elgg_get_site_url() . 'mod/b_extended_profile/img/save.png">' . elgg_echo('gcconnex_profile:save') . '</span>';
                    echo '<span class="cancel-control cancel-' . $sec . ' hidden"><img src="' . elgg_get_site_url() . 'mod/b_extended_profile/img/cancel.png">' . elgg_echo('gcconnex_profile:cancel') . '</span>';
                    echo '</span>';
                }

                echo elgg_view('b_extended_profile/' . $sec); // call the proper view for the section

                echo '</div>'; // close div class=gcconnex-profile-secction-wrapper
            }

        ?>
    </div>
</div>