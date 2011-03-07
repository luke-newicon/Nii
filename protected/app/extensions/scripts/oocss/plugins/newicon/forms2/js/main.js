var oo = {}; // namespacing

document.onmouseover = function(event) {
	var e = event || window.event,
		t = e.target || e.srcElement; // IE || standards

	if (t.className == "btText" && t.parentNode.parentNode.className.indexOf("bt") !== -1) {
		oo.buttonClassName = t.parentNode.parentNode.className;
		t.parentNode.parentNode.className += " btOver";
	}
};

document.onmouseout = function(event) {
	var e = event || window.event,
		t = e.target || e.srcElement;

	if (t.className == "btText" && t.parentNode.parentNode.className.indexOf("bt") !== -1) {
		t.parentNode.parentNode.className = oo.buttonClassName;
		t.blur();
		t.parentNode.parentNode.blur();
	}
};

document.onmousedown = function(event) {
	var e = event || window.event,
		t = e.target || e.srcElement;

	if (t.className == "btText" && t.parentNode.parentNode.className.indexOf("bt") !== -1) {
		t.parentNode.parentNode.className += " btActive";
	}
};

document.onmouseup = function(event) {
	var e = event || window.event,
		t = e.target || e.srcElement;

	if (t.className == "btText" && t.parentNode.parentNode.className.indexOf("bt") !== -1) {
		t.parentNode.parentNode.className = t.parentNode.parentNode.className.replace(/\ btActive/,"");
		t.blur();
		t.parentNode.parentNode.blur();
	}
};
