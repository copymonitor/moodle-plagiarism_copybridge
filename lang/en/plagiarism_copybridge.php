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
 * Strings for component 'plagiarism_copybridge', language 'en'
 *
 * @package   plagiarism_copybridge
 * @copyright 2023 copymonitor.jp
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['pluginname']='CopyMonitor Bridge plugin';
$string['copybridge']='CopyMonitor Bridge';
$string['setting_basic']='CopyMonitor Bridge Default Settings';
$string['setting_basic_desc']='The following settings are the defaults set when enabling CopyMonitor Bridge plugin.';
$string['usecopybridge']='Enable Similarity Check';
$string['copybridge_select_yes']='Yes';
$string['copybridge_select_no']='No';
// setup_form.php
$string['setting_admin']='CopyMonitor Bridge Administration Settings';
$string['copybridge_id']='Client ID';
$string['copybridge_url']='Service URL';
$string['copybridge_key']='License Key';
$string['copybridge_host']='Module Installation Server IP';
$string['copybridge_port']='Module Installation Server Port';
$string['copybridge_open']='Display Similarity Rate to Submitter';
$string['copybridge_id_desc']='Please enter the site ID issued by CopyMonitor Bridge. (Capital letters)';
$string['copybridge_url_desc']='Please enter the CopyMonitor Bridge server URL.';
$string['copybridge_key_desc']='Please enter the license key issued by CopyMonitor Bridge.';
$string['copybridge_host_desc']='The default IP is 127.0.0.1.';
$string['copybridge_port_desc']='The default Port is 3011.';
$string['usecopybridge_desc']='If enabled, \'Similarity Check\' is enabled by default for newly added assignments.';
$string['copybridge_open_desc']='If enabled, \'Display Similarity Rate to Submitter\' is enabled by default for newly added assignments.';

$string['savedconfigsuccess']='The settings have been saved.';

// lib.php : get_form_elements_module()
$string['assignsetting_title']='';
$string['assignsetting_button']='Check Settings';
$string['assignsetting_used']='Enable Similarity Check';
$string['assignsetting_open']='Display Similarity Rate to Submitter';

// lib.php : print_disclosure()
$string['studentdisclosuredefault']='All uploaded files are submitted to the similarity check service.';

// module.js
$string['url_script_empty']='Script address is not set. Please contact the manager.';
$string['url_bridge_empty']='The CopyMonitor Bridge address is not set. Please contact the manager.';

