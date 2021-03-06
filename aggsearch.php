<?php 
	include 'config.php';
	include 'localise.php';
	
	if (!isset($_SESSION))
    {
       session_start();
    }
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

	$con = mysql_connect($_DATABASEHOST, $_DATABASEUSER, $_DATABASEPASSWORD);
	mysql_select_db($_DATABASE);

	if(isset($_REQUEST["taskId"])) 
	{
		$taskid = intval($_REQUEST['taskId']);
		$_SESSION['taskId'] = $taskid;
		$result = mysql_query("SELECT * FROM AggSeaSearches WHERE Task_ID = $taskid");
		$row = mysql_fetch_assoc($result);
		$_SESSION['taskText'] = $row['Description'];
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
?>

<html>
	<head>
		<link rel="stylesheet" type="text/css" href="style.css">
		<link rel="stylesheet" type="text/css" href="styleResultPage.css">
		<link rel="stylesheet" type="text/css" href="styleResultPageRight.css">
		<link rel="stylesheet" type="text/css" href="styleResultPageHeader<?php echo $interface_direction;?>.css">
		<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>

		<link rel="stylesheet" href="fancybox/source/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />
		<script type="text/javascript" src="fancybox/source/jquery.fancybox.pack.js?v=2.1.5"></script>
		<script type="text/javascript" src="Javascript/jquery.waitforimages.min.js"></script>
		<script type="text/javascript">
			
			var favoriteBasket = [];

			var currentinterface = <?php echo json_encode($_SESSION['interface'])?>;
			var currentRequest;
			var timer = 0;
			var initialBoxes;

			var numberOfSourcesReturned = 0;
			var numberOfSourcesRequested = 0;

			var numberOfWebResultsRequested = 0;
			var numberOfImageResultsRequested = 0;
			var numberOfNewsResultsRequested = 0;
			var numberOfVideoResultsRequested = 0;

			var currentPage = 1;
			var openLink = {};
			var wasFinishClicked = false;

			function setCookie(cname, cvalue, exdays) 
			{
			    var d = new Date();
			    d.setTime(d.getTime() + (exdays*24*60*60*1000));
			    var expires = "expires="+d.toUTCString();
			    document.cookie = cname + "=" + cvalue + "; " + expires;
			}

			function getCookie(cname) 
			{
			    var name = cname + "=";
			    var ca = document.cookie.split(';');
			    for(var i = 0; i < ca.length; i++) {
			        var c = ca[i];
			        while (c.charAt(0) == ' ') {
			            c = c.substring(1);
			        }
			        if (c.indexOf(name) == 0) {
			            return c.substring(name.length, c.length);
			        }
			    }
			    return "";
			}

			function clickedVerticalHeading(text, vertical)
			{
				hideContent();

				// go to first page no matter what
				currentPage = 1;

				logNavigationChange("vertical heading", currentinterface, vertical, 1);
				showSingleVertical(vertical);
				$('.verticalLabel.selected').removeClass('selected');
				$('.verticalLabel#' + currentinterface).addClass('selected');
			}

			function clickedSingleVertical(vertical)
			{
				hideContent();
				
				// go to first page no matter what
				currentPage = 1;

				$('.active').removeClass('active');
				$('ul.pagination').children().eq(1).find('a').first().addClass('active');
				$("a.prev").addClass('disabled');
				$("a.next").removeClass('disabled');

				if (vertical == "All")
				{
					logNavigationChange("Show All", currentinterface, vertical, currentPage);
					currentinterface = <?php echo json_encode($_SESSION['interface'])?>;
					rebuildInitialBoxes();

					if (typeof webResults !== "undefined")
					{
						showInitialResults($('#searchText').val(), '<?php echo $number_of_results1 ?>', '<?php echo $number_of_results2 ?>', '<?php echo $number_of_results3 ?>', '<?php echo $number_of_results4 ?>', '<?php echo $source1 ?>','<?php echo $source2 ?>','<?php echo $source3 ?>','<?php echo $source4 ?>', '<?php echo $number_of_sources_requested ?>');
					}
					else
					{
						$('#loading').hide();
					}
					return;
				}
				else
				{
					logNavigationChange("single vertical", currentinterface, vertical, currentPage);
					showSingleVertical(vertical);
				}
			}

			function showSingleVertical(vertical)
			{
				currentinterface = vertical;

				if (typeof webResults !== "undefined")
				{
					showSinglePageOfResults(vertical, false);
				}
				else
				{
					$('#loading').hide();
				}
			}

			function showNextWebResults()
			{
				if (currentinterface == "Image")
				{
					if (currentPage == Math.ceil(imageResults.length/10))
					{
						return;
					}
				}
				else if (currentinterface == "Video")
				{
					if (currentPage == Math.ceil(videoResults.length/10))
					{
						return;
					}
				}
				else if (currentinterface == "News")
				{
					if (currentPage == Math.ceil(newsResults.length/10))
					{
						return;
					}
				}
				else
				{
					if (currentPage == Math.ceil(webResults.length/10))
					{
						return;
					}
				}

				hideContent();

				var $active = $('.active');
				$('.active').removeClass('active');
				console.log($active);
				console.log($active.parent().next().find('a').first());
				$active.parent().next().find('a').first().addClass('active');

				currentPage++;

				var source = currentinterface;

				if (!(source == "Web" || source == "Image" || source == "Video" || source == "News"))
				{
					source = "All";
				}

				logNavigationChange("show next", currentinterface, source, currentPage);
				currentinterface = source;

				if (currentPage == 2)
				{
					$("a.prev").removeClass('disabled');
				}

				if  (currentPage == 7)
				{
					$("a.next").addClass('disabled');
				}

				showSinglePageOfResults(source, false);
			}

			function showPreviousWebResults()
			{
				if (currentPage == 1)
				{
					return;
				}

				hideContent();

				var $active = $('.active');
				$('.active').removeClass('active');
				$active.parent().prev().find('a').first().addClass('active');

				currentPage--;
				
				var source = currentinterface;

				if (!(source == "Web" || source == "Image" || source == "Video" || source == "News"))
				{
					source = "All";
				}

				if (currentPage == 1 && source == "All")
				{
					logNavigationChange("show previous", currentinterface, <?php echo json_encode($_SESSION['interface'])?>, currentPage);
					currentinterface = <?php echo json_encode($_SESSION['interface'])?>;
					rebuildInitialBoxes();
					showInitialResults($('#searchText').val(), '<?php echo $number_of_results1 ?>', '<?php echo $number_of_results2 ?>', '<?php echo $number_of_results3 ?>', '<?php echo $number_of_results4 ?>', '<?php echo $source1 ?>','<?php echo $source2 ?>','<?php echo $source3 ?>','<?php echo $source4 ?>', '<?php echo $number_of_sources_requested ?>');
					return;
				}
				else
				{
					logNavigationChange("show previous", currentinterface, source, currentPage);
					currentinterface = source;
				}

				if  (currentPage == 6)
				{
					$("a.next").removeClass('disabled');
				}

				showSinglePageOfResults(source, false);
			}

			function showSinglePageOfResults(source, isInitial)
			{
				var dataToShow = "";
				var divIdentifier = "";

				if (source == "Image")
				{
					var offset = ((currentPage-1) * 10);

					divIdentifier = "imageResults";	

					for (var i=offset; i<(offset+10); i++)
					{
						if (imageResults[i] != undefined)
						{
							dataToShow += imageResults[i];
						}
					}	
				}
				else if (source == "News")
				{
					var offset = ((currentPage-1) * 10);

					divIdentifier = "newsResults";	

					for (var i=offset; i<(offset+10); i++)
					{
						if (newsResults[i] != undefined)
						{
							dataToShow += newsResults[i];
						}
					}	
				}
				else if (source == "Video")
				{
					var offset = ((currentPage-1) * 10);

					divIdentifier = "videoResults";	

					for (var i=offset; i<(offset+10); i++)
					{
						if (videoResults[i] != undefined)
						{
							dataToShow += videoResults[i];
						}
					}	
				}
				else
				{
					var offset = ((currentPage-1) * 10);

					divIdentifier = "webResults";

					for (var i=offset; i<(offset+10); i++)
					{
						if (webResults[i] != undefined)
						{
							dataToShow += webResults[i];
						}
					}
				}

				$('.resultContainer').html('<div id="box1" class="' + divIdentifier + ' single" vertical="' + currentinterface + '">' + dataToShow + '</div>');
				showFavorites();
				showContent(source);
				
				if (isInitial)
				{
					logInitialResultShown();
				}
			}

			function hideContent()
			{
				hideSuggestions();
				$('.resultContainer').hide();
				$('.footer').hide();
				$('#loading').show();
			}

			function showContent(source)
			{
				$('.resultContainer').waitForImages(function() {
				    // All descendant images have loaded
				    $('#loading').hide();
				    showCorrectPagination(source);
				    $('.resultContainer').show();
				});
			}

			function showCorrectPagination(source)
			{
				$('ul.pagination').html("");

				if (currentPage == 1)
				{
					$('ul.pagination').append('<li><a class="prev disabled" onclick="showPreviousWebResults()" >«</a></li>');
				}
				else
				{
					$('ul.pagination').append('<li><a class="prev" onclick="showPreviousWebResults()" >«</a></li>');
				}

				if (source == "Image")
				{
				  	for (var i = 0; i < Math.ceil(imageResults.length/10); i++)
				  	{
				  		if (currentPage == (i+1))
				  		{
				  			$('ul.pagination').append('<li><a class="active" onclick="showPageOfWebResults(this)">' + (i+1) + '</a></li>');
				  		}
				  		else
				  		{
				  			$('ul.pagination').append('<li><a onclick="showPageOfWebResults(this)">' + (i + 1) + '</a></li>');
				  		}
				  	}

				  	if (currentPage == Math.ceil(imageResults.length/10))
					{
						$('ul.pagination').append('<li><a class="next disabled" onclick="showNextWebResults()">»</a></li> ');
					}
					else
					{
						$('ul.pagination').append('<li><a class="next" onclick="showNextWebResults()">»</a></li> ');
					}
				}
				else if (source == "News")
				{
					for (var i = 0; i < Math.ceil(newsResults.length/10); i++)
				  	{
				  		if (currentPage == (i+1))
				  		{
				  			$('ul.pagination').append('<li><a class="active" onclick="showPageOfWebResults(this)">' + (i+1) + '</a></li>');
				  		}
				  		else
				  		{
				  			$('ul.pagination').append('<li><a onclick="showPageOfWebResults(this)">' + (i + 1) + '</a></li>');
				  		}
				  	}

				  	if (currentPage == Math.ceil(newsResults.length/10))
					{
						$('ul.pagination').append('<li><a class="next disabled" onclick="showNextWebResults()">»</a></li> ');
					}
					else
					{
						$('ul.pagination').append('<li><a class="next" onclick="showNextWebResults()">»</a></li> ');
					}
				}
				else if (source == "Video")
				{
					for (var i = 0; i < Math.ceil(videoResults.length/10); i++)
				  	{
				  		if (currentPage == (i+1))
				  		{
				  			$('ul.pagination').append('<li><a class="active" onclick="showPageOfWebResults(this)">' + (i+1) + '</a></li>');
				  		}
				  		else
				  		{
				  			$('ul.pagination').append('<li><a onclick="showPageOfWebResults(this)">' + (i + 1) + '</a></li>');
				  		}
				  	}
				  	if (currentPage == Math.ceil(videoResults.length/10))
					{
						$('ul.pagination').append('<li><a class="next disabled" onclick="showNextWebResults()">»</a></li> ');
					}
					else
					{
						$('ul.pagination').append('<li><a class="next" onclick="showNextWebResults()">»</a></li> ');
					}
				}
				else if (source == "Web")
				{
				  	for (var i = 0; i < Math.ceil(webResults.length/10); i++)
				  	{
				  		if (currentPage == (i+1))
				  		{
				  			$('ul.pagination').append('<li><a class="active" onclick="showPageOfWebResults(this)">' + (i+1) + '</a></li>');
				  		}
				  		else
				  		{
				  			$('ul.pagination').append('<li><a onclick="showPageOfWebResults(this)">' + (i + 1) + '</a></li>');
				  		}
				  	}

				  	if (currentPage == Math.ceil(webResults.length/10))
					{
						$('ul.pagination').append('<li><a class="next disabled" onclick="showNextWebResults()">»</a></li> ');
					}
					else
					{
						$('ul.pagination').append('<li><a class="next" onclick="showNextWebResults()">»</a></li> ');
					}
				}
				else
				{
					// All - use web results length
					for (var i = 0; i < Math.ceil(webResults.length/10); i++)
				  	{
				  		if (currentPage == (i+1))
				  		{
				  			$('ul.pagination').append('<li><a class="active" onclick="showPageOfWebResults(this)">' + (i+1) + '</a></li>');
				  		}
				  		else
				  		{
				  			$('ul.pagination').append('<li><a onclick="showPageOfWebResults(this)">' + (i + 1) + '</a></li>');
				  		}
				  	}

				  	if (currentPage == Math.ceil(webResults.length/10))
					{
						$('ul.pagination').append('<li><a class="next disabled" onclick="showNextWebResults()">»</a></li> ');
					}
					else
					{
						$('ul.pagination').append('<li><a class="next" onclick="showNextWebResults()">»</a></li> ');
					}
					
				}

				$('.footer').show();
			}

			function rebuildInitialBoxes()
			{
				$('.resultContainer').html(initialBoxes);
			}

			function showPageOfWebResults(el)
			{
				hideContent();

				var numberSelected = parseInt($(el).text());
				var source = currentinterface;

				if (!(source == "Web" || source == "Image" || source == "Video" || source == "News"))
				{
					source = "All";
				}

				if (numberSelected == 1 && source == "All")
				{
					currentPage = numberSelected;
					logNavigationChange("show specific", currentinterface, <?php echo json_encode($_SESSION['interface'])?>, currentPage);
					currentinterface = <?php echo json_encode($_SESSION['interface'])?>;
					rebuildInitialBoxes();
					showInitialResults($('#searchText').val(), '<?php echo $number_of_results1 ?>', '<?php echo $number_of_results2 ?>', '<?php echo $number_of_results3 ?>', '<?php echo $number_of_results4 ?>', '<?php echo $source1 ?>','<?php echo $source2 ?>','<?php echo $source3 ?>','<?php echo $source4 ?>', '<?php echo $number_of_sources_requested ?>');
					return;
				}
				else
				{

					logNavigationChange("show specific", currentinterface, source, numberSelected);
					currentinterface = source;
				}

				$('.active').removeClass('active');
				$('ul.pagination').children().eq(numberSelected).find('a').first().addClass('active');

				currentPage = numberSelected;

				if  (currentPage == 7)
				{
					$("a.next").addClass('disabled');
				}
				else
				{
					$("a.prev").removeClass('disabled');
					$("a.next").removeClass('disabled');
				}

				showSinglePageOfResults(source, false);
			}

			function clickedSearchSuggestion(selectedText)
			{
				hideContent();

				logQuery(selectedText, true);
    			$('#searchText').val(selectedText);
				search(selectedText);	
			}

			function search(text)
			{
				if (timer)
				{
					window.clearTimeout(timer);
				}

				numberOfSourcesReturned = 0;
				currentPage = 1;
				console.log("in search: " + text);
				if(text!='')
				{
					$.ajax({
						type: 'POST',
						url: "image.php",
						data: { searchText: text, market: "en-US", results: 70, offset: 0}
					}).done(function( data ) 
					{
						parseResponse(data);
					}); 
				
					$.ajax({
						type: 'POST',
						url: "news.php",
						data: { searchText: text, market: "en-US", results: 70, offset: 0}
					}).done(function( data ) 
					{
						parseResponse(data);
					}); 

					$.ajax({
						type: 'POST',
						url: "video.php",
						data: { searchText: text, market: "en-US", results: 70, offset: 0}
					}).done(function( data ) 
					{
						parseResponse(data);
					}); 
			
					$.ajax({
						type: 'POST',
						url: "web.php",
						data: { searchText: text, market: "en-US", results: 70, offset: 0}
					}).done(function( data ) 
					{
						parseResponse(data);
					});					
				}
			}

			function parseResponse(returnedJSON) 
			{
				console.log(returnedJSON);
				var data = JSON.parse(returnedJSON);
				
				if (data.source == "Web")
				{
					webResults = data.data;
				}
				else if (data.source == "Image")
				{
					imageResults = data.data;
				}
				else if (data.source == "Video")
				{
					videoResults = data.data;
				}
				else if (data.source == "News")
				{
					newsResults = data.data;
				}

				numberOfSourcesReturned++;

				if (numberOfSourcesReturned == 4)
				{
					if (currentinterface == "Image" || currentinterface == "News" || currentinterface == "Video" || currentinterface == "Web")
					{
						showSinglePageOfResults(currentinterface, true);
					}
					else
					{
						showInitialResults($('#searchText').val(), '<?php echo $number_of_results1 ?>', '<?php echo $number_of_results2 ?>', '<?php echo $number_of_results3 ?>', '<?php echo $number_of_results4 ?>', '<?php echo $source1 ?>','<?php echo $source2 ?>','<?php echo $source3 ?>','<?php echo $source4 ?>', '<?php echo $number_of_sources_requested ?>');
					}
				}
			};

			function showInitialResults(searchText, number_of_results1, number_of_results2, number_of_results3, number_of_results4, source1, source2, source3, source4, number_of_sources_requested)
			{
				var webOffset = 0;
				var imageOffset = 0;
				var newsOffset = 0;
				var videoOffset = 0;
				numberOfWebResultsRequested = 0;
				numberOfNewsResultsRequested= 0;
				numberOfImageResultsRequested = 0;
				numberOfVideoResultsRequested = 0;

				for (var i = 1; i <= number_of_sources_requested; i++)
				{
					$("#box"+i).html("");

					var sourceString = "source".concat(i);
					var source = eval(sourceString);

					var numResultsString = "number_of_results".concat(i);
					var numResults = parseInt(eval(numResultsString));

					if (source == "Web")
					{
						for (var j=webOffset; j<(numResults+webOffset); j++)
						{
							if (webResults[j] != undefined)
							{
								$("#box"+i).append(webResults[j]);
							}
						}

						numberOfWebResultsRequested += numResults;
						webOffset += numResults;
					}
					else if (source == "News")
					{
						$("#box"+i).html("<h1><a class=\"verticalLink\" onclick=\"clickedVerticalHeading('" + searchText + "', '" + source + "')\">" + source + " results for <strong>" + searchText + "</strong></a></h1>");
						
						for (var j=newsOffset; j<(numResults+newsOffset); j++)
						{
							if (newsResults[j] != undefined)
							{
								$("#box"+i).append(newsResults[j]);
							}
						}

						numberOfNewsResultsRequested += numResults;
						newsOffset += numResults;
					}
					else if (source == "Image")
					{
						$("#box"+i).html("<h1><a class=\"verticalLink\" onclick=\"clickedVerticalHeading('" + searchText + "', '" + source + "')\">" + source + " results for <strong>" + searchText + "</strong></a></h1>" );
						
						for (var j=imageOffset; j<(numResults+imageOffset); j++)
						{
							if (imageResults[j] != undefined)
							{
								$("#box"+i).append(imageResults[j]);
							}
						}

						numberOfImageResultsRequested += numResults;
						imageOffset += numResults;
					}
					else if (source == "Video")
					{
						$("#box"+i).html("<h1><a class=\"verticalLink\" onclick=\"clickedVerticalHeading('" + searchText + "', '" + source + "')\">" + source + " results for <strong>" + searchText + "</strong></a></h1>" );
						
						for (var j=videoOffset; j<(numResults+videoOffset); j++)
						{
							if (videoResults[j] != undefined)
							{
								$("#box"+i).append(videoResults[j]);
							}
						}

						numberOfVideoResultsRequested += numResults;
						videoOffset += numResults;
					}
				}

				showFavorites();
				showContent("All");
				logInitialResultShown();
			}

			function showFavorites()
			{
				// console.log("in show favorites with: ");
				var favs = $('.favButton');
				// console.log(favs);
				for (var d = 0; d < favs.length; d++) {
					for (var k = 0; k < favoriteBasket.length; k++) 
					{
						if ($(favs[d]).attr('vertical') == "Web" || $(favs[d]).attr('vertical') == "News")
						{
							if ($(favs[d]).parent().children('a.title').attr('href') === favoriteBasket[k].link && $(favs[d]).attr('vertical') === favoriteBasket[k].vertical) 
							{
								$(favs[d]).addClass("unFavButton");
								$(favs[d]).removeClass("favButton");
								break;
							}
						}
						else if ($(favs[d]).attr('vertical') == "Image" || $(favs[d]).attr('vertical') == "Video")
						{
							if ($(favs[d]).parent().children('a.image').attr('uniqueid') === favoriteBasket[k].uID && $(favs[d]).parent().children('a.image').attr('href') === favoriteBasket[k].link && $(favs[d]).attr('vertical') === favoriteBasket[k].vertical) 
							{
								$(favs[d]).addClass("unFavButton");
								$(favs[d]).removeClass("favButton");
								break;
							}
						}
					}
				}
			}
			
			$(document).ready(function() 
			{
				$('.footer').hide();

				initialBoxes = $('.resultContainer').html();

				// favorites
				var json_string = getCookie("basket");
				if (json_string === "") 
				{
					favoriteBasket = [];
				} 
				else 
				{
					favoriteBasket = JSON.parse(json_string);
				}

				// current interface
				var selectedInterfaceJSON = getCookie("currentInterface");
				console.log(selectedInterfaceJSON);
				if (!(selectedInterfaceJSON === ""))
				{
					selectedInterface = JSON.parse(selectedInterfaceJSON);
					setCookie("currentInterface", "", 365);
					
					if (!(selectedInterface == "panel" || selectedInterface == "blended" || selectedInterface == "tabbed"))
					{
						$('.verticalLabel.selected').removeClass('selected');
						$('.verticalLabel#' + selectedInterface).addClass('selected');
						showSingleVertical(selectedInterface);
					}
				}

				$(window).bind('beforeunload', function(){
					// store cookies
					if (!wasFinishClicked)
					{
						var json_strings = JSON.stringify(favoriteBasket);
						setCookie("basket", "", 365);
						setCookie("basket", json_strings, 365);

						var json_interface = JSON.stringify(currentinterface);
						setCookie("currentInterface", "", 365);
						setCookie("currentInterface", json_interface, 365);
					}
					
					// var json_search = JSON.stringify($('#searchText').val());
					// setCookie("searchText", "", 365);
					// setCookie("searchText", json_search, 365);
				});
			
				$("body").on('click', '.verticalLabel', function()
				{
					$('.verticalLabel.selected').removeClass('selected');
					$(this).addClass('selected');
				});

				$("body").on('click', 'a.suggestionLink', function(event)
				{
					event.preventDefault();
					clickedSearchSuggestion($(this).text());
				});

				$("body").on('click', '#submitbutton', function(event)
				{
					event.preventDefault();
					currentPage = 1;
					hideContent();
					if (currentRequest)
					{
						currentRequest.abort();
					}
					var searchQuery = $('#searchText').val();

					logQuery(searchQuery, false);
					search(searchQuery, '<?php echo $number_of_results1 ?>', '<?php echo $number_of_results2 ?>', '<?php echo $number_of_results3 ?>', '<?php echo $number_of_results4 ?>', '<?php echo $source1 ?>','<?php echo $source2 ?>','<?php echo $source3 ?>','<?php echo $source4 ?>', '<?php echo $number_of_sources_requested ?>');	
				});
				
				$(".fancybox").fancybox(
				{
					overlay: 
					{
						locked : false
					},
					iframe: 
					{
						preload : false
					},
					width: 1000,
					height: 1000,
					beforeShow: function()
					{
	        			//Check for X-Frames
						iframe = document.getElementsByTagName('iframe')[0];
						url = iframe.src;

						iframe.setAttribute("sandbox", "allow-forms allow-pointer-lock allow-same-origin allow-scripts");
					
						$.ajax({url: "check-x-frame.php", data: {url: url }, success: function(result)
						{
							console.log(result +": "+ url);
							//If X-Frames restriction, route through YQL
							if(result.trim()=="true")
							{
								iframe.src = "about:blank";
				
								getData = function (data) {
									if (data && data.query && data.query.results && data.query.results.resources && data.query.results.resources.content && data.query.results.resources.status == 200) loadHTML(data.query.results.resources.content);
									else if (data && data.error && data.error.description) loadHTML(data.error.description);
									else loadHTML('Error: Cannot load ' + url);
								};

								loadURL = function (src) {
									url = src;
									var script = document.createElement('script');
									script.src = 'http://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20data.headers%20where%20url%3D%22' + encodeURIComponent(url) + '%22&format=json&diagnostics=true&env=store%3A%2F%2Fdatatables.org%2Falltableswithkeys&callback=getData';
									document.body.appendChild(script);
								};

								loadHTML = function (html) {
									iframe.src = 'about:blank';
									iframe.contentWindow.document.open();				
									iframe.contentWindow.document.write(html.replace(/<head>/i, '<head><base href="' + url + '"><scr' + 'ipt>document.addEventListener("click", function(e) { if(e.target && e.target.nodeName == "A") { e.preventDefault(); parent.loadURL(e.target.href); } });</scr' + 'ipt>'));
									iframe.contentWindow.document.close();
								}

								loadURL(url);
							}
						}});	
	    			},
	    			afterClose: function()
	    			{
	    				logResultIFrameClosed();
	    			}
			   	});

				// search text
				// var searchJSON = getCookie("searchText");
				// if (searchJSON !== "") 
				// {
				// 	var searchText = JSON.parse(searchJSON);
				// 	$('#searchText').val(searchText);
				// }
			});

			function showSuggestionResult(str)
			{
				console.log("showSuggestionResult");
				if (currentRequest)
				{
					currentRequest.abort();
				}

				if (str.length==0)
				{ 
					hideSuggestions();
				    return;
				}
				// only send the request if the text field is in focus
				if($('#searchText').is(":focus"))
				{
					console.log("Think search text is focus");
					currentRequest = $.post("suggestions.php", { searchText: str }).done(function( responseText ) 
					{ 
						console.log(responseText);
						if (responseText.length != 0 && $('#searchText').is(":focus"))
						{
							document.getElementById("livesearch").innerHTML=  responseText;
	      					document.getElementById("livesearch").style.border = "2px solid #333";
						}
					});
				}
			}

			function hideSuggestions()
			{
				document.getElementById("livesearch").innerHTML="";
				document.getElementById("livesearch").style.border="0px";
			}

			function showResult(str)
			{
				console.log("showResult");
				if (timer)
				{
					window.clearTimeout(timer);
				}
				
				timer = window.setTimeout(function()
				{
					showSuggestionResult(str);
				}, 1000);
			}

			//helper methods
			function htmlspecialchars(string)
			{
				return string
				         .replace(/&/g, "&amp;")
				         .replace(/</g, "&lt;")
				         .replace(/>/g, "&gt;")
				         .replace(/"/g, "&quot;")
				         .replace(/'/g, "&#039;");
			}


			$(document).on('click', '.favButton', function()
			{
				vertical = $(this).attr('vertical');

				if (vertical == "Web" || vertical == "News")
				{
					link = $(this).parent().children('a.title').attr('href');
					title = $(this).parent().children('a.title').text();
					snippet= $(this).parent().parent().children('.snippet').text();
					rank = $(this).parent().parent().attr('rank');
					uniqueIdentifier = "N/A";
					thumbnailLink = "N/A";
				}
				else if (vertical == "Image" || vertical == "Video")
				{
					link = $(this).parent().children('a.image').attr('href');
					title = $(this).parent().children('a.image').attr('title');
					snippet= "";
					rank = $(this).parent().attr('rank');
					uniqueIdentifier = $(this).parent().children('a.image').attr('uniqueid'); 
					thumbnailLink = $(this).parent().children('a.image').css('background-image').replace(/^url\(["']?/, '').replace(/["']?\)$/, '');
				}

				timeOfClick = Date.now();

				console.log("Before add: ");
				console.log(favoriteBasket);

				$.ajax({
					type: 'POST',
					url: "currentQuery.php",
					data: {uID: uniqueIdentifier, time: timeOfClick, link: link, thumbnailLink: thumbnailLink, vertical: vertical, title: title, snippet: snippet, rank: rank, currentinterface: currentinterface}
				}).done(function( returnedJSON ) 
				{
					var data = JSON.parse(returnedJSON);
					favoriteBasket.push({ type: 'favorite', uID: data.uID, time: data.time, link: data.link, thumbnailLink: data.thumbnailLink, vertical: data.vertical, title: data.title, snippet: data.snippet, rank: data.rank, currentinterface: data.currentinterface, queryId: data.currentQuery});

					console.log("After add in the ajax return: ");
					console.log(favoriteBasket);
				}); 
				
				console.log("After add: ");
				console.log(favoriteBasket);
				
				$(this).addClass("unFavButton");
				$(this).removeClass("favButton");
			});

			$(document).on('click', '.unFavButton', function()
			{
				console.log("This is: ");
				console.log($(this));
				vertical = $(this).attr('vertical');

				if (vertical == "Web" || vertical == "News")
				{
					link = $(this).parent().children('a.title').attr('href');
					title = $(this).parent().children('a.title').text();
					snippet= $(this).parent().parent().children('.snippet').text();
					rank = $(this).parent().parent().attr('rank');
					uniqueIdentifier = "N/A";
				}
				else if (vertical == "Image" || vertical == "Video")
				{
					link = $(this).parent().children('a.image').attr('href');
					title = $(this).parent().children('a.image').attr('title');
					snippet= "";
					rank = $(this).parent().attr('rank');
					uniqueIdentifier = $(this).parent().children('a.image').attr('uniqueid'); 
				}

				// console.log("Before: ");
				// console.log(favoriteBasket);
				// console.log("removing w/ link: " + link + ", uId: " + uniqueIdentifier + ", vertical: " + vertical + ", title: " + title + ", snippet: " + snippet + ", rank: " + rank);

				$(favoriteBasket).each(function(i, el)
				{
					if (el.type == "favorite" && el.link == link && el.uID == uniqueIdentifier && el.vertical == vertical && el.title == title && el.snippet == snippet && el.rank == rank)
					{
						favoriteBasket.splice(i, 1);
					}
				});

				// console.log("After: ");
				// console.log(favoriteBasket);

				$(this).addClass("favButton");
				$(this).removeClass("unFavButton");
			});

			/************* Logging ***************/
			
			$(document).on('click contextmenu', 'a', function()
			{
				// console.log("In click");
				link = $(this).attr('href');
				vertical = $(this).attr('vertical');

				if(vertical != undefined && !($(this).hasClass('relevant')))
				{
					if (vertical == "Web" || vertical == "News")
					{
						title = $(this).text();
						snippet= $(this).parent().parent().children('.snippet').text();
						rank = $(this).parent().parent().attr('rank');
					}
					else if (vertical == "Image" || vertical == "Video")
					{
						title = $(this).attr('title');
						snippet= "";
						rank = $(this).parent().attr('rank');
					}

					openLink["link"] = link;
					openLink["vertical"] = vertical;
					openLink["title"] = title;
					openLink["snippet"] = snippet;

					var request = $.ajax({
						type: 'POST',
						url: 'Log.php',
					  	data: { type: 'link', link: link, vertical: vertical, title: title, snippet: snippet, rank: rank, currentinterface: currentinterface},
					  	dataType: "html"
					});

					request.done(function( msg ) 
					{
					});
				}
			});

			$(document).on('click', '#finish', function()
			{
				console.log("got finish click with fav basket length: " + favoriteBasket.length);
				for (var i = 0; i < favoriteBasket.length; i++) 
				{
					var request = $.ajax({
					  type: 'POST',
					  url: 'Log.php',
					  data: { type: "favorite", link: favoriteBasket[i].link, thumbnailLink: favoriteBasket[i].thumbnailLink, uID: favoriteBasket[i].uID, time: favoriteBasket[i].time, vertical: favoriteBasket[i].vertical, title: favoriteBasket[i].title, snippet: favoriteBasket[i].snippet, rank: favoriteBasket[i].rank, currentinterface: favoriteBasket[i].currentinterface, queryId: favoriteBasket[i].queryId},
					  dataType: "html"
					});
					request.done(function( msg ) 
					{
						console.log("response: " + msg);
					});
				}

				wasFinishClicked = true;
				setCookie("basket", "", 365);
				setCookie("currentInterface", "", 365);
				// setCookie("searchText", "", 365);
				
				window.location.href = "studyManager.php";
			});	

			function logResultIFrameClosed()
			{
				link = openLink["link"];
				vertical = openLink["vertical"];
				title = openLink["title"];
				snippet= openLink["snippet"];

				var request = $.ajax({
					type: 'POST',
					url: 'Log.php',
				  	data: { type: 'link_close', link: link, vertical: vertical, title: title, snippet: snippet},
				  	dataType: "html"
				});

				request.done(function( msg ) 
				{
					console.log("Logged close with: " + msg);
					openLink = {};
					console.log("here:" + openLink["link"]);
				});
			}

			function logNavigationChange(type, previousinterface, currentinterface, page)
			{
				var request = $.ajax({
				  type: 'POST',
				  url: 'Log.php',
				  data: { type: 'nav', page: page, navType: type, previousinterface: previousinterface, currentinterface: currentinterface},
				  dataType: "html"
				});

				request.done(function( msg ) {
				});
			}

			function logQuery(searchQuery, isSuggestion)
			{
				var request = $.ajax({
				  type: 'POST',
				  url: 'Log.php',
				  data: { type: 'query', searchQuery: searchQuery, currentinterface: currentinterface, suggestion: isSuggestion},
				  dataType: "html"
				});

				request.done(function( msg ) {
					console.log("Log query: " + msg);
				});
			}

			function logInitialResultShown()
			{
				var request = $.ajax({
				  type: 'POST',
				  url: 'Log.php',
				  data: { type: 'results_shown'},
				  dataType: "html"
				});

				request.done(function( msg ) {
					console.log("in done with: " + msg);
				});
			}

			/********* End Logging *************/
			
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
				<?php
				if($_SESSION['taskId'] === 0)
				{
					echo "<span class=practiceTaskDisplay>This is a Practice Task</span>";
					echo "<br/>";
				}

				echo "<span class=taskDisplay><u>Task Description</u>:&nbsp;";

				if($_SESSION['taskText'])
				{
					echo htmlspecialchars($_SESSION['taskText']);
				}
				
				echo "</span>";

				echo "<a id='finish' href='#'>Finish Task</a>";

				?>

				<form id="searchForm">
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

						<input type="text" style="width:500px;" id="searchText" autocomplete="off" name="searchText" onkeyup="showResult(this.value)">
						<input type="submit" id='submitbutton' value="Search" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
						<div id="livesearch"></div>

						<br/><br/>	
						<div class="links">
							<?php
								if (!($_SESSION['interface'] == 'tabbed'))
								{
									echo('<input type="button" class="verticalLabel selected" value="All" onclick="clickedSingleVertical(\'All\')">');
									echo('<input id="Web" type="button" name="source1" class="verticalLabel" value="Web" onclick="clickedSingleVertical(\'Web\')">');
								}
								else
								{
									echo('<input id="Web" type="button" name="source1" class="verticalLabel selected" value="Web" onclick="clickedSingleVertical(\'Web\')">');
								}
							?>
							<input id="Image" type="button" name="source1" class="verticalLabel" value="Image" onclick="clickedSingleVertical('Image')">
							<input id="Video" type="button" name="source1" class="verticalLabel" value="Video" onclick="clickedSingleVertical('Video')">
							<input id="News" type="button" name="source1" class="verticalLabel" value="News" onclick="clickedSingleVertical('News')">
						</div>
					</div>
				</form>
			</div>
			<img id="loading" src="ajax-loader.gif" style="display: none;"/>

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
							echo "<div id='box" . $i . "' class='webResults vertical' vertical='Web'></div>";
						}
						else if ($currentSource == "Image")
						{
							echo "<div id='box" . $i . "' class='imageResults vertical' vertical='Image'></div>";
						}
						else if ($currentSource == "Video")
						{
							echo "<div id='box" . $i . "' class='videoResults vertical' vertical='Video'></div>";
						}
						else if ($currentSource == "News")
						{
							echo "<div id='box" . $i . "' class='newsResults vertical' vertical='News'></div>";
						}
					}
				?>
			</div>
		</div>

		<div class="footer">
			<ul class="pagination">
			  <li><a class="prev disabled" onclick="showPreviousWebResults()" >«</a></li>
			  <li><a class="active" onclick="showPageOfWebResults(this)">1</a></li>
			  <li><a onclick="showPageOfWebResults(this)">2</a></li>
			  <li><a onclick="showPageOfWebResults(this)">3</a></li>
			  <li><a onclick="showPageOfWebResults(this)">4</a></li>
			  <li><a onclick="showPageOfWebResults(this)">5</a></li>
			  <li><a onclick="showPageOfWebResults(this)">6</a></li>
			  <li><a onclick="showPageOfWebResults(this)">7</a></li>
			  <li><a class="next" onclick="showNextWebResults()">»</a></li>
			</ul>
		</div>
	</body>
</html>
