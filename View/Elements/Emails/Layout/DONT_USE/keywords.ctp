<?php

if (!empty($keywords)) {
	$keywords = implode(',', $keywords);
	echo "<meta name=\"keywords\" content=\"$keywords\" />";
}

?>