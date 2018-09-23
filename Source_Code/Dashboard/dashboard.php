<?php
define("DB_SERVER", "localhost");
define("DB_USER", "ossn_user");
define("DB_PASSWORD", "123");
define("DB_DATABASE", "ossn_db");
$connect = mysqli_connect(DB_SERVER , DB_USER, DB_PASSWORD, DB_DATABASE);
// Check connection
if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
}

$qry = "SELECT COUNT(id) AS total, MONTH(date) as date FROM ossn_issues";
$results = $connect->query($qry);
$row = $results->fetch_assoc();
//echo $row['total'] ;
$connect->close();
?>
<html>
<head>  
<script>
window.onload = function () {
	
var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	
	title:{
		text:"count of issues generated"
	},
	axisX:{
		interval: 1
	},
	axisY2:{
		interlacedColor: "rgba(1,77,101,.2)",
		gridColor: "rgba(1,77,101,.1)",
		title: "Issues per month"
	},
	data: [{
		type: "bar",
		name: "count",
		axisYType: "secondary",
		color: "#014D65",
		dataPoints: [
			{ y: <?php echo $row['total']; ?>, label: "December" },
			{ y: 0, label: "November" },
			{ y: 0, label: "October" },
			{ y: 0, label: "September" },
			{ y: 0, label: "August" },
			{ y: 0, label: "Jul" },
			{ y: 0, label: "June" },
			{ y: 0, label: "May" },
			{ y: 0, label: "April" },
			{ y: 0, label: "March" },
			{ y: 0, label: "February" },
			{ y: 0, label: "January" },
			
		]
	}]
});
chart.render();

}
</script>
</head>
<body>
<div id="chartContainer" style="height: 300px; width: 100%;"></div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</body>
</html>
