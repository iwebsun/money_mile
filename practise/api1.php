<?php

/*
* Simple node app to get an access_token for a Brightcove API
* You will need to substitute valid client_id and client_secret values
* for {your_client_id} and {your_client_secret}
*/
var request = require('request');
var client_id = "e7fe0eb1-1524-46e0-b75c-299d49f69b1e";
var client_secret = "V2FiiMEnACRhjL5jwz0woDE7pEZF4DKpnzTC0QlDGN2z0nGOoJkn0bTjY-Oet--hMD9tXsj4VCr444hOgH-U0A";
var auth_string = new Buffer(client_id + ":" + client_secret).toString('base64');
console.log(auth_string);
request({
method: 'POST',
url: 'https://oauth.brightcove.com/v4/access_token',
headers: {
'Authorization': 'Basic ' + auth_string,
'Content-Type': 'application/x-www-form-urlencoded'
},
body: 'grant_type=client_credentials'
}, function (error, response, body) {
console.log('Status: ', response.statusCode);
console.log('Headers: ', JSON.stringify(response.headers));
console.log('Response: ', body);
console.log('Error: ', error);
});

?>