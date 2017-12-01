var GeoDFP = [];
GeoDFP['D'] = '';
GeoDFP['CC'] = '';
GeoDFP['S'] = '';
if ($.cookie('GeoDFP')) {
	GeoJson = JSON.parse($.cookie('GeoDFP'));
	
	GeoDFP['D'] = GeoJson['DFP']['D'];
	GeoDFP['CC'] = GeoJson['DFP']['CC'];
	GeoDFP['S'] = GeoJson['DFP']['S'];
	
}
else {
	$.ajax({ 
			url:'http://geodds.api.nextmedia.com/geo_api?format=DFP', 
			dataType: 'json', 
			success: function(response) {
											$.cookie('GeoDFP', JSON.stringify(response));
											GeoDFP['D'] = response['DFP']['D'];
											GeoDFP['CC'] = response['DFP']['CC'];
											GeoDFP['S'] = response['DFP']['S'];											
										},
			error: function(){}
	});
}