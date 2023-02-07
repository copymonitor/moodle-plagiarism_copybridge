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
 * Authorization group management
 *
 * @package   plagiarism_copybridge
 * @copyright 2023 copymonitor.jp
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$capabilities = array(
	// capability to enable/disable copybridge inside an activity
	'plagiarism/copybridge:enable' => array(
		'captype' => 'write', 
		'contextlevel' => CONTEXT_COURSE, 
		'legacy' => array(
			'manager' => CAP_ALLOW, 
			'editingteacher' => CAP_ALLOW
		)
	),
	
	// capability to view full reports
	'plagiarism/copybridge:viewfullreport' => array(
		'captype' => 'write',
		'contextlevel' => CONTEXT_COURSE,
		'legacy' => array(
			'manager' => CAP_ALLOW,
			'editingteacher' => CAP_ALLOW,
			'coursecreator' => CAP_ALLOW,
			'teacher' => CAP_ALLOW
		)
	),
	
	// Ability to get all controller links to e.g. to submit/resubmit
	'plagiarism/copybridge:control' => array(
		'captype' => 'write', 
		'contextlevel' => CONTEXT_COURSE,
		'legacy' => array(
			'manager' => CAP_ALLOW, 
			'editingteacher' => CAP_ALLOW,
			'coursecreator' => CAP_ALLOW, 
			'teacher' => CAP_ALLOW
		)
	),
);
