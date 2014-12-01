/*
 * Purpose: Provides 'LinkedIn-like endorsements' functionality for use on user profiles
 *
 * License: GPL v2.0
 * Full license here: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Author: Bryden Arndt
 * email: bryden@arndt.ca
 */

/*
 * Purpose: initialize the script
 */
$(document).ready(function() {
    // initialize errythang and hide some of the toggle elements
    $('.save-control').hide();
    $('.cancel-control').hide();

    $('.edit-aboutme').on("click", {section: "aboutme"}, editProfile);
    $('.save-aboutme').on("click", {section: "aboutme"}, saveProfile);
    $('.cancel-aboutme').on("click", {section: "aboutme"}, cancelChanges);

    $('.edit-education').on("click", {section: "education"}, editProfile);
    $('.save-education').on("click", {section: "education"}, saveProfile);
    $('.cancel-education').on("click", {section: "education"}, cancelChanges);

    $('.edit-experience').on("click", {section: "experience"}, editProfile);
    $('.save-experience').on("click", {section: "experience"}, saveProfile);
    $('.cancel-experience').on("click", {section: "experience"}, cancelChanges);

    $('.edit-endorsements').on("click", {section: "endorsements"}, editProfile);
    $('.save-endorsements').on("click", {section: "endorsements"}, saveProfile);
    $('.cancel-endorsements').on("click", {section: "endorsements"}, cancelChanges);

    // when a user clicks outside of the text box (the one for entering new skills), make it disappear elegantly
    $(document).click(function(event) {
        if(!$(event.target).closest('.gcconnex-endorsement-input-wrapper').length) {
            if($('.gcconnex-endorsement-input-skill').is(":visible")) {
                $('.gcconnex-endorsement-input-skill').hide();
                $('.gcconnex-endorsement-add-skill').fadeIn('slowly');
            }
        }
    });
});

/*
 * Purpose: To handle all click events on "edit" controls for the gcconnex profile.
 *
 * Porpoise: Porpoises are small cetaceans of the family Phocoenidae; they are related to whales and dolphins.
 *   They are distinct from dolphins, although the word "porpoise" has been used to refer to any small dolphin,
 *   especially by sailors and fishermen.
 */
function editProfile(event) {

    var $section = event.data.section; // which edit button is the user clicking on?

    // toggle the edit, save, cancel buttons
    $('.edit-' + $section).hide();
    $('.save-' + $section).show();
    $('.cancel-' + $section).show();

    switch ($section) {
        case 'aboutme':
            // Edit the About Me blurb
            $.get(elgg.normalize_url('ajax/view/b_extended_profile/edit_aboutme'),
                {
                    guid: elgg.get_logged_in_user_guid()
                },
                function(data) {
                        $('.gcconnex-profile-aboutme-display').after('<div class="gcconnex-aboutme-edit-wrapper">' + data + '</div>');
                });
            $('.gcconnex-profile-aboutme-display').hide();
            break;
        case 'education':
            // Edit the edumacation
            $.get(elgg.normalize_url('ajax/view/b_extended_profile/edit_education'),
                {
                    guid: elgg.get_logged_in_user_guid(),
                },
                function(data) {
                    // Output in a DIV with id=somewhere
                    $('.gcconnex-education').append('<div class="gcconnex-education-edit-wrapper">' + data + '</div>');
                });
            $('.gcconnex-profile-education-display').hide();
            break;
        case 'experience':
            // Edit the experience for this user
            $.get(elgg.normalize_url('ajax/view/b_extended_profile/edit_experience'),
                {
                    param: elgg.get_logged_in_user_guid()
                },
                function(data) {
                    // Output in a DIV with id=somewhere
                    $('.gcconnex-experience').append('<div class="gcconnex-experience-edit-wrapper">' + data + '</div>');
                });
            $('.gcconnex-profile-experience-display').hide();
            break;
        case 'endorsements':
            // inject the html to add ability to add skills
            $('.gcconnex-endorsement-wrapper').append('<div class="gcconnex-endorsement-input-wrapper">' +
            '<input type="text" class="gcconnex-endorsement-input-skill" onkeyup="checkForEnter(event)"/>' +
            '<span class="gcconnex-endorsement-add-skill">+ add new skill</span>' +
            '</div>');
            // hide the text box which is only to be shown when toggled by the link
            $('.gcconnex-endorsement-input-skill').hide();

            // the profile owner would like to type in a new skill
            $('.gcconnex-endorsement-add-skill').click(function () {
                $('.gcconnex-endorsement-input-skill').fadeIn('slowly').focus() ;
                $('.gcconnex-endorsement-add-skill').hide();
            });

            $('.gcconnex-endorsement-add').hide();
            $('.gcconnex-endorsement-retract').hide();
            $('.delete-skill').show();

            break;
        default:

    }
}

/*
 * Purpose: Save any changes made to the profile
 */
function saveProfile(event) {

    var $section = event.data.section;

    // toggle the edit, save, cancel buttons
    $('.edit-' + $section).show();
    $('.save-' + $section).hide();
    $('.cancel-' + $section).hide();

    switch ($section) {
        case "aboutme":
            var $about_me = $('.gcconnex-description').val();

            elgg.action('edit_extended_profile', {

                    guid: elgg.get_logged_in_user_guid(),
                    section: 'aboutme',
                    description: $about_me
                },
                function() {
                    // do something on success
                });
            break;
        case "education":
            var $school = $('.gcconnex-education-school').val();
            var $startdate = $('.gcconnex-education-startdate').val();
            var $enddate = $('.gcconnex-education-enddate').val();
            var $program = $('.gcconnex-education-program').val();
            var $field = $('.gcconnex-education-field').val();

            elgg.action('edit_extended_profile', {
                    guid: elgg.get_logged_in_user_guid(),
                    school: $school,
                    startdate: $startdate,
                    enddate: $enddate,
                    program: $program,
                    field: $field
                });
            /*
            elgg.action('edit_extended_profile', {
                data: {
                    guid: elgg.get_logged_in_user_guid(),
                    school: 'Highland High',
                    startdate: 'funday',
                    enddate: 'endday',
                    program: 'program',
                    field: 'field'
                },
                success: function() {
                    // do something on success
                }
            });*/
            break;
        case "experience":
            break;
        case "endorsements":

            $('.gcconnex-endorsement-input-wrapper').remove();
            $('.delete-skill').hide();

            var skillsToAdd = [];

            $(".temporarily-added .gcconnex-endorsement-skill").each(function () {
                skillsToAdd.push($(this).text())
            });

            if (confirm("Are you sure you would like to save changes? Any endorsements for skills that you have removed will be permanently deleted.")) {
                // this is where skills are deleted (if they have been marked for deletion by the user)
                $('.gcconnex-endorsement-skill-wrapper').removeClass('temporarily-added');
                $('.endorsement-markedForDelete').remove();
            }
            else {
                // show() the skills that have been hidden() (marked for deletion)
                $('.gcconnex-enxorsement-skill-wrapper').show();
            }

            $.get(elgg.normalize_url('ajax/view/b_extended_profile/save_endorsements'),
                {
                    param: elgg.get_logged_in_user_guid()
                },
                function(data) {
                    // Output in a DIV with id=somewhere
                    $('.gcconnex-endorsements').append('<div class="gcconnex-endorsements-edit-wrapper">' + data + '</div>');
                });
            $('.gcconnex-profile-endorsements-display').hide();

            // prep the skills array
            /*
            var pathname = '../mod/b_extended_profile/saveEndorsements.php';
            var user = elgg.get_page_owner_guid();
            // save functions
            $('.endorsements-message')
                .html('loading, please standby')
                .load(pathname, 'user=' + user + 'skills=' + skillsToAdd);
                */
            // @todo: show add or retract links based on status of endorsement
            break;
        default:
            break;
    }
}

/*
 * Purpose: Handle click event on the cancel button for all profile changes
 */
function cancelChanges(event) {

    var $section = event.data.section;

    $('.edit-' + $section).show();
    $('.save-' + $section).hide();
    $('.cancel-' + $section).hide();

    switch ($section) {
        case "aboutme":

            // show the about me
            $('.gcconnex-profile-aboutme-display').show();
            $('.gcconnex-aboutme-edit-wrapper').remove();

            break;
        case "education":
            $('.gcconnex-profile-education-display').show();
            $('.gcconnex-education-edit-wrapper').remove();
            break;
        case "experience":
            $('.gcconnex-profile-experience-display').show();
            $('.gcconnex-experience-edit-wrapper').remove();
            break;
        case "endorsements":
            $('.gcconnex-endorsement-input-wrapper').remove();



            $('.delete-skill').hide();
            $('.gcconnex-endorsement-skill-wrapper').removeClass('endorsement-markedForDelete');

            $('.gcconnex-endorsement-skill-wrapper').show();
            $('.temporarily-added').remove();
            break;
        default:
            break;
    }
}

/*
 * Purpose: Listen for the enter key in the "add new skill" text box
 */
function checkForEnter(event) {
    if (event.keyCode == 13) { // 13 = 'Enter' key

        // The new skill being added, as entered by user
        var newSkill = $('.gcconnex-endorsement-input-skill').val().trim();
        // @todo: do data validation to ensure css class-friendly naming (ie: no symbols)
        // @todo: add a max length to newSkill
        addNewSkill(newSkill);
    }
}

/*
 * Purpose: append a new skill to the bottom of the list
 */
function addNewSkill(newSkill) {

    var newSkillDashed = newSkill.replace(/\s+/g, '-'); // replace spaces with '-' for css classes

    // @todo: cap the list of skills at ~8-10 in order not to have "too many" on each profile
    // inject HTML for newly added skill
    $('.gcconnex-endorsement-skills-list-wrapper').append('<div class="gcconnex-endorsement-skill-wrapper temporarily-added">' +
    '<span title="Number of endorsements" class="gcconnex-endorsement-count endorsement-count-' +
    newSkillDashed +
    '">0</span>' +
    '<span title="Test" class="gcconnex-endorsement-skill">' +
    newSkill +
    '</span>' +
    '<span title="Endorse this skill" class="gcconnex-endorsement-add add-endorsement-' +
    newSkillDashed +
    '">+</span>' +
    '<span title="Remove your endorsement for this skill" class="gcconnex-endorsement-retract retract-endorsement-' +
    newSkillDashed +
    '">-</span><span class="delete-skill delete-' +
    newSkillDashed +
    '">Delete this skill</span></div>');

    $('.gcconnex-endorsement-input-skill').val('');                                 // clear the text box
    $('.gcconnex-endorsement-input-skill').hide();                                  // hide the text box
    $('.add-endorsement-' + newSkillDashed).hide();                                 // hide the '+' button
    $('.retract-endorsement-' + newSkillDashed).hide();                             // hide the '-' button
    $('.gcconnex-endorsement-add-skill').show();                                    // show the 'add a new skill' link
    $('.add-endorsement-' + newSkillDashed).on('click', addEndorsement);            // bind the addEndoresement function to the '+'
    $('.retract-endorsement-' + newSkillDashed).on('click', retractEndorsement);    // bind the retractEndorsement function to the '-'
    $('.delete-' + newSkillDashed).on('click', deleteSkill);                        // bind the deleteSkill function to the 'Delete this skill' link
}

/*
 * Purpose: Increase the endorsement count by one, for a specific skill for a specific user
 */
function addEndorsement() {
    // A user is endorsing a skill! Do stuff about it..
    var targetSkill = $(this).siblings('.gcconnex-endorsement-skill').text(); //.text();
    var targetSkillDashed = targetSkill.replace(/\s+/g, '-'); // replace spaces with '-' for css classes

    $('.add-endorsement-' + targetSkillDashed).hide();
    $('.retract-endorsement-' + targetSkillDashed).show();

    var endorse_count = $('.endorsement-count-' + targetSkillDashed).val();
    endorse_count++;
    $('.endorsement-count-' + targetSkillDashed).val(endorse_count);

    // @todo: add the endorsing user's profile image to the list of endorsers for this skill
}

/*
 * Purpose: Retract a previous endorsement for a specific skill for a specific user
 */
function retractEndorsement() {
    // A user is retracting their endorsement for a skill! Do stuff about it..
    var targetSkill = $(this).siblings('.gcconnex-endorsement-skill').text(); //.text();
    var targetSkillDashed = targetSkill.replace(/\s+/g, '-'); // replace spaces with '-' for css classes

    $('.add-endorsement-' + targetSkillDashed).show();
    $('.retract-endorsement-' + targetSkillDashed).hide();

    var endorse_count = $('.endorsement-count-' + targetSkillDashed).val();
    endorse_count--;
    $('.endorsement-count-' + targetSkillDashed).val(endorse_count);
}

/*
 * Purpose: Delete a skill from the list of endorsements
 */
function deleteSkill() {
    // We don't _actually_ delete anything yet, since the user still has the ability to click 'Cancel'
    // instead, we just hide the skill until the user clicks on 'Save'. See the 'saveChanges' function for
    // the actual code where skills are permanently deleted.
    $(this).parent('.gcconnex-endorsement-skill-wrapper').addClass('endorsement-markedForDelete').hide();
}

