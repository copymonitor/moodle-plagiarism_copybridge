// -------------------------------------------------------------------------------------------
//	/lib/javascript.php/.../plagiarism/copybridge/module.js
// -------------------------------------------------------------------------------------------

M.plagiarism_copybridge = { scripturl: '', bridgeurl: '' };

M.plagiarism_copybridge.init = function(Y, scripturl, bridgeurl) {
	M.plagiarism_copybridge.scripturl = scripturl;
	M.plagiarism_copybridge.bridgeurl = bridgeurl
}

M.plagiarism_copybridge.modform = function(Y, group_id, lang) {
	isScriptLoad = !0;
	lang = (lang) ? lang : 'en';

	if (M.plagiarism_copybridge.scripturl == '') { 
		alert(M.util.get_string('url_script_empty', 'plagiarism_copybridge')); 
		isScriptLoad = !1; 
	}
	if (M.plagiarism_copybridge.bridgeurl == '') { 
		alert(M.util.get_string('url_bridge_empty', 'plagiarism_copybridge')); 
		isScriptLoad = !1; 
	}
	if (isScriptLoad) {
		$.getScript(M.plagiarism_copybridge.scripturl, function() {
			CopymonitorBridge.setUrl(M.cfg.wwwroot + M.plagiarism_copybridge.bridgeurl);
			CopymonitorBridge.setLang(lang);

			CopymonitorBridge.initStatusCopymonitorGroup("input[name=copybridge_used]", group_id);
			CopymonitorBridge.initConfigCopymonitorGroup(".btn-copybridge-setting", group_id);
			$("input[name=copybridge_temp_configid]").val(CopymonitorBridge.temp_config_id)
		});
	}
};

