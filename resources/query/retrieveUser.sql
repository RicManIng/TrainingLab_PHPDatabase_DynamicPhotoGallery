SELECT
    utenti.username,
    utenti.password
FROM
    utenti
WHERE
    utenti.username = ?;