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
        "Maimi",
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
    <script src="js/graph.js"></script>
    <?php
        if(!in_array($request, $cities)) {
            echo "<script type=\"text/javascript\">\$(document).ready(function(e) {\$('#wrapper').css('display', 'none');});</script>";
        }
        // Display graph
        else {
            $m = new MongoClient('localhost');
            $db = $m->selectDB("test");
        }
    ?>
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
                <option value="Maimi">Maimi</option>
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