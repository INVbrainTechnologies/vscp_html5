<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta content="text/html; charset=ISO-8859-1" http-equiv="content-type">
<title>Temperature widget 1</title>

<script type="text/javascript" src="../lib/wz_jsgraphics.js"></script>
<script type="text/javascript" src="../lib/vscpwslib.js"></script>

</head>

<body>

<h1>Test animated fan widget</h1>
<br/><br/><br/><br/>
<a href="index.html">Go back to main page</a>

<script type="text/javascript" >
	var fan = new vscpws_animatedfan(<?php echo $_GET["x"]; ?>,<?php echo $_GET["y"]; ?>);
	fan.init();
	fan.setvalue(<?php echo $_GET["value"]; ?>);
</script>
</div>
</body>
</html>
