<?php
 
$wgExtensionCredits['parserhook'][] = array(
'name'         => 'NumberFormat',
'version'      => '0.4.1', // 2011-05-11
'description'  => 'Format numbers: insert thousands separators, round to a given number of decimals',
'author'       => 'Patrick Nagel',
'url'          => 'http://www.mediawiki.org/wiki/Extension:NumberFormat',
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
 
        if ($paramcount >= 1) {
                if ($params[0] == '') return '';
                if (!is_numeric($params[0])) return '<span class="error">First argument to number_format must be a number</span>';
        }
 
        switch ($paramcount) {
                case 4:
                        // Since 'space' cannot be passed through parser functions, users are advised to use
                        // the underscore instead. Converting back to space here.
                        if ($params[2] == '_') $params[2] = ' ';
                        if ($params[3] == '_') $params[3] = ' ';
                        return number_format($params[0], $params[1], $params[2], $params[3]);
                        break;
                case 3:
                        return '<span class="error">number_format needs one, two or four parameters - not three.</span>';
                        break;
                case 2:
                        return number_format($params[0], $params[1]);
                        break;
                case 1:
                        return number_format($params[0]);
                        break;
                case 0:
                        return "";
                        break;
                default:
                        return '<span class="error">wrong number of arguments to number_format.</span>';
        }
} 
