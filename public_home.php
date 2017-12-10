<?php
session_start();
    
    	// VARIABLES
	$aColumns = array('Movie_ID', 'Title','Publisher', 'Price');
	$sIndexColumn = "Title";
	$sTable = "Movie";
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

    
    
    
    
    
    
    
$host="localhost"; // Host name 
$username="tylerguy_tyler"; // Mysql username 
$password="tylerguy!!!"; // Mysql password 
$db_name="tylerguy_uark"; // Database name 
$tbl_name="users"; // Table name 

$connect = mysqli_connect("localhost", "tylerguy_tyler", "tylerguy!!!", "tylerguy_uark"); 

// Connect to server and select databse. mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
mysql_connect("$host", "$username", "$password")or die("cannot connect");
mysql_select_db("$db_name") or die("cannot select DB");
if(!isset($_SESSION['role'])){ //if login in session is not set
        header("Location: http://www.tylerguy.com/uark/public_login.html");}

if(isset($_POST["add_to_cart"]))  
 {  
      if(isset($_SESSION["shopping_cart"]))  
      {  
           $item_array_id = array_column($_SESSION["shopping_cart"], "item_id");  
           if(!in_array($_GET["id"], $item_array_id))  
           {  
                $count = count($_SESSION["shopping_cart"]);  
                $item_array = array(  
     'item_id'               =>     $_GET["id"],  
     'item_name'               =>     $_POST["hidden_name"],  
     'item_price'          =>     $_POST["hidden_price"],  
     'item_quantity'          =>     $_POST["quantity"]                       
                );  
                $_SESSION["shopping_cart"][$count] = $item_array;  
           }  
           else  
           {  
                echo '<script>alert("Item Already Added")</script>';  
                echo '<script>window.location="public_home.php"</script>';  
           }  
      }  
      else  
      {  
           $item_array = array(  
     'item_id'               =>     $_GET["id"],  
     'item_name'               =>     $_POST["hidden_name"],  
     'item_price'          =>     $_POST["hidden_price"],  
     'item_quantity'          =>     $_POST["quantity"]             );  
           $_SESSION["shopping_cart"][0] = $item_array;  
      }  
 }  
 
 if(isset($_GET["action"]))  
 {  
      if($_GET["action"] == "delete")  
      {  

           foreach($_SESSION["shopping_cart"] as $keys => $values)  
           {  
            if($values["item_id"] == $_GET["id"])  
                {  
                     unset($_SESSION["shopping_cart"][$keys]);  
                     echo '<script>alert("Item Removed")</script>';  
                     echo '<script>window.location="public_home.php"</script>';  
                }  
           }  
      }
 }
?>

<!DOCTYPE html>
<html>
    
    <script src="https://code.jquery.com/jquery-3.2.1.js" integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.10.2/jquery-ui.js" ></script>
    <link href="https://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" rel="Stylesheet"></link>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.8.2/umd/popper.js"></script>
    <link  href="https://tylerguy.com/uark/css/bootstrap.css" rel="stylesheet"></link>
    <script src="https://tylerguy.com/uark/js/bootstrap.js"></script>
    <script src="https://tylerguy.com/uark/DataTables/js/jquery.dataTables.js"></script>
    <script src='https://cdn.rawgit.com/pguso/jquery-plugin-circliful/master/js/jquery.circliful.min.js'></script>
    <script src="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css" rel="stylesheet"></script>
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet"></link>
    <script type="text/javascript" src="https://use.fontawesome.com/9efafc294b.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/randomcolor/0.4.4/randomColor.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/prefixfree/1.0.7/prefixfree.min.js"></script>
	
	
	<script src="https://cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js"></script> 
<script src="https://cdn.datatables.net/buttons/1.1.2/js/dataTables.buttons.min.js"></script> 
<script src="https://cdn.datatables.net/select/1.1.2/js/dataTables.select.min.js"></script> 
<script src="https://cdn.datatables.net/responsive/2.0.2/js/dataTables.responsive.min.js"></script> 
<script src="/uark/DataTables/AltEditor.free.js"></script> 
	
	
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
            margin-left: -220px;
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
          background-color: #1a1a1a;
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
        
        
                #accordion:before {
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

	</style>
    <title>TEAM TYLER - UARK</title>
</head>

<body style="background: url('https://www.inboundnow.com/wp-content/uploads/2014/08/bg1.jpg');background-size:cover">
    
<?php
include insert_ac.php;
include delete.php;
mysql_connect( 'localhost', 'tylerguy_tyler', 'tylerguy!!!');
mysql_select_db( 'tylerguy_uark');
$sqltable=Actor;
?>

    <div id="wrapper" ID="bb">
    <div id="papage-content-wrapper">
    <div id="col-2" style="float:left;position:absolute;padding-left:15px;">
            <script>
                
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})

            </script>
            
    <!--- QUERY TO CHOSE SUGGESTED TITLES W/ ACTORS, RELEASE_DATE, STUDIO, TITLE --->
    
    <!--- ADD NEW CUSTOMER, ADD NEW EMPLOYEE, REMOVE or CHANGE ROLE TO CUSTOMER EMPLOYEE --->
    
    <!--- HIDE MENU ITEMS BASED ON ROLE --->
    <div class="list-group col-6" style="padding-top: 15%; padding-bottom: 15%;">

<?php
$id1 = $_SESSION['id'];
$qu2 = "select Title, Publisher, Rental_Cost, Release_Date from Movie inner join ( select distinct Actor_Movie.Movie_ID from Actor_Movie where Actor_ID = ( SELECT AM.Actor_ID AS MostCommonActor FROM Rental R LEFT JOIN Actor_Movie AM ON AM.Movie_ID = R.Movie_ID where R.Customer_ID = ".$_SESSION['id']." 
ORDER BY COUNT(AM.Actor_ID) DESC limit 1 ) limit 3 ) as v2 
on Movie.Movie_ID = v2.Movie_ID";
$res = mysql_query($qu2);   
while($row=mysql_fetch_array($res))
            {  ?>
                  <a class="list-group-item list-group-item-action flex-column align-items-start">
                    <div class="d-flex w-100 justify-content-between">
                      <h5 class="mb-1"><?php echo $row[0]; ?></h5>
                      <small class="text-muted"><?php echo $row[1]; ?></small>
                    </div>
                    <p class="mb-1"><?php echo "$".$row[2]; ?></p>
                    <small class="text-muted"><?php if($row[3]!="0000"){ echo $row[3]; }?></small>
                  </a>
<?php
}

?>

            </div>
            
        </div>
<div id="col-3" style="float:right;padding-top:3%;padding-right:3%">
    <p>
    <?php 
        echo ($_GET["myusername"]);
    ?>
    </p>
    <button type="button" class="btn btn-secondary"><a href="logout.php" style="color:black;">Log Out</a></button>
</div>

<div class="col-7 text-center mx-auto" style="padding-top: 10%;">
<div id="accordion" role="tablist" aria-multiselectable="true">
    
  <div class="card">
    <div class="card-header" role="tab" id="headingOne">
      <h5 class="mb-0">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne" class="mx-auto col-8" style="color:grey;">
          View Current Titles
        </a>
      </h5>
    </div>

    <div id="collapseOne" class="collapse show" role="tabpanel" aria-labelledby="headingOne">
      <div class="card-block">
        <div class="mx-auto">
        <?php /*
        <div class="table-responsive" style="padding-top: 15px;">
<?php
$res=mysql_query("select * from Movie");

while($row=mysql_fetch_array($res))
{
?>
    <form method="post" action="public_home.php?action=add&id=<?php echo $row["Movie_ID"]; ?>">  
        <table id="example" class="table table-hover table-striped" style="padding-top:15px;">
        <thead>
            <tr>
                <th>Title</th>
                <th>Release Date</th>
                <th>Publisher</th>
                <th>Quantity</th>
            </tr>
</thead>
        <tfoot>
            <tr>
                <th>Title</th>
                <th>Release Date</th>
                <th>Publisher</th>
                <th>Quantity</th>
            </tr>
</tfoot>


        <tr>
        <td><?php echo $row["Title"]; ?></td><td><?php echo $row["Release_Date"]; ?></td>
        <td><?php echo $row["Publisher"]; ?></td>
        <td><input type="text" name="quantity" class="form-control" value="1" style="text-align:center;width: 50%;display: inline-table;"/>
        <input type="submit" name="add_to_cart" style="display: inline-table;" class="btn btn-success" value="Add to Cart" /></td>
        <input type="hidden" name="hidden_name" value="<?php echo $row["Title"]; ?>" />  
        <input type="hidden" name="hidden_price" value="<?php echo $row["price"]; ?>" />  
        <input type="hidden" name="hidden_id" value="<?php echo $row["Movie_ID"]; ?>" />  
        </tr>
                
<?php
}   
?> 
        </table>
    </form> <!---
                <h3 style="padding-top:15px;">Order Details</h3>  
                <div class="table-responsive">  
                     <table class="table table-bordered">  
                          <tr>  
                               <th width="40%">Item Name</th>  
                               <th width="10%">Quantity</th>  
                               <th width="20%">Price</th>  
                               <th width="15%">Total</th>  
                               <th width="5%">Action</th>  
                          </tr>  
                          <?php   
                          if(!empty($_SESSION["shopping_cart"]))  
                          {  
                               $total = 0;  
                               foreach($_SESSION["shopping_cart"] as $keys => $values)  
                               {  
                          ?>  
                          <tr>  
                          

                              
                               <td><?php echo $values["item_name"] ?></td>  
                               <td><?php echo $values["item_quantity"]; ?></td>  
                               <td>$ <?php echo $values["item_price"]; ?></td>  
                               <td>$ <?php echo number_format($values["item_quantity"] * $values["item_price"], 2); ?></td>  
                               <td><a href="public_home.php?action=delete&id=<?php echo $values["item_id"]; ?>"><span class="text-danger">Remove</span></a></td>  
                          </tr>  
                          <?php  
                                    $total = $total + ($values["item_quantity"] * $values["item_price"]);  
                               }  
                          ?>  
                          <tr>  
                               <td colspan="3" align="right">Total</td>  
                               <td align="right">$ <?php echo number_format($total, 2); ?></td>  
                               <td></td>  
                          </tr>  
                          <?php  
                          }  
                          ?>  
                              <?php
                              var_dump(get_defined_vars());

                              ?>
                     </table>  
                </div>   --->                        */ ?>


       <?php   
       if(!empty($_SESSION["shopping_cart"]))  
       {  
           ?>
        <table id="example2" class="table table-hover table-striped" style="padding-bottom:15px;">  
        <tr>  
         <th width="45%">Item Name</th>  
         <th width="10%">Quantity</th>  
         <th width="15%">Price</th>  
         <th width="15%">Total</th>  
         <th width="5%">Action</th>  
       </tr>  
       <?php
         $total = 0;  
         foreach($_SESSION["shopping_cart"] as $keys => $values)  
         {  
          ?>  
          <tr>  
           <td><?php echo $values["item_name"]; ?></td>  
           <td><?php $values["item_quantity"] = 1; echo $values["item_quantity"]; ?></td>  
           <td><?php echo $values["item_price"]; ?></td>  
           <td><?php echo number_format($values["item_quantity"] * $values["item_price"], 2); ?></td>  
           <td><a href="public_home.php?action=delete&id=<?php echo $values["item_id"]; ?>"><span class="btn btn-danger">Remove</span></a></td>  
         </tr>  
         <?php  
         $total = $total + ($values["item_quantity"] * $values["item_price"]);  
       }  
       ?>  
       <tr>  
         <td colspan="3" align="right">Total</td>  
         <td align="right"><?php echo number_format($total, 2); ?></td>  
         <td></td>  
       </tr>  

       <tr style="background-color: #ffffff!important;">  
         <td colspan="3" align="right"></td>  
         <td align="right">

          <form action="logout.php" method="post" onSubmit="alert('Please head to the front desk to claim your titles!');">
            <input type="submit" class="btn btn-warning"value="Proceed to payment"/>
            <input type="hidden" name="amount" value="<?php echo number_format($total, 2); ?>">
          </form>

        </td>  

        <td></td>  
      </tr>  
      <?php  
    }  
    ?>  
  </table> 


</div> 

<table id="example" class="display" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th>ID</th>
					<th>Title</th>
					<th>Publisher</th>
					<th>Price</th>
					<th style="background-image: none">Add</th>
				</tr>
			</thead>

        </table>

        <?php  /*
        
           $query = "SELECT * FROM Movie ORDER BY Movie_ID ASC";  
           $result = mysqli_query($connect, $query);  
           if(mysqli_num_rows($result) > 0)  
           {  
            while($row = mysqli_fetch_array($result))  
            {  
             ?>  

             <form method="post" action="public_home.php?action=add&id=<?php echo $row["Movie_ID"]; ?>">  
             
               <table id="example" class="table table-hover table-striped">
                <thead>
            <tr>
                <th>Title</th>
                <th>Release Date</th>
                <th>Publisher</th>
                <th>Quantity</th>
                <th>Cart</th>
            </tr>
</thead>
                <tfoot>
            <tr>
                <th>Title</th>
                <th>Release Date</th>
                <th>Publisher</th>
                <th>Quantity</th>
                <th>Cart</th>
            </tr>
</tfoot>

                <tr>
                <td><?php echo $row["Title"]; ?></td>
                <td><?php echo $row["price"]; ?></td>
                <td><?php echo $row["Publisher"]; ?></td>
                <td><input type="hidden" name="quantity" type="number" value="1" style="width:50%;"/></td>
                <input type="hidden" name="hidden_name" value="<?php echo $row["Title"]; ?>" />  
                <input type="hidden" name="hidden_dt" value="<?php echo $row["Release_Date"]; ?>" />  
                <input type="hidden" name="hidden_pub" value="<?php echo $row["Publisher"]; ?>" />  
                <input type="hidden" name="hidden_price" value="<?php echo $row["price"]; ?>" />  

                 <td><input type="submit" name="add_to_cart" style="margin-top:5px;" class="btn btn-success" value="Add to Cart" /></td>
                 </tr>

             </table>
             
           </form>

           <?php  
         }  
       }
       */
       ?> 




           </div>  
        </div>
     </div>
  </div>
  
<!--- second section --->
  <div class="card" style="margin-top: 15px;">
    <div class="card-header" role="tab" id="headingTwo">
      <h5 class="mb-1">
        <a data-toggle="collapse" data-parent="#headingOne" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" class="mx-auto col-8" style="color:grey;">
          Rental History
        </a>
      </h5>
    </div>

    <div id="collapseTwo" class="collapse" role="tabpanel" aria-labelledby="headingTwo">
      <div class="card-block">
        <div class="mx-auto">
        <div class="table-responsive">
        <table id="example3" class="table table-hover table-striped">
<thead>
            <tr>
                <th>Rental Date</th>
                <th>Title</th>
                <th>Due Date</th>
                <th>Fee</th>
            </tr>
</thead>
<tfoot>
            <tr>
                <th>Rental Date</th>
                <th>Title</th>
                <th>Due Date</th>
                <th>Fee</th>
            </tr>
</tfoot>
<?php    
$qu1 = 'select * from Rental where Customer_ID =' . $_SESSION['id'];

$res = mysql_query($qu1);   
           {  
while($row=mysql_fetch_array($res))
            {  
                ?>
  <tr><td> <?php echo($row['Date_Rented']) ?> </td><td> <?php echo $row['Movie_ID']; ?></td><td><?php if($row['Date_Due']!="0000-00-00"){echo $row['Date_Due'];} else{echo 'N/A';} ?></td><td><?php echo $row['Late_Charges']; ?></td></tr>

<?php
}
}
?>

</table>
        </div>
        </div>
        </div>
     </div>
  </div>
  </div>
</div>
</div>
</div>
</div>
<script>

// Initialize datatable

				// Initialize datatable
				$('#example').dataTable({
					"aProcessing": true,
					"aServerSide": true,
					"ajax": "datatable2.php?ajax"
				});
				
</script>
<script>
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

</body>

</html>