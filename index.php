<?php
include "database.php";
include("FusionChartsFree/Code/PHP/Includes/FusionCharts.php");
include("FusionChartsFree/Code/PHP/Includes/FC_Colors.php");

//include "get_default.php";
//include "submit.php";
//include "database.php";


//Initializations


//$userid = $_GET["user_id"];
//$login = $_GET["login"];


database_connect();
//get_user_info($userid);
$val1="";
$val2="";
$val3="";
//$data_string = get_data($userid,$fresh_no,$known_no,$obviousspy_no,$subtlespy_no);
//$user_string = score($userid);


database_disconnect();



?>


<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" type="text/css" href="mystyle.css" />
</style>
<title>Maharshtra Anganwadi Data - MPR</title>

<script language="Javascript" src="FusionChartsFree/Code/FusionCharts/FusionCharts.js"> </script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script type="text/javascript" src="Highcharts/js/highcharts.js"></script>
<script type="text/javascript" src="Highcharts/js/modules/exporting.js"></script>
<script type="text/javascript" src="json2.js"></script>
<script type="text/javascript">

	var str_last="";

	function trychange(str) {

		alert("maharashtra");
		if(str=="maharashtra")
		{
			//alert("maharashtra");
			var elSel = document.getElementById("secondLevel1");
			elSel.options[elSel.length] = new Option('Total','total');
			elSel.options[elSel.length] = new Option('Rural vs. Urban','rural_urban');
			elSel.options[elSel.length] = new Option('Tribal vs. Non-Tribal','tribal_nontribal');
			document.getElementById("secondLevel").style.visibility="visible";
			
		}
		else if(str=="district")
		{
			//Retrieve District names here using Ajax
			var elSel = document.getElementById("secondLevel1");
			elSel.options[elSel.length] = new Option('Total','total');
			elSel.options[elSel.length] = new Option('Rural vs. Urban','rural_urban');
			elSel.options[elSel.length] = new Option('Tribal vs. Non-Tribal','tribal_nontribal');
			document.getElementById("secondLevel").style.visibility="visible";
		}
		else if(str=="project")
		{
			//Retrieve District Names here using Ajax
			// and then Retrieve Project Names
			var elSel = document.getElementById("secondLevel1");
			elSel.options[elSel.length] = new Option('Total','total');
			elSel.options[elSel.length] = new Option('Rural vs. Urban','rural_urban');
			elSel.options[elSel.length] = new Option('Tribal vs. Non-Tribal','tribal_nontribal');
			document.getElementById("secondLevel").style.visibility="visible";
		}
		else
		{
		}
	}

	function clearsentTrans()
	{       
		document.myform.sentTrans.value = "";
		document.myform.submitbutton.value="next";
		document.myform.string.value="null";
		document.myform.displayTemp.value = "";
	}

	
	function submitTrans()
	{
		var analysisBy = document.getElementById("timewise").value;
		var firstlevel = document.getElementById("firstLevel").value;
		var secondlevel = document.getElementById("secondLevel").value;
		document.getElementById("extra").style.visibility="visible";
		//alert("check");

			var xmlhttp;
			if (window.XMLHttpRequest)
		  	{// code for IE7+, Firefox, Chrome, Opera, Safari
		  	xmlhttp=new XMLHttpRequest();
		  	}
			else
		  	{// code for IE6, IE5
		  	xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		  	}

			xmlhttp.onreadystatechange=function()
		  	{
		  	if (xmlhttp.readyState==4 && xmlhttp.status==200)
		    	{
				if(xmlhttp.responseText != "")
			    	{
					var data_string  = xmlhttp.responseText;
					//alert(data_string);
					//document.getElementById("tablespace").innerHTML = data_string.split("|||")[0];
					var strXML = "<graph caption='Percent Girls / Boys Area wise' formatNumberScale='0' decimalPrecision='0'>";
					var strTable="";
					var i=0;
					for (i=0;i<data_string.split("|||").length;i++)
					{
						var strDataURL = data_string.split("|||")[i];
						var arSubData = strDataURL.split("~~");
						var arSubDataName = arSubData[0].replace('\"','');
						arSubDataName = arSubDataName.replace('\"','');
						//alert(arSubData[1]);
						if(arSubData[1].length==0 || !arSubData[1])
							continue;
						strTable+= arSubDataName+" "+arSubData[2]+"<br \/\>";
						//alert(strXML);
						strXML += "<set name='"+ arSubDataName +"' value='" + ((arSubData[2]*100)/(arSubData[1])) +"' color='AFD8F8' \/\>";
						//alert(strXML);
						if(i>10)
							break;
					}
					strXML += "</graph>";
					str_last=strXML;
					//updateChart(strXML);
					updateChartHigh(data_string);
					updateTable(strTable);

			      }
		    	}
		  	}
			xmlhttp.open("POST","get_data.php",true);
			xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
			//alert("check2");
			xmlhttp.send(); 
			
	}
	function updateChart(str){
				//Create another instance of the chart.
				var chart1 = new FusionCharts('FusionChartsFree/Code/FusionCharts/FCF_Column2D.swf', "", "1200", "300", "0", "0");		   
				chart1.setDataXML(str);
				chart1.render("graphspace");
				str_last=str;
			}

	function changeChart(strtype){
				//Create another instance of the chart.
				var chart1 = new FusionCharts(strtype, "", "1200", "300", "0", "0");		   
				chart1.setDataXML(str_last);
				chart1.render("graphspace");
			}
	

	function updateTable(str){
		document.getElementById("tablespace").innerHTML = str;
	}



function updateChartHigh(data_string){


		$(function () {
		    var chart;
		   
		var categories1 = new Array();		
		for (var i=0;i<data_string.split("|||").length;i++){
			var strTemp = data_string.split("|||")[i].split("~~")[0];
			categories1.push(strTemp);
			if(i>10)
				break;
		}

		var values1 = new Array();		
		for (var i=0;i<data_string.split("|||").length;i++){
			var strTemp = parseInt(data_string.split("|||")[i].split("~~")[2])*100/parseInt(data_string.split("|||")[i].split("~~")[1]);
			values1.push(parseFloat(strTemp));
			if(i>10)
				break;
		}

		    $(document).ready(function() {
			chart = new Highcharts.Chart({
			    chart: {
				renderTo: 'graphspace',
				type: 'column'
			    },
			    title: {
				text: 'Percent Girls/Boys Ratio'
			    },
			    subtitle: {
				text: 'For checking'
			    },
			    xAxis: {
				categories: 
					     categories1
				
			    },
			    yAxis: {
				min: 0,
				title: {
				    text: 'Rainfall (mm)'
				}
			    },
			    legend: {
				layout: 'vertical',
				backgroundColor: '#FFFFFF',
				align: 'left',
				verticalAlign: 'top',
				x: 100,
				y: 70,
				floating: true,
				shadow: true
			    },
			    tooltip: {
				formatter: function() {
				    return ''+
				        this.x +': '+ this.y +' mm';
				}
			    },
			    plotOptions: {
				column: {
				    pointPadding: 0.2,
				    borderWidth: 0
				}
			    },
				series: [{
				name: 'Project Wise',
				data: values1
		    
			    }]
			});
		    });
		    
		});
	}



</script>


</head>
<body>
<h2> Maharashtra Anganwadi Data - MPRs </h2>
<br/>
<br/>
<table>
<tr>
<td width="25%">
Do Analysis by
<select  id= "timewise" name="timwise" onclick="">
  <option value="select">Select</option>
  <option value="maharashtra">Year</option>
  <option value="district">Quarter</option>
  <option value="project">Month</option>
</select>
<br/><br/>
</td>
</tr>
<tr>
<td width="25%">
Select Level of Analysis
<select  id= "firstLevel" name="firstLevel" onclick=trychange(this.value);>
  <option value="select">Select</option>
  <option value="maharashtra">Maharashtra</option>
  <option value="district">District</option>
  <option value="project">Project</option>
  <option value="other">Other</option>
</select>
</td>
<td width="25%"> 
<div id="secondLevel" style="visibility:hidden">
Select Level of Analysis
<select id="secondLevel1" onclick="">
<option value="select">Select</option>
</select>
</div></td>
<td>

</td>
<td>

</td>
</tr>
</table>
<br/>
<br/>
<form name="form1">
<input type="button" value="submit" align="right" onclick="submitTrans();">
</form>
<div id="extra" align='center' style="visibility:hidden">
<div id="graphspace">

</div>
<input type="button" value="Column Chart" align="center" onclick="changeChart('FusionChartsFree/Charts/FCF_Column2D.swf');">
<input type="button" value="Line Chart" align="center" onclick="changeChart('FusionChartsFree/Charts/FCF_Line.swf');">
<input type="button" value="Area Chart" align="center" onclick="changeChart('FusionChartsFree/Code/FusionCharts/FCF_Area2D.swf');">
</div>
<div id="tablespace">
<div>

</body>
</html>
