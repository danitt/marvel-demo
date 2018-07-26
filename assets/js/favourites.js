document.addEventListener("DOMContentLoaded", function () {
  if (!$) {
    console.warn('jQuery not available');
    return;
  }

  // Add Favourite
  $('#addFavourite').click(function () {
    const pathParts = String(window.location.href).split('/');
    const characterId = pathParts[pathParts.length - 1];
    console.log('adding favourite for characterId:', characterId);
    $.post('/favourites/add', {
      characterId
    }, function (result) {
      console.log('XHR result', result);
      window.location.reload();
    });
  });

  // Remove Favourite
  $('#removeFavourite').click(function () {
    const pathParts = String(window.location.href).split('/');
    const characterId = pathParts[pathParts.length - 1];
    console.log('removing favourite for characterId:', characterId);
    $.post('/favourites/remove', {
      characterId
    }, function (result) {
      console.log('XHR result', result);
      window.location.reload();
    });
  });

  console.log('favourites.js loaded');
});