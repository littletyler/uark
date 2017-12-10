$(document).ready(function(){
	$.ajax({
		url: "https://tylerguy.com/uark/chartjs/api/data.php",
		method: "GET",
		success: function(data) {
			console.log(data);
			
			var date = [];
			var rentals = [];
			var unit = [];

			for(var i in data) {
				date.push(data[i].Date_Rented);
				rentals.push(data[i].rentals);
				unit.push(data[i].Unit_ID);
			}
			var chartdata = {   
				labels: date,
				datasets: [
					{
						label: "rentals",
						fill: false,
						lineTension: 0.1,
						backgroundColor: "rgba(59, 89, 152, 0.75)",
						borderColor: "rgba(59, 89, 152, 1)",
						pointHoverBackgroundColor: "rgba(59, 89, 152, 1)",
						pointHoverBorderColor: "rgba(59, 89, 152, 1)",
						data: rentals
					}
				]
			};

			var ctx = $("#mycanvas");

			var LineGraph = new Chart(ctx, {
				type: 'line',
				data: chartdata
			});

		},
		error : function(data) {

		}
	});
});
