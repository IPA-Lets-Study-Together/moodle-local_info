<?php
$capabilities = array('local/info:beinformed' => array(
	'captype' => 'read',
	'contextlevel' => CONTEXT_SYSTEM,
	'archetypes' => array('teacher' => CAP_ALLOW, 'editingteacher' => CAP_ALLOW, 'manager' => CAP_ALLOW)
));