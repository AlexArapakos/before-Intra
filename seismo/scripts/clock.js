function clk() 
{
var timerID = null;
var timerRunning = false;

if(timerRunning)
	clearTimeout(timerID);
	timerRunning = false;

var timeNow = new Date();
var hours = timeNow.getHours();
var minutes = timeNow.getMinutes();
var seconds = timeNow.getSeconds();
var timeValue = "" + ((hours >12) ? hours -12 :hours)
timeValue = ((timeValue <10)? "0":"") + timeValue
timeValue += ((minutes < 10) ? ":0" : ":") + minutes
timeValue += ((seconds < 10) ? ":0" : ":") + seconds
timeValue += (hours >= 12) ? " pm" : " am"
timerID = setTimeout("clk()",1000);
timerRunning = true;

var dateNow = new Date();
var days = new Array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');
var months = new Array('January','February','March','April','May','June','July','August','September','October','November','December');
var date = ((dateNow.getDate()<10) ? "0" : "")+ dateNow.getDate();

function y2k(number)
{
  return (number < 1000) ? number + 1900 : number;
}

today =  days[dateNow.getDay()] +" "+date+" "+months[dateNow.getMonth()]+" "+(y2k(dateNow.getYear()))+", "+timeValue;
                
document.getElementById("clk").innerHTML=today.toString(); 
}

clk();




