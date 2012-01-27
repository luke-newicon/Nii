// Nii custom functions. Call with nii.functionName

var nii = {
	
	// Displays an alert asking the user to confirm their action and redirects to the given url on success
	confirmCancel: function(el, urlel) {
		if ($(el).val() == '1') {
			var answer = confirm("You have unsaved changes.\n\nAre you sure you wish to leave this page?")
			if (!answer) {
				return;
			} 
		}
		var url = $(urlel).attr('href');
		window.location(url);
	},
	
	// Simple! Capitalises the first letter...
	capitaliseFirstLetter: function(string){
		return string.charAt(0).toUpperCase() + string.slice(1);
	},
	
	// Displays a message, which hides itself after a period of time
	// =================================
	// Definable params are:
	//		msg:	The message you wish to display,
	//		params: {
	//			className: class to override styling of message - classes such as 'error',
	//			timeOut: timeout in milliseconds, defaults to 4000 (4 seconds)
	//		}
	showMessage: function (msg,params) {
		if (!params) params = [];
		var className = params['className'];
		if (!className) className = 'success';
		var timeOut = 4000;
		if (params['timeOut']) timeOut = params['timeOut'];
		$("#message").attr("class","");
		if (className) $('#message').addClass('alert-message '+className);
		$("#message").html(msg).slideDown('fast', function() {
			setTimeout(function() {
				$( "#message" ).slideUp('fast');
			}, timeOut );
		});
	},

	//	Adds leading zeros to numbers to pad them to a given length
	leadingZeros: function(num, totalChars, padWith) {
		num = num + "";
		padWith = (padWith) ? padWith : "0";
		if (num.length < totalChars) {
			while (num.length < totalChars) {
				num = padWith + num;
			}
		} else {}

		if (num.length > totalChars) { //if padWith was a multiple character string and num was overpadded
			num = num.substring((num.length - totalChars), totalChars);
		} else {}

		return num;
	},
	
	// Simple password suggestion function, useful for creating secure passwords in forms
	suggestPassword: function(fieldID) {
		var pwchars = new Array("abcdefhjmnpqrstuvwxyz","ABCDEFGHJKLMNPQRSTUVWYXZ","23456789","|!@#$%&*\/=?;:\-_+~^}][");
		var passwordlength = 3;    // but x3  do we want that to be dynamic?  no, keep it simple :)
		var passwd = document.getElementById(fieldID);
		passwd.value = '';

		for (j = 0; j < 4; j++){
			for ( i = 0; i < passwordlength; i++ ) {
				passwd.value += pwchars[j].charAt( Math.floor( Math.random() * pwchars[j].length ) )
			}
		}
		return passwd.value;
	},
	
	getTimeInMintes: function(time, length) {
		
		if (!length)
			length='long';
		
		var granularity;
		
		if (time >= 450) {
			time = time/450;
			granularity = (length=='long') ? ' day' + ((time>1)?'s':'') : 'd';
		} else if (time >= 60) {
			time = time/60;
			granularity = (length=='long') ? ' hour' + ((time>1)?'s':'') : 'h';
		}	else {
			granularity = (length=='long') ? ' min' + ((time>1)?'s':'') : 'm';
		}	
		var decimals = (time.indexOf(".") != -1) ? 1:0;
		return nii.number_format(time, decimals) + granularity;
	},
	
	convertTimeToMinutes: function(string, defaultType) {
		if (!defaultType)
			defaultType = 'h';
		if (nii.isNumber(string)) {
			number = string;
			alpha = defaultType;
		} else {				
			// split string into number + alpha
			pattern = '/(\d+)(.+)/';
			
			splitResults = string.match(pattern);
			number = splitResults[1];
			alpha = splitResults[2].replace(' ', '');
		}
		
		var time;
		
		switch(alpha) {
			
			case "d":
			case "day":
			case "days":
				time = number * 450;
				break;
			
			case "h":
			case "hour":
			case "hours":
				time = number * 60;
				break;
			
			case "m":
			case "min":
			case "mins":
			case "minute":
			case "minutes":
				time = number;
				break;
			
		}

		return time;		
	},
	
	number_format: function (number, decimals, dec_point, thousands_sep) {

			number = (number + '').replace(/[^0-9+-Ee.]/g, '');
			var n = !isFinite(+number) ? 0 : +number,
					prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
					sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
					dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
					s = '',
					toFixedFix = function (n, prec) {
							var k = Math.pow(10, prec);
							return '' + Math.round(n * k) / k;
					};
			// Fix for IE parseFloat(0.55).toFixed(0) = 0;
			s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
			if (s[0].length > 3) {
					s[0] = s[0].replace(/B(?=(?:d{3})+(?!d))/g, sep);
			}
			if ((s[1] || '').length < prec) {
					s[1] = s[1] || '';
					s[1] += new Array(prec - s[1].length + 1).join('0');
			}
			return s.join(dec);
	},
	
	isNumber: function(val) {
		var parm = '0123456789';
		for (i=0; i<parm.length; i++) {
			if (val.indexOf(parm.charAt(i),0) == -1) return false;
		}
		return true;
	}
 
	
}

