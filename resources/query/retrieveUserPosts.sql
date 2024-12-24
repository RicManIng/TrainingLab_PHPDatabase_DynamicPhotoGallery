SELECT
    post.linkImmagine,
    post.data,
    COUNT(postlikes.idLike) AS numeroLikes,
    post.idPost AS id
FROM
    post
    LEFT JOIN postlikes ON post.idPost = postlikes.idPost
    INNER JOIN utenti ON post.idUtente = utenti.idUtente
WHERE
    utenti.username = ?;