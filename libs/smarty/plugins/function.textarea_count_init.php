<?php
function smarty_function_textarea_count_init($params, &$smarty) {

return <<<END
<script language="javascript" type="text/javascript">
function count_chars(prmTextarea, prmLimit, prmMessage) {

	if (prmLimit) {
		if(prmTextarea != null && prmTextarea.value != null) {
			if (prmTextarea.value.length > prmLimit) {
				if(prmMessage)
					alert(prmMessage);
				prmTextarea.value = prmTextarea.value.substring(0, prmLimit);
			} else {
				if (document.getElementById(prmTextarea.name+"_LIMIT"))
					document.getElementById(prmTextarea.name+"_LIMIT").value = prmLimit - prmTextarea.value.length;
			}
		}
	} else
		if (document.getElementById(prmTextarea.name+"_LIMIT"))
			document.getElementById(prmTextarea.name+"_LIMIT").value = prmLimit - prmTextarea.value.length;
}
</script>

END;
}
?>