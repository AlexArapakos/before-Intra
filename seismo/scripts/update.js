function updateDatabase()
{
	showForm(400,150);
	document.getElementById("boxForm").innerHTML='<div id="squareTitle" class="squareTitle">'
												+'<table align="center" border="0" cellpadding="0" cellspacing="0" width="350">'
												+'<tr><td align="left">&nbsp;Updating Database</td>'
												+'<td align="right"><div class="smallText">'
												+'[<a href="#" onclick="hideForm()">Close</a>]&nbsp;</div></td></tr></table></div>'
												+'<div id="squareContent" class="squareContent"></div>';
	document.getElementById('squareTitle').innerHTML="Executing query...";
	document.getElementById('boxForm').style.height="80px";
	document.getElementById('squareContent').innerHTML='<table align="center" border="0" cellpadding="0" cellspacing="5" width="300"><tr>'
													  +'<td>Please wait while updating database...</td>'
													  +'<td><img alt="Updating database..." title="Updating database..." src="img/queryExecution.gif"></td>'
													  +'</tr></table>';	
	getGINOA();				
}

function getGINOA()
{	

	var searchUrl = 'contents/dbQueries/updateDatabase.php';
    
	var dStart = new Date();
    
	GDownloadUrl(searchUrl, function(data, responseCode)
	{
		if(responseCode == 200)
		{
			//alert("data="+data);
			var xml = parseXML(data);
			var result = xml.getElementsByTagName('entriesUpdated');
			var num = result[0].getAttribute('num');
			//alert("num of updated entries = "+num);
			if (num=="error1")
				document.getElementById('status').innerHTML = "<div class='err'>Error1 during updating Database.</div>";
			else if (num=="error2")
				document.getElementById('status').innerHTML = "<div class='err'>Error2 during updating Database.</div>";
			else if (num=="error3")
				document.getElementById('status').innerHTML = "<div class='err'>Error3 during updating Database.</div>";
			else if (num=="error4")
				document.getElementById('status').innerHTML = "<div class='err'>Error4 during updating Database.</div>";
			else if (num=="error5")
				document.getElementById('status').innerHTML = "<div class='err'>Error5 during updating Database.</div>";
			else if (num=="error6")
				document.getElementById('status').innerHTML = "<div class='err'>Error6 during updating Database.</div>";
			else if (num=="error7")
				document.getElementById('status').innerHTML = "<div class='err'>Error7 during updating Database.</div>";
			else
			{
				var dEnd=new Date();
				var executionTime=dEnd.getTime()-dStart.getTime();
				document.getElementById('status').innerHTML ="Database updated succesfully in "+executionTime+ " milliseconds and wrote "+num+ " new entries.";
			}
			hideForm();
		}
		else if(responseCode == -1) 
		{
			alert("Data request timed out. Please try later.");
		}
		else
		{ 
			alert("Request resulted in error. Check XML file is retrievable.");
		}
	});
}