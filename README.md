
# CLUB-MANAGER

Cognome Nome: Tresca Leonardo  
Titolo: CLUB MANAGER  
Tagline: "Tutto il tuo club, in un solo clic."

Descrizione:
ClubManager è una piattaforma web pensata per semplificare e digitalizzare la gestione organizzativa di una società calcistica dilettantistica o giovanile. Il sito consente di centralizzare tutte le informazioni fondamentali per il coordinamento delle attività sportive: squadre, categorie, giocatori, mister, campi e orari di allenamento.

Descrizione completa:
ClubManager fornisce funzionalità per la gestione di squadre, categorie, anagrafiche giocatori, staff tecnico, pianificazione allenamenti, assegnazione campi e invio comunicazioni interne. L'obiettivo è ridurre il carico amministrativo del settore giovanile e delle società dilettantistiche, migliorare la comunicazione interna e rendere accessibili le informazioni operative in modo centralizzato e semplice da usare.

Target:
società calcisiche

Competitors:
- https://www.sportclubby.com/it
- https://www.sporteasy.net/fr/

Tecnologie:
HTML, CSS, JavaScript, PHP, MySQL

1. Requisiti Funzionali
1.1 Gestione Squadre
RF1.1: L’amministratore può creare nuove squadre.
RF1.2: Durante la creazione, è possibile selezionare la categoria (Primi Calci, Pulcini, Esordienti, Giovanissimi, Allievi, Juniores…).
RF1.3: Il sistema assegna automaticamente un ID squadra univoco.
RF1.4: È possibile associare giocatori e staff tecnico alla squadra.
RF1.5: È possibile modificare o eliminare una squadra.


1.2 Anagrafica Giocatori
RF2.1: Registrazione nuovo giocatore con i seguenti dati:
nome, cognome
anno di nascita
ruolo
numero maglia
codice fiscale
contatto genitore (telefono/email)
RF2.2: Possibilità di caricare documenti (certificato medico, tessera FIGC, liberatorie).
RF2.3: Possibilità di aggiornare i dati del giocatore.
RF2.4: Possibilità di archiviare un giocatore non più attivo.
RF2.5: Associare/disassociare un giocatore da una squadra.


1.3 Gestione Mister/Staff
RF3.1: Inserimento anagrafica allenatore:
nome
telefono
email
livello patentino
RF3.2: Assegnazione di uno o più mister a una squadra.
RF3.3: Possibilità di modificare o rimuovere mister associati.


1.4 Gestione Campi Sportivi
RF4.1: Inserimento nuovi campi con:
nome/ID campo
tipologia (erba, sintetico, indoor, a 7, a 11, ecc.)
RF4.2: Definizione orari di disponibilità per ciascun campo.
RF4.3: Modifica o cancellazione di un campo.
RF4.4: Visualizzazione disponibilità settimanale del campo.


1.5 Programmazione Allenamenti
RF5.1: Assegnazione slot orari alle squadre in base ai campi disponibili.
RF5.2: Gestione durata allenamento (es. 1h, 1.5h, ecc.).
RF5.3: Visualizzazione calendario settimanale per:
tutte le squadre
singola squadra
singolo campo
RF5.4: Riconoscimento e segnalazione automatica di sovrapposizioni.
RF5.5: Possibilità di duplicare o ricorrere sessioni settimanali.
RF5.6: Possibilità di spostare allenamenti con drag&drop (se previsto da UI).


1.6 Dashboard Amministrativa
RF6.1: Panoramica squadre attive.
RF6.2: Conteggio totale dei tesserati per categoria.
RF6.3: Statistiche utilizzo campi (per giorno, settimana, fascia oraria).
RF6.4: Alert documenti in scadenza (certificati medici, tessere FIGC).
RF6.5: Notifiche per modifiche allenamenti o aggiornamenti dati.


1.7 Ruoli Utente
RF7.1: Login con credenziali personali.
RF7.2: Amministratore:
può gestire tutte le squadre, orari, campi, utenti.
RF7.3: Allenatore:
può modificare giocatori e staff della propria squadra.
può visualizzare e modificare gli orari della propria squadra.
RF7.4: Visualizzatore:
può solo consultare calendari e anagrafiche, senza modificare.
RF7.5: Il sistema assegna ruoli tramite pannello admin.


1.8 Sistema Documentale
RF8.1: Upload di documenti in formato PDF/JPG/PNG.
RF8.2: Salvataggio su storage locale o cloud.
RF8.3: Alert scadenza documenti.
RF8.4: Download dei documenti dall’interfaccia giocatore.


1.9 Ricerca e Filtri
RF9.1: Ricerca per giocatore (nome/cognome/codice fiscale).
RF9.2: Ricerca squadre per categoria.
RF9.3: Filtraggio allenamenti per campo, giorno, orario.
RF9.4: Filtri documenti scaduti o in scadenza.



LINK PROTOTIPO
[https://sport-team-organizer.lovable.app](https://lovable.dev/projects/0f70866b-f027-4f04-8498-4368c0769ac4)


