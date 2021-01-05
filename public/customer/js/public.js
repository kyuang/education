$(function() {
	//				rem等比缩放
	var f = function() {
		var htmlWidth = document.documentElement.clientWidth || document.body.clientWidth;
		var htmlDOM = document.getElementsByTagName('html')[0];
		if(htmlWidth > 750) {
			htmlWidth = 750
		}
		htmlDOM.style.fontSize = htmlWidth / 7.5 + "px"
	};
	window.onresize = function() {
		f();
	};
	f();
	//ios10以上兼容
	//禁用双指缩放:
	document.documentElement.addEventListener('touchstart', function(event) {
		if(event.touches.length > 1) {
			event.preventDefault();
		}
	}, false);
	//禁用手指双击缩放:
	var lastTouchEnd = 0;
	document.documentElement.addEventListener('touchend', function(event) {
		var now = Date.now();
		if(now - lastTouchEnd <= 300) {
			event.preventDefault();
		}
		lastTouchEnd = now;
	}, false);

});