$(document).ready(function(){
	$.ajax({
		url: "https://www.cryptocompare.com/api/data/coinsnapshot/?fsym=BTC&tsym=USD",
		method: "GET",
		success: function(data) {
		console.log(data);
			
			var date = [];
			var customers = [];

			for(var i in data) {
				date.push(data[i].LASTUPDATE);
				customers.push(data[i].PRICE);
			}
			var chartdata = {   
				labels: date,
				datasets: [
					{
						label: "Signed Up Customers",
						fill: false,
						lineTension: 0.1,
						backgroundColor: "rgba(59, 89, 152, 0.75)",
						borderColor: "rgba(59, 89, 152, 1)",
						pointHoverBackgroundColor: "rgba(59, 89, 152, 1)",
						pointHoverBorderColor: "rgba(59, 89, 152, 1)",
						data: customers
					}
				]
			};

			var ctx = $("#mycanvas3");

			var LineGraph = new Chart(ctx, {
				type: 'line',
				data: chartdata
			});

		},
		error : function(data) {

		}
	});
});