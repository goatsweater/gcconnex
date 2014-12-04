<?php
    /**
     * Profile info box
     */
    elgg_load_js('endorsements-js');
    elgg_load_css('gcconnex-css');
    elgg_load_css('font-awesome');
?>

<div class="profile elgg-col-3of3">
    <div class="elgg-inner clearfix">
        <?php echo elgg_view('profile/owner_block'); ?>
        <?php echo elgg_view('profile/details'); ?>
    </div>
    <div class="b_extended_profile">
        <?php

            $sections = array('About Me', 'Education', 'Work Experience', 'Endorsements');

            foreach($sections as $section) {
                $sec = str_replace(' ', '-', $section);
                $sec = strtolower($sec);

                echo '<div class="gcconnex-profile-section-wrapper gcconnex-' . $sec . '">';
                echo '<div class="gcconnex-profile-title">' . $section . '</div>';

                if (elgg_get_logged_in_user_entity() == elgg_get_page_owner_entity()) {
                    echo '<span class="gcconnex-profile-edit-controls">';
                    echo '<span class="edit-control edit-' . $sec . '"><img src="' . elgg_get_site_url() . 'mod/b_extended_profile/img/edit.png">Edit</span>';
                    echo '<span class="save-control save-' . $sec . ' hidden"><img src="' . elgg_get_site_url() . 'mod/b_extended_profile/img/save.png">Save</span>';
                    echo '<span class="cancel-control cancel-' . $sec . ' hidden"><img src="' . elgg_get_site_url() . 'mod/b_extended_profile/img/cancel.png">Cancel</span>';
                    echo '</span>';

                    echo elgg_view('b_extended_profile/' . $sec);
                }
                echo '</div>';
            }
        ?>
    </div>
</div>