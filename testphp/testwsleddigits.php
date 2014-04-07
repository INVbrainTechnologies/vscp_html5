<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta content="text/html; charset=ISO-8859-1" http-equiv="content-type">
<title>Temperature widget 1</title>

<link rel="stylesheet" type="text/css" href="../css/example.css" />

<script type="text/javascript" src="../lib/wz_jsgraphics.js"></script>
<script type="text/javascript" src="../lib/vscpwslib.js"></script>

</head>

<body>

<h1>Test LED digit</h1>
<h3>Detected Browser: <div id=brow>...</div></h3>
<br/><br/><br/><br/>
<a href="index.html">Go back to main page</a>
<div id="test">
</div>
<table>
	<tr>
		<td align=center><input type=button id=offset value="Reset counter" onclick="reset();" ></td>
		<td width=100 align=center><div id=number> </div></td>
		<td id=wsdi_statustd align=center><div id=wsdi_status>Not initialized</div></td>
	</tr>
</table>
<script type="text/javascript" >
	
	var leddigits = new vscpws_leddigits( <?php echo $_GET["count"]; ?>, <?php echo $_GET["x"]; ?>,<?php echo $_GET["y"]; ?>,"test");
	leddigits.init();
	leddigits.setValue(<?php echo $_GET["value"]; ?>);
	
document.getElementById("brow").textContent = " " + vscpws_BrowserDetect.browser + " "
	+ vscpws_BrowserDetect.version +" " + vscpws_BrowserDetect.OS +" ";	
		var pos = 0;

function get_appropriate_ws_url()
{
	var pcol;
	var u = document.URL;

	/*
	 * We open the websocket encrypted if this page came on an
	 * https:// url itself, otherwise unencrypted
	 */

	if (u.substring(0, 5) == "https") {
		pcol = "wss://";
		u = u.substr(8);
	} else {
		pcol = "ws://";
		if (u.substring(0, 4) == "http")
			u = u.substr(7);
	}

	u = u.split('/');

	//return pcol + u[0];
	return "ws://localhost:7681"
}

document.getElementById("number").textContent = get_appropriate_ws_url();

/* dumb increment protocol */
	
	var socket_di;

	if (vscpws_BrowserDetect.browser == "Firefox") {
		socket_di = new MozWebSocket(get_appropriate_ws_url(),
				   "dumb-increment-protocol");
	} else {
		socket_di = new WebSocket(get_appropriate_ws_url(),
				   "dumb-increment-protocol");
	}


	try {
		socket_di.onopen = function() {
			document.getElementById("wsdi_statustd").style.backgroundColor = "#40ff40";
			document.getElementById("wsdi_status").textContent = " websocket connection opened ";
		} 

		socket_di.onmessage =function got_packet(msg) {
			//document.getElementById("number").textContent = msg.data + "\n";
			leddigits.setValue( parseInt(msg.data) );
		} 

		socket_di.onclose = function(){
			document.getElementById("wsdi_statustd").style.backgroundColor = "#ff4040";
			document.getElementById("wsdi_status").textContent = " websocket connection CLOSED ";
		}
	} catch(exception) {
		alert('<p>Error' + exception);  
	}

function reset() {
	socket_di.send("reset\n");
}
</script>
</div>
</body>
</html>
