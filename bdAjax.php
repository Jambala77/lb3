<!DOCTYPE html>
<html>
<head>
<link href="external.css" rel="stylesheet">
</head>
<body>

<?php
include("bd.php");
$q = $_GET['q'];
	$res = $mysqli->query("SELECT * FROM `lesson_groups` 
LEFT JOIN lesson ON lesson.ID_Lesson=lesson_groups.FID_Lesson2 
LEFT JOIN `groups` AS a ON a.ID_Groups=lesson_groups.FID_Groups
LEFT JOIN lesson_teacher ON lesson_teacher.FID_Lesson1=lesson.ID_Lesson
LEFT JOIN teacher ON teacher.ID_Teacher=lesson_teacher.FID_Teacher WHERE ID_Groups='".$q."'");
	$res->data_seek(0);
	$allCost=0;
	while ($myrow = $res->fetch_assoc())
	{
		$table=$table."<tr><td>".$myrow['week_day']."</td><td>".$myrow['lesson_number']."</td><td>".$myrow['auditorium']."</td><td>".$myrow['disciple']."</td><td>".$myrow['name']."</td><td>".$myrow['type']."</td></tr>";
	}



echo "<table id='myTable' class='table_dark'>
	<tr>
		<th>Week day</th>
		<th>Lesson number</th>
		<th>Auditorium</th>
		<th>Disciple</th>
		<th>Name</th>
		<th>Type</th>
	</tr>";
echo $table;
echo "</table>";
?>
</body>
</html>