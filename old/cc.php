<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<center>
<body>
<form name="form1" method="POST" action="test3.php">
	<table border="1" cellspacing="0" cellpadding="15" align="center">
<?php
	

	$n = $_POST["number1"];
	$m = $_POST["number2"];
	echo "<td></td>";

for ($j=1; $j <= $m ; $j++) {

	echo "<th>"."D".$j."</th>";
			}
	for ($i=0; $i < $n ; $i++)  { 
		echo "<tr>";
		echo "<th>"."S".$i."</th>";
		for ($j=0; $j< $m ; $j++) {
			echo "<td> <input type='text' name='txt_a[".$i."][]'/ ><br/></td>";
		}

		echo "</tr>";
	}
		
?>
	</table>
	<td><input type="submit" name="submit" value="ตกลง" align="center" ></td>
	<input name="number1" type="hidden" value="<?=$_POST["number1"];?>">
	<input name="number2" type="hidden" value="<?=$_POST["number2"];?>">
	</form>
</center>	
</body>
</html>