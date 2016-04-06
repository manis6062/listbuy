//Scripts for the complete site.

// Functions for trailing spaces.
function trim(strText) { 
		// this will get rid of leading spaces
		while (strText.substring(0,1) == ' ')
			strText = strText.substring(1, strText.length);

		// this will get rid of trailing spaces
		while (strText.substring(strText.length-1,strText.length) == ' ')
			strText = strText.substring(0, strText.length-1);
		var pos=0
		var tevePos=0
		while(strText.indexOf("\n",pos)>-1)
		{
			tevePos=strText.indexOf("\n",pos)
			pos=tevePos+1
		}
		
	   return strText;
}

// Functions for combo selected.
function selectcombo(strFormName,strCboName,strval)
{
		for (var i=0; i<eval("document."+strFormName+"."+strCboName+".options.length"); i++)
		{
			if (eval("document."+strFormName+"."+strCboName+".options[i].value")==strval)
			{
				var objFrm = eval("document."+strFormName);
				objFrm[strCboName].options[i].selected=true;
				break;
			}
		}
}

// Functions for radio selected.
function selectradio(strFormName,strradName,strval)
{
		var objFrm = eval("document."+strFormName);
		for (var i=0; i <objFrm.elements.length; i++)
		   {
				if(objFrm.elements[i].type=="radio")
				{
					if(objFrm.elements[i].name == strradName)
					{
						if(objFrm.elements[i].value == strval)
						{
							objFrm.elements[i].checked=true;
						}
					}
				}
		   }
}
// Functions for checkbox selected.
function selectcheck(strFormName,strchkName,strval)
{
		var objFrm = eval("document."+strFormName);
		for (var i=0; i <objFrm.elements.length; i++)
		   {
				if(objFrm.elements[i].type=="checkbox")
				{
					if(objFrm.elements[i].name==strchkName)
					{
						if(strval!="")
						{
							objFrm.elements[i].checked=true;
						}
					}
				}
		   }

}

//Function for alpha-numeric|numeric check
function keyRestrict(e, validchars) {
	 var key='', keychar='';
	 key = getKeyCode(e);
	 if (key == null) return true;
	 keychar = String.fromCharCode(key);
	 keychar = keychar.toLowerCase();
	 validchars = validchars.toLowerCase();
	 if (validchars.indexOf(keychar) != -1)
	  return true;
	 if ( key==null || key==0 || key==8 || key==9 || key==13 || key==27 )
	  return true;
	 return false;
}
function getKeyCode(e) {
	 if (window.event)
		return window.event.keyCode;
	 else if (e)
		return e.which;
	 else
		return null;
}

//Function for image type check
function chkimage(image)
{
	var val = trim(image);
	strlen = val.length;
	strcnt = val.lastIndexOf("\\");
	newstr = val.substr(strcnt+1,strlen);
	tempval = val.toUpperCase();
	val = tempval.substr(val.lastIndexOf("."),val.length);

	if(((val.length==4 )&&((val!='.JPG')  &&  (val!='.GIF')  &&  (val!='.PNG'))) || ((val.length==5 )&&(val!='.JPEG'))) 
	{
		return false;
	}
	else
	{
		return true;
	}
}

function chkpdfdoc(image)
{
	var val = trim(image);
	strlen = val.length;
	strcnt = val.lastIndexOf("\\");
	newstr = val.substr(strcnt+1,strlen);
	tempval = val.toUpperCase();
	val = tempval.substr(val.lastIndexOf("."),val.length);

	if((val!='.PDF') && (val!='.DOC'))   
	{
		return false;
	}
	else
	{
		return true;
	}
}

function chkpdf(image)
{
	var val = trim(image);
	strlen = val.length;
	strcnt = val.lastIndexOf("\\");
	newstr = val.substr(strcnt+1,strlen);
	tempval = val.toUpperCase();
	val = tempval.substr(val.lastIndexOf("."),val.length);

	if(val!='.PDF')    
	{
		return false;
	}
	else
	{
		return true;
	}
}


//Function for voice type check
function chkvoice(voice)
{
	var val = trim(voice);
	strlen = val.length;
	strcnt = val.lastIndexOf("\\");
	newstr = val.substr(strcnt+1,strlen);
	tempval = val.toUpperCase();
	val = tempval.substr(val.lastIndexOf("."),val.length);

	if((val.length==4)&&((val!='.MP3')) )
	{
		return false;
	}
	else
	{
		return true;
	}
}
function chkdoc(docfile)
{
	var val = trim(docfile);
	strlen = val.length;
	strcnt = val.lastIndexOf("\\");
	newstr = val.substr(strcnt+1,strlen);
	tempval = val.toUpperCase();
	val = tempval.substr(val.lastIndexOf("."),val.length);

	if((val.length==4)&&((val!='.DOC')  &&  (val!='.PDF')) )
	{
		return false;
	}
	else
	{
		return true;
	}
}
