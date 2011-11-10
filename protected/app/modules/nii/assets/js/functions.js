// added to niiJs namespace.. might need to fix refering code but now neeter.  
// Can't have random non-namespaced js functions.
// refer to functions like. nii.confirmCancel();

var nii = {
	
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
	
	capitaliseFirstLetter: function(string){
		return string.charAt(0).toUpperCase() + string.slice(1);
	},
	
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
	
	suggestPassword: function(fieldID) {
		var pwchars = new Array("abcdefhjmnpqrstuvwxyz","ABCDEFGHJKLMNPQRSTUVWYXZ","23456789","|!@#$%&*\/=?;:\-_+~^}][");
		var passwordlength = 3;    // but x4  do we want that to be dynamic?  no, keep it simple :)
		var passwd = document.getElementById(fieldID);
		passwd.value = '';

		for (j = 0; j < 4; j++){
			for ( i = 0; i < passwordlength; i++ ) {
				passwd.value += pwchars[j].charAt( Math.floor( Math.random() * pwchars[j].length ) )
			}
		}
		return passwd.value;
	}
}

