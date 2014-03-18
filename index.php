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

try {

	//connecting to database
	global $DB;
	$sql = 'SELECT id FROM mdl_book WHERE name = ?';
	$params = array('Povijesni razvoj računala');

	$result = $DB->get_record_sql($sql, $params);

	$sql = 'SELECT content FROM mdl_book_chapters WHERE bookid = ?';
	$params = array($result->id);

	$result02 = $DB->get_records_sql_menu($sql, $params); //getting book chapter

	print_r($result02);

	$book_chaper = serialize($result02); //converting book chapter array to string

	$pattern_image = '/<img(.*)\/>/'; //regular expression for image tag search
	$pattern_table = '/<table(.*)\>/'; //regular expression for table tag search

	preg_match_all($pattern_image, $book_chaper, $preg_image); //getting preg_match_all for image
	preg_match_all($pattern_table, $book_chaper, $preg_table);

	print_r($preg_image);
	print_r($preg_table);

	if (!empty($preg_image)) {

		$preg_image_indices = count($preg_image); //counting image indices
		
		$alt_search = array_search('alt="', $preg_image); //searching for image alt tag

		$cnt_alt = count($alt_search);

		if ($cnt_alt < $preg_image_indices) {
			echo "Slike nisu validirane";

			$record = new stdClass();
			
		}
	}

	if (!empty($preg_table)) {

		$preg_table_indices = count($preg_table); //counting table indices
		$summary_search = array_search('summary="', $preg_table); //searching for table summary tag
	}
	

	
	

	

	/*echo $cnt;*/

} catch(Exception $e) {
	echo "fail";
}

echo $OUTPUT->footer();