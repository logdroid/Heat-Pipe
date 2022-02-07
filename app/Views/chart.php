<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Chart.JS</title>
</head>

<body>

	<div>
		<canvas id="myChart"></canvas>
	</div>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js" integrity="sha512-TW5s0IT/IppJtu76UbysrBH9Hy/5X41OTAbQuffZFU6lQ1rdcLHzpU5BzVvr/YFykoiMYZVWlr/PX1mDcfM9Qg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns/dist/chartjs-adapter-date-fns.bundle.min.js"></script>

	<script>
		//var r = $.get('http://10.3.0.1:8080/api/chart/node/eaf223dbf83e00655d9457c27b4942e7/12');

		var chart = new Chart($("#myChart"), {
			type: "line",
			data: {},
			options: {
				scales: {
					y: {
						beginAtZero: true,
						position: 'right',
					},
					x: {
						type: 'time',
						time: {
							unit: 'minute',
							stepSize: 10,
						},
					},
				}
			}
		});

		function update_chart() {
			var settings = {
				"url": "<?=base_url()?>/api/chart/group/6cba910764ddd058e010e41a7e80f322/12",
				"method": "GET",
				"timeout": 0,
			};
			$.ajax(settings).done(function(response) {
				chart.data = response.body;
				chart.update();
				console.log(response.body);
			});
		}
		window.onready = update_chart();

		var interval = 1000 * 60 * 1; // where X is your every X 1/2 minute
		setInterval(update_chart, interval);
	</script>

</body>

</html>