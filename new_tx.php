<?php
session_start();

if(!isset($_SESSION['role'])){ //if login in session is not set
    header("Location: http://www.tylerguy.com/uark/");
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
        
        
		#chart-container {
				width: 640px;
				height: auto;
			}

	</style>
    <title>TEAM TYLER - UARK</title>
</head>

<body style="background: url('http://www.inboundnow.com/wp-content/uploads/2014/08/bg1.jpg');background-size:cover">
    
<?php
include insert_ac.php;
include delete.php;
mysql_connect( 'localhost', 'tylerguy_tyler', 'tylerguy!!!');
mysql_select_db( 'tylerguy_uark');
$sqltable=Actor;
?>

    <div id="wrapper">
        <div class="overlay"></div>
        <nav class="navbar navbar-inverse navbar-fixed-top" id="sidebar-wrapper" role="navigation" style="position: absolute; top: 0%; left: 188px; height: -webkit-fill-available;">
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
<div class="container col-10" id="bb">
<div class="row" style="display: -webkit-inline-box;">

<table id="example1" class="table table-dark">
        <thead>
                    <tr>
                        <th>Tx ID</th>
                        <th>Tx Type</th>
                        <th>Customer</th>
                        <th>Date_Rented</th>
                        <th>Date_Due</th>
                        <th>Cost</th>
                        <th>Fees</th>
                        <th>Titles</th>
                        <th>Action</th>
                    </tr>
        </thead>
        <tfoot>
                    <tr>
                        <th>Tx ID</th>
                        <th>Customer</th>
                        <th>Date_Rented</th>
                        <th>Date_Due</th>
                        <th>Date_Returned</th>
                        <th>Cost</th>
                        <th>Fees</th>
                        <th>Titles</th>
                        <th>Action</th>
                    </tr>
        </tfoot>
<?php
$res2=mysql_query("select Rental.Rental_ID, Rental.Date_Rented, Rental.Date_Due, Rental.Date_Returned, CONCAT(Customer.First_Name, Customer.Last_Name) as Name, SUM(Movie.Rental_Cost) as Cost, Rental.Movie_ID, Rental.Late_Charges, GROUP_CONCAT(Movie.Title) as Titles
from Rental, Customer, Movie
where (Rental.Customer_ID = Customer.Customer_ID) and (Rental.Movie_ID=Movie.Movie_ID)
order by Rental.Rental_ID");
while($row2=mysql_fetch_array($res2))
{
    ?>
    <tr><td><?php echo $row2["Rental_ID"];?></td>
 <!---   <td><select class="form-control" id="sel1"d>
    <option>Rental</option>
    <option>Return</option>
    <option>Other</option>
  </select></td> --->
  
  <td><?php echo $row2["Rental_ID"];?></td><td class='table-dark'><?php echo $row2["Name"];?></td><td><?php echo $row2["Date_Rented"];?></td><td><?php echo $row2["Date_Due"];?></td><td><?php echo $row2["Cost"];?></td><td><?php echo $row2["Late"];?></td><td><?php echo $row2["Titles"];?></td>
  <!---
  <td><select class="form-control" id="sel1"d>
    <option>Unpaid</option>
    <option>Paid</option>
    <option>Refusal</option>
  </select></td>
  --->
  <td><button class="btn btn-primary">Open</button></td>
  </tr>
<?php
}
?>
</table>

		</div>
<script>
$(document).ready(function() {
    $('#example').DataTable({
        "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
        "pagingType": "full_numbers"
})
} );
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
</div>
</div>
    </div>
        <!-- /#page-content-wrapper -->
        <script type="text/javascript" src="chartjs/js/jquery.min.js"></script>
		<script type="text/javascript" src="chartjs/js/Chart.min.js"></script>
		<script type="text/javascript" src="chartjs/js/app.js"></script>

		<script type="text/javascript" src="chartjs/js/app_2.js"></script>
		<script type="text/javascript" src="chartjs/js/app_3.js"></script>

    <!-- /#wrapper -->
</body>
</html>