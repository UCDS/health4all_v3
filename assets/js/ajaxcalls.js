$(document).unbind("keydown").bind("keydown",function(e){
	var vPreventDefault=false;
	var vElement = e.srcElement||e.target;
	if((vElement.tagName.toUpperCase()==="INPUT" &&
		(vElement.type.toUpperCase()==="TEXT"
			|| vElement.type.toUpperCase()==="PASSWORD" || vElement.type.toUpperCase()==="FILE"
			|| vElement.type.toUpperCase()==="SEARCH" || vElement.type.toUpperCase()==="EMAIL"
			|| vElement.type.toUpperCase()==="NUMBER"||vElement.type.toUpperCase()==="DATE"))	||vElement.tagName.toUpperCase()==="TEXTAREA")
	{
		vPreventDefault=vElement.readOnly||vElement.disabled;
	}
	else{
		vPreventDefault=true;
	}
	if(e.keyCode===8){
		if(vPreventDefault){
			e.preventDefault();
		}
	}
	else{
		if(!e.ctrlKey&&!e.altKey&&vPreventDefault){ //our busy loop condition should come here &&!($("#mainprocessmessage").is(":visible")||$("#lookupprocessmessage").is(":visible"))
			var vKeyPath = glbShrtcuts.getKeyPath(e.keyCode);
			if(vKeyPath && vKeyPath != location.pathname){
				//location.href=glbShrtcuts.getKeyPath(e.keyCode);
			}
		}
	}
});

var glbShrtcuts=(function(){
	var vKeyMap={};
	return Object.freeze({
		addNewKey:function(vKeyCode,vUrl){
			if(vKeyCode&&vUrl){
				vKeyMap[vKeyCode]=vUrl;
				return true;
			}else{
				return false;
			}
		},
		removeKey:function(vKeyCode){
			if(vKeyCode){
				return delete vKeyMap[vKeyCode];
			}
			else{
				return false;
			}
		},
		getKeyPath:function(vKeyCode){
			return vKeyMap[vKeyCode];
		}
	});
})();

$(function(){
	glbShrtcuts.addNewKey(66,"/funds_tracker/bank_account/bank_book_summary");
	glbShrtcuts.addNewKey(67,"/funds_tracker/cheque_book");
	glbShrtcuts.addNewKey(73,"/funds_tracker/instrument_type");
	glbShrtcuts.addNewKey(80,"/funds_tracker/party");
	glbShrtcuts.addNewKey(82,"/funds_tracker/report/party");
});






/*
* To POST a form using ajax call..
*
*
* |-------------------------------------------------------
* |Input parameters
* |-------------------------------------------------------
* |@param {string} vUrl : url
* |@param {string} vData : Form Data
* |@param {function} vSuccessCallbackFunction : The function to be called after ajax response. The function will be executed only if the ajax call status is success.
* |@param {object} vProps : Contains properties for fot this call. 
* |							@param {boolean} EncodeUrlFlag : All url parameter values will be encoded using encodeURIComponent() if this flag is not set to false
* |							@param {boolean} EncodeDataFlag : All Data will be encoded using  encodeURIComponent() if this flag is not set to false
* |							@param {boolean} Async : Specifies whether this call is sync or async. Default is Async
* |							@param {string} DataType : Data type of response. Default is text.
							@param {boolean} HideBusyLoop : Busy loop will be hidden if this boolean is set to true
* |							@param {function} FailureCallbackFunction : The function to be called after ajax response if any error occurs.
* |-------------------------------------------------------
*
*
* Added By : Pranay
* Added On : 2016-09-02
*/
function jqueryPostAjaxCall( vUrl, vData, vSuccessCallbackFunction, vProps )
{
	if(!vProps || typeof vProps !== 'object') vProps = {};
	//if( vProps.EncodeUrlFlag !== false ) vUrl = encodeUrl(vUrl);
	if( vProps.EncodeDataFlag !== false ) vData = encodeUrl(vData,1);

	if(!vProps.ContentType) vProps.ContentType = "application/x-www-form-urlencoded; charset=utf-8";
	if(!vProps.DataType   ) vProps.DataType    = "text";

//	if( glbValidSession )
	{
		$.ajax({
			type: 'POST',
			data: vData,
			contentType:vProps.ContentType,
			url: vUrl,
			async: (vProps.Async === false ? false : true),
			cache: false,
			beforeSend : function(xhr)
			{
                            if( vProps && vProps.HideBusyLoop === true );
                            else 
                                $(".BusyLoopMain").removeClass("BusyLoopHide").addClass("BusyLoopShow");
			},
			success:function(data, textStatus, jqXHR) 
                                {
                                    vProps.DataType = jqXHR.getResponseHeader("Content-Type") == undefined ? "application/text" : jqXHR.getResponseHeader("Content-Type");
                                    $(".BusyLoopMain").removeClass("BusyLoopShow").addClass("BusyLoopHide");
//						
                                    if(vSuccessCallbackFunction)
                                        vSuccessCallbackFunction(data);

                                },
			error: function(jqXHR, textStatus, errorThrown) {
                                    $(".BusyLoopMain").removeClass("BusyLoopShow").addClass("BusyLoopHide");
                                    handleAjaxError(jqXHR,textStatus,errorThrown);
                                    if(vProps.FailureCallbackFunction) vProps.FailureCallbackFunction(jqXHR);
                                }
		});
	}//if( glbValidSession )
}//jqueryPostAjaxCall

function handleAjaxError(e,x,exception)
{
    var message;
    var statusErrorMap = {
            '0'   : "Server unreachable",
            '400' : "Server understood the request, but request content was invalid.",
            '401' : "Unauthorized access.",
            '403' : "Forbidden resource can't be accessed.",
            '404' : "Requested Page/Resource not found",
            '500' : "Internal server error.",
            '503' : "Service unavailable."
    };

    switch(e.status)
    {
            case 0:
                    /*
                    * case 1: It could be possible to get a status code of 0 if you have sent an AJAX call and a refresh of the browser was triggered before getting the AJAX response. The AJAX call will be cancelled and you will get this status.
                    * case 2: If server is unreachable
                    *
                    * For case 1 alert shouldn't come.
                    *
                    * As of now alert should be hidden As there is no way to distinguish this both cases.
                    * If we find a way to distinguish both case then 'server unreachable' alert can be shown.
                    *
                    * Added By: Pranay
                    * Added On : 2016-05-26
                    */
                    return false;
            break;
            case 200:
                    {
                        alert(e.responseText);
                    }
            break;
            default:
            {
                message = statusErrorMap[e.status];
                if(!message){										
                    if(x=='parsererror'){
                        message="Error: Parsing JSON Request failed.";
                    }else if(x=='timeout'){
                        message="Request Time out.";
                    }else if(x=='abort'){
                        message="Request was aborted by the server";
                    }else {
                        message="Unknown Error \n";
                    }
                  }

                alert(message);
            }
            break;
    }// switch
}// handleAjaxError

function encodeUrl(vUrl, vOnlyData)
{
	var vIndex	 = vUrl.indexOf("?");
	var vServlet = vUrl.substring(0, vIndex);
	var vParams	 = vUrl.substring( vOnlyData ? 0 : (vIndex+1), vUrl.length).trim().split("&");
	var vTempUrl = "";
	for( var dwI = 0; dwI < vParams.length; dwI++ )
	{
		var vParam 	= vParams[dwI];
		if( vParam.trim() != "" )
		{
			var vIndex	= vParam.indexOf("=");
			var vKey 	= vParam.substring(0, vIndex);
			var vValue 	= vParam.substring(vIndex+1, vParam.length);
			var vEnVal 	= encodeURIComponent(vValue);
			if( vTempUrl != "" )
				vTempUrl += "&" + vKey + "=" + vEnVal;
			else
				vTempUrl += vKey + "=" + vEnVal;
		}
	}//for
	if(!vOnlyData)
		vUrl = vServlet + "?" + vTempUrl;
	else 
		vUrl = vTempUrl;
	return vUrl;
}//encodeUrl