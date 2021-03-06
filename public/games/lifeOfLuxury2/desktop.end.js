let errorImage = {},
    errorAudio = {},
    errorSpritesheet = {},
    errorTextureatlas = {};

const loadResource = () => {
    var needUrlPath = "";
    if (
        location.href.indexOf("/games/") !== -1 &&
        location.href.indexOf("public") !== -1
    ) {
        needUrlPath =
            location.href.substring(0, location.href.indexOf("://")) +
            "://" +
            location.hostname +
            location.pathname;
    } else if (location.href.indexOf("/game/") !== -1) {
        var gamename = location.href.substring(
            location.href.indexOf("/game/") + 6
        );
        needUrlPath =
            location.href.substring(0, location.href.indexOf("/game/")) +
            "/games/" +
            gamename;
    } else if (
        location.href.indexOf("public") === -1 &&
        location.href.indexOf("/games/") !== -1
    ) {
        needUrlPath = location.href.substring(0, location.href.indexOf("?"));
    }

    if (location.href.indexOf("slotgames") !== -1) {
        var gamename = location.href.substring(
            location.href.indexOf("/games/") + 7
        );
        needUrlPath = "http://slotgames/games/lifeOfLuxury2";
    }

    var part2Url = "";
    if (location.href.indexOf("ezsl.tk") !== -1) {
        var gamename = location.href.substring(
            location.href.indexOf("/games/") + 7
        );
        gamename = gamename.substring(0, gamename.indexOf("/?"));
        //part2Url = location.href.substring(location.href.indexOf('?'));
        part2Url = "";
        needUrlPath = "http://ezsl.tk/games/lifeOfLuxury2";
    }
    if (location.href.indexOf("playgames.devbet.live") !== -1) {
        var gamename = location.href.substring(
            location.href.indexOf("/games/") + 7
        );
        gamename = gamename.substring(0, gamename.indexOf("/?"));
        part2Url = "";
        needUrlPath = "https://playgames.devbet.live/games/" + gamename;
    }
    if (location.href.indexOf("game.play777games.com") !== -1) {
        var gamename = location.href.substring(
            location.href.indexOf("/games/") + 7
        );
        gamename = gamename.substring(0, gamename.indexOf("/?"));
        var part2Url = location.href.substring(location.href.indexOf("?"));
        needUrlPath = "https://game.play777games.com/games/" + gamename;
    }
    path = needUrlPath;
    if (game.sound.usingWebAudio && game.sound.context.state === "suspended") {
        game.input.onTap.addOnce(game.sound.context.resume, game.sound.context);
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
    game.load.image("game.background", "" + path + "/img/bg.png" + part2Url);
    game.load.image("game.background2", "" + path + "/img/bg2.jpg" + part2Url);
    game.load.image("game.background3", "" + path + "/img/bg3.png" + part2Url);
    game.load.image(
        "background2_panels",
        "" + path + "/img/bg2_panels.png" + part2Url
    );
    game.load.image(
        "game.background_overlay",
        "" + path + "/img/bg_overlay.png" + part2Url
    );
    game.load.image(
        "game.background_overlay2",
        "" + path + "/img/bg_overlay2.png" + part2Url
    );
    game.load.image("bonus", "" + path + "/img/bonus.png" + part2Url);
    game.load.image("multiplier", "" + path + "/img/Multiplier.png" + part2Url);
    game.load.image(
        "spins_remaining",
        "" + path + "/img/spins_remaining.png" + part2Url
    );
    game.load.image("black_bg", path + "/img/black_bg.jpg" + part2Url);
    game.load.image("black_bg2", path + "/img/black_bg2.jpg" + part2Url);
    game.load.image("error_bg", path + "/img/error_bg.jpg" + part2Url);
    game.load.image(
        "session_bg",
        needUrlPath + "/img/session_bg.jpg" + part2Url
    );
    game.load.image(
        "establishing_bg",
        needUrlPath + "/img/establishing_bg.jpg" + part2Url
    );
    game.load.image("btn_yes", path + "/img/btn_yes.jpg" + part2Url);
    game.load.image("btn_no", path + "/img/btn_no.jpg" + part2Url);

    game.load.image("emptyCell", "" + path + "/img/100.jpg" + part2Url);
    for (let i = 0; i <= 10; ++i) {
        game.load.image(
            "cell" + i,
            needUrlPath + "/img/" + i + ".jpg" + part2Url
        );
        game.load.image(
            "cell" + i + "_f",
            needUrlPath + "/img/" + i + "_f.jpg" + part2Url
        );
    }

    game.load.image(
        "freespinStartBG",
        "" + path + "/img/freesponStartBG.jpg" + part2Url
    );
    game.load.image(
        "freesponStartBGAdditionalBonus",
        "" + path + "/img/freesponStartBGAdditionalBonus.jpg" + part2Url
    );
    game.load.image(
        "freesponFinishBGText",
        "" + path + "/img/freesponFinishBGText.png" + part2Url
    );
    game.load.image(
        "freesponStartBGText",
        "" + path + "/img/freesponStartBGText.png" + part2Url
    );
    game.load.image(
        "top_bottom_label_1",
        "" + path + "/img/top_bottom_label_1.png" + part2Url
    );
    game.load.image(
        "top_bottom_label_2",
        "" + path + "/img/top_bottom_label_2.png" + part2Url
    );
    game.load.image(
        "top_label_1",
        "" + path + "/img/top_label_1.png" + part2Url
    );
    game.load.image(
        "top_label_2",
        "" + path + "/img/top_label_2.png" + part2Url
    );
    game.load.image(
        "top_label_3",
        "" + path + "/img/top_label_3.png" + part2Url
    );
    game.load.image(
        "top_label_4",
        "" + path + "/img/top_label_4.png" + part2Url
    );

    game.load.image("collect", "" + path + "/img/btns/Collect.png" + part2Url);
    game.load.image(
        "collect_p",
        "" + path + "/img/btns/Collect_p.png" + part2Url
    );
    game.load.image("help", "" + path + "/img/btns/Help.png" + part2Url);
    game.load.image("help_p", "" + path + "/img/btns/Help_p.png" + part2Url);
    game.load.image(
        "paytable",
        "" + path + "/img/btns/Pay Table.png" + part2Url
    );
    game.load.image(
        "paytable_p",
        "" + path + "/img/btns/Pay Table_p.png" + part2Url
    );

    game.load.image("bar", "" + path + "/img/bar.jpg" + part2Url);
    game.load.image("bar2", "" + path + "/img/bar2.jpg" + part2Url);
    game.load.image("ticker", needUrlPath + "/img/ticker.jpg" + part2Url);

    game.load.image(
        "stopButton",
        "" + path + "/img/btns/Stop Reels.png" + part2Url
    );
    game.load.image(
        "startButton",
        "" + path + "/img/btns/Spin Reels.png" + part2Url
    );
    game.load.image(
        "startButton_p",
        "" + path + "/img/btns/Spin Reels_p.png" + part2Url
    );
    game.load.image(
        "betPerLine",
        "" + path + "/img/btns/Bet Per Line.png" + part2Url
    );
    game.load.image(
        "betPerLine_p",
        "" + path + "/img/btns/Bet Per Line_p.png" + part2Url
    );
    game.load.image(
        "maxBetSpin",
        "" + path + "/img/btns/Max Bet Spin.png" + part2Url
    );
    game.load.image(
        "maxBetSpin_p",
        "" + path + "/img/btns/Max Bet Spin_p.png" + part2Url
    );
    game.load.image(
        "selectLines",
        "" + path + "/img/btns/Select Lines.png" + part2Url
    );
    game.load.image(
        "selectLines_p",
        "" + path + "/img/btns/Select Lines_p.png" + part2Url
    );
    game.load.image("Next", "" + path + "/img/btns/Next.png" + part2Url);
    game.load.image("Next_p", "" + path + "/img/btns/Next_p.png" + part2Url);
    game.load.image("Prev", "" + path + "/img/btns/Prev.png" + part2Url);
    game.load.image("Prev_p", "" + path + "/img/btns/Prev_p.png" + part2Url);

    game.load.image("return", "" + path + "/img/btns/Return.png" + part2Url);
    game.load.image(
        "return_p",
        "" + path + "/img/btns/Return_p.png" + part2Url
    );
    game.load.image("exit", "" + path + "/img/btns/Exit.png" + part2Url);
    game.load.image("exit_p", "" + path + "/img/btns/Exit_p.png" + part2Url);
    game.load.image(
        "addCredit",
        "" + path + "/img/btns/addCredit.png" + part2Url
    );
    game.load.image(
        "addCredit_p",
        "" + path + "/img/btns/addCredit_p.png" + part2Url
    );
    game.load.image(
        "autoPlay",
        "" + path + "/img/btns/Auto Play.png" + part2Url
    );
    game.load.image(
        "autoPlay_p",
        "" + path + "/img/btns/Auto Play_p.png" + part2Url
    );
    game.load.image(
        "autoStop",
        "" + path + "/img/btns/Auto Stop.png" + part2Url
    );
    game.load.image(
        "autoStop_p",
        "" + path + "/img/btns/Auto Stop_p.png" + part2Url
    );
    for (var i = 1; i <= 20; ++i) {
        game.load.image(
            "circleLine_" + i,
            "" + path + "/img/lines/circle/" + i + ".png" + part2Url
        );
        game.load.image(
            "line_" + i,
            "" + path + "/img/lines/lines/" + i + ".png" + part2Url
        );
        game.load.image(
            "square_" + i,
            "" + path + "/img/lines/square/square_" + i + ".png" + part2Url
        );
    }
    game.load.image(
        "help_page_1",
        "" + path + "/img/help_page_1.jpg" + part2Url
    );
    game.load.image(
        "help_page_2",
        "" + path + "/img/help_page_2.jpg" + part2Url
    );
    game.load.image(
        "help_page_3",
        "" + path + "/img/help_page_3.jpg" + part2Url
    );
    game.load.image(
        "help_page_4",
        "" + path + "/img/help_page_4.jpg" + part2Url
    );
    game.load.image(
        "paytable_page_1",
        "" + path + "/img/paytable_page_1.jpg" + part2Url
    );
    game.load.image(
        "paytable_page_2",
        "" + path + "/img/paytable_page_2.jpg" + part2Url
    );
    game.load.image(
        "paytable_page_3",
        "" + path + "/img/paytable_page_3.jpg" + part2Url
    );
    game.load.image(
        "paytable_page_4",
        "" + path + "/img/paytable_page_4.jpg" + part2Url
    );
    game.load.image(
        "paytable_page_5",
        "" + path + "/img/paytable_page_5.jpg" + part2Url
    );
    game.load.image(
        "paytable_page_6",
        "" + path + "/img/paytable_page_6.jpg" + part2Url
    );

    game.load.image("bg_bri", "" + path + "/img/bg_bri.png" + part2Url);
    game.load.image("little_bri", "" + path + "/img/little_bri.png" + part2Url);
    game.load.image("medium_bri", "" + path + "/img/medium_bri.png" + part2Url);
    game.load.image("first_bri", "" + path + "/img/first_bri.png" + part2Url);
    game.load.image("blue_field", "" + path + "/img/blue_field.png" + part2Url);

    game.load.audio(
        "coin1",
        needUrlPath + "/sounds/coins/coin1.mp3" + part2Url
    );
    game.load.audio(
        "coin2",
        needUrlPath + "/sounds/coins/coin2.mp3" + part2Url
    );
    game.load.audio(
        "coin3",
        needUrlPath + "/sounds/coins/coin3.mp3" + part2Url
    );
    game.load.audio(
        "coin4",
        needUrlPath + "/sounds/coins/coin4.mp3" + part2Url
    );
    game.load.audio(
        "coin5",
        needUrlPath + "/sounds/coins/coin5.mp3" + part2Url
    );
    game.load.audio(
        "finishSpin",
        needUrlPath + "/sounds/finishSpin.mp3" + part2Url
    );
    game.load.audio(
        "finishSpin1",
        needUrlPath + "/sounds/finishSpin1.mp3" + part2Url
    );
    game.load.audio(
        "finishSpin2",
        needUrlPath + "/sounds/finishSpin2.mp3" + part2Url
    );
    game.load.audio(
        "finishSpin3",
        needUrlPath + "/sounds/finishSpin3.mp3" + part2Url
    );
    game.load.audio(
        "finishSpin4",
        needUrlPath + "/sounds/finishSpin4.mp3" + part2Url
    );
    game.load.audio(
        "finishSpin5",
        needUrlPath + "/sounds/finishSpin5.mp3" + part2Url
    );
    game.load.audio(
        "freeSpinBg",
        needUrlPath + "/sounds/freeSpinBg.mp3" + part2Url
    );
    game.load.audio(
        "balanceSong",
        needUrlPath + "/sounds/balance.mp3" + part2Url
    );
    game.load.audio(
        "briSound",
        needUrlPath + "/sounds/briSound.mp3" + part2Url
    );

    game.load.audio(
        "briFinish",
        needUrlPath + "/sounds/briFinish.mp3" + part2Url
    );
    game.load.audio(
        "briFreespin",
        needUrlPath + "/sounds/briFreespin.mp3" + part2Url
    );
    game.load.audio("briWin", needUrlPath + "/sounds/briWin.mp3" + part2Url);
    game.load.audio("collect", needUrlPath + "/sounds/collect.mp3" + part2Url);
    game.load.audio(
        "more_pays",
        needUrlPath + "/sounds/more_pays.mp3" + part2Url
    );
    game.load.audio(
        "pay_table",
        needUrlPath + "/sounds/pay_table.mp3" + part2Url
    );
    game.load.audio(
        "select_line",
        needUrlPath + "/sounds/select_line.mp3" + part2Url
    );
    game.load.audio(
        "updateFinish",
        needUrlPath + "/sounds/finish_update_balance.mp3" + part2Url
    );
    game.load.audio("kater", needUrlPath + "/sounds/kater.mp3" + part2Url);
    game.load.audio("plane", needUrlPath + "/sounds/plane.mp3" + part2Url);
    game.load.audio("car", needUrlPath + "/sounds/car.mp3" + part2Url);
    game.load.audio(
        "return_to_game",
        needUrlPath + "/sounds/return_to_game.mp3" + part2Url
    );
    game.load.audio(
        "lose_freespins",
        needUrlPath + "/sounds/lose_freespins.mp3" + part2Url
    );
    game.load.audio(
        "briLineWin",
        needUrlPath + "/sounds/briLineWin.mp3" + part2Url
    );

    game.load.audio("low", needUrlPath + "/sounds/wins/low.mp3" + part2Url);
    game.load.audio(
        "medium",
        needUrlPath + "/sounds/wins/medium.mp3" + part2Url
    );
    game.load.audio("high", needUrlPath + "/sounds/wins/high.mp3" + part2Url);
    game.load.audio("coins", needUrlPath + "/sounds/coins.mp3" + part2Url);
    game.load.audio(
        "logoChange",
        needUrlPath + "/sounds/logoChange.mp3" + part2Url
    );
    game.load.audio("helpSound", needUrlPath + "/sounds/help.mp3" + part2Url);
    game.load.audio(
        "freeSpinMulti",
        needUrlPath + "/sounds/freeSpinMulti.mp3" + part2Url
    );
    game.load.audio("briShow", needUrlPath + "/sounds/briShow.mp3" + part2Url);

    for (let i = 1; i <= 20; ++i) {
        game.load.audio(
            "changeLine" + i,
            needUrlPath + "/sounds/changeLine/" + i + ".mp3" + part2Url
        );
        game.load.audio(
            "changeBet" + i,
            needUrlPath + "/sounds/changeBet/" + i + ".mp3" + part2Url
        );
    }
    for (let i = 1; i <= 9; ++i) {
        game.load.audio(
            "spinSound" + i,
            needUrlPath + "/sounds/spinreels/" + i + ".mp3" + part2Url
        );
    }
    game.load.audio(
        "forcedStop",
        needUrlPath + "/sounds/forcedStop.mp3" + part2Url
    );
    game.load.audio(
        "spinSound1f",
        needUrlPath + "/sounds/spinreels/1f.mp3" + part2Url
    );
    game.load.audio(
        "spinSound2f",
        needUrlPath + "/sounds/spinreels/2f.mp3" + part2Url
    );
    game.load.spritesheet(
        "bri_anim",
        "" + path + "/img/bri_anim.png" + part2Url,
        160,
        149,
        12
    );
    game.load.spritesheet(
        "car_anim",
        "" + path + "/img/car_anim.png" + part2Url,
        160,
        149,
        5
    );
    game.load.spritesheet(
        "kater_anim",
        "" + path + "/img/kater_anim.png" + part2Url,
        160,
        149,
        4
    );
    game.load.spritesheet(
        "plane_anim",
        "" + path + "/img/plane_anim.jpg" + part2Url,
        158,
        149,
        7
    );
    game.load.spritesheet(
        "bri_anim_1",
        "" + path + "/img/bri_anim_1_x5.png" + part2Url,
        564,
        373,
        5
    ); //удалить
    game.load.spritesheet(
        "bri_anim_2",
        "" + path + "/img/bri_anim_2_x4.png" + part2Url,
        564,
        373,
        4
    );
    game.load.spritesheet(
        "bri_anim_freespin",
        "" + path + "/img/bri_anim_freespin.png" + part2Url,
        151,
        145,
        4
    );
    game.load.spritesheet(
        "coin_anim_2",
        needUrlPath + "/img/coin_anim2.png" + part2Url,
        135,
        135,
        8
    );
    game.load.spritesheet(
        "star_anim",
        needUrlPath + "/img/star_anim.png" + part2Url,
        62,
        64,
        6
    );
    game.load.spritesheet(
        "star_anim_mini",
        needUrlPath + "/img/star_anim_mini.png" + part2Url,
        21,
        21,
        3
    );
    game.load.spritesheet(
        "bri_big_anim_finish",
        needUrlPath + "/img/bri_big_anim_finish.png" + part2Url,
        326,
        337,
        4
    );
    game.load.spritesheet(
        "bri_big_anim_middle",
        needUrlPath + "/img/bri_big_anim_middle.png" + part2Url,
        449,
        432,
        4
    );
    game.load.spritesheet(
        "bri_big_anim_start",
        needUrlPath + "/img/bri_big_anim_start.png" + part2Url,
        392,
        372,
        4
    );

    game.load.atlasJSONHash(
        "coin_big_anim",
        needUrlPath + "/img/spritesheet.png",
        needUrlPath + "/img/sprites.json" + part2Url
    );
    game.load.atlasJSONHash(
        "coin_anim",
        needUrlPath + "/img/coin.jpg",
        needUrlPath + "/img/coin.json" + part2Url
    );
};

function checkErrorFiles() {
    errorImage = {};
    errorAudio = {};
    errorSpritesheet = {};
    errorTextureatlas = {};
    function onFileError(name, data) {
        if (data.type === "image") {
            errorImage[name] = data.url;
        } else if (data.type === "audio") {
            errorAudio[name] = data.url;
        } else if (data.type === "spritesheet") {
            errorSpritesheet[name] = data.url;
        } else if (data.type === "textureatlas") {
            errorTextureatlas[name] = data.url;
        } else {
            console.log(name);
            console.log(data.url);
        }
    }
    game.load.onFileError.add(onFileError, this);
}

(function() {
    var preload = {};

    preload.preload = function() {
        game.scale.fullScreenScaleMode = Phaser.ScaleManager.EXACT_FIT; //EXACT_FIT  SHOW_ALL
        game.scale.scaleMode = Phaser.ScaleManager.EXACT_FIT;
        game.scale.pageAlignVertically = true;
        game.scale.scaleMode = 2;
        game.scale.pageAlignHorizontally = true;
        game.stage.disableVisibilityChange = true;

        if (
            Object.keys(errorSpritesheet).length ||
            Object.keys(errorImage).length ||
            Object.keys(errorAudio).length ||
            Object.keys(errorTextureatlas).length
        ) {
            if (Object.keys(errorImage).length) {
                for (let key in errorImage) {
                    game.load.image(key, errorImage[key]);
                }
            }
            if (Object.keys(errorAudio).length) {
                for (let key in errorAudio) {
                    game.load.audio(key, errorAudio[key]);
                }
            }
            if (Object.keys(errorSpritesheet).length) {
                for (let key in errorSpritesheet) {
                    game.load.spritesheet(
                        key,
                        errorSpritesheet[key],
                        392,
                        372,
                        4
                    );
                }
            }
            if (Object.keys(errorTextureatlas).length) {
                for (let key in errorTextureatlas) {
                    game.load.atlasJSONHash(key, errorTextureatlas[key]);
                }
            }
        } else {
            loadResource();
        }

        checkErrorFiles();
    };

    preload.create = function() {
        if (firstRequest) {
            if (
                Object.keys(errorImage).length ||
                Object.keys(errorAudio).length ||
                Object.keys(errorSpritesheet).length ||
                Object.keys(errorTextureatlas).length
            ) {
                setTimeout(() => {
                    game.state.start("preload");
                }, 3000);
            } else {
                game.sound.mute = false;
                game.scale.fullScreenScaleMode = Phaser.ScaleManager.EXACT_FIT;
                game.scale.scaleMode = Phaser.ScaleManager.EXACT_FIT;
                game.scale.refresh();
                document.getElementById("preloader").style.display = "none";
                addSounds();
                if (!featureGameStatus) {
                    game.state.start("game1");
                } else {
                    freeSpinsBegin = true;
                    freeSpinBgSong.play();
                    game.state.start("game2");
                }
                checkWidth();
            }
        }
    };

    game.state.add("preload", preload);
})();

game.state.start("preload");
