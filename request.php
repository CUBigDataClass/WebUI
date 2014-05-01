<?php
	$request = $_GET['city'];

    $cities = array(
        "New York",
        "Los Angeles",
        "Chicago",
        "Dallas",
        "Houston",
        "Philadelphia",
        "Washington",
        "Miami",
        "Atlanta",
        "Boston",
        "San Francisco",
        "Phoenix",
        "Riverside",
        "Detroit",
        "Seattle",
        "Minneapolis",
        "San Diego",
        "Tampa",
        "St Louis",
        "Baltimore",
        "Denver",
        "Pittsburgh",
        "Charlotte",
        "Portland",
        "San Antonio",
        "Orlando",
        "Sacramento",
        "Cincinnati",
        "Cleveland",
        "Kansas City",
    );
	?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Twitter EmotiMap</title>
    
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="css/graph.css" rel="stylesheet">
    <link rel="shortcut icon" href="favicon.ico" />
    <script src="http://code.jquery.com/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <?php
        if(!in_array($request, $cities)) {
            echo "<script type=\"text/javascript\">\$(document).ready(function(e) {\$('#wrapper').css('display', 'none');});</script>";
        }
        // Display graph
        else {
            $m = new Mongo("mongodb://54.186.147.213");
            $db = $m->test;
            $collection = $db->WordCount;

            // Get the city
            $query = array('city' => $request);
            $cursor = $collection->find($query);

            if($cursor->hasNext()) {
                $tweet = $cursor->getNext();
            }
        }
    ?>
    <script type="text/javascript">
        /**
         *  Animated Graph Tutorial for Smashing Magazine
         *  July 2011
         *   
         *  Author: Derek Mack
         *          derekmack.com
         *          @derek_mack
         *
         *  Example 4 - Animated Bar Chart via CSS Transitions (WebKit Only)
         */

         <?php
            if(isset($tweet)) {
                echo "var tweet = " . $tweet . ";";
            }
            else {
                echo "//No DB Found\nvar tweet = null;";
            }
         ?>

        // Wait for the DOM to load everything, just to be safe
        
        /* Sample Tweet
        var tweet = {
          "city" : "Denver",
          "data" : [
            {"word" : "poop",
             "count" : 4},
            {"word" : "mountain",
             "count" : 3},
            {"word" : "13",
             "count" : 1},
            {"word" : "days",
             "count" : 1},
            {"word" : "denver",
             "count" : 2},
            {"word" : "da",
             "count" : 1},
            {"word" : "till",
             "count" : 1},
            {"word" : "matt",
             "count" : 5},
            {"word" : "braces",
             "count" : 1},
            {"word" : "nud",
             "count" : 12},
            {"word" : "kepler",
             "count" : 3},
            {"word" : "retard",
             "count" : 1},
            {"word" : "Conrad",
             "count" : 5},
            {"word" : "ultimate",
             "count" : 8},
            {"word" : "mamabird",
             "count" : 5},
            {"word" : "veins",
             "count" : 1},
            {"word" : "twerk",
             "count" : 2},
            {"word" : "cocaine",
             "count" : 6},
            {"word" : "nigga",
             "count" : 10},
            {"word" : "cumquat",
             "count" : 4},
            ]
        };*/

        function populateGraph(tweetData) {
            $('#g_t').text(tweetData['city']);
            for(var i = 1; i < 21; i++) {
                $('#t' + i.toString()).text(tweetData['data'][i-1]['word']);
                $('#v' + i.toString()).text(tweetData['data'][i-1]['count']);
            }
        };

        $(document).ready(function() {

            // Populate data
            if(tweet != null)
            populateGraph(tweet);

            // Create our graph from the data table and specify a container to put the graph in
            createGraph('#data-table', '.chart');
            
            // Here be graphs
            function createGraph(data, container) {
                // Declare some common variables and container elements 
                var bars = [];
                var figureContainer = $('<div id="figure"></div>');
                var graphContainer = $('<div class="graph"></div>');
                var barContainer = $('<div class="bars"></div>');
                var data = $(data);
                var container = $(container);
                var chartData;      
                var chartYMax;
                var columnGroups;
                
                // Timer variables
                var barTimer;
                var graphTimer;
                
                // Create table data object
                var tableData = {
                    // Get numerical data from table cells
                    chartData: function() {
                        var chartData = [];
                        data.find('tbody td').each(function() {
                            chartData.push($(this).text());
                        });
                        return chartData;
                    },
                    // Get heading data from table caption
                    chartHeading: function() {
                        var chartHeading = data.find('caption').text();
                        return chartHeading;
                    },
                    // Get legend data from table body
                    chartLegend: function() {
                        var chartLegend = [];
                        // Find th elements in table body - that will tell us what items go in the main legend
                        data.find('tbody th').each(function() {
                            chartLegend.push($(this).text());
                        });
                        return chartLegend;
                    },
                    // Get highest value for y-axis scale
                    chartYMax: function() {
                        var chartData = this.chartData();
                        // Round off the value
                        var chartYMax = Math.ceil(Math.max.apply(Math, chartData));
                        return chartYMax;
                    },
                    // Get y-axis data from table cells
                    yLegend: function() {
                        var chartYMax = this.chartYMax();
                        var yLegend = [];
                        // Number of divisions on the y-axis
                        var yAxisMarkings = 5;                      
                        // Add required number of y-axis markings in order from 0 - max
                        for (var i = 0; i < yAxisMarkings; i++) {
                            yLegend.unshift(((chartYMax * i) / (yAxisMarkings - 1)));
                        }
                        return yLegend;
                    },
                    // Get x-axis data from table header
                    xLegend: function() {
                        var xLegend = [];
                        // Find th elements in table header - that will tell us what items go in the x-axis legend
                        data.find('thead th').each(function() {
                            xLegend.push($(this).text());
                        });
                        return xLegend;
                    },
                    // Sort data into groups based on number of columns
                    columnGroups: function() {
                        var columnGroups = [];
                        // Get number of columns from first row of table body
                        var columns = data.find('tbody tr:eq(0) td').length;
                        for (var i = 0; i < columns; i++) {
                            columnGroups[i] = [];
                            data.find('tbody tr').each(function() {
                                columnGroups[i].push($(this).find('td').eq(i).text());
                            });
                        }
                        return columnGroups;
                    }
                }
                
                // Useful variables for accessing table data        
                chartData = tableData.chartData();      
                chartYMax = tableData.chartYMax();
                columnGroups = tableData.columnGroups();
                
                // Construct the graph
                
                // Loop through column groups, adding bars as we go
                $.each(columnGroups, function(i) {
                    // Create bar group container
                    var barGroup = $('<div class="bar-group"></div>');
                    // Add bars inside each column
                    for (var j = 0, k = columnGroups[i].length; j < k; j++) {
                        // Create bar object to store properties (label, height, code etc.) and add it to array
                        // Set the height later in displayGraph() to allow for left-to-right sequential display
                        var barObj = {};
                        barObj.label = this[j];
                        barObj.height = Math.floor(barObj.label / chartYMax * 100) + '%';
                        barObj.bar = $('<div class="bar fig' + j + '"><span>' + barObj.label + '</span></div>')
                            .appendTo(barGroup);
                        bars.push(barObj);
                    }
                    // Add bar groups to graph
                    barGroup.appendTo(barContainer);        
                });
                
                // Add heading to graph
                var chartHeading = tableData.chartHeading();
                var heading = $('<h4>' + chartHeading + '</h4>');
                heading.appendTo(figureContainer);
                
                // Add legend to graph
                var chartLegend = tableData.chartLegend();
                var legendList  = $('<ul class="legend"></ul>');
                $.each(chartLegend, function(i) {           
                    var listItem = $('<li><span class="icon fig' + i + '"></div></span>' + this + '</li>')
                        .appendTo(legendList);
                });
                legendList.appendTo(figureContainer);
                
                // Add x-axis to graph
                var xLegend = tableData.xLegend();      
                var xAxisList   = $('<ul class="x-axis"></ul>');
                $.each(xLegend, function(i) {           
                    var listItem = $('<li><span>' + this + '</span></li>')
                        .appendTo(xAxisList);
                });
                xAxisList.appendTo(graphContainer);
                
                // Add y-axis to graph  
                var yLegend = tableData.yLegend();
                var yAxisList   = $('<ul class="y-axis"></ul>');
                $.each(yLegend, function(i) {           
                    var listItem = $('<li><span>' + this + '</span></li>')
                        .appendTo(yAxisList);
                });
                yAxisList.appendTo(graphContainer);     
                
                // Add bars to graph
                barContainer.appendTo(graphContainer);      
                
                // Add graph to graph container     
                graphContainer.appendTo(figureContainer);
                
                // Add graph container to main container
                figureContainer.appendTo(container);
                
                // Set individual height of bars
                function displayGraph(bars, i) {
                    // Changed the way we loop because of issues with $.each not resetting properly
                    if (i < bars.length) {
                        // Add transition properties and set height via CSS
                        $(bars[i].bar).css({'height': bars[i].height, '-webkit-transition': 'all 0.8s ease-out'});
                        // Wait the specified time then run the displayGraph() function again for the next bar
                        barTimer = setTimeout(function() {
                            i++;                
                            displayGraph(bars, i);
                        }, 100);
                    }
                }
                
                // Reset graph settings and prepare for display
                function resetGraph() {
                    // Set bar height to 0 and clear all transitions
                    $.each(bars, function(i) {
                        $(bars[i].bar).stop().css({'height': 0, '-webkit-transition': 'none'});
                    });
                    
                    // Clear timers
                    clearTimeout(barTimer);
                    clearTimeout(graphTimer);
                    
                    // Restart timer        
                    graphTimer = setTimeout(function() {        
                        displayGraph(bars, 0);
                    }, 200);
                }
                
                // Helper functions
                
                // Call resetGraph() when button is clicked to start graph over
                $('#reset-graph-button').click(function() {
                    resetGraph();
                    return false;
                });
                
                // Finally, display graph via reset function
                resetGraph();
            }   
        });
    </script>
    </head>
    <body>
    <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
      <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Twitter EmotiMap</a>
        </div>
    
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <ul class="nav navbar-nav">
            <li><a href="index.html">Home</a></li>
            <li><a href="about.html">About</a></li>
            <li class="active"><a href="stats.html">Map</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">More <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="proposal.html">Project Text</a></li>
                <li class="divider"></li>
                <li><a href="matt.html">Matt Gross</a></li>
                <li><a href="max.html">Max Trotter</a></li>
                <li><a href="brian.html">Brian McWilliams</a></li>
                <li><a href="andrew.html">Andrew Mahan</a></li>
                <li><a href="dillon.html">Dillon Fancher</a></li>
              </ul>
            </li>
          </ul>
          <!--<form class="navbar-form navbar-left" role="search">
            <div class="form-group">
              <input type="text" class="form-control" placeholder="Search">
            </div>
            <button type="submit" class="btn btn-default">Submit</button>
          </form>
          <ul class="nav navbar-nav navbar-right">
            <li><a href="#">Link</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="#">Action</a></li>
                <li><a href="#">Another action</a></li>
                <li><a href="#">Something else here</a></li>
                <li class="divider"></li>
                <li><a href="#">Separated link</a></li>
              </ul>
            </li>
          </ul>-->
        </div><!-- /.navbar-collapse -->
      </div><!-- /.container-fluid -->
    </nav>
    
    <div class="container-fluid" style="margin-top: 70px;">
        <form method="get" action="request.php#map">
    <div class="row">
        <div class="col-md-offset-5 col-md-2">
            <select class="form-control" name="city">
                <option disabled selected value="">City</option>
                <option value="New York">New York</option>
                <option value="Los Angeles">Los Angeles</option>
                <option value="Chicago">Chicago</option>
                <option value="Dallas">Dallas</option>
                <option value="Houston">Houston</option>
                <option value="Philadelphia">Philadelphia</option>
                <option value="Washington">Washington</option>
                <option value="Miami">Miami</option>
                <option value="Atlanta">Atlanta</option>
                <option value="Boston">Boston</option>
                <option value="San Francisco">San Francisco</option>
                <option value="Phoenix">Phoenix</option>
                <option value="Riverside">Riverside</option>
                <option value="Detroit">Detroit</option>
                <option value="Seattle">Seattle</option>
                <option value="Minneapolis">Minneapolis</option>
                <option value="San Diego">San Diego</option>
                <option value="Tampa">Tampa</option>
                <option value="St Louis">St Louis</option>
                <option value="Baltimore">Baltimore</option>
                <option value="Denver">Denver</option>
                <option value="Pittsburgh">Pittsburgh</option>
                <option value="Charlotte">Charlotte</option>
                <option value="Portland">Portland</option>
                <option value="San Antonio">San Antonio</option>
                <option value="Orlando">Orlando</option>
                <option value="Sacramento">Sacramento</option>
                <option value="Cincinnati">Cincinnati</option>
                <option value="Cleveland">Cleveland</option>
                <option value="Kansas City">Kansas City</option>
            </select>
        </div>
    </div>
    <br />
    <div class="row">
        <div class="col-md-offset-5 col-md-2" style="text-align: center;">
            <button type="submit" class="btn btn-success">Find Word Count</button>
        </div>
    </div>
    </form>
        
        
        <!-- MAP GOES HERE -->
        <div class="row">
        	<div class="col-md-offset-1 col-md-10">
                <div id="wrapper">
                    <div class="chart">
                        <h2 id="g_t"></h2>
                        <table id="data-table" border="1" cellpadding="10" cellspacing="0" summary="The effects of the zombie outbreak on the populations of endangered species from 2012 to 2016">
                            <caption>Word Count</caption>
                            <thead>
                                <tr>
                                    <td>&nbsp;</td>
                                    <!--<th scope="col" id="t1"></th>
                                    <th scope="col" id="t2"></th>
                                    <th scope="col" id="t3"></th>
                                    <th scope="col" id="t4"></th>
                                    <th scope="col" id="t5"></th>
                                    <th scope="col" id="t6"></th>
                                    <th scope="col" id="t7"></th>
                                    <th scope="col" id="t8"></th>
                                    <th scope="col" id="t9"></th>
                                    <th scope="col" id="t10"></th>-->
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row" id="t1"></th>
                                    <td id="v1"></td>
                                </tr>
                                <tr>
                                    <th scope="row" id="t2"></th>
                                    <td id="v2"></td>
                                </tr>
                                <tr>
                                    <th scope="row" id="t3"></th>
                                    <td id="v3"></td>
                                </tr>
                                <tr>
                                    <th scope="row" id="t4"></th>
                                    <td id="v4"></td>
                                </tr>
                                <tr>
                                    <th scope="row" id="t5"></th>
                                    <td id="v5"></td>
                                </tr>
                                <tr>
                                    <th scope="row" id="t6"></th>
                                    <td id="v6"></td>
                                </tr>
                                <tr>
                                    <th scope="row" id="t7"></th>
                                    <td id="v7"></td>
                                </tr>
                                <tr>
                                    <th scope="row" id="t8"></th>
                                    <td id="v8"></td>
                                </tr>
                                <tr>
                                    <th scope="row" id="t9"></th>
                                    <td id="v9"></td>
                                </tr>
                                <tr>
                                    <th scope="row" id="t10"></th>
                                    <td id="v10"></td>
                                </tr>
                                <tr>
                                    <th scope="row" id="t11"></th>
                                    <td id="v11"></td>
                                </tr>
                                <tr>
                                    <th scope="row" id="t12"></th>
                                    <td id="v12"></td>
                                </tr>
                                <tr>
                                    <th scope="row" id="t13"></th>
                                    <td id="v13"></td>
                                </tr>
                                <tr>
                                    <th scope="row" id="t14"></th>
                                    <td id="v14"></td>
                                </tr>
                                <tr>
                                    <th scope="row" id="t15"></th>
                                    <td id="v15"></td>
                                </tr>
                                <tr>
                                    <th scope="row" id="t16"></th>
                                    <td id="v16"></td>
                                </tr>
                                <tr>
                                    <th scope="row" id="t17"></th>
                                    <td id="v17"></td>
                                </tr>
                                <tr>
                                    <th scope="row" id="t18"></th>
                                    <td id="v18"></td>
                                </tr>
                                <tr>
                                    <th scope="row" id="t19"></th>
                                    <td id="v19"></td>
                                </tr>
                                <tr>
                                    <th scope="row" id="t20"></th>
                                    <td id="v20"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
    
    </body>
    </html>