<?php 
	$_SESSION['experiment'] = false;
	$extras_visibility = '';
	
	
	header('Content-Type: text/html; charset=utf-8');

	echo "<!DOCTYPE html PUBLIC '-//W3C//DTD HTML 4.01//EN'>";

	if(isset($_SESSION['current_query']))
	{
		if($_SESSION['current_query'])
		{
			$current_query = $_SESSION['current_query'];
		}
		else
		{
			$current_query = 0;
		}
	}
	else
	{
		$current_query = 0;
	}

	if(isset($_REQUEST["interface"]))
	{
		$_SESSION['interface'] = $_REQUEST["interface"];
	}
	
	//setting up variables
	$localised = $_SESSION['localised'];
	$InterfaceLanguage = $_SESSION['InterfaceLanguage'];
	
	if($InterfaceLanguage=='ar-XA' || $InterfaceLanguage=='he-IL')
	{
		$interface_direction = 'rtl';
		
	}
	else
	{
		$interface_direction = '';
	}
	
	if($_SESSION['interface'])
	{
		if($_SESSION['interface']=='tabbed')
		{
			$option_type = 'radio';
			$option_display = 'nothidden';
			$display_style = 'merged';
		}
		
		if($_SESSION['interface']=='dynamic')
		{
			$option_type = 'radio';
			$option_display = 'nothidden';
			$display_style = 'merged';
		}
		
		if($_SESSION['interface']=='non-blended-panel')
		{
			$option_type = 'checkbox';
			$option_display = 'hidden';
			$display_style = 'nonmerged';
		}
		
		if($_SESSION['interface']=='panel')
		{
			$option_type = 'checkbox';
			$option_display = 'nothidden';
			$display_style = 'nonmerged';
		}
		
		if($_SESSION['interface']=='recommender')
		{
			$option_type = 'radio';
			$option_display = 'nothidden';
			$display_style = 'recommender';
		}
		
	}
	else
	{
		$option_type = 'checkbox';
		$option_display = 'hidden';
		$display_style = 'merged';
	}
	
	$firstSearch = true;

	//getting source type
	if(isset($_REQUEST["source"]))
	{
		$source = $_REQUEST["source"];
		
		if($source=='Web')
		{
			$checkedweb='checked';
		}
		if($source=='News')
		{
			$checkednews='checked';
		}
	}
	else
	{
		$checkedweb='checked';
	}
	
	
	
	
		$name1 = "language1";
		$name2 = "language2";
		$name3 = "language3";
		$name4 = "language4";
		
		if(isset($_REQUEST["language1"])  && $_REQUEST["language1"]!="")
		{
			$selected_language1 = $_REQUEST["language1"];
			$checked1='checked';
			++$number_of_boxes;
		}
		else
		{
			$selected_language1 = '';
		}

		if(isset($_REQUEST["language2"])  && $_REQUEST["language2"]!="")
		{
			$selected_language2 = $_REQUEST["language2"];
			$checked2='checked';
			++$number_of_boxes;
		}
		else
		{
			$selected_language2 = '';
		}

		if(isset($_REQUEST["language3"]) && $_REQUEST["language3"]!="")
		{
			$selected_language3 = $_REQUEST["language3"];
			$checked3='checked';
			++$number_of_boxes;
		}
		else
		{
			$selected_language3 = '';
		}

		if(isset($_REQUEST["language4"]) && $_REQUEST["language4"]!="")
		{
			$selected_language4 = $_REQUEST["language4"];
			$checked4='checked';
			++$number_of_boxes;
		}
		else
		{
			$selected_language4 = '';
		}
		
		if($number_of_boxes==0 && $firstSearch )
		{
			$checked1='checked';
			$checked2='checked';
			$checked3='checked';
			$checked4='checked';
		}
		

	
	if(isset($_REQUEST["searchText"]))
	{
		$firstSearch = false;
		$text = $_REQUEST["searchText"];
	}
	else
	{
		$text = '';
	}
?>

<html>
	<head>
		<link rel="stylesheet" type="text/css" href="style.css">
		<link rel="stylesheet" type="text/css" href="styleResultPage.css">
		<link rel="stylesheet" type="text/css" href="styleResultPageRight.css">
		<link rel="stylesheet" type="text/css" href="styleResultPageHeader<?php echo $interface_direction;?>.css">
		<script src="Javascript/jquery-1.11.0.min.js" type="text/javascript"></script>
		<!-- <script src="src/iframeResizer.contentWindow.min.js" type="text/javascript"></script>-->
		<script type="text/javascript">
		
			var currentinterface = <?php echo json_encode($_SESSION['interface'])?>;
		
			function singleSearchOnNextPrevious(text, number_of_results, language, number, direction, source)
			{
				if(number==1)
				{
					pagination1 = pagination1 + direction;
					pagination = pagination1;
				}
				else if(number==2)
				{
					pagination2 = pagination2 + direction;
					pagination = pagination2;
				}
				else if(number==3)
				{
					pagination3 = pagination3 + direction;
					pagination = pagination3;
				}
				else if(number==4)
				{
					pagination4 = pagination4 + direction;
					pagination = pagination4;
				}
				
				offset=(pagination-1)*number_of_results;
				
				$(".next", $("#translatedQuery"+number)).hide();
				$(".previous", $("#translatedQuery"+number)).hide();
				$("#translatedResultsValues"+number).html('');
				$("#translatedResultsValues"+number).html('<img src=\'images/ajax-loader.gif\'/>');

				text = reverse_htmlspecialchars(text);

				$.post( "search.php", { searchText: text, market: language, results: number_of_results, offset: offset, source: source} ).done(function( data ) {
					
					$("#translatedResultsValues"+number).html(data);
					$(".next", $("#translatedQuery"+number)).show();
					if(pagination>1)
					{
						text = htmlspecialchars(text);
						
						$(".previous a", $("#translatedQuery"+number)).replaceWith("<a href=''>&lt; <?php echo $localised['Previous']?></a>");
						previousString = "javascript:singleSearchOnNextPrevious(\""+text+"\","+number_of_results+",\""+language+"\","+number+","+(-1)+",'"+source+"')";
						$(".previous a", $("#translatedQuery"+number)).attr('href', previousString);
						
						$(".previous", $("#translatedQuery"+number)).show();
					}
				});
			}
			
			function singleSearchOnEditedTranslation(text, number_of_results, language, number, source)
			{
				if(number==1)
				{
					pagination1 = 1;
				}
				else if(number==2)
				{
					pagination2 = 1;
				}
				else if(number==3)
				{
					pagination3 = 1;
				}
				else if(number==4)
				{
					pagination4 = 1;
				}
				
				$(".next", $("#translatedQuery"+number)).hide();
				$(".previous", $("#translatedQuery"+number)).hide();
				$(".next", $("#translatedQuery"+number)).children('a').attr("href", "javascript:singleSearchOnNextPrevious(\""+htmlspecialchars(text)+"\","+number_of_results+",\""+language+"\","+number+","+1+",'"+source+"')");
				$("#translatedResultsValues"+number).html('');
				$("#translatedResultsValues"+number).html('<img src=\'images/ajax-loader.gif\'/>');
				
				$.post( "search.php", { searchText: text, market: language, results: number_of_results, offset: 0, source: source} ).done(function( data ) {
					
					$("#translatedResultsValues"+number).html(data);
					$(".next", $("#translatedQuery"+number)).show();
				});
			}
		
			function translateAndSearch(text, number_of_results1, number_of_results2, number_of_results3, number_of_results4, language1, language2, language3, language4, source)
			{	
				console.log("In translate And Search");			
				var boxnumber = 0;
				
				if(text!='')
				{
							boxnumber++;
							// addBoxOrientation(boxnumber, 'translatedQuery1');
																					
							$('#translatedQuery1').show();
							
							console.log("About to call");
								$.post( "search.php", { searchText: text, market: "en-US", results: 10, offset: 0, source: source} ).done(function( data ) {
									console.log("Called");
									$("#translatedResultsValues1").html(data);

									translatedQuery1 = htmlspecialchars(translatedQuery1);
									
									$(".next a", $("#translatedQuery1")).replaceWith("<a href=''><?php echo $localised['Next']?> &gt;</a>");
									nextString = "javascript:singleSearchOnNextPrevious(\""+translatedQuery1+"\","+number_of_results1+",\""+language1+"\","+1+","+1+",'"+source+"')";
									$(".next a", $("#translatedQuery1")).attr('href', nextString);
								}); 
				}
			}
			
			
			
			$( document ).ready(function() {
				
				//recommender fix
				$(".recommender.checked").insertBefore("#translatedQuery1");
				//end recommender fix
				
				translateAndSearch('<?php echo htmlspecialchars($text, ENT_QUOTES); ?>', '<?php echo $number_of_results1 ?>', '<?php echo $number_of_results2 ?>', '<?php echo $number_of_results3 ?>', '<?php echo $number_of_results4 ?>', '<?php echo $selected_language1 ?>','<?php echo $selected_language2 ?>','<?php echo $selected_language3 ?>','<?php echo $selected_language4 ?>', '<?php echo $source ?>');
			
				$("*[type='radio']").change(function () {
					$( "#submitbutton" ).trigger( "click" );
				});
				
				$("*[type='checkbox']").change(function () {
					$( "#submitbutton" ).trigger( "click" );
				});
				
				pagination1 = 1;
				pagination2 = 1;
				pagination3 = 1;
				pagination4 = 1;
				
			});
			
		
			
			
			//helper methods
			function htmlspecialchars(string){
				return string
				         .replace(/&/g, "&amp;")
				         .replace(/</g, "&lt;")
				         .replace(/>/g, "&gt;")
				         .replace(/"/g, "&quot;")
				         .replace(/'/g, "&#039;");
				}
				
			
		</script>
		<title>
			PerMIA
		</title>
	</head>
	<body>
		
		<?php
			if(!$_SESSION['experiment'])
			{
				include 'top'. $interface_direction . '.php';
			}
			else
			{
				include 'topreduced'. $interface_direction . '.php';
			}
		?>
		
		<div class='container'>
			
			<div class='headerContainer<?php echo $option_display?>'>
				<form>
					<div class='inputBoxes'>
					<input type="hidden" name="interface" value="<?php echo $_SESSION['interface']?>">
					<input type="text" style="width:500px;" id="searchText" name="searchText" value="<?php echo htmlspecialchars($text,ENT_QUOTES)?>">
					<input type="submit" id='submitbutton' value="<?php echo $localised['Search']?>" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
					
					&nbsp;&nbsp;<input type='radio' name='source' id='source1' value='Web' class='<?php echo $extras_visibility ;?> css-radio2 ' <?php echo $checkedweb ;?>><label for='source1' class='<?php echo $extras_visibility ;?> css-radio2-label'> <?php echo $localised['Web']?></label>
					<input type='radio' name='source' id='source2' value='News' class='<?php echo $extras_visibility ;?> css-radio2 ' <?php echo $checkednews ;?>><label for='source2' class='<?php echo $extras_visibility ;?> css-radio2-label'><?php echo $localised['News']?></label>
					
					<br/><br/>
					
					<div id='options' class='<?php echo $option_display;?>'>						
				<?php
				
				if($language1 != "")
				{
					echo '<input type="' . $option_type . '" name="' . htmlspecialchars($name1,ENT_QUOTES) . '" id="language1" value="' . $language1 . '" class="css-' . $option_type . '"' . $checked1 .'><label for="language1" class="css-' . $option_type . '-label">' . $_SESSION['language_codes'][$language1] . '</label>';
				}
				if($language2 != "")
				{
					echo '<input type="' . $option_type . '" name="' . htmlspecialchars($name2,ENT_QUOTES) . '" id="language2" value="' . $language2 . '" class="css-' . $option_type . '"' . $checked2 .'><label for="language2" class="css-' . $option_type . '-label">' . $_SESSION['language_codes'][$language2] . '</label>';
				}
				if($language3 != "")
				{
					echo '<input type="' . $option_type . '" name="' . htmlspecialchars($name3,ENT_QUOTES) . '" id="language3" value="' . $language3 . '" class="css-' . $option_type . '"' . $checked3 .'><label for="language3" class="css-' . $option_type . '-label">' . $_SESSION['language_codes'][$language3] . '</label>';
				}
				if($language4 != "")
				{
					echo '<input type="' . $option_type . '" name="' . htmlspecialchars($name4,ENT_QUOTES) . '" id="language4" value="' . $language4 . '" class="css-' . $option_type . '"' . $checked4 .'><label for="language4" class="css-' . $option_type . '-label">' . $_SESSION['language_codes'][$language4] . '</label>';
				}
				
				
				?>
					</div>
					
					
					
					</div>
				</form>
			</div>
			<div class='resultContainer<?php echo $option_display?>'>
				<?php
				
				for($i=1;$i<5;$i++)
				{
					echo "<div id='translatedQuery" . $i . "' class='hidden box" . $number_of_boxes . " " . $display_style  . " " . ${"checked" . $i} ." " . ${"direction" . $i} . "'>" . 
						"<div class='header'>" . 
							"<div id='translatedQueryValue" . $i . "'  languagenumber='" . $i . "' language='" . ${'language'.$i} . "' class='query'></div>" . 
						"</div>" . 
						"<br/><br/>" . 
						"<div id='translatedResultsValues" . $i . "'></div>" . 
						"<div class='pagination'>" . 
							"<div class='previous left'><a href=''></a></div>" . 
							"<div class='next right'><a href=''></a></div>" . 
						"</div>" . 
					"</div>";
				
				}
				
				?>
				
				
				
			</div>
			
		</div>
	</body>
</html>
