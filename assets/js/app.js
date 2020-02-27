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
/* harmony import */ var _inc_catalog__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_inc_catalog__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _inc_gmap__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./inc/gmap */ "./src/js/inc/gmap.js");
/* harmony import */ var _vendor_swiper__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./vendor/_swiper */ "./src/js/vendor/_swiper.js");
/* harmony import */ var _vendor_pogo_slider__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! ./vendor/_pogo-slider */ "./src/js/vendor/_pogo-slider.js");



window.Helper = new _inc_helper__WEBPACK_IMPORTED_MODULE_1__["default"]();









/***/ }),

/***/ "./src/js/inc/catalog.js":
/*!*******************************!*\
  !*** ./src/js/inc/catalog.js ***!
  \*******************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

/* WEBPACK VAR INJECTION */(function($) {function CatalogCtrl() {
	this.init();
}

CatalogCtrl.prototype.init = function () {
	$('.btn-catalog-info').on('click', this.clickInfo);
	this.imageGallery();
};

CatalogCtrl.prototype.clickInfo = function () {
	var self = $(this);
	var $self_next = self.next();
	if ($self_next.hasClass('hover')) {
		$self_next.removeClass('hover');
	} else {
		$('.catalog-container').find('.btn-catalog-info').next().removeClass('hover');
		$self_next.addClass('hover');
	}
};

CatalogCtrl.prototype.imageGallery = function (e) {
	var $thumbnail = $('.catalog-picture-list-item');
	$thumbnail.on('click', function (e) {
		e.preventDefault();
		$thumbnail.removeClass('active');
		$(this).addClass('active');

		var dataCatalogTarget = $(this).data('catalog-target');
		var $catalog_body = $('[data-catalog-body="' + dataCatalogTarget + '"]');
		$('.catalog-picture-body').find('.pic').removeClass('active');
		$catalog_body.addClass('active');
	});
};

new CatalogCtrl();
/* WEBPACK VAR INJECTION */}.call(this, __webpack_require__(/*! jquery */ "./node_modules/jquery/dist/jquery.js")))

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
	jquery__WEBPACK_IMPORTED_MODULE_0___default()('a[href^="#"]').on('click', this.anchorScroll);
	this.widgetSidebarToggle();
	this.blogIframe();
	this.spFixedContent();
};

// ページトップ(スマホ時だとtouchイベントだと発火が早過ぎるのでclick処理)
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
	var $target = jquery__WEBPACK_IMPORTED_MODULE_0___default()('#widget-archive > ul');
	var $tgl = $target.find('.tgl');
	var $li_tgl = $target.find('li:first .tgl');
	var $li_tgl_child = $target.find('li:first .tgl_child');
	$li_tgl.addClass('open');
	$li_tgl_child.show();
	$tgl.on('click', function () {
		var self = jquery__WEBPACK_IMPORTED_MODULE_0___default()(this);
		self.toggleClass('open');
		self.next('.tgl_child').stop().slideToggle('fast');
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
	});
	// center map
	this.center_map(map, zooms);
};

GmapCtrl.prototype.add_marker = function ($marker, map) {
	var latlng = new google.maps.LatLng($marker.attr('data-lat'), $marker.attr('data-lng'));
	var marker = new google.maps.Marker({
		position: latlng,
		map: map
	});
	// add to array
	map.markers.push(marker);
	// if marker contains HTML, add it to an infoWindow
	if ($marker.html()) {
		// create info window
		var infowindow = new google.maps.InfoWindow({
			content: $marker.html()
		});
		// show info window when marker is clicked
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
}

// Property Extend
HelperCtrl.prototype.extend = function (ext1, ext2) {
	for (var property in ext2) {
		ext1[property] = ext2[property];
	}
	return ext1;
};

// is UserAgent true match
HelperCtrl.prototype.isUA = function (ua) {
	var _ua = window.navigator.userAgent.toLowerCase();
	var navi = _ua.indexOf(ua) !== -1;
	return navi;
};

// param check
HelperCtrl.prototype.param = function (param1, param2) {
	var paramCheck = typeof param1 === 'undefined' ? param2 : param1;
	return paramCheck;
};

// is mobile
HelperCtrl.prototype.isMobile = function () {
	var iOS = this.isUA('iphone') || this.isUA('ipod');
	var Android = this.isUA('android') && this.isUA('mobile');
	var WindowsPhone = this.isUA('windows') && this.isUA('phone');
	var AndroidOld = this.isUA('dream') || this.isUA('cupcake');
	var FirefoxOS = this.isUA('firefox') && this.isUA('mobile');
	var blackberry = this.isUA('blackberry');

	return iOS || Android || WindowsPhone || AndroidOld || FirefoxOS || blackberry;
};

// is touch
HelperCtrl.prototype.isTouch = function () {
	var touchDevice = typeof window.ontouchstart !== 'undefined';
	return touchDevice;
};

// is rotate
HelperCtrl.prototype.isRotate = function () {
	return Math.abs(window.orientation === 90);
};

// is [Internet Explorer] version checked.
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
/* harmony import */ var pogo_slider_jquery_pogo_slider_min__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! pogo-slider/jquery.pogo-slider.min */ "./node_modules/pogo-slider/jquery.pogo-slider.min.js");
/* harmony import */ var pogo_slider_jquery_pogo_slider_min__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(pogo_slider_jquery_pogo_slider_min__WEBPACK_IMPORTED_MODULE_1__);


// import './pogo';


function PogoSliderCtrl() {
	this.$target = jquery__WEBPACK_IMPORTED_MODULE_0___default()('.pogoSlider');
	this.sliderLength = this.$target.find('.pogoSlider-slide').length;
	this.flagPlay = this.sliderLength > 1 ? true : false;
	// Get window.sliderOptions
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
		targetWidth: 1200,
		targetHeight: 544,
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
		autoplayDisableOnInteraction: false
		// mousewheelControl: true
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
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vd2VicGFjay9ib290c3RyYXAiLCJ3ZWJwYWNrOi8vLy4vc3JjL2pzL2FwcC5qcyIsIndlYnBhY2s6Ly8vLi9zcmMvanMvaW5jL2NhdGFsb2cuanMiLCJ3ZWJwYWNrOi8vLy4vc3JjL2pzL2luYy9jb21tb24uanMiLCJ3ZWJwYWNrOi8vLy4vc3JjL2pzL2luYy9kcmF3ZXIuanMiLCJ3ZWJwYWNrOi8vLy4vc3JjL2pzL2luYy9nbWFwLmpzIiwid2VicGFjazovLy8uL3NyYy9qcy9pbmMvaGVscGVyLmpzIiwid2VicGFjazovLy8uL3NyYy9qcy92ZW5kb3IvX3BvZ28tc2xpZGVyLmpzIiwid2VicGFjazovLy8uL3NyYy9qcy92ZW5kb3IvX3N3aXBlci5qcyJdLCJuYW1lcyI6WyJ3aW5kb3ciLCJIZWxwZXIiLCJIZWxwZXJDdHJsIiwiQ2F0YWxvZ0N0cmwiLCJpbml0IiwicHJvdG90eXBlIiwiJCIsIm9uIiwiY2xpY2tJbmZvIiwiaW1hZ2VHYWxsZXJ5Iiwic2VsZiIsIiRzZWxmX25leHQiLCJuZXh0IiwiaGFzQ2xhc3MiLCJyZW1vdmVDbGFzcyIsImZpbmQiLCJhZGRDbGFzcyIsImUiLCIkdGh1bWJuYWlsIiwicHJldmVudERlZmF1bHQiLCJkYXRhQ2F0YWxvZ1RhcmdldCIsImRhdGEiLCIkY2F0YWxvZ19ib2R5IiwiQ29tbW9uQ3RybCIsIiR3aW4iLCJoZWFkZXJQb3MiLCJhbmNob3JTY3JvbGwiLCJiaW5kIiwid2lkZ2V0U2lkZWJhclRvZ2dsZSIsImJsb2dJZnJhbWUiLCJzcEZpeGVkQ29udGVudCIsImhhc2giLCJjdXJyZW50VGFyZ2V0IiwiYXR0ciIsInRhcmdldCIsInBvcyIsIm9mZnNldCIsImhlYWRlciIsImhlaWdodCIsImNoZWNrIiwiaXNNb2JpbGUiLCJzZXQiLCJ0b3AiLCJzcGVlZCIsImFuaW1hdGUiLCJzY3JvbGxUb3AiLCIkdGFyZ2V0IiwiJHRnbCIsIiRsaV90Z2wiLCIkbGlfdGdsX2NoaWxkIiwic2hvdyIsInRvZ2dsZUNsYXNzIiwic3RvcCIsInNsaWRlVG9nZ2xlIiwiZWFjaCIsImNsYXNzTmFtZSIsInNyYyIsInciLCJoIiwidGVzdCIsIndyYXAiLCJwYXJlbnQiLCJzaXplIiwiY3NzIiwiRHJhd2VyQ3RybCIsIiRidXR0b24iLCIkdGFyZ2V0T3ZlcmxheSIsIiRuYXZpIiwiY2xhc3NPcGVuIiwiY2xpY2siLCJyZW1vdmUiLCJhZGQiLCJHbWFwQ3RybCIsIm1hcCIsInJlbmRlcl9tYXAiLCIkZWwiLCIkbWFya2VycyIsInpvb21zIiwiZHJhZyIsImFyZ3MiLCJ6b29tIiwiTnVtYmVyIiwiY2VudGVyIiwiZ29vZ2xlIiwibWFwcyIsIkxhdExuZyIsIm1hcFR5cGVJZCIsIk1hcFR5cGVJZCIsIlJPQURNQVAiLCJzY3JvbGx3aGVlbCIsImRyYWdnYWJsZSIsIk1hcCIsIm1hcmtlcnMiLCJhZGRfbWFya2VyIiwiY2VudGVyX21hcCIsIiRtYXJrZXIiLCJsYXRsbmciLCJtYXJrZXIiLCJNYXJrZXIiLCJwb3NpdGlvbiIsInB1c2giLCJodG1sIiwiaW5mb3dpbmRvdyIsIkluZm9XaW5kb3ciLCJjb250ZW50IiwiZXZlbnQiLCJhZGRMaXN0ZW5lciIsIm9wZW4iLCJib3VuZHMiLCJMYXRMbmdCb3VuZHMiLCJpIiwibGF0IiwibG5nIiwiZXh0ZW5kIiwibGVuZ3RoIiwic2V0Q2VudGVyIiwiZ2V0Q2VudGVyIiwic2V0Wm9vbSIsImZpdEJvdW5kcyIsImlzVUEiLCJpc0lFIiwiZXh0MSIsImV4dDIiLCJwcm9wZXJ0eSIsInVhIiwiX3VhIiwibmF2aWdhdG9yIiwidXNlckFnZW50IiwidG9Mb3dlckNhc2UiLCJuYXZpIiwiaW5kZXhPZiIsInBhcmFtIiwicGFyYW0xIiwicGFyYW0yIiwicGFyYW1DaGVjayIsImlPUyIsIkFuZHJvaWQiLCJXaW5kb3dzUGhvbmUiLCJBbmRyb2lkT2xkIiwiRmlyZWZveE9TIiwiYmxhY2tiZXJyeSIsImlzVG91Y2giLCJ0b3VjaERldmljZSIsIm9udG91Y2hzdGFydCIsImlzUm90YXRlIiwiTWF0aCIsImFicyIsIm9yaWVudGF0aW9uIiwibXNpZSIsIlBvZ29TbGlkZXJDdHJsIiwic2xpZGVyTGVuZ3RoIiwiZmxhZ1BsYXkiLCJzbGlkZXJPcHRpb25zIiwib3B0aW9ucyIsImZyb250U2xpZGVyIiwicG9nb1NsaWRlciIsImRpc3BsYXlQcm9ncmVzcyIsInByZXNlcnZlVGFyZ2V0U2l6ZSIsInJlc3BvbnNpdmUiLCJzbGlkZVRyYW5zaXRpb24iLCJtb2RlIiwic2xpZGVUcmFuc2l0aW9uRHVyYXRpb24iLCJidXR0b25Qb3NpdGlvbiIsIm5hdlBvc2l0aW9uIiwidGFyZ2V0V2lkdGgiLCJ0YXJnZXRIZWlnaHQiLCJwYXVzZU9uSG92ZXIiLCJhdXRvcGxheVRpbWVvdXQiLCJkZWxheSIsImF1dG9wbGF5IiwiU3dpcGVyQ3RybCIsImJyZWFkY3J1bWIiLCJTd2lwZXIiLCJjYXRhbG9nQ2Fyb3VzZWwiLCJzdGFmZkNhcm91c2VsIiwiJGJyZWFkY3J1bWIiLCJsZW5nIiwic2Nyb2xsYmFyIiwiaGlkZSIsImluaXRpYWxTbGlkZSIsImZyZWVNb2RlIiwic2xpZGVzUGVyVmlldyIsInNwYWNlQmV0d2VlbiIsImZyZWUiLCJ3aGVlbCIsIm5hdmlnYXRpb24iLCJuZXh0RWwiLCJwcmV2RWwiLCJlbCIsImNlbnRlcmVkU2xpZGVzIiwiZ3JhYkN1cnNvciIsImF1dG9wbGF5RGlzYWJsZU9uSW50ZXJhY3Rpb24iLCJwYWdpbmF0aW9uIiwiY2xpY2thYmxlIl0sIm1hcHBpbmdzIjoiO0FBQUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQSxnQkFBUSxvQkFBb0I7QUFDNUI7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSx5QkFBaUIsNEJBQTRCO0FBQzdDO0FBQ0E7QUFDQSwwQkFBa0IsMkJBQTJCO0FBQzdDO0FBQ0E7QUFDQTtBQUNB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UCxFQUFKLEVBQXVCO0FBQ3RCMEMsV0FBUyxJQUFUO0FBQ0FxRyxTQUFPLElBQVA7QUFDQUMsVUFBUSxJQUFSO0FBQ0E7O0FBRUQsUUFBTztBQUNOQyxjQUFZO0FBQ1hDLFdBQVEsb0JBREc7QUFFWEMsV0FBUTtBQUZHLEdBRE47QUFLTlYsYUFBVztBQUNWVyxPQUFJLG9CQURNO0FBRVZWLFNBQU07QUFGSSxHQUxMO0FBU05FLFlBQVVHLElBVEo7QUFVTkYsaUJBQWUsTUFWVDtBQVdOUSxrQkFBZ0IzRyxNQVhWO0FBWU5vRyxnQkFBYyxDQVpSO0FBYU5RLGNBQVksSUFiTjtBQWNObkosU0FBTyxHQWREO0FBZU47QUFDQW9KLGdDQUE4QjtBQUM5QjtBQWpCTSxFQUFQO0FBbUJBLENBOUJEOztBQWdDQXJCLFdBQVdySyxTQUFYLENBQXFCeUssYUFBckIsR0FBcUMsWUFBVztBQUMvQyxLQUFJNUYsU0FBUyxLQUFiO0FBQ0EsS0FBSWpGLE9BQU91QyxRQUFQLEVBQUosRUFBdUI7QUFDdEIwQyxXQUFTLElBQVQ7QUFDQTtBQUNELFFBQU87QUFDTjtBQUNBO0FBQ0E7QUFDQThHLGNBQVk7QUFDWEosT0FBSSx3QkFETztBQUVYSyxjQUFXO0FBRkEsR0FKTjtBQVFOUixjQUFZO0FBQ1hDLFdBQVEsa0JBREc7QUFFWEMsV0FBUTtBQUZHLEdBUk47QUFZTk4saUJBQWUsTUFaVDtBQWFOUSxrQkFBZ0IzRyxNQWJWO0FBY05vRyxnQkFBYyxFQWRSO0FBZU5RLGNBQVk7QUFmTixFQUFQO0FBaUJBLENBdEJEOztBQXdCQSxJQUFJcEIsVUFBSixHIiwiZmlsZSI6ImFwcC5qcyIsInNvdXJjZXNDb250ZW50IjpbIiBcdC8vIGluc3RhbGwgYSBKU09OUCBjYWxsYmFjayBmb3IgY2h1bmsgbG9hZGluZ1xuIFx0ZnVuY3Rpb24gd2VicGFja0pzb25wQ2FsbGJhY2soZGF0YSkge1xuIFx0XHR2YXIgY2h1bmtJZHMgPSBkYXRhWzBdO1xuIFx0XHR2YXIgbW9yZU1vZHVsZXMgPSBkYXRhWzFdO1xuIFx0XHR2YXIgZXhlY3V0ZU1vZHVsZXMgPSBkYXRhWzJdO1xuXG4gXHRcdC8vIGFkZCBcIm1vcmVNb2R1bGVzXCIgdG8gdGhlIG1vZHVsZXMgb2JqZWN0LFxuIFx0XHQvLyB0aGVuIGZsYWcgYWxsIFwiY2h1bmtJZHNcIiBhcyBsb2FkZWQgYW5kIGZpcmUgY2FsbGJhY2tcbiBcdFx0dmFyIG1vZHVsZUlkLCBjaHVua0lkLCBpID0gMCwgcmVzb2x2ZXMgPSBbXTtcbiBcdFx0Zm9yKDtpIDwgY2h1bmtJZHMubGVuZ3RoOyBpKyspIHtcbiBcdFx0XHRjaHVua0lkID0gY2h1bmtJZHNbaV07XG4gXHRcdFx0aWYoaW5zdGFsbGVkQ2h1bmtzW2NodW5rSWRdKSB7XG4gXHRcdFx0XHRyZXNvbHZlcy5wdXNoKGluc3RhbGxlZENodW5rc1tjaHVua0lkXVswXSk7XG4gXHRcdFx0fVxuIFx0XHRcdGluc3RhbGxlZENodW5rc1tjaHVua0lkXSA9IDA7XG4gXHRcdH1cbiBcdFx0Zm9yKG1vZHVsZUlkIGluIG1vcmVNb2R1bGVzKSB7XG4gXHRcdFx0aWYoT2JqZWN0LnByb3RvdHlwZS5oYXNPd25Qcm9wZXJ0eS5jYWxsKG1vcmVNb2R1bGVzLCBtb2R1bGVJZCkpIHtcbiBcdFx0XHRcdG1vZHVsZXNbbW9kdWxlSWRdID0gbW9yZU1vZHVsZXNbbW9kdWxlSWRdO1xuIFx0XHRcdH1cbiBcdFx0fVxuIFx0XHRpZihwYXJlbnRKc29ucEZ1bmN0aW9uKSBwYXJlbnRKc29ucEZ1bmN0aW9uKGRhdGEpO1xuXG4gXHRcdHdoaWxlKHJlc29sdmVzLmxlbmd0aCkge1xuIFx0XHRcdHJlc29sdmVzLnNoaWZ0KCkoKTtcbiBcdFx0fVxuXG4gXHRcdC8vIGFkZCBlbnRyeSBtb2R1bGVzIGZyb20gbG9hZGVkIGNodW5rIHRvIGRlZmVycmVkIGxpc3RcbiBcdFx0ZGVmZXJyZWRNb2R1bGVzLnB1c2guYXBwbHkoZGVmZXJyZWRNb2R1bGVzLCBleGVjdXRlTW9kdWxlcyB8fCBbXSk7XG5cbiBcdFx0Ly8gcnVuIGRlZmVycmVkIG1vZHVsZXMgd2hlbiBhbGwgY2h1bmtzIHJlYWR5XG4gXHRcdHJldHVybiBjaGVja0RlZmVycmVkTW9kdWxlcygpO1xuIFx0fTtcbiBcdGZ1bmN0aW9uIGNoZWNrRGVmZXJyZWRNb2R1bGVzKCkge1xuIFx0XHR2YXIgcmVzdWx0O1xuIFx0XHRmb3IodmFyIGkgPSAwOyBpIDwgZGVmZXJyZWRNb2R1bGVzLmxlbmd0aDsgaSsrKSB7XG4gXHRcdFx0dmFyIGRlZmVycmVkTW9kdWxlID0gZGVmZXJyZWRNb2R1bGVzW2ldO1xuIFx0XHRcdHZhciBmdWxmaWxsZWQgPSB0cnVlO1xuIFx0XHRcdGZvcih2YXIgaiA9IDE7IGogPCBkZWZlcnJlZE1vZHVsZS5sZW5ndGg7IGorKykge1xuIFx0XHRcdFx0dmFyIGRlcElkID0gZGVmZXJyZWRNb2R1bGVbal07XG4gXHRcdFx0XHRpZihpbnN0YWxsZWRDaHVua3NbZGVwSWRdICE9PSAwKSBmdWxmaWxsZWQgPSBmYWxzZTtcbiBcdFx0XHR9XG4gXHRcdFx0aWYoZnVsZmlsbGVkKSB7XG4gXHRcdFx0XHRkZWZlcnJlZE1vZHVsZXMuc3BsaWNlKGktLSwgMSk7XG4gXHRcdFx0XHRyZXN1bHQgPSBfX3dlYnBhY2tfcmVxdWlyZV9fKF9fd2VicGFja19yZXF1aXJlX18ucyA9IGRlZmVycmVkTW9kdWxlWzBdKTtcbiBcdFx0XHR9XG4gXHRcdH1cbiBcdFx0cmV0dXJuIHJlc3VsdDtcbiBcdH1cblxuIFx0Ly8gVGhlIG1vZHVsZSBjYWNoZVxuIFx0dmFyIGluc3RhbGxlZE1vZHVsZXMgPSB7fTtcblxuIFx0Ly8gb2JqZWN0IHRvIHN0b3JlIGxvYWRlZCBhbmQgbG9hZGluZyBjaHVua3NcbiBcdC8vIHVuZGVmaW5lZCA9IGNodW5rIG5vdCBsb2FkZWQsIG51bGwgPSBjaHVuayBwcmVsb2FkZWQvcHJlZmV0Y2hlZFxuIFx0Ly8gUHJvbWlzZSA9IGNodW5rIGxvYWRpbmcsIDAgPSBjaHVuayBsb2FkZWRcbiBcdHZhciBpbnN0YWxsZWRDaHVua3MgPSB7XG4gXHRcdFwiYXBwXCI6IDBcbiBcdH07XG5cbiBcdHZhciBkZWZlcnJlZE1vZHVsZXMgPSBbXTtcblxuIFx0Ly8gVGhlIHJlcXVpcmUgZnVuY3Rpb25cbiBcdGZ1bmN0aW9uIF9fd2VicGFja19yZXF1aXJlX18obW9kdWxlSWQpIHtcblxuIFx0XHQvLyBDaGVjayBpZiBtb2R1bGUgaXMgaW4gY2FjaGVcbiBcdFx0aWYoaW5zdGFsbGVkTW9kdWxlc1ttb2R1bGVJZF0pIHtcbiBcdFx0XHRyZXR1cm4gaW5zdGFsbGVkTW9kdWxlc1ttb2R1bGVJZF0uZXhwb3J0cztcbiBcdFx0fVxuIFx0XHQvLyBDcmVhdGUgYSBuZXcgbW9kdWxlIChhbmQgcHV0IGl0IGludG8gdGhlIGNhY2hlKVxuIFx0XHR2YXIgbW9kdWxlID0gaW5zdGFsbGVkTW9kdWxlc1ttb2R1bGVJZF0gPSB7XG4gXHRcdFx0aTogbW9kdWxlSWQsXG4gXHRcdFx0bDogZmFsc2UsXG4gXHRcdFx0ZXhwb3J0czoge31cbiBcdFx0fTtcblxuIFx0XHQvLyBFeGVjdXRlIHRoZSBtb2R1bGUgZnVuY3Rpb25cbiBcdFx0bW9kdWxlc1ttb2R1bGVJZF0uY2FsbChtb2R1bGUuZXhwb3J0cywgbW9kdWxlLCBtb2R1bGUuZXhwb3J0cywgX193ZWJwYWNrX3JlcXVpcmVfXyk7XG5cbiBcdFx0Ly8gRmxhZyB0aGUgbW9kdWxlIGFzIGxvYWRlZFxuIFx0XHRtb2R1bGUubCA9IHRydWU7XG5cbiBcdFx0Ly8gUmV0dXJuIHRoZSBleHBvcnRzIG9mIHRoZSBtb2R1bGVcbiBcdFx0cmV0dXJuIG1vZHVsZS5leHBvcnRzO1xuIFx0fVxuXG5cbiBcdC8vIGV4cG9zZSB0aGUgbW9kdWxlcyBvYmplY3QgKF9fd2VicGFja19tb2R1bGVzX18pXG4gXHRfX3dlYnBhY2tfcmVxdWlyZV9fLm0gPSBtb2R1bGVzO1xuXG4gXHQvLyBleHBvc2UgdGhlIG1vZHVsZSBjYWNoZVxuIFx0X193ZWJwYWNrX3JlcXVpcmVfXy5jID0gaW5zdGFsbGVkTW9kdWxlcztcblxuIFx0Ly8gZGVmaW5lIGdldHRlciBmdW5jdGlvbiBmb3IgaGFybW9ueSBleHBvcnRzXG4gXHRfX3dlYnBhY2tfcmVxdWlyZV9fLmQgPSBmdW5jdGlvbihleHBvcnRzLCBuYW1lLCBnZXR0ZXIpIHtcbiBcdFx0aWYoIV9fd2VicGFja19yZXF1aXJlX18ubyhleHBvcnRzLCBuYW1lKSkge1xuIFx0XHRcdE9iamVjdC5kZWZpbmVQcm9wZXJ0eShleHBvcnRzLCBuYW1lLCB7IGVudW1lcmFibGU6IHRydWUsIGdldDogZ2V0dGVyIH0pO1xuIFx0XHR9XG4gXHR9O1xuXG4gXHQvLyBkZWZpbmUgX19lc01vZHVsZSBvbiBleHBvcnRzXG4gXHRfX3dlYnBhY2tfcmVxdWlyZV9fLnIgPSBmdW5jdGlvbihleHBvcnRzKSB7XG4gXHRcdGlmKHR5cGVvZiBTeW1ib2wgIT09ICd1bmRlZmluZWQnICYmIFN5bWJvbC50b1N0cmluZ1RhZykge1xuIFx0XHRcdE9iamVjdC5kZWZpbmVQcm9wZXJ0eShleHBvcnRzLCBTeW1ib2wudG9TdHJpbmdUYWcsIHsgdmFsdWU6ICdNb2R1bGUnIH0pO1xuIFx0XHR9XG4gXHRcdE9iamVjdC5kZWZpbmVQcm9wZXJ0eShleHBvcnRzLCAnX19lc01vZHVsZScsIHsgdmFsdWU6IHRydWUgfSk7XG4gXHR9O1xuXG4gXHQvLyBjcmVhdGUgYSBmYWtlIG5hbWVzcGFjZSBvYmplY3RcbiBcdC8vIG1vZGUgJiAxOiB2YWx1ZSBpcyBhIG1vZHVsZSBpZCwgcmVxdWlyZSBpdFxuIFx0Ly8gbW9kZSAmIDI6IG1lcmdlIGFsbCBwcm9wZXJ0aWVzIG9mIHZhbHVlIGludG8gdGhlIG5zXG4gXHQvLyBtb2RlICYgNDogcmV0dXJuIHZhbHVlIHdoZW4gYWxyZWFkeSBucyBvYmplY3RcbiBcdC8vIG1vZGUgJiA4fDE6IGJlaGF2ZSBsaWtlIHJlcXVpcmVcbiBcdF9fd2VicGFja19yZXF1aXJlX18udCA9IGZ1bmN0aW9uKHZhbHVlLCBtb2RlKSB7XG4gXHRcdGlmKG1vZGUgJiAxKSB2YWx1ZSA9IF9fd2VicGFja19yZXF1aXJlX18odmFsdWUpO1xuIFx0XHRpZihtb2RlICYgOCkgcmV0dXJuIHZhbHVlO1xuIFx0XHRpZigobW9kZSAmIDQpICYmIHR5cGVvZiB2YWx1ZSA9PT0gJ29iamVjdCcgJiYgdmFsdWUgJiYgdmFsdWUuX19lc01vZHVsZSkgcmV0dXJuIHZhbHVlO1xuIFx0XHR2YXIgbnMgPSBPYmplY3QuY3JlYXRlKG51bGwpO1xuIFx0XHRfX3dlYnBhY2tfcmVxdWlyZV9fLnIobnMpO1xuIFx0XHRPYmplY3QuZGVmaW5lUHJvcGVydHkobnMsICdkZWZhdWx0JywgeyBlbnVtZXJhYmxlOiB0cnVlLCB2YWx1ZTogdmFsdWUgfSk7XG4gXHRcdGlmKG1vZGUgJiAyICYmIHR5cGVvZiB2YWx1ZSAhPSAnc3RyaW5nJykgZm9yKHZhciBrZXkgaW4gdmFsdWUpIF9fd2VicGFja19yZXF1aXJlX18uZChucywga2V5LCBmdW5jdGlvbihrZXkpIHsgcmV0dXJuIHZhbHVlW2tleV07IH0uYmluZChudWxsLCBrZXkpKTtcbiBcdFx0cmV0dXJuIG5zO1xuIFx0fTtcblxuIFx0Ly8gZ2V0RGVmYXVsdEV4cG9ydCBmdW5jdGlvbiBmb3IgY29tcGF0aWJpbGl0eSB3aXRoIG5vbi1oYXJtb255IG1vZHVsZXNcbiBcdF9fd2VicGFja19yZXF1aXJlX18ubiA9IGZ1bmN0aW9uKG1vZHVsZSkge1xuIFx0XHR2YXIgZ2V0dGVyID0gbW9kdWxlICYmIG1vZHVsZS5fX2VzTW9kdWxlID9cbiBcdFx0XHRmdW5jdGlvbiBnZXREZWZhdWx0KCkgeyByZXR1cm4gbW9kdWxlWydkZWZhdWx0J107IH0gOlxuIFx0XHRcdGZ1bmN0aW9uIGdldE1vZHVsZUV4cG9ydHMoKSB7IHJldHVybiBtb2R1bGU7IH07XG4gXHRcdF9fd2VicGFja19yZXF1aXJlX18uZChnZXR0ZXIsICdhJywgZ2V0dGVyKTtcbiBcdFx0cmV0dXJuIGdldHRlcjtcbiBcdH07XG5cbiBcdC8vIE9iamVjdC5wcm90b3R5cGUuaGFzT3duUHJvcGVydHkuY2FsbFxuIFx0X193ZWJwYWNrX3JlcXVpcmVfXy5vID0gZnVuY3Rpb24ob2JqZWN0LCBwcm9wZXJ0eSkgeyByZXR1cm4gT2JqZWN0LnByb3RvdHlwZS5oYXNPd25Qcm9wZXJ0eS5jYWxsKG9iamVjdCwgcHJvcGVydHkpOyB9O1xuXG4gXHQvLyBfX3dlYnBhY2tfcHVibGljX3BhdGhfX1xuIFx0X193ZWJwYWNrX3JlcXVpcmVfXy5wID0gXCJcIjtcblxuIFx0dmFyIGpzb25wQXJyYXkgPSB3aW5kb3dbXCJ3ZWJwYWNrSnNvbnBcIl0gPSB3aW5kb3dbXCJ3ZWJwYWNrSnNvbnBcIl0gfHwgW107XG4gXHR2YXIgb2xkSnNvbnBGdW5jdGlvbiA9IGpzb25wQXJyYXkucHVzaC5iaW5kKGpzb25wQXJyYXkpO1xuIFx0anNvbnBBcnJheS5wdXNoID0gd2VicGFja0pzb25wQ2FsbGJhY2s7XG4gXHRqc29ucEFycmF5ID0ganNvbnBBcnJheS5zbGljZSgpO1xuIFx0Zm9yKHZhciBpID0gMDsgaSA8IGpzb25wQXJyYXkubGVuZ3RoOyBpKyspIHdlYnBhY2tKc29ucENhbGxiYWNrKGpzb25wQXJyYXlbaV0pO1xuIFx0dmFyIHBhcmVudEpzb25wRnVuY3Rpb24gPSBvbGRKc29ucEZ1bmN0aW9uO1xuXG5cbiBcdC8vIGFkZCBlbnRyeSBtb2R1bGUgdG8gZGVmZXJyZWQgbGlzdFxuIFx0ZGVmZXJyZWRNb2R1bGVzLnB1c2goW1wiLi9zcmMvanMvYXBwLmpzXCIsXCJ2ZW5kb3JcIl0pO1xuIFx0Ly8gcnVuIGRlZmVycmVkIG1vZHVsZXMgd2hlbiByZWFkeVxuIFx0cmV0dXJuIGNoZWNrRGVmZXJyZWRNb2R1bGVzKCk7XG4iLCJpbXBvcnQgJ2xpdHknO1xuXG5pbXBvcnQgSGVscGVyQ3RybCBmcm9tICcuL2luYy9oZWxwZXInO1xud2luZG93LkhlbHBlciA9IG5ldyBIZWxwZXJDdHJsKCk7XG5cbmltcG9ydCAnLi9pbmMvY29tbW9uJztcbmltcG9ydCAnLi9pbmMvZHJhd2VyJztcbmltcG9ydCAnLi9pbmMvY2F0YWxvZyc7XG5pbXBvcnQgJy4vaW5jL2dtYXAnO1xuXG5pbXBvcnQgJy4vdmVuZG9yL19zd2lwZXInO1xuaW1wb3J0ICcuL3ZlbmRvci9fcG9nby1zbGlkZXInO1xuIiwiZnVuY3Rpb24gQ2F0YWxvZ0N0cmwoKSB7XG5cdHRoaXMuaW5pdCgpO1xufVxuXG5DYXRhbG9nQ3RybC5wcm90b3R5cGUuaW5pdCA9IGZ1bmN0aW9uKCkge1xuXHQkKCcuYnRuLWNhdGFsb2ctaW5mbycpLm9uKCdjbGljaycsIHRoaXMuY2xpY2tJbmZvKTtcblx0dGhpcy5pbWFnZUdhbGxlcnkoKTtcbn1cblxuQ2F0YWxvZ0N0cmwucHJvdG90eXBlLmNsaWNrSW5mbyA9IGZ1bmN0aW9uKCkge1xuXHRjb25zdCBzZWxmID0gJCh0aGlzKTtcblx0Y29uc3QgJHNlbGZfbmV4dCA9IHNlbGYubmV4dCgpO1xuXHRpZiAoJHNlbGZfbmV4dC5oYXNDbGFzcygnaG92ZXInKSkge1xuXHRcdCRzZWxmX25leHQucmVtb3ZlQ2xhc3MoJ2hvdmVyJyk7XG5cdH0gZWxzZSB7XG5cdFx0JCgnLmNhdGFsb2ctY29udGFpbmVyJykuZmluZCgnLmJ0bi1jYXRhbG9nLWluZm8nKS5uZXh0KCkucmVtb3ZlQ2xhc3MoJ2hvdmVyJyk7XG5cdFx0JHNlbGZfbmV4dC5hZGRDbGFzcygnaG92ZXInKTtcblx0fVxufVxuXG5DYXRhbG9nQ3RybC5wcm90b3R5cGUuaW1hZ2VHYWxsZXJ5ID0gZnVuY3Rpb24oZSkge1xuXHRjb25zdCAkdGh1bWJuYWlsID0gJCgnLmNhdGFsb2ctcGljdHVyZS1saXN0LWl0ZW0nKTtcblx0JHRodW1ibmFpbC5vbignY2xpY2snLCBmdW5jdGlvbihlKSB7XG5cdFx0ZS5wcmV2ZW50RGVmYXVsdCgpO1xuXHRcdCR0aHVtYm5haWwucmVtb3ZlQ2xhc3MoJ2FjdGl2ZScpO1xuXHRcdCQodGhpcykuYWRkQ2xhc3MoJ2FjdGl2ZScpO1xuXG5cdFx0dmFyIGRhdGFDYXRhbG9nVGFyZ2V0ID0gJCh0aGlzKS5kYXRhKCdjYXRhbG9nLXRhcmdldCcpO1xuXHRcdHZhciAkY2F0YWxvZ19ib2R5ID0gJCgnW2RhdGEtY2F0YWxvZy1ib2R5PVwiJyArIGRhdGFDYXRhbG9nVGFyZ2V0ICsgJ1wiXScpO1xuXHRcdCQoJy5jYXRhbG9nLXBpY3R1cmUtYm9keScpLmZpbmQoJy5waWMnKS5yZW1vdmVDbGFzcygnYWN0aXZlJyk7XG5cdFx0JGNhdGFsb2dfYm9keS5hZGRDbGFzcygnYWN0aXZlJyk7XG5cdH0pO1xufVxuXG5uZXcgQ2F0YWxvZ0N0cmwoKTsiLCJpbXBvcnQgJCBmcm9tICdqcXVlcnknO1xuaW1wb3J0IEhlbHBlckN0cmwgZnJvbSAnLi9oZWxwZXInO1xuXG5jb25zdCBIZWxwZXIgPSBuZXcgSGVscGVyQ3RybCgpO1xuXG5mdW5jdGlvbiBDb21tb25DdHJsKCkge1xuXHR0aGlzLiR3aW4gPSAkKHdpbmRvdyk7XG5cdHRoaXMuaGVhZGVyUG9zID0gMDtcblxuXHR0aGlzLmFuY2hvclNjcm9sbCA9IHRoaXMuYW5jaG9yU2Nyb2xsLmJpbmQodGhpcyk7XG5cblx0dGhpcy5pbml0KCk7XG59XG5cbkNvbW1vbkN0cmwucHJvdG90eXBlLmluaXQgPSBmdW5jdGlvbigpIHtcblx0JCgnYVtocmVmXj1cIiNcIl0nKS5vbignY2xpY2snLCB0aGlzLmFuY2hvclNjcm9sbCk7XG5cdHRoaXMud2lkZ2V0U2lkZWJhclRvZ2dsZSgpO1xuXHR0aGlzLmJsb2dJZnJhbWUoKTtcblx0dGhpcy5zcEZpeGVkQ29udGVudCgpO1xufVxuXG4vLyDjg5rjg7zjgrjjg4jjg4Pjg5co44K544Oe44Ob5pmC44Gg44GodG91Y2jjgqTjg5njg7Pjg4jjgaDjgajnmbrngavjgYzml6npgY7jgY7jgovjga7jgadjbGlja+WHpueQhilcbkNvbW1vbkN0cmwucHJvdG90eXBlLmFuY2hvclNjcm9sbCA9IGZ1bmN0aW9uKGUpIHtcblx0ZS5wcmV2ZW50RGVmYXVsdCgpO1xuXHR2YXIgaGFzaCA9ICQoZS5jdXJyZW50VGFyZ2V0KS5hdHRyKCdocmVmJyk7XG5cdGlmIChoYXNoID09PSAnIycpIHJldHVybiBmYWxzZTtcblx0dmFyIHRhcmdldCA9ICQoKGhhc2ggPT0gJyMnID8gJ2h0bWwnIDogaGFzaCkpO1xuXHR2YXIgcG9zID0gdGFyZ2V0Lm9mZnNldCgpO1xuXHR2YXIgaGVhZGVyID0gJCgnaGVhZGVyJykuaGVpZ2h0KCkgKyA2MDtcblx0dmFyIGNoZWNrID0gSGVscGVyLmlzTW9iaWxlKCkgPyAwIDogaGVhZGVyO1xuXHR2YXIgc2V0ID0gcG9zLnRvcCAvIDMgLSA1MDA7XG5cdHZhciBzcGVlZCA9IHNldCA+IDUwMCA/IHNldCA6IDUwMDtcblxuXHQkKCdib2R5LGh0bWwnKS5hbmltYXRlKHtcblx0XHRzY3JvbGxUb3A6IHBvcy50b3AgLSBjaGVja1xuXHR9LCBzcGVlZCwgJ2xpbmVhcicpO1xuXHQkKCcjZHJhd2VyJykuYW5pbWF0ZSh7XG5cdFx0c2Nyb2xsVG9wOiBwb3MudG9wIC0gY2hlY2tcblx0fSwgc3BlZWQsICdsaW5lYXInKTtcbn1cblxuQ29tbW9uQ3RybC5wcm90b3R5cGUud2lkZ2V0U2lkZWJhclRvZ2dsZSA9IGZ1bmN0aW9uKCkge1xuXHRjb25zdCAkdGFyZ2V0ICAgICAgID0gJCgnI3dpZGdldC1hcmNoaXZlID4gdWwnKTtcblx0Y29uc3QgJHRnbCAgICAgICAgICA9ICR0YXJnZXQuZmluZCgnLnRnbCcpO1xuXHRjb25zdCAkbGlfdGdsICAgICAgID0gJHRhcmdldC5maW5kKCdsaTpmaXJzdCAudGdsJyk7XG5cdGNvbnN0ICRsaV90Z2xfY2hpbGQgPSAkdGFyZ2V0LmZpbmQoJ2xpOmZpcnN0IC50Z2xfY2hpbGQnKTtcblx0JGxpX3RnbC5hZGRDbGFzcygnb3BlbicpO1xuXHQkbGlfdGdsX2NoaWxkLnNob3coKTtcblx0JHRnbC5vbignY2xpY2snLCBmdW5jdGlvbiAoKSB7XG5cdFx0Y29uc3Qgc2VsZiA9ICQodGhpcyk7XG5cdFx0c2VsZi50b2dnbGVDbGFzcygnb3BlbicpO1xuXHRcdHNlbGYubmV4dCgnLnRnbF9jaGlsZCcpLnN0b3AoKS5zbGlkZVRvZ2dsZSgnZmFzdCcpO1xuXHR9KTtcbn1cblxuQ29tbW9uQ3RybC5wcm90b3R5cGUuYmxvZ0lmcmFtZSA9IGZ1bmN0aW9uKCkge1xuXHRjb25zdCAkdGFyZ2V0ID0gJCgnLnBvc3QtYm9keScpO1xuXG5cdCR0YXJnZXQuZmluZCgnaWZyYW1lJykuZWFjaChmdW5jdGlvbiAoKSB7XG5cdFx0Y29uc3Qgc2VsZiA9ICQodGhpcyk7XG5cdFx0dmFyIGNsYXNzTmFtZSA9ICdpZnJhbWUnO1xuXHRcdHZhciBzcmMgPSBzZWxmLmF0dHIoJ3NyYycpO1xuXHRcdHZhciB3ID0gc2VsZi5hdHRyKCd3aWR0aCcpO1xuXHRcdHZhciBoID0gc2VsZi5hdHRyKCdoZWlnaHQnKTtcblx0XHRpZiAoL3lvdXR1YmVcXC5jb20vLnRlc3Qoc3JjKSkge1xuXHRcdFx0Y2xhc3NOYW1lICs9ICcgaWZyYW1lLXlvdXR1YmUnO1xuXHRcdH1cblx0XHRzZWxmLndyYXAoJzxkaXYgY2xhc3M9XCInICsgY2xhc3NOYW1lICsgJ1wiPjwvZGl2PicpO1xuXHRcdGlmICgkKHRoaXMpLnBhcmVudCgpLmhhc0NsYXNzKCdpZnJhbWUnKSkge1xuXHRcdFx0dmFyIHNpemUgPSAoaCAvIHcgKiAxMDApO1xuXHRcdFx0JCh0aGlzKS5wYXJlbnQoKS5jc3MoJ3BhZGRpbmctYm90dG9tJywgc2l6ZSArICclJyk7XG5cdFx0fVxuXHR9KVxufVxuXG5Db21tb25DdHJsLnByb3RvdHlwZS5zcEZpeGVkQ29udGVudCA9IGZ1bmN0aW9uKCkge1xuXHRjb25zdCAkdGFyZ2V0ID0gJCgnI3NwRml4ZWRDb250YWN0Jyk7XG5cblx0dGhpcy4kd2luLm9uKCdzY3JvbGwnLCBmdW5jdGlvbigpIHtcblx0XHRsZXQgcG9zID0gJCh0aGlzKS5zY3JvbGxUb3AoKTtcblx0XHRpZiAocG9zID4gdGhpcy5oZWFkZXJQb3MpIHtcblx0XHRcdGlmICgkKHRoaXMpLnNjcm9sbFRvcCgpID4gMCkge1xuXHRcdFx0XHQkdGFyZ2V0LmFkZENsYXNzKCdzY3JvbGxkb3duJyk7XG5cdFx0XHR9XG5cdFx0fSBlbHNlIHtcblx0XHRcdCR0YXJnZXQucmVtb3ZlQ2xhc3MoJ3Njcm9sbGRvd24nKTtcblx0XHR9XG5cdFx0dGhpcy5oZWFkZXJQb3MgPSBwb3M7XG5cdH0pO1xufVxuXG5uZXcgQ29tbW9uQ3RybCgpOyIsImltcG9ydCAkIGZyb20gJ2pxdWVyeSc7XG5cbmZ1bmN0aW9uIERyYXdlckN0cmwoKSB7XG5cdHRoaXMuJGJ1dHRvbiAgICAgICAgPSAkKCcjYnRuRHJhd2VyLCNidG5EcmF3ZXJDbG9zZScpO1xuXHR0aGlzLiR0YXJnZXQgICAgICAgID0gJCgnI2RyYXdlciwjZHJhd2VyT3ZlcmxheScpO1xuXHR0aGlzLiR0YXJnZXRPdmVybGF5ID0gJCgnI2RyYXdlck92ZXJsYXknKTtcblx0dGhpcy4kbmF2aSAgICAgICAgICA9ICQoJyNkcmF3ZXJOYXZpJyk7XG5cdHRoaXMuY2xhc3NPcGVuICAgICAgPSAnZHJhd2VyLW9wZW4nO1xuXG5cdHRoaXMuY2xpY2sgID0gdGhpcy5jbGljay5iaW5kKHRoaXMpO1xuXHR0aGlzLnJlbW92ZSA9IHRoaXMucmVtb3ZlLmJpbmQodGhpcyk7XG5cdHRoaXMuYWRkICAgID0gdGhpcy5hZGQuYmluZCh0aGlzKTtcblxuXHR0aGlzLmluaXQoKTtcbn1cblxuRHJhd2VyQ3RybC5wcm90b3R5cGUuaW5pdCA9IGZ1bmN0aW9uKCkge1xuXHR0aGlzLiRidXR0b24ub24oJ2NsaWNrJywgdGhpcy5jbGljayk7XG5cdHRoaXMuJHRhcmdldE92ZXJsYXkub24oJ2NsaWNrJywgdGhpcy5yZW1vdmUpO1xufVxuXG5EcmF3ZXJDdHJsLnByb3RvdHlwZS5jbGljayA9IGZ1bmN0aW9uKCkge1xuXHRpZiAodGhpcy4kdGFyZ2V0Lmhhc0NsYXNzKHRoaXMuY2xhc3NPcGVuKSkge1xuXHRcdHRoaXMucmVtb3ZlKCk7XG5cdH0gZWxzZSB7XG5cdFx0dGhpcy5hZGQoKTtcblx0fVxufVxuXG5EcmF3ZXJDdHJsLnByb3RvdHlwZS5yZW1vdmUgPSBmdW5jdGlvbigpIHtcblx0dGhpcy4kdGFyZ2V0LnJlbW92ZUNsYXNzKHRoaXMuY2xhc3NPcGVuKTtcblx0dGhpcy4kbmF2aS5yZW1vdmVDbGFzcyh0aGlzLmNsYXNzT3Blbik7XG5cdHRoaXMuJGJ1dHRvbi5yZW1vdmVDbGFzcyh0aGlzLmNsYXNzT3Blbik7XG59XG5cbkRyYXdlckN0cmwucHJvdG90eXBlLmFkZCA9IGZ1bmN0aW9uKCkge1xuXHR0aGlzLiR0YXJnZXQuYWRkQ2xhc3ModGhpcy5jbGFzc09wZW4pO1xuXHR0aGlzLiRuYXZpLmFkZENsYXNzKHRoaXMuY2xhc3NPcGVuKTtcblx0dGhpcy4kYnV0dG9uLmFkZENsYXNzKHRoaXMuY2xhc3NPcGVuKTtcbn1cblxubmV3IERyYXdlckN0cmwoKTsiLCJpbXBvcnQgJCBmcm9tICdqcXVlcnknO1xuaW1wb3J0IEhlbHBlckN0cmwgZnJvbSAnLi9oZWxwZXInO1xuXG5jb25zdCBIZWxwZXIgPSBuZXcgSGVscGVyQ3RybCgpO1xuXG5mdW5jdGlvbiBHbWFwQ3RybCgpIHtcblx0dGhpcy5tYXAgPSBudWxsO1xuXG5cdHRoaXMucmVuZGVyX21hcCA9IHRoaXMucmVuZGVyX21hcC5iaW5kKHRoaXMpO1xuXG5cdHRoaXMuaW5pdCgpO1xufVxuXG5HbWFwQ3RybC5wcm90b3R5cGUuaW5pdCA9IGZ1bmN0aW9uKCkge1xuXHRjb25zdCBzZWxmID0gdGhpcztcblx0JCgnLmFjZi1tYXAnKS5lYWNoKGZ1bmN0aW9uKCkge1xuXHRcdHNlbGYubWFwID0gc2VsZi5yZW5kZXJfbWFwKCQodGhpcykpO1xuXHR9KTtcbn1cblxuR21hcEN0cmwucHJvdG90eXBlLnJlbmRlcl9tYXAgPSBmdW5jdGlvbigkZWwpIHtcblx0Y29uc3Qgc2VsZiA9IHRoaXM7XG5cdHZhciAkbWFya2VycyA9ICRlbC5maW5kKCcubWFya2VyJyk7XG5cdHZhciB6b29tcyA9ICRtYXJrZXJzLmF0dHIoJ2RhdGEtem9vbScpO1xuXHR2YXIgZHJhZyA9IEhlbHBlci5pc01vYmlsZSgpID8gZmFsc2UgOiB0cnVlO1xuXG5cdHZhciBhcmdzID0ge1xuXHRcdHpvb206IE51bWJlcih6b29tcyksXG5cdFx0Y2VudGVyOiBuZXcgZ29vZ2xlLm1hcHMuTGF0TG5nKDAsIDApLFxuXHRcdG1hcFR5cGVJZDogZ29vZ2xlLm1hcHMuTWFwVHlwZUlkLlJPQURNQVAsXG5cdFx0c2Nyb2xsd2hlZWw6IGZhbHNlLFxuXHRcdGRyYWdnYWJsZTogZHJhZ1xuXHR9O1xuXHR2YXIgbWFwID0gbmV3IGdvb2dsZS5tYXBzLk1hcCgkZWxbMF0sIGFyZ3MpO1xuXHRtYXAubWFya2VycyA9IFtdO1xuXHQkbWFya2Vycy5lYWNoKGZ1bmN0aW9uICgpIHtcblx0XHRzZWxmLmFkZF9tYXJrZXIoJCh0aGlzKSwgbWFwKTtcblx0fSk7XG5cdC8vIGNlbnRlciBtYXBcblx0dGhpcy5jZW50ZXJfbWFwKG1hcCwgem9vbXMpO1xufVxuXG5HbWFwQ3RybC5wcm90b3R5cGUuYWRkX21hcmtlciA9IGZ1bmN0aW9uKCRtYXJrZXIsIG1hcCkge1xuXHR2YXIgbGF0bG5nID0gbmV3IGdvb2dsZS5tYXBzLkxhdExuZygkbWFya2VyLmF0dHIoJ2RhdGEtbGF0JyksICRtYXJrZXIuYXR0cignZGF0YS1sbmcnKSk7XG5cdHZhciBtYXJrZXIgPSBuZXcgZ29vZ2xlLm1hcHMuTWFya2VyKHtcblx0XHRwb3NpdGlvbjogbGF0bG5nLFxuXHRcdG1hcDogbWFwXG5cdH0pO1xuXHQvLyBhZGQgdG8gYXJyYXlcblx0bWFwLm1hcmtlcnMucHVzaChtYXJrZXIpO1xuXHQvLyBpZiBtYXJrZXIgY29udGFpbnMgSFRNTCwgYWRkIGl0IHRvIGFuIGluZm9XaW5kb3dcblx0aWYgKCRtYXJrZXIuaHRtbCgpKSB7XG5cdFx0Ly8gY3JlYXRlIGluZm8gd2luZG93XG5cdFx0dmFyIGluZm93aW5kb3cgPSBuZXcgZ29vZ2xlLm1hcHMuSW5mb1dpbmRvdyh7XG5cdFx0XHRjb250ZW50OiAkbWFya2VyLmh0bWwoKVxuXHRcdH0pO1xuXHRcdC8vIHNob3cgaW5mbyB3aW5kb3cgd2hlbiBtYXJrZXIgaXMgY2xpY2tlZFxuXHRcdGdvb2dsZS5tYXBzLmV2ZW50LmFkZExpc3RlbmVyKG1hcmtlciwgJ2NsaWNrJywgZnVuY3Rpb24gKCkge1xuXHRcdFx0aW5mb3dpbmRvdy5vcGVuKG1hcCwgbWFya2VyKTtcblx0XHR9KTtcblx0fVxufVxuXG5HbWFwQ3RybC5wcm90b3R5cGUuY2VudGVyX21hcCA9IGZ1bmN0aW9uKG1hcCwgem9vbXMpIHtcblx0dmFyIGJvdW5kcyA9IG5ldyBnb29nbGUubWFwcy5MYXRMbmdCb3VuZHMoKTtcblx0JC5lYWNoKG1hcC5tYXJrZXJzLCBmdW5jdGlvbiAoaSwgbWFya2VyKSB7XG5cdFx0dmFyIGxhdGxuZyA9IG5ldyBnb29nbGUubWFwcy5MYXRMbmcobWFya2VyLnBvc2l0aW9uLmxhdCgpLCBtYXJrZXIucG9zaXRpb24ubG5nKCkpO1xuXHRcdGJvdW5kcy5leHRlbmQobGF0bG5nKTtcblx0fSk7XG5cdGlmIChtYXAubWFya2Vycy5sZW5ndGggPT0gMSkge1xuXHRcdG1hcC5zZXRDZW50ZXIoYm91bmRzLmdldENlbnRlcigpKTtcblx0XHRtYXAuc2V0Wm9vbShOdW1iZXIoem9vbXMpKTtcblx0fSBlbHNlIHtcblx0XHRtYXAuZml0Qm91bmRzKGJvdW5kcyk7XG5cdH1cbn1cblxubmV3IEdtYXBDdHJsKCk7IiwiZnVuY3Rpb24gSGVscGVyQ3RybCgpIHtcblx0dGhpcy5pc1VBID0gdGhpcy5pc1VBLmJpbmQodGhpcyk7XG5cdHRoaXMuaXNNb2JpbGUgPSB0aGlzLmlzTW9iaWxlLmJpbmQodGhpcyk7XG5cdHRoaXMuaXNJRSA9IHRoaXMuaXNJRS5iaW5kKHRoaXMpO1xufVxuXG4vLyBQcm9wZXJ0eSBFeHRlbmRcbkhlbHBlckN0cmwucHJvdG90eXBlLmV4dGVuZCA9IGZ1bmN0aW9uKGV4dDEsIGV4dDIpIHtcblx0Zm9yICh2YXIgcHJvcGVydHkgaW4gZXh0Mikge1xuXHRcdGV4dDFbcHJvcGVydHldID0gZXh0Mltwcm9wZXJ0eV07XG5cdH1cblx0cmV0dXJuIGV4dDE7XG59XG5cbi8vIGlzIFVzZXJBZ2VudCB0cnVlIG1hdGNoXG5IZWxwZXJDdHJsLnByb3RvdHlwZS5pc1VBID0gZnVuY3Rpb24odWEpIHtcblx0dmFyIF91YSA9IHdpbmRvdy5uYXZpZ2F0b3IudXNlckFnZW50LnRvTG93ZXJDYXNlKCk7XG5cdHZhciBuYXZpID0gX3VhLmluZGV4T2YodWEpICE9PSAtMTtcblx0cmV0dXJuIG5hdmk7XG59XG5cbi8vIHBhcmFtIGNoZWNrXG5IZWxwZXJDdHJsLnByb3RvdHlwZS5wYXJhbSA9IGZ1bmN0aW9uKHBhcmFtMSwgcGFyYW0yKSB7XG5cdHZhciBwYXJhbUNoZWNrID0gdHlwZW9mIHBhcmFtMSA9PT0gJ3VuZGVmaW5lZCcgPyBwYXJhbTIgOiBwYXJhbTE7XG5cdHJldHVybiBwYXJhbUNoZWNrO1xufVxuXG4vLyBpcyBtb2JpbGVcbkhlbHBlckN0cmwucHJvdG90eXBlLmlzTW9iaWxlID0gZnVuY3Rpb24oKSB7XG5cdHZhciBpT1MgPSAodGhpcy5pc1VBKCdpcGhvbmUnKSB8fCB0aGlzLmlzVUEoJ2lwb2QnKSk7XG5cdHZhciBBbmRyb2lkID0gKHRoaXMuaXNVQSgnYW5kcm9pZCcpICYmIHRoaXMuaXNVQSgnbW9iaWxlJykpO1xuXHR2YXIgV2luZG93c1Bob25lID0gKHRoaXMuaXNVQSgnd2luZG93cycpICYmIHRoaXMuaXNVQSgncGhvbmUnKSk7XG5cdHZhciBBbmRyb2lkT2xkID0gKHRoaXMuaXNVQSgnZHJlYW0nKSB8fCB0aGlzLmlzVUEoJ2N1cGNha2UnKSk7XG5cdHZhciBGaXJlZm94T1MgPSAodGhpcy5pc1VBKCdmaXJlZm94JykgJiYgdGhpcy5pc1VBKCdtb2JpbGUnKSk7XG5cdHZhciBibGFja2JlcnJ5ID0gdGhpcy5pc1VBKCdibGFja2JlcnJ5Jyk7XG5cblx0cmV0dXJuIChpT1MgfHwgQW5kcm9pZCB8fCBXaW5kb3dzUGhvbmUgfHwgQW5kcm9pZE9sZCB8fCBGaXJlZm94T1MgfHwgYmxhY2tiZXJyeSk7XG59XG5cbi8vIGlzIHRvdWNoXG5IZWxwZXJDdHJsLnByb3RvdHlwZS5pc1RvdWNoID0gZnVuY3Rpb24oKSB7XG5cdHZhciB0b3VjaERldmljZSA9IHR5cGVvZiB3aW5kb3cub250b3VjaHN0YXJ0ICE9PSAndW5kZWZpbmVkJztcblx0cmV0dXJuIHRvdWNoRGV2aWNlO1xufVxuXG4vLyBpcyByb3RhdGVcbkhlbHBlckN0cmwucHJvdG90eXBlLmlzUm90YXRlID0gZnVuY3Rpb24oKSB7XG5cdHJldHVybiBNYXRoLmFicyh3aW5kb3cub3JpZW50YXRpb24gPT09IDkwKTtcbn1cblxuLy8gaXMgW0ludGVybmV0IEV4cGxvcmVyXSB2ZXJzaW9uIGNoZWNrZWQuXG5IZWxwZXJDdHJsLnByb3RvdHlwZS5pc0lFID0gZnVuY3Rpb24oKSB7XG5cdHZhciBtc2llID0gKHRoaXMuaXNVQSgnbXNpZScpIHx8IHRoaXMuaXNVQSgndHJpZGVudCcpKTtcblx0cmV0dXJuIG1zaWU7XG59XG5cbmV4cG9ydCBkZWZhdWx0IEhlbHBlckN0cmw7IiwiaW1wb3J0ICQgZnJvbSAnanF1ZXJ5JztcbmltcG9ydCAncG9nby1zbGlkZXIvanF1ZXJ5LnBvZ28tc2xpZGVyLm1pbic7XG4vLyBpbXBvcnQgJy4vcG9nbyc7XG5cblxuZnVuY3Rpb24gUG9nb1NsaWRlckN0cmwoKSB7XG5cdHRoaXMuJHRhcmdldCA9ICQoJy5wb2dvU2xpZGVyJyk7XG5cdHRoaXMuc2xpZGVyTGVuZ3RoID0gdGhpcy4kdGFyZ2V0LmZpbmQoJy5wb2dvU2xpZGVyLXNsaWRlJykubGVuZ3RoO1xuXHR0aGlzLmZsYWdQbGF5ID0gKHRoaXMuc2xpZGVyTGVuZ3RoID4gMSkgPyB0cnVlIDogZmFsc2U7XG5cdC8vIEdldCB3aW5kb3cuc2xpZGVyT3B0aW9uc1xuXHR0aGlzLnNsaWRlck9wdGlvbnMgPSBzbGlkZXJPcHRpb25zO1xuXG5cdHRoaXMub3B0aW9ucyA9IHRoaXMub3B0aW9ucy5iaW5kKHRoaXMpO1xuXG5cdHRoaXMuaW5pdCgpO1xufVxuXG5Qb2dvU2xpZGVyQ3RybC5wcm90b3R5cGUuaW5pdCA9IGZ1bmN0aW9uKCkge1xuXHR2YXIgZnJvbnRTbGlkZXIgPSB0aGlzLiR0YXJnZXQucG9nb1NsaWRlcih0aGlzLm9wdGlvbnMoKSkuZGF0YSgncGx1Z2luX3BvZ29TbGlkZXInKTtcbn1cblxuUG9nb1NsaWRlckN0cmwucHJvdG90eXBlLm9wdGlvbnMgPSBmdW5jdGlvbigpIHtcblx0dmFyIG9wdGlvbnMgPSB7XG5cdFx0ZGlzcGxheVByb2dyZXNzICAgICAgICA6IHRydWUsXG5cdFx0cHJlc2VydmVUYXJnZXRTaXplICAgICA6IHRydWUsXG5cdFx0cmVzcG9uc2l2ZSAgICAgICAgICAgICA6IHRydWUsXG5cdFx0c2xpZGVUcmFuc2l0aW9uICAgICAgICA6IHRoaXMuc2xpZGVyT3B0aW9ucy5tb2RlLFxuXHRcdHNsaWRlVHJhbnNpdGlvbkR1cmF0aW9uOiB0aGlzLnNsaWRlck9wdGlvbnMuc3BlZWQsXG5cdFx0YnV0dG9uUG9zaXRpb24gICAgICAgICA6ICdDZW50ZXJIb3Jpem9udGFsJyxcblx0XHRuYXZQb3NpdGlvbiAgICAgICAgICAgIDogJ0JvdHRvbScsXG5cdFx0dGFyZ2V0V2lkdGggICAgICAgICAgICA6IDEyMDAsXG5cdFx0dGFyZ2V0SGVpZ2h0ICAgICAgICAgICA6IDU0NCxcblx0XHRwYXVzZU9uSG92ZXIgICAgICAgICAgIDogZmFsc2Vcblx0fTtcblxuXHRpZiAodGhpcy5zbGlkZXJMZW5ndGggPiAxKSB7XG5cdFx0b3B0aW9ucy5hdXRvcGxheVRpbWVvdXQgPSB0aGlzLnNsaWRlck9wdGlvbnMuZGVsYXk7XG5cdFx0b3B0aW9ucy5hdXRvcGxheSAgICAgICAgPSB0cnVlO1xuXHR9XG5cblx0cmV0dXJuIG9wdGlvbnM7XG59XG5cbm5ldyBQb2dvU2xpZGVyQ3RybCgpOyIsImltcG9ydCAkIGZyb20gJ2pxdWVyeSc7XG5pbXBvcnQgU3dpcGVyIGZyb20gJ3N3aXBlcic7XG5pbXBvcnQgSGVscGVyQ3RybCBmcm9tICcuLi9pbmMvaGVscGVyJztcblxuY29uc3QgSGVscGVyID0gbmV3IEhlbHBlckN0cmwoKTtcblxuZnVuY3Rpb24gU3dpcGVyQ3RybCgpIHtcblxuXG5cblx0dGhpcy5icmVhZGNydW1iID0gdGhpcy5icmVhZGNydW1iLmJpbmQodGhpcyk7XG5cdHRoaXMuaW5pdCgpO1xufVxuXG5Td2lwZXJDdHJsLnByb3RvdHlwZS5pbml0ID0gZnVuY3Rpb24oKSB7XG5cdHZhciBicmVhZGNydW1iID0gbmV3IFN3aXBlcignLmJyZWFkLWNvbnRhaW5lcicsIHRoaXMuYnJlYWRjcnVtYigpKTtcblx0dmFyIGNhdGFsb2dDYXJvdXNlbCA9IG5ldyBTd2lwZXIoJy5jYXRhbG9nLXN3aXBlcicsIHRoaXMuY2F0YWxvZ0Nhcm91c2VsKCkpO1xuXHR2YXIgc3RhZmZDYXJvdXNlbCA9IG5ldyBTd2lwZXIoJy5vdGhlci1zdGFmZi1saXN0JywgdGhpcy5zdGFmZkNhcm91c2VsKCkpO1xufVxuXG5Td2lwZXJDdHJsLnByb3RvdHlwZS5icmVhZGNydW1iID0gZnVuY3Rpb24oKSB7XG5cdGNvbnN0ICRicmVhZGNydW1iID0gJCgnLmJyZWFkLWNvbnRhaW5lcicpO1xuXHRjb25zdCBsZW5nID0gJGJyZWFkY3J1bWIuZmluZCgnbGknKS5sZW5ndGg7XG5cdHJldHVybiB7XG5cdFx0c2Nyb2xsYmFyOiB7XG5cdFx0XHRoaWRlOiB0cnVlLFxuXHRcdH0sXG5cdFx0aW5pdGlhbFNsaWRlOiBsZW5nLFxuXHRcdGZyZWVNb2RlOiB0cnVlLFxuXHRcdHNsaWRlc1BlclZpZXc6ICdhdXRvJyxcblx0XHRzcGFjZUJldHdlZW46IDAsXG5cdH1cbn1cblxuU3dpcGVyQ3RybC5wcm90b3R5cGUuY2F0YWxvZ0Nhcm91c2VsID0gZnVuY3Rpb24oKSB7XG5cdGxldCBjZW50ZXIgPSBmYWxzZTtcblx0bGV0IGZyZWUgPSBmYWxzZTtcblx0bGV0IHdoZWVsID0gZmFsc2U7XG5cblx0aWYgKEhlbHBlci5pc01vYmlsZSgpKSB7XG5cdFx0Y2VudGVyID0gdHJ1ZTtcblx0XHRmcmVlID0gdHJ1ZTtcblx0XHR3aGVlbCA9IHRydWU7XG5cdH1cblxuXHRyZXR1cm4ge1xuXHRcdG5hdmlnYXRpb246IHtcblx0XHRcdG5leHRFbDogJy5jYXRhbG9nLWxpc3QtbmV4dCcsXG5cdFx0XHRwcmV2RWw6ICcuY2F0YWxvZy1saXN0LXByZXYnLFxuXHRcdH0sXG5cdFx0c2Nyb2xsYmFyOiB7XG5cdFx0XHRlbDogJy5jYXRhbG9nLXNjcm9sbGJhcicsXG5cdFx0XHRoaWRlOiBmYWxzZSxcblx0XHR9LFxuXHRcdGZyZWVNb2RlOiBmcmVlLFxuXHRcdHNsaWRlc1BlclZpZXc6ICdhdXRvJyxcblx0XHRjZW50ZXJlZFNsaWRlczogY2VudGVyLFxuXHRcdHNwYWNlQmV0d2VlbjogOCxcblx0XHRncmFiQ3Vyc29yOiB0cnVlLFxuXHRcdHNwZWVkOiA4MDAsXG5cdFx0Ly8gYXV0b3BsYXk6IDQwMDAsXG5cdFx0YXV0b3BsYXlEaXNhYmxlT25JbnRlcmFjdGlvbjogZmFsc2UsXG5cdFx0Ly8gbW91c2V3aGVlbENvbnRyb2w6IHRydWVcblx0fVxufVxuXG5Td2lwZXJDdHJsLnByb3RvdHlwZS5zdGFmZkNhcm91c2VsID0gZnVuY3Rpb24oKSB7XG5cdGxldCBjZW50ZXIgPSBmYWxzZTtcblx0aWYgKEhlbHBlci5pc01vYmlsZSgpKSB7XG5cdFx0Y2VudGVyID0gdHJ1ZTtcblx0fVxuXHRyZXR1cm4ge1xuXHRcdC8vIHNjcm9sbGJhcjogJy5jYXQtdGFnLXNjcm9sbGJhcicsXG5cdFx0Ly8gc2Nyb2xsYmFySGlkZTogZmFsc2UsXG5cdFx0Ly8gZnJlZU1vZGU6IHRydWUsXG5cdFx0cGFnaW5hdGlvbjoge1xuXHRcdFx0ZWw6ICcuc3RhZmYtbGlzdC1wYWdpbmF0aW9uJyxcblx0XHRcdGNsaWNrYWJsZTogdHJ1ZVxuXHRcdH0sXG5cdFx0bmF2aWdhdGlvbjoge1xuXHRcdFx0bmV4dEVsOiAnLnN0YWZmLWxpc3QtbmV4dCcsXG5cdFx0XHRwcmV2RWw6ICcuc3RhZmYtbGlzdC1wcmV2Jyxcblx0XHR9LFxuXHRcdHNsaWRlc1BlclZpZXc6ICdhdXRvJyxcblx0XHRjZW50ZXJlZFNsaWRlczogY2VudGVyLFxuXHRcdHNwYWNlQmV0d2VlbjogMzIsXG5cdFx0Z3JhYkN1cnNvcjogdHJ1ZVxuXHR9XG59XG5cbm5ldyBTd2lwZXJDdHJsKCk7Il0sInNvdXJjZVJvb3QiOiIifQ==