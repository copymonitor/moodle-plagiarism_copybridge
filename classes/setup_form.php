<?php
// This copybridge is part of Moodle - http://moodle.org/
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
 * Admin plagiarism check setting input form
 *
 * @package   plagiarism_copybridge
 * @copyright 2023 copymonitor.jp
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/** @var TYPE_NAME $CFG */
require_once ($CFG->dirroot . '/lib/formslib.php');

class copybridge_setup_form extends moodleform
{
	// Define the form
	function definition() {
		global $CFG;

		$mform = &$this->_form;

        $mform->addElement('html', '<div style="font-weight: bold;font-size: 25px;color: #0f6fc5;margin: 5px;">'.get_string('setting_basic', 'plagiarism_copybridge').'</div>');
        $mform->addElement('html', '<div style="margin: 10px; color: gray;">'.get_string('setting_basic_desc', 'plagiarism_copybridge').'</div>');

        //$mform->addElement('checkbox', 'copybridge_use', get_string('usecopybridge', 'plagiarism_copybridge'));
        $choices = array(0 => get_string('copybridge_select_no', 'plagiarism_copybridge'), 1 => get_string('copybridge_select_yes', 'plagiarism_copybridge'));
        $mform->addElement('select', 'copybridge_use', get_string('usecopybridge', 'plagiarism_copybridge'), $choices);
        $mform->addElement('static', 'copybridge_use_desc', null, get_string('usecopybridge_desc', 'plagiarism_copybridge'));

        $mform->addElement('select', 'copybridge_open', get_string('copybridge_open', 'plagiarism_copybridge'), $choices);
        $mform->addElement('static', 'copybridge_open_desc', null, get_string('copybridge_open_desc', 'plagiarism_copybridge'));

        $mform->addElement('html', '<div style="font-weight: bold;font-size: 25px;color: #0f6fc5;margin: 5px;margin-bottom: 10px;">'.get_string('setting_admin', 'plagiarism_copybridge').'</div>');

		$mform->addElement('text', 'copybridge_id', get_string('copybridge_id', 'plagiarism_copybridge'));
		$mform->addElement('static', 'copybridge_id_desc', null, get_string('copybridge_id_desc', 'plagiarism_copybridge'));
		$mform->addRule('copybridge_id', null, 'required', null, 'client');
		$mform->setType('copybridge_id', PARAM_TEXT);

		//$mform->addElement('text', 'copybridge_url', get_string('copybridge_url', 'plagiarism_copybridge'));
		//$mform->addElement('static', 'copybridge_url_desc', null, get_string('copybridge_url_desc', 'plagiarism_copybridge'));
		//$mform->addRule('copybridge_url', null, 'required', null, 'client');
		//$mform->setType('copybridge_url', PARAM_TEXT);

		//$mform->addElement('text', 'copybridge_key', get_string('copybridge_key', 'plagiarism_copybridge'));
		//$mform->addElement('static', 'copybridge_key_desc', null, get_string('copybridge_key_desc', 'plagiarism_copybridge'));
		//$mform->addRule('copybridge_key', null, 'required', null, 'client');
		//$mform->setType('copybridge_key', PARAM_TEXT);

		$mform->addElement('text', 'copybridge_host', get_string('copybridge_host', 'plagiarism_copybridge'));
		$mform->addElement('static', 'copybridge_host_desc', null, get_string('copybridge_host_desc', 'plagiarism_copybridge'));
		$mform->setDefault('copybridge_host', '127.0.0.1');
		$mform->addRule('copybridge_host', null, 'required', null, 'client');
		$mform->setType('copybridge_host', PARAM_TEXT);

		$mform->addElement('text', 'copybridge_port', get_string('copybridge_port', 'plagiarism_copybridge'));
		$mform->addElement('static', 'copybridge_port_desc', null, get_string('copybridge_port_desc', 'plagiarism_copybridge'));
		$mform->setDefault('copybridge_port', '3011');
		$mform->addRule('copybridge_port', null, 'required', null, 'client');
		$mform->setType('copybridge_port', PARAM_TEXT);

		$this->add_action_buttons(true);
	}
}

