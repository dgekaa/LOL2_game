function game2() {
    var game2 = {
        cell: [],
        copyCell: [],
        spinStatus: false,
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
        briBgArr: [],
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

    game2.preload = function() {};

    game2.create = function() {
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
        coinSound1 = game.add.audio("coin1");
        coinSound2 = game.add.audio("coin2");
        coinSound3 = game.add.audio("coin3");
        coinSound4 = game.add.audio("coin4");
        coinSound5 = game.add.audio("coin5");
        curGame = 2;
        var countBri = 2;
        var mulFreespin = 2;
        var mulFreespinOld = 2;
        var freeSpinCount = 12;
        var allFreeSpinCount = 12;
        allWinOld = 0;
        if (featureGameStatus) {
            allWinOld = allWinOldInit;
            mulFreespin = mulFreespinInit;
            mulFreespinOld = mulFreespinInit;
            freeSpinCount = freeSpinCountInit;
            allFreeSpinCount = allFreeSpinCountInit;
        }
        var balanceSongAudio = game.add.audio("balanceSong");
        balanceSongAudio.loop = true;
        var briSoundAudio = game.add.audio("briSound");
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
        for (var i = 1; i <= 15; ++i) {
            game.add.sprite(cellPos[i - 1][0], cellPos[i - 1][1], "emptyCell");
        }

        // info = [7, 1, 2, 3, 4, 5, 6, 7, 3, 9, 9, 1, 2, 3, 1];
        // info.sort(() => Math.random() - 0.5);

        function infoRandom() {
            const infoArray = [
                [1, 2, 3, 4, 5, 6, 7, 8, 9, 1, 2, 3, 4, 5, 6],
                [2, 9, 1, 2, 3, 4, 5, 6, 1, 2, 3, 4, 5, 6, 7],
                [3, 1, 4, 8, 9, 1, 5, 2, 3, 4, 5, 6, 7, 5, 1],
                [9, 8, 7, 6, 5, 4, 3, 2, 1, 4, 5, 6, 7, 8, 9],
                [1, 5, 9, 4, 7, 8, 2, 3, 6, 4, 5, 8, 9, 1, 2],
                [1, 4, 7, 2, 5, 8, 3, 6, 9, 2, 5, 8, 3, 6, 9],
                [9, 6, 3, 8, 5, 2, 7, 4, 1, 7, 8, 9, 4, 5, 6]
            ];

            info = infoArray[Math.floor(Math.random() * infoArray.length)];
        }

        infoRandom();

        bg = game.add.sprite(0, 0, "game.background2");

        slotLayer1Group = game.add.group();
        slotLayer1Group.add(bg);

        topLabel = game.add.sprite(240, 0, "top_label_1");
        bg_overlay2 = game.add.sprite(0, 0, "game.background_overlay2");

        slotLayer3Group = game.add.group();
        slotLayer3Group.add(topLabel);
        slotLayer2Group = game.add.group();
        slotLayer4Group = game.add.group();
        slotLayer2Group.add(bg_overlay2);
        for (var i = 1; i <= 15; ++i) {
            game2.cell[i] = game.add.sprite(
                cellPos[i - 1][0],
                cellPos[i - 1][1],
                "cell" + info[i - 1] + "_f"
            );
            slotLayer2Group.add(game2.cell[i]);
        }
        console.log(info, "___________________INFO");
        game2.bars[0] = game.add.tileSprite(77, 126 + 94, 158, 447, "bar2");
        game2.bars[0].tilePosition.y = randomNumber(0, 9) * 149;
        game2.bars[1] = game.add.tileSprite(255, 126 + 94, 158, 447, "bar2");
        game2.bars[1].tilePosition.y = randomNumber(0, 9) * 149;
        game2.bars[2] = game.add.tileSprite(433, 126 + 94, 158, 447, "bar2");
        game2.bars[2].tilePosition.y = randomNumber(0, 8) * 149;
        game2.bars[3] = game.add.tileSprite(611, 126 + 95, 158, 447, "bar2");
        game2.bars[3].tilePosition.y = randomNumber(0, 9) * 149;
        game2.bars[4] = game.add.tileSprite(788, 126 + 94, 158, 447, "bar2");
        game2.bars[4].tilePosition.y = randomNumber(0, 9) * 149;
        game2.bars[0].visible = false;
        game2.bars[1].visible = false;
        game2.bars[2].visible = false;
        game2.bars[3].visible = false;
        game2.bars[4].visible = false;
        slotLayer2Group.add(game2.bars[0]);
        slotLayer2Group.add(game2.bars[1]);
        slotLayer2Group.add(game2.bars[2]);
        slotLayer2Group.add(game2.bars[3]);
        slotLayer2Group.add(game2.bars[4]);

        bg2_panels = game.add.sprite(0, 0, "background2_panels");
        createdStars();
        createdStarsMini();
        slotLayer2Group.add(bg2_panels);

        function createdStars() {
            let coordX = randomNumber(0, 1020);
            let coordY;
            let star;
            if (coordX < 159 || coordX > 979) {
                coordY = randomNumber(0, 600);
            } else {
                coordY = randomNumber(0, 159);
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

        multiplier = game.add.sprite(147, -69, "multiplier");
        spins_remaining = game.add.sprite(-238, 5, "spins_remaining");
        bonus = game.add.sprite(1024, 5, "bonus");

        topBottomLabel = game.add.sprite(57, 42, "top_bottom_label_2");
        topBottomLabel.visible = false;
        for (let i = 1; i <= 10; ++i) {
            if (i < 10) {
                briMulti[i] = game.add.sprite(
                    213 + 44 * (i - 1),
                    151 - 204,
                    "little_bri"
                );
                briMulti[i].visible = false;
            } else {
                briMulti[i] = game.add.sprite(
                    213 + -44,
                    151 - 204,
                    "little_bri"
                );
                briMulti[i].visible = false;
            }
        }
        briMulti[1].visible = true;
        briMulti[2].visible = true;
        for (var i = 1; i <= 27; ++i) {
            game2.briBgArr[i] = game.add.sprite(
                155 + (i - 1) * 35,
                671,
                "bg_bri"
            );
            game2.briBgArr[i].anchor.setTo(0.5, 0.5);
            game2.briBgArr[i].visible = false;
        }
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
        var squareArrFreespin = [];
        var coinAnimArr = [];
        addLines(circlePos, linePos, textPos, cellPos, squareArr, squareArrImg);
        hideLines();
        hideLinesCircle();
        hideLinesCircleText();
        for (var i = 1; i <= lines; ++i) {
            showLineCircle(i);
            showLineCircleText(i);
        }

        function addLines(
            circlePos,
            linePos,
            textPos,
            cellPos,
            squareArr,
            squareArrImg
        ) {
            for (var i = 1; i <= 20; ++i) {
                game2.lineArr[i] = game.add.sprite(0, 0 + 94, "line_" + i);
                game2.circleArr[i] = game.add.sprite(
                    circlePos[i - 1][0],
                    circlePos[i - 1][1],
                    "circleLine_" + i
                );
                game2.textArr[i] = game.add.text(
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
                game2.textArr[i].anchor.setTo(0.5, 0.5);
            }
            for (var i = 1; i <= 15; ++i) {
                game2.copyCell[i] = game.add.sprite(
                    cellPos[i - 1][0],
                    cellPos[i - 1][1] + 94,
                    "cell" + info[i - 1] + "_f"
                );

                game2.copyCell[i].visible = false;
                squareArrFreespin[i] = game.add.sprite(
                    cellPos[i - 1][0] - 1,
                    cellPos[i - 1][1] + 94,
                    "square_1"
                );
                squareArrFreespin[i].visible = false;
            }
            for (var i = 1; i <= 20; ++i) {
                for (var j = 1; j <= 5; ++j) {
                    squareArrImg[i - 1][j - 1] = game.add.sprite(
                        cellPos[squareArr[i - 1][j - 1] - 1][0] - 1,
                        cellPos[squareArr[i - 1][j - 1] - 1][1] + 93,
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
            // game.add
            //     .tween(game2.lineArr[lineNumber])
            //     .to({ alpha: 1 }, 100, Phaser.Easing.LINEAR, true)
            //     .onComplete.add(function() {});

            game2.lineArr[lineNumber].visible = true;
        }

        function showLineCircle(lineNumber) {
            game2.circleArr[lineNumber].visible = true;
        }

        function showLineCircleText(lineNumber) {
            game2.textArr[lineNumber].visible = true;
        }

        function hideLines() {
            game2.lineArr.forEach(function(line) {
                // game.add
                //     .tween(line)
                //     .to({ alpha: 0 }, 100, Phaser.Easing.LINEAR, true)
                //     .onComplete.add(function() {});

                line.visible = false;
                line.tint = 0xffffff;
            });
        }

        function hideLinesCircle() {
            game2.circleArr.forEach(function(line) {
                line.visible = false;
            });
        }

        function hideLinesCircleText() {
            game2.textArr.forEach(function(line) {
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
        addScore();
        if (featureGameStatus) {
            briMulti[1].visible = false;
            briMulti[2].visible = false;
            for (let i = 1; i <= mulFreespin % 10; ++i) {
                briMulti[i].visible = true;
            }
            if (mulFreespin >= 10) {
                multiBriText.visible = true;
                multiBriText.setText(mulFreespin - (mulFreespin % 10));
                briMulti[10].visible = true;
            }
            featureGameStatus = false;
        }
        freespinStartBG = game.add.sprite(75, 125, "freespinStartBG");
        freesponStartBGAdditionalBonus = game.add.sprite(
            75,
            125,
            "freesponStartBGAdditionalBonus"
        );
        freesponStartBGAdditionalBonus.visible = false;
        freesponStartBGText = game.add.sprite(75, 125, "freesponStartBGText");
        freesponFinishBGText = game.add.sprite(
            75,
            125 + 94,
            "freesponFinishBGText"
        );
        freesponFinishBGText.visible = false;
        big_red_border = game.add.sprite(497, 343, "coin_big_anim");
        setTimeout(function() {
            game.add
                .tween(freespinStartBG)
                .to({ alpha: 0 }, 1000, "Linear", true)
                .onComplete.add(function() {
                    big_red_border.visible = false;
                    freesponStartBGText.visible = false;
                    moveBgOnBottom();
                    setTimeout(function() {
                        freeSpinStart();
                    }, 2500);
                });
        }, 1000);
        big_red_border.animations
            .add("anim", [], 50, false)
            .play()
            .onComplete.add(function() {});
        big_red_border.anchor.setTo(0.5, 0.5);
        error_bg = game.add.sprite(0, 0, "error_bg");
        error_bg.visible = false;

        function moveBgOnBottom() {
            for (var i = 1; i <= 15; ++i) {
                moveElementOnBottom(game2.cell[i]);
            }
            for (var i = 1; i <= 20; ++i) {
                moveElementOnBottom(game2.circleArr[i]);
                moveElementOnBottom(game2.textArr[i]);
            }
            for (var i = 1; i <= 10; ++i) {
                moveElementOnCenter(briMulti[i]);
            }
            moveElementOnBottom(bg_overlay2);
            moveElementOnBottom(bg2_panels);
            moveElementOnBottom(freespinStartBG);
            moveElementOnBottom(freesponStartBGAdditionalBonus);
            moveElementOnBottom(big_red_border);
            moveElementOnBottom(bottomText);
            moveElementOnBottom(credit);
            moveElementOnBottom(linesText);
            moveElementOnBottom(lineBetText);
            moveElementOnBottom(totalBet);
            moveElementOnBottom(paid);
            moveElementOnCenter(multiplier);
            moveElementOnCenter(multiplierText);
            moveElementOnLeftSide(spins_remaining);
            moveElementOnLeftSide(spinsLeft);
            moveElementOnRightSide(bonus);
            moveElementOnRightSide(bonusText);
        }

        function moveElementOnBottom(elem) {
            game.add
                .tween(elem)
                .to({ y: elem.position.y + 94 }, 500, "Linear", true);
        }

        function moveElementOnCenter(elem) {
            game.add
                .tween(elem)
                .to({ y: elem.position.y + 204 }, 500, "Linear", true);
        }

        function moveElementOnLeftSide(elem) {
            game.add
                .tween(elem)
                .to({ x: elem.position.x + 238 }, 500, "Linear", true);
        }

        function moveElementOnRightSide(elem) {
            game.add
                .tween(elem)
                .to({ x: elem.position.x - 244 }, 500, "Linear", true);
        }

        function freeSpinStart() {
            stopWinAnim = true;
            lineflash = 0;
            realSpinStatus = true;
            game2.spinStatus = true;
            winText.visible = false;
            topBottomLabel.visible = false;
            mulFreespinOld = mulFreespin;
            // setTimeout(() => {
            for (var i = 1; i <= 15; ++i) {
                game2.copyCell[i].visible = false;
            }
            // }, 100);

            bottomText.visible = true;
            bottomText.font = "ArialMT-CondensedBold";
            bottomText.fontSize = "32px";
            bottomText.fill = "#ffffff";
            bottomText.stroke = "#000000";
            bottomText.strokeThickness = 5;
            freeSpinCount = freeSpinCount - 1;
            spinsLeft.setText(freeSpinCount);
            bottomText.setText(
                "SPIN " +
                    (allFreeSpinCount - freeSpinCount) +
                    ": ALL PAYS AT " +
                    mulFreespin +
                    "X"
            );
            bottomText.setTextBounds(0, 586, 1024, 100);

            bg2_panels.loadTexture("game.background3");
            slotLayer2Group.add(topLabel);
            hideLines();
            // hideButtons();
            hideSquare();
            let randomText = randomNumber(1, 2);
            spinSound = game.add.audio("spinSound" + randomText + "f");
            spinSound.play();
            startspin(0);
            startspin(1);
            startspin(2);
            startspin(3);
            startspin(4);
        }

        var errorStatus = false;
        let reconnectCount = 0;

        function requestSpin(gamename, sessionName, betline, lines) {
            // if (window.navigator.onLine) {
            $.ajax({
                type: "get",
                url:
                    getNeedUrlPath() +
                    `/api-v2/action?game_id=${gameId}&user_id=${userId}&mode=${demo}&action=free_spin&session_uuid=${sessionUuid}&token=${token}&linesInGame=${lines}&lineBet=${betline}&platform_id=${platformId}`,
                dataType: "html",
                success: function(data) {
                    console.log(data);
                    if (IsJsonString(data)) {
                        dataSpinRequest = JSON.parse(data);
                        if (dataSpinRequest.status !== "false") {
                            let eventId = game.add.text(
                                975,
                                687,
                                dataSpinRequest.sessionData["eventId"] || "",
                                {
                                    font: "22px Arial",
                                    fill: "#fff",
                                    fontWeight: 600
                                }
                            );
                            eventId.anchor.setTo(1, 0);
                            eventId.visible = true;
                            parseSpinAnswer(dataSpinRequest);
                        } else {
                            errorStatus = true;
                            switch (dataSpinRequest.message) {
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
                                        : createRefID("low balance exception");
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
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    if (freeSpinCount !== 10) {
                        const responseText = xhr.responseText
                            ? JSON.parse(xhr.responseText)
                            : "";
                        const refId =
                            responseText && responseText.refId
                                ? responseText.refId
                                : "";

                        var errorText = "//ошибка 30";
                        console.log("переключение № " + reconnectCount);
                        console.log(errorText);

                        if (refId) {
                            createRefID(refId);
                            error_bg.visible = true;
                            errorStatus = true;
                        } else {
                            if (reconnectCount < 10) {
                                reconnectCount++;
                                reconnectSpin(
                                    gamename,
                                    sessionName,
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
                    } else {
                        requestSpin(gamename, sessionName, betline, lines);
                    }
                    // let timerId = setTimeout(function tick() {
                    //     if (window.navigator.onLine) {
                    //         requestSpin(gamename, sessionName, betline, lines);
                    //         clearTimeout(timerId);
                    //     } else {
                    //         timerId = setTimeout(tick, 1000);
                    //     }
                    // }, 1000);
                }
            });
            // } else {
            //     let timerId = setTimeout(function tick() {
            //         if (window.navigator.onLine) {
            //             requestSpin(gamename, sessionName, betline, lines);
            //             clearTimeout(timerId);
            //         } else {
            //             timerId = setTimeout(tick, 1000);
            //         }
            //     }, 1000);
            // }
        }

        function moveFundsExceptionFunc(
            gamename,
            sessionName,
            betline,
            lines,
            moveFundsExceptionID
        ) {
            // if (!window.navigator.onLine) return;

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
                            requestSpin(gamename, sessionName, betline, lines);
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
                    const responseText = xhr.responseText
                        ? JSON.parse(xhr.responseText)
                        : "";
                    const refId =
                        responseText && responseText.refId
                            ? responseText.refId
                            : "";
                    refId ? createRefID(refId) : createRefID("Funds error");
                    console.log(errorText);
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
            // if (!window.navigator.onLine) return;

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
                            requestSpin(gamename, sessionName, betline, lines);
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
                    requestSpin(gamename, sessionName, betline, lines);
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    var errorText = "//ошибка переподкючения";
                    console.log(errorText);

                    setTimeout(() => {
                        requestSpin(gamename, sessionName, betline, lines);
                    }, 3000);
                }
            });
        }

        var payoffByBonus;
        var coinCount = 0;

        function parseSpinAnswer(dataSpinRequest) {
            console.log(`Win : ${dataSpinRequest.stateData.isWin}`);
            dataArray = dataSpinRequest;
            dataArrValue = dataArray.length;

            winCellInfo = dataArray.logicData["winningCells"];
            wlValues = dataArray.logicData["payoffsForLines"];

            // balance = dataArray.balanceData['balance'] - dataArray.balanceData['totalPayoff'];

            allWin = dataArray.balanceData["payoffByLines"];
            payoffByBonus = dataArray.balanceData["payoffByBonus"];

            if (realSpinStatus) {
                realSpinStatus = false;
            }

            triggerPay = dataArray.longData.balanceData.payoffByBonus;
            linePay = dataArray.longData.balanceData.payoffByLines;
            bonusPay =
                dataArray.longData.balanceData.totalWinningsInFeatureGame;
            infoOldOnlyForThisWindow = dataArray.longData.logicData.table;
            winCellInfo = dataArray.logicData["winningCells"];

            mulFreespin = dataArray.logicData.multiplier;

            if (dataSpinRequest.longData) {
                winOldTrigerFreeSpin =
                    dataArray.longData.balanceData["totalPayoff"];
                infoOld = dataArray.longData.logicData.table;
                wlValuesOld = dataArray.longData.logicData["payoffsForLines"];
                // balanceOld = dataArray.longData.balanceData['balance'] - dataArray.longData.balanceData['totalPayoff'];
                wcvWinValuesArrayOld = [];
                wlWinValuesArrayOld = [];
                winWithoutCoinOld = 0;
                for (key in dataArray.longData.logicData["payoffsForLines"]) {
                    winWithoutCoinOld =
                        winWithoutCoinOld +
                        dataArray.longData.logicData["payoffsForLines"][key]
                            .winValue;
                    wlWinValuesArrayOld.push(
                        dataArray.longData.logicData["payoffsForLines"][key]
                            .lineNumber + 1
                    );
                }
                for (key in dataArray.longData.logicData.table) {
                    if (
                        dataArray.longData.logicData.table[key] === 10 ||
                        dataArray.longData.logicData.table[key] === 0
                    ) {
                        wcvWinValuesArrayOld.push(+key);
                    }
                }
                winCellInfoOld = dataArray.longData.logicData["winningCells"];
                wlValuesFS = dataArray.longData.logicData["payoffsForBonus"];
            }
            coinCount = 0;
            info = dataArray.logicData.table;
            middlespin(0);
            middlespin(1);
            middlespin(2);
            middlespin(3);
            middlespin(4);
        }

        function startspin(number) {
            game.add
                .tween(game2.cell[1 + number * 3])
                .to(
                    { y: game2.cell[1 + number * 3].position.y - 30 },
                    200,
                    Phaser.Easing.LINEAR,
                    true
                )
                .onComplete.add(function() {
                    game2.cell[1 + number * 3].visible = false;
                });
            game.add
                .tween(game2.cell[2 + number * 3])
                .to(
                    { y: game2.cell[2 + number * 3].position.y - 30 },
                    200,
                    Phaser.Easing.LINEAR,
                    true
                )
                .onComplete.add(function() {
                    game2.cell[2 + number * 3].visible = false;
                });
            game.add
                .tween(game2.cell[3 + number * 3])
                .to(
                    { y: game2.cell[3 + number * 3].position.y - 30 },
                    200,
                    Phaser.Easing.LINEAR,
                    true
                )
                .onComplete.add(function() {
                    game2.cell[3 + number * 3].visible = false;
                    game2.bars[number].visible = true;
                    if (number == 0) {
                        game2.spinStatus1 = true;
                    }
                    if (number == 1) {
                        game2.spinStatus2 = true;
                    }
                    if (number == 2) {
                        game2.spinStatus3 = true;
                    }
                    if (number == 3) {
                        game2.spinStatus4 = true;
                    }
                    if (number == 4) {
                        requestSpin(gamename, sessionName, betline, lines);
                        game2.spinStatus5 = true;
                    }
                });
        }

        function middlespin(number) {
            if (number == 0) {
                setTimeout(function() {
                    game2.spinStatus1 = false;
                    game2.bars[0].visible = false;
                    game2.cell[1 + 3 * 0].visible = true;
                    game2.cell[2 + 3 * 0].visible = true;
                    game2.cell[3 + 3 * 0].visible = true;

                    game2.cell[1].loadTexture("cell" + info[0] + "_f");
                    game2.cell[2].loadTexture("cell" + info[1] + "_f");
                    game2.cell[3].loadTexture("cell" + info[2] + "_f");
                    if (info[0] == 10 || info[1] == 10 || info[2] == 10) {
                        coinCount = coinCount + 1;
                        coinSound1.play();
                    }

                    if (info[0] == 0 || info[1] == 0 || info[2] == 0) {
                        briShow.play();
                    } else {
                        finishSpinSound1.play();
                    }
                    endspin(number);
                }, 900);
            }
            if (number == 1) {
                setTimeout(function() {
                    game2.spinStatus2 = false;
                    game2.bars[0].visible = false;
                    game2.cell[1 + 3 * 0].visible = true;
                    game2.cell[2 + 3 * 0].visible = true;
                    game2.cell[3 + 3 * 0].visible = true;

                    game2.cell[1].loadTexture("cell" + info[0] + "_f");
                    game2.cell[2].loadTexture("cell" + info[1] + "_f");
                    game2.cell[3].loadTexture("cell" + info[2] + "_f");
                    game2.bars[1].visible = false;
                    game2.cell[1 + 3 * 1].visible = true;
                    game2.cell[2 + 3 * 1].visible = true;
                    game2.cell[3 + 3 * 1].visible = true;

                    game2.cell[4].loadTexture("cell" + info[3] + "_f");
                    game2.cell[5].loadTexture("cell" + info[4] + "_f");
                    game2.cell[6].loadTexture("cell" + info[5] + "_f");
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
                    }

                    if (info[3] == 0 || info[4] == 0 || info[5] == 0) {
                        briShow.play();
                    } else {
                        finishSpinSound2.play();
                    }
                    endspin(number);
                }, 1350);
            }
            if (number == 2) {
                setTimeout(function() {
                    game2.spinStatus3 = false;
                    game2.bars[0].visible = false;
                    game2.cell[1 + 3 * 0].visible = true;
                    game2.cell[2 + 3 * 0].visible = true;
                    game2.cell[3 + 3 * 0].visible = true;

                    game2.cell[1].loadTexture("cell" + info[0] + "_f");
                    game2.cell[2].loadTexture("cell" + info[1] + "_f");
                    game2.cell[3].loadTexture("cell" + info[2] + "_f");
                    game2.bars[1].visible = false;
                    game2.cell[1 + 3 * 1].visible = true;
                    game2.cell[2 + 3 * 1].visible = true;
                    game2.cell[3 + 3 * 1].visible = true;

                    game2.cell[4].loadTexture("cell" + info[3] + "_f");
                    game2.cell[5].loadTexture("cell" + info[4] + "_f");
                    game2.cell[6].loadTexture("cell" + info[5] + "_f");
                    game2.bars[2].visible = false;
                    game2.cell[1 + 3 * 2].visible = true;
                    game2.cell[2 + 3 * 2].visible = true;
                    game2.cell[3 + 3 * 2].visible = true;

                    game2.cell[7].loadTexture("cell" + info[6] + "_f");
                    game2.cell[8].loadTexture("cell" + info[7] + "_f");
                    game2.cell[9].loadTexture("cell" + info[8] + "_f");
                    if (info[6] == 0 || info[7] == 0 || info[8] == 0) {
                        briShow.play();
                    } else {
                        finishSpinSound3.play();
                    }

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
                    }
                    endspin(number);
                }, 1800);
            }
            if (number == 3) {
                setTimeout(function() {
                    game2.spinStatus4 = false;
                    game2.bars[0].visible = false;
                    game2.cell[1 + 3 * 0].visible = true;
                    game2.cell[2 + 3 * 0].visible = true;
                    game2.cell[3 + 3 * 0].visible = true;

                    game2.cell[1].loadTexture("cell" + info[0] + "_f");
                    game2.cell[2].loadTexture("cell" + info[1] + "_f");
                    game2.cell[3].loadTexture("cell" + info[2] + "_f");
                    game2.bars[1].visible = false;
                    game2.cell[1 + 3 * 1].visible = true;
                    game2.cell[2 + 3 * 1].visible = true;
                    game2.cell[3 + 3 * 1].visible = true;

                    game2.cell[4].loadTexture("cell" + info[3] + "_f");
                    game2.cell[5].loadTexture("cell" + info[4] + "_f");
                    game2.cell[6].loadTexture("cell" + info[5] + "_f");
                    game2.bars[2].visible = false;
                    game2.cell[1 + 3 * 2].visible = true;
                    game2.cell[2 + 3 * 2].visible = true;
                    game2.cell[3 + 3 * 2].visible = true;

                    game2.cell[7].loadTexture("cell" + info[6] + "_f");
                    game2.cell[8].loadTexture("cell" + info[7] + "_f");
                    game2.cell[9].loadTexture("cell" + info[8] + "_f");
                    game2.bars[3].visible = false;
                    game2.cell[1 + 3 * 3].visible = true;
                    game2.cell[2 + 3 * 3].visible = true;
                    game2.cell[3 + 3 * 3].visible = true;

                    game2.cell[10].loadTexture("cell" + info[9] + "_f");
                    game2.cell[11].loadTexture("cell" + info[10] + "_f");
                    game2.cell[12].loadTexture("cell" + info[11] + "_f");
                    if (info[9] == 0 || info[10] == 0 || info[11] == 0) {
                        briShow.play();
                    } else {
                        finishSpinSound4.play();
                    }

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
                    }
                    endspin(number);
                }, 2250);
            }
            if (number == 4) {
                setTimeout(function() {
                    game2.spinStatus5 = false;
                    game2.bars[0].visible = false;
                    game2.cell[1 + 3 * 0].visible = true;
                    game2.cell[2 + 3 * 0].visible = true;
                    game2.cell[3 + 3 * 0].visible = true;

                    game2.cell[1].loadTexture("cell" + info[0] + "_f");
                    game2.cell[2].loadTexture("cell" + info[1] + "_f");
                    game2.cell[3].loadTexture("cell" + info[2] + "_f");
                    game2.bars[1].visible = false;
                    game2.cell[1 + 3 * 1].visible = true;
                    game2.cell[2 + 3 * 1].visible = true;
                    game2.cell[3 + 3 * 1].visible = true;

                    game2.cell[4].loadTexture("cell" + info[3] + "_f");
                    game2.cell[5].loadTexture("cell" + info[4] + "_f");
                    game2.cell[6].loadTexture("cell" + info[5] + "_f");
                    game2.bars[2].visible = false;
                    game2.cell[1 + 3 * 2].visible = true;
                    game2.cell[2 + 3 * 2].visible = true;
                    game2.cell[3 + 3 * 2].visible = true;

                    game2.cell[7].loadTexture("cell" + info[6] + "_f");
                    game2.cell[8].loadTexture("cell" + info[7] + "_f");
                    game2.cell[9].loadTexture("cell" + info[8] + "_f");
                    game2.bars[3].visible = false;
                    game2.cell[1 + 3 * 3].visible = true;
                    game2.cell[2 + 3 * 3].visible = true;
                    game2.cell[3 + 3 * 3].visible = true;

                    game2.cell[10].loadTexture("cell" + info[9] + "_f");
                    game2.cell[11].loadTexture("cell" + info[10] + "_f");
                    game2.cell[12].loadTexture("cell" + info[11] + "_f");
                    game2.bars[4].visible = false;
                    game2.cell[1 + 3 * 4].visible = true;
                    game2.cell[2 + 3 * 4].visible = true;
                    game2.cell[3 + 3 * 4].visible = true;

                    game2.cell[13].loadTexture("cell" + info[12] + "_f");
                    game2.cell[14].loadTexture("cell" + info[13] + "_f");
                    game2.cell[15].loadTexture("cell" + info[14] + "_f");
                    if (info[12] == 0 || info[13] == 0 || info[14] == 0) {
                        briShow.play();
                    } else {
                        finishSpinSound5.play();
                    }

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
                    }
                    endspin(number);
                }, 2700);
            }
        }

        function endspin(number) {
            game2.cell[1 + number * 3].position.y = 127 + 30 + 94;
            game2.cell[2 + number * 3].position.y = 276 + 30 + 94;
            game2.cell[3 + number * 3].position.y = 425 + 30 + 94;
            game.add
                .tween(game2.cell[1 + number * 3])
                .to(
                    { y: game2.cell[1 + number * 3].position.y - 30 },
                    200,
                    Phaser.Easing.LINEAR,
                    true
                )
                .onComplete.add(function() {});
            game.add
                .tween(game2.cell[2 + number * 3])
                .to(
                    { y: game2.cell[2 + number * 3].position.y - 30 },
                    200,
                    Phaser.Easing.LINEAR,
                    true
                )
                .onComplete.add(function() {});
            game.add
                .tween(game2.cell[3 + number * 3])
                .to(
                    { y: game2.cell[3 + number * 3].position.y - 30 },
                    200,
                    Phaser.Easing.LINEAR,
                    true
                )
                .onComplete.add(function() {
                    if (number == 4) {
                        slotLayer3Group.add(topLabel);
                        bg2_panels.loadTexture("background2_panels");
                        game2.spinStatus = false;
                        for (var i = 1; i <= 15; ++i) {
                            game2.cell[i].visible = true;
                            game2.cell[i].loadTexture(
                                "cell" + info[i - 1] + "_f"
                            );
                        }
                        game2.bars[0].visible = false;
                        game2.bars[1].visible = false;
                        game2.bars[2].visible = false;
                        game2.bars[3].visible = false;
                        game2.bars[4].visible = false;
                        checkWin();
                    }
                });
        }

        var briArr = [];
        var briStatus = false;
        var curBri = 0;
        var afterDropFeatureGame = false;
        var wcvFreeSpinWinValuesArray = [];
        console.log(bottomText);

        function checkWin() {
            curBri = 0;
            wlWinValuesArray = [];
            // wcvWinValuesArray = [];
            briArr = [];
            briStatus = false;
            winWithoutCoin = 0;
            for (var i = 1; i <= 15; ++i) {
                game2.copyCell[i].loadTexture("cell" + info[i - 1] + "_f");
            }
            for (key in wlValues) {
                winWithoutCoin = winWithoutCoin + wlValues[key].winValue;
                wlWinValuesArray.push(wlValues[key].lineNumber + 1);
            }
            // for (key in winCellInfo) {
            //     wcvWinValuesArray.push(+(key));
            // }
            for (key in info) {
                if (info[key] === 0) {
                    briStatus = true;
                    briArr.push(+key);
                    countBri = briArr.length;
                }
            }
            afterDropFeatureGame = false;
            if (dataSpinRequest.stateData.isDropFeatureGame) {
                briWinSound.play();
                stopWinAnim = false;
                wcvFreeSpinWinValuesArray = [];
                for (key in info) {
                    if (info[key] === 10 || info[key] === 0) {
                        wcvFreeSpinWinValuesArray.push(+key);
                    }
                }
                showWinFreeSpin(wcvFreeSpinWinValuesArray);
            } else if (wlWinValuesArray.length > 0) {
                stopWinAnim = false;
                updateBalance();
                showWin(wlWinValuesArray, winCellInfo);
                bottomText.setText(allWin + " Credits Won");
                bottomText.fontSize = "35px";
                bottomText.setTextBounds(0, 585, 1024, 100);
            } else {
                lose_freespinsSound.play();
                if (freeSpinCount > 0) {
                    if (briStatus) {
                        briAnim(briArr);
                    } else {
                        setTimeout(function() {
                            freeSpinStart();
                        }, 2500);
                    }
                } else {
                    setTimeout(function() {
                        setTimeout(function() {
                            finishFreespins();
                        }, 2000);
                    }, 2500);
                }
            }
        }

        function showWinFreeSpin(wcvFreeSpinWinValuesArray) {
            console.log(wcvFreeSpinWinValuesArray);
            wcvFreeSpinWinValuesArray.forEach(function(cell, i) {
                squareArrFreespin[cell + 1].visible = true;
            });
            if (afterDropFeatureGame) {
                winText.visible = true;
                winText.setText(
                    "Trigger Pay \n" +
                        payoffByBonus / mulFreespinOld +
                        " x " +
                        mulFreespinOld +
                        " = " +
                        payoffByBonus
                );
            }
            if (!afterDropFeatureGame) {
                bottomText.visible = true;
                bottomText.setText("BONUS RETRIGGERED");

                setTimeout(function() {
                    flickWinFreeSpeen(wcvFreeSpinWinValuesArray);
                }, 1000);
            } else {
                flickWinFreeSpeen(wcvFreeSpinWinValuesArray);
            }
        }

        function flickWinFreeSpeen(wcvFreeSpinWinValuesArray) {
            if (stopWinAnim == true) {
                return;
            }
            wcvFreeSpinWinValuesArray.forEach(function(cell, i) {
                squareArrFreespin[cell + 1].tint = 0xffffff;
            });
            if (afterDropFeatureGame) {
                winText.visible = true;
            }
            setTimeout(function() {
                if (stopWinAnim == true) {
                    wcvFreeSpinWinValuesArray.forEach(function(cell, i) {
                        squareArrFreespin[cell + 1].tint = 0x999999;
                    });
                    return;
                }
                wcvFreeSpinWinValuesArray.forEach(function(cell, i) {
                    squareArrFreespin[cell + 1].tint = 0x999999;
                });
                if (afterDropFeatureGame) {
                    winText.visible = false;
                }
                setTimeout(function() {
                    if (stopWinAnim == true) {
                        return;
                    }
                    wcvFreeSpinWinValuesArray.forEach(function(cell, i) {
                        squareArrFreespin[cell + 1].tint = 0xffffff;
                    });
                    if (afterDropFeatureGame) {
                        winText.visible = true;
                    }
                    setTimeout(function() {
                        if (stopWinAnim == true) {
                            wcvFreeSpinWinValuesArray.forEach(function(
                                cell,
                                i
                            ) {
                                squareArrFreespin[cell + 1].tint = 0x999999;
                            });
                            return;
                        }
                        wcvFreeSpinWinValuesArray.forEach(function(cell, i) {
                            squareArrFreespin[cell + 1].tint = 0x999999;
                        });
                        if (afterDropFeatureGame) {
                            winText.visible = false;
                        }
                        setTimeout(function() {
                            if (stopWinAnim == true) {
                                return;
                            }
                            if (afterDropFeatureGame) {
                                winText.visible = true;
                                if (winWithoutCoin > 0) {
                                    wcvFreeSpinWinValuesArray.forEach(function(
                                        cell,
                                        i
                                    ) {
                                        squareArrFreespin[
                                            cell + 1
                                        ].tint = 0xffffff;
                                        squareArrFreespin[
                                            cell + 1
                                        ].visible = false;
                                    });
                                    showWin(wlWinValuesArray, winCellInfo);
                                } else {
                                    flickWinFreeSpeen(
                                        wcvFreeSpinWinValuesArray
                                    );
                                }
                            } else {
                                wcvFreeSpinWinValuesArray.forEach(function(
                                    cell,
                                    i
                                ) {
                                    squareArrFreespin[cell + 1].visible = false;
                                });
                                console.log("additionalBonus");
                                additionalBonus();
                            }
                        }, 300);
                    }, 600);
                }, 300);
            }, 600);
        }

        function additionalBonus() {
            freesponStartBGAdditionalBonus.visible = true;
            freesponStartBGAdditionalBonus.alpha = 0;

            winText.visible = false;

            const currentPos = mulFreespin - (briArr.length - 1);

            multiplierText.setText(currentPos - 1);
            briMulti.slice(currentPos).forEach(bri => (bri.visible = false));

            game.add
                .tween(freesponStartBGAdditionalBonus)
                .to({ alpha: 1 }, 1000, "Linear", true)
                .onComplete.add(function() {
                    freeSpinCount = freeSpinCount + 12;
                    allFreeSpinCount = allFreeSpinCount + 12;
                    spinsLeft.setText(freeSpinCount);
                    setTimeout(function() {
                        game.add
                            .tween(freesponStartBGAdditionalBonus)
                            .to({ alpha: 0 }, 1000, "Linear", true)
                            .onComplete.add(function() {
                                freesponStartBGAdditionalBonus.visible = false;
                                afterDropFeatureGame = true;
                                showWinFreeSpin(wcvFreeSpinWinValuesArray);
                                setTimeout(function() {
                                    updateBalance();
                                }, 2000);
                            });
                    }, 2500);
                });
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

        function briAnim(briArr) {
            setTimeout(function() {
                setTimeout(function() {
                    briSoundAudio.play();
                }, 400);
                switch (briArr[curBri]) {
                    case 3:
                        firstBri = game.add.sprite(
                            334,
                            296,
                            "bri_big_anim_start"
                        );
                        firstBri.anchor.setTo(0.5, 0.5);
                        firstBri.animations.add("anim", [], 5, true).play();
                        firstBri.scale.x = 0.35;
                        firstBri.scale.y = 0.35;
                        game.add.tween(firstBri.scale).to(
                            {
                                x: 1.2,
                                y: 1.2
                            },
                            900.0,
                            Phaser.Easing.Linear.None,
                            true,
                            0,
                            1000,
                            true
                        );
                        game.add
                            .tween(firstBri)
                            .to(
                                {
                                    x: firstBri.position.x + 94,
                                    y: firstBri.position.y + 204
                                },
                                220 * 3,
                                Phaser.Easing.LINEAR,
                                true
                            )
                            .onComplete.add(function() {
                                game.add
                                    .tween(firstBri)
                                    .to(
                                        {
                                            x: firstBri.position.x + 45,
                                            y: firstBri.position.y + 32
                                        },
                                        50 * 3,
                                        Phaser.Easing.LINEAR,
                                        true
                                    )
                                    .onComplete.add(function() {
                                        game.add
                                            .tween(firstBri)
                                            .to(
                                                {
                                                    x: firstBri.position.x + 48,
                                                    y: firstBri.position.y - 26
                                                },
                                                50 * 3,
                                                Phaser.Easing.LINEAR,
                                                true
                                            )
                                            .onComplete.add(function() {
                                                firstBri.destroy();
                                                animCentrBri();
                                            });
                                    });
                            });
                        break;
                    case 4:
                        firstBri = game.add.sprite(
                            334,
                            296 + 149,
                            "bri_big_anim_start"
                        );
                        firstBri.anchor.setTo(0.5, 0.5);
                        firstBri.animations.add("anim", [], 5, true).play();
                        firstBri.scale.x = 0.35;
                        firstBri.scale.y = 0.35;
                        game.add.tween(firstBri.scale).to(
                            {
                                x: 1.2,
                                y: 1.2
                            },
                            900.0,
                            Phaser.Easing.Linear.None,
                            true,
                            0,
                            1000,
                            true
                        );
                        game.add
                            .tween(firstBri)
                            .to(
                                {
                                    x: firstBri.position.x + 131,
                                    y: firstBri.position.y + 82
                                },
                                150 * 3,
                                Phaser.Easing.LINEAR,
                                true
                            )
                            .onComplete.add(function() {
                                game.add
                                    .tween(firstBri)
                                    .to(
                                        {
                                            x: firstBri.position.x + 100,
                                            y: firstBri.position.y + 0
                                        },
                                        100 * 3,
                                        Phaser.Easing.LINEAR,
                                        true
                                    )
                                    .onComplete.add(function() {
                                        game.add
                                            .tween(firstBri)
                                            .to(
                                                {
                                                    x: firstBri.position.x - 46,
                                                    y: firstBri.position.y - 27
                                                },
                                                50 * 3,
                                                Phaser.Easing.LINEAR,
                                                true
                                            )
                                            .onComplete.add(function() {
                                                firstBri.destroy();
                                                animCentrBri();
                                            });
                                    });
                            });
                        break;
                    case 5:
                        firstBri = game.add.sprite(
                            334,
                            296 + 149 + 149,
                            "bri_big_anim_start"
                        );
                        firstBri.anchor.setTo(0.5, 0.5);
                        firstBri.animations.add("anim", [], 5, true).play();
                        firstBri.scale.x = 0.35;
                        firstBri.scale.y = 0.35;
                        game.add.tween(firstBri.scale).to(
                            {
                                x: 1.2,
                                y: 1.2
                            },
                            900.0,
                            Phaser.Easing.Linear.None,
                            true,
                            0,
                            1000,
                            true
                        );
                        game.add
                            .tween(firstBri)
                            .to(
                                {
                                    x: firstBri.position.x + 225,
                                    y: firstBri.position.y - 61
                                },
                                230 * 3,
                                Phaser.Easing.LINEAR,
                                true
                            )
                            .onComplete.add(function() {
                                game.add
                                    .tween(firstBri)
                                    .to(
                                        {
                                            x: firstBri.position.x + 8,
                                            y: firstBri.position.y - 25
                                        },
                                        20 * 3,
                                        Phaser.Easing.LINEAR,
                                        true
                                    )
                                    .onComplete.add(function() {
                                        game.add
                                            .tween(firstBri)
                                            .to(
                                                {
                                                    x: firstBri.position.x - 50,
                                                    y: firstBri.position.y - 25
                                                },
                                                50 * 3,
                                                Phaser.Easing.LINEAR,
                                                true
                                            )
                                            .onComplete.add(function() {
                                                firstBri.destroy();
                                                animCentrBri();
                                            });
                                    });
                            });
                        break;
                    case 6:
                        firstBri = game.add.sprite(
                            334 + 178,
                            296,
                            "bri_big_anim_start"
                        );
                        firstBri.anchor.setTo(0.5, 0.5);
                        firstBri.animations.add("anim", [], 5, true).play();
                        firstBri.scale.x = 0.35;
                        firstBri.scale.y = 0.35;
                        game.add.tween(firstBri.scale).to(
                            {
                                x: 1.2,
                                y: 1.2
                            },
                            900.0,
                            Phaser.Easing.Linear.None,
                            true,
                            0,
                            1000,
                            true
                        );
                        game.add
                            .tween(firstBri)
                            .to(
                                {
                                    x: firstBri.position.x + 81,
                                    y: firstBri.position.y + 187
                                },
                                200 * 3,
                                Phaser.Easing.LINEAR,
                                true
                            )
                            .onComplete.add(function() {
                                game.add
                                    .tween(firstBri)
                                    .to(
                                        {
                                            x: firstBri.position.x - 52,
                                            y: firstBri.position.y + 33
                                        },
                                        60 * 3,
                                        Phaser.Easing.LINEAR,
                                        true
                                    )
                                    .onComplete.add(function() {
                                        game.add
                                            .tween(firstBri)
                                            .to(
                                                {
                                                    x: firstBri.position.x - 31,
                                                    y: firstBri.position.y - 26
                                                },
                                                40 * 3,
                                                Phaser.Easing.LINEAR,
                                                true
                                            )
                                            .onComplete.add(function() {
                                                firstBri.destroy();
                                                animCentrBri();
                                            });
                                    });
                            });
                        break;
                    case 7:
                        firstBri = game.add.sprite(
                            334 + 178,
                            296 + 149,
                            "bri_big_anim_start"
                        );
                        firstBri.anchor.setTo(0.5, 0.5);
                        firstBri.animations.add("anim", [], 5, true).play();
                        firstBri.scale.x = 0.35;
                        firstBri.scale.y = 0.35;
                        game.add.tween(firstBri.scale).to(
                            {
                                x: 1.2,
                                y: 1.2
                            },
                            900.0,
                            Phaser.Easing.Linear.None,
                            true,
                            0,
                            1000,
                            true
                        );
                        game.add
                            .tween(firstBri)
                            .to(
                                { y: firstBri.position.y + 50 },
                                400,
                                Phaser.Easing.LINEAR,
                                true
                            )
                            .onComplete.add(function() {
                                game.add
                                    .tween(firstBri)
                                    .to(
                                        { y: firstBri.position.y - 50 },
                                        500,
                                        Phaser.Easing.LINEAR,
                                        true
                                    )
                                    .onComplete.add(function() {
                                        firstBri.destroy();
                                        animCentrBri();
                                    });
                            });
                        break;
                    case 8:
                        firstBri = game.add.sprite(
                            334 + 178,
                            296 + 149 + 149,
                            "bri_big_anim_start"
                        );
                        firstBri.anchor.setTo(0.5, 0.5);
                        firstBri.animations.add("anim", [], 5, true).play();
                        firstBri.scale.x = 0.35;
                        firstBri.scale.y = 0.35;
                        game.add.tween(firstBri.scale).to(
                            {
                                x: 1.2,
                                y: 1.2
                            },
                            900.0,
                            Phaser.Easing.Linear.None,
                            true,
                            0,
                            1000,
                            true
                        );
                        game.add
                            .tween(firstBri)
                            .to(
                                {
                                    x: firstBri.position.x - 76,
                                    y: firstBri.position.y - 130
                                },
                                150 * 3,
                                Phaser.Easing.LINEAR,
                                true
                            )
                            .onComplete.add(function() {
                                game.add
                                    .tween(firstBri)
                                    .to(
                                        {
                                            x: firstBri.position.x + 73,
                                            y: firstBri.position.y - 31
                                        },
                                        80 * 3,
                                        Phaser.Easing.LINEAR,
                                        true
                                    )
                                    .onComplete.add(function() {
                                        game.add
                                            .tween(firstBri)
                                            .to(
                                                {
                                                    x: firstBri.position.x + 25,
                                                    y: firstBri.position.y - 25
                                                },
                                                35 * 3,
                                                Phaser.Easing.LINEAR,
                                                true
                                            )
                                            .onComplete.add(function() {
                                                game.add
                                                    .tween(firstBri)
                                                    .to(
                                                        {
                                                            x:
                                                                firstBri
                                                                    .position
                                                                    .x - 25,
                                                            y:
                                                                firstBri
                                                                    .position
                                                                    .y - 25
                                                        },
                                                        35 * 3,
                                                        Phaser.Easing.LINEAR,
                                                        true
                                                    )
                                                    .onComplete.add(function() {
                                                        firstBri.destroy();
                                                        animCentrBri();
                                                    });
                                            });
                                    });
                            });
                        break;
                    case 9:
                        firstBri = game.add.sprite(
                            334 + 178 + 178,
                            296,
                            "bri_big_anim_start"
                        );
                        firstBri.anchor.setTo(0.5, 0.5);
                        firstBri.animations.add("anim", [], 5, true).play();
                        firstBri.scale.x = 0.35;
                        firstBri.scale.y = 0.35;
                        game.add.tween(firstBri.scale).to(
                            {
                                x: 1.2,
                                y: 1.2
                            },
                            900.0,
                            Phaser.Easing.Linear.None,
                            true,
                            0,
                            1000,
                            true
                        );
                        game.add
                            .tween(firstBri)
                            .to(
                                {
                                    x: firstBri.position.x - 94,
                                    y: firstBri.position.y + 204
                                },
                                220 * 3,
                                Phaser.Easing.LINEAR,
                                true
                            )
                            .onComplete.add(function() {
                                game.add
                                    .tween(firstBri)
                                    .to(
                                        {
                                            x: firstBri.position.x - 45,
                                            y: firstBri.position.y + 32
                                        },
                                        50 * 3,
                                        Phaser.Easing.LINEAR,
                                        true
                                    )
                                    .onComplete.add(function() {
                                        game.add
                                            .tween(firstBri)
                                            .to(
                                                {
                                                    x: firstBri.position.x - 48,
                                                    y: firstBri.position.y - 26
                                                },
                                                50 * 3,
                                                Phaser.Easing.LINEAR,
                                                true
                                            )
                                            .onComplete.add(function() {
                                                firstBri.destroy();
                                                animCentrBri();
                                            });
                                    });
                            });
                        break;
                    case 10:
                        firstBri = game.add.sprite(
                            334 + 178 + 178,
                            296 + 149,
                            "bri_big_anim_start"
                        );
                        firstBri.anchor.setTo(0.5, 0.5);
                        firstBri.animations.add("anim", [], 5, true).play();
                        firstBri.scale.x = 0.35;
                        firstBri.scale.y = 0.35;
                        game.add.tween(firstBri.scale).to(
                            {
                                x: 1.2,
                                y: 1.2
                            },
                            900.0,
                            Phaser.Easing.Linear.None,
                            true,
                            0,
                            1000,
                            true
                        );
                        game.add
                            .tween(firstBri)
                            .to(
                                {
                                    x: firstBri.position.x - 131,
                                    y: firstBri.position.y + 82
                                },
                                150 * 3,
                                Phaser.Easing.LINEAR,
                                true
                            )
                            .onComplete.add(function() {
                                game.add
                                    .tween(firstBri)
                                    .to(
                                        {
                                            x: firstBri.position.x - 100,
                                            y: firstBri.position.y + 0
                                        },
                                        100 * 3,
                                        Phaser.Easing.LINEAR,
                                        true
                                    )
                                    .onComplete.add(function() {
                                        game.add
                                            .tween(firstBri)
                                            .to(
                                                {
                                                    x: firstBri.position.x + 46,
                                                    y: firstBri.position.y - 27
                                                },
                                                50 * 3,
                                                Phaser.Easing.LINEAR,
                                                true
                                            )
                                            .onComplete.add(function() {
                                                firstBri.destroy();
                                                animCentrBri();
                                            });
                                    });
                            });
                        break;
                    case 11:
                        firstBri = game.add.sprite(
                            334 + 178 + 178,
                            296 + 149 + 149,
                            "bri_big_anim_start"
                        );
                        firstBri.anchor.setTo(0.5, 0.5);
                        firstBri.animations.add("anim", [], 5, true).play();
                        firstBri.scale.x = 0.35;
                        firstBri.scale.y = 0.35;
                        game.add.tween(firstBri.scale).to(
                            {
                                x: 1.2,
                                y: 1.2
                            },
                            900.0,
                            Phaser.Easing.Linear.None,
                            true,
                            0,
                            1000,
                            true
                        );
                        game.add
                            .tween(firstBri)
                            .to(
                                {
                                    x: firstBri.position.x - 225,
                                    y: firstBri.position.y - 61
                                },
                                230 * 3,
                                Phaser.Easing.LINEAR,
                                true
                            )
                            .onComplete.add(function() {
                                game.add
                                    .tween(firstBri)
                                    .to(
                                        {
                                            x: firstBri.position.x - 8,
                                            y: firstBri.position.y - 25
                                        },
                                        20 * 3,
                                        Phaser.Easing.LINEAR,
                                        true
                                    )
                                    .onComplete.add(function() {
                                        game.add
                                            .tween(firstBri)
                                            .to(
                                                {
                                                    x: firstBri.position.x + 50,
                                                    y: firstBri.position.y - 25
                                                },
                                                50 * 3,
                                                Phaser.Easing.LINEAR,
                                                true
                                            )
                                            .onComplete.add(function() {
                                                firstBri.destroy();
                                                animCentrBri();
                                            });
                                    });
                            });
                        break;
                }
            });
        }

        function animCentrBri() {
            secondBri = game.add.sprite(
                334 + 178,
                296 + 149,
                "bri_big_anim_middle"
            );
            secondBri.anchor.setTo(0.5, 0.5);
            secondBri.animations
                .add("anim", [0, 1, 2, 3, 0, 1, 2, 3], 6, false)
                .play()
                .onComplete.add(function() {
                    secondBri.animations
                        .add("anim", [0, 1, 2, 3, 0, 1, 2, 3], 6, false)
                        .play();
                    const pos = mulFreespin - (countBri - 1);

                    console.log(pos, countBri, "brii");

                    let secondBriX = -(77 - 11 * ((pos + 1) % 10));
                    game.add
                        .tween(secondBri)
                        .to(
                            {
                                x: 512 + secondBriX,
                                y: 435
                            },
                            Math.abs(secondBriX) * 2,
                            Phaser.Easing.LINEAR,
                            true
                        )
                        .onComplete.add(function() {
                            secondBri.destroy();
                            thirdBri = game.add.sprite(
                                334 + 178 + secondBriX,
                                435,
                                "bri_big_anim_finish"
                            );
                            thirdBri.anchor.setTo(0.5, 0.5);
                            thirdBri.scale.x = 1.2;
                            thirdBri.scale.y = 1.2;
                            thirdBri.animations.add("anim", [], 7, true).play();
                            let longX;
                            let longY = 171;

                            if (pos % 10 !== 0) {
                                longX = 189 + 44 * (pos % 10);
                            } else {
                                longX = 189;
                            }
                            game.add
                                .tween(thirdBri.scale)
                                .to(
                                    { x: 0.14, y: 0.14 },
                                    900,
                                    Phaser.Easing.LINEAR,
                                    true
                                );
                            game.add
                                .tween(thirdBri)
                                .to(
                                    {
                                        x: longX,
                                        y: longY
                                    },
                                    900,
                                    Phaser.Easing.LINEAR,
                                    true
                                )
                                .onComplete.add(function() {
                                    thirdBri.destroy();
                                    if (pos % 10 === 0) {
                                        multiBriText.visible = true;
                                        multiBriText.setText(pos);
                                        for (let i = 1; i <= 9; ++i) {
                                            briMulti[i].visible = false;
                                            briMulti[10].visible = true;
                                        }
                                    } else {
                                        briMulti[pos % 10].visible = true;
                                    }

                                    multiplierText.setText(pos);
                                    multiplierText.visible = false;
                                    countBri--;
                                    freeSpinMulti.play();
                                    setTimeout(function() {
                                        multiplierText.visible = true;
                                        setTimeout(function() {
                                            multiplierText.visible = false;
                                            setTimeout(function() {
                                                multiplierText.visible = true;
                                                setTimeout(function() {
                                                    multiplierText.visible = false;
                                                    setTimeout(function() {
                                                        multiplierText.visible = true;
                                                        setTimeout(function() {
                                                            multiplierText.visible = false;
                                                            setTimeout(
                                                                function() {
                                                                    multiplierText.visible = true;
                                                                    setTimeout(
                                                                        function() {
                                                                            multiplierText.visible = false;
                                                                            setTimeout(
                                                                                function() {
                                                                                    multiplierText.visible = true;
                                                                                    if (
                                                                                        briArr.length ===
                                                                                        curBri +
                                                                                            1
                                                                                    ) {
                                                                                        setTimeout(
                                                                                            function() {
                                                                                                if (
                                                                                                    freeSpinCount >
                                                                                                    0
                                                                                                ) {
                                                                                                    freeSpinStart();
                                                                                                }
                                                                                            },
                                                                                            200
                                                                                        );
                                                                                    } else {
                                                                                        curBri =
                                                                                            curBri +
                                                                                            1;
                                                                                        briAnim(
                                                                                            briArr
                                                                                        );
                                                                                    }
                                                                                },
                                                                                200
                                                                            );
                                                                        },
                                                                        200
                                                                    );
                                                                },
                                                                200
                                                            );
                                                        }, 200);
                                                    }, 200);
                                                }, 200);
                                            }, 200);
                                        }, 200);
                                    }, 10);
                                });
                        });
                });
        }

        var sizeLine = 0;

        function showWin(wlWinValuesArray, winCellInfo) {
            multiStatus = false;
            if (stopWinAnim == true) {
                return;
            }
            winText.visible = true;
            if (!dataSpinRequest.stateData.isDropFeatureGame) {
                bottomText.setText(allWin + " Credits Won");
                bottomText.fontSize = "35px";
                bottomText.setTextBounds(0, 585, 1024, 100);
            }
            winText.setText(
                "Line Pay \n" +
                    wlValues[lineflash].winValue / mulFreespinOld +
                    " x " +
                    mulFreespinOld +
                    " = " +
                    wlValues[lineflash].winValue
            );
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

            if (stopWinAnim == true) {
                return;
            }

            showLine(wlWinValuesArray[lineflash]);
            for (var i = 1; i <= sizeLine; ++i) {
                // game.add
                //     .tween(squareArrImg[wlWinValuesArray[lineflash] - 1][i - 1])
                //     .to({ alpha: 1 }, 100, Phaser.Easing.LINEAR, true)
                //     .onComplete.add(function() {});
                squareArrImg[wlWinValuesArray[lineflash] - 1][
                    i - 1
                ].visible = true;

                game2.copyCell[
                    squareArr[wlWinValuesArray[lineflash] - 1][i - 1]
                ].visible = true;
            }

            flickLine(sizeLine, wlWinValuesArray[lineflash]);
        }

        function changeBorderColor(lineNumber, tint) {
            game2.lineArr[lineNumber].tint = tint;
            for (var i = 1; i <= sizeLine; ++i) {
                squareArrImg[lineNumber - 1][i - 1].tint = tint;
            }
        }

        function lastIndication(wlWinValuesArray, lineNumber) {
            if (stopWinAnim == true) {
                return;
            }
            game2.lineArr[lineNumber].tint = 0xffffff;
            for (var i = 1; i <= sizeLine; ++i) {
                squareArrImg[lineNumber - 1][i - 1].tint = 0xffffff;
            }
            winText.visible = true;

            if (lineflash === wlWinValuesArray.length - 1) {
                firstAroundAnim = false;
                lineflash = 0;
            } else {
                lineflash = lineflash + 1;
            }

            if (wlWinValuesArray.length === 1) {
                hideLines();
                hideSquare();

                if (lineflash === 0) {
                    if (dataSpinRequest.stateData.isDropFeatureGame) {
                        showWinFreeSpin(wcvFreeSpinWinValuesArray);
                    } else {
                        showWin(wlWinValuesArray, winCellInfo);
                    }
                } else {
                    showWin(wlWinValuesArray, winCellInfo);
                }
            } else {
                hideLines();
                hideSquare();
                // setTimeout(() => {
                for (var i = 1; i <= sizeLine; ++i) {
                    game2.copyCell[
                        squareArr[lineNumber - 1][i - 1]
                    ].visible = false;
                }
                // }, 200);
                setTimeout(() => {
                    if (lineflash === 0) {
                        if (dataSpinRequest.stateData.isDropFeatureGame) {
                            showWinFreeSpin(wcvFreeSpinWinValuesArray);
                        } else {
                            showWin(wlWinValuesArray, winCellInfo);
                        }
                    } else {
                        showWin(wlWinValuesArray, winCellInfo);
                    }
                }, 0);
            }
        }

        function flickLine(sizeLine, lineNumber) {
            let isLightBorder = true;
            let index = 0;

            (async () => {
                while (index < 4) {
                    if (stopWinAnim == true) {
                        return;
                    }

                    winText.visible = isLightBorder;

                    await delay(isLightBorder ? 600 : 300);
                    index === 3
                        ? lastIndication(wlWinValuesArray, lineNumber)
                        : changeBorderColor(
                              lineNumber,
                              isLightBorder ? 0x999999 : 0xffffff
                          );
                    isLightBorder = !isLightBorder;

                    index++;
                }
            })();
        }

        function upLines() {
            lines = lines + 1;
            if (lines > 15) {
                lines = 1;
                hideLinesCircle();
                hideLinesCircleText();
            }
            hideLines();
            showLine(lines);
            showLineCircle(lines);
            showLineCircleText(lines);
            bet = lines * betline;
            linesText.setText(lines);
            totalBet.setText(bet);
        }

        function upLinesBet() {
            betline = betline + 1;
            if (betline > 10) {
                betline = 1;
            }
            for (var i = 1; i <= 15; ++i) {
                game2.textArr[i].setText(betline);
            }
            bet = lines * betline;
            lineBetText.setText(betline);
            totalBet.setText(bet);
        }

        console.log(mulFreespin);

        function addScore() {
            credit = game.add.text(214, 664, balance, {
                font: '47px "Digital-7 Mono"',
                fill: "#01e033"
            });
            credit.anchor.setTo(1, 0.5);
            linesText = game.add.text(536, 664, lines, {
                font: '47px "Digital-7 Mono"',
                fill: "#01e033"
            });
            linesText.anchor.setTo(1, 0.5);
            lineBetText = game.add.text(666, 664, betline, {
                font: '47px "Digital-7 Mono"',
                fill: "#01e033"
            });
            lineBetText.anchor.setTo(1, 0.5);
            totalBet = game.add.text(812, 664, bet, {
                font: '47px "Digital-7 Mono"',
                fill: "#01e033"
            });
            totalBet.anchor.setTo(1, 0.5);
            paid = game.add.text(992, 664, "0", {
                font: '47px "Digital-7 Mono"',
                fill: "#01e033"
            });
            paid.anchor.setTo(1, 0.5);
            winText = game.add.text(150, 608 + 94, "Trigger Pay \n40", {
                font: '22px "Arial"',
                fill: "#ffffff",
                fontWeight: 600,
                align: "center"
            });

            winText.lineSpacing = -10;
            winText.anchor.setTo(0.5, 0.5);
            winText.visible = false;
            bonusWinText = game.add.text(512, 602 + 94, "BONUS WON 240", {
                font: '25px "Fixedsys Excelsior 3.01"',
                fill: "#ff4921"
            });
            bonusWinText.anchor.setTo(0.5, 0.5);
            bonusWinText.visible = false;
            gameStatusText = game.add.text(894, 598 + 94, "Play 400 Credits", {
                font: '22px "Arial"',
                fill: "#ffffff",
                fontWeight: 600
            });
            gameStatusText.anchor.setTo(0.5, 0.5);
            gameStatusText.visible = false;

            collect_text = game.add.text(
                510,
                342 + 94,
                "HAND PAY 25585 CREDITS",
                {
                    font: '35px "PF Agora Slab Pro"',
                    fill: "#fffc15"
                }
            );
            collect_text.anchor.setTo(0.5, 0.5);
            collect_text.visible = false;
            // bottomText = game.add.text(512, 610, "BONUS!", {
            bottomText = game.add.text(0, 0, "BONUS!", {
                font: '35px "Arial"',
                fill: "#fffd6f",
                stroke: "#000000",
                strokeThickness: 5,
                fontWeight: 800,
                boundsAlignH: "center"
            });
            bottomText.setTextBounds(0, 585, 1024, 100);
            // bottomText.anchor.setTo(0.5, 0.5);
            spinsLeft = game.add.text(194 - 238, 38, freeSpinCount, {
                font: '45px "ArialMT-CondensedBold"',
                fill: "#ffffff"
            });
            spinsLeft.anchor.setTo(1, 0.5);
            bonusText = game.add.text(1006 + 244, 38, allWinOld, {
                font: '45px "ArialMT-CondensedBold"',
                fill: "#ffffff"
            });
            bonusText.anchor.setTo(1, 0.5);
            multiplierText = game.add.text(860, 172 - 204, mulFreespin, {
                font: '45px "ArialMT-CondensedBold"',
                fill: "#ffffff"
            });
            multiplierText.anchor.setTo(1, 0.5);
            multiBriText = game.add.text(192, 170, "10", {
                font: '30px "PragmaticaBoldCyrillic"',
                fill: "#ffffff",
                stroke: "#000000",
                strokeThickness: 6
            });

            multiBriText.anchor.setTo(0.5, 0.5);
            multiBriText.visible = false;
        }

        var helpPageCurent = 1;
        var paytablePageCurent = 1;

        function addPaytable() {
            help_page = game.add.sprite(0, 0, "help_page_1");
            help_page.visible = false;
            paytable_page = game.add.sprite(0, 0, "paytable_page_1");
            paytable_page.visible = false;
            return_to_game = game.add.sprite(883, 506, "return");
            return_to_game.inputEnabled = true;
            return_to_game.input.useHandCursor = true;
            return_to_game.events.onInputDown.add(function(click, pointer) {
                if (pointer.button !== 0 && pointer.button !== undefined)
                    return;
                return_to_game.loadTexture("return_p");
            });
            return_to_game.events.onInputUp.add(function(click, pointer) {
                if (pointer.button !== 0 && pointer.button !== undefined)
                    return;
                return_to_game.loadTexture("return");
                help_page.visible = false;
                paytable_page.visible = false;
                help_next.visible = false;
                paytable_next.visible = false;
                return_to_game.visible = false;
                showButtons();
            });
            return_to_game.visible = false;
            help_next = game.add.sprite(883, 85, "moreHelp");
            help_next.inputEnabled = true;
            help_next.input.useHandCursor = true;
            help_next.events.onInputDown.add(function(click, pointer) {
                if (pointer.button !== 0 && pointer.button !== undefined)
                    return;
                help_next.loadTexture("moreHelp_p");
            });
            help_next.events.onInputUp.add(function(click, pointer) {
                if (pointer.button !== 0 && pointer.button !== undefined)
                    return;
                help_next.loadTexture("moreHelp");
                nextHelp(helpPageCurent);
            });
            help_next.visible = false;
            paytable_next = game.add.sprite(883, 85, "moreHelp");
            paytable_next.inputEnabled = true;
            paytable_next.input.useHandCursor = true;
            paytable_next.events.onInputDown.add(function(click, pointer) {
                if (pointer.button !== 0 && pointer.button !== undefined)
                    return;
                paytable_next.loadTexture("moreHelp_p");
            });
            paytable_next.events.onInputUp.add(function(click, pointer) {
                if (pointer.button !== 0 && pointer.button !== undefined)
                    return;
                paytable_next.loadTexture("moreHelp");
                nextPaytable(paytablePageCurent);
            });
            paytable_next.visible = false;
        }

        function nextHelp(value) {
            helpPageCurent = helpPageCurent + 1;
            if (helpPageCurent > 3) {
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

        function hideButtons(buttonsArray) {
            if (buttonsArray === undefined) {
                buttonsArray = [];
            }
            if (buttonsArray.length == 0) {
                paytable.inputEnabled = false;
                paytable.input.useHandCursor = false;
                paytable.visible = false;
                collect.inputEnabled = false;
                collect.input.useHandCursor = false;
                collect.visible = false;
                help.inputEnabled = false;
                help.input.useHandCursor = false;
                help.visible = false;
                selectLines.inputEnabled = false;
                selectLines.input.useHandCursor = false;
                selectLines.visible = false;
                betPerLine.inputEnabled = false;
                betPerLine.input.useHandCursor = false;
                betPerLine.visible = false;
                startButton.inputEnabled = false;
                startButton.input.useHandCursor = false;
                startButton.visible = false;
                maxBetSpin.inputEnabled = false;
                maxBetSpin.input.useHandCursor = false;
                maxBetSpin.visible = false;
            } else {
                buttonsArray.forEach(function(item) {
                    item[0].inputEnabled = false;
                    item[0].input.useHandCursor = false;
                });
            }
        }

        function showButtons(buttonsArray) {
            if (buttonsArray === undefined) {
                buttonsArray = [];
            }
            if (buttonsArray.length == 0) {
                paytable.inputEnabled = true;
                paytable.input.useHandCursor = true;
                paytable.visible = true;
                collect.inputEnabled = true;
                collect.input.useHandCursor = true;
                collect.visible = true;
                help.inputEnabled = true;
                help.input.useHandCursor = true;
                help.visible = true;
                selectLines.inputEnabled = true;
                selectLines.input.useHandCursor = true;
                selectLines.visible = true;
                betPerLine.inputEnabled = true;
                betPerLine.input.useHandCursor = true;
                betPerLine.visible = true;
                startButton.inputEnabled = true;
                startButton.input.useHandCursor = true;
                startButton.visible = true;
                maxBetSpin.inputEnabled = true;
                maxBetSpin.input.useHandCursor = true;
                maxBetSpin.visible = true;
            } else {
                buttonsArray.forEach(function(item) {
                    item[0].inputEnabled = true;
                    item[0].input.useHandCursor = true;
                });
            }
        }

        var allwinUpd = 0;
        game2.ticker = game.add.tileSprite(0, 799, 1154, 31, "ticker");

        function updateBalance() {
            var x = 0;
            var interval;
            allwinUpd = allWin + payoffByBonus;
            balanceSongAudio.play();
            balanceUpdateStatus2 = true;
            (function() {
                if (x < allwinUpd) {
                    interval = 1000 / 20;
                    if (allwinUpd > 10000) {
                        x += 100;
                    } else if (allwinUpd > 1000) {
                        x += 10;
                    } else {
                        x += 2;
                    }
                    bonusText.setText(allWinOld + x);
                    if (balanceUpdateStatus2 === false) {
                        x = allwinUpd;
                    }

                    setTimeout(arguments.callee, interval);
                } else {
                    balanceUpdateStatus2 = false;
                    balanceSongAudio.stop();
                    updateFinishSound.play();
                    allWinOld = allWinOld + allwinUpd;
                    bonusText.setText(allWinOld);
                    setTimeout(function() {
                        if (freeSpinCount > 0) {
                            if (briStatus) {
                                bottomText.visible = true;
                                briAnim(briArr);
                            } else {
                                freeSpinStart();
                            }
                        } else {
                            finishFreespins();
                        }
                    }, 2000);
                }
            })();
        }

        function updateFinishBalance() {
            var x = 0;
            var interval;
            allwinUpd = allWinOld;
            balanceSongAudio.play();
            balanceUpdateStatus2 = true;
            (function() {
                if (x < allwinUpd) {
                    interval = 1000 / 20;
                    if (allwinUpd > 10000) {
                        x += 100;
                    } else if (allwinUpd > 5000) {
                        x += 25;
                    } else if (allwinUpd > 1000) {
                        x += 10;
                    } else {
                        x += 2;
                    }
                    bonusText.setText(allWinOld - x);
                    credit.setText(balance + x);
                    paid.setText(x);
                    winTextCenter.setText(x);
                    if (balanceUpdateStatus2 === false) {
                        x = allwinUpd;
                    }
                    setTimeout(arguments.callee, interval);
                } else {
                    balanceUpdateStatus2 = false;
                    balanceSongAudio.stop();
                    updateFinishSound.play();
                    bonusText.setText(0);
                    credit.setText(balance + allWinOld);
                    balanceOld = balance;
                    balance = balance + allWinOld;
                    paid.setText(allWinOld);
                    winTextCenter.setText(allWinOld);
                    bottomText.visible = false;
                    setTimeout(function() {
                        freeSpinBgSong.stop();
                        briFinishSound.play();
                        closeFreespins();
                    }, 2000);
                }
            })();
        }

        function closeFreespins() {
            setTimeout(function() {
                winTextCenter.visible = false;
                createdStarsStatus = false;
                createdStarsMiniStatus = false;
                game.add
                    .tween(freespinStartBG)
                    .to({ alpha: 0 }, 1000, "Linear", true)
                    .onComplete.add(function() {
                        big_red_border.visible = false;
                        freesponFinishBGText.visible = false;
                        briLeft.visible = false;
                        briRight.visible = false;
                        moveBgOnTop();
                        setTimeout(function() {
                            afterFreespinStatus = true;
                            game.state.start("game1");
                        }, 1000);
                    });
            }, 1000);
        }

        function finishFreespins() {
            stopWinAnim = true;
            hideLines();
            hideSquare();

            for (var i = 1; i <= 15; ++i) {
                game2.copyCell[i].visible = false;
            }

            for (var i = 1; i <= 15; ++i) {
                squareArrFreespin[i].visible = false;
                squareArrFreespin[i].tint = 0xffffff;
            }
            winText.visible = false;
            bottomText.visible = false;
            eventId.visible = false;

            freesponFinishBGText.visible = true;

            briLeft = game.add.sprite(123, 475, "bri_anim_freespin");
            briLeft.animations.add("anim", [], 8, true).play();
            briRight = game.add.sprite(784, 475, "bri_anim_freespin");
            briRight.animations.add("anim", [], 8, true).play();

            game.add
                .tween(freespinStartBG)
                .to({ alpha: 1 }, 1000, "Linear", true)
                .onComplete.add(function() {
                    winTextCenter = game.add.text(514, 535, "0", {
                        font: '99px "AmazoneBT-Regular"',
                        fill: "#ff4921",
                        stroke: "#000000",
                        strokeThickness: 6
                    });
                    winTextCenter.anchor.setTo(0.5, 0.5);
                    var grd = winTextCenter.context.createLinearGradient(
                        0,
                        0,
                        0,
                        winTextCenter.height
                    );

                    grd.addColorStop(0, "#ff7e00");
                    grd.addColorStop(0.44, "#fff600");
                    grd.addColorStop(0.48, "#ffffcc");
                    grd.addColorStop(0.52, "#fff600");
                    grd.addColorStop(1, "#ff7e00");

                    winTextCenter.fill = grd;
                    for (var i = 1; i <= 15; ++i) {
                        game2.cell[i].loadTexture("cell" + infoOld[i - 1]);
                    }

                    updateFinishBalance();
                });
        }

        function moveBgOnTop() {
            for (var i = 1; i <= 15; ++i) {
                moveElementFromBottom(game2.cell[i]);
            }
            for (var i = 1; i <= 20; ++i) {
                moveElementFromBottom(game2.circleArr[i]);
                moveElementFromBottom(game2.textArr[i]);
            }
            for (var i = 1; i <= 10; ++i) {
                moveElementFromCenter(briMulti[i]);
            }
            moveElementFromBottom(bg_overlay2);
            moveElementFromBottom(bg2_panels);
            moveElementFromBottom(freespinStartBG);
            moveElementFromBottom(big_red_border);
            moveElementFromBottom(bottomText);
            moveElementFromBottom(credit);
            moveElementFromBottom(linesText);
            moveElementFromBottom(lineBetText);
            moveElementFromBottom(totalBet);
            moveElementFromBottom(paid);
            moveElementFromCenter(multiplier);
            moveElementFromCenter(multiplierText);
            moveElementFromCenter(multiBriText);
            moveElementFromLeftSide(spins_remaining);
            moveElementFromLeftSide(spinsLeft);
            moveElementFromRightSide(bonus);
            moveElementFromRightSide(bonusText);
        }

        function moveElementFromBottom(elem) {
            game.add
                .tween(elem)
                .to({ y: elem.position.y - 94 }, 500, "Linear", true);
        }

        function moveElementFromCenter(elem) {
            game.add
                .tween(elem)
                .to({ y: elem.position.y - 204 }, 500, "Linear", true);
        }

        function moveElementFromLeftSide(elem) {
            game.add
                .tween(elem)
                .to({ x: elem.position.x - 238 }, 500, "Linear", true);
        }

        function moveElementFromRightSide(elem) {
            game.add
                .tween(elem)
                .to({ x: elem.position.x + 244 }, 500, "Linear", true);
        }

        $("canvas").mouseup(function(e) {
            if (curGame === 2) {
                if (balanceUpdateStatus2) {
                    balanceUpdateStatus2 = false;
                }
            }
        });

        $("canvas").on("touchend", function(e) {
            if (curGame === 2) {
                if (balanceUpdateStatus2) {
                    balanceUpdateStatus2 = false;
                }
            }
        });
    };

    game2.update = function() {
        if (cursorAnimSprite !== null) {
            cursorAnimSprite.position.x = game.input.x;
            cursorAnimSprite.position.y = game.input.y;
        }
        if (game2.spinStatus1) {
            game2.bars[0].tilePosition.y += 40;
        }
        if (game2.spinStatus2) {
            game2.bars[1].tilePosition.y += 40;
        }
        if (game2.spinStatus3) {
            game2.bars[2].tilePosition.y += 40;
        }
        if (game2.spinStatus4) {
            game2.bars[3].tilePosition.y += 40;
        }
        if (game2.spinStatus5) {
            game2.bars[4].tilePosition.y += 40;
        }
        game2.ticker.tilePosition.x += 0.5;
    };

    game.state.add("game2", game2);
}
