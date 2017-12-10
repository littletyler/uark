<?php

include insert_ac.php;
include delete.php;

//server connection
mysql_connect('localhost','tylerguy_tyler','tylerguy!!!');
//select database
mysql_select_db('tylerguy_uark');

$sql="SELECT * FROM Actor order by actorId";

$records=mysql_query($sql);
?>

<html>
<style>@import url(https://fonts.googleapis.com/css?family=Open+Sans:300,400,700);

#canvas {
  position: absolute;
  background:transparent;
  width:12%;
  height:12%;
}

body {
  font-family: 'Open Sans', sans-serif;
  font-weight: 300;
  line-height: 1.42em;
  color:#A7A1AE;
  background-color:#1F2739;
}

h1 {
  font-size:3em; 
  font-weight: 300;
  line-height:1em;
  text-align: center;
  color: #4DC3FA;
}

h2 {
  font-size:1em; 
  font-weight: 300;
  text-align: center;
  display: block;
  line-height:1em;
  padding-bottom: 2em;
  color: #FB667A;
}

h2 a {
  font-weight: 700;
  text-transform: uppercase;
  color: #FB667A;
  text-decoration: none;
}

.blue { color: #185875; }
.yellow { color: #FFF842; }

.container th h1 {
	  font-weight: bold;
	  font-size: 1em;
  text-align: left;
  color: #a0c2d1;
}

#mytable td {
    font-weight: normal;
	  font-size: 1em;
  -webkit-box-shadow: 0 2px 2px -2px #0E1119;
	   -moz-box-shadow: 0 2px 2px -2px #0E1119;
	        box-shadow: 0 2px 2px -2px #0E1119;
}
#mytable th {
    font-weight: normal;
	  font-size: 1em;
  -webkit-box-shadow: 0 2px 2px -2px #0E1119;
	   -moz-box-shadow: 0 2px 2px -2px #0E1119;
	        box-shadow: 0 2px 2px -2px #0E1119;
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
	  width: 80%;
	  margin: 0 auto;
      display: table;
      padding: 0 0 8em 0;
}

.container td, .container th {
	  padding-bottom: 2%;
	  padding-top: 2%;
      padding-left:2%;  
}


#myInput {
    background-image: url('/css/searchicon.png'); /* Add a search icon to input */
    background-repeat: no-repeat; /* Do not repeat the icon image */
    width: 100%; /* Full-width */
    font-size: 14px; /* Increase font-size */
    padding: 12px 20px 12px 40px; /* Add some padding */
    border: 1px solid #ddd; /* Add a grey border */
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
	background: #ededed url(https://static.tumblr.com/ftv85bp/MIXmud4tx/search-icon.png) no-repeat 9px center;!important
	border: solid 1px #ccc!important;
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
	
	-webkit-box-shadow: 0 0 5px rgba(109,207,246,.5)!important;
	-moz-box-shadow: 0 0 5px rgba(109,207,246,.5)!important;
	box-shadow: 0 0 5px rgba(109,207,246,.5)!important;
}


input:-moz-placeholder {
	color: #999!important;
}
input::-webkit-input-placeholder {
	color: #999!important;
}

/* Demo 2 */
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





    </style>
<head>
    
    <script src="https://use.fontawesome.com/9efafc294b.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/randomcolor/0.4.4/randomColor.min.js"></script>
<title></title>
</head>
<body>
    
        <form id="demo-2">
        <input type="search" id="myInput" onkeyup="myFunction()" placeholder="Search by Name">
        </form>
        
        <canvas id="canvas"></canvas>

<table id="myTable" class="container">
        <tr>
        <th><h1>ActorID</h1></th>
        <th><h1>Full Name</h1></th>
        <th><h1>Delete?</h1></th>
        </tr>
        
        <?php
        while($actor=mysql_fetch_assoc($records)){
            echo "<tr>";
            
            echo "<td>" . $actor['ActorID']."</td>";
            echo "<td>" . $actor['FirstName']." ";
            echo $actor['LastName']."</td>";
            echo "<td>" . '<a class="btn btn-danger" href="delete.php?del='.$actor['ActorID'].'" onclick="DeleteItem();"><i class="fa fa-ban" aria-hidden="true"></i></a>';
            echo "<tr>";

        }//end loop
        ?>

</table>
<script type="text/javascript"> 
function DeleteItem() 
{
     var a = confirm("Are you sure to delete this record?");
     if(a) {
         return true;
       }else{
          return false;
            }
}
</script>
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





    <table width="400" border="0" align="center" cellpadding="0" cellspacing="1">
<tr>
<td><form name="form1" method="post" action="insert_ac.php">
<table width="100%" border="0" cellspacing="1" cellpadding="4">
<tr>
<td colspan="4">Insert new actor</td>
</tr>
<tr>
<select name="table">
  <option value="Actor">Actor</option>
  <option value="saab">Saab</option>
  <option value="fiat">Fiat</option>
  <option value="audi">Audi</option>
</select>
<td width="71">Name</td>
<td width="6">:</td>
<td width="301"><input name="name" type="text" id="name"></td>
</tr>
<tr>
<td>Lastname</td>
<td>:</td>
<td><input name="lastname" type="text" id="lastname"></td>
</tr>
<tr>
<!--<td>ActorID</td>
<td>:</td>
<td><input name="ActorID" type="text" id="ActorID"></td>
</tr>
-->
<tr>
<td colspan="4" align="center"><input type="submit" name="Submit" value="Submit"></td>
</tr>
</table>
</form>
</td>
</tr>
</table>
    </table>
<script>
window.requestAnimFrame = (function() {
  return window.requestAnimationFrame ||
    window.webkitRequestAnimationFrame ||
    window.mozRequestAnimationFrame ||
    function(callback) {
      window.setTimeout(callback, 1000 / 60);
    };
})();

var canvas = document.getElementById("canvas");
var ctx = canvas.getContext("2d");
var W, H;
var particles = [];
var fontsize = 260,
  fontweight = "",
  text = "Actors",
  density = 10,
  cursor_range = 240;
var cursor = null;

function Particle(x, y) {
  this.base = {
    "x": x,
    "y": y
  }
  this.x = x;
  this.y = y;
  this.size = 3;
  this.color = randomColor({
    "hue": "yellow",
    "format": "hex"
  });

  this.update = function() {
    if (cursor) {
      var vx = cursor.x - this.x;
      var vy = cursor.y - this.y;
      var distance = Math.sqrt(vx * vx + vy * vy);
      // (x-10)^2*0.01

      if (distance < cursor_range) {
        var attraction = (distance - cursor_range) * (distance - cursor_range) * (1 / (cursor_range * cursor_range)) * 0.8;
        attraction = Math.round(attraction * 1000) / 1000;

      } else {
        var attraction = 0;
      }

      this.x = this.base.x + vx * attraction;
      this.y = this.base.y + vy * attraction;
    }
  };

  this.draw = function() {
    ctx.beginPath();
    ctx.fillStyle = this.color;
    ctx.arc(this.x, this.y, this.size, 0, 2 * Math.PI);
    ctx.fill();
  };
}

function updateCanvasSize() {
  W = canvas.width = $(canvas).innerWidth();
  H = canvas.height = $(canvas).innerHeight();
}

function drawText() {
  var x = W / 2;
  var y = H / 2;

  ctx.fillStyle = "#ffffff";
  ctx.font = fontweight + " " + fontsize + "px impact";
  ctx.textBaseline = "middle";
  ctx.textAlign = "center";
  ctx.fillText(text, x, y);

  return {
    "width": Math.ceil(ctx.measureText(text).width),
    "height": fontsize,
    "x": x - Math.floor(ctx.measureText(text).width / 2),
    "y": y - fontsize / 2
  };
}

function clear() {
  ctx.clearRect(0, 0, W, H);
}

function update() {
  requestAnimFrame(update);

  clear();

  for (i = 0; i < particles.length; i++) {
    var p = particles[i];
    p.update();
    p.draw();
  }
}

$(window).resize(function() {
  updateCanvasSize();
});
updateCanvasSize();

$("#canvas").mousemove(function(e) {
  cursor = {
    "x": e.pageX,
    "y": e.pageY
  };
});
$("#canvas").mouseout(function(e) {
  cursor = cursor;
});

function ini() {
  var t = drawText();

  var imageData = ctx.getImageData(t.x, t.y, W, H);
  var data = imageData.data;

  clear();

  for (y = 0; y < imageData.height; y += density) {
    for (x = 0; x < imageData.width; x += density) {
      var color = data[((y * (imageData.width * 4)) + (x * 4)) - 1];

      if (color == 255) {
        particles.push(new Particle(t.x + x, t.y + y));
      }
    }
  }

  update();
}
ini();
</script>
</body>
</html>