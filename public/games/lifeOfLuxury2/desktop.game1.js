var game = new Phaser.Game(1024, 800, Phaser.AUTO, '', 'ld29', null, false, false);
var game1;
var startFunc;
var stopUB;
var balanceUpdateStatus = false;
var balanceUpdateStatus2 = false;
var showButMob;
var hideButMob;
var spinStatus = false;
var firstAroundAnim = true;
var topLabelValue = 1;
var spaceStatus = true;
var winSound;
var squareArrFreespin = [];
var coinAnimArr = [];
var briAnimArr = [];
var carAnimArr = [];
var planeAnimArr = [];
var katerAnimArr = [];
var changeLine = [];
var changeBet = [];
var paytableStatus;
var autostart;
var multiStatus = false;
var firstAnim = true;
var timeSpin = false;
var parseAnswerStatus = true;
var dataSpinRequest = {};
var afterFreespinStatus = false;
var addcreditFlickStatus = false;
var createdStarsStatus = true;
var activateFreeSpins = true; //удалить на продакшене
var createdStarsMiniStatus = true;
var briMulti = [];
var squareArr = [
	[2, 5, 8, 11, 14],
	[1, 4, 7, 10, 13],
	[3, 6, 9, 12, 15],
	[1, 5, 9, 11, 13],
	[3, 5, 7, 11, 15],
	[2, 4, 8, 12, 14],
	[2, 6, 8, 10, 14],
	[1, 4, 8, 12, 15],
	[3, 6, 8, 10, 13],
	[1, 5, 7, 11, 13],
	[3, 5, 9, 11, 15],
	[2, 4, 7, 10, 14],
	[2, 6, 9, 12, 14],
	[1, 5, 8, 11, 13],
	[3, 5, 8, 11, 15],
	[2, 5, 7, 11, 14],
	[2, 5, 9, 11, 14],
	[1, 6, 7, 12, 13],
	[3, 4, 9, 10, 15],
	[3, 4, 8, 10, 15]
];
var squareArrImg = [
	[2, 5, 8, 11, 14],
	[1, 4, 7, 10, 13],
	[3, 6, 9, 12, 15],
	[1, 5, 9, 11, 13],
	[3, 5, 7, 11, 15],
	[2, 4, 8, 12, 14],
	[2, 6, 8, 10, 14],
	[1, 4, 8, 12, 15],
	[3, 6, 8, 10, 13],
	[1, 5, 7, 11, 13],
	[3, 5, 9, 11, 15],
	[2, 4, 7, 10, 14],
	[2, 6, 9, 12, 14],
	[1, 5, 8, 11, 13],
	[3, 5, 8, 11, 15],
	[2, 5, 7, 11, 14],
	[2, 5, 9, 11, 14],
	[1, 6, 7, 12, 13],
	[3, 4, 9, 10, 15],
	[3, 4, 8, 10, 15]
];
var allwinUpd = 0;
var allWin;
var errorStatus = false;
var curGame = 1;

function game1() {
	var game1 = {
		cell: [],
		copyCell: [],
		bars: [],
		ticker: null,
		spinStatus1: false,
		spinStatus2: false,
		spinStatus3: false,
		spinStatus4: false,
		spinStatus5: false,
		bet: [],
		circleArr: [],
		lineArr: [],
		textArr: [],
		squareArr: [],
		colorLine: ['#009800', '#fffc00', '#0004ff', '#ff0000', '#ff00d1', '#00fa6d', '#89ff00', '#ff7f00', '#9400ff', '#0004ff', '#009300', '#ff3900', '#ff3900', '#9400ff', '#89ff00']
	};

	game1.preload = function () { };

	game1.create = function () {
		if (game.sound.usingWebAudio &&
			game.sound.context.state === 'suspended') {
			game.input.onTap.addOnce(game.sound.context.resume, game.sound.context);
		}
		if (this.game.device.android && this.game.device.chrome && this.game.device.chromeVersion >= 55) {
			this.game.sound.setTouchLock();
			this.game.sound.touchLocked = true;
			this.game.input.touch.addTouchLockCallback(function () {
				if (this.noAudio || !this.touchLocked || this._unlockSource !== null) {
					return true;
				}
				if (this.usingWebAudio) {

					var buffer = this.context.createBuffer(1, 1, 22050);
					this._unlockSource = this.context.createBufferSource();
					this._unlockSource.buffer = buffer;
					this._unlockSource.connect(this.context.destination);

					if (this._unlockSource.start === undefined) {
						this._unlockSource.noteOn(0);
					} else {
						this._unlockSource.start(0);
					}

					if (this._unlockSource.context.state === 'suspended') {
						this._unlockSource.context.resume();
					}
				}

				return true;

			}, this.game.sound, true);
		}
		if (demo === 'demo') {
			game.scale.setGameSize(1024, 831)
		}
		game1.ticker = game.add.tileSprite(0, 800, 1154, 31, 'ticker');
		checkBalanceTimer = false;
		createdStarsStatus = true;
		createdStarsMiniStatus = true;
		curGame = 1;
		spaceStatus = true;
		spinStatus = false;
		var lineflash = 0;
		coinSound1 = game.add.audio('coin1');
		coinSound2 = game.add.audio('coin2');
		coinSound3 = game.add.audio('coin3');
		coinSound4 = game.add.audio('coin4');
		coinSound5 = game.add.audio('coin5');
		coins = game.add.audio('coins');
		for (var i = 1; i <= 20; ++i) {
			changeLine[i] = game.add.audio('changeLine' + i);
			changeBet[i] = game.add.audio('changeBet' + i);
		}
		var cellPos = [
			[77, 127],
			[77, 276],
			[77, 425],
			[255, 127],
			[255, 276],
			[255, 425],
			[433, 127],
			[433, 276],
			[433, 425],
			[611, 127],
			[611, 276],
			[611, 425],
			[788, 127],
			[788, 276],
			[788, 425]
		];
		// info = [7, 1, 2, 3, 4, 5, 6, 7, 0, 9, 10, 1, 2, 3, 1];
		animCoinArray = [
			[0, 1, 2, 3, 4, 5, 6, 7],
			[2, 3, 4, 5, 6, 7, 0, 1],
			[3, 4, 5, 6, 7, 0, 1, 2],
			[4, 5, 6, 7, 0, 1, 2, 3],
			[6, 7, 0, 1, 2, 3, 4, 5],
			[7, 0, 1, 2, 3, 4, 5, 6]
		]
		bg = game.add.sprite(0, 0, 'game.background2');

		slotLayer1Group = game.add.group();
		slotLayer1Group.add(bg);

		topLabel = game.add.sprite(240, 0, 'top_label_1');
		bg_overlay = game.add.sprite(0, 0, 'game.background_overlay');

		slotLayer3Group = game.add.group();
		slotLayer3Group.add(topLabel);
		slotLayer2Group = game.add.group();
		slotLayer2Group.add(bg_overlay);
		slotLayer4Group = game.add.group();
		for (var i = 1; i <= 15; ++i) {
			if (i === 1 || i === 4 || i === 7 || i === 10 || i === 13) {
				game1.cell[i] = game.add.tileSprite(cellPos[i - 1][0], cellPos[i - 1][1], 158, 179, 'cell' + info[i - 1] + '_x');
				game1.cell[i].tilePosition.y = -30;
			}
			if (i === 2 || i === 5 || i === 8 || i === 11 || i === 14) {
				game1.cell[i] = game.add.tileSprite(cellPos[i - 1][0], cellPos[i - 1][1] - 30, 158, 209, 'cell' + info[i - 1] + '_x');
			}
			if (i === 3 || i === 6 || i === 9 || i === 12 || i === 15) {
				game1.cell[i] = game.add.tileSprite(cellPos[i - 1][0], cellPos[i - 1][1] - 30, 158, 179, 'cell' + info[i - 1] + '_x');
			}
			// test = game.add.tileSprite(77, 126, 158, 179, 'cell4_x');
			// test.tilePosition.y = -30;
			slotLayer2Group.add(game1.cell[i]);
		}

		game1.bars[0] = game.add.tileSprite(77, 126, 158, 447, 'bar');
		game1.bars[0].tilePosition.y = randomNumber(0, 9) * 149;
		game1.bars[1] = game.add.tileSprite(255, 126, 158, 447, 'bar');
		game1.bars[1].tilePosition.y = randomNumber(0, 9) * 149;
		game1.bars[2] = game.add.tileSprite(433, 126, 158, 447, 'bar');
		game1.bars[2].tilePosition.y = randomNumber(0, 9) * 149;
		game1.bars[3] = game.add.tileSprite(611, 126, 158, 447, 'bar');
		game1.bars[3].tilePosition.y = randomNumber(0, 9) * 149;
		game1.bars[4] = game.add.tileSprite(788, 126, 158, 447, 'bar');
		game1.bars[4].tilePosition.y = randomNumber(0, 9) * 149;
		game1.bars[0].visible = false;
		game1.bars[1].visible = false;
		game1.bars[2].visible = false;
		game1.bars[3].visible = false;
		game1.bars[4].visible = false;
		slotLayer2Group.add(game1.bars[0]);
		slotLayer2Group.add(game1.bars[1]);
		slotLayer2Group.add(game1.bars[2]);
		slotLayer2Group.add(game1.bars[3]);
		slotLayer2Group.add(game1.bars[4]);
		// star_anim = game.add.sprite(50, 65, 'star_anim');
		bg2_panels = game.add.sprite(0, 0, 'background2_panels');
		createdStars();
		createdStarsMini();
		// slotLayer3Group.add(star_anim);
		slotLayer2Group.add(bg2_panels);

		function createdStars() {
			let coordX = randomNumber(0, 1020);
			let coordY;
			let star;
			if (coordX < 41 || coordX > 979) {
				coordY = randomNumber(0, 600)
			} else {
				coordY = randomNumber(0, 65)
			}
			star = game.add.sprite(coordX, coordY, 'star_anim');
			star.anchor.setTo(0.5, 0.5);
			star.angle = randomNumber(0, 360);
			star.animations.add('anim', [5, 4, 3, 2, 1, 0], 5, false).play().onComplete.add(function () {
				star.destroy();
			})
			slotLayer1Group.add(star);
			setTimeout(function () {
				if (createdStarsStatus) {
					createdStars();
				}
			}, 200)
		}

		function createdStarsMini() {
			let coordX = randomNumber(240, 792);
			let coordY = randomNumber(0, 110);
			let star;
			star = game.add.sprite(coordX, coordY, 'star_anim_mini');
			star.angle = randomNumber(0, 360);
			star.animations.add('anim', [], 4, false).play().onComplete.add(function () {
				star.destroy();
			})

			slotLayer4Group.add(star);
			setTimeout(function () {
				if (createdStarsMiniStatus) {
					createdStarsMini();
				}
			}, 30)
		}

		let numberSpin = 0;

		function changeNumberSpin() {
			numberSpin = numberSpin + 1;
			if (numberSpin > 17) {
				numberSpin = 0;
			}
			if (numberSpin === 0 || numberSpin === 6 || numberSpin === 12) {
				createdStarsMiniStatus = true;

				animTopLabel('top_label_1');
			}
			if (numberSpin === 3) {
				createdStarsMiniStatus = false;
				animTopLabel('top_label_2');
			}
			if (numberSpin === 9) {
				createdStarsMiniStatus = false;
				animTopLabel('top_label_3');
			}
			if (numberSpin === 15) {
				createdStarsMiniStatus = false;
				animTopLabel('top_label_4');
			}
		}

		function animTopLabel(img) {
			game.add.tween(topLabel).to({ y: topLabel.position.y + 120 }, 400, "Linear", true).onComplete.add(function () {
				changeImgTopLabel(img)
				game.add.tween(topLabel).to({ y: topLabel.position.y - 120 }, 400, "Linear", true).onComplete.add(function () {
					changeImgTopLabel(img)
					if (img === 'top_label_1') {
						createdStarsMini();
					}
					logoChangeSong.play();
				});
			});
		}

		function changeImgTopLabel(img) {
			topLabel.loadTexture(img);
		}
		var changeTextValue = randomNumber(3, 30);
		var changeTextCur = 0;
		var circlePos = [
			[15, 331],
			[15, 187],
			[15, 474],
			[15, 95],
			[15, 569],
			[15, 426],
			[15, 233],
			[15, 141],
			[15, 521],
			[968, 162],
			[968, 499],
			[968, 307],
			[968, 355],
			[968, 210],
			[968, 451],
			[968, 259],
			[968, 403],
			[968, 114],
			[968, 547],
			[15, 378]
		];
		var linePos = [
			[15, 331],
			[15, 187],
			[15, 474],
			[15, 95],
			[15, 569],
			[15, 426],
			[15, 233],
			[15, 141],
			[15, 521],
			[968, 162],
			[968, 499],
			[968, 307],
			[968, 355],
			[968, 210],
			[968, 451],
			[968, 259],
			[968, 403],
			[968, 114],
			[968, 547],
			[15, 378]
		];
		var textPos = [
			[40, 353],
			[40, 209],
			[40, 496],
			[40, 117],
			[40, 591],
			[40, 448],
			[40, 255],
			[40, 163],
			[40, 543],
			[993, 184],
			[993, 521],
			[993, 329],
			[993, 377],
			[993, 232],
			[993, 473],
			[993, 281],
			[993, 425],
			[993, 136],
			[993, 569],
			[40, 400]
		];
		squareArrFreespin = [];
		coinAnimArr = [];
		briAnimArr = [];
		carAnimArr = [];
		planeAnimArr = [];
		katerAnimArr = [];
		addLines(circlePos, linePos, textPos, cellPos, squareArr, squareArrImg)
		hideLines();
		hideLinesCircle();
		hideLinesCircleText();
		for (var i = 1; i <= lines; i++) {
			showLineCircle(i);
			showLineCircleText(i);
			game1.textArr[i].setText(betline);
		}
		blue_field = game.add.sprite(93, 301, 'blue_field');
		blue_field.visible = false;

		function addLines(circlePos, linePos, textPos, cellPos, squareArr, squareArrImg) {
			for (var i = 1; i <= 20; ++i) {
				game1.lineArr[i] = game.add.sprite(0, 0, 'line_' + i);
				game1.circleArr[i] = game.add.sprite(circlePos[i - 1][0], circlePos[i - 1][1], 'circleLine_' + i);
				game1.textArr[i] = game.add.text(textPos[i - 1][0], textPos[i - 1][1], betline, {
					font: '30px "PragmaticaBoldCyrillic"',
					fill: '#ffffff',
					stroke: '#000000',
					strokeThickness: 6
				});
				game1.textArr[i].anchor.setTo(0.5, 0.5);
			}
			for (var i = 1; i <= 15; ++i) {
				game1.copyCell[i] = game.add.sprite(cellPos[i - 1][0], cellPos[i - 1][1], 'cell0');
				game1.copyCell[i].visible = false;
				briAnimArr[i] = game.add.sprite(cellPos[i - 1][0], cellPos[i - 1][1], 'bri_anim');
				briAnimArr[i].visible = false;
				coinAnimArr[i] = game.add.sprite(cellPos[i - 1][0], cellPos[i - 1][1], 'coin_anim');
				coinAnimArr[i].visible = false;
				carAnimArr[i] = game.add.sprite(cellPos[i - 1][0], cellPos[i - 1][1], 'car_anim');
				carAnimArr[i].visible = false;
				planeAnimArr[i] = game.add.sprite(cellPos[i - 1][0], cellPos[i - 1][1], 'plane_anim');
				planeAnimArr[i].visible = false;
				katerAnimArr[i] = game.add.sprite(cellPos[i - 1][0], cellPos[i - 1][1], 'kater_anim');
				katerAnimArr[i].visible = false;
				squareArrFreespin[i] = game.add.sprite(cellPos[i - 1][0] - 1, cellPos[i - 1][1] - 1, 'square_1');
				squareArrFreespin[i].visible = false;
			}
			for (var i = 1; i <= 20; ++i) {
				for (var j = 1; j <= 5; ++j) {
					squareArrImg[i - 1][j - 1] = game.add.sprite(cellPos[squareArr[i - 1][j - 1] - 1][0] - 1, cellPos[squareArr[i - 1][j - 1] - 1][1] - 1, 'square_' + i);
					squareArrImg[i - 1][j - 1].visible = false;
				}
			}
		}

		function showLine(lineNumber) {
			game1.lineArr[lineNumber].visible = true;
		}

		function showLineCircle(lineNumber) {
			game1.circleArr[lineNumber].visible = true;
		}

		function showLineCircleText(lineNumber) {
			game1.textArr[lineNumber].visible = true;
		}

		function showSquare(lineNumber, squareNumber) {
			squareArrImg[lineNumber - 1][squareNumber - 1].visible = true;
		}

		function hideLines() {
			game1.lineArr.forEach(function (line) {
				line.visible = false;
				line.tint = 0xffffff;
			});
		};

		function hideLinesCircle() {
			game1.circleArr.forEach(function (line) {
				line.visible = false;
			});
		};

		function hideLinesCircleText() {
			game1.textArr.forEach(function (line) {
				line.visible = false;
			});
		};

		function hideSquare() {
			for (var i = 1; i <= 20; ++i) {
				for (var j = 1; j <= 5; ++j) {
					squareArrImg[i - 1][j - 1].visible = false;
					squareArrImg[i - 1][j - 1].tint = 0xffffff;
				}
			}
		}
		exit = game.add.sprite(27, 706, 'exit');
		exit.inputEnabled = true;
		exit.input.useHandCursor = true;
		exit.events.onInputUp.add(function () {
			return_to_gameSong.play();
			exit.loadTexture('exit');
			if (balanceUpdateStatus) {
				stopUpdateBalance();
			} else {
				// coinAnim();
				// giveBalance();
				// var allBalance = balance + allWinOld;
				// blue_field.visible = true;
				// collect_text.setText('HAND PAY ' +allBalance+' CREDITS')
				// flickcollect_text();
				// credit.setText(0);
				// paid.setText(allBalance);
				// setTimeout(function() {
				//  location.href = '/';
				// }, 4000);
				bottomText.visible = false;
				hideLines();
				if (demo !== 'true') {
					if ((balance + allWin) !== 0) {
						$('.popup_exit,.overlay').show();
					} else {
						exitGame(false)
					}
				} else {
					exitGame(false)
				}
			}
		});
		paytable = game.add.sprite(265, 706, 'paytable');
		paytable.inputEnabled = true;
		paytable.input.useHandCursor = true;
		paytable.events.onInputUp.add(function () {
			paytable.loadTexture('paytable');
			if (balanceUpdateStatus) {
				stopUpdateBalance();
			} else {
				openInfoPage('paytable');
				bottomText.visible = false;
				hideLines();
				hideButtons();
			}
		});
		help = game.add.sprite(163, 706, 'help');
		help.inputEnabled = true;
		help.input.useHandCursor = true;
		help.events.onInputUp.add(function () {
			help.loadTexture('help');
			if (balanceUpdateStatus) {
				stopUpdateBalance();
			} else {
				openInfoPage('help');
				bottomText.visible = false;
				hideLines();
				hideButtons();
			}
		});

		selectLines = game.add.sprite(412, 706, 'selectLines');
		selectLines.inputEnabled = true;
		selectLines.input.useHandCursor = true;
		selectLines.events.onInputDown.add(function () {
			// selectLines.loadTexture('selectLines_p');
		});
		selectLines.events.onInputUp.add(function () {
			selectLines.loadTexture('selectLines');
			if (balanceUpdateStatus) {
				stopUpdateBalance();
			} else {
				upLines()
			}
		})
		betPerLine = game.add.sprite(531, 706, 'betPerLine');
		betPerLine.inputEnabled = true;
		betPerLine.input.useHandCursor = true;
		betPerLine.events.onInputDown.add(function () {
			// betPerLine.loadTexture('betPerLine_p');
		});
		betPerLine.events.onInputUp.add(function () {
			betPerLine.loadTexture('betPerLine');
			if (balanceUpdateStatus) {
				stopUpdateBalance();
			} else {
				upLinesBet()
			}
		})
		allWin = 0;
		autoPlay = game.add.sprite(888, 706, 'autoPlay');
		autoPlay.inputEnabled = true;
		autoPlay.input.useHandCursor = true;
		autoPlay.events.onInputDown.add(function () {
			if ((balance + allWinOld) === 0) {
				// autoPlay.loadTexture('addCredit_p');
			} else {
				if (autostart === false) {
					// autoPlay.loadTexture('autoPlay_p');
				} else {
					// autoPlay.loadTexture('autoStop_p');
				}
			}
		});
		autoPlay.events.onInputUp.add(function () {
			if ((balance + allWinOld) === 0 && demo !== 'true') {
				// autoPlay.loadTexture('addCredit');
				console.log('press add credits');
				$.ajax({
					type: "get",
					url: getNeedUrlPath() + '/add-credit?userId=' + userId + '&gameId=' + gameId + '&token=' + token +'&platform_id='+ platformId,
					dataType: 'html',
					success: function (data) {
						console.log(getNeedUrlPath() + '/add-credit?userId=' + userId + '&gameId=' + gameId + '&token=' + token+'&platform_id='+ platformId);
						console.log(data)
					},
					error: function (xhr, ajaxOptions, thrownError) {
						var errorText = 'ошибка 80';
						alert(errorText);
					}
				});
			} else {
				if (autostart === false) {
					if (balanceUpdateStatus) {
						stopUpdateBalance();
						autoPlay.loadTexture('autoPlay');
					} else {
						$("#spin").addClass('auto');
						autoPlay.loadTexture('autoStop');
						autostart = true;
						startFunc();
					}
				} else {
					autoPlay.loadTexture('autoPlay');
					$("#spin").removeClass('auto');
					autostart = false;
					showButtons();
					if (spinStatus === true) {
						hideButtons();
						showButtons([
							[startButton, 'startButton']
						]);
						startButton.loadTexture('stopButton');
					}
				}
			}
		})
		startButton = game.add.sprite(650, 706, 'startButton');
		startButton.inputEnabled = true;
		startButton.input.useHandCursor = true;
		startButton.events.onInputDown.add(function () {
			// startButton.loadTexture('startButton_p');
			// btnSound.play();
		});
		startButton.events.onInputUp.add(function () {
			if (spaceStatus) {
				if (balanceUpdateStatus) {
					startButton.loadTexture('startButton');
					stopUpdateBalance();
				} else {
					preStartSpin();
				}
			} else {
				if (paytableStatus === false) {
					if (autostart === false) {
						if (timeSpin) {
							if (dataSpinRequest['status']) {
								if (parseAnswerStatus) {
									startButton.loadTexture('startButton');
									hideButtons([
										[startButton, 'startButton']
									]);
									if (g1s === true) {
										g1s = false;
									} else {
										g2s = false;
									}
									spinSound.stop();
									timeSpin = false;
									game1.bars[0].visible = false;
									game1.cell[1 + 3 * 0].visible = true;
									game1.cell[2 + 3 * 0].visible = true;
									game1.cell[3 + 3 * 0].visible = true;
									game1.bars[1].visible = false;
									game1.cell[1 + 3 * 1].visible = true;
									game1.cell[2 + 3 * 1].visible = true;
									game1.cell[3 + 3 * 1].visible = true;
									game1.bars[2].visible = false;
									game1.cell[1 + 3 * 2].visible = true;
									game1.cell[2 + 3 * 2].visible = true;
									game1.cell[3 + 3 * 2].visible = true;
									game1.bars[3].visible = false;
									game1.cell[1 + 3 * 3].visible = true;
									game1.cell[2 + 3 * 3].visible = true;
									game1.cell[3 + 3 * 3].visible = true;
									game1.bars[4].visible = false;
									game1.cell[1 + 3 * 4].visible = true;
									game1.cell[2 + 3 * 4].visible = true;
									game1.cell[3 + 3 * 4].visible = true;
									game1.cell[1].loadTexture('cell' + info[0] + '_x');
									game1.cell[2].loadTexture('cell' + info[1] + '_x');
									game1.cell[3].loadTexture('cell' + info[2] + '_x');
									game1.cell[4].loadTexture('cell' + info[3] + '_x');
									game1.cell[5].loadTexture('cell' + info[4] + '_x');
									game1.cell[6].loadTexture('cell' + info[5] + '_x');
									game1.cell[7].loadTexture('cell' + info[6] + '_x');
									game1.cell[8].loadTexture('cell' + info[7] + '_x');
									game1.cell[9].loadTexture('cell' + info[8] + '_x');
									game1.cell[10].loadTexture('cell' + info[9] + '_x');
									game1.cell[11].loadTexture('cell' + info[10] + '_x');
									game1.cell[12].loadTexture('cell' + info[11] + '_x');
									game1.cell[13].loadTexture('cell' + info[12] + '_x');
									game1.cell[14].loadTexture('cell' + info[13] + '_x');
									game1.cell[15].loadTexture('cell' + info[14] + '_x');
									if (game1.spinStatus1 === true) {
										game1.spinStatus1 = false;
										endspin(0);
									}
									if (game1.spinStatus2 === true) {
										game1.spinStatus2 = false;
										endspin(1);
									}
									if (game1.spinStatus3 === true) {
										game1.spinStatus3 = false;
										endspin(2);
									}
									if (game1.spinStatus4 === true) {
										game1.spinStatus4 = false;
										endspin(3);
									}
									if (game1.spinStatus5 === true) {
										game1.spinStatus5 = false;
										endspin(4);
									}
									finishSpinSound.play();
								}
							}
						}
					}
				}
			}
		})

		maxBetSpin = game.add.sprite(769, 706, 'maxBetSpin');
		maxBetSpin.inputEnabled = true;
		maxBetSpin.input.useHandCursor = true;
		maxBetSpin.events.onInputDown.add(function () {
			// maxBetSpin.loadTexture('maxBetSpin_p');
		});
		maxBetSpin.events.onInputUp.add(function () {
			maxBetSpin.loadTexture('maxBetSpin');
			if (balanceUpdateStatus) {
				stopUpdateBalance();
			} else {
				if ((balance + allWinOld) > 399) {
					lines = 20;
					betline = 20;
				} else {
					pickMaxSpin();
				}
				hideLinesCircle();
				hideLinesCircleText();
				for (var i = 1; i <= lines; i++) {
					showLineCircle(i);
					showLineCircleText(i);
					game1.textArr[i].setText(betline);
				}
				linesText.setText(lines)
				lineBetText.setText(betline)
				bet = lines * betline;
				totalBet.setText(bet);
				activateFreeSpins = true;
				preStartSpin();
				// requestSpin(gamename, sessionName, betline, lines);
			}
		})
		scorePosions = [
			[160, 57, 38],
			[160, 81, 18],
			[342, 57, 38],
			[342, 81, 18],
			[526, 57, 38],
			[526, 81, 18],
			[187, 648, 17],
			[828, 648, 17]
		];
		balance = +balance;
		if (afterFreespinStatus) {
			balance = balanceOld;
		}
		addScore();
		addinfoPage();

		freespinStartBG = game.add.sprite(75, 125, 'freespinStartBG');
		freespinStartBG.visible = false;
		freesponStartBGText = game.add.sprite(75, 125, 'freesponStartBGText');
		freesponStartBGText.visible = false;
		big_red_border = game.add.sprite(497, 343, 'coin_big_anim');
		big_red_border.anchor.setTo(0.5, 0.5);
		big_red_border.visible = false;
		blackBg = game.add.sprite(0, 0, 'black_bg');
		blackBg.alpha = 0;
		blackBg.visible = false;
		establishing_bg = game.add.sprite(0, 0, 'establishing_bg');
		establishing_bg.visible = false;
		session_bg = game.add.sprite(0, 0, 'session_bg');
		session_bg.visible = false;
		error_bg = game.add.sprite(0, 0, 'error_bg');
		error_bg.visible = false;
		if (afterFreespinStatus) {
			wlValues = wlValuesOld;
			stopWinAnim = false;
			hideButtons();
			allWin = allWinOld + winOldTrigerFreeSpin;
			bottomText.visible = true;
			bottomText.setText(allWin + ' Credits Won');
       bottomText.fontSize = 35;
			paid.setText(allWinOld);
			info = infoOld;
			for (var i = 1; i <= 15; ++i) {
				game1.cell[i].loadTexture('cell' + infoOld[i - 1] + '_x');
				game1.copyCell[i].loadTexture('cell' + infoOld[i - 1]);
			}
			showWinFreeSpin(wcvWinValuesArrayOld);
			updateBalance();
		} else {
			gameStatusTextFlick();
		}
		// if (dataArray.status === 'false') {
		//   errorStatus = true;
		//   if (dataArray.message === 'SessionNotExist') {
		//     session_bg.visible = true;
		//   } else {
		//     error_bg.visible = true;
		//   }
		// }
		var coinCount = 0;


		function parseSpinAnswer(dataSpinRequest) {
			console.log(`Win : ${dataSpinRequest.stateData.isWin}`)

			dataArray = dataSpinRequest;
			dataArrValue = dataArray.length;

			winCellInfo = dataArray.logicData['winningCells'];
			wlValues = dataArray.logicData['payoffsForLines'];

			balanceR = dataArray.balanceData['balance'] - dataArray.balanceData['totalPayoff'];
			balance = dataArray.balanceData['balance'] - dataArray.balanceData['totalPayoff'];

			// linesR = dataArray['linesInGame'];
			// betlineR = dataArray['betLine'];
			allWin = dataArray.balanceData['payoffByLines'];
			if (dataSpinRequest.stateData.isWinOnBonus) {
				allWin = dataArray.balanceData['totalPayoff'];
				winOldTrigerFreeSpin = dataArray.balanceData['totalPayoff'];
				infoOld = dataArray.logicData.table;
				mulFreespin = dataArray.logicData.multiplier;
				wlValuesOld = dataArray.logicData['payoffsForLines'];
				balanceOld = dataArray.balanceData['balance'] - dataArray.balanceData['totalPayoff'];
			}
			if (realSpinStatus) {
				credit.setText(balance);
				realSpinStatus = false;
			}
			coinCount = 0;
			info = dataArray.logicData.table;
			parseAnswerStatus = true;
			middlespin(0);
			middlespin(1);
			middlespin(2);
			middlespin(3);
			middlespin(4);

		}
		startFunc = function startAuto() {
			preStartSpin();
		}
		var g1s = false;
		var g1e = false;
		var g2s = false;
		var g2e = false;
		var g3s = false;
		var g3e = false;

		function startspin(number) {
			game.add.tween(game1.cell[1 + number * 3].tilePosition).to({ y: game1.cell[1 + number * 3].tilePosition.y - 30 }, 200, Phaser.Easing.LINEAR, true).onComplete.add(function () {
				game1.cell[1 + number * 3].visible = false;
			});
			game.add.tween(game1.cell[2 + number * 3].tilePosition).to({ y: game1.cell[2 + number * 3].tilePosition.y - 30 }, 200, Phaser.Easing.LINEAR, true).onComplete.add(function () {
				game1.cell[2 + number * 3].visible = false;
			});
			game.add.tween(game1.cell[3 + number * 3].tilePosition).to({ y: game1.cell[3 + number * 3].tilePosition.y - 30 }, 200, Phaser.Easing.LINEAR, true).onComplete.add(function () {
				game1.cell[3 + number * 3].visible = false;
				game1.bars[number].visible = true;
				if (number == 0) {
					game1.spinStatus1 = true;
				}
				if (number == 1) {
					game1.spinStatus2 = true;
				}
				if (number == 2) {
					game1.spinStatus3 = true;
				}
				if (number == 3) {
					game1.spinStatus4 = true;
				}
				if (number == 4) {
					game1.spinStatus5 = true;
					timeSpin = true;
					if (g2e === true & g1e === false) {
						g1e = true;
						g2s = true;
						g2e = true;
					} else if (g1e === false & g2e === false) {
						g1s = true;
						g1e = true;
					} else if (g1e === true) {
						g2s = true;
						g2e = true;
					}
					requestSpin(gamename, sessionUuid, betline, lines);
					changeTextCur = changeTextCur + 1;
					if (changeTextCur === changeTextValue) {
						topLabel.loadTexture('top_label_' + topLabelValue);
						if (topLabelValue === 2) {
							topLabelValue = 1;
						} else {
							topLabelValue = 2;
						}
						changeTextCur = 0;
						changeTextValue = randomNumber(3, 30);
					}
				}
			});

		};

		function middlespin(number) {
			if (number == 0) {
				setTimeout(function () {
					if (timeSpin) {
						if ((g1e === true & g1s === true) || (g1s === false & g2e === true & g2s === true)) {
							game1.spinStatus1 = false;
							game1.bars[0].visible = false;
							game1.cell[1 + 3 * 0].visible = true;
							game1.cell[2 + 3 * 0].visible = true;
							game1.cell[3 + 3 * 0].visible = true;
							game1.cell[1].loadTexture('cell' + info[0] + '_x');
							game1.cell[2].loadTexture('cell' + info[1] + '_x');
							game1.cell[3].loadTexture('cell' + info[2] + '_x');
							if (info[0] == 10 || info[1] == 10 || info[2] == 10) {
								coinCount = coinCount + 1;
								coinSound1.play();
							} else {
								finishSpinSound1.play();
							}
							endspin(number);
						}
					}
				}, 700);
			}
			if (number == 1) {
				setTimeout(function () {
					if (timeSpin) {
						if ((g1e === true & g1s === true) || (g1e === false & g2e === true & g2s === true)) {
							game1.spinStatus2 = false;
							game1.bars[0].visible = false;
							game1.cell[1 + 3 * 0].visible = true;
							game1.cell[2 + 3 * 0].visible = true;
							game1.cell[3 + 3 * 0].visible = true;
							game1.bars[1].visible = false;
							game1.cell[1 + 3 * 1].visible = true;
							game1.cell[2 + 3 * 1].visible = true;
							game1.cell[3 + 3 * 1].visible = true;
							game1.cell[1].loadTexture('cell' + info[0] + '_x');
							game1.cell[2].loadTexture('cell' + info[1] + '_x');
							game1.cell[3].loadTexture('cell' + info[2] + '_x');
							game1.cell[4].loadTexture('cell' + info[3] + '_x');
							game1.cell[5].loadTexture('cell' + info[4] + '_x');
							game1.cell[6].loadTexture('cell' + info[5] + '_x');

							if (info[3] == 10 || info[4] == 10 || info[5] == 10 || info[3] == 0 || info[4] == 0 || info[5] == 0) {
								coinCount = coinCount + 1;
								if (coinCount === 1) {
									coinSound1.play();
								} else {
									coinSound2.play();
								}
							} else {
								finishSpinSound2.play();
							}

							endspin(number);
						}
					}
				}, 1050);
			}
			if (number == 2) {
				setTimeout(function () {
					if (timeSpin) {
						if ((g1e === true & g1s === true) || (g1e === false & g2e === true & g2s === true)) {
							game1.spinStatus3 = false;
							game1.bars[0].visible = false;
							game1.cell[1 + 3 * 0].visible = true;
							game1.cell[2 + 3 * 0].visible = true;
							game1.cell[3 + 3 * 0].visible = true;
							game1.bars[1].visible = false;
							game1.cell[1 + 3 * 1].visible = true;
							game1.cell[2 + 3 * 1].visible = true;
							game1.cell[3 + 3 * 1].visible = true;
							game1.bars[2].visible = false;
							game1.cell[1 + 3 * 2].visible = true;
							game1.cell[2 + 3 * 2].visible = true;
							game1.cell[3 + 3 * 2].visible = true;

							game1.cell[1].loadTexture('cell' + info[0] + '_x');
							game1.cell[2].loadTexture('cell' + info[1] + '_x');
							game1.cell[3].loadTexture('cell' + info[2] + '_x');
							game1.cell[4].loadTexture('cell' + info[3] + '_x');
							game1.cell[5].loadTexture('cell' + info[4] + '_x');
							game1.cell[6].loadTexture('cell' + info[5] + '_x');
							game1.cell[7].loadTexture('cell' + info[6] + '_x');
							game1.cell[8].loadTexture('cell' + info[7] + '_x');
							game1.cell[9].loadTexture('cell' + info[8] + '_x');
							if (info[6] == 10 || info[7] == 10 || info[8] == 10 || info[6] == 0 || info[7] == 0 || info[8] == 0) {
								coinCount = coinCount + 1;
								if (coinCount === 1) {
									coinSound1.play();
								} else if (coinCount === 2) {
									coinSound2.play();
								} else {
									coinSound3.play();
								}
							} else {
								finishSpinSound3.play();
							}
							endspin(number);
						}
					}
				}, 1400);
			}
			if (number == 3) {
				setTimeout(function () {
					if (timeSpin) {
						if ((g1e === true & g1s === true) || (g1e === false & g2e === true & g2s === true)) {
							game1.spinStatus4 = false;
							game1.bars[0].visible = false;
							game1.cell[1 + 3 * 0].visible = true;
							game1.cell[2 + 3 * 0].visible = true;
							game1.cell[3 + 3 * 0].visible = true;
							game1.bars[1].visible = false;
							game1.cell[1 + 3 * 1].visible = true;
							game1.cell[2 + 3 * 1].visible = true;
							game1.cell[3 + 3 * 1].visible = true;
							game1.bars[2].visible = false;
							game1.cell[1 + 3 * 2].visible = true;
							game1.cell[2 + 3 * 2].visible = true;
							game1.cell[3 + 3 * 2].visible = true;

							game1.bars[3].visible = false;
							game1.cell[1 + 3 * 3].visible = true;
							game1.cell[2 + 3 * 3].visible = true;
							game1.cell[3 + 3 * 3].visible = true;

							game1.cell[1].loadTexture('cell' + info[0] + '_x');
							game1.cell[2].loadTexture('cell' + info[1] + '_x');
							game1.cell[3].loadTexture('cell' + info[2] + '_x');
							game1.cell[4].loadTexture('cell' + info[3] + '_x');
							game1.cell[5].loadTexture('cell' + info[4] + '_x');
							game1.cell[6].loadTexture('cell' + info[5] + '_x');
							game1.cell[7].loadTexture('cell' + info[6] + '_x');
							game1.cell[8].loadTexture('cell' + info[7] + '_x');
							game1.cell[9].loadTexture('cell' + info[8] + '_x');
							game1.cell[10].loadTexture('cell' + info[9] + '_x');
							game1.cell[11].loadTexture('cell' + info[10] + '_x');
							game1.cell[12].loadTexture('cell' + info[11] + '_x');
							if (info[9] == 10 || info[10] == 10 || info[11] == 10 || info[9] == 0 || info[10] == 0 || info[11] == 0) {
								coinCount = coinCount + 1;
								if (coinCount === 1) {
									coinSound1.play();
								} else if (coinCount === 2) {
									coinSound2.play();
								} else if (coinCount === 3) {
									coinSound3.play();
								} else {
									coinSound4.play();
								}
							} else {
								finishSpinSound4.play();
							}
							endspin(number);
						}
					}
				}, 1750);
			}
			if (number == 4) {
				setTimeout(function () {
					if (timeSpin) {
						if ((g1e === true & g1s === true) || (g1e === false & g2e === true & g2s === true)) {
							if (g1e === true) {
								g1s = false;
							} else {
								g2s = false;
							}
							game1.spinStatus5 = false;
							game1.bars[0].visible = false;
							game1.cell[1 + 3 * 0].visible = true;
							game1.cell[2 + 3 * 0].visible = true;
							game1.cell[3 + 3 * 0].visible = true;
							game1.bars[1].visible = false;
							game1.cell[1 + 3 * 1].visible = true;
							game1.cell[2 + 3 * 1].visible = true;
							game1.cell[3 + 3 * 1].visible = true;
							game1.bars[2].visible = false;
							game1.cell[1 + 3 * 2].visible = true;
							game1.cell[2 + 3 * 2].visible = true;
							game1.cell[3 + 3 * 2].visible = true;

							game1.bars[3].visible = false;
							game1.cell[1 + 3 * 3].visible = true;
							game1.cell[2 + 3 * 3].visible = true;
							game1.cell[3 + 3 * 3].visible = true;

							game1.bars[4].visible = false;
							game1.cell[1 + 3 * 4].visible = true;
							game1.cell[2 + 3 * 4].visible = true;
							game1.cell[3 + 3 * 4].visible = true;

							game1.cell[1].loadTexture('cell' + info[0] + '_x');
							game1.cell[2].loadTexture('cell' + info[1] + '_x');
							game1.cell[3].loadTexture('cell' + info[2] + '_x');
							game1.cell[4].loadTexture('cell' + info[3] + '_x');
							game1.cell[5].loadTexture('cell' + info[4] + '_x');
							game1.cell[6].loadTexture('cell' + info[5] + '_x');
							game1.cell[7].loadTexture('cell' + info[6] + '_x');
							game1.cell[8].loadTexture('cell' + info[7] + '_x');
							game1.cell[9].loadTexture('cell' + info[8] + '_x');
							game1.cell[10].loadTexture('cell' + info[9] + '_x');
							game1.cell[11].loadTexture('cell' + info[10] + '_x');
							game1.cell[12].loadTexture('cell' + info[11] + '_x');
							game1.cell[13].loadTexture('cell' + info[12] + '_x');
							game1.cell[14].loadTexture('cell' + info[13] + '_x');
							game1.cell[15].loadTexture('cell' + info[14] + '_x');

							if (info[12] == 10 || info[13] == 10 || info[14] == 10) {
								coinCount = coinCount + 1;
								if (coinCount === 1) {
									coinSound1.play();
								} else if (coinCount === 2) {
									coinSound2.play();
								} else if (coinCount === 3) {
									coinSound3.play();
								} else if (coinCount === 4) {
									coinSound4.play();
								} else {
									coinSound5.play();
								}
							} else {
								finishSpinSound5.play();
							}
							endspin(number);
						}
					}
					if (g1e === true) {
						g1e = false;
					} else {
						g2e = false;
					}
				}, 2100);
			}
		}

		function endspin(number) {
			if (number == 4) {
				timeSpin = false;
			}
			game1.cell[1 + number * 3].tilePosition.y = game1.cell[1 + number * 3].tilePosition.y + 60;
			game1.cell[2 + number * 3].tilePosition.y = game1.cell[2 + number * 3].tilePosition.y + 60;
			game1.cell[3 + number * 3].tilePosition.y = game1.cell[3 + number * 3].tilePosition.y + 60;

			game.add.tween(game1.cell[1 + number * 3].tilePosition).to({ y: game1.cell[1 + number * 3].tilePosition.y - 30 }, 200, Phaser.Easing.LINEAR, true).onComplete.add(function () { });
			game.add.tween(game1.cell[2 + number * 3].tilePosition).to({ y: game1.cell[2 + number * 3].tilePosition.y - 30 }, 200, Phaser.Easing.LINEAR, true).onComplete.add(function () { });
			game.add.tween(game1.cell[3 + number * 3].tilePosition).to({ y: game1.cell[3 + number * 3].tilePosition.y - 30 }, 200, Phaser.Easing.LINEAR, true).onComplete.add(function () {
				if (number == 4) {
					// slotLayer3Group.add(topLabel);
					// bg2_panels.loadTexture('background2_panels');
					checkWin();
					for (var i = 1; i <= 15; ++i) {
						game1.cell[i].visible = true;
						game1.cell[i].loadTexture('cell' + info[i - 1] + '_x');
					}
					game1.bars[0].visible = false;
					game1.bars[1].visible = false;
					game1.bars[2].visible = false;
					game1.bars[3].visible = false;
					game1.bars[4].visible = false;
				}
			});
		}
		var wlWinValuesArray = [];
		var wcvWinValuesArray = [];
		var briSound = false;

		function addCreditFlick() {
			flickBtn = true;
			if (addcreditFlickStatus) {
				autoPlay.loadTexture('addCredit');
				//autoPlay.loadTexture('addCredit_p');
				setTimeout(function () {
					if (addcreditFlickStatus) {
						autoPlay.loadTexture('addCredit_p');
						setTimeout(function () {
							addCreditFlick();
						}, 500);
					} else {
						flickBtn = false;
					}
				}, 500);
			} else {
				flickBtn = false;
			}
		}

		function checkWin() {
			briSound = false;
			wlWinValuesArray = [];
			wcvWinValuesArray = [];
			winWithoutCoin = 0;
			for (var i = 1; i <= 15; ++i) {
				game1.copyCell[i].loadTexture('cell' + info[i - 1]);
			}
			for (key in wlValues) {
				winWithoutCoin = winWithoutCoin + wlValues[key].winValue;
				wlWinValuesArray.push(wlValues[key].lineNumber + 1);

			}
			for (key in winCellInfo) {
				wcvWinValuesArray.push(+(key));

				if (winCellInfo[key] === 0) {
					briSound = true;
				}
			}
			if (dataSpinRequest.stateData.isWinOnBonus) {
				hideButtons();
				briWinSound.play();
				winBonusValue = winOldTrigerFreeSpin - winWithoutCoin;
				stopWinAnim = false;
				wcvWinValuesArray = [];
				bottomText.setText(allWin + " Credits Won");
         bottomText.fontSize = 35;
				for (key in info) {
					if (info[key] === 10 || info[key] === 0) {
						wcvWinValuesArray.push(+(key));
					}
				}
				wcvWinValuesArrayOld = wcvWinValuesArray;
				wlWinValuesArrayOld = wlWinValuesArray;
				winCellInfoOld = winCellInfo;
				showWinFreeSpin(wcvWinValuesArray);
			} else if (wlWinValuesArray.length > 0) {
				stopWinAnim = false;
				firstAroundAnim = true;

				showWin(wlWinValuesArray, winCellInfo);
				bottomText.setText(allWin + " Credits Won");
         bottomText.fontSize = 35;
			} else {
				spinStatus = false;
				gameStatusTextFlick();
				changeNumberSpin();
				if (autostart == false) {
					showButtons();
				}
				if ((balance + allWin) < betline * lines) {
					autostart = false;
					$("#spin").removeClass('auto');
					showButtons();
					hideButtons([
						[startButton, 'startButton']
					]);
					hideButtons([
						[autoPlay, 'autoPlay']
					]);
					if ((balance + allWin) < 1) {
						hideButtons([
							[maxBetSpin, 'maxBetSpin']
						]);
					}
					hideMobileBtn();
					addcreditFlickStatus = false;
					autoPlay.loadTexture('autoPlay');
					console.log(balance + allWin)
					if ((balance + allWin) === 0 && demo !== 'true') {
						checkBalance();
						showButtons([
							[autoPlay, 'autoPlay']
						]);
						//autoPlay.loadTexture('addCredit');
						addcreditFlickStatus = true;
						bottomText.visible = true;
						bottomText.setText("To play please add credit to game.");
            bottomText.fontSize = 25;
						autoPlay.loadTexture('addCredit');
						addCreditFlick();
					}
				} else {
					if (autostart == false) {
						showButtons([
							[startButton, 'startButton']
						]);
						showButtons([
							[autoPlay, 'autoPlay']
						]);
						showButtons([
							[maxBetSpin, 'maxBetSpin']
						]);
						showMobileBtn();
					}
				}
				if (autostart == true) {
					setTimeout(function () {
						if (autostart === true & spinStatus === false) {
							startFunc();
						}
					}, 1000);
				}
			}
		}

		function gameStatusTextFlick() {
			gameStatusText.visible = true;
			gameStatusText.setText('Game Over');
			setTimeout(function () {
				if (spinStatus) {
					return;
				}
				gameStatusText.visible = false;
				setTimeout(function () {
					if (spinStatus) {
						return;
					}
					gameStatusText.visible = true;
					gameStatusText.setText('Play 400 Credits');
					setTimeout(function () {
						if (spinStatus) {
							return;
						}
						gameStatusText.visible = false;
						setTimeout(function () {
							if (spinStatus) {
								return;
							}
							gameStatusTextFlick()
						}, 800);
					}, 800);
				}, 800);
			}, 800);
		}

		function showWinFreeSpin(wcvWinValuesArray) {
			console.log(wcvWinValuesArray)
			wcvWinValuesArray.forEach(function (cell, i) {
				squareArrFreespin[cell + 1].visible = true;
				if (!afterFreespinStatus) {
					if (info[cell] === 10) {
						coinAnimArr[cell + 1].visible = true;
						coinAnimArr[cell + 1].animations.add('coin_anim', [], 30, false).play().onComplete.add(function () {
							coinAnimArr[cell + 1].visible = false;
						});
					}
					if (info[cell] === 0) {
						briAnimArr[cell + 1].visible = true;
						briAnimArr[cell + 1].animations.add('coin_anim', [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12], 15, false).play().onComplete.add(function () {
							briAnimArr[cell + 1].visible = false;
						});
					}
				}
			});
			winText.visible = false;
			if (afterFreespinStatus) {
				winText.visible = true;
				winText.setText('Trigger Pay \n' + +winOldTrigerFreeSpin.toFixed());
			}
			if (!afterFreespinStatus) {
				bottomText.visible = true;
				bottomText.setText("BONUS!");
        bottomText.fontSize = 35;
				setTimeout(function () {
					flickWin(wcvWinValuesArray);
				}, 1000);
			} else {
				flickWin(wcvWinValuesArray);
			}
			if (!afterFreespinStatus) {
				setTimeout(function () {
					stopWinAnim = true;
					for (var i = 1; i <= 15; ++i) {
						game1.copyCell[i].visible = false;
						squareArrFreespin[i].visible = false;
						squareArrFreespin[i].tint = 0xffffff;
					}
					freeSpinBgSong.play();
					freespinStartBG.visible = true;
					freesponStartBGText.visible = true;
					freespinStartBG.alpha = 0;
					big_red_border.visible = true;
					big_red_border.animations.add('anim', [], 50, false).play().onComplete.add(function () {
						stopWinAnim = true;
						autostart = false;
						spinStatus = false;
						$("#spin").removeClass('auto');
						createdStarsStatus = true;
						createdStarsMiniStatus = true;
						game.state.start('game2');
					})
					game.add.tween(freespinStartBG).to({ alpha: 1 }, 1000, "Linear", true).onComplete.add(function () {
						createdStarsStatus = false;
						createdStarsMiniStatus = false;
					})
				}, 4000);
			}
		}


		function requestSpin(gamename, sessionUuid, betline, lines) {
			console.log(getNeedUrlPath() + `/api-v2/action?game_id=${gameId}&user_id=${userId}&mode=${demo}&action=spin&session_uuid=${sessionUuid}&token=${token}&linesInGame=${lines}&lineBet=${betline}&platform_id=${platformId}`);
			$.ajax({
				type: "get",
				url: getNeedUrlPath() + `/api-v2/action?game_id=${gameId}&user_id=${userId}&mode=${demo}&action=spin&session_uuid=${sessionUuid}&token=${token}&linesInGame=${lines}&lineBet=${betline}&platform_id=${platformId}`,
				dataType: 'html',
				success: function (data) {
					console.log(data);
					console.log(JSON.parse(data));
					if (IsJsonString(data)) {
						dataSpinRequest = JSON.parse(data);
						//freespin
						// if (activateFreeSpins)
						// dataSpinRequest = { "info": [5, 2, 10, 10, 1, 3, 10, 5, 2, 2, 9, 6, 9, 3, 1], "allWin": 3, "betLine": "0.1", "linesInGame": "15", "winCellInfo": [false, false, 10, 10, false, false, false, false, false, 10, false, false, false, false, false], "wl": [], "status": true, "balance": 96.0, "rope": { "count": 12, "mul": 2, "allWin": 3 }, "winBonusSymbolsData": [3, 2], "freeSpinData": { "count": 10, "mul": 2, "allWin": 3 }, "check0FreeSpin": false, "info_for_api": ["Ring", "Silver", "Coin", "Coin", "Plane", "Dollar", "Dollar", "Ring", "Silver", "Coin", "Yacht", "Watch", "Yacht", "Dollar", "Plane"], "winLinesData": [] }


						if (dataSpinRequest.status !== 'false') {
							parseSpinAnswer(dataSpinRequest);
						} else {
							errorStatus = true;
							switch (dataSpinRequest.message) {
								case 'ActiveUserSessionException':
									session_bg.visible = true;
									break;
								case 'FirstMoveFundsException':
									error_bg.visible = true;
									break;
								case 'BetPlacingAbortException':
									establishing_bg.visible = true;
									setTimeout("BetPlacingAbortExceptionFunc(gamename, sessionName, betline, lines, dataSpinRequest.betPlacingAbortExceptionID)", 3000);
									break;
								case 'moveFundsException':
									establishing_bg.visible = true;
									setTimeout("moveFundsExceptionFunc(gamename, sessionName, betline, lines, dataSpinRequest.moveFundsExceptionID)", 3000);
									break;
								case 'low balance':
									error_bg.visible = true;
									break;
								case 'UnauthenticatedException':
									error_bg.visible = true;
									break;
							}
						}
					} else {
						console.log('json format error');
						error_bg.visible = true;
						errorStatus = true;
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					var errorText = '//ошибка 30';
					console.log(errorText);
					error_bg.visible = true;
					errorStatus = true;
					// reconnectSpin(gamename, sessionName, betline, lines);
					// setTimeout("reconnectSpin(gamename, sessionName, betline, lines)", 100);
				}
			});
		}

		function moveFundsExceptionFunc(gamename, sessionName, betline, lines, moveFundsExceptionID) {
			$.ajax({
				type: "get",
				url: getNeedUrlPath() + '/moveFundsException?moveFundsExceptionID=' + moveFundsExceptionID+'&platform_id='+ platformId,
				dataType: 'html',
				success: function (data) {
					console.log(data);
					if (IsJsonString(data)) {
						dataSpinRequest = JSON.parse(data);
						// проверка статуса ответа
						if (dataSpinRequest.status === 'false') {
							switch (dataSpinRequest.message) {
								case 'FirstMoveFundsException':
									error_bg.visible = true;
									break;
								case 'BetPlacingAbortException':
									setTimeout("BetPlacingAbortExceptionFunc(gamename, sessionName, betline, lines, dataSpinRequest.betPlacingAbortExceptionID)", 3000);
									break;
								case 'moveFundsException':
									setTimeout("moveFundsExceptionFunc(gamename, sessionName, betline, lines, dataSpinRequest.moveFundsExceptionID)", 3000)
									break;
								case 'LowBalanceException':
									error_bg.visible = true;
									break;
								case 'UnauthenticatedException':
									error_bg.visible = true;
									break;
							}
						} else {
							errorStatus = false;
							establishing_bg.visible = false;
							requestSpin(gamename, sessionUuid, betline, lines)
						}
					} else {
						console.log('json format error');
						error_bg.visible = true;
						errorStatus = true;
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					var errorText = '//ошибка 30';
					console.log(errorText);
					error_bg.visible = true;
					errorStatus = true;
				}
			});
		}

		function BetPlacingAbortExceptionFunc(gamename, sessionName, betline, lines, moveFundsExceptionID) {
			$.ajax({
				type: "get",
				url: getNeedUrlPath() + '/betPlacingAbort?betPlacingAbortExceptionID=' + moveFundsExceptionID +'&platform_id='+ platformId,
				dataType: 'html',
				success: function (data) {
					console.log(data);
					if (IsJsonString(data)) {
						dataSpinRequest = JSON.parse(data);
						// проверка статуса ответа
						if (dataSpinRequest.status === 'false') {
							switch (dataSpinRequest.message) {
								case 'FirstMoveFundsException':
									error_bg.visible = true;
									break;
								case 'BetPlacingAbortException':
									setTimeout("BetPlacingAbortExceptionFunc(gamename, sessionName, betline, lines, dataSpinRequest.betPlacingAbortExceptionID)", 3000);
									break;
								case 'moveFundsException':
									setTimeout("moveFundsExceptionFunc(gamename, sessionName, betline, lines, dataSpinRequest.moveFundsExceptionID)", 3000)
									break;
								case 'LowBalanceException':
									error_bg.visible = true;
									break;
								case 'UnauthenticatedException':
									error_bg.visible = true;
									break;
							}
						} else {
							errorStatus = false;
							establishing_bg.visible = false;
							requestSpin(gamename, sessionUuid, betline, lines)
						}
					} else {
						console.log('json format error');
						error_bg.visible = true;
						errorStatus = true;
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					var errorText = '//ошибка 30';
					console.log(errorText);
					error_bg.visible = true;
					errorStatus = true;
				}
			});
		}

		function reconnectSpin(gamename, sessionName, betline, lines) {
			$.ajax({
				type: "get",
				url: getNeedUrlPath() + '/reconnect',
				dataType: 'html',
				success: function (data) {
					console.log('reconect : true');
					requestSpin(gamename, sessionUuid, betline, lines);
				},
				error: function (xhr, ajaxOptions, thrownError) {
					var errorText = '//ошибка переподкючения';
					console.log(errorText);
					reconnectSpin(gamename, sessionUuid, betline, lines);
					// setTimeout("reconnectSpin()", 100);
				}
			});
		}

		function flickWin(wcvWinValuesArray) {
			if (stopWinAnim == true) {
				return;
			}
			wcvWinValuesArray.forEach(function (cell, i) {
				squareArrFreespin[cell + 1].tint = 0x999999;
			});
			if (afterFreespinStatus) {
				winText.visible = false;
			}
			setTimeout(function () {
				if (stopWinAnim == true) {
					wcvWinValuesArray.forEach(function (cell, i) {
						squareArrFreespin[cell + 1].tint = 0xffffff;
					});
					return;
				}
				wcvWinValuesArray.forEach(function (cell, i) {
					squareArrFreespin[cell + 1].tint = 0xffffff;
				});
				if (afterFreespinStatus) {
					winText.visible = true;
				}
				setTimeout(function () {
					if (stopWinAnim == true) {
						return;
					}
					wcvWinValuesArray.forEach(function (cell, i) {
						squareArrFreespin[cell + 1].tint = 0x999999;
					});
					if (afterFreespinStatus) {
						winText.visible = false;
					}
					setTimeout(function () {
						if (stopWinAnim == true) {
							wcvWinValuesArray.forEach(function (cell, i) {
								squareArrFreespin[cell + 1].tint = 0xffffff;
							});
							return;
						}
						wcvWinValuesArray.forEach(function (cell, i) {
							squareArrFreespin[cell + 1].tint = 0xffffff;
						});
						if (afterFreespinStatus) {
							winText.visible = true;
						}
						setTimeout(function () {
							if (stopWinAnim == true) {
								return;
							}
							if (afterFreespinStatus) {
								if (winWithoutCoin > 0) {
									wcvWinValuesArray.forEach(function (cell, i) {
										squareArrFreespin[cell + 1].visible = false;
									});
									showWin(wlWinValuesArrayOld, winCellInfoOld);
								} else {
									flickWin(wcvWinValuesArray);
								}
							} else {
								flickWin(wcvWinValuesArray);
							}
						}, 500);
					}, 200);
				}, 500);
			}, 200);
		}
		var sizeLine = 0;
		var otherSound = false;

		function showWin(wlWinValuesArray, winCellInfo) {
			otherSound = false;
			multiStatus = false;
			if (stopWinAnim == true) {
				return;
			}
			winText.visible = true;
			if (afterFreespinStatus) {
				winText.visible = true;
			}
			console.log(wlValues[lineflash])
			if (wlValues[lineflash]) {
				winText.setText('Trigger Pay \n' + wlValues[lineflash].winValue);
			} else {
				winText.setText('Trigger Pay \n' + wlValuesFS.winning);
			}
			if (info[squareArr[wlWinValuesArray[lineflash] - 1][0] - 1] !== 0) {
				trigerLine = info[squareArr[wlWinValuesArray[lineflash] - 1][0] - 1];
			} else if (info[squareArr[wlWinValuesArray[lineflash] - 1][1] - 1] !== 0) {
				trigerLine = info[squareArr[wlWinValuesArray[lineflash] - 1][1] - 1];
			} else if (info[squareArr[wlWinValuesArray[lineflash] - 1][2] - 1] !== 0) {
				trigerLine = info[squareArr[wlWinValuesArray[lineflash] - 1][2] - 1];
			} else if (info[squareArr[wlWinValuesArray[lineflash] - 1][3] - 1] !== 0) {
				trigerLine = info[squareArr[wlWinValuesArray[lineflash] - 1][3] - 1];
			} else {
				trigerLine = info[squareArr[wlWinValuesArray[lineflash] - 1][4] - 1];
			}
			if (info[squareArr[wlWinValuesArray[lineflash] - 1][0] - 1] === 0 || info[squareArr[wlWinValuesArray[lineflash] - 1][1] - 1] === 0) {
				multiStatus = true;
			}
			if (info[squareArr[wlWinValuesArray[lineflash] - 1][0] - 1] === 9 & (info[squareArr[wlWinValuesArray[lineflash] - 1][2] - 1] === 0 || info[squareArr[wlWinValuesArray[lineflash] - 1][2] - 1] === 9)) {
				if (firstAroundAnim) {
					if (!afterFreespinStatus) {
						katerSong.play();
					}
					otherSound = true;
				}
			}
			if (info[squareArr[wlWinValuesArray[lineflash] - 1][0] - 1] === 1 & (info[squareArr[wlWinValuesArray[lineflash] - 1][2] - 1] === 0 || info[squareArr[wlWinValuesArray[lineflash] - 1][2] - 1] === 1)) {
				if (firstAroundAnim) {
					if (!afterFreespinStatus) {
						planeSong.play();
					}
					otherSound = true;
				}
			}
			if (info[squareArr[wlWinValuesArray[lineflash] - 1][0] - 1] === 4 & (info[squareArr[wlWinValuesArray[lineflash] - 1][2] - 1] === 0 || info[squareArr[wlWinValuesArray[lineflash] - 1][2] - 1] === 4)) {
				if (firstAroundAnim) {
					if (!afterFreespinStatus) {
						carSong.play();
					}
					otherSound = true;
				}
			}
			if (info[squareArr[wlWinValuesArray[lineflash] - 1][2] - 1] === 0 || info[squareArr[wlWinValuesArray[lineflash] - 1][2] - 1] === trigerLine) {
				if (info[squareArr[wlWinValuesArray[lineflash] - 1][2] - 1] === 0) {
					multiStatus = true;
				}
				if (info[squareArr[wlWinValuesArray[lineflash] - 1][3] - 1] === 0 || info[squareArr[wlWinValuesArray[lineflash] - 1][3] - 1] === trigerLine) {
					if (info[squareArr[wlWinValuesArray[lineflash] - 1][3] - 1] === 0) {
						multiStatus = true;
					}
					if (info[squareArr[wlWinValuesArray[lineflash] - 1][4] - 1] === 0 || info[squareArr[wlWinValuesArray[lineflash] - 1][4] - 1] === trigerLine) {
						if (info[squareArr[wlWinValuesArray[lineflash] - 1][4] - 1] === 0) {
							multiStatus = true;
						}
						sizeLine = 5;
					} else {
						sizeLine = 4;
					}
				} else {
					sizeLine = 3;
				}
			} else {
				sizeLine = 2;
			}
			if (!afterFreespinStatus) {
				if (firstAnim) {
					if (!otherSound) {
						updateBalance();
					} else {
						setTimeout(function () {
							updateBalance();
						}, 2000);
					}
					firstAnim = false;
				}
			}

			if (multiStatus) {
				if (firstAroundAnim) {
					if (!otherSound) {
						if (!afterFreespinStatus) {
							briLineWinSound.play();
						}
					}
					for (var i = 1; i <= sizeLine; ++i) {
						if (info[squareArr[wlWinValuesArray[lineflash] - 1][i - 1] - 1] === 0) {
							briAnimArr[squareArr[wlWinValuesArray[lineflash] - 1][i - 1]].visible = true;
							briAnimArr[squareArr[wlWinValuesArray[lineflash] - 1][i - 1]].animations.add('scatters_anim', [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12], 15, false).play().onComplete.add(function () {
								for (var i = 1; i <= 15; ++i) {
									briAnimArr[i].visible = false;
								}
							});
						}
					}
				}
			}
			if (firstAroundAnim) {
				for (var i = 1; i <= sizeLine; ++i) {
					if (sizeLine >= 3) {
						if (info[squareArr[wlWinValuesArray[lineflash] - 1][i - 1] - 1] === 4) {
							carAnimArr[squareArr[wlWinValuesArray[lineflash] - 1][i - 1]].visible = true;
							carAnimArr[squareArr[wlWinValuesArray[lineflash] - 1][i - 1]].animations.add('scatters_anim', [4, 3, 2, 1, 0], 7, false).play().onComplete.add(function () {
								for (var i = 1; i <= 15; ++i) {
									carAnimArr[i].visible = false;
								}
							});
						}
						if (info[squareArr[wlWinValuesArray[lineflash] - 1][i - 1] - 1] === 1) {
							planeAnimArr[squareArr[wlWinValuesArray[lineflash] - 1][i - 1]].visible = true;
							planeAnimArr[squareArr[wlWinValuesArray[lineflash] - 1][i - 1]].animations.add('scatters_anim', [6, 5, 4, 3, 2, 1, 0], 7, false).play().onComplete.add(function () {
								for (var i = 1; i <= 15; ++i) {
									planeAnimArr[i].visible = false;
								}
							});
						}
						if (info[squareArr[wlWinValuesArray[lineflash] - 1][i - 1] - 1] === 9) {
							katerAnimArr[squareArr[wlWinValuesArray[lineflash] - 1][i - 1]].visible = true;
							katerAnimArr[squareArr[wlWinValuesArray[lineflash] - 1][i - 1]].animations.add('scatters_anim', [4, 3, 2, 1, 0], 7, false).play().onComplete.add(function () {
								for (var i = 1; i <= 15; ++i) {
									katerAnimArr[i].visible = false;
								}
							});
						}
					}
				}
			}
			flickLine(sizeLine, wlWinValuesArray[lineflash], wlWinValuesArray);
		}

		function flickLine(sizeLine, lineNumber, wlWinValuesArray) {
			if (stopWinAnim == true) {
				return;
			}
			showLine(lineNumber);
			for (var i = 1; i <= sizeLine; ++i) {
				squareArrImg[lineNumber - 1][i - 1].visible = true;
				game1.copyCell[squareArr[lineNumber - 1][i - 1]].visible = true;
			}
			setTimeout(function () {
				if (stopWinAnim == true) {
					return;
				}
				winText.visible = false;
				if (afterFreespinStatus) {
					winText.visible = false;
				}
				game1.lineArr[lineNumber].tint = 0x999999;
				for (var i = 1; i <= sizeLine; ++i) {
					squareArrImg[lineNumber - 1][i - 1].tint = 0x999999;
				}
				setTimeout(function () {
					if (stopWinAnim == true) {
						return;
					}
					game1.lineArr[lineNumber].tint = 0xffffff;
					for (var i = 1; i <= sizeLine; ++i) {
						squareArrImg[lineNumber - 1][i - 1].tint = 0xffffff;
					}
					winText.visible = true;
					if (afterFreespinStatus) {
						winText.visible = true;
					}
					setTimeout(function () {
						if (stopWinAnim == true) {
							return;
						}
						winText.visible = false;
						if (afterFreespinStatus) {
							winText.visible = false;
						}
						game1.lineArr[lineNumber].tint = 0x999999;
						for (var i = 1; i <= sizeLine; ++i) {
							squareArrImg[lineNumber - 1][i - 1].tint = 0x999999;
						}
						setTimeout(function () {
							if (stopWinAnim == true) {
								return;
							}
							game1.lineArr[lineNumber].tint = 0xffffff;
							for (var i = 1; i <= sizeLine; ++i) {
								squareArrImg[lineNumber - 1][i - 1].tint = 0xffffff;
							}
							winText.visible = true;
							if (afterFreespinStatus) {
								winText.visible = true;
							}
							setTimeout(function () {
								if (stopWinAnim == true) {
									return;
								}
								if (lineflash === wlWinValuesArray.length - 1) {
									firstAroundAnim = false;
									lineflash = 0;
								} else {
									lineflash = lineflash + 1;
								}
								if (wlWinValuesArray.length === 1) {
									winText.visible = false;
									if (afterFreespinStatus) {
										winText.visible = false;
									}
									game1.lineArr[lineNumber].tint = 0x999999;
									for (var i = 1; i <= sizeLine; ++i) {
										squareArrImg[lineNumber - 1][i - 1].tint = 0x999999;
									}
									setTimeout(function () {
										if (stopWinAnim == true) {
											return;
										}
										game1.lineArr[lineNumber].tint = 0xffffff;
										for (var i = 1; i <= sizeLine; ++i) {
											squareArrImg[lineNumber - 1][i - 1].tint = 0xffffff;
										}
										if (afterFreespinStatus) {
											hideLines();
											hideSquare();
											if (lineflash === 0) {
												showWinFreeSpin(wcvWinValuesArrayOld);
											} else {
												showWin(wlWinValuesArrayOld, winCellInfoOld)
											}
										} else {
											showWin(wlWinValuesArray, winCellInfo)
										}
									}, 150);
								} else {
									hideLines();
									hideSquare();
									for (var i = 1; i <= sizeLine; ++i) {
										game1.copyCell[squareArr[lineNumber - 1][i - 1]].visible = false;
									}
									if (afterFreespinStatus) {
										if (lineflash === 0) {
											showWinFreeSpin(wcvWinValuesArrayOld);
										} else {
											showWin(wlWinValuesArrayOld, winCellInfoOld)
										}
									} else {
										showWin(wlWinValuesArray, winCellInfo)
									}
								}
							}, 500);
						}, 200);
					}, 500);
				}, 200);
			}, 500);
		};

		function upLines() {
			stopWinAnim = true;
			bottomText.visible = false;
			for (var i = 1; i <= 15; ++i) {
				game1.copyCell[i].visible = false;
			}
			hideLines();
			hideSquare();
			lines = lines + 1;
			if (lines > 20) {
				lines = 1
				hideLinesCircle();
				hideLinesCircleText();
			}
			changeLine[lines].play();
			hideLines();
			showLine(lines);
			showLineCircle(lines);
			showLineCircleText(lines);
			bet = lines * betline;
			checkScore();
			linesText.setText(lines)
			totalBet.setText(bet)
		}

		function upLinesBet() {
			stopWinAnim = true;
			bottomText.visible = false;
			for (var i = 1; i <= 15; ++i) {
				game1.copyCell[i].visible = false;
			}
			hideLines();
			hideSquare();
			betline = betline + 1;
			if (betline > 20) {
				betline = 1
			}
			for (var i = 1; i <= 20; ++i) {
				game1.textArr[i].setText(betline);
			}
			changeBet[betline].play();
			bet = lines * betline;
			checkScore();
			lineBetText.setText(betline)
			totalBet.setText(bet)
		}

		function addScore() {

			credit = game.add.text(214, 664, balance, {
				font: '47px "Digital-7 Mono"',
				fill: '#01e033'
			});
			credit.anchor.setTo(1, 0.5);
			linesText = game.add.text(535, 664, lines, {
				font: '47px "Digital-7 Mono"',
				fill: '#01e033'
			});
			linesText.anchor.setTo(1, 0.5);
			lineBetText = game.add.text(665, 664, betline, {
				font: '47px "Digital-7 Mono"',
				fill: '#01e033'
			});
			lineBetText.anchor.setTo(1, 0.5);
			totalBet = game.add.text(812, 664, bet, {
				font: '47px "Digital-7 Mono"',
				fill: '#01e033'
			});
			totalBet.anchor.setTo(1, 0.5);
			paid = game.add.text(991, 664, '0', {
				font: '47px "Digital-7 Mono"',
				fill: '#01e033'
			});
			paid.anchor.setTo(1, 0.5);
			winText = game.add.text(149, 608, 'Trigger Pay \n40', {
				font: '22px "Arial"',
				fill: '#ffffff',
				fontWeight: 600,
				align: 'center'
			});
			winText.lineSpacing = -10;
			winText.anchor.setTo(0.5, 0.5);
			winText.visible = false;
			gameStatusText = game.add.text(893, 597, 'Play 400 Credits', {
				font: '22px "Arial"',
				fill: '#ffffff',
				fontWeight: 600
			});
			gameStatusText.anchor.setTo(0.5, 0.5);
			gameStatusText.visible = false;

			collect_text = game.add.text(510, 341, 'HAND PAY 25585 CREDITS', {
				font: '35px "PF Agora Slab Pro"',
				fill: '#fffc15'
			});
			collect_text.anchor.setTo(0.5, 0.5);
			collect_text.visible = false;
			bottomText = game.add.text(512, 609, 'BONUS!', {
				font: '35px "Arial"',
				fill: '#fffd6f',
				stroke: '#000000',
				strokeThickness: 5,
				fontWeight: 800
			});
			bottomText.anchor.setTo(0.5, 0.5);
			bottomText.visible = false;
		}
		function addGameModeText() {
			credit = game.add.text(214, 664, 'FREE GAME MODE', {
				font: '47px "Digital-7 Mono"',
				fill: '#01e033'
			});
		}
		function flickcollect_text() {
			collect_text.visible = true;
			setTimeout(function () {
				collect_text.visible = false;
				setTimeout(function () {
					flickcollect_text();
				}, 500);
			}, 500);
		}
		var helpPageCurent = 1;
		var paytablePageCurent = 1;

		function nextHelp(value) {
			helpPageCurent = helpPageCurent + 1;
			if (helpPageCurent > 4) {
				helpPageCurent = 1;
			}
			help_page.loadTexture('help_page_' + helpPageCurent);
		}

		function nextPaytable(value) {
			paytablePageCurent = paytablePageCurent + 1;
			if (paytablePageCurent > 5) {
				paytablePageCurent = 1;
			}
			paytable_page.loadTexture('paytable_page_' + paytablePageCurent);
		}

		showButMob = function showB() {
			showButtons();
		}
		hideButMob = function hideB() {
			hideButtons();
		}

		function stopUpdateBalance() {
			balanceUpdateStatus = false;
			if ((balance + allWin) < betline * lines) {
				autostart = false;
				$("#spin").removeClass('auto');
				showButtons();
				hideButtons([
					[startButton, 'startButton']
				]);
				hideButtons([
					[autoPlay, 'autoPlay']
				]);
				if ((balance + allWin) < 1) {
					hideButtons([
						[maxBetSpin, 'maxBetSpin']
					]);
				}
				hideMobileBtn();
				autoPlay.loadTexture('autoPlay');
				if ((balance + allWin) === 0 && demo !== 'true') {
					checkBalance();
					showButtons([
						[autoPlay, 'autoPlay']
					]);
					autoPlay.loadTexture('addCredit');
				}
			} else {
				if (autostart == false) {
					showButtons([
						[startButton, 'startButton']
					]);
					showButtons([
						[autoPlay, 'autoPlay']
					]);
					showButtons([
						[maxBetSpin, 'maxBetSpin']
					]);
					showMobileBtn();
				}
			}
			firstAroundAnim = false;
			katerSong.stop();
			planeSong.stop();
			carSong.stop();
			briLineWinSound.stop();
			winSound.stop();
			updateFinishSound.play();
			gameStatusTextFlick();
			changeNumberSpin();
			allWinOld = allWinOld + +allwinUpd;
			paid.setText(+allwinUpd);
			credit.setText(balance + +allwinUpd);
		}
		stopUB = function stopUpdateBalance2() {
			balanceUpdateStatus = false;
			if ((balance + allWin) < betline * lines) {
				autostart = false;
				$("#spin").removeClass('auto');
				showButtons();
				hideButtons([
					[startButton, 'startButton']
				]);
				hideButtons([
					[autoPlay, 'autoPlay']
				]);
				if ((balance + allWin) < 1) {
					hideButtons([
						[maxBetSpin, 'maxBetSpin']
					]);
				}
				hideMobileBtn();
				autoPlay.loadTexture('autoPlay');
				if ((balance + allWin) === 0 && demo !== 'true') {
					checkBalance();
					showButtons([
						[autoPlay, 'autoPlay']
					]);
					autoPlay.loadTexture('addCredit');
				}
			} else {
				if (autostart == false) {
					showButtons([
						[startButton, 'startButton']
					]);
					showButtons([
						[autoPlay, 'autoPlay']
					]);
					showButtons([
						[maxBetSpin, 'maxBetSpin']
					]);
					showMobileBtn();
				}
			}
			winSound.stop();
			updateFinishSound.play();
			gameStatusTextFlick();
			changeNumberSpin();
			allWinOld = allWinOld + +allwinUpd;
			paid.setText(+allwinUpd);
			credit.setText(balance + +allwinUpd);
		}

		function updateBalance() {
			var x = 0;
			var interval;
			if (autostart == false) {
				showButtons();
			};
			if ((balance + allWin) < betline * lines) {
				autostart = false;
				$("#spin").removeClass('auto');
				showButtons();
				hideButtons([
					[startButton, 'startButton']
				]);
				hideButtons([
					[autoPlay, 'autoPlay']
				]);
				if ((balance + allWin) < 1) {
					hideButtons([
						[maxBetSpin, 'maxBetSpin']
					]);
				}
				hideMobileBtn();
				autoPlay.loadTexture('autoPlay');
				if ((balance + allWin) === 0 && demo !== 'true') {
					checkBalance();
					showButtons([
						[autoPlay, 'autoPlay']
					]);
					autoPlay.loadTexture('addCredit');
				}
			} else {
				if (autostart == false) {
					showButtons([
						[startButton, 'startButton']
					]);
					showButtons([
						[autoPlay, 'autoPlay']
					]);
					showButtons([
						[maxBetSpin, 'maxBetSpin']
					]);
					showMobileBtn();
				}
			}
			if (briSound) {
				let randomText = randomNumber(1, 2);
				switch (randomText) {
					case 1:
						winSound = game.add.audio('high');
						break;
					case 2:
						winSound = game.add.audio('medium');
						break;
				}
			} else if (afterFreespinStatus || allWin >= (betline * lines * 3)) {
				let randomText = randomNumber(1, 2);
				switch (randomText) {
					case 1:
						winSound = game.add.audio('high');
						break;
					case 2:
						winSound = game.add.audio('medium');
						break;
				}
			} else if (allWin < (betline * lines * 3)) {
				winSound = game.add.audio('low');
			} else {
				winSound = game.add.audio('low');
			}
			winSound.loop = true;
			winSound.play();
			allwinUpd = +allWin;
			spinStatus = false;
			balanceUpdateStatus = true;
			if (afterFreespinStatus) {
				x = allWinOld;
			}
			(function () {
				if (x < allwinUpd) {
					interval = 1000 / 10;
					if (allWin > 5000) {
						x += 30;
					} else if (allWin > 2000) {
						x += 25;
					} else if (allWin > 1000) {
						x += 15;
					} else if (allWin > 500) {
						x += 10;
					} else if (allWin > 300) {
						x += 5;
					} else if (allWin > 200) {
						x += 3;
					} else if (allWin > 50) {
						x += 2;
					} else {
						x += 1;
					}
					if (balanceUpdateStatus === false) {
						return;
					} else {
						paid.setText(x);
						credit.setText(balance + x);
						setTimeout(arguments.callee, interval);
					}
				} else {
					balanceUpdateStatus = false;
					if (autostart == false) {
						showButtons();
					}
					if ((balance + allWin) < betline * lines) {
						autostart = false;
						$("#spin").removeClass('auto');
						showButtons();
						hideButtons([
							[startButton, 'startButton']
						]);
						hideButtons([
							[autoPlay, 'autoPlay']
						]);
						if ((balance + allWin) < 1) {
							hideButtons([
								[maxBetSpin, 'maxBetSpin']
							]);
						}
						hideMobileBtn();
						autoPlay.loadTexture('autoPlay');
						if ((balance + allWin) === 0 && demo !== 'true') {
							checkBalance();
							showButtons([
								[autoPlay, 'autoPlay']
							]);
							autoPlay.loadTexture('addCredit');
						}
					} else {
						if (autostart == false) {
							showButtons([
								[startButton, 'startButton']
							]);
							showButtons([
								[autoPlay, 'autoPlay']
							]);
							showButtons([
								[maxBetSpin, 'maxBetSpin']
							]);
							showMobileBtn();
						}
					}
					gameStatusTextFlick();
					changeNumberSpin();
					allWinOld = allWinOld + +allwinUpd;
					paid.setText(+allwinUpd);
					credit.setText(balance + +allwinUpd);
					winSound.stop();
					updateFinishSound.play();
					if (autostart == true) {
						setTimeout(function () {
							if (autostart == true & spinStatus === false) {
								startFunc();
							}
						}, 1000);
					}
				}
			})();
		}
		var coinArrayLeft = [];
		var coinArrayRight = [];

		function coinAnim() {
			coinArrayLeft = [];
			coinArrayRight = [];
			coins.play();
			hideButtons();
			for (var i = 0; i <= 5; ++i) {
				for (var j = 0; j <= 7; ++j) {
					coinArrayLeft[i] = game.add.sprite(-130 + 125 * i - j * 50, -130 - j * 80, 'coin_anim_2');
					coinArrayLeft[i].animations.add('coin_anim_2', animCoinArray[i], 16, true).play();
					coinGoLeftToRight(coinArrayLeft[i])
				}
				for (var j = 0; j <= 7; ++j) {
					coinArrayRight[i] = game.add.sprite(1024 - 125 * i + j * 50, -130 - j * 80, 'coin_anim_2');
					coinArrayRight[i].animations.add('coin_anim_2', animCoinArray[i], 16, true).play();
					coinGoRightToLeft(coinArrayRight[i]);
				}
			}
		}

		function coinGoRightToLeft(elem) {
			game.add.tween(elem).to({ x: elem.position.x - 900, y: elem.position.y + 1530 }, 3500, Phaser.Easing.LINEAR, true)
		}

		function coinGoLeftToRight(elem) {
			game.add.tween(elem).to({ x: elem.position.x + 900, y: elem.position.y + 1530 }, 3500, Phaser.Easing.LINEAR, true).onComplete.add(function () {
				location.href = '/';
			});
		}

		function giveBalance() {
			var x = 0;
			var interval;
			allBalance = balance + allWinOld;
			(function () {
				if (x < allBalance) {
					interval = 1000 / 10;
					if (allBalance > 5000) {
						x += 500;
					} else if (allBalance > 2000) {
						x += 250;
					} else if (allBalance > 1000) {
						x += 150;
					} else if (allBalance > 500) {
						x += 100;
					} else if (allBalance > 300) {
						x += 50;
					} else if (allBalance > 200) {
						x += 30;
					} else if (allBalance > 50) {
						x += 20;
					} else {
						x += 10;
					}
					credit.setText(allBalance - x);
					if (x > allBalance) {
						credit.setText(0);
					}
					setTimeout(arguments.callee, interval);
				} else {
					credit.setText(0);
				}
			})();
		}
		var flickBtn = false;

		function checkScore() {
			addcreditFlickStatus = false;
			if ((balance + allWinOld) < betline * lines ) {
				hideButtons([
					[startButton, 'startButton']
				]);
				if (!flickBtn) {
					autoPlay.loadTexture('autoPlay');
					hideButtons([
						[autoPlay, 'autoPlay']
					]);
				}
				if ((balance + allWinOld) < 1) {
					hideButtons([
						[maxBetSpin, 'maxBetSpin']
					]);
				}
				hideMobileBtn();
				if ((balance + allWinOld) === 0 && demo !== 'true') {
					checkBalance();
					addcreditFlickStatus = true;
					showButtons([
						[autoPlay, 'autoPlay']
					]);
					if (!flickBtn) {
						addcreditFlickStatus = true;
						bottomText.visible = true;
						bottomText.setText("To play please add credit to game.");
            bottomText.fontSize = 25;
						autoPlay.loadTexture('addCredit');
						addCreditFlick();
					}
				}
			} else {
				showButtons([
					[startButton, 'startButton']
				]);
				showButtons([
					[autoPlay, 'autoPlay']
				]);
				showButtons([
					[maxBetSpin, 'maxBetSpin']
				]);
				if (!autostart) {
					autoPlay.loadTexture('autoPlay');
				}
				showMobileBtn();
			}
		}
		var checkBalancedata;
		var getBalanceWait = false;

		function checkBalance() {
			if (!getBalanceWait && demo !== 'true') {
				if (((balance + allWinOld) === 0) && ((balance + allWin) === 0) && curGame === 1) {
					// getBalance();
				} else {
					checkBalanceTimer = true;
					setTimeout(function () {
						if (checkBalanceTimer && !autostart && curGame === 1 && !balanceUpdateStatus) {
							if ((balance + allWin) > 0) {
								// getBalance();
							}
						} else {
							checkBalance()
						}
					}, 30000);
				}
			}
		}

		// function getBalance() {
		//     if (!getBalanceWait) {
		//         getBalanceWait = true;
		//         $.ajax({
		//             type: "get",
		//             url: getNeedUrlPath() + '/get-user-balance?userId=' + userId + '&gameId=' + gameId + '&token=' + token,
		//             dataType: 'html',
		//             success: function(data) {
		//                 console.log(data)
		//                 if (IsJsonString(data)) {
		//                     checkBalancedata = JSON.parse(data);
		//                     setTimeout(function() {
		//                         getBalanceWait = false;
		//                         if (checkBalancedata['status'] == 'true') {
		//                             balance = +(checkBalancedata['balance'] * 100).toFixed();
		//                             changeBalance();
		//                         } else {
		//                             getBalance();
		//                         }
		//                     }, 900);
		//                 } else {
		//                     console.log('json format error');
		//                     error_bg.visible = true;
		//                     errorStatus = true;
		//                 }
		//             },
		//             error: function(xhr, ajaxOptions, thrownError) {
		//                 var errorText = 'ошибка 26';
		//                 console.log(errorText);
		//                 getBalance()
		//             }
		//         });
		//     }
		// }

		function changeBalance() {
			credit.setText(balance);
			checkScore();
			if ((balance + allWin) > 0) {
				checkBalance();
			}
		}

		function pickMaxSpin() {
			var currentBalance = balance + allWinOld;
			var curNumb = 1;
			var curLine = 1;
			var curBet = 1;
			for (var i = 1; i <= 20; ++i) {
				for (var j = 1; j <= 20; ++j) {
					if (i * j > curNumb & i * j <= currentBalance) {
						curNumb = i * j;
						curLine = i;
						curBet = j;
					} else if (i * j === curNumb) {
						if (curBet < j) {
							curLine = i;
							curBet = j;
						}
					}
				}
			}
			lines = curLine;
			betline = curBet;
		}

		function preStartSpin() {
			parseAnswerStatus = false;
			dataSpinRequest['status'] = false;
			allWinOld = 0;
			stopWinAnim = true;
			lineflash = 0;
			realSpinStatus = true;
			spinStatus = true;
			firstAnim = true;
			winText.visible = false;
			afterFreespinStatus = false;
			for (var i = 1; i <= 15; ++i) {
				game1.copyCell[i].visible = false;
				squareArrFreespin[i].visible = false;
				squareArrFreespin[i].tint = 0xffffff;
				briAnimArr[i].visible = false;
				coinAnimArr[i].visible = false;
				planeAnimArr[i].visible = false;
				katerAnimArr[i].visible = false;
			}
			gameStatusText.visible = false;
			bottomText.visible = true;
			bottomText.setText('Good Luck!');
      bottomText.fontSize = 35;
			paid.setText('0');
			startButton.loadTexture('stopButton');
			hideLines();
			hideButtons([
				[paytable, 'paytable'],
				[help, 'help'],
				[selectLines, 'selectLines'],
				[betPerLine, 'betPerLine'],
				[startButton, 'startButton'],
				[maxBetSpin, 'maxBetSpin'],
				[exit, 'exit']
			]);
			if (autostart === false) {
				showButtons([
					[startButton, 'startButton']
				]);
				hideButtons([
					[autoPlay, 'autoPlay']
				]);
			} else {
				showMobileBtn();
			}
			hideSquare();
			// bg2_panels.loadTexture('game.background');
			// slotLayer2Group.add(topLabel);
			setTimeout(function () {
				startspin(0);
				setTimeout(function () {
					startspin(1);
					setTimeout(function () {
						startspin(2);
						setTimeout(function () {
							startspin(3);
							setTimeout(function () {
								startspin(4);
								let randomText = randomNumber(1, 2);
								spinSound = game.add.audio('spinSound' + randomText);
								spinSound.play();
							}, 50);
						}, 50);
					}, 50);
				}, 50);
			}, 50);
		}
		if (firstStartGame) {
			checkBalance();
			firstStartGame = false;
			addEventListener("keyup", function (event) {
				if (event.keyCode == 32) {
					if (!errorStatus) {
						if (curGame === 1) {
							if (spaceStatus) {
								if (spinStatus === false) {
									if (paytableStatus === false) {
										if (autostart === false) {
											if ((balance + allWinOld) >= betline * lines) {
												if (balanceUpdateStatus) {
													stopUpdateBalance();
												} else {
													spinStatus = true;
													preStartSpin();
												}
											}
										}
									}
								}
							} else {
								if (paytableStatus === false) {
									if (autostart === false) {
										if (timeSpin) {
											if (dataSpinRequest['status'] !== 'false') {
												if (parseAnswerStatus) {
													startButton.loadTexture('startButton');
													hideButtons([
														[startButton, 'startButton']
													]);
													if (g1s === true) {
														g1s = false;
													} else {
														g2s = false;
													}
													spinSound.stop();
													timeSpin = false;
													game1.bars[0].visible = false;
													game1.cell[1 + 3 * 0].visible = true;
													game1.cell[2 + 3 * 0].visible = true;
													game1.cell[3 + 3 * 0].visible = true;
													game1.bars[1].visible = false;
													game1.cell[1 + 3 * 1].visible = true;
													game1.cell[2 + 3 * 1].visible = true;
													game1.cell[3 + 3 * 1].visible = true;
													game1.bars[2].visible = false;
													game1.cell[1 + 3 * 2].visible = true;
													game1.cell[2 + 3 * 2].visible = true;
													game1.cell[3 + 3 * 2].visible = true;
													game1.bars[3].visible = false;
													game1.cell[1 + 3 * 3].visible = true;
													game1.cell[2 + 3 * 3].visible = true;
													game1.cell[3 + 3 * 3].visible = true;
													game1.bars[4].visible = false;
													game1.cell[1 + 3 * 4].visible = true;
													game1.cell[2 + 3 * 4].visible = true;
													game1.cell[3 + 3 * 4].visible = true;
													game1.cell[1].loadTexture('cell' + info[0] + '_x');
													game1.cell[2].loadTexture('cell' + info[1] + '_x');
													game1.cell[3].loadTexture('cell' + info[2] + '_x');
													game1.cell[4].loadTexture('cell' + info[3] + '_x');
													game1.cell[5].loadTexture('cell' + info[4] + '_x');
													game1.cell[6].loadTexture('cell' + info[5] + '_x');
													game1.cell[7].loadTexture('cell' + info[6] + '_x');
													game1.cell[8].loadTexture('cell' + info[7] + '_x');
													game1.cell[9].loadTexture('cell' + info[8] + '_x');
													game1.cell[10].loadTexture('cell' + info[9] + '_x');
													game1.cell[11].loadTexture('cell' + info[10] + '_x');
													game1.cell[12].loadTexture('cell' + info[11] + '_x');
													game1.cell[13].loadTexture('cell' + info[12] + '_x');
													game1.cell[14].loadTexture('cell' + info[13] + '_x');
													game1.cell[15].loadTexture('cell' + info[14] + '_x');
													if (game1.spinStatus1 === true) {
														game1.spinStatus1 = false;
														endspin(0);
													}
													if (game1.spinStatus2 === true) {
														game1.spinStatus2 = false;
														endspin(1);
													}
													if (game1.spinStatus3 === true) {
														game1.spinStatus3 = false;
														endspin(2);
													}
													if (game1.spinStatus4 === true) {
														game1.spinStatus4 = false;
														endspin(3);
													}
													if (game1.spinStatus5 === true) {
														game1.spinStatus5 = false;
														endspin(4);
													}
													finishSpinSound.play();
												}
											}
										}
									}
								}
							}
						} else if (curGame === 2) {
							if (balanceUpdateStatus2) {
								balanceUpdateStatus2 = false;
							}
						}
					}
				}
			});
			$('canvas').mouseup(function (e) {
				if (curGame === 2) {
					if (balanceUpdateStatus2) {
						balanceUpdateStatus2 = false;
					}
				}
			});
			hideMobileBtn();
			if (isMobile) {
				black_bg2 = game.add.sprite(0, 0, 'black_bg2');
				black_bg2.inputEnabled = true;
				btn_yes = game.add.sprite(238, 476, 'btn_yes');
				btn_yes.inputEnabled = true;
				btn_yes.input.useHandCursor = true;
				btn_yes.events.onInputUp.add(function () {
					game.sound.mute = false;
					black_bg2.visible = false;
					btn_yes.visible = false;
					btn_no.visible = false;
					checkScore()
				});
				btn_no = game.add.sprite(544, 475, 'btn_no');
				btn_no.inputEnabled = true;
				btn_no.input.useHandCursor = true;
				btn_no.events.onInputUp.add(function () {
					game.sound.mute = true;
					black_bg2.visible = false;
					btn_yes.visible = false;
					btn_no.visible = false;
					checkScore()
				});
			} else {
				checkScore();
			}
		};
	};

	game1.update = function () {
		if (game1.spinStatus1) {
			game1.bars[0].tilePosition.y += 40;
		}
		if (game1.spinStatus2) {
			game1.bars[1].tilePosition.y += 40;
		}
		if (game1.spinStatus3) {
			game1.bars[2].tilePosition.y += 40;
		}
		if (game1.spinStatus4) {
			game1.bars[3].tilePosition.y += 40;
		}
		if (game1.spinStatus5) {
			game1.bars[4].tilePosition.y += 40;
		};
		game1.ticker.tilePosition.x += 0.5;
	};

	game.state.add('game1', game1);

};
