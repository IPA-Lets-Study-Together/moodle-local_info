<?php
require_once(dirname(__FILE__) . '/../../config.php');

require_login();

$context = context_system::instance();

require_capability('local/info:beinformed', $context);

$name = optional_param('name', '', PARAM_TEXT);

if(!$name) {
	$name = fullname($USER);
}

add_to_log(SITEID, 'local_info', 'beinformed', 'local/info/index.php?name=' . urlencode($name));

$PAGE->set_context($context);

$PAGE->set_url(new moodle_url('/local/info/index.php'), array('name' => $name));

$PAGE->set_title(get_string('welcome', 'local_info'));

echo $OUTPUT->header();

echo $OUTPUT->box(get_string('greet', 'local_info', format_string($name)));

global $DB;

try {
	$sql = 'SELECT id FROM mdl_book WHERE name = ?';
	$params = array('Povijesni razvoj računala');

	$result = $DB->get_record_sql($sql, $params);

	$sql = 'SELECT content FROM mdl_book_chapters WHERE bookid = ?';
	$params = array($result->id);

	$result02 = $DB->get_records_sql_menu($sql, $params);

	print_r($result02);

	$subject = serialize($result02); //array to string conversion??
	$pattern = '\bimg\b\i';
	if (preg_match($pattern, $subject)) {
		echo "img was found";
	} else {
		echo "no image in file";
	}

	$mate = serialize($result02); //array to string conversion??

	if (strpos($mate, "summary")) {
		echo "there is some summary here \r\n";
	}

} catch(Exception $e) {
	echo "fail";
}

echo $OUTPUT->footer();