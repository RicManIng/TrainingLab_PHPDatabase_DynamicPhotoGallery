SELECT
    post.linkImmagine,
    post.data,
    COUNT(postlikes.idLike) AS likes,
    utenti.username,
    (
        SELECT
            GROUP_CONCAT(utenti.username SEPARATOR ', ')
        FROM
            utenti
            INNER JOIN postlikes ON utenti.idUtente = postlikes.idUtente
        WHERE
            postlikes.idPost = post.idPost
    ) AS likeUsers
FROM
    post
    LEFT JOIN postlikes ON post.idPost = postlikes.idPost
    LEFT JOIN utenti ON post.idUtente = utenti.idUtente
WHERE
    post.idPost = ?
GROUP BY
    post.idPost;