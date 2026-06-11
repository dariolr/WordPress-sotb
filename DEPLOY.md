# Deploy produzione

Lo script usa WordPress admin per caricare e sostituire il tema `sotb` con uno ZIP generato localmente.

## Uso

```bash
WP_USER='utente' WP_PASS='password' ./scripts/deploy-production.sh
```

Variabili opzionali:

```bash
SITE_URL='https://sonsofthebeach.it'
THEME_SLUG='sotb'
```

## Cosa fa

1. Esegue `php -l` su tutti i file PHP del tema.
2. Crea `.local-wordpress/deploy/sotb.zip`.
3. Effettua login su WordPress admin.
4. Carica lo ZIP da `Aspetto > Temi > Carica tema`.
5. Conferma la sostituzione del tema esistente.
6. Verifica homepage, News, Tornei, Contatti, CSS e asset del pallone.

I file temporanei e cookie di sessione restano in `.local-wordpress/`, esclusa da git.
