<?php
include("bd.php");
$groupToShow=$_POST['groupToShow'];
$teacherToShow=$_POST['teacherToShow'];
$auditoriumToShow=$_POST['auditoriumToShow'];

$res = $mysqli->query("SELECT * FROM `groups`");
$res->data_seek(0);
while ($myrow = $res->fetch_assoc())
{
	$group=$group."<option value='".$myrow['ID_Groups']."'>".$myrow['title']."</option>";
	
}
		
$res = $mysqli->query("SELECT * FROM `teacher`");
$res->data_seek(0);
while ($myrow = $res->fetch_assoc())
{
	$teacher=$teacher."<option value='".$myrow['ID_Teacher']."'>".$myrow['name']."</option>";
}

$res = $mysqli->query("SELECT DISTINCT auditorium FROM `lesson`");
$res->data_seek(0);
while ($myrow = $res->fetch_assoc())
{
	$auditorium=$auditorium."<option>".$myrow['auditorium']."</option>";
}


?>
<!DOCTYPE HTML>
<html>
 <head>
  <script>
  function showUser1(str) {
	//document.write(str+"q");
    if (str == "") {
        document.getElementById("txtHint").innerHTML = "";
        return;
    } else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
		
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
				var table="<tr><th>Week day</th><th>Lesson number</th><th>Auditorium</th><th>Disciple</th><th>Name</th><th>Type</th></tr>";
				let newLine=0;
				//window.alert(this.responseText);
				var i=0;
				JSON.parse(this.responseText, function(k,v) {
					if (v.toString().indexOf(',')==-1){
					if (i==0){
						table += "<tr><td>" +v+"</td>";
					}else
					if (i==5){
						table += "<td>" +v+"</td></tr>";
						i=-1;
					}else{
						table += "<td>" +v+"</td>";
					}
					i++;
					}

				}); 
				console.log(table);
                document.getElementById("myTable").innerHTML = table;
            }
        };
        xmlhttp.open("GET","bdJson.php?q="+str,true);
        xmlhttp.send();
    }
}
function showUser(str) {
	//document.write(str+"q");
    if (str == "") {
        document.getElementById("txtHint").innerHTML = "";
        return;
    } else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("txtHint").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","bdAjax.php?q="+str,true);
        xmlhttp.send();
    }
}
function loadDoc(str) {
	if (str == "") {
        document.getElementById("txtHint").innerHTML = "";
        return;
    } else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onload  = function() {
			//window.alert(xmlhttp.responseText);
            if (this.readyState == 4 && this.status == 200) {
                var xhttp = new XMLHttpRequest();
				xhttp.onload = function() {
					//window.alert(xhttp.responseText);
					if (this.readyState == 4 && this.status == 200) {
						myFunction(this);
					}
				};
				xhttp.open("GET", "http://lst-corp.ru/it_gadem/lb3/data.xml", true);
				xhttp.send();
            }
        };
        xmlhttp.open("GET","bdXML.php?q="+str,true);
        xmlhttp.send();
    }

}
function myFunction(xml) {
  var i;
  var xmlDoc = xml.responseXML;
  //window.alert(xml.responseXML.toXMLString());
  var table="<tr><th>Week day</th><th>Lesson number</th><th>Auditorium</th><th>Disciple</th><th>Name</th><th>Type</th></tr>";
  var x = xmlDoc.getElementsByTagName("LESSON");
  for (i = 0; i <x.length; i++) { 
  //window.alert(x[i].getElementsByTagName("week_day")[0].childNodes[0].nodeValue);
    table += "<tr><td>" +x[i].getElementsByTagName("week_day")[0].childNodes[0].nodeValue +"</td>";
    table += "<td>" +x[i].getElementsByTagName("lesson_number")[0].childNodes[0].nodeValue +"</td>";
    table += "<td>" +x[i].getElementsByTagName("auditorium")[0].childNodes[0].nodeValue +"</td>";
    table += "<td>" +x[i].getElementsByTagName("disciple")[0].childNodes[0].nodeValue +"</td>";
    table += "<td>" +x[i].getElementsByTagName("name")[0].childNodes[0].nodeValue +"</td>";
    table += "<td>" +x[i].getElementsByTagName("type")[0].childNodes[0].nodeValue +"</td></tr>";
  }
  document.getElementById("myTable").innerHTML = table; 
  //window.alert(table);
}
</script>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>ЛБ 3</title>
  <link href="external.css" rel="stylesheet">
 </head>
 <body>

<div class="navigation">
<form action="index.php" method="post">
<a style="margin-left: 60px;">Выберите группу:</a><br>
<span style="margin-left: 130px;" class="custom-dropdown big">
    <select name="groupToShow" onchange="showUser(this.value)">    
        <option selected="selected"  disabled>Group</option>
		<?php echo $group; ?>
    </select>
</span>
</form>

<form action="index.php" method="post">
<a style="margin-left: 60px;">Выберите teacher:</a><br>
<span  style="margin-left: 100px;" class="custom-dropdown big">
    <select name="teacherToShow" onchange="loadDoc(this.value)">    
        <option selected="selected"  disabled>Teacher</option>
		<?php echo $teacher; ?>
    </select>
</span>
</form>

<form action="index.php" method="post">
<a style="margin-left: 50px;">Выберите auditorium:</a><br>
<span style="margin-left: 120px;" class="custom-dropdown big">
    <select  name="auditoriumToShow" onchange="showUser1(this.value)">    
        <option selected="selected"  disabled>Auditorium</option>
		<?php echo $auditorium; ?>
    </select>
</span>
</form>



<div id="txtHint"><b></b></div>
<table id="myTable" class="table_dark">
</table><br>
</div>

 </body>
</html>
