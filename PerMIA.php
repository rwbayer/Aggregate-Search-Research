<?php 
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

	if(isset($_REQUEST["source1"]))
	{
		$_SESSION['source1'] = $_REQUEST["source1"];
		if(isset($_REQUEST["numResults1"]))
		{
			$_SESSION['numResults1'] = $_REQUEST["numResults1"];
		}
	}
	if(isset($_REQUEST["source2"]))
	{
		$_SESSION['source2'] = $_REQUEST["source2"];
		if(isset($_REQUEST["numResults2"]))
		{
			$_SESSION['numResults2'] = $_REQUEST["numResults2"];
		}
	}
	if(isset($_REQUEST["source3"]))
	{
		$_SESSION['source3'] = $_REQUEST["source3"];
		if(isset($_REQUEST["numResults3"]))
		{
			$_SESSION['numResults3'] = $_REQUEST["numResults3"];
		}
	}
	if(isset($_REQUEST["source4"]))
	{
		$_SESSION['source4'] = $_REQUEST["source4"];
		if(isset($_REQUEST["numResults4"]))
		{
			$_SESSION['numResults4'] = $_REQUEST["numResults4"];
		}
	}
		
	if($_SESSION['interface'])
	{
		if($_SESSION['interface']=='tabbed')
		{
			// show tabs
			echo("<style>div.resultContainer{width:100%;max-width:100%; margin-top:10px;}</style>");
		}
		
		if($_SESSION['interface']=='blended')
		{
			// don't have to do anything
		}
		
		if($_SESSION['interface']=='panel')
		{
			echo("<style>.vertical{display:inline-block; max-width:500px; vertical-align:top;} div.resultContainer{width:1050px;max-width:1100px;} #box2, #box4{border: 1px solid lightgray; border-radius: 8px; padding:8px; margin: 0px 15px 15px 15px;}</style>");

		}
	}
	else
	{
		// default to blended
	}
	
	$number_of_sources_requested = 0;
		
	if(isset($_SESSION['source1'])  && $_SESSION["source1"]!="")
	{
		$source1 = $_SESSION["source1"];
		$number_of_results1 = $_SESSION["numResults1"];
		$number_of_sources_requested++;
	}
	else
	{
		$source1 = '';
		$number_of_results1 = 0;
	}

	if(isset($_SESSION["source2"])  && $_SESSION["source2"]!="")
	{
		$source2 = $_SESSION["source2"];
		$number_of_results2 = $_SESSION["numResults2"];
		$number_of_sources_requested++;
	}
	else
	{
		$source2 = '';
		$number_of_results2 = 0;
	}

	if(isset($_SESSION["source3"]) && $_SESSION["source3"]!="")
	{
		$source3 = $_SESSION["source3"];
		$number_of_results3 = $_SESSION["numResults3"];
		$number_of_sources_requested++;
	}
	else
	{
		$source3 = '';
		$number_of_results3 = 0;
	}

	if(isset($_SESSION["source4"]) && $_SESSION["source4"]!="")
	{
		$source4 = $_SESSION["source4"];
		$number_of_results4 = $_SESSION["numResults4"];
		$number_of_sources_requested++;
	}
	else
	{
		$source4 = '';
		$number_of_results4 = 0;
	}
	
	if(isset($_REQUEST["searchText"]))
	{
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
		<script type="text/javascript">

			function clickedVerticalHeading(text, vertical)
			{
				var elementString = '.verticalLabel[value="' + vertical + '"]';
				$(elementString).trigger('click');
			}

			function showNextWebResults(text, el)
			{
				$('.resultContainer').html("");
				$('.footer').hide();

				var $active = $('.active');
				$('.active').removeClass('active');
				$active.parent().next().find('a').first().addClass('active');

				var offset = numberOfWebResultsRequested + ((currentPage-1) * 10);
				currentPage++;

				console.log("Offset is: " + offset);

				$.post("search.php", { searchText: text, market: "en-US", results: 10, offset: offset, source: "Web", i:1}).done(function( returnedJSON ) {
					
					var data = JSON.parse(returnedJSON);

					if (data.source == "Web")
					{
						var divIdentifier = "webResults";
					}
					else if (data.source == "Image")
					{
						var divIdentifier = "imageResults";
					}
					else if (data.source == "Video")
					{
						var divIdentifier = "videoResults";
					}
					else if (data.source == "News")
					{
						var divIdentifier = "newsResults";
					}
					$('.resultContainer').html('<div id="box' + data.i + '" class="' + divIdentifier + '">' + data.data + '</div>');

					showResults();
				});
			}

			function showPreviousWebResults(text)
			{
				$('.resultContainer').html("");
				$('.footer').hide();

				var $active = $('.active');
				$('.active').removeClass('active');
				$active.parent().prev().find('a').first().addClass('active');

				var offset = numberOfWebResultsRequested + ((currentPage-2) * 10);
				currentPage--;

				console.log("Offset is: " + offset);

				$.post("search.php", { searchText: text, market: "en-US", results: 10, offset: offset, source: "Web", i:1}).done(function( returnedJSON ) {
					
					var data = JSON.parse(returnedJSON);

					if (data.source == "Web")
					{
						var divIdentifier = "webResults";
					}
					else if (data.source == "Image")
					{
						var divIdentifier = "imageResults";
					}
					else if (data.source == "Video")
					{
						var divIdentifier = "videoResults";
					}
					else if (data.source == "News")
					{
						var divIdentifier = "newsResults";
					}
					$('.resultContainer').html('<div id="box' + data.i + '" class="' + divIdentifier + '">' + data.data + '</div>');

					showResults();
				});
			}

			function showNumberWebResults(text)
			{
				$('.resultContainer').html("");
				$('.footer').hide();

				var $active = $('.active');
				$('.active').removeClass('active');
				$active.parent().prev().find('a').first().addClass('active');

				var offset = numberOfWebResultsRequested + ((currentPage-2) * 10);
				currentPage--;

				console.log("Offset is: " + offset);

				$.post("search.php", { searchText: text, market: "en-US", results: 10, offset: offset, source: "Web", i:1}).done(function( returnedJSON ) {
					
					var data = JSON.parse(returnedJSON);

					if (data.source == "Web")
					{
						var divIdentifier = "webResults";
					}
					else if (data.source == "Image")
					{
						var divIdentifier = "imageResults";
					}
					else if (data.source == "Video")
					{
						var divIdentifier = "videoResults";
					}
					else if (data.source == "News")
					{
						var divIdentifier = "newsResults";
					}
					$('.resultContainer').html('<div id="box' + data.i + '" class="' + divIdentifier + '">' + data.data + '</div>');

					showResults();
				});
			}

			function clickedSingleVertical(text, vertical)
			{
				$('.resultContainer').html("");

				$.post("search.php", { searchText: text, market: "en-US", results: 10, offset: 0, source: vertical, i:1}).done(function( returnedJSON ) {
					
					var data = JSON.parse(returnedJSON);

					if (data.source == "Web")
					{
						var divIdentifier = "webResults";
					}
					else if (data.source == "Image")
					{
						var divIdentifier = "imageResults";
					}
					else if (data.source == "Video")
					{
						var divIdentifier = "videoResults";
					}
					else if (data.source == "News")
					{
						var divIdentifier = "newsResults";
					}
					$('.resultContainer').html('<div id="box' + data.i + '" class="' + divIdentifier + '">' + data.data + '</div>');

					showResults();
				});
			}

			var numberOfSourcesReturned = 0;
			var numberOfSourcesRequested = 0;
			var numberOfWebResultsRequested = 0;
			var currentPage = 1;

			function translateAndSearch(text, number_of_results1, number_of_results2, number_of_results3, number_of_results4, source1, source2, source3, source4, numberOfSourcesRequestedInit)
			{
				numberOfSourcesRequested = parseInt(numberOfSourcesRequestedInit);
				if(text!='')
				{
					for (var i=1; i<5; i++)
					{
						var sourceString = "source".concat(i);
						var source = eval(sourceString);

						var numResultsString = "number_of_results".concat(i);
						var numResults = eval(numResultsString);

						var offset = 0;

						if (source == "Web")
						{
							console.log("Num results: " + numResults);
							numberOfWebResultsRequested += parseInt(numResults);
							offset = parseInt(numberOfWebResultsRequested);
						}

						if (source != null && source != "")
						{
							$.post("search.php", { searchText: text, market: "en-US", results: numResults, offset: offset, source: source, i:i}).done(function( data ) {
								parseResponse(data);
							}); 
						}
					}	
				}
			}

			var parseResponse = function(returnedJSON) {
				var data = JSON.parse(returnedJSON);
				
				if (data.source == "Web")
				{
					var divIdentifier = "#box".concat(data.i).concat(".webResults");
				}
				else if (data.source == "Image")
				{
					var divIdentifier = "#box".concat(data.i).concat(".imageResults");
				}
				else if (data.source == "Video")
				{
					var divIdentifier = "#box".concat(data.i).concat(".videoResults");
				}
				else if (data.source == "News")
				{
					var divIdentifier = "#box".concat(data.i).concat(".newsResults");
				}

				if (data.source != "Web")
				{
					$(divIdentifier).html("<h1><a class=\"verticalLink\" onclick=\"clickedVerticalHeading('" +  data.searchText + "', '" + data.source + "')\">" + data.source + " results for <strong>" + data.searchText + "</strong></a></h1>" + data.data);
				}
				else
				{
					$(divIdentifier).html(data.data);
				}

				numberOfSourcesReturned++;

				if (numberOfSourcesReturned == numberOfSourcesRequested)
				{
					showResults();
				}
			};

			var showResults = function()
			{
				$('.resultContainer').show();
				$('.footer').show();
			}
			
			$( document ).ready(function() 
			{
				$('.footer').hide();
				translateAndSearch('<?php echo htmlspecialchars($text, ENT_QUOTES); ?>', '<?php echo $number_of_results1 ?>', '<?php echo $number_of_results2 ?>', '<?php echo $number_of_results3 ?>', '<?php echo $number_of_results4 ?>', '<?php echo $source1 ?>','<?php echo $source2 ?>','<?php echo $source3 ?>','<?php echo $source4 ?>', '<?php echo $number_of_sources_requested ?>');
			
				$("body").on('click', '.verticalLabel', function()
				{
					$('.verticalLabel.selected').removeClass('selected');
					$(this).addClass('selected');
				});
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
			Aggregate Search
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
			
			<div class='headerContainer'>
				<form>
					<div class='inputBoxes'>
						<?php 
							if(!($_SESSION['interface']=='tabbed'))
							{
								echo('<input type="hidden" name="source1" value="' . $_SESSION['source1'] . '">');
								echo('<input type="hidden" name="source2" value="' . $_SESSION['source2'] . '">');
								echo('<input type="hidden" name="numResults2" value="' . $_SESSION['numResults2'] . '">');
								echo('<input type="hidden" name="source3" value="' . $_SESSION['source3'] . '">');
								echo('<input type="hidden" name="numResults3" value="' . $_SESSION['numResults3'] . '">');
								echo('<input type="hidden" name="source4" value="' . $_SESSION['source4'] . '">');
								echo('<input type="hidden" name="numResults4" value="' . $_SESSION['numResults4'] . '">');
							}
						?>
						<input type="hidden" name="interface" value="<?php echo $_SESSION['interface']?>">
						<input type="hidden" name="numResults1" value="<?php echo $_SESSION['numResults1']?>">

						<input type="text" style="width:500px;" id="searchText" name="searchText" value="<?php echo htmlspecialchars($text,ENT_QUOTES)?>">
						<input type="submit" id='submitbutton' value="Search" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
					
						
						<br/><br/>	
						<div class="links">
							<?php
								if (!($_SESSION['interface'] == 'tabbed'))
								{
									echo('<input type="submit" class="verticalLabel selected" value="All">');
								}
							?>
							<input type="button" name="source1" class="verticalLabel" value="Web" onclick="clickedSingleVertical('<?php echo htmlspecialchars($text, ENT_QUOTES); ?>', 'Web')">
							<input type="button" name="source1" class="verticalLabel" value="Image" onclick="clickedSingleVertical('<?php echo htmlspecialchars($text, ENT_QUOTES); ?>', 'Image')">
							<input type="button" name="source1" class="verticalLabel" value="Video" onclick="clickedSingleVertical('<?php echo htmlspecialchars($text, ENT_QUOTES); ?>', 'Video')">
							<input type="button" name="source1" class="verticalLabel" value="News" onclick="clickedSingleVertical('<?php echo htmlspecialchars($text, ENT_QUOTES); ?>', 'News')">
						</div>
					</div>
				</form>
			</div>
			<div class='resultContainer'>
				<?php
					for($i=1; $i<5; $i++)
					{

						if ($i != 1 && $_SESSION['interface'] == 'blended')
						{
							echo("<hr>");
						}

						$currentSource = ${"source" . $i};
			
						if ($currentSource == "Web")
						{
							echo "<div id='box" . $i . "' class='webResults vertical'></div>";
						}
						else if ($currentSource == "Image")
						{
							echo "<div id='box" . $i . "' class='imageResults vertical'></div>";
						}
						else if ($currentSource == "Video")
						{
							echo "<div id='box" . $i . "' class='videoResults vertical'></div>";
						}
						else if ($currentSource == "News")
						{
							echo "<div id='box" . $i . "' class='newsResults vertical'></div>";
						}
					}
				?>
				
				
				
			</div>
		</div>

		<div class="footer">
			<ul class="pagination">
			  <li><a onclick="showPreviousWebResults('<?php echo htmlspecialchars($text, ENT_QUOTES); ?>')">«</a></li>
			  <li><a class="active" href="#">1</a></li>
			  <li><a href="#">2</a></li>
			  <li><a href="#">3</a></li>
			  <li><a href="#">4</a></li>
			  <li><a href="#">5</a></li>
			  <li><a href="#">6</a></li>
			  <li><a href="#">7</a></li>
			  <li><a onclick="showNextWebResults('<?php echo htmlspecialchars($text, ENT_QUOTES); ?>', this)">»</a></li>
			</ul>
		</div>
	</body>
</html>
