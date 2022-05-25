<?php
include("bd.php");
$q = $_GET['q'];

$res = $mysqli->query("SELECT * FROM `lesson_groups` 
LEFT JOIN lesson ON lesson.ID_Lesson=lesson_groups.FID_Lesson2 
LEFT JOIN `groups` AS a ON a.ID_Groups=lesson_groups.FID_Groups
LEFT JOIN lesson_teacher ON lesson_teacher.FID_Lesson1=lesson.ID_Lesson
LEFT JOIN teacher ON teacher.ID_Teacher=lesson_teacher.FID_Teacher WHERE ID_Teacher='".$q."'");
	$res->data_seek(0);
	$dom = new DomDocument('1.0', 'UTF-8'); 
	$cars = $dom->createElement('LESSONS');
	while ($myrow = $res->fetch_assoc())
	{
		$root = $dom->createElement('LESSON');
		$child_node_name = $dom->createElement('week_day', $myrow['week_day']);
		$root->appendChild($child_node_name);
		$child_node_text = $dom->createElement('lesson_number', $myrow['lesson_number']);
		$root->appendChild($child_node_text);
		$child_node_text = $dom->createElement('auditorium', $myrow['auditorium']);
		$root->appendChild($child_node_text);
		$child_node_text = $dom->createElement('disciple', $myrow['disciple']);
		$root->appendChild($child_node_text);
		$child_node_text = $dom->createElement('name', $myrow['name']);
		$root->appendChild($child_node_text);
		$child_node_text = $dom->createElement('type', $myrow['type']);
		$root->appendChild($child_node_text);
		$cars->appendChild($root);
	}

	$dom->appendChild($cars);
    $dom->formatOutput = true; // set the formatOutput attribute of domDocument to true

    // save XML as string or file 
    $test1 = $dom->saveXML(); // put string in test1
    $dom->save('data.xml'); // save as file
		echo "Ready";
?>