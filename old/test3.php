<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
<table border="1" cellspacing="0" cellpadding="15" align="center">
<?php

	function arrCol($arr){
		$arrColunm = array();
		for ($i=0; $i < count($arr); $i++) { 
			for ($k=0; $k < count($arr[$i]); $k++) { 
				$arrColunm[$k][] = $arr[$i][$k];
			}
		}
		return $arrColunm;
	}
	function minCol($arr, $col){
		$result = $arr[0][$col];

		for ($i=0; $i < count($arr) - 1; $i++) { 
			# code...
			$result = (@min($result, $arr[$i][$col]));
		}
		return $result;
	}
	function removeMinRow($arr) {
		for ($i=0; $i < count($arr); $i++) { 
			$minRow = @min($arr[$i]);
			for ($j=0; $j < count($arr[$i]); $j++) { 
				$arr[$i][$j] = ($arr[$i][$j] - $minRow);
			}	
		}
		return $arr;
	}
	function removeMinCol($arr){
		$arr = removeMinRow($arr);
		$min = array();
		for ($i=0; $i < count($arr[0]); $i++) { 
			array_push($min, minCol($arr, $i));
		}
		for ($i=0; $i < count($arr); $i++) { 
			for ($j=0; $j < count($arr[$i]); $j++) { 
				$arr[$i][$j] = ($arr[$i][$j] - $min[$j]);
			}
		}
		return $arr;
	}

$row=$_POST["number1"];
$col=$_POST["number2"];
$data = $_POST["txt_a"];
$newData = $data;
$noarr = 0;
$minColArr = array();
$minRowArr = array();

//echo "<pre>";
//print_r($_POST['txt_a']);


	for ($i=0; $i < $row + 1; $i++) { 
		echo "<tr>";
		if (!($i == $row)) {

			for ($j=0; $j < $col + 1; $j++) { 
				if(!($j == $col)) {
					$data = removeMinCol($newData);
					echo '<td>'.$data[$i][$j].'</td>';
				} else {
					// end row
					$countZero = array_count_values($data[$i])[0];
					echo '<td><font color="red">'.$countZero.'</font></td>';
				}
			}	
		} else {
			$arrColunm = arrCol($data);
			// end col
			for ($j=0; $j < $col + 1 ; $j++) {
				
				echo '<td>';
				if (!($j == $col)) {
					$countZero = array_count_values($arrColunm[$j])[0];
					echo '<font color="red">'.$countZero.'</font>';
				}
				echo '</td>';
			}
			
		}
		echo "</tr>";
	}
?>
</table>

</body>
</html>