<?php
	$request = array("type" => $_GET['type'],
					 "s_date" => intval($_GET['s_date']),
					 "e_date" => intval($_GET['e_date']),
					 "location" => $_GET['location']);
					 
	require('arrays.php');
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
            <!--<div class="col-md-offset-3 col-md-2">-->
	    <div class="col-md-offset-4 col-md-2">
                <select class="form-control" name="type">
                    <option selected value="<?php echo $request['type']; ?>"><?php echo $request['type']; ?></option>
                    <option value="Literacy">Literacy</option>
                    <!--<option value="Emotion">Emotion</option>-->
                    <option value="EmojiFreq">Emoji Frequency</option>
                    <option value="HashFreq">Hashtag Frequency</option>
                </select>
            </div>
	    <!--
            <div class="col-md-2">
                <select class="form-control" name="s_date">
                    <option selected value="<?php echo $request['s_date']; ?>"><?php echo $months[$request['s_date']]; ?></option>
                    <option value="2">February</option>
                    <option value="3">March</option>
                    <option value="4">April</option>
                </select><br />
                <select class="form-control" name="e_date">
                    <option selected value="<?php echo $request['e_date']; ?>"><?php echo $months[$request['e_date']]; ?></option>
                    <option value="2">February</option>
                    <option value="3">March</option>
                    <option value="4">April</option>
                </select>
            </div>
	    -->
            <div class="col-md-2">
                <select class="form-control" name="location">
                    <option selected value="<?php echo $request['location']; ?>"><?php echo $us_state_abbrevs_names[$request['location']]; ?></option>
                    <option value="ALL">U.S.A.</option>
                    <option value="DEN">Denver</option>
                    <option value="NYC">New York City</option>
                    <option value="NOR">New Orleans</option>
                    <option value="OAK">Oakland</option>
                    <option value="DET">Detroit</option>
                    <!--<option value="ALL">Entire U.S.</option>
                    <option value="AL">Alabama</option> 
                    <option value="AK">Alaska</option> 
                    <option value="AZ">Arizona</option> 
                    <option value="AR">Arkansas</option> 
                    <option value="CA">California</option> 
                    <option value="CO">Colorado</option> 
                    <option value="CT">Connecticut</option> 
                    <option value="DE">Delaware</option>
                    <option value="FL">Florida</option> 
                    <option value="GA">Georgia</option> 
                    <option value="HI">Hawaii</option> 
                    <option value="ID">Idaho</option> 
                    <option value="IL">Illinois</option> 
                    <option value="IN">Indiana</option> 
                    <option value="IA">Iowa</option> 
                    <option value="KS">Kansas</option> 
                    <option value="KY">Kentucky</option> 
                    <option value="LA">Louisiana</option> 
                    <option value="ME">Maine</option> 
                    <option value="MD">Maryland</option> 
                    <option value="MA">Massachusetts</option> 
                    <option value="MI">Michigan</option> 
                    <option value="MN">Minnesota</option> 
                    <option value="MS">Mississippi</option> 
                    <option value="MO">Missouri</option> 
                    <option value="MT">Montana</option> 
                    <option value="NE">Nebraska</option> 
                    <option value="NV">Nevada</option> 
                    <option value="NH">New Hampshire</option> 
                    <option value="NJ">New Jersey</option> 
                    <option value="NM">New Mexico</option> 
                    <option value="NY">New York</option> 
                    <option value="NC">North Carolina</option> 
                    <option value="ND">North Dakota</option> 
                    <option value="OH">Ohio</option> 
                    <option value="OK">Oklahoma</option> 
                    <option value="OR">Oregon</option> 
                    <option value="PA">Pennsylvania</option> 
                    <option value="RI">Rhode Island</option> 
                    <option value="SC">South Carolina</option> 
                    <option value="SD">South Dakota</option> 
                    <option value="TN">Tennessee</option> 
                    <option value="TX">Texas</option> 
                    <option value="UT">Utah</option> 
                    <option value="VT">Vermont</option> 
                    <option value="VA">Virginia</option> 
                    <option value="WA">Washington</option> 
                    <option value="WV">West Virginia</option> 
                    <option value="WI">Wisconsin</option> 
                    <option value="WY">Wyoming</option>-->
                </select>
            </div>
        </div>
        <br />
        <div class="row">
            <div class="col-md-offset-5 col-md-2" style="text-align: center;">
                <button type="submit" class="btn btn-success">Get Map</button>
            </div>
        </div>
        </form>
        
        
        <!-- MAP GOES HERE -->
        <div class="row">
        	<div class="col-md-offset-1 col-md-10">
                <div id="wrapper">
                    <div class="chart">
                        <h2>Population of endangered species from 2012 &ndash; 2016</h2>
                        <table id="data-table" border="1" cellpadding="10" cellspacing="0" summary="The effects of the zombie outbreak on the populations of endangered species from 2012 to 2016">
                            <caption>Population in thousands</caption>
                            <thead>
                                <tr>
                                    <td>&nbsp;</td>
                                    <th scope="col">2012</th>
                                    <th scope="col">2013</th>
                                    <th scope="col">2014</th>
                                    <th scope="col">2015</th>
                                    <th scope="col">2016</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">Carbon Tiger</th>
                                    <td>4080</td>
                                    <td>6080</td>
                                    <td>6240</td>
                                    <td>3520</td>
                                    <td>2240</td>
                                </tr>
                                <tr>
                                    <th scope="row">Blue Monkey</th>
                                    <td>5680</td>
                                    <td>6880</td>
                                    <td>5760</td>
                                    <td>5120</td>
                                    <td>2640</td>
                                </tr>
                                <tr>
                                    <th scope="row">Tanned Zombie</th>
                                    <td>1040</td>
                                    <td>1760</td>
                                    <td>2880</td>
                                    <td>4720</td>
                                    <td>7520</td>
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