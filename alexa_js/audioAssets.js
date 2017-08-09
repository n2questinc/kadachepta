// 'use strict';
//
// // Audio Source - AWS Podcast : https://aws.amazon.com/podcasts/aws-podcast/
// var audioData = [
//     {
//         'title' : 'Episode 140',
//         'url' : 'https://feeds.soundcloud.com/stream/275202399-amazon-web-services-306355661-amazon-web-services.mp3'
//     },
//     {
//         'title' : 'Episode 139',
//         'url' : 'https://feeds.soundcloud.com/stream/274166909-amazon-web-services-306355661-aws-podcast-episode-139.mp3'
//     }
// ];
//
// module.exports = audioData;

'use strict';

var request = require('sync-request');
var xml2js = require('xml2js');
var res = request('GET',"http://n2quest.com/feed");
var parseString = xml2js.parseString;
var audioData = [
  {
    title: 'Attarintiki Daredi',
    url: 'https://n2quest.com/wp-content/uploads/2017/08/2.mp3'
  }
];

parseString(res.getBody(), function(err,result){
        var stories = result['rss']['channel'][0]['item'];

		console.log("Total stories: " + stories.length);

		stories.forEach(function(entry) {
			var singleObj = {}
			singleObj['title'] = entry['title'][0];
//			console.log(singleObj['title']);
			singleObj['url'] = entry['enclosure'][0].$.url.replace("http", "https");
//			console.log(singleObj['url']);
			audioData.push(singleObj);
		});
});

console.log(audioData);

module.exports = audioData;
