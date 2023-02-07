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
 * Korean language pack
 *
 * @package   plagiarism_copybridge
 * @copyright 2023 copymonitor.jp
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
$string['pluginname']='CopyMonitor Bridge 플러그인';
$string['copybridge']='CopyMonitor Bridge';
$string['setting_basic']='CopyMonitor Bridge 기본설정';
$string['setting_basic_desc']='CopyMonitor Bridge 플러그인 활성화시의 기본값입니다.';
$string['usecopybridge']='유사도 검사 활성화';
$string['copybridge_select_yes']='예';
$string['copybridge_select_no']='아니오';
// setup_form.php
$string['setting_admin']='CopyMonitor Bridge 관리설정';
$string['copybridge_id']='Client ID';
$string['copybridge_url']='서비스 URL';
$string['copybridge_key']='라이선스 키';
$string['copybridge_host']='모듈 설치 서버 IP';
$string['copybridge_port']='모듈 설치 서버 Port';
$string['copybridge_open']='제출자에게 유사도 공개';
$string['copybridge_id_desc']='CopyMonitor Bridge에서 발급받은 사이트 ID를 입력해주세요. (대문자)';
$string['copybridge_url_desc']='CopyBridge 서버 URL을 입력하세요.';
$string['copybridge_key_desc']='CopyMonitor Bridge에서 발급받은 라이선스 키를 입력하세요.';
$string['copybridge_host_desc']='기본 아이피는 127.0.0.1 입니다.';
$string['copybridge_port_desc']='기본 포트는 3011 입니다.';
$string['usecopybridge_desc']='활성화되면 신규 추가된 과제에 대해 \'유사도 검사\'가 기본적으로 활성화됩니다.';
$string['copybridge_open_desc']='활성화되면 신규 추가된 과제에 대해 \'제출자에게 유사도 공개\'가 기본적으로 활성화됩니다.';

$string['savedconfigsuccess']='설정이 저장되었습니다.';

// lib.php : get_form_elements_module()
$string['assignsetting_title']='유사도 설정';
$string['assignsetting_button']='검사 설정';
$string['assignsetting_used']='유사도 검사 활성화';
$string['assignsetting_open']='제출자에게 유사도 공개';

// lib.php : print_disclosure()
$string['studentdisclosuredefault']='업로드된 모든 파일은 유사도 검사 서비스에 제출됩니다.';

// module.js
$string['url_script_empty']='Script 주소가 설정되지 않았습니다. 관리자에게 문의하여주시기 바랍니다.';
$string['url_bridge_empty']='CopyMonitor Bridge 주소가 설정되지 않았습니다. 관리자에게 문의하여주시기 바랍니다.';