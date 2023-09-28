<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>107期末測驗實作題</title>
</head>
<body>
    <form action="2.php" id="form1" name="form1">
        <input type="submit" name="submit" id="submit" value="送出">
    </form>
</body>
</html>

<?php
	session_start();
	date_default_timezone_set('Asia/taipei');
	//隨機產生3數
	$conn = mysqli_connect('localhost', 'root','','php');

	echo "<div>";
	if(isset($_POST["submit"])){
			$arr = array();

			while(count($arr) < 3){
				$ran = rand(0,9);
				if(!in_array($ran,$arr)){
					$arr[] = $ran;
				}
			}
			
			$_SESSION['arr'] = $arr;
			
			if(!isset($_SESSION['detail'])){
				$_SESSION['detail'] = "";
				$_SESSION['detail'] .= implode("",$arr).",";
			}
			else{
				$_SESSION['detail'] .= implode("",$arr).",";
			}

			if(!isset($_SESSION['count'])){
				$_SESSION['count'] = 1;
			}
			else{
				$_SESSION['count'] += 1;
			} //計算次數

			if(!isset($_SESSION['ans'])){
				$_SESSION['ans'] = "";
			}

			if(!isset($_SESSION['check'])){
				$_SESSION['check'] = 0; //按第一次
			}
			else{
				$_SESSION['check'] = 1; 
			}
			
			$result = abs($_SESSION['arr'][1] - $_SESSION['arr'][0]) ==  abs($_SESSION['arr'][2] - $_SESSION['arr'][1]); 

			$_SESSION['ans'] .= $_SESSION['count']." = ";
			for($i=0;$i<count($_SESSION['arr']);$i++){
				$_SESSION['ans'] .= $_SESSION['arr'][$i].",";
			}
			$_SESSION['ans'] .= "</br>";
			
			if($_SESSION['count'] <= 9){
				if($result){
					$_SESSION['ans'] .= "總共試了".$_SESSION['count']."次或成功";
					$today = date("YmdHis");
					$sql = "INSERT INTO `mymaster`(`id`, `freq`) VALUES ('$today','".$_SESSION['count']."')";
					mysqli_query($conn,$sql);
					
					$detail = explode(",",$_SESSION['detail']);
					for($i=0;$i<count($detail)-1;$i++){
						$sql = "INSERT INTO `mydetail`(`id`, `turn`, `rec`) VALUES ('$today','".($i+1)."','".$detail[$i]."')";
						mysqli_query($conn,$sql);
					}
					session_destroy();
				}
			}
			else{
				$_SESSION['ans'] .= "總共試了".$_SESSION['count']."次或成功";

				$today = date("YmdHis");
				$sql = "INSERT INTO `mymaster`(`id`, `freq`) VALUES ('$today','".$_SESSION['count']."')";
				mysqli_query($conn,$sql);
				
				$detail = explode(",",$_SESSION['detail']);
				for($i=0;$i<count($detail)-1;$i++){
					$sql = "INSERT INTO `mydetail`(`id`, `turn`, `rec`) VALUES ('$today','".($i+1)."','".$detail[$i]."')";
					mysqli_query($conn,$sql);
				}
				echo $_SESSION['detail'];
				echo "</br>";
				print_r( $detail);
				echo "</br>";
				mysqli_close($conn);
				session_destroy();
			}			
	}
	
	if(isset($_SESSION['check'])){
		if($_SESSION['check'] == 1){
			print_r($_SESSION['ans']);
		}
		else{
			print_r($_SESSION['arr']);
			echo "</br>";
		}
	}
	echo "</div>";
	//session_destroy();

?>