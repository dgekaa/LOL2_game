$(document).ready(function() {
	var soundStatus = true;
	var stretchStatus = false;
	$('.btn_1').click(function(event) {
		if (soundStatus){
			$(this).removeClass('active')
			soundStatus = false;
			game.sound.mute = true;
		} else {
			$(this).addClass('active')
			soundStatus = true;
			game.sound.mute = false;
		}
		game.scale.refresh();
	});
	$('.btn_2').click(function(event) {
		setTimeout(function(){
			game.scale.refresh();
		}, 50)
		if (stretchStatus){
			$(this).addClass('active')
			stretchStatus = false;
			game.scale.scaleMode = Phaser.ScaleManager.EXACT_FIT;
			game.scale.fullScreenScaleMode = Phaser.ScaleManager.EXACT_FIT ;
		} else {
			$(this).removeClass('active')
			stretchStatus = true;
			game.scale.scaleMode = Phaser.ScaleManager.SHOW_ALL;
			game.scale.fullScreenScaleMode = Phaser.ScaleManager.SHOW_ALL ;
		}
	});
	var iOS = !!navigator.platform && /iPad|iPhone|iPod/.test(navigator.platform);
	if (iOS){
		$('.fullscreen-background').removeClass('destroy');
		$('.fullscreen-instructions').removeClass('destroy');
		$('.fullscreen-overlay').removeClass('destroy');
	}
	$('.btn_3').click(function(event) {
		if (iOS){
			$('.menu_elements').addClass('close');
			if (document.documentElement.clientHeight > document.documentElement.offsetHeight){
				$('.fullscreen-background').removeClass('invis');
				$('.fullscreen-instructions').removeClass('invis');
				$('.fullscreen-overlay').removeClass('invis');
			}
		} else {
			if (game.scale.isFullScreen){
				$(this).removeClass('active')
			// game.scale.stopFullScreen();
			if(document.cancelFullScreen) {
				document.cancelFullScreen();
			} else if(document.mozCancelFullScreen) {
				document.mozCancelFullScreen();
			} else if(document.webkitCancelFullScreen) {
				document.webkitCancelFullScreen();
			}
		}	else{
			$(this).addClass('active')
			// game.scale.startFullScreen(false);
			if(document.body.requestFullScreen) {
				document.body.requestFullScreen();
			} else if(document.body.mozRequestFullScreen) {
				document.body.mozRequestFullScreen();
			} else if(document.body.webkitRequestFullScreen) {
				document.body.webkitRequestFullScreen();
			}
		}
	}
});
});
