SELECT
    post.linkImmagine,
    post.data,
    COUNT(postlikes.idLike) AS likes,
    utenti.username
FROM
    post
    LEFT JOIN postlikes ON post.idPost = postlikes.idPost
    LEFT JOIN utenti ON post.idUtente = utenti.idUtente
GROUP BY 
    post.idPost;