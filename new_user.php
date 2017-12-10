<?php
session_start();

if(!isset($_SESSION['role'])){ //if login in session is not set
    header("Location: http://www.tylerguy.com/uark/");
}

//For more Info: Please visit: http://www.discussdesk.com/bootstrap-datatable-with-add-edit-remove-option-in-php-mysql-ajax.htm

	// VARIABLES
	$aColumns = array('id', 'role', 'username', 'password');
	$sIndexColumn = "id";
	$sTable = "users";
	$gaSql['user'] = "tylerguy_tyler";
	$gaSql['password'] = "tylerguy!!!";
	$gaSql['db'] = "tylerguy_uark";
	$gaSql['server'] = "localhost";


	// DATABASE CONNECTION
	function dbinit(&$gaSql) {
		// ERROR HANDLING
		function fatal_error($sErrorMessage = '') {
			header($_SERVER['SERVER_PROTOCOL'] .' 500 Internal Server Error');
			die($sErrorMessage);
		}

		// MYSQL CONNECT
		if ( !$gaSql['link'] = @mysql_connect($gaSql['server'], $gaSql['user'], $gaSql['password']) ) {
			fatal_error('Could not open connection to server');
		}

		// MYSQL DATABASE SELECT
		if ( !mysql_select_db($gaSql['db'], $gaSql['link']) ) {
			fatal_error('Could not select database');
		}
	}

	// AJAX EDIT FROM JQUERY
	if ( isset($_GET['edit']) && 0 < intval($_GET['edit']) ) {
		dbinit($gaSql);

		// SAVE DATA
		if ( isset($_POST) ) {
			$p = $_POST;
			foreach ( $p as &$val ) $val = mysql_real_escape_string($val);
			if ( !empty($p['id']) && !empty($p['username']) && !empty($p['password']) )
				@mysql_query(" UPDATE $sTable SET name = '" . $p['id'] . "', username = '" . $p['username'] . "', password = '" . $p['password'] . "' WHERE id = " . intval($_GET['edit']));
		}

		// GET DATA
		$query = mysql_query(" SELECT * FROM $sTable WHERE $sIndexColumn = " . intval($_GET['edit']), $gaSql['link']);
		die(json_encode(mysql_fetch_assoc($query)));
	}

	// AJAX ADD FROM JQUERY
	if ( isset($_GET['add']) && isset($_POST) ) {
		dbinit($gaSql);

		$p = $_POST;
		foreach ( $p as &$val ) $val = mysql_real_escape_string($val);
		if ( !empty($p['id']) && !empty($p['username']) && !empty($p['password']) ) {
			@mysql_query(" INSERT INTO $sTable (id, username, password) VALUES ('" . $p['id'] . "', '" . $p['username'] . "', '" . $p['password'] . "')");
			$id = mysql_insert_id();
			$query = mysql_query(" SELECT * FROM $sTable WHERE $sIndexColumn = " . $id, $gaSql['link']);
			die(json_encode(mysql_fetch_assoc($query)));
		}
	}

	// AJAX REMOVE FROM JQUERY
	if ( isset($_GET['remove']) && 0 < intval($_GET['remove']) ) {
		dbinit($gaSql);

		// REMOVE DATA
		@mysql_query(" DELETE FROM $sTable WHERE id = " . intval($_GET['remove']));
	}


	// AJAX FROM JQUERY
	if ( isset($_GET['ajax']) ) {
		dbinit($gaSql);

		// QUERY LIMIT
		$sLimit = "";
		if ( isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1' ) {
			$sLimit = "LIMIT " . intval($_GET['iDisplayStart']) . ", " . intval($_GET['iDisplayLength']);
		}

		// QUERY ORDER
		$sOrder = "";
		if ( isset($_GET['iSortCol_0']) ) {
			$sOrder = "ORDER BY ";
			for ( $i = 0; $i < intval($_GET['iSortingCols']); $i++ ) {
				if ( $_GET['bSortable_' . intval($_GET['iSortCol_' . $i])] == "true" ) {
					$sOrder .= $aColumns[intval($_GET['iSortCol_' . $i])] . " " . ( $_GET['sSortDir_' . $i] === 'asc' ? 'asc' : 'desc' ) . ", ";
				}
			}
			$sOrder = substr_replace($sOrder, "", -2);
			if ( $sOrder == "ORDER BY" ) $sOrder = "";
		}

		// QUERY SEARCH
		$sWhere = "";
		if ( isset($_GET['sSearch']) && $_GET['sSearch'] != "" ) {
			$sWhere = "WHERE (";
			for ( $i = 0; $i < count($aColumns); $i++ ) {
				if ( isset($_GET['bSearchable_' . $i]) && $_GET['bSearchable_' . $i] == "true" ) {
					$sWhere .= $aColumns[$i] . " LIKE '%" . mysql_real_escape_string($_GET['sSearch']) . "%' OR ";
				}
			}
			$sWhere = substr_replace($sWhere, "", -3);
			$sWhere .= ')';
		}

		// BUILD QUERY
		for ( $i = 0; $i < count($aColumns); $i++ ) {
			if ( isset($_GET['bSearchable_' . $i]) && $_GET['bSearchable_' . $i] == "true" && $_GET['sSearch_' . $i] != '' ) {
				if ( $sWhere == "" ) $sWhere = "WHERE ";
				else $sWhere .= " AND ";
				$sWhere .= $aColumns[$i] . " LIKE '%" . mysql_real_escape_string($_GET['sSearch_' . $i]) . "%' ";
			}
		}

		// FETCH
		$sQuery = " SELECT SQL_CALC_FOUND_ROWS " . str_replace(" , ", " ", implode(", ", $aColumns)) . " FROM $sTable $sWhere $sOrder $sLimit ";
		$rResult = mysql_query($sQuery, $gaSql['link']) or fatal_error('MySQL Error: ' . mysql_errno());
		$sQuery = " SELECT FOUND_ROWS() ";
		$rResultFilterTotal = mysql_query($sQuery, $gaSql['link']) or fatal_error('MySQL Error: ' . mysql_errno());
		$aResultFilterTotal = mysql_fetch_array($rResultFilterTotal);
		$iFilteredTotal = $aResultFilterTotal[0];
		$sQuery = " SELECT COUNT(" . $sIndexColumn . ") FROM $sTable ";
		$rResultTotal = mysql_query($sQuery, $gaSql['link']) or fatal_error('MySQL Error: ' . mysql_errno());
		$aResultTotal = mysql_fetch_array($rResultTotal);
		$iTotal = $aResultTotal[0];
		while ( $aRow = mysql_fetch_array($rResult) ) {
			$row = array();
			for ( $i = 0 ; $i < count($aColumns); $i++ ) {
				if ( $aColumns[$i] == "version" ) $row[] = ( $aRow[$aColumns[$i]] == "0" ) ? '-' : $aRow[$aColumns[$i]];
				else if ( $aColumns[$i] != ' ' ) $row[] = $aRow[$aColumns[$i]];
			}
			$output['aaData'][] = array_merge($row, array('<a data-id="row-' . $row[0] . '" href="javascript:editRow(' . $row[0] . ');" class="btn btn-md btn-success">edit</a>&nbsp;<a href="javascript:removeRow(' . $row[0] . ');" class="btn btn-default btn-md" style="background-color: #c83a2a;border-color: #b33426; color: #ffffff;">remove</a>'));
		}

		// RETURN IN JSON
		die(json_encode($output));
	}

?>
<!DOCTYPE html>
<html>
    
    <script src="https://code.jquery.com/jquery-3.2.1.js" integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.10.2/jquery-ui.js" ></script>
    <link href="https://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" rel="Stylesheet"></link>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.8.2/umd/popper.js"></script>
    <script src="https://tylerguy.com/uark/DataTables/js/jquery.dataTables.js"></script>
    
    
    <script src='https://cdn.rawgit.com/pguso/jquery-plugin-circliful/master/js/jquery.circliful.min.js'></script>
    <!---
    <script src="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css" rel="stylesheet"></script>
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet"></link>
    -->
    <link  href="https://tylerguy.com/uark/css/bootstrap.css" rel="stylesheet"></link>
    <script src="https://tylerguy.com/uark/js/bootstrap.js"></script>
    <script type="text/javascript" src="https://tylerguy.com/uark/DataTables/js/ty.min.js"></script>
    <script src="https://tylerguy.com/uark/DataTables/css/dataTables.bootstrap.min.css" rel="stylesheet"></script>
    <link rel="https://tylerguy.com/uark/DataTables/js/jquery.dataTables.min.css">
    <script src="https://tylerguy.com/uark/DataTables/js/dataTables.altEditor.free.js"></script>
    <link rel="https://tylerguy.com/uark/DataTables/js/ty.min.css">
    <script src='https://cdn.rawgit.com/pguso/jquery-plugin-circliful/master/js/jquery.circliful.min.js'></script>
    <link rel="https://tylerguy.com/uark/DataTables/js/bootstrap.min.css">
    
    
    <script type="text/javascript" src="https://use.fontawesome.com/9efafc294b.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/randomcolor/0.4.4/randomColor.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/prefixfree/1.0.7/prefixfree.min.js"></script>
	
<head>
	<style>
        body,
        html { height: 100%;}
        .nav .open > a, 
        .nav .open > a:hover, 
        .nav .open > a:focus {background-color: transparent;}
        
        /*-------------------------------*/
        /*           Wrappers            */
        /*-------------------------------*/
        
        #wrapper {
            padding-left: 0;
            -webkit-transition: all 0.5s ease;
            -moz-transition: all 0.5s ease;
            -o-transition: all 0.5s ease;
            transition: all 0.5s ease;
        }
        
        #wrapper.toggled {
            padding-left: 220px;
        }
        
        #sidebar-wrapper {
            z-index: 1000;
            left: 220px;
            width: 0;
            height: 100%;
            margin-left: -240px;
            overflow-y: auto;
            overflow-x: hidden;
            background: #1a1a1a;
            -webkit-transition: all 0.5s ease;
            -moz-transition: all 0.5s ease;
            -o-transition: all 0.5s ease;
            transition: all 0.5s ease;
        }
        
        #sidebar-wrapper::-webkit-scrollbar {
          display: none;
        }
        
        #wrapper.toggled #sidebar-wrapper {
            width: 220px;
        }
        
        #page-content-wrapper {
            width: 100%;
        }
        
        #wrapper.toggled #page-content-wrapper {
            position: absolute;
            margin-right: -220px;
        }
        
        /*-------------------------------*/
        /*     Sidebar nav styles        */
        /*-------------------------------*/
        
        .sidebar-nav {
            position: absolute;
            top: 0;
            width: 220px;
            margin: 0;
            padding: 0;
            list-style: none;
        }
        
        .sidebar-nav li {
            position: relative; 
            line-height: 20px;
            display: inline-block;
            width: 100%;
        }
        
        .sidebar-nav li:before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            z-index: -1;
            height: 100%;
            width: 3px;
            background-color: #1c1c1c;
            -webkit-transition: width .2s ease-in;
              -moz-transition:  width .2s ease-in;
               -ms-transition:  width .2s ease-in;
                    transition: width .2s ease-in;
        
        }
        .sidebar-nav li:first-child a {
            color: #fff;
            background-color: #1a1a1a;
        }
        .sidebar-nav li:nth-child(2):before {
            background-color: #ec1b5a;   
        }
        .sidebar-nav li:nth-child(3):before {
            background-color: #79aefe;   
        }
        .sidebar-nav li:nth-child(4):before {
            background-color: #314190;   
        }
        .sidebar-nav li:nth-child(5):before {
            background-color: #279636;   
        }
        .sidebar-nav li:nth-child(6):before {
            background-color: #7d5d81;   
        }
        .sidebar-nav li:nth-child(7):before {
            background-color: #ead24c;   
        }
        .sidebar-nav li:nth-child(8):before {
            background-color: #2d2366;   
        }
        .sidebar-nav li:nth-child(9):before {
            background-color: #35acdf;   
        }
        .sidebar-nav li:hover:before,
        .sidebar-nav li.open:hover:before {
            width: 100%;
            -webkit-transition: width .2s ease-in;
              -moz-transition:  width .2s ease-in;
               -ms-transition:  width .2s ease-in;
                    transition: width .2s ease-in;
        }
        
        .sidebar-nav li a {
            display: block;
            color: #ddd;
            text-decoration: none;
            padding: 10px 15px 10px 30px;    
        }
        
        .sidebar-nav li a:hover,
        .sidebar-nav li a:active,
        .sidebar-nav li a:focus,
        .sidebar-nav li.open a:hover,
        .sidebar-nav li.open a:active,
        .sidebar-nav li.open a:focus{
            color: #fff;
            text-decoration: none;
            background-color: transparent;
        }
        
        .sidebar-nav > .sidebar-brand {
            height: 65px;
            font-size: 20px;
            line-height: 44px;
        }
        .sidebar-nav .dropdown-menu {
            position: relative;
            width: 100%;
            padding: 0;
            margin: 0;
            border-radius: 0;
            border: none;
            background-color: #222;
            box-shadow: none;
        }
        
        /*-------------------------------*/
        /*       Hamburger-Cross         */
        /*-------------------------------*/
        
        .hamburger {
          position: fixed;
          top: 20px;  
          z-index: 999;
          display: block;
          width: 32px;
          height: 32px;
          margin-left: 15px;
          background: transparent;
          border: none;
        }
        .hamburger:hover,
        .hamburger:focus,
        .hamburger:active {
          outline: none;
        }
        .hamburger.is-closed:before {
          content: '';
          display: block;
          width: 100px;
          font-size: 14px;
          color: #fff;
          line-height: 32px;
          text-align: center;
          opacity: 0;
          -webkit-transform: translate3d(0,0,0);
          -webkit-transition: all .35s ease-in-out;
        }
        .hamburger.is-closed:hover:before {
          opacity: 1;
          display: block;
          -webkit-transform: translate3d(-100px,0,0);
          -webkit-transition: all .35s ease-in-out;
        }
        
        .hamburger.is-closed .hamb-top,
        .hamburger.is-closed .hamb-middle,
        .hamburger.is-closed .hamb-bottom,
        .hamburger.is-open .hamb-top,
        .hamburger.is-open .hamb-middle,
        .hamburger.is-open .hamb-bottom {
          position: absolute;
          left: 0;
          height: 4px;
          width: 100%;
        }
        .hamburger.is-closed .hamb-top,
        .hamburger.is-closed .hamb-middle,
        .hamburger.is-closed .hamb-bottom {
          background-color: #ffffff;
        }
        .hamburger.is-closed .hamb-top { 
          top: 5px; 
          -webkit-transition: all .35s ease-in-out;
        }
        .hamburger.is-closed .hamb-middle {
          top: 50%;
          margin-top: -2px;
        }
        .hamburger.is-closed .hamb-bottom {
          bottom: 5px;  
          -webkit-transition: all .35s ease-in-out;
        }
        
        .hamburger.is-closed:hover .hamb-top {
          top: 0;
          -webkit-transition: all .35s ease-in-out;
        }
        .hamburger.is-closed:hover .hamb-bottom {
          bottom: 0;
          -webkit-transition: all .35s ease-in-out;
        }
        .hamburger.is-open .hamb-top,
        .hamburger.is-open .hamb-middle,
        .hamburger.is-open .hamb-bottom {
          background-color: #1a1a1a;
        }
        .hamburger.is-open .hamb-top,
        .hamburger.is-open .hamb-bottom {
          top: 50%;
          margin-top: -2px;  
        }
        .hamburger.is-open .hamb-top { 
          -webkit-transform: rotate(45deg);
          -webkit-transition: -webkit-transform .2s cubic-bezier(.73,1,.28,.08);
        }
        .hamburger.is-open .hamb-middle { display: none; }
        .hamburger.is-open .hamb-bottom {
          -webkit-transform: rotate(-45deg);
          -webkit-transition: -webkit-transform .2s cubic-bezier(.73,1,.28,.08);
        }
        .hamburger.is-open:before {
          content: '';
          display: block;
          width: 100px;
          font-size: 14px;
          color: #fff;
          line-height: 32px;
          text-align: center;
          opacity: 0;
          -webkit-transform: translate3d(0,0,0);
          -webkit-transition: all .35s ease-in-out;
        }
        .hamburger.is-open:hover:before {
          opacity: 1;
          display: block;
          -webkit-transform: translate3d(-100px,0,0);
          -webkit-transition: all .35s ease-in-out;
        }
        
        /*-------------------------------*/
        /*            Overlay            */
        /*-------------------------------*/
        
        .overlay {
            position: fixed;
            display: none;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(250,250,250,.8);
            z-index: 1;
        }
        body {
        background: #de5858; /* Old Browsers */
        background: -webkit-linear-gradient(top,#de5858,#e79090); /*Safari 5.1-6*/
        background: -o-linear-gradient(top,#de5858,#e79090); /*Opera 11.1-12*/
        background: -moz-linear-gradient(top,#de5858,#e79090); /*Fx 3.6-15*/
        background: linear-gradient(to bottom, #de5858, #e79090); /*Standard*/
        }
        
        
        #bb:before {
                    content: url('https://www.tylerguy.com/uark/ark-logo-left.png');
                    display: table;
                    margin: 0 auto;
                    height: 70px;
            		object-fit: contain;
                    transform: scale(0.5, 0.5);
        -ms-transform: scale(0.5, 0.5);
        -webkit-transform: scale(0.5, 0.5);
                    }
        
        .table-hover tbody tr:hover {
            background-color:#858383;
        }


        .odd {
            color:black!important;
        }
	</style>
    <title>TEAM TYLER - UARK</title>
</head>

<body style="background: url('https://www.inboundnow.com/wp-content/uploads/2014/08/bg1.jpg');background-size:cover">
    


    <div id="wrapper">
        <div class="overlay"></div>
        <nav class="navbar navbar-inverse navbar-fixed-top" id="sidebar-wrapper" role="navigation" style="position: absolute; top: 0%; height: -webkit-fill-available;">
            <ul class="nav sidebar-nav">
                <li class="sidebar-brand">
                    <a href="#">
                       EyeFly
                    </a>
                </li>
                <li>
                    <a href="/uark/new_tx.php">New Transaction</a>
                </li>
                <li>
                    <a href="/uark/new_user.php">New Customer</a>
                </li>
                <li>
                    <a href="/uark/inventory.php">Inventory</a>
                </li>
                <li>
                    <a href="/uark/reports.php">Reports</a>
                </li>
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Analytics<span class="caret"></span></a>
                  <ul class="dropdown-menu" role="menu">
                    <li class="dropdown-header">Various metrics and <br>other cool information <br>that would be nice to know</li>
                    <li><a href="/uark/sales.php">Sales</a></li>
                    <li><a href="/uark/metrics.php">Metrics</a></li>
                  </ul>
                </li>
                <li>
                    <a href="/uark/admin.php">Manage</a>
                </li>
                <li>
                    <a href="/uark/logout.php">Logout</a>
                </li>
            </ul>
        </nav>

    <div id="papage-content-wrapper">
            <button type="button" class="hamburger is-closed" data-toggle="offcanvas">
                <span class="hamb-top"></span>
    			<span class="hamb-middle"></span>
				<span class="hamb-bottom"></span>
            </button>
        <div class="container" id="bb">
        <h3 align="center" style="color:white;">Test</h3>

        
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
		<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.10/css/jquery.dataTables.css">

		<div class="container-fluid">
		<button type="button" style="padding:10px; margin:0 50px 15px 0;" class="btn btn-primary btn-sm pull-right" data-toggle="modal" data-target="#add-modal"><b>Add More Rows</b></button>
		<div class="row">
<div class="col-md-12 marginT20">

		<div class="table-responsive demo-x content">
		<table id="example" class="display" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th>#</th>
					<th>username</th>
					<th>password</th>
					<th style="background-image: none">Edit</th>
				</tr>
			</thead>
		</table>
		</div>

		</div>
		</div>
		</div>

		<div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-labelledby="edit-modal-label">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		    	<form class="form-horizontal" id="edit-form">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			        <h4 class="modal-title" id="edit-modal-label">Edit selected row</h4>
			      </div>
			      <div class="modal-body">
			      		<input type="hidden" id="edit-id" value="" class="hidden">
			        	<div class="form-group">
					    	<label for="id" class="col-sm-2 control-label">id</label>
					    	<div class="col-sm-10">
					      		<input type="text" class="form-control" id="id" name="id" placeholder="id" required>
					    	</div>
					  	</div>
					  	<div class="form-group">
					    	<label for="username" class="col-sm-2 control-label">Username</label>
					    	<div class="col-sm-10">
					      		<input type="username" class="form-control" id="username" name="username" placeholder="Username" required>
					    	</div>
					  	</div>
					  	<div class="form-group">
					    	<label for="password" class="col-sm-2 control-label">password</label>
					    	<div class="col-sm-10">
					      		<input type="text" class="form-control" id="password" name="password" placeholder="password" required>
					    	</div>
					  	</div>
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			        <button type="submit" class="btn btn-primary">Save changes</button>
			      </div>
		      	</form>
		    </div>
		  </div>
		</div>

		<div class="modal fade" id="add-modal" tabindex="-1" role="dialog" aria-labelledby="add-modal-label">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		    	<form class="form-horizontal" id="add-form">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			        <h4 class="modal-title" id="add-modal-label">Add new row</h4>
			      </div>
			      <div class="modal-body">
			        	<div class="form-group">
					    	<label for="add-id" class="col-sm-2 control-label">id</label>
					    	<div class="col-sm-10">
					      		<input type="text" class="form-control" id="add-id" name="id" placeholder="id" required>
					    	</div>
					  	</div>
					  	<div class="form-group">
					    	<label for="add-username" class="col-sm-2 control-label">Username</label>
					    	<div class="col-sm-10">
					      		<input type="username" class="form-control" id="add-username" name="username" placeholder="Username" required>
					    	</div>
					  	</div>
					  	<div class="form-group">
					    	<label for="add-password" class="col-sm-2 control-label">password</label>
					    	<div class="col-sm-10">
					      		<input type="text" class="form-control" id="add-password" name="password" placeholder="password" required>
					    	</div>
					  	</div>
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			        <button type="submit" class="btn btn-primary">Save changes</button>
			      </div>
		      	</form>
		    </div>
		  </div>
		</div>

		<script src="https://code.jquery.com/jquery-2.2.0.min.js" type="text/javascript"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
		<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.10/js/jquery.dataTables.js"></script>
		<script type="text/javascript" language="javascript" class="init">
			$(document).ready(function() {

				// ATW
				if ( top.location.href != location.href ) top.location.href = location.href;

				// Initialize datatable
				$('#example').dataTable({
					"aProcessing": true,
					"aServerSide": true,
					"ajax": "datatable.php?ajax"
				});

				// Save edited row
				$("#edit-form").on("submit", function(event) {
					event.preventDefault();
					$.post("datatable.php?edit=" + $('#edit-id').val(), $(this).serialize(), function(data) {
						var obj = $.parseJSON(data);
						var tr = $('a[data-id="row-' + $('#edit-id').val() + '"]').parent().parent();
						$('td:eq(1)', tr).html(obj.id);
						$('td:eq(2)', tr).html(obj.username);
						$('td:eq(3)', tr).html(obj.password);
						$('#edit-modal').modal('hide');
					}).fail(function() { alert('Unable to save data, please try again later.'); });
				});

				// Add new row
				$("#add-form").on("submit", function(event) {
					event.preventDefault();
					$.post("datatable.php?add", $(this).serialize(), function(data) {
						var obj = $.parseJSON(data);
						$('#example tbody tr:last').after('<tr role="row"><td class="sorting_1">' + obj.id + '</td><td>' + obj.id + '</td><td>' + obj.username + '</td><td>' + obj.password + '</td><td><a data-id="row-' + obj.id + '" href="javascript:editRow(' + obj.id + ');" class="btn btn-default btn-sm">edit</a>&nbsp;<a href="javascript:removeRow(' + obj.id + ');" class="btn btn-default btn-sm">remove</a></td></tr>');
						$('#add-modal').modal('hide');
					}).fail(function() { alert('Unable to save data, please try again later.'); });
				});

			});

			// Edit row
			function editRow(id) {
				if ( 'undefined' != typeof id ) {
					$.getJSON('datatable.php?edit=' + id, function(obj) {
						$('#edit-id').val(obj.id);
						$('#id').val(obj.id);
						$('#username').val(obj.username);
						$('#password').val(obj.password);
						$('#edit-modal').modal('show')
					}).fail(function() { alert('Unable to fetch data, please try again later.') });
				} else alert('Unknown row id.');
			}

			// Remove row
			function removeRow(id) {
				if ( 'undefined' != typeof id ) {
					$.get('datatable.php?remove=' + id, function() {
						$('a[data-id="row-' + id + '"]').parent().parent().remove();
					}).fail(function() { alert('Unable to fetch data, please try again later.') });
				} else alert('Unknown row id.');
			}
		</script>
	

<script type="text/javascript">


$(document).ready(function () {
  var trigger = $('.hamburger'),
      overlay = $('.overlay'),
     isClosed = false;

    trigger.click(function () {
      hamburger_cross();      
    });

    function hamburger_cross() {

      if (isClosed == true) {          
        overlay.hide();
        trigger.removeClass('is-open');
        trigger.addClass('is-closed');
        isClosed = false;
      } else {   
        overlay.show();
        trigger.removeClass('is-closed');
        trigger.addClass('is-open');
        isClosed = true;
      }
  }
  
  $('[data-toggle="offcanvas"]').click(function () {
        $('#wrapper').toggleClass('toggled');
  });  
});

</script>
</div>
</div>

</div>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"/> 
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.11/css/jquery.dataTables.min.css"/> 
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.1.2/css/buttons.dataTables.min.css"/> 
<link rel="stylesheet" href="https://cdn.datatables.net/select/1.1.2/css/select.dataTables.min.css"/>
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.0.2/css/responsive.dataTables.min.css"/> 

<script src="https://code.jquery.com/jquery-2.2.3.min.js"></script> 
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script> 
<script src="https://cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js"></script> 
<script src="https://cdn.datatables.net/buttons/1.1.2/js/dataTables.buttons.min.js"></script> 
<script src="https://cdn.datatables.net/select/1.1.2/js/dataTables.select.min.js"></script> 
<script src="https://cdn.datatables.net/responsive/2.0.2/js/dataTables.responsive.min.js"></script> 
<script src="/uark/DataTables/AltEditor.free.js"></script> 

</body>
</html>
