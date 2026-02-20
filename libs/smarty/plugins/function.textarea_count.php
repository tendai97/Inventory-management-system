<?php
/* ******************************
	name		name (and id) of the textarea
	class		class to apply to the textarea
	limit		characters countlimit
	message		alert to be displayed
	value		value of the textarea
****************************** */
function smarty_function_textarea_count($params, &$smarty)
{
    if (empty($params['name'])) {
        $smarty->trigger_error("formtool_count_chars: missing 'name' parameter");
        return;
    }
    if (empty($params['limit'])) {
        $smarty->trigger_error("formtool_count_chars: missing 'limit' parameter");
        return;
    }

    $_name = $params['name'];
    $_limit = $params['limit'];
    $_class = ($params["class"]?" class=\"".$params["class"]."\"":"");
    $_alert = $params['message'];
    $_value = $params['value'];

    return "<textarea name=\"$_name\" id=\"$_name\"$_class onkeyup=\"javascript:count_chars(this, $_limit, '".str_replace("'", "\\'", $_alert)."')\">$_value</textarea>";
}
?>