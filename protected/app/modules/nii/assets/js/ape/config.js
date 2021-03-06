/***
 * APE JSF Setup
 */
APE.Config.baseUrl = 'http://ape.newicon.org/ape-jsf'; //APE JSF 
APE.Config.domain = 'auto'; 
APE.Config.server = 'ape.newicon.org:6969'; //APE server URL
APE.Config.transport = 2;  // 2 is JSONP

// local config
//APE.Config.baseUrl = ' http://local.ape-project.org'; //APE JSF 
//APE.Config.domain = 'auto'; 
//APE.Config.server = 'ape.local.ape-project.org:6969'; //APE server URL

(function(){i
	for (var i = 0; i < arguments.length; i++)
		APE.Config.scripts.push(APE.Config.baseUrl + '/Source/' + arguments[i] + '.js');
})('mootools-core', 'Core/APE', 'Core/Events', 'Core/Core', 'Pipe/Pipe', 'Pipe/PipeProxy', 'Pipe/PipeMulti', 'Pipe/PipeSingle', 'Request/Request','Request/Request.Stack', 'Request/Request.CycledStack', 'Transport/Transport.longPolling','Transport/Transport.SSE', 'Transport/Transport.XHRStreaming', 'Transport/Transport.JSONP', 'Core/Utility', 'Core/JSON');
