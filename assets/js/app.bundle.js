/******/ (function(modules) { // webpackBootstrap
/******/ 	// install a JSONP callback for chunk loading
/******/ 	function webpackJsonpCallback(data) {
/******/ 		var chunkIds = data[0];
/******/ 		var moreModules = data[1];
/******/ 		var executeModules = data[2];
/******/
/******/ 		// add "moreModules" to the modules object,
/******/ 		// then flag all "chunkIds" as loaded and fire callback
/******/ 		var moduleId, chunkId, i = 0, resolves = [];
/******/ 		for(;i < chunkIds.length; i++) {
/******/ 			chunkId = chunkIds[i];
/******/ 			if(installedChunks[chunkId]) {
/******/ 				resolves.push(installedChunks[chunkId][0]);
/******/ 			}
/******/ 			installedChunks[chunkId] = 0;
/******/ 		}
/******/ 		for(moduleId in moreModules) {
/******/ 			if(Object.prototype.hasOwnProperty.call(moreModules, moduleId)) {
/******/ 				modules[moduleId] = moreModules[moduleId];
/******/ 			}
/******/ 		}
/******/ 		if(parentJsonpFunction) parentJsonpFunction(data);
/******/
/******/ 		while(resolves.length) {
/******/ 			resolves.shift()();
/******/ 		}
/******/
/******/ 		// add entry modules from loaded chunk to deferred list
/******/ 		deferredModules.push.apply(deferredModules, executeModules || []);
/******/
/******/ 		// run deferred modules when all chunks ready
/******/ 		return checkDeferredModules();
/******/ 	};
/******/ 	function checkDeferredModules() {
/******/ 		var result;
/******/ 		for(var i = 0; i < deferredModules.length; i++) {
/******/ 			var deferredModule = deferredModules[i];
/******/ 			var fulfilled = true;
/******/ 			for(var j = 1; j < deferredModule.length; j++) {
/******/ 				var depId = deferredModule[j];
/******/ 				if(installedChunks[depId] !== 0) fulfilled = false;
/******/ 			}
/******/ 			if(fulfilled) {
/******/ 				deferredModules.splice(i--, 1);
/******/ 				result = __webpack_require__(__webpack_require__.s = deferredModule[0]);
/******/ 			}
/******/ 		}
/******/
/******/ 		return result;
/******/ 	}
/******/
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// object to store loaded and loading chunks
/******/ 	// undefined = chunk not loaded, null = chunk preloaded/prefetched
/******/ 	// Promise = chunk loading, 0 = chunk loaded
/******/ 	var installedChunks = {
/******/ 		"app": 0
/******/ 	};
/******/
/******/ 	var deferredModules = [];
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	var jsonpArray = window["webpackJsonp"] = window["webpackJsonp"] || [];
/******/ 	var oldJsonpFunction = jsonpArray.push.bind(jsonpArray);
/******/ 	jsonpArray.push = webpackJsonpCallback;
/******/ 	jsonpArray = jsonpArray.slice();
/******/ 	for(var i = 0; i < jsonpArray.length; i++) webpackJsonpCallback(jsonpArray[i]);
/******/ 	var parentJsonpFunction = oldJsonpFunction;
/******/
/******/
/******/ 	// add entry module to deferred list
/******/ 	deferredModules.push(["./src/js/app.js","vendor"]);
/******/ 	// run deferred modules when ready
/******/ 	return checkDeferredModules();
/******/ })
/************************************************************************/
/******/ ({

/***/ "./src/js/app.js":
/*!***********************!*\
  !*** ./src/js/app.js ***!
  \***********************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var lity__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! lity */ "./node_modules/lity/dist/lity.js");
/* harmony import */ var lity__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(lity__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _inc_helper__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./inc/helper */ "./src/js/inc/helper.js");
/* harmony import */ var _inc_common__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./inc/common */ "./src/js/inc/common.js");
/* harmony import */ var _inc_drawer__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./inc/drawer */ "./src/js/inc/drawer.js");
/* harmony import */ var _inc_catalog__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./inc/catalog */ "./src/js/inc/catalog.js");
/* harmony import */ var _inc_gmap__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./inc/gmap */ "./src/js/inc/gmap.js");
/* harmony import */ var _vendor_swiper__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./vendor/_swiper */ "./src/js/vendor/_swiper.js");
/* harmony import */ var _vendor_pogo_slider__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! ./vendor/_pogo-slider */ "./src/js/vendor/_pogo-slider.js");


window.Helper = new _inc_helper__WEBPACK_IMPORTED_MODULE_1__["default"]();







/***/ }),

/***/ "./src/js/inc/catalog.js":
/*!*******************************!*\
  !*** ./src/js/inc/catalog.js ***!
  \*******************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! jquery */ "./node_modules/jquery/dist/jquery.js");
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(jquery__WEBPACK_IMPORTED_MODULE_0__);


function CatalogCtrl() {
  this.init();
}

CatalogCtrl.prototype.init = function () {
  jquery__WEBPACK_IMPORTED_MODULE_0___default()('.btn-catalog-info').on('click', this.clickInfo);
  this.imageGallery();
};

CatalogCtrl.prototype.clickInfo = function () {
  var self = jquery__WEBPACK_IMPORTED_MODULE_0___default()(this);
  var $self_next = self.next();

  if ($self_next.hasClass('hover')) {
    $self_next.removeClass('hover');
  } else {
    jquery__WEBPACK_IMPORTED_MODULE_0___default()('.catalog-container').find('.btn-catalog-info').next().removeClass('hover');
    $self_next.addClass('hover');
  }
};

CatalogCtrl.prototype.imageGallery = function (e) {
  var $thumbnail = jquery__WEBPACK_IMPORTED_MODULE_0___default()('.catalog-picture-list-item');
  $thumbnail.on('click', function (e) {
    e.preventDefault();
    $thumbnail.removeClass('active');
    jquery__WEBPACK_IMPORTED_MODULE_0___default()(this).addClass('active');
    var dataCatalogTarget = jquery__WEBPACK_IMPORTED_MODULE_0___default()(this).data('catalog-target');
    var $catalog_body = jquery__WEBPACK_IMPORTED_MODULE_0___default()('[data-catalog-body="' + dataCatalogTarget + '"]');
    jquery__WEBPACK_IMPORTED_MODULE_0___default()('.catalog-picture-body').find('.pic').removeClass('active');
    $catalog_body.addClass('active');
  });
};

new CatalogCtrl();

/***/ }),

/***/ "./src/js/inc/common.js":
/*!******************************!*\
  !*** ./src/js/inc/common.js ***!
  \******************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! jquery */ "./node_modules/jquery/dist/jquery.js");
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(jquery__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _helper__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./helper */ "./src/js/inc/helper.js");


var Helper = new _helper__WEBPACK_IMPORTED_MODULE_1__["default"]();

function CommonCtrl() {
  this.$win = jquery__WEBPACK_IMPORTED_MODULE_0___default()(window);
  this.headerPos = 0;
  this.anchorScroll = this.anchorScroll.bind(this);
  this.init();
}

CommonCtrl.prototype.init = function () {
  jquery__WEBPACK_IMPORTED_MODULE_0___default()(document).on('click', 'a[href^="#"]', this.anchorScroll);
  this.widgetSidebarToggle();
  this.blogIframe();
  this.spFixedContent();
}; // ページトップ(スマホ時だとtouchイベントだと発火が早過ぎるのでclick処理)


CommonCtrl.prototype.anchorScroll = function (e) {
  e.preventDefault();
  var hash = jquery__WEBPACK_IMPORTED_MODULE_0___default()(e.currentTarget).attr('href');
  if (hash === '#') return false;
  var target = jquery__WEBPACK_IMPORTED_MODULE_0___default()(hash == '#' ? 'html' : hash);
  var pos = target.offset();
  var header = jquery__WEBPACK_IMPORTED_MODULE_0___default()('header').height() + 60;
  var check = Helper.isMobile() ? 0 : header;
  var set = pos.top / 3 - 500;
  var speed = set > 500 ? set : 500;
  jquery__WEBPACK_IMPORTED_MODULE_0___default()('body,html').animate({
    scrollTop: pos.top - check
  }, speed, 'linear');
  jquery__WEBPACK_IMPORTED_MODULE_0___default()('#drawer').animate({
    scrollTop: pos.top - check
  }, speed, 'linear');
};

CommonCtrl.prototype.widgetSidebarToggle = function () {
  var $target = jquery__WEBPACK_IMPORTED_MODULE_0___default()('.yearArchiveList');
  $target.each(function () {
    var $self = jquery__WEBPACK_IMPORTED_MODULE_0___default()(this);
    var $tgl = $self.find('.tgl');
    var $li_tgl = $self.find('li:first .tgl');
    var $li_tgl_child = $self.find('li:first .tgl_child');
    $li_tgl.addClass('open');
    $li_tgl_child.show();
    $tgl.on('click', function () {
      var self = jquery__WEBPACK_IMPORTED_MODULE_0___default()(this);
      self.toggleClass('open');
      self.next('.tgl_child').stop().slideToggle('fast');
    });
  });
};

CommonCtrl.prototype.blogIframe = function () {
  var $target = jquery__WEBPACK_IMPORTED_MODULE_0___default()('.post-body');
  $target.find('iframe').each(function () {
    var self = jquery__WEBPACK_IMPORTED_MODULE_0___default()(this);
    var className = 'iframe';
    var src = self.attr('src');
    var w = self.attr('width');
    var h = self.attr('height');

    if (/youtube\.com/.test(src)) {
      className += ' iframe-youtube';
    }

    self.wrap('<div class="' + className + '"></div>');

    if (jquery__WEBPACK_IMPORTED_MODULE_0___default()(this).parent().hasClass('iframe')) {
      var size = h / w * 100;
      jquery__WEBPACK_IMPORTED_MODULE_0___default()(this).parent().css('padding-bottom', size + '%');
    }
  });
};

CommonCtrl.prototype.spFixedContent = function () {
  var $target = jquery__WEBPACK_IMPORTED_MODULE_0___default()('#spFixedContact');
  this.$win.on('scroll', function () {
    var pos = jquery__WEBPACK_IMPORTED_MODULE_0___default()(this).scrollTop();

    if (pos > this.headerPos) {
      if (jquery__WEBPACK_IMPORTED_MODULE_0___default()(this).scrollTop() > 0) {
        $target.addClass('scrolldown');
      }
    } else {
      $target.removeClass('scrolldown');
    }

    this.headerPos = pos;
  });
};

new CommonCtrl();

/***/ }),

/***/ "./src/js/inc/drawer.js":
/*!******************************!*\
  !*** ./src/js/inc/drawer.js ***!
  \******************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! jquery */ "./node_modules/jquery/dist/jquery.js");
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(jquery__WEBPACK_IMPORTED_MODULE_0__);


function DrawerCtrl() {
  this.$button = jquery__WEBPACK_IMPORTED_MODULE_0___default()('#btnDrawer,#btnDrawerClose');
  this.$target = jquery__WEBPACK_IMPORTED_MODULE_0___default()('#drawer,#drawerOverlay');
  this.$targetOverlay = jquery__WEBPACK_IMPORTED_MODULE_0___default()('#drawerOverlay');
  this.$navi = jquery__WEBPACK_IMPORTED_MODULE_0___default()('#drawerNavi');
  this.classOpen = 'drawer-open';
  this.click = this.click.bind(this);
  this.remove = this.remove.bind(this);
  this.add = this.add.bind(this);
  this.init();
}

DrawerCtrl.prototype.init = function () {
  this.$button.on('click', this.click);
  this.$targetOverlay.on('click', this.remove);
};

DrawerCtrl.prototype.click = function () {
  if (this.$target.hasClass(this.classOpen)) {
    this.remove();
  } else {
    this.add();
  }
};

DrawerCtrl.prototype.remove = function () {
  this.$target.removeClass(this.classOpen);
  this.$navi.removeClass(this.classOpen);
  this.$button.removeClass(this.classOpen);
};

DrawerCtrl.prototype.add = function () {
  this.$target.addClass(this.classOpen);
  this.$navi.addClass(this.classOpen);
  this.$button.addClass(this.classOpen);
};

new DrawerCtrl();

/***/ }),

/***/ "./src/js/inc/gmap.js":
/*!****************************!*\
  !*** ./src/js/inc/gmap.js ***!
  \****************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! jquery */ "./node_modules/jquery/dist/jquery.js");
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(jquery__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _helper__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./helper */ "./src/js/inc/helper.js");


var Helper = new _helper__WEBPACK_IMPORTED_MODULE_1__["default"]();

function GmapCtrl() {
  this.map = null;
  this.render_map = this.render_map.bind(this);
  this.init();
}

GmapCtrl.prototype.init = function () {
  var self = this;
  jquery__WEBPACK_IMPORTED_MODULE_0___default()('.acf-map').each(function () {
    self.map = self.render_map(jquery__WEBPACK_IMPORTED_MODULE_0___default()(this));
  });
};

GmapCtrl.prototype.render_map = function ($el) {
  var self = this;
  var $markers = $el.find('.marker');
  var zooms = $markers.attr('data-zoom');
  var drag = Helper.isMobile() ? false : true;
  var args = {
    zoom: Number(zooms),
    center: new google.maps.LatLng(0, 0),
    mapTypeId: google.maps.MapTypeId.ROADMAP,
    scrollwheel: false,
    draggable: drag
  };
  var map = new google.maps.Map($el[0], args);
  map.markers = [];
  $markers.each(function () {
    self.add_marker(jquery__WEBPACK_IMPORTED_MODULE_0___default()(this), map);
  }); // center map

  this.center_map(map, zooms);
};

GmapCtrl.prototype.add_marker = function ($marker, map) {
  var latlng = new google.maps.LatLng($marker.attr('data-lat'), $marker.attr('data-lng'));
  var marker = new google.maps.Marker({
    position: latlng,
    map: map
  }); // add to array

  map.markers.push(marker); // if marker contains HTML, add it to an infoWindow

  if ($marker.html()) {
    // create info window
    var infowindow = new google.maps.InfoWindow({
      content: $marker.html()
    }); // show info window when marker is clicked

    google.maps.event.addListener(marker, 'click', function () {
      infowindow.open(map, marker);
    });
  }
};

GmapCtrl.prototype.center_map = function (map, zooms) {
  var bounds = new google.maps.LatLngBounds();
  jquery__WEBPACK_IMPORTED_MODULE_0___default.a.each(map.markers, function (i, marker) {
    var latlng = new google.maps.LatLng(marker.position.lat(), marker.position.lng());
    bounds.extend(latlng);
  });

  if (map.markers.length == 1) {
    map.setCenter(bounds.getCenter());
    map.setZoom(Number(zooms));
  } else {
    map.fitBounds(bounds);
  }
};

new GmapCtrl();

/***/ }),

/***/ "./src/js/inc/helper.js":
/*!******************************!*\
  !*** ./src/js/inc/helper.js ***!
  \******************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
function HelperCtrl() {
  this.isUA = this.isUA.bind(this);
  this.isMobile = this.isMobile.bind(this);
  this.isIE = this.isIE.bind(this);
} // Property Extend


HelperCtrl.prototype.extend = function (ext1, ext2) {
  for (var property in ext2) {
    ext1[property] = ext2[property];
  }

  return ext1;
}; // is UserAgent true match


HelperCtrl.prototype.isUA = function (ua) {
  var _ua = window.navigator.userAgent.toLowerCase();

  var navi = _ua.indexOf(ua) !== -1;
  return navi;
}; // param check


HelperCtrl.prototype.param = function (param1, param2) {
  var paramCheck = typeof param1 === 'undefined' ? param2 : param1;
  return paramCheck;
}; // is mobile


HelperCtrl.prototype.isMobile = function () {
  var iOS = this.isUA('iphone') || this.isUA('ipod');
  var Android = this.isUA('android') && this.isUA('mobile');
  var WindowsPhone = this.isUA('windows') && this.isUA('phone');
  var AndroidOld = this.isUA('dream') || this.isUA('cupcake');
  var FirefoxOS = this.isUA('firefox') && this.isUA('mobile');
  var blackberry = this.isUA('blackberry');
  return iOS || Android || WindowsPhone || AndroidOld || FirefoxOS || blackberry;
}; // is touch


HelperCtrl.prototype.isTouch = function () {
  var touchDevice = typeof window.ontouchstart !== 'undefined';
  return touchDevice;
}; // is rotate


HelperCtrl.prototype.isRotate = function () {
  return Math.abs(window.orientation === 90);
}; // is [Internet Explorer] version checked.


HelperCtrl.prototype.isIE = function () {
  var msie = this.isUA('msie') || this.isUA('trident');
  return msie;
};

/* harmony default export */ __webpack_exports__["default"] = (HelperCtrl);

/***/ }),

/***/ "./src/js/vendor/_pogo-slider.js":
/*!***************************************!*\
  !*** ./src/js/vendor/_pogo-slider.js ***!
  \***************************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! jquery */ "./node_modules/jquery/dist/jquery.js");
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(jquery__WEBPACK_IMPORTED_MODULE_0__);

window.jQuery = jquery__WEBPACK_IMPORTED_MODULE_0__; // import 'pogo-slider/jquery.pogo-slider.min';

__webpack_require__(/*! pogo-slider/jquery.pogo-slider.min */ "./node_modules/pogo-slider/jquery.pogo-slider.min.js");

function PogoSliderCtrl() {
  this.$target = jquery__WEBPACK_IMPORTED_MODULE_0__('.pogoSlider');
  this.sliderLength = this.$target.find('.pogoSlider-slide').length;
  this.flagPlay = this.sliderLength > 1 ? true : false; // Get window.sliderOptions

  this.sliderOptions = sliderOptions;
  this.options = this.options.bind(this);
  this.init();
}

PogoSliderCtrl.prototype.init = function () {
  var frontSlider = this.$target.pogoSlider(this.options()).data('plugin_pogoSlider');
};

PogoSliderCtrl.prototype.options = function () {
  var options = {
    displayProgress: true,
    preserveTargetSize: true,
    responsive: true,
    slideTransition: this.sliderOptions.mode,
    slideTransitionDuration: this.sliderOptions.speed,
    buttonPosition: 'CenterHorizontal',
    navPosition: 'Bottom',
    targetWidth: 1280,
    targetHeight: 596,
    pauseOnHover: false
  };

  if (this.sliderLength > 1) {
    options.autoplayTimeout = this.sliderOptions.delay;
    options.autoplay = true;
  }

  return options;
};

new PogoSliderCtrl();

/***/ }),

/***/ "./src/js/vendor/_swiper.js":
/*!**********************************!*\
  !*** ./src/js/vendor/_swiper.js ***!
  \**********************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! jquery */ "./node_modules/jquery/dist/jquery.js");
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(jquery__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var swiper__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! swiper */ "./node_modules/swiper/dist/js/swiper.esm.bundle.js");
/* harmony import */ var _inc_helper__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../inc/helper */ "./src/js/inc/helper.js");



var Helper = new _inc_helper__WEBPACK_IMPORTED_MODULE_2__["default"]();

function SwiperCtrl() {
  this.breadcrumb = this.breadcrumb.bind(this);
  this.init();
}

SwiperCtrl.prototype.init = function () {
  var breadcrumb = new swiper__WEBPACK_IMPORTED_MODULE_1__["default"]('.bread-container', this.breadcrumb());
  var catalogCarousel = new swiper__WEBPACK_IMPORTED_MODULE_1__["default"]('.catalog-swiper', this.catalogCarousel());
  var staffCarousel = new swiper__WEBPACK_IMPORTED_MODULE_1__["default"]('.other-staff-list', this.staffCarousel());
};

SwiperCtrl.prototype.breadcrumb = function () {
  var $breadcrumb = jquery__WEBPACK_IMPORTED_MODULE_0___default()('.bread-container');
  var leng = $breadcrumb.find('li').length;
  return {
    scrollbar: {
      hide: true
    },
    initialSlide: leng,
    freeMode: true,
    slidesPerView: 'auto',
    spaceBetween: 0
  };
};

SwiperCtrl.prototype.catalogCarousel = function () {
  var center = false;
  var free = false;
  var wheel = false;

  if (Helper.isMobile()) {
    center = true;
    free = true;
    wheel = true;
  }

  return {
    navigation: {
      nextEl: '.catalog-list-next',
      prevEl: '.catalog-list-prev'
    },
    scrollbar: {
      el: '.catalog-scrollbar',
      hide: false
    },
    freeMode: free,
    slidesPerView: 'auto',
    centeredSlides: center,
    spaceBetween: 8,
    grabCursor: true,
    speed: 800,
    // autoplay: 4000,
    autoplayDisableOnInteraction: false // mousewheelControl: true

  };
};

SwiperCtrl.prototype.staffCarousel = function () {
  var center = false;

  if (Helper.isMobile()) {
    center = true;
  }

  return {
    // scrollbar: '.cat-tag-scrollbar',
    // scrollbarHide: false,
    // freeMode: true,
    pagination: {
      el: '.staff-list-pagination',
      clickable: true
    },
    navigation: {
      nextEl: '.staff-list-next',
      prevEl: '.staff-list-prev'
    },
    slidesPerView: 'auto',
    centeredSlides: center,
    spaceBetween: 32,
    grabCursor: true
  };
};

new SwiperCtrl();

/***/ })

/******/ });
//# sourceMappingURL=app.bundle.js.map