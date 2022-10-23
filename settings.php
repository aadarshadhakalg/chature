<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * local_chature file description here.
 *
 * @package    local_chature
 * @copyright  2022 Aadarsha Dhakal <@link aadarshadhakal.com.np>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// Ensure the configurations for this site are set
if ( $hassiteconfig ){
    $settings = new admin_settingpage( 'local_chature', 'Chature AI' );


    $ADMIN->add( 'Chature AI', $settings );
    $settings->add( new admin_setting_configtext(

        'local_chature/apikey',
        get_string('setting_external_token_name','local_chature'),
        get_string('setting_external_token_des','local_chature'),
        'No Key Defined',
        PARAM_TEXT
    ) );

    $settings->add( new admin_setting_configtext(
        'local_chature/accesstoken',
        get_string('setting_access_token_name','local_chature'),
        get_string('setting_access_token_des','local_chature'),
        'No Key Defined',
        PARAM_TEXT

    ) );

}