/**
 * ログイン画面のスクリプト
 */

// 自動でチェック
var hp_init = function() {
  var elem = document.getElementById('rememberme');
  elem.checked = true;
};
window.onload = hp_init;
