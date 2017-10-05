var FOURTHPI    = Math.PI / 4;
var DEG_2_RAD   = Math.PI / 180;
var RAD_2_DEG   = 180.0 / Math.PI;
var BLOCK_SIZE  = 100000;
var USNGSqEast = "ABCDEFGHJKLMNPQRSTUVWXYZ";
var EASTING_OFFSET  = 500000.0;   // (meters)
var NORTHING_OFFSET = 10000000.0; // (meters)
var k0 = 0.9996;
var  EQUATORIAL_RADIUS  = 6378137.0;   
var  ECC_SQUARED = 0.006694380023; 
var ECC_PRIME_SQUARED = ECC_SQUARED / (1 - ECC_SQUARED);
var E1 = (1 - Math.sqrt(1 - ECC_SQUARED)) / (1 + Math.sqrt(1 - ECC_SQUARED));

function GUsngtoLL(str, zoom) 
{
	var latlon=[];  
  	var usngp = new Object();

   	if(parseUSNG_str(str,usngp)==false)
		return false;
   	var coords = new Object();
   
   	USNGtoUTM(usngp.zone,usngp.let,usngp.sq1,usngp.sq2,usngp.east,usngp.north,coords); 
   
   	if (usngp.let < 'N')    
      	coords.N -= NORTHING_OFFSET;   

   	UTMtoLL(coords.N, coords.E, usngp.zone, coords);
   	latlon[0] = coords.lat;
   	latlon[1] = coords.lon;
   
   	map.setCenter(new GLatLng(latlon[0],latlon[1]), zoom);  
	
	return true;
}

function parseUSNG_str(usngStr_input, parts)
{
   var j = 0;
   var k;
   var usngStr = [];
   var usngStr_temp = [];

   usngStr_temp = usngStr_input.toUpperCase();
   
   var regexp = /%20/g;
   usngStr = usngStr_temp.replace(regexp,"");
   regexp = / /g;
   usngStr = usngStr_temp.replace(regexp,"");

   if (usngStr.length < 7) 
   {
      alert("This application requires minimum USNG precision of 10,000 meters");
      return false;
   }
   
   parts.zone = usngStr.charAt(j++)*10 + usngStr.charAt(j++)*1;
   parts.let = usngStr.charAt(j++)
   parts.sq1 = usngStr.charAt(j++)
   parts.sq2 = usngStr.charAt(j++)

   parts.precision = (usngStr.length-j) / 2;
   parts.east='';
   parts.north='';
   for (var k=0; k<parts.precision; k++) 
   {
       parts.east += usngStr.charAt(j++)
   }

   if (usngStr[j] == " ") 
  		j++; 
   for (var k=0; k<parts.precision; k++) 
   {
       parts.north += usngStr.charAt(j++)
   }
   return true;
}

function USNGtoUTM(zone,let,sq1,sq2,east,north,ret) 
{ 
  	var zoneBase = [1.1,2,0,2.9,3.8,4.7,5.6,6.5,7.3,8.2,9.1,   0, 0.8, 1.7, 2.6, 3.5, 4.4, 5.3, 6.2, 7.0, 7.9];
  	var segBase = [0,2,2,2,4,4,6,6,8,8,   0,0,0,2,2,4,4,6,6,6];  

  	var eSqrs=USNGSqEast.indexOf(sq1);          
  	var appxEast=1+eSqrs%8; 

  	var letNorth = "CDEFGHJKLMNPQRSTUVWX".indexOf(let);
  	if (zone%2)  
  		var nSqrs="ABCDEFGHJKLMNPQRSTUV".indexOf(sq2) 
  	else        
    	var nSqrs="FGHJKLMNPQRSTUVABCDE".indexOf(sq2); 

  	var zoneStart = zoneBase[letNorth];
  	var appxNorth = Number(segBase[letNorth])+nSqrs/10;
  	if ( appxNorth < zoneStart)
       appxNorth += 2; 	  

  	ret.N=appxNorth*1000000+Number(north)*Math.pow(10,5-north.length);
  	ret.E=appxEast*100000+Number(east)*Math.pow(10,5-east.length)
  	ret.zone=zone;
  	ret.letter=let;

  	return;
} 

function UTMtoLL(UTMNorthing, UTMEasting, UTMZoneNumber, ret) 
{  
  var xUTM = parseFloat(UTMEasting) - EASTING_OFFSET; 
  var yUTM = parseFloat(UTMNorthing);
  var zoneNumber = parseInt(UTMZoneNumber);

  var lonOrigin = (zoneNumber - 1) * 6 - 180 + 3; 

  var M = yUTM / k0;
  var mu = M / ( EQUATORIAL_RADIUS * (1 - ECC_SQUARED / 4 - 3 * ECC_SQUARED * 
                  ECC_SQUARED / 64 - 5 * ECC_SQUARED * ECC_SQUARED * ECC_SQUARED / 256 ));

  var phi1Rad = mu + (3 * E1 / 2 - 27 * E1 * E1 * E1 / 32 ) * Math.sin( 2 * mu) 
                 + ( 21 * E1 * E1 / 16 - 55 * E1 * E1 * E1 * E1 / 32) * Math.sin( 4 * mu)
                 + (151 * E1 * E1 * E1 / 96) * Math.sin(6 * mu);
  var phi1 = phi1Rad * RAD_2_DEG;

  var N1 = EQUATORIAL_RADIUS / Math.sqrt( 1 - ECC_SQUARED * Math.sin(phi1Rad) * 
              Math.sin(phi1Rad));
  var T1 = Math.tan(phi1Rad) * Math.tan(phi1Rad);
  var C1 = ECC_PRIME_SQUARED * Math.cos(phi1Rad) * Math.cos(phi1Rad);
  var R1 = EQUATORIAL_RADIUS * (1 - ECC_SQUARED) / Math.pow(1 - ECC_SQUARED * 
                Math.sin(phi1Rad) * Math.sin(phi1Rad), 1.5);
  var D = xUTM / (N1 * k0);

  var lat = phi1Rad - ( N1 * Math.tan(phi1Rad) / R1) * (D * D / 2 - (5 + 3 * T1 + 10
        * C1 - 4 * C1 * C1 - 9 * ECC_PRIME_SQUARED) * D * D * D * D / 24 + (61 + 90 * 
          T1 + 298 * C1 + 45 * T1 * T1 - 252 * ECC_PRIME_SQUARED - 3 * C1 * C1) * D * D *
          D * D * D * D / 720);
  lat = lat * RAD_2_DEG;

  var lon = (D - (1 + 2 * T1 + C1) * D * D * D / 6 + (5 - 2 * C1 + 28 * T1 - 3 * 
            C1 * C1 + 8 * ECC_PRIME_SQUARED + 24 * T1 * T1) * D * D * D * D * D / 120) /
            Math.cos(phi1Rad);

  lon = lonOrigin + lon * RAD_2_DEG;
  ret.lat = lat;
  ret.lon = lon;
  return;
}
