/*
 * Purpose: Provides 'LinkedIn-like endorsements' functionality for use on user profiles and handles ajax for profile edits
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

    //link the edit/save/cancel buttons with the appropriate functions on click..
    $('.edit-about-me').on("click", {section: "about-me"}, editProfile);
    $('.save-about-me').on("click", {section: "about-me"}, saveProfile);
    $('.cancel-about-me').on("click", {section: "about-me"}, cancelChanges);

    $('.edit-education').on("click", {section: "education"}, editProfile);
    $('.save-education').on("click", {section: "education"}, saveProfile);
    $('.cancel-education').on("click", {section: "education"}, cancelChanges);

    $('.edit-work-experience').on("click", {section: "work-experience"}, editProfile);
    $('.save-work-experience').on("click", {section: "work-experience"}, saveProfile);
    $('.cancel-work-experience').on("click", {section: "work-experience"}, cancelChanges);

    $('.edit-endorsements').on("click", {section: "endorsements"}, editProfile);
    $('.save-endorsements').on("click", {section: "endorsements"}, saveProfile);
    $('.cancel-endorsements').on("click", {section: "endorsements"}, cancelChanges);

    $('.gcconnex-education-add-another').on("click", {section: "education"}, addMore);


    // when a user clicks outside of the input text box (the one for entering new skills in the endorsements area), make it disappear elegantly
    $(document).click(function(event) {
        if(!$(event.target).closest('.gcconnex-endorsements-input-wrapper').length) {
            if($('.gcconnex-endorsements-input-skill').is(":visible")) {
                $('.gcconnex-endorsements-input-skill').hide();
                $('.gcconnex-endorsements-add-skill').fadeIn('slowly');
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
        case 'about-me':
            // Edit the About Me blurb
            $.get(elgg.normalize_url('ajax/view/b_extended_profile/edit_about-me'),
                {
                    guid: elgg.get_logged_in_user_guid()
                },
                function(data) {
                    $('.gcconnex-about-me').append('<div class="gcconnex-about-me-edit-wrapper">' + data + '</div>');
                });
            $('.gcconnex-profile-about-me-display').hide();
            break;
        case 'education':
            // Edit the edumacation
            $.get(elgg.normalize_url('ajax/view/b_extended_profile/edit_education'),
                {
                    guid: elgg.get_logged_in_user_guid()
                },
                function(data) {
                    // Output in a DIV with id=somewhere
                    $('.gcconnex-education').append('<div class="gcconnex-education-edit-wrapper">' + data + '</div>');
                });
            $('.gcconnex-profile-education-display').remove();
            break;
        case 'work-experience':
            // Edit the experience for this user
            $.get(elgg.normalize_url('ajax/view/b_extended_profile/edit_work-experience'),
                {
                    guid: elgg.get_logged_in_user_guid()
                },
                function(data) {
                    // Output in a DIV with id=somewhere
                    $('.gcconnex-work-experience').append('<div class="gcconnex-work-experience-edit-wrapper">' + data + '</div>');
                });
            $('.gcconnex-profile-work-experience-display').hide();
            break;
        case 'endorsements':
            // inject the html to add ability to add skills
            $('.gcconnex-endorsements').append('<div class="gcconnex-endorsements-input-wrapper">' +
            '<input type="text" class="gcconnex-endorsements-input-skill" onkeyup="checkForEnter(event)"/>' +
            '<span class="gcconnex-endorsements-add-skill">+ add new skill</span>' +
            '</div>');

            // hide the skill entry text box which is only to be shown when toggled by the link
            $('.gcconnex-endorsements-input-skill').hide();

            // the profile owner would like to type in a new skill
            $('.gcconnex-endorsements-add-skill').click(function () {
                $('.gcconnex-endorsements-input-skill').fadeIn('slowly').focus() ;
                $('.gcconnex-endorsements-add-skill').hide();
            });

            // create a "delete this skill" link for each skill
            $('.gcconnex-endorsements-skill').each(function(){
                $(this).after('<img class="delete-skill-img" src="' + elgg.get_site_url() + 'mod/b_extended_profile/img/delete.png"><span class="delete-skill" onclick="deleteEntry(this)" data-type="skill">Delete this skill</span>'); //goes in here i think..
            });

            //$('.delete-skill').show();

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
        case "about-me":
            var $about_me = tinyMCE.activeEditor.getContent();
            // save the information the user just edited
            elgg.action('b_extended_profile/edit_profile', {
                    guid: elgg.get_logged_in_user_guid(),
                    section: 'about-me',
                    description: $about_me
                });
            $('.gcconnex-about-me-edit-wrapper').remove();

            // fetch and display the information we just saved
            $.get(elgg.normalize_url('ajax/view/b_extended_profile/about-me'),
                {
                    guid: elgg.get_logged_in_user_guid()
                },
                function(data) {
                    $('.gcconnex-about-me').append(data);
                });
            break;
        case "education":

            //var $school = $('.gcconnex-education-school').val();
            var $education_guid = [];
            var $delete_guid = [];

            $('.gcconnex-education-entry').each(function() {
                if ( $(this).is(":hidden") ) {
                    $delete_guid.push($(this).data('guid'));
                }
                else {
                    $education_guid.push($(this).data('guid'));
                }
            });

            var $school = [];
            $('.gcconnex-education-school').not(":hidden").each(function() {
                $school.push($(this).val());
            });

            var $startdate = [];
            $('.gcconnex-education-startdate').not(":hidden").each(function() {
                $startdate.push($(this).val());
            });

            var $enddate = [];
            $('.gcconnex-education-enddate').not(":hidden").each(function() {
                $enddate.push($(this).val());
            });
            var $program = [];
            $('.gcconnex-education-program').not(":hidden").each(function() {
                $program.push($(this).val());
            });
            var $field = [];
            $('.gcconnex-education-field').not(":hidden").each(function() {
                $field.push($(this).val());
            });

            // save the information the user just edited
            elgg.action('b_extended_profile/edit_profile', {
                    guid: elgg.get_logged_in_user_guid(),
                    delete: $delete_guid,
                    eguid: $education_guid,
                    section: 'education',
                    school: $school,
                    startdate: $startdate,
                    enddate: $enddate,
                    program: $program,
                    field: $field
                });
            $('.gcconnex-education-edit-wrapper').remove();

            // fetch and display the information we just saved
            $.get(elgg.normalize_url('ajax/view/b_extended_profile/education'),
                {
                    guid: elgg.get_logged_in_user_guid()
                },
                function(data) {
                    // Output in a DIV with id=somewhere
                    $('.gcconnex-education').append(data);
                });
            break;
        case "work-experience":

            var $work_experience_guid = [];
            var $delete_guid = [];

            $('.gcconnex-work-experience-entry').each(function() {
                if ( $(this).is(":hidden") ) {
                    $delete_guid.push($(this).data('guid'));
                }
                else {
                    $work_experience_guid.push($(this).data('guid'));
                }
            });

            var $organization = [];
            $('.gcconnex-work-experience-organization').not(":hidden").each(function() {
                $organization.push($(this).val());
            });

            var $title = [];
            $('.gcconnex-work-experience-title').not(":hidden").each(function() {
                $title.push($(this).val());
            });

            var $startdate = [];
            $('.gcconnex-work-experience-startdate').not(":hidden").each(function() {
                $startdate.push($(this).val());
            });

            var $enddate = [];
            $('.gcconnex-work-experience-enddate').not(":hidden").each(function() {
                $enddate.push($(this).val());
            });

            var $responsibilities = [];
            $('.gcconnex-work-experience-responsibilities').not(":hidden").each(function() {
                $responsibilities.push($(this).val());
            });

            // save the information the user just edited
            elgg.action('b_extended_profile/edit_profile', {
                guid: elgg.get_logged_in_user_guid(),
                delete: $delete_guid,
                eguid: $work_experience_guid,
                section: 'work-experience',
                organization: $organization,
                title: $title,
                startdate: $startdate,
                enddate: $enddate,
                responsibilities: $responsibilities
            });
            $('.gcconnex-work-experience-edit-wrapper').remove();

            // fetch and display the information we just saved
            $.get(elgg.normalize_url('ajax/view/b_extended_profile/work-experience'),
                {
                    guid: elgg.get_logged_in_user_guid()
                },
                function(data) {
                    // Output in a DIV with id=somewhere
                    $('.gcconnex-work-experience').append(data);
                });
            break;

        case "endorsements":

            //$('.delete-skill').hide();

            var $skills_added = [];
            var $delete_guid = [];

            $('.gcconnex-skill-entry').each(function() {
                if ( $(this).is(":hidden") ) {
                    $delete_guid.push($(this).data('guid'));
                }
                if ( $(this).hasClass("temporarily-added") ) {
                    $skills_added.push($(this).data('skill'));
                }
            });

            if (confirm("Are you sure you would like to save changes? Any endorsements for skills that you have removed will be permanently deleted.")) {
                // save the information the user just edited

                elgg.action('b_extended_profile/edit_profile', {
                    guid: elgg.get_logged_in_user_guid(),
                    section: 'skill',
                    skillsadded: $skills_added,
                    skillsremoved: $delete_guid
                });

                $('.gcconnex-endorsement-input-wrapper').remove();

                $.get(elgg.normalize_url('ajax/view/b_extended_profile/endorsements'),
                    {
                        guid: elgg.get_logged_in_user_guid()
                    },
                    function(data) {
                        // Output in a DIV with id=somewhere
                        $('.gcconnex-endorsements').append(data);
                    });

            }
            else {
                // show() the skills that have been hidden() (marked for deletion)
                $('.gcconnex-enxorsement-skill-wrapper').show();
            }

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
        case "about-me":
            // show the about me
            $('.gcconnex-about-me-edit-wrapper').remove();
            $.get(elgg.normalize_url('ajax/view/b_extended_profile/about-me'),
                {
                    guid: elgg.get_logged_in_user_guid()
                },
                function(data) {
                    // Output in a DIV with id=somewhere
                    $('.gcconnex-about-me').append(data);
                });
            break;
        case "education":
            //$('.gcconnex-profile-education-display').show();
            $('.gcconnex-education-edit-wrapper').remove();
            $.get(elgg.normalize_url('ajax/view/b_extended_profile/education'),
                {
                    guid: elgg.get_logged_in_user_guid()
                },
                function(data) {
                    // Output in a DIV with id=somewhere
                    $('.gcconnex-education').append(data);
                });
            break;
        case "work-experience":
            $('.gcconnex-work-experience-edit-wrapper').remove();
            $.get(elgg.normalize_url('ajax/view/b_extended_profile/work-experience'),
                {
                    guid: elgg.get_logged_in_user_guid()
                },
                function(data) {
                    // Output in a DIV with id=somewhere
                    $('.gcconnex-work-experience').append(data);
                });
            break;
        case "endorsements":
            $('.gcconnex-endorsements-input-wrapper').remove();

            $('.delete-skill').remove();
            $('.delete-skill-img').remove();
            $('.gcconnex-endorsements-skill-wrapper').removeClass('endorsements-markedForDelete');

            $('.gcconnex-endorsements-skill-wrapper').show();
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
        var newSkill = $('.gcconnex-endorsements-input-skill').val().trim();
        // @todo: do data validation to ensure css class-friendly naming (ie: no symbols)
        // @todo: add a max length to newSkill
        addNewSkill(newSkill);
    }
}

/*
 * Purpose: append a new skill to the bottom of the list
 */
function addNewSkill(newSkill) {

    var newSkillDashed = newSkill.replace(/\s+/g, '-').toLowerCase(); // replace spaces with '-' for css classes

    // @todo: cap the list of skills at ~8-10 in order not to have "too many" on each profile
    // inject HTML for newly added skill
    $('.gcconnex-endorsements-skills-list-wrapper').append('<div class="gcconnex-skill-entry temporarily-added" data-skill="' + newSkill + '">' +
    '<span title="Number of endorsements" class="gcconnex-endorsements-count endorsement-count-' +
    newSkillDashed +
    '">0</span>' +
    '<span data-type="' + newSkillDashed + '" class="gcconnex-endorsements-skill">' +
    newSkill +
    '</span>' +
    '<span title="Endorse this skill" class="gcconnex-endorsements-add add-endorsement-' +
    newSkillDashed +
    '">+</span>' +
    '<span title="Remove your endorsement for this skill" class="gcconnex-endorsements-retract retract-endorsement-' +
    newSkillDashed +
    '">-</span><span class="delete-skill delete-' +
    newSkillDashed +
    '">Delete this skill</span></div>');

    $('.gcconnex-endorsements-input-skill').val('');                                 // clear the text box
    $('.gcconnex-endorsements-input-skill').hide();                                  // hide the text box
    $('.add-endorsement-' + newSkillDashed).hide();                                 // hide the '+' button
    $('.retract-endorsements-' + newSkillDashed).hide();                             // hide the '-' button
    $('.gcconnex-endorsements-add-skill').show();                                    // show the 'add a new skill' link
    $('.add-endorsements-' + newSkillDashed).on('click', addEndorsement);            // bind the addEndoresement function to the '+'
    $('.retract-endorsements-' + newSkillDashed).on('click', retractEndorsement);    // bind the retractEndorsement function to the '-'
    $('.delete-' + newSkillDashed).on('click', deleteSkill);                        // bind the deleteSkill function to the 'Delete this skill' link
}

/*
 * Purpose: Increase the endorsement count by one, for a specific skill for a specific user
 */
function addEndorsement() {
    // A user is endorsing a skill! Do stuff about it..
    var targetSkill = $(this).siblings('.gcconnex-endorsements-skill').text(); //.text();
    var targetSkillDashed = targetSkill.replace(/\s+/g, '-'); // replace spaces with '-' for css classes

    $('.add-endorsement-' + targetSkillDashed).hide();
    $('.retract-endorsement-' + targetSkillDashed).show();

    var endorse_count = $('.endorsements-count-' + targetSkillDashed).val();
    endorse_count++;
    $('.endorsements-count-' + targetSkillDashed).val(endorse_count);

    // @todo: add the endorsing user's profile image to the list of endorsers for this skill
}

/*
 * Purpose: Retract a previous endorsement for a specific skill for a specific user
 */
function retractEndorsement() {
    // A user is retracting their endorsement for a skill! Do stuff about it..
    var targetSkill = $(this).siblings('.gcconnex-endorsements-skill').text(); //.text();
    var targetSkillDashed = targetSkill.replace(/\s+/g, '-'); // replace spaces with '-' for css classes

    $('.add-endorsement-' + targetSkillDashed).show();
    $('.retract-endorsement-' + targetSkillDashed).hide();

    var endorse_count = $('.endorsements-count-' + targetSkillDashed).val();
    endorse_count--;
    $('.endorsements-count-' + targetSkillDashed).val(endorse_count);
}

/*
 * Purpose: Delete a skill from the list of endorsements
 */
function deleteSkill() {
    // We don't _actually_ delete anything yet, since the user still has the ability to click 'Cancel'
    // instead, we just hide the skill until the user clicks on 'Save'. See the 'saveChanges' function for
    // the actual code where skills are permanently deleted.
    $(this).parent('.gcconnex-endorsements-skill-wrapper').addClass('endorsements-markedForDelete').hide();
}

function addMore(identifier) {
    var another = $(identifier).data('type');
    $.get(elgg.normalize_url('ajax/view/input/' + another), '',
        function(data) {
            // Output in a DIV with id=somewhere
            $('.gcconnex-' + another + '-all').append(data);
        });
}

/*
 * Purpose: Delete an entry based on the value of the data-type attribute in the delete link
 */
function deleteEntry(identifier) {
    // get the entry-type name
    var entryType = $(identifier).data('type');

    // mark the entry for deletion and hide it from view
    $(identifier).closest('.gcconnex-' + entryType + '-entry').hide();
}