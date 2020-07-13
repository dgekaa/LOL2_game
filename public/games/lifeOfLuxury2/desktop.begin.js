//переменные получаемые из api
var gamename = 'lifeOfLuxury2'; //название игры
var result;
var state;
var sid;
var user;
var min;
var id;
var balance = 1000;
var extralife = 45;
var jackpots;
var betline = 20;
var lines = 20;
var bet = 400;
var info;
var wl;
var dcard;
var dwin;
var dcard2;
var select;
var allWinOld = 0;
var winOldTrigerFreeSpin = 0;
var afterFreespinStatus = false;
var infoOld = [];
var infoOldOnlyForThisWindow = [];
var wcvWinValuesArrayOld;
var winCellInfo = null;
var wlValues = [];
var topAnim = false;
var triggerPay = 0;
var linePay = 0;
var bonusPay = 0;
var freeSpinsBegin = false;
//звуки и полноэкранный режим
var fullStatus = false;
var soundStatus = true;
var waterfallCoin = false;
var firstStartGame = true;
/* init-запрос */

requestInit();
