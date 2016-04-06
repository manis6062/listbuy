var xmlHttp1

function showConfirm(ID,M)
{

document.frm.id.value=ID;
xmlHttp1=GetXmlHttpObject()
if (xmlHttp1==null)
  {
  alert ("Browser does not support HTTP Request")
  return false;
  }
//var cc = document.frm.country_id.value;
var url = "js/ajax_getconfirm.php"
url = url+"?p="+ID+"&m="+M
url = url+"&sid="+Math.random()
xmlHttp1.onreadystatechange=stateChanged 
xmlHttp1.open("GET",url,true)
xmlHttp1.send(null)
return false;
} 

function stateChanged() 
{ 
	if (xmlHttp1.readyState==4 || xmlHttp1.readyState=="complete")
	 { 
	  //alert("bdjbsjkd");
	 document.getElementById("dispconfirm").innerHTML=xmlHttp1.responseText
	// window.location.href("home.html")
	 } 
}

function GetXmlHttpObject()
{
	var xmlHttp1=null;
	try
	 {
		 // Firefox, Opera 8.0+, Safari
		xmlHttp1=new XMLHttpRequest();
	 }
	catch (e)
	 {
		 // Internet Explorer
	 try
	  {
		xmlHttp1=new ActiveXObject("Msxml2.XMLHTTP");
	  }
	 catch (e)
	  {
	  	xmlHttp1=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	 }
	return xmlHttp1;
}