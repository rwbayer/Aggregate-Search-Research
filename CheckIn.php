<?php
	include "config.php";
	include 'localise.php';
	session_start();
	$message ='';

	if (isset($_REQUEST["submitted"])) {
		//$username = $_SESSION['username']; // Change this to have an actual random numerical ID
		//use $userId and $_SESSION['userId'] to make userId consistent across the flow
		$userId = $_SESSION['userId'];

		$language1 = $_REQUEST["language1"];
		$language2 = $_REQUEST["language2"];
		$language3 = $_REQUEST["language3"];
		$language4 = $_REQUEST["language4"];
		// echo $language1 . " " . $language2 ." ";

		$language1readingproficiency = $_REQUEST["language1readingproficiency"];
		$language2readingproficiency = $_REQUEST["language2readingproficiency"];
		$language3readingproficiency = $_REQUEST["language3readingproficiency"];
		$language4readingproficiency = $_REQUEST["language4readingproficiency"];

		$language1writingproficiency = $_REQUEST["language1writingproficiency"];
		$language2writingproficiency = $_REQUEST["language2writingproficiency"];
		$language3writingproficiency = $_REQUEST["language3writingproficiency"];
		$language4writingproficiency = $_REQUEST["language4writingproficiency"];

		$language1listeningproficiency = $_REQUEST["language1listeningproficiency"];
		$language2listeningproficiency = $_REQUEST["language2listeningproficiency"];
		$language3listeningproficiency = $_REQUEST["language3listeningproficiency"];
		$language4listeningproficiency = $_REQUEST["language4listeningproficiency"];

		// echo 	$userId . ", " . $language1 . ", "  . $language2;

		if($language1!="" && $language2!="" &&
		   $language1readingproficiency!=0 && $language2readingproficiency!=0) {
			$con = mysql_connect($_DATABASEHOST, $_DATABASEUSER, $_DATABASEPASSWORD);
			if (!$con) {
			    die('Could not connect: ' . mysql_error());
			}
			mysql_select_db($_DATABASE);
			$query = "INSERT INTO LanguagePreferencesEx(UserId, Language1, L1Reading, L1Writing, L1Listening, Language2, L2Reading, L2Writing, L2Listening,
																									Language3, L3Reading, L3Writing, L3Listening, Language4, L4Reading, L4Writing, L4Listening)
								VALUES ('$userId', '$language1', '$language1readingproficiency', '$language1writingproficiency', '$language1listeningproficiency',
								 '$language2', '$language2readingproficiency', '$language2writingproficiency', '$language2listeningproficiency',
							 	 '$language3', '$language3readingproficiency', '$language3writingproficiency', '$language3listeningproficiency',
						 		 '$language4', '$language4readingproficiency', '$language4writingproficiency', '$language4listeningproficiency')";
			mysql_query($query);
			$message = mysql_error();

			// 	//Language 1
			// 	$query = "INSERT INTO Answers (id, question, user, response) VALUES (NULL, 'language1', '$username', '$language1')";
			// 	//$query = "INSERT INTO `PERMIA`.`Answers` (`id`, `question`, `user`, `response`) VALUES (NULL, 'language1', '$username', '$language1')";
			// 	mysql_query($query);
			// 	$message = mysql_error();
			//
			// 	//Language 2
			// 	$query = "INSERT INTO Answers (id, question, user, response) VALUES (NULL, 'language2', '$username', '$language2')";
			// //$query = "INSERT INTO `PERMIA`.`Answers` (`id`, `question`, `user`, `response`) VALUES (NULL, 'language2', '$username', '$language2')";
			// 	mysql_query($query);
			// 	$message = mysql_error();
			//
			// 	//Language 3
			// 	if($language3!="")
			// 	{
			// 		$query = "INSERT INTO Answers (id, question, user, response) VALUES (NULL, 'language3', '$username', '$language3')";
			// 		mysql_query($query);
			// 		$message = mysql_error();
			// 	}
			//
			// 	//Language 4
			// 	if($language4!="")
			// 	{
			// 		$query = "INSERT INTO Answers (id, question, user, response) VALUES (NULL, 'language4', '$username', '$language4')";
			// 		mysql_query($query);
			// 		$message = mysql_error();
			// 	}
		} else {
			$message = '<div class="error">You must choose at least a first language (language 1) and a second language (language 2), as well as the corresponding proficiencies</div>';
		}

    if($message=='') {
			mysql_close($con);

			//$_SESSION['username']=$username;
			$_SESSION['language1']=$language1;
			$_SESSION['InterfaceLanguage']=Enlgish;
			$_SESSION['language1readingproficiency']=$language1readingproficiency;
			$_SESSION['language1writingproficiency']=$language1writingproficiency;
			$_SESSION['language1listeningproficiency']=$language1listeningproficiency;
			$_SESSION['language2']=$language2;
			$_SESSION['language2readingproficiency']=$language2readingproficiency;
			$_SESSION['language2writingproficiency']=$language2writingproficiency;
			$_SESSION['language2listeningproficiency']=$language2listeningproficiency;
			$_SESSION['language3']=$language3;
			$_SESSION['language3readingproficiency']=$language3readingproficiency;
			$_SESSION['language3writingproficiency']=$language3writingproficiency;
			$_SESSION['language3listeningproficiency']=$language3listeningproficiency;
			$_SESSION['language4']=$language4;
			$_SESSION['language4readingproficiency']=$language4readingproficiency;
			$_SESSION['language4writingproficiency']=$language4writingproficiency;
			$_SESSION['language4listeningproficiency']=$language4listeningproficiency;

			$language_codes = array(
				"ar-XA" => "العربية",
				"bg-BG" => "Български",
				"zh-CN" => "中文",
				"zh-HK" => "粵語",
				"hr-HR" => "Hrvatski",
				"cs-CZ" => "Čeština",
				"da-DK" => "Dansk",
				"nl-NL" => "Nederlands",
				"en-US" => "English",
				"et-EE" => "Eesti",
				"fi-FI" => "Suomi",
				"fr-FR" => "Français",
				"de-DE" => "Deutsch",
				"el-GR" => "Ελληνικά",
				"he-IL" => "עברית",
				"hu-HU" => "Magyar",
				"it-IT" => "Italiano",
				"ja-JP" => "日本語",
				"ko-KR" => "한국어",
				"lv-LV" => "Latviešu",
				"lt-LT" => "Lietuvių",
				"nb-NO" => "Norsk",
				"pl-PL" => "Polski",
				"pt-BR" => "Português",
				"ro-RO" => "Română",
				"ru-RU" => "Русский",
				"sk-SK" => "Slovenčina",
				"sl-SL" => "Slovenščina",
				"es-ES" => "Español",
				"sv-SE" => "Svenska",
				"th-TH" => "ไทย",
				"tr-TR" => "Türkçe",
				"uk-UA" => "Українська",
			);

			$_SESSION['localised'] = $localised_en;
			$_SESSION['language_codes'] = $language_codes;
			header("Location: studyManager.php");
			die();
		}
}
?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN">

		<html>
			<head>
				<link rel="stylesheet" type="text/css" href="style.css">
				<script src="Javascript/jquery-1.11.0.min.js" type="text/javascript"></script>
				<script src="Javascript/jquery.validate.min.js" type="text/javascript"></script>
				<script src="Javascript/additional-methods.min.js" type="text/javascript"></script>
				<link href='http://fonts.googleapis.com/css?family=Indie+Flower' rel='stylesheet' type='text/css'>
				<script type='text/javascript'>
					$( document ).ready(function() {

						//add required if third language is selected
						$('#language3').on('change', function() {
						  	if(this.value != '')
						  	{
								$('#language3readingproficiency').attr('required','required');
								$('#language3writingproficiency').attr('required','required');
								$('#language3listeningproficiency').attr('required','required');
							}
							else
							{
								$('#language3readingproficiency').removeAttr('required');
								$('#language3writingproficiency').removeAttr('required');
								$('#language3listeningproficiency').removeAttr('required');
							}
						});
						//add required if fourth language is selected
						$('#language4').on('change', function() {
						  	if(this.value != '')
						  	{
								$('#language4readingproficiency').attr('required','required');
								$('#language4writingproficiency').attr('required','required');
								$('#language4listeningproficiency').attr('required','required');
							}
							else
							{
								$('#language4readingproficiency').removeAttr('required');
								$('#language4writingproficiency').removeAttr('required');
								$('#language4listeningproficiency').removeAttr('required');
							}
						});

					});
				</script>
				<title>
					PerMIA
				</title>
			</head>
			<body>
		<div class='container'>
			<div class='headerContainer'>

				<div class='mainContainer'>


				<form>
					<div class='instruction'>Please indicate up to 4 languages that you are proficient in (at least 2), and your proficiency in them: <br /> <br /></div>

					Language 1*
					<select name='language1' required>
							<option value="">select language</option>
							<option value="en-US">English</option>
							<option value="zh-CN">Chinese - Simplified</option>
							<option value="zh-HK">Chinese - Traditional</option>
							<option value="fr-FR">French</option>
							<option value="de-DE">German</option>
							<option value="es-ES">Spanish</option>
							<option value="it-IT">Italian</option>
						</select>
						<select name='language1readingproficiency' required>
							<option value="">reading</option>
							<option value="4">4-native/bilingual</option>
							<option value="3">3</option>
							<option value="2">2</option>
							<option value="1">1</option>
							<option value="0">0-no proficiency</option>
						</select>
						<select name='language1writingproficiency' required>
							<option value="">writing</option>
							<option value="4">4-native/bilingual</option>
							<option value="3">3</option>
							<option value="2">2</option>
							<option value="1">1</option>
							<option value="0">0-no proficiency</option>
						</select>
						<select name='language1listeningproficiency' required>
							<option value="">listening</option>
							<option value="4">4-native/bilingual</option>
							<option value="3">3</option>
							<option value="2">2</option>
							<option value="1">1</option>
							<option value="0">0-no proficiency</option>
						</select>
						 <br /><br />
						Language 2* <select name='language2' required>
							<option value="">select language</option>
							<option value="en-US">English</option>
							<option value="zh-CN">Chinese - Simplified</option>
							<option value="zh-HK">Chinese - Traditional</option>
							<option value="fr-FR">French</option>
							<option value="de-DE">German</option>
							<option value="es-ES">Spanish</option>
							<option value="it-IT">Italian</option>
						</select>
						<select name='language2readingproficiency' required>
							<option value="">reading</option>
							<option value="4">4-native/bilingual</option>
							<option value="3">3</option>
							<option value="2">2</option>
							<option value="1">1</option>
							<option value="0">0-no proficiency</option>
						</select>
						<select name='language2writingproficiency' required>
							<option value="">writing</option>
							<option value="4">4-native/bilingual</option>
							<option value="3">3</option>
							<option value="2">2</option>
							<option value="1">1</option>
							<option value="0">0-no proficiency</option>
						</select>
						<select name='language2listeningproficiency' required>
							<option value="">listening</option>
							<option value="4">4-native/bilingual</option>
							<option value="3">3</option>
							<option value="2">2</option>
							<option value="1">1</option>
							<option value="0">0-no proficiency</option>
						</select>
						 <br /><br />
						Language 3&nbsp; <select name='language3' id='language3'>
							<option value="">select language</option>
							<option value="en-US">English</option>
							<option value="zh-CN">Chinese - Simplified</option>
							<option value="zh-HK">Chinese - Traditional</option>
							<option value="fr-FR">French</option>
							<option value="de-DE">German</option>
							<option value="es-ES">Spanish</option>
							<option value="it-IT">Italian</option>
						</select>
						<select name='language3readingproficiency' id='language3readingproficiency'>
							<option value="">reading</option>
							<option value="4">4-native/bilingual</option>
							<option value="3">3</option>
							<option value="2">2</option>
							<option value="1">1</option>
							<option value="0">0-no proficiency</option>
						</select>
						<select name='language3writingproficiency' id='language3writingproficiency'>
							<option value="">writing</option>
							<option value="4">4-native/bilingual</option>
							<option value="3">3</option>
							<option value="2">2</option>
							<option value="1">1</option>
							<option value="0">0-no proficiency</option>
						</select>
						<select name='language3listeningproficiency' id='language3listeningproficiency'>
							<option value="">listening</option>
							<option value="4">4-native/bilingual</option>
							<option value="3">3</option>
							<option value="2">2</option>
							<option value="1">1</option>
							<option value="0">0-no proficiency</option>
						</select>

						 <br /><br />
						Language 4&nbsp; <select name='language4'  id='language4'>
							<option value="">select language</option>
							<option value="en-US">English</option>
							<option value="zh-CN">Chinese - Simplified</option>
							<option value="zh-HK">Chinese - Traditional</option>
							<option value="fr-FR">French</option>
							<option value="de-DE">German</option>
							<option value="es-ES">Spanish</option>
							<option value="it-IT">Italian</option>
						</select>
						<select name='language4readingproficiency' id='language4readingproficiency'>
							<option value="">reading</option>
							<option value="4">4-native/bilingual</option>
							<option value="3">3</option>
							<option value="2">2</option>
							<option value="1">1</option>
							<option value="0">0-no proficiency</option>
						</select>
						<select name='language4writingproficiency' id='language4writingproficiency'>
							<option value="">writing</option>
							<option value="4">4-native/bilingual</option>
							<option value="3">3</option>
							<option value="2">2</option>
							<option value="1">1</option>
							<option value="0">0-no proficiency</option>
						</select>
						<select name='language4listeningproficiency' id='language4listeningproficiency'>
							<option value="">listening</option>
							<option value="4">4-native/bilingual</option>
							<option value="3">3</option>
							<option value="2">2</option>
							<option value="1">1</option>
							<option value="0">0-no proficiency</option>
						</select>

						<!-- <div class='instruction'>Please indicate your preferred interface language: <br /> <br /></div>
						Interface Language: <select name='InterfaceLanguage'>
							<option value="en-US" selected>English</option>
							<option value="fr-FR">French</option>
							<option value="de-DE">German</option>
							<option value="zh-CN">Chinese (simplified)</option>
							<option value="he-IL">Hebrew</option>
						</select> -->

						<br /><br />
						<input type="hidden" name="submitted" value="true">
						<?php echo $message . "<br>"; ?>
            <!-- TODO(xiaoyu): DELETE onclick BEFORE submitting code -->
						<input type="submit" value="Save and get started!" action="">
                   <!-- onclick="window.location.href = 'studyManager.php';"> -->

						<br /><br /><br />
				</form>
				</div>

			</div>
		</div>
	</body>
</html>
