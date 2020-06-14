<?php

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$unlink = $_POST['unlink'];
		$tmpUnlink = $_POST['tmpUnlink'];
		unlink('uploads/'.$unlink);
		unlink($tmpUnlink);
	}
