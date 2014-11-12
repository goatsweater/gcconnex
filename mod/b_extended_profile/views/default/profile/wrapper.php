<?php
/**
 * Profile info box
 */
elgg_load_js('endorsements-js');
elgg_load_css('endorsements-css');
?>

<div class="profile elgg-col-3of3">
    <div class="elgg-inner clearfix">
        <?php echo elgg_view('profile/owner_block'); ?>
        <?php echo elgg_view('profile/details'); ?>

    </div>
    <div class="gcconnex-profile-section-wrapper gcconnex-about-me"><div class="gcconnex-profile-title">About Me</div>
<?php
$user = elgg_get_page_owner_entity();
$aboutme = $user->description;
echo $aboutme; ?>
    </div>
        <?php echo elgg_view('b_extended_profile/education'); ?>
    <div class="gcconnex-profile-section-wrapper gcconnex-experience"><div class="gcconnex-profile-title">Work Experience</div>
        <?php if (elgg_get_logged_in_user_entity() == elgg_get_page_owner_entity()) {
            echo '<span class="gcconnex-profile-edit-controls">';
            echo '<span class="edit-control edit-experience"><img src="' . elgg_get_site_url() . 'mod/b_extended_profile/img/edit.png">Edit</span>';
            echo '<span class="save-control save-experience"><img src="' . elgg_get_site_url() . 'mod/b_extended_profile/img/save.png">Save</span>';
            echo '<span class="cancel-control cancel-experience"><img src="' . elgg_get_site_url() . 'mod/b_extended_profile/img/cancel.png">Cancel</span>';
            echo '</span>';
        }
        ?>
        <div class="experience-dates">August 2008 - April 2014</div>
        <div class="experience-title">Human Resources Manager</div>
        <div class="experience-organization">Harris/Decima Inc.</div>
        <div class="experience-description">Responsible for the staffing levels in the call-centre, benefits administration, policy interpretation and part-time hiring at the Ottawa location. Prepared bi-weekly payroll reports including reimbursements, address changes, increases, bonuses and retroactive adjustments.</div>
    </div>
    <div class="gcconnex-profile-section-wrapper gcconnex-endorsement-wrapper">
        <span class="gcconnex-profile-title">Endorsements</span>

        <?php if (elgg_get_logged_in_user_entity() == elgg_get_page_owner_entity()) {
            echo '<span class="gcconnex-profile-edit-controls">';
            echo '<span class="edit-control edit-endorsements"><img src="' . elgg_get_site_url() . 'mod/b_extended_profile/img/edit.png">Edit</span>';
            echo '<span class="save-control save-endorsements"><img src="' . elgg_get_site_url() . 'mod/b_extended_profile/img/save.png">Save</span>';
            echo '<span class="cancel-control cancel-endorsements"><img src="' . elgg_get_site_url() . 'mod/b_extended_profile/img/cancel.png">Cancel</span>';
            echo '</span>';
        }
        ?>
        <div class="gcconnex-endorsement-skills-list-wrapper"></div>
        <div class="endorsements-message"></div>
    </div>
</div>