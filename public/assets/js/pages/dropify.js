$(function() {
  'use strict';

  $('#image').dropify();
  $('#image2').dropify();
  $('#video').dropify({
      messages: {
          "default": "Videonuzu sürükleyip bırakın veya buraya tıklayın",
          replace: "Yeni video eklemek için, sürükleyin ve bırakın veya buraya tıklayın",
          remove: "Kaldır",
          error: "Ooops, bir hata oluştu."
      },
  });
    $('#lImage').dropify({
        error: {
            'imageFormat': 'Seçtiğiniz görsel yatay formatta olmalıdır.',
        },
    });
    $('#lImage2').dropify({
        error: {
            'imageFormat': 'Seçtiğiniz görsel yatay formatta olmalıdır.',
        },
    });
    $('#avatar1').dropify();
    $('#cover_photo1').dropify();
});
