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
    return __webpack_require__(__webpack_require__.s = 8);
    /******/
})
    /************************************************************************/
    /******/ ({

    /***/ "./resources/js/pages/datatables.init.js":
    /*!***********************************************!*\
      !*** ./resources/js/pages/datatables.init.js ***!
      \***********************************************/
    /*! no static exports found */
    /***/ (function (module, exports) {


        $(document).ready(function () {

            var table = $('#dtCommon').DataTable({
                "aLengthMenu": [
                    [10, 30, 50, -1],
                    [10, 30, 50, "Tüm"]
                ],
                "iDisplayLength": 10,
                "language": {
                    "paginate": {
                        "previous": "<i class='uil uil-angle-left'>",
                        "next": "<i class='uil uil-angle-right'>"
                    }
                },
                "drawCallback": function drawCallback() {
                    $('.dataTables_paginate > .pagination').addClass('pagination-rounded');
                }
            });
            var table2 = $('#dtCommon2').DataTable({
                "aLengthMenu": [
                    [10, 30, 50, -1],
                    [10, 30, 50, "Tüm"]
                ],
                "iDisplayLength": 10,
                "language": {
                    "paginate": {
                        "previous": "<i class='uil uil-angle-left'>",
                        "next": "<i class='uil uil-angle-right'>"
                    }
                },
                "drawCallback": function drawCallback() {
                    $('.dataTables_paginate > .pagination').addClass('pagination-rounded');
                }
            });
            var table3 = $('#dtCommon3').DataTable({
                "aLengthMenu": [
                    [10, 30, 50, -1],
                    [10, 30, 50, "Tüm"]
                ],
                "iDisplayLength": 10,
                "language": {
                    "paginate": {
                        "previous": "<i class='uil uil-angle-left'>",
                        "next": "<i class='uil uil-angle-right'>"
                    }
                },
                "drawCallback": function drawCallback() {
                    $('.dataTables_paginate > .pagination').addClass('pagination-rounded');
                }
            });
            var table4 = $('#dtCommon4').DataTable({
                "aLengthMenu": [
                    [10, 30, 50, -1],
                    [10, 30, 50, "Tüm"]
                ],
                "iDisplayLength": 10,
                "language": {
                    "paginate": {
                        "previous": "<i class='uil uil-angle-left'>",
                        "next": "<i class='uil uil-angle-right'>"
                    }
                },
                "drawCallback": function drawCallback() {
                    $('.dataTables_paginate > .pagination').addClass('pagination-rounded');
                }
            });
            var table5 = $('#dtCommon5').DataTable({
                "aLengthMenu": [
                    [10, 30, 50, -1],
                    [10, 30, 50, "Tüm"]
                ],
                dom: 'lfrtipB',
                buttons: {
                    buttons: [
                        'copy', 'print', 'excelHtml5',

                    ],
                    dom: {
                        button: {
                            tag: "button",
                            className: "btn btn-primary"
                        },
                        buttonLiner: {
                            tag: null
                        }
                    }
                },
                "iDisplayLength": 10,
                "language": {
                    "paginate": {
                        "previous": "<i class='uil uil-angle-left'>",
                        "next": "<i class='uil uil-angle-right'>"
                    }
                },
                "drawCallback": function drawCallback() {
                    $('.dataTables_paginate > .pagination').addClass('pagination-rounded');
                }
            });

            var tblActSto = $('#tblActSto').DataTable({
                "aLengthMenu": [
                    [10, 30, 50, -1],
                    [10, 30, 50, "Tüm"]
                ],
                "iDisplayLength": 10,
                "language": {
                    "paginate": {
                        "previous": "<i class='uil uil-angle-left'>",
                        "next": "<i class='uil uil-angle-right'>"
                    }
                },
                "drawCallback": function drawCallback() {
                    $('.dataTables_paginate > .pagination').addClass('pagination-rounded');
                },
                "order": [[ 3, "desc" ]],
                columnDefs: [ {
                    orderable: false,
                    className: 'select-checkbox',
                    targets:   0
                },{
                    orderable: false,
                    targets: 5
                } ],

                select: {
                    style:    'multi',
                    selector: 'td:first-child',
                },
                dom: 'Brtip',
                buttons: [
                    {
                        extend: 'delete',
                        className: 'btn btn-sm btn-primary',
                        action: function ( e, dt, node, config ) {
                            var rows = dt.rows( { selected: true } ).count();
                            var data = dt.rows( { selected: true } ).data();
                            var arr = [];
                            for (var i = 0; i < rows; i++) {
                                arr.push(data[i][1]);
                            }
                            Swal.fire({
                                title: 'Emin misiniz?',
                                type: "question",
                                html: "Seçili paylaşımları silmek istediğinize emin misiniz?<br><text class='text-primary font-weight-bold'>Bu işlem geri alınamaz.</text>",
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
                                    actionToUrl("/yoneticipaneli/coklupaysil",{ids:arr},false);
                                }
                            });
                        }
                    },
                    {
                        extend: 'selectAll',
                        className: 'btn btn-sm btn-primary',
                    },
                    {
                        extend: 'selectNone',
                        className: 'btn btn-sm btn-primary',
                    },
                ]
            });
            var tblPasSto = $('#tblPasSto').DataTable({
                "aLengthMenu": [
                    [10, 30, 50, -1],
                    [10, 30, 50, "Tüm"]
                ],
                "iDisplayLength": 10,
                "language": {
                    "paginate": {
                        "previous": "<i class='uil uil-angle-left'>",
                        "next": "<i class='uil uil-angle-right'>"
                    }
                },
                "drawCallback": function drawCallback() {
                    $('.dataTables_paginate > .pagination').addClass('pagination-rounded');
                },
                "order": [[ 3, "desc" ]],
                columnDefs: [ {
                    orderable: false,
                    className: 'select-checkbox',
                    targets:   0
                },{
                    orderable: false,
                    targets: 5
                } ],

                select: {
                    style:    'multi',
                    selector: 'td:first-child',
                },
                dom: 'Brtip',
                buttons: [
                    {
                        extend: 'delete',
                        className: 'btn btn-sm btn-primary',
                        action: function ( e, dt, node, config ) {
                            var rows = dt.rows( { selected: true } ).count();
                            var data = dt.rows( { selected: true } ).data();
                            var arr = [];
                            for (var i = 0; i < rows; i++) {
                                arr.push(data[i][1]);
                            }
                            Swal.fire({
                                title: 'Emin misiniz?',
                                type: "question",
                                html: "Seçili paylaşımları silmek istediğinize emin misiniz?<br><text class='text-primary font-weight-bold'>Bu işlem geri alınamaz.</text>",
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
                                    actionToUrl("/yoneticipaneli/coklupaysil",{ids:arr},false);
                                }
                            });
                        }
                    },
                    {
                        extend: 'selectAll',
                        className: 'btn btn-sm btn-primary',
                    },
                    {
                        extend: 'selectNone',
                        className: 'btn btn-sm btn-primary',
                    },
                ]
            });

            var tblActArt = $('#tblActArt').DataTable({
                "aLengthMenu": [
                    [10, 30, 50, -1],
                    [10, 30, 50, "Tüm"]
                ],
                "iDisplayLength": 10,
                "language": {
                    "paginate": {
                        "previous": "<i class='uil uil-angle-left'>",
                        "next": "<i class='uil uil-angle-right'>"
                    }
                },
                "drawCallback": function drawCallback() {
                    $('.dataTables_paginate > .pagination').addClass('pagination-rounded');
                },
                "order": [[ 4, "desc" ]],
                columnDefs: [ {
                    orderable: false,
                    className: 'select-checkbox',
                    targets:   0
                },{
                    orderable: false,
                    targets: 7
                } ],
                select: {
                    style:    'multi',
                    selector: 'td:first-child',
                },
                dom: 'Brtip',
                buttons: [
                    {
                        extend: 'delete',
                        className: 'btn btn-sm btn-primary',
                        action: function ( e, dt, node, config ) {
                            var rows = dt.rows( { selected: true } ).count();
                            var data = dt.rows( { selected: true } ).data();
                            var arr = [];
                            for (var i = 0; i < rows; i++) {
                                arr.push(data[i][1]);
                            }
                            Swal.fire({
                                title: 'Emin misiniz?',
                                type: "question",
                                html: "Seçili yazıları silmek istediğinize emin misiniz?<br><text class='text-primary font-weight-bold'>Bu işlem geri alınamaz.</text>",
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
                                    actionToUrl("/yoneticipaneli/cokluyazisil",{ids:arr},false);
                                }
                            });
                        }
                    },
                    {
                        extend: 'selectAll',
                        className: 'btn btn-sm btn-primary',
                    },
                    {
                        extend: 'selectNone',
                        className: 'btn btn-sm btn-primary',
                    },
                ]
            });
            var tblPasArt = $('#tblPasArt').DataTable({
                "aLengthMenu": [
                    [10, 30, 50, -1],
                    [10, 30, 50, "Tüm"]
                ],
                "iDisplayLength": 10,
                "language": {
                    "paginate": {
                        "previous": "<i class='uil uil-angle-left'>",
                        "next": "<i class='uil uil-angle-right'>"
                    }
                },
                "drawCallback": function drawCallback() {
                    $('.dataTables_paginate > .pagination').addClass('pagination-rounded');
                },
                "order": [[ 4, "desc" ]],
                columnDefs: [ {
                    orderable: false,
                    className: 'select-checkbox',
                    targets:   0
                },{
                    orderable: false,
                    targets: 7
                } ],
                select: {
                    style:    'multi',
                    selector: 'td:first-child',
                },
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'delete',
                        className: 'btn btn-sm btn-primary',
                        action: function ( e, dt, node, config ) {
                            var rows = dt.rows( { selected: true } ).count();
                            var data = dt.rows( { selected: true } ).data();
                            var arr = [];
                            for (var i = 0; i < rows; i++) {
                                arr.push(data[i][1]);
                            }
                            Swal.fire({
                                title: 'Emin misiniz?',
                                type: "question",
                                html: "Seçili yazıları silmek istediğinize emin misiniz?<br><text class='text-primary font-weight-bold'>Bu işlem geri alınamaz.</text>",
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
                                    actionToUrl("/yoneticipaneli/cokluyazisil",{ids:arr},false);
                                }
                            });
                        }
                    },
                    {
                        extend: 'selectAll',
                        className: 'btn btn-sm btn-primary',
                    },
                    {
                        extend: 'selectNone',
                        className: 'btn btn-sm btn-primary',
                    },
                ]
            });

            var tblActAct = $('#tblActAct').DataTable({
                "aLengthMenu": [
                    [10, 30, 50, -1],
                    [10, 30, 50, "Tüm"]
                ],
                "iDisplayLength": 10,
                "language": {
                    "paginate": {
                        "previous": "<i class='uil uil-angle-left'>",
                        "next": "<i class='uil uil-angle-right'>"
                    }
                },
                "drawCallback": function drawCallback() {
                    $('.dataTables_paginate > .pagination').addClass('pagination-rounded');
                },
                "order": [[ 3, "desc" ]],
                columnDefs: [ {
                    orderable: false,
                    targets: 7
                } ],
                select: {
                    style:    'multi',
                    selector: 'td:first-child',
                },
                dom: 'rtip',
            });
            var tblPasAct = $('#tblPasAct').DataTable({
                "aLengthMenu": [
                    [10, 30, 50, -1],
                    [10, 30, 50, "Tüm"]
                ],
                "iDisplayLength": 10,
                "language": {
                    "paginate": {
                        "previous": "<i class='uil uil-angle-left'>",
                        "next": "<i class='uil uil-angle-right'>"
                    }
                },
                "drawCallback": function drawCallback() {
                    $('.dataTables_paginate > .pagination').addClass('pagination-rounded');
                },
                "order": [[ 3, "desc" ]],
                columnDefs: [ {
                    orderable: false,
                    targets: 7
                } ],
                select: {
                    style:    'multi',
                    selector: 'td:first-child',
                },
                dom: 'frtip',
            });

            var tblUruns = $('#tblUruns').DataTable({
                "aLengthMenu": [
                    [10, 30, 50, -1],
                    [10, 30, 50, "Tüm"]
                ],
                "iDisplayLength": 10,
                "language": {
                    "paginate": {
                        "previous": "<i class='uil uil-angle-left'>",
                        "next": "<i class='uil uil-angle-right'>"
                    }
                },
                "drawCallback": function drawCallback() {
                    $('.dataTables_paginate > .pagination').addClass('pagination-rounded');
                },
                "order": [[ 7, "desc" ]],
                columnDefs: [ {
                    orderable: false,
                    className: 'select-checkbox',
                    targets:   0
                },{
                    orderable: false,
                    targets: [5,10]
                } ],
                select: {
                    style:    'multi',
                    selector: 'td:first-child',
                },
                dom: 'Bflrtip',
                buttons: [
                    {
                        extend: 'pacify',
                        className: 'btn btn-sm btn-primary',
                        action: function ( e, dt, node, config ) {
                            var rows = dt.rows( { selected: true } ).count();
                            var data = dt.rows( { selected: true } ).data();
                            var arr = [];
                            for (var i = 0; i < rows; i++) {
                                arr.push(data[i][1]);
                            }
                            Swal.fire({
                                title: 'Emin misiniz?',
                                type: "question",
                                text: "Seçili ürünleri pasifize etmek istediğinize emin misiniz?",
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
                                    actionToUrl("/yoneticipaneli/cokluurunpasif",{ids:arr},false);
                                }
                            });
                        }
                    },
                    {
                        extend: 'qr',
                        className: 'btn btn-sm btn-primary',
                        action: function ( e, dt, node, config ) {
                            var rows = dt.rows( { selected: true } ).count();
                            var data = dt.rows( { selected: true } ).data();
                            var arr = [];
                            for (var i = 0; i < rows; i++) {
                                arr.push(data[i][1]);
                            }
                            if(arr.length > 3){
                                Swal.fire({
                                    title: 'Uyarı',
                                    type: "warning",
                                    text: "Bu özelliği kullanmak için en fazla 3 adet ürün seçmelisiniz.",
                                });
                            }else{
                                Swal.fire({
                                    title: 'Emin misiniz?',
                                    type: "question",
                                    html: "Seçili ürünler için 150'şer adet QR kod oluşturulacak ve kayıtlı e-posta adresinize gönderilecektir.<br>Onaylıyor musunuz?",
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
                                            text: "Bu işlem biraz zaman alabilir",
                                            showConfirmButton: false,
                                            allowOutsideClick: false,
                                        });
                                        actionToUrl("/yoneticipaneli/cokluqrolustur",{ids:arr},false);
                                    }
                                });
                            }

                        }
                    },
                    {
                        extend: 'selectAll',
                        className: 'btn btn-sm btn-primary',
                    },
                    {
                        extend: 'selectNone',
                        className: 'btn btn-sm btn-primary',
                    },
                ]
            });
            var tblUruns2 = $('#tblUruns2').DataTable({
                "aLengthMenu": [
                    [10, 30, 50, -1],
                    [10, 30, 50, "Tüm"]
                ],
                "iDisplayLength": 10,
                "language": {
                    "paginate": {
                        "previous": "<i class='uil uil-angle-left'>",
                        "next": "<i class='uil uil-angle-right'>"
                    }
                },
                "drawCallback": function drawCallback() {
                    $('.dataTables_paginate > .pagination').addClass('pagination-rounded');
                },
                "order": [[ 7, "desc" ]],
                columnDefs: [ {
                    orderable: false,
                    className: 'select-checkbox',
                    targets:   0
                },{
                    orderable: false,
                    targets: [5,9]
                } ],
                select: {
                    style:    'multi',
                    selector: 'td:first-child',
                },
                dom: 'Bflrtip',
                buttons: [
                    {
                        extend: 'pacify',
                        className: 'btn btn-sm btn-primary',
                        action: function ( e, dt, node, config ) {
                            var rows = dt.rows( { selected: true } ).count();
                            var data = dt.rows( { selected: true } ).data();
                            var arr = [];
                            for (var i = 0; i < rows; i++) {
                                arr.push(data[i][1]);
                            }
                            Swal.fire({
                                title: 'Emin misiniz?',
                                type: "question",
                                text: "Seçili ürünleri pasifize etmek istediğinize emin misiniz?",
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
                                    actionToUrl("/yoneticipaneli/cokluurunpasif",{ids:arr},false);
                                }
                            });
                        }
                    },
                    {
                        extend: 'selectAll',
                        className: 'btn btn-sm btn-primary',
                    },
                    {
                        extend: 'selectNone',
                        className: 'btn btn-sm btn-primary',
                    },
                ]
            });

            var tblFBasvurus = $('#tblFBasvurus').DataTable({
                "aLengthMenu": [
                    [10, 30, 50, -1],
                    [10, 30, 50, "Tüm"]
                ],
                "iDisplayLength": 10,
                "language": {
                    "paginate": {
                        "previous": "<i class='uil uil-angle-left'>",
                        "next": "<i class='uil uil-angle-right'>"
                    }
                },
                "drawCallback": function drawCallback() {
                    $('.dataTables_paginate > .pagination').addClass('pagination-rounded');
                },
                "order": [[ 3, "desc" ]],
                columnDefs: [ {
                    orderable: false,
                    targets:   0
                },{
                    orderable: false,
                    targets: 4
                } ],
            });

            var tblActCards = $('#tblActCards').DataTable({
                "aLengthMenu": [
                    [10, 30, 50, -1],
                    [10, 30, 50, "Tüm"]
                ],
                "iDisplayLength": 10,
                "language": {
                    "paginate": {
                        "previous": "<i class='uil uil-angle-left'>",
                        "next": "<i class='uil uil-angle-right'>"
                    }
                },
                "drawCallback": function drawCallback() {
                    $('.dataTables_paginate > .pagination').addClass('pagination-rounded');
                },
                "order": [[ 3, "desc" ]],

            });
            var tblAvCards = $('#tblAvCards').DataTable({
                "aLengthMenu": [
                    [10, 30, 50, -1],
                    [10, 30, 50, "Tüm"]
                ],
                "iDisplayLength": 10,
                "language": {
                    "paginate": {
                        "previous": "<i class='uil uil-angle-left'>",
                        "next": "<i class='uil uil-angle-right'>"
                    }
                },
                "drawCallback": function drawCallback() {
                    $('.dataTables_paginate > .pagination').addClass('pagination-rounded');
                },
                "order": [[ 3, "desc" ]],

            });
            var tblUdCards = $('#tblUdCards').DataTable({
                "aLengthMenu": [
                    [10, 30, 50, -1],
                    [10, 30, 50, "Tüm"]
                ],
                "iDisplayLength": 10,
                "language": {
                    "paginate": {
                        "previous": "<i class='uil uil-angle-left'>",
                        "next": "<i class='uil uil-angle-right'>"
                    }
                },
                "drawCallback": function drawCallback() {
                    $('.dataTables_paginate > .pagination').addClass('pagination-rounded');
                },
                "order": [[ 3, "desc" ]],

            });


            var tblUserLogs = $('#tblUserLogs').DataTable({
                dom: 'rtip',
                "iDisplayLength": 10,
                "language": {
                    "paginate": {
                        "previous": "<i class='uil uil-angle-left'>",
                        "next": "<i class='uil uil-angle-right'>"
                    }
                },
                "drawCallback": function drawCallback() {
                    $('.dataTables_paginate > .pagination').addClass('pagination-rounded');
                },
                "order": [[ 2, "desc" ]],
                columnDefs: [ {
                    orderable: false,
                    targets:   0
                },{
                    orderable: false,
                    targets: 1
                } ],

            });
            var tblStoreLogs = $('#tblStoreLogs').DataTable({
                dom: 'rtip',
                "iDisplayLength": 10,
                "language": {
                    "paginate": {
                        "previous": "<i class='uil uil-angle-left'>",
                        "next": "<i class='uil uil-angle-right'>"
                    }
                },
                "drawCallback": function drawCallback() {
                    $('.dataTables_paginate > .pagination').addClass('pagination-rounded');
                },
                "order": [[ 2, "desc" ]],
                columnDefs: [ {
                    orderable: false,
                    targets:   0
                },{
                    orderable: false,
                    targets: 1
                } ],

            });
            var tblBrandLogs = $('#tblBrandLogs').DataTable({
                dom: 'rtip',
                "iDisplayLength": 10,
                "language": {
                    "paginate": {
                        "previous": "<i class='uil uil-angle-left'>",
                        "next": "<i class='uil uil-angle-right'>"
                    }
                },
                "drawCallback": function drawCallback() {
                    $('.dataTables_paginate > .pagination').addClass('pagination-rounded');
                },
                "order": [[ 2, "desc" ]],
                columnDefs: [ {
                    orderable: false,
                    targets:   0
                },{
                    orderable: false,
                    targets: 1
                } ],

            });

            function actionToUrl(url, params, newWindow) {
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                var form = $('<form>');
                form.attr('action', url);
                form.attr('method', 'POST');
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

                var input2 = $('<input type="hidden">');
                input2.attr({
                    'id': '_token',
                    'name': '_token',
                    'value': CSRF_TOKEN,
                });
                form.append(input2);

                // Submit the form, then remove it from the page
                form.appendTo(document.body);
                form.submit();
                form.remove();
            }

            $('#basic-datatable').DataTable({
                "language": {
                    "paginate": {
                        "previous": "<i class='uil uil-angle-left'>",
                        "next": "<i class='uil uil-angle-right'>"
                    }
                },
                "drawCallback": function drawCallback() {
                    $('.dataTables_paginate > .pagination').addClass('pagination-rounded');
                }
            }); //Buttons examples

            $('#selection-datatable').DataTable({
                select: {
                    style: 'multi'
                },
                "language": {
                    "paginate": {
                        "previous": "<i class='uil uil-angle-left'>",
                        "next": "<i class='uil uil-angle-right'>"
                    }
                },
                "drawCallback": function drawCallback() {
                    $('.dataTables_paginate > .pagination').addClass('pagination-rounded');
                }
            }); // Key Datatable

            $('#key-datatable').DataTable({
                keys: true,
                "language": {
                    "paginate": {
                        "previous": "<i class='uil uil-angle-left'>",
                        "next": "<i class='uil uil-angle-right'>"
                    }
                },
                "drawCallback": function drawCallback() {
                    $('.dataTables_paginate > .pagination').addClass('pagination-rounded');
                }
            });

        });

        /***/
    }),

    /***/ 8:
    /*!*****************************************************!*\
      !*** multi ./resources/js/pages/datatables.init.js ***!
      \*****************************************************/
    /*! no static exports found */
    /***/ (function (module, exports, __webpack_require__) {

        module.exports = __webpack_require__(/*! /Users/nikhil/projects/themes/shreyu/laravel/resources/js/pages/datatables.init.js */"./resources/js/pages/datatables.init.js");


        /***/
    })

    /******/
});
