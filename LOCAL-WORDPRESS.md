# Ambiente WordPress locale

Questo progetto usa un ambiente locale senza Docker:

- WordPress core in `.local-wordpress/wordpress`
- database SQLite in `.local-wordpress/data`
- temi montati da `themes/` tramite symlink

## Avvio rapido

```bash
./scripts/setup-local-wordpress.sh
./scripts/start-local-wordpress.sh
```

Poi apri:

- Sito: `http://localhost:8080`
- Admin: `http://localhost:8080/wp-admin/`

Credenziali locali create dallo script:

- Utente: `admin`
- Password: `admin`

## Note

Lo script attiva il tema `sotb` e crea le pagine `Home`, `News`, `Tornei` e `Contatti`.

I file dentro `themes/` sono quelli del repository: modificare il tema locale modifica gli stessi file del progetto.
