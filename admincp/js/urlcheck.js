// JavaScript Document
function urlcheck(str){
	var url="http://"
	var dot="."
	var lurl=str.indexOf(url)
	var ldot=str.indexOf(dot)	
	var lstr=str.length
	var j=0

	if (str.indexOf(url)==-1 || str.indexOf(url)>0){
	   alert("Invalid URL. Please provide http://")
	   return false
	}
	if (str.indexOf(dot)==-1 || str.indexOf(dot)==0 || str.indexOf(dot)==lstr){
		    alert("Invalid URL")
		    return false
	}
	if(str.indexOf(url,(lurl+1)) != -1){
		alert("Invalid URL")
		return false
	}
	if (str.substring(7,8)==dot || str.substring(lurl+8,lurl+9)==dot){
		    alert("Invalid URL")
		    return false
	}
	if (str.indexOf(dot,(lurl+2))==-1){
		alert("Invalid URL")
		return false
	}
	
	for(var i=lstr-1; i >= 0; i--){
		j++
		if(str.substr(i,1)==dot){
			break;
		}		
	}
	
	if(j>5 || j<3){
		alert("Domain Must within 2 to 4 chars")
		return false
	}
	if (str.indexOf(" ")!=-1){
		alert("Invalid URL")
		return false
	}

	 return true
}
