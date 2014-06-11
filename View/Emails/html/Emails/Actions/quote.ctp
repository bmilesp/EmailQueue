<?php 
	echo $this->element("Quotes.quote", array("price"=>$custom_vars['Price'], "front_end"=>$custom_vars, "replyToEmail"=>$custom_vars['replyToEmail'])); 
?>