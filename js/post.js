function crateLikeCard(username){
    let likesContainer = document.getElementById('likesContainer');
    let likeCard = document.createElement('div');
    likeCard.className = 'likeCard';
    likesContainer.appendChild(likeCard);

    let userIcon = document.createElement('i');
    userIcon.className = 'fas fa-user';
    likeCard.appendChild(userIcon);

    let usertext = document.createElement('p');
    usertext.innerHTML = username;
    likeCard.appendChild(usertext);
}

window.onload = function() {
    likes.forEach(element => {
        crateLikeCard(element.username);
    });
}