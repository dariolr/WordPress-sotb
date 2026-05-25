# MVP Setup - Sons Of The Beach (WordPress + Elementor)

Questa guida serve a pubblicare la prima versione del sito con 5 pagine:
- Home
- News
- Interviste
- Tornei
- Contatti

## 1) Impostazioni WordPress iniziali

1. Vai in `Impostazioni > Generali`
2. Verifica titolo sito: `Sons Of The Beach`
3. Verifica lingua: `Italiano`

## 2) Crea le pagine

Vai in `Pagine > Aggiungi nuova` e crea:
- Home
- News
- Interviste
- Tornei
- Contatti

Pubblicale tutte.

## 3) Imposta la Home

Vai in `Impostazioni > Lettura`:
- `La tua homepage mostra` -> `Una pagina statica`
- Homepage -> `Home`

## 4) Crea menu principale

Vai in `Aspetto > Menu`:
1. Crea menu `Menu Principale`
2. Aggiungi pagine: Home, News, Interviste, Tornei, Contatti
3. Assegna alla posizione `Primary` (o Header, in base al tema)

## 5) Inserisci i contenuti MVP

Usa i testi nel file:
- `themes/hello-elementor-child/mvp-content.md`

Per ogni pagina:
1. Apri pagina
2. Clicca `Modifica con Elementor`
3. Incolla titolo, testi e card suggerite

## 6) Stile grafico (gia pronto)

Il file CSS del child theme contiene:
- palette colori logo
- card
- hero
- CTA

Classi utili da applicare nei widget Elementor:
- `sotb-hero`
- `sotb-kicker`
- `sotb-card`
- `sotb-section-title`
- `sotb-cta`
- `sotb-meta`

## 7) Instagram (MVP)

Opzione semplice:
1. In Elementor aggiungi widget `HTML` o `Shortcode` nella Home
2. Inserisci embed del profilo/post Instagram

Opzione consigliata (plugin feed):
1. Installa plugin feed Instagram compatibile con Elementor
2. Collega account Instagram
3. Mostra 6 post in Home (sezione Instagram)

## 8) Ruoli staff (non tecnico)

Vai in `Utenti`:
- Redattore 1 -> ruolo `Editor`
- Redattore 2 -> ruolo `Editor`

Flusso consigliato:
1. Bozza articolo
2. Revisione interna
3. Pubblicazione

## 9) Checklist rapida go-live

- Menu corretto
- Home impostata
- Form contatti funzionante
- Instagram visibile
- Link pagine ok
- Mobile verificato (Home/News/Tornei)

## 10) Sicurezza minima urgente

1. Cambia password WP admin condivisa in chat.
2. Cambia password FTP/SFTP.
3. In `.vscode/sftp.json` evita credenziali in chiaro.
