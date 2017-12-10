$(document).ready(function(){
	$.ajax({
		url: "https://tylerguy.com/uark/chartjs/api/data_2.php",
		method: "GET",
		success: function(data) {
			console.log(data);
			
			var date = [];
			var customers = [];

			for(var i in data) {
				date.push(data[i].Join_Date);
				customers.push(data[i].customers);
			}
			var chartdata = {   
				labels: date,
				datasets: [
					{
						label: "Signed Up Customers",
						fill: true,
						lineTension: 0.1,
						backgroundColor: "rgba(59, 89, 152, 0.75)",
						borderColor: "rgba(59, 89, 152, 1)",
						pointHoverBackgroundColor: "rgba(59, 89, 152, 1)",
						pointHoverBorderColor: "rgba(59, 89, 152, 1)",
						data: customers
					}
				]
			};

			var ctx = $("#mycanvas2");

			var LineGraph = new Chart(ctx, {
				type: 'line',
				data: chartdata
			});

		},
		error : function(data) {

		}
	});
});