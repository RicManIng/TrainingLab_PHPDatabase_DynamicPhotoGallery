DELETE
FROM
    utenti
WHERE
    utenti.idUtente = ?
    OR utenti.username = ?;