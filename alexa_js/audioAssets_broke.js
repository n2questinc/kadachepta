'use strict';

var asyncrequest = require('request');
var xml2js = require('xml2js');
var parseString = xml2js.parseString;
var audioData = [];

asyncrequest("http://n2quest.com/feed", function(error, responsemeta, body) {

	parseString(body, function(err, result){
			var stories = result['rss']['channel'][0]['item'];

			console.log("Total stories: " + stories.length);

			stories.forEach(function(entry) {
				var singleObj = {}
				singleObj['title'] = entry['title'][0];
				singleObj['value'] = entry['enclosure'][0].$.url;
				audioData.push(singleObj);
			});
	});
	console.dir(audioData);
});

module.exports = audioData;
console.log("Program ended");
