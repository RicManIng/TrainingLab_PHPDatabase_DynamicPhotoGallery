
function createCard(cardElt){
    let cardContainer = document.getElementById("cardsContainer");
    let card = document.createElement("div");
    card.classList.add("card");
    cardContainer.appendChild(card);

    let cardImg = document.createElement("img");
    cardImg.src = cardElt.linkImmagine;
    card.appendChild(cardImg);

    

    let infoContainer = document.createElement("div");
    infoContainer.classList.add("infoContainer");
    card.appendChild(infoContainer);

    let cardAuthor = document.createElement("p");
    cardAuthor.innerHTML = cardElt.username;
    infoContainer.appendChild(cardAuthor);

    let cardDate = document.createElement("p");
    cardDate.innerHTML = cardElt.data;
    infoContainer.appendChild(cardDate);

    let cardLikesContainer = document.createElement("div");
    cardLikesContainer.classList.add("likesContainer");
    infoContainer.appendChild(cardLikesContainer);
    let cardLikes = document.createElement("p");
    cardLikes.innerHTML = cardElt.likes;
    cardLikesContainer.appendChild(cardLikes);
    let likeIcon = document.createElement("i");
    likeIcon.classList.add("fas");
    likeIcon.classList.add("fa-heart");
    cardLikesContainer.appendChild(likeIcon);
}

window.onload = function(){
    cardsArray.array.forEach(element => {
        createCard(element);
    });
}