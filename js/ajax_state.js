var xmlHttp

function showState(ID)
{


xmlHttp=GetXmlHttpObject()
if (xmlHttp==null)
  {
  alert ("Browser does not support HTTP Request")
  return false;
  }
//var cc = document.frm.country_id.value;
var url = "js/ajax_state.php"
url = url+"?country_id="+ID
url = url+"&sid="+Math.random()
xmlHttp.onreadystatechange=stateChanged 
xmlHttp.open("GET",url,true)
xmlHttp.send(null)
return false;
} 

function stateChanged() 
{ 
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	 { 
	  //alert("bdjbsjkd");
	 document.getElementById("TxtState").innerHTML=xmlHttp.responseText
	// window.location.href("home.html")
	 } 
}

function GetXmlHttpObject()
{
	var xmlHttp=null;
	try
	 {
		 // Firefox, Opera 8.0+, Safari
		xmlHttp=new XMLHttpRequest();
	 }
	catch (e)
	 {
		 // Internet Explorer
	 try
	  {
		xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
	  }
	 catch (e)
	  {
	  	xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	 }
	return xmlHttp;
}