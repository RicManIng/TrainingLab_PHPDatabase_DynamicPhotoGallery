function createPostCard(post){
    let cardsContainer = document.getElementById('loadedContents');

    let card = document.createElement('div');
    card.className = 'card';
    cardsContainer.appendChild(card);

    let cardImgContainer = document.createElement('div');
    cardImgContainer.className = 'cardImgContainer';
    cardImgContainer.style.backgroundImage = `url(${post.linkImmagine})`;
    card.appendChild(cardImgContainer);

    let cardInfoContainer = document.createElement('div');
    cardInfoContainer.className = 'cardInfoContainer';
    card.appendChild(cardInfoContainer);

    let cardDate = document.createElement('p');
    cardDate.className = 'cardDate';
    cardDate.textContent = post.data;
    cardInfoContainer.appendChild(cardDate);

    let cardLikeContainer = document.createElement('div');
    cardLikeContainer.className = 'cardLikeContainer';
    cardInfoContainer.appendChild(cardLikeContainer);

    let cardLike = document.createElement('p');
    cardLike.className = 'cardLike';
    cardLike.textContent = post.numeroLikes;
    cardLikeContainer.appendChild(cardLike);

    let cardLikeIcon = document.createElement('i');
    cardLikeIcon.className = 'fas fa-heart';
    cardLikeContainer.appendChild(cardLikeIcon);

    let cardCommandsContainer = document.createElement('div');
    cardCommandsContainer.className = 'cardCommandsContainer';
    card.appendChild(cardCommandsContainer);

    let modifyIcon = document.createElement('i');
    modifyIcon.className = 'fas fa-edit fa-2x';
    modifyIcon.onclick = function(){
        window.location.href = "addPost.php?state=modify&postId=" + post.id;
    }
    cardCommandsContainer.appendChild(modifyIcon);

    let deleteIcon = document.createElement('i');
    deleteIcon.className = 'fas fa-trash fa-2x';
    deleteIcon.onclick = function(){
        window.location.href = "addPost.php?state=delete&postId=" + post.id;
    }
    cardCommandsContainer.appendChild(deleteIcon);

}

window.onload = function(){
    console.log(loadedContents);
    console.log(loadedContents.length);

    if(loadedContents.length == 1 && loadedContents[0]['id'] == null){
        let noContents = document.createElement('p');
        noContents.textContent = "Non hai ancora caricato nessun contenuto";
        noContents.style.textAlign = 'center';
        noContents.style.color = 'brown';
        document.getElementById('loadedContents').appendChild(noContents);
    } else{
        loadedContents.forEach(post => {
            createPostCard(post);    
        });
    }

    let addContentButton = document.getElementById('addContent');
    let deleteAccountButton = document.getElementById('deleteAccount');

    addContentButton.onclick = function(){
        window.location.href = "addPost.php?state=add";
    }

    deleteAccountButton.onclick = function(){
        window.location.href = "deleteUser.php";
    }
}