document.addEventListener("DOMContentLoaded", function () {
  if (!$) {
    console.warn('jQuery not available');
    return;
  }
  $('#addFavourite').click(function () {
    const pathParts = String(window.location.href).split('/');
    const characterId = pathParts[pathParts.length - 1];
    console.log('adding favourite for characterId:', characterId);
    $.post('/favourites/add', {
      characterId
    }, function (result) {
      console.log('XHR result', result);
    });
  });
  console.log('favourites.js loaded');
});