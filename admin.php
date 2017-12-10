<?php
include insert_ac.php;
include delete.php;
include conf.php;

mysql_connect( 'localhost', 'tylerguy_tyler', 'tylerguy!!!');
mysql_select_db( 'tylerguy_uark');

$sqltable=Actor;
$sql=( 'SELECT * FROM ' . $sqltable . ' order by actorId');
$records=mysql_query($sql);



echo "<link rel='stylesheet' type='text/css' href='https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css'/>";
echo "<link rel='stylesheet' type='text/css' href='https://tylerguy.com/uark/stylesheet.css'/>";
echo "<script type='text/javascript' src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js'></script>";
echo "<script type='text/javascript' src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>";
echo "<script type='text/javascript' src='https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js'></script>";
echo "<script type='text/javascript' src='https://tylerguy.com/uark/menu.js'></script>";


?>

<!DOCTYPE html>
<html>
<style>
	      .fa {
            color: grey;
        }
        #mytable {
            width: 100%;
        }
        #mytable td {
            font-weight: normal;
            font-size: 1em;
            -webkit-box-shadow: 0 2px 2px -2px #0E1119;
            -moz-box-shadow: 0 2px 2px -2px #0E1119;
            box-shadow: 0 2px 2px -2px #0E1119;
        }
        #mytable th {
            -webkit-box-shadow: 0 2px 2px -2px #0E1119;
            -moz-box-shadow: 0 2px 2px -2px #0E1119;
            color: grey;
            border-collapse: separate;
            border-spacing: 50px 0;
            background-color: #f5f6f7;
            border: solid 1px #b4b6bd;
            border-radius: 5px;
            box-sizing: border-box;
            color: #767c8b;
            font: 18px/22px arial;
            height: 55px;
            margin: 10px 0 9px 14px;
            outline: 0;
            padding-left: 18px;
            transition: box-shadow 0.4s ease;
        }
        th:nth-child(1) {
            width: 10px!important;
        }
        .container td {
            font-weight: normal;
            font-size: 1em;
            -webkit-box-shadow: 0 2px 2px -2px #0E1119;
            -moz-box-shadow: 0 2px 2px -2px #0E1119;
            box-shadow: 0 2px 2px -2px #0E1119;
        }
        .container {
            text-align: left;
            overflow: hidden;
            margin: 0 auto;
            display: table;
            padding: 0 0 8em 0;
        }
        .container td,
        .container th {
            padding-bottom: 2%;
            padding-top: 2%;
            padding-left: 2%;
        }
        #myInput {
            background-image: url('/css/searchicon.png');
            /* Add a search icon to input */

            background-repeat: no-repeat;
            /* Do not repeat the icon image */

            width: 100%;
            /* Full-width */

            font-size: 14px;
            /* Increase font-size */

            padding: 12px 20px 12px 40px;
            /* Add some padding */

            border: 1px solid #ddd;
            /* Add a grey border */
        }
        input {
            outline: none;
        }
        input[type=search] {
            -webkit-appearance: textfield;
            -webkit-box-sizing: content-box;
            font-family: inherit;
            font-size: 100%;
        }
        input::-webkit-search-decoration,
        input::-webkit-search-cancel-button {
            display: none!important;
        }
        input[type=search] {
            background: #ededed url(https://static.tumblr.com/ftv85bp/MIXmud4tx/search-icon.png) no-repeat 9px center;
            !important border: solid 1px #ccc!important;
            padding: 9px 10px 9px 32px!important;
            width: 55px!important;
            -webkit-border-radius: 10em!important;
            -moz-border-radius: 10em!important;
            border-radius: 10em!important;
            -webkit-transition: all .5s!important;
            -moz-transition: all .5s!important;
            transition: all .5s!important;
        }
        input[type=search]:focus {
            width: 130px!important;
            background-color: #fff!important;
            border-color: #66CC75!important;
            -webkit-box-shadow: 0 0 5px rgba(109, 207, 246, .5)!important;
            -moz-box-shadow: 0 0 5px rgba(109, 207, 246, .5)!important;
            box-shadow: 0 0 5px rgba(109, 207, 246, .5)!important;
        }
        input:-moz-placeholder {
            color: #999!important;
        }
        input::-webkit-input-placeholder {
            color: #999!important;
        }
        #demo-2 input[type=search] {
            width: 15px!important;
            padding-left: 10px!important;
            color: transparent!important;
            cursor: pointer!important;
        }
        #demo-2 input[type=search]:hover {
            background-color: #fff!important;
        }
        #demo-2 input[type=search]:focus {
            width: 150px!important;
            padding-left: 32px!important;
            color: #000!important;
            background-color: #fff!important;
            cursor: auto!important;
        }
        #demo-2 input:-moz-placeholder {
            color: transparent!important;
        }
        #demo-2 input::-webkit-input-placeholder {
            color: transparent!important;
        }
        /**
	* Eric Meyer's Reset CSS v2.0 (https://meyerweb.com/eric/tools/css/reset/)
	* https://cssreset.com
	*/

        html,
        body,
        div,
        span,
        applet,
        object,
        iframe,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        p,
        blockquote,
        pre,
        a,
        abbr,
        acronym,
        address,
        big,
        cite,
        code,
        del,
        dfn,
        em,
        img,
        ins,
        kbd,
        q,
        s,
        samp,
        small,
        strike,
        strong,
        sub,
        sup,
        tt,
        var,
        b,
        u,
        i,
        center,
        dl,
        dt,
        dd,
        ol,
        ul,
        li,
        fieldset,
        form,
        label,
        legend,
        table,
        caption,
        tbody,
        tfoot,
        thead,
        tr,
        th,
        td,
        article,
        aside,
        canvas,
        details,
        embed,
        figure,
        figcaption,
        footer,
        header,
        hgroup,
        menu,
        nav,
        output,
        ruby,
        section,
        summary,
        time,
        mark,
        audio,
        video {
            margin: 0;
            padding: 0;
            border: 0;
            font-size: 100%;
            font: inherit;
            vertical-align: baseline;
        }
        h1 {
            font-variant: all-petite-caps;
        }
        /* HTML5 display-role reset for older browsers */

        article,
        aside,
        details,
        figcaption,
        figure,
        footer,
        header,
        hgroup,
        menu,
        nav,
        section {
            display: block;
        }
        body {
            line-height: 1;
        }
        ol,
        ul {
            list-style: none;
        }
        blockquote,
        q {
            quotes: none;
        }
        blockquote:before,
        blockquote:after,
        q:before,
        q:after {
            content: '';
            content: none;
        }
        /* Reset End */

        body {
            background: url("https://www.tylerguy.com/uark/bg1.jpg") no-repeat center center fixed;
            background-size: cover;
        }

        .container:before {
            content: url('https://www.tylerguy.com/uark/ark-logo-left.png');
            display: table;
            margin: 0 auto;
            height: 70px;
    		object-fit: contain;
            transform: scale(0.5, 0.5);
-ms-transform: scale(0.5, 0.5);
-webkit-transform: scale(0.5, 0.5);
        }
        #loginform {
            background: #e1e3e8;
            border: solid 1px #fff;
            border-radius: 5px;
            box-shadow: 0 0 7px -1px rgba(0, 0, 0, 0.4);
            height: 75px;
            margin: 20px auto 20px;
            position: relative;
            width: 800px;
        }
        .login-username .input {
            margin-left: 14px;
        }
        .input {
            background-color: #f5f6f7;
            border: solid 1px #b4b6bd;
            border-radius: 5px;
            box-sizing: border-box;
            color: #767c8b;
            font: 18px/22px arial;
            height: 55px;
            margin: 10px 0 9px 14px;
            outline: 0;
            padding-left: 18px;
            transition: box-shadow 0.4s ease;
            width: 248px;
        }
        .input:focus {
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
        }
        .login-password .input {
            margin-right: 14px;
        }
        .button-primary {
            background-color: #ff6600;
            border: solid 1px transparent;
            border-radius: 0 6px 6px 0;
            box-shadow: 0 0 7px -1px rgba(0, 0, 0, 0.5);
            color: #fff;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            height: 52px;
            left: 800px;
            margin: 12px 0 0 1px;
            outline: none;
            position: absolute;
            text-align: center;
            text-shadow: 0 0 1px #000;
            transition: box-shadow 0.5s ease, text-shadow 0.5s 0.3s;
        }
        .button-primary:hover {
            text-shadow: 0 0 1px rgba(255, 255, 255, 0.8);
            box-shadow: 0 0 7px -1px rgba(0, 0, 0, 0.8);
        }
        #white {
            color: white;
        }
        #loginform .login-remember {
            display: none;
        }
        td a {
            display: block;
            width: 100%;
        }
        /* Code Ends */

a {
	color: #f0f0f0;
	text-decoration: none;
}
a:hover {	color: #fff;}

.side {
  background-color: transparent;
	float: right;
	min-width: 320px;
}


.main p {
	font-size: 2em;
	padding: 0 1em;
	margin: 0;
	line-height: 1.5;
	float: right;
	width: 70%;
}
.dr-menu {
	width: 100%;
	max-width: 400px;
	min-width: 300px;
	position: relative;
	font-size: 1.3em;
	line-height: 2.5;
	font-weight: 400;
	color: #fff;
	padding-top: 2em;
}
.dr-menu > div  {
	cursor: pointer;
	position: absolute;
	width: 100%;
	z-index: 100;
}
.dr-menu > div .dr-icon {
	top: 0;
	left: 0;
	position: absolute;
	font-size: 150%;
	line-height: 1.6;
	padding: 0 10px;
	-webkit-transition: all 0.2s ease;
	   -moz-transition: all 0.2s ease;
	        transition: all 0.2s ease;
}
.dr-menu.dr-menu-open > div .dr-icon {
	color: #fff;
	left: 100%;
	-webkit-transform: translateX(-100%);
	   -moz-transform: translateX(-100%);
	    -ms-transform: translateX(-100%);
	        transform: translateX(-100%);
}
.dr-menu > div .dr-icon:after {
	content: "\f0d9";
	position: absolute;
	font-size: 50%;
	line-height: 3.25;
	left: -10%;
	opacity: 0;
}
.dr-menu.dr-menu-open > div .dr-icon:after {opacity: 1;}
.dr-menu > div .dr-label {
	padding-left: 3em;
	position: relative;
	display: block;
	color: #fff;
	font-size: 0.9em;
	font-weight: 700;
	letter-spacing: 1px;
	text-transform: uppercase;
	line-height: 2.75;
	-webkit-transition: all 0.2s ease;
	   -moz-transition: all 0.2s ease;
	        transition: all 0.2s ease;
}
.dr-menu.dr-menu-open > div .dr-label {
	-webkit-transform: translateY(-90%);
	   -moz-transform: translateY(-90%);
	    -ms-transform: translateY(-90%);
	        transform: translateY(-90%);
}
.dr-menu ul {
	padding: 0;
	margin: 0 3em 0 0;
	list-style: none;
	opacity: 0;
	position: relative;
	z-index: 0;
	pointer-events: none;
	-webkit-transition: opacity 0s linear 205ms;
	   -moz-transition: opacity 0s linear 205ms;
	        transition: opacity 0s linear 205ms;
}
.dr-menu.dr-menu-open ul {
	opacity: 1;
	z-index: 200;
	pointer-events: auto;
	-webkit-transition: opacity 0s linear 0s;
	   -moz-transition: opacity 0s linear 0s;
	        transition: opacity 0s linear 0s;
}
.dr-menu ul li {
	display: block;
	margin: 0 0 5px 0;
	opacity: 0;
	-webkit-transition: opacity 0.3s ease;
	   -moz-transition: opacity 0.3s ease;
	        transition: opacity 0.3s ease;
}
.dr-menu.dr-menu-open ul li {opacity: 1;}
.dr-menu.dr-menu-open ul li:nth-child(2) {
	-webkit-transition-delay: 35ms;
	   -moz-transition-delay: 35ms;
	        transition-delay: 35ms;
}
.dr-menu.dr-menu-open ul li:nth-child(3) {
	-webkit-transition-delay: 70ms;
	   -moz-transition-delay: 70ms;
	        transition-delay: 70ms;
}
.dr-menu.dr-menu-open ul li:nth-child(4) {
	-webkit-transition-delay: 105ms;
	   -moz-transition-delay: 105ms;
	        transition-delay: 105ms;
}
.dr-menu.dr-menu-open ul li:nth-child(5) {
	-webkit-transition-delay: 140ms;
	   -moz-transition-delay: 140ms;
	        transition-delay: 140ms;
}
.dr-menu.dr-menu-open ul li:nth-child(6) {
	-webkit-transition-delay: 175ms;
	   -moz-transition-delay: 175ms;
	        transition-delay: 175ms;
}
.dr-menu.dr-menu-open ul li:nth-child(7) {
	-webkit-transition-delay: 205ms;
	   -moz-transition-delay: 205ms;
	        transition-delay: 205ms;
}
.dr-menu ul li a {
	display: inline-block;
	padding: 0 20px;
	color: #fff;
}
.dr-menu ul li a:hover {color: #fff;}
.dr-icon:before, .dr-icon:after {
	position: relative;
	font-family: 'FontAwesome';
	speak: none;
	font-style: normal;
	font-weight: normal;
	font-variant: normal;
	text-transform: none;
	-webkit-font-smoothing: antialiased;
}
.dr-menu ul .dr-icon:before {margin-right: 15px;}
.dr-icon-bullhorn:before {content: "\f234";}
.dr-icon-camera:before {content: "\f03d";}
.dr-icon-heart:before {content: "\f08a";}
.dr-icon-settings:before {content: "\f1de";}
.dr-icon-switch:before {content: "\f011";}
.dr-icon-download:before {content: "\f019";}
.dr-icon-user:before {content: "\f007";}
.dr-icon-menu:before {content: "\f0c9";}
@media screen and (max-width: 66.9375em) {
	.side, .main p {
		float: none;
		width: 100%;
		box-shadow: none;
		padding: 1em;
	}
	.main p {font-size: 130%;}
}

</style>
<head>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/prefixfree/1.0.7/prefixfree.min.js"></script>
  <link rel='stylesheet prefetch' href='https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css'>


    <script>
  function myFunction() {
	 // Declare variables
	 var input, filter, table, tr, td, i;
	 input = document.getElementById("myInput");
	 filter = input.value.toUpperCase();
	 table = document.getElementById("myTable");
	 tr = table.getElementsByTagName("tr");

	 // Loop through all table rows, and hide those who don't match the search query
	 for (i = 0; i < tr.length; i++) {
	   td = tr[i].getElementsByTagName("td")[1];
	   if (td) {
	     if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
	       tr[i].style.display = "";
	     } else {
	       tr[i].style.display = "none";
	     }
	   }
	 }
	}
    </script>
    <script type="text/javascript">
            function DeleteItem() {
                var a = confirm("Are you sure to delete this record?");
                if (a) {
                    return true;
                } else {
                    return false;
                }
            }
     </script>

    <title>TEAM TYLER - UARK</title>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script type="text/javascript" src="https://use.fontawesome.com/9efafc294b.js"></script>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/randomcolor/0.4.4/randomColor.min.js">
	</script>


</head>

<body id="white">
        <form id="demo-2" name="demo-2" style="
    padding-left: 7px;padding-top: 7px;position:fixed;z-index:200;">
        <input id="myInput" onkeyup="myFunction()" placeholder="Search by Name" type="search">
    </form>
	    <div class="side" style="float:left;">

					      <nav class="dr-menu">
						        <div class="dr-trigger">
          <span class="dr-icon dr-icon-menu"></span>
          <a class="dr-label">EyeFly</a>
        </div>
						        <ul>
							          <li><a class="dr-icon dr-icon-user" href="#">Account</a></li>
							          <li><a class="dr-icon dr-icon-camera" href="/inventory.php">Inventory</a></li>
							          <li><a class="dr-icon dr-icon-heart" href="#">Transaction</a></li>
							          <li><a class="dr-icon dr-icon-bullhorn" href="#">Reports</a></li>
							          <li><a class="dr-icon dr-icon-download" href="#"></a></li>
							          <li><a class="dr-icon dr-icon-settings" href="#">Settings</a></li>
							          <li><a class="dr-icon dr-icon-switch" href="/uark/">Logout</a></li>
						        </ul>
					      </nav>
				    </div>
			  </div>
		</div>



    <div class="container" id="main" style="width: 70%;
    position: absolute;
    padding-right: 15%;
    padding-left: 15%;">

        <h2><?php echo $sqltable . ' View'; ?></h1>
		<table id="myTable">
			<tr>
				<th>
					<h1><?php echo $sqltable; ?> ID</h1>
				</th>
				<th>
					<h1>Full Name</h1>
				</th>
				<th>
					<h1 style="text-align: center;">Delete?</h1>
				</th>
			</tr><?php
			        while($table_name=mysql_fetch_assoc($records)){
			            echo "<tr>";
			            echo "<td class='input' width='50px' style='min-width:250px;'>" . $table_name[$sqltable.'ID'] . "</td>";
			            echo "<td class='input' style='text-align:center;'>"  . $table_name['FirstName'] ." ".$table_name['LastName'] . "</td>";
			            echo "<td class='input' style='text-align:center;'>" . '<a class="btn btn-danger" href="delete.php?del='.$table_name[$sqltable.'ID'].'" onclick="DeleteItem();"><i class="fa fa-ban" aria-hidden="true"></i></a>';
			            echo "<tr>";

			        }//end loop
			        ?>
		</table>

	<form action="insert_ac.php" id="loginform" method="post" name="loginform">
		<select style="width:30%;" class="input" name="table">
			<option value="Actor">
				Actor
			</option>
		</select>
		<label for="user_login"></label> <input style="width:30%;" class="input"  id="name" name="name" type="text"> <input style="width:30%;" class="input" id="lastname" name="lastname" type="text">
		<input class="button-primary" name="Submit" type="submit" value="Submit">
	</form>

	</div>



	<script  src="menu.js"></script>


</body>
</html>
