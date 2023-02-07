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
 * Japanese language pack
 *
 * @package   plagiarism_copybridge
 * @copyright 2023 copymonitor.jp
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
$string['pluginname']='CopyMonitor Bridgeプラグイン';
$string['copybridge']='CopyMonitor Bridge';
$string['setting_basic']='CopyMonitor Bridgeデフォルト設定';
$string['setting_basic_desc']='CopyMonitor Bridgeプラグインを有効にする際の既定値です。';
$string['usecopybridge']='類似度チェックを有効にする';
$string['copybridge_select_yes']='Yes';
$string['copybridge_select_no']='No';
// setup_form.php
$string['setting_admin']='CopyMonitor Bridge管理設定';
$string['copybridge_id']='Client ID';
$string['copybridge_url']='サービスURL';
$string['copybridge_key']='ライセンスキー';
$string['copybridge_host']='モジュールインストールサーバIP';
$string['copybridge_port']='モジュールインストールサーバPort';
$string['copybridge_open']='提出者に類似度を表示する';
$string['copybridge_id_desc']='CopyMonitor Bridgeから発行されたサイトIDを入力してください。（アルファベットの大文字）';
$string['copybridge_url_desc']='CopyMonitor BridgeサーバURLを入力してください。';
$string['copybridge_key_desc']='CopyMonitor Bridgeから発行されたライセンスキーを入力してください。';
$string['copybridge_host_desc']='基本IPは127.0.0.1です。';
$string['copybridge_port_desc']='基本Portは3011です。';
$string['usecopybridge_desc']='この設定を有効にした場合、新規で追加された課題に対して「類似度チェックを有効にする」の設定がデフォルトで有効になります。';
$string['copybridge_open_desc']='この設定を有効にした場合、新規で追加された課題に対して「提出者に類似度を表示する」の設定がデフォルトで有効になります。';

$string['savedconfigsuccess']='設定が保存されました。';

// lib.php : get_form_elements_module()
$string['assignsetting_title']='';
$string['assignsetting_button']='チェック設定';
$string['assignsetting_used']='類似度チェックを有効にする';
$string['assignsetting_open']='提出者に類似度を表示する';

// lib.php : print_disclosure()
$string['studentdisclosuredefault']='アップロードされたすべてのファイルは、類似度チェックサービスに提出されます。';

// module.js
$string['url_script_empty']='Scriptアドレスが設定されていません。管理者にお問い合わせください。';
$string['url_bridge_empty']='CopyMonitor Bridgeアドレスが設定されていません。 管理者にお問い合わせください。';
