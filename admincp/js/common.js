if(window.ActiveXObject) {
	try {
		var oHTTP = new ActiveXObject("Msxml2.XMLHTTP");
	} 
	catch(e) {
		var oHTTP = new ActiveXObject("Microsoft.XMLHTTP");
	}
} 
else {
	var oHTTP = new XMLHttpRequest();
}


/*******************************************************
For Check User Details
*******************************************************/
function updateStatus(status, id){
	updateStatusDisplay(id, 'ajax_call.php?mode=status&status='+status+'&promotional_id='+id);
	return false;
}

function updateStatusDisplay(id, page) {
	oHTTP.open("POST", page, true);
	oHTTP.onreadystatechange=function() {
		if (oHTTP.readyState==4) {
			var getValue=oHTTP.responseText;
			if(getValue == "Active") {
				getID = "idStatus_"+id;
				document.getElementById(getID).innerHTML = '<a href="#" onclick="updateStatus(0, '+id+');"><img src="images/bt_active.png" alt="Click to Inactive" border="0" /></a>';
			}
			else {
				getID = "idStatus_"+id;
				document.getElementById(getID).innerHTML = '<a href="#" onclick="updateStatus(1, '+id+');"><img src="images/btn_deactive.png" alt="Click to Active" border="0" /></a>';
			}
		}
	}
	oHTTP.send(null);
}

/*******************************************************
For Check User Details
*******************************************************/
function checkUserName(){
	if(document.forms['frm'].elements['email'].value==""){
		document.getElementById('textContentHTML').innerHTML = 'Please enter email ID.';
		document.getElementById('theLayer').style.visibility = 'visible';	
		return false;
	}
	var userLoginName = document.forms['frm'].elements['email'].value;
	
	checkUser('ajax_call.php?mode=check_username&email='+userLoginName+'');
}

function checkUser(page) {
	oHTTP.open("POST", page, true);
	oHTTP.onreadystatechange=function() {
		if (oHTTP.readyState==4) {
			var getValue=oHTTP.responseText;
			document.getElementById('textContentHTML').innerHTML = getValue;
			document.getElementById('theLayer').style.visibility = 'visible';
		}
	}
	oHTTP.send(null);
}

