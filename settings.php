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
 pl * settings.php - allows the admin to configure plagiarism stuff
 *
 * @package   plagiarism_copybridge
 * @author    Dan Marsden <dan@danmarsden.com>
 * @copyright 2023 copymonitor.jp
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
require_once(__DIR__.'/../../config.php');
require_once($CFG->libdir . '/adminlib.php');
require_once($CFG->libdir . '/plagiarismlib.php');
require_once($CFG->dirroot . '/plagiarism/copybridge/lib.php');
require_once($CFG->dirroot . '/plagiarism/copybridge/classes/setup_form.php');

require_login();
admin_externalpage_setup('plagiarismcopybridge');

$context = context_system::instance();
require_capability('moodle/site:config', $context, $USER->id, true, "nopermissions");

$mform = new copybridge_setup_form();
$plagiarismplugin = new plagiarism_plugin_copybridge();

if ($mform->is_cancelled()) {
	$url = new moodle_url('/plagiarism/copybridge/settings.php');
	redirect($url);
}

$plagiarismsettings = (array) get_config('plagiarism_copybridge');
//echo '<pre>'.var_dump($plagiarismsettings).'</pre>';

echo $OUTPUT->header();

if (($data = $mform->get_data()) && confirm_sesskey()) {
	// Setting whether to use plugins
	if (!isset($data->copybridge_use)) $data->copybridge_use = 0;
	set_config('enabled', $data->copybridge_use, 'plagiarism_copybridge');

	// Setting all plugin configuration information (config_plugins)
	foreach ($data as $field => $value) {
		if (strpos($field, 'copybridge') === 0) {
			if ($field == 'copybridge_id') $value = strtoupper($value);

			$conf_info = $DB->get_record('config_plugins', array('name'=>$field, 'plugin'=>'plagiarism_copybridge'));
			if ($conf_info) {
				$conf_info->value = $value;
				if (!$DB->update_record('config_plugins', $conf_info)) {
					error("errorupdating");
				}
			} else {
				$conf_info = new stdClass();
				$conf_info->value = $value;
				$conf_info->plugin = 'plagiarism_copybridge';
				$conf_info->name = $field;
				if (!$DB->insert_record('config_plugins', $conf_info)) {
					error("errorinserting");
				}
			}
		}
	}
	echo $OUTPUT->notification(get_string('savedconfigsuccess', 'plagiarism_copybridge'), 'notifysuccess');
}

$mform->set_data($plagiarismsettings);

echo $OUTPUT->box_start('generalbox boxaligncenter', 'intro');
$mform->display();
echo $OUTPUT->box_end();
echo $OUTPUT->footer();

