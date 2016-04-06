var xmlHttp13

function imgcode()
{


xmlHttp13=GetXmlHttpObject()
if (xmlHttp13==null)
  {
  alert ("Browser does not support HTTP Request")
  return false;
  }
//var cc = document.frm.country_id.value;
var url = "ajax_imgcode.php"
url = url+"?sid="+Math.random()
xmlHttp13.onreadystatechange=stateChanged13
xmlHttp13.open("GET",url,true)
xmlHttp13.send(null)
return false;
} 

function stateChanged13() 
{ 
	if (xmlHttp13.readyState==4 || xmlHttp13.readyState=="complete")
	 { 
	  //alert("bdjbsjkd");
	  var mmm=xmlHttp13.responseText;
	  //alert(mmm);
	 document.getElementById("imgco").innerHTML=xmlHttp13.responseText
	 
	// window.location.href("home.html")
	 } 
}

function GetXmlHttpObject()
{
	var xmlHttp13=null;
	try
	 {
		 // Firefox, Opera 8.0+, Safari
		xmlHttp13=new XMLHttpRequest();
	 }
	catch (e)
	 {
		 // Internet Explorer
	 try
	  {
		xmlHttp13=new ActiveXObject("Msxml2.XMLHTTP");
	  }
	 catch (e)
	  {
	  	xmlHttp13=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	 }
	return xmlHttp13;
}