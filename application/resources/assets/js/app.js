/******/ (function(modules) { // webpackBootstrap
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
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ (function(module, exports, __webpack_require__) {

(function webpackMissingModule() { throw new Error("Cannot find module \"C:\\laragon\\www\\application\\resources\\assets\\js\\app.js\""); }());
module.exports = __webpack_require__(1);


/***/ }),
/* 1 */
/***/ (function(module, exports) {

throw new Error("Module build failed: ModuleBuildError: Module build failed: Error: Node Sass does not yet support your current environment: Windows 64-bit with Unsupported runtime (108)\nFor more information on which environments are supported please see:\nhttps://github.com/sass/node-sass/releases/tag/v4.5.3\n    at module.exports (C:\\laragon\\www\\application\\node_modules\\node-sass\\lib\\binding.js:13:13)\n    at Object.<anonymous> (C:\\laragon\\www\\application\\node_modules\\node-sass\\lib\\index.js:14:35)\n    at Module._compile (node:internal/modules/cjs/loader:1119:14)\n    at Module._extensions..js (node:internal/modules/cjs/loader:1173:10)\n    at Module.load (node:internal/modules/cjs/loader:997:32)\n    at Module._load (node:internal/modules/cjs/loader:838:12)\n    at Module.require (node:internal/modules/cjs/loader:1021:19)\n    at require (node:internal/modules/cjs/helpers:103:18)\n    at Object.<anonymous> (C:\\laragon\\www\\application\\node_modules\\sass-loader\\lib\\loader.js:3:14)\n    at Module._compile (node:internal/modules/cjs/loader:1119:14)\n    at Module._extensions..js (node:internal/modules/cjs/loader:1173:10)\n    at Module.load (node:internal/modules/cjs/loader:997:32)\n    at Module._load (node:internal/modules/cjs/loader:838:12)\n    at Module.require (node:internal/modules/cjs/loader:1021:19)\n    at require (node:internal/modules/cjs/helpers:103:18)\n    at loadLoader (C:\\laragon\\www\\application\\node_modules\\loader-runner\\lib\\loadLoader.js:13:17)\n    at iteratePitchingLoaders (C:\\laragon\\www\\application\\node_modules\\loader-runner\\lib\\LoaderRunner.js:169:2)\n    at iteratePitchingLoaders (C:\\laragon\\www\\application\\node_modules\\loader-runner\\lib\\LoaderRunner.js:165:10)\n    at C:\\laragon\\www\\application\\node_modules\\loader-runner\\lib\\LoaderRunner.js:173:18\n    at loadLoader (C:\\laragon\\www\\application\\node_modules\\loader-runner\\lib\\loadLoader.js:36:3)\n    at iteratePitchingLoaders (C:\\laragon\\www\\application\\node_modules\\loader-runner\\lib\\LoaderRunner.js:169:2)\n    at iteratePitchingLoaders (C:\\laragon\\www\\application\\node_modules\\loader-runner\\lib\\LoaderRunner.js:165:10)\n    at C:\\laragon\\www\\application\\node_modules\\loader-runner\\lib\\LoaderRunner.js:173:18\n    at loadLoader (C:\\laragon\\www\\application\\node_modules\\loader-runner\\lib\\loadLoader.js:36:3)\n    at iteratePitchingLoaders (C:\\laragon\\www\\application\\node_modules\\loader-runner\\lib\\LoaderRunner.js:169:2)\n    at iteratePitchingLoaders (C:\\laragon\\www\\application\\node_modules\\loader-runner\\lib\\LoaderRunner.js:165:10)\n    at C:\\laragon\\www\\application\\node_modules\\loader-runner\\lib\\LoaderRunner.js:173:18\n    at loadLoader (C:\\laragon\\www\\application\\node_modules\\loader-runner\\lib\\loadLoader.js:36:3)\n    at iteratePitchingLoaders (C:\\laragon\\www\\application\\node_modules\\loader-runner\\lib\\LoaderRunner.js:169:2)\n    at runLoaders (C:\\laragon\\www\\application\\node_modules\\loader-runner\\lib\\LoaderRunner.js:362:2)\n    at C:\\laragon\\www\\application\\node_modules\\webpack\\lib\\NormalModule.js:195:19\n    at C:\\laragon\\www\\application\\node_modules\\loader-runner\\lib\\LoaderRunner.js:364:11\n    at C:\\laragon\\www\\application\\node_modules\\loader-runner\\lib\\LoaderRunner.js:170:18\n    at loadLoader (C:\\laragon\\www\\application\\node_modules\\loader-runner\\lib\\loadLoader.js:27:11)\n    at iteratePitchingLoaders (C:\\laragon\\www\\application\\node_modules\\loader-runner\\lib\\LoaderRunner.js:169:2)\n    at iteratePitchingLoaders (C:\\laragon\\www\\application\\node_modules\\loader-runner\\lib\\LoaderRunner.js:165:10)\n    at C:\\laragon\\www\\application\\node_modules\\loader-runner\\lib\\LoaderRunner.js:173:18\n    at loadLoader (C:\\laragon\\www\\application\\node_modules\\loader-runner\\lib\\loadLoader.js:36:3)\n    at iteratePitchingLoaders (C:\\laragon\\www\\application\\node_modules\\loader-runner\\lib\\LoaderRunner.js:169:2)\n    at iteratePitchingLoaders (C:\\laragon\\www\\application\\node_modules\\loader-runner\\lib\\LoaderRunner.js:165:10)\n    at C:\\laragon\\www\\application\\node_modules\\loader-runner\\lib\\LoaderRunner.js:173:18\n    at loadLoader (C:\\laragon\\www\\application\\node_modules\\loader-runner\\lib\\loadLoader.js:36:3)\n    at iteratePitchingLoaders (C:\\laragon\\www\\application\\node_modules\\loader-runner\\lib\\LoaderRunner.js:169:2)\n    at iteratePitchingLoaders (C:\\laragon\\www\\application\\node_modules\\loader-runner\\lib\\LoaderRunner.js:165:10)\n    at C:\\laragon\\www\\application\\node_modules\\loader-runner\\lib\\LoaderRunner.js:173:18\n    at loadLoader (C:\\laragon\\www\\application\\node_modules\\loader-runner\\lib\\loadLoader.js:36:3)\n    at iteratePitchingLoaders (C:\\laragon\\www\\application\\node_modules\\loader-runner\\lib\\LoaderRunner.js:169:2)\n    at runLoaders (C:\\laragon\\www\\application\\node_modules\\loader-runner\\lib\\LoaderRunner.js:362:2)\n    at NormalModule.doBuild (C:\\laragon\\www\\application\\node_modules\\webpack\\lib\\NormalModule.js:182:3)\n    at NormalModule.build (C:\\laragon\\www\\application\\node_modules\\webpack\\lib\\NormalModule.js:275:15)\n    at Compilation.buildModule (C:\\laragon\\www\\application\\node_modules\\webpack\\lib\\Compilation.js:151:10)\n    at C:\\laragon\\www\\application\\node_modules\\webpack\\lib\\Compilation.js:456:10\n    at C:\\laragon\\www\\application\\node_modules\\webpack\\lib\\NormalModuleFactory.js:241:5\n    at C:\\laragon\\www\\application\\node_modules\\webpack\\lib\\NormalModuleFactory.js:94:13\n    at C:\\laragon\\www\\application\\node_modules\\tapable\\lib\\Tapable.js:268:11\n    at NormalModuleFactory.<anonymous> (C:\\laragon\\www\\application\\node_modules\\webpack\\lib\\CompatibilityPlugin.js:52:5)\n    at NormalModuleFactory.applyPluginsAsyncWaterfall (C:\\laragon\\www\\application\\node_modules\\tapable\\lib\\Tapable.js:272:13)\n    at C:\\laragon\\www\\application\\node_modules\\webpack\\lib\\NormalModuleFactory.js:69:10\n    at C:\\laragon\\www\\application\\node_modules\\webpack\\lib\\NormalModuleFactory.js:194:7\n    at process.processTicksAndRejections (node:internal/process/task_queues:77:11)");

/***/ })
/******/ ]);