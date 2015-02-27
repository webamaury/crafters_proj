<?php include_once(_APP_PATH . 'views/includes_admin/head.inc.php'); ?>
<?php include_once(_APP_PATH . 'views/includes_admin/header.inc.php'); ?>

<div class="container" id="admin_index">
	<div class="col-xs-12 col-md-9 modules_button">
		<div class="col-xs-12">
			<div class="col-xs-12 thumbnail">
				<div class="col-xs-12 col-sm-8">
					<div class="col-xs-12 text-center"><h6>Visits on last 15 days</h6></div>
					<div class="col-xs-12">
						<canvas id="canvas" height="200" width="500"></canvas>
					</div>
				</div>
				<div class="col-xs-6 col-sm-4">
					<div class="col-xs-12 text-center"><h6>% / browsers</h6></div>
					<div class="col-xs-12 center-block">
						<canvas id="chart-area" width="220" height="180"/>
					</div>
				</div>
			</div>
		</div>
		<?php
		foreach ($modules as $module)
		{
			?>
		<div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
			<a href="index.php?module=<?php echo $module['path'] ; ?>">
				<div class="thumbnail text-center">
					<span class="glyphicon <?php echo $module['icon'] ; ?>"></span>
					<br/><h3><?php echo $module['name'] ; ?></h3>
					<p><?php echo $module['description'] ; ?></p>
				</div>
			</a>
		</div>
			<?php
		}
		?>
	</div>
	<div class="col-xs-12 col-md-3">
		<div class="col-xs-12 col-lg-12">
			<div class="thumbnail sidebaromom">
				<div class="row">
					<div class="col-xs-12">
						<h5 class="text-center">Last 30 days</h5>
						<div class="col-xs-12">
							<div class="col-xs-12 text-center unitcount">
								<span class="glyphicon glyphicon-book"></span> Orders : <?php echo $new_order->nbOrder; ?>
							</div>
							<div class="col-xs-12 text-center unitcount">
								<span class="glyphicon glyphicon-fire"></span> Products : <?php echo $new_prod->nbProduct; ?>
							</div>
							<div class="col-xs-12 text-center unitcount">
								<span class="glyphicon glyphicon-user"></span> Users : <?php echo $new_user->nbUser; ?>
							</div>
							<div class="col-xs-12 text-center unitcount">
								<span class="glyphicon glyphicon-envelope"></span> Messages : <?php echo $new_message->nbMessage; ?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<ul class="list-group">
				<li class="list-group-item"><a href="index.php?module=adminUsers"><span class="glyphicon glyphicon-star"></span> Admins</a></li>
				<li class="list-group-item"><a href="index.php?module=config"><span class="glyphicon glyphicon-cog"></span> Config</a></li>
			</ul>

		</div>
	</div>


	<script src="../tools/plugin_jquery/chart.min.js"></script>
	<script>

		function displayGraph(flux) {


			var results = flux.results;
			var continent_donnee = flux.continent_donnee;

			var varlabel = [];
			var varvalue = [];

			$.each(results, function(key, value) {
				varlabel.push(key);
				varvalue.push(value);
			});

			var randomScalingFactor = function(){ return Math.round(Math.random()*100)};
			var lineChartData = {
				labels : varlabel,
				datasets : [
					{
						label: "My Second dataset",
						fillColor: "rgba(66,139,202,0.3)",
						strokeColor: "#428bca",
						pointColor: "#428bca",
						pointStrokeColor: "#fff",
						pointHighlightFill: "#fff",
						pointHighlightStroke: "rgba(151,187,205,1)",
						data: varvalue
					}
				]

			}

			var pieData = [
				{
					value: <?php echo $dataset_browsers['Opera']; ?>,
					color:"#e74c3c",
					highlight: "#c0392b",
					label: "Opera"
				},
				{
					value: <?php echo $dataset_browsers['Internet Explorer']; ?>,
					color: "#95a5a6",
					highlight: "#7f8c8d",
					label: "Internet Explorer"
				},
				{
					value: <?php echo $dataset_browsers['Firefox']; ?>,
					color: "#f39c12",
					highlight: "#e67e22",
					label: "Firefox"
				},
				{
					value: <?php echo $dataset_browsers['Chrome']; ?>,
					color: "#2ecc71",
					highlight: "#27ae60",
					label: "Chrome"
				},
				{
					value: <?php echo $dataset_browsers['Safari']; ?>,
					color: "#3498db",
					highlight: "#2980b9",
					label: "Safari"
				}

			];*/

				var ctx = document.getElementById("canvas").getContext("2d");
				window.myLine = new Chart(ctx).Line(lineChartData, {
					responsive: true,
					tooltipTemplate: "<%if (label){%><%}%><%= value %>",
					scaleShowGridLines: false,
					pointDot: false,
					showScale: true,
					scaleOverride: true,

					// ** Required if scaleOverride is true **
					// Number - The number of steps in a hard coded scale
					scaleSteps: 5,
					// Number - The value jump in the hard coded scale
					scaleStepWidth: 3000,
					// Number - The scale starting value
					scaleStartValue: 0,
				});

				/*var ctx = document.getElementById("chart-area").getContext("2d");
				window.myPie = new Chart(ctx).Pie(pieData, {
					responsive: true,
					tooltipTemplate: "<%if (label){%><%=label%>: <%}%><%= value %>%"
				});*/

		}

		$(document).ready(function(){
			$.get("index.php?module=index&action=ajaxGapi",{},function(data){
				if(data.error){
					alert(data.message);
				}else{
					//SI C BON
					displayGraph(data);

				}
			},'json');
		});



	</script>
</div>
