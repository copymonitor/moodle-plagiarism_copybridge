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
 * Bridge Server API communication class
 *
 * @package   plagiarism_copybridge
 * @copyright 2023 copymonitor.jp
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

class CopyBridgeHttpRequest
{
	var $m_host;
	var $m_uri;
	var $m_ssl;
	var $m_port;
	var $m_param;
	var $m_headers;
	var $m_post_vars = array();
	var $m_file_list = array();
	var $m_filepath_list = array();
	var $m_timeout = 30;
	var $m_retry_count = 1;
	var $boundary;

	public function __construct($host, $port = 443) {
		$this->m_host = trim($host);
		$this->m_uri = "/";

		if (strpos($this->m_host, 'https') === 0) {
			$this->m_ssl = true;
		} else {
			$this->m_ssl = false;
			if ($port == 443) $port = 80;
		}

		$this->m_port = $port;
		$this->boundary = sha1(1);
	}

	public function CopyBridgeHttpRequest($host, $port = 443) {
		self::__construct($host, $port);
	}

	function setUri($uri) {
		$this->m_uri = $uri;
	}
	function setTimeout($timeout) {
		$this->m_timeout = $timeout;
	}
	function setRetryCount($retry_count) {
		$this->m_retry_count = $retry_count;
	}
	function setAct($act) {
		$this->setParam('act', $act);
	}
	function setKey($key) {
		$this->setParam('key', $key);
	}
	function setSkin($skin) {
		$this->setParam('skin', $skin);
	}
	function setResponseType($response_type) {
		$this->setParam('response_type', $response_type);
	}

	function setParam($name, $value) {
		if (!$name) return;
		if (!$value) return;

		if ($name == "file") {
			$this->m_file_list[] = $value;
		} else if ($name == "filepath") {
			$this->m_filepath_list[] = $value;
		} else if ($name == "file_path") {
			$this->m_filepath_list[] = $value;
		} else if ($name == "file_info") {
			$this->m_post_vars[$name] = json_encode($value);
		} else {
			$this->m_post_vars[$name] = $value;
		}
		error_log($name);
		error_log($value);
	}

	function _getParamContent() {
		$content = '';
		if (count($this->m_post_vars)) {
			foreach ($this->m_post_vars as $key => $value) {
				if ($content) $content .= '&';
				$content .= urlencode($key) . '=' . urlencode($value);
			}
		}

		if (count($this->m_filepath_list)) {
			foreach ($this->m_filepath_list as $key => $value) {
				if ($content) $content .= '&';
				$content .= urlencode("file_path") . '=' . urlencode($value);
			}
		}

		return $content;
	}

	function send() {
		return $this->sendWithSock();
	}

	function fsockopen($host, $port, &$errno, &$errstr, $timeout) {
		$count = 0;
		do {
			if ($count > 0) sleep(1);
			$sock = @fsockopen($host, $port, $errno, $errstr, $timeout);
		} while ((!$sock) && $count++ < $this->m_retry_count);

		return $sock;
	}

	function createMultiPartData() {
		$crlf = "\r\n";
		$body = '';

		foreach ($this->m_post_vars as $key => $value) {
			$body .= '--' . $this->boundary . $crlf
				. 'Content-Disposition: form-data; name="' . $key . '"' . $crlf
				. 'Content-Length: ' . strlen($value) . $crlf . $crlf
				. $value . $crlf;
		}

		if ($this->m_filepath_list) {
			foreach ($this->m_filepath_list as $key => $value) {
				$body .= '--' . $this->boundary . $crlf
					. 'Content-Disposition: form-data; name="filepath"' . $crlf
					. 'Content-Length: ' . strlen($value) . $crlf . $crlf
					. $value . $crlf;
			}
		}

		foreach ($this->m_file_list as $file) {
			$file_contents = @file_get_contents($file);
			$body .= '--' . $this->boundary . $crlf
				. 'Content-Disposition: form-data; name="file[]"; filename="' . basename($file) . '"' . $crlf
				. 'Content-Type: application/octet-stream' . $crlf
				. 'Content-Length: ' . strlen($file_contents) . $crlf . $crlf
				. $file_contents . $crlf;
		}

		$body .= '--' . $this->boundary . '--';

		return $body;
	}

	function getFileCount() {
		return count($this->m_file_list);
	}

	function sendWithSock() {
		static $crlf = "\r\n";

		if ($this->m_ssl) {
			$host = preg_replace('@^https@', 'ssl', $this->m_host);
			$host = preg_replace('@/$@', '', $host);
		} else {
			$host = str_replace("http://", "", $this->m_host);
		}
		error_log($host);
		$errno = 0;
		$errstr = null;
		$ret = new stdClass();

		$sock = $this->fsockopen($host, $this->m_port, $errno, $errstr, $this->m_timeout);
		if (!$sock) {
			$ret->code = $errno;
			$ret->body = str_replace("\n", "", $errstr);
			$ret->body = str_replace("\r", "", $ret->body);
			//$ret->body = iconv('euc-kr', 'utf-8', $ret->body);
		}
		else {
			$file_count = $this->getFileCount();
			if ($file_count) {
				$post_body = $this->createMultiPartData();
				$headers['Content-Type'] = "multipart/form-data; boundary=" . $this->boundary;
			} else {
				$post_body = $this->_getParamContent();
				$headers['Content-Type'] = "application/x-www-form-urlencoded";
			}

			$headers['Content-Length'] = strlen($post_body);

			$request = "POST " . $this->m_uri . " HTTP/1.0" . $crlf;

			$headers['Accept'] = '*/*';
			$headers['Host'] = preg_replace('@^ssl:\/\/@', '', $host);
			$headers['User-Agent'] = PHP_OS . " php " . PHP_VERSION;
			//$headers['Cookie'] = __FILE__." (function:".__FUNCTION__.")(line:".__LINE__.")";

			foreach ($headers as $equiv => $content) {
				$request .= $equiv . ": " . $content . $crlf;
			}
			$request .= $crlf . $post_body;
			fwrite($sock, $request);

			$arr = preg_split('/ +/', rtrim(fgets($sock)), 3);
			if (count($arr) != 3) list($httpver, $code) = $arr;
			else list($httpver, $code, $status) = $arr;

			// read response headers
			$is_chunked = false;
			while (strlen(trim($line = fgets($sock)))) {
				list ($equiv, $content) = preg_split('/ *: */', rtrim($line), 2);
				if (!strcasecmp($equiv, 'Transfer-Encoding') && $content == 'chunked') {
					$is_chunked = true;
				}
			}

			$body = '';
			while (!feof($sock)) {
				if ($is_chunked) {
					$chunk_size = hexdec(fgets($sock));
					if ($chunk_size) $body .= fread($sock, $chunk_size);
				} else {
					$body .= fgets($sock, 4096);
				}
			}
			fclose($sock);

			$ret->code = $code;
			$ret->body = $body;
		}
		return $ret;
	}
}

if (!function_exists("get_copybridge_response")) {
	function get_copybridge_response($message_type, $code, $message) {
		"{\"message_type\":\"" . $message_type . "\",\"error\":" . $code . ",\"message\":\"" . $message . "\"}";
	}
}
