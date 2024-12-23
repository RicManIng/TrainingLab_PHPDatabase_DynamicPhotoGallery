SELECT 
    post.linkImmagine,
    post.data,
    post.descrizione,
    utenti.username
FROM
    post
    LEFT JOIN utenti ON post.idUtente = utenti.idUtente
WHERE
    post.idPost = ?;
