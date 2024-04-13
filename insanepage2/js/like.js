  if (!isLiked) {
    // Если лайк еще не поставлен, изменяем его состояние на "поставлен"
    isLiked = true;
    // Меняем иконку лайка и текст кнопки
    likeButton.innerHTML = '<span class="like-icon">❤️</span><span class="like-text">Liked</span>';
  } else {
    // Если лайк уже поставлен, изменяем его состояние на "не поставлен"
    isLiked = false;
    // Меняем иконку лайка и текст кнопки обратно
    likeButton.innerHTML = '<span class="like-icon">🤍</span><span class="like-text">Like</span>';
  }