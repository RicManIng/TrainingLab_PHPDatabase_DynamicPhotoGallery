SELECT
    utenti.username,
    utenti.password,
    utenti.idUtente
FROM
    utenti
WHERE
    utenti.username = ?;