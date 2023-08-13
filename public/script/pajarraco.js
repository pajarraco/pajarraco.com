var stopButton = 0;
var docW = $(window).width() - 200;
var docH = $(window).height() - 150;
var mySimbolW = new Array();
var mySimbolH = new Array();
var mySpeedX = new Array();
var mySpeedY = new Array();
var maxButton = 5;

$(window).load(function() {
	for (i = 1; i <= maxButton; i++) {
		mySpeedX[i] = Math.random() * 40;
		mySpeedY[i] = Math.random() * 40;

		var simSelector = Math.round(Math.random() * 2);
		if (simSelector == 0) {
			mySimbolW[i] = '+';
		} else {
			mySimbolW[i] = '-';
		}
		simSelector = Math.round(Math.random() * 2);
		if (simSelector == 0) {
			mySimbolH[i] = '+';
		} else {
			mySimbolH[i] = '-';
		}

		$('#a' + i)
			.css('top', Math.random() * docH + 10 + 'px')
			.css('left', Math.random() * docW + 10 + 'px');
	}

	(function myTimer() {
		setTimeout(function() {
			// code here
			for (var i = 1; i <= maxButton; i++) {
				if (i != stopButton) {
					var myLeft = $('#a' + i).css('left');
					myLeft = myLeft.substr(0, myLeft.length - 2);
					var myTop = $('#a' + i).css('top');
					myTop = myTop.substr(0, myTop.length - 2);

					if (myLeft >= docW && mySimbolW[i] == '+') {
						mySimbolW[i] = '-';
					}
					if (myTop >= docH && mySimbolH[i] == '+') {
						mySimbolH[i] = '-';
					}
					if (myLeft <= 40 && mySimbolW[i] == '-') {
						mySimbolW[i] = '+';
					}
					if (myTop <= 40 && mySimbolH[i] == '-') {
						mySimbolH[i] = '+';
					}

					$('#a' + i).animate(
						{
							left: mySimbolW[i] + '=' + mySpeedX[i],
							top: mySimbolH[i] + '=' + mySpeedY[i]
						},
						300,
						'linear'
					);
				}
			}
			// end code
			myTimer();
		}, 300);
	})();
});

function stop(bottom) {
	$(bottom).stop();
	var id = $(bottom)
		.attr('id')
		.substr(1, 1);
	stopButton = id;

	mySpeedX[id] = Math.random() * 40;
	mySpeedY[id] = Math.random() * 40;

	var simSelector = Math.round(Math.random() * 2);
	if (simSelector == 0) {
		mySimbolW[id] = '+';
	} else {
		mySimbolW[id] = '-';
	}
	simSelector = Math.round(Math.random() * 2);
	if (simSelector == 0) {
		mySimbolH[id] = '+';
	} else {
		mySimbolH[id] = '-';
	}
}

function start() {
	stopButton = 0;
}
