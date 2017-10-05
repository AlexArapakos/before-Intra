var pi = 3.14159265358979;

var sm_a = 6378137.0;
var sm_b = 6356752.314;
var sm_EccSquared = 6.69437999013e-03;
var UTMScaleFactor = 0.9996;

function utmToLatLon(zoneNumber, hemishphere, easting, northing, zoom)
{	
	latlon = new Array(2);
    var x, y, zone, southhemi;
	
	if (isNaN (parseInt (zoneNumber.value))) 
	{
    	alert ("Please enter a valid UTM zone.");
        return false;
    }

    zone = parseFloat (zoneNumber.value);

    if ((zone < 1) || (60 < zone)) 
	{
    	alert ("The UTM zone you entered is out of range. Please enter a number in the range [1, 60].");
        return false;
    }
	
	if(hemishphere.value=="S")
		southhemi = true;
	else
        southhemi = false;     
        
    if (isNaN (parseFloat (easting.value))) 
	{
    	alert ("Please enter a valid easting.");
        return false;
    }

    x = parseFloat (easting.value);

    if (isNaN (parseFloat (northing.value))) 
	{
     	alert ("Please enter a valid northing.");
        return false;
    }

    y = parseFloat (northing.value);   	   

    UTMXYToLatLon (x, y, zone, southhemi, latlon);
	
	map.setCenter(new GLatLng(RadToDeg (latlon[0]),RadToDeg (latlon[1])), zoom);   
      
    return true;	
}

function UTMXYToLatLon (x, y, zone, southhemi, latlon)
{
	var cmeridian;
        	
	x -= 500000.0;
    x /= UTMScaleFactor;        	
        
    if (southhemi)
    	y -= 10000000.0;
        		
    y /= UTMScaleFactor;
        
    cmeridian = UTMCentralMeridian (zone);
    MapXYToLatLon (x, y, cmeridian, latlon);
        	
    return;
}

function MapXYToLatLon (x, y, lambda0, philambda)
{
	var phif, Nf, Nfpow, nuf2, ep2, tf, tf2, tf4, cf;
    var x1frac, x2frac, x3frac, x4frac, x5frac, x6frac, x7frac, x8frac;
    var x2poly, x3poly, x4poly, x5poly, x6poly, x7poly, x8poly;

    phif = FootpointLatitude (y);
        	        
    ep2 = (Math.pow (sm_a, 2.0) - Math.pow (sm_b, 2.0)) / Math.pow (sm_b, 2.0);
                
    cf = Math.cos (phif);

    nuf2 = ep2 * Math.pow (cf, 2.0);
        	
	Nf = Math.pow (sm_a, 2.0) / (sm_b * Math.sqrt (1 + nuf2));
    Nfpow = Nf;        	
        
    tf = Math.tan (phif);
    tf2 = tf * tf;
    tf4 = tf2 * tf2;
        
    x1frac = 1.0 / (Nfpow * cf);        
    Nfpow *= Nf;   
    x2frac = tf / (2.0 * Nfpow);        
    Nfpow *= Nf;   
    x3frac = 1.0 / (6.0 * Nfpow * cf);        
    Nfpow *= Nf;   
    x4frac = tf / (24.0 * Nfpow);        
    Nfpow *= Nf;  
    x5frac = 1.0 / (120.0 * Nfpow * cf);        
    Nfpow *= Nf;  
    x6frac = tf / (720.0 * Nfpow);        
    Nfpow *= Nf;   
    x7frac = 1.0 / (5040.0 * Nfpow * cf);        
    Nfpow *= Nf;   
    x8frac = tf / (40320.0 * Nfpow);
    x2poly = -1.0 - nuf2;        
    x3poly = -1.0 - 2 * tf2 - nuf2;        
    x4poly = 5.0 + 3.0 * tf2 + 6.0 * nuf2 - 6.0 * tf2 * nuf2 - 3.0 * (nuf2 *nuf2) - 9.0 * tf2 * (nuf2 * nuf2);        
    x5poly = 5.0 + 28.0 * tf2 + 24.0 * tf4 + 6.0 * nuf2 + 8.0 * tf2 * nuf2;        
    x6poly = -61.0 - 90.0 * tf2 - 45.0 * tf4 - 107.0 * nuf2	+ 162.0 * tf2 * nuf2;        
    x7poly = -61.0 - 662.0 * tf2 - 1320.0 * tf4 - 720.0 * (tf4 * tf2);        
    x8poly = 1385.0 + 3633.0 * tf2 + 4095.0 * tf4 + 1575 * (tf4 * tf2);        	
        
    philambda[0] = phif + x2frac * x2poly * (x * x)	+ x4frac * x4poly * Math.pow (x, 4.0) + x6frac * x6poly * Math.pow (x, 6.0)
        	+ x8frac * x8poly * Math.pow (x, 8.0);
                
    philambda[1] = lambda0 + x1frac * x	+ x3frac * x3poly * Math.pow (x, 3.0) + x5frac * x5poly * Math.pow (x, 5.0)
        	+ x7frac * x7poly * Math.pow (x, 7.0);
        	
    return;
}

function UTMCentralMeridian (zone)
{
	var cmeridian;
    cmeridian = DegToRad (-183.0 + (zone * 6.0));    
    return cmeridian;
}

function FootpointLatitude (y)
{
	var y_, alpha_, beta_, gamma_, delta_, epsilon_, n;
    var result;

    n = (sm_a - sm_b) / (sm_a + sm_b);        	
    alpha_ = ((sm_a + sm_b) / 2.0) * (1 + (Math.pow (n, 2.0) / 4) + (Math.pow (n, 4.0) / 64));
    y_ = y / alpha_;         
    beta_ = (3.0 * n / 2.0) + (-27.0 * Math.pow (n, 3.0) / 32.0) + (269.0 * Math.pow (n, 5.0) / 512.0);	
    gamma_ = (21.0 * Math.pow (n, 2.0) / 16.0) + (-55.0 * Math.pow (n, 4.0) / 32.0);
    delta_ = (151.0 * Math.pow (n, 3.0) / 96.0) + (-417.0 * Math.pow (n, 5.0) / 128.0);	
    epsilon_ = (1097.0 * Math.pow (n, 4.0) / 512.0);
    result = y_ + (beta_ * Math.sin (2.0 * y_)) + (gamma_ * Math.sin (4.0 * y_)) + (delta_ * Math.sin (6.0 * y_))
            + (epsilon_ * Math.sin (8.0 * y_));
        
    return result;
}

function DegToRad (deg)
{
	return (deg / 180.0 * pi)
}

function RadToDeg (rad)
{
    return (rad / pi * 180.0)
}

