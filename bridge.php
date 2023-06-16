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
 * Plagiarism check linked API CopyBridge linked
 *
 * @package   plagiarism_copybridge
 * @copyright 2023 copymonitor.jp
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require(__DIR__ . '/../../config.php');

require_once($CFG->dirroot . '/plagiarism/copybridge/lib.php');
require_once($CFG->dirroot . '/plagiarism/copybridge/classes/CopyBridgeHttp.class.php');


$context = context_system::instance();

//$group_id = (isset($_REQUEST["group_id"])) ? $_REQUEST["group_id"] : null; //Issue #6
$group_id = optional_param('group_id', null, PARAM_TEXT);
$user_id = $USER->username;
//$auth = has_capability('plagiarism/copybridge:control', $context) ? 'manager' : 'user';
$auth = user_has_role_assignment($USER->id,5) ? 'user' : 'manager'; // cmbridge auth check
$remote_addr = $_SERVER["REMOTE_ADDR"];

//$act = (isset($_REQUEST["act"])) ? $_REQUEST["act"] : "";  //Issue #6
$act = optional_param('act', '', PARAM_TEXT);

// API request param
$temp_config_id = optional_param('temp_config_id', null, PARAM_TEXT);
$asis_config_id = optional_param('asis_config_id', null, PARAM_TEXT);
$uri = optional_param('uri', null, PARAM_TEXT);
$response_type = optional_param('response_type', null, PARAM_TEXT);
$lang = optional_param('lang', null, PARAM_TEXT);

$update_date = optional_param('update_date', null, PARAM_TEXT);
$writer_id = optional_param('writer_id', null, PARAM_TEXT);

$allowed_actions = array( // Allow only allowed requests to execute
    'get_copymonitor_info',
    'config_copymonitor_group',
    'status_copymonitor_group',
    'copymonitor_view');
if (!in_array($act, $allowed_actions)) return;

//debugging("[act : $act] [role : $auth] [group : $group_id] [user : $user_id]");


$bridgeip = get_config('plagiarism_copybridge', 'copybridge_host') ?? '127.0.0.1';
$bridgeport = get_config('plagiarism_copybridge', 'copybridge_port') ?? '3011';

// ----------------------------------------------------------------------------- REQUEST

$oCopyBridgeHttpRequest = new CopyBridgeHttpRequest('http://' . $bridgeip, $bridgeport);
$oCopyBridgeHttpRequest->setUri("/" . $act);

/*	foreach ($_REQUEST as $key => $val) {
		if ($key == "user_id") continue;
		if ($key == "auth") continue;
		if ($key == "id") continue;
		$oCopyBridgeHttpRequest->setParam($key, $val);
	}*/

$oCopyBridgeHttpRequest->setParam("act", $act);
$oCopyBridgeHttpRequest->setParam("temp_config_id", $temp_config_id);
$oCopyBridgeHttpRequest->setParam("asis_config_id", $asis_config_id);
$oCopyBridgeHttpRequest->setParam("group_id", $group_id);
$oCopyBridgeHttpRequest->setParam("uri", $uri);
$oCopyBridgeHttpRequest->setParam("response_type", $response_type);
$oCopyBridgeHttpRequest->setParam("lang", $lang);

$oCopyBridgeHttpRequest->setParam("update_date", $update_date);
$oCopyBridgeHttpRequest->setParam("writer_id", $writer_id);

$oCopyBridgeHttpRequest->setParam("auth", $auth);
$oCopyBridgeHttpRequest->setParam("user_id", $user_id);
$oCopyBridgeHttpRequest->setParam("remote_addr", $remote_addr);

$output = $oCopyBridgeHttpRequest->send();

// ----------------------------------------------------------------------------- RESPONSE

// header("Content-Type: text/html; charset=UTF-8");
//echo $oCopyBridgeHttpRequest->_getParamContent();

if ($output->code != 200) {
    $code = $output->code;
    if ($code == 0) $code = -1;
    echo get_copybridge_response("LMS", $output->code, $output->body);
} else { // success http request
    echo $output->body;
}
