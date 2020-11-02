var game = new Phaser.Game(
    1024,
    800,
    Phaser.AUTO,
    "",
    "ld29",
    null,
    false,
    false
);

if (devicePixelRatio && devicePixelRatio > 1.9) {
    game.resolution = devicePixelRatio;
}

var game1;
var triggerShow = 0;
var isTriggerPay = true;
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
var allowSpin = true;
var briMulti = [];
var timerSpin = [];
var isGetResponse = false;
var globalMiddleSpin;
var doItOnce = true;
var isSpinStart = false;
var lola = false;
var isEnd = {
    "0": false,
    "1": false,
    "2": false,
    "3": false,
    "4": false
};

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

var evIdAfterFreeeSpeen = "";

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
        colorLine: [
            "#009800",
            "#fffc00",
            "#0004ff",
            "#ff0000",
            "#ff00d1",
            "#00fa6d",
            "#89ff00",
            "#ff7f00",
            "#9400ff",
            "#0004ff",
            "#009300",
            "#ff3900",
            "#ff3900",
            "#9400ff",
            "#89ff00"
        ]
    };

    game1.create = function() {
        window.onfocus = function() {
            !spinStatus && console.log("___ GET BALANCE ___");
        };

        if (
            game.sound.usingWebAudio &&
            game.sound.context.state === "suspended"
        ) {
            game.input.onTap.addOnce(
                game.sound.context.resume,
                game.sound.context
            );
        }
        if (
            this.game.device.android &&
            this.game.device.chrome &&
            this.game.device.chromeVersion >= 55
        ) {
            this.game.sound.setTouchLock();
            this.game.sound.touchLocked = true;
            this.game.input.touch.addTouchLockCallback(
                function() {
                    if (
                        this.noAudio ||
                        !this.touchLocked ||
                        this._unlockSource !== null
                    ) {
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

                        if (this._unlockSource.context.state === "suspended") {
                            this._unlockSource.context.resume();
                        }
                    }

                    return true;
                },
                this.game.sound,
                true
            );
        }
        if (demo === "demo") {
            game.scale.setGameSize(1024, 831);
        }
        freeSpinsBegin = false;
        game1.ticker = game.add.tileSprite(0, 800, 1154, 31, "ticker");
        checkBalanceTimer = false;
        createdStarsStatus = true;
        createdStarsMiniStatus = true;
        curGame = 1;
        spaceStatus = true;
        spinStatus = false;
        var lineflash = 0;
        coinSound1 = game.add.audio("coin1");
        coinSound2 = game.add.audio("coin2");
        coinSound3 = game.add.audio("coin3");
        coinSound4 = game.add.audio("coin4");
        coinSound5 = game.add.audio("coin5");
        forcedStop = game.add.audio("forcedStop");
        coins = game.add.audio("coins");
        for (var i = 1; i <= 20; ++i) {
            changeLine[i] = game.add.audio("changeLine" + i);
            changeBet[i] = game.add.audio("changeBet" + i);
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
        // info = [7, 1, 2, 3, 4, 5, 6, 7, 3, 9, 9, 1, 2, 3, 1];
        animCoinArray = [
            [0, 1, 2, 3, 4, 5, 6, 7],
            [2, 3, 4, 5, 6, 7, 0, 1],
            [3, 4, 5, 6, 7, 0, 1, 2],
            [4, 5, 6, 7, 0, 1, 2, 3],
            [6, 7, 0, 1, 2, 3, 4, 5],
            [7, 0, 1, 2, 3, 4, 5, 6]
        ];
        bg = game.add.sprite(0, 0, "game.background2");

        slotLayer1Group = game.add.group();
        slotLayer1Group.add(bg);

        topLabel = game.add.sprite(240, 0, "top_label_1");

        bg_overlay = game.add.sprite(0, 0, "game.background_overlay");

        slotLayer3Group = game.add.group();
        slotLayer3Group.add(topLabel);
        slotLayer2Group = game.add.group();
        groupCell = game.add.group();
        slotLayer2Group.add(bg_overlay);
        slotLayer4Group = game.add.group();

        for (var i = 1; i <= 15; ++i) {
            if (i === 1 || i === 4 || i === 7 || i === 10 || i === 13) {
                game1.cell[i] = game.add.sprite(
                    cellPos[i - 1][0],
                    cellPos[i - 1][1],
                    "cell" + info[i - 1]
                );
            }
            if (i === 2 || i === 5 || i === 8 || i === 11 || i === 14) {
                game1.cell[i] = game.add.sprite(
                    cellPos[i - 1][0],
                    cellPos[i - 1][1],
                    "cell" + info[i - 1]
                );
            }
            if (i === 3 || i === 6 || i === 9 || i === 12 || i === 15) {
                game1.cell[i] = game.add.sprite(
                    cellPos[i - 1][0],
                    cellPos[i - 1][1],
                    "cell" + info[i - 1]
                );
            }
            groupCell.add(game1.cell[i]);
        }
        var mask = game.add.graphics(0, 0);
        mask.beginFill(0xffffff);
        mask.drawRect(0, 127, 1024, 449);
        groupCell.mask = mask;
        game1.bars[0] = game.add.tileSprite(77, 126, 158, 447, "bar");
        game1.bars[0].tilePosition.y = randomNumber(0, 9) * 149;
        game1.bars[1] = game.add.tileSprite(255, 126, 158, 447, "bar");
        game1.bars[1].tilePosition.y = randomNumber(0, 9) * 149;
        game1.bars[2] = game.add.tileSprite(433, 126, 158, 447, "bar");
        game1.bars[2].tilePosition.y = randomNumber(0, 9) * 149;
        game1.bars[3] = game.add.tileSprite(611, 126, 158, 447, "bar");
        game1.bars[3].tilePosition.y = randomNumber(0, 9) * 149;
        game1.bars[4] = game.add.tileSprite(788, 126, 158, 447, "bar");
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
        bg2_panels = game.add.sprite(0, 0, "background2_panels");
        createdStars();
        createdStarsMini();
        // slotLayer3Group.add(star_anim);
        slotLayer2Group.add(bg2_panels);

        function createdStars() {
            let coordX = randomNumber(0, 1020);
            let coordY;
            let star;
            if (coordX < 41 || coordX > 979) {
                coordY = randomNumber(0, 600);
            } else {
                coordY = randomNumber(0, 65);
            }
            star = game.add.sprite(coordX, coordY, "star_anim");
            star.anchor.setTo(0.5, 0.5);
            star.angle = randomNumber(0, 360);
            star.animations
                .add("anim", [5, 4, 3, 2, 1, 0], 5, false)
                .play()
                .onComplete.add(function() {
                    star.destroy();
                });
            slotLayer1Group.add(star);
            setTimeout(function() {
                if (createdStarsStatus) {
                    createdStars();
                }
            }, 200);
        }

        function createdStarsMini() {
            let coordX = randomNumber(240, 792);
            let coordY = randomNumber(0, 110);
            let star;
            star = game.add.sprite(coordX, coordY, "star_anim_mini");
            star.angle = randomNumber(0, 360);
            star.animations
                .add("anim", [], 4, false)
                .play()
                .onComplete.add(function() {
                    star.destroy();
                });

            slotLayer4Group.add(star);
            setTimeout(function() {
                if (createdStarsMiniStatus) {
                    createdStarsMini();
                }
            }, 30);
        }

        let numberSpin = 0;

        function changeNumberSpin() {
            numberSpin = numberSpin + 1;
            if (numberSpin > 17) {
                numberSpin = 0;
            }
            if (numberSpin === 0 || numberSpin === 6 || numberSpin === 12) {
                createdStarsMiniStatus = true;
                animTopLabel("top_label_1");
            }
            if (numberSpin === 3) {
                createdStarsMiniStatus = false;
                animTopLabel("top_label_2");
            }
            if (numberSpin === 9) {
                createdStarsMiniStatus = false;
                animTopLabel("top_label_3");
            }
            if (numberSpin === 15) {
                createdStarsMiniStatus = false;
                animTopLabel("top_label_4");
            }
        }

        function animTopLabel(img) {
            game.add
                .tween(topLabel)
                .to(
                    {
                        y:
                            img === "top_label_1"
                                ? topLabel.position.y + 120
                                : topLabel.position.y + 103
                    },
                    400,
                    "Linear",
                    true
                )
                .onComplete.add(function() {
                    changeImgTopLabel(img);
                    game.add
                        .tween(topLabel)
                        .to(
                            {
                                y:
                                    img === "top_label_1"
                                        ? topLabel.position.y - 140
                                        : topLabel.position.y - 83
                            },
                            400,
                            "Linear",
                            true
                        )
                        .onComplete.add(function() {
                            changeImgTopLabel(img);
                            if (img === "top_label_1") {
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
            [36, 353],
            [36, 209],
            [36, 496],
            [36, 117],
            [36, 591],
            [36, 448],
            [36, 255],
            [36, 163],
            [36, 543],
            [989, 184],
            [989, 521],
            [989, 329],
            [989, 377],
            [989, 232],
            [989, 473],
            [989, 281],
            [989, 425],
            [989, 136],
            [989, 569],
            [36, 400]
        ];
        squareArrFreespin = [];
        coinAnimArr = [];
        briAnimArr = [];
        carAnimArr = [];
        planeAnimArr = [];
        katerAnimArr = [];
        addLines(circlePos, linePos, textPos, cellPos, squareArr, squareArrImg);
        hideLines();
        hideLinesCircle();
        hideLinesCircleText();
        for (var i = 1; i <= lines; i++) {
            showLineCircle(i);
            showLineCircleText(i);
            game1.textArr[i].setText(betline);
        }
        blue_field = game.add.sprite(93, 301, "blue_field");
        blue_field.visible = false;

        function addLines(
            circlePos,
            linePos,
            textPos,
            cellPos,
            squareArr,
            squareArrImg
        ) {
            for (var i = 1; i <= 20; ++i) {
                game1.lineArr[i] = game.add.sprite(0, 0, "line_" + i);
                game1.circleArr[i] = game.add.sprite(
                    circlePos[i - 1][0],
                    circlePos[i - 1][1],
                    "circleLine_" + i
                );
                game1.textArr[i] = game.add.text(
                    textPos[i - 1][0],
                    textPos[i - 1][1],
                    betline,
                    {
                        font: '30px "PragmaticaBoldCyrillic"',
                        fill: "#ffffff",
                        stroke: "#000000",
                        strokeThickness: 6
                    }
                );
                game1.textArr[i].anchor.setTo(0.5, 0.5);
            }
            for (var i = 1; i <= 15; ++i) {
                game1.copyCell[i] = game.add.sprite(
                    cellPos[i - 1][0],
                    cellPos[i - 1][1],
                    "cell0"
                );
                game1.copyCell[i].visible = false;
                briAnimArr[i] = game.add.sprite(
                    cellPos[i - 1][0] - 1,
                    cellPos[i - 1][1] - 1,
                    "bri_anim"
                );
                briAnimArr[i].visible = false;
                coinAnimArr[i] = game.add.sprite(
                    cellPos[i - 1][0],
                    cellPos[i - 1][1],
                    "coin_anim"
                );
                coinAnimArr[i].visible = false;
                carAnimArr[i] = game.add.sprite(
                    cellPos[i - 1][0] - 1,
                    cellPos[i - 1][1] - 1,
                    "car_anim"
                );
                carAnimArr[i].visible = false;
                planeAnimArr[i] = game.add.sprite(
                    cellPos[i - 1][0],
                    cellPos[i - 1][1],
                    "plane_anim"
                );
                planeAnimArr[i].visible = false;
                katerAnimArr[i] = game.add.sprite(
                    cellPos[i - 1][0] - 1,
                    cellPos[i - 1][1] - 1,
                    "kater_anim"
                );
                katerAnimArr[i].visible = false;
                squareArrFreespin[i] = game.add.sprite(
                    cellPos[i - 1][0] - 1,
                    cellPos[i - 1][1] - 1,
                    "square_1"
                );
                squareArrFreespin[i].visible = false;
            }
            for (var i = 1; i <= 20; ++i) {
                for (var j = 1; j <= 5; ++j) {
                    squareArrImg[i - 1][j - 1] = game.add.sprite(
                        cellPos[squareArr[i - 1][j - 1] - 1][0] - 1,
                        cellPos[squareArr[i - 1][j - 1] - 1][1] - 1,
                        "square_" + i
                    );
                    // game.add
                    //     .tween(squareArrImg[i - 1][j - 1])
                    //     .to({ alpha: 0 }, 100, Phaser.Easing.LINEAR, true)
                    //     .onComplete.add(function() {});

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

        function hideLines() {
            game1.lineArr.forEach(function(line) {
                line.visible = false;
                line.tint = 0xffffff;
            });
        }

        function hideLinesCircle() {
            game1.circleArr.forEach(function(line) {
                line.visible = false;
            });
        }

        function hideLinesCircleText() {
            game1.textArr.forEach(function(line) {
                line.visible = false;
            });
        }

        function hideSquare() {
            for (var i = 1; i <= 20; ++i) {
                for (var j = 1; j <= 5; ++j) {
                    squareArrImg[i - 1][j - 1].visible = false;
                    squareArrImg[i - 1][j - 1].tint = 0xffffff;
                }
            }
            for (var i = 1; i <= 15; ++i) {
                squareArrFreespin[i].visible = false;
                squareArrFreespin[i].tint = 0xffffff;
            }
        }

        exit = game.add.sprite(27, 706, "exit");
        exit.inputEnabled = true;
        exit.input.useHandCursor = true;
        exit.events.onInputUp.add(function(click, pointer) {
            return_to_gameSong.play();
            exit.loadTexture("exit");
            if (balanceUpdateStatus) {
                stopUpdateBalance();
            } else {
                bottomText.visible = false;
                hideLines();
                if (demo !== "demo") {
                    if (BALANCE + allWin !== 0) {
                        $(".popup_exit,.overlay").show();
                    } else {
                        exitGame(false);
                    }
                } else {
                    exitGame(false);
                }
            }
        });
        paytable = game.add.sprite(265, 706, "paytable");
        paytable.inputEnabled = true;
        paytable.input.useHandCursor = true;
        paytable.events.onInputUp.add(function(click, pointer) {
            paytable.loadTexture("paytable");
            if (balanceUpdateStatus) {
                stopUpdateBalance();
            } else {
                openInfoPage("paytable");
                eventId.visible = false;
                if (isMobile) {
                    document.querySelector(".btn_1").style.display = "none";
                }

                bottomText.visible = false;
                hideLines();
                hideButtons();
            }
        });
        help = game.add.sprite(163, 706, "help");
        help.inputEnabled = true;
        help.input.useHandCursor = true;
        help.events.onInputUp.add(function(click, pointer) {
            help.loadTexture("help");
            if (balanceUpdateStatus) {
                stopUpdateBalance();
            } else {
                eventId.visible = false;
                if (isMobile) {
                    document.querySelector(".btn_1").style.display = "none";
                }
                openInfoPage("help");
                bottomText.visible = false;
                hideLines();
                hideButtons();
            }
        });

        selectLines = game.add.sprite(412, 706, "selectLines");
        selectLines.inputEnabled = true;
        selectLines.input.useHandCursor = true;
        selectLines.events.onInputDown.add(function() {
            // selectLines.loadTexture('selectLines_p');
        });
        selectLines.events.onInputUp.add(function(click, pointer) {
            // if (pointer.button !== 0 && pointer.button !== undefined)
            //     return;
            // if (!window.navigator.onLine) return;

            selectLines.loadTexture("selectLines");
            if (balanceUpdateStatus) {
                stopUpdateBalance();
            } else {
                upLines();
            }
        });
        betPerLine = game.add.sprite(531, 706, "betPerLine");
        betPerLine.inputEnabled = true;
        betPerLine.input.useHandCursor = true;
        betPerLine.events.onInputDown.add(function() {});
        betPerLine.events.onInputUp.add(function(click, pointer) {
            betPerLine.loadTexture("betPerLine");
            if (balanceUpdateStatus) {
                stopUpdateBalance();
            } else {
                upLinesBet();
            }
        });
        allWin = 0;
        autoPlay = game.add.sprite(888, 706, "autoPlay");
        autoPlay.inputEnabled = true;
        autoPlay.input.useHandCursor = true;
        autoPlay.events.onInputDown.add(function() {});
        autoPlay.events.onInputUp.add(function(click, pointer) {
            if (autostart === false) {
                if (balanceUpdateStatus) {
                    stopUpdateBalance();
                    autoPlay.loadTexture("autoPlay");
                } else {
                    if (
                        BALANCE + allWinOld < betline * lines &&
                        demo !== "demo"
                    ) {
                        console.log("press add credits");
                        $.ajax({
                            type: "get",
                            url:
                                getNeedUrlPath() +
                                "/add-credit?userId=" +
                                userId +
                                "&gameId=" +
                                gameId +
                                "&token=" +
                                token +
                                "&platform_id=" +
                                platformId,
                            dataType: "html",
                            success: function(data) {
                                console.log(
                                    getNeedUrlPath() +
                                        "/add-credit?userId=" +
                                        userId +
                                        "&gameId=" +
                                        gameId +
                                        "&token=" +
                                        token +
                                        "&platform_id=" +
                                        platformId
                                );
                                console.log(data);
                            },
                            error: function(xhr, ajaxOptions, thrownError) {
                                var errorText = "ошибка 80";
                                alert(errorText);
                            }
                        });
                    } else {
                        $("#spin").addClass("auto");
                        autoPlay.loadTexture("autoStop");
                        autostart = true;
                        startFunc();
                    }
                }
            } else {
                autoPlay.loadTexture("autoPlay");
                $("#spin").removeClass("auto");
                autostart = false;
                showButtons();
                if (spinStatus === true) {
                    hideButtons();
                    showButtons([[startButton, "startButton"]]);
                    startButton.loadTexture("stopButton");
                }
            }
        });
        startButton = game.add.sprite(650, 706, "startButton");
        startButton.inputEnabled = true;
        startButton.input.useHandCursor = true;
        startButton.events.onInputDown.add(function() {});
        startButton.events.onInputUp.add(function(click, pointer) {
            if (maxBetSpin.visible) spaceStatus = true;
            if (isSpinStart) allowSpin = false;
            if (spaceStatus && allowSpin) {
                if (balanceUpdateStatus) {
                    startButton.loadTexture("startButton");
                    stopUpdateBalance();
                } else {
                    preStartSpin();
                }
            } else {
                if (paytableStatus === false) {
                    if (autostart === false) {
                        if (timeSpin) {
                            if (dataSpinRequest["status"]) {
                                if (parseAnswerStatus) {
                                    startButton.loadTexture("startButton");
                                    hideButtons([[startButton, "startButton"]]);
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
                                    game1.cell[1].loadTexture("cell" + info[0]);
                                    game1.cell[2].loadTexture("cell" + info[1]);
                                    game1.cell[3].loadTexture("cell" + info[2]);
                                    game1.cell[4].loadTexture("cell" + info[3]);
                                    game1.cell[5].loadTexture("cell" + info[4]);
                                    game1.cell[6].loadTexture("cell" + info[5]);
                                    game1.cell[7].loadTexture("cell" + info[6]);
                                    game1.cell[8].loadTexture("cell" + info[7]);
                                    game1.cell[9].loadTexture("cell" + info[8]);
                                    game1.cell[10].loadTexture(
                                        "cell" + info[9]
                                    );
                                    game1.cell[11].loadTexture(
                                        "cell" + info[10]
                                    );
                                    game1.cell[12].loadTexture(
                                        "cell" + info[11]
                                    );
                                    game1.cell[13].loadTexture(
                                        "cell" + info[12]
                                    );
                                    game1.cell[14].loadTexture(
                                        "cell" + info[13]
                                    );
                                    game1.cell[15].loadTexture(
                                        "cell" + info[14]
                                    );
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
        });

        maxBetSpin = game.add.sprite(769, 706, "maxBetSpin");
        maxBetSpin.inputEnabled = true;
        maxBetSpin.input.useHandCursor = true;
        maxBetSpin.events.onInputDown.add(function() {
            // maxBetSpin.loadTexture("maxBetSpin_p");
        });
        maxBetSpin.events.onInputUp.add(function(click, pointer) {
            maxBetSpin.loadTexture("maxBetSpin");
            if (balanceUpdateStatus) {
                stopUpdateBalance();
            } else {
                if (BALANCE + allWinOld > 399) {
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
                linesText.setText(lines);
                lineBetText.setText(betline);
                bet = lines * betline;
                totalBet.setText(bet);
                activateFreeSpins = true;
                preStartSpin();
            }
        });
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
        BALANCE = +BALANCE;
        if (afterFreespinStatus) {
            BALANCE = balanceOld;
        }
        addScore();
        addinfoPage();

        eventId = game.add.text(
            1020,
            0,
            evIdAfterFreeeSpeen ? evIdAfterFreeeSpeen : "",
            {
                font: "17px Arial",
                fill: "#fff",
                fontWeight: "bold"
            }
        );
        eventId.anchor.setTo(1, 0);
        freespinStartBG = game.add.sprite(75, 125, "freespinStartBG");
        freespinStartBG.visible = false;
        freesponStartBGText = game.add.sprite(75, 125, "freesponStartBGText");
        freesponStartBGText.visible = false;
        big_red_border = game.add.sprite(497, 343, "coin_big_anim");
        big_red_border.anchor.setTo(0.5, 0.5);
        big_red_border.visible = false;
        blackBg = game.add.sprite(0, 0, "black_bg");
        blackBg.alpha = 0;
        blackBg.visible = false;
        establishing_bg = game.add.sprite(0, 0, "establishing_bg");
        establishing_bg.visible = false;
        session_bg = game.add.sprite(0, 0, "session_bg");
        session_bg.visible = false;
        error_bg = game.add.sprite(0, 0, "error_bg");
        error_bg.visible = false;

        if (afterFreespinStatus) {
            wlValues = wlValuesOld;
            winWithoutCoin = winWithoutCoinOld;
            stopWinAnim = false;
            hideButtons();
            allWin = allWinOld + winOldTrigerFreeSpin;
            bottomText.visible = true;
            bottomText.setText(allWin + " Credits Won");
            bottomText.y = 0;
            bottomText.fontSize = 35;

            paid.setText(allWinOld);
            info = infoOldOnlyForThisWindow;
            for (var i = 1; i <= 15; ++i) {
                game1.cell[i].loadTexture(
                    "cell" + infoOldOnlyForThisWindow[i - 1]
                );
                game1.copyCell[i].loadTexture(
                    "cell" + infoOldOnlyForThisWindow[i - 1]
                );
            }
            showWinFreeSpin(wcvWinValuesArrayOld);
            updateBalance();
        } else {
            gameStatusTextFlick();
        }

        var coinCount = 0;

        function parseSpinAnswer(dataSpinRequest) {
            console.log(dataSpinRequest);
            console.log(`Win : ${dataSpinRequest.stateData.isWin}`);

            dataArray = dataSpinRequest;
            dataArrValue = dataArray.length;

            winCellInfo = dataArray.logicData["winningCells"];
            wlValues = dataArray.logicData["payoffsForLines"];

            balanceR =
                dataArray.balanceData["balance"] -
                dataArray.balanceData["totalPayoff"];
            BALANCE =
                dataArray.balanceData["balance"] -
                dataArray.balanceData["totalPayoff"];

            allWin = dataArray.balanceData["payoffByLines"];

            if (dataArray.sessionData["eventId"]) {
                evIdAfterFreeeSpeen = dataArray.sessionData["eventId"];
                eventId.setText(`${dataArray.sessionData["eventId"]}`);
                eventId.visible = true;
            }

            if (dataSpinRequest.stateData.isWinOnBonus) {
                allWin = dataArray.balanceData["totalPayoff"];
                triggerPay = winOldTrigerFreeSpin =
                    dataArray.balanceData["totalPayoff"];
                infoOld = dataArray.logicData.table;
                mulFreespin = dataArray.logicData.multiplier;
                wlValuesOld = dataArray.logicData["payoffsForLines"];
                console.log(wlValuesOld);
                balanceOld =
                    dataArray.balanceData["balance"] -
                    dataArray.balanceData["totalPayoff"];
            }
            if (realSpinStatus) {
                credit.setText(BALANCE);
                realSpinStatus = false;
            }

            coinCount = 0;
            info = dataArray.logicData.table;
            parseAnswerStatus = true;
            isGetResponse = true;
            middlespin(0, 700);
            middlespin(1, 1050);
            middlespin(2, 1400);
            middlespin(3, 1750);
            middlespin(4, 2100);
        }

        startFunc = function startAuto() {
            preStartSpin();
        };

        function startspin(number) {
            game.add
                .tween(game1.cell[1 + number * 3])
                .to(
                    { y: game1.cell[1 + number * 3].position.y - 30 },
                    60,
                    Phaser.Easing.LINEAR,
                    true
                )
                .onComplete.add(function() {
                    game1.cell[1 + number * 3].visible = false;
                });
            game.add
                .tween(game1.cell[2 + number * 3])
                .to(
                    { y: game1.cell[2 + number * 3].position.y - 30 },
                    60,
                    Phaser.Easing.LINEAR,
                    true
                )
                .onComplete.add(function() {
                    game1.cell[2 + number * 3].visible = false;
                });
            game.add
                .tween(game1.cell[3 + number * 3])
                .to(
                    { y: game1.cell[3 + number * 3].position.y - 30 },
                    60,
                    Phaser.Easing.LINEAR,
                    true
                )
                .onComplete.add(function() {
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
                        requestSpin(gamename, sessionUuid, betline, lines);
                        changeTextCur = changeTextCur + 1;
                        if (changeTextCur === changeTextValue) {
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
        }

        function middlespin(number, time) {
            if (number == 0) {
                timerSpin[number] = setTimeout(function() {
                    if (timeSpin) {
                        game1.spinStatus1 = false;
                        game1.bars[0].visible = false;
                        game1.cell[1 + 3 * 0].visible = true;
                        game1.cell[2 + 3 * 0].visible = true;
                        game1.cell[3 + 3 * 0].visible = true;
                        game1.cell[1].loadTexture("cell" + info[0]);
                        game1.cell[2].loadTexture("cell" + info[1]);
                        game1.cell[3].loadTexture("cell" + info[2]);
                        if (info[0] == 10 || info[1] == 10 || info[2] == 10) {
                            coinCount = coinCount + 1;
                            coinSound1.play();
                        } else {
                            finishSpinSound1.play();
                        }
                        endspin(number);
                    }
                }, time);
            }
            if (number == 1) {
                timerSpin[number] = setTimeout(function() {
                    if (timeSpin) {
                        game1.spinStatus2 = false;
                        game1.bars[0].visible = false;
                        game1.cell[1 + 3 * 0].visible = true;
                        game1.cell[2 + 3 * 0].visible = true;
                        game1.cell[3 + 3 * 0].visible = true;
                        game1.bars[1].visible = false;
                        game1.cell[1 + 3 * 1].visible = true;
                        game1.cell[2 + 3 * 1].visible = true;
                        game1.cell[3 + 3 * 1].visible = true;
                        game1.cell[1].loadTexture("cell" + info[0]);
                        game1.cell[2].loadTexture("cell" + info[1]);
                        game1.cell[3].loadTexture("cell" + info[2]);
                        game1.cell[4].loadTexture("cell" + info[3]);
                        game1.cell[5].loadTexture("cell" + info[4]);
                        game1.cell[6].loadTexture("cell" + info[5]);

                        if (
                            info[3] == 10 ||
                            info[4] == 10 ||
                            info[5] == 10 ||
                            info[3] == 0 ||
                            info[4] == 0 ||
                            info[5] == 0
                        ) {
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
                }, time);
            }
            if (number == 2) {
                timerSpin[number] = setTimeout(function() {
                    if (timeSpin) {
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

                        game1.cell[1].loadTexture("cell" + info[0]);
                        game1.cell[2].loadTexture("cell" + info[1]);
                        game1.cell[3].loadTexture("cell" + info[2]);
                        game1.cell[4].loadTexture("cell" + info[3]);
                        game1.cell[5].loadTexture("cell" + info[4]);
                        game1.cell[6].loadTexture("cell" + info[5]);
                        game1.cell[7].loadTexture("cell" + info[6]);
                        game1.cell[8].loadTexture("cell" + info[7]);
                        game1.cell[9].loadTexture("cell" + info[8]);
                        if (
                            info[6] == 10 ||
                            info[7] == 10 ||
                            info[8] == 10 ||
                            info[6] == 0 ||
                            info[7] == 0 ||
                            info[8] == 0
                        ) {
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
                        console.log(finishSpinSound3);
                        finishSpinSound3.play();
                        endspin(number);
                        // }
                    }
                }, time);
            }
            if (number == 3) {
                timerSpin[number] = setTimeout(function() {
                    if (timeSpin) {
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

                        game1.cell[1].loadTexture("cell" + info[0]);
                        game1.cell[2].loadTexture("cell" + info[1]);
                        game1.cell[3].loadTexture("cell" + info[2]);
                        game1.cell[4].loadTexture("cell" + info[3]);
                        game1.cell[5].loadTexture("cell" + info[4]);
                        game1.cell[6].loadTexture("cell" + info[5]);
                        game1.cell[7].loadTexture("cell" + info[6]);
                        game1.cell[8].loadTexture("cell" + info[7]);
                        game1.cell[9].loadTexture("cell" + info[8]);
                        game1.cell[10].loadTexture("cell" + info[9]);
                        game1.cell[11].loadTexture("cell" + info[10]);
                        game1.cell[12].loadTexture("cell" + info[11]);
                        if (
                            info[9] == 10 ||
                            info[10] == 10 ||
                            info[11] == 10 ||
                            info[9] == 0 ||
                            info[10] == 0 ||
                            info[11] == 0
                        ) {
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
                }, time);
            }
            if (number == 4) {
                timerSpin[number] = setTimeout(function() {
                    if (timeSpin) {
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

                        game1.cell[1].loadTexture("cell" + info[0]);
                        game1.cell[2].loadTexture("cell" + info[1]);
                        game1.cell[3].loadTexture("cell" + info[2]);
                        game1.cell[4].loadTexture("cell" + info[3]);
                        game1.cell[5].loadTexture("cell" + info[4]);
                        game1.cell[6].loadTexture("cell" + info[5]);
                        game1.cell[7].loadTexture("cell" + info[6]);
                        game1.cell[8].loadTexture("cell" + info[7]);
                        game1.cell[9].loadTexture("cell" + info[8]);
                        game1.cell[10].loadTexture("cell" + info[9]);
                        game1.cell[11].loadTexture("cell" + info[10]);
                        game1.cell[12].loadTexture("cell" + info[11]);
                        game1.cell[13].loadTexture("cell" + info[12]);
                        game1.cell[14].loadTexture("cell" + info[13]);
                        game1.cell[15].loadTexture("cell" + info[14]);

                        if (
                            info[12] == 10 ||
                            info[13] == 10 ||
                            info[14] == 10
                        ) {
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
                }, time);
            }
        }

        globalMiddleSpin = middlespin;

        function endspin(number) {
            if (!isEnd[number + ""]) {
                if (number == 4) {
                    timeSpin = false;
                }
                game1.cell[1 + number * 3].position.y = 127 + 30;
                game1.cell[2 + number * 3].position.y = 276 + 30;
                game1.cell[3 + number * 3].position.y = 425 + 30;

                game.add
                    .tween(game1.cell[1 + number * 3])
                    .to(
                        { y: game1.cell[1 + number * 3].position.y - 30 },
                        60,
                        Phaser.Easing.LINEAR,
                        true
                    )
                    .onComplete.add(function() {});
                game.add
                    .tween(game1.cell[2 + number * 3])
                    .to(
                        { y: game1.cell[2 + number * 3].position.y - 30 },
                        60,
                        Phaser.Easing.LINEAR,
                        true
                    )
                    .onComplete.add(function() {});
                game.add
                    .tween(game1.cell[3 + number * 3])
                    .to(
                        { y: game1.cell[3 + number * 3].position.y - 30 },
                        60,
                        Phaser.Easing.LINEAR,
                        true
                    )
                    .onComplete.add(function() {
                        if (number == 4) {
                            checkWin();
                            for (var i = 1; i <= 15; ++i) {
                                game1.cell[i].visible = true;
                                game1.cell[i].loadTexture("cell" + info[i - 1]);
                            }
                            game1.bars[0].visible = false;
                            game1.bars[1].visible = false;
                            game1.bars[2].visible = false;
                            game1.bars[3].visible = false;
                            game1.bars[4].visible = false;
                            spinSound.stop();
                            if (!allowSpin) forcedStop.play();
                            allowSpin = true;
                            isGetResponse = false;
                            doItOnce = false;
                            isSpinStart = false;
                        }
                    });

                isEnd[number + ""] = true;
            }
        }

        var wlWinValuesArray = [];
        var wcvWinValuesArray = [];
        var briSound = false;

        function addCreditFlick() {
            flickBtn = true;
            if (addcreditFlickStatus) {
                autoPlay.loadTexture("addCredit");
                setTimeout(function() {
                    if (addcreditFlickStatus) {
                        autoPlay.loadTexture("addCredit_p");
                        setTimeout(function() {
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
                game1.copyCell[i].loadTexture("cell" + info[i - 1]);
            }
            for (key in wlValues) {
                winWithoutCoin = winWithoutCoin + wlValues[key].winValue;
                wlWinValuesArray.push(wlValues[key].lineNumber + 1);
            }
            for (key in winCellInfo) {
                wcvWinValuesArray.push(+key);

                if (winCellInfo[key] === 0) {
                    briSound = true;
                }
            }
            if (dataSpinRequest.stateData.isWinOnBonus) {
                console.log("allo");
                topLabel.key !== "top_label_1" && animTopLabel("top_label_1");
                hideButtons();
                briWinSound.play();
                winBonusValue = winOldTrigerFreeSpin - winWithoutCoin;
                stopWinAnim = false;
                wcvWinValuesArray = [];
                bottomText.setText(
                    bonusPay + linePay + triggerPay + " Credits Won"
                );
                bottomText.y = 0;
                bottomText.fontSize = 35;
                for (key in info) {
                    if (info[key] === 10 || info[key] === 0) {
                        wcvWinValuesArray.push(+key);
                    }
                }
                wcvWinValuesArrayOld = wcvWinValuesArray;
                wlWinValuesArrayOld = wlWinValuesArray;
                winCellInfoOld = winCellInfo;
                winWithoutCoinOld = winWithoutCoin;
                showWinFreeSpin(wcvWinValuesArray);
            } else if (wlWinValuesArray.length > 0) {
                stopWinAnim = false;
                firstAroundAnim = true;
                showWin(wlWinValuesArray);
                bottomText.setText(allWin + " Credits Won");
                bottomText.y = 0;
                bottomText.fontSize = 35;
            } else {
                spinStatus = false;
                bottomText.visible = false;
                gameStatusTextFlick();
                changeNumberSpin();
                if (autostart == false) {
                    showButtons();
                }
                if (BALANCE + allWin < betline * lines) {
                    autostart = false;
                    $("#spin").removeClass("auto");
                    showButtons();
                    hideButtons([[startButton, "startButton"]]);
                    hideButtons([[autoPlay, "autoPlay"]]);
                    if (BALANCE + allWin < 1) {
                        hideButtons([[maxBetSpin, "maxBetSpin"]]);
                    }
                    hideMobileBtn();
                    addcreditFlickStatus = false;
                    autoPlay.loadTexture("autoPlay");
                    console.log(BALANCE + allWin);
                    if (demo !== "demo") {
                        checkBalance();
                        showButtons([[autoPlay, "autoPlay"]]);
                        addcreditFlickStatus = true;
                        bottomText.visible = true;
                        bottomText.setText(
                            "To play please add credit to game."
                        );
                        bottomText.y = 7;
                        bottomText.fontSize = 25;

                        addcreditFlickStatus = true;
                        autoPlay.loadTexture("addCredit");
                        addCreditFlick();
                    }
                } else {
                    if (autostart == false) {
                        showButtons([[startButton, "startButton"]]);
                        if (!spinStatus) {
                            showButtons([[autoPlay, "autoPlay"]]);
                            showButtons([[maxBetSpin, "maxBetSpin"]]);
                        }
                        showMobileBtn();
                    }
                }
                if (autostart == true) {
                    setTimeout(function() {
                        if ((autostart === true) & (spinStatus === false)) {
                            startFunc();
                        }
                    }, 1000);
                }
            }
        }

        function gameStatusTextFlick() {
            gameStatusText.visible = true;
            gameStatusText.setText("Game Over");
            setTimeout(function() {
                if (spinStatus) {
                    return;
                }
                gameStatusText.visible = false;
                setTimeout(function() {
                    if (spinStatus) {
                        return;
                    }
                    gameStatusText.visible = true;
                    gameStatusText.setText("Play 400 Credits");
                    setTimeout(function() {
                        if (spinStatus) {
                            return;
                        }
                        gameStatusText.visible = false;
                        setTimeout(function() {
                            if (spinStatus) {
                                return;
                            }
                            gameStatusTextFlick();
                        }, 800);
                    }, 800);
                }, 800);
            }, 800);
        }

        function showWinFreeSpin(wcvWinValuesArray) {
            console.log(wcvWinValuesArray);
            wcvWinValuesArray.forEach(function(cell, i) {
                squareArrFreespin[cell + 1].tint = 0xffffff;
                squareArrFreespin[cell + 1].visible = true;

                if (!afterFreespinStatus) {
                    if (info[cell] === 10) {
                        coinAnimArr[cell + 1].visible = true;
                        coinAnimArr[cell + 1].animations
                            .add("coin_anim", [], 25, false)
                            .play()
                            .onComplete.add(function() {
                                coinAnimArr[cell + 1].visible = false;
                            });
                    }
                    if (info[cell] === 0) {
                        briAnimArr[cell + 1].visible = true;
                        briAnimArr[cell + 1].animations
                            .add(
                                "coin_anim",
                                [
                                    0,
                                    1,
                                    2,
                                    3,
                                    4,
                                    5,
                                    6,
                                    7,
                                    8,
                                    9,
                                    10,
                                    11,
                                    0,
                                    1,
                                    2,
                                    3,
                                    4,
                                    5,
                                    6,
                                    7,
                                    8,
                                    9,
                                    10,
                                    11
                                ],
                                15,
                                false
                            )
                            .play()
                            .onComplete.add(function() {
                                briAnimArr[cell + 1].visible = false;
                            });
                    }
                }
            });
            if (afterFreespinStatus) {
                winText.visible = true;
            }
            if (!afterFreespinStatus) {
                bottomText.visible = true;
                bottomText.setText("BONUS!");
                bottomText.y = 0;
                bottomText.fontSize = 35;
                setTimeout(function() {
                    flickWin(wcvWinValuesArray);
                }, 1000);
            } else {
                flickWin(wcvWinValuesArray);
            }
            if (!afterFreespinStatus) {
                setTimeout(function() {
                    freeSpinBgSong.play();

                    stopWinAnim = true;
                    for (var i = 1; i <= 15; ++i) {
                        game1.copyCell[i].visible = false;
                        squareArrFreespin[i].visible = false;
                        squareArrFreespin[i].tint = 0xffffff;
                    }
                    freespinStartBG.visible = true;
                    freesponStartBGText.visible = true;
                    freespinStartBG.alpha = 0;
                    big_red_border.visible = true;
                    big_red_border.animations
                        .add("anim", [], 50, false)
                        .play()
                        .onComplete.add(function() {
                            freeSpinsBegin = true;
                            stopWinAnim = true;
                            autostart = false;
                            spinStatus = false;
                            $("#spin").removeClass("auto");
                            createdStarsStatus = true;
                            createdStarsMiniStatus = true;
                            game.state.start("game2");
                        });
                    game.add
                        .tween(freespinStartBG)
                        .to({ alpha: 1 }, 1000, "Linear", true)
                        .onComplete.add(function() {
                            createdStarsStatus = false;
                            createdStarsMiniStatus = false;
                        });
                }, 4000);
            }
        }

        let reconnectCount = 0;

        function requestSpin(gamename, sessionUuid, betline, lines) {
            stopWinAnim = true;
            function sendMsg() {
                if (demo !== "demo") {
                    getBalanceWait = false;
                    getBalance();
                }
                imageAnim && clearInterval(imageAnim);
                winText.visible = false;
                $.ajax({
                    type: "get",
                    url:
                        getNeedUrlPath() +
                        `/api-v2/action?game_id=${gameId}&user_id=${userId}&mode=${demo}&action=spin&session_uuid=${sessionUuid}&token=${token}&linesInGame=${lines}&lineBet=${betline}&platform_id=${platformId}`,
                    dataType: "html",
                    success: function(data) {
                        if (IsJsonString(data)) {
                            dataSpinRequest = JSON.parse(data);

                            if (dataSpinRequest.status !== "false") {
                                isGetResponse = true;
                                parseSpinAnswer(dataSpinRequest);
                            } else {
                                errorStatus = true;
                                switch (dataSpinRequest.message) {
                                    case "ActiveUserSessionException":
                                        session_bg.visible = true;
                                        break;
                                    case "FirstMoveFundsException":
                                        dataSpinRequest.refId
                                            ? createRefID(dataSpinRequest.refId)
                                            : createRefID("Funds exception");
                                        error_bg.visible = true;
                                        break;
                                    case "BetPlacingAbortException":
                                        establishing_bg.visible = true;
                                        setTimeout(
                                            "BetPlacingAbortExceptionFunc(gamename, sessionName, betline, lines, dataSpinRequest.betPlacingAbortExceptionID)",
                                            3000
                                        );
                                        break;
                                    case "moveFundsException":
                                        establishing_bg.visible = true;
                                        setTimeout(
                                            "moveFundsExceptionFunc(gamename, sessionName, betline, lines, dataSpinRequest.moveFundsExceptionID)",
                                            3000
                                        );
                                        break;
                                    case "low balance":
                                        dataSpinRequest.refId
                                            ? createRefID(dataSpinRequest.refId)
                                            : createRefID("low balance");
                                        error_bg.visible = true;
                                        break;
                                    case "UnauthenticatedException":
                                        dataSpinRequest.refId
                                            ? createRefID(dataSpinRequest.refId)
                                            : createRefID(
                                                  "Unauthenticated exception"
                                              );
                                        error_bg.visible = true;
                                        break;
                                }
                            }
                        } else {
                            console.log("json format error");
                            createRefID("api-v2 json format error");
                            error_bg.visible = true;
                            errorStatus = true;
                            isGetResponse = false;
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        var errorText = "//ошибка 30";
                        console.log("переключение № " + reconnectCount);
                        console.log(errorText);

                        const responseText = xhr.responseText
                            ? JSON.parse(xhr.responseText)
                            : "";
                        const refId =
                            responseText && responseText.refId
                                ? responseText.refId
                                : "";

                        if (refId) {
                            createRefID(refId);
                            error_bg.visible = true;
                            errorStatus = true;
                        } else {
                            if (reconnectCount < 10) {
                                reconnectCount++;
                                reconnectSpin(
                                    gamename,
                                    sessionUuid,
                                    betline,
                                    lines
                                );
                            } else if (reconnectCount >= 10) {
                                createRefID("internet problem");
                                error_bg.visible = true;
                                errorStatus = true;
                                reconnectCount = 0;
                            }
                        }
                    }
                });
            }

            sendMsg(gamename, sessionName, betline, lines);
        }

        function moveFundsExceptionFunc(
            gamename,
            sessionName,
            betline,
            lines,
            moveFundsExceptionID
        ) {
            $.ajax({
                type: "get",
                url:
                    getNeedUrlPath() +
                    "/moveFundsException?moveFundsExceptionID=" +
                    moveFundsExceptionID +
                    "&platform_id=" +
                    platformId,
                dataType: "html",
                success: function(data) {
                    console.log(data);
                    if (IsJsonString(data)) {
                        dataSpinRequest = JSON.parse(data);
                        // проверка статуса ответа
                        if (dataSpinRequest.status === "false") {
                            switch (dataSpinRequest.message) {
                                case "FirstMoveFundsException":
                                    dataSpinRequest.refId
                                        ? createRefID(dataSpinRequest.refId)
                                        : createRefID("Funds exception");
                                    error_bg.visible = true;
                                    break;
                                case "BetPlacingAbortException":
                                    setTimeout(
                                        "BetPlacingAbortExceptionFunc(gamename, sessionName, betline, lines, dataSpinRequest.betPlacingAbortExceptionID)",
                                        3000
                                    );
                                    break;
                                case "moveFundsException":
                                    setTimeout(
                                        "moveFundsExceptionFunc(gamename, sessionName, betline, lines, dataSpinRequest.moveFundsExceptionID)",
                                        3000
                                    );
                                    break;
                                case "LowBalanceException":
                                    dataSpinRequest.refId
                                        ? createRefID(dataSpinRequest.refId)
                                        : createRefID("LowBalance exception");
                                    error_bg.visible = true;
                                    break;
                                case "UnauthenticatedException":
                                    dataSpinRequest.refId
                                        ? createRefID(dataSpinRequest.refId)
                                        : createRefID(
                                              "Unauthenticated exception"
                                          );
                                    error_bg.visible = true;
                                    break;
                            }
                        } else {
                            errorStatus = false;
                            establishing_bg.visible = false;
                            requestSpin(gamename, sessionUuid, betline, lines);
                        }
                    } else {
                        console.log("json format error");
                        createRefID("moveFundsException json format error");
                        error_bg.visible = true;
                        errorStatus = true;
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    var errorText = "//ошибка 30";
                    console.log(errorText);
                    const responseText = xhr.responseText
                        ? JSON.parse(xhr.responseText)
                        : "";
                    const refId =
                        responseText && responseText.refId
                            ? responseText.refId
                            : "";
                    refId ? createRefID(refId) : createRefID("funds error");
                    error_bg.visible = true;
                    errorStatus = true;
                }
            });
        }

        function BetPlacingAbortExceptionFunc(
            gamename,
            sessionName,
            betline,
            lines,
            moveFundsExceptionID
        ) {
            $.ajax({
                type: "get",
                url:
                    getNeedUrlPath() +
                    "/betPlacingAbort?betPlacingAbortExceptionID=" +
                    moveFundsExceptionID +
                    "&platform_id=" +
                    platformId,
                dataType: "html",
                success: function(data) {
                    console.log(data);
                    if (IsJsonString(data)) {
                        dataSpinRequest = JSON.parse(data);
                        // проверка статуса ответа
                        if (dataSpinRequest.status === "false") {
                            switch (dataSpinRequest.message) {
                                case "FirstMoveFundsException":
                                    dataSpinRequest.refId
                                        ? createRefID(dataSpinRequest.refId)
                                        : createRefID("Funds exception");
                                    error_bg.visible = true;
                                    break;
                                case "BetPlacingAbortException":
                                    setTimeout(
                                        "BetPlacingAbortExceptionFunc(gamename, sessionName, betline, lines, dataSpinRequest.betPlacingAbortExceptionID)",
                                        3000
                                    );
                                    break;
                                case "moveFundsException":
                                    setTimeout(
                                        "moveFundsExceptionFunc(gamename, sessionName, betline, lines, dataSpinRequest.moveFundsExceptionID)",
                                        3000
                                    );
                                    break;
                                case "LowBalanceException":
                                    dataSpinRequest.refId
                                        ? createRefID(dataSpinRequest.refId)
                                        : createRefID("LowBalance exception");
                                    error_bg.visible = true;
                                    break;
                                case "UnauthenticatedException":
                                    dataSpinRequest.refId
                                        ? createRefID(dataSpinRequest.refId)
                                        : createRefID(
                                              "Unauthenticated exception"
                                          );
                                    error_bg.visible = true;
                                    break;
                            }
                        } else {
                            errorStatus = false;
                            establishing_bg.visible = false;
                            requestSpin(gamename, sessionUuid, betline, lines);
                        }
                    } else {
                        console.log("json format error");
                        createRefID("betPlacingAbort json format error");
                        error_bg.visible = true;
                        errorStatus = true;
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    var errorText = "//ошибка 30";
                    console.log(errorText);
                    const responseText = xhr.responseText
                        ? JSON.parse(xhr.responseText)
                        : "";
                    const refId =
                        responseText && responseText.refId
                            ? responseText.refId
                            : "";
                    refId
                        ? createRefID(refId)
                        : createRefID("betPlacingAbort error");
                    error_bg.visible = true;
                    errorStatus = true;
                }
            });
        }

        function reconnectSpin(gamename, sessionName, betline, lines) {
            $.ajax({
                type: "get",
                url: getNeedUrlPath() + "/reconnect",
                dataType: "html",
                success: function(data) {
                    console.log("reconect : true");
                    requestSpin(gamename, sessionUuid, betline, lines);
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    var errorText = "//ошибка переподкючения";
                    console.log(errorText);
                    setTimeout(() => {
                        requestSpin(gamename, sessionUuid, betline, lines);
                    }, 3000);
                }
            });
        }

        function flickWin(wcvWinValuesArray) {
            function lightBorder() {
                if (stopWinAnim == true) {
                    wcvWinValuesArray.forEach(function(cell, i) {
                        squareArrFreespin[cell + 1].tint = 0xffffff;
                    });
                    return;
                }
                wcvWinValuesArray.forEach(function(cell, i) {
                    squareArrFreespin[cell + 1].tint = 0xffffff;
                });
                if (afterFreespinStatus) {
                    if (triggerShow) {
                        if (triggerShow % 2 === 0) {
                            isTriggerPay = true;
                        } else {
                            isTriggerPay = false;
                        }
                    }

                    if (isTriggerPay) {
                        winText.setText(
                            "Trigger Pay \n" + triggerPay.toFixed()
                        );
                    } else {
                        winText.setText("Bonus Pay \n" + bonusPay.toFixed());
                    }

                    winText.visible = true;

                    triggerShow++;
                } else {
                    if (triggerShow) {
                        if (triggerShow % 2 === 0) {
                            isTriggerPay = true;
                        } else {
                            isTriggerPay = false;
                        }
                    }

                    winText.setText("");

                    winText.visible = true;

                    triggerShow++;
                }
            }

            function darkBorder() {
                if (stopWinAnim == true) {
                    return;
                }
                wcvWinValuesArray.forEach(function(cell, i) {
                    squareArrFreespin[cell + 1].tint = 0x999999;
                });
                if (afterFreespinStatus) {
                    winText.visible = false;
                }
            }

            function lastIndication() {
                if (stopWinAnim == true) {
                    return;
                }
                if (afterFreespinStatus) {
                    if (winWithoutCoin > 0) {
                        wcvWinValuesArray.forEach(function(cell, i) {
                            squareArrFreespin[cell + 1].visible = false;
                        });

                        setTimeout(() => showWin(wlWinValuesArrayOld), 140);
                    } else {
                        flickWin(wcvWinValuesArray);
                    }
                } else {
                    flickWin(wcvWinValuesArray);
                }
            }

            let isLightBorder = true;
            let index = 0;

            async function startIndication() {
                while (winWithoutCoin > 0 ? index < 8 : true) {
                    if (stopWinAnim == true) {
                        return;
                    }
                    await delay(isLightBorder ? 275 : 550);

                    if (index === 7 && winWithoutCoin > 0) {
                        lastIndication();
                    } else {
                        isLightBorder ? lightBorder() : darkBorder();
                    }

                    index++;
                    isLightBorder = !isLightBorder;
                }
            }
            startIndication();
        }

        var sizeLine = 0;
        var otherSound = false;

        function showWin(wlWinValuesArray, oneLineAnimation) {
            otherSound = false;
            multiStatus = false;
            if (stopWinAnim == true) {
                return;
            }
            if (!oneLineAnimation) winText.visible = true;
            if (afterFreespinStatus && !oneLineAnimation) {
                winText.visible = true;
            }

            if (wlValues[lineflash]) {
                winText.setText("Line Pay \n" + wlValues[lineflash].winValue);
            } else {
                winText.setText("Line Pay \n" + wlValuesFS.winning);
            }
            if (info[squareArr[wlWinValuesArray[lineflash] - 1][0] - 1] !== 0) {
                trigerLine =
                    info[squareArr[wlWinValuesArray[lineflash] - 1][0] - 1];
            } else if (
                info[squareArr[wlWinValuesArray[lineflash] - 1][1] - 1] !== 0
            ) {
                trigerLine =
                    info[squareArr[wlWinValuesArray[lineflash] - 1][1] - 1];
            } else if (
                info[squareArr[wlWinValuesArray[lineflash] - 1][2] - 1] !== 0
            ) {
                trigerLine =
                    info[squareArr[wlWinValuesArray[lineflash] - 1][2] - 1];
            } else if (
                info[squareArr[wlWinValuesArray[lineflash] - 1][3] - 1] !== 0
            ) {
                trigerLine =
                    info[squareArr[wlWinValuesArray[lineflash] - 1][3] - 1];
            } else {
                trigerLine =
                    info[squareArr[wlWinValuesArray[lineflash] - 1][4] - 1];
            }
            if (
                info[squareArr[wlWinValuesArray[lineflash] - 1][0] - 1] === 0 ||
                info[squareArr[wlWinValuesArray[lineflash] - 1][1] - 1] === 0
            ) {
                multiStatus = true;
            }

            if (firstAroundAnim) {
                if (
                    (info[squareArr[wlWinValuesArray[lineflash] - 1][0] - 1] ===
                        9) &
                    (info[squareArr[wlWinValuesArray[lineflash] - 1][2] - 1] ===
                        0 ||
                        info[
                            squareArr[wlWinValuesArray[lineflash] - 1][2] - 1
                        ] === 9)
                ) {
                    if (firstAroundAnim) {
                        if (!afterFreespinStatus && !oneLineAnimation) {
                            katerSong.play();
                        }
                        otherSound = true;
                    }
                }
                if (
                    (info[squareArr[wlWinValuesArray[lineflash] - 1][0] - 1] ===
                        1) &
                    (info[squareArr[wlWinValuesArray[lineflash] - 1][2] - 1] ===
                        0 ||
                        info[
                            squareArr[wlWinValuesArray[lineflash] - 1][2] - 1
                        ] === 1)
                ) {
                    if (firstAroundAnim) {
                        if (!afterFreespinStatus && !oneLineAnimation) {
                            planeSong.play();
                        }
                        otherSound = true;
                    }
                }

                if (
                    (info[squareArr[wlWinValuesArray[lineflash] - 1][0] - 1] ===
                        4) &
                    (info[squareArr[wlWinValuesArray[lineflash] - 1][2] - 1] ===
                        0 ||
                        info[
                            squareArr[wlWinValuesArray[lineflash] - 1][2] - 1
                        ] === 4)
                ) {
                    if (firstAroundAnim) {
                        if (!afterFreespinStatus && !oneLineAnimation) {
                            carSong.play();
                        }
                        otherSound = true;
                    }
                }
            }

            if (
                info[squareArr[wlWinValuesArray[lineflash] - 1][2] - 1] === 0 ||
                info[squareArr[wlWinValuesArray[lineflash] - 1][2] - 1] ===
                    trigerLine
            ) {
                if (
                    info[squareArr[wlWinValuesArray[lineflash] - 1][2] - 1] ===
                    0
                ) {
                    multiStatus = true;
                }
                if (
                    info[squareArr[wlWinValuesArray[lineflash] - 1][3] - 1] ===
                        0 ||
                    info[squareArr[wlWinValuesArray[lineflash] - 1][3] - 1] ===
                        trigerLine
                ) {
                    if (
                        info[
                            squareArr[wlWinValuesArray[lineflash] - 1][3] - 1
                        ] === 0
                    ) {
                        multiStatus = true;
                    }
                    if (
                        info[
                            squareArr[wlWinValuesArray[lineflash] - 1][4] - 1
                        ] === 0 ||
                        info[
                            squareArr[wlWinValuesArray[lineflash] - 1][4] - 1
                        ] === trigerLine
                    ) {
                        if (
                            info[
                                squareArr[wlWinValuesArray[lineflash] - 1][4] -
                                    1
                            ] === 0
                        ) {
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
                        setTimeout(function() {
                            updateBalance();
                        }, 2000);
                    }
                    firstAnim = false;
                }
            }

            if (multiStatus) {
                if (!otherSound) {
                    if (!afterFreespinStatus) {
                        firstAroundAnim && briLineWinSound.play();
                    }
                }
                for (var i = 1; i <= sizeLine; ++i) {
                    if (
                        info[
                            squareArr[wlWinValuesArray[lineflash] - 1][i - 1] -
                                1
                        ] === 0
                    ) {
                        briAnimArr[
                            squareArr[wlWinValuesArray[lineflash] - 1][i - 1]
                        ].visible = true;
                        briAnimArr[
                            squareArr[wlWinValuesArray[lineflash] - 1][i - 1]
                        ].animations
                            .add(
                                "scatters_anim",
                                [
                                    0,
                                    1,
                                    2,
                                    3,
                                    4,
                                    5,
                                    6,
                                    7,
                                    8,
                                    9,
                                    10,
                                    11,
                                    12,
                                    0,
                                    1,
                                    2,
                                    3,
                                    4,
                                    5,
                                    6,
                                    7,
                                    8,
                                    9,
                                    10,
                                    11,
                                    12
                                ],
                                12,
                                false
                            )
                            .play()
                            .onComplete.add(function() {
                                if (wlWinValuesArray.length === 1) {
                                    setTimeout(() => {
                                        showWin(wlWinValuesArray, true);
                                    }, 3000);
                                } else {
                                    for (var i = 1; i <= 15; ++i) {
                                        briAnimArr[i].visible = false;
                                    }
                                }
                            });
                    }
                }
            }

            for (var i = 1; i <= sizeLine; ++i) {
                if (sizeLine >= 3) {
                    if (
                        info[
                            squareArr[wlWinValuesArray[lineflash] - 1][i - 1] -
                                1
                        ] === 4
                    ) {
                        carAnimArr[
                            squareArr[wlWinValuesArray[lineflash] - 1][i - 1]
                        ].visible = true;
                        carAnimArr[
                            squareArr[wlWinValuesArray[lineflash] - 1][i - 1]
                        ].animations
                            .add("scatters_anim", [4, 3, 2, 1, 0], 5, false)
                            .play()
                            .onComplete.add(function() {
                                if (wlWinValuesArray.length === 1) {
                                    setTimeout(() => {
                                        showWin(wlWinValuesArray, true);
                                    }, 3000);
                                } else {
                                    for (var i = 1; i <= 15; ++i) {
                                        carAnimArr[i].visible = false;
                                    }
                                }
                            });
                    }
                }

                if (sizeLine >= 2) {
                    if (
                        info[
                            squareArr[wlWinValuesArray[lineflash] - 1][i - 1] -
                                1
                        ] === 1
                    ) {
                        if (sizeLine === 2 && !oneLineAnimation) {
                            firstAroundAnim && planeSong.play();
                        }

                        planeAnimArr[
                            squareArr[wlWinValuesArray[lineflash] - 1][i - 1]
                        ].visible = true;

                        planeAnimArr[
                            squareArr[wlWinValuesArray[lineflash] - 1][i - 1]
                        ].animations
                            .add(
                                "scatters_anim",
                                [0, 1, 2, 3, 4, 5, 6],
                                5,
                                false
                            )
                            .play()
                            .onComplete.add(function() {
                                if (wlWinValuesArray.length === 1) {
                                    setTimeout(() => {
                                        showWin(wlWinValuesArray, true);
                                    }, 3000);
                                } else {
                                    for (var i = 1; i <= 15; ++i) {
                                        planeAnimArr[i].visible = false;
                                    }
                                }
                            });
                    }
                    if (
                        info[
                            squareArr[wlWinValuesArray[lineflash] - 1][i - 1] -
                                1
                        ] === 9
                    ) {
                        if (sizeLine === 2 && !oneLineAnimation) {
                            firstAroundAnim && katerSong.play();
                        }

                        katerAnimArr[
                            squareArr[wlWinValuesArray[lineflash] - 1][i - 1]
                        ].visible = true;

                        katerAnimArr[
                            squareArr[wlWinValuesArray[lineflash] - 1][i - 1]
                        ].animations
                            .add("scatters_anim", [3, 2, 1, 0], 4, false)
                            .play()
                            .onComplete.add(function() {
                                if (wlWinValuesArray.length === 1) {
                                    setTimeout(() => {
                                        showWin(wlWinValuesArray, true);
                                    }, 3000);
                                } else {
                                    for (var i = 1; i <= 15; ++i) {
                                        katerAnimArr[i].visible = false;
                                    }
                                }
                            });
                    }
                }
            }

            if (stopWinAnim == true) {
                return;
            }

            showLine(wlWinValuesArray[lineflash]);
            for (var i = 1; i <= sizeLine; ++i) {
                squareArrImg[wlWinValuesArray[lineflash] - 1][
                    i - 1
                ].visible = true;

                game1.copyCell[
                    squareArr[wlWinValuesArray[lineflash] - 1][i - 1]
                ].visible = true;
            }

            if (wlWinValuesArray.length === 1 && !afterFreespinStatus) {
                !oneLineAnimation &&
                    oneLineIndication(
                        sizeLine,
                        wlWinValuesArray[lineflash],
                        wlWinValuesArray
                    );
            } else {
                multipleLinesOfIndication(
                    sizeLine,
                    wlWinValuesArray[lineflash],
                    wlWinValuesArray
                );
            }
        }

        function changeBorderColor(lineNumber, tint) {
            game1.lineArr[lineNumber].tint = tint;
            for (var i = 1; i <= sizeLine; ++i) {
                squareArrImg[lineNumber - 1][i - 1].tint = tint;
            }
        }

        let imageAnim;

        function oneLineIndication(sizeLine, lineNumber) {
            let isLightBorder = true;

            if (stopWinAnim == true) {
                return;
            }

            imageAnim = setInterval(
                () => {
                    winText.visible = isLightBorder;

                    changeBorderColor(
                        lineNumber,
                        isLightBorder ? 0x999999 : 0xffffff
                    );

                    isLightBorder = !isLightBorder;
                },
                isLightBorder ? 550 : 275
            );
        }

        function multipleLinesOfIndication(
            sizeLine,
            lineNumber,
            wlWinValuesArray
        ) {
            let isLightBorder = true;
            let index = 0;

            (async () => {
                while (index < 8) {
                    if (stopWinAnim == true) {
                        return;
                    }

                    winText.visible = isLightBorder;

                    await delay(isLightBorder ? 600 : 300);

                    if (index === 7) {
                        changeBorderColor(
                            lineNumber,
                            isLightBorder ? 0x999999 : 0xffffff
                        );
                        lastIndication(wlWinValuesArray, lineNumber);
                    } else {
                        changeBorderColor(
                            lineNumber,
                            isLightBorder ? 0x999999 : 0xffffff
                        );
                    }

                    isLightBorder = !isLightBorder;

                    index++;
                }
            })();
        }

        function lastIndication(wlWinValuesArray, lineNumber) {
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
                winText.visible = true;
                if (afterFreespinStatus) {
                    winText.visible = true;
                }
                if (afterFreespinStatus) {
                    hideLines();
                    hideSquare();
                    if (lineflash === 0) {
                        showWinFreeSpin(wcvWinValuesArrayOld);
                    } else {
                        showWin(wlWinValuesArrayOld);
                    }
                } else {
                    showWin(wlWinValuesArray);
                }
            } else {
                hideLines();
                hideSquare();
                // setTimeout(() => {
                for (var i = 1; i <= sizeLine; ++i) {
                    game1.copyCell[
                        squareArr[lineNumber - 1][i - 1]
                    ].visible = false;
                }
                // }, 100);

                setTimeout(() => {
                    if (afterFreespinStatus) {
                        if (lineflash === 0) {
                            showWinFreeSpin(wcvWinValuesArrayOld);
                        } else {
                            showWin(wlWinValuesArrayOld);
                        }
                    } else {
                        showWin(wlWinValuesArray);
                    }
                }, 0);
            }
        }

        function upLines() {
            for (var i = 1; i <= 15; ++i) {
                squareArrFreespin[i].visible = false;
                squareArrFreespin[i].tint = 0xffffff;
                briAnimArr[i].visible = false;
                coinAnimArr[i].visible = false;
                planeAnimArr[i].visible = false;
                katerAnimArr[i].visible = false;
                carAnimArr[i].visible = false;
            }

            stopWinAnim = true;
            bottomText.visible = false;
            for (var i = 1; i <= 15; ++i) {
                game1.copyCell[i].visible = false;
            }
            hideLines();
            hideSquare();
            lines = lines + 1;
            if (lines > 20) {
                lines = 1;
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
            linesText.setText(lines);
            totalBet.setText(bet);

            if (BALANCE + allWinOld < betline * lines) {
                bottomText.setText("To play please add credit to game.");
                bottomText.y = 7;
                bottomText.fontSize = 25;
                bottomText.visible = true;
            }
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
                betline = 1;
            }
            for (var i = 1; i <= 20; ++i) {
                game1.textArr[i].setText(betline);
            }
            changeBet[betline].play();
            bet = lines * betline;
            checkScore();
            lineBetText.setText(betline);
            totalBet.setText(bet);

            if (BALANCE + allWinOld < betline * lines) {
                bottomText.setText("To play please add credit to game.");
                bottomText.y = 7;
                bottomText.fontSize = 25;
                bottomText.visible = true;
            }
        }

        function addScore() {
            credit = game.add.text(214, 664, BALANCE, {
                font: '47px "Digital-7 Mono"',
                fill: "#01e033"
            });
            credit.anchor.setTo(1, 0.5);
            linesText = game.add.text(536, 664, lines, {
                font: '47px "Digital-7 Mono"',
                fill: "#01e033"
            });
            linesText.anchor.setTo(1, 0.5);
            lineBetText = game.add.text(664, 664, betline, {
                font: '47px "Digital-7 Mono"',
                fill: "#01e033"
            });
            lineBetText.anchor.setTo(1, 0.5);
            totalBet = game.add.text(812, 664, bet, {
                font: '47px "Digital-7 Mono"',
                fill: "#01e033"
            });
            totalBet.anchor.setTo(1, 0.5);
            paid = game.add.text(990, 664, "0", {
                font: '47px "Digital-7 Mono"',
                fill: "#01e033"
            });
            paid.anchor.setTo(1, 0.5);
            winText = game.add.text(150, 608, "Trigger Pay \n40", {
                font: '22px "Arial"',
                fill: "#ffffff",
                fontWeight: 600,
                align: "center"
            });
            winText.lineSpacing = -10;
            winText.anchor.setTo(0.5, 0.5);
            winText.visible = false;
            gameStatusText = game.add.text(894, 598, "Play 400 Credits", {
                font: '22px "Arial"',
                fill: "#ffffff",
                fontWeight: 600
            });
            gameStatusText.anchor.setTo(0.5, 0.5);
            gameStatusText.visible = false;

            collect_text = game.add.text(510, 342, "HAND PAY 25585 CREDITS", {
                font: '35px "PF Agora Slab Pro"',
                fill: "#fffc15"
            });
            collect_text.anchor.setTo(0.5, 0.5);
            collect_text.visible = false;

            // bottomText = game.add.text(512, 610, "BONUS!", {
            bottomText = game.add.text(0, 0, "BONUS!", {
                font: '35px "Arial"',
                fill: "#fffd6f",
                stroke: "#000000",
                strokeThickness: 4,
                fontWeight: 600,
                boundsAlignH: "center"
            });
            bottomText.setTextBounds(0, 584, 1024, 100);
            // bottomText.anchor.setTo(1, 1);
            bottomText.visible = false;
        }

        function addGameModeText() {
            credit = game.add.text(214, 664, "FREE GAME MODE", {
                font: '47px "Digital-7 Mono"',
                fill: "#01e033"
            });
        }

        function flickcollect_text() {
            collect_text.visible = true;
            setTimeout(function() {
                collect_text.visible = false;
                setTimeout(function() {
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
            help_page.loadTexture("help_page_" + helpPageCurent);
        }

        function nextPaytable(value) {
            paytablePageCurent = paytablePageCurent + 1;
            if (paytablePageCurent > 5) {
                paytablePageCurent = 1;
            }
            paytable_page.loadTexture("paytable_page_" + paytablePageCurent);
        }

        showButMob = function showB() {
            showButtons();
        };
        hideButMob = function hideB() {
            hideButtons();
        };

        function stopUpdateBalance() {
            balanceUpdateStatus = false;
            if (BALANCE + allWin < betline * lines) {
                autostart = false;
                $("#spin").removeClass("auto");
                showButtons();
                hideButtons([[startButton, "startButton"]]);
                hideButtons([[autoPlay, "autoPlay"]]);
                if (BALANCE + allWin < 1) {
                    hideButtons([[maxBetSpin, "maxBetSpin"]]);
                }
                hideMobileBtn();
                autoPlay.loadTexture("autoPlay");
                if (demo !== "demo") {
                    checkBalance();
                    showButtons([[autoPlay, "autoPlay"]]);
                    autoPlay.loadTexture("addCredit");
                    addcreditFlickStatus = true;
                    addCreditFlick();
                }
            } else {
                if (autostart == false) {
                    showButtons([[startButton, "startButton"]]);
                    if (!spinStatus) {
                        showButtons([[autoPlay, "autoPlay"]]);
                        showButtons([[maxBetSpin, "maxBetSpin"]]);
                    }
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
            credit.setText(BALANCE + +allwinUpd);
        }

        stopUB = function stopUpdateBalance2() {
            balanceUpdateStatus = false;
            if (BALANCE + allWin < betline * lines) {
                autostart = false;
                $("#spin").removeClass("auto");
                showButtons();
                hideButtons([[startButton, "startButton"]]);
                hideButtons([[autoPlay, "autoPlay"]]);
                if (BALANCE + allWin < 1) {
                    hideButtons([[maxBetSpin, "maxBetSpin"]]);
                }
                hideMobileBtn();
                autoPlay.loadTexture("autoPlay");
                if (BALANCE + allWin < betline * lines && demo !== "demo") {
                    checkBalance();
                    showButtons([[autoPlay, "autoPlay"]]);
                    autoPlay.loadTexture("addCredit");
                    addcreditFlickStatus = true;
                    addCreditFlick();
                }
            } else {
                if (autostart == false) {
                    showButtons([[startButton, "startButton"]]);
                    if (!spinStatus) {
                        showButtons([[autoPlay, "autoPlay"]]);
                        showButtons([[maxBetSpin, "maxBetSpin"]]);
                    }
                    showMobileBtn();
                }
            }
            winSound.stop();
            updateFinishSound.play();
            gameStatusTextFlick();
            changeNumberSpin();
            allWinOld = allWinOld + +allwinUpd;
            paid.setText(+allwinUpd);
            credit.setText(BALANCE + +allwinUpd);
        };

        function updateBalance() {
            var x = 0;
            var interval;
            if (autostart == false) {
                showButtons();
            }
            if (BALANCE + allWin < betline * lines) {
                autostart = false;
                $("#spin").removeClass("auto");
                showButtons();
                hideButtons([[startButton, "startButton"]]);
                hideButtons([[autoPlay, "autoPlay"]]);
                if (BALANCE + allWin < 1) {
                    hideButtons([[maxBetSpin, "maxBetSpin"]]);
                }
                hideMobileBtn();
                autoPlay.loadTexture("autoPlay");

                showButtons([[autoPlay, "autoPlay"]]);
            } else {
                if (autostart == false) {
                    showButtons([[startButton, "startButton"]]);
                    if (!spinStatus) {
                        showButtons([[autoPlay, "autoPlay"]]);
                        showButtons([[maxBetSpin, "maxBetSpin"]]);
                    }
                    showMobileBtn();
                }
            }
            if (briSound) {
                let randomText = randomNumber(1, 2);
                switch (randomText) {
                    case 1:
                        winSound = game.add.audio("high");
                        break;
                    case 2:
                        winSound = game.add.audio("medium");
                        break;
                }
            } else if (afterFreespinStatus || allWin >= betline * lines * 3) {
                let randomText = randomNumber(1, 2);
                switch (randomText) {
                    case 1:
                        winSound = game.add.audio("high");
                        break;
                    case 2:
                        winSound = game.add.audio("medium");
                        break;
                }
            } else if (allWin < betline * lines * 3) {
                winSound = game.add.audio("low");
            } else {
                winSound = game.add.audio("low");
            }
            winSound.loop = true;
            winSound.play();
            allwinUpd = +allWin;
            spinStatus = false;
            balanceUpdateStatus = true;
            if (afterFreespinStatus) {
                x = allWinOld;
            }
            (function() {
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
                        credit.setText(BALANCE + x);
                        setTimeout(arguments.callee, interval);
                    }
                } else {
                    balanceUpdateStatus = false;
                    if (autostart == false) {
                        showButtons();
                    }
                    if (BALANCE + allWin < betline * lines) {
                        autostart = false;
                        $("#spin").removeClass("auto");
                        showButtons();
                        hideButtons([[startButton, "startButton"]]);
                        hideButtons([[autoPlay, "autoPlay"]]);
                        if (BALANCE + allWin < 1) {
                            hideButtons([[maxBetSpin, "maxBetSpin"]]);
                        }
                        hideMobileBtn();
                        autoPlay.loadTexture("autoPlay");
                        if (demo !== "demo") {
                            checkBalance();
                            showButtons([[autoPlay, "autoPlay"]]);
                            autoPlay.loadTexture("addCredit");
                            addcreditFlickStatus = true;
                            addCreditFlick();
                        }
                    } else {
                        if (autostart == false) {
                            showButtons([[startButton, "startButton"]]);
                            if (!spinStatus) {
                                showButtons([[autoPlay, "autoPlay"]]);
                                showButtons([[maxBetSpin, "maxBetSpin"]]);
                            }
                            showMobileBtn();
                        }
                    }
                    gameStatusTextFlick();
                    changeNumberSpin();
                    allWinOld = allWinOld + +allwinUpd;
                    paid.setText(+allwinUpd);
                    credit.setText(BALANCE + +allwinUpd);
                    winSound.stop();
                    updateFinishSound.play();
                    if (autostart == true) {
                        setTimeout(function() {
                            if ((autostart == true) & (spinStatus === false)) {
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
                    coinArrayLeft[i] = game.add.sprite(
                        -130 + 125 * i - j * 50,
                        -130 - j * 80,
                        "coin_anim_2"
                    );
                    coinArrayLeft[i].animations
                        .add("coin_anim_2", animCoinArray[i], 16, true)
                        .play();
                    coinGoLeftToRight(coinArrayLeft[i]);
                }
                for (var j = 0; j <= 7; ++j) {
                    coinArrayRight[i] = game.add.sprite(
                        1024 - 125 * i + j * 50,
                        -130 - j * 80,
                        "coin_anim_2"
                    );
                    coinArrayRight[i].animations
                        .add("coin_anim_2", animCoinArray[i], 16, true)
                        .play();
                    coinGoRightToLeft(coinArrayRight[i]);
                }
            }
        }

        function coinGoRightToLeft(elem) {
            game.add.tween(elem).to(
                {
                    x: elem.position.x - 900,
                    y: elem.position.y + 1530
                },
                3500,
                Phaser.Easing.LINEAR,
                true
            );
        }

        function coinGoLeftToRight(elem) {
            game.add
                .tween(elem)
                .to(
                    {
                        x: elem.position.x + 900,
                        y: elem.position.y + 1530
                    },
                    3500,
                    Phaser.Easing.LINEAR,
                    true
                )
                .onComplete.add(function() {
                    location.href = "/";
                });
        }

        function giveBalance() {
            var x = 0;
            var interval;
            allBalance = BALANCE + allWinOld;
            (function() {
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
            if (BALANCE + allWinOld < betline * lines) {
                hideButtons([[startButton, "startButton"]]);
                if (!flickBtn && !spinStatus) {
                    autoPlay.loadTexture("autoPlay");
                    hideButtons([[autoPlay, "autoPlay"]]);
                }
                if (BALANCE + allWinOld < 1) {
                    hideButtons([[maxBetSpin, "maxBetSpin"]]);
                }
                hideMobileBtn();
                if (demo !== "demo") {
                    checkBalance();
                    addcreditFlickStatus = true;
                    !spinStatus && showButtons([[autoPlay, "autoPlay"]]);

                    if (!flickBtn && !spinStatus) {
                        addcreditFlickStatus = true;
                        bottomText.visible = true;
                        bottomText.setText(
                            "To play please add credit to game."
                        );
                        bottomText.y = 7;
                        bottomText.fontSize = 25;
                        autoPlay.loadTexture("addCredit");
                        addCreditFlick();
                    }
                }
            } else {
                if (!spinStatus) {
                    showButtons([[startButton, "startButton"]]);
                    showButtons([[autoPlay, "autoPlay"]]);
                    showButtons([[maxBetSpin, "maxBetSpin"]]);
                    if (!autostart) {
                        autoPlay.loadTexture("autoPlay");
                    }
                    showMobileBtn();
                }
            }
        }

        var checkBalancedata;
        var getBalanceWait = false;

        function checkBalance() {
            if (!getBalanceWait && demo !== "demo") {
                if (
                    BALANCE + allWinOld < betline * lines &&
                    BALANCE + allWin < betline * lines &&
                    curGame === 1
                ) {
                    getBalance();
                } else {
                    // setTimeout(function() {
                    if (
                        !autostart &&
                        curGame === 1 &&
                        !balanceUpdateStatus &&
                        !spinStatus
                    ) {
                        if (BALANCE + allWin > 0) {
                            // getBalance();
                        }
                    } else {
                        // checkBalance();
                    }
                    // }, 30000);
                }
            }
        }

        function getBalance() {
            if (!getBalanceWait) {
                getBalanceWait = true;
                $.ajax({
                    type: "get",
                    url:
                        getNeedUrlPath() +
                        "/get-user-balance?userId=" +
                        userId +
                        "&gameId=" +
                        gameId +
                        "&token=" +
                        token +
                        "&platformId=" +
                        platformId +
                        "&session_uuid=" +
                        sessionUuid,
                    dataType: "html",
                    success: function(data) {
                        console.log(data);
                        if (IsJsonString(data)) {
                            checkBalancedata = JSON.parse(data);
                            getBalanceWait = false;
                            if (
                                checkBalancedata["status"] == "true" &&
                                BALANCE + allWin !==
                                    +checkBalancedata["balance"].toFixed()
                            ) {
                                BALANCE = +checkBalancedata[
                                    "balance"
                                ].toFixed();
                                changeBalance();
                            } else if (checkBalancedata["status"] !== "true") {
                                checkBalancedata.refId
                                    ? createRefID(checkBalancedata.refId)
                                    : createRefID("checkBalance status error");
                                error_bg.visible = true;
                                errorStatus = true;
                            } else if (BALANCE + allWinOld >= betline * lines) {
                                checkBalance();
                            } else {
                                getBalance();
                            }
                        } else {
                            console.log("json format error");
                            createRefID("get-user-balance json format error");
                            error_bg.visible = true;
                            errorStatus = true;
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        const responseText = xhr.responseText
                            ? JSON.parse(xhr.responseText)
                            : "";
                        const refId =
                            responseText && responseText.refId
                                ? responseText.refId
                                : "";
                        refId
                            ? createRefID(refId)
                            : createRefID("get-user-balance error");
                        error_bg.visible = true;
                        errorStatus = true;
                    }
                });
            }
        }

        function changeBalance() {
            !spinStatus && credit.setText(BALANCE);
            checkScore();

            if (BALANCE + allWinOld >= betline * lines) {
                if (!spinStatus) {
                    bottomText.setText("");
                    bottomText.visible = true;
                }
            }

            if (BALANCE + allWin > 0) {
                checkBalance();
            }
        }

        function pickMaxSpin() {
            var currentBalance = BALANCE + allWinOld;
            var curNumb = 1;
            var curLine = 1;
            var curBet = 1;
            for (var i = 1; i <= 20; ++i) {
                for (var j = 1; j <= 20; ++j) {
                    if ((i * j > curNumb) & (i * j <= currentBalance)) {
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
            isEnd["0"] = false;
            isEnd["1"] = false;
            isEnd["2"] = false;
            isEnd["3"] = false;
            isEnd["4"] = false;
            isSpinStart = true;
            doItOnce = true;
            parseAnswerStatus = false;
            dataSpinRequest["status"] = false;
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
            }

            for (var i = 1; i <= 15; ++i) {
                squareArrFreespin[i].visible = false;
                squareArrFreespin[i].tint = 0xffffff;
                briAnimArr[i].visible = false;
                coinAnimArr[i].visible = false;
                planeAnimArr[i].visible = false;
                katerAnimArr[i].visible = false;
                carAnimArr[i].visible = false;
            }
            gameStatusText.visible = false;
            bottomText.visible = true;
            bottomText.setText("Good Luck!");
            bottomText.y = 0;
            bottomText.fontSize = 35;
            paid.setText("0");
            startButton.loadTexture("stopButton");
            hideLines();
            hideButtons([
                [paytable, "paytable"],
                [help, "help"],
                [selectLines, "selectLines"],
                [betPerLine, "betPerLine"],
                [startButton, "startButton"],
                [maxBetSpin, "maxBetSpin"],
                [exit, "exit"]
            ]);
            if (autostart === false) {
                showButtons([[startButton, "startButton"]]);
                hideButtons([[autoPlay, "autoPlay"]]);
            } else {
                showMobileBtn();
            }
            hideSquare();

            setTimeout(function() {
                startspin(0);
                setTimeout(function() {
                    startspin(1);
                    setTimeout(function() {
                        startspin(2);
                        setTimeout(function() {
                            startspin(3);
                            setTimeout(function() {
                                startspin(4);
                                let randomText = randomNumber(1, 2);
                                spinSound = game.add.audio(
                                    "spinSound" + randomText
                                );
                                spinSound.play();
                            }, 50);
                        }, 50);
                    }, 50);
                }, 50);
            }, 50);
        }

        if (firstStartGame) {
            document.body.querySelector("canvas").setAttribute("tabindex", "1");
            checkBalance();
            firstStartGame = false;
            document.body
                .querySelector("canvas")
                .addEventListener("keyup", function(event) {
                    if (event.keyCode === 32) {
                        if (!errorStatus) {
                            if (curGame === 1) {
                                if (startButton.visible) {
                                    if (isSpinStart) allowSpin = false;

                                    if (spinStatus === false) {
                                        if (paytableStatus === false) {
                                            if (autostart === false) {
                                                if (
                                                    BALANCE + allWinOld >=
                                                    betline * lines
                                                ) {
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
                                                if (
                                                    dataSpinRequest[
                                                        "status"
                                                    ] !== "false"
                                                ) {
                                                    if (parseAnswerStatus) {
                                                        startButton.loadTexture(
                                                            "startButton"
                                                        );
                                                        hideButtons([
                                                            [
                                                                startButton,
                                                                "startButton"
                                                            ]
                                                        ]);
                                                        timerSpin.forEach(
                                                            function(item, i) {
                                                                clearTimeout(
                                                                    timerSpin[i]
                                                                );
                                                            }
                                                        );
                                                        spinSound.stop();
                                                        timeSpin = false;
                                                        game1.bars[0].visible = false;
                                                        game1.cell[
                                                            1 + 3 * 0
                                                        ].visible = true;
                                                        game1.cell[
                                                            2 + 3 * 0
                                                        ].visible = true;
                                                        game1.cell[
                                                            3 + 3 * 0
                                                        ].visible = true;
                                                        game1.bars[1].visible = false;
                                                        game1.cell[
                                                            1 + 3 * 1
                                                        ].visible = true;
                                                        game1.cell[
                                                            2 + 3 * 1
                                                        ].visible = true;
                                                        game1.cell[
                                                            3 + 3 * 1
                                                        ].visible = true;
                                                        game1.bars[2].visible = false;
                                                        game1.cell[
                                                            1 + 3 * 2
                                                        ].visible = true;
                                                        game1.cell[
                                                            2 + 3 * 2
                                                        ].visible = true;
                                                        game1.cell[
                                                            3 + 3 * 2
                                                        ].visible = true;
                                                        game1.bars[3].visible = false;
                                                        game1.cell[
                                                            1 + 3 * 3
                                                        ].visible = true;
                                                        game1.cell[
                                                            2 + 3 * 3
                                                        ].visible = true;
                                                        game1.cell[
                                                            3 + 3 * 3
                                                        ].visible = true;
                                                        game1.bars[4].visible = false;
                                                        game1.cell[
                                                            1 + 3 * 4
                                                        ].visible = true;
                                                        game1.cell[
                                                            2 + 3 * 4
                                                        ].visible = true;
                                                        game1.cell[
                                                            3 + 3 * 4
                                                        ].visible = true;
                                                        game1.cell[1].loadTexture(
                                                            "cell" + info[0]
                                                        );
                                                        game1.cell[2].loadTexture(
                                                            "cell" + info[1]
                                                        );
                                                        game1.cell[3].loadTexture(
                                                            "cell" + info[2]
                                                        );
                                                        game1.cell[4].loadTexture(
                                                            "cell" + info[3]
                                                        );
                                                        game1.cell[5].loadTexture(
                                                            "cell" + info[4]
                                                        );
                                                        game1.cell[6].loadTexture(
                                                            "cell" + info[5]
                                                        );
                                                        game1.cell[7].loadTexture(
                                                            "cell" + info[6]
                                                        );
                                                        game1.cell[8].loadTexture(
                                                            "cell" + info[7]
                                                        );
                                                        game1.cell[9].loadTexture(
                                                            "cell" + info[8]
                                                        );
                                                        game1.cell[10].loadTexture(
                                                            "cell" + info[9]
                                                        );
                                                        game1.cell[11].loadTexture(
                                                            "cell" + info[10]
                                                        );
                                                        game1.cell[12].loadTexture(
                                                            "cell" + info[11]
                                                        );
                                                        game1.cell[13].loadTexture(
                                                            "cell" + info[12]
                                                        );
                                                        game1.cell[14].loadTexture(
                                                            "cell" + info[13]
                                                        );
                                                        game1.cell[15].loadTexture(
                                                            "cell" + info[14]
                                                        );
                                                        if (
                                                            game1.spinStatus1 ===
                                                            true
                                                        ) {
                                                            game1.spinStatus1 = false;
                                                            endspin(0);
                                                        }
                                                        if (
                                                            game1.spinStatus2 ===
                                                            true
                                                        ) {
                                                            game1.spinStatus2 = false;
                                                            endspin(1);
                                                        }
                                                        if (
                                                            game1.spinStatus3 ===
                                                            true
                                                        ) {
                                                            game1.spinStatus3 = false;
                                                            endspin(2);
                                                        }
                                                        if (
                                                            game1.spinStatus4 ===
                                                            true
                                                        ) {
                                                            game1.spinStatus4 = false;
                                                            endspin(3);
                                                        }
                                                        if (
                                                            game1.spinStatus5 ===
                                                            true
                                                        ) {
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
            $("canvas").mouseup(function(e) {
                if (curGame === 2) {
                    if (balanceUpdateStatus2) {
                        console.log(1);
                        balanceUpdateStatus2 = false;
                    }
                }
            });
            hideMobileBtn();
            if (isMobile) {
                game.sound.mute = false;
                checkScore();
            } else {
                checkScore();
            }
        }
    };

    game1.update = function() {
        if (!allowSpin && isGetResponse && doItOnce) {
            timerSpin.forEach(function(i) {
                clearTimeout(i);
            });

            game1.spinStatus1 && globalMiddleSpin(0, 0);
            game1.spinStatus2 && globalMiddleSpin(1, 0);
            game1.spinStatus3 && globalMiddleSpin(2, 0);
            game1.spinStatus4 && globalMiddleSpin(3, 0);
            game1.spinStatus5 && globalMiddleSpin(4, 0);
            doItOnce = false;
        }

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
        }
        game1.ticker.tilePosition.x += 0.5;
        // document.body.querySelector('canvas').focus();
    };

    game.state.add("game1", game1);
}
