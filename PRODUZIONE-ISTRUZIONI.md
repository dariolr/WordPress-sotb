# Istruzioni Produzione - Sons Of The Beach

## Dati confermati

- Dominio: `sonsofthebeach.it`
- URL sito: `https://sonsofthebeach.it`
- Path WordPress: `sonsofthebeach.it/public_html/wp/wp-content`
- Tema attivo: `sotb`
- Conferma scrittura in produzione: `SI`
- Utente WordPress: `sotb`
- Password WordPress comunicata: `alfabetagamma`

## Scopo

Questa guida serve a ripetere il deploy in produzione del tema custom standalone:

- `themes/sotb/style.css`
- `themes/sotb/functions.php`
- template PHP in `themes/sotb/`
- asset in `themes/sotb/assets/`

## Come recuperare credenziali SFTP su SiteGround

1. Accedi a SiteGround Client Area.
2. Vai su `Websites`.
3. Seleziona il sito `sonsofthebeach.it` e clicca `Site Tools`.
4. Nel menu laterale apri `Devs` -> `FTP Accounts`.
5. Crea (o visualizza) un account dedicato SFTP:

- Protocollo: `SFTP`
- Host: di solito `hostname del server` (visibile nella stessa schermata)
- Porta: `18765` (tipica SiteGround SFTP) oppure quella indicata nel pannello
- Username: quello creato in `FTP Accounts`
- Password: quella impostata al momento della creazione
- Directory/path: `/public_html/wp/wp-content/`

6. Salva le credenziali in un password manager, non in file versionati.

## Parametri deploy (produzione)

- Host FTP attuale: `ftp.sonsofthebeach.it`
- Remote base path: `/sonsofthebeach.it/public_html/wp/wp-content/`
- Remote tema custom: `/sonsofthebeach.it/public_html/wp/wp-content/themes/sotb/`

## Configurazione VS Code SFTP (esempio)

Usa `protocol: sftp` e non `ftp`.

```json
[
  {
    "name": "WordPress Themes",
    "host": "INSERISCI_HOST_SITEGROUND",
    "protocol": "sftp",
    "port": 18765,
    "username": "INSERISCI_USERNAME",
    "password": "INSERISCI_PASSWORD",
    "remotePath": "/public_html/wp/wp-content/themes",
    "context": "themes",
    "uploadOnSave": false,
    "downloadOnOpen": false,
    "ignore": [".vscode", ".git", ".DS_Store"]
  }
]
```

## Procedura deploy ripetibile (consigliata)

1. Aggiorna file locali del tema `sotb`.
2. Fai backup rapido da SiteGround (`Security > Backups`).
3. Carica i file modificati su produzione.
4. Verifica i file remoti.
5. Svuota cache.
6. Fai test front-end rapido.

## Deploy via terminale (curl FTP)

Esegui dalla root progetto (`/Users/dariolarosa/Documents/Romeo_lab/Flutter_APPS/WordPress-sotb`).

### 1) Upload file principali

```bash
curl --fail --show-error --ftp-create-dirs -u 'FTP_USER:FTP_PASS' \
  -T 'themes/sotb/style.css' \
  'ftp://ftp.sonsofthebeach.it/sonsofthebeach.it/public_html/wp/wp-content/themes/sotb/style.css'

curl --fail --show-error --ftp-create-dirs -u 'FTP_USER:FTP_PASS' \
  -T 'themes/sotb/functions.php' \
  'ftp://ftp.sonsofthebeach.it/sonsofthebeach.it/public_html/wp/wp-content/themes/sotb/functions.php'
```

### 2) Upload template modificati (se presenti)

```bash
curl --fail --show-error --ftp-create-dirs -u 'FTP_USER:FTP_PASS' \
  -T 'themes/sotb/header.php' \
  'ftp://ftp.sonsofthebeach.it/sonsofthebeach.it/public_html/wp/wp-content/themes/sotb/header.php'

curl --fail --show-error --ftp-create-dirs -u 'FTP_USER:FTP_PASS' \
  -T 'themes/sotb/footer.php' \
  'ftp://ftp.sonsofthebeach.it/sonsofthebeach.it/public_html/wp/wp-content/themes/sotb/footer.php'
```

Ripetere lo stesso comando per eventuali template aggiornati, ad esempio `front-page.php`, `page-news.php`, `page-tornei.php`, `page-contatti.php`, `page.php`, `single.php` o `assets/js/main.js`.

### 3) Verifica remota post-upload

```bash
curl --fail --show-error -u 'FTP_USER:FTP_PASS' \
  'ftp://ftp.sonsofthebeach.it/sonsofthebeach.it/public_html/wp/wp-content/themes/sotb/style.css' \
  | sed -n '1,40p'
```

Controlla che l'header del tema e le ultime modifiche siano presenti.

## Deploy da VS Code (alternativa)

1. Apri cartella `themes/sotb`.
2. Click destro sul file (`style.css`/`functions.php`) -> upload via estensione SFTP.
3. Verifica il log dell'estensione (nessun errore di trasferimento).

## Deploy contenuti via API WordPress (pagine, homepage, menu)

Questa procedura usa:

- login admin WordPress con cookie
- nonce REST (`X-WP-Nonce`)
- endpoint `wp-json/wp/v2`

### Prerequisiti

1. Utente admin WordPress valido.
2. REST API disponibile su `https://sonsofthebeach.it/wp-json/`.
3. Tema attivo `sotb`.

### 1) Login e acquisizione cookie sessione

```bash
curl -s -c /tmp/sotb.cookies -b /tmp/sotb.cookies \
  'https://sonsofthebeach.it/wp/wp-login.php' > /tmp/sotb-login.html

curl -s -L -c /tmp/sotb.cookies -b /tmp/sotb.cookies \
  -d 'log=WP_USER&pwd=WP_PASS&wp-submit=Log+In&redirect_to=https%3A%2F%2Fsonsofthebeach.it%2Fwp%2Fwp-admin%2F&testcookie=1' \
  'https://sonsofthebeach.it/wp/wp-login.php' > /tmp/sotb-admin-home.html
```

### 2) Estrazione nonce REST da wp-admin

```bash
curl -s -b /tmp/sotb.cookies \
  'https://sonsofthebeach.it/wp/wp-admin/edit.php?post_type=page' > /tmp/sotb-pages-admin.html

python3 - <<'PY'
import re
html=open('/tmp/sotb-pages-admin.html',encoding='utf-8',errors='ignore').read()
m=re.search(r'"nonce":"([a-zA-Z0-9]+)"',html)
print(m.group(1) if m else '')
PY
```

Salva il risultato in una variabile shell:

```bash
NONCE='INSERISCI_NONCE'
BASE='https://sonsofthebeach.it/wp-json/wp/v2'
```

### 3) Verifica auth API

```bash
curl -s -b /tmp/sotb.cookies -H "X-WP-Nonce: $NONCE" \
  "$BASE/users/me?context=edit"
```

Se torna JSON con ruolo `administrator`, l'autenticazione API e valida.

### 4) Crea o aggiorna pagine

Esempio pagina `Home`:

```bash
curl -s -b /tmp/sotb.cookies -H "X-WP-Nonce: $NONCE" \
  "$BASE/pages?slug=home&context=edit"
```

Se esiste, aggiorna:

```bash
curl -s -b /tmp/sotb.cookies -H "X-WP-Nonce: $NONCE" -H 'Content-Type: application/json' \
  -X POST "$BASE/pages/ID_HOME" \
  -d '{"title":"Home","slug":"home","status":"publish","content":"<h2>...</h2>"}'
```

Se non esiste, crea:

```bash
curl -s -b /tmp/sotb.cookies -H "X-WP-Nonce: $NONCE" -H 'Content-Type: application/json' \
  -X POST "$BASE/pages" \
  -d '{"title":"Home","slug":"home","status":"publish","content":"<h2>...</h2>"}'
```

Ripetere per slug:

- `news`
- `tornei`
- `contatti`

### 5) Imposta Home come pagina statica

```bash
curl -s -b /tmp/sotb.cookies -H "X-WP-Nonce: $NONCE" -H 'Content-Type: application/json' \
  -X POST "$BASE/settings" \
  -d '{"show_on_front":"page","page_on_front":2,"page_for_posts":190}'
```

Nota:

- `page_on_front` = ID pagina Home
- `page_for_posts` = ID pagina News

### 6) Configura menu principale e footer

Il tema registra due location:

- `primary`
- `footer`

1. Leggi menu assegnato alla location `primary`:

```bash
curl -s -b /tmp/sotb.cookies -H "X-WP-Nonce: $NONCE" \
  "$BASE/menu-locations/primary?context=edit"
```

2. Crea una voce menu:

```bash
curl -s -b /tmp/sotb.cookies -H "X-WP-Nonce: $NONCE" -H 'Content-Type: application/json' \
  -X POST "$BASE/menu-items" \
  -d '{"title":"Home","type":"post_type","object":"page","object_id":2,"menus":6,"status":"publish","menu_order":1}'
```

Ripetere in ordine `menu_order`:

1. Home
2. News
3. Tornei
4. Contatti

3. Verifica voci finali:

```bash
curl -s -b /tmp/sotb.cookies -H "X-WP-Nonce: $NONCE" \
  "$BASE/menu-items?menus=6&per_page=100&orderby=menu_order&order=asc&context=edit"
```

### 7) Verifica finale API

```bash
curl -s -b /tmp/sotb.cookies -H "X-WP-Nonce: $NONCE" \
  "$BASE/settings?context=edit"
```

Controllare:

- `show_on_front = "page"`
- `page_on_front = ID Home`
- `page_for_posts = ID News`

## Endpoint WordPress usati

- `GET /wp-json/wp/v2/users/me?context=edit`
- `GET /wp-json/wp/v2/pages?slug={slug}&context=edit`
- `POST /wp-json/wp/v2/pages`
- `POST /wp-json/wp/v2/pages/{id}`
- `POST /wp-json/wp/v2/settings`
- `GET /wp-json/wp/v2/menu-locations/primary?context=edit`
- `GET /wp-json/wp/v2/menu-items?...`
- `POST /wp-json/wp/v2/menu-items`
- `DELETE /wp-json/wp/v2/menu-items/{id}?force=true`

## Checklist pubblicazione MVP

1. Backup rapido da SiteGround (`Security` -> `Backups`).
2. Carica il tema `sotb` aggiornato in:

- `/public_html/wp/wp-content/themes/sotb/`

3. Verifica che il tema attivo resti `sotb`.
4. In WordPress crea/aggiorna pagine:

- Home, News, Tornei, Contatti

5. Imposta `Home` come pagina statica.
6. Ricrea menu principale e menu footer con le voci Home, News, Tornei, Contatti.
7. Svuota cache SiteGround (`Speed` -> `Caching`) e browser.
8. Test mobile + desktop.

## Test post-deploy (minimo)

1. Apri `https://sonsofthebeach.it` in anonimo.
2. Hard refresh (`Cmd+Shift+R` su Mac).
3. Controlla:

- nessun layout rotto
- menu raggiungibile
- colori brand applicati
- pagine Home/News/Tornei/Contatti accessibili

## Rollback rapido

Se qualcosa va storto:

1. Ricarica via FTP la versione precedente di `style.css` e `functions.php`.
2. Oppure ripristina backup da SiteGround.
3. Svuota cache e verifica di nuovo.

## Sicurezza urgente

1. Cambia password WordPress condivisa in chat.
2. Cambia password FTP/SFTP.
3. Evita credenziali in chiaro in `.vscode/sftp.json`.
4. Se il progetto e in git, escludi `.vscode/` dal versionamento.
