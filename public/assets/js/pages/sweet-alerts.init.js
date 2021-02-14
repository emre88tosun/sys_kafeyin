/******/
(function (modules) { // webpackBootstrap
    /******/ 	// The module cache
    /******/
    var installedModules = {};
    /******/
    /******/ 	// The require function
    /******/
    function __webpack_require__(moduleId) {
        /******/
        /******/ 		// Check if module is in cache
        /******/
        if (installedModules[moduleId]) {
            /******/
            return installedModules[moduleId].exports;
            /******/
        }
        /******/ 		// Create a new module (and put it into the cache)
        /******/
        var module = installedModules[moduleId] = {
            /******/            i: moduleId,
            /******/            l: false,
            /******/            exports: {}
            /******/
        };
        /******/
        /******/ 		// Execute the module function
        /******/
        modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
        /******/
        /******/ 		// Flag the module as loaded
        /******/
        module.l = true;
        /******/
        /******/ 		// Return the exports of the module
        /******/
        return module.exports;
        /******/
    }

    /******/
    /******/
    /******/ 	// expose the modules object (__webpack_modules__)
    /******/
    __webpack_require__.m = modules;
    /******/
    /******/ 	// expose the module cache
    /******/
    __webpack_require__.c = installedModules;
    /******/
    /******/ 	// define getter function for harmony exports
    /******/
    __webpack_require__.d = function (exports, name, getter) {
        /******/
        if (!__webpack_require__.o(exports, name)) {
            /******/
            Object.defineProperty(exports, name, {enumerable: true, get: getter});
            /******/
        }
        /******/
    };
    /******/
    /******/ 	// define __esModule on exports
    /******/
    __webpack_require__.r = function (exports) {
        /******/
        if (typeof Symbol !== 'undefined' && Symbol.toStringTag) {
            /******/
            Object.defineProperty(exports, Symbol.toStringTag, {value: 'Module'});
            /******/
        }
        /******/
        Object.defineProperty(exports, '__esModule', {value: true});
        /******/
    };
    /******/
    /******/ 	// create a fake namespace object
    /******/ 	// mode & 1: value is a module id, require it
    /******/ 	// mode & 2: merge all properties of value into the ns
    /******/ 	// mode & 4: return value when already ns object
    /******/ 	// mode & 8|1: behave like require
    /******/
    __webpack_require__.t = function (value, mode) {
        /******/
        if (mode & 1) value = __webpack_require__(value);
        /******/
        if (mode & 8) return value;
        /******/
        if ((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
        /******/
        var ns = Object.create(null);
        /******/
        __webpack_require__.r(ns);
        /******/
        Object.defineProperty(ns, 'default', {enumerable: true, value: value});
        /******/
        if (mode & 2 && typeof value != 'string') for (var key in value) __webpack_require__.d(ns, key, function (key) {
            return value[key];
        }.bind(null, key));
        /******/
        return ns;
        /******/
    };
    /******/
    /******/ 	// getDefaultExport function for compatibility with non-harmony modules
    /******/
    __webpack_require__.n = function (module) {
        /******/
        var getter = module && module.__esModule ?
            /******/            function getDefault() {
                return module['default'];
            } :
            /******/            function getModuleExports() {
                return module;
            };
        /******/
        __webpack_require__.d(getter, 'a', getter);
        /******/
        return getter;
        /******/
    };
    /******/
    /******/ 	// Object.prototype.hasOwnProperty.call
    /******/
    __webpack_require__.o = function (object, property) {
        return Object.prototype.hasOwnProperty.call(object, property);
    };
    /******/
    /******/ 	// __webpack_public_path__
    /******/
    __webpack_require__.p = "/";
    /******/
    /******/
    /******/ 	// Load entry module and return exports
    /******/
    return __webpack_require__(__webpack_require__.s = 24);
    /******/
})
    /************************************************************************/
    /******/ ({

    /***/ "./resources/js/pages/sweet-alerts.init.js":
    /*!*************************************************!*\
      !*** ./resources/js/pages/sweet-alerts.init.js ***!
      \*************************************************/
    /*! no static exports found */
    /***/ (function (module, exports) {

        !function ($) {
            "use strict";

            var SweetAlert = function SweetAlert() {
            }; //examples

            SweetAlert.prototype.init = function () {

                $('.sa-yorumSil').click(function () {
                    var idd2 = $(this).data('id');
                    Swal.fire({
                        title: 'Emin misiniz?',
                        text: "Yorumu silmek istediğinize emin misiniz?",
                        type: "question",
                        showCancelButton: true,
                        confirmButtonColor: "#4caf50",
                        cancelButtonColor: "#f44336",
                        confirmButtonText: "Onayla",
                        cancelButtonText: "İptal",
                        allowOutsideClick: false,
                    }).then(function (result) {
                        if (result.value) {
                            Swal.fire({
                                type: 'info',
                                title: "Lütfen bekleyin",
                                showConfirmButton: false,
                                allowOutsideClick: false,
                            });
                            postToUrl('/adminpanel/yorumsil?yorumID=' + idd2, {yorumID: idd2}, false);
                        }
                    });
                });
                $('.sa-kFotoSil').click(function () {
                    var idd2 = $(this).data('id');
                    Swal.fire({
                        title: 'Emin misiniz?',
                        text: "Fotoğrafı silmek istediğinize emin misiniz?",
                        type: "question",
                        showCancelButton: true,
                        confirmButtonColor: "#4caf50",
                        cancelButtonColor: "#f44336",
                        confirmButtonText: "Onayla",
                        cancelButtonText: "İptal",
                        allowOutsideClick: false,
                    }).then(function (result) {
                        if (result.value) {
                            Swal.fire({
                                type: 'info',
                                title: "Lütfen bekleyin",
                                showConfirmButton: false,
                                allowOutsideClick: false,
                            });
                            postToUrl('/adminpanel/kfotosil', {id: idd2}, false);
                        }
                    });
                });
                $('.sa-payPasif').click(function () {
                    var idd2 = $(this).data('id');
                    Swal.fire({
                        title: 'Emin misiniz?',
                        text: "Paylaşımı pasifize etmek istediğinize emin misiniz?",
                        type: "question",
                        showCancelButton: true,
                        confirmButtonColor: "#4caf50",
                        cancelButtonColor: "#f44336",
                        confirmButtonText: "Onayla",
                        cancelButtonText: "İptal",
                        allowOutsideClick: false,
                    }).then(function (result) {
                        if (result.value) {
                            Swal.fire({
                                type: 'info',
                                title: "Lütfen bekleyin",
                                showConfirmButton: false,
                                allowOutsideClick: false,
                            });
                            postToUrl('/adminpanel/paypasif', {id: idd2}, false);
                        }
                    });
                });
                $('.sa-paySil').click(function () {
                    var idd2 = $(this).data('id');
                    Swal.fire({
                        title: 'Emin misiniz?',
                        text: "Paylaşımı silmek istediğinize emin misiniz?",
                        type: "question",
                        showCancelButton: true,
                        confirmButtonColor: "#4caf50",
                        cancelButtonColor: "#f44336",
                        confirmButtonText: "Onayla",
                        cancelButtonText: "İptal",
                        allowOutsideClick: false,
                    }).then(function (result) {
                        if (result.value) {
                            Swal.fire({
                                type: 'info',
                                title: "Lütfen bekleyin",
                                showConfirmButton: false,
                                allowOutsideClick: false,
                            });
                            postToUrl('/adminpanel/paysil', {id: idd2}, false);
                        }
                    });
                });
                $('.sa-yaziPasif').click(function () {
                    var idd2 = $(this).data('id');
                    Swal.fire({
                        title: 'Emin misiniz?',
                        text: "Yazıyı pasifize etmek istediğinize emin misiniz?",
                        type: "question",
                        showCancelButton: true,
                        confirmButtonColor: "#4caf50",
                        cancelButtonColor: "#f44336",
                        confirmButtonText: "Onayla",
                        cancelButtonText: "İptal",
                        allowOutsideClick: false,
                    }).then(function (result) {
                        if (result.value) {
                            Swal.fire({
                                type: 'info',
                                title: "Lütfen bekleyin",
                                showConfirmButton: false,
                                allowOutsideClick: false,
                            });
                            postToUrl('/adminpanel/yazipasif', {id: idd2}, false);
                        }
                    });
                });
                $('.sa-yaziSil').click(function () {
                    var idd2 = $(this).data('id');
                    Swal.fire({
                        title: 'Emin misiniz?',
                        text: "Yazıyı silmek istediğinize emin misiniz?",
                        type: "question",
                        showCancelButton: true,
                        confirmButtonColor: "#4caf50",
                        cancelButtonColor: "#f44336",
                        confirmButtonText: "Onayla",
                        cancelButtonText: "İptal",
                        allowOutsideClick: false,
                    }).then(function (result) {
                        if (result.value) {
                            Swal.fire({
                                type: 'info',
                                title: "Lütfen bekleyin",
                                showConfirmButton: false,
                                allowOutsideClick: false,
                            });
                            postToUrl('/adminpanel/yazisil', {id: idd2}, false);
                        }
                    });
                });
                $('.sa-etkPasif').click(function () {
                    var idd2 = $(this).data('id');
                    Swal.fire({
                        title: 'Emin misiniz?',
                        text: "Etkinliği pasifize etmek istediğinize emin misiniz?",
                        type: "question",
                        showCancelButton: true,
                        confirmButtonColor: "#4caf50",
                        cancelButtonColor: "#f44336",
                        confirmButtonText: "Onayla",
                        cancelButtonText: "İptal",
                        allowOutsideClick: false,
                    }).then(function (result) {
                        if (result.value) {
                            Swal.fire({
                                type: 'info',
                                title: "Lütfen bekleyin",
                                showConfirmButton: false,
                                allowOutsideClick: false,
                            });
                            postToUrl('/adminpanel/etkpasif', {id: idd2}, false);
                        }
                    });
                });
                $('.sa-etkSil').click(function () {
                    var idd2 = $(this).data('id');
                    Swal.fire({
                        title: 'Emin misiniz?',
                        text: "Etkinliği silmek istediğinize emin misiniz?",
                        type: "question",
                        showCancelButton: true,
                        confirmButtonColor: "#4caf50",
                        cancelButtonColor: "#f44336",
                        confirmButtonText: "Onayla",
                        cancelButtonText: "İptal",
                        allowOutsideClick: false,
                    }).then(function (result) {
                        if (result.value) {
                            Swal.fire({
                                type: 'info',
                                title: "Lütfen bekleyin",
                                showConfirmButton: false,
                                allowOutsideClick: false,
                            });
                            postToUrl('/adminpanel/etksil', {id: idd2}, false);
                        }
                    });
                });
                $('.sa-urunPasif').click(function () {
                    var idd2 = $(this).data('id');
                    Swal.fire({
                        title: 'Emin misiniz?',
                        text: "Ürünü pasifize etmek istediğinize emin misiniz? Bağlı QR kod varsa pasif hale getirilecektir.",
                        type: "question",
                        showCancelButton: true,
                        confirmButtonColor: "#4caf50",
                        cancelButtonColor: "#f44336",
                        confirmButtonText: "Onayla",
                        cancelButtonText: "İptal",
                        allowOutsideClick: false,
                    }).then(function (result) {
                        if (result.value) {
                            Swal.fire({
                                type: 'info',
                                title: "Lütfen bekleyin",
                                showConfirmButton: false,
                                allowOutsideClick: false,
                            });
                            postToUrl('/adminpanel/urunpasif', {id: idd2}, false);
                        }
                    });
                });
                $('.sa-urunSil').click(function () {
                    var idd2 = $(this).data('id');
                    Swal.fire({
                        title: 'Emin misiniz?',
                        text: "Ürünü silmek istediğinize emin misiniz? Bağlı QR kod varsa silinmiş hale getirilecektir.",
                        type: "question",
                        showCancelButton: true,
                        confirmButtonColor: "#4caf50",
                        cancelButtonColor: "#f44336",
                        confirmButtonText: "Onayla",
                        cancelButtonText: "İptal",
                        allowOutsideClick: false,
                    }).then(function (result) {
                        if (result.value) {
                            Swal.fire({
                                type: 'info',
                                title: "Lütfen bekleyin",
                                showConfirmButton: false,
                                allowOutsideClick: false,
                            });
                            postToUrl('/adminpanel/urunsil', {id: idd2}, false);
                        }
                    });
                });
                $('.sa-lokaSil').click(function () {
                    var idd2 = $(this).data('id');
                    Swal.fire({
                        title: 'Emin misiniz?',
                        text: "Lokasyonu silmek istediğinize emin misiniz?",
                        type: "question",
                        showCancelButton: true,
                        confirmButtonColor: "#4caf50",
                        cancelButtonColor: "#f44336",
                        confirmButtonText: "Onayla",
                        cancelButtonText: "İptal",
                        allowOutsideClick: false,
                    }).then(function (result) {
                        if (result.value) {
                            Swal.fire({
                                type: 'info',
                                title: "Lütfen bekleyin",
                                showConfirmButton: false,
                                allowOutsideClick: false,
                            });
                            postToUrl('/adminpanel/lokasil', {id: idd2}, false);
                        }
                    });
                });
                $('.sa-kNewsSil').click(function () {
                    var idd2 = $(this).data('id');
                    Swal.fire({
                        title: 'Emin misiniz?',
                        text: "Haberi silmek istediğinize emin misiniz?",
                        type: "question",
                        showCancelButton: true,
                        confirmButtonColor: "#4caf50",
                        cancelButtonColor: "#f44336",
                        confirmButtonText: "Onayla",
                        cancelButtonText: "İptal",
                        allowOutsideClick: false,
                    }).then(function (result) {
                        if (result.value) {
                            Swal.fire({
                                type: 'info',
                                title: "Lütfen bekleyin",
                                showConfirmButton: false,
                                allowOutsideClick: false,
                            });
                            postToUrl('/adminpanel/knewssil', {id: idd2}, false);
                        }
                    });
                });
                $('.sa-popMagazaSil').click(function () {
                    var idd2 = $(this).data('id');
                    Swal.fire({
                        title: 'Emin misiniz?',
                        text: "Popüler mağazayı silmek istediğinize emin misiniz?",
                        type: "question",
                        showCancelButton: true,
                        confirmButtonColor: "#4caf50",
                        cancelButtonColor: "#f44336",
                        confirmButtonText: "Onayla",
                        cancelButtonText: "İptal",
                        allowOutsideClick: false,
                    }).then(function (result) {
                        if (result.value) {
                            Swal.fire({
                                type: 'info',
                                title: "Lütfen bekleyin",
                                showConfirmButton: false,
                                allowOutsideClick: false,
                            });
                            postToUrl('/adminpanel/popmagazasil', {id: idd2}, false);
                        }
                    });
                });
                $('.sa-sonMagazaSil').click(function () {
                    var idd2 = $(this).data('id');
                    Swal.fire({
                        title: 'Emin misiniz?',
                        text: "En son eklenen mağazayı silmek istediğinize emin misiniz?",
                        type: "question",
                        showCancelButton: true,
                        confirmButtonColor: "#4caf50",
                        cancelButtonColor: "#f44336",
                        confirmButtonText: "Onayla",
                        cancelButtonText: "İptal",
                        allowOutsideClick: false,
                    }).then(function (result) {
                        if (result.value) {
                            Swal.fire({
                                type: 'info',
                                title: "Lütfen bekleyin",
                                showConfirmButton: false,
                                allowOutsideClick: false,
                            });
                            postToUrl('/adminpanel/sonmagazasil', {id: idd2}, false);
                        }
                    });
                });
                $('.sa-edtMagazaSil').click(function () {
                    var idd2 = $(this).data('id');
                    Swal.fire({
                        title: 'Emin misiniz?',
                        text: "Editörün tercihi mağazayı silmek istediğinize emin misiniz?",
                        type: "question",
                        showCancelButton: true,
                        confirmButtonColor: "#4caf50",
                        cancelButtonColor: "#f44336",
                        confirmButtonText: "Onayla",
                        cancelButtonText: "İptal",
                        allowOutsideClick: false,
                    }).then(function (result) {
                        if (result.value) {
                            Swal.fire({
                                type: 'info',
                                title: "Lütfen bekleyin",
                                showConfirmButton: false,
                                allowOutsideClick: false,
                            });
                            postToUrl('/adminpanel/edtmagazasil', {id: idd2}, false);
                        }
                    });
                });
                $('.sa-kLokSil').click(function () {
                    var idd2 = $(this).data('id');
                    Swal.fire({
                        title: 'Emin misiniz?',
                        text: "Lokasyonu silmek istediğinize emin misiniz?",
                        type: "question",
                        showCancelButton: true,
                        confirmButtonColor: "#4caf50",
                        cancelButtonColor: "#f44336",
                        confirmButtonText: "Onayla",
                        cancelButtonText: "İptal",
                        allowOutsideClick: false,
                    }).then(function (result) {
                        if (result.value) {
                            Swal.fire({
                                type: 'info',
                                title: "Lütfen bekleyin",
                                showConfirmButton: false,
                                allowOutsideClick: false,
                            });
                            postToUrl('/adminpanel/klokasyonsil', {id: idd2}, false);
                        }
                    });
                });
                $('.sa-duySil').click(function () {
                    var idd2 = $(this).data('id');
                    Swal.fire({
                        title: 'Emin misiniz?',
                        text: "Duyuruyu silmek istediğinize emin misiniz?",
                        type: "question",
                        showCancelButton: true,
                        confirmButtonColor: "#4caf50",
                        cancelButtonColor: "#f44336",
                        confirmButtonText: "Onayla",
                        cancelButtonText: "İptal",
                        allowOutsideClick: false,
                    }).then(function (result) {
                        if (result.value) {
                            Swal.fire({
                                type: 'info',
                                title: "Lütfen bekleyin",
                                showConfirmButton: false,
                                allowOutsideClick: false,
                            });
                            postToUrl('/adminpanel/duysil', {id: idd2}, false);
                        }
                    });
                });
                $('.sa-kAnketPasif').click(function () {
                    var idd2 = $(this).data('id');
                    Swal.fire({
                        title: 'Emin misiniz?',
                        text: "Anketi pasif hale getirmek istediğinize emin misiniz?",
                        type: "question",
                        showCancelButton: true,
                        confirmButtonColor: "#4caf50",
                        cancelButtonColor: "#f44336",
                        confirmButtonText: "Onayla",
                        cancelButtonText: "İptal",
                        allowOutsideClick: false,
                    }).then(function (result) {
                        if (result.value) {
                            Swal.fire({
                                type: 'info',
                                title: "Lütfen bekleyin",
                                showConfirmButton: false,
                                allowOutsideClick: false,
                            });
                            postToUrl('/adminpanel/kanketpasif', {id: idd2}, false);
                        }
                    });
                });
                $('.sa-kAnketSil').click(function () {
                    var idd2 = $(this).data('id');
                    Swal.fire({
                        title: 'Emin misiniz?',
                        text: "Anketi silmek istediğinize emin misiniz?",
                        type: "question",
                        showCancelButton: true,
                        confirmButtonColor: "#4caf50",
                        cancelButtonColor: "#f44336",
                        confirmButtonText: "Onayla",
                        cancelButtonText: "İptal",
                        allowOutsideClick: false,
                    }).then(function (result) {
                        if (result.value) {
                            Swal.fire({
                                type: 'info',
                                title: "Lütfen bekleyin",
                                showConfirmButton: false,
                                allowOutsideClick: false,
                            });
                            postToUrl('/adminpanel/kanketsil', {id: idd2}, false);
                        }
                    });
                });
                $('.sa-mAnketPasif').click(function () {
                    var idd2 = $(this).data('id');
                    Swal.fire({
                        title: 'Emin misiniz?',
                        text: "Anketi pasif hale getirmek istediğinize emin misiniz?",
                        type: "question",
                        showCancelButton: true,
                        confirmButtonColor: "#4caf50",
                        cancelButtonColor: "#f44336",
                        confirmButtonText: "Onayla",
                        cancelButtonText: "İptal",
                        allowOutsideClick: false,
                    }).then(function (result) {
                        if (result.value) {
                            Swal.fire({
                                type: 'info',
                                title: "Lütfen bekleyin",
                                showConfirmButton: false,
                                allowOutsideClick: false,
                            });
                            postToUrl('/adminpanel/manketpasif', {id: idd2}, false);
                        }
                    });
                });
                $('.sa-mAnketSil').click(function () {
                    var idd2 = $(this).data('id');
                    Swal.fire({
                        title: 'Emin misiniz?',
                        text: "Anketi silmek istediğinize emin misiniz?",
                        type: "question",
                        showCancelButton: true,
                        confirmButtonColor: "#4caf50",
                        cancelButtonColor: "#f44336",
                        confirmButtonText: "Onayla",
                        cancelButtonText: "İptal",
                        allowOutsideClick: false,
                    }).then(function (result) {
                        if (result.value) {
                            Swal.fire({
                                type: 'info',
                                title: "Lütfen bekleyin",
                                showConfirmButton: false,
                                allowOutsideClick: false,
                            });
                            postToUrl('/adminpanel/manketsil', {id: idd2}, false);
                        }
                    });
                });
                $('.sa-yorumSil2').click(function () {
                    var idd2 = $(this).data('id');
                    Swal.fire({
                        title: 'Emin misiniz?',
                        text: "Yorumu silmek istediğinize emin misiniz?",
                        type: "question",
                        showCancelButton: true,
                        confirmButtonColor: "#4caf50",
                        cancelButtonColor: "#f44336",
                        confirmButtonText: "Onayla",
                        cancelButtonText: "İptal",
                        allowOutsideClick: false,
                    }).then(function (result) {
                        if (result.value) {
                            Swal.fire({
                                type: 'info',
                                title: "Lütfen bekleyin",
                                showConfirmButton: false,
                                allowOutsideClick: false,
                            });
                            postToUrl('/adminpanel/yorumsil2', {id: idd2}, false);
                        }
                    });
                });
                $('.sa-tskMail1').click(function () {
                    var idd2 = $(this).data('id');
                    Swal.fire({
                        title: 'Emin misiniz?',
                        text: "Şikayet sahibine teşekkür e-postası göndermek istediğinize emin misiniz?",
                        type: "question",
                        showCancelButton: true,
                        confirmButtonColor: "#4caf50",
                        cancelButtonColor: "#f44336",
                        confirmButtonText: "Onayla",
                        cancelButtonText: "İptal",
                        allowOutsideClick: false,
                    }).then(function (result) {
                        if (result.value) {
                            Swal.fire({
                                type: 'info',
                                title: "Lütfen bekleyin",
                                showConfirmButton: false,
                                allowOutsideClick: false,
                            });
                            postToUrl('/adminpanel/tskmail1', {id: idd2}, false);
                        }
                    });
                });
                $('.sa-sikayetSil').click(function () {
                    var idd2 = $(this).data('id');
                    Swal.fire({
                        title: 'Emin misiniz?',
                        text: "Şikayeti silmek istediğinize emin misiniz?",
                        type: "question",
                        showCancelButton: true,
                        confirmButtonColor: "#4caf50",
                        cancelButtonColor: "#f44336",
                        confirmButtonText: "Onayla",
                        cancelButtonText: "İptal",
                        allowOutsideClick: false,
                    }).then(function (result) {
                        if (result.value) {
                            Swal.fire({
                                type: 'info',
                                title: "Lütfen bekleyin",
                                showConfirmButton: false,
                                allowOutsideClick: false,
                            });
                            postToUrl('/adminpanel/sikayetsil', {id: idd2}, false);
                        }
                    });
                });
                $('.sa-oneriOkundu').click(function () {
                    var idd2 = $(this).data('id');
                    Swal.fire({
                        title: 'Emin misiniz?',
                        text: "Öneriyi okundu olarak işaretlemek istediğinize emin misiniz?",
                        type: "question",
                        showCancelButton: true,
                        confirmButtonColor: "#4caf50",
                        cancelButtonColor: "#f44336",
                        confirmButtonText: "Onayla",
                        cancelButtonText: "İptal",
                        allowOutsideClick: false,
                    }).then(function (result) {
                        if (result.value) {
                            Swal.fire({
                                type: 'info',
                                title: "Lütfen bekleyin",
                                showConfirmButton: false,
                                allowOutsideClick: false,
                            });
                            postToUrl('/adminpanel/oneriokundu', {id: idd2}, false);
                        }
                    });
                });
                $('.sa-oneriSil').click(function () {
                    var idd2 = $(this).data('id');
                    Swal.fire({
                        title: 'Emin misiniz?',
                        text: "Öneriyi silmek istediğinize emin misiniz?",
                        type: "question",
                        showCancelButton: true,
                        confirmButtonColor: "#4caf50",
                        cancelButtonColor: "#f44336",
                        confirmButtonText: "Onayla",
                        cancelButtonText: "İptal",
                        allowOutsideClick: false,
                    }).then(function (result) {
                        if (result.value) {
                            Swal.fire({
                                type: 'info',
                                title: "Lütfen bekleyin",
                                showConfirmButton: false,
                                allowOutsideClick: false,
                            });
                            postToUrl('/adminpanel/onerisil', {id: idd2}, false);
                        }
                    });
                });
                $('.sa-dlkOkundu').click(function () {
                    var idd2 = $(this).data('id');
                    Swal.fire({
                        title: 'Emin misiniz?',
                        text: "Öneriyi okundu olarak işaretlemek istediğinize emin misiniz?",
                        type: "question",
                        showCancelButton: true,
                        confirmButtonColor: "#4caf50",
                        cancelButtonColor: "#f44336",
                        confirmButtonText: "Onayla",
                        cancelButtonText: "İptal",
                        allowOutsideClick: false,
                    }).then(function (result) {
                        if (result.value) {
                            Swal.fire({
                                type: 'info',
                                title: "Lütfen bekleyin",
                                showConfirmButton: false,
                                allowOutsideClick: false,
                            });
                            postToUrl('/adminpanel/dlkokundu', {id: idd2}, false);
                        }
                    });
                });
                $('.sa-dlkSil').click(function () {
                    var idd2 = $(this).data('id');
                    Swal.fire({
                        title: 'Emin misiniz?',
                        text: "Öneriyi silmek istediğinize emin misiniz?",
                        type: "question",
                        showCancelButton: true,
                        confirmButtonColor: "#4caf50",
                        cancelButtonColor: "#f44336",
                        confirmButtonText: "Onayla",
                        cancelButtonText: "İptal",
                        allowOutsideClick: false,
                    }).then(function (result) {
                        if (result.value) {
                            Swal.fire({
                                type: 'info',
                                title: "Lütfen bekleyin",
                                showConfirmButton: false,
                                allowOutsideClick: false,
                            });
                            postToUrl('/adminpanel/dlksil', {id: idd2}, false);
                        }
                    });
                });
                $('.sa-favArtSil').click(function () {
                    var idd2 = $(this).data('id');
                    Swal.fire({
                        title: 'Emin misiniz?',
                        text: "Favori yazıyı silmek istediğinize emin misiniz?",
                        type: "question",
                        showCancelButton: true,
                        confirmButtonColor: "#4caf50",
                        cancelButtonColor: "#f44336",
                        confirmButtonText: "Onayla",
                        cancelButtonText: "İptal",
                        allowOutsideClick: false,
                    }).then(function (result) {
                        if (result.value) {
                            Swal.fire({
                                type: 'info',
                                title: "Lütfen bekleyin",
                                showConfirmButton: false,
                                allowOutsideClick: false,
                            });
                            postToUrl('/adminpanel/favartsil', {id: idd2}, false);
                        }
                    });
                });
                $('.sa-favActSil').click(function () {
                    var idd2 = $(this).data('id');
                    Swal.fire({
                        title: 'Emin misiniz?',
                        text: "Favori etkinliği silmek istediğinize emin misiniz?",
                        type: "question",
                        showCancelButton: true,
                        confirmButtonColor: "#4caf50",
                        cancelButtonColor: "#f44336",
                        confirmButtonText: "Onayla",
                        cancelButtonText: "İptal",
                        allowOutsideClick: false,
                    }).then(function (result) {
                        if (result.value) {
                            Swal.fire({
                                type: 'info',
                                title: "Lütfen bekleyin",
                                showConfirmButton: false,
                                allowOutsideClick: false,
                            });
                            postToUrl('/adminpanel/favactsil', {id: idd2}, false);
                        }
                    });
                });
                $('.sa-favStoSil').click(function () {
                    var idd2 = $(this).data('id');
                    Swal.fire({
                        title: 'Emin misiniz?',
                        text: "Favori mağazayı silmek istediğinize emin misiniz?",
                        type: "question",
                        showCancelButton: true,
                        confirmButtonColor: "#4caf50",
                        cancelButtonColor: "#f44336",
                        confirmButtonText: "Onayla",
                        cancelButtonText: "İptal",
                        allowOutsideClick: false,
                    }).then(function (result) {
                        if (result.value) {
                            Swal.fire({
                                type: 'info',
                                title: "Lütfen bekleyin",
                                showConfirmButton: false,
                                allowOutsideClick: false,
                            });
                            postToUrl('/adminpanel/favstosil', {id: idd2}, false);
                        }
                    });
                });
                $('.sa-takipSil').click(function () {
                    var idd2 = $(this).data('id');
                    Swal.fire({
                        title: 'Emin misiniz?',
                        text: "Takibi silmek istediğinize emin misiniz?",
                        type: "question",
                        showCancelButton: true,
                        confirmButtonColor: "#4caf50",
                        cancelButtonColor: "#f44336",
                        confirmButtonText: "Onayla",
                        cancelButtonText: "İptal",
                        allowOutsideClick: false,
                    }).then(function (result) {
                        if (result.value) {
                            Swal.fire({
                                type: 'info',
                                title: "Lütfen bekleyin",
                                showConfirmButton: false,
                                allowOutsideClick: false,
                            });
                            postToUrl('/adminpanel/takipsil', {id: idd2}, false);
                        }
                    });
                });
                $('.sa-kartSil').click(function () {
                    var idd2 = $(this).data('id');
                    Swal.fire({
                        title: 'Emin misiniz?',
                        text: "Kartı silmek istediğinize emin misiniz?",
                        type: "question",
                        showCancelButton: true,
                        confirmButtonColor: "#4caf50",
                        cancelButtonColor: "#f44336",
                        confirmButtonText: "Onayla",
                        cancelButtonText: "İptal",
                        allowOutsideClick: false,
                    }).then(function (result) {
                        if (result.value) {
                            Swal.fire({
                                type: 'info',
                                title: "Lütfen bekleyin",
                                showConfirmButton: false,
                                allowOutsideClick: false,
                            });
                            postToUrl('/adminpanel/kartsil', {id: idd2}, false);
                        }
                    });
                });
                $('.sa-kKullaniciSil').click(function () {
                    var idd2 = $(this).data('id');
                    Swal.fire({
                        title: 'Devam etmek için lütfen şifrenizi girin.',
                        input: 'password',
                        showCancelButton: true,
                        confirmButtonColor: "#4caf50",
                        cancelButtonColor: "#f44336",
                        confirmButtonText: "Onayla",
                        cancelButtonText: "İptal",
                        allowOutsideClick: false,
                        showLoaderOnConfirm: false,
                    }).then(function (kPass) {
                        if(kPass.value){
                            Swal.fire({
                                type: 'info',
                                title: "Lütfen bekleyin",
                                showConfirmButton: false,
                                allowOutsideClick: false,
                            });
                            postToUrl('/adminpanel/kkullanicisil', {id: idd2,pass: kPass.value}, false);
                        }else{
                            Swal.fire({
                                type: 'warning',
                                title: "Şifrenizi girerek tekrar deneyiniz.",
                                showConfirmButton: false,
                                cancelButtonText: "Kapat",
                                cancelButtonColor: "#ff8c00",
                                showCancelButton: true,
                                allowOutsideClick: true,
                            });
                        }
                    });
                });
                $('.sa-aKullaniciSil').click(function () {
                    var idd2 = $(this).data('id');
                    Swal.fire({
                        title: 'Devam etmek için lütfen şifrenizi girin.',
                        input: 'password',
                        showCancelButton: true,
                        confirmButtonColor: "#4caf50",
                        cancelButtonColor: "#f44336",
                        confirmButtonText: "Onayla",
                        cancelButtonText: "İptal",
                        allowOutsideClick: false,
                        showLoaderOnConfirm: false,
                    }).then(function (kPass) {
                        if(kPass.value){
                            Swal.fire({
                                type: 'info',
                                title: "Lütfen bekleyin",
                                showConfirmButton: false,
                                allowOutsideClick: false,
                            });
                            postToUrl('/adminpanel/akullanicisil', {id: idd2,pass: kPass.value}, false);
                        }else{
                            Swal.fire({
                                type: 'warning',
                                title: "Şifrenizi girerek tekrar deneyiniz.",
                                showConfirmButton: false,
                                cancelButtonText: "Kapat",
                                cancelButtonColor: "#ff8c00",
                                showCancelButton: true,
                                allowOutsideClick: true,
                            });
                        }
                    });
                });
                $('.sa-dBasvuruSil').click(function () {
                    var idd2 = $(this).data('id');
                    Swal.fire({
                        title: 'Emin misiniz?',
                        text: "Başvuruyu silmek istediğinize emin misiniz?",
                        type: "question",
                        showCancelButton: true,
                        confirmButtonColor: "#4caf50",
                        cancelButtonColor: "#f44336",
                        confirmButtonText: "Onayla",
                        cancelButtonText: "İptal",
                        allowOutsideClick: false,
                    }).then(function (result) {
                        if (result.value) {
                            Swal.fire({
                                type: 'info',
                                title: "Lütfen bekleyin",
                                showConfirmButton: false,
                                allowOutsideClick: false,
                            });
                            postToUrl('/adminpanel/dbasvurusil', {id: idd2}, false);
                        }
                    });
                });
                $('.sa-yBasvuruSil1').click(function () {
                    var idd2 = $(this).data('id');
                    Swal.fire({
                        title: 'Emin misiniz?',
                        text: "Kodu kullanılabilir hale getirip başvuruyu silmek istediğinize emin misiniz?",
                        type: "question",
                        showCancelButton: true,
                        confirmButtonColor: "#4caf50",
                        cancelButtonColor: "#f44336",
                        confirmButtonText: "Onayla",
                        cancelButtonText: "İptal",
                        allowOutsideClick: false,
                    }).then(function (result) {
                        if (result.value) {
                            Swal.fire({
                                type: 'info',
                                title: "Lütfen bekleyin",
                                showConfirmButton: false,
                                allowOutsideClick: false,
                            });
                            postToUrl('/adminpanel/yasbvurusil1', {id: idd2}, false);
                        }
                    });
                });
                $('.sa-yBasvuruSil2').click(function () {
                    var idd2 = $(this).data('id');
                    Swal.fire({
                        title: 'Emin misiniz?',
                        text: "Kodu ile beraber başvuruyu silmek istediğinize emin misiniz?",
                        type: "question",
                        showCancelButton: true,
                        confirmButtonColor: "#4caf50",
                        cancelButtonColor: "#f44336",
                        confirmButtonText: "Onayla",
                        cancelButtonText: "İptal",
                        allowOutsideClick: false,
                    }).then(function (result) {
                        if (result.value) {
                            Swal.fire({
                                type: 'info',
                                title: "Lütfen bekleyin",
                                showConfirmButton: false,
                                allowOutsideClick: false,
                            });
                            postToUrl('/adminpanel/yasbvurusil2', {id: idd2}, false);
                        }
                    });
                });
                $('.sa-configClear').click(function () {
                    Swal.fire({
                        title: 'Emin misiniz?',
                        text: "Config:Clear komutu çalıştırılsın mı?",
                        type: "question",
                        showCancelButton: true,
                        confirmButtonColor: "#4caf50",
                        cancelButtonColor: "#f44336",
                        confirmButtonText: "Onayla",
                        cancelButtonText: "İptal",
                        allowOutsideClick: false,
                    }).then(function (result) {
                        if (result.value) {
                            Swal.fire({
                                type: 'info',
                                title: "Lütfen bekleyin",
                                showConfirmButton: false,
                                allowOutsideClick: false,
                            });
                            postToUrl('/adminpanel/configclear', {}, false);
                        }
                    });
                });
                $('.sa-cacheClear').click(function () {
                    Swal.fire({
                        title: 'Emin misiniz?',
                        text: "Cache:Clear komutu çalıştırılsın mı?",
                        type: "question",
                        showCancelButton: true,
                        confirmButtonColor: "#4caf50",
                        cancelButtonColor: "#f44336",
                        confirmButtonText: "Onayla",
                        cancelButtonText: "İptal",
                        allowOutsideClick: false,
                    }).then(function (result) {
                        if (result.value) {
                            Swal.fire({
                                type: 'info',
                                title: "Lütfen bekleyin",
                                showConfirmButton: false,
                                allowOutsideClick: false,
                            });
                            postToUrl('/adminpanel/cacheclear', {}, false);
                        }
                    });
                });
                $('.sa-configCache').click(function () {
                    Swal.fire({
                        title: 'Emin misiniz?',
                        text: "Config:Cache komutu çalıştırılsın mı?",
                        type: "question",
                        showCancelButton: true,
                        confirmButtonColor: "#4caf50",
                        cancelButtonColor: "#f44336",
                        confirmButtonText: "Onayla",
                        cancelButtonText: "İptal",
                        allowOutsideClick: false,
                    }).then(function (result) {
                        if (result.value) {
                            Swal.fire({
                                type: 'info',
                                title: "Lütfen bekleyin",
                                showConfirmButton: false,
                                allowOutsideClick: false,
                            });
                            postToUrl('/adminpanel/configcache', {}, false);
                        }
                    });
                });
                $('.sa-optimizeClear').click(function () {
                    Swal.fire({
                        title: 'Emin misiniz?',
                        text: "Optimize:Clear komutu çalıştırılsın mı?",
                        type: "question",
                        showCancelButton: true,
                        confirmButtonColor: "#4caf50",
                        cancelButtonColor: "#f44336",
                        confirmButtonText: "Onayla",
                        cancelButtonText: "İptal",
                        allowOutsideClick: false,
                    }).then(function (result) {
                        if (result.value) {
                            Swal.fire({
                                type: 'info',
                                title: "Lütfen bekleyin",
                                showConfirmButton: false,
                                allowOutsideClick: false,
                            });
                            postToUrl('/adminpanel/optimizeclear', {}, false);
                        }
                    });
                });
                $('.sa-serverUp').click(function () {
                    Swal.fire({
                        title: 'Emin misiniz?',
                        text: "Sunucu açılsın mı?",
                        type: "question",
                        showCancelButton: true,
                        confirmButtonColor: "#4caf50",
                        cancelButtonColor: "#f44336",
                        confirmButtonText: "Onayla",
                        cancelButtonText: "İptal",
                        allowOutsideClick: false,
                    }).then(function (result) {
                        if (result.value) {
                            Swal.fire({
                                type: 'info',
                                title: "Lütfen bekleyin",
                                showConfirmButton: false,
                                allowOutsideClick: false,
                            });
                            postToUrl('/adminpanel/sunucuac', {}, false);
                        }
                    });
                });
                $('.sa-serverDown').click(function () {
                    Swal.fire({
                        title: 'Emin misiniz?',
                        text: "Sunucu kapatılsın mı?",
                        type: "question",
                        showCancelButton: true,
                        confirmButtonColor: "#4caf50",
                        cancelButtonColor: "#f44336",
                        confirmButtonText: "Onayla",
                        cancelButtonText: "İptal",
                        allowOutsideClick: false,
                    }).then(function (result) {
                        if (result.value) {
                            Swal.fire({
                                type: 'info',
                                title: "Lütfen bekleyin",
                                showConfirmButton: false,
                                allowOutsideClick: false,
                            });
                            postToUrl('/adminpanel/sunucukapat', {}, false);
                        }
                    });
                });
                $('.sa-boolSetSil').click(function () {
                    var idd2 = $(this).data('id');
                    Swal.fire({
                        title: 'Emin misiniz?',
                        text: "Boolean ayar silinsin mi?",
                        type: "question",
                        showCancelButton: true,
                        confirmButtonColor: "#4caf50",
                        cancelButtonColor: "#f44336",
                        confirmButtonText: "Onayla",
                        cancelButtonText: "İptal",
                        allowOutsideClick: false,
                    }).then(function (result) {
                        if (result.value) {
                            Swal.fire({
                                type: 'info',
                                title: "Lütfen bekleyin",
                                showConfirmButton: false,
                                allowOutsideClick: false,
                            });
                            postToUrl('/adminpanel/boolayarsil', {id: idd2}, false);
                        }
                    });
                });
                $('.sa-stringSetSil').click(function () {
                    var idd2 = $(this).data('id');
                    Swal.fire({
                        title: 'Emin misiniz?',
                        text: "String ayar silinsin mi?",
                        type: "question",
                        showCancelButton: true,
                        confirmButtonColor: "#4caf50",
                        cancelButtonColor: "#f44336",
                        confirmButtonText: "Onayla",
                        cancelButtonText: "İptal",
                        allowOutsideClick: false,
                    }).then(function (result) {
                        if (result.value) {
                            Swal.fire({
                                type: 'info',
                                title: "Lütfen bekleyin",
                                showConfirmButton: false,
                                allowOutsideClick: false,
                            });
                            postToUrl('/adminpanel/stringayarsil', {id: idd2}, false);
                        }
                    });
                });

                //sto

                $('.sa-stoPaySil').click(function () {
                    var idd2 = $(this).data('id');
                    Swal.fire({
                        title: 'Emin misiniz?',
                        type: "question",
                        html: "Paylaşımı silmek istediğinize emin misiniz?<br><text class='text-primary font-weight-bold'>Bu işlem geri alınamaz.</text>",
                        showCancelButton: true,
                        confirmButtonColor: "#4caf50",
                        cancelButtonColor: "#f44336",
                        confirmButtonText: "Onayla",
                        cancelButtonText: "İptal",
                        allowOutsideClick: false,
                    }).then(function (result) {
                        if (result.value) {
                            Swal.fire({
                                type: 'info',
                                title: "Lütfen bekleyin",
                                showConfirmButton: false,
                                allowOutsideClick: false,
                            });
                            postToUrl('/yoneticipaneli/paysil', {id: idd2}, false);
                        }
                    });
                });
                $('.sa-stoPayPasif').click(function () {
                    var idd2 = $(this).data('id');
                    Swal.fire({
                        title: 'Emin misiniz?',
                        type: "question",
                        html: "Paylaşımı pasif hale getirmek istediğinize emin misiniz?<br><text class='text-primary font-weight-bold'>Bu işlem geri alınamaz.</text>",
                        showCancelButton: true,
                        confirmButtonColor: "#4caf50",
                        cancelButtonColor: "#f44336",
                        confirmButtonText: "Onayla",
                        cancelButtonText: "İptal",
                        allowOutsideClick: false,
                    }).then(function (result) {
                        if (result.value) {
                            Swal.fire({
                                type: 'info',
                                title: "Lütfen bekleyin",
                                showConfirmButton: false,
                                allowOutsideClick: false,
                            });
                            postToUrl('/yoneticipaneli/paypasif', {id: idd2}, false);
                        }
                    });
                });
                $('.sa-stoArtSil').click(function () {
                    var idd2 = $(this).data('id');
                    Swal.fire({
                        title: 'Emin misiniz?',
                        type: "question",
                        html: "Yazıyı silmek istediğinize emin misiniz?<br><text class='text-primary font-weight-bold'>Bu işlem geri alınamaz.</text>",
                        showCancelButton: true,
                        confirmButtonColor: "#4caf50",
                        cancelButtonColor: "#f44336",
                        confirmButtonText: "Onayla",
                        cancelButtonText: "İptal",
                        allowOutsideClick: false,
                    }).then(function (result) {
                        if (result.value) {
                            Swal.fire({
                                type: 'info',
                                title: "Lütfen bekleyin",
                                showConfirmButton: false,
                                allowOutsideClick: false,
                            });
                            postToUrl('/yoneticipaneli/yazisil', {id: idd2}, false);
                        }
                    });
                });
                $('.sa-stoArtPasif').click(function () {
                    var idd2 = $(this).data('id');
                    Swal.fire({
                        title: 'Emin misiniz?',
                        type: "question",
                        html: "Yazıyı pasif hale getirmek istediğinize emin misiniz?<br><text class='text-primary font-weight-bold'>Bu işlem geri alınamaz.</text>",
                        showCancelButton: true,
                        confirmButtonColor: "#4caf50",
                        cancelButtonColor: "#f44336",
                        confirmButtonText: "Onayla",
                        cancelButtonText: "İptal",
                        allowOutsideClick: false,
                    }).then(function (result) {
                        if (result.value) {
                            Swal.fire({
                                type: 'info',
                                title: "Lütfen bekleyin",
                                showConfirmButton: false,
                                allowOutsideClick: false,
                            });
                            postToUrl('/yoneticipaneli/yazipasif', {id: idd2}, false);
                        }
                    });
                });
                $('.sa-stoActSil').click(function () {
                    var idd2 = $(this).data('id');
                    Swal.fire({
                        title: 'Emin misiniz?',
                        type: "question",
                        html: "Etkinliği silmek istediğinize emin misiniz?<br><text class='text-primary font-weight-bold'>Bu işlem geri alınamaz.</text>",
                        showCancelButton: true,
                        confirmButtonColor: "#4caf50",
                        cancelButtonColor: "#f44336",
                        confirmButtonText: "Onayla",
                        cancelButtonText: "İptal",
                        allowOutsideClick: false,
                    }).then(function (result) {
                        if (result.value) {
                            Swal.fire({
                                type: 'info',
                                title: "Lütfen bekleyin",
                                showConfirmButton: false,
                                allowOutsideClick: false,
                            });
                            postToUrl('/yoneticipaneli/etksil', {id: idd2}, false);
                        }
                    });
                });
                $('.sa-stoActPasif').click(function () {
                    var idd2 = $(this).data('id');
                    Swal.fire({
                        title: 'Emin misiniz?',
                        type: "question",
                        html: "Etkinliği pasif hale getirmek istediğinize emin misiniz?<br><text class='text-primary font-weight-bold'>Bu işlem geri alınamaz.</text>",
                        showCancelButton: true,
                        confirmButtonColor: "#4caf50",
                        cancelButtonColor: "#f44336",
                        confirmButtonText: "Onayla",
                        cancelButtonText: "İptal",
                        allowOutsideClick: false,
                    }).then(function (result) {
                        if (result.value) {
                            Swal.fire({
                                type: 'info',
                                title: "Lütfen bekleyin",
                                showConfirmButton: false,
                                allowOutsideClick: false,
                            });
                            postToUrl('/yoneticipaneli/etkpasif', {id: idd2}, false);
                        }
                    });
                });
                $('.sa-stoActTickCancel').click(function () {
                    var idd2 = $(this).data('id');
                    Swal.fire({
                        title: 'Emin misiniz?',
                        type: "question",
                        html: "Bilet satışını durdurmak istediğinize emin misiniz?",
                        showCancelButton: true,
                        confirmButtonColor: "#4caf50",
                        cancelButtonColor: "#f44336",
                        confirmButtonText: "Onayla",
                        cancelButtonText: "İptal",
                        allowOutsideClick: false,
                    }).then(function (result) {
                        if (result.value) {
                            Swal.fire({
                                type: 'info',
                                title: "Lütfen bekleyin",
                                showConfirmButton: false,
                                allowOutsideClick: false,
                            });
                            postToUrl('/yoneticipaneli/etkbilsatkapat', {id: idd2}, false);
                        }
                    });
                });
                $('.sa-stoActTickOpen').click(function () {
                    var idd2 = $(this).data('id');
                    Swal.fire({
                        title: 'Emin misiniz?',
                        type: "question",
                        html: "Bilet satışını açmak istediğinize emin misiniz?",
                        showCancelButton: true,
                        confirmButtonColor: "#4caf50",
                        cancelButtonColor: "#f44336",
                        confirmButtonText: "Onayla",
                        cancelButtonText: "İptal",
                        allowOutsideClick: false,
                    }).then(function (result) {
                        if (result.value) {
                            Swal.fire({
                                type: 'info',
                                title: "Lütfen bekleyin",
                                showConfirmButton: false,
                                allowOutsideClick: false,
                            });
                            postToUrl('/yoneticipaneli/etkbilsatac', {id: idd2}, false);
                        }
                    });
                });
                $('.sa-stoUrnPasif').click(function () {
                    var idd2 = $(this).data('id');
                    Swal.fire({
                        title: 'Emin misiniz?',
                        type: "question",
                        text: "Ürünü pasif hale getirmek istediğinize emin misiniz?",
                        showCancelButton: true,
                        confirmButtonColor: "#4caf50",
                        cancelButtonColor: "#f44336",
                        confirmButtonText: "Onayla",
                        cancelButtonText: "İptal",
                        allowOutsideClick: false,
                    }).then(function (result) {
                        if (result.value) {
                            Swal.fire({
                                type: 'info',
                                title: "Lütfen bekleyin",
                                showConfirmButton: false,
                                allowOutsideClick: false,
                            });
                            postToUrl('/yoneticipaneli/urnpasif', {id: idd2}, false);
                        }
                    });
                });
                $('.sa-stoUrnAktif').click(function () {
                    var idd2 = $(this).data('id');
                    Swal.fire({
                        title: 'Emin misiniz?',
                        type: "question",
                        text: "Ürünü aktif hale getirmek istediğinize emin misiniz?",
                        showCancelButton: true,
                        confirmButtonColor: "#4caf50",
                        cancelButtonColor: "#f44336",
                        confirmButtonText: "Onayla",
                        cancelButtonText: "İptal",
                        allowOutsideClick: false,
                    }).then(function (result) {
                        if (result.value) {
                            Swal.fire({
                                type: 'info',
                                title: "Lütfen bekleyin",
                                showConfirmButton: false,
                                allowOutsideClick: false,
                            });
                            postToUrl('/yoneticipaneli/urnaktif', {id: idd2}, false);
                        }
                    });
                });
                $('.sa-stoDelUrnQr').click(function () {
                    var idd2 = $(this).data('id');
                    Swal.fire({
                        title: 'Emin misiniz?',
                        type: "question",
                        html: "Ürününüze ait aktif QR kodaları silmek istediğinize emin misiniz?<br><text class='text-primary font-weight-bold'>Bu işlem geri alınamaz.</text>",
                        showCancelButton: true,
                        confirmButtonColor: "#4caf50",
                        cancelButtonColor: "#f44336",
                        confirmButtonText: "Onayla",
                        cancelButtonText: "İptal",
                        allowOutsideClick: false,
                    }).then(function (result) {
                        if (result.value) {
                            Swal.fire({
                                type: 'info',
                                title: "Lütfen bekleyin",
                                showConfirmButton: false,
                                allowOutsideClick: false,
                            });
                            postToUrl('/yoneticipaneli/urndelqrs', {id: idd2}, false);
                        }
                    });
                });
                $('.sa-stoUrnQr').click(function () {
                    var idd2 = $(this).data('id');
                    Swal.fire({
                        title: 'Emin misiniz?',
                        type: "question",
                        html: "Ürününüze ait 150 adet QR kod oluşturulacak ve kayıtlı e-posta adresinize gönderilecektir.<br>Onaylıyor musunu?",
                        showCancelButton: true,
                        confirmButtonColor: "#4caf50",
                        cancelButtonColor: "#f44336",
                        confirmButtonText: "Onayla",
                        cancelButtonText: "İptal",
                        allowOutsideClick: false,
                    }).then(function (result) {
                        if (result.value) {
                            Swal.fire({
                                type: 'info',
                                title: "Lütfen bekleyin",
                                text: "Bu işlem biraz zaman alabilir.",
                                showConfirmButton: false,
                                allowOutsideClick: false,
                            });
                            postToUrl('/yoneticipaneli/qrolustur', {id: idd2}, false);
                        }
                    });
                });
                $('.btn-okundu').click(function () {
                    Swal.fire({
                        type: 'info',
                        title: "Lütfen bekleyin",
                        showConfirmButton: false,
                        allowOutsideClick: false,
                    });
                    postToUrl('/yoneticipaneli/bildirimlerokundu', {}, false);
                });
                $('.sa-cancelDBasvuru').click(function () {
                    var idd2 = $(this).data('id');
                    Swal.fire({
                        title: 'Emin misiniz?',
                        type: "question",
                        html: "Başvurunuzu iptal etmek istediğinize emin misiniz?<br><text class='text-primary font-weight-bold'>Bu işlem geri alınamaz.</text>",
                        showCancelButton: true,
                        confirmButtonColor: "#4caf50",
                        cancelButtonColor: "#f44336",
                        confirmButtonText: "Onayla",
                        cancelButtonText: "İptal",
                        allowOutsideClick: false,
                    }).then(function (result) {
                        if (result.value) {
                            Swal.fire({
                                type: 'info',
                                title: "Lütfen bekleyin",
                                showConfirmButton: false,
                                allowOutsideClick: false,
                            });
                            postToUrl('/yoneticipaneli/canceldbasvuru', {id: idd2}, false);
                        }
                    });
                });

                function postToUrl(url, params, newWindow) {
                    var form = $('<form>');
                    form.attr('action', url);
                    form.attr('method', 'GET');
                    if (newWindow) {
                        form.attr('target', '_blank');
                    }

                    var addParam = function (paramName, paramValue) {
                        var input = $('<input type="hidden">');
                        input.attr({
                            'id': paramName,
                            'name': paramName,
                            'value': paramValue
                        });
                        form.append(input);
                    };

                    // Params is an Array.
                    if (params instanceof Array) {
                        for (var i = 0; i < params.length; i++) {
                            addParam(i, params[i]);
                        }
                    }

                    // Params is an Associative array or Object.
                    if (params instanceof Object) {
                        for (var key in params) {
                            addParam(key, params[key]);
                        }
                    }

                    // Submit the form, then remove it from the page
                    form.appendTo(document.body);
                    form.submit();
                    form.remove();
                }

                $('.sa-title').click(function () {
                    var idd2 = $(this).data('id');
                    Swal.fire({
                        title: "Onay",
                        text: 'Seçtiğiniz ürün için 72 adet QR kod kayıtlı e-posta adresinize gönderilecektir. Onaylıyor musunuz?',
                        type: 'question',
                        showCancelButton: true,
                        confirmButtonColor: "#4caf50",
                        cancelButtonColor: "#f44336",
                        confirmButtonText: "Onayla",
                        cancelButtonText: "İptal",
                        allowOutsideClick: false,
                    }).then(function (result) {
                        if (result.value) {
                            Swal.fire({
                                type: 'info',
                                title: "Lütfen bekleyin",
                                showConfirmButton: false,
                                allowOutsideClick: false,
                            });
                            postToUrl('/portalmakeqr?item_id=' + idd2, {item_id: idd2}, false);
                        }
                    });
                }); //Success Message

                $('.sa-warning').click(function () {
                    var idd2 = $(this).data('id');
                    Swal.fire({
                        title: 'Emin misiniz?',
                        text: "Yazınızı inaktif hale getirmek istediğinize emin misiniz? " +
                            "<text class='text-primary font-weight-bold'>Bu işlem geri alınamaz.</text>",
                        type: "question",
                        showCancelButton: true,
                        confirmButtonColor: "#4caf50",
                        cancelButtonColor: "#f44336",
                        confirmButtonText: "Onayla",
                        cancelButtonText: "İptal",
                        allowOutsideClick: false,
                    }).then(function (result) {
                        if (result.value) {
                            Swal.fire({
                                type: 'info',
                                title: "Lütfen bekleyin",
                                showConfirmButton: false,
                                allowOutsideClick: false,
                            });
                            postToUrl('/getyaziinaktifet?article_id=' + idd2, {article_id: idd2}, false);
                        }
                    });
                });

                $('.sa-delete-item').click(function () {
                    var idd2 = $(this).data('id');
                    Swal.fire({
                        title: 'Emin misiniz?',
                        text: "Ürününüzü silmek istediğinize emin misiniz? " +
                            "<text class='text-primary font-weight-bold'>Bu işlem geri alınamaz.</text>",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#4caf50",
                        cancelButtonColor: "#f44336",
                        confirmButtonText: "Onayla",
                        cancelButtonText: "İptal",
                        allowOutsideClick: false,
                    }).then(function (result) {
                        if (result.value) {
                            Swal.fire({
                                type: 'info',
                                title: "Lütfen bekleyin",
                                showConfirmButton: false,
                                allowOutsideClick: false,
                            });
                            postToUrl('/portaldeleteitem?item_id=' + idd2, {item_id: idd2}, false);

                        }
                    });
                });

                $('#sa-basic').on('click', function () {
                    Swal.fire({
                        title: 'Any fool can use a computer',
                        confirmButtonColor: '#ff8c00'
                    });
                }); //A title with a text under

                $('#sa-success').click(function (e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Good job!',
                        text: 'You clicked the button!',
                        type: 'success',
                        showCancelButton: true,
                        confirmButtonColor: '#ff8c00',
                        cancelButtonColor: "#f46a6a"
                    });
                }); //Warning Message

                $('#sa-params').click(function () {
                    Swal.fire({
                        title: 'Emin misiniz?',
                        text: "Yazınızı psifize etmek istediğinize emin misiniz? <text class='text-primary font-weight-bold'>Bu işlem geri alınamaz.</text>",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, delete it!',
                        cancelButtonText: 'No, cancel!',
                        confirmButtonClass: 'btn btn-success mt-2',
                        cancelButtonClass: 'btn btn-danger ml-2 mt-2',
                        buttonsStyling: false
                    }).then(function (result) {
                        if (result.value) {
                            Swal.fire({
                                title: 'Deleted!',
                                text: 'Your file has been deleted.',
                                type: 'success'
                            });
                        } else if ( // Read more about handling dismissals
                            result.dismiss === Swal.DismissReason.cancel) {
                            Swal.fire({
                                title: 'Cancelled',
                                text: 'Your imaginary file is safe :)',
                                type: 'error',
                            });
                        }
                    });
                }); //Custom Image

                $('#sa-image').click(function (e) {
                    e.preventDefault();
                    var link = $(this).attr('href');
                    Swal.fire({
                        title: 'Logo',
                        text: '',
                        imageUrl: link,
                        imageHeight: 300,
                        confirmButtonColor: "#ff8c00",
                        animation: false,
                        confirmButtonText: 'Geri Dön',
                    })
                });

                $('#sa-image2').click(function (e) {
                    e.preventDefault();
                    var link = $(this).attr('href');
                    Swal.fire({
                        title: 'Kapak Fotoğrafı',
                        text: '',
                        imageUrl: link,
                        confirmButtonColor: "#ff8c00",
                        animation: false,
                        confirmButtonText: 'Geri Dön',
                    })
                });

                $('#sa-close').click(function () {
                    var timerInterval;
                    Swal.fire({
                        title: 'Auto close alert!',
                        html: 'I will close in <strong></strong> seconds.',
                        timer: 2000,
                        onBeforeOpen: function onBeforeOpen() {
                            Swal.showLoading();
                            timerInterval = setInterval(function () {
                                Swal.getContent().querySelector('strong').textContent = Swal.getTimerLeft();
                            }, 100);
                        },
                        onClose: function onClose() {
                            clearInterval(timerInterval);
                        }
                    }).then(function (result) {
                        if ( // Read more about handling dismissals
                            result.dismiss === Swal.DismissReason.timer) {
                            console.log('I was closed by the timer');
                        }
                    });
                }); //custom html alert

                $('#custom-html-alert').click(function () {
                    Swal.fire({
                        title: '<i>HTML</i> <u>example</u>',
                        type: 'info',
                        html: 'You can use <b>bold text</b>, ' + '<a href="//Themesbrand.in/">links</a> ' + 'and other HTML tags',
                        showCloseButton: true,
                        showCancelButton: true,
                        confirmButtonClass: 'btn btn-success',
                        cancelButtonClass: 'btn btn-danger ml-1',
                        confirmButtonColor: "#47bd9a",
                        cancelButtonColor: "#f46a6a",
                        confirmButtonText: '<i class="fas fa-thumbs-up mr-1"></i> Great!',
                        cancelButtonText: '<i class="fas fa-thumbs-down"></i>'
                    });
                }); //position

                $('#sa-position').click(function () {
                    Swal.fire({
                        position: 'top-end',
                        type: 'success',
                        title: 'Your work has been saved',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }); //Custom width padding

                $('#custom-padding-width-alert').click(function () {
                    Swal.fire({
                        title: 'Custom width, padding, background.',
                        width: 600,
                        padding: 100,
                        confirmButtonColor: "#ff8c00",
                        background: '#fff url(//subtlepatterns2015.subtlepatterns.netdna-cdn.com/patterns/geometry.png)'
                    });
                }); //Ajax

                $('.ajax-alert').click(function () {
                    Swal.fire({
                        title: 'Submit email to run ajax request',
                        text: 'Devam etmek için lütfen şifrenizi girin.',
                        input: 'text',
                        showCancelButton: true,
                        confirmButtonColor: "#4caf50",
                        cancelButtonColor: "#f44336",
                        confirmButtonText: "Onayla",
                        cancelButtonText: "İptal",
                        allowOutsideClick: false,
                        showLoaderOnConfirm: true,
                        preConfirm: function preConfirm(kPass) {
                            return new Promise(function (resolve, reject) {
                                setTimeout(function () {
                                    if (!kPass) {
                                        reject('Lütfen şifrenizi girin.');
                                    } else {
                                        resolve();
                                    }
                                }, 200);
                            });
                        },
                    }).then(function (kPass) {
                        Swal.fire({
                            type: 'success',
                            title: 'Ajax request finished!',
                            html: 'Submitted email: ' + kPass.value
                        });
                    });
                }); //chaining modal alert

                $('#chaining-alert').click(function () {
                    Swal.mixin({
                        input: 'text',
                        confirmButtonText: 'Next &rarr;',
                        showCancelButton: true,
                        confirmButtonColor: "#ff8c00",
                        cancelButtonColor: "#74788d",
                        progressSteps: ['1', '2', '3']
                    }).queue([{
                        title: 'Question 1',
                        text: 'Chaining swal2 modals is easy'
                    }, 'Question 2', 'Question 3']).then(function (result) {
                        if (result.value) {
                            Swal.fire({
                                title: 'All done!',
                                html: 'Your answers: <pre><code>' + JSON.stringify(result.value) + '</code></pre>',
                                confirmButtonText: 'Lovely!'
                            });
                        }
                    });
                }); //Danger

                $('#dynamic-alert').click(function () {
                    swal.queue([{
                        title: 'Your public IP',
                        confirmButtonColor: "#ff8c00",
                        confirmButtonText: 'Show my public IP',
                        text: 'Your public IP will be received ' + 'via AJAX request',
                        showLoaderOnConfirm: true,
                        preConfirm: function preConfirm() {
                            return new Promise(function (resolve) {
                                $.get('https://api.ipify.org?format=json').done(function (data) {
                                    swal.insertQueueStep(data.ip);
                                    resolve();
                                });
                            });
                        }
                    }])["catch"](swal.noop);
                });
            }, //init
                $.SweetAlert = new SweetAlert(), $.SweetAlert.Constructor = SweetAlert;
        }(window.jQuery), //initializing
            function ($) {
                "use strict";

                $.SweetAlert.init();
            }(window.jQuery);

        /***/
    }),

    /***/ 24:
    /*!*******************************************************!*\
      !*** multi ./resources/js/pages/sweet-alerts.init.js ***!
      \*******************************************************/
    /*! no static exports found */
    /***/ (function (module, exports, __webpack_require__) {

        module.exports = __webpack_require__(/*! F:\wamp\www\Work\Qovex\Laravel\resources\js\pages\sweet-alerts.init.js */"./resources/js/pages/sweet-alerts.init.js");


        /***/
    })

    /******/
});
