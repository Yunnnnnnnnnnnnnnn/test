
<!DOCTYPE html>
	<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>考</title>
	</head>
	<body><form action="formTest.php" method="post" name="form1" id="form1">
<p>
  <input type="submit" name="submit" id="submit" value="送出">
  </br>
<?php
	
		session_start();
		
		if(!isset($_SESSION['submit']))
			$arr=array();

	
		while (count($arr)<3)
		{
			$ran = rand(0,9);

			if(!in_array($ran,$arr))
			{
				$arr[]=$ran;
			}
		}
		print_r($arr);
			echo "</br>";
			
		

?>
