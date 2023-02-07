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
 * lib.php - Contains Plagiarism plugin specific functions called by Modules.
 *
 * @since 2.0
 * @package    plagiarism_copybridge
 * @subpackage plagiarism
 * @copyright  2023 copymonitor.jp
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
if (!defined('MOODLE_INTERNAL')) {
	die('Direct access to this script is forbidden.'); ///  It must be included from a Moodle page
}

//get global class
global $CFG;
require_once ($CFG->dirroot . '/plagiarism/lib.php');

///// CopyBridge Class ////////////////////////////////////////////////////
class plagiarism_plugin_copybridge extends plagiarism_plugin
{

	// ------------------------------------------------------------------
	// 설정정보 로딩
	public static function get_settings() {
		static $plagiarismsettings;
		if (!empty($plagiarismsettings) || $plagiarismsettings === false) {
			return $plagiarismsettings;
		}

		$plagiarismsettings = (array) get_config('plagiarism_copybridge');
		if (isset($plagiarismsettings['enabled']) && $plagiarismsettings['enabled']) {
			if (empty($plagiarismsettings['copybridge_id'])) return false;
			//if (empty($plagiarismsettings['copybridge_key'])) return false;
			//if (empty($plagiarismsettings['copybridge_host'])) return false;
			//if (empty($plagiarismsettings['copybridge_port'])) return false;

			return $plagiarismsettings;
		}
		return false;
	}

	// ------------------------------------------------------------------
	public function get_links($linkarray) {
		return '';
	}

	// ------------------------------------------------------------------
	// professor : Homework room inspection setting input form
	function plagiarism_copybridge_coursemodule_standard_elements($formwrapper, $mform) {
		$plugin = new plagiarism_plugin_copybridge();
		$context = context_course::instance($formwrapper->get_course()->id);
		$plugin->get_form_elements_module($mform, $context,
			isset($formwrapper->get_current()->modulename) ? 'mod_'.$formwrapper->get_current()->modulename : '');
	}


	public function get_form_elements_module($mform, $context, $modulename = "") {
		global $DB, $USER, $COURSE, $PAGE, $CFG;

		$plugin = new plagiarism_plugin_copybridge();
		$plagiarismsettings = $plugin->get_settings();
		if (!$plagiarismsettings) return;

		if ($modulename != 'assign' && $modulename != 'mod_assign') return '';

		$cmid = optional_param('update', 0, PARAM_INT);		// 코스ID
		$cm = get_coursemodule_from_id('assign', $cmid);
        $cmcourse =  '';
        !empty($cm->course) ? $cmcourse = $cm->course : $cmcourse = $cm["course"];

        $cminstance =  '';
        !empty($cm->instance) ? $cminstance = $cm->instance : $cminstance = $cm["instance"];

		// Inspection setting information DB query
		$config = $DB->get_record('plagiarism_copybridge', array('cm' => $cmid));
		if (!$config) {
			$config = new \stdClass();
			$config->cm = $cmid;
			//$config->courseid = $cm->course;
			//$config->assignid = $cm->instance;
            $config->courseid = $cmcourse;
            $config->assignid = $cminstance;
			$config->isused = 1;
			$config->isopen = $plagiarismsettings["copybridge_open"];
			$config->temp_configid = '';
		}
		//debugging('<PRE>'.var_export($config, true).'</PRE>');

		$lang = $plugin->plagiarism_configval('lang');
		$scripturl = $plugin->plagiarism_configval('scripturl');
		$bridgeurl = $plugin->plagiarism_configval('bridgeurl');
		//$group_id = $plugin->plagiarism_configval('prefixid') . '_' . $cm->course . '_' . $cmid;
        $group_id = $plugin->plagiarism_configval('prefixid') . '_' . $cmcourse . '_' . $cmid;

		// -------------------------------------------------------------------------------- 입력폼 생성

		$PAGE->requires->jquery();

		$mform->addElement('header', 'copybridgedesc', get_string('copybridge', 'plagiarism_copybridge'));

		// HIDDEN INFO
		$mform->addElement('hidden', 'copybridge_temp_configid', '');
		//$mform->setDefault('copybridge_temp_configid', $config->temp_configid);
        $mform->setType('copybridge_temp_configid', PARAM_TEXT);

		$mform->addElement('hidden', 'group_id', '');
		$mform->setDefault('group_id', $group_id);
        $mform->setType('group_id', PARAM_TEXT);

		// Whether to enable plagiarism check
		$used_group = array();
		$used_group[] = $mform->createElement('checkbox', 'copybridge_used', '', get_string('assignsetting_used', 'plagiarism_copybridge'));
		//$used_group[] = $mform->createElement('button', 'copybridge_setting', get_string('assignsetting_button', 'plagiarism_copybridge'),
		//	array('class' => 'btn btn-sm btn-info btn-copybridge-setting'));
		$used_group[] = $mform->createElement('static', 'copybridge_setting', '',
			html_writer::tag('input', '', array(
				'id' => 'id_copybridge_setting',
				'name' => 'copybridge_setting',
				'type' => 'button',
				'class' => 'btn btn-sm btn-info btn-copybridge-setting',
				'value' => get_string('assignsetting_button', 'plagiarism_copybridge')
			))
		);
		$mform->addGroup($used_group, 'usedgroup', '', '&nbsp; &nbsp;', false);
		$mform->setDefault('copybridge_used', $config->isused);

		// Whether plagiarism rates are disclosed to students
		$mform->addElement('checkbox', 'copybridge_open', get_string('assignsetting_open', 'plagiarism_copybridge'));
		$mform->setDefault('copybridge_open', $config->isopen);

		// -------------------------------------------------------------------------------- JS 생성

		//$PAGE->requires->js('/plagiarism/copybridge/module.js', true);
		$jsmodule = array('name' => 'plagiarism_copybridge'
			, 'fullpath' => '/plagiarism/copybridge/module.js','requires' => array());

		$PAGE->requires->js_init_call('M.plagiarism_copybridge.init'
			, array($scripturl, $bridgeurl), false, $jsmodule);
		$PAGE->requires->strings_for_js(['url_bridge_empty', 'url_script_empty'], 'plagiarism_copybridge');

		$PAGE->requires->js_init_call('M.plagiarism_copybridge.modform'
			, array($group_id, $lang), false, $jsmodule);

		$mform->disabledif('copybridge_open', 'copybridge_used', 'notchecked');

		$mform->setExpanded('copybridgedesc', true);
	}


	// ------------------------------------------------------------------
	// professor : Save homework test settings
	function plagiarism_copybridge_coursemodule_edit_post_actions($data, $course) {
		$plugin = new plagiarism_plugin_copybridge();
		$plugin->save_form_elements($data);
		return $data;
	}

	public function save_form_elements($data) {
		global $DB;

		$plugin = new plagiarism_plugin_copybridge();
		// validation check
		if (!$plugin->get_settings()) return $data; // Check if CopyBridge module is used
		if ($data->modulename != "assign") return $data; // Check whether assignment module is used

		$cmid = $data->coursemodule;
		$cm = get_coursemodule_from_id('assign', $cmid);

		$config = new \stdClass();
		$config->cm = $cmid;
		$config->courseid = $cm->course;
		$config->assignid = $cm->instance;
		$config->isused = (isset($data->copybridge_used)) ? $data->copybridge_used : 0; // checkbox
		$config->isopen = (isset($data->copybridge_open)) ? $data->copybridge_open : 0; // checkbox
		$config->temp_configid = $data->copybridge_temp_configid;

		$current = $DB->get_record('plagiarism_copybridge', array('cm' => $cmid));
		if ($current) {
			$config->id = $current->id;
			$DB->update_record('plagiarism_copybridge', $config);
		} else {
			$config->cm = $cmid;
			$DB->insert_record('plagiarism_copybridge', $config);
		}

		//debugging(var_export($config, true));

		return $data;
	}



	/**
	 * hook to allow a disclosure to be printed notifying users what will happen with their submission
	 * @param int $cmid - course module id
	 * @return string
	 */
	public function print_disclosure($cmid) {
		global $OUTPUT;

		//$plagiarismsettings = $this->get_settings();

		echo $OUTPUT->box_start('generalbox boxaligncenter', 'intro');

		$formatoptions = new stdClass();
		$formatoptions->noclean = true;
		echo format_text(get_string('studentdisclosuredefault', 'plagiarism_copybridge'), FORMAT_MOODLE, $formatoptions);

		echo $OUTPUT->box_end();
	}

	/**
	 * hook to allow status of submitted files to be updated - called on grading/report pages.
	 *
	 * @param object $course - full Course object
	 * @param object $cm - full cm object
	 */
	public function update_status($course, $cm) {
		//called at top of submissions/grading pages - allows printing of admin style links or updating status
	}

	/**
	 * called by admin/cron.php
	 *
	 */
	public function cron() {
		//do any scheduled task stuff
	}

	// ===================================================================================

	public function plagiarism_configval($confname, $nullval = null) {
		global $COURSE;
		$result = $nullval;

		$plugin = new plagiarism_plugin_copybridge();
		$plagiarismsettings = $plugin->get_settings();
		if (!$plagiarismsettings) return $result;

		//$lang = current_language();
		//$lang = ($lang == 'ja') ? "jp" : $lang;
        $lang = "jp" ; // CM Bridge - Fixed language setting

		switch (trim($confname)) {
			case  'scripturl' :
                $result = 'https://www.cmbridge.jp/cm/common/js/copymonitor.bridge.js';
				break;
			case 'bridgeurl' :
				$result = '/plagiarism/copybridge/bridge.php'; break;
			case 'courseid' :
				$result = $COURSE->id; break;
			case 'lang' :
				$result = $lang; break;
			case 'prefixid' :
				$result = strtoupper($plagiarismsettings['copybridge_id'] ?? 'CBGRP');
				break;
			default :
				if ($plagiarismsettings[trim($confname)]) {
					$result = $plagiarismsettings[trim($confname)];
				}
				break;
		}

		return $result;
	}
}
