/*************************************************************
{
  version : undefined,
  author  : miosee,
  script  : hairspress.js
}
*************************************************************/
// "use strict";

// Property Extend
function extend(ext1, ext2) {
  for(var property in ext2) {
    ext1[property] = ext2[property];
  }
  return ext1;
}

// is UserAgent true match
function isUA(ua) {
  var _ua = window.navigator.userAgent.toLowerCase();
  var navi = _ua.indexOf(ua) !== -1;
  return navi;
}

// param check
function param(param1,param2) {
  var paramCheck = typeof param1 === 'undefined' ? param2 : param1;
  return paramCheck;
}

// is mobile
function isMobile() {
  var iOS = (isUA('iphone') || isUA('ipod'));
  var Android = (isUA('android') && isUA('mobile'));
  var WindowsPhone = (isUA('windows') && isUA('phone'));
  var AndroidOld = (isUA('dream') || isUA('cupcake'));
  var FirefoxOS = (isUA('firefox') && isUA('mobile'));
  var blackberry = isUA('blackberry');

  return (iOS || Android || WindowsPhone || AndroidOld || FirefoxOS || blackberry);
}

// is touch
function isTouch() {
  var touchDevice = typeof window.ontouchstart !== 'undefined';
  return touchDevice;
}

// is rotate
function isRotate() {
  return Math.abs(window.orientation === 90);
}

// is [Internet Explorer] version checked.
function isIE() {
  var msie = (isUA('msie') || isUA('trident'));
  return msie;
}

// jQuery Plugins Library
;(function($){
  // is Visible check
  $.fn.isVisible = function() {
      return $.expr.filters.visible(this[0]);
  };

  // show() Toggle function
  $.fn.showToggle = function(){
    var elem = this;
    elem.each(function(){
      var obj = $(this);
      if(obj.isVisible()) {
        obj.hide();
      } else {
        obj.show();
      }
    });
    return this;
  };

  // スマホ用のモバイル向け電話番号リンク
  $.fn.telLink = function(options) {
    if( !isMobile() ) return false;
    var defaults = {
      linkClass: 'tel-anchor'
    };
    var option = $.extend(defaults, options);
    var elem = this;
    elem.each(function() {
      var _this = $(this);
      var tel = _this.data('tel');
      var className = option.linkClass ? ' class="' + option.linkClass + '"' : '';
      _this.wrap('<a href="tel:' + tel + '"' + className + '></a>');
    });
    return this;
  };

  // タッチデバイス用のタップイベント
  $.fn.touchPointer = function(options) {
    var defaults = {
      start: function() {
        return;
      },
      move: function() {
        return;
      },
      end: function() {
        return;
      }
    };
    var option = $.extend(defaults, options);
    var elem = this;
    elem.each(function() {
      var _this = $(this);

      // イベントハンドラー条件付（タッチデバイス判定）
      var eventHandler = isTouch() ? 'touchstart touchmove touchend' : 'click';
      var touchStart;
      _this.on(eventHandler, function(event) {
        event.preventDefault();
        // タッチした位置を取得する関数
        var touchPosition = function(e) {
          var x = e.originalEvent.touches[0].pageX;
          var y = e.originalEvent.touches[0].pageY;
          x = Math.floor(x);
          y = Math.floor(y);
          var pos = {
            'x': x,
            'y': y
          };
          return pos;
        };

        // タッチ開始

        if( event.type == 'touchstart' ) {
          // var s_pos = touchPosition(event);
          // touchStart = s_pos.y;
          option.start.call(this, event);
          // 指を離したときの判定を行う為のdata属性を付与
          $(this).attr('data-touchend', '');

          return;
        }
        // タッチ移動させた時の処理
        if( event.type == 'touchmove' ) {
          // タッチポイントを色々させるための変数たち
          var offset = $(this).offset();
          var pos = touchPosition(event);
          var w = $(this).width();
          var h = $(this).height();

          // 現在のオブジェクトのタッチポイントを取得し、オブジェクトの範囲から外れた場合
          // タッチエンドの処理を行わないようにdata属性を削除
          // if( (touchStart > pos.y) || (offset.top + h) > pos.y) {
          //   $(this).removeAttr('data-touchend');
          //   return;
          // }
          if( offset.left > pos.x || (offset.left + w) < pos.x || offset.top > pos.y || (offset.top + h) < pos.y ) {

            option.move.call(this, event);
            $(this).removeAttr('data-touchend');
          }
          return;
        }

        // 指を離した時に処理　touchmoveでdata属性が消されてない場合実行する
        if( 'undefined' != typeof $(this).attr('data-touchend') ) {
          // メニューボタン用の関数を呼び出し、コールでイベントを戻す
          option.end.call(this, event);
          $(this).removeAttr('data-touchend');
        }

        // PC用のクリックイベントだった場合に処理
        if( event.type == 'click' ) {
          option.end.call(this, event);
        }
      });
    });
    return this;
  };

  // iFrameにDIVをラップする
  $.fn.iframeWrapper = function(options) {
    var defaults = {
      video : [
        {
          url: 'youtube.com',
          container: 'iframe-video'
        },
        {
          url: 'vimeo.com',
          container: 'iframe-video'
        },
        {
          url: 'google.com/maps',
          container: 'iframe-gmap'
        }
      ]
    };
    var option = $.extend(defaults, options);
    var elem = this;
    elem.find('iframe').each(function() {
      var _this = $(this);
      var src = _this.attr('src');
      for( var i = 0, leng = option.video; i < leng; i++ ) {
        if( src.match(option.video[i].url) ) {
          _this.wrap('<div class="iframe ' + option.video[i].container + '"></div>');
        }
      }
    });
    return this;
  };

  // ソーシャルカウント取得
  $.fn.socialCount = function(options) {
    var defaults = {
      api: 'http://graph.facebook.com/?id=',
      find: '.fb',
      count: '.count'
    };

    var option = $.extend(defaults, options);
    var elem = this;
    elem.each(function() {
      var obj = $(this);
      var o = option;
      var findObj = obj.find(o.find);
      var postURL = findObj.attr('data-permalink');
      var countBox = findObj.find(o.count);

      if( postURL !== '' ) {
        var api_url = o.api + encodeURIComponent(postURL);
        $.ajax({
          url: api_url,
          // type: 'GET',
          dataType: 'jsonp',
          success: function(data) {
            // var count = data.count || data.shares;
            var count = '';
            if( typeof data.count !== 'undefined' ) {
              count = data.count;
            } else if( typeof data.shares !== 'undefined' ) {
              count = data.shares;
            } else {
              count = '0';
            }

            if( count !== '' ) {
              countBox.text(count);
            } else {
              countBox.text('0');
            }
            console.info('success', o.find, count );
          },
          error: function() {
            console.error('error');
          },
          complete: function() {
            return false;
          }
        });
      } else {
        countBox.text('0');
        console.error('Attribute : [data-permalink] is not defined.');
      }
    });
  };

  var scrollStopEvent = new $.Event('scrollstop');
  var scrollDelay = 200;
  var scrollTimer;
  function scrollStopEventTrigger() {
    if( scrollTimer ) {
      clearTimeout(scrollTimer);
    }
    scrollTimer = setTimeout(function() {
      $(window).trigger(scrollStopEvent);
    }, scrollDelay);
  }
  $(window).on('scroll', scrollStopEventTrigger);
  $('body').on('touchmove', scrollStopEventTrigger);
})(jQuery);

/*--- 読み込み時のJS ---*/
jQuery(document).ready(function($) {
  /*--- タッチデバイス向けhover ---*/
  // var hoverTouchStart = function() {
  //   var elem = $(this);
  //   var pos = elem.offset().top;
  //   moved = function() {
  //     movePos = elem.offset().top;
  //     if( pos == movePos ) {
  //       elem.addClass('hover');
  //     }
  //   };
  //   setTimeout(moved, 100);
  // };
  // var hoverTouchEnd = function() {
  //   var elem = $(this);
  //   remover = function() {
  //     elem.removeClass('hover');
  //   };
  //   setTimeout(remover, 500);
  // };
  // $(document).on('touchstart', 'a', hoverTouchStart);
  // $(document).on('touchend', 'a', hoverTouchEnd);
  /*--- End / タッチデバイス向けhover ---*/
});

