var BCLS = (function() {
    var account_id    = '5814665417001',
        client_id     = 'fc98d02c-7d9f-4863-b118-6da550e0932f',
        client_secret = 'RWglCpPUTAneCxzQATwz49ucnNJizIqLFHVxeHFjwsxi4Iw_yaMtxzrH9Ndn66V3qIC7Emb0AU4iSNRHgDUFZQ',
        getSearch     = document.getElementById('getSearch'),
        //apiRequest    = document.getElementById('apiRequest'),
        //requestBody   = document.getElementById('requestBody'),
        //apiResponse   = document.getElementById('apiResponse'),
        //generateKey = document.getElementById('generateKey'),
        allButtons    = document.getElementsByTagName('button'),
        searchStr     = document.getElementById('searchStr'),
        _csrfToken    = document.getElementById('_tokenSearch'),
        // api urls
        proxyURL      = 'http://localhost/MoneyMile/public/search/api',
        baseURL       = 'https://policy.api.brightcove.com/v1/accounts/',
        edgeURL       = 'https://edge.api.brightcove.com/playback/v1/accounts/',
        urlSuffix     = '/policy_keys';

    function processAjaxData(response, urlPath) { 

      document.getElementById('overlay').style.display = "none";
      document.getElementById("overlay").classList.remove("currently-loading");
      document.getElementById('dataDisplay').innerHTML = response;

      window.history.pushState({"pageTitle":response.pageTitle},"", '/searchStr');
    }

    /**
     * tests for all the ways a variable might be undefined or not have a value
     * @param {*} x the variable to test
     * @return {Boolean} true if variable is defined and has a value
     */
    function isDefined(x) {
        if ( x === '' || x === null || x === undefined) {
            return false;
        }
        return true;
    }

    /**
     * disables all buttons so user can't submit new request until current one finishes
     */
    function disableButtons() {
        var i,
            iMax = allButtons.length;
        for (i = 0; i < iMax; i++) {
            allButtons[i].setAttribute('disabled', 'disabled');
        }
    }

    /**
     * re-enables all buttons
     */
    function enableButtons() {
        var i,
            iMax = allButtons.length;
        for (i = 0; i < iMax; i++) {
            allButtons[i].removeAttribute('disabled');
        }
    }

    /**
     * sort an array of objects based on an object property
     * @param {array} targetArray - array to be sorted
     * @param {string|number} objProperty - object property to sort on
     * @return sorted array
     */
    function sortArray(targetArray, objProperty) {
        targetArray.sort(function (b, a) {
            var propA = a[objProperty], propB = b[objProperty];
            // sort ascending; reverse propA and propB to sort descending
            if (propA < propB) {
                 return -1;
            } else if (propA > propB) {
                 return 1;
            } else {
                 return 0;
            }
        });
        return targetArray;
    }

    function processSources(sources) {
        var i = sources.length;
        // remove non-MP4 sources
        // while (i > 0) {
        //     i--;
        //     if (sources[i].container !== 'MP4') {
        //         sources.splice(i, 1);
        //     } else if (sources[i].hasOwnProperty('stream_name')) {
        //         sources.splice(i, 1);
        //     }
        // }
        // sort sources by encoding rate
        sortArray(sources, 'encoding_rate');
        // return the first item (highest bitrate)
        return sources[0];
    }

    /**
     * sets up the data for the API request
     * @param {String} id the id of the button that was clicked
     */
    function setRequestData() {
        var options = {},
          body = {},
            callback = function(response) {
              response = JSON.parse(response);
              getPolicy( response["key-string"] );
              //apiResponse.textContent = JSON.stringify(response, null, '  ');
            }; 
        options.url = baseURL + account_id + urlSuffix;
        options.requestType = 'POST';
        body['key-data'] = {};
        body['key-data']['account-id'] = account_id;
        body['key-data'].apis = ["search"];
        //options.requestBody = JSON.stringify(body);
        if (isDefined(client_id) && isDefined(client_secret)) {
          options.client_id = client_id;
          options.client_secret = client_secret;
        }
        options.proxyURL = proxyURL;
        //apiRequest.textContent = options.url;
        //requestBody.textContent = JSON.stringify(JSON.parse(options.requestBody), null, '  ');
        console.log('options', options);
        makeRequest(options, callback);
    }

    function addItems() {
        var i, iMax, video, pubdate, eItem, videoURL, thumbnailURL, doThumbnail = true, tags='';
        tags += '<div id="videos">';
          if (videosArray.length > 0) {
            iMax = videosArray.length;
              for (i = 0; i < iMax; i += 1) {
                  video = videosArray[i];
                  // video may not have a valid source
                  if (isDefined(video.source) && isDefined(video.source.src)) {
                      videoURL = encodeURI(video.source.src.replace(/&/g, '&'));
                  } else {
                      videoURL = "";
                  }
                  // depending on when/how the video was created, it may have different thumbnail properties or none at all
                  if (isDefined(video.images) && isDefined(video.images.thumbnail)) {
                      thumbnailURL = encodeURI(video.images.thumbnail.sources[0].src.replace(/&/g, '&'));
                  } else if (isDefined(video.thumbnail)) {
                      thumbnailURL = encodeURI(video.thumbnail.replace(/&/g, '&'));
                  } else {
                      doThumbnail = false;
                  }

                  tags += '<div id="videos">';
                    tags += '<div class="thubnail">';
                      tags += '<img src="'+thumbnailURL+'" class="thumb" name="'+video.name+'" title="'+video.name+'" />';
                    tags += '</div>'
                    tags += '<label>'+video.name+'</label>';
                  tags += '</div>';
                  
              }
          } else {
            tags += '<p style="text-color:red:"><b> No Search Result found </b></p>';
          }
        tags += '</div>';
        console.log(tags);

        processAjaxData( tags, urlPath);
        enableButtons();
    }

    function setRequestDataWithPolicy (id, pk) {
      var endPoint = '',
          requesturl;
      switch (id) {
          case 'getVideos':
              var callback = function(response) {
                  var i,
                      iMax,
                      parsedData;
                  parsedData = JSON.parse(response);
                  videosArray = parsedData.videos;
                  console.log('videosArray', videosArray);
                  // for each video, get the best source and set that as source
                  iMax = videosArray.length;
                  for (i = 0; i < iMax; i++) {
                      videosArray[i].source = processSources(videosArray[i].sources);
                  }
                  addItems();
              };
          endPoint = account_id + '/videos?limit=100';
          if (isDefined(search)) {
              endPoint += '&q=' + search;
          }
          requesturl = edgeURL + endPoint;
          console.log('rurl - '+requesturl)
          //apiRequest.textContent = requesturl;
          getMediaData(requesturl, id, callback, pk);
              break;
      }
    }

    /**
     * send API request to the proxy
     * @param  {Object} requestData options for the request
     * @param  {String} requestID the type of request = id of the button
     * @param  {Function} [callback] callback function
     */
    function getMediaData(requesturl, requestID, callback, pk) {
      var httpRequest = new XMLHttpRequest(),
          parsedData,
          requestParams,
          dataString,
          sources,
          // response handler
          getResponse = function() {
              try {
                  if (httpRequest.readyState === 4) {
                      if (httpRequest.status >= 200 && httpRequest.status < 300) {
                          // check for completion
                          if (requestID === 'getVideos') {
                                  callback(httpRequest.responseText);
                          } else {
                            alert('There was a problem with the request. Request returned ' + httpRequest.status);
                          }
                      }
                  }
              } catch (e) {
                alert('Caught Exception: ' + e);
              }
          };
      // set response handler
      httpRequest.onreadystatechange = getResponse;
      // open the request
      httpRequest.open('GET', requesturl);
      // set headers
      httpRequest.setRequestHeader("BCOV-Policy", pk);
      // open and send request
      httpRequest.send();
    }

    /**
     * send API request to the proxy
     * @param  {Object} options for the request
     * @param  {String} options.url the full API request URL
     * @param  {String="GET","POST","PATCH","PUT","DELETE"} requestData [options.requestType="GET"] HTTP type for the request
     * @param  {String} options.proxyURL proxyURL to send the request to
     * @param  {String} options.client_id client id for the account (default is in the proxy)
     * @param  {String} options.client_secret client secret for the account (default is in the proxy)
     * @param  {JSON} [options.requestBody] Data to be sent in the request body in the form of a JSON string
     * @param  {Function} [callback] callback function that will process the response
     */
    function makeRequest(options, callback) {
      var httpRequest = new XMLHttpRequest(),
        response,
        proxyURL = options.proxyURL,
        // response handler
        getResponse = function() {
          try {
            if (httpRequest.readyState === 4) {
              if (httpRequest.status >= 200 && httpRequest.status < 300) {
                response = httpRequest.responseText;
                //console.log('response', response);
                // some API requests return '{null}' for empty responses - breaks JSON.parse
                if (response === '{null}') {
                  response = null;
                }
                // return the response
                callback(response);
              } else {
                alert('There was a problem with the request. Request returned ' + httpRequest.status);
              }
            }
          } catch (e) {
            //alert('ssdsfd');
            alert('Caught Exception: ' + e);
          }
        };
      /**
       * set up request data
       * the proxy used here takes the following request body:
       * JSON.stringify(options)
       */
      // set response handler
      httpRequest.onreadystatechange = getResponse;
      // open the request
      httpRequest.open('POST', proxyURL);
      // set headers if there is a set header line, remove it
      // open and send request

      if(isDefined(_csrfToken.value)) {
        httpRequest.setRequestHeader("X-CSRF-TOKEN", _csrfToken.value);
      }
      
      httpRequest.send(JSON.stringify(options));
    }

    function init() {  
      getSearch.addEventListener('click', function() {

        // disable buttons to prevent a new request before current one finishes
        disableButtons();
        document.getElementById('overlay').style.display = "inline";
        document.getElementById("overlay").classList.add("currently-loading");

        // only use entered account id if client id and secret are entered also
        if (!isDefined(client_id) && !isDefined(client_secret)) {
            if (!isDefined(account_id)) { 
                window.alert('To use your own account, you must specify an account id, and client id, and a client secret - since at least one of these is missing, a sample account will be used');
            }
        }
        setRequestData();
      });
    }

    function getPolicy( policy_key ) {
      console.log(policy_key);
      var numVideos;

      if (!isDefined(policy_key)) {
            window.alert('To use your own account, you must provide your own policy key - since it is missing, a sample account will be used');
      }

      search = searchStr.value;

      setRequestDataWithPolicy('getVideos', policy_key)
    }

    
    init();
})(); 