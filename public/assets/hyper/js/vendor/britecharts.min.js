(function webpackUniversalModuleDefinition(root, factory) {
	if(typeof exports === 'object' && typeof module === 'object')
		module.exports = factory();
	else if(typeof define === 'function' && define.amd)
		define([], factory);
	else if(typeof exports === 'object')
		exports["britecharts"] = factory();
	else
		root["britecharts"] = factory();
})(this, function() {
return /******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
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
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
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
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 123);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__src_creator__ = __webpack_require__(52);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "creator", function() { return __WEBPACK_IMPORTED_MODULE_0__src_creator__["a"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__src_local__ = __webpack_require__(206);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "local", function() { return __WEBPACK_IMPORTED_MODULE_1__src_local__["a"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__src_matcher__ = __webpack_require__(97);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "matcher", function() { return __WEBPACK_IMPORTED_MODULE_2__src_matcher__["a"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__src_mouse__ = __webpack_require__(207);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "mouse", function() { return __WEBPACK_IMPORTED_MODULE_3__src_mouse__["a"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__src_namespace__ = __webpack_require__(53);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "namespace", function() { return __WEBPACK_IMPORTED_MODULE_4__src_namespace__["a"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5__src_namespaces__ = __webpack_require__(54);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "namespaces", function() { return __WEBPACK_IMPORTED_MODULE_5__src_namespaces__["a"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_6__src_select__ = __webpack_require__(208);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "select", function() { return __WEBPACK_IMPORTED_MODULE_6__src_select__["a"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_7__src_selectAll__ = __webpack_require__(236);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "selectAll", function() { return __WEBPACK_IMPORTED_MODULE_7__src_selectAll__["a"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_8__src_selection_index__ = __webpack_require__(10);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "selection", function() { return __WEBPACK_IMPORTED_MODULE_8__src_selection_index__["b"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_9__src_selector__ = __webpack_require__(58);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "selector", function() { return __WEBPACK_IMPORTED_MODULE_9__src_selector__["a"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_10__src_selectorAll__ = __webpack_require__(98);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "selectorAll", function() { return __WEBPACK_IMPORTED_MODULE_10__src_selectorAll__["a"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_11__src_selection_style__ = __webpack_require__(101);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "style", function() { return __WEBPACK_IMPORTED_MODULE_11__src_selection_style__["b"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_12__src_touch__ = __webpack_require__(237);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "touch", function() { return __WEBPACK_IMPORTED_MODULE_12__src_touch__["a"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_13__src_touches__ = __webpack_require__(238);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "touches", function() { return __WEBPACK_IMPORTED_MODULE_13__src_touches__["a"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_14__src_window__ = __webpack_require__(59);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "window", function() { return __WEBPACK_IMPORTED_MODULE_14__src_window__["a"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_15__src_selection_on__ = __webpack_require__(56);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "event", function() { return __WEBPACK_IMPORTED_MODULE_15__src_selection_on__["c"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "customEvent", function() { return __WEBPACK_IMPORTED_MODULE_15__src_selection_on__["a"]; });


















/***/ }),
/* 1 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__src_bisect__ = __webpack_require__(67);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "bisect", function() { return __WEBPACK_IMPORTED_MODULE_0__src_bisect__["c"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "bisectRight", function() { return __WEBPACK_IMPORTED_MODULE_0__src_bisect__["b"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "bisectLeft", function() { return __WEBPACK_IMPORTED_MODULE_0__src_bisect__["a"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__src_ascending__ = __webpack_require__(24);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "ascending", function() { return __WEBPACK_IMPORTED_MODULE_1__src_ascending__["a"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__src_bisector__ = __webpack_require__(68);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "bisector", function() { return __WEBPACK_IMPORTED_MODULE_2__src_bisector__["a"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__src_cross__ = __webpack_require__(125);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "cross", function() { return __WEBPACK_IMPORTED_MODULE_3__src_cross__["a"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__src_descending__ = __webpack_require__(126);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "descending", function() { return __WEBPACK_IMPORTED_MODULE_4__src_descending__["a"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5__src_deviation__ = __webpack_require__(70);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "deviation", function() { return __WEBPACK_IMPORTED_MODULE_5__src_deviation__["a"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_6__src_extent__ = __webpack_require__(72);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "extent", function() { return __WEBPACK_IMPORTED_MODULE_6__src_extent__["a"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_7__src_histogram__ = __webpack_require__(127);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "histogram", function() { return __WEBPACK_IMPORTED_MODULE_7__src_histogram__["a"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_8__src_threshold_freedmanDiaconis__ = __webpack_require__(130);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "thresholdFreedmanDiaconis", function() { return __WEBPACK_IMPORTED_MODULE_8__src_threshold_freedmanDiaconis__["a"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_9__src_threshold_scott__ = __webpack_require__(131);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "thresholdScott", function() { return __WEBPACK_IMPORTED_MODULE_9__src_threshold_scott__["a"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_10__src_threshold_sturges__ = __webpack_require__(76);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "thresholdSturges", function() { return __WEBPACK_IMPORTED_MODULE_10__src_threshold_sturges__["a"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_11__src_max__ = __webpack_require__(132);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "max", function() { return __WEBPACK_IMPORTED_MODULE_11__src_max__["a"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_12__src_mean__ = __webpack_require__(133);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "mean", function() { return __WEBPACK_IMPORTED_MODULE_12__src_mean__["a"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_13__src_median__ = __webpack_require__(134);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "median", function() { return __WEBPACK_IMPORTED_MODULE_13__src_median__["a"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_14__src_merge__ = __webpack_require__(135);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "merge", function() { return __WEBPACK_IMPORTED_MODULE_14__src_merge__["a"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_15__src_min__ = __webpack_require__(77);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "min", function() { return __WEBPACK_IMPORTED_MODULE_15__src_min__["a"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_16__src_pairs__ = __webpack_require__(69);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "pairs", function() { return __WEBPACK_IMPORTED_MODULE_16__src_pairs__["a"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_17__src_permute__ = __webpack_require__(136);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "permute", function() { return __WEBPACK_IMPORTED_MODULE_17__src_permute__["a"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_18__src_quantile__ = __webpack_require__(43);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "quantile", function() { return __WEBPACK_IMPORTED_MODULE_18__src_quantile__["a"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_19__src_range__ = __webpack_require__(74);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "range", function() { return __WEBPACK_IMPORTED_MODULE_19__src_range__["a"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_20__src_scan__ = __webpack_require__(137);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "scan", function() { return __WEBPACK_IMPORTED_MODULE_20__src_scan__["a"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_21__src_shuffle__ = __webpack_require__(138);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "shuffle", function() { return __WEBPACK_IMPORTED_MODULE_21__src_shuffle__["a"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_22__src_sum__ = __webpack_require__(139);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "sum", function() { return __WEBPACK_IMPORTED_MODULE_22__src_sum__["a"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_23__src_ticks__ = __webpack_require__(75);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "ticks", function() { return __WEBPACK_IMPORTED_MODULE_23__src_ticks__["a"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "tickIncrement", function() { return __WEBPACK_IMPORTED_MODULE_23__src_ticks__["b"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "tickStep", function() { return __WEBPACK_IMPORTED_MODULE_23__src_ticks__["c"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_24__src_transpose__ = __webpack_require__(78);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "transpose", function() { return __WEBPACK_IMPORTED_MODULE_24__src_transpose__["a"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_25__src_variance__ = __webpack_require__(71);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "variance", function() { return __WEBPACK_IMPORTED_MODULE_25__src_variance__["a"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_26__src_zip__ = __webpack_require__(140);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "zip", function() { return __WEBPACK_IMPORTED_MODULE_26__src_zip__["a"]; });





























/***/ }),
/* 2 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (immutable) */ __webpack_exports__["a"] = newInterval;
var t0 = new Date,
    t1 = new Date;

function newInterval(floori, offseti, count, field) {

  function interval(date) {
    return floori(date = new Date(+date)), date;
  }

  interval.floor = interval;

  interval.ceil = function(date) {
    return floori(date = new Date(date - 1)), offseti(date, 1), floori(date), date;
  };

  interval.round = function(date) {
    var d0 = interval(date),
        d1 = interval.ceil(date);
    return date - d0 < d1 - date ? d0 : d1;
  };

  interval.offset = function(date, step) {
    return offseti(date = new Date(+date), step == null ? 1 : Math.floor(step)), date;
  };

  interval.range = function(start, stop, step) {
    var range = [];
    start = interval.ceil(start);
    step = step == null ? 1 : Math.floor(step);
    if (!(start < stop) || !(step > 0)) return range; // also handles Invalid Date
    do range.push(new Date(+start)); while (offseti(start, step), floori(start), start < stop)
    return range;
  };

  interval.filter = function(test) {
    return newInterval(function(date) {
      if (date >= date) while (floori(date), !test(date)) date.setTime(date - 1);
    }, function(date, step) {
      if (date >= date) {
        if (step < 0) while (++step <= 0) {
          while (offseti(date, -1), !test(date)) {} // eslint-disable-line no-empty
        } else while (--step >= 0) {
          while (offseti(date, +1), !test(date)) {} // eslint-disable-line no-empty
        }
      }
    });
  };

  if (count) {
    interval.count = function(start, end) {
      t0.setTime(+start), t1.setTime(+end);
      floori(t0), floori(t1);
      return Math.floor(count(t0, t1));
    };

    interval.every = function(step) {
      step = Math.floor(step);
      return !isFinite(step) || !(step > 0) ? null
          : !(step > 1) ? interval
          : interval.filter(field
              ? function(d) { return field(d) % step === 0; }
              : function(d) { return interval.count(0, d) % step === 0; });
    };
  }

  return interval;
}


/***/ }),
/* 3 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__src_selection_index__ = __webpack_require__(239);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__src_transition_index__ = __webpack_require__(16);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "transition", function() { return __WEBPACK_IMPORTED_MODULE_1__src_transition_index__["b"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__src_active__ = __webpack_require__(260);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "active", function() { return __WEBPACK_IMPORTED_MODULE_2__src_active__["a"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__src_interrupt__ = __webpack_require__(102);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "interrupt", function() { return __WEBPACK_IMPORTED_MODULE_3__src_interrupt__["a"]; });






/***/ }),
/* 4 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__src_linear__ = __webpack_require__(141);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "easeLinear", function() { return __WEBPACK_IMPORTED_MODULE_0__src_linear__["a"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__src_quad__ = __webpack_require__(142);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "easeQuad", function() { return __WEBPACK_IMPORTED_MODULE_1__src_quad__["b"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "easeQuadIn", function() { return __WEBPACK_IMPORTED_MODULE_1__src_quad__["a"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "easeQuadOut", function() { return __WEBPACK_IMPORTED_MODULE_1__src_quad__["c"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "easeQuadInOut", function() { return __WEBPACK_IMPORTED_MODULE_1__src_quad__["b"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__src_cubic__ = __webpack_require__(143);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "easeCubic", function() { return __WEBPACK_IMPORTED_MODULE_2__src_cubic__["b"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "easeCubicIn", function() { return __WEBPACK_IMPORTED_MODULE_2__src_cubic__["a"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "easeCubicOut", function() { return __WEBPACK_IMPORTED_MODULE_2__src_cubic__["c"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "easeCubicInOut", function() { return __WEBPACK_IMPORTED_MODULE_2__src_cubic__["b"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__src_poly__ = __webpack_require__(144);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "easePoly", function() { return __WEBPACK_IMPORTED_MODULE_3__src_poly__["b"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "easePolyIn", function() { return __WEBPACK_IMPORTED_MODULE_3__src_poly__["a"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "easePolyOut", function() { return __WEBPACK_IMPORTED_MODULE_3__src_poly__["c"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "easePolyInOut", function() { return __WEBPACK_IMPORTED_MODULE_3__src_poly__["b"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__src_sin__ = __webpack_require__(145);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "easeSin", function() { return __WEBPACK_IMPORTED_MODULE_4__src_sin__["b"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "easeSinIn", function() { return __WEBPACK_IMPORTED_MODULE_4__src_sin__["a"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "easeSinOut", function() { return __WEBPACK_IMPORTED_MODULE_4__src_sin__["c"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "easeSinInOut", function() { return __WEBPACK_IMPORTED_MODULE_4__src_sin__["b"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5__src_exp__ = __webpack_require__(146);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "easeExp", function() { return __WEBPACK_IMPORTED_MODULE_5__src_exp__["b"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "easeExpIn", function() { return __WEBPACK_IMPORTED_MODULE_5__src_exp__["a"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "easeExpOut", function() { return __WEBPACK_IMPORTED_MODULE_5__src_exp__["c"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "easeExpInOut", function() { return __WEBPACK_IMPORTED_MODULE_5__src_exp__["b"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_6__src_circle__ = __webpack_require__(147);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "easeCircle", function() { return __WEBPACK_IMPORTED_MODULE_6__src_circle__["b"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "easeCircleIn", function() { return __WEBPACK_IMPORTED_MODULE_6__src_circle__["a"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "easeCircleOut", function() { return __WEBPACK_IMPORTED_MODULE_6__src_circle__["c"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "easeCircleInOut", function() { return __WEBPACK_IMPORTED_MODULE_6__src_circle__["b"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_7__src_bounce__ = __webpack_require__(148);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "easeBounce", function() { return __WEBPACK_IMPORTED_MODULE_7__src_bounce__["c"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "easeBounceIn", function() { return __WEBPACK_IMPORTED_MODULE_7__src_bounce__["a"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "easeBounceOut", function() { return __WEBPACK_IMPORTED_MODULE_7__src_bounce__["c"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "easeBounceInOut", function() { return __WEBPACK_IMPORTED_MODULE_7__src_bounce__["b"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_8__src_back__ = __webpack_require__(149);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "easeBack", function() { return __WEBPACK_IMPORTED_MODULE_8__src_back__["b"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "easeBackIn", function() { return __WEBPACK_IMPORTED_MODULE_8__src_back__["a"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "easeBackOut", function() { return __WEBPACK_IMPORTED_MODULE_8__src_back__["c"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "easeBackInOut", function() { return __WEBPACK_IMPORTED_MODULE_8__src_back__["b"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_9__src_elastic__ = __webpack_require__(150);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "easeElastic", function() { return __WEBPACK_IMPORTED_MODULE_9__src_elastic__["c"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "easeElasticIn", function() { return __WEBPACK_IMPORTED_MODULE_9__src_elastic__["a"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "easeElasticOut", function() { return __WEBPACK_IMPORTED_MODULE_9__src_elastic__["c"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "easeElasticInOut", function() { return __WEBPACK_IMPORTED_MODULE_9__src_elastic__["b"]; });





















/***/ }),
/* 5 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
var __WEBPACK_AMD_DEFINE_RESULT__;

!(__WEBPACK_AMD_DEFINE_RESULT__ = function () {

    // Color Gradients
    var colorGradients = {
        greenBlue: ['#39C7EA', '#4CDCBA'],
        orangePink: ['#FBC670', '#F766B8'],
        bluePurple: ['#3DC3C9', '#824a9e']
    };
    var colorGradientsHuman = {
        greenBlue: 'Green to Blue',
        orangePink: 'Orange to Pink',
        bluePurple: 'Blue to Purple'
    };

    // Color Schemas
    // Standard Color Schema for Britecharts
    var britecharts = ['#6aedc7', //green
    '#39c2c9', //blue
    '#ffce00', //yellow
    '#ffa71a', //orange
    '#f866b9', //pink
    '#998ce3' //purple
    ];
    // Grey Palette
    var grey = ['#F8F8FA', '#EFF2F5', '#D2D6DF', '#C3C6CF', '#ADB0B6', '#666A73', '#45494E', '#363A43', '#282C35'];
    // Orange Palette
    var orange = ['#fcc870', '#ffa71a', '#fb8825', '#f6682f', '#db5a2c', '#bf4c28', '#a43b1c', '#892a10', '#f9e9c5'];
    // Blue Palette
    var blueGreen = ['#ccf7f6', '#70e4e0', '#00d8d2', '#00acaf', '#007f8c', '#005e66', '#003c3f', '#002d2f', '#0d2223'];
    // LightBlue Palette
    var teal = ['#ccfffe', '#94f7f4', '#00fff8', '#1de1e1', '#39c2c9', '#2e9a9d', '#227270', '#1a5957', '#133f3e'];
    // Green Palette
    var green = ['#edfff7', '#d7ffef', '#c0ffe7', '#95f5d7', '#6aedc7', '#59c3a3', '#479980', '#34816a', '#206953'];
    // Yellow Palette
    var yellow = ['#f9f2b3', '#fbe986', '#fce05a', '#fed72d', '#ffce00', '#fcc11c', '#f9b438', '#eda629', '#e09819'];
    // Pink Palette
    var pink = ['#fdd1ea', '#fb9cd2', '#f866b9', '#fc40b6', '#ff1ab3', '#e3239d', '#c62c86', '#a62073', '#85135f'];
    // Purple Palette
    var purple = ['#ddd6fc', '#bbb1f0', '#998ce3', '#8e6bc1', '#824a9e', '#77337f', '#6b1c60', '#591650', '#470f3f'];
    // Red Palette
    var red = ['#ffd8d4', '#ffb5b0', '#ff938c', '#ff766c', '#ff584c', '#f04b42', '#e03d38', '#be2e29', '#9c1e19'];

    var colorSchemas = {
        britecharts: britecharts,
        grey: grey,
        orange: orange,
        blueGreen: blueGreen,
        teal: teal,
        green: green,
        yellow: yellow,
        pink: pink,
        purple: purple,
        red: red
    };
    var colorSchemasHuman = {
        'britecharts': 'Britecharts Default',
        'grey': 'Britecharts Grey',
        'orange': 'Orange',
        'blueGreen': 'Blue',
        'teal': 'Light Blue',
        'green': 'Green',
        'yellow': 'Yellow',
        'pink': 'Pink',
        'purple': 'Purple',
        'red': 'Red'
    };

    // Single Colors
    var aloeGreen = ['#7bdcc0']; // To Deprecate
    var greenColor = ['#6aedc7'];
    var blueColor = ['#39c2c9'];
    var yellowColor = ['#ffce00'];
    var orangeColor = ['#ffa71a'];
    var pinkColor = ['#f866b9'];
    var purpleColor = ['#998ce3'];

    var singleColors = {
        aloeGreen: aloeGreen,
        greenColor: greenColor,
        blueColor: blueColor,
        yellowColor: yellowColor,
        orangeColor: orangeColor,
        pinkColor: pinkColor,
        purpleColor: purpleColor
    };
    var singleColorsHuman = {
        aloeGreen: 'Aloe Green',
        greenColor: 'Green',
        blueColor: 'Blue',
        yellowColor: 'Yellow',
        orangeColor: 'Orange',
        pinkColor: 'Pink',
        purpleColor: 'Purple'
    };

    return {
        colorSchemas: colorSchemas,
        colorSchemasHuman: colorSchemasHuman,
        colorGradients: colorGradients,
        colorGradientsHuman: colorGradientsHuman,
        singleColors: singleColors,
        singleColorsHuman: singleColorsHuman
    };
}.call(exports, __webpack_require__, exports, module),
				__WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));

/***/ }),
/* 6 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__src_dispatch__ = __webpack_require__(156);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "dispatch", function() { return __WEBPACK_IMPORTED_MODULE_0__src_dispatch__["a"]; });



/***/ }),
/* 7 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__src_defaultLocale__ = __webpack_require__(157);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "formatDefaultLocale", function() { return __WEBPACK_IMPORTED_MODULE_0__src_defaultLocale__["a"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "format", function() { return __WEBPACK_IMPORTED_MODULE_0__src_defaultLocale__["b"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "formatPrefix", function() { return __WEBPACK_IMPORTED_MODULE_0__src_defaultLocale__["c"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__src_locale__ = __webpack_require__(80);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "formatLocale", function() { return __WEBPACK_IMPORTED_MODULE_1__src_locale__["a"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__src_formatSpecifier__ = __webpack_require__(81);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "formatSpecifier", function() { return __WEBPACK_IMPORTED_MODULE_2__src_formatSpecifier__["a"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__src_precisionFixed__ = __webpack_require__(163);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "precisionFixed", function() { return __WEBPACK_IMPORTED_MODULE_3__src_precisionFixed__["a"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__src_precisionPrefix__ = __webpack_require__(164);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "precisionPrefix", function() { return __WEBPACK_IMPORTED_MODULE_4__src_precisionPrefix__["a"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5__src_precisionRound__ = __webpack_require__(165);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "precisionRound", function() { return __WEBPACK_IMPORTED_MODULE_5__src_precisionRound__["a"]; });








/***/ }),
/* 8 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__src_band__ = __webpack_require__(166);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "scaleBand", function() { return __WEBPACK_IMPORTED_MODULE_0__src_band__["a"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "scalePoint", function() { return __WEBPACK_IMPORTED_MODULE_0__src_band__["b"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__src_identity__ = __webpack_require__(172);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "scaleIdentity", function() { return __WEBPACK_IMPORTED_MODULE_1__src_identity__["a"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__src_linear__ = __webpack_require__(28);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "scaleLinear", function() { return __WEBPACK_IMPORTED_MODULE_2__src_linear__["a"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__src_log__ = __webpack_require__(184);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "scaleLog", function() { return __WEBPACK_IMPORTED_MODULE_3__src_log__["a"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__src_ordinal__ = __webpack_require__(84);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "scaleOrdinal", function() { return __WEBPACK_IMPORTED_MODULE_4__src_ordinal__["a"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "scaleImplicit", function() { return __WEBPACK_IMPORTED_MODULE_4__src_ordinal__["b"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5__src_pow__ = __webpack_require__(185);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "scalePow", function() { return __WEBPACK_IMPORTED_MODULE_5__src_pow__["a"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "scaleSqrt", function() { return __WEBPACK_IMPORTED_MODULE_5__src_pow__["b"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_6__src_quantile__ = __webpack_require__(186);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "scaleQuantile", function() { return __WEBPACK_IMPORTED_MODULE_6__src_quantile__["a"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_7__src_quantize__ = __webpack_require__(187);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "scaleQuantize", function() { return __WEBPACK_IMPORTED_MODULE_7__src_quantize__["a"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_8__src_threshold__ = __webpack_require__(188);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "scaleThreshold", function() { return __WEBPACK_IMPORTED_MODULE_8__src_threshold__["a"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_9__src_time__ = __webpack_require__(94);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "scaleTime", function() { return __WEBPACK_IMPORTED_MODULE_9__src_time__["b"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_10__src_utcTime__ = __webpack_require__(204);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "scaleUtc", function() { return __WEBPACK_IMPORTED_MODULE_10__src_utcTime__["a"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_11__src_sequential__ = __webpack_require__(205);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "scaleSequential", function() { return __WEBPACK_IMPORTED_MODULE_11__src_sequential__["a"]; });

























/***/ }),
/* 9 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__src_value__ = __webpack_require__(48);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "interpolate", function() { return __WEBPACK_IMPORTED_MODULE_0__src_value__["a"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__src_array__ = __webpack_require__(88);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "interpolateArray", function() { return __WEBPACK_IMPORTED_MODULE_1__src_array__["a"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__src_basis__ = __webpack_require__(49);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "interpolateBasis", function() { return __WEBPACK_IMPORTED_MODULE_2__src_basis__["b"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__src_basisClosed__ = __webpack_require__(86);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "interpolateBasisClosed", function() { return __WEBPACK_IMPORTED_MODULE_3__src_basisClosed__["a"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__src_date__ = __webpack_require__(89);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "interpolateDate", function() { return __WEBPACK_IMPORTED_MODULE_4__src_date__["a"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5__src_number__ = __webpack_require__(35);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "interpolateNumber", function() { return __WEBPACK_IMPORTED_MODULE_5__src_number__["a"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_6__src_object__ = __webpack_require__(90);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "interpolateObject", function() { return __WEBPACK_IMPORTED_MODULE_6__src_object__["a"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_7__src_round__ = __webpack_require__(173);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "interpolateRound", function() { return __WEBPACK_IMPORTED_MODULE_7__src_round__["a"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_8__src_string__ = __webpack_require__(91);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "interpolateString", function() { return __WEBPACK_IMPORTED_MODULE_8__src_string__["a"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_9__src_transform_index__ = __webpack_require__(174);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "interpolateTransformCss", function() { return __WEBPACK_IMPORTED_MODULE_9__src_transform_index__["a"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "interpolateTransformSvg", function() { return __WEBPACK_IMPORTED_MODULE_9__src_transform_index__["b"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_10__src_zoom__ = __webpack_require__(177);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "interpolateZoom", function() { return __WEBPACK_IMPORTED_MODULE_10__src_zoom__["a"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_11__src_rgb__ = __webpack_require__(85);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "interpolateRgb", function() { return __WEBPACK_IMPORTED_MODULE_11__src_rgb__["a"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "interpolateRgbBasis", function() { return __WEBPACK_IMPORTED_MODULE_11__src_rgb__["b"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "interpolateRgbBasisClosed", function() { return __WEBPACK_IMPORTED_MODULE_11__src_rgb__["c"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_12__src_hsl__ = __webpack_require__(178);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "interpolateHsl", function() { return __WEBPACK_IMPORTED_MODULE_12__src_hsl__["a"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "interpolateHslLong", function() { return __WEBPACK_IMPORTED_MODULE_12__src_hsl__["b"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_13__src_lab__ = __webpack_require__(179);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "interpolateLab", function() { return __WEBPACK_IMPORTED_MODULE_13__src_lab__["a"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_14__src_hcl__ = __webpack_require__(180);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "interpolateHcl", function() { return __WEBPACK_IMPORTED_MODULE_14__src_hcl__["a"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "interpolateHclLong", function() { return __WEBPACK_IMPORTED_MODULE_14__src_hcl__["b"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_15__src_cubehelix__ = __webpack_require__(181);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "interpolateCubehelix", function() { return __WEBPACK_IMPORTED_MODULE_15__src_cubehelix__["b"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "interpolateCubehelixLong", function() { return __WEBPACK_IMPORTED_MODULE_15__src_cubehelix__["a"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_16__src_quantize__ = __webpack_require__(182);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "quantize", function() { return __WEBPACK_IMPORTED_MODULE_16__src_quantize__["a"]; });



















/***/ }),
/* 10 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "c", function() { return root; });
/* harmony export (immutable) */ __webpack_exports__["a"] = Selection;
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__select__ = __webpack_require__(209);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__selectAll__ = __webpack_require__(210);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__filter__ = __webpack_require__(211);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__data__ = __webpack_require__(212);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__enter__ = __webpack_require__(99);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5__exit__ = __webpack_require__(214);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_6__merge__ = __webpack_require__(215);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_7__order__ = __webpack_require__(216);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_8__sort__ = __webpack_require__(217);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_9__call__ = __webpack_require__(218);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_10__nodes__ = __webpack_require__(219);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_11__node__ = __webpack_require__(220);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_12__size__ = __webpack_require__(221);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_13__empty__ = __webpack_require__(222);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_14__each__ = __webpack_require__(223);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_15__attr__ = __webpack_require__(224);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_16__style__ = __webpack_require__(101);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_17__property__ = __webpack_require__(225);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_18__classed__ = __webpack_require__(226);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_19__text__ = __webpack_require__(227);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_20__html__ = __webpack_require__(228);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_21__raise__ = __webpack_require__(229);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_22__lower__ = __webpack_require__(230);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_23__append__ = __webpack_require__(231);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_24__insert__ = __webpack_require__(232);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_25__remove__ = __webpack_require__(233);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_26__datum__ = __webpack_require__(234);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_27__on__ = __webpack_require__(56);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_28__dispatch__ = __webpack_require__(235);






























var root = [null];

function Selection(groups, parents) {
  this._groups = groups;
  this._parents = parents;
}

function selection() {
  return new Selection([[document.documentElement]], root);
}

Selection.prototype = selection.prototype = {
  constructor: Selection,
  select: __WEBPACK_IMPORTED_MODULE_0__select__["a" /* default */],
  selectAll: __WEBPACK_IMPORTED_MODULE_1__selectAll__["a" /* default */],
  filter: __WEBPACK_IMPORTED_MODULE_2__filter__["a" /* default */],
  data: __WEBPACK_IMPORTED_MODULE_3__data__["a" /* default */],
  enter: __WEBPACK_IMPORTED_MODULE_4__enter__["b" /* default */],
  exit: __WEBPACK_IMPORTED_MODULE_5__exit__["a" /* default */],
  merge: __WEBPACK_IMPORTED_MODULE_6__merge__["a" /* default */],
  order: __WEBPACK_IMPORTED_MODULE_7__order__["a" /* default */],
  sort: __WEBPACK_IMPORTED_MODULE_8__sort__["a" /* default */],
  call: __WEBPACK_IMPORTED_MODULE_9__call__["a" /* default */],
  nodes: __WEBPACK_IMPORTED_MODULE_10__nodes__["a" /* default */],
  node: __WEBPACK_IMPORTED_MODULE_11__node__["a" /* default */],
  size: __WEBPACK_IMPORTED_MODULE_12__size__["a" /* default */],
  empty: __WEBPACK_IMPORTED_MODULE_13__empty__["a" /* default */],
  each: __WEBPACK_IMPORTED_MODULE_14__each__["a" /* default */],
  attr: __WEBPACK_IMPORTED_MODULE_15__attr__["a" /* default */],
  style: __WEBPACK_IMPORTED_MODULE_16__style__["a" /* default */],
  property: __WEBPACK_IMPORTED_MODULE_17__property__["a" /* default */],
  classed: __WEBPACK_IMPORTED_MODULE_18__classed__["a" /* default */],
  text: __WEBPACK_IMPORTED_MODULE_19__text__["a" /* default */],
  html: __WEBPACK_IMPORTED_MODULE_20__html__["a" /* default */],
  raise: __WEBPACK_IMPORTED_MODULE_21__raise__["a" /* default */],
  lower: __WEBPACK_IMPORTED_MODULE_22__lower__["a" /* default */],
  append: __WEBPACK_IMPORTED_MODULE_23__append__["a" /* default */],
  insert: __WEBPACK_IMPORTED_MODULE_24__insert__["a" /* default */],
  remove: __WEBPACK_IMPORTED_MODULE_25__remove__["a" /* default */],
  datum: __WEBPACK_IMPORTED_MODULE_26__datum__["a" /* default */],
  on: __WEBPACK_IMPORTED_MODULE_27__on__["b" /* default */],
  dispatch: __WEBPACK_IMPORTED_MODULE_28__dispatch__["a" /* default */]
};

/* harmony default export */ __webpack_exports__["b"] = (selection);


/***/ }),
/* 11 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* unused harmony export CREATED */
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "c", function() { return SCHEDULED; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "d", function() { return STARTING; });
/* unused harmony export STARTED */
/* unused harmony export RUNNING */
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "b", function() { return ENDING; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return ENDED; });
/* harmony export (immutable) */ __webpack_exports__["g"] = init;
/* harmony export (immutable) */ __webpack_exports__["h"] = set;
/* harmony export (immutable) */ __webpack_exports__["f"] = get;
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_d3_dispatch__ = __webpack_require__(6);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_d3_timer__ = __webpack_require__(103);



var emptyOn = Object(__WEBPACK_IMPORTED_MODULE_0_d3_dispatch__["dispatch"])("start", "end", "interrupt");
var emptyTween = [];

var CREATED = 0;
var SCHEDULED = 1;
var STARTING = 2;
var STARTED = 3;
var RUNNING = 4;
var ENDING = 5;
var ENDED = 6;

/* harmony default export */ __webpack_exports__["e"] = (function(node, name, id, index, group, timing) {
  var schedules = node.__transition;
  if (!schedules) node.__transition = {};
  else if (id in schedules) return;
  create(node, id, {
    name: name,
    index: index, // For context during callback.
    group: group, // For context during callback.
    on: emptyOn,
    tween: emptyTween,
    time: timing.time,
    delay: timing.delay,
    duration: timing.duration,
    ease: timing.ease,
    timer: null,
    state: CREATED
  });
});

function init(node, id) {
  var schedule = node.__transition;
  if (!schedule || !(schedule = schedule[id]) || schedule.state > CREATED) throw new Error("too late");
  return schedule;
}

function set(node, id) {
  var schedule = node.__transition;
  if (!schedule || !(schedule = schedule[id]) || schedule.state > STARTING) throw new Error("too late");
  return schedule;
}

function get(node, id) {
  var schedule = node.__transition;
  if (!schedule || !(schedule = schedule[id])) throw new Error("too late");
  return schedule;
}

function create(node, id, self) {
  var schedules = node.__transition,
      tween;

  // Initialize the self timer when the transition is created.
  // Note the actual delay is not known until the first callback!
  schedules[id] = self;
  self.timer = Object(__WEBPACK_IMPORTED_MODULE_1_d3_timer__["c" /* timer */])(schedule, 0, self.time);

  function schedule(elapsed) {
    self.state = SCHEDULED;
    self.timer.restart(start, self.delay, self.time);

    // If the elapsed delay is less than our first sleep, start immediately.
    if (self.delay <= elapsed) start(elapsed - self.delay);
  }

  function start(elapsed) {
    var i, j, n, o;

    // If the state is not SCHEDULED, then we previously errored on start.
    if (self.state !== SCHEDULED) return stop();

    for (i in schedules) {
      o = schedules[i];
      if (o.name !== self.name) continue;

      // While this element already has a starting transition during this frame,
      // defer starting an interrupting transition until that transition has a
      // chance to tick (and possibly end); see d3/d3-transition#54!
      if (o.state === STARTED) return Object(__WEBPACK_IMPORTED_MODULE_1_d3_timer__["b" /* timeout */])(start);

      // Interrupt the active transition, if any.
      // Dispatch the interrupt event.
      if (o.state === RUNNING) {
        o.state = ENDED;
        o.timer.stop();
        o.on.call("interrupt", node, node.__data__, o.index, o.group);
        delete schedules[i];
      }

      // Cancel any pre-empted transitions. No interrupt event is dispatched
      // because the cancelled transitions never started. Note that this also
      // removes this transition from the pending list!
      else if (+i < id) {
        o.state = ENDED;
        o.timer.stop();
        delete schedules[i];
      }
    }

    // Defer the first tick to end of the current frame; see d3/d3#1576.
    // Note the transition may be canceled after start and before the first tick!
    // Note this must be scheduled before the start event; see d3/d3-transition#16!
    // Assuming this is successful, subsequent callbacks go straight to tick.
    Object(__WEBPACK_IMPORTED_MODULE_1_d3_timer__["b" /* timeout */])(function() {
      if (self.state === STARTED) {
        self.state = RUNNING;
        self.timer.restart(tick, self.delay, self.time);
        tick(elapsed);
      }
    });

    // Dispatch the start event.
    // Note this must be done before the tween are initialized.
    self.state = STARTING;
    self.on.call("start", node, node.__data__, self.index, self.group);
    if (self.state !== STARTING) return; // interrupted
    self.state = STARTED;

    // Initialize the tween, deleting null tween.
    tween = new Array(n = self.tween.length);
    for (i = 0, j = -1; i < n; ++i) {
      if (o = self.tween[i].value.call(node, node.__data__, self.index, self.group)) {
        tween[++j] = o;
      }
    }
    tween.length = j + 1;
  }

  function tick(elapsed) {
    var t = elapsed < self.duration ? self.ease.call(null, elapsed / self.duration) : (self.timer.restart(stop), self.state = ENDING, 1),
        i = -1,
        n = tween.length;

    while (++i < n) {
      tween[i].call(null, t);
    }

    // Dispatch the end event.
    if (self.state === ENDING) {
      self.on.call("end", node, node.__data__, self.index, self.group);
      stop();
    }
  }

  function stop() {
    self.state = ENDED;
    self.timer.stop();
    delete schedules[id];
    for (var i in schedules) return; // eslint-disable-line no-unused-vars
    delete node.__transition;
  }
}


/***/ }),
/* 12 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__src_color__ = __webpack_require__(44);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "color", function() { return __WEBPACK_IMPORTED_MODULE_0__src_color__["e"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "rgb", function() { return __WEBPACK_IMPORTED_MODULE_0__src_color__["g"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "hsl", function() { return __WEBPACK_IMPORTED_MODULE_0__src_color__["f"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__src_lab__ = __webpack_require__(154);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "lab", function() { return __WEBPACK_IMPORTED_MODULE_1__src_lab__["a"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "hcl", function() { return __WEBPACK_IMPORTED_MODULE_1__src_lab__["b"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__src_cubehelix__ = __webpack_require__(155);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "cubehelix", function() { return __WEBPACK_IMPORTED_MODULE_2__src_cubehelix__["a"]; });





/***/ }),
/* 13 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
var __WEBPACK_AMD_DEFINE_RESULT__;

!(__WEBPACK_AMD_DEFINE_RESULT__ = function () {

    var linearGradient = "\n            <defs>\n                <linearGradient id=\"lgrad\" x1=\"0%\" y1=\"50%\" x2=\"100%\" y2=\"50%\" >\n                    <stop offset=\"0\" stop-color=\"#ffffff\" stop-opacity=\"0.8\" />\n                    <stop offset=\"33.33%\" stop-color=\"#ffffff\" stop-opacity=\"0.8\" />\n                    <stop offset=\"50%\" stop-color=\"#ffffff\" stop-opacity=\"0\" />\n                    <stop offset=\"66.66%\" stop-color=\"#ffffff\" stop-opacity=\"0.8\" />\n                    <stop offset=\"100%\" stop-color=\"#ffffff\" stop-opacity=\"0.8\" />\n                </linearGradient>\n            </defs>\n        ";
    var bar = "\n            <svg class=\"load-state bar-load-state\" xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 711 325\">\n              " + linearGradient + "\n                <g fill=\"none\" fill-rule=\"evenodd\">\n                    <g transform=\"translate(0 29)\">\n                        <g stroke=\"#EFF2F5\" stroke-dasharray=\"4 4\">\n                            <path d=\"M.400592911 200.302477L710.674315 200.302477M.400592884 131.172748L710.674315 131.172748M.324410282 64.2071321L710.621499 64.2071321M.291004517.563888874L709.82431.563888889\"/>\n                        </g>\n                        <g fill=\"#D2D6DF\" transform=\"translate(63.08 11)\">\n                            <polygon points=\"-.08 176 23.92 176 23.92 255 -.08 255\"/>\n                            <polygon points=\"50.829 147 74.829 147 74.829 255 50.829 255\"/>\n                            <polygon points=\"254.465 0 278.465 0 278.465 255 254.465 255\"/>\n                            <polygon points=\"458.102 169 482.102 169 482.102 255 458.102 255\"/>\n                            <polygon points=\"152.647 82 176.647 82 176.647 255 152.647 255\"/>\n                            <polygon points=\"356.283 66 380.283 66 380.283 255 356.283 255\"/>\n                            <polygon points=\"559.92 229 583.92 229 583.92 255 559.92 255\"/>\n                            <polygon points=\"101.738 115 125.738 115 125.738 255 101.738 255\"/>\n                            <polygon points=\"305.374 42 329.374 42 329.374 255 305.374 255\"/>\n                            <polygon points=\"509.011 201 533.011 201 533.011 255 509.011 255\"/>\n                            <polygon points=\"203.556 19 227.556 19 227.556 255 203.556 255\"/>\n                            <polygon points=\"407.192 115 431.192 115 431.192 255 407.192 255\"/>\n                        </g>\n                    </g>\n                    <polygon fill=\"#D2D6DF\" fill-rule=\"nonzero\" points=\"0 295 711 295 711 294 0 294\"/>\n                </g>\n                <rect class=\"chart-filter\" fill=\"url(#lgrad)\" x=\"-100%\" y=\"0\" width=\"300%\" height=\"100%\"></rect>\n            </svg>\n        ";
    var donut = "\n            <svg class=\"load-state donut-load-state\" xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 376 331\">\n                " + linearGradient + "\n                <g fill=\"none\" fill-rule=\"evenodd\">\n                    <g transform=\"translate(116 107)\">\n                        <circle cx=\"72\" cy=\"72\" r=\"72\" stroke=\"#EFF2F5\" stroke-linecap=\"round\" stroke-width=\"9.6\"/>\n                        <path stroke=\"#D2D6DF\" stroke-width=\"19.2\" d=\"M126.153559,119.524055 C137.264629,106.845712 144,90.2321371 144,72.0444604 C144,32.2554036 111.764502,0 72,0\"/>\n                        <circle cx=\"72\" cy=\"72\" r=\"67.2\" fill=\"#FFF\"/>\n                    </g>\n                </g>\n                <rect class=\"chart-filter\" fill=\"url(#lgrad)\" x=\"-100%\" y=\"0\" width=\"300%\" height=\"100%\"></rect>\n            </svg>\n        ";
    var line = "\n            <svg\n                class=\"load-state line-load-state\"\n                xmlns=\"http://www.w3.org/2000/svg\"\n                viewBox=\"0 0 711 325\"\n            >\n                " + linearGradient + "\n                <path\n                    id=\"chart-bg\"\n                    class=\"chart-bg\"\n                    style=\"stroke:#C3C6CF;\"\n                    d=\"M3.4,216.5h707.3 M3.4,160.5h707.3 M3.3,103.5h707.3 M3.3,48.5h707.6 M0.4,276.6H710H0.4z\"\n                />\n                <polyline\n                    id=\"chart-line\"\n                    class=\"chart-line\"\n                    style=\"stroke:#C3C6CF;stroke-width:4;fill:none;\"\n                    points=\"8.8,175.8 62.4,237.7 116.1,184.7 169.7,175.8 223.3,57 277,176.8 330.6,176.8 384.3,122.5 437.9,176.8 491.6,176.8 545.2,218.4 598.8,122.5 652.5,184.7 706.1,135.1 \"\n                />\n                <rect class=\"chart-filter\" fill=\"url(#lgrad)\" x=\"-100%\" y=\"0\" width=\"300%\" height=\"100%\"></rect>\n            </svg>\n        ";
    var stackedArea = "\n            <svg\n                class=\"load-state stacked-area-load-state\"\n                xmlns=\"http://www.w3.org/2000/svg\"\n                viewBox=\"0 0 711 325\"\n            >\n                " + linearGradient + "\n                <path\n                    id=\"chart-bg\"\n                    class=\"chart-bg\"\n                    style=\"stroke:#C3C6CF;\"\n                    d=\"M3.4,216.5h707.3 M3.4,160.5h707.3 M3.3,103.5h707.3 M3.3,48.5h707.6 M0.4,276.6H710H0.4z\"\n                />\n                <g transform=\"translate(20 50)\">\n                    <path\n                        id=\"chart-area\"\n                        strokeLinecap=\"square\"\n                        d=\"M0.34233103,0.593688165 L709.977885,0.593688189\"\n                        transform=\"translate(.01 227.976)\"\n                    />\n                    <path fill=\"#C3C6CF\" d=\"M0.528124801,224.014648 L0.528124801,177.734375 L53.3834796,177.734375 C71.5390789,177.734375 86.8277373,168.972754 101.240241,151.662202 C112.578335,138.044258 121.139826,123.110227 136.974507,91.596773 C137.343842,90.8617404 139.300293,86.9654028 139.856735,85.8583549 C155.041692,55.6476711 163.354313,41.0906306 174.319873,27.7179171 C188.951312,9.87459412 204.885845,0.5 223.830634,0.5 C242.123071,0.5 257.291724,8.27027858 270.907992,23.1359289 C281.228683,34.4036118 289.135925,47.1272372 302.542017,72.085092 C303.275893,73.4513345 306.289669,79.0766612 307.063369,80.5168656 C321.41025,107.222876 330.088083,120.97663 341.470704,132.92446 C355.88994,148.05969 371.908861,155.792969 391.654853,155.792969 C412.142049,155.792969 428.763593,152.325614 442.880698,145.765582 C454.197328,140.506893 463.373931,133.679865 473.786035,123.626931 C476.528659,120.978915 486.44777,110.911455 488.791866,108.6483 C502.907223,95.0203436 514.194325,88.9355469 530.135322,88.9355469 C546.532652,88.9355469 559.505909,97.338499 575.973261,115.41103 C579.723508,119.526837 593.103621,135.086814 592.915496,134.871799 C605.09738,148.794859 614.368835,157.635549 625.072091,164.58539 C638.386599,173.230769 652.701021,177.734375 669.279853,177.734375 L673.779853,177.734375 L673.779853,224.014648 L0.528124801,224.014648 Z\" />\n                </g>\n                <rect class=\"chart-filter\" fill=\"url(#lgrad)\" x=\"-100%\" y=\"0\" width=\"300%\" height=\"100%\"></rect>\n            </svg>\n        ";

    return {
        bar: bar,
        donut: donut,
        line: line,
        stackedArea: stackedArea
    };
}.call(exports, __webpack_require__, exports, module),
				__WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));

/***/ }),
/* 14 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "d", function() { return durationSecond; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "c", function() { return durationMinute; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "b", function() { return durationHour; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return durationDay; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "e", function() { return durationWeek; });
var durationSecond = 1e3;
var durationMinute = 6e4;
var durationHour = 36e5;
var durationDay = 864e5;
var durationWeek = 6048e5;


/***/ }),
/* 15 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
var __WEBPACK_AMD_DEFINE_RESULT__;

!(__WEBPACK_AMD_DEFINE_RESULT__ = function (require) {
    'use strict';

    var _require = __webpack_require__(5),
        colorSchemas = _require.colorSchemas;

    var constants = __webpack_require__(20);
    var serializeWithStyles = __webpack_require__(286);

    var isBrowser = typeof window !== 'undefined';
    var isIE = navigator.msSaveOrOpenBlob;
    var IE_ERROR_MSG = 'Sorry, this feature is not available for IE. If you require this to work, check this issue https://github.com/eventbrite/britecharts/pull/652';

    var encoder = isBrowser && window.btoa;

    if (!encoder) {
        encoder = __webpack_require__(287).encode;
    }

    // Base64 doesn't work really well with Unicode strings, so we need to use this function
    // Ref: https://developer.mozilla.org/en-US/docs/Web/API/WindowBase64/Base64_encoding_and_decoding
    var b64EncodeUnicode = function b64EncodeUnicode(str) {
        return encoder(encodeURIComponent(str).replace(/%([0-9A-F]{2})/g, function (match, p1) {
            return String.fromCharCode('0x' + p1);
        }));
    };

    var config = {
        styleClass: 'britechartStyle',
        defaultFilename: 'britechart.png',
        chartBackground: 'white',
        imageSourceBase: 'data:image/svg+xml;base64,',
        titleFontSize: '15px',
        titleFontFamily: '\'Benton Sans\', sans-serif',
        titleTopOffset: 15,
        get styleBackgroundString() {
            return '<style>svg{background:' + this.chartBackground + ';}</style>';
        }
    };

    /**
     * Main function to be used as a method by chart instances to export charts to png
     * @param  {array} svgs         (or an svg element) pass in both chart & legend as array or just chart as svg or in array
     * @param  {string} filename    [download to be called <filename>.png]
     * @param  {string} title       Title for the image
     */
    function exportChart(d3svg, filename, title) {
        if (isIE) {
            // eslint-disable-next-line no-console
            console.error(IE_ERROR_MSG);

            return false;
        }

        var img = createImage(convertSvgToHtml.call(this, d3svg, title));

        img.onload = handleImageLoad.bind(img, createCanvas(this.width(), this.height()), filename);
    }

    /**
     * adds background styles to raw html
     * @param {string} html raw html
     */
    function addBackground(html) {
        return html.replace('>', '>' + config.styleBackgroundString);
    }

    /**
     * Takes the D3 SVG element, adds proper SVG tags, adds inline styles
     * from stylesheets, adds white background and returns string
     * @param  {SVGElement} d3svg   TYPE d3 svg element
     * @return {String}             String of passed d3
     */
    function convertSvgToHtml(d3svg, title) {
        if (!d3svg) {
            return;
        }

        d3svg.attr('version', 1.1).attr('xmlns', 'http://www.w3.org/2000/svg');
        var serializer = serializeWithStyles.initializeSerializer();
        var html = serializer(d3svg.node());

        html = formatHtmlByBrowser(html);
        html = prependTitle.call(this, html, title, parseInt(d3svg.attr('width'), 10));
        html = addBackground(html);

        return html;
    }

    /**
     * Create Canvas
     * @param  {number} width
     * @param  {number} height
     * @return {object} TYPE canvas element
     */
    function createCanvas(width, height) {
        var canvas = document.createElement('canvas');

        canvas.height = height;
        canvas.width = width;

        return canvas;
    }

    /**
     * Create Image
     * @param  {string} svgHtml string representation of svg el
     * @return {object}  TYPE element <img>, src points at svg
     */
    function createImage(svgHtml) {
        var img = new Image();

        img.src = '' + config.imageSourceBase + b64EncodeUnicode(svgHtml);

        return img;
    };

    /**
     * Draws image on canvas
     * @param  {object} image TYPE:el <img>, to be drawn
     * @param  {object} canvas TYPE: el <canvas>, to draw on
     */
    function drawImageOnCanvas(image, canvas) {
        canvas.getContext('2d').drawImage(image, 0, 0);

        return canvas;
    }

    /**
     * Triggers browser to download image, convert canvas to url,
     * we need to append the link el to the dom before clicking it for Firefox to register
     * point <a> at it and trigger click
     * @param  {object} canvas TYPE: el <canvas>
     * @param  {string} filename
     * @param  {string} extensionType
     */
    function downloadCanvas(canvas) {
        var filename = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : config.defaultFilename;
        var extensionType = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : 'image/png';

        var url = canvas.toDataURL(extensionType);
        var link = document.createElement('a');

        link.href = url;
        link.download = filename;
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }

    /**
     * Some browsers need special formatting, we handle that here
     * @param  {string} html string of svg html
     * @return {string} string of svg html
     */
    function formatHtmlByBrowser(html) {
        if (navigator.userAgent.search('FireFox') > -1) {
            return html.replace(/url.*&quot;\)/, 'url(&quot;linearGradient[id*="-gradient-"]&quot;);');
        }

        return html;
    }

    /**
     * Handles on load event fired by img.onload, this=img
     * @param  {object} canvas TYPE: el <canvas>
     * @param  {string} filename
     * @param  {object} e
     */
    function handleImageLoad(canvas, filename, e) {
        e.preventDefault();

        downloadCanvas(drawImageOnCanvas(this, canvas), filename);
    }

    /**
     * if passed, append title to the raw html to appear on graph
     * @param  {string} html     raw html string
     * @param  {string} title    title of the graph
     * @param  {number} svgWidth width of graph container
     * @return {string}         raw html with title prepended
     */
    function prependTitle(html, title, svgWidth) {
        if (!title || !svgWidth) {
            return html;
        }
        var grey = colorSchemas.grey;


        html = html.replace(/<g/, '<text x="' + this.margin().left + '" y="' + config.titleTopOffset + '" font-family="' + config.titleFontFamily + '" font-size="' + config.titleFontSize + '" fill="' + grey[6] + '"> ' + title + ' </text><g ');

        return html;
    }

    return {
        exportChart: exportChart,
        convertSvgToHtml: convertSvgToHtml,
        createImage: createImage,
        drawImageOnCanvas: drawImageOnCanvas
    };
}.call(exports, __webpack_require__, exports, module),
				__WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));

/***/ }),
/* 16 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (immutable) */ __webpack_exports__["a"] = Transition;
/* harmony export (immutable) */ __webpack_exports__["b"] = transition;
/* harmony export (immutable) */ __webpack_exports__["c"] = newId;
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_d3_selection__ = __webpack_require__(0);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__attr__ = __webpack_require__(244);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__attrTween__ = __webpack_require__(245);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__delay__ = __webpack_require__(246);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__duration__ = __webpack_require__(247);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5__ease__ = __webpack_require__(248);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_6__filter__ = __webpack_require__(249);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_7__merge__ = __webpack_require__(250);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_8__on__ = __webpack_require__(251);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_9__remove__ = __webpack_require__(252);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_10__select__ = __webpack_require__(253);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_11__selectAll__ = __webpack_require__(254);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_12__selection__ = __webpack_require__(255);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_13__style__ = __webpack_require__(256);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_14__styleTween__ = __webpack_require__(257);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_15__text__ = __webpack_require__(258);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_16__transition__ = __webpack_require__(259);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_17__tween__ = __webpack_require__(37);



















var id = 0;

function Transition(groups, parents, name, id) {
  this._groups = groups;
  this._parents = parents;
  this._name = name;
  this._id = id;
}

function transition(name) {
  return Object(__WEBPACK_IMPORTED_MODULE_0_d3_selection__["selection"])().transition(name);
}

function newId() {
  return ++id;
}

var selection_prototype = __WEBPACK_IMPORTED_MODULE_0_d3_selection__["selection"].prototype;

Transition.prototype = transition.prototype = {
  constructor: Transition,
  select: __WEBPACK_IMPORTED_MODULE_10__select__["a" /* default */],
  selectAll: __WEBPACK_IMPORTED_MODULE_11__selectAll__["a" /* default */],
  filter: __WEBPACK_IMPORTED_MODULE_6__filter__["a" /* default */],
  merge: __WEBPACK_IMPORTED_MODULE_7__merge__["a" /* default */],
  selection: __WEBPACK_IMPORTED_MODULE_12__selection__["a" /* default */],
  transition: __WEBPACK_IMPORTED_MODULE_16__transition__["a" /* default */],
  call: selection_prototype.call,
  nodes: selection_prototype.nodes,
  node: selection_prototype.node,
  size: selection_prototype.size,
  empty: selection_prototype.empty,
  each: selection_prototype.each,
  on: __WEBPACK_IMPORTED_MODULE_8__on__["a" /* default */],
  attr: __WEBPACK_IMPORTED_MODULE_1__attr__["a" /* default */],
  attrTween: __WEBPACK_IMPORTED_MODULE_2__attrTween__["a" /* default */],
  style: __WEBPACK_IMPORTED_MODULE_13__style__["a" /* default */],
  styleTween: __WEBPACK_IMPORTED_MODULE_14__styleTween__["a" /* default */],
  text: __WEBPACK_IMPORTED_MODULE_15__text__["a" /* default */],
  remove: __WEBPACK_IMPORTED_MODULE_9__remove__["a" /* default */],
  tween: __WEBPACK_IMPORTED_MODULE_17__tween__["a" /* default */],
  delay: __WEBPACK_IMPORTED_MODULE_3__delay__["a" /* default */],
  duration: __WEBPACK_IMPORTED_MODULE_4__duration__["a" /* default */],
  ease: __WEBPACK_IMPORTED_MODULE_5__ease__["a" /* default */]
};


/***/ }),
/* 17 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__src_axis__ = __webpack_require__(151);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "axisTop", function() { return __WEBPACK_IMPORTED_MODULE_0__src_axis__["d"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "axisRight", function() { return __WEBPACK_IMPORTED_MODULE_0__src_axis__["c"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "axisBottom", function() { return __WEBPACK_IMPORTED_MODULE_0__src_axis__["a"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "axisLeft", function() { return __WEBPACK_IMPORTED_MODULE_0__src_axis__["b"]; });



/***/ }),
/* 18 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return map; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "b", function() { return slice; });
var array = Array.prototype;

var map = array.map;
var slice = array.slice;


/***/ }),
/* 19 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__src_defaultLocale__ = __webpack_require__(51);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "timeFormatDefaultLocale", function() { return __WEBPACK_IMPORTED_MODULE_0__src_defaultLocale__["a"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "timeFormat", function() { return __WEBPACK_IMPORTED_MODULE_0__src_defaultLocale__["b"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "timeParse", function() { return __WEBPACK_IMPORTED_MODULE_0__src_defaultLocale__["c"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "utcFormat", function() { return __WEBPACK_IMPORTED_MODULE_0__src_defaultLocale__["d"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "utcParse", function() { return __WEBPACK_IMPORTED_MODULE_0__src_defaultLocale__["e"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__src_locale__ = __webpack_require__(95);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "timeFormatLocale", function() { return __WEBPACK_IMPORTED_MODULE_1__src_locale__["a"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__src_isoFormat__ = __webpack_require__(96);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "isoFormat", function() { return __WEBPACK_IMPORTED_MODULE_2__src_isoFormat__["a"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__src_isoParse__ = __webpack_require__(203);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "isoParse", function() { return __WEBPACK_IMPORTED_MODULE_3__src_isoParse__["a"]; });






/***/ }),
/* 20 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
var __WEBPACK_AMD_DEFINE_RESULT__;

!(__WEBPACK_AMD_DEFINE_RESULT__ = function () {

    var d3Shape = __webpack_require__(21);
    var d3Time = __webpack_require__(25);

    var axisTimeCombinations = {
        MINUTE_HOUR: 'minute-hour',
        HOUR_DAY: 'hour-daymonth',
        DAY_MONTH: 'day-month',
        MONTH_YEAR: 'month-year',
        CUSTOM: 'custom'
    };

    var timeBenchmarks = {
        ONE_AND_A_HALF_YEARS: 47304000000,
        ONE_YEAR: 31536000365,
        ONE_DAY: 86400001
    };

    var curveMap = {
        linear: d3Shape.curveLinear,
        basis: d3Shape.curveBasis,
        cardinal: d3Shape.curveCardinal,
        catmullRom: d3Shape.curveCatmullRom,
        monotoneX: d3Shape.curveMonotoneX,
        monotoneY: d3Shape.curveMonotoneY,
        natural: d3Shape.curveNatural,
        step: d3Shape.curveStep,
        stepAfter: d3Shape.curveStepAfter,
        stepBefore: d3Shape.curveStepBefore
    };

    var emptyDonutData = [{
        'quantity': 1,
        'percentage': 100
    }];

    var timeIntervals = {
        timeMillisecond: d3Time.timeMillisecond,
        utcMillisecond: d3Time.utcMillisecond,
        timeSecond: d3Time.timeSecond,
        utcSecond: d3Time.utcSecond,
        timeMinute: d3Time.timeMinute,
        utcMinute: d3Time.utcMinute,
        timeHour: d3Time.timeHour,
        utcHour: d3Time.utcHour,
        timeDay: d3Time.timeDay,
        utcDay: d3Time.utcDay,
        timeWeek: d3Time.timeWeek,
        utcWeek: d3Time.utcWeek,
        timeSunday: d3Time.timeSunday,
        utcSunday: d3Time.utcSunday,
        timeMonday: d3Time.timeMonday,
        utcMonday: d3Time.utcMonday,
        timeTuesday: d3Time.timeTuesday,
        utcTuesday: d3Time.utcTuesday,
        timeWednesday: d3Time.timeWednesday,
        utcWednesday: d3Time.utcWednesday,
        timeThursday: d3Time.timeThursday,
        utcThursday: d3Time.utcThursday,
        timeFriday: d3Time.timeFriday,
        utcFriday: d3Time.utcFriday,
        timeSaturday: d3Time.timeSaturday,
        utcSaturday: d3Time.utcSaturday,
        timeMonth: d3Time.timeMonth,
        utcMonth: d3Time.utcMonth,
        timeYear: d3Time.timeYear,
        utcYear: d3Time.utcYear
    };

    return {
        axisTimeCombinations: axisTimeCombinations,
        curveMap: curveMap,
        emptyDonutData: emptyDonutData,
        timeBenchmarks: timeBenchmarks,
        lineGradientId: 'lineGradientId',
        timeIntervals: timeIntervals
    };
}.call(exports, __webpack_require__, exports, module),
				__WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));

/***/ }),
/* 21 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__src_arc__ = __webpack_require__(261);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "arc", function() { return __WEBPACK_IMPORTED_MODULE_0__src_arc__["a"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__src_area__ = __webpack_require__(105);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "area", function() { return __WEBPACK_IMPORTED_MODULE_1__src_area__["a"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__src_line__ = __webpack_require__(61);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "line", function() { return __WEBPACK_IMPORTED_MODULE_2__src_line__["a"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__src_pie__ = __webpack_require__(263);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "pie", function() { return __WEBPACK_IMPORTED_MODULE_3__src_pie__["a"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__src_areaRadial__ = __webpack_require__(266);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "areaRadial", function() { return __WEBPACK_IMPORTED_MODULE_4__src_areaRadial__["a"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "radialArea", function() { return __WEBPACK_IMPORTED_MODULE_4__src_areaRadial__["a"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5__src_lineRadial__ = __webpack_require__(107);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "lineRadial", function() { return __WEBPACK_IMPORTED_MODULE_5__src_lineRadial__["a"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "radialLine", function() { return __WEBPACK_IMPORTED_MODULE_5__src_lineRadial__["a"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_6__src_pointRadial__ = __webpack_require__(108);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "pointRadial", function() { return __WEBPACK_IMPORTED_MODULE_6__src_pointRadial__["a"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_7__src_link_index__ = __webpack_require__(267);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "linkHorizontal", function() { return __WEBPACK_IMPORTED_MODULE_7__src_link_index__["a"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "linkVertical", function() { return __WEBPACK_IMPORTED_MODULE_7__src_link_index__["c"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "linkRadial", function() { return __WEBPACK_IMPORTED_MODULE_7__src_link_index__["b"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_8__src_symbol__ = __webpack_require__(268);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "symbol", function() { return __WEBPACK_IMPORTED_MODULE_8__src_symbol__["a"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "symbols", function() { return __WEBPACK_IMPORTED_MODULE_8__src_symbol__["b"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_9__src_symbol_circle__ = __webpack_require__(110);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "symbolCircle", function() { return __WEBPACK_IMPORTED_MODULE_9__src_symbol_circle__["a"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_10__src_symbol_cross__ = __webpack_require__(111);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "symbolCross", function() { return __WEBPACK_IMPORTED_MODULE_10__src_symbol_cross__["a"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_11__src_symbol_diamond__ = __webpack_require__(112);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "symbolDiamond", function() { return __WEBPACK_IMPORTED_MODULE_11__src_symbol_diamond__["a"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_12__src_symbol_square__ = __webpack_require__(114);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "symbolSquare", function() { return __WEBPACK_IMPORTED_MODULE_12__src_symbol_square__["a"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_13__src_symbol_star__ = __webpack_require__(113);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "symbolStar", function() { return __WEBPACK_IMPORTED_MODULE_13__src_symbol_star__["a"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_14__src_symbol_triangle__ = __webpack_require__(115);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "symbolTriangle", function() { return __WEBPACK_IMPORTED_MODULE_14__src_symbol_triangle__["a"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_15__src_symbol_wye__ = __webpack_require__(116);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "symbolWye", function() { return __WEBPACK_IMPORTED_MODULE_15__src_symbol_wye__["a"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_16__src_curve_basisClosed__ = __webpack_require__(269);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "curveBasisClosed", function() { return __WEBPACK_IMPORTED_MODULE_16__src_curve_basisClosed__["a"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_17__src_curve_basisOpen__ = __webpack_require__(270);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "curveBasisOpen", function() { return __WEBPACK_IMPORTED_MODULE_17__src_curve_basisOpen__["a"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_18__src_curve_basis__ = __webpack_require__(41);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "curveBasis", function() { return __WEBPACK_IMPORTED_MODULE_18__src_curve_basis__["b"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_19__src_curve_bundle__ = __webpack_require__(271);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "curveBundle", function() { return __WEBPACK_IMPORTED_MODULE_19__src_curve_bundle__["a"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_20__src_curve_cardinalClosed__ = __webpack_require__(117);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "curveCardinalClosed", function() { return __WEBPACK_IMPORTED_MODULE_20__src_curve_cardinalClosed__["b"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_21__src_curve_cardinalOpen__ = __webpack_require__(118);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "curveCardinalOpen", function() { return __WEBPACK_IMPORTED_MODULE_21__src_curve_cardinalOpen__["b"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_22__src_curve_cardinal__ = __webpack_require__(42);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "curveCardinal", function() { return __WEBPACK_IMPORTED_MODULE_22__src_curve_cardinal__["b"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_23__src_curve_catmullRomClosed__ = __webpack_require__(272);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "curveCatmullRomClosed", function() { return __WEBPACK_IMPORTED_MODULE_23__src_curve_catmullRomClosed__["a"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_24__src_curve_catmullRomOpen__ = __webpack_require__(273);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "curveCatmullRomOpen", function() { return __WEBPACK_IMPORTED_MODULE_24__src_curve_catmullRomOpen__["a"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_25__src_curve_catmullRom__ = __webpack_require__(63);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "curveCatmullRom", function() { return __WEBPACK_IMPORTED_MODULE_25__src_curve_catmullRom__["a"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_26__src_curve_linearClosed__ = __webpack_require__(274);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "curveLinearClosed", function() { return __WEBPACK_IMPORTED_MODULE_26__src_curve_linearClosed__["a"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_27__src_curve_linear__ = __webpack_require__(39);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "curveLinear", function() { return __WEBPACK_IMPORTED_MODULE_27__src_curve_linear__["a"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_28__src_curve_monotone__ = __webpack_require__(275);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "curveMonotoneX", function() { return __WEBPACK_IMPORTED_MODULE_28__src_curve_monotone__["a"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "curveMonotoneY", function() { return __WEBPACK_IMPORTED_MODULE_28__src_curve_monotone__["b"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_29__src_curve_natural__ = __webpack_require__(276);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "curveNatural", function() { return __WEBPACK_IMPORTED_MODULE_29__src_curve_natural__["a"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_30__src_curve_step__ = __webpack_require__(277);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "curveStep", function() { return __WEBPACK_IMPORTED_MODULE_30__src_curve_step__["a"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "curveStepAfter", function() { return __WEBPACK_IMPORTED_MODULE_30__src_curve_step__["b"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "curveStepBefore", function() { return __WEBPACK_IMPORTED_MODULE_30__src_curve_step__["c"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_31__src_stack__ = __webpack_require__(278);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "stack", function() { return __WEBPACK_IMPORTED_MODULE_31__src_stack__["a"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_32__src_offset_expand__ = __webpack_require__(279);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "stackOffsetExpand", function() { return __WEBPACK_IMPORTED_MODULE_32__src_offset_expand__["a"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_33__src_offset_diverging__ = __webpack_require__(280);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "stackOffsetDiverging", function() { return __WEBPACK_IMPORTED_MODULE_33__src_offset_diverging__["a"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_34__src_offset_none__ = __webpack_require__(32);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "stackOffsetNone", function() { return __WEBPACK_IMPORTED_MODULE_34__src_offset_none__["a"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_35__src_offset_silhouette__ = __webpack_require__(281);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "stackOffsetSilhouette", function() { return __WEBPACK_IMPORTED_MODULE_35__src_offset_silhouette__["a"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_36__src_offset_wiggle__ = __webpack_require__(282);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "stackOffsetWiggle", function() { return __WEBPACK_IMPORTED_MODULE_36__src_offset_wiggle__["a"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_37__src_order_ascending__ = __webpack_require__(64);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "stackOrderAscending", function() { return __WEBPACK_IMPORTED_MODULE_37__src_order_ascending__["a"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_38__src_order_descending__ = __webpack_require__(283);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "stackOrderDescending", function() { return __WEBPACK_IMPORTED_MODULE_38__src_order_descending__["a"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_39__src_order_insideOut__ = __webpack_require__(284);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "stackOrderInsideOut", function() { return __WEBPACK_IMPORTED_MODULE_39__src_order_insideOut__["a"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_40__src_order_none__ = __webpack_require__(33);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "stackOrderNone", function() { return __WEBPACK_IMPORTED_MODULE_40__src_order_none__["a"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_41__src_order_reverse__ = __webpack_require__(285);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "stackOrderReverse", function() { return __WEBPACK_IMPORTED_MODULE_41__src_order_reverse__["a"]; });




 // Note: radialArea is deprecated!
 // Note: radialLine is deprecated!









































/***/ }),
/* 22 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony default export */ __webpack_exports__["a"] = (function(x) {
  return function constant() {
    return x;
  };
});


/***/ }),
/* 23 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
var __WEBPACK_AMD_DEFINE_RESULT__;

!(__WEBPACK_AMD_DEFINE_RESULT__ = function (require) {
    'use strict';

    var d3Format = __webpack_require__(7);

    var idCounter = 0;

    var integerValueFormats = {
        small: {
            limit: 10,
            format: d3Format.format('')
        },
        medium: {
            limit: 1000,
            format: d3Format.format('')
        },
        large: {
            limit: null,
            format: d3Format.format('.2s')
        }
    };

    var decimalValueFormats = {
        small: {
            limit: 10,
            format: d3Format.format('.3f')
        },
        medium: {
            limit: 100,
            format: d3Format.format('.1f')
        },
        large: {
            limit: null,
            format: d3Format.format('.2s')
        }
    };

    /**
     * Return a relative size for the value given, based in our decimal or integer tables
     * @param {Number} value    Value to assess its relative size
     * @param {Object} limits   Object stablishing the limits and formats
     * to consider the value of a given size
     */
    var getValueSize = function getValueSize(value, limits) {
        var size = 'large';

        if (value < limits.small.limit) {
            size = 'small';
        } else if (value < limits.medium.limit) {
            size = 'medium';
        }

        return size;
    };

    /**
     * Calculates percentage of value from total
     * @param  {Number}  value    Value to check
     * @param  {Number}  total    Sum of values
     * @param  {String}  decimals Specifies number of decimals https://github.com/d3/d3-format
     * @return {String}           Percentage
     */
    var calculatePercent = function calculatePercent(value, total, decimals) {
        var percent = total ? value / total * 100 : 0;

        return d3Format.format(decimals)(percent);
    };

    /**
     * Checks if a number is an integer or a decimal value
     * @param  {Number}  value Value to check
     * @return {Boolean}       If it is an iteger
     */
    var isInteger = function isInteger(value) {
        return value % 1 === 0;
    };

    /**
     * Formats a floating point value depending on its value range
     * @param  {Number} value Decimal point value to format
     * @return {Number}       Formatted value to show
     */
    var formatDecimalValue = function formatDecimalValue(value) {
        var size = getValueSize(value, decimalValueFormats);
        var format = decimalValueFormats[size].format;

        return format(value);
    };

    /**
     * Formats an integer value depending on its value range
     * @param  {Number} value Decimal point value to format
     * @return {Number}       Formatted value to show
     */
    var formatIntegerValue = function formatIntegerValue(value) {
        var size = getValueSize(value, integerValueFormats);
        var format = integerValueFormats[size].format;

        return format(value);
    };

    /**
     * Generates a unique id with a prefix
     * @param  {String} prefix   Prefix to add before the id
     * @return {String}          Unique id
     */
    var uniqueId = function uniqueId(prefix) {
        var id = ++idCounter;

        return prefix.toString() + '-' + id;
    };

    return {
        calculatePercent: calculatePercent,
        isInteger: isInteger,
        formatDecimalValue: formatDecimalValue,
        formatIntegerValue: formatIntegerValue,
        uniqueId: uniqueId
    };
}.call(exports, __webpack_require__, exports, module),
				__WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));

/***/ }),
/* 24 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony default export */ __webpack_exports__["a"] = (function(a, b) {
  return a < b ? -1 : a > b ? 1 : a >= b ? 0 : NaN;
});


/***/ }),
/* 25 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__src_interval__ = __webpack_require__(2);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "timeInterval", function() { return __WEBPACK_IMPORTED_MODULE_0__src_interval__["a"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__src_millisecond__ = __webpack_require__(189);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "timeMillisecond", function() { return __WEBPACK_IMPORTED_MODULE_1__src_millisecond__["a"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "timeMilliseconds", function() { return __WEBPACK_IMPORTED_MODULE_1__src_millisecond__["b"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "utcMillisecond", function() { return __WEBPACK_IMPORTED_MODULE_1__src_millisecond__["a"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "utcMilliseconds", function() { return __WEBPACK_IMPORTED_MODULE_1__src_millisecond__["b"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__src_second__ = __webpack_require__(190);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "timeSecond", function() { return __WEBPACK_IMPORTED_MODULE_2__src_second__["a"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "timeSeconds", function() { return __WEBPACK_IMPORTED_MODULE_2__src_second__["b"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "utcSecond", function() { return __WEBPACK_IMPORTED_MODULE_2__src_second__["a"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "utcSeconds", function() { return __WEBPACK_IMPORTED_MODULE_2__src_second__["b"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__src_minute__ = __webpack_require__(191);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "timeMinute", function() { return __WEBPACK_IMPORTED_MODULE_3__src_minute__["a"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "timeMinutes", function() { return __WEBPACK_IMPORTED_MODULE_3__src_minute__["b"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__src_hour__ = __webpack_require__(192);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "timeHour", function() { return __WEBPACK_IMPORTED_MODULE_4__src_hour__["a"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "timeHours", function() { return __WEBPACK_IMPORTED_MODULE_4__src_hour__["b"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5__src_day__ = __webpack_require__(193);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "timeDay", function() { return __WEBPACK_IMPORTED_MODULE_5__src_day__["b"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "timeDays", function() { return __WEBPACK_IMPORTED_MODULE_5__src_day__["a"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_6__src_week__ = __webpack_require__(194);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "timeWeek", function() { return __WEBPACK_IMPORTED_MODULE_6__src_week__["g"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "timeWeeks", function() { return __WEBPACK_IMPORTED_MODULE_6__src_week__["h"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "timeSunday", function() { return __WEBPACK_IMPORTED_MODULE_6__src_week__["g"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "timeSundays", function() { return __WEBPACK_IMPORTED_MODULE_6__src_week__["h"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "timeMonday", function() { return __WEBPACK_IMPORTED_MODULE_6__src_week__["c"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "timeMondays", function() { return __WEBPACK_IMPORTED_MODULE_6__src_week__["d"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "timeTuesday", function() { return __WEBPACK_IMPORTED_MODULE_6__src_week__["k"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "timeTuesdays", function() { return __WEBPACK_IMPORTED_MODULE_6__src_week__["l"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "timeWednesday", function() { return __WEBPACK_IMPORTED_MODULE_6__src_week__["m"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "timeWednesdays", function() { return __WEBPACK_IMPORTED_MODULE_6__src_week__["n"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "timeThursday", function() { return __WEBPACK_IMPORTED_MODULE_6__src_week__["i"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "timeThursdays", function() { return __WEBPACK_IMPORTED_MODULE_6__src_week__["j"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "timeFriday", function() { return __WEBPACK_IMPORTED_MODULE_6__src_week__["a"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "timeFridays", function() { return __WEBPACK_IMPORTED_MODULE_6__src_week__["b"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "timeSaturday", function() { return __WEBPACK_IMPORTED_MODULE_6__src_week__["e"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "timeSaturdays", function() { return __WEBPACK_IMPORTED_MODULE_6__src_week__["f"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_7__src_month__ = __webpack_require__(195);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "timeMonth", function() { return __WEBPACK_IMPORTED_MODULE_7__src_month__["a"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "timeMonths", function() { return __WEBPACK_IMPORTED_MODULE_7__src_month__["b"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_8__src_year__ = __webpack_require__(196);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "timeYear", function() { return __WEBPACK_IMPORTED_MODULE_8__src_year__["a"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "timeYears", function() { return __WEBPACK_IMPORTED_MODULE_8__src_year__["b"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_9__src_utcMinute__ = __webpack_require__(197);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "utcMinute", function() { return __WEBPACK_IMPORTED_MODULE_9__src_utcMinute__["a"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "utcMinutes", function() { return __WEBPACK_IMPORTED_MODULE_9__src_utcMinute__["b"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_10__src_utcHour__ = __webpack_require__(198);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "utcHour", function() { return __WEBPACK_IMPORTED_MODULE_10__src_utcHour__["a"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "utcHours", function() { return __WEBPACK_IMPORTED_MODULE_10__src_utcHour__["b"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_11__src_utcDay__ = __webpack_require__(199);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "utcDay", function() { return __WEBPACK_IMPORTED_MODULE_11__src_utcDay__["a"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "utcDays", function() { return __WEBPACK_IMPORTED_MODULE_11__src_utcDay__["b"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_12__src_utcWeek__ = __webpack_require__(200);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "utcWeek", function() { return __WEBPACK_IMPORTED_MODULE_12__src_utcWeek__["g"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "utcWeeks", function() { return __WEBPACK_IMPORTED_MODULE_12__src_utcWeek__["h"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "utcSunday", function() { return __WEBPACK_IMPORTED_MODULE_12__src_utcWeek__["g"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "utcSundays", function() { return __WEBPACK_IMPORTED_MODULE_12__src_utcWeek__["h"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "utcMonday", function() { return __WEBPACK_IMPORTED_MODULE_12__src_utcWeek__["c"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "utcMondays", function() { return __WEBPACK_IMPORTED_MODULE_12__src_utcWeek__["d"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "utcTuesday", function() { return __WEBPACK_IMPORTED_MODULE_12__src_utcWeek__["k"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "utcTuesdays", function() { return __WEBPACK_IMPORTED_MODULE_12__src_utcWeek__["l"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "utcWednesday", function() { return __WEBPACK_IMPORTED_MODULE_12__src_utcWeek__["m"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "utcWednesdays", function() { return __WEBPACK_IMPORTED_MODULE_12__src_utcWeek__["n"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "utcThursday", function() { return __WEBPACK_IMPORTED_MODULE_12__src_utcWeek__["i"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "utcThursdays", function() { return __WEBPACK_IMPORTED_MODULE_12__src_utcWeek__["j"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "utcFriday", function() { return __WEBPACK_IMPORTED_MODULE_12__src_utcWeek__["a"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "utcFridays", function() { return __WEBPACK_IMPORTED_MODULE_12__src_utcWeek__["b"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "utcSaturday", function() { return __WEBPACK_IMPORTED_MODULE_12__src_utcWeek__["e"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "utcSaturdays", function() { return __WEBPACK_IMPORTED_MODULE_12__src_utcWeek__["f"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_13__src_utcMonth__ = __webpack_require__(201);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "utcMonth", function() { return __WEBPACK_IMPORTED_MODULE_13__src_utcMonth__["a"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "utcMonths", function() { return __WEBPACK_IMPORTED_MODULE_13__src_utcMonth__["b"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_14__src_utcYear__ = __webpack_require__(202);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "utcYear", function() { return __WEBPACK_IMPORTED_MODULE_14__src_utcYear__["a"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "utcYears", function() { return __WEBPACK_IMPORTED_MODULE_14__src_utcYear__["b"]; });































/***/ }),
/* 26 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony default export */ __webpack_exports__["a"] = (function(x) {
  return x === null ? NaN : +x;
});


/***/ }),
/* 27 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__src_nest__ = __webpack_require__(167);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "nest", function() { return __WEBPACK_IMPORTED_MODULE_0__src_nest__["a"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__src_set__ = __webpack_require__(168);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "set", function() { return __WEBPACK_IMPORTED_MODULE_1__src_set__["a"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__src_map__ = __webpack_require__(47);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "map", function() { return __WEBPACK_IMPORTED_MODULE_2__src_map__["a"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__src_keys__ = __webpack_require__(169);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "keys", function() { return __WEBPACK_IMPORTED_MODULE_3__src_keys__["a"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__src_values__ = __webpack_require__(170);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "values", function() { return __WEBPACK_IMPORTED_MODULE_4__src_values__["a"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5__src_entries__ = __webpack_require__(171);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "entries", function() { return __WEBPACK_IMPORTED_MODULE_5__src_entries__["a"]; });








/***/ }),
/* 28 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (immutable) */ __webpack_exports__["b"] = linearish;
/* harmony export (immutable) */ __webpack_exports__["a"] = linear;
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_d3_array__ = __webpack_require__(1);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_d3_interpolate__ = __webpack_require__(9);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__continuous__ = __webpack_require__(36);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__tickFormat__ = __webpack_require__(183);





function linearish(scale) {
  var domain = scale.domain;

  scale.ticks = function(count) {
    var d = domain();
    return Object(__WEBPACK_IMPORTED_MODULE_0_d3_array__["ticks"])(d[0], d[d.length - 1], count == null ? 10 : count);
  };

  scale.tickFormat = function(count, specifier) {
    return Object(__WEBPACK_IMPORTED_MODULE_3__tickFormat__["a" /* default */])(domain(), count, specifier);
  };

  scale.nice = function(count) {
    if (count == null) count = 10;

    var d = domain(),
        i0 = 0,
        i1 = d.length - 1,
        start = d[i0],
        stop = d[i1],
        step;

    if (stop < start) {
      step = start, start = stop, stop = step;
      step = i0, i0 = i1, i1 = step;
    }

    step = Object(__WEBPACK_IMPORTED_MODULE_0_d3_array__["tickIncrement"])(start, stop, count);

    if (step > 0) {
      start = Math.floor(start / step) * step;
      stop = Math.ceil(stop / step) * step;
      step = Object(__WEBPACK_IMPORTED_MODULE_0_d3_array__["tickIncrement"])(start, stop, count);
    } else if (step < 0) {
      start = Math.ceil(start * step) / step;
      stop = Math.floor(stop * step) / step;
      step = Object(__WEBPACK_IMPORTED_MODULE_0_d3_array__["tickIncrement"])(start, stop, count);
    }

    if (step > 0) {
      d[i0] = Math.floor(start / step) * step;
      d[i1] = Math.ceil(stop / step) * step;
      domain(d);
    } else if (step < 0) {
      d[i0] = Math.ceil(start * step) / step;
      d[i1] = Math.floor(stop * step) / step;
      domain(d);
    }

    return scale;
  };

  return scale;
}

function linear() {
  var scale = Object(__WEBPACK_IMPORTED_MODULE_2__continuous__["b" /* default */])(__WEBPACK_IMPORTED_MODULE_2__continuous__["c" /* deinterpolateLinear */], __WEBPACK_IMPORTED_MODULE_1_d3_interpolate__["interpolateNumber"]);

  scale.copy = function() {
    return Object(__WEBPACK_IMPORTED_MODULE_2__continuous__["a" /* copy */])(scale, linear());
  };

  return linearish(scale);
}


/***/ }),
/* 29 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (immutable) */ __webpack_exports__["c"] = hue;
/* harmony export (immutable) */ __webpack_exports__["b"] = gamma;
/* harmony export (immutable) */ __webpack_exports__["a"] = nogamma;
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__constant__ = __webpack_require__(87);


function linear(a, d) {
  return function(t) {
    return a + t * d;
  };
}

function exponential(a, b, y) {
  return a = Math.pow(a, y), b = Math.pow(b, y) - a, y = 1 / y, function(t) {
    return Math.pow(a + t * b, y);
  };
}

function hue(a, b) {
  var d = b - a;
  return d ? linear(a, d > 180 || d < -180 ? d - 360 * Math.round(d / 360) : d) : Object(__WEBPACK_IMPORTED_MODULE_0__constant__["a" /* default */])(isNaN(a) ? b : a);
}

function gamma(y) {
  return (y = +y) === 1 ? nogamma : function(a, b) {
    return b - a ? exponential(a, b, y) : Object(__WEBPACK_IMPORTED_MODULE_0__constant__["a" /* default */])(isNaN(a) ? b : a);
  };
}

function nogamma(a, b) {
  var d = b - a;
  return d ? linear(a, d) : Object(__WEBPACK_IMPORTED_MODULE_0__constant__["a" /* default */])(isNaN(a) ? b : a);
}


/***/ }),
/* 30 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__src_path__ = __webpack_require__(262);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return __WEBPACK_IMPORTED_MODULE_0__src_path__["a"]; });



/***/ }),
/* 31 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return abs; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "d", function() { return atan2; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "e", function() { return cos; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "h", function() { return max; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "i", function() { return min; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "k", function() { return sin; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "l", function() { return sqrt; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "f", function() { return epsilon; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "j", function() { return pi; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "g", function() { return halfPi; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "m", function() { return tau; });
/* harmony export (immutable) */ __webpack_exports__["b"] = acos;
/* harmony export (immutable) */ __webpack_exports__["c"] = asin;
var abs = Math.abs;
var atan2 = Math.atan2;
var cos = Math.cos;
var max = Math.max;
var min = Math.min;
var sin = Math.sin;
var sqrt = Math.sqrt;

var epsilon = 1e-12;
var pi = Math.PI;
var halfPi = pi / 2;
var tau = 2 * pi;

function acos(x) {
  return x > 1 ? 0 : x < -1 ? pi : Math.acos(x);
}

function asin(x) {
  return x >= 1 ? halfPi : x <= -1 ? -halfPi : Math.asin(x);
}


/***/ }),
/* 32 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony default export */ __webpack_exports__["a"] = (function(series, order) {
  if (!((n = series.length) > 1)) return;
  for (var i = 1, j, s0, s1 = series[order[0]], n, m = s1.length; i < n; ++i) {
    s0 = s1, s1 = series[order[i]];
    for (j = 0; j < m; ++j) {
      s1[j][1] += s1[j][0] = isNaN(s0[j][1]) ? s0[j][0] : s0[j][1];
    }
  }
});


/***/ }),
/* 33 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony default export */ __webpack_exports__["a"] = (function(series) {
  var n = series.length, o = new Array(n);
  while (--n >= 0) o[n] = n;
  return o;
});


/***/ }),
/* 34 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__formatDecimal__ = __webpack_require__(46);


/* harmony default export */ __webpack_exports__["a"] = (function(x) {
  return x = Object(__WEBPACK_IMPORTED_MODULE_0__formatDecimal__["a" /* default */])(Math.abs(x)), x ? x[1] : NaN;
});


/***/ }),
/* 35 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony default export */ __webpack_exports__["a"] = (function(a, b) {
  return a = +a, b -= a, function(t) {
    return a + b * t;
  };
});


/***/ }),
/* 36 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (immutable) */ __webpack_exports__["c"] = deinterpolateLinear;
/* harmony export (immutable) */ __webpack_exports__["a"] = copy;
/* harmony export (immutable) */ __webpack_exports__["b"] = continuous;
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_d3_array__ = __webpack_require__(1);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_d3_interpolate__ = __webpack_require__(9);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__array__ = __webpack_require__(18);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__constant__ = __webpack_require__(50);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__number__ = __webpack_require__(92);






var unit = [0, 1];

function deinterpolateLinear(a, b) {
  return (b -= (a = +a))
      ? function(x) { return (x - a) / b; }
      : Object(__WEBPACK_IMPORTED_MODULE_3__constant__["a" /* default */])(b);
}

function deinterpolateClamp(deinterpolate) {
  return function(a, b) {
    var d = deinterpolate(a = +a, b = +b);
    return function(x) { return x <= a ? 0 : x >= b ? 1 : d(x); };
  };
}

function reinterpolateClamp(reinterpolate) {
  return function(a, b) {
    var r = reinterpolate(a = +a, b = +b);
    return function(t) { return t <= 0 ? a : t >= 1 ? b : r(t); };
  };
}

function bimap(domain, range, deinterpolate, reinterpolate) {
  var d0 = domain[0], d1 = domain[1], r0 = range[0], r1 = range[1];
  if (d1 < d0) d0 = deinterpolate(d1, d0), r0 = reinterpolate(r1, r0);
  else d0 = deinterpolate(d0, d1), r0 = reinterpolate(r0, r1);
  return function(x) { return r0(d0(x)); };
}

function polymap(domain, range, deinterpolate, reinterpolate) {
  var j = Math.min(domain.length, range.length) - 1,
      d = new Array(j),
      r = new Array(j),
      i = -1;

  // Reverse descending domains.
  if (domain[j] < domain[0]) {
    domain = domain.slice().reverse();
    range = range.slice().reverse();
  }

  while (++i < j) {
    d[i] = deinterpolate(domain[i], domain[i + 1]);
    r[i] = reinterpolate(range[i], range[i + 1]);
  }

  return function(x) {
    var i = Object(__WEBPACK_IMPORTED_MODULE_0_d3_array__["bisect"])(domain, x, 1, j) - 1;
    return r[i](d[i](x));
  };
}

function copy(source, target) {
  return target
      .domain(source.domain())
      .range(source.range())
      .interpolate(source.interpolate())
      .clamp(source.clamp());
}

// deinterpolate(a, b)(x) takes a domain value x in [a,b] and returns the corresponding parameter t in [0,1].
// reinterpolate(a, b)(t) takes a parameter t in [0,1] and returns the corresponding domain value x in [a,b].
function continuous(deinterpolate, reinterpolate) {
  var domain = unit,
      range = unit,
      interpolate = __WEBPACK_IMPORTED_MODULE_1_d3_interpolate__["interpolate"],
      clamp = false,
      piecewise,
      output,
      input;

  function rescale() {
    piecewise = Math.min(domain.length, range.length) > 2 ? polymap : bimap;
    output = input = null;
    return scale;
  }

  function scale(x) {
    return (output || (output = piecewise(domain, range, clamp ? deinterpolateClamp(deinterpolate) : deinterpolate, interpolate)))(+x);
  }

  scale.invert = function(y) {
    return (input || (input = piecewise(range, domain, deinterpolateLinear, clamp ? reinterpolateClamp(reinterpolate) : reinterpolate)))(+y);
  };

  scale.domain = function(_) {
    return arguments.length ? (domain = __WEBPACK_IMPORTED_MODULE_2__array__["a" /* map */].call(_, __WEBPACK_IMPORTED_MODULE_4__number__["a" /* default */]), rescale()) : domain.slice();
  };

  scale.range = function(_) {
    return arguments.length ? (range = __WEBPACK_IMPORTED_MODULE_2__array__["b" /* slice */].call(_), rescale()) : range.slice();
  };

  scale.rangeRound = function(_) {
    return range = __WEBPACK_IMPORTED_MODULE_2__array__["b" /* slice */].call(_), interpolate = __WEBPACK_IMPORTED_MODULE_1_d3_interpolate__["interpolateRound"], rescale();
  };

  scale.clamp = function(_) {
    return arguments.length ? (clamp = !!_, rescale()) : clamp;
  };

  scale.interpolate = function(_) {
    return arguments.length ? (interpolate = _, rescale()) : interpolate;
  };

  return rescale();
}


/***/ }),
/* 37 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (immutable) */ __webpack_exports__["b"] = tweenValue;
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__schedule__ = __webpack_require__(11);


function tweenRemove(id, name) {
  var tween0, tween1;
  return function() {
    var schedule = Object(__WEBPACK_IMPORTED_MODULE_0__schedule__["h" /* set */])(this, id),
        tween = schedule.tween;

    // If this node shared tween with the previous node,
    // just assign the updated shared tween and we’re done!
    // Otherwise, copy-on-write.
    if (tween !== tween0) {
      tween1 = tween0 = tween;
      for (var i = 0, n = tween1.length; i < n; ++i) {
        if (tween1[i].name === name) {
          tween1 = tween1.slice();
          tween1.splice(i, 1);
          break;
        }
      }
    }

    schedule.tween = tween1;
  };
}

function tweenFunction(id, name, value) {
  var tween0, tween1;
  if (typeof value !== "function") throw new Error;
  return function() {
    var schedule = Object(__WEBPACK_IMPORTED_MODULE_0__schedule__["h" /* set */])(this, id),
        tween = schedule.tween;

    // If this node shared tween with the previous node,
    // just assign the updated shared tween and we’re done!
    // Otherwise, copy-on-write.
    if (tween !== tween0) {
      tween1 = (tween0 = tween).slice();
      for (var t = {name: name, value: value}, i = 0, n = tween1.length; i < n; ++i) {
        if (tween1[i].name === name) {
          tween1[i] = t;
          break;
        }
      }
      if (i === n) tween1.push(t);
    }

    schedule.tween = tween1;
  };
}

/* harmony default export */ __webpack_exports__["a"] = (function(name, value) {
  var id = this._id;

  name += "";

  if (arguments.length < 2) {
    var tween = Object(__WEBPACK_IMPORTED_MODULE_0__schedule__["f" /* get */])(this.node(), id).tween;
    for (var i = 0, n = tween.length, t; i < n; ++i) {
      if ((t = tween[i]).name === name) {
        return t.value;
      }
    }
    return null;
  }

  return this.each((value == null ? tweenRemove : tweenFunction)(id, name, value));
});

function tweenValue(transition, name, value) {
  var id = transition._id;

  transition.each(function() {
    var schedule = Object(__WEBPACK_IMPORTED_MODULE_0__schedule__["h" /* set */])(this, id);
    (schedule.value || (schedule.value = {}))[name] = value.apply(this, arguments);
  });

  return function(node) {
    return Object(__WEBPACK_IMPORTED_MODULE_0__schedule__["f" /* get */])(node, id).value[name];
  };
}


/***/ }),
/* 38 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
var __WEBPACK_AMD_DEFINE_RESULT__;

!(__WEBPACK_AMD_DEFINE_RESULT__ = function (require) {

    var d3Selection = __webpack_require__(0);

    var wrapConfig = {
        lineHeight: 1.2,
        smallTextOffset: 10,
        smallTextLineHeightRatio: 0.9,
        smallTextRatio: 0.6,
        valueClassName: 'value',
        labelClassName: 'label'
    };

    var defaultTextSize = 12;
    var defaultFontFace = 'Arial';

    /**
     * Wraps a selection of text within the available width
     * @param  {Number} xOffset        X axis offset for the text
     * @param  {Number} fontSize       Size of the base font
     * @param  {Number} availableWidth Width of the container where the text needs to wrap on
     * @param  {D3Selection} node      SVG text element that contains the text to wrap
     *
     * REF: http://bl.ocks.org/mbostock/7555321
     * More discussions on https://github.com/mbostock/d3/issues/1642
     * @return {void}
     */
    var wrapText = function wrapText(xOffset, fontSize, availableWidth, node) {
        var text = d3Selection.select(node),
            words = text.text().split(/\s+/).reverse(),
            word = void 0,
            line = [],
            lineNumber = 0,
            smallLineHeight = wrapConfig.lineHeight * wrapConfig.smallTextLineHeightRatio,
            y = text.attr('y'),
            dy = parseFloat(text.attr('dy')),
            smallFontSize = fontSize * wrapConfig.smallTextRatio,
            tspan = text.text(null).append('tspan').attr('x', xOffset).attr('y', y - 5).attr('dy', dy + 'em').classed(wrapConfig.valueClassName, true).style('font-size', fontSize + 'px');

        tspan.text(words.pop());
        tspan = text.append('tspan').classed(wrapConfig.labelClassName, true).attr('x', xOffset).attr('y', y + wrapConfig.smallTextOffset).attr('dy', ++lineNumber * smallLineHeight + dy + 'em').style('font-size', smallFontSize + 'px');

        while (word = words.pop()) {
            line.push(word);
            tspan.text(line.join(' '));
            if (tspan.node() && tspan.node().getComputedTextLength() > availableWidth - 50) {
                line.pop();
                tspan.text(line.join(' '));
                line = [word];
                tspan = text.append('tspan').classed(wrapConfig.labelClassName, true).attr('x', xOffset).attr('y', y + wrapConfig.smallTextOffset).attr('dy', ++lineNumber * smallLineHeight + dy + 'em').text(word).style('font-size', smallFontSize + 'px');
            }
        }
    };

    /**
     * Wraps a selection of text within the available width, also adds class .adjust-upwards
     * to configure a y offset for entries with multiple rows
     * @param  {D3Selection} text       D3 text element
     * @param  {Number} width           Width of the container where the text needs to wrap on
     * @param  {Number} [xpos=0]        Number passed to determine the x offset
     * @param  {Number} [limit=2]       Number of lines before an ellipses is added and the rest of the text is cut off
     *
     * REF: http://bl.ocks.org/mbostock/7555321
     * More discussions on https://github.com/mbostock/d3/issues/1642
     * @return {void}
     */
    var wrapTextWithEllipses = function wrapTextWithEllipses(text, width) {
        var xpos = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : 0;
        var limit = arguments.length > 3 && arguments[3] !== undefined ? arguments[3] : 2;

        text.each(function () {
            var words, word, line, lineNumber, lineHeight, y, dy, tspan;

            text = d3Selection.select(this);

            words = text.text().split(/\s+/).reverse();
            line = [];
            lineNumber = 0;
            lineHeight = 1.2;
            y = text.attr('y');
            dy = parseFloat(text.attr('dy'));
            tspan = text.text(null).append('tspan').attr('x', xpos).attr('y', y).attr('dy', dy + 'em');

            while (word = words.pop()) {
                line.push(word);
                tspan.text(line.join(' '));

                if (tspan.node() && tspan.node().getComputedTextLength() > width) {
                    line.pop();
                    tspan.text(line.join(' '));

                    if (lineNumber < limit - 1) {
                        line = [word];
                        tspan = text.append('tspan').attr('x', xpos).attr('y', y).attr('dy', ++lineNumber * lineHeight + dy + 'em').text(word);
                        // if we need two lines for the text, move them both up to center them
                        text.classed('adjust-upwards', true);
                    } else {
                        line.push('...');
                        tspan.text(line.join(' '));
                        break;
                    }
                }
            }
        });
    };

    /**
     * Figures out an approximate of the text width by using a canvas element
     * This avoids having to actually render the text to measure it from the DOM itself
     * @param  {String} text                Text to measure
     * @param  {Number} [fontSize=12]       Font size (or default)
     * @param  {String} [fontFace='Arial']  Font family to use in the calculation (or default)
     * @return {String}                     Approximated width of the text
     */
    var getTextWidth = function getTextWidth(text) {
        var fontSize = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : defaultTextSize;
        var fontFace = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : defaultFontFace;

        var a = document.createElement('canvas'),
            b = a.getContext('2d');

        b.font = fontSize + 'px ' + fontFace;

        return b.measureText(text).width;
    };

    return {
        getTextWidth: getTextWidth,
        wrapText: wrapText,
        wrapTextWithEllipses: wrapTextWithEllipses
    };
}.call(exports, __webpack_require__, exports, module),
				__WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));

/***/ }),
/* 39 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
function Linear(context) {
  this._context = context;
}

Linear.prototype = {
  areaStart: function() {
    this._line = 0;
  },
  areaEnd: function() {
    this._line = NaN;
  },
  lineStart: function() {
    this._point = 0;
  },
  lineEnd: function() {
    if (this._line || (this._line !== 0 && this._point === 1)) this._context.closePath();
    this._line = 1 - this._line;
  },
  point: function(x, y) {
    x = +x, y = +y;
    switch (this._point) {
      case 0: this._point = 1; this._line ? this._context.lineTo(x, y) : this._context.moveTo(x, y); break;
      case 1: this._point = 2; // proceed
      default: this._context.lineTo(x, y); break;
    }
  }
};

/* harmony default export */ __webpack_exports__["a"] = (function(context) {
  return new Linear(context);
});


/***/ }),
/* 40 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony default export */ __webpack_exports__["a"] = (function() {});


/***/ }),
/* 41 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (immutable) */ __webpack_exports__["c"] = point;
/* harmony export (immutable) */ __webpack_exports__["a"] = Basis;
function point(that, x, y) {
  that._context.bezierCurveTo(
    (2 * that._x0 + that._x1) / 3,
    (2 * that._y0 + that._y1) / 3,
    (that._x0 + 2 * that._x1) / 3,
    (that._y0 + 2 * that._y1) / 3,
    (that._x0 + 4 * that._x1 + x) / 6,
    (that._y0 + 4 * that._y1 + y) / 6
  );
}

function Basis(context) {
  this._context = context;
}

Basis.prototype = {
  areaStart: function() {
    this._line = 0;
  },
  areaEnd: function() {
    this._line = NaN;
  },
  lineStart: function() {
    this._x0 = this._x1 =
    this._y0 = this._y1 = NaN;
    this._point = 0;
  },
  lineEnd: function() {
    switch (this._point) {
      case 3: point(this, this._x1, this._y1); // proceed
      case 2: this._context.lineTo(this._x1, this._y1); break;
    }
    if (this._line || (this._line !== 0 && this._point === 1)) this._context.closePath();
    this._line = 1 - this._line;
  },
  point: function(x, y) {
    x = +x, y = +y;
    switch (this._point) {
      case 0: this._point = 1; this._line ? this._context.lineTo(x, y) : this._context.moveTo(x, y); break;
      case 1: this._point = 2; break;
      case 2: this._point = 3; this._context.lineTo((5 * this._x0 + this._x1) / 6, (5 * this._y0 + this._y1) / 6); // proceed
      default: point(this, x, y); break;
    }
    this._x0 = this._x1, this._x1 = x;
    this._y0 = this._y1, this._y1 = y;
  }
};

/* harmony default export */ __webpack_exports__["b"] = (function(context) {
  return new Basis(context);
});


/***/ }),
/* 42 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (immutable) */ __webpack_exports__["c"] = point;
/* harmony export (immutable) */ __webpack_exports__["a"] = Cardinal;
function point(that, x, y) {
  that._context.bezierCurveTo(
    that._x1 + that._k * (that._x2 - that._x0),
    that._y1 + that._k * (that._y2 - that._y0),
    that._x2 + that._k * (that._x1 - x),
    that._y2 + that._k * (that._y1 - y),
    that._x2,
    that._y2
  );
}

function Cardinal(context, tension) {
  this._context = context;
  this._k = (1 - tension) / 6;
}

Cardinal.prototype = {
  areaStart: function() {
    this._line = 0;
  },
  areaEnd: function() {
    this._line = NaN;
  },
  lineStart: function() {
    this._x0 = this._x1 = this._x2 =
    this._y0 = this._y1 = this._y2 = NaN;
    this._point = 0;
  },
  lineEnd: function() {
    switch (this._point) {
      case 2: this._context.lineTo(this._x2, this._y2); break;
      case 3: point(this, this._x1, this._y1); break;
    }
    if (this._line || (this._line !== 0 && this._point === 1)) this._context.closePath();
    this._line = 1 - this._line;
  },
  point: function(x, y) {
    x = +x, y = +y;
    switch (this._point) {
      case 0: this._point = 1; this._line ? this._context.lineTo(x, y) : this._context.moveTo(x, y); break;
      case 1: this._point = 2; this._x1 = x, this._y1 = y; break;
      case 2: this._point = 3; // proceed
      default: point(this, x, y); break;
    }
    this._x0 = this._x1, this._x1 = this._x2, this._x2 = x;
    this._y0 = this._y1, this._y1 = this._y2, this._y2 = y;
  }
};

/* harmony default export */ __webpack_exports__["b"] = ((function custom(tension) {

  function cardinal(context) {
    return new Cardinal(context, tension);
  }

  cardinal.tension = function(tension) {
    return custom(+tension);
  };

  return cardinal;
})(0));


/***/ }),
/* 43 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__number__ = __webpack_require__(26);


/* harmony default export */ __webpack_exports__["a"] = (function(values, p, valueof) {
  if (valueof == null) valueof = __WEBPACK_IMPORTED_MODULE_0__number__["a" /* default */];
  if (!(n = values.length)) return;
  if ((p = +p) <= 0 || n < 2) return +valueof(values[0], 0, values);
  if (p >= 1) return +valueof(values[n - 1], n - 1, values);
  var n,
      i = (n - 1) * p,
      i0 = Math.floor(i),
      value0 = +valueof(values[i0], i0, values),
      value1 = +valueof(values[i0 + 1], i0 + 1, values);
  return value0 + (value1 - value0) * (i - i0);
});


/***/ }),
/* 44 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (immutable) */ __webpack_exports__["a"] = Color;
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "d", function() { return darker; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "c", function() { return brighter; });
/* harmony export (immutable) */ __webpack_exports__["e"] = color;
/* harmony export (immutable) */ __webpack_exports__["h"] = rgbConvert;
/* harmony export (immutable) */ __webpack_exports__["g"] = rgb;
/* harmony export (immutable) */ __webpack_exports__["b"] = Rgb;
/* unused harmony export hslConvert */
/* harmony export (immutable) */ __webpack_exports__["f"] = hsl;
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__define__ = __webpack_require__(45);


function Color() {}

var darker = 0.7;
var brighter = 1 / darker;

var reI = "\\s*([+-]?\\d+)\\s*",
    reN = "\\s*([+-]?\\d*\\.?\\d+(?:[eE][+-]?\\d+)?)\\s*",
    reP = "\\s*([+-]?\\d*\\.?\\d+(?:[eE][+-]?\\d+)?)%\\s*",
    reHex3 = /^#([0-9a-f]{3})$/,
    reHex6 = /^#([0-9a-f]{6})$/,
    reRgbInteger = new RegExp("^rgb\\(" + [reI, reI, reI] + "\\)$"),
    reRgbPercent = new RegExp("^rgb\\(" + [reP, reP, reP] + "\\)$"),
    reRgbaInteger = new RegExp("^rgba\\(" + [reI, reI, reI, reN] + "\\)$"),
    reRgbaPercent = new RegExp("^rgba\\(" + [reP, reP, reP, reN] + "\\)$"),
    reHslPercent = new RegExp("^hsl\\(" + [reN, reP, reP] + "\\)$"),
    reHslaPercent = new RegExp("^hsla\\(" + [reN, reP, reP, reN] + "\\)$");

var named = {
  aliceblue: 0xf0f8ff,
  antiquewhite: 0xfaebd7,
  aqua: 0x00ffff,
  aquamarine: 0x7fffd4,
  azure: 0xf0ffff,
  beige: 0xf5f5dc,
  bisque: 0xffe4c4,
  black: 0x000000,
  blanchedalmond: 0xffebcd,
  blue: 0x0000ff,
  blueviolet: 0x8a2be2,
  brown: 0xa52a2a,
  burlywood: 0xdeb887,
  cadetblue: 0x5f9ea0,
  chartreuse: 0x7fff00,
  chocolate: 0xd2691e,
  coral: 0xff7f50,
  cornflowerblue: 0x6495ed,
  cornsilk: 0xfff8dc,
  crimson: 0xdc143c,
  cyan: 0x00ffff,
  darkblue: 0x00008b,
  darkcyan: 0x008b8b,
  darkgoldenrod: 0xb8860b,
  darkgray: 0xa9a9a9,
  darkgreen: 0x006400,
  darkgrey: 0xa9a9a9,
  darkkhaki: 0xbdb76b,
  darkmagenta: 0x8b008b,
  darkolivegreen: 0x556b2f,
  darkorange: 0xff8c00,
  darkorchid: 0x9932cc,
  darkred: 0x8b0000,
  darksalmon: 0xe9967a,
  darkseagreen: 0x8fbc8f,
  darkslateblue: 0x483d8b,
  darkslategray: 0x2f4f4f,
  darkslategrey: 0x2f4f4f,
  darkturquoise: 0x00ced1,
  darkviolet: 0x9400d3,
  deeppink: 0xff1493,
  deepskyblue: 0x00bfff,
  dimgray: 0x696969,
  dimgrey: 0x696969,
  dodgerblue: 0x1e90ff,
  firebrick: 0xb22222,
  floralwhite: 0xfffaf0,
  forestgreen: 0x228b22,
  fuchsia: 0xff00ff,
  gainsboro: 0xdcdcdc,
  ghostwhite: 0xf8f8ff,
  gold: 0xffd700,
  goldenrod: 0xdaa520,
  gray: 0x808080,
  green: 0x008000,
  greenyellow: 0xadff2f,
  grey: 0x808080,
  honeydew: 0xf0fff0,
  hotpink: 0xff69b4,
  indianred: 0xcd5c5c,
  indigo: 0x4b0082,
  ivory: 0xfffff0,
  khaki: 0xf0e68c,
  lavender: 0xe6e6fa,
  lavenderblush: 0xfff0f5,
  lawngreen: 0x7cfc00,
  lemonchiffon: 0xfffacd,
  lightblue: 0xadd8e6,
  lightcoral: 0xf08080,
  lightcyan: 0xe0ffff,
  lightgoldenrodyellow: 0xfafad2,
  lightgray: 0xd3d3d3,
  lightgreen: 0x90ee90,
  lightgrey: 0xd3d3d3,
  lightpink: 0xffb6c1,
  lightsalmon: 0xffa07a,
  lightseagreen: 0x20b2aa,
  lightskyblue: 0x87cefa,
  lightslategray: 0x778899,
  lightslategrey: 0x778899,
  lightsteelblue: 0xb0c4de,
  lightyellow: 0xffffe0,
  lime: 0x00ff00,
  limegreen: 0x32cd32,
  linen: 0xfaf0e6,
  magenta: 0xff00ff,
  maroon: 0x800000,
  mediumaquamarine: 0x66cdaa,
  mediumblue: 0x0000cd,
  mediumorchid: 0xba55d3,
  mediumpurple: 0x9370db,
  mediumseagreen: 0x3cb371,
  mediumslateblue: 0x7b68ee,
  mediumspringgreen: 0x00fa9a,
  mediumturquoise: 0x48d1cc,
  mediumvioletred: 0xc71585,
  midnightblue: 0x191970,
  mintcream: 0xf5fffa,
  mistyrose: 0xffe4e1,
  moccasin: 0xffe4b5,
  navajowhite: 0xffdead,
  navy: 0x000080,
  oldlace: 0xfdf5e6,
  olive: 0x808000,
  olivedrab: 0x6b8e23,
  orange: 0xffa500,
  orangered: 0xff4500,
  orchid: 0xda70d6,
  palegoldenrod: 0xeee8aa,
  palegreen: 0x98fb98,
  paleturquoise: 0xafeeee,
  palevioletred: 0xdb7093,
  papayawhip: 0xffefd5,
  peachpuff: 0xffdab9,
  peru: 0xcd853f,
  pink: 0xffc0cb,
  plum: 0xdda0dd,
  powderblue: 0xb0e0e6,
  purple: 0x800080,
  rebeccapurple: 0x663399,
  red: 0xff0000,
  rosybrown: 0xbc8f8f,
  royalblue: 0x4169e1,
  saddlebrown: 0x8b4513,
  salmon: 0xfa8072,
  sandybrown: 0xf4a460,
  seagreen: 0x2e8b57,
  seashell: 0xfff5ee,
  sienna: 0xa0522d,
  silver: 0xc0c0c0,
  skyblue: 0x87ceeb,
  slateblue: 0x6a5acd,
  slategray: 0x708090,
  slategrey: 0x708090,
  snow: 0xfffafa,
  springgreen: 0x00ff7f,
  steelblue: 0x4682b4,
  tan: 0xd2b48c,
  teal: 0x008080,
  thistle: 0xd8bfd8,
  tomato: 0xff6347,
  turquoise: 0x40e0d0,
  violet: 0xee82ee,
  wheat: 0xf5deb3,
  white: 0xffffff,
  whitesmoke: 0xf5f5f5,
  yellow: 0xffff00,
  yellowgreen: 0x9acd32
};

Object(__WEBPACK_IMPORTED_MODULE_0__define__["a" /* default */])(Color, color, {
  displayable: function() {
    return this.rgb().displayable();
  },
  toString: function() {
    return this.rgb() + "";
  }
});

function color(format) {
  var m;
  format = (format + "").trim().toLowerCase();
  return (m = reHex3.exec(format)) ? (m = parseInt(m[1], 16), new Rgb((m >> 8 & 0xf) | (m >> 4 & 0x0f0), (m >> 4 & 0xf) | (m & 0xf0), ((m & 0xf) << 4) | (m & 0xf), 1)) // #f00
      : (m = reHex6.exec(format)) ? rgbn(parseInt(m[1], 16)) // #ff0000
      : (m = reRgbInteger.exec(format)) ? new Rgb(m[1], m[2], m[3], 1) // rgb(255, 0, 0)
      : (m = reRgbPercent.exec(format)) ? new Rgb(m[1] * 255 / 100, m[2] * 255 / 100, m[3] * 255 / 100, 1) // rgb(100%, 0%, 0%)
      : (m = reRgbaInteger.exec(format)) ? rgba(m[1], m[2], m[3], m[4]) // rgba(255, 0, 0, 1)
      : (m = reRgbaPercent.exec(format)) ? rgba(m[1] * 255 / 100, m[2] * 255 / 100, m[3] * 255 / 100, m[4]) // rgb(100%, 0%, 0%, 1)
      : (m = reHslPercent.exec(format)) ? hsla(m[1], m[2] / 100, m[3] / 100, 1) // hsl(120, 50%, 50%)
      : (m = reHslaPercent.exec(format)) ? hsla(m[1], m[2] / 100, m[3] / 100, m[4]) // hsla(120, 50%, 50%, 1)
      : named.hasOwnProperty(format) ? rgbn(named[format])
      : format === "transparent" ? new Rgb(NaN, NaN, NaN, 0)
      : null;
}

function rgbn(n) {
  return new Rgb(n >> 16 & 0xff, n >> 8 & 0xff, n & 0xff, 1);
}

function rgba(r, g, b, a) {
  if (a <= 0) r = g = b = NaN;
  return new Rgb(r, g, b, a);
}

function rgbConvert(o) {
  if (!(o instanceof Color)) o = color(o);
  if (!o) return new Rgb;
  o = o.rgb();
  return new Rgb(o.r, o.g, o.b, o.opacity);
}

function rgb(r, g, b, opacity) {
  return arguments.length === 1 ? rgbConvert(r) : new Rgb(r, g, b, opacity == null ? 1 : opacity);
}

function Rgb(r, g, b, opacity) {
  this.r = +r;
  this.g = +g;
  this.b = +b;
  this.opacity = +opacity;
}

Object(__WEBPACK_IMPORTED_MODULE_0__define__["a" /* default */])(Rgb, rgb, Object(__WEBPACK_IMPORTED_MODULE_0__define__["b" /* extend */])(Color, {
  brighter: function(k) {
    k = k == null ? brighter : Math.pow(brighter, k);
    return new Rgb(this.r * k, this.g * k, this.b * k, this.opacity);
  },
  darker: function(k) {
    k = k == null ? darker : Math.pow(darker, k);
    return new Rgb(this.r * k, this.g * k, this.b * k, this.opacity);
  },
  rgb: function() {
    return this;
  },
  displayable: function() {
    return (0 <= this.r && this.r <= 255)
        && (0 <= this.g && this.g <= 255)
        && (0 <= this.b && this.b <= 255)
        && (0 <= this.opacity && this.opacity <= 1);
  },
  toString: function() {
    var a = this.opacity; a = isNaN(a) ? 1 : Math.max(0, Math.min(1, a));
    return (a === 1 ? "rgb(" : "rgba(")
        + Math.max(0, Math.min(255, Math.round(this.r) || 0)) + ", "
        + Math.max(0, Math.min(255, Math.round(this.g) || 0)) + ", "
        + Math.max(0, Math.min(255, Math.round(this.b) || 0))
        + (a === 1 ? ")" : ", " + a + ")");
  }
}));

function hsla(h, s, l, a) {
  if (a <= 0) h = s = l = NaN;
  else if (l <= 0 || l >= 1) h = s = NaN;
  else if (s <= 0) h = NaN;
  return new Hsl(h, s, l, a);
}

function hslConvert(o) {
  if (o instanceof Hsl) return new Hsl(o.h, o.s, o.l, o.opacity);
  if (!(o instanceof Color)) o = color(o);
  if (!o) return new Hsl;
  if (o instanceof Hsl) return o;
  o = o.rgb();
  var r = o.r / 255,
      g = o.g / 255,
      b = o.b / 255,
      min = Math.min(r, g, b),
      max = Math.max(r, g, b),
      h = NaN,
      s = max - min,
      l = (max + min) / 2;
  if (s) {
    if (r === max) h = (g - b) / s + (g < b) * 6;
    else if (g === max) h = (b - r) / s + 2;
    else h = (r - g) / s + 4;
    s /= l < 0.5 ? max + min : 2 - max - min;
    h *= 60;
  } else {
    s = l > 0 && l < 1 ? 0 : h;
  }
  return new Hsl(h, s, l, o.opacity);
}

function hsl(h, s, l, opacity) {
  return arguments.length === 1 ? hslConvert(h) : new Hsl(h, s, l, opacity == null ? 1 : opacity);
}

function Hsl(h, s, l, opacity) {
  this.h = +h;
  this.s = +s;
  this.l = +l;
  this.opacity = +opacity;
}

Object(__WEBPACK_IMPORTED_MODULE_0__define__["a" /* default */])(Hsl, hsl, Object(__WEBPACK_IMPORTED_MODULE_0__define__["b" /* extend */])(Color, {
  brighter: function(k) {
    k = k == null ? brighter : Math.pow(brighter, k);
    return new Hsl(this.h, this.s, this.l * k, this.opacity);
  },
  darker: function(k) {
    k = k == null ? darker : Math.pow(darker, k);
    return new Hsl(this.h, this.s, this.l * k, this.opacity);
  },
  rgb: function() {
    var h = this.h % 360 + (this.h < 0) * 360,
        s = isNaN(h) || isNaN(this.s) ? 0 : this.s,
        l = this.l,
        m2 = l + (l < 0.5 ? l : 1 - l) * s,
        m1 = 2 * l - m2;
    return new Rgb(
      hsl2rgb(h >= 240 ? h - 240 : h + 120, m1, m2),
      hsl2rgb(h, m1, m2),
      hsl2rgb(h < 120 ? h + 240 : h - 120, m1, m2),
      this.opacity
    );
  },
  displayable: function() {
    return (0 <= this.s && this.s <= 1 || isNaN(this.s))
        && (0 <= this.l && this.l <= 1)
        && (0 <= this.opacity && this.opacity <= 1);
  }
}));

/* From FvD 13.37, CSS Color Module Level 3 */
function hsl2rgb(h, m1, m2) {
  return (h < 60 ? m1 + (m2 - m1) * h / 60
      : h < 180 ? m2
      : h < 240 ? m1 + (m2 - m1) * (240 - h) / 60
      : m1) * 255;
}


/***/ }),
/* 45 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (immutable) */ __webpack_exports__["b"] = extend;
/* harmony default export */ __webpack_exports__["a"] = (function(constructor, factory, prototype) {
  constructor.prototype = factory.prototype = prototype;
  prototype.constructor = constructor;
});

function extend(parent, definition) {
  var prototype = Object.create(parent.prototype);
  for (var key in definition) prototype[key] = definition[key];
  return prototype;
}


/***/ }),
/* 46 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
// Computes the decimal coefficient and exponent of the specified number x with
// significant digits p, where x is positive and p is in [1, 21] or undefined.
// For example, formatDecimal(1.23) returns ["123", 0].
/* harmony default export */ __webpack_exports__["a"] = (function(x, p) {
  if ((i = (x = p ? x.toExponential(p - 1) : x.toExponential()).indexOf("e")) < 0) return null; // NaN, ±Infinity
  var i, coefficient = x.slice(0, i);

  // The string returned by toExponential either has the form \d\.\d+e[-+]\d+
  // (e.g., 1.2e+3) or the form \de[-+]\d+ (e.g., 1e+3).
  return [
    coefficient.length > 1 ? coefficient[0] + coefficient.slice(2) : coefficient,
    +x.slice(i + 1)
  ];
});


/***/ }),
/* 47 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "b", function() { return prefix; });
var prefix = "$";

function Map() {}

Map.prototype = map.prototype = {
  constructor: Map,
  has: function(key) {
    return (prefix + key) in this;
  },
  get: function(key) {
    return this[prefix + key];
  },
  set: function(key, value) {
    this[prefix + key] = value;
    return this;
  },
  remove: function(key) {
    var property = prefix + key;
    return property in this && delete this[property];
  },
  clear: function() {
    for (var property in this) if (property[0] === prefix) delete this[property];
  },
  keys: function() {
    var keys = [];
    for (var property in this) if (property[0] === prefix) keys.push(property.slice(1));
    return keys;
  },
  values: function() {
    var values = [];
    for (var property in this) if (property[0] === prefix) values.push(this[property]);
    return values;
  },
  entries: function() {
    var entries = [];
    for (var property in this) if (property[0] === prefix) entries.push({key: property.slice(1), value: this[property]});
    return entries;
  },
  size: function() {
    var size = 0;
    for (var property in this) if (property[0] === prefix) ++size;
    return size;
  },
  empty: function() {
    for (var property in this) if (property[0] === prefix) return false;
    return true;
  },
  each: function(f) {
    for (var property in this) if (property[0] === prefix) f(this[property], property.slice(1), this);
  }
};

function map(object, f) {
  var map = new Map;

  // Copy constructor.
  if (object instanceof Map) object.each(function(value, key) { map.set(key, value); });

  // Index array by numeric index or specified key function.
  else if (Array.isArray(object)) {
    var i = -1,
        n = object.length,
        o;

    if (f == null) while (++i < n) map.set(i, object[i]);
    else while (++i < n) map.set(f(o = object[i], i, object), o);
  }

  // Convert object to map.
  else if (object) for (var key in object) map.set(key, object[key]);

  return map;
}

/* harmony default export */ __webpack_exports__["a"] = (map);


/***/ }),
/* 48 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_d3_color__ = __webpack_require__(12);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__rgb__ = __webpack_require__(85);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__array__ = __webpack_require__(88);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__date__ = __webpack_require__(89);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__number__ = __webpack_require__(35);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5__object__ = __webpack_require__(90);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_6__string__ = __webpack_require__(91);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_7__constant__ = __webpack_require__(87);









/* harmony default export */ __webpack_exports__["a"] = (function(a, b) {
  var t = typeof b, c;
  return b == null || t === "boolean" ? Object(__WEBPACK_IMPORTED_MODULE_7__constant__["a" /* default */])(b)
      : (t === "number" ? __WEBPACK_IMPORTED_MODULE_4__number__["a" /* default */]
      : t === "string" ? ((c = Object(__WEBPACK_IMPORTED_MODULE_0_d3_color__["color"])(b)) ? (b = c, __WEBPACK_IMPORTED_MODULE_1__rgb__["a" /* default */]) : __WEBPACK_IMPORTED_MODULE_6__string__["a" /* default */])
      : b instanceof __WEBPACK_IMPORTED_MODULE_0_d3_color__["color"] ? __WEBPACK_IMPORTED_MODULE_1__rgb__["a" /* default */]
      : b instanceof Date ? __WEBPACK_IMPORTED_MODULE_3__date__["a" /* default */]
      : Array.isArray(b) ? __WEBPACK_IMPORTED_MODULE_2__array__["a" /* default */]
      : typeof b.valueOf !== "function" && typeof b.toString !== "function" || isNaN(b) ? __WEBPACK_IMPORTED_MODULE_5__object__["a" /* default */]
      : __WEBPACK_IMPORTED_MODULE_4__number__["a" /* default */])(a, b);
});


/***/ }),
/* 49 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (immutable) */ __webpack_exports__["a"] = basis;
function basis(t1, v0, v1, v2, v3) {
  var t2 = t1 * t1, t3 = t2 * t1;
  return ((1 - 3 * t1 + 3 * t2 - t3) * v0
      + (4 - 6 * t2 + 3 * t3) * v1
      + (1 + 3 * t1 + 3 * t2 - 3 * t3) * v2
      + t3 * v3) / 6;
}

/* harmony default export */ __webpack_exports__["b"] = (function(values) {
  var n = values.length - 1;
  return function(t) {
    var i = t <= 0 ? (t = 0) : t >= 1 ? (t = 1, n - 1) : Math.floor(t * n),
        v1 = values[i],
        v2 = values[i + 1],
        v0 = i > 0 ? values[i - 1] : 2 * v1 - v2,
        v3 = i < n - 1 ? values[i + 2] : 2 * v2 - v1;
    return basis((t - i / n) * n, v0, v1, v2, v3);
  };
});


/***/ }),
/* 50 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony default export */ __webpack_exports__["a"] = (function(x) {
  return function() {
    return x;
  };
});


/***/ }),
/* 51 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "b", function() { return timeFormat; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "c", function() { return timeParse; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "d", function() { return utcFormat; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "e", function() { return utcParse; });
/* harmony export (immutable) */ __webpack_exports__["a"] = defaultLocale;
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__locale__ = __webpack_require__(95);


var locale;
var timeFormat;
var timeParse;
var utcFormat;
var utcParse;

defaultLocale({
  dateTime: "%x, %X",
  date: "%-m/%-d/%Y",
  time: "%-I:%M:%S %p",
  periods: ["AM", "PM"],
  days: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
  shortDays: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"],
  months: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
  shortMonths: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"]
});

function defaultLocale(definition) {
  locale = Object(__WEBPACK_IMPORTED_MODULE_0__locale__["a" /* default */])(definition);
  timeFormat = locale.format;
  timeParse = locale.parse;
  utcFormat = locale.utcFormat;
  utcParse = locale.utcParse;
  return locale;
}


/***/ }),
/* 52 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__namespace__ = __webpack_require__(53);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__namespaces__ = __webpack_require__(54);



function creatorInherit(name) {
  return function() {
    var document = this.ownerDocument,
        uri = this.namespaceURI;
    return uri === __WEBPACK_IMPORTED_MODULE_1__namespaces__["b" /* xhtml */] && document.documentElement.namespaceURI === __WEBPACK_IMPORTED_MODULE_1__namespaces__["b" /* xhtml */]
        ? document.createElement(name)
        : document.createElementNS(uri, name);
  };
}

function creatorFixed(fullname) {
  return function() {
    return this.ownerDocument.createElementNS(fullname.space, fullname.local);
  };
}

/* harmony default export */ __webpack_exports__["a"] = (function(name) {
  var fullname = Object(__WEBPACK_IMPORTED_MODULE_0__namespace__["a" /* default */])(name);
  return (fullname.local
      ? creatorFixed
      : creatorInherit)(fullname);
});


/***/ }),
/* 53 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__namespaces__ = __webpack_require__(54);


/* harmony default export */ __webpack_exports__["a"] = (function(name) {
  var prefix = name += "", i = prefix.indexOf(":");
  if (i >= 0 && (prefix = name.slice(0, i)) !== "xmlns") name = name.slice(i + 1);
  return __WEBPACK_IMPORTED_MODULE_0__namespaces__["a" /* default */].hasOwnProperty(prefix) ? {space: __WEBPACK_IMPORTED_MODULE_0__namespaces__["a" /* default */][prefix], local: name} : name;
});


/***/ }),
/* 54 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "b", function() { return xhtml; });
var xhtml = "http://www.w3.org/1999/xhtml";

/* harmony default export */ __webpack_exports__["a"] = ({
  svg: "http://www.w3.org/2000/svg",
  xhtml: xhtml,
  xlink: "http://www.w3.org/1999/xlink",
  xml: "http://www.w3.org/XML/1998/namespace",
  xmlns: "http://www.w3.org/2000/xmlns/"
});


/***/ }),
/* 55 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__selection_on__ = __webpack_require__(56);


/* harmony default export */ __webpack_exports__["a"] = (function() {
  var current = __WEBPACK_IMPORTED_MODULE_0__selection_on__["c" /* event */], source;
  while (source = current.sourceEvent) current = source;
  return current;
});


/***/ }),
/* 56 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "c", function() { return event; });
/* harmony export (immutable) */ __webpack_exports__["a"] = customEvent;
var filterEvents = {};

var event = null;

if (typeof document !== "undefined") {
  var element = document.documentElement;
  if (!("onmouseenter" in element)) {
    filterEvents = {mouseenter: "mouseover", mouseleave: "mouseout"};
  }
}

function filterContextListener(listener, index, group) {
  listener = contextListener(listener, index, group);
  return function(event) {
    var related = event.relatedTarget;
    if (!related || (related !== this && !(related.compareDocumentPosition(this) & 8))) {
      listener.call(this, event);
    }
  };
}

function contextListener(listener, index, group) {
  return function(event1) {
    var event0 = event; // Events can be reentrant (e.g., focus).
    event = event1;
    try {
      listener.call(this, this.__data__, index, group);
    } finally {
      event = event0;
    }
  };
}

function parseTypenames(typenames) {
  return typenames.trim().split(/^|\s+/).map(function(t) {
    var name = "", i = t.indexOf(".");
    if (i >= 0) name = t.slice(i + 1), t = t.slice(0, i);
    return {type: t, name: name};
  });
}

function onRemove(typename) {
  return function() {
    var on = this.__on;
    if (!on) return;
    for (var j = 0, i = -1, m = on.length, o; j < m; ++j) {
      if (o = on[j], (!typename.type || o.type === typename.type) && o.name === typename.name) {
        this.removeEventListener(o.type, o.listener, o.capture);
      } else {
        on[++i] = o;
      }
    }
    if (++i) on.length = i;
    else delete this.__on;
  };
}

function onAdd(typename, value, capture) {
  var wrap = filterEvents.hasOwnProperty(typename.type) ? filterContextListener : contextListener;
  return function(d, i, group) {
    var on = this.__on, o, listener = wrap(value, i, group);
    if (on) for (var j = 0, m = on.length; j < m; ++j) {
      if ((o = on[j]).type === typename.type && o.name === typename.name) {
        this.removeEventListener(o.type, o.listener, o.capture);
        this.addEventListener(o.type, o.listener = listener, o.capture = capture);
        o.value = value;
        return;
      }
    }
    this.addEventListener(typename.type, listener, capture);
    o = {type: typename.type, name: typename.name, value: value, listener: listener, capture: capture};
    if (!on) this.__on = [o];
    else on.push(o);
  };
}

/* harmony default export */ __webpack_exports__["b"] = (function(typename, value, capture) {
  var typenames = parseTypenames(typename + ""), i, n = typenames.length, t;

  if (arguments.length < 2) {
    var on = this.node().__on;
    if (on) for (var j = 0, m = on.length, o; j < m; ++j) {
      for (i = 0, o = on[j]; i < n; ++i) {
        if ((t = typenames[i]).type === o.type && t.name === o.name) {
          return o.value;
        }
      }
    }
    return;
  }

  on = value ? onAdd : onRemove;
  if (capture == null) capture = false;
  for (i = 0; i < n; ++i) this.each(on(typenames[i], value, capture));
  return this;
});

function customEvent(event1, listener, that, args) {
  var event0 = event;
  event1.sourceEvent = event;
  event = event1;
  try {
    return listener.apply(that, args);
  } finally {
    event = event0;
  }
}


/***/ }),
/* 57 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony default export */ __webpack_exports__["a"] = (function(node, event) {
  var svg = node.ownerSVGElement || node;

  if (svg.createSVGPoint) {
    var point = svg.createSVGPoint();
    point.x = event.clientX, point.y = event.clientY;
    point = point.matrixTransform(node.getScreenCTM().inverse());
    return [point.x, point.y];
  }

  var rect = node.getBoundingClientRect();
  return [event.clientX - rect.left - node.clientLeft, event.clientY - rect.top - node.clientTop];
});


/***/ }),
/* 58 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
function none() {}

/* harmony default export */ __webpack_exports__["a"] = (function(selector) {
  return selector == null ? none : function() {
    return this.querySelector(selector);
  };
});


/***/ }),
/* 59 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony default export */ __webpack_exports__["a"] = (function(node) {
  return (node.ownerDocument && node.ownerDocument.defaultView) // node is a Node
      || (node.document && node) // node is a Window
      || node.defaultView; // node is a Document
});


/***/ }),
/* 60 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (immutable) */ __webpack_exports__["b"] = now;
/* harmony export (immutable) */ __webpack_exports__["a"] = Timer;
/* harmony export (immutable) */ __webpack_exports__["c"] = timer;
/* unused harmony export timerFlush */
var frame = 0, // is an animation frame pending?
    timeout = 0, // is a timeout pending?
    interval = 0, // are any timers active?
    pokeDelay = 1000, // how frequently we check for clock skew
    taskHead,
    taskTail,
    clockLast = 0,
    clockNow = 0,
    clockSkew = 0,
    clock = typeof performance === "object" && performance.now ? performance : Date,
    setFrame = typeof window === "object" && window.requestAnimationFrame ? window.requestAnimationFrame.bind(window) : function(f) { setTimeout(f, 17); };

function now() {
  return clockNow || (setFrame(clearNow), clockNow = clock.now() + clockSkew);
}

function clearNow() {
  clockNow = 0;
}

function Timer() {
  this._call =
  this._time =
  this._next = null;
}

Timer.prototype = timer.prototype = {
  constructor: Timer,
  restart: function(callback, delay, time) {
    if (typeof callback !== "function") throw new TypeError("callback is not a function");
    time = (time == null ? now() : +time) + (delay == null ? 0 : +delay);
    if (!this._next && taskTail !== this) {
      if (taskTail) taskTail._next = this;
      else taskHead = this;
      taskTail = this;
    }
    this._call = callback;
    this._time = time;
    sleep();
  },
  stop: function() {
    if (this._call) {
      this._call = null;
      this._time = Infinity;
      sleep();
    }
  }
};

function timer(callback, delay, time) {
  var t = new Timer;
  t.restart(callback, delay, time);
  return t;
}

function timerFlush() {
  now(); // Get the current time, if not already set.
  ++frame; // Pretend we’ve set an alarm, if we haven’t already.
  var t = taskHead, e;
  while (t) {
    if ((e = clockNow - t._time) >= 0) t._call.call(null, e);
    t = t._next;
  }
  --frame;
}

function wake() {
  clockNow = (clockLast = clock.now()) + clockSkew;
  frame = timeout = 0;
  try {
    timerFlush();
  } finally {
    frame = 0;
    nap();
    clockNow = 0;
  }
}

function poke() {
  var now = clock.now(), delay = now - clockLast;
  if (delay > pokeDelay) clockSkew -= delay, clockLast = now;
}

function nap() {
  var t0, t1 = taskHead, t2, time = Infinity;
  while (t1) {
    if (t1._call) {
      if (time > t1._time) time = t1._time;
      t0 = t1, t1 = t1._next;
    } else {
      t2 = t1._next, t1._next = null;
      t1 = t0 ? t0._next = t2 : taskHead = t2;
    }
  }
  taskTail = t0;
  sleep(time);
}

function sleep(time) {
  if (frame) return; // Soonest alarm already set, or will be.
  if (timeout) timeout = clearTimeout(timeout);
  var delay = time - clockNow;
  if (delay > 24) {
    if (time < Infinity) timeout = setTimeout(wake, delay);
    if (interval) interval = clearInterval(interval);
  } else {
    if (!interval) clockLast = clockNow, interval = setInterval(poke, pokeDelay);
    frame = 1, setFrame(wake);
  }
}


/***/ }),
/* 61 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_d3_path__ = __webpack_require__(30);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__constant__ = __webpack_require__(22);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__curve_linear__ = __webpack_require__(39);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__point__ = __webpack_require__(62);





/* harmony default export */ __webpack_exports__["a"] = (function() {
  var x = __WEBPACK_IMPORTED_MODULE_3__point__["a" /* x */],
      y = __WEBPACK_IMPORTED_MODULE_3__point__["b" /* y */],
      defined = Object(__WEBPACK_IMPORTED_MODULE_1__constant__["a" /* default */])(true),
      context = null,
      curve = __WEBPACK_IMPORTED_MODULE_2__curve_linear__["a" /* default */],
      output = null;

  function line(data) {
    var i,
        n = data.length,
        d,
        defined0 = false,
        buffer;

    if (context == null) output = curve(buffer = Object(__WEBPACK_IMPORTED_MODULE_0_d3_path__["a" /* path */])());

    for (i = 0; i <= n; ++i) {
      if (!(i < n && defined(d = data[i], i, data)) === defined0) {
        if (defined0 = !defined0) output.lineStart();
        else output.lineEnd();
      }
      if (defined0) output.point(+x(d, i, data), +y(d, i, data));
    }

    if (buffer) return output = null, buffer + "" || null;
  }

  line.x = function(_) {
    return arguments.length ? (x = typeof _ === "function" ? _ : Object(__WEBPACK_IMPORTED_MODULE_1__constant__["a" /* default */])(+_), line) : x;
  };

  line.y = function(_) {
    return arguments.length ? (y = typeof _ === "function" ? _ : Object(__WEBPACK_IMPORTED_MODULE_1__constant__["a" /* default */])(+_), line) : y;
  };

  line.defined = function(_) {
    return arguments.length ? (defined = typeof _ === "function" ? _ : Object(__WEBPACK_IMPORTED_MODULE_1__constant__["a" /* default */])(!!_), line) : defined;
  };

  line.curve = function(_) {
    return arguments.length ? (curve = _, context != null && (output = curve(context)), line) : curve;
  };

  line.context = function(_) {
    return arguments.length ? (_ == null ? context = output = null : output = curve(context = _), line) : context;
  };

  return line;
});


/***/ }),
/* 62 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (immutable) */ __webpack_exports__["a"] = x;
/* harmony export (immutable) */ __webpack_exports__["b"] = y;
function x(p) {
  return p[0];
}

function y(p) {
  return p[1];
}


/***/ }),
/* 63 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (immutable) */ __webpack_exports__["b"] = point;
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__math__ = __webpack_require__(31);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__cardinal__ = __webpack_require__(42);



function point(that, x, y) {
  var x1 = that._x1,
      y1 = that._y1,
      x2 = that._x2,
      y2 = that._y2;

  if (that._l01_a > __WEBPACK_IMPORTED_MODULE_0__math__["f" /* epsilon */]) {
    var a = 2 * that._l01_2a + 3 * that._l01_a * that._l12_a + that._l12_2a,
        n = 3 * that._l01_a * (that._l01_a + that._l12_a);
    x1 = (x1 * a - that._x0 * that._l12_2a + that._x2 * that._l01_2a) / n;
    y1 = (y1 * a - that._y0 * that._l12_2a + that._y2 * that._l01_2a) / n;
  }

  if (that._l23_a > __WEBPACK_IMPORTED_MODULE_0__math__["f" /* epsilon */]) {
    var b = 2 * that._l23_2a + 3 * that._l23_a * that._l12_a + that._l12_2a,
        m = 3 * that._l23_a * (that._l23_a + that._l12_a);
    x2 = (x2 * b + that._x1 * that._l23_2a - x * that._l12_2a) / m;
    y2 = (y2 * b + that._y1 * that._l23_2a - y * that._l12_2a) / m;
  }

  that._context.bezierCurveTo(x1, y1, x2, y2, that._x2, that._y2);
}

function CatmullRom(context, alpha) {
  this._context = context;
  this._alpha = alpha;
}

CatmullRom.prototype = {
  areaStart: function() {
    this._line = 0;
  },
  areaEnd: function() {
    this._line = NaN;
  },
  lineStart: function() {
    this._x0 = this._x1 = this._x2 =
    this._y0 = this._y1 = this._y2 = NaN;
    this._l01_a = this._l12_a = this._l23_a =
    this._l01_2a = this._l12_2a = this._l23_2a =
    this._point = 0;
  },
  lineEnd: function() {
    switch (this._point) {
      case 2: this._context.lineTo(this._x2, this._y2); break;
      case 3: this.point(this._x2, this._y2); break;
    }
    if (this._line || (this._line !== 0 && this._point === 1)) this._context.closePath();
    this._line = 1 - this._line;
  },
  point: function(x, y) {
    x = +x, y = +y;

    if (this._point) {
      var x23 = this._x2 - x,
          y23 = this._y2 - y;
      this._l23_a = Math.sqrt(this._l23_2a = Math.pow(x23 * x23 + y23 * y23, this._alpha));
    }

    switch (this._point) {
      case 0: this._point = 1; this._line ? this._context.lineTo(x, y) : this._context.moveTo(x, y); break;
      case 1: this._point = 2; break;
      case 2: this._point = 3; // proceed
      default: point(this, x, y); break;
    }

    this._l01_a = this._l12_a, this._l12_a = this._l23_a;
    this._l01_2a = this._l12_2a, this._l12_2a = this._l23_2a;
    this._x0 = this._x1, this._x1 = this._x2, this._x2 = x;
    this._y0 = this._y1, this._y1 = this._y2, this._y2 = y;
  }
};

/* harmony default export */ __webpack_exports__["a"] = ((function custom(alpha) {

  function catmullRom(context) {
    return alpha ? new CatmullRom(context, alpha) : new __WEBPACK_IMPORTED_MODULE_1__cardinal__["a" /* Cardinal */](context, 0);
  }

  catmullRom.alpha = function(alpha) {
    return custom(+alpha);
  };

  return catmullRom;
})(0.5));


/***/ }),
/* 64 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (immutable) */ __webpack_exports__["b"] = sum;
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__none__ = __webpack_require__(33);


/* harmony default export */ __webpack_exports__["a"] = (function(series) {
  var sums = series.map(sum);
  return Object(__WEBPACK_IMPORTED_MODULE_0__none__["a" /* default */])(series).sort(function(a, b) { return sums[a] - sums[b]; });
});

function sum(series) {
  var s = 0, i = -1, n = series.length, v;
  while (++i < n) if (v = +series[i][1]) s += v;
  return s;
}


/***/ }),
/* 65 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
var __WEBPACK_AMD_DEFINE_RESULT__;

var _slicedToArray = function () { function sliceIterator(arr, i) { var _arr = []; var _n = true; var _d = false; var _e = undefined; try { for (var _i = arr[Symbol.iterator](), _s; !(_n = (_s = _i.next()).done); _n = true) { _arr.push(_s.value); if (i && _arr.length === i) break; } } catch (err) { _d = true; _e = err; } finally { try { if (!_n && _i["return"]) _i["return"](); } finally { if (_d) throw _e; } } return _arr; } return function (arr, i) { if (Array.isArray(arr)) { return arr; } else if (Symbol.iterator in Object(arr)) { return sliceIterator(arr, i); } else { throw new TypeError("Invalid attempt to destructure non-iterable instance"); } }; }();

var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; };

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

!(__WEBPACK_AMD_DEFINE_RESULT__ = function (require) {
    'use strict';

    var _settingsToMajorTickM;

    var d3Time = __webpack_require__(25);
    var d3TimeFormat = __webpack_require__(19);

    var _require = __webpack_require__(20),
        axisTimeCombinations = _require.axisTimeCombinations,
        timeBenchmarks = _require.timeBenchmarks;

    var _require2 = __webpack_require__(119),
        convertMillisecondsToDays = _require2.convertMillisecondsToDays,
        getLocaleDateFormatter = _require2.getLocaleDateFormatter;

    var singleTickWidth = 20;
    var horizontalTickSpacing = 50;
    var minEntryNumForDayFormat = 5;

    var formatMap = {
        minute: d3TimeFormat.timeFormat('%M m'),
        hour: d3TimeFormat.timeFormat('%H %p'),
        day: d3TimeFormat.timeFormat('%e'),
        daymonth: d3TimeFormat.timeFormat('%d %b'),
        month: d3TimeFormat.timeFormat('%b'),
        year: d3TimeFormat.timeFormat('%Y')
    };
    var localeTimeMap = {
        minute: { minute: 'numeric' },
        hour: { hour: 'numeric' },
        day: { day: 'numeric' },
        daymonth: { day: 'numeric', month: 'short' },
        month: { month: 'short' },
        year: { year: 'numeric' }
    };
    var settingsToMajorTickMap = (_settingsToMajorTickM = {}, _defineProperty(_settingsToMajorTickM, axisTimeCombinations.MINUTE_HOUR, d3Time.timeHour.every(1)), _defineProperty(_settingsToMajorTickM, axisTimeCombinations.HOUR_DAY, d3Time.timeDay.every(1)), _defineProperty(_settingsToMajorTickM, axisTimeCombinations.DAY_MONTH, d3Time.timeMonth.every(1)), _defineProperty(_settingsToMajorTickM, axisTimeCombinations.MONTH_YEAR, d3Time.timeYear.every(1)), _settingsToMajorTickM);

    /**
     * Figures out the proper settings from the current time span
     * @param  {Number} timeSpan    Span of time charted by the graph in milliseconds
     * @return {String}             Type of settings for the given timeSpan
     */
    var getAxisSettingsFromTimeSpan = function getAxisSettingsFromTimeSpan(timeSpan) {
        var ONE_YEAR = timeBenchmarks.ONE_YEAR,
            ONE_DAY = timeBenchmarks.ONE_DAY;

        var settings = void 0;

        if (timeSpan < ONE_DAY) {
            settings = axisTimeCombinations.HOUR_DAY;
        } else if (timeSpan < ONE_YEAR) {
            settings = axisTimeCombinations.DAY_MONTH;
        } else {
            settings = axisTimeCombinations.MONTH_YEAR;
        }

        return settings;
    };

    /**
     * Calculates the maximum number of ticks for the x axis
     * @param  {Number} width               Chart width
     * @param  {Number} dataPointNumber     Number of entries on the data
     * @return {Number}                     Number of ticks to render
     */
    var getMaxNumOfHorizontalTicks = function getMaxNumOfHorizontalTicks(width, dataPointNumber) {
        var ticksForWidth = Math.ceil(width / (singleTickWidth + horizontalTickSpacing));

        return dataPointNumber < minEntryNumForDayFormat ? d3Time.timeDay : Math.min(dataPointNumber, ticksForWidth);
    };

    /**
     * Returns tick object to be used when building the x axis
     * @param {dataByDate} dataByDate       Chart data ordered by Date
     * @param {Number} width                Chart width
     * @param {String} [settings=null]      Optional forced settings for axis
     * @param {String} [locale=null]        Optional forced locale
     * @return {object} tick settings for major and minr axis
     */
    var getTimeSeriesAxis = function getTimeSeriesAxis(dataByDate, width) {
        var settings = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : null;
        var locale = arguments.length > 3 && arguments[3] !== undefined ? arguments[3] : null;

        var firstDate = new Date(dataByDate[0].date);
        var lastDate = new Date(dataByDate[dataByDate.length - 1].date);
        var dateTimeSpan = lastDate - firstDate;

        if (locale && (typeof Intl === 'undefined' || (typeof Intl === 'undefined' ? 'undefined' : _typeof(Intl)) === 'object' && !Intl.DateTimeFormat)) {
            locale = null;
        }

        if (!settings) {
            settings = getAxisSettingsFromTimeSpan(dateTimeSpan);
        }

        var _settings$split = settings.split('-'),
            _settings$split2 = _slicedToArray(_settings$split, 2),
            minor = _settings$split2[0],
            major = _settings$split2[1];

        var majorTickValue = settingsToMajorTickMap[settings];
        var minorTickValue = getMaxNumOfHorizontalTicks(width, convertMillisecondsToDays(dateTimeSpan));

        return {
            minor: {
                format: locale ? getLocaleDateFormatter(locale, minor) : formatMap[minor],
                tick: minorTickValue
            },
            major: {
                format: locale ? getLocaleDateFormatter(locale, major) : formatMap[major],
                tick: majorTickValue
            }
        };
    };

    return {
        getTimeSeriesAxis: getTimeSeriesAxis
    };
}.call(exports, __webpack_require__, exports, module),
				__WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));

/***/ }),
/* 66 */
/***/ (function(module, exports) {

/**
 * lodash (Custom Build) <https://lodash.com/>
 * Build: `lodash modularize exports="npm" -o ./`
 * Copyright jQuery Foundation and other contributors <https://jquery.org/>
 * Released under MIT license <https://lodash.com/license>
 * Based on Underscore.js 1.8.3 <http://underscorejs.org/LICENSE>
 * Copyright Jeremy Ashkenas, DocumentCloud and Investigative Reporters & Editors
 */

/** Used as references for various `Number` constants. */
var MAX_SAFE_INTEGER = 9007199254740991;

/** `Object#toString` result references. */
var argsTag = '[object Arguments]',
    funcTag = '[object Function]',
    genTag = '[object GeneratorFunction]';

/** Used to detect unsigned integer values. */
var reIsUint = /^(?:0|[1-9]\d*)$/;

/**
 * A faster alternative to `Function#apply`, this function invokes `func`
 * with the `this` binding of `thisArg` and the arguments of `args`.
 *
 * @private
 * @param {Function} func The function to invoke.
 * @param {*} thisArg The `this` binding of `func`.
 * @param {Array} args The arguments to invoke `func` with.
 * @returns {*} Returns the result of `func`.
 */
function apply(func, thisArg, args) {
  switch (args.length) {
    case 0: return func.call(thisArg);
    case 1: return func.call(thisArg, args[0]);
    case 2: return func.call(thisArg, args[0], args[1]);
    case 3: return func.call(thisArg, args[0], args[1], args[2]);
  }
  return func.apply(thisArg, args);
}

/**
 * The base implementation of `_.times` without support for iteratee shorthands
 * or max array length checks.
 *
 * @private
 * @param {number} n The number of times to invoke `iteratee`.
 * @param {Function} iteratee The function invoked per iteration.
 * @returns {Array} Returns the array of results.
 */
function baseTimes(n, iteratee) {
  var index = -1,
      result = Array(n);

  while (++index < n) {
    result[index] = iteratee(index);
  }
  return result;
}

/**
 * Creates a unary function that invokes `func` with its argument transformed.
 *
 * @private
 * @param {Function} func The function to wrap.
 * @param {Function} transform The argument transform.
 * @returns {Function} Returns the new function.
 */
function overArg(func, transform) {
  return function(arg) {
    return func(transform(arg));
  };
}

/** Used for built-in method references. */
var objectProto = Object.prototype;

/** Used to check objects for own properties. */
var hasOwnProperty = objectProto.hasOwnProperty;

/**
 * Used to resolve the
 * [`toStringTag`](http://ecma-international.org/ecma-262/7.0/#sec-object.prototype.tostring)
 * of values.
 */
var objectToString = objectProto.toString;

/** Built-in value references. */
var propertyIsEnumerable = objectProto.propertyIsEnumerable;

/* Built-in method references for those with the same name as other `lodash` methods. */
var nativeKeys = overArg(Object.keys, Object),
    nativeMax = Math.max;

/** Detect if properties shadowing those on `Object.prototype` are non-enumerable. */
var nonEnumShadows = !propertyIsEnumerable.call({ 'valueOf': 1 }, 'valueOf');

/**
 * Creates an array of the enumerable property names of the array-like `value`.
 *
 * @private
 * @param {*} value The value to query.
 * @param {boolean} inherited Specify returning inherited property names.
 * @returns {Array} Returns the array of property names.
 */
function arrayLikeKeys(value, inherited) {
  // Safari 8.1 makes `arguments.callee` enumerable in strict mode.
  // Safari 9 makes `arguments.length` enumerable in strict mode.
  var result = (isArray(value) || isArguments(value))
    ? baseTimes(value.length, String)
    : [];

  var length = result.length,
      skipIndexes = !!length;

  for (var key in value) {
    if ((inherited || hasOwnProperty.call(value, key)) &&
        !(skipIndexes && (key == 'length' || isIndex(key, length)))) {
      result.push(key);
    }
  }
  return result;
}

/**
 * Assigns `value` to `key` of `object` if the existing value is not equivalent
 * using [`SameValueZero`](http://ecma-international.org/ecma-262/7.0/#sec-samevaluezero)
 * for equality comparisons.
 *
 * @private
 * @param {Object} object The object to modify.
 * @param {string} key The key of the property to assign.
 * @param {*} value The value to assign.
 */
function assignValue(object, key, value) {
  var objValue = object[key];
  if (!(hasOwnProperty.call(object, key) && eq(objValue, value)) ||
      (value === undefined && !(key in object))) {
    object[key] = value;
  }
}

/**
 * The base implementation of `_.keys` which doesn't treat sparse arrays as dense.
 *
 * @private
 * @param {Object} object The object to query.
 * @returns {Array} Returns the array of property names.
 */
function baseKeys(object) {
  if (!isPrototype(object)) {
    return nativeKeys(object);
  }
  var result = [];
  for (var key in Object(object)) {
    if (hasOwnProperty.call(object, key) && key != 'constructor') {
      result.push(key);
    }
  }
  return result;
}

/**
 * The base implementation of `_.rest` which doesn't validate or coerce arguments.
 *
 * @private
 * @param {Function} func The function to apply a rest parameter to.
 * @param {number} [start=func.length-1] The start position of the rest parameter.
 * @returns {Function} Returns the new function.
 */
function baseRest(func, start) {
  start = nativeMax(start === undefined ? (func.length - 1) : start, 0);
  return function() {
    var args = arguments,
        index = -1,
        length = nativeMax(args.length - start, 0),
        array = Array(length);

    while (++index < length) {
      array[index] = args[start + index];
    }
    index = -1;
    var otherArgs = Array(start + 1);
    while (++index < start) {
      otherArgs[index] = args[index];
    }
    otherArgs[start] = array;
    return apply(func, this, otherArgs);
  };
}

/**
 * Copies properties of `source` to `object`.
 *
 * @private
 * @param {Object} source The object to copy properties from.
 * @param {Array} props The property identifiers to copy.
 * @param {Object} [object={}] The object to copy properties to.
 * @param {Function} [customizer] The function to customize copied values.
 * @returns {Object} Returns `object`.
 */
function copyObject(source, props, object, customizer) {
  object || (object = {});

  var index = -1,
      length = props.length;

  while (++index < length) {
    var key = props[index];

    var newValue = customizer
      ? customizer(object[key], source[key], key, object, source)
      : undefined;

    assignValue(object, key, newValue === undefined ? source[key] : newValue);
  }
  return object;
}

/**
 * Creates a function like `_.assign`.
 *
 * @private
 * @param {Function} assigner The function to assign values.
 * @returns {Function} Returns the new assigner function.
 */
function createAssigner(assigner) {
  return baseRest(function(object, sources) {
    var index = -1,
        length = sources.length,
        customizer = length > 1 ? sources[length - 1] : undefined,
        guard = length > 2 ? sources[2] : undefined;

    customizer = (assigner.length > 3 && typeof customizer == 'function')
      ? (length--, customizer)
      : undefined;

    if (guard && isIterateeCall(sources[0], sources[1], guard)) {
      customizer = length < 3 ? undefined : customizer;
      length = 1;
    }
    object = Object(object);
    while (++index < length) {
      var source = sources[index];
      if (source) {
        assigner(object, source, index, customizer);
      }
    }
    return object;
  });
}

/**
 * Checks if `value` is a valid array-like index.
 *
 * @private
 * @param {*} value The value to check.
 * @param {number} [length=MAX_SAFE_INTEGER] The upper bounds of a valid index.
 * @returns {boolean} Returns `true` if `value` is a valid index, else `false`.
 */
function isIndex(value, length) {
  length = length == null ? MAX_SAFE_INTEGER : length;
  return !!length &&
    (typeof value == 'number' || reIsUint.test(value)) &&
    (value > -1 && value % 1 == 0 && value < length);
}

/**
 * Checks if the given arguments are from an iteratee call.
 *
 * @private
 * @param {*} value The potential iteratee value argument.
 * @param {*} index The potential iteratee index or key argument.
 * @param {*} object The potential iteratee object argument.
 * @returns {boolean} Returns `true` if the arguments are from an iteratee call,
 *  else `false`.
 */
function isIterateeCall(value, index, object) {
  if (!isObject(object)) {
    return false;
  }
  var type = typeof index;
  if (type == 'number'
        ? (isArrayLike(object) && isIndex(index, object.length))
        : (type == 'string' && index in object)
      ) {
    return eq(object[index], value);
  }
  return false;
}

/**
 * Checks if `value` is likely a prototype object.
 *
 * @private
 * @param {*} value The value to check.
 * @returns {boolean} Returns `true` if `value` is a prototype, else `false`.
 */
function isPrototype(value) {
  var Ctor = value && value.constructor,
      proto = (typeof Ctor == 'function' && Ctor.prototype) || objectProto;

  return value === proto;
}

/**
 * Performs a
 * [`SameValueZero`](http://ecma-international.org/ecma-262/7.0/#sec-samevaluezero)
 * comparison between two values to determine if they are equivalent.
 *
 * @static
 * @memberOf _
 * @since 4.0.0
 * @category Lang
 * @param {*} value The value to compare.
 * @param {*} other The other value to compare.
 * @returns {boolean} Returns `true` if the values are equivalent, else `false`.
 * @example
 *
 * var object = { 'a': 1 };
 * var other = { 'a': 1 };
 *
 * _.eq(object, object);
 * // => true
 *
 * _.eq(object, other);
 * // => false
 *
 * _.eq('a', 'a');
 * // => true
 *
 * _.eq('a', Object('a'));
 * // => false
 *
 * _.eq(NaN, NaN);
 * // => true
 */
function eq(value, other) {
  return value === other || (value !== value && other !== other);
}

/**
 * Checks if `value` is likely an `arguments` object.
 *
 * @static
 * @memberOf _
 * @since 0.1.0
 * @category Lang
 * @param {*} value The value to check.
 * @returns {boolean} Returns `true` if `value` is an `arguments` object,
 *  else `false`.
 * @example
 *
 * _.isArguments(function() { return arguments; }());
 * // => true
 *
 * _.isArguments([1, 2, 3]);
 * // => false
 */
function isArguments(value) {
  // Safari 8.1 makes `arguments.callee` enumerable in strict mode.
  return isArrayLikeObject(value) && hasOwnProperty.call(value, 'callee') &&
    (!propertyIsEnumerable.call(value, 'callee') || objectToString.call(value) == argsTag);
}

/**
 * Checks if `value` is classified as an `Array` object.
 *
 * @static
 * @memberOf _
 * @since 0.1.0
 * @category Lang
 * @param {*} value The value to check.
 * @returns {boolean} Returns `true` if `value` is an array, else `false`.
 * @example
 *
 * _.isArray([1, 2, 3]);
 * // => true
 *
 * _.isArray(document.body.children);
 * // => false
 *
 * _.isArray('abc');
 * // => false
 *
 * _.isArray(_.noop);
 * // => false
 */
var isArray = Array.isArray;

/**
 * Checks if `value` is array-like. A value is considered array-like if it's
 * not a function and has a `value.length` that's an integer greater than or
 * equal to `0` and less than or equal to `Number.MAX_SAFE_INTEGER`.
 *
 * @static
 * @memberOf _
 * @since 4.0.0
 * @category Lang
 * @param {*} value The value to check.
 * @returns {boolean} Returns `true` if `value` is array-like, else `false`.
 * @example
 *
 * _.isArrayLike([1, 2, 3]);
 * // => true
 *
 * _.isArrayLike(document.body.children);
 * // => true
 *
 * _.isArrayLike('abc');
 * // => true
 *
 * _.isArrayLike(_.noop);
 * // => false
 */
function isArrayLike(value) {
  return value != null && isLength(value.length) && !isFunction(value);
}

/**
 * This method is like `_.isArrayLike` except that it also checks if `value`
 * is an object.
 *
 * @static
 * @memberOf _
 * @since 4.0.0
 * @category Lang
 * @param {*} value The value to check.
 * @returns {boolean} Returns `true` if `value` is an array-like object,
 *  else `false`.
 * @example
 *
 * _.isArrayLikeObject([1, 2, 3]);
 * // => true
 *
 * _.isArrayLikeObject(document.body.children);
 * // => true
 *
 * _.isArrayLikeObject('abc');
 * // => false
 *
 * _.isArrayLikeObject(_.noop);
 * // => false
 */
function isArrayLikeObject(value) {
  return isObjectLike(value) && isArrayLike(value);
}

/**
 * Checks if `value` is classified as a `Function` object.
 *
 * @static
 * @memberOf _
 * @since 0.1.0
 * @category Lang
 * @param {*} value The value to check.
 * @returns {boolean} Returns `true` if `value` is a function, else `false`.
 * @example
 *
 * _.isFunction(_);
 * // => true
 *
 * _.isFunction(/abc/);
 * // => false
 */
function isFunction(value) {
  // The use of `Object#toString` avoids issues with the `typeof` operator
  // in Safari 8-9 which returns 'object' for typed array and other constructors.
  var tag = isObject(value) ? objectToString.call(value) : '';
  return tag == funcTag || tag == genTag;
}

/**
 * Checks if `value` is a valid array-like length.
 *
 * **Note:** This method is loosely based on
 * [`ToLength`](http://ecma-international.org/ecma-262/7.0/#sec-tolength).
 *
 * @static
 * @memberOf _
 * @since 4.0.0
 * @category Lang
 * @param {*} value The value to check.
 * @returns {boolean} Returns `true` if `value` is a valid length, else `false`.
 * @example
 *
 * _.isLength(3);
 * // => true
 *
 * _.isLength(Number.MIN_VALUE);
 * // => false
 *
 * _.isLength(Infinity);
 * // => false
 *
 * _.isLength('3');
 * // => false
 */
function isLength(value) {
  return typeof value == 'number' &&
    value > -1 && value % 1 == 0 && value <= MAX_SAFE_INTEGER;
}

/**
 * Checks if `value` is the
 * [language type](http://www.ecma-international.org/ecma-262/7.0/#sec-ecmascript-language-types)
 * of `Object`. (e.g. arrays, functions, objects, regexes, `new Number(0)`, and `new String('')`)
 *
 * @static
 * @memberOf _
 * @since 0.1.0
 * @category Lang
 * @param {*} value The value to check.
 * @returns {boolean} Returns `true` if `value` is an object, else `false`.
 * @example
 *
 * _.isObject({});
 * // => true
 *
 * _.isObject([1, 2, 3]);
 * // => true
 *
 * _.isObject(_.noop);
 * // => true
 *
 * _.isObject(null);
 * // => false
 */
function isObject(value) {
  var type = typeof value;
  return !!value && (type == 'object' || type == 'function');
}

/**
 * Checks if `value` is object-like. A value is object-like if it's not `null`
 * and has a `typeof` result of "object".
 *
 * @static
 * @memberOf _
 * @since 4.0.0
 * @category Lang
 * @param {*} value The value to check.
 * @returns {boolean} Returns `true` if `value` is object-like, else `false`.
 * @example
 *
 * _.isObjectLike({});
 * // => true
 *
 * _.isObjectLike([1, 2, 3]);
 * // => true
 *
 * _.isObjectLike(_.noop);
 * // => false
 *
 * _.isObjectLike(null);
 * // => false
 */
function isObjectLike(value) {
  return !!value && typeof value == 'object';
}

/**
 * Assigns own enumerable string keyed properties of source objects to the
 * destination object. Source objects are applied from left to right.
 * Subsequent sources overwrite property assignments of previous sources.
 *
 * **Note:** This method mutates `object` and is loosely based on
 * [`Object.assign`](https://mdn.io/Object/assign).
 *
 * @static
 * @memberOf _
 * @since 0.10.0
 * @category Object
 * @param {Object} object The destination object.
 * @param {...Object} [sources] The source objects.
 * @returns {Object} Returns `object`.
 * @see _.assignIn
 * @example
 *
 * function Foo() {
 *   this.a = 1;
 * }
 *
 * function Bar() {
 *   this.c = 3;
 * }
 *
 * Foo.prototype.b = 2;
 * Bar.prototype.d = 4;
 *
 * _.assign({ 'a': 0 }, new Foo, new Bar);
 * // => { 'a': 1, 'c': 3 }
 */
var assign = createAssigner(function(object, source) {
  if (nonEnumShadows || isPrototype(source) || isArrayLike(source)) {
    copyObject(source, keys(source), object);
    return;
  }
  for (var key in source) {
    if (hasOwnProperty.call(source, key)) {
      assignValue(object, key, source[key]);
    }
  }
});

/**
 * Creates an array of the own enumerable property names of `object`.
 *
 * **Note:** Non-object values are coerced to objects. See the
 * [ES spec](http://ecma-international.org/ecma-262/7.0/#sec-object.keys)
 * for more details.
 *
 * @static
 * @since 0.1.0
 * @memberOf _
 * @category Object
 * @param {Object} object The object to query.
 * @returns {Array} Returns the array of property names.
 * @example
 *
 * function Foo() {
 *   this.a = 1;
 *   this.b = 2;
 * }
 *
 * Foo.prototype.c = 3;
 *
 * _.keys(new Foo);
 * // => ['a', 'b'] (iteration order is not guaranteed)
 *
 * _.keys('hi');
 * // => ['0', '1']
 */
function keys(object) {
  return isArrayLike(object) ? arrayLikeKeys(object) : baseKeys(object);
}

module.exports = assign;


/***/ }),
/* 67 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "b", function() { return bisectRight; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return bisectLeft; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__ascending__ = __webpack_require__(24);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__bisector__ = __webpack_require__(68);



var ascendingBisect = Object(__WEBPACK_IMPORTED_MODULE_1__bisector__["a" /* default */])(__WEBPACK_IMPORTED_MODULE_0__ascending__["a" /* default */]);
var bisectRight = ascendingBisect.right;
var bisectLeft = ascendingBisect.left;
/* harmony default export */ __webpack_exports__["c"] = (bisectRight);


/***/ }),
/* 68 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__ascending__ = __webpack_require__(24);


/* harmony default export */ __webpack_exports__["a"] = (function(compare) {
  if (compare.length === 1) compare = ascendingComparator(compare);
  return {
    left: function(a, x, lo, hi) {
      if (lo == null) lo = 0;
      if (hi == null) hi = a.length;
      while (lo < hi) {
        var mid = lo + hi >>> 1;
        if (compare(a[mid], x) < 0) lo = mid + 1;
        else hi = mid;
      }
      return lo;
    },
    right: function(a, x, lo, hi) {
      if (lo == null) lo = 0;
      if (hi == null) hi = a.length;
      while (lo < hi) {
        var mid = lo + hi >>> 1;
        if (compare(a[mid], x) > 0) hi = mid;
        else lo = mid + 1;
      }
      return lo;
    }
  };
});

function ascendingComparator(f) {
  return function(d, x) {
    return Object(__WEBPACK_IMPORTED_MODULE_0__ascending__["a" /* default */])(f(d), x);
  };
}


/***/ }),
/* 69 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (immutable) */ __webpack_exports__["b"] = pair;
/* harmony default export */ __webpack_exports__["a"] = (function(array, f) {
  if (f == null) f = pair;
  var i = 0, n = array.length - 1, p = array[0], pairs = new Array(n < 0 ? 0 : n);
  while (i < n) pairs[i] = f(p, p = array[++i]);
  return pairs;
});

function pair(a, b) {
  return [a, b];
}


/***/ }),
/* 70 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__variance__ = __webpack_require__(71);


/* harmony default export */ __webpack_exports__["a"] = (function(array, f) {
  var v = Object(__WEBPACK_IMPORTED_MODULE_0__variance__["a" /* default */])(array, f);
  return v ? Math.sqrt(v) : v;
});


/***/ }),
/* 71 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__number__ = __webpack_require__(26);


/* harmony default export */ __webpack_exports__["a"] = (function(values, valueof) {
  var n = values.length,
      m = 0,
      i = -1,
      mean = 0,
      value,
      delta,
      sum = 0;

  if (valueof == null) {
    while (++i < n) {
      if (!isNaN(value = Object(__WEBPACK_IMPORTED_MODULE_0__number__["a" /* default */])(values[i]))) {
        delta = value - mean;
        mean += delta / ++m;
        sum += delta * (value - mean);
      }
    }
  }

  else {
    while (++i < n) {
      if (!isNaN(value = Object(__WEBPACK_IMPORTED_MODULE_0__number__["a" /* default */])(valueof(values[i], i, values)))) {
        delta = value - mean;
        mean += delta / ++m;
        sum += delta * (value - mean);
      }
    }
  }

  if (m > 1) return sum / (m - 1);
});


/***/ }),
/* 72 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony default export */ __webpack_exports__["a"] = (function(values, valueof) {
  var n = values.length,
      i = -1,
      value,
      min,
      max;

  if (valueof == null) {
    while (++i < n) { // Find the first comparable value.
      if ((value = values[i]) != null && value >= value) {
        min = max = value;
        while (++i < n) { // Compare the remaining values.
          if ((value = values[i]) != null) {
            if (min > value) min = value;
            if (max < value) max = value;
          }
        }
      }
    }
  }

  else {
    while (++i < n) { // Find the first comparable value.
      if ((value = valueof(values[i], i, values)) != null && value >= value) {
        min = max = value;
        while (++i < n) { // Compare the remaining values.
          if ((value = valueof(values[i], i, values)) != null) {
            if (min > value) min = value;
            if (max < value) max = value;
          }
        }
      }
    }
  }

  return [min, max];
});


/***/ }),
/* 73 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "b", function() { return slice; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return map; });
var array = Array.prototype;

var slice = array.slice;
var map = array.map;


/***/ }),
/* 74 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony default export */ __webpack_exports__["a"] = (function(start, stop, step) {
  start = +start, stop = +stop, step = (n = arguments.length) < 2 ? (stop = start, start = 0, 1) : n < 3 ? 1 : +step;

  var i = -1,
      n = Math.max(0, Math.ceil((stop - start) / step)) | 0,
      range = new Array(n);

  while (++i < n) {
    range[i] = start + i * step;
  }

  return range;
});


/***/ }),
/* 75 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (immutable) */ __webpack_exports__["b"] = tickIncrement;
/* harmony export (immutable) */ __webpack_exports__["c"] = tickStep;
var e10 = Math.sqrt(50),
    e5 = Math.sqrt(10),
    e2 = Math.sqrt(2);

/* harmony default export */ __webpack_exports__["a"] = (function(start, stop, count) {
  var reverse = stop < start,
      i = -1,
      n,
      ticks,
      step;

  if (reverse) n = start, start = stop, stop = n;

  if ((step = tickIncrement(start, stop, count)) === 0 || !isFinite(step)) return [];

  if (step > 0) {
    start = Math.ceil(start / step);
    stop = Math.floor(stop / step);
    ticks = new Array(n = Math.ceil(stop - start + 1));
    while (++i < n) ticks[i] = (start + i) * step;
  } else {
    start = Math.floor(start * step);
    stop = Math.ceil(stop * step);
    ticks = new Array(n = Math.ceil(start - stop + 1));
    while (++i < n) ticks[i] = (start - i) / step;
  }

  if (reverse) ticks.reverse();

  return ticks;
});

function tickIncrement(start, stop, count) {
  var step = (stop - start) / Math.max(0, count),
      power = Math.floor(Math.log(step) / Math.LN10),
      error = step / Math.pow(10, power);
  return power >= 0
      ? (error >= e10 ? 10 : error >= e5 ? 5 : error >= e2 ? 2 : 1) * Math.pow(10, power)
      : -Math.pow(10, -power) / (error >= e10 ? 10 : error >= e5 ? 5 : error >= e2 ? 2 : 1);
}

function tickStep(start, stop, count) {
  var step0 = Math.abs(stop - start) / Math.max(0, count),
      step1 = Math.pow(10, Math.floor(Math.log(step0) / Math.LN10)),
      error = step0 / step1;
  if (error >= e10) step1 *= 10;
  else if (error >= e5) step1 *= 5;
  else if (error >= e2) step1 *= 2;
  return stop < start ? -step1 : step1;
}


/***/ }),
/* 76 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony default export */ __webpack_exports__["a"] = (function(values) {
  return Math.ceil(Math.log(values.length) / Math.LN2) + 1;
});


/***/ }),
/* 77 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony default export */ __webpack_exports__["a"] = (function(values, valueof) {
  var n = values.length,
      i = -1,
      value,
      min;

  if (valueof == null) {
    while (++i < n) { // Find the first comparable value.
      if ((value = values[i]) != null && value >= value) {
        min = value;
        while (++i < n) { // Compare the remaining values.
          if ((value = values[i]) != null && min > value) {
            min = value;
          }
        }
      }
    }
  }

  else {
    while (++i < n) { // Find the first comparable value.
      if ((value = valueof(values[i], i, values)) != null && value >= value) {
        min = value;
        while (++i < n) { // Compare the remaining values.
          if ((value = valueof(values[i], i, values)) != null && min > value) {
            min = value;
          }
        }
      }
    }
  }

  return min;
});


/***/ }),
/* 78 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__min__ = __webpack_require__(77);


/* harmony default export */ __webpack_exports__["a"] = (function(matrix) {
  if (!(n = matrix.length)) return [];
  for (var i = -1, m = Object(__WEBPACK_IMPORTED_MODULE_0__min__["a" /* default */])(matrix, length), transpose = new Array(m); ++i < m;) {
    for (var j = -1, n, row = transpose[i] = new Array(n); ++j < n;) {
      row[j] = matrix[j][i];
    }
  }
  return transpose;
});

function length(d) {
  return d.length;
}


/***/ }),
/* 79 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return deg2rad; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "b", function() { return rad2deg; });
var deg2rad = Math.PI / 180;
var rad2deg = 180 / Math.PI;


/***/ }),
/* 80 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__exponent__ = __webpack_require__(34);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__formatGroup__ = __webpack_require__(158);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__formatNumerals__ = __webpack_require__(159);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__formatSpecifier__ = __webpack_require__(81);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__formatTypes__ = __webpack_require__(82);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5__formatPrefixAuto__ = __webpack_require__(83);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_6__identity__ = __webpack_require__(162);








var prefixes = ["y","z","a","f","p","n","µ","m","","k","M","G","T","P","E","Z","Y"];

/* harmony default export */ __webpack_exports__["a"] = (function(locale) {
  var group = locale.grouping && locale.thousands ? Object(__WEBPACK_IMPORTED_MODULE_1__formatGroup__["a" /* default */])(locale.grouping, locale.thousands) : __WEBPACK_IMPORTED_MODULE_6__identity__["a" /* default */],
      currency = locale.currency,
      decimal = locale.decimal,
      numerals = locale.numerals ? Object(__WEBPACK_IMPORTED_MODULE_2__formatNumerals__["a" /* default */])(locale.numerals) : __WEBPACK_IMPORTED_MODULE_6__identity__["a" /* default */],
      percent = locale.percent || "%";

  function newFormat(specifier) {
    specifier = Object(__WEBPACK_IMPORTED_MODULE_3__formatSpecifier__["a" /* default */])(specifier);

    var fill = specifier.fill,
        align = specifier.align,
        sign = specifier.sign,
        symbol = specifier.symbol,
        zero = specifier.zero,
        width = specifier.width,
        comma = specifier.comma,
        precision = specifier.precision,
        type = specifier.type;

    // Compute the prefix and suffix.
    // For SI-prefix, the suffix is lazily computed.
    var prefix = symbol === "$" ? currency[0] : symbol === "#" && /[boxX]/.test(type) ? "0" + type.toLowerCase() : "",
        suffix = symbol === "$" ? currency[1] : /[%p]/.test(type) ? percent : "";

    // What format function should we use?
    // Is this an integer type?
    // Can this type generate exponential notation?
    var formatType = __WEBPACK_IMPORTED_MODULE_4__formatTypes__["a" /* default */][type],
        maybeSuffix = !type || /[defgprs%]/.test(type);

    // Set the default precision if not specified,
    // or clamp the specified precision to the supported range.
    // For significant precision, it must be in [1, 21].
    // For fixed precision, it must be in [0, 20].
    precision = precision == null ? (type ? 6 : 12)
        : /[gprs]/.test(type) ? Math.max(1, Math.min(21, precision))
        : Math.max(0, Math.min(20, precision));

    function format(value) {
      var valuePrefix = prefix,
          valueSuffix = suffix,
          i, n, c;

      if (type === "c") {
        valueSuffix = formatType(value) + valueSuffix;
        value = "";
      } else {
        value = +value;

        // Perform the initial formatting.
        var valueNegative = value < 0;
        value = formatType(Math.abs(value), precision);

        // If a negative value rounds to zero during formatting, treat as positive.
        if (valueNegative && +value === 0) valueNegative = false;

        // Compute the prefix and suffix.
        valuePrefix = (valueNegative ? (sign === "(" ? sign : "-") : sign === "-" || sign === "(" ? "" : sign) + valuePrefix;
        valueSuffix = valueSuffix + (type === "s" ? prefixes[8 + __WEBPACK_IMPORTED_MODULE_5__formatPrefixAuto__["b" /* prefixExponent */] / 3] : "") + (valueNegative && sign === "(" ? ")" : "");

        // Break the formatted value into the integer “value” part that can be
        // grouped, and fractional or exponential “suffix” part that is not.
        if (maybeSuffix) {
          i = -1, n = value.length;
          while (++i < n) {
            if (c = value.charCodeAt(i), 48 > c || c > 57) {
              valueSuffix = (c === 46 ? decimal + value.slice(i + 1) : value.slice(i)) + valueSuffix;
              value = value.slice(0, i);
              break;
            }
          }
        }
      }

      // If the fill character is not "0", grouping is applied before padding.
      if (comma && !zero) value = group(value, Infinity);

      // Compute the padding.
      var length = valuePrefix.length + value.length + valueSuffix.length,
          padding = length < width ? new Array(width - length + 1).join(fill) : "";

      // If the fill character is "0", grouping is applied after padding.
      if (comma && zero) value = group(padding + value, padding.length ? width - valueSuffix.length : Infinity), padding = "";

      // Reconstruct the final output based on the desired alignment.
      switch (align) {
        case "<": value = valuePrefix + value + valueSuffix + padding; break;
        case "=": value = valuePrefix + padding + value + valueSuffix; break;
        case "^": value = padding.slice(0, length = padding.length >> 1) + valuePrefix + value + valueSuffix + padding.slice(length); break;
        default: value = padding + valuePrefix + value + valueSuffix; break;
      }

      return numerals(value);
    }

    format.toString = function() {
      return specifier + "";
    };

    return format;
  }

  function formatPrefix(specifier, value) {
    var f = newFormat((specifier = Object(__WEBPACK_IMPORTED_MODULE_3__formatSpecifier__["a" /* default */])(specifier), specifier.type = "f", specifier)),
        e = Math.max(-8, Math.min(8, Math.floor(Object(__WEBPACK_IMPORTED_MODULE_0__exponent__["a" /* default */])(value) / 3))) * 3,
        k = Math.pow(10, -e),
        prefix = prefixes[8 + e / 3];
    return function(value) {
      return f(k * value) + prefix;
    };
  }

  return {
    format: newFormat,
    formatPrefix: formatPrefix
  };
});


/***/ }),
/* 81 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (immutable) */ __webpack_exports__["a"] = formatSpecifier;
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__formatTypes__ = __webpack_require__(82);


// [[fill]align][sign][symbol][0][width][,][.precision][type]
var re = /^(?:(.)?([<>=^]))?([+\-\( ])?([$#])?(0)?(\d+)?(,)?(\.\d+)?([a-z%])?$/i;

function formatSpecifier(specifier) {
  return new FormatSpecifier(specifier);
}

formatSpecifier.prototype = FormatSpecifier.prototype; // instanceof

function FormatSpecifier(specifier) {
  if (!(match = re.exec(specifier))) throw new Error("invalid format: " + specifier);

  var match,
      fill = match[1] || " ",
      align = match[2] || ">",
      sign = match[3] || "-",
      symbol = match[4] || "",
      zero = !!match[5],
      width = match[6] && +match[6],
      comma = !!match[7],
      precision = match[8] && +match[8].slice(1),
      type = match[9] || "";

  // The "n" type is an alias for ",g".
  if (type === "n") comma = true, type = "g";

  // Map invalid types to the default format.
  else if (!__WEBPACK_IMPORTED_MODULE_0__formatTypes__["a" /* default */][type]) type = "";

  // If zero fill is specified, padding goes after sign and before digits.
  if (zero || (fill === "0" && align === "=")) zero = true, fill = "0", align = "=";

  this.fill = fill;
  this.align = align;
  this.sign = sign;
  this.symbol = symbol;
  this.zero = zero;
  this.width = width;
  this.comma = comma;
  this.precision = precision;
  this.type = type;
}

FormatSpecifier.prototype.toString = function() {
  return this.fill
      + this.align
      + this.sign
      + this.symbol
      + (this.zero ? "0" : "")
      + (this.width == null ? "" : Math.max(1, this.width | 0))
      + (this.comma ? "," : "")
      + (this.precision == null ? "" : "." + Math.max(0, this.precision | 0))
      + this.type;
};


/***/ }),
/* 82 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__formatDefault__ = __webpack_require__(160);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__formatPrefixAuto__ = __webpack_require__(83);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__formatRounded__ = __webpack_require__(161);




/* harmony default export */ __webpack_exports__["a"] = ({
  "": __WEBPACK_IMPORTED_MODULE_0__formatDefault__["a" /* default */],
  "%": function(x, p) { return (x * 100).toFixed(p); },
  "b": function(x) { return Math.round(x).toString(2); },
  "c": function(x) { return x + ""; },
  "d": function(x) { return Math.round(x).toString(10); },
  "e": function(x, p) { return x.toExponential(p); },
  "f": function(x, p) { return x.toFixed(p); },
  "g": function(x, p) { return x.toPrecision(p); },
  "o": function(x) { return Math.round(x).toString(8); },
  "p": function(x, p) { return Object(__WEBPACK_IMPORTED_MODULE_2__formatRounded__["a" /* default */])(x * 100, p); },
  "r": __WEBPACK_IMPORTED_MODULE_2__formatRounded__["a" /* default */],
  "s": __WEBPACK_IMPORTED_MODULE_1__formatPrefixAuto__["a" /* default */],
  "X": function(x) { return Math.round(x).toString(16).toUpperCase(); },
  "x": function(x) { return Math.round(x).toString(16); }
});


/***/ }),
/* 83 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "b", function() { return prefixExponent; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__formatDecimal__ = __webpack_require__(46);


var prefixExponent;

/* harmony default export */ __webpack_exports__["a"] = (function(x, p) {
  var d = Object(__WEBPACK_IMPORTED_MODULE_0__formatDecimal__["a" /* default */])(x, p);
  if (!d) return x + "";
  var coefficient = d[0],
      exponent = d[1],
      i = exponent - (prefixExponent = Math.max(-8, Math.min(8, Math.floor(exponent / 3))) * 3) + 1,
      n = coefficient.length;
  return i === n ? coefficient
      : i > n ? coefficient + new Array(i - n + 1).join("0")
      : i > 0 ? coefficient.slice(0, i) + "." + coefficient.slice(i)
      : "0." + new Array(1 - i).join("0") + Object(__WEBPACK_IMPORTED_MODULE_0__formatDecimal__["a" /* default */])(x, Math.max(0, p + i - 1))[0]; // less than 1y!
});


/***/ }),
/* 84 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "b", function() { return implicit; });
/* harmony export (immutable) */ __webpack_exports__["a"] = ordinal;
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_d3_collection__ = __webpack_require__(27);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__array__ = __webpack_require__(18);



var implicit = {name: "implicit"};

function ordinal(range) {
  var index = Object(__WEBPACK_IMPORTED_MODULE_0_d3_collection__["map"])(),
      domain = [],
      unknown = implicit;

  range = range == null ? [] : __WEBPACK_IMPORTED_MODULE_1__array__["b" /* slice */].call(range);

  function scale(d) {
    var key = d + "", i = index.get(key);
    if (!i) {
      if (unknown !== implicit) return unknown;
      index.set(key, i = domain.push(d));
    }
    return range[(i - 1) % range.length];
  }

  scale.domain = function(_) {
    if (!arguments.length) return domain.slice();
    domain = [], index = Object(__WEBPACK_IMPORTED_MODULE_0_d3_collection__["map"])();
    var i = -1, n = _.length, d, key;
    while (++i < n) if (!index.has(key = (d = _[i]) + "")) index.set(key, domain.push(d));
    return scale;
  };

  scale.range = function(_) {
    return arguments.length ? (range = __WEBPACK_IMPORTED_MODULE_1__array__["b" /* slice */].call(_), scale) : range.slice();
  };

  scale.unknown = function(_) {
    return arguments.length ? (unknown = _, scale) : unknown;
  };

  scale.copy = function() {
    return ordinal()
        .domain(domain)
        .range(range)
        .unknown(unknown);
  };

  return scale;
}


/***/ }),
/* 85 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "b", function() { return rgbBasis; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "c", function() { return rgbBasisClosed; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_d3_color__ = __webpack_require__(12);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__basis__ = __webpack_require__(49);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__basisClosed__ = __webpack_require__(86);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__color__ = __webpack_require__(29);





/* harmony default export */ __webpack_exports__["a"] = ((function rgbGamma(y) {
  var color = Object(__WEBPACK_IMPORTED_MODULE_3__color__["b" /* gamma */])(y);

  function rgb(start, end) {
    var r = color((start = Object(__WEBPACK_IMPORTED_MODULE_0_d3_color__["rgb"])(start)).r, (end = Object(__WEBPACK_IMPORTED_MODULE_0_d3_color__["rgb"])(end)).r),
        g = color(start.g, end.g),
        b = color(start.b, end.b),
        opacity = Object(__WEBPACK_IMPORTED_MODULE_3__color__["a" /* default */])(start.opacity, end.opacity);
    return function(t) {
      start.r = r(t);
      start.g = g(t);
      start.b = b(t);
      start.opacity = opacity(t);
      return start + "";
    };
  }

  rgb.gamma = rgbGamma;

  return rgb;
})(1));

function rgbSpline(spline) {
  return function(colors) {
    var n = colors.length,
        r = new Array(n),
        g = new Array(n),
        b = new Array(n),
        i, color;
    for (i = 0; i < n; ++i) {
      color = Object(__WEBPACK_IMPORTED_MODULE_0_d3_color__["rgb"])(colors[i]);
      r[i] = color.r || 0;
      g[i] = color.g || 0;
      b[i] = color.b || 0;
    }
    r = spline(r);
    g = spline(g);
    b = spline(b);
    color.opacity = 1;
    return function(t) {
      color.r = r(t);
      color.g = g(t);
      color.b = b(t);
      return color + "";
    };
  };
}

var rgbBasis = rgbSpline(__WEBPACK_IMPORTED_MODULE_1__basis__["b" /* default */]);
var rgbBasisClosed = rgbSpline(__WEBPACK_IMPORTED_MODULE_2__basisClosed__["a" /* default */]);


/***/ }),
/* 86 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__basis__ = __webpack_require__(49);


/* harmony default export */ __webpack_exports__["a"] = (function(values) {
  var n = values.length;
  return function(t) {
    var i = Math.floor(((t %= 1) < 0 ? ++t : t) * n),
        v0 = values[(i + n - 1) % n],
        v1 = values[i % n],
        v2 = values[(i + 1) % n],
        v3 = values[(i + 2) % n];
    return Object(__WEBPACK_IMPORTED_MODULE_0__basis__["a" /* basis */])((t - i / n) * n, v0, v1, v2, v3);
  };
});


/***/ }),
/* 87 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony default export */ __webpack_exports__["a"] = (function(x) {
  return function() {
    return x;
  };
});


/***/ }),
/* 88 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__value__ = __webpack_require__(48);


/* harmony default export */ __webpack_exports__["a"] = (function(a, b) {
  var nb = b ? b.length : 0,
      na = a ? Math.min(nb, a.length) : 0,
      x = new Array(nb),
      c = new Array(nb),
      i;

  for (i = 0; i < na; ++i) x[i] = Object(__WEBPACK_IMPORTED_MODULE_0__value__["a" /* default */])(a[i], b[i]);
  for (; i < nb; ++i) c[i] = b[i];

  return function(t) {
    for (i = 0; i < na; ++i) c[i] = x[i](t);
    return c;
  };
});


/***/ }),
/* 89 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony default export */ __webpack_exports__["a"] = (function(a, b) {
  var d = new Date;
  return a = +a, b -= a, function(t) {
    return d.setTime(a + b * t), d;
  };
});


/***/ }),
/* 90 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__value__ = __webpack_require__(48);


/* harmony default export */ __webpack_exports__["a"] = (function(a, b) {
  var i = {},
      c = {},
      k;

  if (a === null || typeof a !== "object") a = {};
  if (b === null || typeof b !== "object") b = {};

  for (k in b) {
    if (k in a) {
      i[k] = Object(__WEBPACK_IMPORTED_MODULE_0__value__["a" /* default */])(a[k], b[k]);
    } else {
      c[k] = b[k];
    }
  }

  return function(t) {
    for (k in i) c[k] = i[k](t);
    return c;
  };
});


/***/ }),
/* 91 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__number__ = __webpack_require__(35);


var reA = /[-+]?(?:\d+\.?\d*|\.?\d+)(?:[eE][-+]?\d+)?/g,
    reB = new RegExp(reA.source, "g");

function zero(b) {
  return function() {
    return b;
  };
}

function one(b) {
  return function(t) {
    return b(t) + "";
  };
}

/* harmony default export */ __webpack_exports__["a"] = (function(a, b) {
  var bi = reA.lastIndex = reB.lastIndex = 0, // scan index for next number in b
      am, // current match in a
      bm, // current match in b
      bs, // string preceding current number in b, if any
      i = -1, // index in s
      s = [], // string constants and placeholders
      q = []; // number interpolators

  // Coerce inputs to strings.
  a = a + "", b = b + "";

  // Interpolate pairs of numbers in a & b.
  while ((am = reA.exec(a))
      && (bm = reB.exec(b))) {
    if ((bs = bm.index) > bi) { // a string precedes the next number in b
      bs = b.slice(bi, bs);
      if (s[i]) s[i] += bs; // coalesce with previous string
      else s[++i] = bs;
    }
    if ((am = am[0]) === (bm = bm[0])) { // numbers in a & b match
      if (s[i]) s[i] += bm; // coalesce with previous string
      else s[++i] = bm;
    } else { // interpolate non-matching numbers
      s[++i] = null;
      q.push({i: i, x: Object(__WEBPACK_IMPORTED_MODULE_0__number__["a" /* default */])(am, bm)});
    }
    bi = reB.lastIndex;
  }

  // Add remains of b.
  if (bi < b.length) {
    bs = b.slice(bi);
    if (s[i]) s[i] += bs; // coalesce with previous string
    else s[++i] = bs;
  }

  // Special optimization for only a single match.
  // Otherwise, interpolate each of the numbers and rejoin the string.
  return s.length < 2 ? (q[0]
      ? one(q[0].x)
      : zero(b))
      : (b = q.length, function(t) {
          for (var i = 0, o; i < b; ++i) s[(o = q[i]).i] = o.x(t);
          return s.join("");
        });
});


/***/ }),
/* 92 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony default export */ __webpack_exports__["a"] = (function(x) {
  return +x;
});


/***/ }),
/* 93 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony default export */ __webpack_exports__["a"] = (function(domain, interval) {
  domain = domain.slice();

  var i0 = 0,
      i1 = domain.length - 1,
      x0 = domain[i0],
      x1 = domain[i1],
      t;

  if (x1 < x0) {
    t = i0, i0 = i1, i1 = t;
    t = x0, x0 = x1, x1 = t;
  }

  domain[i0] = interval.floor(x0);
  domain[i1] = interval.ceil(x1);
  return domain;
});


/***/ }),
/* 94 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (immutable) */ __webpack_exports__["a"] = calendar;
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_d3_array__ = __webpack_require__(1);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_d3_interpolate__ = __webpack_require__(9);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2_d3_time__ = __webpack_require__(25);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3_d3_time_format__ = __webpack_require__(19);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__array__ = __webpack_require__(18);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5__continuous__ = __webpack_require__(36);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_6__nice__ = __webpack_require__(93);








var durationSecond = 1000,
    durationMinute = durationSecond * 60,
    durationHour = durationMinute * 60,
    durationDay = durationHour * 24,
    durationWeek = durationDay * 7,
    durationMonth = durationDay * 30,
    durationYear = durationDay * 365;

function date(t) {
  return new Date(t);
}

function number(t) {
  return t instanceof Date ? +t : +new Date(+t);
}

function calendar(year, month, week, day, hour, minute, second, millisecond, format) {
  var scale = Object(__WEBPACK_IMPORTED_MODULE_5__continuous__["b" /* default */])(__WEBPACK_IMPORTED_MODULE_5__continuous__["c" /* deinterpolateLinear */], __WEBPACK_IMPORTED_MODULE_1_d3_interpolate__["interpolateNumber"]),
      invert = scale.invert,
      domain = scale.domain;

  var formatMillisecond = format(".%L"),
      formatSecond = format(":%S"),
      formatMinute = format("%I:%M"),
      formatHour = format("%I %p"),
      formatDay = format("%a %d"),
      formatWeek = format("%b %d"),
      formatMonth = format("%B"),
      formatYear = format("%Y");

  var tickIntervals = [
    [second,  1,      durationSecond],
    [second,  5,  5 * durationSecond],
    [second, 15, 15 * durationSecond],
    [second, 30, 30 * durationSecond],
    [minute,  1,      durationMinute],
    [minute,  5,  5 * durationMinute],
    [minute, 15, 15 * durationMinute],
    [minute, 30, 30 * durationMinute],
    [  hour,  1,      durationHour  ],
    [  hour,  3,  3 * durationHour  ],
    [  hour,  6,  6 * durationHour  ],
    [  hour, 12, 12 * durationHour  ],
    [   day,  1,      durationDay   ],
    [   day,  2,  2 * durationDay   ],
    [  week,  1,      durationWeek  ],
    [ month,  1,      durationMonth ],
    [ month,  3,  3 * durationMonth ],
    [  year,  1,      durationYear  ]
  ];

  function tickFormat(date) {
    return (second(date) < date ? formatMillisecond
        : minute(date) < date ? formatSecond
        : hour(date) < date ? formatMinute
        : day(date) < date ? formatHour
        : month(date) < date ? (week(date) < date ? formatDay : formatWeek)
        : year(date) < date ? formatMonth
        : formatYear)(date);
  }

  function tickInterval(interval, start, stop, step) {
    if (interval == null) interval = 10;

    // If a desired tick count is specified, pick a reasonable tick interval
    // based on the extent of the domain and a rough estimate of tick size.
    // Otherwise, assume interval is already a time interval and use it.
    if (typeof interval === "number") {
      var target = Math.abs(stop - start) / interval,
          i = Object(__WEBPACK_IMPORTED_MODULE_0_d3_array__["bisector"])(function(i) { return i[2]; }).right(tickIntervals, target);
      if (i === tickIntervals.length) {
        step = Object(__WEBPACK_IMPORTED_MODULE_0_d3_array__["tickStep"])(start / durationYear, stop / durationYear, interval);
        interval = year;
      } else if (i) {
        i = tickIntervals[target / tickIntervals[i - 1][2] < tickIntervals[i][2] / target ? i - 1 : i];
        step = i[1];
        interval = i[0];
      } else {
        step = Math.max(Object(__WEBPACK_IMPORTED_MODULE_0_d3_array__["tickStep"])(start, stop, interval), 1);
        interval = millisecond;
      }
    }

    return step == null ? interval : interval.every(step);
  }

  scale.invert = function(y) {
    return new Date(invert(y));
  };

  scale.domain = function(_) {
    return arguments.length ? domain(__WEBPACK_IMPORTED_MODULE_4__array__["a" /* map */].call(_, number)) : domain().map(date);
  };

  scale.ticks = function(interval, step) {
    var d = domain(),
        t0 = d[0],
        t1 = d[d.length - 1],
        r = t1 < t0,
        t;
    if (r) t = t0, t0 = t1, t1 = t;
    t = tickInterval(interval, t0, t1, step);
    t = t ? t.range(t0, t1 + 1) : []; // inclusive stop
    return r ? t.reverse() : t;
  };

  scale.tickFormat = function(count, specifier) {
    return specifier == null ? tickFormat : format(specifier);
  };

  scale.nice = function(interval, step) {
    var d = domain();
    return (interval = tickInterval(interval, d[0], d[d.length - 1], step))
        ? domain(Object(__WEBPACK_IMPORTED_MODULE_6__nice__["a" /* default */])(d, interval))
        : scale;
  };

  scale.copy = function() {
    return Object(__WEBPACK_IMPORTED_MODULE_5__continuous__["a" /* copy */])(scale, calendar(year, month, week, day, hour, minute, second, millisecond, format));
  };

  return scale;
}

/* harmony default export */ __webpack_exports__["b"] = (function() {
  return calendar(__WEBPACK_IMPORTED_MODULE_2_d3_time__["timeYear"], __WEBPACK_IMPORTED_MODULE_2_d3_time__["timeMonth"], __WEBPACK_IMPORTED_MODULE_2_d3_time__["timeWeek"], __WEBPACK_IMPORTED_MODULE_2_d3_time__["timeDay"], __WEBPACK_IMPORTED_MODULE_2_d3_time__["timeHour"], __WEBPACK_IMPORTED_MODULE_2_d3_time__["timeMinute"], __WEBPACK_IMPORTED_MODULE_2_d3_time__["timeSecond"], __WEBPACK_IMPORTED_MODULE_2_d3_time__["timeMillisecond"], __WEBPACK_IMPORTED_MODULE_3_d3_time_format__["timeFormat"]).domain([new Date(2000, 0, 1), new Date(2000, 0, 2)]);
});


/***/ }),
/* 95 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (immutable) */ __webpack_exports__["a"] = formatLocale;
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_d3_time__ = __webpack_require__(25);


function localDate(d) {
  if (0 <= d.y && d.y < 100) {
    var date = new Date(-1, d.m, d.d, d.H, d.M, d.S, d.L);
    date.setFullYear(d.y);
    return date;
  }
  return new Date(d.y, d.m, d.d, d.H, d.M, d.S, d.L);
}

function utcDate(d) {
  if (0 <= d.y && d.y < 100) {
    var date = new Date(Date.UTC(-1, d.m, d.d, d.H, d.M, d.S, d.L));
    date.setUTCFullYear(d.y);
    return date;
  }
  return new Date(Date.UTC(d.y, d.m, d.d, d.H, d.M, d.S, d.L));
}

function newYear(y) {
  return {y: y, m: 0, d: 1, H: 0, M: 0, S: 0, L: 0};
}

function formatLocale(locale) {
  var locale_dateTime = locale.dateTime,
      locale_date = locale.date,
      locale_time = locale.time,
      locale_periods = locale.periods,
      locale_weekdays = locale.days,
      locale_shortWeekdays = locale.shortDays,
      locale_months = locale.months,
      locale_shortMonths = locale.shortMonths;

  var periodRe = formatRe(locale_periods),
      periodLookup = formatLookup(locale_periods),
      weekdayRe = formatRe(locale_weekdays),
      weekdayLookup = formatLookup(locale_weekdays),
      shortWeekdayRe = formatRe(locale_shortWeekdays),
      shortWeekdayLookup = formatLookup(locale_shortWeekdays),
      monthRe = formatRe(locale_months),
      monthLookup = formatLookup(locale_months),
      shortMonthRe = formatRe(locale_shortMonths),
      shortMonthLookup = formatLookup(locale_shortMonths);

  var formats = {
    "a": formatShortWeekday,
    "A": formatWeekday,
    "b": formatShortMonth,
    "B": formatMonth,
    "c": null,
    "d": formatDayOfMonth,
    "e": formatDayOfMonth,
    "H": formatHour24,
    "I": formatHour12,
    "j": formatDayOfYear,
    "L": formatMilliseconds,
    "m": formatMonthNumber,
    "M": formatMinutes,
    "p": formatPeriod,
    "S": formatSeconds,
    "U": formatWeekNumberSunday,
    "w": formatWeekdayNumber,
    "W": formatWeekNumberMonday,
    "x": null,
    "X": null,
    "y": formatYear,
    "Y": formatFullYear,
    "Z": formatZone,
    "%": formatLiteralPercent
  };

  var utcFormats = {
    "a": formatUTCShortWeekday,
    "A": formatUTCWeekday,
    "b": formatUTCShortMonth,
    "B": formatUTCMonth,
    "c": null,
    "d": formatUTCDayOfMonth,
    "e": formatUTCDayOfMonth,
    "H": formatUTCHour24,
    "I": formatUTCHour12,
    "j": formatUTCDayOfYear,
    "L": formatUTCMilliseconds,
    "m": formatUTCMonthNumber,
    "M": formatUTCMinutes,
    "p": formatUTCPeriod,
    "S": formatUTCSeconds,
    "U": formatUTCWeekNumberSunday,
    "w": formatUTCWeekdayNumber,
    "W": formatUTCWeekNumberMonday,
    "x": null,
    "X": null,
    "y": formatUTCYear,
    "Y": formatUTCFullYear,
    "Z": formatUTCZone,
    "%": formatLiteralPercent
  };

  var parses = {
    "a": parseShortWeekday,
    "A": parseWeekday,
    "b": parseShortMonth,
    "B": parseMonth,
    "c": parseLocaleDateTime,
    "d": parseDayOfMonth,
    "e": parseDayOfMonth,
    "H": parseHour24,
    "I": parseHour24,
    "j": parseDayOfYear,
    "L": parseMilliseconds,
    "m": parseMonthNumber,
    "M": parseMinutes,
    "p": parsePeriod,
    "S": parseSeconds,
    "U": parseWeekNumberSunday,
    "w": parseWeekdayNumber,
    "W": parseWeekNumberMonday,
    "x": parseLocaleDate,
    "X": parseLocaleTime,
    "y": parseYear,
    "Y": parseFullYear,
    "Z": parseZone,
    "%": parseLiteralPercent
  };

  // These recursive directive definitions must be deferred.
  formats.x = newFormat(locale_date, formats);
  formats.X = newFormat(locale_time, formats);
  formats.c = newFormat(locale_dateTime, formats);
  utcFormats.x = newFormat(locale_date, utcFormats);
  utcFormats.X = newFormat(locale_time, utcFormats);
  utcFormats.c = newFormat(locale_dateTime, utcFormats);

  function newFormat(specifier, formats) {
    return function(date) {
      var string = [],
          i = -1,
          j = 0,
          n = specifier.length,
          c,
          pad,
          format;

      if (!(date instanceof Date)) date = new Date(+date);

      while (++i < n) {
        if (specifier.charCodeAt(i) === 37) {
          string.push(specifier.slice(j, i));
          if ((pad = pads[c = specifier.charAt(++i)]) != null) c = specifier.charAt(++i);
          else pad = c === "e" ? " " : "0";
          if (format = formats[c]) c = format(date, pad);
          string.push(c);
          j = i + 1;
        }
      }

      string.push(specifier.slice(j, i));
      return string.join("");
    };
  }

  function newParse(specifier, newDate) {
    return function(string) {
      var d = newYear(1900),
          i = parseSpecifier(d, specifier, string += "", 0);
      if (i != string.length) return null;

      // The am-pm flag is 0 for AM, and 1 for PM.
      if ("p" in d) d.H = d.H % 12 + d.p * 12;

      // Convert day-of-week and week-of-year to day-of-year.
      if ("W" in d || "U" in d) {
        if (!("w" in d)) d.w = "W" in d ? 1 : 0;
        var day = "Z" in d ? utcDate(newYear(d.y)).getUTCDay() : newDate(newYear(d.y)).getDay();
        d.m = 0;
        d.d = "W" in d ? (d.w + 6) % 7 + d.W * 7 - (day + 5) % 7 : d.w + d.U * 7 - (day + 6) % 7;
      }

      // If a time zone is specified, all fields are interpreted as UTC and then
      // offset according to the specified time zone.
      if ("Z" in d) {
        d.H += d.Z / 100 | 0;
        d.M += d.Z % 100;
        return utcDate(d);
      }

      // Otherwise, all fields are in local time.
      return newDate(d);
    };
  }

  function parseSpecifier(d, specifier, string, j) {
    var i = 0,
        n = specifier.length,
        m = string.length,
        c,
        parse;

    while (i < n) {
      if (j >= m) return -1;
      c = specifier.charCodeAt(i++);
      if (c === 37) {
        c = specifier.charAt(i++);
        parse = parses[c in pads ? specifier.charAt(i++) : c];
        if (!parse || ((j = parse(d, string, j)) < 0)) return -1;
      } else if (c != string.charCodeAt(j++)) {
        return -1;
      }
    }

    return j;
  }

  function parsePeriod(d, string, i) {
    var n = periodRe.exec(string.slice(i));
    return n ? (d.p = periodLookup[n[0].toLowerCase()], i + n[0].length) : -1;
  }

  function parseShortWeekday(d, string, i) {
    var n = shortWeekdayRe.exec(string.slice(i));
    return n ? (d.w = shortWeekdayLookup[n[0].toLowerCase()], i + n[0].length) : -1;
  }

  function parseWeekday(d, string, i) {
    var n = weekdayRe.exec(string.slice(i));
    return n ? (d.w = weekdayLookup[n[0].toLowerCase()], i + n[0].length) : -1;
  }

  function parseShortMonth(d, string, i) {
    var n = shortMonthRe.exec(string.slice(i));
    return n ? (d.m = shortMonthLookup[n[0].toLowerCase()], i + n[0].length) : -1;
  }

  function parseMonth(d, string, i) {
    var n = monthRe.exec(string.slice(i));
    return n ? (d.m = monthLookup[n[0].toLowerCase()], i + n[0].length) : -1;
  }

  function parseLocaleDateTime(d, string, i) {
    return parseSpecifier(d, locale_dateTime, string, i);
  }

  function parseLocaleDate(d, string, i) {
    return parseSpecifier(d, locale_date, string, i);
  }

  function parseLocaleTime(d, string, i) {
    return parseSpecifier(d, locale_time, string, i);
  }

  function formatShortWeekday(d) {
    return locale_shortWeekdays[d.getDay()];
  }

  function formatWeekday(d) {
    return locale_weekdays[d.getDay()];
  }

  function formatShortMonth(d) {
    return locale_shortMonths[d.getMonth()];
  }

  function formatMonth(d) {
    return locale_months[d.getMonth()];
  }

  function formatPeriod(d) {
    return locale_periods[+(d.getHours() >= 12)];
  }

  function formatUTCShortWeekday(d) {
    return locale_shortWeekdays[d.getUTCDay()];
  }

  function formatUTCWeekday(d) {
    return locale_weekdays[d.getUTCDay()];
  }

  function formatUTCShortMonth(d) {
    return locale_shortMonths[d.getUTCMonth()];
  }

  function formatUTCMonth(d) {
    return locale_months[d.getUTCMonth()];
  }

  function formatUTCPeriod(d) {
    return locale_periods[+(d.getUTCHours() >= 12)];
  }

  return {
    format: function(specifier) {
      var f = newFormat(specifier += "", formats);
      f.toString = function() { return specifier; };
      return f;
    },
    parse: function(specifier) {
      var p = newParse(specifier += "", localDate);
      p.toString = function() { return specifier; };
      return p;
    },
    utcFormat: function(specifier) {
      var f = newFormat(specifier += "", utcFormats);
      f.toString = function() { return specifier; };
      return f;
    },
    utcParse: function(specifier) {
      var p = newParse(specifier, utcDate);
      p.toString = function() { return specifier; };
      return p;
    }
  };
}

var pads = {"-": "", "_": " ", "0": "0"},
    numberRe = /^\s*\d+/, // note: ignores next directive
    percentRe = /^%/,
    requoteRe = /[\\\^\$\*\+\?\|\[\]\(\)\.\{\}]/g;

function pad(value, fill, width) {
  var sign = value < 0 ? "-" : "",
      string = (sign ? -value : value) + "",
      length = string.length;
  return sign + (length < width ? new Array(width - length + 1).join(fill) + string : string);
}

function requote(s) {
  return s.replace(requoteRe, "\\$&");
}

function formatRe(names) {
  return new RegExp("^(?:" + names.map(requote).join("|") + ")", "i");
}

function formatLookup(names) {
  var map = {}, i = -1, n = names.length;
  while (++i < n) map[names[i].toLowerCase()] = i;
  return map;
}

function parseWeekdayNumber(d, string, i) {
  var n = numberRe.exec(string.slice(i, i + 1));
  return n ? (d.w = +n[0], i + n[0].length) : -1;
}

function parseWeekNumberSunday(d, string, i) {
  var n = numberRe.exec(string.slice(i));
  return n ? (d.U = +n[0], i + n[0].length) : -1;
}

function parseWeekNumberMonday(d, string, i) {
  var n = numberRe.exec(string.slice(i));
  return n ? (d.W = +n[0], i + n[0].length) : -1;
}

function parseFullYear(d, string, i) {
  var n = numberRe.exec(string.slice(i, i + 4));
  return n ? (d.y = +n[0], i + n[0].length) : -1;
}

function parseYear(d, string, i) {
  var n = numberRe.exec(string.slice(i, i + 2));
  return n ? (d.y = +n[0] + (+n[0] > 68 ? 1900 : 2000), i + n[0].length) : -1;
}

function parseZone(d, string, i) {
  var n = /^(Z)|([+-]\d\d)(?:\:?(\d\d))?/.exec(string.slice(i, i + 6));
  return n ? (d.Z = n[1] ? 0 : -(n[2] + (n[3] || "00")), i + n[0].length) : -1;
}

function parseMonthNumber(d, string, i) {
  var n = numberRe.exec(string.slice(i, i + 2));
  return n ? (d.m = n[0] - 1, i + n[0].length) : -1;
}

function parseDayOfMonth(d, string, i) {
  var n = numberRe.exec(string.slice(i, i + 2));
  return n ? (d.d = +n[0], i + n[0].length) : -1;
}

function parseDayOfYear(d, string, i) {
  var n = numberRe.exec(string.slice(i, i + 3));
  return n ? (d.m = 0, d.d = +n[0], i + n[0].length) : -1;
}

function parseHour24(d, string, i) {
  var n = numberRe.exec(string.slice(i, i + 2));
  return n ? (d.H = +n[0], i + n[0].length) : -1;
}

function parseMinutes(d, string, i) {
  var n = numberRe.exec(string.slice(i, i + 2));
  return n ? (d.M = +n[0], i + n[0].length) : -1;
}

function parseSeconds(d, string, i) {
  var n = numberRe.exec(string.slice(i, i + 2));
  return n ? (d.S = +n[0], i + n[0].length) : -1;
}

function parseMilliseconds(d, string, i) {
  var n = numberRe.exec(string.slice(i, i + 3));
  return n ? (d.L = +n[0], i + n[0].length) : -1;
}

function parseLiteralPercent(d, string, i) {
  var n = percentRe.exec(string.slice(i, i + 1));
  return n ? i + n[0].length : -1;
}

function formatDayOfMonth(d, p) {
  return pad(d.getDate(), p, 2);
}

function formatHour24(d, p) {
  return pad(d.getHours(), p, 2);
}

function formatHour12(d, p) {
  return pad(d.getHours() % 12 || 12, p, 2);
}

function formatDayOfYear(d, p) {
  return pad(1 + __WEBPACK_IMPORTED_MODULE_0_d3_time__["timeDay"].count(Object(__WEBPACK_IMPORTED_MODULE_0_d3_time__["timeYear"])(d), d), p, 3);
}

function formatMilliseconds(d, p) {
  return pad(d.getMilliseconds(), p, 3);
}

function formatMonthNumber(d, p) {
  return pad(d.getMonth() + 1, p, 2);
}

function formatMinutes(d, p) {
  return pad(d.getMinutes(), p, 2);
}

function formatSeconds(d, p) {
  return pad(d.getSeconds(), p, 2);
}

function formatWeekNumberSunday(d, p) {
  return pad(__WEBPACK_IMPORTED_MODULE_0_d3_time__["timeSunday"].count(Object(__WEBPACK_IMPORTED_MODULE_0_d3_time__["timeYear"])(d), d), p, 2);
}

function formatWeekdayNumber(d) {
  return d.getDay();
}

function formatWeekNumberMonday(d, p) {
  return pad(__WEBPACK_IMPORTED_MODULE_0_d3_time__["timeMonday"].count(Object(__WEBPACK_IMPORTED_MODULE_0_d3_time__["timeYear"])(d), d), p, 2);
}

function formatYear(d, p) {
  return pad(d.getFullYear() % 100, p, 2);
}

function formatFullYear(d, p) {
  return pad(d.getFullYear() % 10000, p, 4);
}

function formatZone(d) {
  var z = d.getTimezoneOffset();
  return (z > 0 ? "-" : (z *= -1, "+"))
      + pad(z / 60 | 0, "0", 2)
      + pad(z % 60, "0", 2);
}

function formatUTCDayOfMonth(d, p) {
  return pad(d.getUTCDate(), p, 2);
}

function formatUTCHour24(d, p) {
  return pad(d.getUTCHours(), p, 2);
}

function formatUTCHour12(d, p) {
  return pad(d.getUTCHours() % 12 || 12, p, 2);
}

function formatUTCDayOfYear(d, p) {
  return pad(1 + __WEBPACK_IMPORTED_MODULE_0_d3_time__["utcDay"].count(Object(__WEBPACK_IMPORTED_MODULE_0_d3_time__["utcYear"])(d), d), p, 3);
}

function formatUTCMilliseconds(d, p) {
  return pad(d.getUTCMilliseconds(), p, 3);
}

function formatUTCMonthNumber(d, p) {
  return pad(d.getUTCMonth() + 1, p, 2);
}

function formatUTCMinutes(d, p) {
  return pad(d.getUTCMinutes(), p, 2);
}

function formatUTCSeconds(d, p) {
  return pad(d.getUTCSeconds(), p, 2);
}

function formatUTCWeekNumberSunday(d, p) {
  return pad(__WEBPACK_IMPORTED_MODULE_0_d3_time__["utcSunday"].count(Object(__WEBPACK_IMPORTED_MODULE_0_d3_time__["utcYear"])(d), d), p, 2);
}

function formatUTCWeekdayNumber(d) {
  return d.getUTCDay();
}

function formatUTCWeekNumberMonday(d, p) {
  return pad(__WEBPACK_IMPORTED_MODULE_0_d3_time__["utcMonday"].count(Object(__WEBPACK_IMPORTED_MODULE_0_d3_time__["utcYear"])(d), d), p, 2);
}

function formatUTCYear(d, p) {
  return pad(d.getUTCFullYear() % 100, p, 2);
}

function formatUTCFullYear(d, p) {
  return pad(d.getUTCFullYear() % 10000, p, 4);
}

function formatUTCZone() {
  return "+0000";
}

function formatLiteralPercent() {
  return "%";
}


/***/ }),
/* 96 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "b", function() { return isoSpecifier; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__defaultLocale__ = __webpack_require__(51);


var isoSpecifier = "%Y-%m-%dT%H:%M:%S.%LZ";

function formatIsoNative(date) {
  return date.toISOString();
}

var formatIso = Date.prototype.toISOString
    ? formatIsoNative
    : Object(__WEBPACK_IMPORTED_MODULE_0__defaultLocale__["d" /* utcFormat */])(isoSpecifier);

/* harmony default export */ __webpack_exports__["a"] = (formatIso);


/***/ }),
/* 97 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var matcher = function(selector) {
  return function() {
    return this.matches(selector);
  };
};

if (typeof document !== "undefined") {
  var element = document.documentElement;
  if (!element.matches) {
    var vendorMatches = element.webkitMatchesSelector
        || element.msMatchesSelector
        || element.mozMatchesSelector
        || element.oMatchesSelector;
    matcher = function(selector) {
      return function() {
        return vendorMatches.call(this, selector);
      };
    };
  }
}

/* harmony default export */ __webpack_exports__["a"] = (matcher);


/***/ }),
/* 98 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
function empty() {
  return [];
}

/* harmony default export */ __webpack_exports__["a"] = (function(selector) {
  return selector == null ? empty : function() {
    return this.querySelectorAll(selector);
  };
});


/***/ }),
/* 99 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (immutable) */ __webpack_exports__["a"] = EnterNode;
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__sparse__ = __webpack_require__(100);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__index__ = __webpack_require__(10);



/* harmony default export */ __webpack_exports__["b"] = (function() {
  return new __WEBPACK_IMPORTED_MODULE_1__index__["a" /* Selection */](this._enter || this._groups.map(__WEBPACK_IMPORTED_MODULE_0__sparse__["a" /* default */]), this._parents);
});

function EnterNode(parent, datum) {
  this.ownerDocument = parent.ownerDocument;
  this.namespaceURI = parent.namespaceURI;
  this._next = null;
  this._parent = parent;
  this.__data__ = datum;
}

EnterNode.prototype = {
  constructor: EnterNode,
  appendChild: function(child) { return this._parent.insertBefore(child, this._next); },
  insertBefore: function(child, next) { return this._parent.insertBefore(child, next); },
  querySelector: function(selector) { return this._parent.querySelector(selector); },
  querySelectorAll: function(selector) { return this._parent.querySelectorAll(selector); }
};


/***/ }),
/* 100 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony default export */ __webpack_exports__["a"] = (function(update) {
  return new Array(update.length);
});


/***/ }),
/* 101 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (immutable) */ __webpack_exports__["b"] = styleValue;
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__window__ = __webpack_require__(59);


function styleRemove(name) {
  return function() {
    this.style.removeProperty(name);
  };
}

function styleConstant(name, value, priority) {
  return function() {
    this.style.setProperty(name, value, priority);
  };
}

function styleFunction(name, value, priority) {
  return function() {
    var v = value.apply(this, arguments);
    if (v == null) this.style.removeProperty(name);
    else this.style.setProperty(name, v, priority);
  };
}

/* harmony default export */ __webpack_exports__["a"] = (function(name, value, priority) {
  return arguments.length > 1
      ? this.each((value == null
            ? styleRemove : typeof value === "function"
            ? styleFunction
            : styleConstant)(name, value, priority == null ? "" : priority))
      : styleValue(this.node(), name);
});

function styleValue(node, name) {
  return node.style.getPropertyValue(name)
      || Object(__WEBPACK_IMPORTED_MODULE_0__window__["a" /* default */])(node).getComputedStyle(node, null).getPropertyValue(name);
}


/***/ }),
/* 102 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__transition_schedule__ = __webpack_require__(11);


/* harmony default export */ __webpack_exports__["a"] = (function(node, name) {
  var schedules = node.__transition,
      schedule,
      active,
      empty = true,
      i;

  if (!schedules) return;

  name = name == null ? null : name + "";

  for (i in schedules) {
    if ((schedule = schedules[i]).name !== name) { empty = false; continue; }
    active = schedule.state > __WEBPACK_IMPORTED_MODULE_0__transition_schedule__["d" /* STARTING */] && schedule.state < __WEBPACK_IMPORTED_MODULE_0__transition_schedule__["b" /* ENDING */];
    schedule.state = __WEBPACK_IMPORTED_MODULE_0__transition_schedule__["a" /* ENDED */];
    schedule.timer.stop();
    if (active) schedule.on.call("interrupt", node, node.__data__, schedule.index, schedule.group);
    delete schedules[i];
  }

  if (empty) delete node.__transition;
});


/***/ }),
/* 103 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__src_timer__ = __webpack_require__(60);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return __WEBPACK_IMPORTED_MODULE_0__src_timer__["b"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "c", function() { return __WEBPACK_IMPORTED_MODULE_0__src_timer__["c"]; });
/* unused harmony reexport timerFlush */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__src_timeout__ = __webpack_require__(241);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "b", function() { return __WEBPACK_IMPORTED_MODULE_1__src_timeout__["a"]; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__src_interval__ = __webpack_require__(242);
/* unused harmony reexport interval */







/***/ }),
/* 104 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_d3_color__ = __webpack_require__(12);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_d3_interpolate__ = __webpack_require__(9);



/* harmony default export */ __webpack_exports__["a"] = (function(a, b) {
  var c;
  return (typeof b === "number" ? __WEBPACK_IMPORTED_MODULE_1_d3_interpolate__["interpolateNumber"]
      : b instanceof __WEBPACK_IMPORTED_MODULE_0_d3_color__["color"] ? __WEBPACK_IMPORTED_MODULE_1_d3_interpolate__["interpolateRgb"]
      : (c = Object(__WEBPACK_IMPORTED_MODULE_0_d3_color__["color"])(b)) ? (b = c, __WEBPACK_IMPORTED_MODULE_1_d3_interpolate__["interpolateRgb"])
      : __WEBPACK_IMPORTED_MODULE_1_d3_interpolate__["interpolateString"])(a, b);
});


/***/ }),
/* 105 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_d3_path__ = __webpack_require__(30);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__constant__ = __webpack_require__(22);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__curve_linear__ = __webpack_require__(39);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__line__ = __webpack_require__(61);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__point__ = __webpack_require__(62);






/* harmony default export */ __webpack_exports__["a"] = (function() {
  var x0 = __WEBPACK_IMPORTED_MODULE_4__point__["a" /* x */],
      x1 = null,
      y0 = Object(__WEBPACK_IMPORTED_MODULE_1__constant__["a" /* default */])(0),
      y1 = __WEBPACK_IMPORTED_MODULE_4__point__["b" /* y */],
      defined = Object(__WEBPACK_IMPORTED_MODULE_1__constant__["a" /* default */])(true),
      context = null,
      curve = __WEBPACK_IMPORTED_MODULE_2__curve_linear__["a" /* default */],
      output = null;

  function area(data) {
    var i,
        j,
        k,
        n = data.length,
        d,
        defined0 = false,
        buffer,
        x0z = new Array(n),
        y0z = new Array(n);

    if (context == null) output = curve(buffer = Object(__WEBPACK_IMPORTED_MODULE_0_d3_path__["a" /* path */])());

    for (i = 0; i <= n; ++i) {
      if (!(i < n && defined(d = data[i], i, data)) === defined0) {
        if (defined0 = !defined0) {
          j = i;
          output.areaStart();
          output.lineStart();
        } else {
          output.lineEnd();
          output.lineStart();
          for (k = i - 1; k >= j; --k) {
            output.point(x0z[k], y0z[k]);
          }
          output.lineEnd();
          output.areaEnd();
        }
      }
      if (defined0) {
        x0z[i] = +x0(d, i, data), y0z[i] = +y0(d, i, data);
        output.point(x1 ? +x1(d, i, data) : x0z[i], y1 ? +y1(d, i, data) : y0z[i]);
      }
    }

    if (buffer) return output = null, buffer + "" || null;
  }

  function arealine() {
    return Object(__WEBPACK_IMPORTED_MODULE_3__line__["a" /* default */])().defined(defined).curve(curve).context(context);
  }

  area.x = function(_) {
    return arguments.length ? (x0 = typeof _ === "function" ? _ : Object(__WEBPACK_IMPORTED_MODULE_1__constant__["a" /* default */])(+_), x1 = null, area) : x0;
  };

  area.x0 = function(_) {
    return arguments.length ? (x0 = typeof _ === "function" ? _ : Object(__WEBPACK_IMPORTED_MODULE_1__constant__["a" /* default */])(+_), area) : x0;
  };

  area.x1 = function(_) {
    return arguments.length ? (x1 = _ == null ? null : typeof _ === "function" ? _ : Object(__WEBPACK_IMPORTED_MODULE_1__constant__["a" /* default */])(+_), area) : x1;
  };

  area.y = function(_) {
    return arguments.length ? (y0 = typeof _ === "function" ? _ : Object(__WEBPACK_IMPORTED_MODULE_1__constant__["a" /* default */])(+_), y1 = null, area) : y0;
  };

  area.y0 = function(_) {
    return arguments.length ? (y0 = typeof _ === "function" ? _ : Object(__WEBPACK_IMPORTED_MODULE_1__constant__["a" /* default */])(+_), area) : y0;
  };

  area.y1 = function(_) {
    return arguments.length ? (y1 = _ == null ? null : typeof _ === "function" ? _ : Object(__WEBPACK_IMPORTED_MODULE_1__constant__["a" /* default */])(+_), area) : y1;
  };

  area.lineX0 =
  area.lineY0 = function() {
    return arealine().x(x0).y(y0);
  };

  area.lineY1 = function() {
    return arealine().x(x0).y(y1);
  };

  area.lineX1 = function() {
    return arealine().x(x1).y(y0);
  };

  area.defined = function(_) {
    return arguments.length ? (defined = typeof _ === "function" ? _ : Object(__WEBPACK_IMPORTED_MODULE_1__constant__["a" /* default */])(!!_), area) : defined;
  };

  area.curve = function(_) {
    return arguments.length ? (curve = _, context != null && (output = curve(context)), area) : curve;
  };

  area.context = function(_) {
    return arguments.length ? (_ == null ? context = output = null : output = curve(context = _), area) : context;
  };

  return area;
});


/***/ }),
/* 106 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return curveRadialLinear; });
/* harmony export (immutable) */ __webpack_exports__["b"] = curveRadial;
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__linear__ = __webpack_require__(39);


var curveRadialLinear = curveRadial(__WEBPACK_IMPORTED_MODULE_0__linear__["a" /* default */]);

function Radial(curve) {
  this._curve = curve;
}

Radial.prototype = {
  areaStart: function() {
    this._curve.areaStart();
  },
  areaEnd: function() {
    this._curve.areaEnd();
  },
  lineStart: function() {
    this._curve.lineStart();
  },
  lineEnd: function() {
    this._curve.lineEnd();
  },
  point: function(a, r) {
    this._curve.point(r * Math.sin(a), r * -Math.cos(a));
  }
};

function curveRadial(curve) {

  function radial(context) {
    return new Radial(curve(context));
  }

  radial._curve = curve;

  return radial;
}


/***/ }),
/* 107 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (immutable) */ __webpack_exports__["b"] = lineRadial;
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__curve_radial__ = __webpack_require__(106);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__line__ = __webpack_require__(61);



function lineRadial(l) {
  var c = l.curve;

  l.angle = l.x, delete l.x;
  l.radius = l.y, delete l.y;

  l.curve = function(_) {
    return arguments.length ? c(Object(__WEBPACK_IMPORTED_MODULE_0__curve_radial__["b" /* default */])(_)) : c()._curve;
  };

  return l;
}

/* harmony default export */ __webpack_exports__["a"] = (function() {
  return lineRadial(Object(__WEBPACK_IMPORTED_MODULE_1__line__["a" /* default */])().curve(__WEBPACK_IMPORTED_MODULE_0__curve_radial__["a" /* curveRadialLinear */]));
});


/***/ }),
/* 108 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony default export */ __webpack_exports__["a"] = (function(x, y) {
  return [(y = +y) * Math.cos(x -= Math.PI / 2), y * Math.sin(x)];
});


/***/ }),
/* 109 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return slice; });
var slice = Array.prototype.slice;


/***/ }),
/* 110 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__math__ = __webpack_require__(31);


/* harmony default export */ __webpack_exports__["a"] = ({
  draw: function(context, size) {
    var r = Math.sqrt(size / __WEBPACK_IMPORTED_MODULE_0__math__["j" /* pi */]);
    context.moveTo(r, 0);
    context.arc(0, 0, r, 0, __WEBPACK_IMPORTED_MODULE_0__math__["m" /* tau */]);
  }
});


/***/ }),
/* 111 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony default export */ __webpack_exports__["a"] = ({
  draw: function(context, size) {
    var r = Math.sqrt(size / 5) / 2;
    context.moveTo(-3 * r, -r);
    context.lineTo(-r, -r);
    context.lineTo(-r, -3 * r);
    context.lineTo(r, -3 * r);
    context.lineTo(r, -r);
    context.lineTo(3 * r, -r);
    context.lineTo(3 * r, r);
    context.lineTo(r, r);
    context.lineTo(r, 3 * r);
    context.lineTo(-r, 3 * r);
    context.lineTo(-r, r);
    context.lineTo(-3 * r, r);
    context.closePath();
  }
});


/***/ }),
/* 112 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var tan30 = Math.sqrt(1 / 3),
    tan30_2 = tan30 * 2;

/* harmony default export */ __webpack_exports__["a"] = ({
  draw: function(context, size) {
    var y = Math.sqrt(size / tan30_2),
        x = y * tan30;
    context.moveTo(0, -y);
    context.lineTo(x, 0);
    context.lineTo(0, y);
    context.lineTo(-x, 0);
    context.closePath();
  }
});


/***/ }),
/* 113 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__math__ = __webpack_require__(31);


var ka = 0.89081309152928522810,
    kr = Math.sin(__WEBPACK_IMPORTED_MODULE_0__math__["j" /* pi */] / 10) / Math.sin(7 * __WEBPACK_IMPORTED_MODULE_0__math__["j" /* pi */] / 10),
    kx = Math.sin(__WEBPACK_IMPORTED_MODULE_0__math__["m" /* tau */] / 10) * kr,
    ky = -Math.cos(__WEBPACK_IMPORTED_MODULE_0__math__["m" /* tau */] / 10) * kr;

/* harmony default export */ __webpack_exports__["a"] = ({
  draw: function(context, size) {
    var r = Math.sqrt(size * ka),
        x = kx * r,
        y = ky * r;
    context.moveTo(0, -r);
    context.lineTo(x, y);
    for (var i = 1; i < 5; ++i) {
      var a = __WEBPACK_IMPORTED_MODULE_0__math__["m" /* tau */] * i / 5,
          c = Math.cos(a),
          s = Math.sin(a);
      context.lineTo(s * r, -c * r);
      context.lineTo(c * x - s * y, s * x + c * y);
    }
    context.closePath();
  }
});


/***/ }),
/* 114 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony default export */ __webpack_exports__["a"] = ({
  draw: function(context, size) {
    var w = Math.sqrt(size),
        x = -w / 2;
    context.rect(x, x, w, w);
  }
});


/***/ }),
/* 115 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var sqrt3 = Math.sqrt(3);

/* harmony default export */ __webpack_exports__["a"] = ({
  draw: function(context, size) {
    var y = -Math.sqrt(size / (sqrt3 * 3));
    context.moveTo(0, y * 2);
    context.lineTo(-sqrt3 * y, -y);
    context.lineTo(sqrt3 * y, -y);
    context.closePath();
  }
});


/***/ }),
/* 116 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var c = -0.5,
    s = Math.sqrt(3) / 2,
    k = 1 / Math.sqrt(12),
    a = (k / 2 + 1) * 3;

/* harmony default export */ __webpack_exports__["a"] = ({
  draw: function(context, size) {
    var r = Math.sqrt(size / a),
        x0 = r / 2,
        y0 = r * k,
        x1 = x0,
        y1 = r * k + r,
        x2 = -x1,
        y2 = y1;
    context.moveTo(x0, y0);
    context.lineTo(x1, y1);
    context.lineTo(x2, y2);
    context.lineTo(c * x0 - s * y0, s * x0 + c * y0);
    context.lineTo(c * x1 - s * y1, s * x1 + c * y1);
    context.lineTo(c * x2 - s * y2, s * x2 + c * y2);
    context.lineTo(c * x0 + s * y0, c * y0 - s * x0);
    context.lineTo(c * x1 + s * y1, c * y1 - s * x1);
    context.lineTo(c * x2 + s * y2, c * y2 - s * x2);
    context.closePath();
  }
});


/***/ }),
/* 117 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (immutable) */ __webpack_exports__["a"] = CardinalClosed;
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__noop__ = __webpack_require__(40);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__cardinal__ = __webpack_require__(42);



function CardinalClosed(context, tension) {
  this._context = context;
  this._k = (1 - tension) / 6;
}

CardinalClosed.prototype = {
  areaStart: __WEBPACK_IMPORTED_MODULE_0__noop__["a" /* default */],
  areaEnd: __WEBPACK_IMPORTED_MODULE_0__noop__["a" /* default */],
  lineStart: function() {
    this._x0 = this._x1 = this._x2 = this._x3 = this._x4 = this._x5 =
    this._y0 = this._y1 = this._y2 = this._y3 = this._y4 = this._y5 = NaN;
    this._point = 0;
  },
  lineEnd: function() {
    switch (this._point) {
      case 1: {
        this._context.moveTo(this._x3, this._y3);
        this._context.closePath();
        break;
      }
      case 2: {
        this._context.lineTo(this._x3, this._y3);
        this._context.closePath();
        break;
      }
      case 3: {
        this.point(this._x3, this._y3);
        this.point(this._x4, this._y4);
        this.point(this._x5, this._y5);
        break;
      }
    }
  },
  point: function(x, y) {
    x = +x, y = +y;
    switch (this._point) {
      case 0: this._point = 1; this._x3 = x, this._y3 = y; break;
      case 1: this._point = 2; this._context.moveTo(this._x4 = x, this._y4 = y); break;
      case 2: this._point = 3; this._x5 = x, this._y5 = y; break;
      default: Object(__WEBPACK_IMPORTED_MODULE_1__cardinal__["c" /* point */])(this, x, y); break;
    }
    this._x0 = this._x1, this._x1 = this._x2, this._x2 = x;
    this._y0 = this._y1, this._y1 = this._y2, this._y2 = y;
  }
};

/* harmony default export */ __webpack_exports__["b"] = ((function custom(tension) {

  function cardinal(context) {
    return new CardinalClosed(context, tension);
  }

  cardinal.tension = function(tension) {
    return custom(+tension);
  };

  return cardinal;
})(0));


/***/ }),
/* 118 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (immutable) */ __webpack_exports__["a"] = CardinalOpen;
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__cardinal__ = __webpack_require__(42);


function CardinalOpen(context, tension) {
  this._context = context;
  this._k = (1 - tension) / 6;
}

CardinalOpen.prototype = {
  areaStart: function() {
    this._line = 0;
  },
  areaEnd: function() {
    this._line = NaN;
  },
  lineStart: function() {
    this._x0 = this._x1 = this._x2 =
    this._y0 = this._y1 = this._y2 = NaN;
    this._point = 0;
  },
  lineEnd: function() {
    if (this._line || (this._line !== 0 && this._point === 3)) this._context.closePath();
    this._line = 1 - this._line;
  },
  point: function(x, y) {
    x = +x, y = +y;
    switch (this._point) {
      case 0: this._point = 1; break;
      case 1: this._point = 2; break;
      case 2: this._point = 3; this._line ? this._context.lineTo(this._x2, this._y2) : this._context.moveTo(this._x2, this._y2); break;
      case 3: this._point = 4; // proceed
      default: Object(__WEBPACK_IMPORTED_MODULE_0__cardinal__["c" /* point */])(this, x, y); break;
    }
    this._x0 = this._x1, this._x1 = this._x2, this._x2 = x;
    this._y0 = this._y1, this._y1 = this._y2, this._y2 = y;
  }
};

/* harmony default export */ __webpack_exports__["b"] = ((function custom(tension) {

  function cardinal(context) {
    return new CardinalOpen(context, tension);
  }

  cardinal.tension = function(tension) {
    return custom(+tension);
  };

  return cardinal;
})(0));


/***/ }),
/* 119 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
var __WEBPACK_AMD_DEFINE_RESULT__;

!(__WEBPACK_AMD_DEFINE_RESULT__ = function (require) {
    'use strict';

    var d3Format = __webpack_require__(7);
    var idCounter = 0;

    /**
     * Calculates a new date by summing a given amount of days to a given date
     * @param  {String}  startDate      Date
     * @param  {Number}  days           Number of days to add
     * @return {String}                 Offsetted date
     */
    var addDays = function addDays(startDate, days) {
        var result = new Date(startDate);

        result.setDate(result.getDate() + days);

        return String(result);
    };

    /**
     * Calculates difference between dates in days
     * @param  {String}  startDate  Date in string form
     * @param  {String}  endDate    Date in string form
     * @return {Number}             Number of days between dates
     */
    var diffDays = function diffDays(startDate, endDate) {
        var oneDayInMilliseconds = 24 * 60 * 60 * 1000;

        return Math.ceil(Math.abs((new Date(startDate).getTime() - new Date(endDate).getTime()) / oneDayInMilliseconds));
    };

    /**
     * Takes a number representing milliseconds and convert to days
     * @param  {Number} milliseconds    Any number of days in milliseconds
     * @return {Number}                 Number of days that the input represents
     */
    var convertMillisecondsToDays = function convertMillisecondsToDays(milliseconds) {
        return Math.ceil(milliseconds / (24 * 60 * 60 * 1000));
    };

    /**
     * Takes a locale (string) and the format to return and returns a function to format dates
     * @param  {String} locale              Locale tag eg. en-US, fr-FR, ru-RU
     * @param  {String} [timeUnit='day']    Minute, hour, day, dayMonth, month, year
     * @return {Function}                   Function that formats dates in the proper locale
     */
    var getLocaleDateFormatter = function getLocaleDateFormatter(locale) {
        var timeUnit = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 'day';

        var options = localeTimeMap[timeUnit];
        var formatter = new Intl.DateTimeFormat(locale, options);

        return function (date) {
            return formatter.format(date);
        };
    };

    return {
        addDays: addDays,
        convertMillisecondsToDays: convertMillisecondsToDays,
        diffDays: diffDays,
        getLocaleDateFormatter: getLocaleDateFormatter
    };
}.call(exports, __webpack_require__, exports, module),
				__WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));

/***/ }),
/* 120 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
var __WEBPACK_AMD_DEFINE_RESULT__;

!(__WEBPACK_AMD_DEFINE_RESULT__ = function (require) {

  var d3Selection = __webpack_require__(0);
  var filterId = 'highlight-filter';

  var createFilterContainer = function createFilterContainer(metadataSelection) {
    var highlightFilter = metadataSelection.append('defs').append('filter').attr('id', filterId);

    return highlightFilter;
  };

  var createGausianBlur = function createGausianBlur(filterSelector) {
    filterSelector.append('feGaussianBlur').attr('stdDeviation', 1).attr('result', 'coloredBlur');

    return filterId;
  };

  var createGlow = function createGlow(filterSelector) {
    filterSelector.attr('x', '-30%').attr('y', '-30%').attr('width', '160%').attr('height', '160%');

    filterSelector.append('feGaussianBlur').attr('stdDeviation', '0.9 0.9').attr('result', 'glow');

    var merge = filterSelector.append('feMerge');

    merge.append('feMergeNode').attr('in', 'glow');

    merge.append('feMergeNode').attr('in', 'glow');

    merge.append('feMergeNode').attr('in', 'glow');

    return filterId;
  };

  var createGlowWithMatrix = function createGlowWithMatrix(filterSelector) {
    var colorMatrix = '0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 1 0';

    filterSelector.attr('x', '-500%').attr('y', '-500%').attr('width', '1800%').attr('height', '1800%');

    filterSelector.append('feColorMatrix').attr('type', 'matrix').attr('values', colorMatrix);

    filterSelector.append('feGaussianBlur').attr('stdDeviation', '1').attr('result', 'coloredBlur').attr('in', 'SourceGraphic');

    var merge = filterSelector.append('feMerge');

    merge.append('feMergeNode').attr('in', 'coloredBlur');

    merge.append('feMergeNode').attr('in', 'SourceGraphic');

    return filterId;
  };

  var createWhiteGlow = function createWhiteGlow(filterSelector) {
    filterSelector.attr('x', '-5000%').attr('y', '-5000%').attr('width', '10000%').attr('height', '10000%');

    filterSelector.append('feFlood').attr('result', 'flood').attr('flood-color', '#ffffff').attr('flood-opacity', '1');

    filterSelector.append('feComposite').attr('result', 'mask').attr('in2', 'SourceGraphic').attr('operator', 'in').attr('in', 'flood');

    filterSelector.append('feMorphology').attr('result', 'dilated').attr('operator', 'dilate').attr('radius', '2').attr('in', 'mask');

    filterSelector.append('feGaussianBlur').attr('result', 'blurred').attr('stdDeviation', '5').attr('in', 'dilated');

    var merge = filterSelector.append('feMerge');

    merge.append('feMergeNode').attr('in', 'blurred');

    merge.append('feMergeNode').attr('in', 'SourceGraphic');

    return filterId;
  };

  var bounceCircleHighlight = function bounceCircleHighlight(el, ease, radius) {
    var bounceRadius = arguments.length > 3 && arguments[3] !== undefined ? arguments[3] : radius * 2;

    var duration = 100;
    var delay = 50;

    el.transition().ease(ease).duration(duration).attr('r', bounceRadius).transition().ease(ease).delay(delay).duration(duration).attr('r', radius);
  };

  return {
    bounceCircleHighlight: bounceCircleHighlight,
    createFilterContainer: createFilterContainer,
    createGausianBlur: createGausianBlur,
    createWhiteGlow: createWhiteGlow,
    createGlow: createGlow,
    createGlowWithMatrix: createGlowWithMatrix
  };
}.call(exports, __webpack_require__, exports, module),
				__WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));

/***/ }),
/* 121 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (immutable) */ __webpack_exports__["b"] = yesdrag;
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_d3_selection__ = __webpack_require__(0);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__noevent__ = __webpack_require__(122);



/* harmony default export */ __webpack_exports__["a"] = (function(view) {
  var root = view.document.documentElement,
      selection = Object(__WEBPACK_IMPORTED_MODULE_0_d3_selection__["select"])(view).on("dragstart.drag", __WEBPACK_IMPORTED_MODULE_1__noevent__["a" /* default */], true);
  if ("onselectstart" in root) {
    selection.on("selectstart.drag", __WEBPACK_IMPORTED_MODULE_1__noevent__["a" /* default */], true);
  } else {
    root.__noselect = root.style.MozUserSelect;
    root.style.MozUserSelect = "none";
  }
});

function yesdrag(view, noclick) {
  var root = view.document.documentElement,
      selection = Object(__WEBPACK_IMPORTED_MODULE_0_d3_selection__["select"])(view).on("dragstart.drag", null);
  if (noclick) {
    selection.on("click.drag", __WEBPACK_IMPORTED_MODULE_1__noevent__["a" /* default */], true);
    setTimeout(function() { selection.on("click.drag", null); }, 0);
  }
  if ("onselectstart" in root) {
    selection.on("selectstart.drag", null);
  } else {
    root.style.MozUserSelect = root.__noselect;
    delete root.__noselect;
  }
}


/***/ }),
/* 122 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (immutable) */ __webpack_exports__["b"] = nopropagation;
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_d3_selection__ = __webpack_require__(0);


function nopropagation() {
  __WEBPACK_IMPORTED_MODULE_0_d3_selection__["event"].stopImmediatePropagation();
}

/* harmony default export */ __webpack_exports__["a"] = (function() {
  __WEBPACK_IMPORTED_MODULE_0_d3_selection__["event"].preventDefault();
  __WEBPACK_IMPORTED_MODULE_0_d3_selection__["event"].stopImmediatePropagation();
});


/***/ }),
/* 123 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
        value: true
});
exports.colors = exports.brush = exports.step = exports.heatmap = exports.stackedBar = exports.groupedBar = exports.stackedArea = exports.sparkline = exports.miniTooltip = exports.tooltip = exports.loadingStates = exports.line = exports.legend = exports.donut = exports.bar = undefined;

var _bar = __webpack_require__(124);

var _bar2 = _interopRequireDefault(_bar);

var _donut = __webpack_require__(290);

var _donut2 = _interopRequireDefault(_donut);

var _legend = __webpack_require__(291);

var _legend2 = _interopRequireDefault(_legend);

var _line = __webpack_require__(292);

var _line2 = _interopRequireDefault(_line);

var _load = __webpack_require__(13);

var _load2 = _interopRequireDefault(_load);

var _tooltip = __webpack_require__(293);

var _tooltip2 = _interopRequireDefault(_tooltip);

var _miniTooltip = __webpack_require__(294);

var _miniTooltip2 = _interopRequireDefault(_miniTooltip);

var _sparkline = __webpack_require__(295);

var _sparkline2 = _interopRequireDefault(_sparkline);

var _stackedArea = __webpack_require__(296);

var _stackedArea2 = _interopRequireDefault(_stackedArea);

var _groupedBar = __webpack_require__(297);

var _groupedBar2 = _interopRequireDefault(_groupedBar);

var _stackedBar = __webpack_require__(298);

var _stackedBar2 = _interopRequireDefault(_stackedBar);

var _heatmap = __webpack_require__(299);

var _heatmap2 = _interopRequireDefault(_heatmap);

var _step = __webpack_require__(300);

var _step2 = _interopRequireDefault(_step);

var _brush = __webpack_require__(301);

var _brush2 = _interopRequireDefault(_brush);

var _color = __webpack_require__(5);

var _color2 = _interopRequireDefault(_color);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.bar = _bar2.default;
exports.donut = _donut2.default;
exports.legend = _legend2.default;
exports.line = _line2.default;
exports.loadingStates = _load2.default;
exports.tooltip = _tooltip2.default;
exports.miniTooltip = _miniTooltip2.default;
exports.sparkline = _sparkline2.default;
exports.stackedArea = _stackedArea2.default;
exports.groupedBar = _groupedBar2.default;
exports.stackedBar = _stackedBar2.default;
exports.heatmap = _heatmap2.default;
exports.step = _step2.default;
exports.brush = _brush2.default;
exports.colors = _color2.default;

/***/ }),
/* 124 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
var __WEBPACK_AMD_DEFINE_RESULT__;

var _extends = Object.assign || function (target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i]; for (var key in source) { if (Object.prototype.hasOwnProperty.call(source, key)) { target[key] = source[key]; } } } return target; };

function _toConsumableArray(arr) { if (Array.isArray(arr)) { for (var i = 0, arr2 = Array(arr.length); i < arr.length; i++) { arr2[i] = arr[i]; } return arr2; } else { return Array.from(arr); } }

!(__WEBPACK_AMD_DEFINE_RESULT__ = function (require) {
    'use strict';

    var d3Array = __webpack_require__(1);
    var d3Ease = __webpack_require__(4);
    var d3Axis = __webpack_require__(17);
    var d3Color = __webpack_require__(12);
    var d3Dispatch = __webpack_require__(6);
    var d3Format = __webpack_require__(7);
    var d3Scale = __webpack_require__(8);
    var d3Selection = __webpack_require__(0);
    var d3Transition = __webpack_require__(3);

    var textHelper = __webpack_require__(38);

    var _require = __webpack_require__(15),
        exportChart = _require.exportChart;

    var colorHelper = __webpack_require__(5);

    var _require2 = __webpack_require__(13),
        barChartLoadingMarkup = _require2.bar;

    var _require3 = __webpack_require__(23),
        uniqueId = _require3.uniqueId;

    var PERCENTAGE_FORMAT = '%';
    var NUMBER_FORMAT = ',f';

    /**
     * @typedef BarChartData
     * @type {Object[]}
     * @property {Number} value        Value of the group (required)
     * @property {String} name         Name of the group (required)
     *
     * @example
     * [
     *     {
     *         value: 1,
     *         name: 'glittering'
     *     },
     *     {
     *         value: 1,
     *         name: 'luminous'
     *     }
     * ]
     */

    /**
     * Bar Chart reusable API class that renders a
     * simple and configurable bar chart.
     *
     * @module Bar
     * @tutorial bar
     * @requires d3-array, d3-axis, d3-dispatch, d3-scale, d3-selection
     *
     * @example
     * var barChart = bar();
     *
     * barChart
     *     .height(500)
     *     .width(800);
     *
     * d3Selection.select('.css-selector')
     *     .datum(dataset)
     *     .call(barChart);
     *
     */
    return function module() {

        var margin = {
            top: 20,
            right: 20,
            bottom: 30,
            left: 40
        },
            width = 960,
            height = 500,
            loadingState = barChartLoadingMarkup,
            data = void 0,
            dataZeroed = void 0,
            chartWidth = void 0,
            chartHeight = void 0,
            xScale = void 0,
            yScale = void 0,
            colorSchema = colorHelper.singleColors.aloeGreen,
            colorList = void 0,
            colorMap = void 0,
            chartGradientColors = null,
            chartGradient = null,
            chartGradientEl = void 0,
            chartGradientId = uniqueId('bar-gradient'),
            yTicks = 5,
            xTicks = 5,
            percentageAxisToMaxRatio = 1,
            numberFormat = NUMBER_FORMAT,
            enableLabels = false,
            labelsMargin = 7,
            labelsNumberFormat = NUMBER_FORMAT,
            labelsSize = 12,
            betweenBarsPadding = 0.1,
            xAxis = void 0,
            yAxis = void 0,
            xAxisPadding = {
            top: 0,
            left: 0,
            bottom: 0,
            right: 0
        },
            yAxisPaddingBetweenChart = 10,
            yAxisLineWrapLimit = 1,
            isHorizontal = false,
            svg = void 0,
            hasSingleBarHighlight = true,
            isAnimated = false,
            ease = d3Ease.easeQuadInOut,
            animationDuration = 800,
            animationStepRatio = 70,
            interBarDelay = function interBarDelay(d, i) {
            return animationStepRatio * i;
        },
            highlightBarFunction = function highlightBarFunction(barSelection) {
            return barSelection.attr('fill', function (_ref) {
                var name = _ref.name;
                return d3Color.color(chartGradientColors ? chartGradientColors[1] : colorMap(name)).darker();
            });
        },
            orderingFunction = void 0,
            valueLabel = 'value',
            nameLabel = 'name',
            labelEl = void 0,
            xAxisLabelEl = null,
            xAxisLabel = null,
            xAxisLabelOffset = 30,
            yAxisLabelEl = null,
            yAxisLabel = null,
            yAxisLabelOffset = -30,
            baseLine = void 0,
            maskGridLines = void 0,
            shouldReverseColorList = true,


        // Dispatcher object to broadcast the mouse events
        // Ref: https://github.com/mbostock/d3/wiki/Internals#d3_dispatch
        dispatcher = d3Dispatch.dispatch('customMouseOver', 'customMouseOut', 'customMouseMove', 'customClick'),


        // extractors
        getName = function getName(_ref2) {
            var name = _ref2.name;
            return name;
        },
            getValue = function getValue(_ref3) {
            var value = _ref3.value;
            return value;
        },
            _labelsFormatValue = function _labelsFormatValue(_ref4) {
            var value = _ref4.value;
            return d3Format.format(labelsNumberFormat)(value);
        },
            _labelsHorizontalX = function _labelsHorizontalX(_ref5) {
            var value = _ref5.value;
            return xScale(value) + labelsMargin;
        },
            _labelsHorizontalY = function _labelsHorizontalY(_ref6) {
            var name = _ref6.name;
            return yScale(name) + yScale.bandwidth() / 2 + labelsSize * (3 / 8);
        },
            _labelsVerticalX = function _labelsVerticalX(_ref7) {
            var name = _ref7.name;
            return xScale(name);
        },
            _labelsVerticalY = function _labelsVerticalY(_ref8) {
            var value = _ref8.value;
            return yScale(value) - labelsMargin;
        };

        /**
         * This function creates the graph using the selection as container
         * @param  {D3Selection} _selection A d3 selection that represents
         *                                  the container(s) where the chart(s) will be rendered
         * @param {BarChartData} _data The data to attach and generate the chart
         */
        function exports(_selection) {
            _selection.each(function (_data) {
                chartWidth = width - margin.left - margin.right - yAxisPaddingBetweenChart * 1.2;
                chartHeight = height - margin.top - margin.bottom;

                var _sortData = sortData(cleanData(_data));

                data = _sortData.data;
                dataZeroed = _sortData.dataZeroed;


                buildScales();
                buildAxis();
                buildSVG(this);
                buildGradient();
                drawGridLines();
                drawBars();
                drawAxis();

                if (enableLabels) {
                    drawLabels();
                }
            });
        }

        /**
         * Creates the d3 x and y axis, setting orientations
         * @private
         */
        function buildAxis() {
            if (isHorizontal) {
                xAxis = d3Axis.axisBottom(xScale).ticks(xTicks, numberFormat).tickSizeInner([-chartHeight]);

                yAxis = d3Axis.axisLeft(yScale);
            } else {
                xAxis = d3Axis.axisBottom(xScale);

                yAxis = d3Axis.axisLeft(yScale).ticks(yTicks, numberFormat);
            }
        }

        /**
         * Builds containers for the chart, the axis and a wrapper for all of them
         * Also applies the Margin convention
         * @private
         */
        function buildContainerGroups() {
            var container = svg.append('g').classed('container-group', true).attr('transform', 'translate(' + (margin.left + yAxisPaddingBetweenChart) + ', ' + margin.top + ')');

            container.append('g').classed('grid-lines-group', true);
            container.append('g').classed('chart-group', true);
            container.append('g').classed('x-axis-group axis', true).append('g').classed('x-axis-label', true);
            container.append('g').attr('transform', 'translate(' + -1 * yAxisPaddingBetweenChart + ', 0)').classed('y-axis-group axis', true).append('g').classed('y-axis-label', true);
            container.append('g').classed('metadata-group', true);
        }

        /**
         * Builds the gradient element to be used later
         * @return {void}
         * @private
         */
        function buildGradient() {
            if (!chartGradientEl && chartGradientColors) {
                chartGradientEl = svg.select('.metadata-group').append('linearGradient').attr('id', chartGradientId).attr('x1', '0%').attr('y1', '0%').attr('x2', '100%').attr('y2', '100%').attr('gradientUnits', 'userSpaceOnUse').selectAll('stop').data([{ offset: '0%', color: chartGradientColors[0] }, { offset: '50%', color: chartGradientColors[1] }]).enter().append('stop').attr('offset', function (_ref9) {
                    var offset = _ref9.offset;
                    return offset;
                }).attr('stop-color', function (_ref10) {
                    var color = _ref10.color;
                    return color;
                });
            }
        }

        /**
         * Creates the x and y scales of the graph
         * @private
         */
        function buildScales() {
            var percentageAxis = Math.min(percentageAxisToMaxRatio * d3Array.max(data, getValue));

            if (isHorizontal) {
                xScale = d3Scale.scaleLinear().domain([0, percentageAxis]).rangeRound([0, chartWidth]);

                yScale = d3Scale.scaleBand().domain(data.map(getName)).rangeRound([chartHeight, 0]).padding(betweenBarsPadding);
            } else {
                xScale = d3Scale.scaleBand().domain(data.map(getName)).rangeRound([0, chartWidth]).padding(betweenBarsPadding);

                yScale = d3Scale.scaleLinear().domain([0, percentageAxis]).rangeRound([chartHeight, 0]);
            }

            if (shouldReverseColorList) {
                colorList = data.map(function (d) {
                    return d;
                }).reverse().map(function (_ref11, i) {
                    var name = _ref11.name;
                    return {
                        name: name,
                        color: colorSchema[i % colorSchema.length] };
                });
            } else {
                colorList = data.map(function (d) {
                    return d;
                }).map(function (_ref12, i) {
                    var name = _ref12.name;
                    return {
                        name: name,
                        color: colorSchema[i % colorSchema.length] };
                });
            }

            colorMap = function colorMap(item) {
                return colorList.filter(function (_ref13) {
                    var name = _ref13.name;
                    return name === item;
                })[0].color;
            };
        }

        /**
         * Builds the SVG element that will contain the chart
         * @param  {HTMLElement} container DOM element that will work as the container of the graph
         * @private
         */
        function buildSVG(container) {
            if (!svg) {
                svg = d3Selection.select(container).append('svg').classed('britechart bar-chart', true);

                buildContainerGroups();
            }

            svg.attr('width', width).attr('height', height);
        }

        /**
         * Cleaning data casting the values and names to the proper type while keeping
         * the rest of properties on the data
         * It also creates a set of zeroed data (for animation purposes)
         * @param  {BarChartData} originalData  Raw data as passed to the container
         * @return  {BarChartData}              Clean data
         * @private
         */
        function cleanData(originalData) {
            var data = originalData.reduce(function (acc, d) {
                d.value = +d[valueLabel];
                d.name = String(d[nameLabel]);

                return [].concat(_toConsumableArray(acc), [d]);
            }, []);

            var dataZeroed = data.map(function (d) {
                return {
                    value: 0,
                    name: String(d[nameLabel])
                };
            });

            return { data: data, dataZeroed: dataZeroed };
        }

        /**
         * A utility function that checks if custom gradient
         * color map should be applied if specified by the user
         * @param {String} name - bar's data point name
         * @return {void}
         * @private
         */
        function computeColor(name) {
            return chartGradientColors ? 'url(#' + chartGradientId + ')' : colorMap(name);
        }

        /**
         * Sorts data if orderingFunction is specified
         * @param  {BarChartData}     clean unordered data
         * @return  {BarChartData}    clean ordered data
         * @private
         */
        function sortData(unorderedData) {
            var data = unorderedData.data,
                dataZeroed = unorderedData.dataZeroed;


            if (orderingFunction) {
                data.sort(orderingFunction);
                dataZeroed.sort(orderingFunction);
            }

            return { data: data, dataZeroed: dataZeroed };
        }

        /**
         * Utility function that wraps a text into the given width
         * @param  {D3Selection} text         Text to write
         * @param  {Number} containerWidth
         * @private
         */
        function wrapText(text, containerWidth) {
            textHelper.wrapTextWithEllipses(text, containerWidth, 0, yAxisLineWrapLimit);
        }

        /**
         * Draws the x and y axis on the svg object within their
         * respective groups
         * @private
         */
        function drawAxis() {
            svg.select('.x-axis-group.axis').attr('transform', 'translate(0, ' + chartHeight + ')').call(xAxis);

            svg.select('.y-axis-group.axis').call(yAxis);

            svg.selectAll('.y-axis-group .tick text').call(wrapText, margin.left - yAxisPaddingBetweenChart);

            drawAxisLabels();
        }

        /**
         * Draws the x and y axis custom labels respective groups
         * @private
         */
        function drawAxisLabels() {
            if (yAxisLabel) {
                if (yAxisLabelEl) {
                    yAxisLabelEl.remove();
                }
                yAxisLabelEl = svg.select('.y-axis-label').append('text').classed('y-axis-label-text', true).attr('x', -chartHeight / 2).attr('y', yAxisLabelOffset).attr('text-anchor', 'middle').attr('transform', 'rotate(270 0 0)').text(yAxisLabel);
            }

            if (xAxisLabel) {
                if (xAxisLabelEl) {
                    xAxisLabelEl.remove();
                }
                xAxisLabelEl = svg.select('.x-axis-label').append('text').attr('y', xAxisLabelOffset).attr('text-anchor', 'middle').classed('x-axis-label-text', true).attr('x', chartWidth / 2).text(xAxisLabel);
            }
        }

        /**
         * Draws the bars along the x axis
         * @param  {D3Selection} bars Selection of bars
         * @return {void}
         */
        function drawHorizontalBars(bars) {
            // Enter + Update
            bars.enter().append('rect').classed('bar', true).attr('y', chartHeight).attr('x', 0).attr('height', yScale.bandwidth()).attr('width', function (_ref14) {
                var value = _ref14.value;
                return xScale(value);
            }).on('mouseover', function (d, index, barList) {
                handleMouseOver(this, d, barList, chartWidth, chartHeight);
            }).on('mousemove', function (d) {
                handleMouseMove(this, d, chartWidth, chartHeight);
            }).on('mouseout', function (d, index, barList) {
                handleMouseOut(this, d, barList, chartWidth, chartHeight);
            }).on('click', function (d) {
                handleClick(this, d, chartWidth, chartHeight);
            }).merge(bars).attr('x', 0).attr('y', function (_ref15) {
                var name = _ref15.name;
                return yScale(name);
            }).attr('height', yScale.bandwidth()).attr('width', function (_ref16) {
                var value = _ref16.value;
                return xScale(value);
            }).attr('fill', function (_ref17) {
                var name = _ref17.name;
                return computeColor(name);
            });
        }

        /**
         * Draws and animates the bars along the x axis
         * @param  {D3Selection} bars Selection of bars
         * @return {void}
         */
        function drawAnimatedHorizontalBars(bars) {
            // Enter + Update
            bars.enter().append('rect').classed('bar', true).attr('x', 0).attr('y', chartHeight).attr('height', yScale.bandwidth()).attr('width', function (_ref18) {
                var value = _ref18.value;
                return xScale(value);
            }).on('mouseover', function (d, index, barList) {
                handleMouseOver(this, d, barList, chartWidth, chartHeight);
            }).on('mousemove', function (d) {
                handleMouseMove(this, d, chartWidth, chartHeight);
            }).on('mouseout', function (d, index, barList) {
                handleMouseOut(this, d, barList, chartWidth, chartHeight);
            }).on('click', function (d) {
                handleClick(this, d, chartWidth, chartHeight);
            });

            bars.attr('x', 0).attr('y', function (_ref19) {
                var name = _ref19.name;
                return yScale(name);
            }).attr('height', yScale.bandwidth()).attr('fill', function (_ref20) {
                var name = _ref20.name;
                return computeColor(name);
            }).transition().duration(animationDuration).delay(interBarDelay).ease(ease).attr('width', function (_ref21) {
                var value = _ref21.value;
                return xScale(value);
            });
        }

        /**
         * Draws and animates the bars along the y axis
         * @param  {D3Selection} bars Selection of bars
         * @return {void}
         */
        function drawAnimatedVerticalBars(bars) {
            // Enter + Update
            bars.enter().append('rect').classed('bar', true).attr('x', chartWidth).attr('y', function (_ref22) {
                var value = _ref22.value;
                return yScale(value);
            }).attr('width', xScale.bandwidth()).attr('height', function (_ref23) {
                var value = _ref23.value;
                return chartHeight - yScale(value);
            }).on('mouseover', function (d, index, barList) {
                handleMouseOver(this, d, barList, chartWidth, chartHeight);
            }).on('mousemove', function (d) {
                handleMouseMove(this, d, chartWidth, chartHeight);
            }).on('mouseout', function (d, index, barList) {
                handleMouseOut(this, d, barList, chartWidth, chartHeight);
            }).on('click', function (d) {
                handleClick(this, d, chartWidth, chartHeight);
            }).merge(bars).attr('x', function (_ref24) {
                var name = _ref24.name;
                return xScale(name);
            }).attr('width', xScale.bandwidth()).attr('fill', function (_ref25) {
                var name = _ref25.name;
                return computeColor(name);
            }).transition().duration(animationDuration).delay(interBarDelay).ease(ease).attr('y', function (_ref26) {
                var value = _ref26.value;
                return yScale(value);
            }).attr('height', function (_ref27) {
                var value = _ref27.value;
                return chartHeight - yScale(value);
            });
        }

        /**
         * Draws the bars along the y axis
         * @param  {D3Selection} bars Selection of bars
         * @return {void}
         */
        function drawVerticalBars(bars) {
            // Enter + Update
            bars.enter().append('rect').classed('bar', true).attr('x', chartWidth).attr('y', function (_ref28) {
                var value = _ref28.value;
                return yScale(value);
            }).attr('width', xScale.bandwidth()).attr('height', function (_ref29) {
                var value = _ref29.value;
                return chartHeight - yScale(value);
            }).on('mouseover', function (d, index, barList) {
                handleMouseOver(this, d, barList, chartWidth, chartHeight);
            }).on('mousemove', function (d) {
                handleMouseMove(this, d, chartWidth, chartHeight);
            }).on('mouseout', function (d, index, barList) {
                handleMouseOut(this, d, barList, chartWidth, chartHeight);
            }).on('click', function (d) {
                handleClick(this, d, chartWidth, chartHeight);
            }).merge(bars).attr('x', function (_ref30) {
                var name = _ref30.name;
                return xScale(name);
            }).attr('y', function (_ref31) {
                var value = _ref31.value;
                return yScale(value);
            }).attr('width', xScale.bandwidth()).attr('height', function (_ref32) {
                var value = _ref32.value;
                return chartHeight - yScale(value);
            }).attr('fill', function (_ref33) {
                var name = _ref33.name;
                return computeColor(name);
            });
        }

        /**
         * Draws labels at the end of each bar
         * @private
         * @return {void}
         */
        function drawLabels() {
            var labelXPosition = isHorizontal ? _labelsHorizontalX : _labelsVerticalX;
            var labelYPosition = isHorizontal ? _labelsHorizontalY : _labelsVerticalY;
            var text = _labelsFormatValue;

            if (labelEl) {
                svg.selectAll('.percentage-label-group').remove();
            }

            labelEl = svg.select('.metadata-group').append('g').classed('percentage-label-group', true).selectAll('text').data(data.reverse()).enter().append('text');

            labelEl.classed('percentage-label', true).attr('x', labelXPosition).attr('y', labelYPosition).text(text).attr('font-size', labelsSize + 'px');
        }

        /**
         * Draws the bar elements within the chart group
         * @private
         */
        function drawBars() {
            var bars = void 0;

            if (isAnimated) {
                bars = svg.select('.chart-group').selectAll('.bar').data(dataZeroed);

                if (isHorizontal) {
                    drawHorizontalBars(bars);
                } else {
                    drawVerticalBars(bars);
                }

                bars = svg.select('.chart-group').selectAll('.bar').data(data);

                if (isHorizontal) {
                    drawAnimatedHorizontalBars(bars);
                } else {
                    drawAnimatedVerticalBars(bars);
                }

                // Exit
                bars.exit().transition().style('opacity', 0).remove();
            } else {
                bars = svg.select('.chart-group').selectAll('.bar').data(data);

                if (isHorizontal) {
                    drawHorizontalBars(bars);
                } else {
                    drawVerticalBars(bars);
                }

                // Exit
                bars.exit().remove();
            }
        }

        /**
         * Draws grid lines on the background of the chart
         * @return void
         */
        function drawGridLines() {
            svg.select('.grid-lines-group').selectAll('line').remove();

            if (isHorizontal) {
                drawHorizontalGridLines();
            } else {
                drawVerticalGridLines();
            }
        }

        /**
         * Draws the grid lines for an horizontal bar chart
         * @return {void}
         */
        function drawHorizontalGridLines() {
            maskGridLines = svg.select('.grid-lines-group').selectAll('line.vertical-grid-line').data(xScale.ticks(xTicks).slice(1)).enter().append('line').attr('class', 'vertical-grid-line').attr('y1', xAxisPadding.left).attr('y2', chartHeight).attr('x1', function (d) {
                return xScale(d);
            }).attr('x2', function (d) {
                return xScale(d);
            });

            drawVerticalExtendedLine();
        }

        /**
         * Draws a vertical line to extend y-axis till the edges
         * @return {void}
         */
        function drawVerticalExtendedLine() {
            baseLine = svg.select('.grid-lines-group').selectAll('line.extended-y-line').data([0]).enter().append('line').attr('class', 'extended-y-line').attr('y1', xAxisPadding.bottom).attr('y2', chartHeight).attr('x1', 0).attr('x2', 0);
        }

        /**
         * Draws the grid lines for a vertical bar chart
         * @return {void}
         */
        function drawVerticalGridLines() {
            maskGridLines = svg.select('.grid-lines-group').selectAll('line.horizontal-grid-line').data(yScale.ticks(yTicks).slice(1)).enter().append('line').attr('class', 'horizontal-grid-line').attr('x1', xAxisPadding.left).attr('x2', chartWidth).attr('y1', function (d) {
                return yScale(d);
            }).attr('y2', function (d) {
                return yScale(d);
            });

            drawHorizontalExtendedLine();
        }

        /**
         * Draws a vertical line to extend x-axis till the edges
         * @return {void}
         */
        function drawHorizontalExtendedLine() {
            baseLine = svg.select('.grid-lines-group').selectAll('line.extended-x-line').data([0]).enter().append('line').attr('class', 'extended-x-line').attr('x1', xAxisPadding.left).attr('x2', chartWidth).attr('y1', chartHeight).attr('y2', chartHeight);
        }

        /**
         * Custom OnMouseOver event handler
         * @return {void}
         * @private
         */
        function handleMouseOver(e, d, barList, chartWidth, chartHeight) {
            dispatcher.call('customMouseOver', e, d, d3Selection.mouse(e), [chartWidth, chartHeight]);
            highlightBarFunction = highlightBarFunction || function () {};

            if (hasSingleBarHighlight) {
                highlightBarFunction(d3Selection.select(e));
                return;
            }

            barList.forEach(function (barRect) {
                if (barRect === e) {
                    return;
                }
                highlightBarFunction(d3Selection.select(barRect));
            });
        }

        /**
         * Custom OnMouseMove event handler
         * @return {void}
         * @private
         */
        function handleMouseMove(e, d, chartWidth, chartHeight) {
            dispatcher.call('customMouseMove', e, d, d3Selection.mouse(e), [chartWidth, chartHeight]);
        }

        /**
         * Custom OnMouseOver event handler
         * @return {void}
         * @private
         */
        function handleMouseOut(e, d, barList, chartWidth, chartHeight) {
            dispatcher.call('customMouseOut', e, d, d3Selection.mouse(e), [chartWidth, chartHeight]);

            barList.forEach(function (barRect) {
                d3Selection.select(barRect).attr('fill', function (_ref34) {
                    var name = _ref34.name;
                    return computeColor(name);
                });
            });
        }

        /**
         * Custom onClick event handler
         * @return {void}
         * @private
         */
        function handleClick(e, d, chartWidth, chartHeight) {
            dispatcher.call('customClick', e, d, d3Selection.mouse(e), [chartWidth, chartHeight]);
        }

        // API

        /**
         * Gets or Sets the gradient colors of a bar in the chart
         * @param  {String[]} _x Desired color gradient for the line (array of two hexadecimal numbers)
         * @return {String[] | module} Current color gradient or Line Chart module to chain calls
         * @public
         */
        exports.chartGradient = function (_x) {
            if (!arguments.length) {
                return chartGradientColors;
            }
            chartGradientColors = _x;

            return this;
        };

        /**
         * Gets or Sets the padding of the chart (Default is 0.1)
         * @param  { Number | module } _x Padding value to get/set
         * @return {padding | module} Current padding or Chart module to chain calls
         * @public
         */
        exports.betweenBarsPadding = function (_x) {
            if (!arguments.length) {
                return betweenBarsPadding;
            }
            betweenBarsPadding = _x;

            return this;
        };

        /**
         * Gets or Sets the colorSchema of the chart
         * @param  {String[]} _x Desired colorSchema for the graph
         * @return { colorSchema | module} Current colorSchema or Chart module to chain calls
         * @public
         */
        exports.colorSchema = function (_x) {
            if (!arguments.length) {
                return colorSchema;
            }
            colorSchema = _x;

            return this;
        };

        /**
         * If true, adds labels at the end of the bars
         * @param  {Boolean} [_x=false]
         * @return {Boolean | module}    Current value of enableLabels or Chart module to chain calls
         * @public
         */
        exports.enableLabels = function (_x) {
            if (!arguments.length) {
                return enableLabels;
            }
            enableLabels = _x;

            return this;
        };

        /**
         * Chart exported to png and a download action is fired
         * @param {String} filename     File title for the resulting picture
         * @param {String} title        Title to add at the top of the exported picture
         * @public
         */
        exports.exportChart = function (filename, title) {
            exportChart.call(exports, svg, filename, title);
        };

        /**
         * Gets or Sets the hasPercentage status
         * @param  {boolean} _x     Should use percentage as value format
         * @return {boolean | module} Is percentage used or Chart module to chain calls
         * @public
         */
        exports.hasPercentage = function (_x) {
            if (!arguments.length) {
                return numberFormat === PERCENTAGE_FORMAT;
            }
            if (_x) {
                numberFormat = PERCENTAGE_FORMAT;
            } else {
                numberFormat = NUMBER_FORMAT;
            }

            return this;
        };

        /**
         * Gets or Sets the hasSingleBarHighlight status.
         * If the value is true (default), only the hovered bar is considered to
         * be highlighted and will be darkened by default. If the value is false,
         * all the bars but the hovered bar are considered to be highlighted
         * and will be darkened (by default). To customize the bar highlight or
         * remove it completely, use highlightBarFunction instead.
         * @param  {boolean} _x        Should highlight the hovered bar
         * @return {boolean | module} Is hasSingleBarHighlight used or Chart module to chain calls
         * @public
         */
        exports.hasSingleBarHighlight = function (_x) {
            if (!arguments.length) {
                return hasSingleBarHighlight;
            }
            hasSingleBarHighlight = _x;

            return this;
        };

        /**
         * Gets or Sets the height of the chart
         * @param  {number} _x Desired width for the graph
         * @return {height | module} Current height or Chart module to chain calls
         * @public
         */
        exports.height = function (_x) {
            if (!arguments.length) {
                return height;
            }
            height = _x;

            return this;
        };

        /**
         * Gets or Sets the highlightBarFunction function. The callback passed to
         * this function returns a bar selection from the bar chart. Use this function
         * if you want to apply a custom behavior to the highlighted bar on hover.
         * When hasSingleBarHighlight is true the highlighted bar will be the
         * one that was hovered by the user. When hasSingleBarHighlight is false
         * the highlighted bars are all the bars but the hovered one. The default
         * highlight effect on a bar is darkening the highlighted bar(s) color.
         * @param  {Function} _x        Desired operation operation on a hovered bar passed through callback
         * @return {highlightBarFunction | module} Is highlightBarFunction used or Chart module to chain calls
         * @public
         * @example barChart.highlightBarFunction(bar => bar.attr('fill', 'blue'))
         * barChart.highlightBarFunction(null) // will disable the default highlight effect
         */
        exports.highlightBarFunction = function (_x) {
            if (!arguments.length) {
                return highlightBarFunction;
            }
            highlightBarFunction = _x;

            return this;
        };

        /**
         * Gets or Sets the isAnimated property of the chart, making it to animate when render.
         * By default this is 'false'
         *
         * @param  {Boolean} _x             Desired animation flag
         * @return {isAnimated | module}    Current isAnimated flag or Chart module
         * @public
         */
        exports.isAnimated = function (_x) {
            if (!arguments.length) {
                return isAnimated;
            }
            isAnimated = _x;

            return this;
        };

        /**
         * Gets or Sets the horizontal direction of the chart
         * @param  {number} _x              Desired horizontal direction for the graph
         * @return { isHorizontal | module} If it is horizontal or Chart module to chain calls
         * @public
         */
        exports.isHorizontal = function (_x) {
            if (!arguments.length) {
                return isHorizontal;
            }
            isHorizontal = _x;

            return this;
        };

        /**
         * Offset between end of bar and start of the percentage bars
         * @param  {number} [_x=7]      Margin offset from end of bar
         * @return {number | module}    Current offset or Chart module to chain calls
         * @public
         */
        exports.labelsMargin = function (_x) {
            if (!arguments.length) {
                return labelsMargin;
            }
            labelsMargin = _x;

            return this;
        };

        /**
         * Gets or Sets the labels number format
         * @param  {string} [_x=",f"] desired label number format for the bar chart
         * @return {string | module} Current labelsNumberFormat or Chart module to chain calls
         * @public
         */
        exports.labelsNumberFormat = function (_x) {
            if (!arguments.length) {
                return labelsNumberFormat;
            }
            labelsNumberFormat = _x;

            return this;
        };

        /**
         * Get or Sets the labels text size
         * @param  {number} [_x=12] label font size
         * @return {number | module}    Current text size or Chart module to chain calls
         * @public
         */
        exports.labelsSize = function (_x) {
            if (!arguments.length) {
                return labelsSize;
            }
            labelsSize = _x;

            return this;
        };

        /**
         * Gets or Sets the loading state of the chart
         * @param  {string} markup Desired markup to show when null data
         * @return {loadingState | module} Current loading state markup or Chart module to chain calls
         * @public
         */
        exports.loadingState = function (_markup) {
            if (!arguments.length) {
                return loadingState;
            }
            loadingState = _markup;

            return this;
        };

        /**
         * Gets or Sets the margin of the chart
         * @param  {object} _x Margin object to get/set
         * @return {margin | module} Current margin or Chart module to chain calls
         * @public
         */
        exports.margin = function (_x) {
            if (!arguments.length) {
                return margin;
            }
            margin = _extends({}, margin, _x);

            return this;
        };

        /**
         * Gets or Sets the nameLabel of the chart
         * @param  {Number} _x Desired nameLabel for the graph
         * @return {nameLabel | module} Current nameLabel or Chart module to chain calls
         * @public
         */
        exports.nameLabel = function (_x) {
            if (!arguments.length) {
                return nameLabel;
            }
            nameLabel = _x;

            return this;
        };

        /**
         * Gets or Sets the number format of the bar chart
         * @param  {string} _x Desired number format for the bar chart
         * @return {numberFormat | module} Current numberFormat or Chart module to chain calls
         * @public
         */
        exports.numberFormat = function (_x) {
            if (!arguments.length) {
                return numberFormat;
            }
            numberFormat = _x;

            return this;
        };

        /**
         * Exposes an 'on' method that acts as a bridge with the event dispatcher
         * We are going to expose this events:
         * customMouseOver, customMouseMove, customMouseOut, and customClick
         *
         * @return {module} Bar Chart
         * @public
         */
        exports.on = function () {
            var value = dispatcher.on.apply(dispatcher, arguments);

            return value === dispatcher ? exports : value;
        };

        /**
         * Configurable extension of the x axis
         * if your max point was 50% you might want to show x axis to 60%, pass 1.2
         * @param  {number} _x ratio to max data point to add to the x axis
         * @return {ratio | module} Current ratio or Chart module to chain calls
         * @public
         */
        exports.percentageAxisToMaxRatio = function (_x) {
            if (!arguments.length) {
                return percentageAxisToMaxRatio;
            }
            percentageAxisToMaxRatio = _x;

            return this;
        };

        /**
         * Gets or Sets whether the color list should be reversed or not
         * @param  {boolean} _x     Should reverse the color list
         * @return {boolean | module} Is color list being reversed or Chart module to chain calls
         * @public
         */
        exports.shouldReverseColorList = function (_x) {
            if (!arguments.length) {
                return shouldReverseColorList;
            }
            shouldReverseColorList = _x;

            return this;
        };

        /**
         * Changes the order of items given the custom function
         * @param  {Function} _x             A custom function that sets logic for ordering
         * @return {(Function | Module)}   A custom ordering function or Chart module to chain calls
         * @public
         */
        exports.orderingFunction = function (_x) {
            if (!arguments.length) {
                return orderingFunction;
            }
            orderingFunction = _x;

            return this;
        };

        /**
         * Gets or Sets the valueLabel of the chart
         * @param  {Number} _x Desired valueLabel for the graph
         * @return { valueLabel | module} Current valueLabel or Chart module to chain calls
         * @public
         */
        exports.valueLabel = function (_x) {
            if (!arguments.length) {
                return valueLabel;
            }
            valueLabel = _x;

            return this;
        };

        /**
         * Gets or Sets the width of the chart
         * @param  {number} _x Desired width for the graph
         * @return {width | module} Current width or Chart module to chain calls
         * @public
         */
        exports.width = function (_x) {
            if (!arguments.length) {
                return width;
            }
            width = _x;

            return this;
        };

        /**
         * Gets or Sets the text of the xAxisLabel on the chart
         * @param  {String} _x Desired text for the label
         * @return {String | module} label or Chart module to chain calls
         * @public
         */
        exports.xAxisLabel = function (_x) {
            if (!arguments.length) {
                return xAxisLabel;
            }
            xAxisLabel = _x;

            return this;
        };

        /**
         * Gets or Sets the offset of the xAxisLabel on the chart
         * @param  {Number} _x Desired offset for the label
         * @return {Number | module} label or Chart module to chain calls
         * @public
         */
        exports.xAxisLabelOffset = function (_x) {
            if (!arguments.length) {
                return xAxisLabelOffset;
            }
            xAxisLabelOffset = _x;

            return this;
        };

        /**
         * Gets or Sets the number of ticks of the x axis on the chart
         * (Default is 5)
         * @param  {Number} _x          Desired horizontal ticks
         * @return {Number | module}    Current xTicks or Chart module to chain calls
         * @public
         */
        exports.xTicks = function (_x) {
            if (!arguments.length) {
                return xTicks;
            }
            xTicks = _x;

            return this;
        };

        /**
         * Gets or Sets the text of the yAxisLabel on the chart
         * @param  {String} _x Desired text for the label
         * @return {String | module} label or Chart module to chain calls
         * @public
         */
        exports.yAxisLabel = function (_x) {
            if (!arguments.length) {
                return yAxisLabel;
            }
            yAxisLabel = _x;

            return this;
        };

        /**
         * Gets or Sets the offset of the yAxisLabel on the chart
         * @param  {Number} _x Desired offset for the label
         * @return {Number | module} label or Chart module to chain calls
         * @public
         */
        exports.yAxisLabelOffset = function (_x) {
            if (!arguments.length) {
                return yAxisLabelOffset;
            }
            yAxisLabelOffset = _x;

            return this;
        };

        /**
         * Space between y axis and chart
         * (Default 10)
         * @param  {Number} _x          Space between y axis and chart
         * @return {Number| module}     Current value of yAxisPaddingBetweenChart or Chart module to chain calls
         * @public
         */
        exports.yAxisPaddingBetweenChart = function (_x) {
            if (!arguments.length) {
                return yAxisPaddingBetweenChart;
            }
            yAxisPaddingBetweenChart = _x;

            return this;
        };

        /**
         * Gets or Sets the number of vertical ticks on the chart
         * (Default is 6)
         * @param  {Number} _x          Desired number of vertical ticks for the graph
         * @return {Number | module}    Current yTicks or Chart module to chain calls
         * @public
         */
        exports.yTicks = function (_x) {
            if (!arguments.length) {
                return yTicks;
            }
            yTicks = _x;

            return this;
        };

        return exports;
    };
}.call(exports, __webpack_require__, exports, module),
				__WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));

/***/ }),
/* 125 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__pairs__ = __webpack_require__(69);


/* harmony default export */ __webpack_exports__["a"] = (function(values0, values1, reduce) {
  var n0 = values0.length,
      n1 = values1.length,
      values = new Array(n0 * n1),
      i0,
      i1,
      i,
      value0;

  if (reduce == null) reduce = __WEBPACK_IMPORTED_MODULE_0__pairs__["b" /* pair */];

  for (i0 = i = 0; i0 < n0; ++i0) {
    for (value0 = values0[i0], i1 = 0; i1 < n1; ++i1, ++i) {
      values[i] = reduce(value0, values1[i1]);
    }
  }

  return values;
});


/***/ }),
/* 126 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony default export */ __webpack_exports__["a"] = (function(a, b) {
  return b < a ? -1 : b > a ? 1 : b >= a ? 0 : NaN;
});


/***/ }),
/* 127 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__array__ = __webpack_require__(73);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__bisect__ = __webpack_require__(67);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__constant__ = __webpack_require__(128);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__extent__ = __webpack_require__(72);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__identity__ = __webpack_require__(129);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5__range__ = __webpack_require__(74);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_6__ticks__ = __webpack_require__(75);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_7__threshold_sturges__ = __webpack_require__(76);









/* harmony default export */ __webpack_exports__["a"] = (function() {
  var value = __WEBPACK_IMPORTED_MODULE_4__identity__["a" /* default */],
      domain = __WEBPACK_IMPORTED_MODULE_3__extent__["a" /* default */],
      threshold = __WEBPACK_IMPORTED_MODULE_7__threshold_sturges__["a" /* default */];

  function histogram(data) {
    var i,
        n = data.length,
        x,
        values = new Array(n);

    for (i = 0; i < n; ++i) {
      values[i] = value(data[i], i, data);
    }

    var xz = domain(values),
        x0 = xz[0],
        x1 = xz[1],
        tz = threshold(values, x0, x1);

    // Convert number of thresholds into uniform thresholds.
    if (!Array.isArray(tz)) {
      tz = Object(__WEBPACK_IMPORTED_MODULE_6__ticks__["c" /* tickStep */])(x0, x1, tz);
      tz = Object(__WEBPACK_IMPORTED_MODULE_5__range__["a" /* default */])(Math.ceil(x0 / tz) * tz, Math.floor(x1 / tz) * tz, tz); // exclusive
    }

    // Remove any thresholds outside the domain.
    var m = tz.length;
    while (tz[0] <= x0) tz.shift(), --m;
    while (tz[m - 1] > x1) tz.pop(), --m;

    var bins = new Array(m + 1),
        bin;

    // Initialize bins.
    for (i = 0; i <= m; ++i) {
      bin = bins[i] = [];
      bin.x0 = i > 0 ? tz[i - 1] : x0;
      bin.x1 = i < m ? tz[i] : x1;
    }

    // Assign data to bins by value, ignoring any outside the domain.
    for (i = 0; i < n; ++i) {
      x = values[i];
      if (x0 <= x && x <= x1) {
        bins[Object(__WEBPACK_IMPORTED_MODULE_1__bisect__["c" /* default */])(tz, x, 0, m)].push(data[i]);
      }
    }

    return bins;
  }

  histogram.value = function(_) {
    return arguments.length ? (value = typeof _ === "function" ? _ : Object(__WEBPACK_IMPORTED_MODULE_2__constant__["a" /* default */])(_), histogram) : value;
  };

  histogram.domain = function(_) {
    return arguments.length ? (domain = typeof _ === "function" ? _ : Object(__WEBPACK_IMPORTED_MODULE_2__constant__["a" /* default */])([_[0], _[1]]), histogram) : domain;
  };

  histogram.thresholds = function(_) {
    return arguments.length ? (threshold = typeof _ === "function" ? _ : Array.isArray(_) ? Object(__WEBPACK_IMPORTED_MODULE_2__constant__["a" /* default */])(__WEBPACK_IMPORTED_MODULE_0__array__["b" /* slice */].call(_)) : Object(__WEBPACK_IMPORTED_MODULE_2__constant__["a" /* default */])(_), histogram) : threshold;
  };

  return histogram;
});


/***/ }),
/* 128 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony default export */ __webpack_exports__["a"] = (function(x) {
  return function() {
    return x;
  };
});


/***/ }),
/* 129 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony default export */ __webpack_exports__["a"] = (function(x) {
  return x;
});


/***/ }),
/* 130 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__array__ = __webpack_require__(73);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__ascending__ = __webpack_require__(24);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__number__ = __webpack_require__(26);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__quantile__ = __webpack_require__(43);





/* harmony default export */ __webpack_exports__["a"] = (function(values, min, max) {
  values = __WEBPACK_IMPORTED_MODULE_0__array__["a" /* map */].call(values, __WEBPACK_IMPORTED_MODULE_2__number__["a" /* default */]).sort(__WEBPACK_IMPORTED_MODULE_1__ascending__["a" /* default */]);
  return Math.ceil((max - min) / (2 * (Object(__WEBPACK_IMPORTED_MODULE_3__quantile__["a" /* default */])(values, 0.75) - Object(__WEBPACK_IMPORTED_MODULE_3__quantile__["a" /* default */])(values, 0.25)) * Math.pow(values.length, -1 / 3)));
});


/***/ }),
/* 131 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__deviation__ = __webpack_require__(70);


/* harmony default export */ __webpack_exports__["a"] = (function(values, min, max) {
  return Math.ceil((max - min) / (3.5 * Object(__WEBPACK_IMPORTED_MODULE_0__deviation__["a" /* default */])(values) * Math.pow(values.length, -1 / 3)));
});


/***/ }),
/* 132 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony default export */ __webpack_exports__["a"] = (function(values, valueof) {
  var n = values.length,
      i = -1,
      value,
      max;

  if (valueof == null) {
    while (++i < n) { // Find the first comparable value.
      if ((value = values[i]) != null && value >= value) {
        max = value;
        while (++i < n) { // Compare the remaining values.
          if ((value = values[i]) != null && value > max) {
            max = value;
          }
        }
      }
    }
  }

  else {
    while (++i < n) { // Find the first comparable value.
      if ((value = valueof(values[i], i, values)) != null && value >= value) {
        max = value;
        while (++i < n) { // Compare the remaining values.
          if ((value = valueof(values[i], i, values)) != null && value > max) {
            max = value;
          }
        }
      }
    }
  }

  return max;
});


/***/ }),
/* 133 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__number__ = __webpack_require__(26);


/* harmony default export */ __webpack_exports__["a"] = (function(values, valueof) {
  var n = values.length,
      m = n,
      i = -1,
      value,
      sum = 0;

  if (valueof == null) {
    while (++i < n) {
      if (!isNaN(value = Object(__WEBPACK_IMPORTED_MODULE_0__number__["a" /* default */])(values[i]))) sum += value;
      else --m;
    }
  }

  else {
    while (++i < n) {
      if (!isNaN(value = Object(__WEBPACK_IMPORTED_MODULE_0__number__["a" /* default */])(valueof(values[i], i, values)))) sum += value;
      else --m;
    }
  }

  if (m) return sum / m;
});


/***/ }),
/* 134 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__ascending__ = __webpack_require__(24);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__number__ = __webpack_require__(26);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__quantile__ = __webpack_require__(43);




/* harmony default export */ __webpack_exports__["a"] = (function(values, valueof) {
  var n = values.length,
      i = -1,
      value,
      numbers = [];

  if (valueof == null) {
    while (++i < n) {
      if (!isNaN(value = Object(__WEBPACK_IMPORTED_MODULE_1__number__["a" /* default */])(values[i]))) {
        numbers.push(value);
      }
    }
  }

  else {
    while (++i < n) {
      if (!isNaN(value = Object(__WEBPACK_IMPORTED_MODULE_1__number__["a" /* default */])(valueof(values[i], i, values)))) {
        numbers.push(value);
      }
    }
  }

  return Object(__WEBPACK_IMPORTED_MODULE_2__quantile__["a" /* default */])(numbers.sort(__WEBPACK_IMPORTED_MODULE_0__ascending__["a" /* default */]), 0.5);
});


/***/ }),
/* 135 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony default export */ __webpack_exports__["a"] = (function(arrays) {
  var n = arrays.length,
      m,
      i = -1,
      j = 0,
      merged,
      array;

  while (++i < n) j += arrays[i].length;
  merged = new Array(j);

  while (--n >= 0) {
    array = arrays[n];
    m = array.length;
    while (--m >= 0) {
      merged[--j] = array[m];
    }
  }

  return merged;
});


/***/ }),
/* 136 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony default export */ __webpack_exports__["a"] = (function(array, indexes) {
  var i = indexes.length, permutes = new Array(i);
  while (i--) permutes[i] = array[indexes[i]];
  return permutes;
});


/***/ }),
/* 137 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__ascending__ = __webpack_require__(24);


/* harmony default export */ __webpack_exports__["a"] = (function(values, compare) {
  if (!(n = values.length)) return;
  var n,
      i = 0,
      j = 0,
      xi,
      xj = values[j];

  if (compare == null) compare = __WEBPACK_IMPORTED_MODULE_0__ascending__["a" /* default */];

  while (++i < n) {
    if (compare(xi = values[i], xj) < 0 || compare(xj, xj) !== 0) {
      xj = xi, j = i;
    }
  }

  if (compare(xj, xj) === 0) return j;
});


/***/ }),
/* 138 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony default export */ __webpack_exports__["a"] = (function(array, i0, i1) {
  var m = (i1 == null ? array.length : i1) - (i0 = i0 == null ? 0 : +i0),
      t,
      i;

  while (m) {
    i = Math.random() * m-- | 0;
    t = array[m + i0];
    array[m + i0] = array[i + i0];
    array[i + i0] = t;
  }

  return array;
});


/***/ }),
/* 139 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony default export */ __webpack_exports__["a"] = (function(values, valueof) {
  var n = values.length,
      i = -1,
      value,
      sum = 0;

  if (valueof == null) {
    while (++i < n) {
      if (value = +values[i]) sum += value; // Note: zero and null are equivalent.
    }
  }

  else {
    while (++i < n) {
      if (value = +valueof(values[i], i, values)) sum += value;
    }
  }

  return sum;
});


/***/ }),
/* 140 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__transpose__ = __webpack_require__(78);


/* harmony default export */ __webpack_exports__["a"] = (function() {
  return Object(__WEBPACK_IMPORTED_MODULE_0__transpose__["a" /* default */])(arguments);
});


/***/ }),
/* 141 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (immutable) */ __webpack_exports__["a"] = linear;
function linear(t) {
  return +t;
}


/***/ }),
/* 142 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (immutable) */ __webpack_exports__["a"] = quadIn;
/* harmony export (immutable) */ __webpack_exports__["c"] = quadOut;
/* harmony export (immutable) */ __webpack_exports__["b"] = quadInOut;
function quadIn(t) {
  return t * t;
}

function quadOut(t) {
  return t * (2 - t);
}

function quadInOut(t) {
  return ((t *= 2) <= 1 ? t * t : --t * (2 - t) + 1) / 2;
}


/***/ }),
/* 143 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (immutable) */ __webpack_exports__["a"] = cubicIn;
/* harmony export (immutable) */ __webpack_exports__["c"] = cubicOut;
/* harmony export (immutable) */ __webpack_exports__["b"] = cubicInOut;
function cubicIn(t) {
  return t * t * t;
}

function cubicOut(t) {
  return --t * t * t + 1;
}

function cubicInOut(t) {
  return ((t *= 2) <= 1 ? t * t * t : (t -= 2) * t * t + 2) / 2;
}


/***/ }),
/* 144 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return polyIn; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "c", function() { return polyOut; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "b", function() { return polyInOut; });
var exponent = 3;

var polyIn = (function custom(e) {
  e = +e;

  function polyIn(t) {
    return Math.pow(t, e);
  }

  polyIn.exponent = custom;

  return polyIn;
})(exponent);

var polyOut = (function custom(e) {
  e = +e;

  function polyOut(t) {
    return 1 - Math.pow(1 - t, e);
  }

  polyOut.exponent = custom;

  return polyOut;
})(exponent);

var polyInOut = (function custom(e) {
  e = +e;

  function polyInOut(t) {
    return ((t *= 2) <= 1 ? Math.pow(t, e) : 2 - Math.pow(2 - t, e)) / 2;
  }

  polyInOut.exponent = custom;

  return polyInOut;
})(exponent);


/***/ }),
/* 145 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (immutable) */ __webpack_exports__["a"] = sinIn;
/* harmony export (immutable) */ __webpack_exports__["c"] = sinOut;
/* harmony export (immutable) */ __webpack_exports__["b"] = sinInOut;
var pi = Math.PI,
    halfPi = pi / 2;

function sinIn(t) {
  return 1 - Math.cos(t * halfPi);
}

function sinOut(t) {
  return Math.sin(t * halfPi);
}

function sinInOut(t) {
  return (1 - Math.cos(pi * t)) / 2;
}


/***/ }),
/* 146 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (immutable) */ __webpack_exports__["a"] = expIn;
/* harmony export (immutable) */ __webpack_exports__["c"] = expOut;
/* harmony export (immutable) */ __webpack_exports__["b"] = expInOut;
function expIn(t) {
  return Math.pow(2, 10 * t - 10);
}

function expOut(t) {
  return 1 - Math.pow(2, -10 * t);
}

function expInOut(t) {
  return ((t *= 2) <= 1 ? Math.pow(2, 10 * t - 10) : 2 - Math.pow(2, 10 - 10 * t)) / 2;
}


/***/ }),
/* 147 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (immutable) */ __webpack_exports__["a"] = circleIn;
/* harmony export (immutable) */ __webpack_exports__["c"] = circleOut;
/* harmony export (immutable) */ __webpack_exports__["b"] = circleInOut;
function circleIn(t) {
  return 1 - Math.sqrt(1 - t * t);
}

function circleOut(t) {
  return Math.sqrt(1 - --t * t);
}

function circleInOut(t) {
  return ((t *= 2) <= 1 ? 1 - Math.sqrt(1 - t * t) : Math.sqrt(1 - (t -= 2) * t) + 1) / 2;
}


/***/ }),
/* 148 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (immutable) */ __webpack_exports__["a"] = bounceIn;
/* harmony export (immutable) */ __webpack_exports__["c"] = bounceOut;
/* harmony export (immutable) */ __webpack_exports__["b"] = bounceInOut;
var b1 = 4 / 11,
    b2 = 6 / 11,
    b3 = 8 / 11,
    b4 = 3 / 4,
    b5 = 9 / 11,
    b6 = 10 / 11,
    b7 = 15 / 16,
    b8 = 21 / 22,
    b9 = 63 / 64,
    b0 = 1 / b1 / b1;

function bounceIn(t) {
  return 1 - bounceOut(1 - t);
}

function bounceOut(t) {
  return (t = +t) < b1 ? b0 * t * t : t < b3 ? b0 * (t -= b2) * t + b4 : t < b6 ? b0 * (t -= b5) * t + b7 : b0 * (t -= b8) * t + b9;
}

function bounceInOut(t) {
  return ((t *= 2) <= 1 ? 1 - bounceOut(1 - t) : bounceOut(t - 1) + 1) / 2;
}


/***/ }),
/* 149 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return backIn; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "c", function() { return backOut; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "b", function() { return backInOut; });
var overshoot = 1.70158;

var backIn = (function custom(s) {
  s = +s;

  function backIn(t) {
    return t * t * ((s + 1) * t - s);
  }

  backIn.overshoot = custom;

  return backIn;
})(overshoot);

var backOut = (function custom(s) {
  s = +s;

  function backOut(t) {
    return --t * t * ((s + 1) * t + s) + 1;
  }

  backOut.overshoot = custom;

  return backOut;
})(overshoot);

var backInOut = (function custom(s) {
  s = +s;

  function backInOut(t) {
    return ((t *= 2) < 1 ? t * t * ((s + 1) * t - s) : (t -= 2) * t * ((s + 1) * t + s) + 2) / 2;
  }

  backInOut.overshoot = custom;

  return backInOut;
})(overshoot);


/***/ }),
/* 150 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return elasticIn; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "c", function() { return elasticOut; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "b", function() { return elasticInOut; });
var tau = 2 * Math.PI,
    amplitude = 1,
    period = 0.3;

var elasticIn = (function custom(a, p) {
  var s = Math.asin(1 / (a = Math.max(1, a))) * (p /= tau);

  function elasticIn(t) {
    return a * Math.pow(2, 10 * --t) * Math.sin((s - t) / p);
  }

  elasticIn.amplitude = function(a) { return custom(a, p * tau); };
  elasticIn.period = function(p) { return custom(a, p); };

  return elasticIn;
})(amplitude, period);

var elasticOut = (function custom(a, p) {
  var s = Math.asin(1 / (a = Math.max(1, a))) * (p /= tau);

  function elasticOut(t) {
    return 1 - a * Math.pow(2, -10 * (t = +t)) * Math.sin((t + s) / p);
  }

  elasticOut.amplitude = function(a) { return custom(a, p * tau); };
  elasticOut.period = function(p) { return custom(a, p); };

  return elasticOut;
})(amplitude, period);

var elasticInOut = (function custom(a, p) {
  var s = Math.asin(1 / (a = Math.max(1, a))) * (p /= tau);

  function elasticInOut(t) {
    return ((t = t * 2 - 1) < 0
        ? a * Math.pow(2, 10 * t) * Math.sin((s - t) / p)
        : 2 - a * Math.pow(2, -10 * t) * Math.sin((s + t) / p)) / 2;
  }

  elasticInOut.amplitude = function(a) { return custom(a, p * tau); };
  elasticInOut.period = function(p) { return custom(a, p); };

  return elasticInOut;
})(amplitude, period);


/***/ }),
/* 151 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (immutable) */ __webpack_exports__["d"] = axisTop;
/* harmony export (immutable) */ __webpack_exports__["c"] = axisRight;
/* harmony export (immutable) */ __webpack_exports__["a"] = axisBottom;
/* harmony export (immutable) */ __webpack_exports__["b"] = axisLeft;
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__array__ = __webpack_require__(152);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__identity__ = __webpack_require__(153);



var top = 1,
    right = 2,
    bottom = 3,
    left = 4,
    epsilon = 1e-6;

function translateX(x) {
  return "translate(" + (x + 0.5) + ",0)";
}

function translateY(y) {
  return "translate(0," + (y + 0.5) + ")";
}

function number(scale) {
  return function(d) {
    return +scale(d);
  };
}

function center(scale) {
  var offset = Math.max(0, scale.bandwidth() - 1) / 2; // Adjust for 0.5px offset.
  if (scale.round()) offset = Math.round(offset);
  return function(d) {
    return +scale(d) + offset;
  };
}

function entering() {
  return !this.__axis;
}

function axis(orient, scale) {
  var tickArguments = [],
      tickValues = null,
      tickFormat = null,
      tickSizeInner = 6,
      tickSizeOuter = 6,
      tickPadding = 3,
      k = orient === top || orient === left ? -1 : 1,
      x = orient === left || orient === right ? "x" : "y",
      transform = orient === top || orient === bottom ? translateX : translateY;

  function axis(context) {
    var values = tickValues == null ? (scale.ticks ? scale.ticks.apply(scale, tickArguments) : scale.domain()) : tickValues,
        format = tickFormat == null ? (scale.tickFormat ? scale.tickFormat.apply(scale, tickArguments) : __WEBPACK_IMPORTED_MODULE_1__identity__["a" /* default */]) : tickFormat,
        spacing = Math.max(tickSizeInner, 0) + tickPadding,
        range = scale.range(),
        range0 = +range[0] + 0.5,
        range1 = +range[range.length - 1] + 0.5,
        position = (scale.bandwidth ? center : number)(scale.copy()),
        selection = context.selection ? context.selection() : context,
        path = selection.selectAll(".domain").data([null]),
        tick = selection.selectAll(".tick").data(values, scale).order(),
        tickExit = tick.exit(),
        tickEnter = tick.enter().append("g").attr("class", "tick"),
        line = tick.select("line"),
        text = tick.select("text");

    path = path.merge(path.enter().insert("path", ".tick")
        .attr("class", "domain")
        .attr("stroke", "#000"));

    tick = tick.merge(tickEnter);

    line = line.merge(tickEnter.append("line")
        .attr("stroke", "#000")
        .attr(x + "2", k * tickSizeInner));

    text = text.merge(tickEnter.append("text")
        .attr("fill", "#000")
        .attr(x, k * spacing)
        .attr("dy", orient === top ? "0em" : orient === bottom ? "0.71em" : "0.32em"));

    if (context !== selection) {
      path = path.transition(context);
      tick = tick.transition(context);
      line = line.transition(context);
      text = text.transition(context);

      tickExit = tickExit.transition(context)
          .attr("opacity", epsilon)
          .attr("transform", function(d) { return isFinite(d = position(d)) ? transform(d) : this.getAttribute("transform"); });

      tickEnter
          .attr("opacity", epsilon)
          .attr("transform", function(d) { var p = this.parentNode.__axis; return transform(p && isFinite(p = p(d)) ? p : position(d)); });
    }

    tickExit.remove();

    path
        .attr("d", orient === left || orient == right
            ? "M" + k * tickSizeOuter + "," + range0 + "H0.5V" + range1 + "H" + k * tickSizeOuter
            : "M" + range0 + "," + k * tickSizeOuter + "V0.5H" + range1 + "V" + k * tickSizeOuter);

    tick
        .attr("opacity", 1)
        .attr("transform", function(d) { return transform(position(d)); });

    line
        .attr(x + "2", k * tickSizeInner);

    text
        .attr(x, k * spacing)
        .text(format);

    selection.filter(entering)
        .attr("fill", "none")
        .attr("font-size", 10)
        .attr("font-family", "sans-serif")
        .attr("text-anchor", orient === right ? "start" : orient === left ? "end" : "middle");

    selection
        .each(function() { this.__axis = position; });
  }

  axis.scale = function(_) {
    return arguments.length ? (scale = _, axis) : scale;
  };

  axis.ticks = function() {
    return tickArguments = __WEBPACK_IMPORTED_MODULE_0__array__["a" /* slice */].call(arguments), axis;
  };

  axis.tickArguments = function(_) {
    return arguments.length ? (tickArguments = _ == null ? [] : __WEBPACK_IMPORTED_MODULE_0__array__["a" /* slice */].call(_), axis) : tickArguments.slice();
  };

  axis.tickValues = function(_) {
    return arguments.length ? (tickValues = _ == null ? null : __WEBPACK_IMPORTED_MODULE_0__array__["a" /* slice */].call(_), axis) : tickValues && tickValues.slice();
  };

  axis.tickFormat = function(_) {
    return arguments.length ? (tickFormat = _, axis) : tickFormat;
  };

  axis.tickSize = function(_) {
    return arguments.length ? (tickSizeInner = tickSizeOuter = +_, axis) : tickSizeInner;
  };

  axis.tickSizeInner = function(_) {
    return arguments.length ? (tickSizeInner = +_, axis) : tickSizeInner;
  };

  axis.tickSizeOuter = function(_) {
    return arguments.length ? (tickSizeOuter = +_, axis) : tickSizeOuter;
  };

  axis.tickPadding = function(_) {
    return arguments.length ? (tickPadding = +_, axis) : tickPadding;
  };

  return axis;
}

function axisTop(scale) {
  return axis(top, scale);
}

function axisRight(scale) {
  return axis(right, scale);
}

function axisBottom(scale) {
  return axis(bottom, scale);
}

function axisLeft(scale) {
  return axis(left, scale);
}


/***/ }),
/* 152 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return slice; });
var slice = Array.prototype.slice;


/***/ }),
/* 153 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony default export */ __webpack_exports__["a"] = (function(x) {
  return x;
});


/***/ }),
/* 154 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (immutable) */ __webpack_exports__["a"] = lab;
/* unused harmony export Lab */
/* harmony export (immutable) */ __webpack_exports__["b"] = hcl;
/* unused harmony export Hcl */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__define__ = __webpack_require__(45);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__color__ = __webpack_require__(44);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__math__ = __webpack_require__(79);




var Kn = 18,
    Xn = 0.950470, // D65 standard referent
    Yn = 1,
    Zn = 1.088830,
    t0 = 4 / 29,
    t1 = 6 / 29,
    t2 = 3 * t1 * t1,
    t3 = t1 * t1 * t1;

function labConvert(o) {
  if (o instanceof Lab) return new Lab(o.l, o.a, o.b, o.opacity);
  if (o instanceof Hcl) {
    var h = o.h * __WEBPACK_IMPORTED_MODULE_2__math__["a" /* deg2rad */];
    return new Lab(o.l, Math.cos(h) * o.c, Math.sin(h) * o.c, o.opacity);
  }
  if (!(o instanceof __WEBPACK_IMPORTED_MODULE_1__color__["b" /* Rgb */])) o = Object(__WEBPACK_IMPORTED_MODULE_1__color__["h" /* rgbConvert */])(o);
  var b = rgb2xyz(o.r),
      a = rgb2xyz(o.g),
      l = rgb2xyz(o.b),
      x = xyz2lab((0.4124564 * b + 0.3575761 * a + 0.1804375 * l) / Xn),
      y = xyz2lab((0.2126729 * b + 0.7151522 * a + 0.0721750 * l) / Yn),
      z = xyz2lab((0.0193339 * b + 0.1191920 * a + 0.9503041 * l) / Zn);
  return new Lab(116 * y - 16, 500 * (x - y), 200 * (y - z), o.opacity);
}

function lab(l, a, b, opacity) {
  return arguments.length === 1 ? labConvert(l) : new Lab(l, a, b, opacity == null ? 1 : opacity);
}

function Lab(l, a, b, opacity) {
  this.l = +l;
  this.a = +a;
  this.b = +b;
  this.opacity = +opacity;
}

Object(__WEBPACK_IMPORTED_MODULE_0__define__["a" /* default */])(Lab, lab, Object(__WEBPACK_IMPORTED_MODULE_0__define__["b" /* extend */])(__WEBPACK_IMPORTED_MODULE_1__color__["a" /* Color */], {
  brighter: function(k) {
    return new Lab(this.l + Kn * (k == null ? 1 : k), this.a, this.b, this.opacity);
  },
  darker: function(k) {
    return new Lab(this.l - Kn * (k == null ? 1 : k), this.a, this.b, this.opacity);
  },
  rgb: function() {
    var y = (this.l + 16) / 116,
        x = isNaN(this.a) ? y : y + this.a / 500,
        z = isNaN(this.b) ? y : y - this.b / 200;
    y = Yn * lab2xyz(y);
    x = Xn * lab2xyz(x);
    z = Zn * lab2xyz(z);
    return new __WEBPACK_IMPORTED_MODULE_1__color__["b" /* Rgb */](
      xyz2rgb( 3.2404542 * x - 1.5371385 * y - 0.4985314 * z), // D65 -> sRGB
      xyz2rgb(-0.9692660 * x + 1.8760108 * y + 0.0415560 * z),
      xyz2rgb( 0.0556434 * x - 0.2040259 * y + 1.0572252 * z),
      this.opacity
    );
  }
}));

function xyz2lab(t) {
  return t > t3 ? Math.pow(t, 1 / 3) : t / t2 + t0;
}

function lab2xyz(t) {
  return t > t1 ? t * t * t : t2 * (t - t0);
}

function xyz2rgb(x) {
  return 255 * (x <= 0.0031308 ? 12.92 * x : 1.055 * Math.pow(x, 1 / 2.4) - 0.055);
}

function rgb2xyz(x) {
  return (x /= 255) <= 0.04045 ? x / 12.92 : Math.pow((x + 0.055) / 1.055, 2.4);
}

function hclConvert(o) {
  if (o instanceof Hcl) return new Hcl(o.h, o.c, o.l, o.opacity);
  if (!(o instanceof Lab)) o = labConvert(o);
  var h = Math.atan2(o.b, o.a) * __WEBPACK_IMPORTED_MODULE_2__math__["b" /* rad2deg */];
  return new Hcl(h < 0 ? h + 360 : h, Math.sqrt(o.a * o.a + o.b * o.b), o.l, o.opacity);
}

function hcl(h, c, l, opacity) {
  return arguments.length === 1 ? hclConvert(h) : new Hcl(h, c, l, opacity == null ? 1 : opacity);
}

function Hcl(h, c, l, opacity) {
  this.h = +h;
  this.c = +c;
  this.l = +l;
  this.opacity = +opacity;
}

Object(__WEBPACK_IMPORTED_MODULE_0__define__["a" /* default */])(Hcl, hcl, Object(__WEBPACK_IMPORTED_MODULE_0__define__["b" /* extend */])(__WEBPACK_IMPORTED_MODULE_1__color__["a" /* Color */], {
  brighter: function(k) {
    return new Hcl(this.h, this.c, this.l + Kn * (k == null ? 1 : k), this.opacity);
  },
  darker: function(k) {
    return new Hcl(this.h, this.c, this.l - Kn * (k == null ? 1 : k), this.opacity);
  },
  rgb: function() {
    return labConvert(this).rgb();
  }
}));


/***/ }),
/* 155 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (immutable) */ __webpack_exports__["a"] = cubehelix;
/* unused harmony export Cubehelix */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__define__ = __webpack_require__(45);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__color__ = __webpack_require__(44);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__math__ = __webpack_require__(79);




var A = -0.14861,
    B = +1.78277,
    C = -0.29227,
    D = -0.90649,
    E = +1.97294,
    ED = E * D,
    EB = E * B,
    BC_DA = B * C - D * A;

function cubehelixConvert(o) {
  if (o instanceof Cubehelix) return new Cubehelix(o.h, o.s, o.l, o.opacity);
  if (!(o instanceof __WEBPACK_IMPORTED_MODULE_1__color__["b" /* Rgb */])) o = Object(__WEBPACK_IMPORTED_MODULE_1__color__["h" /* rgbConvert */])(o);
  var r = o.r / 255,
      g = o.g / 255,
      b = o.b / 255,
      l = (BC_DA * b + ED * r - EB * g) / (BC_DA + ED - EB),
      bl = b - l,
      k = (E * (g - l) - C * bl) / D,
      s = Math.sqrt(k * k + bl * bl) / (E * l * (1 - l)), // NaN if l=0 or l=1
      h = s ? Math.atan2(k, bl) * __WEBPACK_IMPORTED_MODULE_2__math__["b" /* rad2deg */] - 120 : NaN;
  return new Cubehelix(h < 0 ? h + 360 : h, s, l, o.opacity);
}

function cubehelix(h, s, l, opacity) {
  return arguments.length === 1 ? cubehelixConvert(h) : new Cubehelix(h, s, l, opacity == null ? 1 : opacity);
}

function Cubehelix(h, s, l, opacity) {
  this.h = +h;
  this.s = +s;
  this.l = +l;
  this.opacity = +opacity;
}

Object(__WEBPACK_IMPORTED_MODULE_0__define__["a" /* default */])(Cubehelix, cubehelix, Object(__WEBPACK_IMPORTED_MODULE_0__define__["b" /* extend */])(__WEBPACK_IMPORTED_MODULE_1__color__["a" /* Color */], {
  brighter: function(k) {
    k = k == null ? __WEBPACK_IMPORTED_MODULE_1__color__["c" /* brighter */] : Math.pow(__WEBPACK_IMPORTED_MODULE_1__color__["c" /* brighter */], k);
    return new Cubehelix(this.h, this.s, this.l * k, this.opacity);
  },
  darker: function(k) {
    k = k == null ? __WEBPACK_IMPORTED_MODULE_1__color__["d" /* darker */] : Math.pow(__WEBPACK_IMPORTED_MODULE_1__color__["d" /* darker */], k);
    return new Cubehelix(this.h, this.s, this.l * k, this.opacity);
  },
  rgb: function() {
    var h = isNaN(this.h) ? 0 : (this.h + 120) * __WEBPACK_IMPORTED_MODULE_2__math__["a" /* deg2rad */],
        l = +this.l,
        a = isNaN(this.s) ? 0 : this.s * l * (1 - l),
        cosh = Math.cos(h),
        sinh = Math.sin(h);
    return new __WEBPACK_IMPORTED_MODULE_1__color__["b" /* Rgb */](
      255 * (l + a * (A * cosh + B * sinh)),
      255 * (l + a * (C * cosh + D * sinh)),
      255 * (l + a * (E * cosh)),
      this.opacity
    );
  }
}));


/***/ }),
/* 156 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var noop = {value: function() {}};

function dispatch() {
  for (var i = 0, n = arguments.length, _ = {}, t; i < n; ++i) {
    if (!(t = arguments[i] + "") || (t in _)) throw new Error("illegal type: " + t);
    _[t] = [];
  }
  return new Dispatch(_);
}

function Dispatch(_) {
  this._ = _;
}

function parseTypenames(typenames, types) {
  return typenames.trim().split(/^|\s+/).map(function(t) {
    var name = "", i = t.indexOf(".");
    if (i >= 0) name = t.slice(i + 1), t = t.slice(0, i);
    if (t && !types.hasOwnProperty(t)) throw new Error("unknown type: " + t);
    return {type: t, name: name};
  });
}

Dispatch.prototype = dispatch.prototype = {
  constructor: Dispatch,
  on: function(typename, callback) {
    var _ = this._,
        T = parseTypenames(typename + "", _),
        t,
        i = -1,
        n = T.length;

    // If no callback was specified, return the callback of the given type and name.
    if (arguments.length < 2) {
      while (++i < n) if ((t = (typename = T[i]).type) && (t = get(_[t], typename.name))) return t;
      return;
    }

    // If a type was specified, set the callback for the given type and name.
    // Otherwise, if a null callback was specified, remove callbacks of the given name.
    if (callback != null && typeof callback !== "function") throw new Error("invalid callback: " + callback);
    while (++i < n) {
      if (t = (typename = T[i]).type) _[t] = set(_[t], typename.name, callback);
      else if (callback == null) for (t in _) _[t] = set(_[t], typename.name, null);
    }

    return this;
  },
  copy: function() {
    var copy = {}, _ = this._;
    for (var t in _) copy[t] = _[t].slice();
    return new Dispatch(copy);
  },
  call: function(type, that) {
    if ((n = arguments.length - 2) > 0) for (var args = new Array(n), i = 0, n, t; i < n; ++i) args[i] = arguments[i + 2];
    if (!this._.hasOwnProperty(type)) throw new Error("unknown type: " + type);
    for (t = this._[type], i = 0, n = t.length; i < n; ++i) t[i].value.apply(that, args);
  },
  apply: function(type, that, args) {
    if (!this._.hasOwnProperty(type)) throw new Error("unknown type: " + type);
    for (var t = this._[type], i = 0, n = t.length; i < n; ++i) t[i].value.apply(that, args);
  }
};

function get(type, name) {
  for (var i = 0, n = type.length, c; i < n; ++i) {
    if ((c = type[i]).name === name) {
      return c.value;
    }
  }
}

function set(type, name, callback) {
  for (var i = 0, n = type.length; i < n; ++i) {
    if (type[i].name === name) {
      type[i] = noop, type = type.slice(0, i).concat(type.slice(i + 1));
      break;
    }
  }
  if (callback != null) type.push({name: name, value: callback});
  return type;
}

/* harmony default export */ __webpack_exports__["a"] = (dispatch);


/***/ }),
/* 157 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "b", function() { return format; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "c", function() { return formatPrefix; });
/* harmony export (immutable) */ __webpack_exports__["a"] = defaultLocale;
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__locale__ = __webpack_require__(80);


var locale;
var format;
var formatPrefix;

defaultLocale({
  decimal: ".",
  thousands: ",",
  grouping: [3],
  currency: ["$", ""]
});

function defaultLocale(definition) {
  locale = Object(__WEBPACK_IMPORTED_MODULE_0__locale__["a" /* default */])(definition);
  format = locale.format;
  formatPrefix = locale.formatPrefix;
  return locale;
}


/***/ }),
/* 158 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony default export */ __webpack_exports__["a"] = (function(grouping, thousands) {
  return function(value, width) {
    var i = value.length,
        t = [],
        j = 0,
        g = grouping[0],
        length = 0;

    while (i > 0 && g > 0) {
      if (length + g + 1 > width) g = Math.max(1, width - length);
      t.push(value.substring(i -= g, i + g));
      if ((length += g + 1) > width) break;
      g = grouping[j = (j + 1) % grouping.length];
    }

    return t.reverse().join(thousands);
  };
});


/***/ }),
/* 159 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony default export */ __webpack_exports__["a"] = (function(numerals) {
  return function(value) {
    return value.replace(/[0-9]/g, function(i) {
      return numerals[+i];
    });
  };
});


/***/ }),
/* 160 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony default export */ __webpack_exports__["a"] = (function(x, p) {
  x = x.toPrecision(p);

  out: for (var n = x.length, i = 1, i0 = -1, i1; i < n; ++i) {
    switch (x[i]) {
      case ".": i0 = i1 = i; break;
      case "0": if (i0 === 0) i0 = i; i1 = i; break;
      case "e": break out;
      default: if (i0 > 0) i0 = 0; break;
    }
  }

  return i0 > 0 ? x.slice(0, i0) + x.slice(i1 + 1) : x;
});


/***/ }),
/* 161 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__formatDecimal__ = __webpack_require__(46);


/* harmony default export */ __webpack_exports__["a"] = (function(x, p) {
  var d = Object(__WEBPACK_IMPORTED_MODULE_0__formatDecimal__["a" /* default */])(x, p);
  if (!d) return x + "";
  var coefficient = d[0],
      exponent = d[1];
  return exponent < 0 ? "0." + new Array(-exponent).join("0") + coefficient
      : coefficient.length > exponent + 1 ? coefficient.slice(0, exponent + 1) + "." + coefficient.slice(exponent + 1)
      : coefficient + new Array(exponent - coefficient.length + 2).join("0");
});


/***/ }),
/* 162 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony default export */ __webpack_exports__["a"] = (function(x) {
  return x;
});


/***/ }),
/* 163 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__exponent__ = __webpack_require__(34);


/* harmony default export */ __webpack_exports__["a"] = (function(step) {
  return Math.max(0, -Object(__WEBPACK_IMPORTED_MODULE_0__exponent__["a" /* default */])(Math.abs(step)));
});


/***/ }),
/* 164 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__exponent__ = __webpack_require__(34);


/* harmony default export */ __webpack_exports__["a"] = (function(step, value) {
  return Math.max(0, Math.max(-8, Math.min(8, Math.floor(Object(__WEBPACK_IMPORTED_MODULE_0__exponent__["a" /* default */])(value) / 3))) * 3 - Object(__WEBPACK_IMPORTED_MODULE_0__exponent__["a" /* default */])(Math.abs(step)));
});


/***/ }),
/* 165 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__exponent__ = __webpack_require__(34);


/* harmony default export */ __webpack_exports__["a"] = (function(step, max) {
  step = Math.abs(step), max = Math.abs(max) - step;
  return Math.max(0, Object(__WEBPACK_IMPORTED_MODULE_0__exponent__["a" /* default */])(max) - Object(__WEBPACK_IMPORTED_MODULE_0__exponent__["a" /* default */])(step)) + 1;
});


/***/ }),
/* 166 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (immutable) */ __webpack_exports__["a"] = band;
/* harmony export (immutable) */ __webpack_exports__["b"] = point;
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_d3_array__ = __webpack_require__(1);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__ordinal__ = __webpack_require__(84);



function band() {
  var scale = Object(__WEBPACK_IMPORTED_MODULE_1__ordinal__["a" /* default */])().unknown(undefined),
      domain = scale.domain,
      ordinalRange = scale.range,
      range = [0, 1],
      step,
      bandwidth,
      round = false,
      paddingInner = 0,
      paddingOuter = 0,
      align = 0.5;

  delete scale.unknown;

  function rescale() {
    var n = domain().length,
        reverse = range[1] < range[0],
        start = range[reverse - 0],
        stop = range[1 - reverse];
    step = (stop - start) / Math.max(1, n - paddingInner + paddingOuter * 2);
    if (round) step = Math.floor(step);
    start += (stop - start - step * (n - paddingInner)) * align;
    bandwidth = step * (1 - paddingInner);
    if (round) start = Math.round(start), bandwidth = Math.round(bandwidth);
    var values = Object(__WEBPACK_IMPORTED_MODULE_0_d3_array__["range"])(n).map(function(i) { return start + step * i; });
    return ordinalRange(reverse ? values.reverse() : values);
  }

  scale.domain = function(_) {
    return arguments.length ? (domain(_), rescale()) : domain();
  };

  scale.range = function(_) {
    return arguments.length ? (range = [+_[0], +_[1]], rescale()) : range.slice();
  };

  scale.rangeRound = function(_) {
    return range = [+_[0], +_[1]], round = true, rescale();
  };

  scale.bandwidth = function() {
    return bandwidth;
  };

  scale.step = function() {
    return step;
  };

  scale.round = function(_) {
    return arguments.length ? (round = !!_, rescale()) : round;
  };

  scale.padding = function(_) {
    return arguments.length ? (paddingInner = paddingOuter = Math.max(0, Math.min(1, _)), rescale()) : paddingInner;
  };

  scale.paddingInner = function(_) {
    return arguments.length ? (paddingInner = Math.max(0, Math.min(1, _)), rescale()) : paddingInner;
  };

  scale.paddingOuter = function(_) {
    return arguments.length ? (paddingOuter = Math.max(0, Math.min(1, _)), rescale()) : paddingOuter;
  };

  scale.align = function(_) {
    return arguments.length ? (align = Math.max(0, Math.min(1, _)), rescale()) : align;
  };

  scale.copy = function() {
    return band()
        .domain(domain())
        .range(range)
        .round(round)
        .paddingInner(paddingInner)
        .paddingOuter(paddingOuter)
        .align(align);
  };

  return rescale();
}

function pointish(scale) {
  var copy = scale.copy;

  scale.padding = scale.paddingOuter;
  delete scale.paddingInner;
  delete scale.paddingOuter;

  scale.copy = function() {
    return pointish(copy());
  };

  return scale;
}

function point() {
  return pointish(band().paddingInner(1));
}


/***/ }),
/* 167 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__map__ = __webpack_require__(47);


/* harmony default export */ __webpack_exports__["a"] = (function() {
  var keys = [],
      sortKeys = [],
      sortValues,
      rollup,
      nest;

  function apply(array, depth, createResult, setResult) {
    if (depth >= keys.length) {
      if (sortValues != null) array.sort(sortValues);
      return rollup != null ? rollup(array) : array;
    }

    var i = -1,
        n = array.length,
        key = keys[depth++],
        keyValue,
        value,
        valuesByKey = Object(__WEBPACK_IMPORTED_MODULE_0__map__["a" /* default */])(),
        values,
        result = createResult();

    while (++i < n) {
      if (values = valuesByKey.get(keyValue = key(value = array[i]) + "")) {
        values.push(value);
      } else {
        valuesByKey.set(keyValue, [value]);
      }
    }

    valuesByKey.each(function(values, key) {
      setResult(result, key, apply(values, depth, createResult, setResult));
    });

    return result;
  }

  function entries(map, depth) {
    if (++depth > keys.length) return map;
    var array, sortKey = sortKeys[depth - 1];
    if (rollup != null && depth >= keys.length) array = map.entries();
    else array = [], map.each(function(v, k) { array.push({key: k, values: entries(v, depth)}); });
    return sortKey != null ? array.sort(function(a, b) { return sortKey(a.key, b.key); }) : array;
  }

  return nest = {
    object: function(array) { return apply(array, 0, createObject, setObject); },
    map: function(array) { return apply(array, 0, createMap, setMap); },
    entries: function(array) { return entries(apply(array, 0, createMap, setMap), 0); },
    key: function(d) { keys.push(d); return nest; },
    sortKeys: function(order) { sortKeys[keys.length - 1] = order; return nest; },
    sortValues: function(order) { sortValues = order; return nest; },
    rollup: function(f) { rollup = f; return nest; }
  };
});

function createObject() {
  return {};
}

function setObject(object, key, value) {
  object[key] = value;
}

function createMap() {
  return Object(__WEBPACK_IMPORTED_MODULE_0__map__["a" /* default */])();
}

function setMap(map, key, value) {
  map.set(key, value);
}


/***/ }),
/* 168 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__map__ = __webpack_require__(47);


function Set() {}

var proto = __WEBPACK_IMPORTED_MODULE_0__map__["a" /* default */].prototype;

Set.prototype = set.prototype = {
  constructor: Set,
  has: proto.has,
  add: function(value) {
    value += "";
    this[__WEBPACK_IMPORTED_MODULE_0__map__["b" /* prefix */] + value] = value;
    return this;
  },
  remove: proto.remove,
  clear: proto.clear,
  values: proto.keys,
  size: proto.size,
  empty: proto.empty,
  each: proto.each
};

function set(object, f) {
  var set = new Set;

  // Copy constructor.
  if (object instanceof Set) object.each(function(value) { set.add(value); });

  // Otherwise, assume it’s an array.
  else if (object) {
    var i = -1, n = object.length;
    if (f == null) while (++i < n) set.add(object[i]);
    else while (++i < n) set.add(f(object[i], i, object));
  }

  return set;
}

/* harmony default export */ __webpack_exports__["a"] = (set);


/***/ }),
/* 169 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony default export */ __webpack_exports__["a"] = (function(map) {
  var keys = [];
  for (var key in map) keys.push(key);
  return keys;
});


/***/ }),
/* 170 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony default export */ __webpack_exports__["a"] = (function(map) {
  var values = [];
  for (var key in map) values.push(map[key]);
  return values;
});


/***/ }),
/* 171 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony default export */ __webpack_exports__["a"] = (function(map) {
  var entries = [];
  for (var key in map) entries.push({key: key, value: map[key]});
  return entries;
});


/***/ }),
/* 172 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (immutable) */ __webpack_exports__["a"] = identity;
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__array__ = __webpack_require__(18);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__linear__ = __webpack_require__(28);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__number__ = __webpack_require__(92);




function identity() {
  var domain = [0, 1];

  function scale(x) {
    return +x;
  }

  scale.invert = scale;

  scale.domain = scale.range = function(_) {
    return arguments.length ? (domain = __WEBPACK_IMPORTED_MODULE_0__array__["a" /* map */].call(_, __WEBPACK_IMPORTED_MODULE_2__number__["a" /* default */]), scale) : domain.slice();
  };

  scale.copy = function() {
    return identity().domain(domain);
  };

  return Object(__WEBPACK_IMPORTED_MODULE_1__linear__["b" /* linearish */])(scale);
}


/***/ }),
/* 173 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony default export */ __webpack_exports__["a"] = (function(a, b) {
  return a = +a, b -= a, function(t) {
    return Math.round(a + b * t);
  };
});


/***/ }),
/* 174 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return interpolateTransformCss; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "b", function() { return interpolateTransformSvg; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__number__ = __webpack_require__(35);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__parse__ = __webpack_require__(175);



function interpolateTransform(parse, pxComma, pxParen, degParen) {

  function pop(s) {
    return s.length ? s.pop() + " " : "";
  }

  function translate(xa, ya, xb, yb, s, q) {
    if (xa !== xb || ya !== yb) {
      var i = s.push("translate(", null, pxComma, null, pxParen);
      q.push({i: i - 4, x: Object(__WEBPACK_IMPORTED_MODULE_0__number__["a" /* default */])(xa, xb)}, {i: i - 2, x: Object(__WEBPACK_IMPORTED_MODULE_0__number__["a" /* default */])(ya, yb)});
    } else if (xb || yb) {
      s.push("translate(" + xb + pxComma + yb + pxParen);
    }
  }

  function rotate(a, b, s, q) {
    if (a !== b) {
      if (a - b > 180) b += 360; else if (b - a > 180) a += 360; // shortest path
      q.push({i: s.push(pop(s) + "rotate(", null, degParen) - 2, x: Object(__WEBPACK_IMPORTED_MODULE_0__number__["a" /* default */])(a, b)});
    } else if (b) {
      s.push(pop(s) + "rotate(" + b + degParen);
    }
  }

  function skewX(a, b, s, q) {
    if (a !== b) {
      q.push({i: s.push(pop(s) + "skewX(", null, degParen) - 2, x: Object(__WEBPACK_IMPORTED_MODULE_0__number__["a" /* default */])(a, b)});
    } else if (b) {
      s.push(pop(s) + "skewX(" + b + degParen);
    }
  }

  function scale(xa, ya, xb, yb, s, q) {
    if (xa !== xb || ya !== yb) {
      var i = s.push(pop(s) + "scale(", null, ",", null, ")");
      q.push({i: i - 4, x: Object(__WEBPACK_IMPORTED_MODULE_0__number__["a" /* default */])(xa, xb)}, {i: i - 2, x: Object(__WEBPACK_IMPORTED_MODULE_0__number__["a" /* default */])(ya, yb)});
    } else if (xb !== 1 || yb !== 1) {
      s.push(pop(s) + "scale(" + xb + "," + yb + ")");
    }
  }

  return function(a, b) {
    var s = [], // string constants and placeholders
        q = []; // number interpolators
    a = parse(a), b = parse(b);
    translate(a.translateX, a.translateY, b.translateX, b.translateY, s, q);
    rotate(a.rotate, b.rotate, s, q);
    skewX(a.skewX, b.skewX, s, q);
    scale(a.scaleX, a.scaleY, b.scaleX, b.scaleY, s, q);
    a = b = null; // gc
    return function(t) {
      var i = -1, n = q.length, o;
      while (++i < n) s[(o = q[i]).i] = o.x(t);
      return s.join("");
    };
  };
}

var interpolateTransformCss = interpolateTransform(__WEBPACK_IMPORTED_MODULE_1__parse__["a" /* parseCss */], "px, ", "px)", "deg)");
var interpolateTransformSvg = interpolateTransform(__WEBPACK_IMPORTED_MODULE_1__parse__["b" /* parseSvg */], ", ", ")", ")");


/***/ }),
/* 175 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (immutable) */ __webpack_exports__["a"] = parseCss;
/* harmony export (immutable) */ __webpack_exports__["b"] = parseSvg;
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__decompose__ = __webpack_require__(176);


var cssNode,
    cssRoot,
    cssView,
    svgNode;

function parseCss(value) {
  if (value === "none") return __WEBPACK_IMPORTED_MODULE_0__decompose__["b" /* identity */];
  if (!cssNode) cssNode = document.createElement("DIV"), cssRoot = document.documentElement, cssView = document.defaultView;
  cssNode.style.transform = value;
  value = cssView.getComputedStyle(cssRoot.appendChild(cssNode), null).getPropertyValue("transform");
  cssRoot.removeChild(cssNode);
  value = value.slice(7, -1).split(",");
  return Object(__WEBPACK_IMPORTED_MODULE_0__decompose__["a" /* default */])(+value[0], +value[1], +value[2], +value[3], +value[4], +value[5]);
}

function parseSvg(value) {
  if (value == null) return __WEBPACK_IMPORTED_MODULE_0__decompose__["b" /* identity */];
  if (!svgNode) svgNode = document.createElementNS("http://www.w3.org/2000/svg", "g");
  svgNode.setAttribute("transform", value);
  if (!(value = svgNode.transform.baseVal.consolidate())) return __WEBPACK_IMPORTED_MODULE_0__decompose__["b" /* identity */];
  value = value.matrix;
  return Object(__WEBPACK_IMPORTED_MODULE_0__decompose__["a" /* default */])(value.a, value.b, value.c, value.d, value.e, value.f);
}


/***/ }),
/* 176 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "b", function() { return identity; });
var degrees = 180 / Math.PI;

var identity = {
  translateX: 0,
  translateY: 0,
  rotate: 0,
  skewX: 0,
  scaleX: 1,
  scaleY: 1
};

/* harmony default export */ __webpack_exports__["a"] = (function(a, b, c, d, e, f) {
  var scaleX, scaleY, skewX;
  if (scaleX = Math.sqrt(a * a + b * b)) a /= scaleX, b /= scaleX;
  if (skewX = a * c + b * d) c -= a * skewX, d -= b * skewX;
  if (scaleY = Math.sqrt(c * c + d * d)) c /= scaleY, d /= scaleY, skewX /= scaleY;
  if (a * d < b * c) a = -a, b = -b, skewX = -skewX, scaleX = -scaleX;
  return {
    translateX: e,
    translateY: f,
    rotate: Math.atan2(b, a) * degrees,
    skewX: Math.atan(skewX) * degrees,
    scaleX: scaleX,
    scaleY: scaleY
  };
});


/***/ }),
/* 177 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var rho = Math.SQRT2,
    rho2 = 2,
    rho4 = 4,
    epsilon2 = 1e-12;

function cosh(x) {
  return ((x = Math.exp(x)) + 1 / x) / 2;
}

function sinh(x) {
  return ((x = Math.exp(x)) - 1 / x) / 2;
}

function tanh(x) {
  return ((x = Math.exp(2 * x)) - 1) / (x + 1);
}

// p0 = [ux0, uy0, w0]
// p1 = [ux1, uy1, w1]
/* harmony default export */ __webpack_exports__["a"] = (function(p0, p1) {
  var ux0 = p0[0], uy0 = p0[1], w0 = p0[2],
      ux1 = p1[0], uy1 = p1[1], w1 = p1[2],
      dx = ux1 - ux0,
      dy = uy1 - uy0,
      d2 = dx * dx + dy * dy,
      i,
      S;

  // Special case for u0 ≅ u1.
  if (d2 < epsilon2) {
    S = Math.log(w1 / w0) / rho;
    i = function(t) {
      return [
        ux0 + t * dx,
        uy0 + t * dy,
        w0 * Math.exp(rho * t * S)
      ];
    }
  }

  // General case.
  else {
    var d1 = Math.sqrt(d2),
        b0 = (w1 * w1 - w0 * w0 + rho4 * d2) / (2 * w0 * rho2 * d1),
        b1 = (w1 * w1 - w0 * w0 - rho4 * d2) / (2 * w1 * rho2 * d1),
        r0 = Math.log(Math.sqrt(b0 * b0 + 1) - b0),
        r1 = Math.log(Math.sqrt(b1 * b1 + 1) - b1);
    S = (r1 - r0) / rho;
    i = function(t) {
      var s = t * S,
          coshr0 = cosh(r0),
          u = w0 / (rho2 * d1) * (coshr0 * tanh(rho * s + r0) - sinh(r0));
      return [
        ux0 + u * dx,
        uy0 + u * dy,
        w0 * coshr0 / cosh(rho * s + r0)
      ];
    }
  }

  i.duration = S * 1000;

  return i;
});


/***/ }),
/* 178 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "b", function() { return hslLong; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_d3_color__ = __webpack_require__(12);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__color__ = __webpack_require__(29);



function hsl(hue) {
  return function(start, end) {
    var h = hue((start = Object(__WEBPACK_IMPORTED_MODULE_0_d3_color__["hsl"])(start)).h, (end = Object(__WEBPACK_IMPORTED_MODULE_0_d3_color__["hsl"])(end)).h),
        s = Object(__WEBPACK_IMPORTED_MODULE_1__color__["a" /* default */])(start.s, end.s),
        l = Object(__WEBPACK_IMPORTED_MODULE_1__color__["a" /* default */])(start.l, end.l),
        opacity = Object(__WEBPACK_IMPORTED_MODULE_1__color__["a" /* default */])(start.opacity, end.opacity);
    return function(t) {
      start.h = h(t);
      start.s = s(t);
      start.l = l(t);
      start.opacity = opacity(t);
      return start + "";
    };
  }
}

/* harmony default export */ __webpack_exports__["a"] = (hsl(__WEBPACK_IMPORTED_MODULE_1__color__["c" /* hue */]));
var hslLong = hsl(__WEBPACK_IMPORTED_MODULE_1__color__["a" /* default */]);


/***/ }),
/* 179 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (immutable) */ __webpack_exports__["a"] = lab;
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_d3_color__ = __webpack_require__(12);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__color__ = __webpack_require__(29);



function lab(start, end) {
  var l = Object(__WEBPACK_IMPORTED_MODULE_1__color__["a" /* default */])((start = Object(__WEBPACK_IMPORTED_MODULE_0_d3_color__["lab"])(start)).l, (end = Object(__WEBPACK_IMPORTED_MODULE_0_d3_color__["lab"])(end)).l),
      a = Object(__WEBPACK_IMPORTED_MODULE_1__color__["a" /* default */])(start.a, end.a),
      b = Object(__WEBPACK_IMPORTED_MODULE_1__color__["a" /* default */])(start.b, end.b),
      opacity = Object(__WEBPACK_IMPORTED_MODULE_1__color__["a" /* default */])(start.opacity, end.opacity);
  return function(t) {
    start.l = l(t);
    start.a = a(t);
    start.b = b(t);
    start.opacity = opacity(t);
    return start + "";
  };
}


/***/ }),
/* 180 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "b", function() { return hclLong; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_d3_color__ = __webpack_require__(12);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__color__ = __webpack_require__(29);



function hcl(hue) {
  return function(start, end) {
    var h = hue((start = Object(__WEBPACK_IMPORTED_MODULE_0_d3_color__["hcl"])(start)).h, (end = Object(__WEBPACK_IMPORTED_MODULE_0_d3_color__["hcl"])(end)).h),
        c = Object(__WEBPACK_IMPORTED_MODULE_1__color__["a" /* default */])(start.c, end.c),
        l = Object(__WEBPACK_IMPORTED_MODULE_1__color__["a" /* default */])(start.l, end.l),
        opacity = Object(__WEBPACK_IMPORTED_MODULE_1__color__["a" /* default */])(start.opacity, end.opacity);
    return function(t) {
      start.h = h(t);
      start.c = c(t);
      start.l = l(t);
      start.opacity = opacity(t);
      return start + "";
    };
  }
}

/* harmony default export */ __webpack_exports__["a"] = (hcl(__WEBPACK_IMPORTED_MODULE_1__color__["c" /* hue */]));
var hclLong = hcl(__WEBPACK_IMPORTED_MODULE_1__color__["a" /* default */]);


/***/ }),
/* 181 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return cubehelixLong; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_d3_color__ = __webpack_require__(12);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__color__ = __webpack_require__(29);



function cubehelix(hue) {
  return (function cubehelixGamma(y) {
    y = +y;

    function cubehelix(start, end) {
      var h = hue((start = Object(__WEBPACK_IMPORTED_MODULE_0_d3_color__["cubehelix"])(start)).h, (end = Object(__WEBPACK_IMPORTED_MODULE_0_d3_color__["cubehelix"])(end)).h),
          s = Object(__WEBPACK_IMPORTED_MODULE_1__color__["a" /* default */])(start.s, end.s),
          l = Object(__WEBPACK_IMPORTED_MODULE_1__color__["a" /* default */])(start.l, end.l),
          opacity = Object(__WEBPACK_IMPORTED_MODULE_1__color__["a" /* default */])(start.opacity, end.opacity);
      return function(t) {
        start.h = h(t);
        start.s = s(t);
        start.l = l(Math.pow(t, y));
        start.opacity = opacity(t);
        return start + "";
      };
    }

    cubehelix.gamma = cubehelixGamma;

    return cubehelix;
  })(1);
}

/* harmony default export */ __webpack_exports__["b"] = (cubehelix(__WEBPACK_IMPORTED_MODULE_1__color__["c" /* hue */]));
var cubehelixLong = cubehelix(__WEBPACK_IMPORTED_MODULE_1__color__["a" /* default */]);


/***/ }),
/* 182 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony default export */ __webpack_exports__["a"] = (function(interpolator, n) {
  var samples = new Array(n);
  for (var i = 0; i < n; ++i) samples[i] = interpolator(i / (n - 1));
  return samples;
});


/***/ }),
/* 183 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_d3_array__ = __webpack_require__(1);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_d3_format__ = __webpack_require__(7);



/* harmony default export */ __webpack_exports__["a"] = (function(domain, count, specifier) {
  var start = domain[0],
      stop = domain[domain.length - 1],
      step = Object(__WEBPACK_IMPORTED_MODULE_0_d3_array__["tickStep"])(start, stop, count == null ? 10 : count),
      precision;
  specifier = Object(__WEBPACK_IMPORTED_MODULE_1_d3_format__["formatSpecifier"])(specifier == null ? ",f" : specifier);
  switch (specifier.type) {
    case "s": {
      var value = Math.max(Math.abs(start), Math.abs(stop));
      if (specifier.precision == null && !isNaN(precision = Object(__WEBPACK_IMPORTED_MODULE_1_d3_format__["precisionPrefix"])(step, value))) specifier.precision = precision;
      return Object(__WEBPACK_IMPORTED_MODULE_1_d3_format__["formatPrefix"])(specifier, value);
    }
    case "":
    case "e":
    case "g":
    case "p":
    case "r": {
      if (specifier.precision == null && !isNaN(precision = Object(__WEBPACK_IMPORTED_MODULE_1_d3_format__["precisionRound"])(step, Math.max(Math.abs(start), Math.abs(stop))))) specifier.precision = precision - (specifier.type === "e");
      break;
    }
    case "f":
    case "%": {
      if (specifier.precision == null && !isNaN(precision = Object(__WEBPACK_IMPORTED_MODULE_1_d3_format__["precisionFixed"])(step))) specifier.precision = precision - (specifier.type === "%") * 2;
      break;
    }
  }
  return Object(__WEBPACK_IMPORTED_MODULE_1_d3_format__["format"])(specifier);
});


/***/ }),
/* 184 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (immutable) */ __webpack_exports__["a"] = log;
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_d3_array__ = __webpack_require__(1);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_d3_format__ = __webpack_require__(7);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__constant__ = __webpack_require__(50);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__nice__ = __webpack_require__(93);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__continuous__ = __webpack_require__(36);






function deinterpolate(a, b) {
  return (b = Math.log(b / a))
      ? function(x) { return Math.log(x / a) / b; }
      : Object(__WEBPACK_IMPORTED_MODULE_2__constant__["a" /* default */])(b);
}

function reinterpolate(a, b) {
  return a < 0
      ? function(t) { return -Math.pow(-b, t) * Math.pow(-a, 1 - t); }
      : function(t) { return Math.pow(b, t) * Math.pow(a, 1 - t); };
}

function pow10(x) {
  return isFinite(x) ? +("1e" + x) : x < 0 ? 0 : x;
}

function powp(base) {
  return base === 10 ? pow10
      : base === Math.E ? Math.exp
      : function(x) { return Math.pow(base, x); };
}

function logp(base) {
  return base === Math.E ? Math.log
      : base === 10 && Math.log10
      || base === 2 && Math.log2
      || (base = Math.log(base), function(x) { return Math.log(x) / base; });
}

function reflect(f) {
  return function(x) {
    return -f(-x);
  };
}

function log() {
  var scale = Object(__WEBPACK_IMPORTED_MODULE_4__continuous__["b" /* default */])(deinterpolate, reinterpolate).domain([1, 10]),
      domain = scale.domain,
      base = 10,
      logs = logp(10),
      pows = powp(10);

  function rescale() {
    logs = logp(base), pows = powp(base);
    if (domain()[0] < 0) logs = reflect(logs), pows = reflect(pows);
    return scale;
  }

  scale.base = function(_) {
    return arguments.length ? (base = +_, rescale()) : base;
  };

  scale.domain = function(_) {
    return arguments.length ? (domain(_), rescale()) : domain();
  };

  scale.ticks = function(count) {
    var d = domain(),
        u = d[0],
        v = d[d.length - 1],
        r;

    if (r = v < u) i = u, u = v, v = i;

    var i = logs(u),
        j = logs(v),
        p,
        k,
        t,
        n = count == null ? 10 : +count,
        z = [];

    if (!(base % 1) && j - i < n) {
      i = Math.round(i) - 1, j = Math.round(j) + 1;
      if (u > 0) for (; i < j; ++i) {
        for (k = 1, p = pows(i); k < base; ++k) {
          t = p * k;
          if (t < u) continue;
          if (t > v) break;
          z.push(t);
        }
      } else for (; i < j; ++i) {
        for (k = base - 1, p = pows(i); k >= 1; --k) {
          t = p * k;
          if (t < u) continue;
          if (t > v) break;
          z.push(t);
        }
      }
    } else {
      z = Object(__WEBPACK_IMPORTED_MODULE_0_d3_array__["ticks"])(i, j, Math.min(j - i, n)).map(pows);
    }

    return r ? z.reverse() : z;
  };

  scale.tickFormat = function(count, specifier) {
    if (specifier == null) specifier = base === 10 ? ".0e" : ",";
    if (typeof specifier !== "function") specifier = Object(__WEBPACK_IMPORTED_MODULE_1_d3_format__["format"])(specifier);
    if (count === Infinity) return specifier;
    if (count == null) count = 10;
    var k = Math.max(1, base * count / scale.ticks().length); // TODO fast estimate?
    return function(d) {
      var i = d / pows(Math.round(logs(d)));
      if (i * base < base - 0.5) i *= base;
      return i <= k ? specifier(d) : "";
    };
  };

  scale.nice = function() {
    return domain(Object(__WEBPACK_IMPORTED_MODULE_3__nice__["a" /* default */])(domain(), {
      floor: function(x) { return pows(Math.floor(logs(x))); },
      ceil: function(x) { return pows(Math.ceil(logs(x))); }
    }));
  };

  scale.copy = function() {
    return Object(__WEBPACK_IMPORTED_MODULE_4__continuous__["a" /* copy */])(scale, log().base(base));
  };

  return scale;
}


/***/ }),
/* 185 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (immutable) */ __webpack_exports__["a"] = pow;
/* harmony export (immutable) */ __webpack_exports__["b"] = sqrt;
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__constant__ = __webpack_require__(50);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__linear__ = __webpack_require__(28);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__continuous__ = __webpack_require__(36);




function raise(x, exponent) {
  return x < 0 ? -Math.pow(-x, exponent) : Math.pow(x, exponent);
}

function pow() {
  var exponent = 1,
      scale = Object(__WEBPACK_IMPORTED_MODULE_2__continuous__["b" /* default */])(deinterpolate, reinterpolate),
      domain = scale.domain;

  function deinterpolate(a, b) {
    return (b = raise(b, exponent) - (a = raise(a, exponent)))
        ? function(x) { return (raise(x, exponent) - a) / b; }
        : Object(__WEBPACK_IMPORTED_MODULE_0__constant__["a" /* default */])(b);
  }

  function reinterpolate(a, b) {
    b = raise(b, exponent) - (a = raise(a, exponent));
    return function(t) { return raise(a + b * t, 1 / exponent); };
  }

  scale.exponent = function(_) {
    return arguments.length ? (exponent = +_, domain(domain())) : exponent;
  };

  scale.copy = function() {
    return Object(__WEBPACK_IMPORTED_MODULE_2__continuous__["a" /* copy */])(scale, pow().exponent(exponent));
  };

  return Object(__WEBPACK_IMPORTED_MODULE_1__linear__["b" /* linearish */])(scale);
}

function sqrt() {
  return pow().exponent(0.5);
}


/***/ }),
/* 186 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (immutable) */ __webpack_exports__["a"] = quantile;
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_d3_array__ = __webpack_require__(1);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__array__ = __webpack_require__(18);



function quantile() {
  var domain = [],
      range = [],
      thresholds = [];

  function rescale() {
    var i = 0, n = Math.max(1, range.length);
    thresholds = new Array(n - 1);
    while (++i < n) thresholds[i - 1] = Object(__WEBPACK_IMPORTED_MODULE_0_d3_array__["quantile"])(domain, i / n);
    return scale;
  }

  function scale(x) {
    if (!isNaN(x = +x)) return range[Object(__WEBPACK_IMPORTED_MODULE_0_d3_array__["bisect"])(thresholds, x)];
  }

  scale.invertExtent = function(y) {
    var i = range.indexOf(y);
    return i < 0 ? [NaN, NaN] : [
      i > 0 ? thresholds[i - 1] : domain[0],
      i < thresholds.length ? thresholds[i] : domain[domain.length - 1]
    ];
  };

  scale.domain = function(_) {
    if (!arguments.length) return domain.slice();
    domain = [];
    for (var i = 0, n = _.length, d; i < n; ++i) if (d = _[i], d != null && !isNaN(d = +d)) domain.push(d);
    domain.sort(__WEBPACK_IMPORTED_MODULE_0_d3_array__["ascending"]);
    return rescale();
  };

  scale.range = function(_) {
    return arguments.length ? (range = __WEBPACK_IMPORTED_MODULE_1__array__["b" /* slice */].call(_), rescale()) : range.slice();
  };

  scale.quantiles = function() {
    return thresholds.slice();
  };

  scale.copy = function() {
    return quantile()
        .domain(domain)
        .range(range);
  };

  return scale;
}


/***/ }),
/* 187 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (immutable) */ __webpack_exports__["a"] = quantize;
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_d3_array__ = __webpack_require__(1);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__array__ = __webpack_require__(18);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__linear__ = __webpack_require__(28);




function quantize() {
  var x0 = 0,
      x1 = 1,
      n = 1,
      domain = [0.5],
      range = [0, 1];

  function scale(x) {
    if (x <= x) return range[Object(__WEBPACK_IMPORTED_MODULE_0_d3_array__["bisect"])(domain, x, 0, n)];
  }

  function rescale() {
    var i = -1;
    domain = new Array(n);
    while (++i < n) domain[i] = ((i + 1) * x1 - (i - n) * x0) / (n + 1);
    return scale;
  }

  scale.domain = function(_) {
    return arguments.length ? (x0 = +_[0], x1 = +_[1], rescale()) : [x0, x1];
  };

  scale.range = function(_) {
    return arguments.length ? (n = (range = __WEBPACK_IMPORTED_MODULE_1__array__["b" /* slice */].call(_)).length - 1, rescale()) : range.slice();
  };

  scale.invertExtent = function(y) {
    var i = range.indexOf(y);
    return i < 0 ? [NaN, NaN]
        : i < 1 ? [x0, domain[0]]
        : i >= n ? [domain[n - 1], x1]
        : [domain[i - 1], domain[i]];
  };

  scale.copy = function() {
    return quantize()
        .domain([x0, x1])
        .range(range);
  };

  return Object(__WEBPACK_IMPORTED_MODULE_2__linear__["b" /* linearish */])(scale);
}


/***/ }),
/* 188 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (immutable) */ __webpack_exports__["a"] = threshold;
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_d3_array__ = __webpack_require__(1);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__array__ = __webpack_require__(18);



function threshold() {
  var domain = [0.5],
      range = [0, 1],
      n = 1;

  function scale(x) {
    if (x <= x) return range[Object(__WEBPACK_IMPORTED_MODULE_0_d3_array__["bisect"])(domain, x, 0, n)];
  }

  scale.domain = function(_) {
    return arguments.length ? (domain = __WEBPACK_IMPORTED_MODULE_1__array__["b" /* slice */].call(_), n = Math.min(domain.length, range.length - 1), scale) : domain.slice();
  };

  scale.range = function(_) {
    return arguments.length ? (range = __WEBPACK_IMPORTED_MODULE_1__array__["b" /* slice */].call(_), n = Math.min(domain.length, range.length - 1), scale) : range.slice();
  };

  scale.invertExtent = function(y) {
    var i = range.indexOf(y);
    return [domain[i - 1], domain[i]];
  };

  scale.copy = function() {
    return threshold()
        .domain(domain)
        .range(range);
  };

  return scale;
}


/***/ }),
/* 189 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "b", function() { return milliseconds; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__interval__ = __webpack_require__(2);


var millisecond = Object(__WEBPACK_IMPORTED_MODULE_0__interval__["a" /* default */])(function() {
  // noop
}, function(date, step) {
  date.setTime(+date + step);
}, function(start, end) {
  return end - start;
});

// An optimized implementation for this simple case.
millisecond.every = function(k) {
  k = Math.floor(k);
  if (!isFinite(k) || !(k > 0)) return null;
  if (!(k > 1)) return millisecond;
  return Object(__WEBPACK_IMPORTED_MODULE_0__interval__["a" /* default */])(function(date) {
    date.setTime(Math.floor(date / k) * k);
  }, function(date, step) {
    date.setTime(+date + step * k);
  }, function(start, end) {
    return (end - start) / k;
  });
};

/* harmony default export */ __webpack_exports__["a"] = (millisecond);
var milliseconds = millisecond.range;


/***/ }),
/* 190 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "b", function() { return seconds; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__interval__ = __webpack_require__(2);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__duration__ = __webpack_require__(14);



var second = Object(__WEBPACK_IMPORTED_MODULE_0__interval__["a" /* default */])(function(date) {
  date.setTime(Math.floor(date / __WEBPACK_IMPORTED_MODULE_1__duration__["d" /* durationSecond */]) * __WEBPACK_IMPORTED_MODULE_1__duration__["d" /* durationSecond */]);
}, function(date, step) {
  date.setTime(+date + step * __WEBPACK_IMPORTED_MODULE_1__duration__["d" /* durationSecond */]);
}, function(start, end) {
  return (end - start) / __WEBPACK_IMPORTED_MODULE_1__duration__["d" /* durationSecond */];
}, function(date) {
  return date.getUTCSeconds();
});

/* harmony default export */ __webpack_exports__["a"] = (second);
var seconds = second.range;


/***/ }),
/* 191 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "b", function() { return minutes; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__interval__ = __webpack_require__(2);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__duration__ = __webpack_require__(14);



var minute = Object(__WEBPACK_IMPORTED_MODULE_0__interval__["a" /* default */])(function(date) {
  date.setTime(Math.floor(date / __WEBPACK_IMPORTED_MODULE_1__duration__["c" /* durationMinute */]) * __WEBPACK_IMPORTED_MODULE_1__duration__["c" /* durationMinute */]);
}, function(date, step) {
  date.setTime(+date + step * __WEBPACK_IMPORTED_MODULE_1__duration__["c" /* durationMinute */]);
}, function(start, end) {
  return (end - start) / __WEBPACK_IMPORTED_MODULE_1__duration__["c" /* durationMinute */];
}, function(date) {
  return date.getMinutes();
});

/* harmony default export */ __webpack_exports__["a"] = (minute);
var minutes = minute.range;


/***/ }),
/* 192 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "b", function() { return hours; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__interval__ = __webpack_require__(2);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__duration__ = __webpack_require__(14);



var hour = Object(__WEBPACK_IMPORTED_MODULE_0__interval__["a" /* default */])(function(date) {
  var offset = date.getTimezoneOffset() * __WEBPACK_IMPORTED_MODULE_1__duration__["c" /* durationMinute */] % __WEBPACK_IMPORTED_MODULE_1__duration__["b" /* durationHour */];
  if (offset < 0) offset += __WEBPACK_IMPORTED_MODULE_1__duration__["b" /* durationHour */];
  date.setTime(Math.floor((+date - offset) / __WEBPACK_IMPORTED_MODULE_1__duration__["b" /* durationHour */]) * __WEBPACK_IMPORTED_MODULE_1__duration__["b" /* durationHour */] + offset);
}, function(date, step) {
  date.setTime(+date + step * __WEBPACK_IMPORTED_MODULE_1__duration__["b" /* durationHour */]);
}, function(start, end) {
  return (end - start) / __WEBPACK_IMPORTED_MODULE_1__duration__["b" /* durationHour */];
}, function(date) {
  return date.getHours();
});

/* harmony default export */ __webpack_exports__["a"] = (hour);
var hours = hour.range;


/***/ }),
/* 193 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return days; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__interval__ = __webpack_require__(2);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__duration__ = __webpack_require__(14);



var day = Object(__WEBPACK_IMPORTED_MODULE_0__interval__["a" /* default */])(function(date) {
  date.setHours(0, 0, 0, 0);
}, function(date, step) {
  date.setDate(date.getDate() + step);
}, function(start, end) {
  return (end - start - (end.getTimezoneOffset() - start.getTimezoneOffset()) * __WEBPACK_IMPORTED_MODULE_1__duration__["c" /* durationMinute */]) / __WEBPACK_IMPORTED_MODULE_1__duration__["a" /* durationDay */];
}, function(date) {
  return date.getDate() - 1;
});

/* harmony default export */ __webpack_exports__["b"] = (day);
var days = day.range;


/***/ }),
/* 194 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "g", function() { return sunday; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "c", function() { return monday; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "k", function() { return tuesday; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "m", function() { return wednesday; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "i", function() { return thursday; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return friday; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "e", function() { return saturday; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "h", function() { return sundays; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "d", function() { return mondays; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "l", function() { return tuesdays; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "n", function() { return wednesdays; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "j", function() { return thursdays; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "b", function() { return fridays; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "f", function() { return saturdays; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__interval__ = __webpack_require__(2);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__duration__ = __webpack_require__(14);



function weekday(i) {
  return Object(__WEBPACK_IMPORTED_MODULE_0__interval__["a" /* default */])(function(date) {
    date.setDate(date.getDate() - (date.getDay() + 7 - i) % 7);
    date.setHours(0, 0, 0, 0);
  }, function(date, step) {
    date.setDate(date.getDate() + step * 7);
  }, function(start, end) {
    return (end - start - (end.getTimezoneOffset() - start.getTimezoneOffset()) * __WEBPACK_IMPORTED_MODULE_1__duration__["c" /* durationMinute */]) / __WEBPACK_IMPORTED_MODULE_1__duration__["e" /* durationWeek */];
  });
}

var sunday = weekday(0);
var monday = weekday(1);
var tuesday = weekday(2);
var wednesday = weekday(3);
var thursday = weekday(4);
var friday = weekday(5);
var saturday = weekday(6);

var sundays = sunday.range;
var mondays = monday.range;
var tuesdays = tuesday.range;
var wednesdays = wednesday.range;
var thursdays = thursday.range;
var fridays = friday.range;
var saturdays = saturday.range;


/***/ }),
/* 195 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "b", function() { return months; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__interval__ = __webpack_require__(2);


var month = Object(__WEBPACK_IMPORTED_MODULE_0__interval__["a" /* default */])(function(date) {
  date.setDate(1);
  date.setHours(0, 0, 0, 0);
}, function(date, step) {
  date.setMonth(date.getMonth() + step);
}, function(start, end) {
  return end.getMonth() - start.getMonth() + (end.getFullYear() - start.getFullYear()) * 12;
}, function(date) {
  return date.getMonth();
});

/* harmony default export */ __webpack_exports__["a"] = (month);
var months = month.range;


/***/ }),
/* 196 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "b", function() { return years; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__interval__ = __webpack_require__(2);


var year = Object(__WEBPACK_IMPORTED_MODULE_0__interval__["a" /* default */])(function(date) {
  date.setMonth(0, 1);
  date.setHours(0, 0, 0, 0);
}, function(date, step) {
  date.setFullYear(date.getFullYear() + step);
}, function(start, end) {
  return end.getFullYear() - start.getFullYear();
}, function(date) {
  return date.getFullYear();
});

// An optimized implementation for this simple case.
year.every = function(k) {
  return !isFinite(k = Math.floor(k)) || !(k > 0) ? null : Object(__WEBPACK_IMPORTED_MODULE_0__interval__["a" /* default */])(function(date) {
    date.setFullYear(Math.floor(date.getFullYear() / k) * k);
    date.setMonth(0, 1);
    date.setHours(0, 0, 0, 0);
  }, function(date, step) {
    date.setFullYear(date.getFullYear() + step * k);
  });
};

/* harmony default export */ __webpack_exports__["a"] = (year);
var years = year.range;


/***/ }),
/* 197 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "b", function() { return utcMinutes; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__interval__ = __webpack_require__(2);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__duration__ = __webpack_require__(14);



var utcMinute = Object(__WEBPACK_IMPORTED_MODULE_0__interval__["a" /* default */])(function(date) {
  date.setUTCSeconds(0, 0);
}, function(date, step) {
  date.setTime(+date + step * __WEBPACK_IMPORTED_MODULE_1__duration__["c" /* durationMinute */]);
}, function(start, end) {
  return (end - start) / __WEBPACK_IMPORTED_MODULE_1__duration__["c" /* durationMinute */];
}, function(date) {
  return date.getUTCMinutes();
});

/* harmony default export */ __webpack_exports__["a"] = (utcMinute);
var utcMinutes = utcMinute.range;


/***/ }),
/* 198 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "b", function() { return utcHours; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__interval__ = __webpack_require__(2);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__duration__ = __webpack_require__(14);



var utcHour = Object(__WEBPACK_IMPORTED_MODULE_0__interval__["a" /* default */])(function(date) {
  date.setUTCMinutes(0, 0, 0);
}, function(date, step) {
  date.setTime(+date + step * __WEBPACK_IMPORTED_MODULE_1__duration__["b" /* durationHour */]);
}, function(start, end) {
  return (end - start) / __WEBPACK_IMPORTED_MODULE_1__duration__["b" /* durationHour */];
}, function(date) {
  return date.getUTCHours();
});

/* harmony default export */ __webpack_exports__["a"] = (utcHour);
var utcHours = utcHour.range;


/***/ }),
/* 199 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "b", function() { return utcDays; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__interval__ = __webpack_require__(2);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__duration__ = __webpack_require__(14);



var utcDay = Object(__WEBPACK_IMPORTED_MODULE_0__interval__["a" /* default */])(function(date) {
  date.setUTCHours(0, 0, 0, 0);
}, function(date, step) {
  date.setUTCDate(date.getUTCDate() + step);
}, function(start, end) {
  return (end - start) / __WEBPACK_IMPORTED_MODULE_1__duration__["a" /* durationDay */];
}, function(date) {
  return date.getUTCDate() - 1;
});

/* harmony default export */ __webpack_exports__["a"] = (utcDay);
var utcDays = utcDay.range;


/***/ }),
/* 200 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "g", function() { return utcSunday; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "c", function() { return utcMonday; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "k", function() { return utcTuesday; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "m", function() { return utcWednesday; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "i", function() { return utcThursday; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return utcFriday; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "e", function() { return utcSaturday; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "h", function() { return utcSundays; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "d", function() { return utcMondays; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "l", function() { return utcTuesdays; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "n", function() { return utcWednesdays; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "j", function() { return utcThursdays; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "b", function() { return utcFridays; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "f", function() { return utcSaturdays; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__interval__ = __webpack_require__(2);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__duration__ = __webpack_require__(14);



function utcWeekday(i) {
  return Object(__WEBPACK_IMPORTED_MODULE_0__interval__["a" /* default */])(function(date) {
    date.setUTCDate(date.getUTCDate() - (date.getUTCDay() + 7 - i) % 7);
    date.setUTCHours(0, 0, 0, 0);
  }, function(date, step) {
    date.setUTCDate(date.getUTCDate() + step * 7);
  }, function(start, end) {
    return (end - start) / __WEBPACK_IMPORTED_MODULE_1__duration__["e" /* durationWeek */];
  });
}

var utcSunday = utcWeekday(0);
var utcMonday = utcWeekday(1);
var utcTuesday = utcWeekday(2);
var utcWednesday = utcWeekday(3);
var utcThursday = utcWeekday(4);
var utcFriday = utcWeekday(5);
var utcSaturday = utcWeekday(6);

var utcSundays = utcSunday.range;
var utcMondays = utcMonday.range;
var utcTuesdays = utcTuesday.range;
var utcWednesdays = utcWednesday.range;
var utcThursdays = utcThursday.range;
var utcFridays = utcFriday.range;
var utcSaturdays = utcSaturday.range;


/***/ }),
/* 201 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "b", function() { return utcMonths; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__interval__ = __webpack_require__(2);


var utcMonth = Object(__WEBPACK_IMPORTED_MODULE_0__interval__["a" /* default */])(function(date) {
  date.setUTCDate(1);
  date.setUTCHours(0, 0, 0, 0);
}, function(date, step) {
  date.setUTCMonth(date.getUTCMonth() + step);
}, function(start, end) {
  return end.getUTCMonth() - start.getUTCMonth() + (end.getUTCFullYear() - start.getUTCFullYear()) * 12;
}, function(date) {
  return date.getUTCMonth();
});

/* harmony default export */ __webpack_exports__["a"] = (utcMonth);
var utcMonths = utcMonth.range;


/***/ }),
/* 202 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "b", function() { return utcYears; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__interval__ = __webpack_require__(2);


var utcYear = Object(__WEBPACK_IMPORTED_MODULE_0__interval__["a" /* default */])(function(date) {
  date.setUTCMonth(0, 1);
  date.setUTCHours(0, 0, 0, 0);
}, function(date, step) {
  date.setUTCFullYear(date.getUTCFullYear() + step);
}, function(start, end) {
  return end.getUTCFullYear() - start.getUTCFullYear();
}, function(date) {
  return date.getUTCFullYear();
});

// An optimized implementation for this simple case.
utcYear.every = function(k) {
  return !isFinite(k = Math.floor(k)) || !(k > 0) ? null : Object(__WEBPACK_IMPORTED_MODULE_0__interval__["a" /* default */])(function(date) {
    date.setUTCFullYear(Math.floor(date.getUTCFullYear() / k) * k);
    date.setUTCMonth(0, 1);
    date.setUTCHours(0, 0, 0, 0);
  }, function(date, step) {
    date.setUTCFullYear(date.getUTCFullYear() + step * k);
  });
};

/* harmony default export */ __webpack_exports__["a"] = (utcYear);
var utcYears = utcYear.range;


/***/ }),
/* 203 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__isoFormat__ = __webpack_require__(96);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__defaultLocale__ = __webpack_require__(51);



function parseIsoNative(string) {
  var date = new Date(string);
  return isNaN(date) ? null : date;
}

var parseIso = +new Date("2000-01-01T00:00:00.000Z")
    ? parseIsoNative
    : Object(__WEBPACK_IMPORTED_MODULE_1__defaultLocale__["e" /* utcParse */])(__WEBPACK_IMPORTED_MODULE_0__isoFormat__["b" /* isoSpecifier */]);

/* harmony default export */ __webpack_exports__["a"] = (parseIso);


/***/ }),
/* 204 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__time__ = __webpack_require__(94);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_d3_time_format__ = __webpack_require__(19);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2_d3_time__ = __webpack_require__(25);




/* harmony default export */ __webpack_exports__["a"] = (function() {
  return Object(__WEBPACK_IMPORTED_MODULE_0__time__["a" /* calendar */])(__WEBPACK_IMPORTED_MODULE_2_d3_time__["utcYear"], __WEBPACK_IMPORTED_MODULE_2_d3_time__["utcMonth"], __WEBPACK_IMPORTED_MODULE_2_d3_time__["utcWeek"], __WEBPACK_IMPORTED_MODULE_2_d3_time__["utcDay"], __WEBPACK_IMPORTED_MODULE_2_d3_time__["utcHour"], __WEBPACK_IMPORTED_MODULE_2_d3_time__["utcMinute"], __WEBPACK_IMPORTED_MODULE_2_d3_time__["utcSecond"], __WEBPACK_IMPORTED_MODULE_2_d3_time__["utcMillisecond"], __WEBPACK_IMPORTED_MODULE_1_d3_time_format__["utcFormat"]).domain([Date.UTC(2000, 0, 1), Date.UTC(2000, 0, 2)]);
});


/***/ }),
/* 205 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (immutable) */ __webpack_exports__["a"] = sequential;
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__linear__ = __webpack_require__(28);


function sequential(interpolator) {
  var x0 = 0,
      x1 = 1,
      clamp = false;

  function scale(x) {
    var t = (x - x0) / (x1 - x0);
    return interpolator(clamp ? Math.max(0, Math.min(1, t)) : t);
  }

  scale.domain = function(_) {
    return arguments.length ? (x0 = +_[0], x1 = +_[1], scale) : [x0, x1];
  };

  scale.clamp = function(_) {
    return arguments.length ? (clamp = !!_, scale) : clamp;
  };

  scale.interpolator = function(_) {
    return arguments.length ? (interpolator = _, scale) : interpolator;
  };

  scale.copy = function() {
    return sequential(interpolator).domain([x0, x1]).clamp(clamp);
  };

  return Object(__WEBPACK_IMPORTED_MODULE_0__linear__["b" /* linearish */])(scale);
}


/***/ }),
/* 206 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (immutable) */ __webpack_exports__["a"] = local;
var nextId = 0;

function local() {
  return new Local;
}

function Local() {
  this._ = "@" + (++nextId).toString(36);
}

Local.prototype = local.prototype = {
  constructor: Local,
  get: function(node) {
    var id = this._;
    while (!(id in node)) if (!(node = node.parentNode)) return;
    return node[id];
  },
  set: function(node, value) {
    return node[this._] = value;
  },
  remove: function(node) {
    return this._ in node && delete node[this._];
  },
  toString: function() {
    return this._;
  }
};


/***/ }),
/* 207 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__sourceEvent__ = __webpack_require__(55);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__point__ = __webpack_require__(57);



/* harmony default export */ __webpack_exports__["a"] = (function(node) {
  var event = Object(__WEBPACK_IMPORTED_MODULE_0__sourceEvent__["a" /* default */])();
  if (event.changedTouches) event = event.changedTouches[0];
  return Object(__WEBPACK_IMPORTED_MODULE_1__point__["a" /* default */])(node, event);
});


/***/ }),
/* 208 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__selection_index__ = __webpack_require__(10);


/* harmony default export */ __webpack_exports__["a"] = (function(selector) {
  return typeof selector === "string"
      ? new __WEBPACK_IMPORTED_MODULE_0__selection_index__["a" /* Selection */]([[document.querySelector(selector)]], [document.documentElement])
      : new __WEBPACK_IMPORTED_MODULE_0__selection_index__["a" /* Selection */]([[selector]], __WEBPACK_IMPORTED_MODULE_0__selection_index__["c" /* root */]);
});


/***/ }),
/* 209 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__index__ = __webpack_require__(10);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__selector__ = __webpack_require__(58);



/* harmony default export */ __webpack_exports__["a"] = (function(select) {
  if (typeof select !== "function") select = Object(__WEBPACK_IMPORTED_MODULE_1__selector__["a" /* default */])(select);

  for (var groups = this._groups, m = groups.length, subgroups = new Array(m), j = 0; j < m; ++j) {
    for (var group = groups[j], n = group.length, subgroup = subgroups[j] = new Array(n), node, subnode, i = 0; i < n; ++i) {
      if ((node = group[i]) && (subnode = select.call(node, node.__data__, i, group))) {
        if ("__data__" in node) subnode.__data__ = node.__data__;
        subgroup[i] = subnode;
      }
    }
  }

  return new __WEBPACK_IMPORTED_MODULE_0__index__["a" /* Selection */](subgroups, this._parents);
});


/***/ }),
/* 210 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__index__ = __webpack_require__(10);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__selectorAll__ = __webpack_require__(98);



/* harmony default export */ __webpack_exports__["a"] = (function(select) {
  if (typeof select !== "function") select = Object(__WEBPACK_IMPORTED_MODULE_1__selectorAll__["a" /* default */])(select);

  for (var groups = this._groups, m = groups.length, subgroups = [], parents = [], j = 0; j < m; ++j) {
    for (var group = groups[j], n = group.length, node, i = 0; i < n; ++i) {
      if (node = group[i]) {
        subgroups.push(select.call(node, node.__data__, i, group));
        parents.push(node);
      }
    }
  }

  return new __WEBPACK_IMPORTED_MODULE_0__index__["a" /* Selection */](subgroups, parents);
});


/***/ }),
/* 211 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__index__ = __webpack_require__(10);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__matcher__ = __webpack_require__(97);



/* harmony default export */ __webpack_exports__["a"] = (function(match) {
  if (typeof match !== "function") match = Object(__WEBPACK_IMPORTED_MODULE_1__matcher__["a" /* default */])(match);

  for (var groups = this._groups, m = groups.length, subgroups = new Array(m), j = 0; j < m; ++j) {
    for (var group = groups[j], n = group.length, subgroup = subgroups[j] = [], node, i = 0; i < n; ++i) {
      if ((node = group[i]) && match.call(node, node.__data__, i, group)) {
        subgroup.push(node);
      }
    }
  }

  return new __WEBPACK_IMPORTED_MODULE_0__index__["a" /* Selection */](subgroups, this._parents);
});


/***/ }),
/* 212 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__index__ = __webpack_require__(10);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__enter__ = __webpack_require__(99);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__constant__ = __webpack_require__(213);




var keyPrefix = "$"; // Protect against keys like “__proto__”.

function bindIndex(parent, group, enter, update, exit, data) {
  var i = 0,
      node,
      groupLength = group.length,
      dataLength = data.length;

  // Put any non-null nodes that fit into update.
  // Put any null nodes into enter.
  // Put any remaining data into enter.
  for (; i < dataLength; ++i) {
    if (node = group[i]) {
      node.__data__ = data[i];
      update[i] = node;
    } else {
      enter[i] = new __WEBPACK_IMPORTED_MODULE_1__enter__["a" /* EnterNode */](parent, data[i]);
    }
  }

  // Put any non-null nodes that don’t fit into exit.
  for (; i < groupLength; ++i) {
    if (node = group[i]) {
      exit[i] = node;
    }
  }
}

function bindKey(parent, group, enter, update, exit, data, key) {
  var i,
      node,
      nodeByKeyValue = {},
      groupLength = group.length,
      dataLength = data.length,
      keyValues = new Array(groupLength),
      keyValue;

  // Compute the key for each node.
  // If multiple nodes have the same key, the duplicates are added to exit.
  for (i = 0; i < groupLength; ++i) {
    if (node = group[i]) {
      keyValues[i] = keyValue = keyPrefix + key.call(node, node.__data__, i, group);
      if (keyValue in nodeByKeyValue) {
        exit[i] = node;
      } else {
        nodeByKeyValue[keyValue] = node;
      }
    }
  }

  // Compute the key for each datum.
  // If there a node associated with this key, join and add it to update.
  // If there is not (or the key is a duplicate), add it to enter.
  for (i = 0; i < dataLength; ++i) {
    keyValue = keyPrefix + key.call(parent, data[i], i, data);
    if (node = nodeByKeyValue[keyValue]) {
      update[i] = node;
      node.__data__ = data[i];
      nodeByKeyValue[keyValue] = null;
    } else {
      enter[i] = new __WEBPACK_IMPORTED_MODULE_1__enter__["a" /* EnterNode */](parent, data[i]);
    }
  }

  // Add any remaining nodes that were not bound to data to exit.
  for (i = 0; i < groupLength; ++i) {
    if ((node = group[i]) && (nodeByKeyValue[keyValues[i]] === node)) {
      exit[i] = node;
    }
  }
}

/* harmony default export */ __webpack_exports__["a"] = (function(value, key) {
  if (!value) {
    data = new Array(this.size()), j = -1;
    this.each(function(d) { data[++j] = d; });
    return data;
  }

  var bind = key ? bindKey : bindIndex,
      parents = this._parents,
      groups = this._groups;

  if (typeof value !== "function") value = Object(__WEBPACK_IMPORTED_MODULE_2__constant__["a" /* default */])(value);

  for (var m = groups.length, update = new Array(m), enter = new Array(m), exit = new Array(m), j = 0; j < m; ++j) {
    var parent = parents[j],
        group = groups[j],
        groupLength = group.length,
        data = value.call(parent, parent && parent.__data__, j, parents),
        dataLength = data.length,
        enterGroup = enter[j] = new Array(dataLength),
        updateGroup = update[j] = new Array(dataLength),
        exitGroup = exit[j] = new Array(groupLength);

    bind(parent, group, enterGroup, updateGroup, exitGroup, data, key);

    // Now connect the enter nodes to their following update node, such that
    // appendChild can insert the materialized enter node before this node,
    // rather than at the end of the parent node.
    for (var i0 = 0, i1 = 0, previous, next; i0 < dataLength; ++i0) {
      if (previous = enterGroup[i0]) {
        if (i0 >= i1) i1 = i0 + 1;
        while (!(next = updateGroup[i1]) && ++i1 < dataLength);
        previous._next = next || null;
      }
    }
  }

  update = new __WEBPACK_IMPORTED_MODULE_0__index__["a" /* Selection */](update, parents);
  update._enter = enter;
  update._exit = exit;
  return update;
});


/***/ }),
/* 213 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony default export */ __webpack_exports__["a"] = (function(x) {
  return function() {
    return x;
  };
});


/***/ }),
/* 214 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__sparse__ = __webpack_require__(100);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__index__ = __webpack_require__(10);



/* harmony default export */ __webpack_exports__["a"] = (function() {
  return new __WEBPACK_IMPORTED_MODULE_1__index__["a" /* Selection */](this._exit || this._groups.map(__WEBPACK_IMPORTED_MODULE_0__sparse__["a" /* default */]), this._parents);
});


/***/ }),
/* 215 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__index__ = __webpack_require__(10);


/* harmony default export */ __webpack_exports__["a"] = (function(selection) {

  for (var groups0 = this._groups, groups1 = selection._groups, m0 = groups0.length, m1 = groups1.length, m = Math.min(m0, m1), merges = new Array(m0), j = 0; j < m; ++j) {
    for (var group0 = groups0[j], group1 = groups1[j], n = group0.length, merge = merges[j] = new Array(n), node, i = 0; i < n; ++i) {
      if (node = group0[i] || group1[i]) {
        merge[i] = node;
      }
    }
  }

  for (; j < m0; ++j) {
    merges[j] = groups0[j];
  }

  return new __WEBPACK_IMPORTED_MODULE_0__index__["a" /* Selection */](merges, this._parents);
});


/***/ }),
/* 216 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony default export */ __webpack_exports__["a"] = (function() {

  for (var groups = this._groups, j = -1, m = groups.length; ++j < m;) {
    for (var group = groups[j], i = group.length - 1, next = group[i], node; --i >= 0;) {
      if (node = group[i]) {
        if (next && next !== node.nextSibling) next.parentNode.insertBefore(node, next);
        next = node;
      }
    }
  }

  return this;
});


/***/ }),
/* 217 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__index__ = __webpack_require__(10);


/* harmony default export */ __webpack_exports__["a"] = (function(compare) {
  if (!compare) compare = ascending;

  function compareNode(a, b) {
    return a && b ? compare(a.__data__, b.__data__) : !a - !b;
  }

  for (var groups = this._groups, m = groups.length, sortgroups = new Array(m), j = 0; j < m; ++j) {
    for (var group = groups[j], n = group.length, sortgroup = sortgroups[j] = new Array(n), node, i = 0; i < n; ++i) {
      if (node = group[i]) {
        sortgroup[i] = node;
      }
    }
    sortgroup.sort(compareNode);
  }

  return new __WEBPACK_IMPORTED_MODULE_0__index__["a" /* Selection */](sortgroups, this._parents).order();
});

function ascending(a, b) {
  return a < b ? -1 : a > b ? 1 : a >= b ? 0 : NaN;
}


/***/ }),
/* 218 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony default export */ __webpack_exports__["a"] = (function() {
  var callback = arguments[0];
  arguments[0] = this;
  callback.apply(null, arguments);
  return this;
});


/***/ }),
/* 219 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony default export */ __webpack_exports__["a"] = (function() {
  var nodes = new Array(this.size()), i = -1;
  this.each(function() { nodes[++i] = this; });
  return nodes;
});


/***/ }),
/* 220 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony default export */ __webpack_exports__["a"] = (function() {

  for (var groups = this._groups, j = 0, m = groups.length; j < m; ++j) {
    for (var group = groups[j], i = 0, n = group.length; i < n; ++i) {
      var node = group[i];
      if (node) return node;
    }
  }

  return null;
});


/***/ }),
/* 221 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony default export */ __webpack_exports__["a"] = (function() {
  var size = 0;
  this.each(function() { ++size; });
  return size;
});


/***/ }),
/* 222 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony default export */ __webpack_exports__["a"] = (function() {
  return !this.node();
});


/***/ }),
/* 223 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony default export */ __webpack_exports__["a"] = (function(callback) {

  for (var groups = this._groups, j = 0, m = groups.length; j < m; ++j) {
    for (var group = groups[j], i = 0, n = group.length, node; i < n; ++i) {
      if (node = group[i]) callback.call(node, node.__data__, i, group);
    }
  }

  return this;
});


/***/ }),
/* 224 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__namespace__ = __webpack_require__(53);


function attrRemove(name) {
  return function() {
    this.removeAttribute(name);
  };
}

function attrRemoveNS(fullname) {
  return function() {
    this.removeAttributeNS(fullname.space, fullname.local);
  };
}

function attrConstant(name, value) {
  return function() {
    this.setAttribute(name, value);
  };
}

function attrConstantNS(fullname, value) {
  return function() {
    this.setAttributeNS(fullname.space, fullname.local, value);
  };
}

function attrFunction(name, value) {
  return function() {
    var v = value.apply(this, arguments);
    if (v == null) this.removeAttribute(name);
    else this.setAttribute(name, v);
  };
}

function attrFunctionNS(fullname, value) {
  return function() {
    var v = value.apply(this, arguments);
    if (v == null) this.removeAttributeNS(fullname.space, fullname.local);
    else this.setAttributeNS(fullname.space, fullname.local, v);
  };
}

/* harmony default export */ __webpack_exports__["a"] = (function(name, value) {
  var fullname = Object(__WEBPACK_IMPORTED_MODULE_0__namespace__["a" /* default */])(name);

  if (arguments.length < 2) {
    var node = this.node();
    return fullname.local
        ? node.getAttributeNS(fullname.space, fullname.local)
        : node.getAttribute(fullname);
  }

  return this.each((value == null
      ? (fullname.local ? attrRemoveNS : attrRemove) : (typeof value === "function"
      ? (fullname.local ? attrFunctionNS : attrFunction)
      : (fullname.local ? attrConstantNS : attrConstant)))(fullname, value));
});


/***/ }),
/* 225 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
function propertyRemove(name) {
  return function() {
    delete this[name];
  };
}

function propertyConstant(name, value) {
  return function() {
    this[name] = value;
  };
}

function propertyFunction(name, value) {
  return function() {
    var v = value.apply(this, arguments);
    if (v == null) delete this[name];
    else this[name] = v;
  };
}

/* harmony default export */ __webpack_exports__["a"] = (function(name, value) {
  return arguments.length > 1
      ? this.each((value == null
          ? propertyRemove : typeof value === "function"
          ? propertyFunction
          : propertyConstant)(name, value))
      : this.node()[name];
});


/***/ }),
/* 226 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
function classArray(string) {
  return string.trim().split(/^|\s+/);
}

function classList(node) {
  return node.classList || new ClassList(node);
}

function ClassList(node) {
  this._node = node;
  this._names = classArray(node.getAttribute("class") || "");
}

ClassList.prototype = {
  add: function(name) {
    var i = this._names.indexOf(name);
    if (i < 0) {
      this._names.push(name);
      this._node.setAttribute("class", this._names.join(" "));
    }
  },
  remove: function(name) {
    var i = this._names.indexOf(name);
    if (i >= 0) {
      this._names.splice(i, 1);
      this._node.setAttribute("class", this._names.join(" "));
    }
  },
  contains: function(name) {
    return this._names.indexOf(name) >= 0;
  }
};

function classedAdd(node, names) {
  var list = classList(node), i = -1, n = names.length;
  while (++i < n) list.add(names[i]);
}

function classedRemove(node, names) {
  var list = classList(node), i = -1, n = names.length;
  while (++i < n) list.remove(names[i]);
}

function classedTrue(names) {
  return function() {
    classedAdd(this, names);
  };
}

function classedFalse(names) {
  return function() {
    classedRemove(this, names);
  };
}

function classedFunction(names, value) {
  return function() {
    (value.apply(this, arguments) ? classedAdd : classedRemove)(this, names);
  };
}

/* harmony default export */ __webpack_exports__["a"] = (function(name, value) {
  var names = classArray(name + "");

  if (arguments.length < 2) {
    var list = classList(this.node()), i = -1, n = names.length;
    while (++i < n) if (!list.contains(names[i])) return false;
    return true;
  }

  return this.each((typeof value === "function"
      ? classedFunction : value
      ? classedTrue
      : classedFalse)(names, value));
});


/***/ }),
/* 227 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
function textRemove() {
  this.textContent = "";
}

function textConstant(value) {
  return function() {
    this.textContent = value;
  };
}

function textFunction(value) {
  return function() {
    var v = value.apply(this, arguments);
    this.textContent = v == null ? "" : v;
  };
}

/* harmony default export */ __webpack_exports__["a"] = (function(value) {
  return arguments.length
      ? this.each(value == null
          ? textRemove : (typeof value === "function"
          ? textFunction
          : textConstant)(value))
      : this.node().textContent;
});


/***/ }),
/* 228 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
function htmlRemove() {
  this.innerHTML = "";
}

function htmlConstant(value) {
  return function() {
    this.innerHTML = value;
  };
}

function htmlFunction(value) {
  return function() {
    var v = value.apply(this, arguments);
    this.innerHTML = v == null ? "" : v;
  };
}

/* harmony default export */ __webpack_exports__["a"] = (function(value) {
  return arguments.length
      ? this.each(value == null
          ? htmlRemove : (typeof value === "function"
          ? htmlFunction
          : htmlConstant)(value))
      : this.node().innerHTML;
});


/***/ }),
/* 229 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
function raise() {
  if (this.nextSibling) this.parentNode.appendChild(this);
}

/* harmony default export */ __webpack_exports__["a"] = (function() {
  return this.each(raise);
});


/***/ }),
/* 230 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
function lower() {
  if (this.previousSibling) this.parentNode.insertBefore(this, this.parentNode.firstChild);
}

/* harmony default export */ __webpack_exports__["a"] = (function() {
  return this.each(lower);
});


/***/ }),
/* 231 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__creator__ = __webpack_require__(52);


/* harmony default export */ __webpack_exports__["a"] = (function(name) {
  var create = typeof name === "function" ? name : Object(__WEBPACK_IMPORTED_MODULE_0__creator__["a" /* default */])(name);
  return this.select(function() {
    return this.appendChild(create.apply(this, arguments));
  });
});


/***/ }),
/* 232 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__creator__ = __webpack_require__(52);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__selector__ = __webpack_require__(58);



function constantNull() {
  return null;
}

/* harmony default export */ __webpack_exports__["a"] = (function(name, before) {
  var create = typeof name === "function" ? name : Object(__WEBPACK_IMPORTED_MODULE_0__creator__["a" /* default */])(name),
      select = before == null ? constantNull : typeof before === "function" ? before : Object(__WEBPACK_IMPORTED_MODULE_1__selector__["a" /* default */])(before);
  return this.select(function() {
    return this.insertBefore(create.apply(this, arguments), select.apply(this, arguments) || null);
  });
});


/***/ }),
/* 233 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
function remove() {
  var parent = this.parentNode;
  if (parent) parent.removeChild(this);
}

/* harmony default export */ __webpack_exports__["a"] = (function() {
  return this.each(remove);
});


/***/ }),
/* 234 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony default export */ __webpack_exports__["a"] = (function(value) {
  return arguments.length
      ? this.property("__data__", value)
      : this.node().__data__;
});


/***/ }),
/* 235 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__window__ = __webpack_require__(59);


function dispatchEvent(node, type, params) {
  var window = Object(__WEBPACK_IMPORTED_MODULE_0__window__["a" /* default */])(node),
      event = window.CustomEvent;

  if (typeof event === "function") {
    event = new event(type, params);
  } else {
    event = window.document.createEvent("Event");
    if (params) event.initEvent(type, params.bubbles, params.cancelable), event.detail = params.detail;
    else event.initEvent(type, false, false);
  }

  node.dispatchEvent(event);
}

function dispatchConstant(type, params) {
  return function() {
    return dispatchEvent(this, type, params);
  };
}

function dispatchFunction(type, params) {
  return function() {
    return dispatchEvent(this, type, params.apply(this, arguments));
  };
}

/* harmony default export */ __webpack_exports__["a"] = (function(type, params) {
  return this.each((typeof params === "function"
      ? dispatchFunction
      : dispatchConstant)(type, params));
});


/***/ }),
/* 236 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__selection_index__ = __webpack_require__(10);


/* harmony default export */ __webpack_exports__["a"] = (function(selector) {
  return typeof selector === "string"
      ? new __WEBPACK_IMPORTED_MODULE_0__selection_index__["a" /* Selection */]([document.querySelectorAll(selector)], [document.documentElement])
      : new __WEBPACK_IMPORTED_MODULE_0__selection_index__["a" /* Selection */]([selector == null ? [] : selector], __WEBPACK_IMPORTED_MODULE_0__selection_index__["c" /* root */]);
});


/***/ }),
/* 237 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__sourceEvent__ = __webpack_require__(55);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__point__ = __webpack_require__(57);



/* harmony default export */ __webpack_exports__["a"] = (function(node, touches, identifier) {
  if (arguments.length < 3) identifier = touches, touches = Object(__WEBPACK_IMPORTED_MODULE_0__sourceEvent__["a" /* default */])().changedTouches;

  for (var i = 0, n = touches ? touches.length : 0, touch; i < n; ++i) {
    if ((touch = touches[i]).identifier === identifier) {
      return Object(__WEBPACK_IMPORTED_MODULE_1__point__["a" /* default */])(node, touch);
    }
  }

  return null;
});


/***/ }),
/* 238 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__sourceEvent__ = __webpack_require__(55);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__point__ = __webpack_require__(57);



/* harmony default export */ __webpack_exports__["a"] = (function(node, touches) {
  if (touches == null) touches = Object(__WEBPACK_IMPORTED_MODULE_0__sourceEvent__["a" /* default */])().touches;

  for (var i = 0, n = touches ? touches.length : 0, points = new Array(n); i < n; ++i) {
    points[i] = Object(__WEBPACK_IMPORTED_MODULE_1__point__["a" /* default */])(node, touches[i]);
  }

  return points;
});


/***/ }),
/* 239 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_d3_selection__ = __webpack_require__(0);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__interrupt__ = __webpack_require__(240);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__transition__ = __webpack_require__(243);




__WEBPACK_IMPORTED_MODULE_0_d3_selection__["selection"].prototype.interrupt = __WEBPACK_IMPORTED_MODULE_1__interrupt__["a" /* default */];
__WEBPACK_IMPORTED_MODULE_0_d3_selection__["selection"].prototype.transition = __WEBPACK_IMPORTED_MODULE_2__transition__["a" /* default */];


/***/ }),
/* 240 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__interrupt__ = __webpack_require__(102);


/* harmony default export */ __webpack_exports__["a"] = (function(name) {
  return this.each(function() {
    Object(__WEBPACK_IMPORTED_MODULE_0__interrupt__["a" /* default */])(this, name);
  });
});


/***/ }),
/* 241 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__timer__ = __webpack_require__(60);


/* harmony default export */ __webpack_exports__["a"] = (function(callback, delay, time) {
  var t = new __WEBPACK_IMPORTED_MODULE_0__timer__["a" /* Timer */];
  delay = delay == null ? 0 : +delay;
  t.restart(function(elapsed) {
    t.stop();
    callback(elapsed + delay);
  }, delay, time);
  return t;
});


/***/ }),
/* 242 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__timer__ = __webpack_require__(60);


/* unused harmony default export */ var _unused_webpack_default_export = (function(callback, delay, time) {
  var t = new __WEBPACK_IMPORTED_MODULE_0__timer__["a" /* Timer */], total = delay;
  if (delay == null) return t.restart(callback, delay, time), t;
  delay = +delay, time = time == null ? Object(__WEBPACK_IMPORTED_MODULE_0__timer__["b" /* now */])() : +time;
  t.restart(function tick(elapsed) {
    elapsed += total;
    t.restart(tick, total += delay, time);
    callback(elapsed);
  }, delay, time);
  return t;
});


/***/ }),
/* 243 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__transition_index__ = __webpack_require__(16);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__transition_schedule__ = __webpack_require__(11);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2_d3_ease__ = __webpack_require__(4);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3_d3_timer__ = __webpack_require__(103);





var defaultTiming = {
  time: null, // Set on use.
  delay: 0,
  duration: 250,
  ease: __WEBPACK_IMPORTED_MODULE_2_d3_ease__["easeCubicInOut"]
};

function inherit(node, id) {
  var timing;
  while (!(timing = node.__transition) || !(timing = timing[id])) {
    if (!(node = node.parentNode)) {
      return defaultTiming.time = Object(__WEBPACK_IMPORTED_MODULE_3_d3_timer__["a" /* now */])(), defaultTiming;
    }
  }
  return timing;
}

/* harmony default export */ __webpack_exports__["a"] = (function(name) {
  var id,
      timing;

  if (name instanceof __WEBPACK_IMPORTED_MODULE_0__transition_index__["a" /* Transition */]) {
    id = name._id, name = name._name;
  } else {
    id = Object(__WEBPACK_IMPORTED_MODULE_0__transition_index__["c" /* newId */])(), (timing = defaultTiming).time = Object(__WEBPACK_IMPORTED_MODULE_3_d3_timer__["a" /* now */])(), name = name == null ? null : name + "";
  }

  for (var groups = this._groups, m = groups.length, j = 0; j < m; ++j) {
    for (var group = groups[j], n = group.length, node, i = 0; i < n; ++i) {
      if (node = group[i]) {
        Object(__WEBPACK_IMPORTED_MODULE_1__transition_schedule__["e" /* default */])(node, name, id, i, group, timing || inherit(node, id));
      }
    }
  }

  return new __WEBPACK_IMPORTED_MODULE_0__transition_index__["a" /* Transition */](groups, this._parents, name, id);
});


/***/ }),
/* 244 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_d3_interpolate__ = __webpack_require__(9);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_d3_selection__ = __webpack_require__(0);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__tween__ = __webpack_require__(37);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__interpolate__ = __webpack_require__(104);





function attrRemove(name) {
  return function() {
    this.removeAttribute(name);
  };
}

function attrRemoveNS(fullname) {
  return function() {
    this.removeAttributeNS(fullname.space, fullname.local);
  };
}

function attrConstant(name, interpolate, value1) {
  var value00,
      interpolate0;
  return function() {
    var value0 = this.getAttribute(name);
    return value0 === value1 ? null
        : value0 === value00 ? interpolate0
        : interpolate0 = interpolate(value00 = value0, value1);
  };
}

function attrConstantNS(fullname, interpolate, value1) {
  var value00,
      interpolate0;
  return function() {
    var value0 = this.getAttributeNS(fullname.space, fullname.local);
    return value0 === value1 ? null
        : value0 === value00 ? interpolate0
        : interpolate0 = interpolate(value00 = value0, value1);
  };
}

function attrFunction(name, interpolate, value) {
  var value00,
      value10,
      interpolate0;
  return function() {
    var value0, value1 = value(this);
    if (value1 == null) return void this.removeAttribute(name);
    value0 = this.getAttribute(name);
    return value0 === value1 ? null
        : value0 === value00 && value1 === value10 ? interpolate0
        : interpolate0 = interpolate(value00 = value0, value10 = value1);
  };
}

function attrFunctionNS(fullname, interpolate, value) {
  var value00,
      value10,
      interpolate0;
  return function() {
    var value0, value1 = value(this);
    if (value1 == null) return void this.removeAttributeNS(fullname.space, fullname.local);
    value0 = this.getAttributeNS(fullname.space, fullname.local);
    return value0 === value1 ? null
        : value0 === value00 && value1 === value10 ? interpolate0
        : interpolate0 = interpolate(value00 = value0, value10 = value1);
  };
}

/* harmony default export */ __webpack_exports__["a"] = (function(name, value) {
  var fullname = Object(__WEBPACK_IMPORTED_MODULE_1_d3_selection__["namespace"])(name), i = fullname === "transform" ? __WEBPACK_IMPORTED_MODULE_0_d3_interpolate__["interpolateTransformSvg"] : __WEBPACK_IMPORTED_MODULE_3__interpolate__["a" /* default */];
  return this.attrTween(name, typeof value === "function"
      ? (fullname.local ? attrFunctionNS : attrFunction)(fullname, i, Object(__WEBPACK_IMPORTED_MODULE_2__tween__["b" /* tweenValue */])(this, "attr." + name, value))
      : value == null ? (fullname.local ? attrRemoveNS : attrRemove)(fullname)
      : (fullname.local ? attrConstantNS : attrConstant)(fullname, i, value + ""));
});


/***/ }),
/* 245 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_d3_selection__ = __webpack_require__(0);


function attrTweenNS(fullname, value) {
  function tween() {
    var node = this, i = value.apply(node, arguments);
    return i && function(t) {
      node.setAttributeNS(fullname.space, fullname.local, i(t));
    };
  }
  tween._value = value;
  return tween;
}

function attrTween(name, value) {
  function tween() {
    var node = this, i = value.apply(node, arguments);
    return i && function(t) {
      node.setAttribute(name, i(t));
    };
  }
  tween._value = value;
  return tween;
}

/* harmony default export */ __webpack_exports__["a"] = (function(name, value) {
  var key = "attr." + name;
  if (arguments.length < 2) return (key = this.tween(key)) && key._value;
  if (value == null) return this.tween(key, null);
  if (typeof value !== "function") throw new Error;
  var fullname = Object(__WEBPACK_IMPORTED_MODULE_0_d3_selection__["namespace"])(name);
  return this.tween(key, (fullname.local ? attrTweenNS : attrTween)(fullname, value));
});


/***/ }),
/* 246 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__schedule__ = __webpack_require__(11);


function delayFunction(id, value) {
  return function() {
    Object(__WEBPACK_IMPORTED_MODULE_0__schedule__["g" /* init */])(this, id).delay = +value.apply(this, arguments);
  };
}

function delayConstant(id, value) {
  return value = +value, function() {
    Object(__WEBPACK_IMPORTED_MODULE_0__schedule__["g" /* init */])(this, id).delay = value;
  };
}

/* harmony default export */ __webpack_exports__["a"] = (function(value) {
  var id = this._id;

  return arguments.length
      ? this.each((typeof value === "function"
          ? delayFunction
          : delayConstant)(id, value))
      : Object(__WEBPACK_IMPORTED_MODULE_0__schedule__["f" /* get */])(this.node(), id).delay;
});


/***/ }),
/* 247 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__schedule__ = __webpack_require__(11);


function durationFunction(id, value) {
  return function() {
    Object(__WEBPACK_IMPORTED_MODULE_0__schedule__["h" /* set */])(this, id).duration = +value.apply(this, arguments);
  };
}

function durationConstant(id, value) {
  return value = +value, function() {
    Object(__WEBPACK_IMPORTED_MODULE_0__schedule__["h" /* set */])(this, id).duration = value;
  };
}

/* harmony default export */ __webpack_exports__["a"] = (function(value) {
  var id = this._id;

  return arguments.length
      ? this.each((typeof value === "function"
          ? durationFunction
          : durationConstant)(id, value))
      : Object(__WEBPACK_IMPORTED_MODULE_0__schedule__["f" /* get */])(this.node(), id).duration;
});


/***/ }),
/* 248 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__schedule__ = __webpack_require__(11);


function easeConstant(id, value) {
  if (typeof value !== "function") throw new Error;
  return function() {
    Object(__WEBPACK_IMPORTED_MODULE_0__schedule__["h" /* set */])(this, id).ease = value;
  };
}

/* harmony default export */ __webpack_exports__["a"] = (function(value) {
  var id = this._id;

  return arguments.length
      ? this.each(easeConstant(id, value))
      : Object(__WEBPACK_IMPORTED_MODULE_0__schedule__["f" /* get */])(this.node(), id).ease;
});


/***/ }),
/* 249 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_d3_selection__ = __webpack_require__(0);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__index__ = __webpack_require__(16);



/* harmony default export */ __webpack_exports__["a"] = (function(match) {
  if (typeof match !== "function") match = Object(__WEBPACK_IMPORTED_MODULE_0_d3_selection__["matcher"])(match);

  for (var groups = this._groups, m = groups.length, subgroups = new Array(m), j = 0; j < m; ++j) {
    for (var group = groups[j], n = group.length, subgroup = subgroups[j] = [], node, i = 0; i < n; ++i) {
      if ((node = group[i]) && match.call(node, node.__data__, i, group)) {
        subgroup.push(node);
      }
    }
  }

  return new __WEBPACK_IMPORTED_MODULE_1__index__["a" /* Transition */](subgroups, this._parents, this._name, this._id);
});


/***/ }),
/* 250 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__index__ = __webpack_require__(16);


/* harmony default export */ __webpack_exports__["a"] = (function(transition) {
  if (transition._id !== this._id) throw new Error;

  for (var groups0 = this._groups, groups1 = transition._groups, m0 = groups0.length, m1 = groups1.length, m = Math.min(m0, m1), merges = new Array(m0), j = 0; j < m; ++j) {
    for (var group0 = groups0[j], group1 = groups1[j], n = group0.length, merge = merges[j] = new Array(n), node, i = 0; i < n; ++i) {
      if (node = group0[i] || group1[i]) {
        merge[i] = node;
      }
    }
  }

  for (; j < m0; ++j) {
    merges[j] = groups0[j];
  }

  return new __WEBPACK_IMPORTED_MODULE_0__index__["a" /* Transition */](merges, this._parents, this._name, this._id);
});


/***/ }),
/* 251 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__schedule__ = __webpack_require__(11);


function start(name) {
  return (name + "").trim().split(/^|\s+/).every(function(t) {
    var i = t.indexOf(".");
    if (i >= 0) t = t.slice(0, i);
    return !t || t === "start";
  });
}

function onFunction(id, name, listener) {
  var on0, on1, sit = start(name) ? __WEBPACK_IMPORTED_MODULE_0__schedule__["g" /* init */] : __WEBPACK_IMPORTED_MODULE_0__schedule__["h" /* set */];
  return function() {
    var schedule = sit(this, id),
        on = schedule.on;

    // If this node shared a dispatch with the previous node,
    // just assign the updated shared dispatch and we’re done!
    // Otherwise, copy-on-write.
    if (on !== on0) (on1 = (on0 = on).copy()).on(name, listener);

    schedule.on = on1;
  };
}

/* harmony default export */ __webpack_exports__["a"] = (function(name, listener) {
  var id = this._id;

  return arguments.length < 2
      ? Object(__WEBPACK_IMPORTED_MODULE_0__schedule__["f" /* get */])(this.node(), id).on.on(name)
      : this.each(onFunction(id, name, listener));
});


/***/ }),
/* 252 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
function removeFunction(id) {
  return function() {
    var parent = this.parentNode;
    for (var i in this.__transition) if (+i !== id) return;
    if (parent) parent.removeChild(this);
  };
}

/* harmony default export */ __webpack_exports__["a"] = (function() {
  return this.on("end.remove", removeFunction(this._id));
});


/***/ }),
/* 253 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_d3_selection__ = __webpack_require__(0);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__index__ = __webpack_require__(16);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__schedule__ = __webpack_require__(11);




/* harmony default export */ __webpack_exports__["a"] = (function(select) {
  var name = this._name,
      id = this._id;

  if (typeof select !== "function") select = Object(__WEBPACK_IMPORTED_MODULE_0_d3_selection__["selector"])(select);

  for (var groups = this._groups, m = groups.length, subgroups = new Array(m), j = 0; j < m; ++j) {
    for (var group = groups[j], n = group.length, subgroup = subgroups[j] = new Array(n), node, subnode, i = 0; i < n; ++i) {
      if ((node = group[i]) && (subnode = select.call(node, node.__data__, i, group))) {
        if ("__data__" in node) subnode.__data__ = node.__data__;
        subgroup[i] = subnode;
        Object(__WEBPACK_IMPORTED_MODULE_2__schedule__["e" /* default */])(subgroup[i], name, id, i, subgroup, Object(__WEBPACK_IMPORTED_MODULE_2__schedule__["f" /* get */])(node, id));
      }
    }
  }

  return new __WEBPACK_IMPORTED_MODULE_1__index__["a" /* Transition */](subgroups, this._parents, name, id);
});


/***/ }),
/* 254 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_d3_selection__ = __webpack_require__(0);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__index__ = __webpack_require__(16);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__schedule__ = __webpack_require__(11);




/* harmony default export */ __webpack_exports__["a"] = (function(select) {
  var name = this._name,
      id = this._id;

  if (typeof select !== "function") select = Object(__WEBPACK_IMPORTED_MODULE_0_d3_selection__["selectorAll"])(select);

  for (var groups = this._groups, m = groups.length, subgroups = [], parents = [], j = 0; j < m; ++j) {
    for (var group = groups[j], n = group.length, node, i = 0; i < n; ++i) {
      if (node = group[i]) {
        for (var children = select.call(node, node.__data__, i, group), child, inherit = Object(__WEBPACK_IMPORTED_MODULE_2__schedule__["f" /* get */])(node, id), k = 0, l = children.length; k < l; ++k) {
          if (child = children[k]) {
            Object(__WEBPACK_IMPORTED_MODULE_2__schedule__["e" /* default */])(child, name, id, k, children, inherit);
          }
        }
        subgroups.push(children);
        parents.push(node);
      }
    }
  }

  return new __WEBPACK_IMPORTED_MODULE_1__index__["a" /* Transition */](subgroups, parents, name, id);
});


/***/ }),
/* 255 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_d3_selection__ = __webpack_require__(0);


var Selection = __WEBPACK_IMPORTED_MODULE_0_d3_selection__["selection"].prototype.constructor;

/* harmony default export */ __webpack_exports__["a"] = (function() {
  return new Selection(this._groups, this._parents);
});


/***/ }),
/* 256 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_d3_interpolate__ = __webpack_require__(9);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_d3_selection__ = __webpack_require__(0);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__tween__ = __webpack_require__(37);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__interpolate__ = __webpack_require__(104);





function styleRemove(name, interpolate) {
  var value00,
      value10,
      interpolate0;
  return function() {
    var value0 = Object(__WEBPACK_IMPORTED_MODULE_1_d3_selection__["style"])(this, name),
        value1 = (this.style.removeProperty(name), Object(__WEBPACK_IMPORTED_MODULE_1_d3_selection__["style"])(this, name));
    return value0 === value1 ? null
        : value0 === value00 && value1 === value10 ? interpolate0
        : interpolate0 = interpolate(value00 = value0, value10 = value1);
  };
}

function styleRemoveEnd(name) {
  return function() {
    this.style.removeProperty(name);
  };
}

function styleConstant(name, interpolate, value1) {
  var value00,
      interpolate0;
  return function() {
    var value0 = Object(__WEBPACK_IMPORTED_MODULE_1_d3_selection__["style"])(this, name);
    return value0 === value1 ? null
        : value0 === value00 ? interpolate0
        : interpolate0 = interpolate(value00 = value0, value1);
  };
}

function styleFunction(name, interpolate, value) {
  var value00,
      value10,
      interpolate0;
  return function() {
    var value0 = Object(__WEBPACK_IMPORTED_MODULE_1_d3_selection__["style"])(this, name),
        value1 = value(this);
    if (value1 == null) value1 = (this.style.removeProperty(name), Object(__WEBPACK_IMPORTED_MODULE_1_d3_selection__["style"])(this, name));
    return value0 === value1 ? null
        : value0 === value00 && value1 === value10 ? interpolate0
        : interpolate0 = interpolate(value00 = value0, value10 = value1);
  };
}

/* harmony default export */ __webpack_exports__["a"] = (function(name, value, priority) {
  var i = (name += "") === "transform" ? __WEBPACK_IMPORTED_MODULE_0_d3_interpolate__["interpolateTransformCss"] : __WEBPACK_IMPORTED_MODULE_3__interpolate__["a" /* default */];
  return value == null ? this
          .styleTween(name, styleRemove(name, i))
          .on("end.style." + name, styleRemoveEnd(name))
      : this.styleTween(name, typeof value === "function"
          ? styleFunction(name, i, Object(__WEBPACK_IMPORTED_MODULE_2__tween__["b" /* tweenValue */])(this, "style." + name, value))
          : styleConstant(name, i, value + ""), priority);
});


/***/ }),
/* 257 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
function styleTween(name, value, priority) {
  function tween() {
    var node = this, i = value.apply(node, arguments);
    return i && function(t) {
      node.style.setProperty(name, i(t), priority);
    };
  }
  tween._value = value;
  return tween;
}

/* harmony default export */ __webpack_exports__["a"] = (function(name, value, priority) {
  var key = "style." + (name += "");
  if (arguments.length < 2) return (key = this.tween(key)) && key._value;
  if (value == null) return this.tween(key, null);
  if (typeof value !== "function") throw new Error;
  return this.tween(key, styleTween(name, value, priority == null ? "" : priority));
});


/***/ }),
/* 258 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__tween__ = __webpack_require__(37);


function textConstant(value) {
  return function() {
    this.textContent = value;
  };
}

function textFunction(value) {
  return function() {
    var value1 = value(this);
    this.textContent = value1 == null ? "" : value1;
  };
}

/* harmony default export */ __webpack_exports__["a"] = (function(value) {
  return this.tween("text", typeof value === "function"
      ? textFunction(Object(__WEBPACK_IMPORTED_MODULE_0__tween__["b" /* tweenValue */])(this, "text", value))
      : textConstant(value == null ? "" : value + ""));
});


/***/ }),
/* 259 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__index__ = __webpack_require__(16);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__schedule__ = __webpack_require__(11);



/* harmony default export */ __webpack_exports__["a"] = (function() {
  var name = this._name,
      id0 = this._id,
      id1 = Object(__WEBPACK_IMPORTED_MODULE_0__index__["c" /* newId */])();

  for (var groups = this._groups, m = groups.length, j = 0; j < m; ++j) {
    for (var group = groups[j], n = group.length, node, i = 0; i < n; ++i) {
      if (node = group[i]) {
        var inherit = Object(__WEBPACK_IMPORTED_MODULE_1__schedule__["f" /* get */])(node, id0);
        Object(__WEBPACK_IMPORTED_MODULE_1__schedule__["e" /* default */])(node, name, id1, i, group, {
          time: inherit.time + inherit.delay + inherit.duration,
          delay: 0,
          duration: inherit.duration,
          ease: inherit.ease
        });
      }
    }
  }

  return new __WEBPACK_IMPORTED_MODULE_0__index__["a" /* Transition */](groups, this._parents, name, id1);
});


/***/ }),
/* 260 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__transition_index__ = __webpack_require__(16);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__transition_schedule__ = __webpack_require__(11);



var root = [null];

/* harmony default export */ __webpack_exports__["a"] = (function(node, name) {
  var schedules = node.__transition,
      schedule,
      i;

  if (schedules) {
    name = name == null ? null : name + "";
    for (i in schedules) {
      if ((schedule = schedules[i]).state > __WEBPACK_IMPORTED_MODULE_1__transition_schedule__["c" /* SCHEDULED */] && schedule.name === name) {
        return new __WEBPACK_IMPORTED_MODULE_0__transition_index__["a" /* Transition */]([[node]], root, name, +i);
      }
    }
  }

  return null;
});


/***/ }),
/* 261 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_d3_path__ = __webpack_require__(30);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__constant__ = __webpack_require__(22);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__math__ = __webpack_require__(31);




function arcInnerRadius(d) {
  return d.innerRadius;
}

function arcOuterRadius(d) {
  return d.outerRadius;
}

function arcStartAngle(d) {
  return d.startAngle;
}

function arcEndAngle(d) {
  return d.endAngle;
}

function arcPadAngle(d) {
  return d && d.padAngle; // Note: optional!
}

function intersect(x0, y0, x1, y1, x2, y2, x3, y3) {
  var x10 = x1 - x0, y10 = y1 - y0,
      x32 = x3 - x2, y32 = y3 - y2,
      t = (x32 * (y0 - y2) - y32 * (x0 - x2)) / (y32 * x10 - x32 * y10);
  return [x0 + t * x10, y0 + t * y10];
}

// Compute perpendicular offset line of length rc.
// http://mathworld.wolfram.com/Circle-LineIntersection.html
function cornerTangents(x0, y0, x1, y1, r1, rc, cw) {
  var x01 = x0 - x1,
      y01 = y0 - y1,
      lo = (cw ? rc : -rc) / Object(__WEBPACK_IMPORTED_MODULE_2__math__["l" /* sqrt */])(x01 * x01 + y01 * y01),
      ox = lo * y01,
      oy = -lo * x01,
      x11 = x0 + ox,
      y11 = y0 + oy,
      x10 = x1 + ox,
      y10 = y1 + oy,
      x00 = (x11 + x10) / 2,
      y00 = (y11 + y10) / 2,
      dx = x10 - x11,
      dy = y10 - y11,
      d2 = dx * dx + dy * dy,
      r = r1 - rc,
      D = x11 * y10 - x10 * y11,
      d = (dy < 0 ? -1 : 1) * Object(__WEBPACK_IMPORTED_MODULE_2__math__["l" /* sqrt */])(Object(__WEBPACK_IMPORTED_MODULE_2__math__["h" /* max */])(0, r * r * d2 - D * D)),
      cx0 = (D * dy - dx * d) / d2,
      cy0 = (-D * dx - dy * d) / d2,
      cx1 = (D * dy + dx * d) / d2,
      cy1 = (-D * dx + dy * d) / d2,
      dx0 = cx0 - x00,
      dy0 = cy0 - y00,
      dx1 = cx1 - x00,
      dy1 = cy1 - y00;

  // Pick the closer of the two intersection points.
  // TODO Is there a faster way to determine which intersection to use?
  if (dx0 * dx0 + dy0 * dy0 > dx1 * dx1 + dy1 * dy1) cx0 = cx1, cy0 = cy1;

  return {
    cx: cx0,
    cy: cy0,
    x01: -ox,
    y01: -oy,
    x11: cx0 * (r1 / r - 1),
    y11: cy0 * (r1 / r - 1)
  };
}

/* harmony default export */ __webpack_exports__["a"] = (function() {
  var innerRadius = arcInnerRadius,
      outerRadius = arcOuterRadius,
      cornerRadius = Object(__WEBPACK_IMPORTED_MODULE_1__constant__["a" /* default */])(0),
      padRadius = null,
      startAngle = arcStartAngle,
      endAngle = arcEndAngle,
      padAngle = arcPadAngle,
      context = null;

  function arc() {
    var buffer,
        r,
        r0 = +innerRadius.apply(this, arguments),
        r1 = +outerRadius.apply(this, arguments),
        a0 = startAngle.apply(this, arguments) - __WEBPACK_IMPORTED_MODULE_2__math__["g" /* halfPi */],
        a1 = endAngle.apply(this, arguments) - __WEBPACK_IMPORTED_MODULE_2__math__["g" /* halfPi */],
        da = Object(__WEBPACK_IMPORTED_MODULE_2__math__["a" /* abs */])(a1 - a0),
        cw = a1 > a0;

    if (!context) context = buffer = Object(__WEBPACK_IMPORTED_MODULE_0_d3_path__["a" /* path */])();

    // Ensure that the outer radius is always larger than the inner radius.
    if (r1 < r0) r = r1, r1 = r0, r0 = r;

    // Is it a point?
    if (!(r1 > __WEBPACK_IMPORTED_MODULE_2__math__["f" /* epsilon */])) context.moveTo(0, 0);

    // Or is it a circle or annulus?
    else if (da > __WEBPACK_IMPORTED_MODULE_2__math__["m" /* tau */] - __WEBPACK_IMPORTED_MODULE_2__math__["f" /* epsilon */]) {
      context.moveTo(r1 * Object(__WEBPACK_IMPORTED_MODULE_2__math__["e" /* cos */])(a0), r1 * Object(__WEBPACK_IMPORTED_MODULE_2__math__["k" /* sin */])(a0));
      context.arc(0, 0, r1, a0, a1, !cw);
      if (r0 > __WEBPACK_IMPORTED_MODULE_2__math__["f" /* epsilon */]) {
        context.moveTo(r0 * Object(__WEBPACK_IMPORTED_MODULE_2__math__["e" /* cos */])(a1), r0 * Object(__WEBPACK_IMPORTED_MODULE_2__math__["k" /* sin */])(a1));
        context.arc(0, 0, r0, a1, a0, cw);
      }
    }

    // Or is it a circular or annular sector?
    else {
      var a01 = a0,
          a11 = a1,
          a00 = a0,
          a10 = a1,
          da0 = da,
          da1 = da,
          ap = padAngle.apply(this, arguments) / 2,
          rp = (ap > __WEBPACK_IMPORTED_MODULE_2__math__["f" /* epsilon */]) && (padRadius ? +padRadius.apply(this, arguments) : Object(__WEBPACK_IMPORTED_MODULE_2__math__["l" /* sqrt */])(r0 * r0 + r1 * r1)),
          rc = Object(__WEBPACK_IMPORTED_MODULE_2__math__["i" /* min */])(Object(__WEBPACK_IMPORTED_MODULE_2__math__["a" /* abs */])(r1 - r0) / 2, +cornerRadius.apply(this, arguments)),
          rc0 = rc,
          rc1 = rc,
          t0,
          t1;

      // Apply padding? Note that since r1 ≥ r0, da1 ≥ da0.
      if (rp > __WEBPACK_IMPORTED_MODULE_2__math__["f" /* epsilon */]) {
        var p0 = Object(__WEBPACK_IMPORTED_MODULE_2__math__["c" /* asin */])(rp / r0 * Object(__WEBPACK_IMPORTED_MODULE_2__math__["k" /* sin */])(ap)),
            p1 = Object(__WEBPACK_IMPORTED_MODULE_2__math__["c" /* asin */])(rp / r1 * Object(__WEBPACK_IMPORTED_MODULE_2__math__["k" /* sin */])(ap));
        if ((da0 -= p0 * 2) > __WEBPACK_IMPORTED_MODULE_2__math__["f" /* epsilon */]) p0 *= (cw ? 1 : -1), a00 += p0, a10 -= p0;
        else da0 = 0, a00 = a10 = (a0 + a1) / 2;
        if ((da1 -= p1 * 2) > __WEBPACK_IMPORTED_MODULE_2__math__["f" /* epsilon */]) p1 *= (cw ? 1 : -1), a01 += p1, a11 -= p1;
        else da1 = 0, a01 = a11 = (a0 + a1) / 2;
      }

      var x01 = r1 * Object(__WEBPACK_IMPORTED_MODULE_2__math__["e" /* cos */])(a01),
          y01 = r1 * Object(__WEBPACK_IMPORTED_MODULE_2__math__["k" /* sin */])(a01),
          x10 = r0 * Object(__WEBPACK_IMPORTED_MODULE_2__math__["e" /* cos */])(a10),
          y10 = r0 * Object(__WEBPACK_IMPORTED_MODULE_2__math__["k" /* sin */])(a10);

      // Apply rounded corners?
      if (rc > __WEBPACK_IMPORTED_MODULE_2__math__["f" /* epsilon */]) {
        var x11 = r1 * Object(__WEBPACK_IMPORTED_MODULE_2__math__["e" /* cos */])(a11),
            y11 = r1 * Object(__WEBPACK_IMPORTED_MODULE_2__math__["k" /* sin */])(a11),
            x00 = r0 * Object(__WEBPACK_IMPORTED_MODULE_2__math__["e" /* cos */])(a00),
            y00 = r0 * Object(__WEBPACK_IMPORTED_MODULE_2__math__["k" /* sin */])(a00);

        // Restrict the corner radius according to the sector angle.
        if (da < __WEBPACK_IMPORTED_MODULE_2__math__["j" /* pi */]) {
          var oc = da0 > __WEBPACK_IMPORTED_MODULE_2__math__["f" /* epsilon */] ? intersect(x01, y01, x00, y00, x11, y11, x10, y10) : [x10, y10],
              ax = x01 - oc[0],
              ay = y01 - oc[1],
              bx = x11 - oc[0],
              by = y11 - oc[1],
              kc = 1 / Object(__WEBPACK_IMPORTED_MODULE_2__math__["k" /* sin */])(Object(__WEBPACK_IMPORTED_MODULE_2__math__["b" /* acos */])((ax * bx + ay * by) / (Object(__WEBPACK_IMPORTED_MODULE_2__math__["l" /* sqrt */])(ax * ax + ay * ay) * Object(__WEBPACK_IMPORTED_MODULE_2__math__["l" /* sqrt */])(bx * bx + by * by))) / 2),
              lc = Object(__WEBPACK_IMPORTED_MODULE_2__math__["l" /* sqrt */])(oc[0] * oc[0] + oc[1] * oc[1]);
          rc0 = Object(__WEBPACK_IMPORTED_MODULE_2__math__["i" /* min */])(rc, (r0 - lc) / (kc - 1));
          rc1 = Object(__WEBPACK_IMPORTED_MODULE_2__math__["i" /* min */])(rc, (r1 - lc) / (kc + 1));
        }
      }

      // Is the sector collapsed to a line?
      if (!(da1 > __WEBPACK_IMPORTED_MODULE_2__math__["f" /* epsilon */])) context.moveTo(x01, y01);

      // Does the sector’s outer ring have rounded corners?
      else if (rc1 > __WEBPACK_IMPORTED_MODULE_2__math__["f" /* epsilon */]) {
        t0 = cornerTangents(x00, y00, x01, y01, r1, rc1, cw);
        t1 = cornerTangents(x11, y11, x10, y10, r1, rc1, cw);

        context.moveTo(t0.cx + t0.x01, t0.cy + t0.y01);

        // Have the corners merged?
        if (rc1 < rc) context.arc(t0.cx, t0.cy, rc1, Object(__WEBPACK_IMPORTED_MODULE_2__math__["d" /* atan2 */])(t0.y01, t0.x01), Object(__WEBPACK_IMPORTED_MODULE_2__math__["d" /* atan2 */])(t1.y01, t1.x01), !cw);

        // Otherwise, draw the two corners and the ring.
        else {
          context.arc(t0.cx, t0.cy, rc1, Object(__WEBPACK_IMPORTED_MODULE_2__math__["d" /* atan2 */])(t0.y01, t0.x01), Object(__WEBPACK_IMPORTED_MODULE_2__math__["d" /* atan2 */])(t0.y11, t0.x11), !cw);
          context.arc(0, 0, r1, Object(__WEBPACK_IMPORTED_MODULE_2__math__["d" /* atan2 */])(t0.cy + t0.y11, t0.cx + t0.x11), Object(__WEBPACK_IMPORTED_MODULE_2__math__["d" /* atan2 */])(t1.cy + t1.y11, t1.cx + t1.x11), !cw);
          context.arc(t1.cx, t1.cy, rc1, Object(__WEBPACK_IMPORTED_MODULE_2__math__["d" /* atan2 */])(t1.y11, t1.x11), Object(__WEBPACK_IMPORTED_MODULE_2__math__["d" /* atan2 */])(t1.y01, t1.x01), !cw);
        }
      }

      // Or is the outer ring just a circular arc?
      else context.moveTo(x01, y01), context.arc(0, 0, r1, a01, a11, !cw);

      // Is there no inner ring, and it’s a circular sector?
      // Or perhaps it’s an annular sector collapsed due to padding?
      if (!(r0 > __WEBPACK_IMPORTED_MODULE_2__math__["f" /* epsilon */]) || !(da0 > __WEBPACK_IMPORTED_MODULE_2__math__["f" /* epsilon */])) context.lineTo(x10, y10);

      // Does the sector’s inner ring (or point) have rounded corners?
      else if (rc0 > __WEBPACK_IMPORTED_MODULE_2__math__["f" /* epsilon */]) {
        t0 = cornerTangents(x10, y10, x11, y11, r0, -rc0, cw);
        t1 = cornerTangents(x01, y01, x00, y00, r0, -rc0, cw);

        context.lineTo(t0.cx + t0.x01, t0.cy + t0.y01);

        // Have the corners merged?
        if (rc0 < rc) context.arc(t0.cx, t0.cy, rc0, Object(__WEBPACK_IMPORTED_MODULE_2__math__["d" /* atan2 */])(t0.y01, t0.x01), Object(__WEBPACK_IMPORTED_MODULE_2__math__["d" /* atan2 */])(t1.y01, t1.x01), !cw);

        // Otherwise, draw the two corners and the ring.
        else {
          context.arc(t0.cx, t0.cy, rc0, Object(__WEBPACK_IMPORTED_MODULE_2__math__["d" /* atan2 */])(t0.y01, t0.x01), Object(__WEBPACK_IMPORTED_MODULE_2__math__["d" /* atan2 */])(t0.y11, t0.x11), !cw);
          context.arc(0, 0, r0, Object(__WEBPACK_IMPORTED_MODULE_2__math__["d" /* atan2 */])(t0.cy + t0.y11, t0.cx + t0.x11), Object(__WEBPACK_IMPORTED_MODULE_2__math__["d" /* atan2 */])(t1.cy + t1.y11, t1.cx + t1.x11), cw);
          context.arc(t1.cx, t1.cy, rc0, Object(__WEBPACK_IMPORTED_MODULE_2__math__["d" /* atan2 */])(t1.y11, t1.x11), Object(__WEBPACK_IMPORTED_MODULE_2__math__["d" /* atan2 */])(t1.y01, t1.x01), !cw);
        }
      }

      // Or is the inner ring just a circular arc?
      else context.arc(0, 0, r0, a10, a00, cw);
    }

    context.closePath();

    if (buffer) return context = null, buffer + "" || null;
  }

  arc.centroid = function() {
    var r = (+innerRadius.apply(this, arguments) + +outerRadius.apply(this, arguments)) / 2,
        a = (+startAngle.apply(this, arguments) + +endAngle.apply(this, arguments)) / 2 - __WEBPACK_IMPORTED_MODULE_2__math__["j" /* pi */] / 2;
    return [Object(__WEBPACK_IMPORTED_MODULE_2__math__["e" /* cos */])(a) * r, Object(__WEBPACK_IMPORTED_MODULE_2__math__["k" /* sin */])(a) * r];
  };

  arc.innerRadius = function(_) {
    return arguments.length ? (innerRadius = typeof _ === "function" ? _ : Object(__WEBPACK_IMPORTED_MODULE_1__constant__["a" /* default */])(+_), arc) : innerRadius;
  };

  arc.outerRadius = function(_) {
    return arguments.length ? (outerRadius = typeof _ === "function" ? _ : Object(__WEBPACK_IMPORTED_MODULE_1__constant__["a" /* default */])(+_), arc) : outerRadius;
  };

  arc.cornerRadius = function(_) {
    return arguments.length ? (cornerRadius = typeof _ === "function" ? _ : Object(__WEBPACK_IMPORTED_MODULE_1__constant__["a" /* default */])(+_), arc) : cornerRadius;
  };

  arc.padRadius = function(_) {
    return arguments.length ? (padRadius = _ == null ? null : typeof _ === "function" ? _ : Object(__WEBPACK_IMPORTED_MODULE_1__constant__["a" /* default */])(+_), arc) : padRadius;
  };

  arc.startAngle = function(_) {
    return arguments.length ? (startAngle = typeof _ === "function" ? _ : Object(__WEBPACK_IMPORTED_MODULE_1__constant__["a" /* default */])(+_), arc) : startAngle;
  };

  arc.endAngle = function(_) {
    return arguments.length ? (endAngle = typeof _ === "function" ? _ : Object(__WEBPACK_IMPORTED_MODULE_1__constant__["a" /* default */])(+_), arc) : endAngle;
  };

  arc.padAngle = function(_) {
    return arguments.length ? (padAngle = typeof _ === "function" ? _ : Object(__WEBPACK_IMPORTED_MODULE_1__constant__["a" /* default */])(+_), arc) : padAngle;
  };

  arc.context = function(_) {
    return arguments.length ? ((context = _ == null ? null : _), arc) : context;
  };

  return arc;
});


/***/ }),
/* 262 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var pi = Math.PI,
    tau = 2 * pi,
    epsilon = 1e-6,
    tauEpsilon = tau - epsilon;

function Path() {
  this._x0 = this._y0 = // start of current subpath
  this._x1 = this._y1 = null; // end of current subpath
  this._ = "";
}

function path() {
  return new Path;
}

Path.prototype = path.prototype = {
  constructor: Path,
  moveTo: function(x, y) {
    this._ += "M" + (this._x0 = this._x1 = +x) + "," + (this._y0 = this._y1 = +y);
  },
  closePath: function() {
    if (this._x1 !== null) {
      this._x1 = this._x0, this._y1 = this._y0;
      this._ += "Z";
    }
  },
  lineTo: function(x, y) {
    this._ += "L" + (this._x1 = +x) + "," + (this._y1 = +y);
  },
  quadraticCurveTo: function(x1, y1, x, y) {
    this._ += "Q" + (+x1) + "," + (+y1) + "," + (this._x1 = +x) + "," + (this._y1 = +y);
  },
  bezierCurveTo: function(x1, y1, x2, y2, x, y) {
    this._ += "C" + (+x1) + "," + (+y1) + "," + (+x2) + "," + (+y2) + "," + (this._x1 = +x) + "," + (this._y1 = +y);
  },
  arcTo: function(x1, y1, x2, y2, r) {
    x1 = +x1, y1 = +y1, x2 = +x2, y2 = +y2, r = +r;
    var x0 = this._x1,
        y0 = this._y1,
        x21 = x2 - x1,
        y21 = y2 - y1,
        x01 = x0 - x1,
        y01 = y0 - y1,
        l01_2 = x01 * x01 + y01 * y01;

    // Is the radius negative? Error.
    if (r < 0) throw new Error("negative radius: " + r);

    // Is this path empty? Move to (x1,y1).
    if (this._x1 === null) {
      this._ += "M" + (this._x1 = x1) + "," + (this._y1 = y1);
    }

    // Or, is (x1,y1) coincident with (x0,y0)? Do nothing.
    else if (!(l01_2 > epsilon)) {}

    // Or, are (x0,y0), (x1,y1) and (x2,y2) collinear?
    // Equivalently, is (x1,y1) coincident with (x2,y2)?
    // Or, is the radius zero? Line to (x1,y1).
    else if (!(Math.abs(y01 * x21 - y21 * x01) > epsilon) || !r) {
      this._ += "L" + (this._x1 = x1) + "," + (this._y1 = y1);
    }

    // Otherwise, draw an arc!
    else {
      var x20 = x2 - x0,
          y20 = y2 - y0,
          l21_2 = x21 * x21 + y21 * y21,
          l20_2 = x20 * x20 + y20 * y20,
          l21 = Math.sqrt(l21_2),
          l01 = Math.sqrt(l01_2),
          l = r * Math.tan((pi - Math.acos((l21_2 + l01_2 - l20_2) / (2 * l21 * l01))) / 2),
          t01 = l / l01,
          t21 = l / l21;

      // If the start tangent is not coincident with (x0,y0), line to.
      if (Math.abs(t01 - 1) > epsilon) {
        this._ += "L" + (x1 + t01 * x01) + "," + (y1 + t01 * y01);
      }

      this._ += "A" + r + "," + r + ",0,0," + (+(y01 * x20 > x01 * y20)) + "," + (this._x1 = x1 + t21 * x21) + "," + (this._y1 = y1 + t21 * y21);
    }
  },
  arc: function(x, y, r, a0, a1, ccw) {
    x = +x, y = +y, r = +r;
    var dx = r * Math.cos(a0),
        dy = r * Math.sin(a0),
        x0 = x + dx,
        y0 = y + dy,
        cw = 1 ^ ccw,
        da = ccw ? a0 - a1 : a1 - a0;

    // Is the radius negative? Error.
    if (r < 0) throw new Error("negative radius: " + r);

    // Is this path empty? Move to (x0,y0).
    if (this._x1 === null) {
      this._ += "M" + x0 + "," + y0;
    }

    // Or, is (x0,y0) not coincident with the previous point? Line to (x0,y0).
    else if (Math.abs(this._x1 - x0) > epsilon || Math.abs(this._y1 - y0) > epsilon) {
      this._ += "L" + x0 + "," + y0;
    }

    // Is this arc empty? We’re done.
    if (!r) return;

    // Does the angle go the wrong way? Flip the direction.
    if (da < 0) da = da % tau + tau;

    // Is this a complete circle? Draw two arcs to complete the circle.
    if (da > tauEpsilon) {
      this._ += "A" + r + "," + r + ",0,1," + cw + "," + (x - dx) + "," + (y - dy) + "A" + r + "," + r + ",0,1," + cw + "," + (this._x1 = x0) + "," + (this._y1 = y0);
    }

    // Is this arc non-empty? Draw an arc!
    else if (da > epsilon) {
      this._ += "A" + r + "," + r + ",0," + (+(da >= pi)) + "," + cw + "," + (this._x1 = x + r * Math.cos(a1)) + "," + (this._y1 = y + r * Math.sin(a1));
    }
  },
  rect: function(x, y, w, h) {
    this._ += "M" + (this._x0 = this._x1 = +x) + "," + (this._y0 = this._y1 = +y) + "h" + (+w) + "v" + (+h) + "h" + (-w) + "Z";
  },
  toString: function() {
    return this._;
  }
};

/* harmony default export */ __webpack_exports__["a"] = (path);


/***/ }),
/* 263 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__constant__ = __webpack_require__(22);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__descending__ = __webpack_require__(264);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__identity__ = __webpack_require__(265);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__math__ = __webpack_require__(31);





/* harmony default export */ __webpack_exports__["a"] = (function() {
  var value = __WEBPACK_IMPORTED_MODULE_2__identity__["a" /* default */],
      sortValues = __WEBPACK_IMPORTED_MODULE_1__descending__["a" /* default */],
      sort = null,
      startAngle = Object(__WEBPACK_IMPORTED_MODULE_0__constant__["a" /* default */])(0),
      endAngle = Object(__WEBPACK_IMPORTED_MODULE_0__constant__["a" /* default */])(__WEBPACK_IMPORTED_MODULE_3__math__["m" /* tau */]),
      padAngle = Object(__WEBPACK_IMPORTED_MODULE_0__constant__["a" /* default */])(0);

  function pie(data) {
    var i,
        n = data.length,
        j,
        k,
        sum = 0,
        index = new Array(n),
        arcs = new Array(n),
        a0 = +startAngle.apply(this, arguments),
        da = Math.min(__WEBPACK_IMPORTED_MODULE_3__math__["m" /* tau */], Math.max(-__WEBPACK_IMPORTED_MODULE_3__math__["m" /* tau */], endAngle.apply(this, arguments) - a0)),
        a1,
        p = Math.min(Math.abs(da) / n, padAngle.apply(this, arguments)),
        pa = p * (da < 0 ? -1 : 1),
        v;

    for (i = 0; i < n; ++i) {
      if ((v = arcs[index[i] = i] = +value(data[i], i, data)) > 0) {
        sum += v;
      }
    }

    // Optionally sort the arcs by previously-computed values or by data.
    if (sortValues != null) index.sort(function(i, j) { return sortValues(arcs[i], arcs[j]); });
    else if (sort != null) index.sort(function(i, j) { return sort(data[i], data[j]); });

    // Compute the arcs! They are stored in the original data's order.
    for (i = 0, k = sum ? (da - n * pa) / sum : 0; i < n; ++i, a0 = a1) {
      j = index[i], v = arcs[j], a1 = a0 + (v > 0 ? v * k : 0) + pa, arcs[j] = {
        data: data[j],
        index: i,
        value: v,
        startAngle: a0,
        endAngle: a1,
        padAngle: p
      };
    }

    return arcs;
  }

  pie.value = function(_) {
    return arguments.length ? (value = typeof _ === "function" ? _ : Object(__WEBPACK_IMPORTED_MODULE_0__constant__["a" /* default */])(+_), pie) : value;
  };

  pie.sortValues = function(_) {
    return arguments.length ? (sortValues = _, sort = null, pie) : sortValues;
  };

  pie.sort = function(_) {
    return arguments.length ? (sort = _, sortValues = null, pie) : sort;
  };

  pie.startAngle = function(_) {
    return arguments.length ? (startAngle = typeof _ === "function" ? _ : Object(__WEBPACK_IMPORTED_MODULE_0__constant__["a" /* default */])(+_), pie) : startAngle;
  };

  pie.endAngle = function(_) {
    return arguments.length ? (endAngle = typeof _ === "function" ? _ : Object(__WEBPACK_IMPORTED_MODULE_0__constant__["a" /* default */])(+_), pie) : endAngle;
  };

  pie.padAngle = function(_) {
    return arguments.length ? (padAngle = typeof _ === "function" ? _ : Object(__WEBPACK_IMPORTED_MODULE_0__constant__["a" /* default */])(+_), pie) : padAngle;
  };

  return pie;
});


/***/ }),
/* 264 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony default export */ __webpack_exports__["a"] = (function(a, b) {
  return b < a ? -1 : b > a ? 1 : b >= a ? 0 : NaN;
});


/***/ }),
/* 265 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony default export */ __webpack_exports__["a"] = (function(d) {
  return d;
});


/***/ }),
/* 266 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__curve_radial__ = __webpack_require__(106);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__area__ = __webpack_require__(105);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__lineRadial__ = __webpack_require__(107);




/* harmony default export */ __webpack_exports__["a"] = (function() {
  var a = Object(__WEBPACK_IMPORTED_MODULE_1__area__["a" /* default */])().curve(__WEBPACK_IMPORTED_MODULE_0__curve_radial__["a" /* curveRadialLinear */]),
      c = a.curve,
      x0 = a.lineX0,
      x1 = a.lineX1,
      y0 = a.lineY0,
      y1 = a.lineY1;

  a.angle = a.x, delete a.x;
  a.startAngle = a.x0, delete a.x0;
  a.endAngle = a.x1, delete a.x1;
  a.radius = a.y, delete a.y;
  a.innerRadius = a.y0, delete a.y0;
  a.outerRadius = a.y1, delete a.y1;
  a.lineStartAngle = function() { return Object(__WEBPACK_IMPORTED_MODULE_2__lineRadial__["b" /* lineRadial */])(x0()); }, delete a.lineX0;
  a.lineEndAngle = function() { return Object(__WEBPACK_IMPORTED_MODULE_2__lineRadial__["b" /* lineRadial */])(x1()); }, delete a.lineX1;
  a.lineInnerRadius = function() { return Object(__WEBPACK_IMPORTED_MODULE_2__lineRadial__["b" /* lineRadial */])(y0()); }, delete a.lineY0;
  a.lineOuterRadius = function() { return Object(__WEBPACK_IMPORTED_MODULE_2__lineRadial__["b" /* lineRadial */])(y1()); }, delete a.lineY1;

  a.curve = function(_) {
    return arguments.length ? c(Object(__WEBPACK_IMPORTED_MODULE_0__curve_radial__["b" /* default */])(_)) : c()._curve;
  };

  return a;
});


/***/ }),
/* 267 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (immutable) */ __webpack_exports__["a"] = linkHorizontal;
/* harmony export (immutable) */ __webpack_exports__["c"] = linkVertical;
/* harmony export (immutable) */ __webpack_exports__["b"] = linkRadial;
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_d3_path__ = __webpack_require__(30);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__array__ = __webpack_require__(109);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__constant__ = __webpack_require__(22);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__point__ = __webpack_require__(62);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__pointRadial__ = __webpack_require__(108);






function linkSource(d) {
  return d.source;
}

function linkTarget(d) {
  return d.target;
}

function link(curve) {
  var source = linkSource,
      target = linkTarget,
      x = __WEBPACK_IMPORTED_MODULE_3__point__["a" /* x */],
      y = __WEBPACK_IMPORTED_MODULE_3__point__["b" /* y */],
      context = null;

  function link() {
    var buffer, argv = __WEBPACK_IMPORTED_MODULE_1__array__["a" /* slice */].call(arguments), s = source.apply(this, argv), t = target.apply(this, argv);
    if (!context) context = buffer = Object(__WEBPACK_IMPORTED_MODULE_0_d3_path__["a" /* path */])();
    curve(context, +x.apply(this, (argv[0] = s, argv)), +y.apply(this, argv), +x.apply(this, (argv[0] = t, argv)), +y.apply(this, argv));
    if (buffer) return context = null, buffer + "" || null;
  }

  link.source = function(_) {
    return arguments.length ? (source = _, link) : source;
  };

  link.target = function(_) {
    return arguments.length ? (target = _, link) : target;
  };

  link.x = function(_) {
    return arguments.length ? (x = typeof _ === "function" ? _ : Object(__WEBPACK_IMPORTED_MODULE_2__constant__["a" /* default */])(+_), link) : x;
  };

  link.y = function(_) {
    return arguments.length ? (y = typeof _ === "function" ? _ : Object(__WEBPACK_IMPORTED_MODULE_2__constant__["a" /* default */])(+_), link) : y;
  };

  link.context = function(_) {
    return arguments.length ? ((context = _ == null ? null : _), link) : context;
  };

  return link;
}

function curveHorizontal(context, x0, y0, x1, y1) {
  context.moveTo(x0, y0);
  context.bezierCurveTo(x0 = (x0 + x1) / 2, y0, x0, y1, x1, y1);
}

function curveVertical(context, x0, y0, x1, y1) {
  context.moveTo(x0, y0);
  context.bezierCurveTo(x0, y0 = (y0 + y1) / 2, x1, y0, x1, y1);
}

function curveRadial(context, x0, y0, x1, y1) {
  var p0 = Object(__WEBPACK_IMPORTED_MODULE_4__pointRadial__["a" /* default */])(x0, y0),
      p1 = Object(__WEBPACK_IMPORTED_MODULE_4__pointRadial__["a" /* default */])(x0, y0 = (y0 + y1) / 2),
      p2 = Object(__WEBPACK_IMPORTED_MODULE_4__pointRadial__["a" /* default */])(x1, y0),
      p3 = Object(__WEBPACK_IMPORTED_MODULE_4__pointRadial__["a" /* default */])(x1, y1);
  context.moveTo(p0[0], p0[1]);
  context.bezierCurveTo(p1[0], p1[1], p2[0], p2[1], p3[0], p3[1]);
}

function linkHorizontal() {
  return link(curveHorizontal);
}

function linkVertical() {
  return link(curveVertical);
}

function linkRadial() {
  var l = link(curveRadial);
  l.angle = l.x, delete l.x;
  l.radius = l.y, delete l.y;
  return l;
}


/***/ }),
/* 268 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "b", function() { return symbols; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_d3_path__ = __webpack_require__(30);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__symbol_circle__ = __webpack_require__(110);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__symbol_cross__ = __webpack_require__(111);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__symbol_diamond__ = __webpack_require__(112);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__symbol_star__ = __webpack_require__(113);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5__symbol_square__ = __webpack_require__(114);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_6__symbol_triangle__ = __webpack_require__(115);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_7__symbol_wye__ = __webpack_require__(116);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_8__constant__ = __webpack_require__(22);










var symbols = [
  __WEBPACK_IMPORTED_MODULE_1__symbol_circle__["a" /* default */],
  __WEBPACK_IMPORTED_MODULE_2__symbol_cross__["a" /* default */],
  __WEBPACK_IMPORTED_MODULE_3__symbol_diamond__["a" /* default */],
  __WEBPACK_IMPORTED_MODULE_5__symbol_square__["a" /* default */],
  __WEBPACK_IMPORTED_MODULE_4__symbol_star__["a" /* default */],
  __WEBPACK_IMPORTED_MODULE_6__symbol_triangle__["a" /* default */],
  __WEBPACK_IMPORTED_MODULE_7__symbol_wye__["a" /* default */]
];

/* harmony default export */ __webpack_exports__["a"] = (function() {
  var type = Object(__WEBPACK_IMPORTED_MODULE_8__constant__["a" /* default */])(__WEBPACK_IMPORTED_MODULE_1__symbol_circle__["a" /* default */]),
      size = Object(__WEBPACK_IMPORTED_MODULE_8__constant__["a" /* default */])(64),
      context = null;

  function symbol() {
    var buffer;
    if (!context) context = buffer = Object(__WEBPACK_IMPORTED_MODULE_0_d3_path__["a" /* path */])();
    type.apply(this, arguments).draw(context, +size.apply(this, arguments));
    if (buffer) return context = null, buffer + "" || null;
  }

  symbol.type = function(_) {
    return arguments.length ? (type = typeof _ === "function" ? _ : Object(__WEBPACK_IMPORTED_MODULE_8__constant__["a" /* default */])(_), symbol) : type;
  };

  symbol.size = function(_) {
    return arguments.length ? (size = typeof _ === "function" ? _ : Object(__WEBPACK_IMPORTED_MODULE_8__constant__["a" /* default */])(+_), symbol) : size;
  };

  symbol.context = function(_) {
    return arguments.length ? (context = _ == null ? null : _, symbol) : context;
  };

  return symbol;
});


/***/ }),
/* 269 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__noop__ = __webpack_require__(40);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__basis__ = __webpack_require__(41);



function BasisClosed(context) {
  this._context = context;
}

BasisClosed.prototype = {
  areaStart: __WEBPACK_IMPORTED_MODULE_0__noop__["a" /* default */],
  areaEnd: __WEBPACK_IMPORTED_MODULE_0__noop__["a" /* default */],
  lineStart: function() {
    this._x0 = this._x1 = this._x2 = this._x3 = this._x4 =
    this._y0 = this._y1 = this._y2 = this._y3 = this._y4 = NaN;
    this._point = 0;
  },
  lineEnd: function() {
    switch (this._point) {
      case 1: {
        this._context.moveTo(this._x2, this._y2);
        this._context.closePath();
        break;
      }
      case 2: {
        this._context.moveTo((this._x2 + 2 * this._x3) / 3, (this._y2 + 2 * this._y3) / 3);
        this._context.lineTo((this._x3 + 2 * this._x2) / 3, (this._y3 + 2 * this._y2) / 3);
        this._context.closePath();
        break;
      }
      case 3: {
        this.point(this._x2, this._y2);
        this.point(this._x3, this._y3);
        this.point(this._x4, this._y4);
        break;
      }
    }
  },
  point: function(x, y) {
    x = +x, y = +y;
    switch (this._point) {
      case 0: this._point = 1; this._x2 = x, this._y2 = y; break;
      case 1: this._point = 2; this._x3 = x, this._y3 = y; break;
      case 2: this._point = 3; this._x4 = x, this._y4 = y; this._context.moveTo((this._x0 + 4 * this._x1 + x) / 6, (this._y0 + 4 * this._y1 + y) / 6); break;
      default: Object(__WEBPACK_IMPORTED_MODULE_1__basis__["c" /* point */])(this, x, y); break;
    }
    this._x0 = this._x1, this._x1 = x;
    this._y0 = this._y1, this._y1 = y;
  }
};

/* harmony default export */ __webpack_exports__["a"] = (function(context) {
  return new BasisClosed(context);
});


/***/ }),
/* 270 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__basis__ = __webpack_require__(41);


function BasisOpen(context) {
  this._context = context;
}

BasisOpen.prototype = {
  areaStart: function() {
    this._line = 0;
  },
  areaEnd: function() {
    this._line = NaN;
  },
  lineStart: function() {
    this._x0 = this._x1 =
    this._y0 = this._y1 = NaN;
    this._point = 0;
  },
  lineEnd: function() {
    if (this._line || (this._line !== 0 && this._point === 3)) this._context.closePath();
    this._line = 1 - this._line;
  },
  point: function(x, y) {
    x = +x, y = +y;
    switch (this._point) {
      case 0: this._point = 1; break;
      case 1: this._point = 2; break;
      case 2: this._point = 3; var x0 = (this._x0 + 4 * this._x1 + x) / 6, y0 = (this._y0 + 4 * this._y1 + y) / 6; this._line ? this._context.lineTo(x0, y0) : this._context.moveTo(x0, y0); break;
      case 3: this._point = 4; // proceed
      default: Object(__WEBPACK_IMPORTED_MODULE_0__basis__["c" /* point */])(this, x, y); break;
    }
    this._x0 = this._x1, this._x1 = x;
    this._y0 = this._y1, this._y1 = y;
  }
};

/* harmony default export */ __webpack_exports__["a"] = (function(context) {
  return new BasisOpen(context);
});


/***/ }),
/* 271 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__basis__ = __webpack_require__(41);


function Bundle(context, beta) {
  this._basis = new __WEBPACK_IMPORTED_MODULE_0__basis__["a" /* Basis */](context);
  this._beta = beta;
}

Bundle.prototype = {
  lineStart: function() {
    this._x = [];
    this._y = [];
    this._basis.lineStart();
  },
  lineEnd: function() {
    var x = this._x,
        y = this._y,
        j = x.length - 1;

    if (j > 0) {
      var x0 = x[0],
          y0 = y[0],
          dx = x[j] - x0,
          dy = y[j] - y0,
          i = -1,
          t;

      while (++i <= j) {
        t = i / j;
        this._basis.point(
          this._beta * x[i] + (1 - this._beta) * (x0 + t * dx),
          this._beta * y[i] + (1 - this._beta) * (y0 + t * dy)
        );
      }
    }

    this._x = this._y = null;
    this._basis.lineEnd();
  },
  point: function(x, y) {
    this._x.push(+x);
    this._y.push(+y);
  }
};

/* harmony default export */ __webpack_exports__["a"] = ((function custom(beta) {

  function bundle(context) {
    return beta === 1 ? new __WEBPACK_IMPORTED_MODULE_0__basis__["a" /* Basis */](context) : new Bundle(context, beta);
  }

  bundle.beta = function(beta) {
    return custom(+beta);
  };

  return bundle;
})(0.85));


/***/ }),
/* 272 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__cardinalClosed__ = __webpack_require__(117);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__noop__ = __webpack_require__(40);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__catmullRom__ = __webpack_require__(63);




function CatmullRomClosed(context, alpha) {
  this._context = context;
  this._alpha = alpha;
}

CatmullRomClosed.prototype = {
  areaStart: __WEBPACK_IMPORTED_MODULE_1__noop__["a" /* default */],
  areaEnd: __WEBPACK_IMPORTED_MODULE_1__noop__["a" /* default */],
  lineStart: function() {
    this._x0 = this._x1 = this._x2 = this._x3 = this._x4 = this._x5 =
    this._y0 = this._y1 = this._y2 = this._y3 = this._y4 = this._y5 = NaN;
    this._l01_a = this._l12_a = this._l23_a =
    this._l01_2a = this._l12_2a = this._l23_2a =
    this._point = 0;
  },
  lineEnd: function() {
    switch (this._point) {
      case 1: {
        this._context.moveTo(this._x3, this._y3);
        this._context.closePath();
        break;
      }
      case 2: {
        this._context.lineTo(this._x3, this._y3);
        this._context.closePath();
        break;
      }
      case 3: {
        this.point(this._x3, this._y3);
        this.point(this._x4, this._y4);
        this.point(this._x5, this._y5);
        break;
      }
    }
  },
  point: function(x, y) {
    x = +x, y = +y;

    if (this._point) {
      var x23 = this._x2 - x,
          y23 = this._y2 - y;
      this._l23_a = Math.sqrt(this._l23_2a = Math.pow(x23 * x23 + y23 * y23, this._alpha));
    }

    switch (this._point) {
      case 0: this._point = 1; this._x3 = x, this._y3 = y; break;
      case 1: this._point = 2; this._context.moveTo(this._x4 = x, this._y4 = y); break;
      case 2: this._point = 3; this._x5 = x, this._y5 = y; break;
      default: Object(__WEBPACK_IMPORTED_MODULE_2__catmullRom__["b" /* point */])(this, x, y); break;
    }

    this._l01_a = this._l12_a, this._l12_a = this._l23_a;
    this._l01_2a = this._l12_2a, this._l12_2a = this._l23_2a;
    this._x0 = this._x1, this._x1 = this._x2, this._x2 = x;
    this._y0 = this._y1, this._y1 = this._y2, this._y2 = y;
  }
};

/* harmony default export */ __webpack_exports__["a"] = ((function custom(alpha) {

  function catmullRom(context) {
    return alpha ? new CatmullRomClosed(context, alpha) : new __WEBPACK_IMPORTED_MODULE_0__cardinalClosed__["a" /* CardinalClosed */](context, 0);
  }

  catmullRom.alpha = function(alpha) {
    return custom(+alpha);
  };

  return catmullRom;
})(0.5));


/***/ }),
/* 273 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__cardinalOpen__ = __webpack_require__(118);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__catmullRom__ = __webpack_require__(63);



function CatmullRomOpen(context, alpha) {
  this._context = context;
  this._alpha = alpha;
}

CatmullRomOpen.prototype = {
  areaStart: function() {
    this._line = 0;
  },
  areaEnd: function() {
    this._line = NaN;
  },
  lineStart: function() {
    this._x0 = this._x1 = this._x2 =
    this._y0 = this._y1 = this._y2 = NaN;
    this._l01_a = this._l12_a = this._l23_a =
    this._l01_2a = this._l12_2a = this._l23_2a =
    this._point = 0;
  },
  lineEnd: function() {
    if (this._line || (this._line !== 0 && this._point === 3)) this._context.closePath();
    this._line = 1 - this._line;
  },
  point: function(x, y) {
    x = +x, y = +y;

    if (this._point) {
      var x23 = this._x2 - x,
          y23 = this._y2 - y;
      this._l23_a = Math.sqrt(this._l23_2a = Math.pow(x23 * x23 + y23 * y23, this._alpha));
    }

    switch (this._point) {
      case 0: this._point = 1; break;
      case 1: this._point = 2; break;
      case 2: this._point = 3; this._line ? this._context.lineTo(this._x2, this._y2) : this._context.moveTo(this._x2, this._y2); break;
      case 3: this._point = 4; // proceed
      default: Object(__WEBPACK_IMPORTED_MODULE_1__catmullRom__["b" /* point */])(this, x, y); break;
    }

    this._l01_a = this._l12_a, this._l12_a = this._l23_a;
    this._l01_2a = this._l12_2a, this._l12_2a = this._l23_2a;
    this._x0 = this._x1, this._x1 = this._x2, this._x2 = x;
    this._y0 = this._y1, this._y1 = this._y2, this._y2 = y;
  }
};

/* harmony default export */ __webpack_exports__["a"] = ((function custom(alpha) {

  function catmullRom(context) {
    return alpha ? new CatmullRomOpen(context, alpha) : new __WEBPACK_IMPORTED_MODULE_0__cardinalOpen__["a" /* CardinalOpen */](context, 0);
  }

  catmullRom.alpha = function(alpha) {
    return custom(+alpha);
  };

  return catmullRom;
})(0.5));


/***/ }),
/* 274 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__noop__ = __webpack_require__(40);


function LinearClosed(context) {
  this._context = context;
}

LinearClosed.prototype = {
  areaStart: __WEBPACK_IMPORTED_MODULE_0__noop__["a" /* default */],
  areaEnd: __WEBPACK_IMPORTED_MODULE_0__noop__["a" /* default */],
  lineStart: function() {
    this._point = 0;
  },
  lineEnd: function() {
    if (this._point) this._context.closePath();
  },
  point: function(x, y) {
    x = +x, y = +y;
    if (this._point) this._context.lineTo(x, y);
    else this._point = 1, this._context.moveTo(x, y);
  }
};

/* harmony default export */ __webpack_exports__["a"] = (function(context) {
  return new LinearClosed(context);
});


/***/ }),
/* 275 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (immutable) */ __webpack_exports__["a"] = monotoneX;
/* harmony export (immutable) */ __webpack_exports__["b"] = monotoneY;
function sign(x) {
  return x < 0 ? -1 : 1;
}

// Calculate the slopes of the tangents (Hermite-type interpolation) based on
// the following paper: Steffen, M. 1990. A Simple Method for Monotonic
// Interpolation in One Dimension. Astronomy and Astrophysics, Vol. 239, NO.
// NOV(II), P. 443, 1990.
function slope3(that, x2, y2) {
  var h0 = that._x1 - that._x0,
      h1 = x2 - that._x1,
      s0 = (that._y1 - that._y0) / (h0 || h1 < 0 && -0),
      s1 = (y2 - that._y1) / (h1 || h0 < 0 && -0),
      p = (s0 * h1 + s1 * h0) / (h0 + h1);
  return (sign(s0) + sign(s1)) * Math.min(Math.abs(s0), Math.abs(s1), 0.5 * Math.abs(p)) || 0;
}

// Calculate a one-sided slope.
function slope2(that, t) {
  var h = that._x1 - that._x0;
  return h ? (3 * (that._y1 - that._y0) / h - t) / 2 : t;
}

// According to https://en.wikipedia.org/wiki/Cubic_Hermite_spline#Representations
// "you can express cubic Hermite interpolation in terms of cubic Bézier curves
// with respect to the four values p0, p0 + m0 / 3, p1 - m1 / 3, p1".
function point(that, t0, t1) {
  var x0 = that._x0,
      y0 = that._y0,
      x1 = that._x1,
      y1 = that._y1,
      dx = (x1 - x0) / 3;
  that._context.bezierCurveTo(x0 + dx, y0 + dx * t0, x1 - dx, y1 - dx * t1, x1, y1);
}

function MonotoneX(context) {
  this._context = context;
}

MonotoneX.prototype = {
  areaStart: function() {
    this._line = 0;
  },
  areaEnd: function() {
    this._line = NaN;
  },
  lineStart: function() {
    this._x0 = this._x1 =
    this._y0 = this._y1 =
    this._t0 = NaN;
    this._point = 0;
  },
  lineEnd: function() {
    switch (this._point) {
      case 2: this._context.lineTo(this._x1, this._y1); break;
      case 3: point(this, this._t0, slope2(this, this._t0)); break;
    }
    if (this._line || (this._line !== 0 && this._point === 1)) this._context.closePath();
    this._line = 1 - this._line;
  },
  point: function(x, y) {
    var t1 = NaN;

    x = +x, y = +y;
    if (x === this._x1 && y === this._y1) return; // Ignore coincident points.
    switch (this._point) {
      case 0: this._point = 1; this._line ? this._context.lineTo(x, y) : this._context.moveTo(x, y); break;
      case 1: this._point = 2; break;
      case 2: this._point = 3; point(this, slope2(this, t1 = slope3(this, x, y)), t1); break;
      default: point(this, this._t0, t1 = slope3(this, x, y)); break;
    }

    this._x0 = this._x1, this._x1 = x;
    this._y0 = this._y1, this._y1 = y;
    this._t0 = t1;
  }
}

function MonotoneY(context) {
  this._context = new ReflectContext(context);
}

(MonotoneY.prototype = Object.create(MonotoneX.prototype)).point = function(x, y) {
  MonotoneX.prototype.point.call(this, y, x);
};

function ReflectContext(context) {
  this._context = context;
}

ReflectContext.prototype = {
  moveTo: function(x, y) { this._context.moveTo(y, x); },
  closePath: function() { this._context.closePath(); },
  lineTo: function(x, y) { this._context.lineTo(y, x); },
  bezierCurveTo: function(x1, y1, x2, y2, x, y) { this._context.bezierCurveTo(y1, x1, y2, x2, y, x); }
};

function monotoneX(context) {
  return new MonotoneX(context);
}

function monotoneY(context) {
  return new MonotoneY(context);
}


/***/ }),
/* 276 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
function Natural(context) {
  this._context = context;
}

Natural.prototype = {
  areaStart: function() {
    this._line = 0;
  },
  areaEnd: function() {
    this._line = NaN;
  },
  lineStart: function() {
    this._x = [];
    this._y = [];
  },
  lineEnd: function() {
    var x = this._x,
        y = this._y,
        n = x.length;

    if (n) {
      this._line ? this._context.lineTo(x[0], y[0]) : this._context.moveTo(x[0], y[0]);
      if (n === 2) {
        this._context.lineTo(x[1], y[1]);
      } else {
        var px = controlPoints(x),
            py = controlPoints(y);
        for (var i0 = 0, i1 = 1; i1 < n; ++i0, ++i1) {
          this._context.bezierCurveTo(px[0][i0], py[0][i0], px[1][i0], py[1][i0], x[i1], y[i1]);
        }
      }
    }

    if (this._line || (this._line !== 0 && n === 1)) this._context.closePath();
    this._line = 1 - this._line;
    this._x = this._y = null;
  },
  point: function(x, y) {
    this._x.push(+x);
    this._y.push(+y);
  }
};

// See https://www.particleincell.com/2012/bezier-splines/ for derivation.
function controlPoints(x) {
  var i,
      n = x.length - 1,
      m,
      a = new Array(n),
      b = new Array(n),
      r = new Array(n);
  a[0] = 0, b[0] = 2, r[0] = x[0] + 2 * x[1];
  for (i = 1; i < n - 1; ++i) a[i] = 1, b[i] = 4, r[i] = 4 * x[i] + 2 * x[i + 1];
  a[n - 1] = 2, b[n - 1] = 7, r[n - 1] = 8 * x[n - 1] + x[n];
  for (i = 1; i < n; ++i) m = a[i] / b[i - 1], b[i] -= m, r[i] -= m * r[i - 1];
  a[n - 1] = r[n - 1] / b[n - 1];
  for (i = n - 2; i >= 0; --i) a[i] = (r[i] - a[i + 1]) / b[i];
  b[n - 1] = (x[n] + a[n - 1]) / 2;
  for (i = 0; i < n - 1; ++i) b[i] = 2 * x[i + 1] - a[i + 1];
  return [a, b];
}

/* harmony default export */ __webpack_exports__["a"] = (function(context) {
  return new Natural(context);
});


/***/ }),
/* 277 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (immutable) */ __webpack_exports__["c"] = stepBefore;
/* harmony export (immutable) */ __webpack_exports__["b"] = stepAfter;
function Step(context, t) {
  this._context = context;
  this._t = t;
}

Step.prototype = {
  areaStart: function() {
    this._line = 0;
  },
  areaEnd: function() {
    this._line = NaN;
  },
  lineStart: function() {
    this._x = this._y = NaN;
    this._point = 0;
  },
  lineEnd: function() {
    if (0 < this._t && this._t < 1 && this._point === 2) this._context.lineTo(this._x, this._y);
    if (this._line || (this._line !== 0 && this._point === 1)) this._context.closePath();
    if (this._line >= 0) this._t = 1 - this._t, this._line = 1 - this._line;
  },
  point: function(x, y) {
    x = +x, y = +y;
    switch (this._point) {
      case 0: this._point = 1; this._line ? this._context.lineTo(x, y) : this._context.moveTo(x, y); break;
      case 1: this._point = 2; // proceed
      default: {
        if (this._t <= 0) {
          this._context.lineTo(this._x, y);
          this._context.lineTo(x, y);
        } else {
          var x1 = this._x * (1 - this._t) + x * this._t;
          this._context.lineTo(x1, this._y);
          this._context.lineTo(x1, y);
        }
        break;
      }
    }
    this._x = x, this._y = y;
  }
};

/* harmony default export */ __webpack_exports__["a"] = (function(context) {
  return new Step(context, 0.5);
});

function stepBefore(context) {
  return new Step(context, 0);
}

function stepAfter(context) {
  return new Step(context, 1);
}


/***/ }),
/* 278 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__array__ = __webpack_require__(109);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__constant__ = __webpack_require__(22);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__offset_none__ = __webpack_require__(32);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__order_none__ = __webpack_require__(33);





function stackValue(d, key) {
  return d[key];
}

/* harmony default export */ __webpack_exports__["a"] = (function() {
  var keys = Object(__WEBPACK_IMPORTED_MODULE_1__constant__["a" /* default */])([]),
      order = __WEBPACK_IMPORTED_MODULE_3__order_none__["a" /* default */],
      offset = __WEBPACK_IMPORTED_MODULE_2__offset_none__["a" /* default */],
      value = stackValue;

  function stack(data) {
    var kz = keys.apply(this, arguments),
        i,
        m = data.length,
        n = kz.length,
        sz = new Array(n),
        oz;

    for (i = 0; i < n; ++i) {
      for (var ki = kz[i], si = sz[i] = new Array(m), j = 0, sij; j < m; ++j) {
        si[j] = sij = [0, +value(data[j], ki, j, data)];
        sij.data = data[j];
      }
      si.key = ki;
    }

    for (i = 0, oz = order(sz); i < n; ++i) {
      sz[oz[i]].index = i;
    }

    offset(sz, oz);
    return sz;
  }

  stack.keys = function(_) {
    return arguments.length ? (keys = typeof _ === "function" ? _ : Object(__WEBPACK_IMPORTED_MODULE_1__constant__["a" /* default */])(__WEBPACK_IMPORTED_MODULE_0__array__["a" /* slice */].call(_)), stack) : keys;
  };

  stack.value = function(_) {
    return arguments.length ? (value = typeof _ === "function" ? _ : Object(__WEBPACK_IMPORTED_MODULE_1__constant__["a" /* default */])(+_), stack) : value;
  };

  stack.order = function(_) {
    return arguments.length ? (order = _ == null ? __WEBPACK_IMPORTED_MODULE_3__order_none__["a" /* default */] : typeof _ === "function" ? _ : Object(__WEBPACK_IMPORTED_MODULE_1__constant__["a" /* default */])(__WEBPACK_IMPORTED_MODULE_0__array__["a" /* slice */].call(_)), stack) : order;
  };

  stack.offset = function(_) {
    return arguments.length ? (offset = _ == null ? __WEBPACK_IMPORTED_MODULE_2__offset_none__["a" /* default */] : _, stack) : offset;
  };

  return stack;
});


/***/ }),
/* 279 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__none__ = __webpack_require__(32);


/* harmony default export */ __webpack_exports__["a"] = (function(series, order) {
  if (!((n = series.length) > 0)) return;
  for (var i, n, j = 0, m = series[0].length, y; j < m; ++j) {
    for (y = i = 0; i < n; ++i) y += series[i][j][1] || 0;
    if (y) for (i = 0; i < n; ++i) series[i][j][1] /= y;
  }
  Object(__WEBPACK_IMPORTED_MODULE_0__none__["a" /* default */])(series, order);
});


/***/ }),
/* 280 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony default export */ __webpack_exports__["a"] = (function(series, order) {
  if (!((n = series.length) > 1)) return;
  for (var i, j = 0, d, dy, yp, yn, n, m = series[order[0]].length; j < m; ++j) {
    for (yp = yn = 0, i = 0; i < n; ++i) {
      if ((dy = (d = series[order[i]][j])[1] - d[0]) >= 0) {
        d[0] = yp, d[1] = yp += dy;
      } else if (dy < 0) {
        d[1] = yn, d[0] = yn += dy;
      } else {
        d[0] = yp;
      }
    }
  }
});


/***/ }),
/* 281 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__none__ = __webpack_require__(32);


/* harmony default export */ __webpack_exports__["a"] = (function(series, order) {
  if (!((n = series.length) > 0)) return;
  for (var j = 0, s0 = series[order[0]], n, m = s0.length; j < m; ++j) {
    for (var i = 0, y = 0; i < n; ++i) y += series[i][j][1] || 0;
    s0[j][1] += s0[j][0] = -y / 2;
  }
  Object(__WEBPACK_IMPORTED_MODULE_0__none__["a" /* default */])(series, order);
});


/***/ }),
/* 282 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__none__ = __webpack_require__(32);


/* harmony default export */ __webpack_exports__["a"] = (function(series, order) {
  if (!((n = series.length) > 0) || !((m = (s0 = series[order[0]]).length) > 0)) return;
  for (var y = 0, j = 1, s0, m, n; j < m; ++j) {
    for (var i = 0, s1 = 0, s2 = 0; i < n; ++i) {
      var si = series[order[i]],
          sij0 = si[j][1] || 0,
          sij1 = si[j - 1][1] || 0,
          s3 = (sij0 - sij1) / 2;
      for (var k = 0; k < i; ++k) {
        var sk = series[order[k]],
            skj0 = sk[j][1] || 0,
            skj1 = sk[j - 1][1] || 0;
        s3 += skj0 - skj1;
      }
      s1 += sij0, s2 += s3 * sij0;
    }
    s0[j - 1][1] += s0[j - 1][0] = y;
    if (s1) y -= s2 / s1;
  }
  s0[j - 1][1] += s0[j - 1][0] = y;
  Object(__WEBPACK_IMPORTED_MODULE_0__none__["a" /* default */])(series, order);
});


/***/ }),
/* 283 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__ascending__ = __webpack_require__(64);


/* harmony default export */ __webpack_exports__["a"] = (function(series) {
  return Object(__WEBPACK_IMPORTED_MODULE_0__ascending__["a" /* default */])(series).reverse();
});


/***/ }),
/* 284 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__none__ = __webpack_require__(33);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__ascending__ = __webpack_require__(64);



/* harmony default export */ __webpack_exports__["a"] = (function(series) {
  var n = series.length,
      i,
      j,
      sums = series.map(__WEBPACK_IMPORTED_MODULE_1__ascending__["b" /* sum */]),
      order = Object(__WEBPACK_IMPORTED_MODULE_0__none__["a" /* default */])(series).sort(function(a, b) { return sums[b] - sums[a]; }),
      top = 0,
      bottom = 0,
      tops = [],
      bottoms = [];

  for (i = 0; i < n; ++i) {
    j = order[i];
    if (top < bottom) {
      top += sums[j];
      tops.push(j);
    } else {
      bottom += sums[j];
      bottoms.push(j);
    }
  }

  return bottoms.reverse().concat(tops);
});


/***/ }),
/* 285 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__none__ = __webpack_require__(33);


/* harmony default export */ __webpack_exports__["a"] = (function(series) {
  return Object(__WEBPACK_IMPORTED_MODULE_0__none__["a" /* default */])(series).reverse();
});


/***/ }),
/* 286 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


module.exports = function () {

    'use strict';

    // Styles inherited from style sheets will not be rendered for elements with these tag names

    var noStyleTags = {
        'BASE': true,
        'HEAD': true,
        'HTML': true,
        'META': true,
        'NOFRAME': true,
        'NOSCRIPT': true,
        'PARAM': true,
        'SCRIPT': true,
        'STYLE': true,
        'TITLE': true
    };

    // This list determines which css default values lookup tables are precomputed at load time
    // Lookup tables for other tag names will be automatically built at runtime if needed
    var tagNames = ['A', 'ABBR', 'ADDRESS', 'AREA', 'ARTICLE', 'ASIDE', 'AUDIO', 'B', 'BASE', 'BDI', 'BDO', 'BLOCKQUOTE', 'BODY', 'BR', 'BUTTON', 'CANVAS', 'CAPTION', 'CENTER', 'CITE', 'CODE', 'COL', 'COLGROUP', 'COMMAND', 'DATALIST', 'DD', 'DEL', 'DETAILS', 'DFN', 'DIV', 'DL', 'DT', 'EM', 'EMBED', 'FIELDSET', 'FIGCAPTION', 'FIGURE', 'FONT', 'FOOTER', 'FORM', 'H1', 'H2', 'H3', 'H4', 'H5', 'H6', 'HEAD', 'HEADER', 'HGROUP', 'HR', 'HTML', 'I', 'IFRAME', 'IMG', 'INPUT', 'INS', 'KBD', 'LABEL', 'LEGEND', 'LI', 'LINK', 'MAP', 'MARK', 'MATH', 'MENU', 'META', 'METER', 'NAV', 'NOBR', 'NOSCRIPT', 'OBJECT', 'OL', 'OPTION', 'OPTGROUP', 'OUTPUT', 'P', 'PARAM', 'PRE', 'PROGRESS', 'Q', 'RP', 'RT', 'RUBY', 'S', 'SAMP', 'SCRIPT', 'SECTION', 'SELECT', 'SMALL', 'SOURCE', 'SPAN', 'STRONG', 'STYLE', 'SUB', 'SUMMARY', 'SUP', 'SVG', 'TABLE', 'TBODY', 'TD', 'TEXTAREA', 'TFOOT', 'TH', 'THEAD', 'TIME', 'TITLE', 'TR', 'TRACK', 'U', 'UL', 'VAR', 'VIDEO', 'WBR'];

    /**
     * Extracts the styles of elements of the given tag name
     * @param {String} tagName  Tag name that we will check for styles
     * @return {Object}         Values of the styles applied to the given element
     */
    var computeDefaultStyleByTagName = function computeDefaultStyleByTagName(tagName) {
        var defaultStyle = {},
            element = document.body.appendChild(document.createElement(tagName)),
            computedStyle = window.getComputedStyle(element);

        [].forEach.call(computedStyle, function (style) {
            defaultStyle[style] = computedStyle[style];
        });
        document.body.removeChild(element);

        return defaultStyle;
    };

    /**
     * Returns a serializer function, only run it when you know you want to serialize your chart
     * @return {func} serializer to add styles in line to dom string
     */
    var initializeSerializer = function initializeSerializer() {
        // Mapping between tag names and css default values lookup tables. This allows to exclude default values in the result.
        var defaultStylesByTagName = {};

        // Precompute the lookup tables.
        [].forEach.call(tagNames, function (name) {
            if (!noStyleTags[name]) {
                defaultStylesByTagName[name] = computeDefaultStyleByTagName(name);
            }
        });

        function getDefaultStyleByTagName(tagName) {
            tagName = tagName.toUpperCase();

            if (!defaultStylesByTagName[tagName]) {
                defaultStylesByTagName[tagName] = computeDefaultStyleByTagName(tagName);
            }

            return defaultStylesByTagName[tagName];
        }

        function serializeWithStyles(elem) {
            var cssTexts = [],
                elements = void 0,
                computedStyle = void 0,
                defaultStyle = void 0,
                result = void 0;

            if (!elem || elem.nodeType !== Node.ELEMENT_NODE) {
                // 'Error: Object passed in to serializeWithSyles not of nodeType Node.ELEMENT_NODE'

                return;
            }

            cssTexts = [];
            elements = elem.querySelectorAll('*');

            [].forEach.call(elements, function (el, i) {
                if (!noStyleTags[el.tagName]) {
                    computedStyle = window.getComputedStyle(el);
                    defaultStyle = getDefaultStyleByTagName(el.tagName);
                    cssTexts[i] = el.style.cssText;
                    [].forEach.call(computedStyle, function (cssPropName) {
                        if (computedStyle[cssPropName] !== defaultStyle[cssPropName]) {
                            el.style[cssPropName] = computedStyle[cssPropName];
                        }
                    });
                }
            });

            result = elem.outerHTML;
            elements = [].map.call(elements, function (el, i) {
                el.style.cssText = cssTexts[i];

                return el;
            });

            return result;
        };

        return serializeWithStyles;
    };

    return {
        initializeSerializer: initializeSerializer
    };
}();

/***/ }),
/* 287 */
/***/ (function(module, exports, __webpack_require__) {

/* WEBPACK VAR INJECTION */(function(module, global) {var __WEBPACK_AMD_DEFINE_RESULT__;/*! http://mths.be/base64 v0.1.0 by @mathias | MIT license */
;(function(root) {

	// Detect free variables `exports`.
	var freeExports = typeof exports == 'object' && exports;

	// Detect free variable `module`.
	var freeModule = typeof module == 'object' && module &&
		module.exports == freeExports && module;

	// Detect free variable `global`, from Node.js or Browserified code, and use
	// it as `root`.
	var freeGlobal = typeof global == 'object' && global;
	if (freeGlobal.global === freeGlobal || freeGlobal.window === freeGlobal) {
		root = freeGlobal;
	}

	/*--------------------------------------------------------------------------*/

	var InvalidCharacterError = function(message) {
		this.message = message;
	};
	InvalidCharacterError.prototype = new Error;
	InvalidCharacterError.prototype.name = 'InvalidCharacterError';

	var error = function(message) {
		// Note: the error messages used throughout this file match those used by
		// the native `atob`/`btoa` implementation in Chromium.
		throw new InvalidCharacterError(message);
	};

	var TABLE = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/';
	// http://whatwg.org/html/common-microsyntaxes.html#space-character
	var REGEX_SPACE_CHARACTERS = /[\t\n\f\r ]/g;

	// `decode` is designed to be fully compatible with `atob` as described in the
	// HTML Standard. http://whatwg.org/html/webappapis.html#dom-windowbase64-atob
	// The optimized base64-decoding algorithm used is based on @atk’s excellent
	// implementation. https://gist.github.com/atk/1020396
	var decode = function(input) {
		input = String(input)
			.replace(REGEX_SPACE_CHARACTERS, '');
		var length = input.length;
		if (length % 4 == 0) {
			input = input.replace(/==?$/, '');
			length = input.length;
		}
		if (
			length % 4 == 1 ||
			// http://whatwg.org/C#alphanumeric-ascii-characters
			/[^+a-zA-Z0-9/]/.test(input)
		) {
			error(
				'Invalid character: the string to be decoded is not correctly encoded.'
			);
		}
		var bitCounter = 0;
		var bitStorage;
		var buffer;
		var output = '';
		var position = -1;
		while (++position < length) {
			buffer = TABLE.indexOf(input.charAt(position));
			bitStorage = bitCounter % 4 ? bitStorage * 64 + buffer : buffer;
			// Unless this is the first of a group of 4 characters…
			if (bitCounter++ % 4) {
				// …convert the first 8 bits to a single ASCII character.
				output += String.fromCharCode(
					0xFF & bitStorage >> (-2 * bitCounter & 6)
				);
			}
		}
		return output;
	};

	// `encode` is designed to be fully compatible with `btoa` as described in the
	// HTML Standard: http://whatwg.org/html/webappapis.html#dom-windowbase64-btoa
	var encode = function(input) {
		input = String(input);
		if (/[^\0-\xFF]/.test(input)) {
			// Note: no need to special-case astral symbols here, as surrogates are
			// matched, and the input is supposed to only contain ASCII anyway.
			error(
				'The string to be encoded contains characters outside of the ' +
				'Latin1 range.'
			);
		}
		var padding = input.length % 3;
		var output = '';
		var position = -1;
		var a;
		var b;
		var c;
		var d;
		var buffer;
		// Make sure any padding is handled outside of the loop.
		var length = input.length - padding;

		while (++position < length) {
			// Read three bytes, i.e. 24 bits.
			a = input.charCodeAt(position) << 16;
			b = input.charCodeAt(++position) << 8;
			c = input.charCodeAt(++position);
			buffer = a + b + c;
			// Turn the 24 bits into four chunks of 6 bits each, and append the
			// matching character for each of them to the output.
			output += (
				TABLE.charAt(buffer >> 18 & 0x3F) +
				TABLE.charAt(buffer >> 12 & 0x3F) +
				TABLE.charAt(buffer >> 6 & 0x3F) +
				TABLE.charAt(buffer & 0x3F)
			);
		}

		if (padding == 2) {
			a = input.charCodeAt(position) << 8;
			b = input.charCodeAt(++position);
			buffer = a + b;
			output += (
				TABLE.charAt(buffer >> 10) +
				TABLE.charAt((buffer >> 4) & 0x3F) +
				TABLE.charAt((buffer << 2) & 0x3F) +
				'='
			);
		} else if (padding == 1) {
			buffer = input.charCodeAt(position);
			output += (
				TABLE.charAt(buffer >> 2) +
				TABLE.charAt((buffer << 4) & 0x3F) +
				'=='
			);
		}

		return output;
	};

	var base64 = {
		'encode': encode,
		'decode': decode,
		'version': '0.1.0'
	};

	// Some AMD build optimizers, like r.js, check for specific condition patterns
	// like the following:
	if (
		true
	) {
		!(__WEBPACK_AMD_DEFINE_RESULT__ = function() {
			return base64;
		}.call(exports, __webpack_require__, exports, module),
				__WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));
	}	else if (freeExports && !freeExports.nodeType) {
		if (freeModule) { // in Node.js or RingoJS v0.8.0+
			freeModule.exports = base64;
		} else { // in Narwhal or RingoJS v0.7.0-
			for (var key in base64) {
				base64.hasOwnProperty(key) && (freeExports[key] = base64[key]);
			}
		}
	} else { // in Rhino or a web browser
		root.base64 = base64;
	}

}(this));

/* WEBPACK VAR INJECTION */}.call(exports, __webpack_require__(288)(module), __webpack_require__(289)))

/***/ }),
/* 288 */
/***/ (function(module, exports) {

module.exports = function(module) {
	if(!module.webpackPolyfill) {
		module.deprecate = function() {};
		module.paths = [];
		// module.parent = undefined by default
		if(!module.children) module.children = [];
		Object.defineProperty(module, "loaded", {
			enumerable: true,
			get: function() {
				return module.l;
			}
		});
		Object.defineProperty(module, "id", {
			enumerable: true,
			get: function() {
				return module.i;
			}
		});
		module.webpackPolyfill = 1;
	}
	return module;
};


/***/ }),
/* 289 */
/***/ (function(module, exports) {

var g;

// This works in non-strict mode
g = (function() {
	return this;
})();

try {
	// This works if eval is allowed (see CSP)
	g = g || Function("return this")() || (1,eval)("this");
} catch(e) {
	// This works if the window reference is available
	if(typeof window === "object")
		g = window;
}

// g can still be undefined, but nothing to do about it...
// We return undefined, instead of nothing here, so it's
// easier to handle this case. if(!global) { ...}

module.exports = g;


/***/ }),
/* 290 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
var __WEBPACK_AMD_DEFINE_RESULT__;

var _extends = Object.assign || function (target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i]; for (var key in source) { if (Object.prototype.hasOwnProperty.call(source, key)) { target[key] = source[key]; } } } return target; };

function _toConsumableArray(arr) { if (Array.isArray(arr)) { for (var i = 0, arr2 = Array(arr.length); i < arr.length; i++) { arr2[i] = arr[i]; } return arr2; } else { return Array.from(arr); } }

!(__WEBPACK_AMD_DEFINE_RESULT__ = function (require) {
    'use strict';

    var d3Dispatch = __webpack_require__(6);
    var d3Ease = __webpack_require__(4);
    var d3Format = __webpack_require__(7);
    var d3Interpolate = __webpack_require__(9);
    var d3Scale = __webpack_require__(8);
    var d3Shape = __webpack_require__(21);
    var d3Selection = __webpack_require__(0);
    var d3Transition = __webpack_require__(3);

    var _require = __webpack_require__(15),
        exportChart = _require.exportChart;

    var textHelper = __webpack_require__(38);
    var colorHelper = __webpack_require__(5);

    var _require2 = __webpack_require__(23),
        calculatePercent = _require2.calculatePercent;

    var _require3 = __webpack_require__(20),
        emptyDonutData = _require3.emptyDonutData;

    var _require4 = __webpack_require__(13),
        donut = _require4.donut;

    /**
     * @typedef DonutChartData
     * @type {Object[]}
     * @property {Number} quantity     Quantity of the group (required)
     * @property {Number} percentage   Percentage of the total (optional)
     * @property {String} name         Name of the group (required)
     * @property {Number} id           Identifier for the group required for legend feature (optional)
     *
     * @example
     * [
     *     {
     *         quantity: 1,
     *         percentage: 50,
     *         name: 'glittering',
     *         id: 1
     *     },
     *     {
     *         quantity: 1,
     *         percentage: 50,
     *         name: 'luminous',
     *         id: 2
     *     }
     * ]
     */

    /**
     * Reusable Donut Chart API class that renders a
     * simple and configurable donut chart.
     *
     * @module Donut
     * @tutorial donut
     * @requires d3-dispatch, d3-ease, d3-interpolate, d3-scale, d3-shape, d3-selection
     *
     * @example
     * var donutChart = donut();
     *
     * donutChart
     *     .externalRadius(500)
     *     .internalRadius(200);
     *
     * d3Selection.select('.css-selector')
     *     .datum(dataset)
     *     .call(donutChart);
     *
     */


    return function module() {
        var margin = {
            top: 0,
            right: 0,
            bottom: 0,
            left: 0
        },
            width = 300,
            height = 300,
            loadingState = donut,
            ease = d3Ease.easeCubicInOut,
            arcTransitionDuration = 750,
            pieDrawingTransitionDuration = 1200,
            pieHoverTransitionDuration = 150,
            radiusHoverOffset = 12,
            paddingAngle = 0,
            data = void 0,
            chartWidth = void 0,
            chartHeight = void 0,
            externalRadius = 140,
            internalRadius = 45.5,
            legendWidth = externalRadius + internalRadius,
            layout = void 0,
            shape = void 0,
            slices = void 0,
            svg = void 0,
            isAnimated = false,
            isEmpty = false,
            highlightedSliceId = void 0,
            highlightedSlice = void 0,
            hasFixedHighlightedSlice = false,
            hasHoverAnimation = true,
            hasLastHoverSliceHighlighted = false,
            lastHighlightedSlice = null,
            emptyDataConfig = {
            emptySliceColor: '#EFF2F5',
            showEmptySlice: false
        },
            quantityLabel = 'quantity',
            nameLabel = 'name',
            percentageLabel = 'percentage',
            percentageFormat = '.1f',
            numberFormat = void 0,


        // colors
        colorScale = void 0,
            colorSchema = colorHelper.colorSchemas.britecharts,
            centeredTextFunction = function centeredTextFunction(d) {
            return d.percentage + '% ' + d.name;
        },


        // utils
        storeAngle = function storeAngle(d) {
            this._current = d;
        },
            reduceOuterRadius = function reduceOuterRadius(d) {
            d.outerRadius = externalRadius - radiusHoverOffset;
        },
            orderingFunction = function orderingFunction(a, b) {
            return b.quantity - a.quantity;
        },
            sumValues = function sumValues(data) {
            return data.reduce(function (total, d) {
                return d.quantity + total;
            }, 0);
        },


        // extractors
        getQuantity = function getQuantity(_ref) {
            var quantity = _ref.quantity;
            return quantity;
        },
            getSliceFill = function getSliceFill(_ref2) {
            var data = _ref2.data;
            return colorScale(data.name);
        },


        // events
        dispatcher = d3Dispatch.dispatch('customMouseOver', 'customMouseOut', 'customMouseMove', 'customClick');

        /**
         * This function creates the graph using the selection as container
         *
         * @param {D3Selection} _selection A d3 selection that represents
         *                                  the container(s) where the chart(s) will be rendered
         * @param {DonutChartData} _data The data to attach and generate the chart
         */
        function exports(_selection) {
            _selection.each(function (_data) {
                chartWidth = width - margin.left - margin.right;
                chartHeight = height - margin.top - margin.bottom;
                data = cleanData(_data);

                buildLayout();
                buildColorScale();
                buildShape();
                buildSVG(this);
                drawSlices();
                initTooltip();

                if (highlightedSliceId) {
                    initHighlightSlice();
                }
                if (isEmpty && emptyDataConfig.showEmptySlice) {
                    drawEmptySlice();
                }
            });
        }

        /**
         * Builds color scale for chart, if any colorSchema was defined
         * @private
         */
        function buildColorScale() {
            if (colorSchema) {
                colorScale = d3Scale.scaleOrdinal().range(colorSchema);
            }
        }

        /**
         * Builds containers for the chart, the legend and a wrapper for all of them
         * @private
         */
        function buildContainerGroups() {
            var container = svg.append('g').classed('container-group', true);

            container.append('g').classed('chart-group', true);
            container.append('g').classed('legend-group', true);
        }

        /**
         * Builds the pie layout that will produce data ready to draw
         * @private
         */
        function buildLayout() {
            layout = d3Shape.pie().padAngle(paddingAngle).value(getQuantity).sort(orderingFunction);
        }

        /**
         * Builds the shape function
         * @private
         */
        function buildShape() {
            shape = d3Shape.arc().innerRadius(internalRadius).padRadius(externalRadius);
        }

        /**
         * Builds the SVG element that will contain the chart
         *
         * @param  {HTMLElement} container DOM element that will work as the container of the graph
         * @private
         */
        function buildSVG(container) {
            if (!svg) {
                svg = d3Selection.select(container).append('svg').classed('britechart donut-chart', true);

                buildContainerGroups();
            }

            // Updates Container Group position
            svg.select('.container-group').attr('transform', 'translate(' + width / 2 + ', ' + height / 2 + ')');

            // Updates SVG size
            svg.attr('width', width).attr('height', height);
        }

        /**
         * Cleaning data casting the quantities, names and percentages to the proper type while keeping
         * the rest of properties on the data. It also calculates the percentages if not present.
         * @param  {DonutChartData} data    Data as passed to the container
         * @return {DonutChartData}         Clean data with percentages
         * @private
         */
        function cleanData(data) {
            var dataWithPercentages = void 0;
            var cleanData = data.reduce(function (acc, d) {
                // Skip data without quantity
                if (d[quantityLabel] === undefined || d[quantityLabel] === null) {
                    return acc;
                }

                d.quantity = +d[quantityLabel];
                d.name = String(d[nameLabel]);
                d.percentage = d[percentageLabel] || null;

                return [].concat(_toConsumableArray(acc), [d]);
            }, []);

            var totalQuantity = sumValues(cleanData);

            if (totalQuantity === 0 && emptyDataConfig.showEmptySlice) {
                isEmpty = true;
            }

            dataWithPercentages = cleanData.map(function (d) {
                d.percentage = String(d.percentage || calculatePercent(d[quantityLabel], totalQuantity, percentageFormat));

                return d;
            });

            return dataWithPercentages;
        }

        /**
         * Cleans any value that could be on the legend text element
         * @private
         */
        function cleanLegend() {
            svg.select('.donut-text').text('');
        }

        /**
         * Draw an empty slice
         * @private
         */
        function drawEmptySlice() {

            if (slices) {
                svg.selectAll('g.arc').remove();
            }
            slices = svg.select('.chart-group').selectAll('g.arc').data(layout(emptyDonutData));

            var newSlices = slices.enter().append('g').each(storeAngle).each(reduceOuterRadius).classed('arc', true).append('path');

            newSlices.merge(slices).attr('fill', emptyDataConfig.emptySliceColor).attr('d', shape).transition().ease(ease).duration(pieDrawingTransitionDuration).attrTween('d', tweenLoading);

            slices.exit().remove();
        }

        /**
         * Draws the values on the donut slice inside the text element
         *
         * @param  {Object} obj Data object
         * @private
         */
        function drawLegend(obj) {
            if (obj.data) {

                svg.select('.donut-text').text(function () {
                    return centeredTextFunction(obj.data);
                }).attr('dy', '.2em').attr('text-anchor', 'middle');

                svg.select('.donut-text').call(wrapText, legendWidth);
            }
        }

        /**
         * Draws the slices of the donut
         * @private
         */
        function drawSlices() {
            // Not ideal, we need to figure out how to call exit for nested elements
            if (slices) {
                svg.selectAll('g.arc').remove();
            }

            slices = svg.select('.chart-group').selectAll('g.arc').data(layout(data));

            var newSlices = slices.enter().append('g').each(storeAngle).each(reduceOuterRadius).classed('arc', true).append('path');

            if (isAnimated) {
                newSlices.merge(slices).attr('fill', getSliceFill).on('mouseover', function (d) {
                    handleMouseOver(this, d, chartWidth, chartHeight);
                }).on('mousemove', function (d) {
                    handleMouseMove(this, d, chartWidth, chartHeight);
                }).on('mouseout', function (d) {
                    handleMouseOut(this, d, chartWidth, chartHeight);
                }).on('click', function (d) {
                    handleClick(this, d, chartWidth, chartHeight);
                }).transition().ease(ease).duration(pieDrawingTransitionDuration).attrTween('d', tweenLoading);
            } else {
                newSlices.merge(slices).attr('fill', getSliceFill).attr('d', shape).on('mouseover', function (d) {
                    handleMouseOver(this, d, chartWidth, chartHeight);
                }).on('mousemove', function (d) {
                    handleMouseMove(this, d, chartWidth, chartHeight);
                }).on('mouseout', function (d) {
                    handleMouseOut(this, d, chartWidth, chartHeight);
                }).on('click', function (d) {
                    handleClick(this, d, chartWidth, chartHeight);
                });
            }

            slices.exit().remove();
        }

        /**
         * Checks if the given element id is the same as the highlightedSliceId and returns the
         * element if that's the case
         * @param  {DOMElement} options.data Dom element to check
         * @return {DOMElement}              Dom element if it has the same id
         */
        function filterHighlightedSlice(_ref3) {
            var data = _ref3.data;

            if (data.id === highlightedSliceId) {
                return this;
            }
        }

        /**
         * Handles a path mouse over
         * @return {void}
         * @private
         */
        function handleMouseOver(el, d, chartWidth, chartHeight) {
            drawLegend(d);
            dispatcher.call('customMouseOver', el, d, d3Selection.mouse(el), [chartWidth, chartHeight]);

            if (hasHoverAnimation) {
                // if the hovered slice is not the same as the last slice hovered
                // after mouseout event, then shrink the last slice that was highlighted
                if (lastHighlightedSlice && el !== lastHighlightedSlice) {
                    tweenGrowth(lastHighlightedSlice, externalRadius - radiusHoverOffset, pieHoverTransitionDuration);
                }
                if (highlightedSlice && el !== highlightedSlice) {
                    tweenGrowth(highlightedSlice, externalRadius - radiusHoverOffset);
                }
                tweenGrowth(el, externalRadius);
            }
        }

        /**
         * Handles a path mouse move
         * @return {void}
         * @private
         */
        function handleMouseMove(el, d, chartWidth, chartHeight) {
            dispatcher.call('customMouseMove', el, d, d3Selection.mouse(el), [chartWidth, chartHeight]);
        }

        /**
         * Handles a path mouse out
         * @return {void}
         * @private
         */
        function handleMouseOut(el, d, chartWidth, chartHeight) {
            cleanLegend();

            // When there is a fixed highlighted slice,
            // we will always highlight it and render legend
            if (highlightedSlice && hasFixedHighlightedSlice && !hasLastHoverSliceHighlighted) {
                drawLegend(highlightedSlice.__data__);
                tweenGrowth(highlightedSlice, externalRadius);
            }

            // When the current slice is not the highlighted, or there isn't a fixed highlighted slice and it is the highlighted
            // we will shrink the slice
            if (el !== highlightedSlice || !hasFixedHighlightedSlice && el === highlightedSlice) {
                tweenGrowth(el, externalRadius - radiusHoverOffset, pieHoverTransitionDuration);
            }

            if (hasLastHoverSliceHighlighted) {
                drawLegend(el.__data__);
                tweenGrowth(el, externalRadius);
                lastHighlightedSlice = el;
            }

            dispatcher.call('customMouseOut', el, d, d3Selection.mouse(el), [chartWidth, chartHeight]);
        }

        /**
         * Handles a path click
         * @return {void}
         * @private
         */
        function handleClick(el, d, chartWidth, chartHeight) {
            dispatcher.call('customClick', el, d, d3Selection.mouse(el), [chartWidth, chartHeight]);
        }

        /**
         * Find the slice by id and growth it if needed
         * @private
         */
        function initHighlightSlice() {
            highlightedSlice = svg.selectAll('.chart-group .arc path').select(filterHighlightedSlice).node();

            if (highlightedSlice) {
                drawLegend(highlightedSlice.__data__);
                tweenGrowth(highlightedSlice, externalRadius, pieDrawingTransitionDuration);
            }
        }

        /**
         * Creates the text element that will hold the legend of the chart
         */
        function initTooltip() {
            svg.select('.legend-group').append('text').attr('class', 'donut-text');
        }

        /**
         * Stores current angles and interpolates with new angles
         * Check out {@link http://bl.ocks.org/mbostock/1346410| this example}
         *
         * @param  {Object}     a   New data for slice
         * @return {Function}       Tweening function for the donut shape
         * @private
         */
        function tweenArc(a) {
            var i = d3Interpolate.interpolate(this._current, a);

            this._current = i(0);

            return function (t) {
                return shape(i(t));
            };
        }

        /**
         * Animate slice with tweens depending on the attributes given
         *
         * @param  {DOMElement} slice   Slice to growth
         * @param  {Number} outerRadius Final outer radius value
         * @param  {Number} delay       Delay of animation
         * @private
         */
        function tweenGrowth(slice, outerRadius) {
            var delay = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : 0;

            d3Selection.select(slice).transition().delay(delay).attrTween('d', function (d) {
                var i = d3Interpolate.interpolate(d.outerRadius, outerRadius);

                return function (t) {
                    d.outerRadius = i(t);

                    return shape(d);
                };
            });
        }

        /**
         * Animation for chart loading
         * Check out {@link http://bl.ocks.org/mbostock/4341574| this example}
         *
         * @param  {Object} b Data point
         * @return {Function}   Tween function
         * @private
         */
        function tweenLoading(b) {
            var i = void 0;

            b.innerRadius = 0;
            i = d3Interpolate.interpolate({ startAngle: 0, endAngle: 0 }, b);

            return function (t) {
                return shape(i(t));
            };
        }

        /**
         * Utility function that wraps a text into the given width
         *
         * @param  {D3Selection} text         Text to write
         * @param  {Number} legendWidth Width of the container
         * @private
         */
        function wrapText(text, legendWidth) {
            var fontSize = externalRadius / 5;

            textHelper.wrapText.call(null, 0, fontSize, legendWidth, text.node());
        }

        // API

        /**
         * Gets or Sets the centeredTextFunction of the chart. If function is provided
         * the format will be changed by the custom function's value format.
         * The default format function value is "${d.percentage}% ${d.name}".
         * The callback will provide the data object with id, name, percentage, and quantity.
         * Also provides the component added by the user in each data entry.
         * @param  {Function} _x        Custom function that returns a formatted string
         * @return {Function | module}  Current centeredTextFunction or Chart module to chain calls
         * @public
         * @example donutChart.centeredTextFunction(d => `${d.id} ${d.quantity}`)
         */
        exports.centeredTextFunction = function (_x) {
            if (!arguments.length) {
                return centeredTextFunction;
            }
            centeredTextFunction = _x;

            return this;
        };

        /**
         * Gets or Sets the colorSchema of the chart
         * @param  {String[]} _x        Desired colorSchema for the graph
         * @return { String | module}   Current colorSchema or Chart module to chain calls
         * @public
         */
        exports.colorSchema = function (_x) {
            if (!arguments.length) {
                return colorSchema;
            }
            colorSchema = _x;

            return this;
        };

        /**
         * Gets or Sets the emptyDataConfig of the chart. If set and data is empty (quantity
         * adds up to zero or there are no entries), the chart will render an empty slice
         * with a given color (light gray by default)
         * @param  {Object} _x emptyDataConfig object to get/set
         * @return { Object | module} Current config for when chart data is an empty array
         * @public
         * @example donutChart.emptyDataConfig({showEmptySlice: true, emptySliceColor: '#000000'})
         */
        exports.emptyDataConfig = function (_x) {
            if (!arguments.length) {
                return emptyDataConfig;
            }
            emptyDataConfig = _x;

            return this;
        };

        /**
         * Chart exported to png and a download action is fired
         * @param {String} filename     File title for the resulting picture
         * @param {String} title        Title to add at the top of the exported picture
         * @public
         */
        exports.exportChart = function (filename, title) {
            exportChart.call(exports, svg, filename, title);
        };

        /**
         * Gets or Sets the externalRadius of the chart
         * @param  {Number} _x              ExternalRadius number to get/set
         * @return { (Number | Module) }    Current externalRadius or Donut Chart module to chain calls
         * @public
         */
        exports.externalRadius = function (_x) {
            if (!arguments.length) {
                return externalRadius;
            }
            externalRadius = _x;

            return this;
        };

        /**
         * Gets or Sets the hasHoverAnimation property of the chart. By default,
         * donut chart highlights the hovered slice. This property explicitly
         * disables this hover behavior.
         * @param  {boolean} _x         Decide whether hover slice animation should be enabled
         * @return {boolean | module}   Current hasHoverAnimation flag or Chart module
         * @public
         */
        exports.hasHoverAnimation = function (_x) {
            if (!arguments.length) {
                return hasHoverAnimation;
            }
            hasHoverAnimation = _x;

            return this;
        };

        /**
         * Gets or Sets the hasFixedHighlightedSlice property of the chart, making it to
         * highlight the selected slice id set with `highlightSliceById` all the time.
         *
         * @param  {boolean} _x         If we want to make the highlighted slice permanently highlighted
         * @return {boolean | module}   Current hasFixedHighlightedSlice flag or Chart module
         * @public
         */
        exports.hasFixedHighlightedSlice = function (_x) {
            if (!arguments.length) {
                return hasFixedHighlightedSlice;
            }
            hasFixedHighlightedSlice = _x;

            return this;
        };

        /**
         * Gets or sets the hasLastHoverSliceHighlighted property.
         * If property is true, the last hovered slice will be highlighted
         * after 'mouseout` event is triggered. The last hovered slice will remain
         * in highlight state.
         * Note: if both hasFixedHighlightedSlice and hasLastHoverSliceHighlighted
         * are true, the latter property will override the former.
         * @param {boolean} _x          Decide whether the last hovered slice should be highlighted
         * @return {boolean | module}   Current hasLastHoverSliceHighlighted value or Chart module
         * @public
         */
        exports.hasLastHoverSliceHighlighted = function (_x) {
            if (!arguments.length) {
                return hasLastHoverSliceHighlighted;
            }
            hasLastHoverSliceHighlighted = _x;

            return this;
        };

        /**
         * Gets or Sets the height of the chart
         * @param  {Number} _x              Desired width for the graph
         * @return { (Number | Module) }    Current height or Donut Chart module to chain calls
         * @public
         */
        exports.height = function (_x) {
            if (!arguments.length) {
                return height;
            }
            height = _x;

            return this;
        };

        /**
         * Gets or Sets the id of the slice to highlight
         * @param  {Number} _x              Slice id
         * @return { (Number | Module) }    Current highlighted slice id or Donut Chart module to chain calls
         * @public
         */
        exports.highlightSliceById = function (_x) {
            if (!arguments.length) {
                return highlightedSliceId;
            }
            highlightedSliceId = _x;

            return this;
        };

        /**
         * Gets or Sets the internalRadius of the chart
         * @param  {Number} _x              InternalRadius number to get/set
         * @return { (Number | Module) }    Current internalRadius or Donut Chart module to chain calls
         * @public
         */
        exports.internalRadius = function (_x) {
            if (!arguments.length) {
                return internalRadius;
            }
            internalRadius = _x;

            return this;
        };

        /**
         * Gets or Sets the isAnimated property of the chart, making it to animate when render.
         * By default this is 'false'
         *
         * @param  {Boolean} _x             Desired animation flag
         * @return { Boolean | module}      Current isAnimated flag or Chart module
         * @public
         */
        exports.isAnimated = function (_x) {
            if (!arguments.length) {
                return isAnimated;
            }
            isAnimated = _x;

            return this;
        };

        /**
         * Gets or Sets the loading state of the chart
         * @param  {string} markup Desired markup to show when null data
         * @return { loadingState | module} Current loading state markup or Chart module to chain calls
         * @public
         */
        exports.loadingState = function (_markup) {
            if (!arguments.length) {
                return loadingState;
            }
            loadingState = _markup;

            return this;
        };

        /**
         * Gets or Sets the margin of the chart
         * @param  {Object} _x              Margin object to get/set
         * @return { (Object | Module) }    Current margin or Donut Chart module to chain calls
         * @public
         */
        exports.margin = function (_x) {
            if (!arguments.length) {
                return margin;
            }
            margin = _extends({}, margin, _x);

            return this;
        };

        /**
         * Gets or Sets the number format of the donut chart
         * @param  {string} _x Desired number format for the donut chart
         * @return {numberFormat | module} Current numberFormat or Chart module to chain calls
         * @public
         */
        exports.numberFormat = function (_x) {
            if (!arguments.length) {
                return numberFormat;
            }
            numberFormat = _x;

            return this;
        };

        /**
         * Exposes an 'on' method that acts as a bridge with the event dispatcher
         * We are going to expose this events:
         * customMouseOver, customMouseMove, customMouseOut and customClick
         *
         * @return {module} Bar Chart
         * @public
         */
        exports.on = function () {
            var value = dispatcher.on.apply(dispatcher, arguments);

            return value === dispatcher ? exports : value;
        };

        /**
         * Changes the order of items given custom function
         * @param  {Function} _x              A custom function that sets logic for ordering
         * @return { (Function | Module) }    Void function with no return
         * @public
         */
        exports.orderingFunction = function (_x) {
            if (!arguments.length) {
                return orderingFunction;
            }
            orderingFunction = _x;

            return this;
        };

        /**
          * Gets or Sets the percentage format for the percentage label
          * @param  {String} _x              Format for the percentage label (e.g. '.1f')
          * @return { (Number | Module) }    Current format or Donut Chart module to chain calls
          * @public
          */
        exports.percentageFormat = function (_x) {
            if (!arguments.length) {
                return percentageFormat;
            }
            percentageFormat = _x;

            return this;
        };

        /**
            * Gets or Sets the radiusHoverOffset of the chart
            * @param  {Number} _x              Desired offset for the hovered slice
            * @return { (Number | Module) }    Current offset or Donut Chart module to chain calls
            * @public
            */
        exports.radiusHoverOffset = function (_x) {
            if (!arguments.length) {
                return radiusHoverOffset;
            }
            radiusHoverOffset = _x;

            return this;
        };

        /**
         * Gets or Sets the width of the chart
         * @param  {Number} _x              Desired width for the graph
         * @return { (Number | Module) }    Current width or Donut Chart module to chain calls
         * @public
         */
        exports.width = function (_x) {
            if (!arguments.length) {
                return width;
            }
            width = _x;

            return this;
        };

        return exports;
    };
}.call(exports, __webpack_require__, exports, module),
				__WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));

/***/ }),
/* 291 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
var __WEBPACK_AMD_DEFINE_RESULT__;

var _extends = Object.assign || function (target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i]; for (var key in source) { if (Object.prototype.hasOwnProperty.call(source, key)) { target[key] = source[key]; } } } return target; };

function _toConsumableArray(arr) { if (Array.isArray(arr)) { for (var i = 0, arr2 = Array(arr.length); i < arr.length; i++) { arr2[i] = arr[i]; } return arr2; } else { return Array.from(arr); } }

!(__WEBPACK_AMD_DEFINE_RESULT__ = function (require) {
    'use strict';

    var d3Format = __webpack_require__(7);
    var d3Scale = __webpack_require__(8);
    var d3Selection = __webpack_require__(0);
    var d3Transition = __webpack_require__(3);

    var textHelper = __webpack_require__(38);
    var colorHelper = __webpack_require__(5);

    /**
     * @typedef LegendChartData
     * @type {Object[]}
     * @property {Number} id        Id of the group (required)
     * @property {String} name      Name of the group (required)
     * @property {Number} quantity  Quantity of the group (optional)
     *
     * @example
     * [
     *     {
     *         id: 1,
     *         quantity: 2,
     *         name: 'glittering'
     *     },
     *     {
     *         id: 2,
     *         quantity: 3,
     *         name: 'luminous'
     *     }
     * ]
     */

    /**
     * @fileOverview Legend Component reusable API class that renders a
     * simple and configurable legend element.
     *
     * @module Legend
     * @tutorial legend
     * @exports charts/legend
     * @requires d3-format, d3-scale, d3-selection, d3-transition
     *
     * @example
     * var donutChart = donut(),
     *     legendBox = legend();
     *
     * donutChart
     *     .externalRadius(500)
     *     .internalRadius(200)
     *     .on('customMouseOver', function(data) {
     *         legendBox.highlight(data.data.id);
     *     })
     *     .on('customMouseOut', function() {
     *         legendBox.clearHighlight();
     *     });
     *
     * d3Selection.select('.css-selector')
     *     .datum(dataset)
     *     .call(donutChart);
     *
     * d3Selection.select('.other-css-selector')
     *     .datum(dataset)
     *     .call(legendBox);
     *
     */
    return function module() {

        var margin = {
            top: 5,
            right: 5,
            bottom: 5,
            left: 5
        },
            width = 320,
            height = 180,
            textSize = 12,
            textLetterSpacing = 0.5,
            markerSize = 16,
            markerYOffset = -(textSize - 2) / 2,
            marginRatio = 1.5,
            valueReservedSpace = 40,
            numberLetterSpacing = 0.8,
            numberFormat = 's',
            unit = '',
            isFadedClassName = 'is-faded',
            isHorizontal = false,
            highlightedEntryId = null,
            hasQuantities = true,


        // colors
        colorScale = void 0,
            colorSchema = colorHelper.colorSchemas.britecharts,
            getId = function getId(_ref) {
            var id = _ref.id;
            return id;
        },
            getName = function getName(_ref2) {
            var name = _ref2.name;
            return name;
        },
            getFormattedQuantity = function getFormattedQuantity(_ref3) {
            var quantity = _ref3.quantity;
            return d3Format.format(numberFormat)(quantity) + unit;
        },
            getCircleFill = function getCircleFill(_ref4) {
            var name = _ref4.name;
            return colorScale(name);
        },
            hasQuantity = function hasQuantity(_ref5) {
            var quantity = _ref5.quantity;
            return typeof quantity === 'number' || typeof quantity === 'string';
        },
            entries = void 0,
            chartWidth = void 0,
            chartHeight = void 0,
            data = void 0,
            svg = void 0;

        /**
         * This function creates the graph using the selection as container
         * @param  {D3Selection} _selection A d3 selection that represents
         *                                  the container(s) where the chart(s) will be rendered
         * @param {LegendChartData} _data The data to attach and generate the chart
         */
        function exports(_selection) {
            _selection.each(function (_data) {
                chartWidth = width - margin.left - margin.right;
                chartHeight = height - margin.top - margin.bottom;
                data = cleanData(_data);

                buildColorScale();
                buildSVG(this);

                if (isHorizontal) {
                    drawHorizontalLegend();
                } else {
                    drawVerticalLegend();
                }

                if (highlightedEntryId) {
                    cleanFadedLines();
                    fadeLinesBut(highlightedEntryId);
                }
            });
        }

        /**
         * Depending on the size of the horizontal legend, we are going to add a new
         * line with the last entry of the legend
         * @return {void}
         * @private
         */
        function adjustLines() {
            var lineWidth = svg.select('.legend-line').node().getBoundingClientRect().width + markerSize;
            var lineWidthSpace = chartWidth - lineWidth;

            if (lineWidthSpace <= 0) {
                splitInLines();
            }

            centerInlineLegendOnSVG();
        }

        /**
         * Builds containers for the legend
         * Also applies the Margin convention
         * @private
         */
        function buildContainerGroups() {
            var container = svg.append('g').classed('legend-container-group', true).attr('transform', 'translate(' + margin.left + ',' + margin.top + ')');

            container.append('g').classed('legend-group', true);
        }

        /**
         * Builds color scale for chart
         * @private
         */
        function buildColorScale() {
            colorScale = d3Scale.scaleOrdinal().range(colorSchema);
        }

        /**
         * Builds the SVG element that will contain the chart
         * @param  {HTMLElement} container DOM element that will work as the container of the graph
         * @private
         */
        function buildSVG(container) {
            if (!svg) {
                svg = d3Selection.select(container).append('svg').classed('britechart britechart-legend', true);

                buildContainerGroups();
            }

            svg.attr('width', width).attr('height', height);
        }

        /**
         * Centers the legend on the chart given that is a single line of labels
         * @return {void}
         * @private
         */
        function centerInlineLegendOnSVG() {
            var legendGroupSize = svg.select('g.legend-container-group').node().getBoundingClientRect().width + getLineElementMargin();
            var emptySpace = width - legendGroupSize;
            var newXPosition = emptySpace / 2;

            if (emptySpace > 0) {
                svg.select('g.legend-container-group').attr('transform', 'translate(' + newXPosition + ',0)');
            }
        }

        /**
         * Centers the legend on the chart given that is a stack of labels
         * @return {void}
         * @private
         */
        function centerVerticalLegendOnSVG() {
            var legendGroupSize = svg.select('g.legend-container-group').node().getBoundingClientRect().width;
            var emptySpace = width - legendGroupSize;
            var newXPosition = emptySpace / 2 - legendGroupSize / 2;

            if (emptySpace > 0) {
                svg.select('g.legend-container-group').attr('transform', 'translate(' + newXPosition + ',0)');
            }
        }

        /**
         * Makes sure the types of the data are right and checks if it has quantities
         * @param {LegendChartData} data
         * @private
         */
        function cleanData(data) {
            hasQuantities = data.filter(hasQuantity).length === data.length;

            return data.reduce(function (acc, d) {
                if (d.quantity !== undefined && d.quantity !== null) {
                    d.quantity = +d.quantity;
                }
                d.name = String(d.name);
                d.id = +d.id;

                return [].concat(_toConsumableArray(acc), [d]);
            }, []);
        }

        /**
         * Removes the faded class from all the entry lines
         * @private
         */
        function cleanFadedLines() {
            svg.select('.legend-group').selectAll('g.legend-entry').classed(isFadedClassName, false);
        }

        /**
         * Draws the entries of the legend within a single line
         * @private
         */
        function drawHorizontalLegend() {
            var xOffset = markerSize;

            svg.select('.legend-group').selectAll('g').remove();

            // We want a single line
            svg.select('.legend-group').append('g').classed('legend-line', true);

            // And one entry per data item
            entries = svg.select('.legend-line').selectAll('g.legend-entry').data(data);

            // Enter
            entries.enter().append('g').classed('legend-entry', true).attr('data-item', getId).attr('transform', function (_ref6) {
                var name = _ref6.name;

                var horizontalOffset = xOffset,
                    lineHeight = chartHeight / 2,
                    verticalOffset = lineHeight,
                    labelWidth = textHelper.getTextWidth(name, textSize);

                xOffset += markerSize + 2 * getLineElementMargin() + labelWidth;

                return 'translate(' + horizontalOffset + ',' + verticalOffset + ')';
            }).merge(entries).append('circle').classed('legend-circle', true).attr('cx', markerSize / 2).attr('cy', markerYOffset).attr('r', markerSize / 2).style('fill', getCircleFill).style('stroke-width', 1);

            svg.select('.legend-group').selectAll('g.legend-entry').append('text').classed('legend-entry-name', true).text(getName).attr('x', getLineElementMargin()).style('font-size', textSize + 'px').style('letter-spacing', textLetterSpacing + 'px');

            // Exit
            svg.select('.legend-group').selectAll('g.legend-entry').exit().transition().style('opacity', 0).remove();

            adjustLines();
        }

        /**
         * Draws the entries of the legend
         * @private
         */
        function drawVerticalLegend() {
            svg.select('.legend-group').selectAll('g').remove();

            entries = svg.select('.legend-group').selectAll('g.legend-line').data(data);

            // Enter
            entries.enter().append('g').classed('legend-line', true).append('g').classed('legend-entry', true).attr('data-item', getId).attr('transform', function (d, i) {
                var horizontalOffset = markerSize + getLineElementMargin(),
                    lineHeight = chartHeight / (data.length + 1),
                    verticalOffset = (i + 1) * lineHeight;

                return 'translate(' + horizontalOffset + ',' + verticalOffset + ')';
            }).merge(entries).append('circle').classed('legend-circle', true).attr('cx', markerSize / 2).attr('cy', markerYOffset).attr('r', markerSize / 2).style('fill', getCircleFill).style('stroke-width', 1);

            svg.select('.legend-group').selectAll('g.legend-line').selectAll('g.legend-entry').append('text').classed('legend-entry-name', true).text(getName).attr('x', getLineElementMargin()).style('font-size', textSize + 'px').style('letter-spacing', textLetterSpacing + 'px');

            if (hasQuantities) {
                writeEntryValues();
            } else {
                centerVerticalLegendOnSVG();
            }

            // Exit
            svg.select('.legend-group').selectAll('g.legend-line').exit().transition().style('opacity', 0).remove();
        }

        /**
         * Applies the faded class to all lines but the one that has the given id
         * @param  {number} exceptionItemId Id of the line that needs to stay the same
         * @private
         */
        function fadeLinesBut(exceptionItemId) {
            var classToFade = 'g.legend-entry';
            var entryLine = svg.select('[data-item="' + exceptionItemId + '"]');

            if (entryLine.nodes().length) {
                svg.select('.legend-group').selectAll(classToFade).classed(isFadedClassName, true);

                entryLine.classed(isFadedClassName, false);
            }
        }

        /**
         * Calculates the margin between elements of the legend
         * @return {Number} Margin to apply between elements
         * @private
         */
        function getLineElementMargin() {
            return marginRatio * markerSize;
        }

        /**
         * Simple method to move the last item of an overflowing legend into the next line
         * @return {void}
         * @private
         */
        function splitInLines() {
            var legendEntries = svg.selectAll('.legend-entry');
            var numberOfEntries = legendEntries.size();
            var lineHeight = chartHeight / 2 * 1.7;
            var newLine = svg.select('.legend-group').append('g').classed('legend-line', true).attr('transform', 'translate(0, ' + lineHeight + ')');
            var lastEntry = legendEntries.filter(':nth-child(' + numberOfEntries + ')');

            lastEntry.attr('transform', 'translate(' + markerSize + ',0)');
            newLine.append(function () {
                return lastEntry.node();
            });
        }

        /**
         * Draws the data entry quantities within the legend-entry lines
         * @return {void}
         * @private
         */
        function writeEntryValues() {
            svg.select('.legend-group').selectAll('g.legend-line').selectAll('g.legend-entry').append('text').classed('legend-entry-value', true).text(getFormattedQuantity).attr('x', chartWidth - valueReservedSpace).style('font-size', textSize + 'px').style('letter-spacing', numberLetterSpacing + 'px').style('text-anchor', 'end').style('startOffset', '100%');
        }

        // API

        /**
         * Clears all highlighted entries
         * @public
         */
        exports.clearHighlight = function () {
            cleanFadedLines();
        };

        /**
         * Gets or Sets the colorSchema of the chart
         * @param  {array} _x           Color scheme array to get/set
         * @return {number | module}    Current colorSchema or Donut Chart module to chain calls
         * @public
         */
        exports.colorSchema = function (_x) {
            if (!arguments.length) {
                return colorSchema;
            }
            colorSchema = _x;

            return this;
        };

        /**
         * Gets or Sets the height of the legend chart
         * @param  {number} _x          Desired width for the chart
         * @return {height | module}    Current height or Legend module to chain calls
         * @public
         */
        exports.height = function (_x) {
            if (!arguments.length) {
                return height;
            }
            height = _x;

            return this;
        };

        /**
         * Highlights a line entry by fading the rest of lines
         * @param  {number} entryId     ID of the entry line
         * @public
         */
        exports.highlight = function (entryId) {
            cleanFadedLines();
            fadeLinesBut(entryId);
        };

        /**
         * Gets or Sets the id of the entry to highlight
         * @param  {Number} _x              Entry id
         * @return { (Number | Module) }    Current highlighted slice id or Donut Chart module to chain calls
         * @public
         */
        exports.highlightEntryById = function (_x) {
            if (!arguments.length) {
                return highlightedEntryId;
            }
            highlightedEntryId = _x;

            return this;
        };

        /**
         * Gets or Sets the horizontal mode on the legend
         * @param  {Boolean} _x         Desired horizontal mode for the graph
         * @return {Boolean | module}   If it is horizontal or Legend module to chain calls
         * @public
         */
        exports.isHorizontal = function (_x) {
            if (!arguments.length) {
                return isHorizontal;
            }
            isHorizontal = _x;

            return this;
        };

        /**
         * Gets or Sets the margin of the legend chart
         * @param  {object} _x          Margin object to get/set
         * @return {object | module}    Current margin or Legend module to chain calls
         * @public
         */
        exports.margin = function (_x) {
            if (!arguments.length) {
                return margin;
            }
            margin = _extends({}, margin, _x);

            return this;
        };

        /**
         * Gets or Sets the margin ratio of the legend chart.
         * Used to determine spacing between legend elements.
         * @param  {number} _x          Margin Ratio to get/set
         * @return {number | module}    Current marginRatio or Legend module to chain calls
         * @public
         */
        exports.marginRatio = function (_x) {
            if (!arguments.length) {
                return marginRatio;
            }
            marginRatio = _x;

            return this;
        };

        /**
         * Gets or Sets the markerSize of the legend chart.
         * This markerSize will determine the horizontal and vertical size of the colored marks
         * added as color identifiers for the chart's categories.
         *
         * @param  {object} _x          Margin object to get/set
         * @return {object | module}    Current markerSize or Legend module to chain calls
         * @public
         */
        exports.markerSize = function (_x) {
            if (!arguments.length) {
                return markerSize;
            }
            markerSize = _x;

            return this;
        };

        /**
         * Gets or Sets the number format of the legend chart
         * @param  {string} _x          Desired number format for the legend chart
         * @return {string | module}    Current number format or Legend module to chain calls
         * @public
         */
        exports.numberFormat = function (_x) {
            if (!arguments.length) {
                return numberFormat;
            }
            numberFormat = _x;

            return this;
        };

        /**
         * Gets or Sets the unit of the value
         * @param  {String} _x          Desired unit
         * @return {String | module}    Current unit or Legend module to chain calls
         * @public
         */
        exports.unit = function (_x) {
            if (!arguments.length) {
                return unit;
            }
            unit = _x;

            return this;
        };

        /**
         * Gets or Sets the width of the legend chart
         * @param  {number} _x          Desired width for the graph
         * @return {number | module}    Current width or Legend module to chain calls
         * @public
         */
        exports.width = function (_x) {
            if (!arguments.length) {
                return width;
            }
            width = _x;

            return this;
        };

        return exports;
    };
}.call(exports, __webpack_require__, exports, module),
				__WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));

/***/ }),
/* 292 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
var __WEBPACK_AMD_DEFINE_RESULT__;

var _slicedToArray = function () { function sliceIterator(arr, i) { var _arr = []; var _n = true; var _d = false; var _e = undefined; try { for (var _i = arr[Symbol.iterator](), _s; !(_n = (_s = _i.next()).done); _n = true) { _arr.push(_s.value); if (i && _arr.length === i) break; } } catch (err) { _d = true; _e = err; } finally { try { if (!_n && _i["return"]) _i["return"](); } finally { if (_d) throw _e; } } return _arr; } return function (arr, i) { if (Array.isArray(arr)) { return arr; } else if (Symbol.iterator in Object(arr)) { return sliceIterator(arr, i); } else { throw new TypeError("Invalid attempt to destructure non-iterable instance"); } }; }();

var _extends = Object.assign || function (target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i]; for (var key in source) { if (Object.prototype.hasOwnProperty.call(source, key)) { target[key] = source[key]; } } } return target; };

function _toConsumableArray(arr) { if (Array.isArray(arr)) { for (var i = 0, arr2 = Array(arr.length); i < arr.length; i++) { arr2[i] = arr[i]; } return arr2; } else { return Array.from(arr); } }

function _objectWithoutProperties(obj, keys) { var target = {}; for (var i in obj) { if (keys.indexOf(i) >= 0) continue; if (!Object.prototype.hasOwnProperty.call(obj, i)) continue; target[i] = obj[i]; } return target; }

!(__WEBPACK_AMD_DEFINE_RESULT__ = function (require) {
    'use strict';

    var d3Array = __webpack_require__(1);
    var d3Axis = __webpack_require__(17);
    var d3Collection = __webpack_require__(27);
    var d3Dispatch = __webpack_require__(6);
    var d3Ease = __webpack_require__(4);
    var d3Format = __webpack_require__(7);
    var d3Scale = __webpack_require__(8);
    var d3Shape = __webpack_require__(21);
    var d3Selection = __webpack_require__(0);
    var d3Transition = __webpack_require__(3);
    var d3TimeFormat = __webpack_require__(19);

    var _require = __webpack_require__(15),
        exportChart = _require.exportChart;

    var colorHelper = __webpack_require__(5);

    var _require2 = __webpack_require__(13),
        lineChartLoadingMarkup = _require2.line;

    var _require3 = __webpack_require__(65),
        getTimeSeriesAxis = _require3.getTimeSeriesAxis;

    var _require4 = __webpack_require__(20),
        axisTimeCombinations = _require4.axisTimeCombinations,
        curveMap = _require4.curveMap;

    var _require5 = __webpack_require__(120),
        createFilterContainer = _require5.createFilterContainer,
        createGlowWithMatrix = _require5.createGlowWithMatrix,
        bounceCircleHighlight = _require5.bounceCircleHighlight;

    var _require6 = __webpack_require__(23),
        formatIntegerValue = _require6.formatIntegerValue,
        formatDecimalValue = _require6.formatDecimalValue,
        isInteger = _require6.isInteger,
        uniqueId = _require6.uniqueId;

    /**
     * @typedef D3Selection
     * @type {Array[]}
     * @property {Number} length            Size of the selection
     * @property {DOMElement} parentNode    Parent of the selection
     */

    /**
      * @typedef lineChartFlatData
      * @type {Object}
      * @property {String} topicName    Topic name (required)
      * @property {Number} topic        Topic identifier (required)
      * @property {Object[]} dates      All date entries with values for that topic in ISO8601 format (required)
      *
      * @example
      * [
      *     {
      *         topicName: 'San Francisco',
      *         name: 123,
      *         date: '2017-01-16T16:00:00-08:00',
      *         value: 1
      *     }
      * ]
      */

    /**
     * Former data standard, it is currently calculated internally if not passed
     * @typedef lineChartDataByTopic
     * @type {Object}
     * @property {String} topicName    Topic name (required)
     * @property {Number} topic        Topic identifier (required)
     * @property {Object[]} dates      All date entries with values for that topic in ISO8601 format (required)
     *
     * @example
     * {
     *     topicName: 'San Francisco',
     *     topic: 123,
     *     dates: [
     *         {
     *             date: '2017-01-16T16:00:00-08:00',
     *             value: 1
     *         },
     *         {
     *             date: '2017-01-16T17:00:00-08:00',
     *             value: 2
     *         }
     *     ]
     * }
     */

    /**
      * The Data by Date is calculated internally in the chart in order to pass it to our tooltips
      * @typedef lineChartDataByDate
      * @type {Object[]}
      * @property {String} date         Date in ISO8601 format (required)
      * @property {Object[]} topics     List of topics with values that date (required)
      *
      * @example
      * [
      *     {
      *         date: "2015-06-27T07:00:00.000Z",
      *         topics: [
      *             {
      *                 "name": 1,
      *                 "value": 1,
      *                 "topicName": "San Francisco"
      *             },
      *             {
      *                 "name": 2,
      *                 "value": 20,
      *                 "topicName": "Los Angeles"
      *             },
      *             {
      *                 "name": 3,
      *                 "value": 10,
      *                 "topicName": "Oakland"
      *             }
      *         ]
      *     },
      *     {...}
      * ]
      */

    /**
     * The data shape for the line chart.
     * Note that up to version 2.10.1, this required a "dataByTopic" array described on lineChartDataByTopic.
     * The "dataByTopic" schema still works, but we prefer a flat dataset as described here.
     * @typedef LineChartData
     * @type {Object}
     * @property {lineChartFlatData[]} data  Data values to chart (required)
     *
     * @example
     * {
     *     data: [
     *         {
     *             topicName: 'San Francisco',
     *             name: 1,
     *             date: '2017-01-16T16:00:00-08:00',
     *             value: 1
     *         },
     *         {
     *             topicName: 'San Francisco',
     *             name: 1,
     *             date: '2017-01-17T16:00:00-08:00',
     *             value: 2
     *         },
     *         {
     *             topicName: 'Oakland',
     *             name: 2,
     *             date: '2017-01-16T16:00:00-08:00',
     *             value: 3
     *         },
     *         {
     *             topicName: 'Oakland',
     *             name: 2,
     *             date: '2017-01-17T16:00:00-08:00',
     *             value: 7
     *         }
     *     ]
     * }
     */

    /**
     * Line Chart reusable API module that allows us
     * rendering a multi line and configurable chart.
     *
     * @module Line
     * @tutorial line
     * @requires d3-array, d3-axis, d3-brush, d3-ease, d3-format, d3-scale, d3-shape, d3-selection, d3-time, d3-time-format
     *
     * @example
     * let lineChart = line();
     *
     * lineChart
     *     .aspectRatio(0.5)
     *     .width(500);
     *
     * d3Selection.select('.css-selector')
     *     .datum(dataset)
     *     .call(lineChart);
     *
     */


    return function module() {

        var margin = {
            top: 60,
            right: 30,
            bottom: 40,
            left: 70
        },
            width = 960,
            height = 500,
            loadingState = lineChartLoadingMarkup,
            aspectRatio = null,
            tooltipThreshold = 480,
            svg = void 0,
            paths = void 0,
            chartWidth = void 0,
            chartHeight = void 0,
            xScale = void 0,
            yScale = void 0,
            colorScale = void 0,
            xAxis = void 0,
            xMonthAxis = void 0,
            yAxis = void 0,
            xAxisPadding = {
            top: 0,
            left: 15,
            bottom: 0,
            right: 0
        },
            monthAxisPadding = 28,
            tickPadding = 5,
            colorSchema = colorHelper.colorSchemas.britecharts,
            singleLineGradientColors = colorHelper.colorGradients.greenBlue,
            topicColorMap = void 0,
            linearGradient = void 0,
            lineGradientId = uniqueId('one-line-gradient'),
            highlightFilter = null,
            highlightFilterId = null,
            highlightCircleSize = 12,
            highlightCircleRadius = 5,
            highlightCircleStroke = 2,
            highlightCircleStrokeAll = 5,
            highlightCircleActiveRadius = highlightCircleRadius + 2,
            highlightCircleActiveStrokeWidth = 5,
            highlightCircleActiveStrokeOpacity = 0.6,
            xAxisFormat = null,
            xTicks = null,
            xAxisCustomFormat = null,
            locale = void 0,
            shouldShowAllDataPoints = false,
            isAnimated = false,
            ease = d3Ease.easeQuadInOut,
            animationDuration = 1500,
            maskingRectangle = void 0,
            lineCurve = 'linear',
            dataByTopic = void 0,
            dataByDate = void 0,
            dateLabel = 'date',
            valueLabel = 'value',
            topicLabel = 'topic',
            topicNameLabel = 'topicName',
            xAxisLabel = null,
            xAxisLabelEl = null,
            xAxisLabelPadding = 36,
            yAxisLabel = null,
            yAxisLabelEl = null,
            yAxisLabelPadding = 36,
            yTicks = 5,
            overlay = void 0,
            overlayColor = 'rgba(0, 0, 0, 0)',
            verticalMarkerContainer = void 0,
            verticalMarkerLine = void 0,
            numberFormat = void 0,
            verticalGridLines = void 0,
            horizontalGridLines = void 0,
            grid = null,
            baseLine = void 0,
            pathYCache = {},


        // extractors
        getDate = function getDate(_ref) {
            var date = _ref.date;
            return date;
        },
            getValue = function getValue(_ref2) {
            var value = _ref2.value;
            return value;
        },
            getTopic = function getTopic(_ref3) {
            var topic = _ref3.topic;
            return topic;
        },
            getVariableTopicName = function getVariableTopicName(d) {
            return d[topicNameLabel];
        },
            getLineColor = function getLineColor(_ref4) {
            var topic = _ref4.topic;
            return colorScale(topic);
        },


        // events
        dispatcher = d3Dispatch.dispatch('customMouseOver', 'customMouseOut', 'customMouseMove', 'customDataEntryClick', 'customTouchMove');

        /**
         * This function creates the graph using the selection and data provided
         *
         * @param {D3Selection} _selection A d3 selection that represents
         *                                  the container(s) where the chart(s) will be rendered
         * @param {LineChartData} _data The data to attach and generate the chart
         */
        function exports(_selection) {
            _selection.each(function (_data) {
                var _cleanData = cleanData(_data);

                dataByTopic = _cleanData.dataByTopic;
                dataByDate = _cleanData.dataByDate;


                chartWidth = width - margin.left - margin.right;
                chartHeight = height - margin.top - margin.bottom;

                buildScales();
                buildSVG(this);
                buildAxis();
                drawAxis();
                buildGradient();
                drawLines();
                createMaskingClip();

                if (shouldShowTooltip()) {
                    drawHoverOverlay();
                    drawVerticalMarker();
                    addMouseEvents();
                }

                if (shouldShowAllDataPoints) {
                    drawAllDataPoints();
                }

                addTouchEvents();
            });
        }

        /**
         * Adds a filter to the element
         * @param {DOMElement} el
         * @private
         */
        function addGlowFilter(el) {
            if (!highlightFilter) {
                highlightFilter = createFilterContainer(svg.select('.metadata-group'));
                highlightFilterId = createGlowWithMatrix(highlightFilter);
            }

            var glowEl = d3Selection.select(el);

            glowEl.style('stroke-width', highlightCircleActiveStrokeWidth).style('stroke-opacity', highlightCircleActiveStrokeOpacity).attr('filter', 'url(#' + highlightFilterId + ')');

            bounceCircleHighlight(glowEl, ease, highlightCircleRadius);
        }

        /**
         * Adds events to the container group if the environment is not mobile
         * Adding: mouseover, mouseout and mousemove
         */
        function addMouseEvents() {
            svg.on('mouseover', function (d) {
                handleMouseOver(this, d);
            }).on('mouseout', function (d) {
                handleMouseOut(this, d);
            }).on('mousemove', function (d) {
                handleMouseMove(this, d);
            });
        }

        /**
         * Adds events to the container group for the mobile environment
         * Adding: touchmove
         * @private
         */
        function addTouchEvents() {
            svg.on('touchmove', function (d) {
                handleTouchMove(this, d);
            });
        }

        /**
         * Adjusts the position of the y axis' ticks
         * @param  {D3Selection} selection Y axis group
         * @return void
         */
        function adjustYTickLabels(selection) {
            selection.selectAll('.tick text').attr('transform', 'translate(0, -7)');
        }

        /**
         * Formats the value depending on its characteristics
         * @param  {Number} value Value to format
         * @return {Number}       Formatted value
         */
        function getFormattedValue(value) {
            var format = void 0;

            if (isInteger(value)) {
                format = formatIntegerValue;
            } else {
                format = formatDecimalValue;
            }

            if (numberFormat) {
                format = d3Format.format(numberFormat);
            }

            return format(value);
        }

        /**
         * Creates the d3 x and y axis, setting orientations
         * @private
         */
        function buildAxis() {
            var minor = void 0,
                major = void 0;

            if (xAxisFormat === 'custom' && typeof xAxisCustomFormat === 'string') {
                minor = {
                    tick: xTicks,
                    format: d3TimeFormat.timeFormat(xAxisCustomFormat)
                };
                major = null;
            } else {
                var _getTimeSeriesAxis = getTimeSeriesAxis(dataByDate, width, xAxisFormat, locale);

                minor = _getTimeSeriesAxis.minor;
                major = _getTimeSeriesAxis.major;


                xMonthAxis = d3Axis.axisBottom(xScale).ticks(major.tick).tickSize(0, 0).tickFormat(major.format);
            }

            xAxis = d3Axis.axisBottom(xScale).ticks(minor.tick).tickSize(10, 0).tickPadding(tickPadding).tickFormat(minor.format);

            yAxis = d3Axis.axisLeft(yScale).ticks(yTicks).tickSize([0]).tickPadding(tickPadding).tickFormat(getFormattedValue);

            drawGridLines(minor.tick, yTicks);
        }

        /**
         * Builds containers for the chart, the axis and a wrapper for all of them
         * NOTE: The order of drawing of this group elements is really important,
         * as everything else will be drawn on top of them
         * @private
         */
        function buildContainerGroups() {
            var container = svg.append('g').classed('container-group', true).attr('transform', 'translate(' + margin.left + ',' + margin.top + ')');

            container.append('g').classed('x-axis-group', true).append('g').classed('axis x', true);
            container.selectAll('.x-axis-group').append('g').classed('month-axis', true);
            container.append('g').classed('y-axis-group', true).append('g').classed('axis y', true);
            container.append('g').classed('grid-lines-group', true);
            container.append('g').classed('chart-group', true);
            container.append('g').classed('metadata-group', true);
        }

        /**
         * Builds the gradient element to be used later
         * @return {void}
         */
        function buildGradient() {
            if (!linearGradient) {
                linearGradient = svg.select('.metadata-group').append('linearGradient').attr('id', lineGradientId).attr('x1', '0%').attr('y1', '0%').attr('x2', '100%').attr('y2', '0%').attr('gradientUnits', 'userSpaceOnUse').selectAll('stop').data([{ offset: '0%', color: singleLineGradientColors[0] }, { offset: '100%', color: singleLineGradientColors[1] }]).enter().append('stop').attr('offset', function (_ref5) {
                    var offset = _ref5.offset;
                    return offset;
                }).attr('stop-color', function (_ref6) {
                    var color = _ref6.color;
                    return color;
                });
            }
        }

        /**
         * Creates the x and y scales of the graph
         * @private
         */
        function buildScales() {
            var minX = d3Array.min(dataByTopic, function (_ref7) {
                var dates = _ref7.dates;
                return d3Array.min(dates, getDate);
            }),
                maxX = d3Array.max(dataByTopic, function (_ref8) {
                var dates = _ref8.dates;
                return d3Array.max(dates, getDate);
            }),
                maxY = d3Array.max(dataByTopic, function (_ref9) {
                var dates = _ref9.dates;
                return d3Array.max(dates, getValue);
            }),
                minY = d3Array.min(dataByTopic, function (_ref10) {
                var dates = _ref10.dates;
                return d3Array.min(dates, getValue);
            });
            var yScaleBottomValue = Math.abs(minY) < 0 ? Math.abs(minY) : 0;

            xScale = d3Scale.scaleTime().domain([minX, maxX]).rangeRound([0, chartWidth]);

            yScale = d3Scale.scaleLinear().domain([yScaleBottomValue, Math.abs(maxY)]).rangeRound([chartHeight, 0]).nice();

            colorScale = d3Scale.scaleOrdinal().range(colorSchema).domain(dataByTopic.map(getTopic));

            var range = colorScale.range();

            topicColorMap = colorScale.domain().reduce(function (memo, item, i) {
                memo[item] = range[i];

                return memo;
            }, {});
        }

        /**
         * Builds the SVG element that will contain the chart
         *
         * @param  {HTMLElement} container DOM element that will work as the container of the graph
         * @private
         */
        function buildSVG(container) {
            if (!svg) {
                svg = d3Selection.select(container).append('svg').classed('britechart line-chart', true);

                buildContainerGroups();
            }

            svg.attr('width', width).attr('height', height);
        }

        /**
         * Parses dates and values into JS Date objects and numbers
         * @param  {obj} dataByTopic    Raw data grouped by topic
         * @return {obj}                Parsed data with dataByTopic and dataByDate
         */
        function cleanData(_ref11) {
            var dataByTopic = _ref11.dataByTopic,
                dataByDate = _ref11.dataByDate,
                data = _ref11.data;

            if (!dataByTopic && !data) {
                throw new Error('Data needs to have a dataByTopic or data property. See more in http://eventbrite.github.io/britecharts/global.html#LineChartData__anchor');
            }

            // If dataByTopic or data are not present, we generate them
            if (!dataByTopic) {
                dataByTopic = d3Collection.nest().key(getVariableTopicName).entries(data).map(function (d) {
                    return {
                        topic: d.values[0]['name'],
                        topicName: d.key,
                        dates: d.values
                    };
                });
            } else {
                data = dataByTopic.reduce(function (accum, topic) {
                    topic.dates.forEach(function (date) {
                        accum.push({
                            topicName: topic[topicNameLabel],
                            name: topic[topicLabel],
                            date: date[dateLabel],
                            value: date[valueLabel]
                        });
                    });

                    return accum;
                }, []);
            }

            // Nest data by date and format
            dataByDate = d3Collection.nest().key(getDate).entries(data).map(function (d) {
                return {
                    date: new Date(d.key),
                    topics: d.values
                };
            });

            var normalizedDataByTopic = dataByTopic.reduce(function (accum, topic) {
                var dates = topic.dates,
                    restProps = _objectWithoutProperties(topic, ['dates']);

                var newDates = dates.map(function (d) {
                    return {
                        date: new Date(d[dateLabel]),
                        value: +d[valueLabel]
                    };
                });

                accum.push(_extends({ dates: newDates }, restProps));

                return accum;
            }, []);

            return {
                dataByTopic: normalizedDataByTopic,
                dataByDate: dataByDate
            };
        }

        /**
         * Removes all the datapoints highlighter circles added to the marker container
         * @return void
         */
        function cleanDataPointHighlights() {
            verticalMarkerContainer.selectAll('.circle-container').remove();
        }

        /**
         * Creates a masking clip that would help us fake an animation if the
         * proper flag is true
         *
         * @return {void}
         */
        function createMaskingClip() {
            if (isAnimated) {
                // We use a white rectangle to simulate the line drawing animation
                maskingRectangle = svg.append('rect').attr('class', 'masking-rectangle').attr('width', width).attr('height', height).attr('x', 0).attr('y', 0);

                maskingRectangle.transition().duration(animationDuration).ease(ease).attr('x', width).on('end', function () {
                    return maskingRectangle.remove();
                });
            }
        }

        /**
         * Draws the x and y axis on the svg object within their
         * respective groups along with the axis labels if given
         * @private
         */
        function drawAxis() {
            svg.select('.x-axis-group .axis.x').attr('transform', 'translate(0, ' + chartHeight + ')').call(xAxis);

            if (xAxisFormat !== 'custom') {
                svg.select('.x-axis-group .month-axis').attr('transform', 'translate(0, ' + (chartHeight + monthAxisPadding) + ')').call(xMonthAxis);
            }

            if (xAxisLabel) {
                if (xAxisLabelEl) {
                    svg.selectAll('.x-axis-label').remove();
                }
                var xLabelXPosition = chartWidth / 2;
                var xLabelYPosition = chartHeight + monthAxisPadding + xAxisLabelPadding;

                xAxisLabelEl = svg.select('.x-axis-group').append('text').attr('x', xLabelXPosition).attr('y', xLabelYPosition).attr('text-anchor', 'middle').attr('class', 'x-axis-label').text(xAxisLabel);
            }

            svg.select('.y-axis-group .axis.y').attr('transform', 'translate(' + -xAxisPadding.left + ', 0)').call(yAxis).call(adjustYTickLabels);

            if (yAxisLabel) {
                if (yAxisLabelEl) {
                    svg.selectAll('.y-axis-label').remove();
                }
                // Note this coordinates are rotated, so they are not what they look
                var yLabelYPosition = -yAxisLabelPadding - xAxisPadding.left;
                var yLabelXPosition = -chartHeight / 2;

                yAxisLabelEl = svg.select('.y-axis-group').append('text').attr('x', yLabelXPosition).attr('y', yLabelYPosition).attr('text-anchor', 'middle').attr('transform', 'rotate(270)').attr('class', 'y-axis-label').text(yAxisLabel);
            }
        }

        /**
         * Draws the line elements within the chart group
         * @private
         */
        function drawLines() {
            var lines = void 0,
                topicLine = void 0;

            topicLine = d3Shape.line().curve(curveMap[lineCurve]).x(function (_ref12) {
                var date = _ref12.date;
                return xScale(date);
            }).y(function (_ref13) {
                var value = _ref13.value;
                return yScale(value);
            });

            lines = svg.select('.chart-group').selectAll('.line').data(dataByTopic, getTopic);

            paths = lines.enter().append('g').attr('class', 'topic').append('path').attr('class', 'line').merge(lines).attr('id', function (_ref14) {
                var topic = _ref14.topic;
                return topic;
            }).attr('d', function (_ref15) {
                var dates = _ref15.dates;
                return topicLine(dates);
            }).style('stroke', function (d) {
                return dataByTopic.length === 1 ? 'url(#' + lineGradientId + ')' : getLineColor(d);
            });

            lines.exit().remove();
        }

        /**
         * Draws grid lines on the background of the chart
         * @return void
         */
        function drawGridLines(xTicks, yTicks) {
            svg.select('.grid-lines-group').selectAll('line').remove();

            if (grid === 'horizontal' || grid === 'full') {
                horizontalGridLines = svg.select('.grid-lines-group').selectAll('line.horizontal-grid-line').data(yScale.ticks(yTicks)).enter().append('line').attr('class', 'horizontal-grid-line').attr('x1', -xAxisPadding.left - 30).attr('x2', chartWidth).attr('y1', function (d) {
                    return yScale(d);
                }).attr('y2', function (d) {
                    return yScale(d);
                });
            }

            if (grid === 'vertical' || grid === 'full') {
                verticalGridLines = svg.select('.grid-lines-group').selectAll('line.vertical-grid-line').data(xScale.ticks(xTicks)).enter().append('line').attr('class', 'vertical-grid-line').attr('y1', 0).attr('y2', chartHeight).attr('x1', function (d) {
                    return xScale(d);
                }).attr('x2', function (d) {
                    return xScale(d);
                });
            }

            //draw a horizontal line to extend x-axis till the edges
            baseLine = svg.select('.grid-lines-group').selectAll('line.extended-x-line').data([0]).enter().append('line').attr('class', 'extended-x-line').attr('x1', -xAxisPadding.left - 30).attr('x2', chartWidth).attr('y1', height - margin.bottom - margin.top).attr('y2', height - margin.bottom - margin.top);
        }

        /**
         * Draws an overlay element over the graph
         * @inner
         * @return void
         */
        function drawHoverOverlay() {
            if (!overlay) {
                overlay = svg.select('.metadata-group').append('rect').attr('class', 'overlay').attr('y1', 0).attr('y2', height).attr('height', chartHeight).attr('width', chartWidth).attr('fill', overlayColor).style('display', 'none');
            }
        }

        /**
         * Draws all data points of the chart
         * if shouldShowAllDataPoints is set to true
         * @private
         * @return void
         */
        function drawAllDataPoints() {
            svg.select('.chart-group').selectAll('.data-points-container').remove();

            var nodesById = paths.nodes().reduce(function (acc, node) {
                acc[node.id] = node;

                return acc;
            }, {});

            var allTopics = dataByDate.reduce(function (accum, dataPoint) {
                var dataPointTopics = dataPoint.topics.map(function (topic) {
                    return {
                        topic: topic,
                        node: nodesById[topic.name]
                    };
                });

                accum = [].concat(_toConsumableArray(accum), _toConsumableArray(dataPointTopics));

                return accum;
            }, []);

            var allDataPoints = svg.select('.chart-group').append('g').classed('data-points-container', true).selectAll('circle').data(allTopics).enter().append('circle').classed('data-point-mark', true).attr('r', highlightCircleRadius).style('stroke-width', highlightCircleStroke).style('stroke', function (d) {
                return topicColorMap[d.topic.name];
            }).style('cursor', 'pointer').attr('cx', function (d) {
                return xScale(new Date(d.topic.date));
            }).attr('cy', function (d) {
                return getPathYFromX(xScale(new Date(d.topic.date)), d.node, d.topic.name);
            });
        }

        /**
         * Creates the vertical marker
         * @return void
         */
        function drawVerticalMarker() {
            if (!verticalMarkerContainer) {
                verticalMarkerContainer = svg.select('.metadata-group').append('g').attr('class', 'hover-marker vertical-marker-container').attr('transform', 'translate(9999, 0)');

                verticalMarkerLine = verticalMarkerContainer.selectAll('path').data([{
                    x1: 0,
                    y1: 0,
                    x2: 0,
                    y2: 0
                }]).enter().append('line').classed('vertical-marker', true).attr('x1', 0).attr('y1', chartHeight).attr('x2', 0).attr('y2', 0);
            }
        }

        /**
         * Finds out which datapoint is closer to the given x position
         * @param  {Number} x0 Date value for data point
         * @param  {Object} d0 Previous datapoint
         * @param  {Object} d1 Next datapoint
         * @return {Object}    d0 or d1, the datapoint with closest date to x0
         */
        function findOutNearestDate(x0, d0, d1) {
            return new Date(x0).getTime() - new Date(d0.date).getTime() > new Date(d1.date).getTime() - new Date(x0).getTime() ? d0 : d1;
        }

        /**
         * Finds out the data entry that is closer to the given position on pixels
         * @param  {Number} mouseX X position of the mouse
         * @return {Object}        Data entry that is closer to that x axis position
         */
        function getNearestDataPoint(mouseX) {
            var dateFromInvertedX = xScale.invert(mouseX);
            var bisectDate = d3Array.bisector(getDate).left;
            var dataEntryIndex = bisectDate(dataByDate, dateFromInvertedX, 1);
            var dataEntryForXPosition = dataByDate[dataEntryIndex];
            var previousDataEntryForXPosition = dataByDate[dataEntryIndex - 1];
            var nearestDataPoint = void 0;

            if (previousDataEntryForXPosition && dataEntryForXPosition) {
                nearestDataPoint = findOutNearestDate(dateFromInvertedX, dataEntryForXPosition, previousDataEntryForXPosition);
            } else {
                nearestDataPoint = dataEntryForXPosition;
            }

            return nearestDataPoint;
        }

        /**
         * MouseMove handler, calculates the nearest dataPoint to the cursor
         * and updates metadata related to it
         * @private
         */
        function handleMouseMove(e) {
            var _d3Selection$mouse = d3Selection.mouse(e),
                _d3Selection$mouse2 = _slicedToArray(_d3Selection$mouse, 2),
                xPosition = _d3Selection$mouse2[0],
                yPosition = _d3Selection$mouse2[1],
                xPositionOffset = -margin.left,
                dataPoint = getNearestDataPoint(xPosition + xPositionOffset),
                dataPointXPosition = void 0;

            if (dataPoint) {
                dataPointXPosition = xScale(new Date(dataPoint.date));
                // More verticalMarker to that datapoint
                moveVerticalMarker(dataPointXPosition);
                // Add data points highlighting
                highlightDataPoints(dataPoint);
                // Emit event with xPosition for tooltip or similar feature
                dispatcher.call('customMouseMove', e, dataPoint, topicColorMap, dataPointXPosition, yPosition);
            }
        }

        /**
         * MouseOut handler, hides overlay and removes active class on verticalMarkerLine
         * It also resets the container of the vertical marker
         * @private
         */
        function handleMouseOut(e, d) {
            overlay.style('display', 'none');
            verticalMarkerLine.classed('bc-is-active', false);
            verticalMarkerContainer.attr('transform', 'translate(9999, 0)');

            dispatcher.call('customMouseOut', e, d, d3Selection.mouse(e));
        }

        /**
         * Mouseover handler, shows overlay and adds active class to verticalMarkerLine
         * @private
         */
        function handleMouseOver(e, d) {
            overlay.style('display', 'block');
            verticalMarkerLine.classed('bc-is-active', true);

            dispatcher.call('customMouseOver', e, d, d3Selection.mouse(e));
        }

        /**
         * Mouseclick handler over one of the highlight points
         * It will only pass the information with the event
         * @private
         */
        function handleHighlightClick(e, d) {
            dispatcher.call('customDataEntryClick', e, d, d3Selection.mouse(e));
        }

        /**
         * Touchmove highlighted points
         * It will only pass the information with the event
         * @private
         */
        function handleTouchMove(e, d) {
            dispatcher.call('customTouchMove', e, d, d3Selection.touch(e));
        }

        /**
         * Creates coloured circles marking where the exact data y value is for a given data point
         * @param  {Object} dataPoint Data point to extract info from
         * @private
         */
        function highlightDataPoints(dataPoint) {
            cleanDataPointHighlights();

            var nodes = paths.nodes();
            var nodesById = nodes.reduce(function (acc, node) {
                acc[node.id] = node;

                return acc;
            }, {});

            // Group corresponding path node with its topic, and
            // sorting the topics based on the order of the colors,
            // so that the order always stays constant
            var topicsWithNode = dataPoint.topics.map(function (topic) {
                return {
                    topic: topic,
                    node: nodesById[topic.name]
                };
            }).filter(function (_ref16) {
                var topic = _ref16.topic;
                return !!topic;
            }).sort(function (a, b) {
                return topicColorMap[a.topic.name] < topicColorMap[b.topic.name];
            });

            dataPoint.topics = topicsWithNode.map(function (_ref17) {
                var topic = _ref17.topic;
                return topic;
            });

            dataPoint.topics.forEach(function (d, index) {
                var marker = verticalMarkerContainer.append('g').classed('circle-container', true).append('circle').classed('data-point-highlighter', true).attr('cx', highlightCircleSize).attr('cy', 0).attr('r', highlightCircleRadius).style('stroke-width', function () {
                    return shouldShowAllDataPoints ? highlightCircleStrokeAll : highlightCircleStroke;
                }).style('stroke', topicColorMap[d.name]).style('cursor', 'pointer').on('click', function () {
                    addGlowFilter(this);
                    handleHighlightClick(this, d);
                }).on('mouseout', function () {
                    removeFilter(this);
                });

                var path = topicsWithNode[index].node;
                var x = xScale(new Date(dataPoint.topics[index].date));
                var y = getPathYFromX(x, path, d.name);

                marker.attr('transform', 'translate( ' + -highlightCircleSize + ', ' + y + ' )');
            });
        }

        /**
         * Finds the y coordinate of a path given an x coordinate and the line's path node.
         * @param  {number} x The x coordinate
         * @param  {node} path The path node element
         * @param {*} name - The name identifier of the topic
         * @param  {number} error The margin of error from the actual x coordinate. Default 0.01
         * @private
         */
        function getPathYFromX(x, path, name, error) {
            var key = name + '-' + x;

            if (key in pathYCache) {
                return pathYCache[key];
            }

            error = error || 0.01;

            var maxIterations = 100;

            var lengthStart = 0;
            var lengthEnd = path.getTotalLength();
            var point = path.getPointAtLength((lengthEnd + lengthStart) / 2);
            var iterations = 0;

            while (x < point.x - error || x > point.x + error) {
                var midpoint = (lengthStart + lengthEnd) / 2;

                point = path.getPointAtLength(midpoint);

                if (x < point.x) {
                    lengthEnd = midpoint;
                } else {
                    lengthStart = midpoint;
                }

                iterations += 1;
                if (maxIterations < iterations) {
                    break;
                }
            }

            pathYCache[key] = point.y;

            return pathYCache[key];
        }

        /**
         * Helper method to update the x position of the vertical marker
         * @param  {Object} dataPoint Data entry to extract info
         * @return void
         */
        function moveVerticalMarker(verticalMarkerXPosition) {
            verticalMarkerContainer.attr('transform', 'translate(' + verticalMarkerXPosition + ',0)');
        }

        /**
         * Resets a point filter
         * @param {DOMElement} point  Point to reset
         */
        function removeFilter(point) {
            d3Selection.select(point).attr('filter', 'none');
        }

        /**
         * Determines if we should add the tooltip related logic depending on the
         * size of the chart and the tooltipThreshold variable value
         * @return {Boolean} Should we build the tooltip?
         */
        function shouldShowTooltip() {
            return width > tooltipThreshold;
        }

        // API

        /**
         * Gets or Sets the aspect ratio of the chart
         * @param  {Number} _x Desired aspect ratio for the graph
         * @return { (Number | Module) } Current aspect ratio or Line Chart module to chain calls
         * @public
         */
        exports.aspectRatio = function (_x) {
            if (!arguments.length) {
                return aspectRatio;
            }
            aspectRatio = _x;

            return this;
        };

        /**
         * Gets or Sets the label of the X axis of the chart
         * @param  {String} _x Desired label for the X axis
         * @return { (String | Module) } Current label of the X axis or Line Chart module to chain calls
         * @public
         */
        exports.xAxisLabel = function (_x) {
            if (!arguments.length) {
                return xAxisLabel;
            }
            xAxisLabel = _x;

            return this;
        };

        /**
         * Gets or Sets the label of the Y axis of the chart
         * @param  {String} _x Desired label for the Y axis
         * @return { (String | Module) } Current label of the Y axis or Line Chart module to chain calls
         * @public
         */
        exports.yAxisLabel = function (_x) {
            if (!arguments.length) {
                return yAxisLabel;
            }
            yAxisLabel = _x;

            return this;
        };

        /**
         * Gets or Sets the colorSchema of the chart
         * @param  {String[]} _x Desired colorSchema for the graph
         * @return { colorSchema | module} Current colorSchema or Chart module to chain calls
         * @public
         */
        exports.colorSchema = function (_x) {
            if (!arguments.length) {
                return colorSchema;
            }
            colorSchema = _x;

            return this;
        };

        /**
         * Gets or Sets the dateLabel of the chart
         * @param  {Number} _x Desired dateLabel for the graph
         * @return { dateLabel | module} Current dateLabel or Chart module to chain calls
         * @public
         */
        exports.dateLabel = function (_x) {
            if (!arguments.length) {
                return dateLabel;
            }
            dateLabel = _x;

            return this;
        };

        /**
         * Exposes the ability to force the chart to show a certain x axis grouping
         * @param  {String} _x Desired format
         * @return { (String|Module) }    Current format or module to chain calls
         * @public
         * @example
         *     line.xAxisFormat(line.axisTimeCombinations.HOUR_DAY)
         */
        exports.xAxisFormat = function (_x) {
            if (!arguments.length) {
                return xAxisFormat;
            }
            xAxisFormat = _x;

            return this;
        };

        /**
         * Exposes the ability to force the chart to show a certain x format
         * It requires a `xAxisFormat` of 'custom' in order to work.
         * NOTE: localization not supported
         * @param  {String} _x              Desired format for x axis
         * @return { (String|Module) }      Current format or module to chain calls
         * @public
         */
        exports.xAxisCustomFormat = function (_x) {
            if (!arguments.length) {
                return xAxisCustomFormat;
            }
            xAxisCustomFormat = _x;

            return this;
        };

        /**
         * Exposes the ability to force the chart to show a certain x ticks. It requires a `xAxisFormat` of 'custom' in order to work.
         * NOTE: This value needs to be a multiple of 2, 5 or 10. They won't always work as expected, as D3 decides at the end
         * how many and where the ticks will appear.
         *
         * @param  {Number} _x              Desired number of x axis ticks (multiple of 2, 5 or 10)
         * @return { (Number|Module) }      Current number or ticks or module to chain calls
         * @public
         */
        exports.xTicks = function (_x) {
            if (!arguments.length) {
                return xTicks;
            }
            xTicks = _x;

            return this;
        };

        /**
         * Gets or Sets the grid mode.
         *
         * @param  {String} _x Desired mode for the grid ('vertical'|'horizontal'|'full')
         * @return { String | module} Current mode of the grid or Line Chart module to chain calls
         * @public
         */
        exports.grid = function (_x) {
            if (!arguments.length) {
                return grid;
            }
            grid = _x;

            return this;
        };

        /**
         * Gets or Sets the height of the chart
         * @param  {Number} _x Desired width for the graph
         * @return { (Number | Module) } Current height or Line Chart module to chain calls
         * @public
         */
        exports.height = function (_x) {
            if (!arguments.length) {
                return height;
            }
            if (aspectRatio) {
                width = Math.ceil(_x / aspectRatio);
            }
            height = _x;

            return this;
        };

        /**
         * Gets or Sets the isAnimated property of the chart, making it to animate when render.
         * By default this is 'false'
         *
         * @param  {Boolean} _x Desired animation flag
         * @return { isAnimated | module} Current isAnimated flag or Chart module
         * @public
         */
        exports.isAnimated = function (_x) {
            if (!arguments.length) {
                return isAnimated;
            }
            isAnimated = _x;

            return this;
        };

        /**
         * Gets or Sets the loading state of the chart
         * @param  {string} markup Desired markup to show when null data
         * @return { loadingState | module} Current loading state markup or Chart module to chain calls
         * @public
         */
        exports.loadingState = function (_markup) {
            if (!arguments.length) {
                return loadingState;
            }
            loadingState = _markup;

            return this;
        };

        /**
         * Gets or Sets the margin of the chart
         * @param  {Object} _x Margin object to get/set
         * @return { (Object | Module) } Current margin or Line Chart module to chain calls
         * @public
         */
        exports.margin = function (_x) {
            if (!arguments.length) {
                return margin;
            }
            margin = _extends({}, margin, _x);

            return this;
        };

        /**
         * Gets or Sets the number format of the line chart
         * @param  {string} _x Desired number format for the line chart
         * @return {numberFormat | module} Current numberFormat or Chart module to chain calls
         * @public
         */
        exports.numberFormat = function (_x) {
            if (!arguments.length) {
                return numberFormat;
            }
            numberFormat = _x;

            return this;
        };

        /**
         * Gets or Sets the curve of the line chart
         * @param  {curve} _x Desired curve for the lines, default 'linear'. Other options are:
         * basis, natural, monotoneX, monotoneY, step, stepAfter, stepBefore, cardinal, and
         * catmullRom. Visit https://github.com/d3/d3-shape#curves for more information.
         * @return { (curve | Module) } Current line curve or Line Chart module to chain calls
         * @public
         */
        exports.lineCurve = function (_x) {
            if (!arguments.length) {
                return lineCurve;
            }
            lineCurve = _x;

            return this;
        };

        /**
         * Gets or Sets the gradient colors of the line chart when there is only one line
         * @param  {String[]} _x Desired color gradient for the line (array of two hexadecimal numbers)
         * @return { (Number | Module) } Current color gradient or Line Chart module to chain calls
         * @public
         */
        exports.lineGradient = function (_x) {
            if (!arguments.length) {
                return singleLineGradientColors;
            }
            singleLineGradientColors = _x;

            return this;
        };

        /**
         * Gets or Sets the topicLabel of the chart
         * @param  {Boolean} _x=false       Whether all data points should be drawn
         * @return {shouldShowAllDataPoints | module}   Current shouldShowAllDataPoints or Chart module to chain calls
         * @public
         */
        exports.shouldShowAllDataPoints = function (_x) {
            if (!arguments.length) {
                return shouldShowAllDataPoints;
            }
            shouldShowAllDataPoints = _x;

            return this;
        };

        /**
         * Gets or Sets the minimum width of the graph in order to show the tooltip
         * NOTE: This could also depend on the aspect ratio
         * @param  {Number} _x Desired tooltip threshold for the graph
         * @return { (Number | Module) } Current tooltip threshold or Line Chart module to chain calls
         * @public
         */
        exports.tooltipThreshold = function (_x) {
            if (!arguments.length) {
                return tooltipThreshold;
            }
            tooltipThreshold = _x;

            return this;
        };

        /**
         * Gets or Sets the topicLabel of the chart
         * @param  {Number} _x Desired topicLabel for the graph
         * @return {topicLabel | module} Current topicLabel or Chart module to chain calls
         * @public
         */
        exports.topicLabel = function (_x) {
            if (!arguments.length) {
                return topicLabel;
            }
            topicLabel = _x;

            return this;
        };

        /**
         * Gets or Sets the valueLabel of the chart
         * @param  {Number} _x Desired valueLabel for the graph
         * @return {valueLabel | module} Current valueLabel or Chart module to chain calls
         * @public
         */
        exports.valueLabel = function (_x) {
            if (!arguments.length) {
                return valueLabel;
            }
            valueLabel = _x;

            return this;
        };

        /**
         * Gets or Sets the yAxisLabelPadding of the chart.
         * The default value is -36
         * @param  {Number} _x Desired yAxisLabelPadding for the graph
         * @return {yAxisLabelPadding | module} Current yAxisLabelPadding or Chart module to chain calls
         * @public
         */
        exports.yAxisLabelPadding = function (_x) {
            if (!arguments.length) {
                return yAxisLabelPadding;
            }
            yAxisLabelPadding = _x;

            return this;
        };

        /**
         * Gets or Sets the number of ticks of the y axis on the chart
         * (Default is 5)
         * @param  {Number} _x          Desired yTicks
         * @return {Number | module}   Current yTicks or Chart module to chain calls
         * @public
         */
        exports.yTicks = function (_x) {
            if (!arguments.length) {
                return yTicks;
            }
            yTicks = _x;

            return this;
        };

        /**
         * Gets or Sets the width of the chart
         * @param  {Number} _x Desired width for the graph
         * @return {Number | Module} Current width or Line Chart module to chain calls
         * @public
         */
        exports.width = function (_x) {
            if (!arguments.length) {
                return width;
            }
            if (aspectRatio) {
                height = Math.ceil(_x * aspectRatio);
            }
            width = _x;

            return this;
        };

        /**
         * Pass language tag for the tooltip to localize the date.
         * Feature uses Intl.DateTimeFormat, for compatability and support, refer to
         * https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/DateTimeFormat
         * @param  {String} _x  must be a language tag (BCP 47) like 'en-US' or 'fr-FR'
         * @return { (String|Module) }    Current locale or module to chain calls
         * @public
         */
        exports.locale = function (_x) {
            if (!arguments.length) {
                return locale;
            }
            locale = _x;

            return this;
        };

        /**
         * Chart exported to png and a download action is fired
         * @param {String} filename     File title for the resulting picture
         * @param {String} title        Title to add at the top of the exported picture
         * @public
         */
        exports.exportChart = function (filename, title) {
            exportChart.call(exports, svg, filename, title);
        };

        /**
         * Exposes an 'on' method that acts as a bridge with the event dispatcher
         * We are going to expose this events:
         * customMouseHover, customMouseMove, customMouseOut,
         * customDataEntryClick, and customTouchMove
         *
         * @return {module} Bar Chart
         * @public
         */
        exports.on = function () {
            var value = dispatcher.on.apply(dispatcher, arguments);

            return value === dispatcher ? exports : value;
        };

        /**
         * Exposes the constants to be used to force the x axis to respect a certain granularity
         * current options: MINUTE_HOUR, HOUR_DAY, DAY_MONTH, MONTH_YEAR
         * @example
         *     line.xAxisCustomFormat(line.axisTimeCombinations.HOUR_DAY)
         */
        exports.axisTimeCombinations = axisTimeCombinations;

        return exports;
    };
}.call(exports, __webpack_require__, exports, module),
				__WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));

/***/ }),
/* 293 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
var __WEBPACK_AMD_DEFINE_RESULT__;

var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; };

var _slicedToArray = function () { function sliceIterator(arr, i) { var _arr = []; var _n = true; var _d = false; var _e = undefined; try { for (var _i = arr[Symbol.iterator](), _s; !(_n = (_s = _i.next()).done); _n = true) { _arr.push(_s.value); if (i && _arr.length === i) break; } } catch (err) { _d = true; _e = err; } finally { try { if (!_n && _i["return"]) _i["return"](); } finally { if (_d) throw _e; } } return _arr; } return function (arr, i) { if (Array.isArray(arr)) { return arr; } else if (Symbol.iterator in Object(arr)) { return sliceIterator(arr, i); } else { throw new TypeError("Invalid attempt to destructure non-iterable instance"); } }; }();

!(__WEBPACK_AMD_DEFINE_RESULT__ = function (require) {
    'use strict';

    var d3Ease = __webpack_require__(4);
    var d3Format = __webpack_require__(7);
    var d3Selection = __webpack_require__(0);
    var d3Transition = __webpack_require__(3);
    var d3TimeFormat = __webpack_require__(19);

    var _require = __webpack_require__(20),
        axisTimeCombinations = _require.axisTimeCombinations;

    var _require2 = __webpack_require__(23),
        formatIntegerValue = _require2.formatIntegerValue,
        formatDecimalValue = _require2.formatDecimalValue,
        isInteger = _require2.isInteger;

    var _require3 = __webpack_require__(38),
        getTextWidth = _require3.getTextWidth;

    /**
     * Tooltip Component reusable API class that renders a
     * simple and configurable tooltip element for Britechart's
     * line chart or stacked area chart.
     *
     * @module Tooltip
     * @tutorial tooltip
     * @requires d3-array, d3-axis, d3-dispatch, d3-format, d3-scale, d3-selection, d3-transition
     *
     * @example
     * var lineChart = line(),
     *     tooltip = tooltip();
     *
     * tooltip
     *     .title('Tooltip title');
     *
     * lineChart
     *     .width(500)
     *     .on('customMouseOver', function() {
     *          tooltip.show();
     *     })
     *     .on('customMouseMove', function(dataPoint, topicColorMap, dataPointXPosition) {
     *          tooltip.update(dataPoint, topicColorMap, dataPointXPosition);
     *     })
     *     .on('customMouseOut', function() {
     *          tooltip.hide();
     *     });
     *
     * d3Selection.select('.css-selector')
     *     .datum(dataset)
     *     .call(lineChart);
     *
     * d3Selection.select('.metadata-group .hover-marker')
     *     .datum([])
     *     .call(tooltip);
     *
     */


    return function module() {

        var margin = {
            top: 2,
            right: 2,
            bottom: 2,
            left: 2
        },
            width = 250,
            height = 45,
            title = 'Tooltip title',
            shouldShowDateInTitle = true,
            valueFormat = null,


        // tooltip
        tooltip = void 0,
            tooltipOffset = {
            y: -55,
            x: 0
        },
            tooltipMaxTopicLength = 170,
            tooltipTextContainer = void 0,
            tooltipDivider = void 0,
            tooltipBody = void 0,
            tooltipTitle = void 0,
            tooltipWidth = 250,
            tooltipHeight = 48,
            tooltipBorderRadius = 3,
            ttTextX = 0,
            ttTextY = 37,
            textHeight = void 0,
            entryLineLimit = 3,
            initialTooltipTextXPosition = -25,
            tooltipTextLinePadding = 5,
            tooltipRightWidth = void 0,

        // Animations
        mouseChaseDuration = 100,
            ease = d3Ease.easeQuadInOut,
            circleYOffset = 8,
            colorMap = void 0,
            bodyFillColor = '#FFFFFF',
            borderStrokeColor = '#D2D6DF',
            titleFillColor = '#6D717A',
            textFillColor = '#282C35',
            tooltipTextColor = '#000000',
            dateLabel = 'date',
            valueLabel = 'value',
            nameLabel = 'name',
            topicLabel = 'topics',
            defaultAxisSettings = axisTimeCombinations.DAY_MONTH,
            dateFormat = null,
            dateCustomFormat = null,
            topicsOrder = [],


        // formats
        numberFormat = null,
            valueFormatter = null,
            monthDayYearFormat = d3TimeFormat.timeFormat('%b %d, %Y'),
            monthDayHourFormat = d3TimeFormat.timeFormat('%b %d, %I %p'),
            locale = void 0,
            chartWidth = void 0,
            chartHeight = void 0,
            data = void 0,
            svg = void 0;

        /**
         * This function creates the graph using the selection as container
         * @param {D3Selection} _selection A d3 selection that represents
         *                                  the container(s) where the chart(s) will be rendered
         * @param {Object} _data The data to attach and generate the chart
         */
        function exports(_selection) {
            _selection.each(function (_data) {
                chartWidth = width - margin.left - margin.right;
                chartHeight = height - margin.top - margin.bottom;
                data = _data;

                buildSVG(this);
            });
        }

        /**
         * Builds containers for the tooltip
         * Also applies the Margin convention
         * @private
         */
        function buildContainerGroups() {
            var container = svg.append('g').classed('tooltip-container-group select-disable', true).attr('transform', 'translate( ' + margin.left + ', ' + margin.top + ')');

            container.append('g').classed('tooltip-group', true);
        }

        /**
         * Builds the SVG element that will contain the chart
         * @param  {HTMLElement} container DOM element that will work as the container of the graph
         * @private
         */
        function buildSVG(container) {
            if (!svg) {
                svg = d3Selection.select(container).append('g').classed('britechart britechart-tooltip', true).style('visibility', 'hidden');

                buildContainerGroups();
                drawTooltip();
            }
            svg.transition().attr('width', width).attr('height', height);

            // Hidden by default
            exports.hide();
        }

        /**
         * Resets the tooltipBody content
         * @return void
         * @private
         */
        function cleanContent() {
            tooltipBody.selectAll('text').remove();
            tooltipBody.selectAll('circle').remove();
        }

        /**
         * Draws the different elements of the Tooltip box
         * @return void
         * @private
         */
        function drawTooltip() {
            tooltipTextContainer = svg.selectAll('.tooltip-group').append('g').classed('tooltip-text', true);

            tooltip = tooltipTextContainer.append('rect').classed('tooltip-text-container', true).attr('x', -tooltipWidth / 4 + 8).attr('y', 0).attr('width', tooltipWidth).attr('height', tooltipHeight).attr('rx', tooltipBorderRadius).attr('ry', tooltipBorderRadius).style('fill', bodyFillColor).style('stroke', borderStrokeColor).style('stroke-width', 1);

            tooltipTitle = tooltipTextContainer.append('text').classed('tooltip-title', true).attr('x', -tooltipWidth / 4 + 16).attr('dy', '.35em').attr('y', 16).style('fill', titleFillColor);

            tooltipDivider = tooltipTextContainer.append('line').classed('tooltip-divider', true).attr('x1', -tooltipWidth / 4 + 16).attr('x2', 265).attr('y1', 31).attr('y2', 31).style('stroke', borderStrokeColor);

            tooltipBody = tooltipTextContainer.append('g').classed('tooltip-body', true).style('transform', 'translateY(8px)').style('fill', textFillColor);
        }

        /**
         * Formats the value depending on its characteristics
         * @param  {Number} value Value to format
         * @return {Number}       Formatted value
         * @private
         */
        function getFormattedValue(value) {
            if (valueFormatter !== null) {
                return valueFormatter(value);
            }

            var chosenValueFormatter = formatDecimalValue;

            if (!value) {
                return 0;
            }
            if (numberFormat !== null) {
                chosenValueFormatter = d3Format.format(numberFormat);
            } else if (isInteger(value)) {
                chosenValueFormatter = formatIntegerValue;
            }

            return chosenValueFormatter(value);
        }

        /**
         * Calculates the desired position for the tooltip
         * @param  {Number} mouseX             Current horizontal mouse position
         * @param  {Number} mouseY             Current vertical mouse position
         * @return {Number[]}                  X and Y position
         * @private
         */
        function getTooltipPosition(_ref) {
            var _ref2 = _slicedToArray(_ref, 2),
                mouseX = _ref2[0],
                mouseY = _ref2[1];

            var tooltipX = void 0,
                tooltipY = void 0;

            // show tooltip to the right
            if (mouseX - tooltipWidth < 0) {
                // Tooltip on the right
                tooltipX = tooltipWidth - 185;
            } else {
                // Tooltip on the left
                tooltipX = -205;
            }

            if (mouseY) {
                tooltipY = tooltipOffset.y;
                // tooltipY = mouseY + tooltipOffset.y;
            } else {
                tooltipY = tooltipOffset.y;
            }

            return [tooltipX, tooltipY];
        }

        /**
         * Extracts the value from the data object
         * @param  {Object} data Data value containing the info
         * @return {String}      Value to show
         */
        function getValueText(data) {
            var value = data[valueLabel];
            var valueText = void 0;

            if (data.missingValue) {
                valueText = '-';
            } else {
                valueText = getFormattedValue(value).toString();
            }

            return valueText;
        }

        /**
         * Resets the height of the tooltip and the pointer for the text
         * position
         */
        function resetSizeAndPositionPointers() {
            tooltipHeight = 48;
            ttTextY = 37;
            ttTextX = 0;
        }

        /**
         * Draws the data entries inside the tooltip for a given topic
         * @param  {Object} topic Topic to extract data from
         * @return void
         * @private
         */
        function updateTopicContent(topic) {
            var name = topic[nameLabel],
                tooltipRight = void 0,
                tooltipLeftText = void 0,
                tooltipRightText = void 0,
                elementText = void 0;

            tooltipLeftText = topic.topicName || name;
            tooltipRightText = getValueText(topic);

            elementText = tooltipBody.append('text').classed('tooltip-left-text', true).attr('dy', '1em').attr('x', ttTextX).attr('y', ttTextY).style('fill', tooltipTextColor).text(tooltipLeftText).call(textWrap, tooltipMaxTopicLength, initialTooltipTextXPosition);

            tooltipRight = tooltipBody.append('text').classed('tooltip-right-text', true).attr('dy', '1em').attr('x', ttTextX).attr('y', ttTextY).style('fill', tooltipTextColor).text(tooltipRightText);

            // IE11 give us sometimes a height of 0 when hovering on top of the vertical marker
            // This hack fixes it for some cases, but it doesn't work in multiline (they won't wrap)
            // Let's remove this once we stop supporting IE11
            textHeight = elementText.node().getBBox().height ? elementText.node().getBBox().height : textHeight;

            tooltipHeight += textHeight + tooltipTextLinePadding;
            // update the width if it exists because IE renders the elements
            // too slow and cant figure out the width?
            tooltipRightWidth = tooltipRight.node().getBBox().width ? tooltipRight.node().getBBox().width : tooltipRightWidth;
            tooltipRight.attr('x', tooltipWidth - tooltipRightWidth - 10 - tooltipWidth / 4);

            tooltipBody.append('circle').classed('tooltip-circle', true).attr('cx', 23 - tooltipWidth / 4).attr('cy', ttTextY + circleYOffset).attr('r', 5).style('fill', colorMap[name]).style('stroke-width', 1);

            ttTextY += textHeight + 7;
        }

        /**
         * Updates size and position of tooltip depending on the side of the chart we are in
         * TODO: This needs a refactor, following the mini-tooltip code.
         *
         * @param  {Object} dataPoint DataPoint of the tooltip
         * @param  {Number} xPosition DataPoint's x position in the chart
         * @param  {Number} xPosition DataPoint's y position in the chart
         * @return void
         * @private
         */
        function updatePositionAndSize(dataPoint, xPosition, yPosition) {
            var _getTooltipPosition = getTooltipPosition([xPosition, yPosition]),
                _getTooltipPosition2 = _slicedToArray(_getTooltipPosition, 2),
                tooltipX = _getTooltipPosition2[0],
                tooltipY = _getTooltipPosition2[1];

            tooltip.attr('width', tooltipWidth).attr('height', tooltipHeight + 10);

            tooltipTextContainer.transition().duration(mouseChaseDuration).ease(ease).attr('transform', 'translate(' + tooltipX + ', ' + tooltipY + ')');

            tooltipDivider.attr('x2', tooltipWidth - 60);
        }

        /**
         * Updates value of tooltipTitle with the data meaning and the date
         * @param  {Object} dataPoint Point of data to use as source
         * @return void
         * @private
         */
        function updateTitle(dataPoint) {
            var tTitle = title;
            var formattedDate = formatDate(new Date(dataPoint[dateLabel]));

            if (tTitle.length) {
                if (shouldShowDateInTitle) {
                    tTitle = tTitle + ' - ' + formattedDate;
                }
            } else {
                tTitle = formattedDate;
            }

            tooltipTitle.text(tTitle);
        }

        /**
         * Figures out which date format to use when showing the date of the current data entry
         * @param {Date} date   Date object to format
         * @return {Function}   The proper date formatting function
         * @private
         */
        function formatDate(date) {
            var settings = dateFormat || defaultAxisSettings;
            var format = null;
            var localeOptions = { month: 'short', day: 'numeric' };

            if (settings === axisTimeCombinations.DAY_MONTH || settings === axisTimeCombinations.MONTH_YEAR) {
                format = monthDayYearFormat;
                localeOptions.year = 'numeric';
            } else if (settings === axisTimeCombinations.HOUR_DAY || settings === axisTimeCombinations.MINUTE_HOUR) {
                format = monthDayHourFormat;
                localeOptions.hour = 'numeric';
            } else if (settings === axisTimeCombinations.CUSTOM && typeof dateCustomFormat === 'string') {
                format = d3TimeFormat.timeFormat(dateCustomFormat);
            }

            if (locale && typeof Intl !== 'undefined' && (typeof Intl === 'undefined' ? 'undefined' : _typeof(Intl)) === 'object' && Intl.DateTimeFormat) {
                var f = Intl.DateTimeFormat(locale, localeOptions);

                return f.format(date);
            }

            return format(date);
        }

        /**
         * Helper method to sort the passed topics array by the names passed int he order arary
         * @param  {Object[]} topics    Topics data, retrieved from datapoint passed by line chart
         * @param  {Object[]} order     Array of names in the order to sort topics by
         * @return {Object[]}           sorted topics object
         * @private
         */
        function _sortByTopicsOrder(topics) {
            var order = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : topicsOrder;

            return order.map(function (orderName) {
                return topics.filter(function (_ref3) {
                    var name = _ref3.name;
                    return name === orderName;
                })[0];
            });
        }

        /**
         * Sorts topic by alphabetical order for arrays of objects with a name proeprty
         * @param  {Array} topics   List of topic objects
         * @return {Array}          List of topic name strings
         * @private
         */
        function _sortByAlpha(topics) {
            return topics.map(function (d) {
                return d;
            }).sort(function (a, b) {
                if (a.name > b.name) return 1;
                if (a.name === b.name) return 0;

                return -1;
            });

            var otherIndex = topics.map(function (_ref4) {
                var name = _ref4.name;
                return name;
            }).indexOf('Other');

            if (otherIndex >= 0) {
                var other = topics.splice(otherIndex, 1);

                topics = topics.concat(other);
            }
        }

        /**
         * Wraps a text given the text, width, x position and textFormatter function
         * @param  {D3Selection} text  Selection with the text to wrap inside
         * @param  {Number} width Desired max width for that line
         * @param  {Number} xpos  Initial x position of the text
         * REF: http://bl.ocks.org/mbostock/7555321
         * More discussions on https://github.com/mbostock/d3/issues/1642
         * @private
         *
         */
        function textWrap(text, width) {
            var xpos = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : 0;

            text.each(function () {
                var words, word, line, lineNumber, lineHeight, y, dy, tspan;

                text = d3Selection.select(this);

                words = text.text().split(/\s+/).reverse();
                line = [];
                lineNumber = 0;
                lineHeight = 1.2;
                y = text.attr('y');
                dy = parseFloat(text.attr('dy'));
                tspan = text.text(null).append('tspan').attr('x', xpos).attr('y', y).attr('dy', dy + 'em');

                while (word = words.pop()) {
                    line.push(word);
                    tspan.text(line.join(' '));

                    // fixes for IE wrap text issue
                    var textWidth = getTextWidth(line.join(' '), 16, 'Karla, sans-serif');

                    if (textWidth > width) {
                        line.pop();
                        tspan.text(line.join(' '));

                        if (lineNumber < entryLineLimit - 1) {
                            line = [word];
                            tspan = text.append('tspan').attr('x', xpos).attr('y', y).attr('dy', ++lineNumber * lineHeight + dy + 'em').text(word);
                        }
                    }
                }
            });
        }

        /**
         * Draws the data entries inside the tooltip
         * @param  {Object} dataPoint   Data entry from to take the info
         * @return void
         * @private
         */
        function updateContent(dataPoint) {
            var topics = dataPoint[topicLabel];

            // sort order by topicsOrder array if passed
            if (topicsOrder.length) {
                topics = _sortByTopicsOrder(topics);
            } else if (topics.length && topics[0].name) {
                topics = _sortByAlpha(topics);
            }

            cleanContent();
            updateTitle(dataPoint);
            resetSizeAndPositionPointers();
            topics.forEach(updateTopicContent);
        }

        /**
         * Updates tooltip title, content, size and position
         * sorts by alphatical name order if not forced order given
         *
         * @param  {lineChartPointByDate} dataPoint  Current datapoint to show info about
         * @param  {Number} xPosition           Position of the mouse on the X axis
         * @return void
         * @private
         */
        function updateTooltip(dataPoint, xPosition, yPosition) {
            updateContent(dataPoint);
            updatePositionAndSize(dataPoint, xPosition, yPosition);
        }

        // API

        /**
         * constants to be used to force the x axis to respect a certain granularity
         * current options: HOUR_DAY, DAY_MONTH, MONTH_YEAR
         * @example tooltip.dateFormat(tooltip.axisTimeCombinations.HOUR_DAY)
         */
        exports.axisTimeCombinations = axisTimeCombinations;

        /**
         * Exposes the ability to force the tooltip to use a certain date format
         * @param  {String} _x          Desired format
         * @return {String | module}  Current format or module to chain calls
         * @public
         */
        exports.dateFormat = function (_x) {
            if (!arguments.length) {
                return dateFormat || defaultAxisSettings;
            }
            dateFormat = _x;

            return this;
        };

        /**
         * Exposes the ability to use a custom date format
         * @param  {String} _x          Desired custom format
         * @return {String | module}  Current format or module to chain calls
         * @public
         * @example tooltip.dateFormat(tooltip.axisTimeCombinations.CUSTOM);
         * tooltip.dateCustomFormat('%H:%M %p')
         */
        exports.dateCustomFormat = function (_x) {
            if (!arguments.length) {
                return dateCustomFormat;
            }
            dateCustomFormat = _x;

            return this;
        };

        /**
         * Gets or Sets the dateLabel of the data
         * @param  {String} _x          Desired dateLabel
         * @return {String | module}   Current dateLabel or Chart module to chain calls
         * @public
         */
        exports.dateLabel = function (_x) {
            if (!arguments.length) {
                return dateLabel;
            }
            dateLabel = _x;

            return this;
        };

        /**
         * Hides the tooltip
         * @return {module} Tooltip module to chain calls
         * @public
         */
        exports.hide = function () {
            svg.style('visibility', 'hidden');

            return this;
        };

        /**
         * Pass locale for the tooltip to render the date in
         * @param  {String} _x          Must be a locale tag like 'en-US' or 'fr-FR'
         * @return {String | module}    Current locale or module to chain calls
         * @public
         */
        exports.locale = function (_x) {
            if (!arguments.length) {
                return locale;
            }
            locale = _x;

            return this;
        };

        /**
         * Gets or Sets the nameLabel of the data
         * @param  {String} _x           Desired nameLabel
         * @return {String | module}    Current nameLabel or Chart module to chain calls
         * @public
         */
        exports.nameLabel = function (_x) {
            if (!arguments.length) {
                return nameLabel;
            }
            nameLabel = _x;

            return this;
        };

        /**
         * Gets or Sets the number format for the value displayed on the tooltip
         * @param  {string} Desired number format
         * @return {string | module} Current numberFormat or Chart module to chain calls
         * @public
         */
        exports.numberFormat = function (_x) {
            if (!arguments.length) {
                return numberFormat;
            }
            numberFormat = _x;

            return this;
        };

        /**
         * Gets or Sets the formatter function for the value displayed on the tooltip.
         * Setting this property makes the tooltip ignore numberFormat.
         * @param  {Function} _x Desired formatter function
         * @return {Function | module} Current valueFormatter or Chart module to chain calls
         * @public
         * @example tooltipChart.valueFormatter(value => value.toString().length.toString())
         */
        exports.valueFormatter = function (_x) {
            if (!arguments.length) {
                return valueFormatter;
            }
            valueFormatter = _x;

            return this;
        };

        /**
         * Gets or Sets shouldShowDateInTitle
         * @param  {Boolean} _x          Desired value
         * @return {Boolean | module}    Current shouldShowDateInTitle or Chart module to chain calls
         * @public
         */
        exports.shouldShowDateInTitle = function (_x) {
            if (!arguments.length) {
                return shouldShowDateInTitle;
            }
            shouldShowDateInTitle = _x;

            return this;
        };

        /**
         * Shows the tooltip
         * @return {module} Tooltip module to chain calls
         * @public
         */
        exports.show = function () {
            svg.style('visibility', 'visible');

            return this;
        };

        /**
         * Gets or Sets the title of the tooltip (to only show the date, set a blank title)
         * @param  {String} _x          Desired title
         * @return {String | module}   Current title or module to chain calls
         * @public
         */
        exports.title = function (_x) {
            if (!arguments.length) {
                return title;
            }
            title = _x;

            return this;
        };

        /**
         * Pass an override for the offset of your tooltip
         * @param  {Object} tooltipOffset  Object representing the X and Y offsets
         * @return {Object | module}       Current tooltipOffset
         * @public
         */
        exports.tooltipOffset = function (_x) {
            if (!arguments.length) {
                return tooltipOffset;
            }
            tooltipOffset = _x;

            return this;
        };

        /**
         * Pass an override for the ordering of your tooltip
         * @param  {String[]} _x           Array of the names of your tooltip items
         * @return {String[] | module}    Current overrideOrder or Chart module to chain calls
         * @public
         */
        exports.topicsOrder = function (_x) {
            if (!arguments.length) {
                return topicsOrder;
            }
            topicsOrder = _x;

            return this;
        };

        /**
         * Gets or Sets the topicLabel of the data
         * @param  {String} _x          Desired topicLabel
         * @return {String | module}   Current topicLabel or Chart module to chain calls
         * @public
         */
        exports.topicLabel = function (_x) {
            if (!arguments.length) {
                return topicLabel;
            }
            topicLabel = _x;

            return this;
        };

        /**
         * Updates the position and content of the tooltip
         * @param  {Object} dataPoint       Datapoint to represent
         * @param  {Object} colorMapping    Color scheme of the topics
         * @param  {Number} position        X-scale position in pixels
         * @return {Module}                 Tooltip module to chain calls
         * @public
         */
        exports.update = function (dataPoint, colorMapping, xPosition) {
            var yPosition = arguments.length > 3 && arguments[3] !== undefined ? arguments[3] : null;

            colorMap = colorMapping;
            updateTooltip(dataPoint, xPosition, yPosition);

            return this;
        };

        /**
         * Gets or Sets the valueLabel of the data
         * @param  {String} _x          Desired valueLabel
         * @return {String | module}   Current valueLabel or Chart module to chain calls
         * @public
         */
        exports.valueLabel = function (_x) {
            if (!arguments.length) {
                return valueLabel;
            }
            valueLabel = _x;

            return this;
        };

        return exports;
    };
}.call(exports, __webpack_require__, exports, module),
				__WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));

/***/ }),
/* 294 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
var __WEBPACK_AMD_DEFINE_RESULT__;

var _slicedToArray = function () { function sliceIterator(arr, i) { var _arr = []; var _n = true; var _d = false; var _e = undefined; try { for (var _i = arr[Symbol.iterator](), _s; !(_n = (_s = _i.next()).done); _n = true) { _arr.push(_s.value); if (i && _arr.length === i) break; } } catch (err) { _d = true; _e = err; } finally { try { if (!_n && _i["return"]) _i["return"](); } finally { if (_d) throw _e; } } return _arr; } return function (arr, i) { if (Array.isArray(arr)) { return arr; } else if (Symbol.iterator in Object(arr)) { return sliceIterator(arr, i); } else { throw new TypeError("Invalid attempt to destructure non-iterable instance"); } }; }();

!(__WEBPACK_AMD_DEFINE_RESULT__ = function (require) {
    'use strict';

    var d3Array = __webpack_require__(1);
    var d3Ease = __webpack_require__(4);
    var d3Format = __webpack_require__(7);
    var d3Selection = __webpack_require__(0);
    var d3Transition = __webpack_require__(3);

    var NUMBER_FORMAT = '.2f';

    /**
     * Mini Tooltip Component reusable API class that renders a
     * simple and configurable tooltip element for Britechart's
     * bar and step chart.
     *
     * @module Mini-tooltip
     * @tutorial bar
     * @requires d3
     *
     * @example
     * var barChart = line(),
     *     miniTooltip = miniTooltip();
     *
     * barChart
     *     .width(500)
     *     .height(300)
     *     .on('customMouseHover', miniTooltip.show)
     *     .on('customMouseMove', miniTooltip.update)
     *     .on('customMouseOut', miniTooltip.hide);
     *
     * d3Selection.select('.css-selector')
     *     .datum(dataset)
     *     .call(barChart);
     *
     * d3Selection.select('.metadata-group .mini-tooltip-container')
     *     .datum([])
     *     .call(miniTooltip);
     *
     */
    return function module() {

        var margin = {
            top: 12,
            right: 12,
            bottom: 12,
            left: 12
        },
            width = 100,
            height = 100,


        // Optional Title
        title = '',


        // Data Format
        valueLabel = 'value',
            nameLabel = 'name',


        // Animations
        mouseChaseDuration = 100,
            ease = d3Ease.easeQuadInOut,


        // tooltip
        tooltipBackground = void 0,
            backgroundBorderRadius = 1,
            tooltipTextContainer = void 0,
            tooltipOffset = {
            y: 0,
            x: 20
        },


        // Fonts
        textSize = 14,
            textLineHeight = 1.5,
            valueTextSize = 27,
            valueTextLineHeight = 1.18,


        // Colors
        bodyFillColor = '#FFFFFF',
            borderStrokeColor = '#D2D6DF',
            titleFillColor = '#666a73',
            nameTextFillColor = '#666a73',
            valueTextFillColor = '#45494E',
            valueTextWeight = 200,


        // formats
        numberFormat = NUMBER_FORMAT,
            valueFormatter = function valueFormatter(value) {
            return d3Format.format(numberFormat)(value);
        },
            chartWidth = void 0,
            chartHeight = void 0,
            svg = void 0;

        /**
         * This function creates the graph using the selection as container
         * @param {D3Selection} _selection A d3 selection that represents
         *                                  the container(s) where the chart(s) will be rendered
         */
        function exports(_selection) {
            _selection.each(function () {
                chartWidth = width - margin.left - margin.right;
                chartHeight = height - margin.top - margin.bottom;

                buildSVG(this);
                drawTooltip();
            });
        }

        /**
         * Builds containers for the tooltip
         * Also applies the Margin convention
         * @private
         */
        function buildContainerGroups() {
            var container = svg.append('g').classed('tooltip-container-group', true).attr('transform', 'translate( ' + margin.left + ', ' + margin.top + ')');

            container.append('g').classed('tooltip-group', true);
        }

        /**
         * Builds the SVG element that will contain the chart
         * @param  {HTMLElement} container DOM element that will work as the container of the graph
         * @private
         */
        function buildSVG(container) {
            if (!svg) {
                svg = d3Selection.select(container).append('g').classed('britechart britechart-mini-tooltip', true);

                buildContainerGroups();
            }
            svg.transition().attr('width', width).attr('height', height);

            // Hidden by default
            exports.hide();
        }

        /**
         * Draws the different elements of the Tooltip box
         * @return void
         */
        function drawTooltip() {
            tooltipTextContainer = svg.selectAll('.tooltip-group').append('g').classed('tooltip-text select-disable', true);

            tooltipBackground = tooltipTextContainer.append('rect').classed('tooltip-background', true).attr('width', width).attr('height', height).attr('rx', backgroundBorderRadius).attr('ry', backgroundBorderRadius).attr('y', -margin.top).attr('x', -margin.left).style('fill', bodyFillColor).style('stroke', borderStrokeColor).style('stroke-width', 1).style('pointer-events', 'none').style('opacity', 0.9);
        }

        /**
         * Figures out the max length of the tooltip lines
         * @param  {D3Selection[]} texts    List of svg elements of each line
         * @return {Number}                 Max size of the lines
         */
        function getMaxLengthLine() {
            for (var _len = arguments.length, texts = Array(_len), _key = 0; _key < _len; _key++) {
                texts[_key] = arguments[_key];
            }

            var textSizes = texts.filter(function (x) {
                return !!x;
            }).map(function (x) {
                return x.node().getBBox().width;
            });

            return d3Array.max(textSizes);
        }

        /**
         * Calculates the desired position for the tooltip
         * @param  {Number} mouseX             Current horizontal mouse position
         * @param  {Number} mouseY             Current vertical mouse position
         * @param  {Number} parentChartWidth   Parent's chart width
         * @param  {Number} parentChartHeight  Parent's chart height
         * @return {Number[]}                  X and Y position
         * @private
         */
        function getTooltipPosition(_ref, _ref2) {
            var _ref4 = _slicedToArray(_ref, 2),
                mouseX = _ref4[0],
                mouseY = _ref4[1];

            var _ref3 = _slicedToArray(_ref2, 2),
                parentChartWidth = _ref3[0],
                parentChartHeight = _ref3[1];

            var tooltipX = void 0,
                tooltipY = void 0;

            if (hasEnoughHorizontalRoom(parentChartWidth, mouseX)) {
                tooltipX = mouseX + tooltipOffset.x;
            } else {
                tooltipX = mouseX - chartWidth - tooltipOffset.x - margin.right;
            }

            if (hasEnoughVerticalRoom(parentChartHeight, mouseY)) {
                tooltipY = mouseY + tooltipOffset.y;
            } else {
                tooltipY = mouseY - chartHeight - tooltipOffset.y - margin.bottom;
            }

            return [tooltipX, tooltipY];
        }

        /**
         * Checks if the mouse is over the bounds of the parent chart
         * @param  {Number}  chartWidth Parent's chart
         * @param  {Number}  positionX  Mouse position
         * @return {Boolean}            If the mouse position allows space for the tooltip
         */
        function hasEnoughHorizontalRoom(parentChartWidth, positionX) {
            return parentChartWidth - margin.left - margin.right - chartWidth - positionX > 0;
        }

        /**
         * Checks if the mouse is over the bounds of the parent chart
         * @param  {Number}  chartWidth Parent's chart
         * @param  {Number}  positionX  Mouse position
         * @return {Boolean}            If the mouse position allows space for the tooltip
         */
        function hasEnoughVerticalRoom(parentChartHeight, positionY) {
            return parentChartHeight - margin.top - margin.bottom - chartHeight - positionY > 0;
        }

        /**
         * Hides the tooltip
         * @return {void}
         */
        function hideTooltip() {
            svg.style('visibility', 'hidden');
        }

        /**
         * Shows the tooltip updating it's content
         * @param  {Object} dataPoint Data point from the chart
         * @return {void}
         */
        function showTooltip(dataPoint) {
            updateContent(dataPoint);
            svg.style('visibility', 'visible');
        }

        /**
         * Draws the data entries inside the tooltip for a given topic
         * @param  {Object} topic Topic to extract data from
         * @return void
         */
        function updateContent() {
            var dataPoint = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};

            var value = dataPoint[valueLabel] || '',
                name = dataPoint[nameLabel] || '',
                lineHeight = textSize * textLineHeight,
                valueLineHeight = valueTextSize * valueTextLineHeight,
                defaultDy = '1em',
                temporalHeight = 0,
                tooltipValue = void 0,
                tooltipName = void 0,
                tooltipTitle = void 0;

            tooltipTextContainer.selectAll('text').remove();

            if (title) {
                tooltipTitle = tooltipTextContainer.append('text').classed('mini-tooltip-title', true).attr('dy', defaultDy).attr('y', 0).style('fill', titleFillColor).style('font-size', textSize).text(title);

                temporalHeight = lineHeight + temporalHeight;
            }

            if (name) {
                tooltipName = tooltipTextContainer.append('text').classed('mini-tooltip-name', true).attr('dy', defaultDy).attr('y', temporalHeight || 0).style('fill', nameTextFillColor).style('font-size', textSize).text(name);

                temporalHeight = lineHeight + temporalHeight;
            }

            if (value) {
                tooltipValue = tooltipTextContainer.append('text').classed('mini-tooltip-value', true).attr('dy', defaultDy).attr('y', temporalHeight || 0).style('fill', valueTextFillColor).style('font-size', valueTextSize).style('font-weight', valueTextWeight).text(valueFormatter(value));

                temporalHeight = valueLineHeight + temporalHeight;
            }

            chartWidth = getMaxLengthLine(tooltipName, tooltipTitle, tooltipValue);
            chartHeight = temporalHeight;
        }

        /**
         * Updates size and position of tooltip depending on the side of the chart we are in
         * @param  {Object} dataPoint DataPoint of the tooltip
         * @return void
         */
        function updatePositionAndSize(mousePosition, parentChartSize) {
            var _getTooltipPosition = getTooltipPosition(mousePosition, parentChartSize),
                _getTooltipPosition2 = _slicedToArray(_getTooltipPosition, 2),
                tooltipX = _getTooltipPosition2[0],
                tooltipY = _getTooltipPosition2[1];

            svg.transition().duration(mouseChaseDuration).ease(ease).attr('height', chartHeight + margin.top + margin.bottom).attr('width', chartWidth + margin.left + margin.right).attr('transform', 'translate(' + tooltipX + ',' + tooltipY + ')');

            tooltipBackground.attr('height', chartHeight + margin.top + margin.bottom).attr('width', chartWidth + margin.left + margin.right);
        }

        /**
         * Updates tooltip content, size and position
         *
         * @param  {Object} dataPoint Current datapoint to show info about
         * @return void
         */
        function updateTooltip(dataPoint, position, chartSize) {
            updateContent(dataPoint);
            updatePositionAndSize(position, chartSize);
        }

        /**
         * Hides the tooltip
         * @return {Module} Tooltip module to chain calls
         * @public
         */
        exports.hide = function () {
            hideTooltip();

            return this;
        };

        /**
         * Gets or Sets data's nameLabel
         * @param  {text} _x Desired nameLabel
         * @return { text | module} nameLabel or Step Chart module to chain calls
         * @public
         */
        exports.nameLabel = function (_x) {
            if (!arguments.length) {
                return nameLabel;
            }
            nameLabel = _x;

            return this;
        };

        /**
         * Gets or Sets the number format for the value displayed on the tooltip
         * @param  {string} [_x=".2f"] Desired number format
         * @return {string | module} Current numberFormat or Chart module to chain calls
         * @public
         */
        exports.numberFormat = function (_x) {
            if (!arguments.length) {
                return numberFormat;
            }
            numberFormat = _x;

            return this;
        };

        /**
         * Gets or Sets the formatter function for the value displayed on the tooltip.
         * Setting this property makes the tooltip ignore numberFormat. Set by default to
         * d3-format formatter with numberFormat.
         * @param  {Function} _x Desired formatter function
         * @return {Function | module} Current valueFormatter or Chart module to chain calls
         * @public
         * @example tooltipChart.valueFormatter(value => value.toString().length.toString())
         */
        exports.valueFormatter = function (_x) {
            if (!arguments.length) {
                return valueFormatter;
            }
            valueFormatter = _x;

            return this;
        };

        /**
         * Shows the tooltip
         * @return {Module} Tooltip module to chain calls
         * @public
         */
        exports.show = function () {
            showTooltip();

            return this;
        };

        /**
         * Gets or Sets the title of the tooltip
         * @param  {string} _x Desired title
         * @return { string | module} Current title or module to chain calls
         * @public
         */
        exports.title = function (_x) {
            if (!arguments.length) {
                return title;
            }
            title = _x;

            return this;
        };

        /**
         * Updates the position and content of the tooltip
         * @param  {Object} dataPoint       Datapoint of the hovered element
         * @param  {Array} mousePosition    Mouse position relative to the parent chart [x, y]
         * @param  {Array} chartSize        Parent chart size [x, y]
         * @return {module}                 Current component
         */
        exports.update = function (dataPoint, mousePosition, chartSize) {
            updateTooltip(dataPoint, mousePosition, chartSize);

            return this;
        };

        /**
         * Gets or Sets data's valueLabel
         * @param  {text} _x        Desired valueLabel
         * @return {text | module}  valueLabel or Step Chart module to chain calls
         * @public
         */
        exports.valueLabel = function (_x) {
            if (!arguments.length) {
                return valueLabel;
            }
            valueLabel = _x;

            return this;
        };

        return exports;
    };
}.call(exports, __webpack_require__, exports, module),
				__WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));

/***/ }),
/* 295 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
var __WEBPACK_AMD_DEFINE_RESULT__;

var _extends = Object.assign || function (target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i]; for (var key in source) { if (Object.prototype.hasOwnProperty.call(source, key)) { target[key] = source[key]; } } } return target; };

function _toConsumableArray(arr) { if (Array.isArray(arr)) { for (var i = 0, arr2 = Array(arr.length); i < arr.length; i++) { arr2[i] = arr[i]; } return arr2; } else { return Array.from(arr); } }

!(__WEBPACK_AMD_DEFINE_RESULT__ = function (require) {
    'use strict';

    var d3Array = __webpack_require__(1);
    var d3Ease = __webpack_require__(4);
    var d3Scale = __webpack_require__(8);
    var d3Shape = __webpack_require__(21);
    var d3Selection = __webpack_require__(0);
    var d3Transition = __webpack_require__(3);

    var _require = __webpack_require__(15),
        exportChart = _require.exportChart;

    var colorHelper = __webpack_require__(5);

    var _require2 = __webpack_require__(13),
        stackedAreaLoadingMarkup = _require2.stackedArea;

    var _require3 = __webpack_require__(23),
        uniqueId = _require3.uniqueId;

    var DEFAULT_TITLE_TEXT_STYLE = {
        'font-size': '22px',
        'font-family': 'sans-serif',
        'font-style': 'normal',
        'font-weight': 0

        /**
         * @typedef SparklineChartData
         * @type {Object[]}
         * @property {Number} value        Value of the group (required)
         * @property {String} name         Name of the group (required)
         *
         * @example
         * [
         *     {
         *         value: 1,
         *         date: '2011-01-06T00:00:00Z'
         *     },
         *     {
         *         value: 2,
         *         date: '2011-01-07T00:00:00Z'
         *     }
         * ]
         */

        /**
         * Sparkline Chart reusable API module that allows us
         * rendering a sparkline configurable chart.
         *
         * @module Sparkline
         * @tutorial sparkline
         * @requires d3
         *
         * @example
         * var sparkLineChart = sparkline();
         *
         * sparkLineChart
         *     .width(200)
         *     .height(100);
         *
         * d3Selection.select('.css-selector')
         *     .datum(dataset)
         *     .call(sparkLineChart);
         *
         */
    };return function module() {

        var margin = {
            left: 5,
            right: 5,
            top: 5,
            bottom: 5
        },
            width = 100,
            height = 30,
            loadingState = stackedAreaLoadingMarkup,
            xScale = void 0,
            yScale = void 0,
            areaGradient = ['#F5FDFF', '#F6FEFC'],
            areaGradientEl = void 0,
            areaGradientId = uniqueId('sparkline-area-gradient'),
            lineStrokeWidth = 2,
            lineGradient = colorHelper.colorGradients.greenBlue,
            lineGradientEl = void 0,
            lineGradientId = uniqueId('sparkline-line-gradient'),
            maskingClip = void 0,
            maskingClipId = uniqueId('maskingClip'),
            svg = void 0,
            chartWidth = void 0,
            chartHeight = void 0,
            data = void 0,
            hasArea = true,
            isAnimated = false,
            clipDuration = 3000,
            ease = d3Ease.easeQuadInOut,
            topLine = void 0,
            area = void 0,
            circle = void 0,
            titleEl = void 0,
            titleText = void 0,
            titleTextStyle = DEFAULT_TITLE_TEXT_STYLE,
            markerSize = 1.5,
            valueLabel = 'value',
            dateLabel = 'date',


        // getters
        getDate = function getDate(_ref) {
            var date = _ref.date;
            return date;
        },
            getValue = function getValue(_ref2) {
            var value = _ref2.value;
            return value;
        };

        /**
         * This function creates the graph using the selection and data provided
         *
         * @param {D3Selection} _selection A d3 selection that represents
         * the container(s) where the chart(s) will be rendered
         * @param {SparklineChartData} _data The data to attach and generate the chart
         */
        function exports(_selection) {
            _selection.each(function (_data) {
                chartWidth = width - margin.left - margin.right;
                chartHeight = height - margin.top - margin.bottom;
                data = cleanData(_data);

                buildScales();
                buildSVG(this);
                createGradients();
                createMaskingClip();
                drawArea();
                drawLine();
                drawEndMarker();

                if (titleText) {
                    drawSparklineTitle();
                }
            });
        }

        /**
         * Builds containers for the chart, the axis and a wrapper for all of them
         * NOTE: The order of drawing of this group elements is really important,
         * as everything else will be drawn on top of them
         * @private
         */
        function buildContainerGroups() {
            var container = svg.append('g').classed('container-group', true).attr('transform', 'translate(' + margin.left + ',' + margin.top + ')');

            container.append('g').classed('text-group', true);
            container.append('g').classed('chart-group', true);
            container.append('g').classed('metadata-group', true);
        }

        /**
         * Creates the x, y and color scales of the chart
         * @private
         */
        function buildScales() {
            xScale = d3Scale.scaleLinear().domain(d3Array.extent(data, getDate)).range([0, chartWidth]);

            yScale = d3Scale.scaleLinear().domain(d3Array.extent(data, getValue)).range([chartHeight, 0]);
        }

        /**
         * Builds the SVG element that will contain the chart
         * @param  {HTMLElement} container DOM element that will work as the container of the graph
         * @private
         */
        function buildSVG(container) {
            if (!svg) {
                svg = d3Selection.select(container).append('svg').classed('britechart sparkline', true);

                buildContainerGroups();
            }

            svg.attr('width', width).attr('height', height);
        }

        /**
         * Cleaning data casting the values and dates to the proper type while keeping
         * the rest of properties on the data
         * @param  {SparklineChartData} originalData    Raw data from the container
         * @return {SparklineChartData}                 Clean data
         * @private
         */
        function cleanData(originalData) {
            return originalData.reduce(function (acc, d) {
                d.date = new Date(d[dateLabel]);
                d.value = +d[valueLabel];

                return [].concat(_toConsumableArray(acc), [d]);
            }, []);
        }

        /**
         * Creates the gradient on the area below the line
         * @return {void}
         */
        function createGradients() {
            var metadataGroup = svg.select('.metadata-group');

            if (areaGradientEl || lineGradientEl) {
                svg.selectAll('#' + areaGradientId).remove();
                svg.selectAll('#' + lineGradientId).remove();
            }

            areaGradientEl = metadataGroup.append('linearGradient').attr('id', areaGradientId).attr('class', 'area-gradient').attr('gradientUnits', 'userSpaceOnUse').attr('x1', 0).attr('x2', xScale(data[data.length - 1].date)).attr('y1', 0).attr('y2', 0).selectAll('stop').data([{ offset: '0%', color: areaGradient[0] }, { offset: '100%', color: areaGradient[1] }]).enter().append('stop').attr('offset', function (_ref3) {
                var offset = _ref3.offset;
                return offset;
            }).attr('stop-color', function (_ref4) {
                var color = _ref4.color;
                return color;
            });

            lineGradientEl = metadataGroup.append('linearGradient').attr('id', lineGradientId).attr('class', 'line-gradient').attr('gradientUnits', 'userSpaceOnUse').attr('x1', 0).attr('x2', xScale(data[data.length - 1].date)).attr('y1', 0).attr('y2', 0).selectAll('stop').data([{ offset: '0%', color: lineGradient[0] }, { offset: '100%', color: lineGradient[1] }]).enter().append('stop').attr('offset', function (_ref5) {
                var offset = _ref5.offset;
                return offset;
            }).attr('stop-color', function (_ref6) {
                var color = _ref6.color;
                return color;
            });
        }

        /**
         * Creates a masking clip that would help us fake an animation if the
         * proper flag is true
         *
         * @return {void}
         */
        function createMaskingClip() {
            if (maskingClip) {
                svg.selectAll('#' + maskingClipId).remove();
            }

            if (isAnimated) {
                maskingClip = svg.select('.metadata-group').append('clipPath').attr('id', maskingClipId).attr('class', 'clip-path').append('rect').attr('width', 0).attr('height', height);

                d3Selection.select('#' + maskingClipId + ' rect').transition().ease(ease).duration(clipDuration).attr('width', width);
            }
        }

        /**
         * Draws the area that will be placed below the line
         * @private
         */
        function drawArea() {
            if (area) {
                svg.selectAll('.sparkline-area').remove();
            }

            area = d3Shape.area().x(function (_ref7) {
                var date = _ref7.date;
                return xScale(date);
            }).y0(function () {
                return yScale(0) + lineStrokeWidth / 2;
            }).y1(function (_ref8) {
                var value = _ref8.value;
                return yScale(value);
            }).curve(d3Shape.curveBasis);

            svg.select('.chart-group').append('path').datum(data).attr('class', 'sparkline-area').attr('fill', 'url(#' + areaGradientId + ')').attr('d', area).attr('clip-path', 'url(#' + maskingClipId + ')');
        }

        /**
         * Draws the line element within the chart group
         * @private
         */
        function drawLine() {
            if (topLine) {
                svg.selectAll('.line').remove();
            }

            topLine = d3Shape.line().curve(d3Shape.curveBasis).x(function (_ref9) {
                var date = _ref9.date;
                return xScale(date);
            }).y(function (_ref10) {
                var value = _ref10.value;
                return yScale(value);
            });

            svg.select('.chart-group').append('path').datum(data).attr('class', 'line').attr('stroke', 'url(#' + lineGradientId + ')').attr('d', topLine).attr('clip-path', 'url(#' + maskingClipId + ')');
        }

        /**
         * Draws the text element within the text group
         * Is displayed at the top of sparked area
         * @private
         */
        function drawSparklineTitle() {
            if (titleEl) {
                svg.selectAll('.sparkline-text').remove();
            }

            titleEl = svg.selectAll('.text-group').append('text').attr('x', chartWidth / 2).attr('y', chartHeight / 6).attr('text-anchor', 'middle').attr('class', 'sparkline-text').style('font-size', titleTextStyle['font-size'] || DEFAULT_TITLE_TEXT_STYLE['font-size']).style('fill', titleTextStyle['fill'] || lineGradient[0]).style('font-family', titleTextStyle['font-family'] || DEFAULT_TITLE_TEXT_STYLE['font-family']).style('font-weight', titleTextStyle['font-weight'] || DEFAULT_TITLE_TEXT_STYLE['font-weight']).style('font-style', titleTextStyle['font-style'] || DEFAULT_TITLE_TEXT_STYLE['font-style']).text(titleText);
        }

        /**
         * Draws a marker at the end of the sparkline
         */
        function drawEndMarker() {
            if (circle) {
                svg.selectAll('.sparkline-circle').remove();
            }

            circle = svg.selectAll('.chart-group').append('circle').attr('class', 'sparkline-circle').attr('cx', xScale(data[data.length - 1].date)).attr('cy', yScale(data[data.length - 1].value)).attr('r', markerSize);
        }

        // API

        /**
         * Gets or Sets the areaGradient of the chart
         * @param  {String[]} _x Desired areaGradient for the graph
         * @return {areaGradient | module} Current areaGradient or Chart module to chain calls
         * @public
         */
        exports.areaGradient = function (_x) {
            if (!arguments.length) {
                return areaGradient;
            }
            areaGradient = _x;
            return this;
        };

        /**
         * Gets or Sets the dateLabel of the chart
         * @param  {Number} _x Desired dateLabel for the graph
         * @return {dateLabel | module} Current dateLabel or Chart module to chain calls
         * @public
         */
        exports.dateLabel = function (_x) {
            if (!arguments.length) {
                return dateLabel;
            }
            dateLabel = _x;

            return this;
        };

        /**
         * Gets or Sets the duration of the animation
         * @param  {Number} _x Desired animation duration for the graph
         * @return {dateLabel | module} Current animation duration or Chart module to chain calls
         * @public
         */
        exports.duration = function (_x) {
            if (!arguments.length) {
                return clipDuration;
            }
            clipDuration = _x;

            return this;
        };

        /**
         * Chart exported to png and a download action is fired
         * @param {String} filename     File title for the resulting picture
         * @param {String} title        Title to add at the top of the exported picture
         * @public
         */
        exports.exportChart = function (filename, title) {
            exportChart.call(exports, svg, filename, title);
        };

        /**
         * Gets or Sets the height of the chart
         * @param  {Number} _x Desired width for the graph
         * @return { height | module} Current height or Chart module to chain calls
         * @public
         */
        exports.height = function (_x) {
            if (!arguments.length) {
                return height;
            }
            height = _x;

            return this;
        };

        /**
         * Gets or Sets the isAnimated property of the chart, making it to animate when render.
         * By default this is 'false'
         *
         * @param  {Boolean} _x Desired animation flag
         * @return {isAnimated | module} Current isAnimated flag or Chart module
         * @public
         */
        exports.isAnimated = function (_x) {
            if (!arguments.length) {
                return isAnimated;
            }
            isAnimated = _x;

            return this;
        };

        /**
         * Gets or Sets the lineGradient of the chart
         * @param  {String[]} _x Desired lineGradient for the graph
         * @return {lineGradient | module} Current lineGradient or Chart module to chain calls
         * @public
         */
        exports.lineGradient = function (_x) {
            if (!arguments.length) {
                return lineGradient;
            }
            lineGradient = _x;
            return this;
        };

        /**
         * Gets or Sets the loading state of the chart
         * @param  {string} markup Desired markup to show when null data
         * @return {loadingState | module} Current loading state markup or Chart module to chain calls
         * @public
         */
        exports.loadingState = function (_markup) {
            if (!arguments.length) {
                return loadingState;
            }
            loadingState = _markup;

            return this;
        };

        /**
         * Gets or Sets the margin of the chart
         * @param  {Object} _x Margin object to get/set
         * @return {margin | module} Current margin or Chart module to chain calls
         * @public
         */
        exports.margin = function (_x) {
            if (!arguments.length) {
                return margin;
            }
            margin = _extends({}, margin, _x);

            return this;
        };

        /**
         * Gets or Sets the text of the title at the top of sparkline.
         * To style the title, use the titleTextStyle method below.
         * @param  {String} _x  String to set
         * @return {String | module} Current titleText or Chart module to chain calls
         * @public
         */
        exports.titleText = function (_x) {
            if (!arguments.length) {
                return titleText;
            }
            titleText = _x;

            return this;
        };

        /**
         * Gets or Sets the text style object of the title at the top of sparkline.
         * Using this method, you can set font-family, font-size, font-weight, font-style,
         * and color (fill). The default text font settings:
         *
         * <pre>
         * <code>
         * {
         *    'font-family': 'sans-serif',
         *    'font-size': '22px',
         *    'font-weight': 0,
         *    'font-style': 'normal',
         *    'fill': linearGradient[0]
         * }
         * </code>
         * </pre>
         *
         * You can set attributes individually. Setting just 'font-family'
         * within the object will set custom 'font-family` while the rest
         * of the attributes will have the default values provided above.
         * @param  {Object} _x  Object with text font configurations
         * @return {Object | module} Current titleTextStyle or Chart module to chain calls
         * @public
         * @example
         * sparkline.titleTextStyle({
         *    'font-family': 'Roboto',
         *    'font-size': '1.5em',
         *    'font-weight': 600,
         *    'font-style': 'italic',
         *    'fill': 'lightblue'
         * })
         */
        exports.titleTextStyle = function (_x) {
            if (!arguments.length) {
                return titleTextStyle;
            }
            titleTextStyle = _x;

            return this;
        };

        /**
         * Gets or Sets the valueLabel of the chart
         * @param  {Number} _x Desired valueLabel for the graph
         * @return {valueLabel | module} Current valueLabel or Chart module to chain calls
         * @public
         */
        exports.valueLabel = function (_x) {
            if (!arguments.length) {
                return valueLabel;
            }
            valueLabel = _x;

            return this;
        };

        /**
         * Gets or Sets the width of the chart
         * @param  {Number} _x Desired width for the graph
         * @return {width | module} Current width or Chart module to chain calls
         * @public
         */
        exports.width = function (_x) {
            if (!arguments.length) {
                return width;
            }
            width = _x;

            return this;
        };

        return exports;
    };
}.call(exports, __webpack_require__, exports, module),
				__WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));

/***/ }),
/* 296 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
var __WEBPACK_AMD_DEFINE_RESULT__;

var _extends = Object.assign || function (target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i]; for (var key in source) { if (Object.prototype.hasOwnProperty.call(source, key)) { target[key] = source[key]; } } } return target; };

var _slicedToArray = function () { function sliceIterator(arr, i) { var _arr = []; var _n = true; var _d = false; var _e = undefined; try { for (var _i = arr[Symbol.iterator](), _s; !(_n = (_s = _i.next()).done); _n = true) { _arr.push(_s.value); if (i && _arr.length === i) break; } } catch (err) { _d = true; _e = err; } finally { try { if (!_n && _i["return"]) _i["return"](); } finally { if (_d) throw _e; } } return _arr; } return function (arr, i) { if (Array.isArray(arr)) { return arr; } else if (Symbol.iterator in Object(arr)) { return sliceIterator(arr, i); } else { throw new TypeError("Invalid attempt to destructure non-iterable instance"); } }; }();

function _toConsumableArray(arr) { if (Array.isArray(arr)) { for (var i = 0, arr2 = Array(arr.length); i < arr.length; i++) { arr2[i] = arr[i]; } return arr2; } else { return Array.from(arr); } }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

!(__WEBPACK_AMD_DEFINE_RESULT__ = function (require) {
    'use strict';

    var d3Array = __webpack_require__(1);
    var d3Axis = __webpack_require__(17);
    var d3Collection = __webpack_require__(27);
    var d3Dispatch = __webpack_require__(6);
    var d3Ease = __webpack_require__(4);
    var d3Scale = __webpack_require__(8);
    var d3Shape = __webpack_require__(21);
    var d3Selection = __webpack_require__(0);
    var d3Transition = __webpack_require__(3);
    var d3TimeFormat = __webpack_require__(19);
    var assign = __webpack_require__(66);

    var _require = __webpack_require__(15),
        exportChart = _require.exportChart;

    var colorHelper = __webpack_require__(5);

    var _require2 = __webpack_require__(65),
        getTimeSeriesAxis = _require2.getTimeSeriesAxis;

    var _require3 = __webpack_require__(20),
        axisTimeCombinations = _require3.axisTimeCombinations,
        curveMap = _require3.curveMap;

    var _require4 = __webpack_require__(23),
        formatIntegerValue = _require4.formatIntegerValue,
        formatDecimalValue = _require4.formatDecimalValue,
        isInteger = _require4.isInteger;

    var _require5 = __webpack_require__(120),
        createFilterContainer = _require5.createFilterContainer,
        createGlowWithMatrix = _require5.createGlowWithMatrix,
        bounceCircleHighlight = _require5.bounceCircleHighlight;

    var _require6 = __webpack_require__(119),
        addDays = _require6.addDays,
        diffDays = _require6.diffDays;

    var _require7 = __webpack_require__(13),
        stackedAreaLoadingMarkup = _require7.stackedArea;

    var uniq = function uniq(arrArg) {
        return arrArg.filter(function (elem, pos, arr) {
            return arr.indexOf(elem) === pos;
        });
    };

    /**
     * @typdef D3Layout
     * @type function
     */

    /**
     * @typedef areaChartData
     * @type {Object[]}
     * @property {String} date         Date of the entry in ISO8601 format (required)
     * @property {String} name         Name of the entry (required)
     * @property {Number} value        Value of the entry (required)
     *
     * @example
     * [
     *     {
     *         date: "2011-01-05T00:00:00Z",
     *         name: "Direct",
     *         value: 0
     *     }
     * ]
     */

    /**
     * Stacked Area Chart reusable API module that allows us
     * rendering a multi area and configurable chart.
     *
     * @module Stacked-area
     * @tutorial stacked-area
     * @requires d3-array, d3-axis, d3-collection, d3-ease, d3-scale, d3-shape, d3-selection, d3-time, d3-time-format
     *
     * @example
     * let stackedArea = stackedArea();
     *
     * stackedArea
     *     .width(containerWidth);
     *
     * d3Selection.select('.css-selector')
     *     .datum(dataset.data)
     *     .call(stackedArea);
     *
     */

    return function module() {

        var margin = {
            top: 70,
            right: 30,
            bottom: 60,
            left: 70
        },
            width = 960,
            height = 500,
            loadingState = stackedAreaLoadingMarkup,
            xScale = void 0,
            xAxis = void 0,
            xMonthAxis = void 0,
            yScale = void 0,
            yAxis = void 0,
            aspectRatio = null,
            monthAxisPadding = 30,
            yTicks = 5,
            yTickTextYOffset = -8,
            yAxisLabel = void 0,
            yAxisLabelEl = void 0,
            yAxisLabelOffset = -60,
            yTickTextXOffset = -20,
            tickPadding = 5,
            colorSchema = colorHelper.colorSchemas.britecharts,
            lineGradient = colorHelper.colorGradients.greenBlue,
            highlightFilter = null,
            highlightFilterId = null,
            highlightCircleSize = 12,
            highlightCircleRadius = 5,
            highlightCircleStroke = 1.2,
            highlightCircleActiveRadius = highlightCircleRadius + 2,
            highlightCircleActiveStrokeWidth = 5,
            highlightCircleActiveStrokeOpacity = 0.6,
            areaOpacity = 0.24,
            categoryColorMap = void 0,
            order = void 0,
            topicsOrder = void 0,
            xAxisFormat = null,
            xTicks = null,
            xAxisCustomFormat = null,
            locale = void 0,
            baseLine = void 0,
            areaCurve = 'monotoneX',
            layers = void 0,
            series = void 0,
            layersInitial = void 0,
            area = void 0,
            areaOutline = void 0,


        // Area Animation
        maxAreaNumber = 10,
            areaAnimationDelayStep = 20,
            areaAnimationDelays = d3Array.range(areaAnimationDelayStep, maxAreaNumber * areaAnimationDelayStep, areaAnimationDelayStep),
            overlay = void 0,
            overlayColor = 'rgba(0, 0, 0, 0)',
            verticalMarkerContainer = void 0,
            verticalMarkerLine = void 0,
            epsilon = void 0,
            dataPoints = {},
            pointsSize = 1.5,
            pointsColor = '#c0c6cc',
            pointsBorderColor = '#ffffff',
            isAnimated = false,
            ease = d3Ease.easeQuadInOut,
            areaAnimationDuration = 1000,
            hasOutline = true,
            svg = void 0,
            chartWidth = void 0,
            chartHeight = void 0,
            data = void 0,
            dataByDate = void 0,
            dataByDateFormatted = void 0,
            dataByDateZeroed = void 0,
            verticalGridLines = void 0,
            horizontalGridLines = void 0,
            grid = null,
            tooltipThreshold = 480,
            xAxisPadding = {
            top: 0,
            left: 15,
            bottom: 0,
            right: 0
        },
            dateLabel = 'date',
            valueLabel = 'value',
            keyLabel = 'name',
            emptyDataConfig = {
            minDate: new Date(new Date().setDate(new Date().getDate() - 30)),
            maxDate: new Date(),
            maxY: 500
        },
            isUsingFakeData = false,


        // getters
        getName = function getName(_ref) {
            var name = _ref.name;
            return name;
        },
            getDate = function getDate(_ref2) {
            var date = _ref2.date;
            return date;
        },


        // events
        dispatcher = d3Dispatch.dispatch('customMouseOver', 'customMouseOut', 'customMouseMove', 'customDataEntryClick', 'customTouchMove');

        /**
          * This function creates the graph using the selection and data provided
          * @param {D3Selection} _selection A d3 selection that represents
          * the container(s) where the chart(s) will be rendered
          * @param {areaChartData} _data The data to attach and generate the chart
          */
        function exports(_selection) {
            _selection.each(function (_data) {
                chartWidth = width - margin.left - margin.right;
                chartHeight = height - margin.top - margin.bottom;
                data = cleanData(_data);
                dataByDate = getDataByDate(data);

                buildLayers();
                buildScales();
                buildSVG(this);
                buildAxis();
                drawAxis();
                drawStackedAreas();

                addTouchEvents();

                if (shouldShowTooltip()) {
                    drawHoverOverlay();
                    drawVerticalMarker();
                    addMouseEvents();
                }
            });
        }

        /**
         * Adds a filter to the element
         * @param {DOMElement} el
         * @private
         */
        function addGlowFilter(el) {
            if (!highlightFilter) {
                highlightFilter = createFilterContainer(svg.select('.metadata-group'));
                highlightFilterId = createGlowWithMatrix(highlightFilter);
            }

            var glowEl = d3Selection.select(el);

            glowEl.style('stroke-width', highlightCircleActiveStrokeWidth).style('stroke-opacity', highlightCircleActiveStrokeOpacity).attr('filter', 'url(#' + highlightFilterId + ')');

            bounceCircleHighlight(glowEl, ease, highlightCircleActiveRadius);
        }

        /**
         * Adds events to the container group if the environment is not mobile
         * Adding: mouseover, mouseout and mousemove
         * @private
         */
        function addMouseEvents() {
            svg.on('mouseover', function (d) {
                handleMouseOver(this, d);
            }).on('mouseout', function (d) {
                handleMouseOut(this, d);
            }).on('mousemove', function (d) {
                handleMouseMove(this, d);
            });
        }

        /**
         * Adds events to the container group for the mobile environment
         * Adding: touchmove
         * @private
         */
        function addTouchEvents() {
            svg.on('touchmove', function (d) {
                handleTouchMove(this, d);
            });
        }

        /**
         * Formats the value depending on its characteristics
         * @param  {Number} value Value to format
         * @return {Number}       Formatted value
         */
        function getFormattedValue(value) {
            var format = void 0;

            if (isInteger(value)) {
                format = formatIntegerValue;
            } else {
                format = formatDecimalValue;
            }

            return format(value);
        }

        /**
         * Creates the d3 x and y axis, setting orientations
         * @private
         */
        function buildAxis() {
            var minor = void 0,
                major = void 0;

            if (xAxisFormat === 'custom' && typeof xAxisCustomFormat === 'string') {
                minor = {
                    tick: xTicks,
                    format: d3TimeFormat.timeFormat(xAxisCustomFormat)
                };
                major = null;
            } else {
                var _getTimeSeriesAxis = getTimeSeriesAxis(dataByDate, width, xAxisFormat, locale);

                minor = _getTimeSeriesAxis.minor;
                major = _getTimeSeriesAxis.major;


                xMonthAxis = d3Axis.axisBottom(xScale).ticks(major.tick).tickSize(0, 0).tickFormat(major.format);
            }

            xAxis = d3Axis.axisBottom(xScale).ticks(minor.tick).tickSize(10, 0).tickPadding(tickPadding).tickFormat(minor.format);

            yAxis = d3Axis.axisRight(yScale).ticks(yTicks).tickSize([0]).tickPadding(tickPadding).tickFormat(getFormattedValue);

            drawGridLines(minor.tick, yTicks);
        }

        /**
         * Builds containers for the chart, the axis and a wrapper for all of them
         * NOTE: The order of drawing of this group elements is really important,
         * as everything else will be drawn on top of them
         * @private
         */
        function buildContainerGroups() {
            var container = svg.append('g').classed('container-group', true).attr('transform', 'translate(' + margin.left + ',' + margin.top + ')');

            container.append('g').classed('x-axis-group', true).append('g').classed('x axis', true);
            container.selectAll('.x-axis-group').append('g').classed('month-axis', true);
            container.append('g').classed('y-axis-group axis', true);
            container.append('g').classed('grid-lines-group', true);
            container.append('g').classed('y-axis-label', true);
            container.append('g').classed('chart-group', true);
            container.append('g').classed('metadata-group', true);
        }

        /**
         * Builds the stacked layers layout
         * @return {D3Layout} Layout for drawing the chart
         * @private
         */
        function buildLayers() {
            dataByDateFormatted = dataByDate.map(function (d) {
                return assign({}, d, d.values);
            }).map(function (d) {
                Object.keys(d).forEach(function (k) {
                    var entry = d[k];

                    if (entry && entry.name) {
                        d[entry.name] = entry.value;
                    }
                });

                return assign({}, d, {
                    date: new Date(d['key'])
                });
            });

            dataByDateZeroed = dataByDate.map(function (d) {
                return assign({}, d, d.values);
            }).map(function (d) {
                Object.keys(d).forEach(function (k) {
                    var entry = d[k];

                    if (entry && entry.name) {
                        d[entry.name] = 0;
                    }
                });

                return assign({}, d, {
                    date: new Date(d['key'])
                });
            });

            var initialTotalsObject = uniq(data.map(getName)).reduce(function (memo, key) {
                return assign({}, memo, _defineProperty({}, key, 0));
            }, {});

            var totals = data.reduce(function (memo, item) {
                return assign({}, memo, _defineProperty({}, item.name, memo[item.name] += item.value));
            }, initialTotalsObject);

            order = topicsOrder || formatOrder(totals);

            var stack3 = d3Shape.stack().keys(order).order(d3Shape.stackOrderNone).offset(d3Shape.stackOffsetNone);

            layersInitial = stack3(dataByDateZeroed);
            layers = stack3(dataByDateFormatted);
        }

        /**
         * Takes an object with all topics as keys and their aggregate totals as values,
         * sorts them into a list by descending total value and
         * moves "Other" to the end
         * @param  {Object} totals  Keys of all the topics and their corresponding totals
         * @return {Array}          List of topic names in aggregate order
         */
        function formatOrder(totals) {
            var order = Object.keys(totals).sort(function (a, b) {
                if (totals[a] > totals[b]) return -1;
                if (totals[a] === totals[b]) return 0;

                return 1;
            });

            var otherIndex = order.indexOf('Other');

            if (otherIndex >= 0) {
                var other = order.splice(otherIndex, 1);

                order = order.concat(other);
            }

            return order;
        }

        /**
         * Creates the x, y and color scales of the chart
         * @private
         */
        function buildScales() {
            var maxValueByDate = isUsingFakeData ? emptyDataConfig.maxY : getMaxValueByDate();

            xScale = d3Scale.scaleTime().domain(d3Array.extent(dataByDate, function (_ref3) {
                var date = _ref3.date;
                return date;
            })).rangeRound([0, chartWidth]);

            yScale = d3Scale.scaleLinear().domain([0, maxValueByDate]).rangeRound([chartHeight, 0]).nice();

            categoryColorMap = order.reduce(function (memo, topic, index) {
                return assign({}, memo, _defineProperty({}, topic, colorSchema[index]));
            }, {});
        }

        /**
         * @param  {HTMLElement} container DOM element that will work as the container of the graph
         * @private
         */
        function buildSVG(container) {
            if (!svg) {
                svg = d3Selection.select(container).append('svg').classed('britechart stacked-area', true);

                buildContainerGroups();
            }

            svg.attr('width', width).attr('height', height);
        }

        /**
         * Creates fake data for when data is an empty array
         * @return {array}      Fake data built from emptyDataConfig settings
         */
        function createFakeData() {
            var numDays = diffDays(emptyDataConfig.minDate, emptyDataConfig.maxDate);
            var emptyArray = Array.apply(null, Array(numDays));

            isUsingFakeData = true;

            return [].concat(_toConsumableArray(emptyArray.map(function (el, i) {
                var _ref4;

                return _ref4 = {}, _defineProperty(_ref4, dateLabel, addDays(emptyDataConfig.minDate, i)), _defineProperty(_ref4, valueLabel, 0), _defineProperty(_ref4, keyLabel, '1'), _ref4;
            })), _toConsumableArray(emptyArray.map(function (el, i) {
                var _ref5;

                return _ref5 = {}, _defineProperty(_ref5, dateLabel, addDays(emptyDataConfig.minDate, i)), _defineProperty(_ref5, valueLabel, 0), _defineProperty(_ref5, keyLabel, '2'), _ref5;
            })));
        }

        /**
         * Cleaning data casting the values and dates to the proper type while keeping
         * the rest of properties on the data. It creates fake data is the data is empty.
         * @param  {areaChartData} originalData   Raw data from the container
         * @return {areaChartData}                Parsed data with values and dates
         * @private
         */
        function cleanData(originalData) {
            originalData = originalData.length === 0 ? createFakeData() : originalData;

            return originalData.reduce(function (acc, d) {
                d.date = new Date(d[dateLabel]), d.value = +d[valueLabel];

                return [].concat(_toConsumableArray(acc), [d]);
            }, []);
        }

        /**
         * Draws the x and y axis on the svg object within their
         * respective groups
         * @private
         */
        function drawAxis() {
            svg.select('.x-axis-group .axis.x').attr('transform', 'translate( 0, ' + chartHeight + ' )').call(xAxis);

            if (xAxisFormat !== 'custom') {
                svg.select('.x-axis-group .month-axis').attr('transform', 'translate(0, ' + (chartHeight + monthAxisPadding) + ')').call(xMonthAxis);
            }

            svg.select('.y-axis-group.axis').attr('transform', 'translate( ' + -xAxisPadding.left + ', 0)').call(yAxis).call(adjustYTickLabels);

            if (yAxisLabel) {
                if (yAxisLabelEl) {
                    svg.selectAll('.y-axis-label-text').remove();
                }

                yAxisLabelEl = svg.select('.y-axis-label').append('text').classed('y-axis-label-text', true).attr('x', -chartHeight / 2).attr('y', yAxisLabelOffset).attr('text-anchor', 'middle').attr('transform', 'rotate(270 0 0)').text(yAxisLabel);
            }

            // Moving the YAxis tick labels to the right side
            // d3Selection.selectAll('.y-axis-group .tick text')
            //     .attr('transform', `translate( ${-chartWidth - yTickTextXOffset}, ${yTickTextYOffset})` );
        }

        /**
         * Adjusts the position of the y axis' ticks
         * @param  {D3Selection} selection Y axis group
         * @return void
         */
        function adjustYTickLabels(selection) {
            selection.selectAll('.tick text').attr('transform', 'translate(' + yTickTextXOffset + ', ' + yTickTextYOffset + ')');
        }

        /**
         * Creates SVG dot elements for each data entry and draws them
         * TODO: Plug
         */
        function drawDataReferencePoints() {
            // Creates Dots on Data points
            var points = svg.select('.chart-group').selectAll('.dots').data(layers).enter().append('g').attr('class', 'dots').attr('d', function (_ref6) {
                var values = _ref6.values;
                return area(values);
            }).attr('clip-path', 'url(#clip)');

            // Processes the points
            // TODO: Optimize this code
            points.selectAll('.dot').data(function (_ref7, index) {
                var values = _ref7.values;
                return values.map(function (point) {
                    return { index: index, point: point };
                });
            }).enter().append('circle').attr('class', 'dot').attr('r', function () {
                return pointsSize;
            }).attr('fill', function () {
                return pointsColor;
            }).attr('stroke-width', '0').attr('stroke', pointsBorderColor).attr('transform', function (d) {
                var point = d.point;

                var key = xScale(point.date);

                dataPoints[key] = dataPoints[key] || [];
                dataPoints[key].push(d);

                var date = point.date,
                    y = point.y,
                    y0 = point.y0;


                return 'translate( ' + xScale(date) + ', ' + yScale(y + y0) + ' )';
            });
        }

        /**
         * Draws grid lines on the background of the chart
         * @return void
         */
        function drawGridLines(xTicks, yTicks) {
            svg.select('.grid-lines-group').selectAll('line').remove();

            if (grid === 'horizontal' || grid === 'full') {
                horizontalGridLines = svg.select('.grid-lines-group').selectAll('line.horizontal-grid-line').data(yScale.ticks(yTicks)).enter().append('line').attr('class', 'horizontal-grid-line').attr('x1', -xAxisPadding.left - 30).attr('x2', chartWidth).attr('y1', function (d) {
                    return yScale(d);
                }).attr('y2', function (d) {
                    return yScale(d);
                });
            }

            if (grid === 'vertical' || grid === 'full') {
                verticalGridLines = svg.select('.grid-lines-group').selectAll('line.vertical-grid-line').data(xScale.ticks(xTicks)).enter().append('line').attr('class', 'vertical-grid-line').attr('y1', 0).attr('y2', chartHeight).attr('x1', function (d) {
                    return xScale(d);
                }).attr('x2', function (d) {
                    return xScale(d);
                });
            }

            //draw a horizontal line to extend x-axis till the edges
            baseLine = svg.select('.grid-lines-group').selectAll('line.extended-x-line').data([0]).enter().append('line').attr('class', 'extended-x-line').attr('x1', -xAxisPadding.left - 30).attr('x2', chartWidth).attr('y1', height - margin.bottom - margin.top).attr('y2', height - margin.bottom - margin.top);
        }

        /**
         * Draws an overlay element over the graph
         * @private
         */
        function drawHoverOverlay() {
            // Not ideal, we need to figure out how to call exit for nested elements
            if (overlay) {
                svg.selectAll('.overlay').remove();
            }

            overlay = svg.select('.metadata-group').append('rect').attr('class', 'overlay').attr('y1', 0).attr('y2', chartHeight).attr('height', chartHeight).attr('width', chartWidth).attr('fill', overlayColor).style('display', 'none');
        }

        /**
         * Draws an empty line when the data is all zero
         * @private
         */
        function drawEmptyDataLine() {
            var emptyDataLine = d3Shape.line().x(function (d) {
                return xScale(d.date);
            }).y(function () {
                return yScale(0) - 1;
            });

            var chartGroup = svg.select('.chart-group');

            chartGroup.append('path').attr('class', 'empty-data-line').attr('d', emptyDataLine(dataByDateFormatted)).style('stroke', 'url(#empty-data-line-gradient)');

            chartGroup.append('linearGradient').attr('id', 'empty-data-line-gradient').attr('gradientUnits', 'userSpaceOnUse').attr('x1', 0).attr('x2', xScale(data[data.length - 1].date)).attr('y1', 0).attr('y2', 0).selectAll('stop').data([{ offset: '0%', color: lineGradient[0] }, { offset: '100%', color: lineGradient[1] }]).enter().append('stop').attr('offset', function (_ref8) {
                var offset = _ref8.offset;
                return offset;
            }).attr('stop-color', function (_ref9) {
                var color = _ref9.color;
                return color;
            });
        }

        /**
         * Draws the different areas into the chart-group element
         * @private
         */
        function drawStackedAreas() {
            // Not ideal, we need to figure out how to call exit for nested elements
            if (series) {
                svg.selectAll('.layer-container').remove();
                svg.selectAll('.layer').remove();
                svg.selectAll('.area-outline').remove();
            }

            if (isUsingFakeData) {
                drawEmptyDataLine();

                return;
            }

            area = d3Shape.area().curve(curveMap[areaCurve]).x(function (_ref10) {
                var data = _ref10.data;
                return xScale(data.date);
            }).y0(function (d) {
                return yScale(d[0]);
            }).y1(function (d) {
                return yScale(d[1]);
            });

            areaOutline = d3Shape.line().curve(area.curve()).x(function (_ref11) {
                var data = _ref11.data;
                return xScale(data.date);
            }).y(function (d) {
                return yScale(d[1]);
            });

            if (isAnimated) {
                series = svg.select('.chart-group').selectAll('.layer').data(layersInitial, getName).enter().append('g').classed('layer-container', true);

                series.append('path').attr('class', 'layer').attr('d', area).style('opacity', areaOpacity).style('fill', function (_ref12) {
                    var key = _ref12.key;
                    return categoryColorMap[key];
                });

                series.append('path').attr('class', 'area-outline').attr('d', areaOutline).style('stroke', function (_ref13) {
                    var key = _ref13.key;
                    return categoryColorMap[key];
                });

                // Update
                svg.select('.chart-group').selectAll('.layer').data(layers).transition().delay(function (_, i) {
                    return areaAnimationDelays[i];
                }).duration(areaAnimationDuration).ease(ease).attr('d', area).style('opacity', areaOpacity).style('fill', function (_ref14) {
                    var key = _ref14.key;
                    return categoryColorMap[key];
                });

                svg.select('.chart-group').selectAll('.area-outline').data(layers).transition().delay(function (_, i) {
                    return areaAnimationDelays[i];
                }).duration(areaAnimationDuration).ease(ease).attr('d', areaOutline);
            } else {
                series = svg.select('.chart-group').selectAll('.layer').data(layers).enter().append('g').classed('layer-container', true);

                series.append('path').attr('class', 'layer').attr('d', area).style('opacity', areaOpacity).style('fill', function (_ref15) {
                    var key = _ref15.key;
                    return categoryColorMap[key];
                });

                series.append('path').attr('class', 'area-outline').attr('d', areaOutline).style('stroke', function (_ref16) {
                    var key = _ref16.key;
                    return categoryColorMap[key];
                });

                // Update
                svg.select('.chart-group').selectAll('.layer').attr('d', area).style('opacity', areaOpacity).style('fill', function (_ref17) {
                    var key = _ref17.key;
                    return categoryColorMap[key];
                });

                svg.select('.chart-group').selectAll('.area-outline').attr('class', 'area-outline').attr('d', areaOutline).style('stroke', function (_ref18) {
                    var key = _ref18.key;
                    return categoryColorMap[key];
                });
            }

            if (!hasOutline) {
                svg.select('.chart-group').selectAll('.area-outline').style('display', 'none');
            }

            // Exit
            series.exit().transition().style('opacity', 0).remove();
        }

        /**
         * Creates the vertical marker
         * @return void
         */
        function drawVerticalMarker() {
            // Not ideal, we need to figure out how to call exit for nested elements
            if (verticalMarkerContainer) {
                svg.selectAll('.vertical-marker-container').remove();
            }

            verticalMarkerContainer = svg.select('.metadata-group').append('g').attr('class', 'vertical-marker-container').attr('transform', 'translate(9999, 0)');

            verticalMarkerLine = verticalMarkerContainer.selectAll('path').data([{
                x1: 0,
                y1: 0,
                x2: 0,
                y2: 0
            }]).enter().append('line').classed('vertical-marker', true).attr('x1', 0).attr('y1', chartHeight).attr('x2', 0).attr('y2', 0);
        }

        /**
         * Removes all the datapoints highlighter circles added to the marker container
         * @return void
         * @private
         */
        function cleanDataPointHighlights() {
            verticalMarkerContainer.selectAll('.circle-container').remove();
        }

        /**
         * Orders the data by date for consumption on the chart tooltip
         * @param  {areaChartData} data    Chart data
         * @return {Object[]}               Chart data ordered by date
         * @private
         */
        function getDataByDate(data) {
            return d3Collection.nest().key(getDate).entries(data.sort(function (a, b) {
                return a.date - b.date;
            })).map(function (d) {
                return assign({}, d, {
                    date: new Date(d.key)
                });
            });

            // let b =  d3Collection.nest()
            //                     .key(getDate).sortKeys(d3Array.ascending)
            //                     .entries(data);
        }

        /**
         * Computes the maximum sum of values for any date
         *
         * @return {Number} Max value
         */
        function getMaxValueByDate() {
            var keys = uniq(data.map(function (o) {
                return o.name;
            }));
            var maxValueByDate = d3Array.max(dataByDateFormatted, function (d) {
                var vals = keys.map(function (key) {
                    return d[key];
                });

                return d3Array.sum(vals);
            });

            return maxValueByDate;
        }

        /**
         * Finds out the data entry that is closer to the given position on pixels
         * @param  {Number} mouseX X position of the mouse
         * @return {obj}        Data entry that is closer to that x axis position
         */
        function getNearestDataPoint(mouseX) {
            var points = dataByDate.filter(function (_ref19) {
                var date = _ref19.date;
                return Math.abs(xScale(date) - mouseX) <= epsilon;
            });

            if (points.length) {
                return points[0];
            }
        }

        /**
         * Epsilon is the value given to the number representing half of the distance in
         * pixels between two date data points
         * @return {Number} half distance between any two points
         */
        function setEpsilon() {
            var dates = dataByDate.map(function (_ref20) {
                var date = _ref20.date;
                return date;
            });

            epsilon = (xScale(dates[1]) - xScale(dates[0])) / 2;
        }

        /**
         * MouseMove handler, calculates the nearest dataPoint to the cursor
         * and updates metadata related to it
         * @private
         */
        function handleMouseMove(e) {
            epsilon || setEpsilon();

            var _d3Selection$mouse = d3Selection.mouse(e),
                _d3Selection$mouse2 = _slicedToArray(_d3Selection$mouse, 2),
                xPosition = _d3Selection$mouse2[0],
                yPosition = _d3Selection$mouse2[1],
                dataPoint = getNearestDataPoint(xPosition - margin.left),
                dataPointXPosition = void 0;

            if (dataPoint) {
                dataPointXPosition = xScale(new Date(dataPoint.key));
                // Move verticalMarker to that datapoint
                moveVerticalMarker(dataPointXPosition);
                // Add data points highlighting
                highlightDataPoints(dataPoint);
                // Emit event with xPosition for tooltip or similar feature
                dispatcher.call('customMouseMove', e, dataPoint, categoryColorMap, dataPointXPosition, yPosition);
            }
        }

        /**
         * MouseOut handler, hides overlay and removes active class on verticalMarkerLine
         * It also resets the container of the vertical marker
         * @private
         */
        function handleMouseOut(e, d) {
            overlay.style('display', 'none');
            verticalMarkerLine.classed('bc-is-active', false);
            verticalMarkerContainer.attr('transform', 'translate(9999, 0)');

            dispatcher.call('customMouseOut', e, d, d3Selection.mouse(e));
        }

        /**
         * Mouseover handler, shows overlay and adds active class to verticalMarkerLine
         * @private
         */
        function handleMouseOver(e, d) {
            overlay.style('display', 'block');
            verticalMarkerLine.classed('bc-is-active', true);

            dispatcher.call('customMouseOver', e, d, d3Selection.mouse(e));
        }

        /**
         * Touchmove highlighted points
         * It will only pass the information with the event
         * @private
         */
        function handleTouchMove(e, d) {
            dispatcher.call('customTouchMove', e, d, d3Selection.touch(e));
        }

        /**
         * Mouseclick handler over one of the highlight points
         * It will only pass the information with the event
         * @private
         */
        function handleHighlightClick(e, d) {
            dispatcher.call('customDataEntryClick', e, d, d3Selection.mouse(e));
        }

        /**
         * Creates coloured circles marking where the exact data y value is for a given data point
         * @param  {obj} dataPoint Data point to extract info from
         * @private
         */
        function highlightDataPoints(_ref21) {
            var values = _ref21.values;

            var accumulator = 0;

            cleanDataPointHighlights();

            // ensure order stays constant
            var sortedValues = order.reduce(function (acc, current) {
                return [].concat(_toConsumableArray(acc), [values.find(function (_ref22) {
                    var name = _ref22.name;
                    return name === current;
                })]);
            }, []);

            sortedValues.forEach(function (d, index) {
                var marker = verticalMarkerContainer.append('g').classed('circle-container', true).append('circle').classed('data-point-highlighter', true).attr('cx', highlightCircleSize).attr('cy', 0).attr('r', highlightCircleRadius).style('stroke-width', highlightCircleStroke).style('stroke', categoryColorMap[d.name]).style('cursor', 'pointer').on('click', function () {
                    addGlowFilter(this);
                    handleHighlightClick(this, d);
                }).on('mouseout', function () {
                    removeFilter(this);
                });

                accumulator = accumulator + sortedValues[index][valueLabel];

                marker.attr('transform', 'translate( ' + -highlightCircleSize + ', ' + yScale(accumulator) + ' )');
            });
        }

        /**
         * Helper method to update the x position of the vertical marker
         * @param  {obj} dataPoint Data entry to extract info
         * @return void
         */
        function moveVerticalMarker(verticalMarkerXPosition) {
            verticalMarkerContainer.attr('transform', 'translate(' + verticalMarkerXPosition + ',0)');
        }

        /**
         * Resets a point filter
         * @param {DOMElement} point  Point to reset
         */
        function removeFilter(point) {
            d3Selection.select(point).attr('filter', 'none');
        }

        /**
         * Determines if we should add the tooltip related logic depending on the
         * size of the chart and the tooltipThreshold variable value
         * @return {boolean} Should we build the tooltip?
         * @private
         */
        function shouldShowTooltip() {
            return width > tooltipThreshold && !isUsingFakeData;
        }

        // API

        /**
        * Gets or Sets the area curve of the stacked area.
        * @param {String} [_x='monotoneX'] Desired curve for the stacked area, default 'monotoneX'. Other options are:
        * basis, natural, linear, monotoneY, step, stepAfter, stepBefore, cardinal, and
        * catmullRom. Visit https://github.com/d3/d3-shape#curves for more information.
        * @return {String | module} Current area curve setting or Chart module to chain calls
        * @public
        * @example stackedArea.areaCurve('step')
        */
        exports.areaCurve = function (_x) {
            if (!arguments.length) {
                return areaCurve;
            }
            areaCurve = _x;

            return this;
        };

        /**
         * Gets or Sets the opacity of the stacked areas in the chart (all of them will have the same opacity)
         * @param  {Number} _x                  Opacity to get/set
         * @return {Number | module}          Current opacity or Area Chart module to chain calls
         * @public
         */
        exports.areaOpacity = function (_x) {
            if (!arguments.length) {
                return areaOpacity;
            }
            areaOpacity = _x;

            return this;
        };

        /**
         * Gets or Sets the aspect ratio of the chart
         * @param  {Number} _x Desired aspect ratio for the graph
         * @return {Number | Module} Current aspect ratio or Area Chart module to chain calls
         * @public
         */
        exports.aspectRatio = function (_x) {
            if (!arguments.length) {
                return aspectRatio;
            }
            aspectRatio = _x;

            return this;
        };

        /**
         * Exposes the constants to be used to force the x axis to respect a certain granularity
         * current options: MINUTE_HOUR, HOUR_DAY, DAY_MONTH, MONTH_YEAR
         * @example
         *     area.xAxisFormat(area.axisTimeCombinations.HOUR_DAY)
         */
        exports.axisTimeCombinations = axisTimeCombinations;

        /**
         * Gets or Sets the colorSchema of the chart
         * @param  {String[]} _x Desired colorSchema for the graph
         * @return {String[] | module} Current colorSchema or Chart module to chain calls
         * @public
         */
        exports.colorSchema = function (_x) {
            if (!arguments.length) {
                return colorSchema;
            }
            colorSchema = _x;

            return this;
        };

        /**
         * Gets or Sets the dateLabel of the chart
         * @param  {String} _x Desired dateLabel for the graph
         * @return {String | module} Current dateLabel or Chart module to chain calls
         * @public
         */
        exports.dateLabel = function (_x) {
            if (!arguments.length) {
                return dateLabel;
            }
            dateLabel = _x;

            return this;
        };

        /**
         * Gets or Sets the emptyDataConfig of the chart
         * @param  {Object} _x emptyDataConfig object to get/set
         * @return {Object | module} Current config for when chart data is an empty array
         * @public
         */
        exports.emptyDataConfig = function (_x) {
            if (!arguments.length) {
                return emptyDataConfig;
            }
            emptyDataConfig = _x;

            return this;
        };

        /**
         * Gets or Sets the grid mode.
         *
         * @param  {String} _x Desired mode for the grid ('vertical'|'horizontal'|'full')
         * @return {String | module} Current mode of the grid or Area Chart module to chain calls
         * @public
         */
        exports.grid = function (_x) {
            if (!arguments.length) {
                return grid;
            }
            grid = _x;

            return this;
        };

        exports.hasOutline = function (_x) {
            if (!arguments.length) {
                return hasOutline;
            }
            hasOutline = _x;

            return this;
        };

        /**
         * Gets or Sets the height of the chart
         * @param  {Number} _x Desired width for the graph
         * @return {Number | module} Current height or Area Chart module to chain calls
         * @public
         */
        exports.height = function (_x) {
            if (!arguments.length) {
                return height;
            }
            if (aspectRatio) {
                width = Math.ceil(_x / aspectRatio);
            }
            height = _x;

            return this;
        };

        /**
         * Gets or Sets the isAnimated property of the chart, making it to animate when render.
         * By default this is 'false'
         *
         * @param  {Boolean} _x Desired animation flag
         * @return {Boolean | module} Current isAnimated flag or Chart module
         * @public
         */
        exports.isAnimated = function (_x) {
            if (!arguments.length) {
                return isAnimated;
            }
            isAnimated = _x;

            return this;
        };

        /**
         * Gets or Sets the keyLabel of the chart
         * @param  {Number} _x Desired keyLabel for the graph
         * @return {Number | module} Current keyLabel or Chart module to chain calls
         * @public
         */
        exports.keyLabel = function (_x) {
            if (!arguments.length) {
                return keyLabel;
            }
            keyLabel = _x;

            return this;
        };

        /**
         * Gets or Sets the margin of the chart
         * @param  {Object} _x Margin object to get/set
         * @return {Object | module} Current margin or Area Chart module to chain calls
         * @public
         */
        exports.margin = function (_x) {
            if (!arguments.length) {
                return margin;
            }
            margin = _extends({}, margin, _x);

            return this;
        };

        /**
         * Gets or Sets the minimum width of the graph in order to show the tooltip
         * NOTE: This could also depend on the aspect ratio
         *
         * @param  {Number} _x          Minimum width of the graph
         * @return {Number | module}    Current tooltipThreshold or Area Chart module to chain calls
         * @public
         */
        exports.tooltipThreshold = function (_x) {
            if (!arguments.length) {
                return tooltipThreshold;
            }
            tooltipThreshold = _x;

            return this;
        };

        /**
         * Pass an override for the ordering of the topics
         * @param  {String[]} _x           Array of the names of your tooltip items
         * @return {String[] | module}    Current override order or Chart module to chain calls
         * @public
         */
        exports.topicsOrder = function (_x) {
            if (!arguments.length) {
                return topicsOrder;
            }
            topicsOrder = _x;

            return this;
        };

        /**
         * Gets or Sets the loading state of the chart
         * @param  {String} markup Desired markup to show when null data
         * @return {String | module} Current loading state markup or Chart module to chain calls
         * @public
         */
        exports.loadingState = function (_markup) {
            if (!arguments.length) {
                return loadingState;
            }
            loadingState = _markup;

            return this;
        };

        /**
         * Pass language tag for the tooltip to localize the date.
         * Feature uses Intl.DateTimeFormat, for compatability and support, refer to
         * https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/DateTimeFormat
         * @param  {String} _x  must be a language tag (BCP 47) like 'en-US' or 'fr-FR'
         * @return {String | Module}    Current locale or module to chain calls
         * @public
         */
        exports.locale = function (_x) {
            if (!arguments.length) {
                return locale;
            }
            locale = _x;

            return this;
        };

        /**
         * Chart exported to png and a download action is fired
         * @param {String} filename     File title for the resulting picture
         * @param {String} title        Title to add at the top of the exported picture
         * @public
         */
        exports.exportChart = function (filename, title) {
            exportChart.call(exports, svg, filename, title);
        };

        /**
         * Exposes an 'on' method that acts as a bridge with the event dispatcher
         * We are going to expose this events:
         * customMouseOver, customMouseMove, customMouseOut,
         * customDataEntryClick and customTouchMove
         * @return {module} Stacked Area
         * @public
         */
        exports.on = function () {
            var value = dispatcher.on.apply(dispatcher, arguments);

            return value === dispatcher ? exports : value;
        };

        /**
         * Gets or Sets the valueLabel of the chart
         * @param  {Number} _x Desired valueLabel for the graph
         * @return {Number | module} Current valueLabel or Chart module to chain calls
         * @public
         */
        exports.valueLabel = function (_x) {
            if (!arguments.length) {
                return valueLabel;
            }
            valueLabel = _x;

            return this;
        };

        /**
         * Gets or Sets the width of the chart
         * @param  {Number} _x Desired width for the graph
         * @return {Number | module} Current width or Area Chart module to chain calls
         * @public
         */
        exports.width = function (_x) {
            if (!arguments.length) {
                return width;
            }
            if (aspectRatio) {
                height = Math.ceil(_x * aspectRatio);
            }
            width = _x;

            return this;
        };

        /**
         * Exposes the ability to force the chart to show a certain x format
         * It requires a `xAxisFormat` of 'custom' in order to work.
         * NOTE: localization not supported
         * @param  {String} _x            Desired format for x axis
         * @return {String | Module}      Current format or module to chain calls
         * @public
         */
        exports.xAxisCustomFormat = function (_x) {
            if (!arguments.length) {
                return xAxisCustomFormat;
            }
            xAxisCustomFormat = _x;

            return this;
        };

        /**
         * Exposes the ability to force the chart to show a certain x axis grouping
         * @param  {String} _x          Desired format
         * @return {String | Module}    Current format or module to chain calls
         * @public
         * @example
         *     area.xAxisFormat(area.axisTimeCombinations.HOUR_DAY)
         */
        exports.xAxisFormat = function (_x) {
            if (!arguments.length) {
                return xAxisFormat;
            }
            xAxisFormat = _x;

            return this;
        };

        /**
         * Exposes the ability to force the chart to show a certain x ticks. It requires a `xAxisFormat` of 'custom' in order to work.
         * NOTE: This value needs to be a multiple of 2, 5 or 10. They won't always work as expected, as D3 decides at the end
         * how many and where the ticks will appear.
         *
         * @param  {Number} _x            Desired number of x axis ticks (multiple of 2, 5 or 10)
         * @return {Number | Module}      Current number or ticks or module to chain calls
         * @public
         */
        exports.xTicks = function (_x) {
            if (!arguments.length) {
                return xTicks;
            }
            xTicks = _x;

            return this;
        };

        /**
         * Gets or Sets the y-axis label of the chart
         * @param  {String} _x Desired label string
         * @return {String | module} Current yAxisLabel or Chart module to chain calls
         * @public
         * @example stackedArea.yAxisLabel('Ticket Sales')
         */
        exports.yAxisLabel = function (_x) {
            if (!arguments.length) {
                return yAxisLabel;
            }
            yAxisLabel = _x;

            return this;
        };

        /**
         * Gets or Sets the offset of the yAxisLabel of the chart.
         * The method accepts both positive and negative values.
         * The default value is -60
         * @param  {Number} [_x=-60] Desired offset for the label
         * @return {Number | module} Current yAxisLabelOffset or Chart module to chain calls
         * @public
         * @example stackedArea.yAxisLabelOffset(-55)
         */
        exports.yAxisLabelOffset = function (_x) {
            if (!arguments.length) {
                return yAxisLabelOffset;
            }
            yAxisLabelOffset = _x;

            return this;
        };

        /**
         * Gets or Sets the number of ticks of the y axis on the chart
         * (Default is 5)
         * @param  {Number} [_x=5]      Desired vertical ticks
         * @return {Number | module}    Current vertical ticks or Chart module to chain calls
         * @public
         */
        exports.yTicks = function (_x) {
            if (!arguments.length) {
                return yTicks;
            }
            yTicks = _x;

            return this;
        };

        return exports;
    };
}.call(exports, __webpack_require__, exports, module),
				__WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));

/***/ }),
/* 297 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
var __WEBPACK_AMD_DEFINE_RESULT__;

var _extends = Object.assign || function (target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i]; for (var key in source) { if (Object.prototype.hasOwnProperty.call(source, key)) { target[key] = source[key]; } } } return target; };

var _slicedToArray = function () { function sliceIterator(arr, i) { var _arr = []; var _n = true; var _d = false; var _e = undefined; try { for (var _i = arr[Symbol.iterator](), _s; !(_n = (_s = _i.next()).done); _n = true) { _arr.push(_s.value); if (i && _arr.length === i) break; } } catch (err) { _d = true; _e = err; } finally { try { if (!_n && _i["return"]) _i["return"](); } finally { if (_d) throw _e; } } return _arr; } return function (arr, i) { if (Array.isArray(arr)) { return arr; } else if (Symbol.iterator in Object(arr)) { return sliceIterator(arr, i); } else { throw new TypeError("Invalid attempt to destructure non-iterable instance"); } }; }();

function _toConsumableArray(arr) { if (Array.isArray(arr)) { for (var i = 0, arr2 = Array(arr.length); i < arr.length; i++) { arr2[i] = arr[i]; } return arr2; } else { return Array.from(arr); } }

!(__WEBPACK_AMD_DEFINE_RESULT__ = function (require) {
    'use strict';

    var d3Array = __webpack_require__(1);
    var d3Axis = __webpack_require__(17);
    var d3Color = __webpack_require__(12);
    var d3Collection = __webpack_require__(27);
    var d3Dispatch = __webpack_require__(6);
    var d3Ease = __webpack_require__(4);
    var d3Interpolate = __webpack_require__(9);
    var d3Scale = __webpack_require__(8);
    var d3Selection = __webpack_require__(0);
    var assign = __webpack_require__(66);
    var d3Transition = __webpack_require__(3);

    var _require = __webpack_require__(15),
        exportChart = _require.exportChart;

    var colorHelper = __webpack_require__(5);

    var _require2 = __webpack_require__(13),
        bar = _require2.bar;

    var NUMBER_FORMAT = ',f';
    var uniq = function uniq(arrArg) {
        return arrArg.filter(function (elem, pos, arr) {
            return arr.indexOf(elem) == pos;
        });
    };

    /**
     * @typdef D3Layout
     * @type function
     */

    /**
     * @typedef GroupedBarChartData
     * @type {Object[]}
     * @property {String} name     Name of the entry
     * @property {String} group    Group of the entry
     * @property {Number} value    Value of the entry
     *
     * @example
     * [
     *     {
     *         name: "2011-01",
     *         group: "Direct",
     *         value: 0
     *     }
     * ]
     */

    /**
     * Grouped Bar Chart reusable API module that allows us
     * rendering a multi grouped bar and configurable chart.
     *
     * @module Grouped-bar
     * @tutorial grouped-bar
     * @requires d3-array, d3-axis, d3-color, d3-collection, d3-dispatch, d3-ease,
     *  d3-interpolate, d3-scale, d3-selection, lodash assign
     *
     * @example
     * let groupedBar = GroupedBar();
     *
     * groupedBar
     *     .width(containerWidth);
     *
     * d3Selection.select('.css-selector')
     *     .datum(dataset.data)
     *     .call(groupedBar);
     *
     */
    return function module() {

        var margin = {
            top: 40,
            right: 30,
            bottom: 60,
            left: 70
        },
            width = 960,
            height = 500,
            loadingState = bar,
            xScale = void 0,
            xScale2 = void 0,
            xAxis = void 0,
            yScale = void 0,
            yScale2 = void 0,
            yAxis = void 0,
            aspectRatio = null,
            yTickTextOffset = {
            y: -8,
            x: -20
        },
            yTicks = 5,
            xTicks = 5,
            baseLine = void 0,
            colorSchema = colorHelper.colorSchemas.britecharts,
            colorScale = void 0,
            categoryColorMap = void 0,
            layers = void 0,
            ease = d3Ease.easeQuadInOut,
            isHorizontal = false,
            svg = void 0,
            chartWidth = void 0,
            chartHeight = void 0,
            data = void 0,
            groups = void 0,
            layerElements = void 0,
            transformedData = void 0,
            tooltipThreshold = 480,
            xAxisPadding = {
            top: 0,
            left: 0,
            bottom: 0,
            right: 0
        },
            yAxisLabel = void 0,
            yAxisLabelEl = void 0,
            yAxisLabelOffset = -60,
            barOpacity = 0.24,
            animationDelayStep = 20,
            animationDelays = void 0,
            animationDuration = 1000,
            grid = null,
            nameLabel = 'name',
            valueLabel = 'value',
            groupLabel = 'group',
            valueLabelFormat = NUMBER_FORMAT,


        // getters
        getName = function getName(_ref) {
            var name = _ref.name;
            return name;
        },
            getValue = function getValue(_ref2) {
            var value = _ref2.value;
            return value;
        },
            getGroup = function getGroup(_ref3) {
            var group = _ref3.group;
            return group;
        },
            isAnimated = false,


        // events
        dispatcher = d3Dispatch.dispatch('customMouseOver', 'customMouseOut', 'customMouseMove', 'customClick');

        /**
         * This function creates the graph using the selection and data provided
         * @param {D3Selection} _selection A d3 selection that represents
         * the container(s) where the chart(s) will be rendered
         * @param {GroupedBarChartData} _data The data to attach and generate the chart
         */
        function exports(_selection) {
            _selection.each(function (_data) {
                chartWidth = width - margin.left - margin.right;
                chartHeight = height - margin.top - margin.bottom;
                data = cleanData(_data);

                prepareData(data);
                buildScales();
                buildLayers();
                buildSVG(this);
                drawGridLines();
                buildAxis();
                drawAxis();
                drawGroupedBar();
                addMouseEvents();
            });
        }

        /**
         * Adds events to the container group if the environment is not mobile
         * Adding: mouseover, mouseout and mousemove
         */
        function addMouseEvents() {
            if (shouldShowTooltip()) {
                svg.on('mouseover', function (d) {
                    handleMouseOver(this, d);
                }).on('mouseout', function (d) {
                    handleMouseOut(this, d);
                }).on('mousemove', function (d) {
                    handleMouseMove(this, d);
                }).on('click', function (d) {
                    handleCustomClick(this, d);
                });;
            }

            svg.selectAll('.bar').on('mouseover', function (d) {
                handleBarsMouseOver(this, d);
            }).on('mouseout', function (d) {
                handleBarsMouseOut(this, d);
            });
        }

        /**
         * Adjusts the position of the y axis' ticks
         * @param  {D3Selection} selection Y axis group
         * @return void
         */
        function adjustYTickLabels(selection) {
            selection.selectAll('.tick text').attr('transform', 'translate(' + yTickTextOffset['x'] + ', ' + yTickTextOffset['y'] + ')');
        }

        /**
         * Creates the d3 x and y axis, setting orientations
         * @private
         */
        function buildAxis() {
            if (isHorizontal) {
                xAxis = d3Axis.axisBottom(xScale).ticks(xTicks, valueLabelFormat);
                yAxis = d3Axis.axisLeft(yScale);
            } else {
                xAxis = d3Axis.axisBottom(xScale);
                yAxis = d3Axis.axisLeft(yScale).ticks(yTicks, valueLabelFormat);
            }
        }

        /**
         * Builds containers for the chart, the axis and a wrapper for all of them
         * NOTE: The order of drawing of this group elements is really important,
         * as everything else will be drawn on top of them
         * @private
         */
        function buildContainerGroups() {
            var container = svg.append('g').classed('container-group', true).attr('transform', 'translate(' + margin.left + ',' + margin.top + ')');

            container.append('g').classed('x-axis-group', true).append('g').classed('x axis', true);
            container.selectAll('.x-axis-group').append('g').classed('month-axis', true);
            container.append('g').classed('y-axis-group axis', true);
            container.append('g').classed('y-axis-label', true);
            container.append('g').classed('grid-lines-group', true);
            container.append('g').classed('chart-group', true);
            container.append('g').classed('metadata-group', true);
        }

        /**
         * Builds the grouped layers layout
         * @return {D3Layout} Layout for drawing the chart
         * @private
         */
        function buildLayers() {
            layers = transformedData.map(function (item) {
                var ret = {};

                groups.forEach(function (key) {
                    ret[key] = item[key];
                });

                return assign({}, item, ret);
            });
        }

        /**
         * Creates the x, y and color scales of the chart
         * @private
         */
        function buildScales() {
            var yMax = d3Array.max(data.map(getValue));

            if (isHorizontal) {
                xScale = d3Scale.scaleLinear().domain([0, yMax]).rangeRound([0, chartWidth - 1]);
                // 1 pix for edge tick

                yScale = d3Scale.scaleBand().domain(data.map(getName)).rangeRound([chartHeight, 0]).padding(0.1);

                yScale2 = d3Scale.scaleBand().domain(data.map(getGroup)).rangeRound([yScale.bandwidth(), 0]).padding(0.1);
            } else {
                xScale = d3Scale.scaleBand().domain(data.map(getName)).rangeRound([0, chartWidth]).padding(0.1);
                xScale2 = d3Scale.scaleBand().domain(data.map(getGroup)).rangeRound([0, xScale.bandwidth()]).padding(0.1);

                yScale = d3Scale.scaleLinear().domain([0, yMax]).rangeRound([chartHeight, 0]).nice();
            }

            colorScale = d3Scale.scaleOrdinal().range(colorSchema).domain(data.map(getGroup));

            categoryColorMap = colorScale.domain(data.map(getName)).domain().reduce(function (memo, item) {
                data.forEach(function (v) {
                    if (getName(v) == item) {
                        memo[v.name] = colorScale(v.group);
                        memo[v.group] = colorScale(v.group);
                        memo[v.group + item] = colorScale(v.group);
                    }
                });
                return memo;
            }, {});
        }

        /**
         * @param  {HTMLElement} container DOM element that will work as the container of the graph
         * @private
         */
        function buildSVG(container) {
            if (!svg) {
                svg = d3Selection.select(container).append('svg').classed('britechart grouped-bar', true);

                buildContainerGroups();
            }

            svg.attr('width', width).attr('height', height);
        }

        /**
         * Cleaning data casting the values, groups, topic names and names to the proper type while keeping
         * the rest of properties on the data
         * @param  {GroupedBarChartData} originalData   Raw data from the container
         * @return {GroupedBarChartData}                Parsed data with values and dates
         * @private
         */
        function cleanData(originalData) {
            return originalData.reduce(function (acc, d) {
                d.value = +d[valueLabel];
                d.group = d[groupLabel];
                // for tooltip
                d.topicName = getGroup(d);
                d.name = d[nameLabel];

                return [].concat(_toConsumableArray(acc), [d]);
            }, []);
        }

        /**
         * Draws the x and y axis on the svg object within their
         * respective groups
         * @private
         */
        function drawAxis() {
            if (isHorizontal) {
                svg.select('.x-axis-group .axis.x').attr('transform', 'translate( 0, ' + chartHeight + ' )').call(xAxis);

                svg.select('.y-axis-group.axis').attr('transform', 'translate( ' + -xAxisPadding.left + ', 0)').call(yAxis);
            } else {
                svg.select('.x-axis-group .axis.x').attr('transform', 'translate( 0, ' + chartHeight + ' )').call(xAxis);

                svg.select('.y-axis-group.axis').attr('transform', 'translate( ' + -xAxisPadding.left + ', 0)').call(yAxis).call(adjustYTickLabels);
            }

            if (yAxisLabel) {
                if (yAxisLabelEl) {
                    svg.selectAll('.y-axis-label-text').remove();
                }

                yAxisLabelEl = svg.select('.y-axis-label').append('text').classed('y-axis-label-text', true).attr('x', -chartHeight / 2).attr('y', yAxisLabelOffset).attr('text-anchor', 'middle').attr('transform', 'rotate(270 0 0)').text(yAxisLabel);
            }
        }

        /**
         * Draws a vertical line to extend x-axis till the edges
         * @return {void}
         */
        function drawHorizontalExtendedLine() {
            baseLine = svg.select('.grid-lines-group').selectAll('line.extended-x-line').data([0]).enter().append('line').attr('class', 'extended-x-line').attr('x1', xAxisPadding.left).attr('x2', chartWidth).attr('y1', chartHeight).attr('y2', chartHeight);
        }

        /**
         * Draws a vertical line to extend y-axis till the edges
         * @return {void}
         */
        function drawVerticalExtendedLine() {
            baseLine = svg.select('.grid-lines-group').selectAll('line.extended-y-line').data([0]).enter().append('line').attr('class', 'extended-y-line').attr('y1', xAxisPadding.bottom).attr('y2', chartHeight).attr('x1', 0).attr('x2', 0);
        }

        /**
         * Draws grid lines on the background of the chart
         * @return void
         */
        function drawGridLines() {
            var scale = isHorizontal ? xScale : yScale;

            svg.select('.grid-lines-group').selectAll('line').remove();

            if (grid === 'horizontal' || grid === 'full') {
                svg.select('.grid-lines-group').selectAll('line.horizontal-grid-line').data(scale.ticks(yTicks).slice(1)).enter().append('line').attr('class', 'horizontal-grid-line').attr('x1', -xAxisPadding.left + 1).attr('x2', chartWidth).attr('y1', function (d) {
                    return yScale(d);
                }).attr('y2', function (d) {
                    return yScale(d);
                });
            }

            if (grid === 'vertical' || grid === 'full') {
                svg.select('.grid-lines-group').selectAll('line.vertical-grid-line').data(scale.ticks(xTicks).slice(1)).enter().append('line').attr('class', 'vertical-grid-line').attr('y1', 0).attr('y2', chartHeight).attr('x1', function (d) {
                    return xScale(d);
                }).attr('x2', function (d) {
                    return xScale(d);
                });
            }

            if (isHorizontal) {
                drawVerticalExtendedLine();
            } else {
                drawHorizontalExtendedLine();
            }
        }

        /**
         * Draws the bars along the x axis
         * @param  {D3Selection} layersSelection Selection of layers
         * @return {void}
         */
        function drawHorizontalBars(layersSelection) {
            var layerJoin = layersSelection.data(layers);

            layerElements = layerJoin.enter().append('g').attr('transform', function (_ref4) {
                var key = _ref4.key;
                return 'translate(0,' + yScale(key) + ')';
            }).classed('layer', true);

            var barJoin = layerElements.selectAll('.bar').data(function (_ref5) {
                var values = _ref5.values;
                return values;
            });

            // Enter + Update
            var bars = barJoin.enter().append('rect').classed('bar', true).attr('x', 1).attr('y', function (d) {
                return yScale2(getGroup(d));
            }).attr('height', yScale2.bandwidth()).attr('fill', function (_ref6) {
                var group = _ref6.group;
                return categoryColorMap[group];
            });

            if (isAnimated) {
                bars.style('opacity', barOpacity).transition().delay(function (_, i) {
                    return animationDelays[i];
                }).duration(animationDuration).ease(ease).tween('attr.width', horizontalBarsTween);
            } else {
                bars.attr('width', function (d) {
                    return xScale(getValue(d));
                });
            }
        }

        /**
         * Draws the bars along the y axis
         * @param  {D3Selection} layersSelection Selection of layers
         * @return {void}
         */
        function drawVerticalBars(layersSelection) {
            var layerJoin = layersSelection.data(layers);

            layerElements = layerJoin.enter().append('g').attr('transform', function (_ref7) {
                var key = _ref7.key;
                return 'translate(' + xScale(key) + ',0)';
            }).classed('layer', true);

            var barJoin = layerElements.selectAll('.bar').data(function (_ref8) {
                var values = _ref8.values;
                return values;
            });

            var bars = barJoin.enter().append('rect').classed('bar', true).attr('x', function (d) {
                return xScale2(getGroup(d));
            }).attr('y', function (_ref9) {
                var value = _ref9.value;
                return yScale(value);
            }).attr('width', xScale2.bandwidth).attr('fill', function (_ref10) {
                var group = _ref10.group;
                return categoryColorMap[group];
            });

            if (isAnimated) {
                bars.style('opacity', barOpacity).transition().delay(function (_, i) {
                    return animationDelays[i];
                }).duration(animationDuration).ease(ease).tween('attr.height', verticalBarsTween);
            } else {
                bars.attr('height', function (d) {
                    return chartHeight - yScale(getValue(d));
                });
            }
        }

        /**
         * Draws the different areas into the chart-group element
         * @private
         */
        function drawGroupedBar() {
            // Not ideal, we need to figure out how to call exit for nested elements
            if (layerElements) {
                svg.selectAll('.layer').remove();
            }

            var series = svg.select('.chart-group').selectAll('.layer');

            animationDelays = d3Array.range(animationDelayStep, (layers.length + 1) * animationDelayStep, animationDelayStep);
            if (isHorizontal) {
                drawHorizontalBars(series);
            } else {
                drawVerticalBars(series);
            }

            // Exit
            series.exit().transition().style('opacity', 0).remove();
        }

        /**
         * Extract X position on the chart from a given mouse event
         * @param  {obj} event D3 mouse event
         * @return {Number}       Position on the x axis of the mouse
         * @private
         */
        function getMousePosition(event) {
            return d3Selection.mouse(event);
        }

        /**
         * Finds out the data entry that is closer to the given position on pixels
         * @param  {Number} mouseX X position of the mouse
         * @return {obj}        Data entry that is closer to that x axis position
         */
        function getNearestDataPoint(mouseX) {
            var adjustedMouseX = mouseX - margin.left,
                epsilon = xScale2.bandwidth(),
                nearest = [];

            layers.forEach(function (data) {
                var found = data.values.find(function (d2) {
                    return Math.abs(adjustedMouseX >= xScale(d2[nameLabel]) + xScale2(d2[groupLabel])) && Math.abs(adjustedMouseX - xScale2(d2[groupLabel]) - xScale(d2[nameLabel]) <= epsilon);
                });

                if (found) {
                    found.values = data.values;
                    found.key = found.name;
                    nearest.push(found);
                }
            });

            return nearest.length ? nearest[0] : undefined;
        }

        /**
        * Finds out the data entry that is closer to the given position on pixels
        * @param  {Number} mouseX X position of the mouse
        * @return {obj}        Data entry that is closer to that x axis position
        */
        function getNearestDataPoint2(mouseY) {
            var adjustedMouseY = mouseY - margin.bottom,
                epsilon = yScale.bandwidth(),
                nearest = [];

            layers.map(function (data) {
                var found = data.values.find(function (d2) {
                    return Math.abs(adjustedMouseY >= yScale(d2[nameLabel])) && Math.abs(adjustedMouseY - yScale(d2[nameLabel]) <= epsilon * 2);
                });

                if (found) {
                    found.values = data.values;
                    found.key = found.name;
                    nearest.push(found);
                }
            });

            return nearest.length ? nearest[0] : undefined;
        }

        /**
         * Handles a mouseover event on top of a bar
         * @param  {obj} e the fired event
         * @param  {obj} d data of bar
         * @return {void}
         */
        function handleBarsMouseOver(e, d) {
            d3Selection.select(e).attr('fill', function () {
                return d3Color.color(categoryColorMap[d.group]).darker();
            });
        }

        /**
         * Handles a mouseout event out of a bar
         * @param  {obj} e the fired event
         * @param  {obj} d data of bar
         * @return {void}
         */
        function handleBarsMouseOut(e, d) {
            d3Selection.select(e).attr('fill', function () {
                return categoryColorMap[d.group];
            });
        }

        /**
         * MouseMove handler, calculates the nearest dataPoint to the cursor
         * and updates metadata related to it
         * @param  {obj} e the fired event
         * @private
         */
        function handleMouseMove(e) {
            var _getMousePosition = getMousePosition(e),
                _getMousePosition2 = _slicedToArray(_getMousePosition, 2),
                mouseX = _getMousePosition2[0],
                mouseY = _getMousePosition2[1],
                dataPoint = isHorizontal ? getNearestDataPoint2(mouseY) : getNearestDataPoint(mouseX),
                x = void 0,
                y = void 0;

            if (dataPoint) {
                // Move verticalMarker to that datapoint
                if (isHorizontal) {
                    x = mouseX - margin.left;
                    y = yScale(dataPoint.key) + yScale.bandwidth() / 2;
                } else {
                    x = xScale(dataPoint.key) + xScale2(dataPoint[groupLabel]);
                    y = mouseY - margin.bottom;
                }
                moveTooltipOriginXY(x, y);

                // Emit event with xPosition for tooltip or similar feature
                dispatcher.call('customMouseMove', e, dataPoint, categoryColorMap, x, y);
            }
        }

        /**
         * Click handler, shows data that was clicked and passes to the user
         * @private
         */
        function handleCustomClick(e) {
            var _getMousePosition3 = getMousePosition(e),
                _getMousePosition4 = _slicedToArray(_getMousePosition3, 2),
                mouseX = _getMousePosition4[0],
                mouseY = _getMousePosition4[1];

            var dataPoint = isHorizontal ? getNearestDataPoint2(mouseY) : getNearestDataPoint(mouseX);

            dispatcher.call('customClick', e, dataPoint, d3Selection.mouse(e));
        }

        /**
         * MouseOut handler, hides overlay and removes active class on verticalMarkerLine
         * It also resets the container of the vertical marker
         * @private
         */
        function handleMouseOut(e, d) {
            svg.select('.metadata-group').attr('transform', 'translate(9999, 0)');
            dispatcher.call('customMouseOut', e, d, d3Selection.mouse(e));
        }

        /**
         * Mouseover handler, shows overlay and adds active class to verticalMarkerLine
         * @private
         */
        function handleMouseOver(e, d) {
            dispatcher.call('customMouseOver', e, d, d3Selection.mouse(e));
        }

        /**
         * Animation tween of horizontal bars
         * @param  {obj} d data of bar
         * @return {void}
         */
        function horizontalBarsTween(d) {
            var node = d3Selection.select(this),
                i = d3Interpolate.interpolateRound(0, xScale(getValue(d))),
                j = d3Interpolate.interpolateNumber(0, 1);

            return function (t) {
                node.attr('width', i(t)).style('opacity', j(t));
            };
        }

        /**
         * Helper method to update the x position of the vertical marker
         * @param  {obj} dataPoint Data entry to extract info
         * @return void
         */
        function moveTooltipOriginXY(originXPosition, originYPosition) {
            svg.select('.metadata-group').attr('transform', 'translate(' + originXPosition + ',' + originYPosition + ')');
        }

        /**
         * Prepare data for create chart.
         * @private
         */
        function prepareData(data) {
            groups = uniq(data.map(function (d) {
                return getGroup(d);
            }));
            transformedData = d3Collection.nest().key(getName).rollup(function (values) {
                var ret = {};

                values.forEach(function (entry) {
                    if (entry && entry[groupLabel]) {
                        ret[entry[groupLabel]] = getValue(entry);
                    }
                });
                //for tooltip
                ret.values = values;
                return ret;
            }).entries(data).map(function (data) {
                return assign({}, {
                    total: d3Array.sum(d3Array.permute(data.value, groups)),
                    key: data.key
                }, data.value);
            });
        }

        /**
         * Determines if we should add the tooltip related logic depending on the
         * size of the chart and the tooltipThreshold variable value
         * @return {boolean} Should we build the tooltip?
         * @private
         */
        function shouldShowTooltip() {
            return width > tooltipThreshold;
        }

        /**
         * Animation tween of vertical bars
         * @param  {obj} d data of bar
         * @return {void}
         */
        function verticalBarsTween(d) {
            var node = d3Selection.select(this),
                i = d3Interpolate.interpolateRound(0, chartHeight - yScale(getValue(d))),
                y = d3Interpolate.interpolateRound(chartHeight, yScale(getValue(d))),
                j = d3Interpolate.interpolateNumber(0, 1);

            return function (t) {
                node.attr('y', y(t)).attr('height', i(t)).style('opacity', j(t));
            };
        }

        // API

        /**
         * Gets or Sets the aspect ratio of the chart
         * @param  {Number} _x Desired aspect ratio for the graph
         * @return { (Number | Module) } Current aspect ratio or Area Chart module to chain calls
         * @public
         */
        exports.aspectRatio = function (_x) {
            if (!arguments.length) {
                return aspectRatio;
            }
            aspectRatio = _x;

            return this;
        };

        /**
         * Gets or Sets the colorSchema of the chart
         * @param  {String[]} _x Desired colorSchema for the graph
         * @return { colorSchema | module} Current colorSchema or Chart module to chain calls
         * @public
         */
        exports.colorSchema = function (_x) {
            if (!arguments.length) {
                return colorSchema;
            }
            colorSchema = _x;

            return this;
        };

        /**
         * Chart exported to png and a download action is fired
         * @param {String} filename     File title for the resulting picture
         * @param {String} title        Title to add at the top of the exported picture
         * @public
         */
        exports.exportChart = function (filename, title) {
            exportChart.call(exports, svg, filename, title);
        };

        /**
         * Gets or Sets the groupLabel of the chart
         * @param  {String} _x Desired groupLabel for the graph
         * @return { groupLabel | module} Current groupLabel or Chart module to chain calls
         * @public
         */
        exports.groupLabel = function (_x) {
            if (!arguments.length) {
                return groupLabel;
            }
            groupLabel = _x;

            return this;
        };

        /**
         * Gets or Sets the grid mode.
         *
         * @param  {String} _x Desired mode for the grid ('vertical'|'horizontal'|'full')
         * @return { String | module} Current mode of the grid or Area Chart module to chain calls
         * @public
         */
        exports.grid = function (_x) {
            if (!arguments.length) {
                return grid;
            }
            grid = _x;

            return this;
        };

        /**
         * Gets or Sets the height of the chart
         * @param  {Number} _x Desired width for the graph
         * @return { height | module} Current height or Area Chart module to chain calls
         * @public
         */
        exports.height = function (_x) {
            if (!arguments.length) {
                return height;
            }
            if (aspectRatio) {
                width = Math.ceil(_x / aspectRatio);
            }
            height = _x;

            return this;
        };

        /**
         * Gets or Sets the horizontal direction of the chart
         * @param  {number} _x Desired horizontal direction for the graph
         * @return { isHorizontal | module} If it is horizontal or Bar Chart module to chain calls
         * @public
         */
        exports.isHorizontal = function (_x) {
            if (!arguments.length) {
                return isHorizontal;
            }
            isHorizontal = _x;

            return this;
        };

        /**
         * Gets or Sets the isAnimated property of the chart, making it to animate when render.
         * By default this is 'false'
         *
         * @param  {Boolean} _x Desired animation flag
         * @return { isAnimated | module} Current isAnimated flag or Chart module
         * @public
         */
        exports.isAnimated = function (_x) {
            if (!arguments.length) {
                return isAnimated;
            }
            isAnimated = _x;

            return this;
        };

        /**
         * Gets or Sets the loading state of the chart
         * @param  {string} markup Desired markup to show when null data
         * @return { loadingState | module} Current loading state markup or Chart module to chain calls
         * @public
         */
        exports.loadingState = function (_markup) {
            if (!arguments.length) {
                return loadingState;
            }
            loadingState = _markup;

            return this;
        };

        /**
         * Gets or Sets the margin of the chart
         * @param  {Object} _x Margin object to get/set
         * @return { margin | module} Current margin or Area Chart module to chain calls
         * @public
         */
        exports.margin = function (_x) {
            if (!arguments.length) {
                return margin;
            }
            margin = _extends({}, margin, _x);

            return this;
        };

        /**
         * Gets or Sets the nameLabel of the chart
         * @param  {Number} _x Desired dateLabel for the graph
         * @return { nameLabel | module} Current nameLabel or Chart module to chain calls
         * @public
         */
        exports.nameLabel = function (_x) {
            if (!arguments.length) {
                return nameLabel;
            }
            nameLabel = _x;

            return this;
        };

        /**
         * Gets or Sets the number of ticks of the y axis on the chart
         * @param  {Number} _x          Desired vertical ticks
         * @return {Number | module}    Current yTicks or Chart module to chain calls
         * @public
         */
        exports.yTicks = function (_x) {
            if (!arguments.length) {
                return yTicks;
            }
            yTicks = _x;

            return this;
        };

        /**
         * Exposes an 'on' method that acts as a bridge with the event dispatcher
         * We are going to expose this events:
         * customMouseOver, customMouseMove, customMouseOut, and customClick
         *
         * @return {module} Bar Chart
         * @public
         */
        exports.on = function () {
            var value = dispatcher.on.apply(dispatcher, arguments);

            return value === dispatcher ? exports : value;
        };

        /**
         * Gets or Sets the minimum width of the graph in order to show the tooltip
         * NOTE: This could also depend on the aspect ratio
         *
         * @param  {Number} [_x=480] Minimum width of chart to show the tooltip
         * @return {Number | module} Current tooltipThreshold or Area Chart module to chain calls
         * @public
         */
        exports.tooltipThreshold = function (_x) {
            if (!arguments.length) {
                return tooltipThreshold;
            }
            tooltipThreshold = _x;

            return this;
        };

        /**
         * Gets or Sets the valueLabel of the chart
         * @param  {Number} _x Desired valueLabel for the graph
         * @return {Number | module} Current valueLabel or Chart module to chain calls
         * @public
         */
        exports.valueLabel = function (_x) {
            if (!arguments.length) {
                return valueLabel;
            }
            valueLabel = _x;

            return this;
        };

        /**
         * Gets or Sets the valueLabelFormat of the chart
         * @param  {String[]} _x Desired valueLabelFormat for the graph
         * @return {String[] | module} Current valueLabelFormat or Chart module to chain calls
         * @public
         */
        exports.valueLabelFormat = function (_x) {
            if (!arguments.length) {
                return valueLabelFormat;
            }
            valueLabelFormat = _x;

            return this;
        };

        /**
         * Gets or Sets the width of the chart
         * @param  {Number} _x Desired width for the graph
         * @return {Number | module} Current width or Area Chart module to chain calls
         * @public
         */
        exports.width = function (_x) {
            if (!arguments.length) {
                return width;
            }
            if (aspectRatio) {
                height = Math.ceil(_x * aspectRatio);
            }
            width = _x;

            return this;
        };

        /**
         * Gets or Sets the number of ticks of the x axis on the chart
         * @param  {Number} _x Desired xTicks
         * @return {Number | module} Current xTicks or Chart module to chain calls
         * @public
         */
        exports.xTicks = function (_x) {
            if (!arguments.length) {
                return xTicks;
            }
            xTicks = _x;

            return this;
        };

        /**
         * Gets or Sets the y-axis label of the chart
         * @param  {String} _x Desired label string
         * @return {String | module} Current yAxisLabel or Chart module to chain calls
         * @public
         * @example groupedBar.yAxisLabel('Ticket Sales')
         */
        exports.yAxisLabel = function (_x) {
            if (!arguments.length) {
                return yAxisLabel;
            }
            yAxisLabel = _x;

            return this;
        };

        /**
         * Gets or Sets the offset of the yAxisLabel of the chart.
         * The method accepts both positive and negative values.
         * The default value is -60
         * @param  {Number} _x Desired offset for the label
         * @return {Number | module} Current yAxisLabelOffset or Chart module to chain calls
         * @public
         * @example groupedBar.yAxisLabelOffset(-55)
         */
        exports.yAxisLabelOffset = function (_x) {
            if (!arguments.length) {
                return yAxisLabelOffset;
            }
            yAxisLabelOffset = _x;

            return this;
        };

        /**
         * Gets or Sets the x and y offset of ticks of the y axis on the chart
         * @param  {Object} _x Desired offset
         * @return {Object | module} Current offset or Chart module to chain calls
         * @public
         */
        exports.yTickTextOffset = function (_x) {
            if (!arguments.length) {
                return yTickTextOffset;
            }
            yTickTextOffset = _x;

            return this;
        };

        return exports;
    };
}.call(exports, __webpack_require__, exports, module),
				__WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));

/***/ }),
/* 298 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
var __WEBPACK_AMD_DEFINE_RESULT__;

var _extends = Object.assign || function (target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i]; for (var key in source) { if (Object.prototype.hasOwnProperty.call(source, key)) { target[key] = source[key]; } } } return target; };

var _slicedToArray = function () { function sliceIterator(arr, i) { var _arr = []; var _n = true; var _d = false; var _e = undefined; try { for (var _i = arr[Symbol.iterator](), _s; !(_n = (_s = _i.next()).done); _n = true) { _arr.push(_s.value); if (i && _arr.length === i) break; } } catch (err) { _d = true; _e = err; } finally { try { if (!_n && _i["return"]) _i["return"](); } finally { if (_d) throw _e; } } return _arr; } return function (arr, i) { if (Array.isArray(arr)) { return arr; } else if (Symbol.iterator in Object(arr)) { return sliceIterator(arr, i); } else { throw new TypeError("Invalid attempt to destructure non-iterable instance"); } }; }();

function _toConsumableArray(arr) { if (Array.isArray(arr)) { for (var i = 0, arr2 = Array(arr.length); i < arr.length; i++) { arr2[i] = arr[i]; } return arr2; } else { return Array.from(arr); } }

!(__WEBPACK_AMD_DEFINE_RESULT__ = function (require) {
    'use strict';

    var d3Array = __webpack_require__(1);
    var d3Axis = __webpack_require__(17);
    var d3Color = __webpack_require__(12);
    var d3Collection = __webpack_require__(27);
    var d3Dispatch = __webpack_require__(6);
    var d3Ease = __webpack_require__(4);
    var d3Interpolate = __webpack_require__(9);
    var d3Scale = __webpack_require__(8);
    var d3Shape = __webpack_require__(21);
    var d3Selection = __webpack_require__(0);
    var assign = __webpack_require__(66);
    var d3Transition = __webpack_require__(3);

    var _require = __webpack_require__(15),
        exportChart = _require.exportChart;

    var colorHelper = __webpack_require__(5);

    var _require2 = __webpack_require__(13),
        barChartLoadingMarkup = _require2.bar;

    var PERCENTAGE_FORMAT = '%';
    var NUMBER_FORMAT = ',f';
    var uniq = function uniq(arrArg) {
        return arrArg.filter(function (elem, pos, arr) {
            return arr.indexOf(elem) == pos;
        });
    };

    /**
     * @typdef D3Layout
     * @type function
     */

    /**
     * @typedef stackedBarData
     * @type {Object[]}
     * @property {String} name         Name of the entry
     * @property {String} stack        Stack of the entry
     * @property {Number} value        Value of the entry
     *
     * @example
     * [
     *     {
     *         name: "2011-01",
     *         stack: "Direct",
     *         value: 0
     *     }
     * ]
     */

    /**
     * Stacked Area Chart reusable API module that allows us
     * rendering a multi area and configurable chart.
     *
     * @module Stacked-bar
     * @tutorial stacked-bar
     * @requires d3-array, d3-axis, d3-color, d3-collection, d3-dispatch, d3-ease,
     *  d3-interpolate, d3-scale, d3-shape, d3-selection, lodash assign
     *
     * @example
     * let stackedBar = stackedBar();
     *
     * stackedBar
     *     .width(containerWidth);
     *
     * d3Selection.select('.css-selector')
     *     .datum(dataset.data)
     *     .call(stackedBar);
     *
     */
    return function module() {

        var margin = {
            top: 40,
            right: 30,
            bottom: 60,
            left: 70
        },
            width = 960,
            height = 500,
            loadingState = barChartLoadingMarkup,
            xScale = void 0,
            xAxis = void 0,
            yScale = void 0,
            yAxis = void 0,
            aspectRatio = null,
            betweenBarsPadding = 0.1,
            yTickTextYOffset = -8,
            yTickTextXOffset = -20,
            locale = void 0,
            yTicks = 5,
            xTicks = 5,
            percentageAxisToMaxRatio = 1,
            colorSchema = colorHelper.colorSchemas.britecharts,
            colorScale = void 0,
            categoryColorMap = void 0,
            layers = void 0,
            ease = d3Ease.easeQuadInOut,
            isHorizontal = false,
            svg = void 0,
            chartWidth = void 0,
            chartHeight = void 0,
            data = void 0,
            transformedData = void 0,
            stacks = void 0,
            layerElements = void 0,
            hasReversedStacks = false,
            tooltipThreshold = 480,
            yAxisLabel = void 0,
            yAxisLabelEl = void 0,
            yAxisLabelOffset = -60,
            baseLine = void 0,
            xAxisPadding = {
            top: 0,
            left: 0,
            bottom: 0,
            right: 0
        },
            barOpacity = 0.24,
            animationDelayStep = 20,
            animationDuration = 1000,
            animationDelays = void 0,
            grid = null,
            nameLabel = 'name',
            valueLabel = 'value',
            stackLabel = 'stack',
            valueLabelFormat = NUMBER_FORMAT,


        // getters
        getName = function getName(data) {
            return data[nameLabel];
        },
            getValue = function getValue(data) {
            return data[valueLabel];
        },
            getStack = function getStack(data) {
            return data[stackLabel];
        },
            getValOrDefaultToZero = function getValOrDefaultToZero(val) {
            return isNaN(val) || val < 0 ? 0 : val;
        },
            isAnimated = false,


        // events
        dispatcher = d3Dispatch.dispatch('customMouseOver', 'customMouseOut', 'customMouseMove', 'customClick');

        /**
         * This function creates the graph using the selection and data provided
         * @param {D3Selection} _selection A d3 selection that represents
         * the container(s) where the chart(s) will be rendered
         * @param {stackedBarData} _data The data to attach and generate the chart
         */
        function exports(_selection) {
            _selection.each(function (_data) {
                chartWidth = width - margin.left - margin.right;
                chartHeight = height - margin.top - margin.bottom;
                data = cleanData(_data);

                prepareData(data);
                buildScales();
                buildLayers();
                buildSVG(this);
                drawGridLines();
                buildAxis();
                drawAxis();
                drawStackedBar();
                addMouseEvents();
            });
        }

        /**
         * Adds events to the container group if the environment is not mobile
         * Adding: mouseover, mouseout and mousemove
         */
        function addMouseEvents() {
            if (shouldShowTooltip()) {
                svg.on('mouseover', function (d) {
                    handleMouseOver(this, d);
                }).on('mouseout', function (d) {
                    handleMouseOut(this, d);
                }).on('mousemove', function (d) {
                    handleMouseMove(this, d);
                }).on('click', function (d) {
                    handleClick(this, d);
                });
            }

            svg.selectAll('.bar').on('mouseover', handleBarsMouseOver).on('mouseout', handleBarsMouseOut);
        }

        /**
         * Adjusts the position of the y axis' ticks
         * @param  {D3Selection} selection Y axis group
         * @return void
         */
        function adjustYTickLabels(selection) {
            selection.selectAll('.tick text').attr('transform', 'translate(' + yTickTextXOffset + ', ' + yTickTextYOffset + ')');
        }

        /**
         * Creates the d3 x and y axis, setting orientations
         * @private
         */
        function buildAxis() {
            if (isHorizontal) {
                xAxis = d3Axis.axisBottom(xScale).ticks(xTicks, valueLabelFormat);
                yAxis = d3Axis.axisLeft(yScale);
            } else {
                xAxis = d3Axis.axisBottom(xScale);
                yAxis = d3Axis.axisLeft(yScale).ticks(yTicks, valueLabelFormat);
            }
        }

        /**
         * Builds containers for the chart, the axis and a wrapper for all of them
         * NOTE: The order of drawing of this group elements is really important,
         * as everything else will be drawn on top of them
         * @private
         */
        function buildContainerGroups() {
            var container = svg.append('g').classed('container-group', true).attr('transform', 'translate(' + margin.left + ',' + margin.top + ')');

            container.append('g').classed('x-axis-group', true).append('g').classed('x axis', true);
            container.selectAll('.x-axis-group').append('g').classed('month-axis', true);
            container.append('g').classed('y-axis-group axis', true);
            container.append('g').classed('grid-lines-group', true);
            container.append('g').classed('chart-group', true);
            container.append('g').classed('y-axis-label', true);
            container.append('g').classed('metadata-group', true);
        }

        /**
         * Builds the stacked layers layout
         * @return {D3Layout} Layout for drawing the chart
         * @private
         */
        function buildLayers() {
            var stack3 = d3Shape.stack().keys(stacks),
                dataInitial = transformedData.map(function (item) {
                var ret = {};

                stacks.forEach(function (key) {
                    ret[key] = item[key];
                });

                return assign({}, item, ret);
            });

            layers = stack3(dataInitial);
        }

        /**
         * Creates the x, y and color scales of the chart
         * @private
         */
        function buildScales() {
            var yMax = d3Array.max(transformedData.map(function (d) {
                return d.total;
            }));

            if (isHorizontal) {
                xScale = d3Scale.scaleLinear().domain([0, yMax]).rangeRound([0, chartWidth - 1]);
                // 1 pix for edge tick

                yScale = d3Scale.scaleBand().domain(data.map(getName)).rangeRound([chartHeight, 0]).padding(betweenBarsPadding);
            } else {
                xScale = d3Scale.scaleBand().domain(data.map(getName)).rangeRound([0, chartWidth]).padding(betweenBarsPadding);

                yScale = d3Scale.scaleLinear().domain([0, yMax]).rangeRound([chartHeight, 0]).nice();
            }

            colorScale = d3Scale.scaleOrdinal().range(colorSchema).domain(data.map(getStack));

            categoryColorMap = colorScale.domain(data.map(getStack)).domain().reduce(function (memo, item) {
                memo[item] = colorScale(item);
                return memo;
            }, {});
        }

        /**
         * @param  {HTMLElement} container DOM element that will work as the container of the graph
         * @private
         */
        function buildSVG(container) {
            if (!svg) {
                svg = d3Selection.select(container).append('svg').classed('britechart stacked-bar', true);

                buildContainerGroups();
            }

            svg.attr('width', width).attr('height', height);
        }

        /**
         * Cleaning data casting the values, stacks, names and topic names to the proper type while keeping
         * the rest of properties on the data
         * @param  {stackedBarData} originalData   Raw data from the container
         * @return {stackedBarData}                Parsed data with values and dates
         * @private
         */
        function cleanData(originalData) {
            return originalData.reduce(function (acc, d) {
                d.value = +d[valueLabel];
                d.stack = d[stackLabel];
                d.topicName = getStack(d); // for tooltip
                d.name = d[nameLabel];

                return [].concat(_toConsumableArray(acc), [d]);
            }, []);
        }

        /**
         * Draws the x and y axis on the svg object within their
         * respective groups
         * @private
         */
        function drawAxis() {
            if (isHorizontal) {
                svg.select('.x-axis-group .axis.x').attr('transform', 'translate( 0, ' + chartHeight + ' )').call(xAxis);

                svg.select('.y-axis-group.axis').attr('transform', 'translate( ' + -xAxisPadding.left + ', 0)').call(yAxis);
            } else {
                svg.select('.x-axis-group .axis.x').attr('transform', 'translate( 0, ' + chartHeight + ' )').call(xAxis);

                svg.select('.y-axis-group.axis').attr('transform', 'translate( ' + -xAxisPadding.left + ', 0)').call(yAxis).call(adjustYTickLabels);
            }

            if (yAxisLabel) {
                if (yAxisLabelEl) {
                    svg.selectAll('.y-axis-label-text').remove();
                }

                yAxisLabelEl = svg.select('.y-axis-label').append('text').classed('y-axis-label-text', true).attr('x', -chartHeight / 2).attr('y', yAxisLabelOffset).attr('text-anchor', 'middle').attr('transform', 'rotate(270 0 0)').text(yAxisLabel);
            }
        }

        /**
         * Draws grid lines on the background of the chart
         * @return void
         */
        function drawGridLines() {
            var scale = isHorizontal ? xScale : yScale;

            svg.select('.grid-lines-group').selectAll('line').remove();

            if (grid === 'horizontal' || grid === 'full') {
                svg.select('.grid-lines-group').selectAll('line.horizontal-grid-line').data(scale.ticks(yTicks).slice(1)).enter().append('line').attr('class', 'horizontal-grid-line').attr('x1', -xAxisPadding.left + 1).attr('x2', chartWidth).attr('y1', function (d) {
                    return yScale(d);
                }).attr('y2', function (d) {
                    return yScale(d);
                });
            }

            if (grid === 'vertical' || grid === 'full') {
                svg.select('.grid-lines-group').selectAll('line.vertical-grid-line').data(scale.ticks(xTicks).slice(1)).enter().append('line').attr('class', 'vertical-grid-line').attr('y1', 0).attr('y2', chartHeight).attr('x1', function (d) {
                    return xScale(d);
                }).attr('x2', function (d) {
                    return xScale(d);
                });
            }

            if (isHorizontal) {
                drawVerticalExtendedLine();
            } else {
                drawHorizontalExtendedLine();
            }
        }

        /**
         * Draws the bars along the x axis
         * @param  {D3Selection} layersSelection Selection of bars
         * @return {void}
         */
        function drawHorizontalBars(layersSelection) {
            var layerJoin = layersSelection.data(layers);

            layerElements = layerJoin.enter().append('g').attr('fill', function (_ref) {
                var key = _ref.key;
                return categoryColorMap[key];
            }).classed('layer', true);

            var barJoin = layerElements.selectAll('.bar').data(function (d) {
                return filterOutUnkownValues(d);
            });

            // Enter + Update
            var bars = barJoin.enter().append('rect').classed('bar', true).attr('x', function (d) {
                return xScale(d[0]);
            }).attr('y', function (d) {
                return yScale(d.data.key);
            }).attr('height', yScale.bandwidth());

            if (isAnimated) {
                bars.style('opacity', barOpacity).transition().delay(function (_, i) {
                    return animationDelays[i];
                }).duration(animationDuration).ease(ease).tween('attr.width', horizontalBarsTween);
            } else {
                bars.attr('width', function (d) {
                    return xScale(d[1] - d[0]);
                });
            }
        }

        /**
         * Draws a vertical line to extend x-axis till the edges
         * @return {void}
         */
        function drawHorizontalExtendedLine() {
            baseLine = svg.select('.grid-lines-group').selectAll('line.extended-x-line').data([0]).enter().append('line').attr('class', 'extended-x-line').attr('x1', xAxisPadding.left).attr('x2', chartWidth).attr('y1', chartHeight).attr('y2', chartHeight);
        }

        /**
         * Draws the bars along the y axis
         * @param  {D3Selection} layersSelection Selection of bars
         * @return {void}
         */
        function drawVerticalBars(layersSelection) {
            var layerJoin = layersSelection.data(layers);

            layerElements = layerJoin.enter().append('g').attr('fill', function (_ref2) {
                var key = _ref2.key;
                return categoryColorMap[key];
            }).classed('layer', true);

            var barJoin = layerElements.selectAll('.bar').data(function (d) {
                return filterOutUnkownValues(d);
            });

            // Enter + Update
            var bars = barJoin.enter().append('rect').classed('bar', true).attr('x', function (d) {
                return xScale(d.data.key);
            }).attr('y', function (d) {
                return yScale(d[1]);
            }).attr('width', xScale.bandwidth);

            if (isAnimated) {
                bars.style('opacity', barOpacity).transition().delay(function (_, i) {
                    return animationDelays[i];
                }).duration(animationDuration).ease(ease).tween('attr.height', verticalBarsTween);
            } else {
                bars.attr('height', function (d) {
                    return yScale(d[0]) - yScale(d[1]);
                });
            }
        }

        /**
         * Draws a vertical line to extend y-axis till the edges
         * @return {void}
         */
        function drawVerticalExtendedLine() {
            baseLine = svg.select('.grid-lines-group').selectAll('line.extended-y-line').data([0]).enter().append('line').attr('class', 'extended-y-line').attr('y1', xAxisPadding.bottom).attr('y2', chartHeight).attr('x1', 0).attr('x2', 0);
        }

        /**
         * Draws the different areas into the chart-group element
         * @private
         */
        function drawStackedBar() {
            // Not ideal, we need to figure out how to call exit for nested elements
            if (layerElements) {
                svg.selectAll('.layer').remove();
            }

            var series = svg.select('.chart-group').selectAll('.layer');

            animationDelays = d3Array.range(animationDelayStep, (layers[0].length + 1) * animationDelayStep, animationDelayStep);

            if (isHorizontal) {
                drawHorizontalBars(series);
            } else {
                drawVerticalBars(series);
            }
            // Exit
            series.exit().transition().style('opacity', 0).remove();
        }

        /**
         * Filter out unkown stacks/values in the bar layers
         * @param {Object[]} d
         * @return {Object[]} filteredData
         * @private
         */
        function filterOutUnkownValues(d) {
            return d.map(function (layerEls) {
                for (var i = 0; i < layerEls.length; i++) {
                    layerEls[i] = getValOrDefaultToZero(layerEls[i]);
                }
                return layerEls;
            });
        }

        /**
         * Extract X position on the chart from a given mouse event
         * @param  {obj} event D3 mouse event
         * @return {Number}       Position on the x axis of the mouse
         * @private
         */
        function getMousePosition(event) {
            return d3Selection.mouse(event);
        }

        /**
         * Finds out the data entry that is closer to the given position on pixels
         * @param  {Number} mouseX  X position of the mouse
         * @return {obj}            Data entry that is closer to that x axis position
         */
        function getNearestDataPoint(mouseX) {
            var adjustedMouseX = mouseX - margin.left;

            var nearest = transformedData.find(function (_ref3) {
                var key = _ref3.key;

                var barStart = xScale(key);
                var barEnd = barStart + xScale.bandwidth();

                // If mouseX is between barStart & barEnd
                return adjustedMouseX >= barStart && adjustedMouseX < barEnd;
            });

            return nearest;
        }

        /**
         * Finds out the data entry that is closer to the given position on pixels (horizontal)
         * @param  {Number} mouseY  Y position of the mouse
         * @return {obj}            Data entry that is closer to that y axis position
         */
        function getNearestDataPoint2(mouseY) {
            var adjustedMouseY = mouseY - margin.top;

            var nearest = transformedData.find(function (_ref4) {
                var key = _ref4.key;

                var barStart = yScale(key);
                var barEnd = barStart + yScale.bandwidth();

                // If mouseY is between barStart & barEnd
                return adjustedMouseY >= barStart && adjustedMouseY < barEnd;
            });

            return nearest;
        }

        /**
         * Handles a mouseover event on top of a bar
         * @return {void}
         */
        function handleBarsMouseOver() {
            var _this = this;

            d3Selection.select(this).attr('fill', function () {
                return d3Color.color(d3Selection.select(_this.parentNode).attr('fill')).darker();
            });
        }

        /**
         * Handles a mouseout event out of a bar
         * @return {void}
         */
        function handleBarsMouseOut() {
            var _this2 = this;

            d3Selection.select(this).attr('fill', function () {
                return d3Selection.select(_this2.parentNode).attr('fill');
            });
        }

        /**
         * MouseMove handler, calculates the nearest dataPoint to the cursor
         * and updates metadata related to it
         * @private
         */
        function handleMouseMove(e) {
            var _getMousePosition = getMousePosition(e),
                _getMousePosition2 = _slicedToArray(_getMousePosition, 2),
                mouseX = _getMousePosition2[0],
                mouseY = _getMousePosition2[1],
                dataPoint = isHorizontal ? getNearestDataPoint2(mouseY) : getNearestDataPoint(mouseX),
                x = void 0,
                y = void 0;

            if (dataPoint) {
                // Move verticalMarker to that datapoint
                if (isHorizontal) {
                    x = mouseX - margin.left;
                    y = yScale(dataPoint.key) + yScale.bandwidth() / 2;
                } else {
                    x = xScale(dataPoint.key) + margin.left;
                    y = mouseY - margin.bottom;
                }
                moveTooltipOriginXY(x, y);

                // Emit event with xPosition for tooltip or similar feature
                dispatcher.call('customMouseMove', e, dataPoint, categoryColorMap, x, y);
            }
        }

        /**
         * Click handler, passes the data point of the clicked bar
         * (or it's nearest point)
         * @private
         */

        function handleClick(e) {
            var _getMousePosition3 = getMousePosition(e),
                _getMousePosition4 = _slicedToArray(_getMousePosition3, 2),
                mouseX = _getMousePosition4[0],
                mouseY = _getMousePosition4[1];

            var dataPoint = isHorizontal ? getNearestDataPoint2(mouseY) : getNearestDataPoint(mouseX);

            dispatcher.call('customClick', e, dataPoint, d3Selection.mouse(e));
        }

        /**
         * MouseOut handler, hides overlay and removes active class on verticalMarkerLine
         * It also resets the container of the vertical marker
         * @private
         */
        function handleMouseOut(e, d) {
            svg.select('.metadata-group').attr('transform', 'translate(9999, 0)');
            dispatcher.call('customMouseOut', e, d, d3Selection.mouse(e));
        }

        /**
         * Mouseover handler, shows overlay and adds active class to verticalMarkerLine
         * @private
         */
        function handleMouseOver(e, d) {
            dispatcher.call('customMouseOver', e, d, d3Selection.mouse(e));
        }

        /**
         * Animation tween of horizontal bars
         * @param  {obj} d data of bar
         * @return {void}
         */
        function horizontalBarsTween(d) {
            var node = d3Selection.select(this),
                i = d3Interpolate.interpolateRound(0, xScale(d[1] - d[0])),
                j = d3Interpolate.interpolateNumber(0, 1);

            return function (t) {
                node.attr('width', i(t)).style('opacity', j(t));
            };
        }

        /**
         * Helper method to update the x position of the vertical marker
         * @param  {obj} dataPoint Data entry to extract info
         * @return void
         */
        function moveTooltipOriginXY(originXPosition, originYPosition) {
            svg.select('.metadata-group').attr('transform', 'translate(' + originXPosition + ',' + originYPosition + ')');
        }

        /**
         * Prepare data for create chart.
         * @private
         */
        function prepareData(data) {
            stacks = uniq(data.map(function (_ref5) {
                var stack = _ref5.stack;
                return stack;
            }));

            if (hasReversedStacks) {
                stacks = stacks.reverse();
            }

            transformedData = d3Collection.nest().key(getName).rollup(function (values) {
                var ret = {};

                values.forEach(function (entry) {
                    if (entry && entry[stackLabel]) {
                        ret[entry[stackLabel]] = getValue(entry);
                    }
                });
                ret.values = values; //for tooltip

                return ret;
            }).entries(data).map(function (data) {
                return assign({}, {
                    total: d3Array.sum(d3Array.permute(data.value, stacks)),
                    key: data.key
                }, data.value);
            });
        }

        /**
         * Determines if we should add the tooltip related logic depending on the
         * size of the chart and the tooltipThreshold variable value
         * @return {boolean} Should we build the tooltip?
         * @private
         */
        function shouldShowTooltip() {
            return width > tooltipThreshold;
        }

        /**
         * Animation tween of vertical bars
         * @param  {obj} d data of bar
         * @return {void}
         */
        function verticalBarsTween(d) {
            var vertDiff = yScale(d[0]) - yScale(d[1]);

            var node = d3Selection.select(this),
                i = d3Interpolate.interpolateRound(0, getValOrDefaultToZero(vertDiff)),
                j = d3Interpolate.interpolateNumber(0, 1);

            return function (t) {
                node.attr('height', i(t)).style('opacity', j(t));
            };
        }

        // API
        /**
         * Gets or Sets the aspect ratio of the chart
         * @param  {Number} _x Desired aspect ratio for the graph
         * @return {Number | module} Current aspect ratio or Area Chart module to chain calls
         * @public
         */
        exports.aspectRatio = function (_x) {
            if (!arguments.length) {
                return aspectRatio;
            }
            aspectRatio = _x;

            return this;
        };

        /**
         * Gets or Sets the padding of the stacked bar chart
         * The default value is
         * @param  {Number} _x Padding value to get/set
         * @return {Number | module} Current padding or Chart module to chain calls
         * @public
         */
        exports.betweenBarsPadding = function (_x) {
            if (!arguments.length) {
                return betweenBarsPadding;
            }
            betweenBarsPadding = _x;

            return this;
        };

        /**
         * Gets or Sets the colorSchema of the chart
         * @param  {String[]} _x Desired colorSchema for the graph
         * @return {String[] | module} Current colorSchema or Chart module to chain calls
         * @public
         */
        exports.colorSchema = function (_x) {
            if (!arguments.length) {
                return colorSchema;
            }
            colorSchema = _x;

            return this;
        };

        /**
         * Chart exported to png and a download action is fired
         * @param {String} filename     File title for the resulting picture
         * @param {String} title        Title to add at the top of the exported picture
         * @public
         */
        exports.exportChart = function (filename, title) {
            exportChart.call(exports, svg, filename, title);
        };

        /**
         * Gets or Sets the grid mode.
         *
         * @param  {String} _x Desired mode for the grid ('vertical'|'horizontal'|'full')
         * @return {String | module} Current mode of the grid or Area Chart module to chain calls
         * @public
         */
        exports.grid = function (_x) {
            if (!arguments.length) {
                return grid;
            }
            grid = _x;

            return this;
        };

        /**
         * Gets or Sets the hasPercentage status
         * @param  {Boolean} _x     Should use percentage as value format
         * @return {Boolean | module} Is percentage used or Chart module to chain calls
         * @public
         */
        exports.hasPercentage = function (_x) {
            if (!arguments.length) {
                return valueLabelFormat === PERCENTAGE_FORMAT;
            }
            if (_x) {
                valueLabelFormat = PERCENTAGE_FORMAT;
            } else {
                valueLabelFormat = NUMBER_FORMAT;
            }

            return this;
        };

        /**
         * Gets or Sets the height of the chart
         * @param  {Number} _x Desired width for the graph
         * @return {Number | module} Current height or Area Chart module to chain calls
         * @public
         */
        exports.height = function (_x) {
            if (!arguments.length) {
                return height;
            }
            if (aspectRatio) {
                width = Math.ceil(_x / aspectRatio);
            }
            height = _x;

            return this;
        };

        /**
         * Gets or Sets the horizontal direction of the chart
         * @param  {Boolean} _x Desired horizontal direction for the graph
         * @return {Boolean | module} If it is horizontal or Bar Chart module to chain calls
         * @public
         */
        exports.isHorizontal = function (_x) {
            if (!arguments.length) {
                return isHorizontal;
            }
            isHorizontal = _x;

            return this;
        };

        /**
         * Gets or Sets the hasReversedStacks property of the chart, reversing the order of stacks.
         * @param  {Boolean} _x Desired hasReversedStacks flag
         * @return {Boolean | module} Current hasReversedStacks or Chart module to chain calls
         * @public
         */
        exports.hasReversedStacks = function (_x) {
            if (!arguments.length) {
                return hasReversedStacks;
            }
            hasReversedStacks = _x;

            return this;
        };

        /**
         * Gets or Sets the isAnimated property of the chart, making it to animate when render.
         * By default this is 'false'
         *
         * @param  {Boolean} _x Desired animation flag
         * @return {Boolean | module} Current isAnimated flag or Chart module
         * @public
         */
        exports.isAnimated = function (_x) {
            if (!arguments.length) {
                return isAnimated;
            }
            isAnimated = _x;

            return this;
        };

        /**
         * Pass language tag for the tooltip to localize the date.
         * Feature uses Intl.DateTimeFormat, for compatability and support, refer to
         * https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/DateTimeFormat
         * @param  {String} _x  must be a language tag (BCP 47) like 'en-US' or 'fr-FR'
         * @return {String | module}    Current locale or module to chain calls
         */
        exports.locale = function (_x) {
            if (!arguments.length) {
                return locale;
            }
            locale = _x;

            return this;
        };

        /**
         * Gets or Sets the margin of the chart
         * @param  {Object} _x Margin object to get/set
         * @return {Object | module} Current margin or Area Chart module to chain calls
         * @public
         */
        exports.margin = function (_x) {
            if (!arguments.length) {
                return margin;
            }
            margin = _extends({}, margin, _x);

            return this;
        };

        /**
         * Gets or Sets the nameLabel of the chart
         * @param  {Number} _x Desired dateLabel for the graph
         * @return {Number | module} Current nameLabel or Chart module to chain calls
         * @public
         */
        exports.nameLabel = function (_x) {
            if (!arguments.length) {
                return nameLabel;
            }
            nameLabel = _x;

            return this;
        };

        /**
         * Gets or Sets the number of ticks of the x axis on the chart
         * (Default is 5)
         * @param  {Number} _x Desired horizontal ticks
         * @return {Number | module} Current xTicks or Chart module to chain calls
         * @public
         */
        exports.xTicks = function (_x) {
            if (!arguments.length) {
                return xTicks;
            }
            xTicks = _x;

            return this;
        };

        /**
         * Gets or Sets the number of vertical ticks of the axis on the chart
         * @param  {Number} _x          Desired vertical ticks
         * @return {Number | module}    Current yTicks or Chart module to chain calls
         * @public
         */
        exports.yTicks = function (_x) {
            if (!arguments.length) {
                return yTicks;
            }
            yTicks = _x;

            return this;
        };

        /**
         * Gets or Sets the loading state of the chart
         * @param  {String} markup Desired markup to show when null data
         * @return {String | module} Current loading state markup or Chart module to chain calls
         * @public
         */
        exports.loadingState = function (_markup) {
            if (!arguments.length) {
                return loadingState;
            }
            loadingState = _markup;

            return this;
        };

        /**
         * Exposes an 'on' method that acts as a bridge with the event dispatcher
         * We are going to expose this events:
         * customMouseOver, customMouseMove, customMouseOut, and customClick
         *
         * @return {module} Bar Chart
         * @public
         */
        exports.on = function () {
            var value = dispatcher.on.apply(dispatcher, arguments);

            return value === dispatcher ? exports : value;
        };

        /**
         * Configurable extension of the x axis
         * if your max point was 50% you might want to show x axis to 60%, pass 1.2
         * @param  {Number} _x ratio to max data point to add to the x axis
         * @return {Number | module} Current ratio or Bar Chart module to chain calls
         * @public
         */
        exports.percentageAxisToMaxRatio = function (_x) {
            if (!arguments.length) {
                return percentageAxisToMaxRatio;
            }
            percentageAxisToMaxRatio = _x;

            return this;
        };

        /**
         * Gets or Sets the stackLabel of the chart
         * @param  {String} _x Desired stackLabel for the graph
         * @return {String | module} Current stackLabel or Chart module to chain calls
         * @public
         */
        exports.stackLabel = function (_x) {
            if (!arguments.length) {
                return stackLabel;
            }
            stackLabel = _x;

            return this;
        };

        /**
         * Gets or Sets the minimum width of the graph in order to show the tooltip
         * NOTE: This could also depend on the aspect ratio
         *
         * @param  {Number} [_x=480] Minimum width of the graph
         * @return {Number | module} Current tooltipThreshold or Area Chart module to chain calls
         * @public
         */
        exports.tooltipThreshold = function (_x) {
            if (!arguments.length) {
                return tooltipThreshold;
            }
            tooltipThreshold = _x;

            return this;
        };

        /**
         * Gets or Sets the valueLabel of the chart
         * @param  {Number} _x Desired valueLabel for the graph
         * @return {Number | module} Current valueLabel or Chart module to chain calls
         * @public
         */
        exports.valueLabel = function (_x) {
            if (!arguments.length) {
                return valueLabel;
            }
            valueLabel = _x;

            return this;
        };

        /**
         * Gets or Sets the valueLabelFormat of the chart
         * @param  {String[]} _x Desired valueLabelFormat for the graph
         * @return {String[] | module} Current valueLabelFormat or Chart module to chain calls
         * @public
         */
        exports.valueLabelFormat = function (_x) {
            if (!arguments.length) {
                return valueLabelFormat;
            }
            valueLabelFormat = _x;

            return this;
        };

        /**
         * Gets or Sets the width of the chart
         * @param  {Number} _x Desired width for the graph
         * @return {Number | module} Current width or Area Chart module to chain calls
         * @public
         */
        exports.width = function (_x) {
            if (!arguments.length) {
                return width;
            }
            if (aspectRatio) {
                height = Math.ceil(_x * aspectRatio);
            }
            width = _x;

            return this;
        };

        /**
         * Gets or Sets the y-axis label of the chart
         * @param  {String} _x Desired label string
         * @return {String | module} Current yAxisLabel or Chart module to chain calls
         * @public
         * @example stackedBar.yAxisLabel('Ticket Sales')
         */
        exports.yAxisLabel = function (_x) {
            if (!arguments.length) {
                return yAxisLabel;
            }
            yAxisLabel = _x;

            return this;
        };

        /**
         * Gets or Sets the offset of the yAxisLabel of the chart.
         * The method accepts both positive and negative values.
         * The default value is -60
         * @param  {Number} _x Desired offset for the label
         * @return {Number | module} Current yAxisLabelOffset or Chart module to chain calls
         * @public
         * @example stackedBar.yAxisLabelOffset(-55)
         */
        exports.yAxisLabelOffset = function (_x) {
            if (!arguments.length) {
                return yAxisLabelOffset;
            }
            yAxisLabelOffset = _x;

            return this;
        };

        return exports;
    };
}.call(exports, __webpack_require__, exports, module),
				__WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));

/***/ }),
/* 299 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
var __WEBPACK_AMD_DEFINE_RESULT__;

var _extends = Object.assign || function (target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i]; for (var key in source) { if (Object.prototype.hasOwnProperty.call(source, key)) { target[key] = source[key]; } } } return target; };

function _toConsumableArray(arr) { if (Array.isArray(arr)) { for (var i = 0, arr2 = Array(arr.length); i < arr.length; i++) { arr2[i] = arr[i]; } return arr2; } else { return Array.from(arr); } }

!(__WEBPACK_AMD_DEFINE_RESULT__ = function (require) {
    'use strict';

    var d3Array = __webpack_require__(1);
    var d3Selection = __webpack_require__(0);
    var d3Scale = __webpack_require__(8);
    var d3Transition = __webpack_require__(3);
    var d3Interpolate = __webpack_require__(9);

    var _require = __webpack_require__(15),
        exportChart = _require.exportChart;

    var colorHelper = __webpack_require__(5);

    /**
     * @typedef HeatmapData
     * @type {Array[]}
     * @property {Number} week
     * @property {Number} day
     * @property {Number} value
     *
     * @example
     * [
     *     {
     *         day: 0,
     *         hour: 0,
     *         value: 7
     *     },
     *     {
     *         day: 0,
     *         hour: 1,
     *         value: 10
     *     }
     * ]
     */

    /**
     * Reusable Heatmap API module that renders a
     * simple and configurable heatmap chart.
     *
     * @module Heatmap
     * @tutorial heatmap
     * @requires d3-array, d3-selection, d3-scale, d3-interpolate, d3-transition
     *
     * @example
     * let heatmap = heatmap();
     *
     * heatmap
     *     .width(500);
     *
     * d3Selection.select('.css-selector')
     *     .datum(dataset)
     *     .call(heatmap);
     */
    return function module() {

        var margin = {
            top: 40,
            right: 20,
            bottom: 20,
            left: 40
        },
            width = 780,
            height = 270,
            svg = void 0,
            data = void 0,
            chartWidth = void 0,
            chartHeight = void 0,
            boxes = void 0,
            boxSize = 30,
            boxBorderSize = 2,
            boxInitialOpacity = 0.2,
            boxFinalOpacity = 1,
            boxInitialColor = '#BBBBBB',
            boxBorderColor = '#FFFFFF',
            colorScale = void 0,
            colorSchema = colorHelper.colorSchemas.red,
            animationDuration = 2000,
            dayLabels = void 0,
            daysHuman = ['Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa', 'Su'],
            dayLabelWidth = 30,
            hourLabels = void 0,
            hoursHuman = ['00h', '01h', '02h', '03h', '04h', '05h', '06h', '07h', '08h', '09h', '10h', '11h', '12h', '13h', '14h', '15h', '16h', '17h', '18h', '19h', '20h', '21h', '22h', '23h'],
            hourLabelHeight = 20,
            getValue = function getValue(_ref) {
            var value = _ref.value;
            return value;
        };

        /**
         * This function creates the graph using the selection as container
         * @param  {D3Selection} _selection A d3 selection that represents
         *                                  the container(s) where the chart(s) will be rendered
         * @param {HeatmapData} _data The data to attach and generate the chart
         */
        function exports(_selection) {
            _selection.each(function (_data) {
                data = cleanData(_data);

                chartWidth = width - margin.left - margin.right;
                chartHeight = height - margin.top - margin.bottom;

                buildScales();
                buildSVG(this);
                drawDayLabels();
                drawHourLabels();
                drawBoxes();
            });
        }

        /**
         * Builds the SVG element that will contain the chart
         * @param  {HTMLElement} container DOM element that will work as the container of the graph
         * @return {void}
         * @private
         */
        function buildSVG(container) {
            if (!svg) {
                svg = d3Selection.select(container).append('svg').classed('britechart heatmap', true);

                buildContainerGroups();
            }

            svg.attr('width', width).attr('height', height);
        }

        /**
         * Builds containers for the chart, the axis and a wrapper for all of them
         * Also applies the Margin convention
         * @return {void}
         * @private
         */
        function buildContainerGroups() {
            var container = svg.append('g').classed('container-group', true).attr('transform', 'translate(' + margin.left + ', ' + margin.top + ')');

            container.append('g').classed('chart-group', true);
            container.append('g').classed('day-labels-group', true);
            container.append('g').classed('hour-labels-group', true);
            container.append('g').classed('metadata-group', true);
        }

        /**
         * Cleaning data casting the values to the proper
         * type while keeping the rest of properties on the data. It
         * also creates a set of zeroed data (for animation purposes)
         * @param   {HeatmapData} originalData  Raw data as passed to the container
         * @return  {HeatmapData}               Clean data
         * @private
         */
        function cleanData(originalData) {
            return originalData.reduce(function (acc, _ref2) {
                var day = _ref2.day,
                    hour = _ref2.hour,
                    value = _ref2.value;

                return [].concat(_toConsumableArray(acc), [{
                    day: +day,
                    hour: +hour,
                    value: +value
                }]);
            }, []);
        }

        /**
         * Creates the scales for the heatmap chart
         * @return void
         */
        function buildScales() {
            colorScale = d3Scale.scaleLinear().range([colorSchema[0], colorSchema[colorSchema.length - 1]]).domain(d3Array.extent(data, getValue)).interpolate(d3Interpolate.interpolateHcl);
        }

        /**
         * Draws the boxes of the heatmap
         */
        function drawBoxes() {
            boxes = svg.select('.chart-group').selectAll('.box').data(data);

            boxes.enter().append('rect').classed('box', true).attr('width', boxSize).attr('height', boxSize).attr('x', function (_ref3) {
                var hour = _ref3.hour;
                return hour * boxSize;
            }).attr('y', function (_ref4) {
                var day = _ref4.day;
                return day * boxSize;
            }).style('opacity', boxInitialOpacity).style('fill', boxInitialColor).style('stroke', boxBorderColor).style('stroke-width', boxBorderSize).transition().duration(animationDuration).style('fill', function (_ref5) {
                var value = _ref5.value;
                return colorScale(value);
            }).style('opacity', boxFinalOpacity);

            boxes.exit().remove();
        }

        /**
         * Draws the day labels
         */
        function drawDayLabels() {
            var dayLabelsGroup = svg.select('.day-labels-group');

            dayLabels = svg.select('.day-labels-group').selectAll('.day-label').data(daysHuman);

            dayLabels.enter().append('text').text(function (label) {
                return label;
            }).attr('x', 0).attr('y', function (d, i) {
                return i * boxSize;
            }).style('text-anchor', 'start').style('dominant-baseline', 'central').attr('class', 'day-label');

            dayLabelsGroup.attr('transform', 'translate(-' + dayLabelWidth + ', ' + boxSize / 2 + ')');
        }

        /**
         * Draws the hour labels
         */
        function drawHourLabels() {
            var hourLabelsGroup = svg.select('.hour-labels-group');

            hourLabels = svg.select('.hour-labels-group').selectAll('.hour-label').data(hoursHuman);

            hourLabels.enter().append('text').text(function (label) {
                return label;
            }).attr('y', 0).attr('x', function (d, i) {
                return i * boxSize;
            }).style('text-anchor', 'middle').style('dominant-baseline', 'central').attr('class', 'hour-label');

            hourLabelsGroup.attr('transform', 'translate(' + boxSize / 2 + ', -' + hourLabelHeight + ')');
        }

        // API
        /**
         * Gets or Sets the boxSize of the chart
         * @param  {Number} _x=30       Desired boxSize for the heatmap boxes
         * @return {Number | module}    Current boxSize or Chart module to chain calls
         * @public
         */
        exports.boxSize = function (_x) {
            if (!arguments.length) {
                return boxSize;
            }
            boxSize = _x;

            return this;
        };

        /**
         * Gets or Sets the colorSchema of the chart
         * @param  {String[]} _x=britecharts-red  Desired colorSchema for the heatma boxes
         * @return {String[] | module}            Current colorSchema or Chart module to chain calls
         * @public
         */
        exports.colorSchema = function (_x) {
            if (!arguments.length) {
                return colorSchema;
            }
            colorSchema = _x;

            return this;
        };

        /**
         * Chart exported to png and a download action is fired
         * @param {String} filename     File title for the resulting picture
         * @param {String} title        Title to add at the top of the exported picture
         * @public
         */
        exports.exportChart = function (filename, title) {
            exportChart.call(exports, svg, filename, title);
        };

        /**
         * Gets or Sets the height of the chart
         * @param  {Number} _x          Desired height for the chart
         * @return {Number | module}    Current height or Chart module to chain calls
         * @public
         */
        exports.height = function (_x) {
            if (!arguments.length) {
                return height;
            }
            height = _x;

            return this;
        };

        /**
         * Gets or Sets the margin of the chart
         * @param  {Object} _x          Margin object to get/set
         * @return {margin | module}    Current margin or Chart module to chain calls
         * @public
         */
        exports.margin = function (_x) {
            if (!arguments.length) {
                return margin;
            }
            margin = _extends({}, margin, _x);

            return this;
        };

        /**
         * Gets or Sets the width of the chart
         * @param  {Number} _x           Desired width for the chart
         * @return {Number | module}     Current width or Chart module to chain calls
         * @public
         */
        exports.width = function (_x) {
            if (!arguments.length) {
                return width;
            }
            width = _x;

            return this;
        };

        return exports;
    };
}.call(exports, __webpack_require__, exports, module),
				__WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));

/***/ }),
/* 300 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
var __WEBPACK_AMD_DEFINE_RESULT__;

var _extends = Object.assign || function (target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i]; for (var key in source) { if (Object.prototype.hasOwnProperty.call(source, key)) { target[key] = source[key]; } } } return target; };

function _toConsumableArray(arr) { if (Array.isArray(arr)) { for (var i = 0, arr2 = Array(arr.length); i < arr.length; i++) { arr2[i] = arr[i]; } return arr2; } else { return Array.from(arr); } }

!(__WEBPACK_AMD_DEFINE_RESULT__ = function (require) {
    'use strict';

    var d3Array = __webpack_require__(1);
    var d3Axis = __webpack_require__(17);
    var d3Dispatch = __webpack_require__(6);
    var d3Ease = __webpack_require__(4);
    var d3Format = __webpack_require__(7);
    var d3Scale = __webpack_require__(8);
    var d3Selection = __webpack_require__(0);
    var d3Transition = __webpack_require__(3);

    var _require = __webpack_require__(15),
        exportChart = _require.exportChart;

    var _require2 = __webpack_require__(13),
        line = _require2.line;

    /**
     * @typedef StepChartData
     * @type Object[]
     *
     * @property {String} key      Key we measure (required)
     * @property {Number} value    value of the key (required)
     *
     * @example
     * [
     *     {
     *         value: 1,
     *         key: 'glittering'
     *     },
     *     {
     *         value: 1,
     *         key: 'luminous'
     *     }
     * ]
     */

    /**
     * Step Chart reusable API class that renders a
     * simple and configurable step chart.
     *
     * @module Step
     * @tutorial step
     * @requires d3-array, d3-axis, d3-dispatch, d3-format, d3-scale, d3-selection, d3-transition
     *
     * @example
     * var stepChart= step();
     *
     * stepChart
     *     .height(500)
     *     .width(800);
     *
     * d3Selection.select('.css-selector')
     *     .datum(dataset)
     *     .call(stepChart);
     *
     */

    return function module() {

        var margin = {
            top: 20,
            right: 20,
            bottom: 30,
            left: 40
        },
            width = 960,
            height = 500,
            loadingState = line,
            ease = d3Ease.easeQuadInOut,
            data = void 0,
            chartWidth = void 0,
            chartHeight = void 0,
            xScale = void 0,
            yScale = void 0,
            yTicks = 6,
            xAxis = void 0,
            xAxisLabel = void 0,
            xAxisLabelEl = void 0,
            yAxis = void 0,
            yAxisLabel = void 0,
            yAxisLabelEl = void 0,
            xAxisLabelOffset = 80,
            yAxisLabelOffset = -20,
            xAxisPadding = {
            top: 0,
            left: 0,
            bottom: 0,
            right: 0
        },
            yTickPadding = 8,
            svg = void 0,
            valueLabel = 'value',
            nameLabel = 'key',
            maskGridLines = void 0,
            baseLine = void 0,


        // Dispatcher object to broadcast the mouse events
        // Ref: https://github.com/mbostock/d3/wiki/Internals#d3_dispatch
        dispatcher = d3Dispatch.dispatch('customMouseOver', 'customMouseOut', 'customMouseMove'),


        // Formats
        yAxisTickFormat = d3Format.format('.3'),


        // extractors
        getKey = function getKey(_ref) {
            var key = _ref.key;
            return key;
        },
            getValue = function getValue(_ref2) {
            var value = _ref2.value;
            return value;
        };

        /**
         * This function creates the graph using the selection as container
         * @param  {D3Selection} _selection A d3 selection that represents
         *                                  the container(s) where the chart(s) will be rendered
         * @param {StepChartData} _data The data to attach and generate the chart
         */
        function exports(_selection) {
            _selection.each(function (_data) {
                // Make space on the left of the graph for the y axis label
                chartWidth = width - margin.left - margin.right;
                chartHeight = height - margin.top - margin.bottom;
                data = cleanData(_data);

                buildScales();
                buildAxis();
                buildSVG(this);
                drawGridLines();
                drawSteps();
                drawAxis();
            });
        }

        /**
         * Creates the d3 x and y axis, setting orientations
         * @private
         */
        function buildAxis() {
            xAxis = d3Axis.axisBottom(xScale);

            yAxis = d3Axis.axisLeft(yScale).ticks(yTicks).tickPadding(yTickPadding).tickFormat(yAxisTickFormat);
        }

        /**
         * Builds containers for the chart, the axis and a wrapper for all of them
         * Also applies the Margin convention
         * @private
         */
        function buildContainerGroups() {
            var container = svg.append('g').classed('container-group', true).attr('transform', 'translate(' + margin.left + ', ' + margin.top + ')');

            container.append('g').classed('grid-lines-group', true);
            container.append('g').classed('chart-group', true);
            container.append('g').classed('x-axis-group axis', true).append('g').classed('x-axis-label', true);
            container.append('g').classed('y-axis-group axis', true).append('g').classed('y-axis-label', true);
            container.append('g').classed('metadata-group', true);
        }

        /**
         * Creates the x and y scales of the graph
         * @private
         */
        function buildScales() {
            xScale = d3Scale.scaleBand().domain(data.map(getKey)).rangeRound([0, chartWidth]).paddingInner(0);

            yScale = d3Scale.scaleLinear().domain([0, d3Array.max(data, getValue)]).rangeRound([chartHeight, 0]);
        }

        /**
         * Builds the SVG element that will contain the chart
         * @param  {HTMLElement} container DOM element that will work as the container of the graph
         * @private
         */
        function buildSVG(container) {
            if (!svg) {
                svg = d3Selection.select(container).append('svg').classed('britechart step-chart', true);

                buildContainerGroups();
            }

            svg.attr('width', width).attr('height', height);
        }

        /**
         * Cleaning data casting the values and keys to the proper type while keeping
         * the rest of properties on the data
         * @param  {StepChartData} originalData Data as provided on the container
         * @private
         */
        function cleanData(originalData) {
            return originalData.reduce(function (acc, d) {
                d.value = +d[valueLabel];
                d.key = String(d[nameLabel]);

                return [].concat(_toConsumableArray(acc), [d]);
            }, []);
        }

        /**
         * Draws the x and y axis on the svg object within their
         * respective groups
         * @private
         */
        function drawAxis() {
            svg.select('.x-axis-group.axis').attr('transform', 'translate(0, ' + chartHeight + ')').call(xAxis);

            svg.selectAll('.x-axis-group .tick text').style('text-anchor', 'start').attr('transform', 'rotate(45 -1 10)');

            if (xAxisLabel) {
                if (xAxisLabelEl) {
                    svg.selectAll('.x-axis-label-text').remove();
                }
                xAxisLabelEl = svg.select('.x-axis-label').append('text').attr('y', xAxisLabelOffset).attr('text-anchor', 'middle').classed('x-axis-label-text', true).attr('x', chartWidth / 2).text(xAxisLabel);
            }

            svg.select('.y-axis-group.axis').call(yAxis);

            if (yAxisLabel) {
                if (yAxisLabelEl) {
                    svg.selectAll('.y-axis-label-text').remove();
                }
                yAxisLabelEl = svg.select('.y-axis-label').append('text').classed('y-axis-label-text', true).attr('x', -chartHeight / 2).attr('y', yAxisLabelOffset).attr('text-anchor', 'middle').attr('transform', 'rotate(270 0 0)').text(yAxisLabel);
            }
        }

        /**
         * Draws the step elements within the chart group
         * @private
         */
        function drawSteps() {
            var steps = svg.select('.chart-group').selectAll('.step').data(data);

            // Enter
            steps.enter().append('rect').classed('step', true).attr('x', chartWidth) // Initially drawing the steps at the end of Y axis
            .attr('y', function (_ref3) {
                var value = _ref3.value;
                return yScale(value);
            }).attr('width', xScale.bandwidth()).attr('height', function (d) {
                return chartHeight - yScale(d.value);
            }).on('mouseover', function (d) {
                handleMouseOver(this, d, chartWidth, chartHeight);
            }).on('mousemove', function (d) {
                handleMouseMove(this, d, chartWidth, chartHeight);
            }).on('mouseout', function (d) {
                handleMouseOut(this, d, chartWidth, chartHeight);
            }).merge(steps).transition().ease(ease).attr('x', function (_ref4) {
                var key = _ref4.key;
                return xScale(key);
            }).attr('y', function (d) {
                return yScale(d.value);
            }).attr('width', xScale.bandwidth()).attr('height', function (d) {
                return chartHeight - yScale(d.value);
            });

            // Exit
            steps.exit().transition().style('opacity', 0).remove();
        }

        /**
         * Draws grid lines on the background of the chart
         * @return void
         */
        function drawGridLines() {
            if (maskGridLines) {
                svg.selectAll('.horizontal-grid-line').remove();
            }
            if (baseLine) {
                svg.selectAll('.extended-x-line').remove();
            }

            maskGridLines = svg.select('.grid-lines-group').selectAll('line.horizontal-grid-line').data(yScale.ticks(yTicks)).enter().append('line').attr('class', 'horizontal-grid-line').attr('x1', xAxisPadding.left).attr('x2', chartWidth).attr('y1', function (d) {
                return yScale(d);
            }).attr('y2', function (d) {
                return yScale(d);
            });

            if (baseLine) {
                svg.selectAll('.extended-x-line').remove();
            }

            //draw a horizontal line to extend x-axis till the edges
            baseLine = svg.select('.grid-lines-group').selectAll('line.extended-x-line').data([0]).enter().append('line').attr('class', 'extended-x-line').attr('x1', xAxisPadding.left).attr('x2', chartWidth).attr('y1', chartHeight).attr('y2', chartHeight);
        }

        // API

        /**
         * Custom OnMouseOver event handler
         * @return {void}
         * @private
         */
        function handleMouseOver(e, d, chartWidth, chartHeight) {
            dispatcher.call('customMouseOver', e, d, d3Selection.mouse(e), [chartWidth, chartHeight]);
        }

        /**
         * Custom OnMouseMove event handler
         * @return {void}
         * @private
         */
        function handleMouseMove(e, d, chartWidth, chartHeight) {
            dispatcher.call('customMouseMove', e, d, d3Selection.mouse(e), [chartWidth, chartHeight]);
        }

        /**
         * Custom OnMouseOver event handler
         * @return {void}
         * @private
         */
        function handleMouseOut(e, d, chartWidth, chartHeight) {
            dispatcher.call('customMouseOut', e, d, d3Selection.mouse(e), [chartWidth, chartHeight]);
        }

        /**
         * Chart exported to png and a download action is fired
         * @param {String} filename     File title for the resulting picture
         * @param {String} title        Title to add at the top of the exported picture
         * @public
         */
        exports.exportChart = function (filename) {
            exportChart.call(exports, svg, filename);
        };

        /**
         * Gets or Sets the margin of the chart
         * @param  {object} _x Margin object to get/set
         * @return { margin | module} Current margin or Chart module to chain calls
         * @public
         */
        exports.margin = function (_x) {
            if (!arguments.length) {
                return margin;
            }
            margin = _extends({}, margin, _x);
            return this;
        };

        /**
         * Gets or Sets the number of vertical ticks on the chart
         * (Default is 6)
         * @param  {Number} _x          Desired number of vertical ticks for the graph
         * @return {Number | module}    Current yTicks or Chart module to chain calls
         * @public
         */
        exports.yTicks = function (_x) {
            if (!arguments.length) {
                return yTicks;
            }
            yTicks = _x;
            return this;
        };

        /**
          * Gets or Sets the height of the chart
          * @param  {number} _x Desired width for the graph
          * @return { height | module} Current height or Chart module to chain calls
          * @public
          */
        exports.height = function (_x) {
            if (!arguments.length) {
                return height;
            }
            height = _x;
            return this;
        };

        /**
         * Gets or Sets the loading state of the chart
         * @param  {string} markup Desired markup to show when null data
         * @return { loadingState | module} Current loading state markup or Chart module to chain calls
         * @public
         */
        exports.loadingState = function (_markup) {
            if (!arguments.length) {
                return loadingState;
            }
            loadingState = _markup;

            return this;
        };

        /**
         * Exposes an 'on' method that acts as a bridge with the event dispatcher
         * We are going to expose this events:
         * customMouseOver, customMouseMove and customMouseOut
         *
         * @return {module} Bar Chart
         * @public
         */
        exports.on = function () {
            var value = dispatcher.on.apply(dispatcher, arguments);

            return value === dispatcher ? exports : value;
        };

        /**
         * Gets or Sets the width of the chart
         * @param  {number} _x Desired width for the graph
         * @return { width | module} Current width or Chart module to chain calls
         * @public
         */
        exports.width = function (_x) {
            if (!arguments.length) {
                return width;
            }
            width = _x;
            return this;
        };

        /**
         * Gets or Sets the text of the xAxisLabel on the chart
         * @param  {String} _x Desired text for the label
         * @return {String | module} label or Chart module to chain calls
         * @public
         */
        exports.xAxisLabel = function (_x) {
            if (!arguments.length) {
                return xAxisLabel;
            }
            xAxisLabel = _x;
            return this;
        };

        /**
         * Gets or Sets the offset of the xAxisLabel on the chart
         * @param  {Number} _x Desired offset for the label
         * @return {Number | module} label or Chart module to chain calls
         * @public
         */
        exports.xAxisLabelOffset = function (_x) {
            if (!arguments.length) {
                return xAxisLabelOffset;
            }
            xAxisLabelOffset = _x;
            return this;
        };

        /**
         * Gets or Sets the text of the yAxisLabel on the chart
         * @param  {String} _x Desired text for the label
         * @return {String | module} label or Chart module to chain calls
         * @public
         */
        exports.yAxisLabel = function (_x) {
            if (!arguments.length) {
                return yAxisLabel;
            }
            yAxisLabel = _x;
            return this;
        };

        /**
         * Gets or Sets the offset of the yAxisLabel on the chart
         * @param  {Number} _x Desired offset for the label
         * @return {Number | module} label or Chart module to chain calls
         * @public
         */
        exports.yAxisLabelOffset = function (_x) {
            if (!arguments.length) {
                return yAxisLabelOffset;
            }
            yAxisLabelOffset = _x;
            return this;
        };

        return exports;
    };
}.call(exports, __webpack_require__, exports, module),
				__WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));

/***/ }),
/* 301 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
var __WEBPACK_AMD_DEFINE_RESULT__;

var _extends = Object.assign || function (target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i]; for (var key in source) { if (Object.prototype.hasOwnProperty.call(source, key)) { target[key] = source[key]; } } } return target; };

function _toConsumableArray(arr) { if (Array.isArray(arr)) { for (var i = 0, arr2 = Array(arr.length); i < arr.length; i++) { arr2[i] = arr[i]; } return arr2; } else { return Array.from(arr); } }

!(__WEBPACK_AMD_DEFINE_RESULT__ = function (require) {
    'use strict';

    var d3Array = __webpack_require__(1);
    var d3Axis = __webpack_require__(17);
    var d3Brush = __webpack_require__(302);
    var d3Ease = __webpack_require__(4);
    var d3Scale = __webpack_require__(8);
    var d3Shape = __webpack_require__(21);
    var d3Dispatch = __webpack_require__(6);
    var d3Selection = __webpack_require__(0);
    var d3Time = __webpack_require__(25);
    var d3Transition = __webpack_require__(3);
    var d3TimeFormat = __webpack_require__(19);

    var colorHelper = __webpack_require__(5);
    var timeAxisHelper = __webpack_require__(65);

    var _require = __webpack_require__(20),
        axisTimeCombinations = _require.axisTimeCombinations,
        timeIntervals = _require.timeIntervals;

    var _require2 = __webpack_require__(23),
        uniqueId = _require2.uniqueId;

    var _require3 = __webpack_require__(13),
        line = _require3.line;

    /**
     * @typedef BrushChartData
     * @type {Object[]}
     * @property {Number} value        Value to chart (required)
     * @property {Date} date           Date of the value in ISO8601 format (required)
     *
     * @example
     * [
     *     {
     *         value: 1,
     *         date: '2011-01-06T00:00:00Z'
     *     },
     *     {
     *         value: 2,
     *         date: '2011-01-07T00:00:00Z'
     *     }
     * ]
     */

    /**
     * Brush Chart reusable API class that renders a
     * simple and configurable brush chart.
     *
     * @module Brush
     * @tutorial brush
     * @requires d3-array
     * @requires d3-axis
     * @requires d3-brush
     * @requires d3-ease
     * @requires d3-scale
     * @requires d3-shape
     * @requires d3-dispatch
     * @requires d3-selection
     * @requires d3-time
     * @requires d3-transition
     * @requires d3-time-format
     *
     * @example
     * let brushChart = brush();
     *
     * brushChart
     *     .height(500)
     *     .width(800);
     *
     * d3Selection.select('.css-selector')
     *     .datum(dataset)
     *     .call(brushChart);
     */

    return function module() {

        var margin = {
            top: 20,
            right: 20,
            bottom: 30,
            left: 20
        },
            width = 960,
            height = 500,
            loadingState = line,
            data = void 0,
            svg = void 0,
            ease = d3Ease.easeQuadOut,
            dateLabel = 'date',
            valueLabel = 'value',
            dateRange = [null, null],
            chartWidth = void 0,
            chartHeight = void 0,
            xScale = void 0,
            yScale = void 0,
            xAxis = void 0,
            xAxisFormat = null,
            xTicks = null,
            xAxisCustomFormat = null,
            locale = void 0,
            brush = void 0,
            chartBrush = void 0,
            brushArea = void 0,
            handle = void 0,
            tickPadding = 5,
            chartGradientEl = void 0,
            gradient = colorHelper.colorGradients.greenBlue,
            gradientId = uniqueId('brush-area-gradient'),
            roundingTimeInterval = 'timeDay',


        // Dispatcher object to broadcast the mouse events
        // @see {@link https://github.com/d3/d3/blob/master/API.md#dispatches-d3-dispatch}
        dispatcher = d3Dispatch.dispatch('customBrushStart', 'customBrushEnd'),


        // extractors
        getValue = function getValue(_ref) {
            var value = _ref.value;
            return value;
        },
            getDate = function getDate(_ref2) {
            var date = _ref2.date;
            return date;
        };

        /**
         * This function creates the graph using the selection as container
         * @param  {D3Selection} _selection A d3 selection that represents
         *                                  the container(s) where the chart(s) will be rendered
         * @param {BrushChartData} _data The data to attach and generate the chart
         */
        function exports(_selection) {
            _selection.each(function (_data) {
                chartWidth = width - margin.left - margin.right;
                chartHeight = height - margin.top - margin.bottom;
                data = cleanData(cloneData(_data));

                buildScales();
                buildAxis();
                buildSVG(this);
                buildGradient();
                buildBrush();
                drawArea();
                drawAxis();
                drawBrush();
                drawHandles();
            });
        }

        /**
         * Creates the d3 x axis, setting orientation
         * @private
         */
        function buildAxis() {
            var minor = void 0,
                major = void 0;

            if (xAxisFormat === 'custom' && typeof xAxisCustomFormat === 'string') {
                minor = {
                    tick: xTicks,
                    format: d3TimeFormat.timeFormat(xAxisCustomFormat)
                };
            } else {
                var _timeAxisHelper$getTi = timeAxisHelper.getTimeSeriesAxis(data, width, xAxisFormat);

                minor = _timeAxisHelper$getTi.minor;
                major = _timeAxisHelper$getTi.major;
            }

            xAxis = d3Axis.axisBottom(xScale).ticks(minor.tick).tickSize(10, 0).tickPadding([tickPadding]).tickFormat(minor.format);
        }

        /**
         * Creates the brush element and attaches a listener
         * @return {void}
         */
        function buildBrush() {
            brush = d3Brush.brushX().extent([[0, 0], [chartWidth, chartHeight]]).on('brush', handleBrushStart).on('end', handleBrushEnd);
        }

        /**
         * Builds containers for the chart, the axis and a wrapper for all of them
         * Also applies the Margin convention
         * @private
         */
        function buildContainerGroups() {
            var container = svg.append('g').classed('container-group', true).attr('transform', 'translate(' + margin.left + ', ' + margin.top + ')');

            container.append('g').classed('chart-group', true);
            container.append('g').classed('x-axis-group', true).append('g').classed('x axis', true);
            container.append('g').classed('brush-group', true);
            container.append('g').classed('metadata-group', true);
        }

        /**
         * Creates the gradient on the area
         * @return {void}
         */
        function buildGradient() {
            if (!chartGradientEl) {
                chartGradientEl = svg.select('.metadata-group').append('linearGradient').attr('id', gradientId).attr('gradientUnits', 'userSpaceOnUse').attr('x1', 0).attr('x2', xScale(data[data.length - 1].date)).attr('y1', 0).attr('y2', 0).selectAll('stop').data([{ offset: '0%', color: gradient[0] }, { offset: '100%', color: gradient[1] }]).enter().append('stop').attr('offset', function (_ref3) {
                    var offset = _ref3.offset;
                    return offset;
                }).attr('stop-color', function (_ref4) {
                    var color = _ref4.color;
                    return color;
                });
            }
        }

        /**
         * Creates the x and y scales of the graph
         * @private
         */
        function buildScales() {
            xScale = d3Scale.scaleTime().domain(d3Array.extent(data, getDate)).range([0, chartWidth]);

            yScale = d3Scale.scaleLinear().domain([0, d3Array.max(data, getValue)]).range([chartHeight, 0]);
        }

        /**
         * Builds the SVG element that will contain the chart
         * @param  {HTMLElement} container DOM element that will work as the container of the graph
         * @private
         */
        function buildSVG(container) {
            if (!svg) {
                svg = d3Selection.select(container).append('svg').classed('britechart brush-chart', true);

                buildContainerGroups();
            }

            svg.attr('width', width).attr('height', height);
        }

        /**
         * Cleaning data casting the values and dates to the proper type while keeping
         * the rest of properties on the data
         * @param  {BrushChartData} originalData        Raw data from the container
         * @return {BrushChartData}                     Clean data
         * @private
         */
        function cleanData(originalData) {
            return originalData.reduce(function (acc, d) {
                d.date = new Date(d[dateLabel]);
                d.value = +d[valueLabel];

                return [].concat(_toConsumableArray(acc), [d]);
            }, []);
        }

        /**
         * Clones the passed array of data
         * @param  {Object[]} dataToClone Data to clone
         * @return {Object[]}             Cloned data
         */
        function cloneData(dataToClone) {
            return JSON.parse(JSON.stringify(dataToClone));
        }

        /**
         * Draws the x axis on the svg object within its group
         *
         * @private
         */
        function drawAxis() {
            svg.select('.x-axis-group .axis.x').attr('transform', 'translate(0, ' + chartHeight + ')').call(xAxis);
        }

        /**
         * Draws the area that is going to represent the data
         *
         * @return {void}
         */
        function drawArea() {
            if (brushArea) {
                svg.selectAll('.brush-area').remove();
            }

            // Create and configure the area generator
            brushArea = d3Shape.area().x(function (_ref5) {
                var date = _ref5.date;
                return xScale(date);
            }).y0(chartHeight).y1(function (_ref6) {
                var value = _ref6.value;
                return yScale(value);
            }).curve(d3Shape.curveBasis);

            // Create the area path
            svg.select('.chart-group').append('path').datum(data).attr('class', 'brush-area').attr('d', brushArea);
        }

        /**
         * Draws the Brush components on its group
         * @return {void}
         */
        function drawBrush() {
            chartBrush = svg.select('.brush-group').call(brush);

            // Update the height of the brushing rectangle
            chartBrush.selectAll('rect').classed('brush-rect', true).attr('height', chartHeight);

            chartBrush.selectAll('.selection').attr('fill', 'url(#' + gradientId + ')');
        }

        /**
         * Draws a handle for the Brush section
         * @return {void}
         */
        function drawHandles() {
            var handleFillColor = colorHelper.colorSchemasHuman.grey[1];

            // Styling
            handle = chartBrush.selectAll('.handle.brush-rect').style('fill', handleFillColor);
        }

        /**
         * When a brush event starts, we can extract info from the extension
         * of the brush.
         *
         * @return {void}
         */
        function handleBrushStart() {
            var selection = d3Selection.event.selection;

            if (!selection) {
                return;
            }

            dispatcher.call('customBrushStart', this, selection.map(xScale.invert));
        }

        /**
         * Processes the end brush event, snapping the boundaries to days
         * as showed on the example on https://bl.ocks.org/mbostock/6232537
         * @return {void}
         * @private
         */
        function handleBrushEnd() {
            if (!d3Selection.event.sourceEvent) {
                return; // Only transition after input.
            }

            var dateExtentRounded = [null, null];
            var selection = d3Selection.event.selection;

            if (selection) {
                var dateExtent = selection.map(xScale.invert);

                dateExtentRounded = dateExtent.map(timeIntervals[roundingTimeInterval].round);

                // If empty when rounded, use floor & ceil instead.
                if (dateExtentRounded[0] >= dateExtentRounded[1]) {
                    dateExtentRounded[0] = timeIntervals[roundingTimeInterval].floor(dateExtent[0]);
                    dateExtentRounded[1] = timeIntervals[roundingTimeInterval].offset(dateExtentRounded[0]);
                }

                d3Selection.select(this).transition().call(d3Selection.event.target.move, dateExtentRounded.map(xScale));
            }

            dispatcher.call('customBrushEnd', this, dateExtentRounded);
        }

        /**
         * Sets a new brush extent within the passed dates
         * @param {String | Date} dateA Initial Date
         * @param {String | Date} dateB End Date
         */
        function setBrushByDates(dateA, dateB) {
            var selection = null;

            if (dateA !== null) {
                selection = [xScale(new Date(dateA)), xScale(new Date(dateB))];
            }

            brush.move(chartBrush, selection);
        }

        // API

        /**
         * Exposes the constants to be used to force the x axis to respect a certain granularity
         * current options: MINUTE_HOUR, HOUR_DAY, DAY_MONTH, MONTH_YEAR
         * @example
         *     brush.xAxisCustomFormat(brush.axisTimeCombinations.HOUR_DAY)
         */
        exports.axisTimeCombinations = axisTimeCombinations;

        /**
         * Gets or Sets the dateRange for the selected part of the brush
         * @param  {String[]} _x            Desired dateRange for the graph
         * @return { dateRange | module}    Current dateRange or Chart module to chain calls
         * @public
         */
        exports.dateRange = function (_x) {
            if (!arguments.length) {
                return dateRange;
            }
            dateRange = _x;

            if (Array.isArray(dateRange)) {
                setBrushByDates.apply(undefined, _toConsumableArray(dateRange));
            }

            return this;
        };

        /**
         * Gets or Sets the gradient of the chart
         * @param  {String[]} [_x=colorHelper.colorGradients.greenBlue]    Desired gradient for the graph
         * @return {String | Module}    Current gradient or Chart module to chain calls
         * @public
         */
        exports.gradient = function (_x) {
            if (!arguments.length) {
                return gradient;
            }
            gradient = _x;

            return this;
        };

        /**
         * Gets or Sets the height of the chart
         * @param  {Number} _x          Desired width for the graph
         * @return {Number | Module}    Current height or Chart module to chain calls
         * @public
         */
        exports.height = function (_x) {
            if (!arguments.length) {
                return height;
            }
            height = _x;

            return this;
        };

        /**
         * Gets or Sets the loading state of the chart
         * @param  {string} markup              Desired markup to show when null data
         * @return { loadingState | module}     Current loading state markup or Chart module to chain calls
         * @public
         */
        exports.loadingState = function (_markup) {
            if (!arguments.length) {
                return loadingState;
            }
            loadingState = _markup;

            return this;
        };

        /**
         * Pass language tag for the tooltip to localize the date.
         * Feature uses Intl.DateTimeFormat, for compatability and support, refer to
         * https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/DateTimeFormat
         * @param  {String} _x              Must be a language tag (BCP 47) like 'en-US' or 'fr-FR'
         * @return { (String|Module) }      Current locale or module to chain calls
         */
        exports.locale = function (_x) {
            if (!arguments.length) {
                return locale;
            }
            locale = _x;

            return this;
        };

        /**
         * Gets or Sets the margin of the chart
         * @param  {Object} _x          Margin object to get/set
         * @return {Object | Module}    Current margin or Chart module to chain calls
         * @public
         */
        exports.margin = function (_x) {
            if (!arguments.length) {
                return margin;
            }
            margin = _extends({}, margin, _x);

            return this;
        };

        /**
         * Date range
         * @typedef DateExtent
         * @type {Date[]}
         * @property {Date} 0 Lower bound date selection
         * @property {Date} 1 Upper bound date selection
         * @see {@link https://github.com/d3/d3-brush#brushSelection|d3-brush:brushSelection}
         */

        /**
         * Event indicating when the brush moves
         * @event customBrushStart
         * @type {module:Brush~DateExtent}
         * @see {@link https://github.com/d3/d3-brush#brush_on|d3-brush:on(brush)}
         */

        /**
         * Event indicating the end of a brush gesture
         * @event customBrushEnd
         * @type {module:Brush~DateExtent}
         * @see {@link https://github.com/d3/d3-brush#brush_on|d3-brush:on(end)}
         */

        /**
         * @callback eventCallback
         * @param {module:Brush~DateExtent} dateExtent Date range
         */

        /**
         * Adds, removes, or gets the callback for the specified typenames.
         * @param {String} typenames One or more event type names, delimited by a space
         * @param {module:Brush~eventCallback} [callback] Callback to register
         * @return {module:Brush}
         * @listens customBrushStart
         * @listens customBrushEnd
         * @see {@link https://github.com/d3/d3-dispatch/blob/master/README.md#dispatch_on|d3-dispatch:on}
         * @public
         */
        exports.on = function () {
            var value = dispatcher.on.apply(dispatcher, arguments);

            return value === dispatcher ? exports : value;
        };

        /**
         * Gets or Sets the width of the chart
         * @param  {Number} _x          Desired width for the graph
         * @return {Number | Module}    Current width or Chart module to chain calls
         * @public
         */
        exports.width = function (_x) {
            if (!arguments.length) {
                return width;
            }
            width = _x;

            return this;
        };

        /**
         * Exposes the ability to force the chart to show a certain x format
         * It requires a `xAxisFormat` of 'custom' in order to work.
         * @param  {String} _x              Desired format for x axis
         * @return {String | Module}        Current format or module to chain calls
         */
        exports.xAxisCustomFormat = function (_x) {
            if (!arguments.length) {
                return xAxisCustomFormat;
            }
            xAxisCustomFormat = _x;

            return this;
        };

        /**
         * Exposes the ability to force the chart to show a certain x axis grouping
         * @param  {String} _x          Desired format
         * @return {String | Module}    Current format or module to chain calls
         * @example
         *     brush.xAxisFormat(brush.axisTimeCombinations.HOUR_DAY)
         */
        exports.xAxisFormat = function (_x) {
            if (!arguments.length) {
                return xAxisFormat;
            }
            xAxisFormat = _x;

            return this;
        };

        /**
         * Exposes the ability to force the chart to show a certain x ticks. It requires a `xAxisCustomFormat` of 'custom' in order to work.
         * NOTE: This value needs to be a multiple of 2, 5 or 10. They won't always work as expected, as D3 decides at the end
         * how many and where the ticks will appear.
         *
         * @param  {Number} _x              Desired number of x axis ticks (multiple of 2, 5 or 10)
         * @return {Number | Module}        Current number or ticks or module to chain calls
         */
        exports.xTicks = function (_x) {
            if (!arguments.length) {
                return xTicks;
            }
            xTicks = _x;

            return this;
        };

        /**
         * Gets or Sets the rounding time interval of the selection boundary
         * @param  {roundingTimeInterval} _x Desired time interval for the selection, default 'timeDay'. All options are:
         * timeMillisecond, utcMillisecond, timeSecond, utcSecond, timeMinute, utcMinute, timeHour, utcHour, timeDay, utcDay
         * timeWeek, utcWeek, timeSunday, utcSunday, timeMonday, utcMonday, timeTuesday, utcTuesday, timeWednesday,
         * utcWednesday, timeThursday, utcThursday, timeFriday, utcFriday, timeSaturday, utcSaturday, timeMonth, utcMonth,
         * timeYear and utcYear. Visit https://github.com/d3/d3-time#intervals for more information.
         * @return { (roundingTimeInterval | Module) } Current time interval or module to chain calls
         * @public
         */
        exports.roundingTimeInterval = function (_x) {
            if (!arguments.length) {
                return roundingTimeInterval;
            }
            roundingTimeInterval = _x;

            return this;
        };

        return exports;
    };
}.call(exports, __webpack_require__, exports, module),
				__WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));

/***/ }),
/* 302 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__src_brush__ = __webpack_require__(303);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "brush", function() { return __WEBPACK_IMPORTED_MODULE_0__src_brush__["d"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "brushX", function() { return __WEBPACK_IMPORTED_MODULE_0__src_brush__["b"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "brushY", function() { return __WEBPACK_IMPORTED_MODULE_0__src_brush__["c"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "brushSelection", function() { return __WEBPACK_IMPORTED_MODULE_0__src_brush__["a"]; });



/***/ }),
/* 303 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (immutable) */ __webpack_exports__["a"] = brushSelection;
/* harmony export (immutable) */ __webpack_exports__["b"] = brushX;
/* harmony export (immutable) */ __webpack_exports__["c"] = brushY;
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_d3_dispatch__ = __webpack_require__(6);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_d3_drag__ = __webpack_require__(304);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2_d3_interpolate__ = __webpack_require__(9);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3_d3_selection__ = __webpack_require__(0);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4_d3_transition__ = __webpack_require__(3);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5__constant__ = __webpack_require__(308);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_6__event__ = __webpack_require__(309);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_7__noevent__ = __webpack_require__(310);









var MODE_DRAG = {name: "drag"},
    MODE_SPACE = {name: "space"},
    MODE_HANDLE = {name: "handle"},
    MODE_CENTER = {name: "center"};

var X = {
  name: "x",
  handles: ["e", "w"].map(type),
  input: function(x, e) { return x && [[x[0], e[0][1]], [x[1], e[1][1]]]; },
  output: function(xy) { return xy && [xy[0][0], xy[1][0]]; }
};

var Y = {
  name: "y",
  handles: ["n", "s"].map(type),
  input: function(y, e) { return y && [[e[0][0], y[0]], [e[1][0], y[1]]]; },
  output: function(xy) { return xy && [xy[0][1], xy[1][1]]; }
};

var XY = {
  name: "xy",
  handles: ["n", "e", "s", "w", "nw", "ne", "se", "sw"].map(type),
  input: function(xy) { return xy; },
  output: function(xy) { return xy; }
};

var cursors = {
  overlay: "crosshair",
  selection: "move",
  n: "ns-resize",
  e: "ew-resize",
  s: "ns-resize",
  w: "ew-resize",
  nw: "nwse-resize",
  ne: "nesw-resize",
  se: "nwse-resize",
  sw: "nesw-resize"
};

var flipX = {
  e: "w",
  w: "e",
  nw: "ne",
  ne: "nw",
  se: "sw",
  sw: "se"
};

var flipY = {
  n: "s",
  s: "n",
  nw: "sw",
  ne: "se",
  se: "ne",
  sw: "nw"
};

var signsX = {
  overlay: +1,
  selection: +1,
  n: null,
  e: +1,
  s: null,
  w: -1,
  nw: -1,
  ne: +1,
  se: +1,
  sw: -1
};

var signsY = {
  overlay: +1,
  selection: +1,
  n: -1,
  e: null,
  s: +1,
  w: null,
  nw: -1,
  ne: -1,
  se: +1,
  sw: +1
};

function type(t) {
  return {type: t};
}

// Ignore right-click, since that should open the context menu.
function defaultFilter() {
  return !__WEBPACK_IMPORTED_MODULE_3_d3_selection__["event"].button;
}

function defaultExtent() {
  var svg = this.ownerSVGElement || this;
  return [[0, 0], [svg.width.baseVal.value, svg.height.baseVal.value]];
}

// Like d3.local, but with the name “__brush” rather than auto-generated.
function local(node) {
  while (!node.__brush) if (!(node = node.parentNode)) return;
  return node.__brush;
}

function empty(extent) {
  return extent[0][0] === extent[1][0]
      || extent[0][1] === extent[1][1];
}

function brushSelection(node) {
  var state = node.__brush;
  return state ? state.dim.output(state.selection) : null;
}

function brushX() {
  return brush(X);
}

function brushY() {
  return brush(Y);
}

/* harmony default export */ __webpack_exports__["d"] = (function() {
  return brush(XY);
});

function brush(dim) {
  var extent = defaultExtent,
      filter = defaultFilter,
      listeners = Object(__WEBPACK_IMPORTED_MODULE_0_d3_dispatch__["dispatch"])(brush, "start", "brush", "end"),
      handleSize = 6,
      touchending;

  function brush(group) {
    var overlay = group
        .property("__brush", initialize)
      .selectAll(".overlay")
      .data([type("overlay")]);

    overlay.enter().append("rect")
        .attr("class", "overlay")
        .attr("pointer-events", "all")
        .attr("cursor", cursors.overlay)
      .merge(overlay)
        .each(function() {
          var extent = local(this).extent;
          Object(__WEBPACK_IMPORTED_MODULE_3_d3_selection__["select"])(this)
              .attr("x", extent[0][0])
              .attr("y", extent[0][1])
              .attr("width", extent[1][0] - extent[0][0])
              .attr("height", extent[1][1] - extent[0][1]);
        });

    group.selectAll(".selection")
      .data([type("selection")])
      .enter().append("rect")
        .attr("class", "selection")
        .attr("cursor", cursors.selection)
        .attr("fill", "#777")
        .attr("fill-opacity", 0.3)
        .attr("stroke", "#fff")
        .attr("shape-rendering", "crispEdges");

    var handle = group.selectAll(".handle")
      .data(dim.handles, function(d) { return d.type; });

    handle.exit().remove();

    handle.enter().append("rect")
        .attr("class", function(d) { return "handle handle--" + d.type; })
        .attr("cursor", function(d) { return cursors[d.type]; });

    group
        .each(redraw)
        .attr("fill", "none")
        .attr("pointer-events", "all")
        .style("-webkit-tap-highlight-color", "rgba(0,0,0,0)")
        .on("mousedown.brush touchstart.brush", started);
  }

  brush.move = function(group, selection) {
    if (group.selection) {
      group
          .on("start.brush", function() { emitter(this, arguments).beforestart().start(); })
          .on("interrupt.brush end.brush", function() { emitter(this, arguments).end(); })
          .tween("brush", function() {
            var that = this,
                state = that.__brush,
                emit = emitter(that, arguments),
                selection0 = state.selection,
                selection1 = dim.input(typeof selection === "function" ? selection.apply(this, arguments) : selection, state.extent),
                i = Object(__WEBPACK_IMPORTED_MODULE_2_d3_interpolate__["interpolate"])(selection0, selection1);

            function tween(t) {
              state.selection = t === 1 && empty(selection1) ? null : i(t);
              redraw.call(that);
              emit.brush();
            }

            return selection0 && selection1 ? tween : tween(1);
          });
    } else {
      group
          .each(function() {
            var that = this,
                args = arguments,
                state = that.__brush,
                selection1 = dim.input(typeof selection === "function" ? selection.apply(that, args) : selection, state.extent),
                emit = emitter(that, args).beforestart();

            Object(__WEBPACK_IMPORTED_MODULE_4_d3_transition__["interrupt"])(that);
            state.selection = selection1 == null || empty(selection1) ? null : selection1;
            redraw.call(that);
            emit.start().brush().end();
          });
    }
  };

  function redraw() {
    var group = Object(__WEBPACK_IMPORTED_MODULE_3_d3_selection__["select"])(this),
        selection = local(this).selection;

    if (selection) {
      group.selectAll(".selection")
          .style("display", null)
          .attr("x", selection[0][0])
          .attr("y", selection[0][1])
          .attr("width", selection[1][0] - selection[0][0])
          .attr("height", selection[1][1] - selection[0][1]);

      group.selectAll(".handle")
          .style("display", null)
          .attr("x", function(d) { return d.type[d.type.length - 1] === "e" ? selection[1][0] - handleSize / 2 : selection[0][0] - handleSize / 2; })
          .attr("y", function(d) { return d.type[0] === "s" ? selection[1][1] - handleSize / 2 : selection[0][1] - handleSize / 2; })
          .attr("width", function(d) { return d.type === "n" || d.type === "s" ? selection[1][0] - selection[0][0] + handleSize : handleSize; })
          .attr("height", function(d) { return d.type === "e" || d.type === "w" ? selection[1][1] - selection[0][1] + handleSize : handleSize; });
    }

    else {
      group.selectAll(".selection,.handle")
          .style("display", "none")
          .attr("x", null)
          .attr("y", null)
          .attr("width", null)
          .attr("height", null);
    }
  }

  function emitter(that, args) {
    return that.__brush.emitter || new Emitter(that, args);
  }

  function Emitter(that, args) {
    this.that = that;
    this.args = args;
    this.state = that.__brush;
    this.active = 0;
  }

  Emitter.prototype = {
    beforestart: function() {
      if (++this.active === 1) this.state.emitter = this, this.starting = true;
      return this;
    },
    start: function() {
      if (this.starting) this.starting = false, this.emit("start");
      return this;
    },
    brush: function() {
      this.emit("brush");
      return this;
    },
    end: function() {
      if (--this.active === 0) delete this.state.emitter, this.emit("end");
      return this;
    },
    emit: function(type) {
      Object(__WEBPACK_IMPORTED_MODULE_3_d3_selection__["customEvent"])(new __WEBPACK_IMPORTED_MODULE_6__event__["a" /* default */](brush, type, dim.output(this.state.selection)), listeners.apply, listeners, [type, this.that, this.args]);
    }
  };

  function started() {
    if (__WEBPACK_IMPORTED_MODULE_3_d3_selection__["event"].touches) { if (__WEBPACK_IMPORTED_MODULE_3_d3_selection__["event"].changedTouches.length < __WEBPACK_IMPORTED_MODULE_3_d3_selection__["event"].touches.length) return Object(__WEBPACK_IMPORTED_MODULE_7__noevent__["a" /* default */])(); }
    else if (touchending) return;
    if (!filter.apply(this, arguments)) return;

    var that = this,
        type = __WEBPACK_IMPORTED_MODULE_3_d3_selection__["event"].target.__data__.type,
        mode = (__WEBPACK_IMPORTED_MODULE_3_d3_selection__["event"].metaKey ? type = "overlay" : type) === "selection" ? MODE_DRAG : (__WEBPACK_IMPORTED_MODULE_3_d3_selection__["event"].altKey ? MODE_CENTER : MODE_HANDLE),
        signX = dim === Y ? null : signsX[type],
        signY = dim === X ? null : signsY[type],
        state = local(that),
        extent = state.extent,
        selection = state.selection,
        W = extent[0][0], w0, w1,
        N = extent[0][1], n0, n1,
        E = extent[1][0], e0, e1,
        S = extent[1][1], s0, s1,
        dx,
        dy,
        moving,
        shifting = signX && signY && __WEBPACK_IMPORTED_MODULE_3_d3_selection__["event"].shiftKey,
        lockX,
        lockY,
        point0 = Object(__WEBPACK_IMPORTED_MODULE_3_d3_selection__["mouse"])(that),
        point = point0,
        emit = emitter(that, arguments).beforestart();

    if (type === "overlay") {
      state.selection = selection = [
        [w0 = dim === Y ? W : point0[0], n0 = dim === X ? N : point0[1]],
        [e0 = dim === Y ? E : w0, s0 = dim === X ? S : n0]
      ];
    } else {
      w0 = selection[0][0];
      n0 = selection[0][1];
      e0 = selection[1][0];
      s0 = selection[1][1];
    }

    w1 = w0;
    n1 = n0;
    e1 = e0;
    s1 = s0;

    var group = Object(__WEBPACK_IMPORTED_MODULE_3_d3_selection__["select"])(that)
        .attr("pointer-events", "none");

    var overlay = group.selectAll(".overlay")
        .attr("cursor", cursors[type]);

    if (__WEBPACK_IMPORTED_MODULE_3_d3_selection__["event"].touches) {
      group
          .on("touchmove.brush", moved, true)
          .on("touchend.brush touchcancel.brush", ended, true);
    } else {
      var view = Object(__WEBPACK_IMPORTED_MODULE_3_d3_selection__["select"])(__WEBPACK_IMPORTED_MODULE_3_d3_selection__["event"].view)
          .on("keydown.brush", keydowned, true)
          .on("keyup.brush", keyupped, true)
          .on("mousemove.brush", moved, true)
          .on("mouseup.brush", ended, true);

      Object(__WEBPACK_IMPORTED_MODULE_1_d3_drag__["a" /* dragDisable */])(__WEBPACK_IMPORTED_MODULE_3_d3_selection__["event"].view);
    }

    Object(__WEBPACK_IMPORTED_MODULE_7__noevent__["b" /* nopropagation */])();
    Object(__WEBPACK_IMPORTED_MODULE_4_d3_transition__["interrupt"])(that);
    redraw.call(that);
    emit.start();

    function moved() {
      var point1 = Object(__WEBPACK_IMPORTED_MODULE_3_d3_selection__["mouse"])(that);
      if (shifting && !lockX && !lockY) {
        if (Math.abs(point1[0] - point[0]) > Math.abs(point1[1] - point[1])) lockY = true;
        else lockX = true;
      }
      point = point1;
      moving = true;
      Object(__WEBPACK_IMPORTED_MODULE_7__noevent__["a" /* default */])();
      move();
    }

    function move() {
      var t;

      dx = point[0] - point0[0];
      dy = point[1] - point0[1];

      switch (mode) {
        case MODE_SPACE:
        case MODE_DRAG: {
          if (signX) dx = Math.max(W - w0, Math.min(E - e0, dx)), w1 = w0 + dx, e1 = e0 + dx;
          if (signY) dy = Math.max(N - n0, Math.min(S - s0, dy)), n1 = n0 + dy, s1 = s0 + dy;
          break;
        }
        case MODE_HANDLE: {
          if (signX < 0) dx = Math.max(W - w0, Math.min(E - w0, dx)), w1 = w0 + dx, e1 = e0;
          else if (signX > 0) dx = Math.max(W - e0, Math.min(E - e0, dx)), w1 = w0, e1 = e0 + dx;
          if (signY < 0) dy = Math.max(N - n0, Math.min(S - n0, dy)), n1 = n0 + dy, s1 = s0;
          else if (signY > 0) dy = Math.max(N - s0, Math.min(S - s0, dy)), n1 = n0, s1 = s0 + dy;
          break;
        }
        case MODE_CENTER: {
          if (signX) w1 = Math.max(W, Math.min(E, w0 - dx * signX)), e1 = Math.max(W, Math.min(E, e0 + dx * signX));
          if (signY) n1 = Math.max(N, Math.min(S, n0 - dy * signY)), s1 = Math.max(N, Math.min(S, s0 + dy * signY));
          break;
        }
      }

      if (e1 < w1) {
        signX *= -1;
        t = w0, w0 = e0, e0 = t;
        t = w1, w1 = e1, e1 = t;
        if (type in flipX) overlay.attr("cursor", cursors[type = flipX[type]]);
      }

      if (s1 < n1) {
        signY *= -1;
        t = n0, n0 = s0, s0 = t;
        t = n1, n1 = s1, s1 = t;
        if (type in flipY) overlay.attr("cursor", cursors[type = flipY[type]]);
      }

      if (state.selection) selection = state.selection; // May be set by brush.move!
      if (lockX) w1 = selection[0][0], e1 = selection[1][0];
      if (lockY) n1 = selection[0][1], s1 = selection[1][1];

      if (selection[0][0] !== w1
          || selection[0][1] !== n1
          || selection[1][0] !== e1
          || selection[1][1] !== s1) {
        state.selection = [[w1, n1], [e1, s1]];
        redraw.call(that);
        emit.brush();
      }
    }

    function ended() {
      Object(__WEBPACK_IMPORTED_MODULE_7__noevent__["b" /* nopropagation */])();
      if (__WEBPACK_IMPORTED_MODULE_3_d3_selection__["event"].touches) {
        if (__WEBPACK_IMPORTED_MODULE_3_d3_selection__["event"].touches.length) return;
        if (touchending) clearTimeout(touchending);
        touchending = setTimeout(function() { touchending = null; }, 500); // Ghost clicks are delayed!
        group.on("touchmove.brush touchend.brush touchcancel.brush", null);
      } else {
        Object(__WEBPACK_IMPORTED_MODULE_1_d3_drag__["b" /* dragEnable */])(__WEBPACK_IMPORTED_MODULE_3_d3_selection__["event"].view, moving);
        view.on("keydown.brush keyup.brush mousemove.brush mouseup.brush", null);
      }
      group.attr("pointer-events", "all");
      overlay.attr("cursor", cursors.overlay);
      if (state.selection) selection = state.selection; // May be set by brush.move (on start)!
      if (empty(selection)) state.selection = null, redraw.call(that);
      emit.end();
    }

    function keydowned() {
      switch (__WEBPACK_IMPORTED_MODULE_3_d3_selection__["event"].keyCode) {
        case 16: { // SHIFT
          shifting = signX && signY;
          break;
        }
        case 18: { // ALT
          if (mode === MODE_HANDLE) {
            if (signX) e0 = e1 - dx * signX, w0 = w1 + dx * signX;
            if (signY) s0 = s1 - dy * signY, n0 = n1 + dy * signY;
            mode = MODE_CENTER;
            move();
          }
          break;
        }
        case 32: { // SPACE; takes priority over ALT
          if (mode === MODE_HANDLE || mode === MODE_CENTER) {
            if (signX < 0) e0 = e1 - dx; else if (signX > 0) w0 = w1 - dx;
            if (signY < 0) s0 = s1 - dy; else if (signY > 0) n0 = n1 - dy;
            mode = MODE_SPACE;
            overlay.attr("cursor", cursors.selection);
            move();
          }
          break;
        }
        default: return;
      }
      Object(__WEBPACK_IMPORTED_MODULE_7__noevent__["a" /* default */])();
    }

    function keyupped() {
      switch (__WEBPACK_IMPORTED_MODULE_3_d3_selection__["event"].keyCode) {
        case 16: { // SHIFT
          if (shifting) {
            lockX = lockY = shifting = false;
            move();
          }
          break;
        }
        case 18: { // ALT
          if (mode === MODE_CENTER) {
            if (signX < 0) e0 = e1; else if (signX > 0) w0 = w1;
            if (signY < 0) s0 = s1; else if (signY > 0) n0 = n1;
            mode = MODE_HANDLE;
            move();
          }
          break;
        }
        case 32: { // SPACE
          if (mode === MODE_SPACE) {
            if (__WEBPACK_IMPORTED_MODULE_3_d3_selection__["event"].altKey) {
              if (signX) e0 = e1 - dx * signX, w0 = w1 + dx * signX;
              if (signY) s0 = s1 - dy * signY, n0 = n1 + dy * signY;
              mode = MODE_CENTER;
            } else {
              if (signX < 0) e0 = e1; else if (signX > 0) w0 = w1;
              if (signY < 0) s0 = s1; else if (signY > 0) n0 = n1;
              mode = MODE_HANDLE;
            }
            overlay.attr("cursor", cursors[type]);
            move();
          }
          break;
        }
        default: return;
      }
      Object(__WEBPACK_IMPORTED_MODULE_7__noevent__["a" /* default */])();
    }
  }

  function initialize() {
    var state = this.__brush || {selection: null};
    state.extent = extent.apply(this, arguments);
    state.dim = dim;
    return state;
  }

  brush.extent = function(_) {
    return arguments.length ? (extent = typeof _ === "function" ? _ : Object(__WEBPACK_IMPORTED_MODULE_5__constant__["a" /* default */])([[+_[0][0], +_[0][1]], [+_[1][0], +_[1][1]]]), brush) : extent;
  };

  brush.filter = function(_) {
    return arguments.length ? (filter = typeof _ === "function" ? _ : Object(__WEBPACK_IMPORTED_MODULE_5__constant__["a" /* default */])(!!_), brush) : filter;
  };

  brush.handleSize = function(_) {
    return arguments.length ? (handleSize = +_, brush) : handleSize;
  };

  brush.on = function() {
    var value = listeners.on.apply(listeners, arguments);
    return value === listeners ? brush : value;
  };

  return brush;
}


/***/ }),
/* 304 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__src_drag__ = __webpack_require__(305);
/* unused harmony reexport drag */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__src_nodrag__ = __webpack_require__(121);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return __WEBPACK_IMPORTED_MODULE_1__src_nodrag__["a"]; });
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "b", function() { return __WEBPACK_IMPORTED_MODULE_1__src_nodrag__["b"]; });




/***/ }),
/* 305 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_d3_dispatch__ = __webpack_require__(6);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_d3_selection__ = __webpack_require__(0);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__nodrag__ = __webpack_require__(121);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__noevent__ = __webpack_require__(122);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__constant__ = __webpack_require__(306);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5__event__ = __webpack_require__(307);







// Ignore right-click, since that should open the context menu.
function defaultFilter() {
  return !__WEBPACK_IMPORTED_MODULE_1_d3_selection__["event"].button;
}

function defaultContainer() {
  return this.parentNode;
}

function defaultSubject(d) {
  return d == null ? {x: __WEBPACK_IMPORTED_MODULE_1_d3_selection__["event"].x, y: __WEBPACK_IMPORTED_MODULE_1_d3_selection__["event"].y} : d;
}

function touchable() {
  return "ontouchstart" in this;
}

/* unused harmony default export */ var _unused_webpack_default_export = (function() {
  var filter = defaultFilter,
      container = defaultContainer,
      subject = defaultSubject,
      gestures = {},
      listeners = Object(__WEBPACK_IMPORTED_MODULE_0_d3_dispatch__["dispatch"])("start", "drag", "end"),
      active = 0,
      mousedownx,
      mousedowny,
      mousemoving,
      touchending,
      clickDistance2 = 0;

  function drag(selection) {
    selection
        .on("mousedown.drag", mousedowned)
      .filter(touchable)
        .on("touchstart.drag", touchstarted)
        .on("touchmove.drag", touchmoved)
        .on("touchend.drag touchcancel.drag", touchended)
        .style("touch-action", "none")
        .style("-webkit-tap-highlight-color", "rgba(0,0,0,0)");
  }

  function mousedowned() {
    if (touchending || !filter.apply(this, arguments)) return;
    var gesture = beforestart("mouse", container.apply(this, arguments), __WEBPACK_IMPORTED_MODULE_1_d3_selection__["mouse"], this, arguments);
    if (!gesture) return;
    Object(__WEBPACK_IMPORTED_MODULE_1_d3_selection__["select"])(__WEBPACK_IMPORTED_MODULE_1_d3_selection__["event"].view).on("mousemove.drag", mousemoved, true).on("mouseup.drag", mouseupped, true);
    Object(__WEBPACK_IMPORTED_MODULE_2__nodrag__["a" /* default */])(__WEBPACK_IMPORTED_MODULE_1_d3_selection__["event"].view);
    Object(__WEBPACK_IMPORTED_MODULE_3__noevent__["b" /* nopropagation */])();
    mousemoving = false;
    mousedownx = __WEBPACK_IMPORTED_MODULE_1_d3_selection__["event"].clientX;
    mousedowny = __WEBPACK_IMPORTED_MODULE_1_d3_selection__["event"].clientY;
    gesture("start");
  }

  function mousemoved() {
    Object(__WEBPACK_IMPORTED_MODULE_3__noevent__["a" /* default */])();
    if (!mousemoving) {
      var dx = __WEBPACK_IMPORTED_MODULE_1_d3_selection__["event"].clientX - mousedownx, dy = __WEBPACK_IMPORTED_MODULE_1_d3_selection__["event"].clientY - mousedowny;
      mousemoving = dx * dx + dy * dy > clickDistance2;
    }
    gestures.mouse("drag");
  }

  function mouseupped() {
    Object(__WEBPACK_IMPORTED_MODULE_1_d3_selection__["select"])(__WEBPACK_IMPORTED_MODULE_1_d3_selection__["event"].view).on("mousemove.drag mouseup.drag", null);
    Object(__WEBPACK_IMPORTED_MODULE_2__nodrag__["b" /* yesdrag */])(__WEBPACK_IMPORTED_MODULE_1_d3_selection__["event"].view, mousemoving);
    Object(__WEBPACK_IMPORTED_MODULE_3__noevent__["a" /* default */])();
    gestures.mouse("end");
  }

  function touchstarted() {
    if (!filter.apply(this, arguments)) return;
    var touches = __WEBPACK_IMPORTED_MODULE_1_d3_selection__["event"].changedTouches,
        c = container.apply(this, arguments),
        n = touches.length, i, gesture;

    for (i = 0; i < n; ++i) {
      if (gesture = beforestart(touches[i].identifier, c, __WEBPACK_IMPORTED_MODULE_1_d3_selection__["touch"], this, arguments)) {
        Object(__WEBPACK_IMPORTED_MODULE_3__noevent__["b" /* nopropagation */])();
        gesture("start");
      }
    }
  }

  function touchmoved() {
    var touches = __WEBPACK_IMPORTED_MODULE_1_d3_selection__["event"].changedTouches,
        n = touches.length, i, gesture;

    for (i = 0; i < n; ++i) {
      if (gesture = gestures[touches[i].identifier]) {
        Object(__WEBPACK_IMPORTED_MODULE_3__noevent__["a" /* default */])();
        gesture("drag");
      }
    }
  }

  function touchended() {
    var touches = __WEBPACK_IMPORTED_MODULE_1_d3_selection__["event"].changedTouches,
        n = touches.length, i, gesture;

    if (touchending) clearTimeout(touchending);
    touchending = setTimeout(function() { touchending = null; }, 500); // Ghost clicks are delayed!
    for (i = 0; i < n; ++i) {
      if (gesture = gestures[touches[i].identifier]) {
        Object(__WEBPACK_IMPORTED_MODULE_3__noevent__["b" /* nopropagation */])();
        gesture("end");
      }
    }
  }

  function beforestart(id, container, point, that, args) {
    var p = point(container, id), s, dx, dy,
        sublisteners = listeners.copy();

    if (!Object(__WEBPACK_IMPORTED_MODULE_1_d3_selection__["customEvent"])(new __WEBPACK_IMPORTED_MODULE_5__event__["a" /* default */](drag, "beforestart", s, id, active, p[0], p[1], 0, 0, sublisteners), function() {
      if ((__WEBPACK_IMPORTED_MODULE_1_d3_selection__["event"].subject = s = subject.apply(that, args)) == null) return false;
      dx = s.x - p[0] || 0;
      dy = s.y - p[1] || 0;
      return true;
    })) return;

    return function gesture(type) {
      var p0 = p, n;
      switch (type) {
        case "start": gestures[id] = gesture, n = active++; break;
        case "end": delete gestures[id], --active; // nobreak
        case "drag": p = point(container, id), n = active; break;
      }
      Object(__WEBPACK_IMPORTED_MODULE_1_d3_selection__["customEvent"])(new __WEBPACK_IMPORTED_MODULE_5__event__["a" /* default */](drag, type, s, id, n, p[0] + dx, p[1] + dy, p[0] - p0[0], p[1] - p0[1], sublisteners), sublisteners.apply, sublisteners, [type, that, args]);
    };
  }

  drag.filter = function(_) {
    return arguments.length ? (filter = typeof _ === "function" ? _ : Object(__WEBPACK_IMPORTED_MODULE_4__constant__["a" /* default */])(!!_), drag) : filter;
  };

  drag.container = function(_) {
    return arguments.length ? (container = typeof _ === "function" ? _ : Object(__WEBPACK_IMPORTED_MODULE_4__constant__["a" /* default */])(_), drag) : container;
  };

  drag.subject = function(_) {
    return arguments.length ? (subject = typeof _ === "function" ? _ : Object(__WEBPACK_IMPORTED_MODULE_4__constant__["a" /* default */])(_), drag) : subject;
  };

  drag.on = function() {
    var value = listeners.on.apply(listeners, arguments);
    return value === listeners ? drag : value;
  };

  drag.clickDistance = function(_) {
    return arguments.length ? (clickDistance2 = (_ = +_) * _, drag) : Math.sqrt(clickDistance2);
  };

  return drag;
});


/***/ }),
/* 306 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony default export */ __webpack_exports__["a"] = (function(x) {
  return function() {
    return x;
  };
});


/***/ }),
/* 307 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (immutable) */ __webpack_exports__["a"] = DragEvent;
function DragEvent(target, type, subject, id, active, x, y, dx, dy, dispatch) {
  this.target = target;
  this.type = type;
  this.subject = subject;
  this.identifier = id;
  this.active = active;
  this.x = x;
  this.y = y;
  this.dx = dx;
  this.dy = dy;
  this._ = dispatch;
}

DragEvent.prototype.on = function() {
  var value = this._.on.apply(this._, arguments);
  return value === this._ ? this : value;
};


/***/ }),
/* 308 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony default export */ __webpack_exports__["a"] = (function(x) {
  return function() {
    return x;
  };
});


/***/ }),
/* 309 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony default export */ __webpack_exports__["a"] = (function(target, type, selection) {
  this.target = target;
  this.type = type;
  this.selection = selection;
});


/***/ }),
/* 310 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (immutable) */ __webpack_exports__["b"] = nopropagation;
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_d3_selection__ = __webpack_require__(0);


function nopropagation() {
  __WEBPACK_IMPORTED_MODULE_0_d3_selection__["event"].stopImmediatePropagation();
}

/* harmony default export */ __webpack_exports__["a"] = (function() {
  __WEBPACK_IMPORTED_MODULE_0_d3_selection__["event"].preventDefault();
  __WEBPACK_IMPORTED_MODULE_0_d3_selection__["event"].stopImmediatePropagation();
});


/***/ })
/******/ ]);
});
//# sourceMappingURL=britecharts.min.js.map