<?php
include("bd.php");
$arrayMoney = array();
$q = $_GET['q'];

	$res = $mysqli->query("SELECT * FROM `lesson_groups` 
LEFT JOIN lesson ON lesson.ID_Lesson=lesson_groups.FID_Lesson2 
LEFT JOIN `groups` AS a ON a.ID_Groups=lesson_groups.FID_Groups
LEFT JOIN lesson_teacher ON lesson_teacher.FID_Lesson1=lesson.ID_Lesson
LEFT JOIN teacher ON teacher.ID_Teacher=lesson_teacher.FID_Teacher WHERE auditorium='".$q."'");
	$res->data_seek(0);
	$allCost=0;
	while ($myrow = $res->fetch_assoc())
	{
		array_push($arrayMoney, $myrow['week_day']);
		array_push($arrayMoney, $myrow['lesson_number']);
		array_push($arrayMoney, $myrow['auditorium']);
		array_push($arrayMoney, $myrow['disciple']);
		array_push($arrayMoney, $myrow['name']);
		array_push($arrayMoney, $myrow['type']);
	}

		echo json_encode($arrayMoney);
//echo 1;
?>
