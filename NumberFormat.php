<?php
 
$wgExtensionCredits['parserhook'][] = array(
'name'         => 'NumberFormat',
'version'      => '0.5', // 2012-06-22
'description'  => 'Format numbers: insert thousands separators, round to a given number of decimals',
'author'       => array(
		'[[mw:User:Patrick Nagel|Patrick Nagel]]',
		'[[mw:User:Pastakhov|Pavel Astakhov]]'
		),
'url'          => 'https://www.mediawiki.org/wiki/Extension:NumberFormat',
);
 
$wgExtensionFunctions[] = 'number_format_Setup';
$wgHooks['LanguageGetMagic'][] = 'number_format_Magic';
 
function number_format_Setup() {
        global $wgParser;
        $wgParser->setFunctionHook('number_format', 'number_format_Render');
}
 
function number_format_Magic(&$magicWords, $langCode) {
        $magicWords['number_format'] = array(0, 'number_format');
        return true;
}
 
function number_format_Render(&$parser) {
        // {{#number_format:number|decimals|dec_point|thousands_sep}}
 
        // Get the parameters that were passed to this function
        $params = func_get_args();
        array_shift($params);
        $paramcount = count($params);
 
	if (isset($params[0]) && $params[0] == '') return '';

	switch ($paramcount) {
		case 5:
			// Since 'space' cannot be passed through parser functions, users are advised to use
			// the underscore instead. Converting back to space here.    
			if ($params[4] == '_') $params[4] = ' ';
			$params[0]=str_replace($params[4],'.',$params[0]);
		case 4:                    
			if ($params[3] == '_') $params[3] = ' '; //Converting back to space
		case 3:
			if ($params[2] == '_') $params[2] = ' '; //Converting back to space
		case 2:
			if ($params[1] == '_') $params[1] = strrpos($params[0], '.') ? strlen($params[0])-strrpos($params[0], '.')-1 : 0; //Number of decimal points same as input
		case 1:
			break;
		case 0:
			return ""; //Empty output for empty input
			break;
		default:
			return '<span class="error">Wrong number of arguments to number_format.</span>';
	}

	$params[0] = preg_replace("/[^\.0-9e]*/","",$params[0]); //Set to plain number
	if (!is_numeric($params[0])) return '<span class="error">First argument to number_format must be a number</span>';
	$output = number_format($params[0], isset($params[1]) ? $params[1] : null, isset($params[2]) ? $params[2] : null, isset($params[3]) ? $params[3] : null);

	switch ($params[3]) {
		case 't':
			$output = str_replace ( 't', '&thinsp;', $output );
			break;
		case 'n':
			$output = str_replace ( 'n', '&nbsp;', $output );
			break;
	}
	return $output;
}