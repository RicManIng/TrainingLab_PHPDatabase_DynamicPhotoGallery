SELECT
    utenti.username
FROM
    utenti
    INNER JOIN postlikes ON utenti.idUtente = postlikes.idUtente
    INNER JOIN post ON post.idPost = postlikes.idPost
WHERE
    postlikes.idPost = ?;