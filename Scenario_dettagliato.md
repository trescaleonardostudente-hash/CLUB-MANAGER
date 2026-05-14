Specifica del Caso d'Uso (Scenario Dettagliato)
Nome Caso d'Uso: UC6 - Pianificazione Sessione di Allenamento (con sistema anti-sovrapposizione)
Requisito Funzionale di Riferimento: RF5.1, RF5.4
Attore Primario: Allenatore (Livello 2), Amministratore (Livello 1)
Scopo: Permettere allo staff tecnico di prenotare un campo sportivo per una sessione di allenamento, garantendo che non si creino conflitti logistici e doppie prenotazioni sulla stessa struttura.

1. Pre-condizioni
Affinché il caso d'uso possa avere inizio, devono essere soddisfatte le seguenti condizioni di stato del sistema:

L'attore ha effettuato il login con successo ed è stato autenticato dal middleware con ruolo di Amministratore o Allenatore.

Nel database (tabella squadre) esiste almeno una squadra attiva.

Nel database (tabella campi) esiste almeno un campo sportivo disponibile.

L'attore si trova nel modulo "Area Tecnica" della Dashboard.

2. Post-condizioni
Stato del sistema al termine dell'esecuzione del caso d'uso:

In caso di Successo: Un nuovo record viene inserito nella tabella allenamenti. Il calendario generale, quello della specifica squadra e quello del campo risultano aggiornati con la nuova sessione.

In caso di Fallimento (Eccezione): Nessun record viene scritto nel database. Il sistema rimane nello stato precedente, preservando l'integrità del calendario ed evitando sovrapposizioni.

3. Flusso Principale degli Eventi (Happy Path)
Questo è il percorso standard quando non ci sono errori o conflitti:

Attore: Clicca sul pulsante "Pianifica Sessione" dalla Dashboard.

Sistema: Carica la pagina pianifica_allenamento.php e mostra il modulo di inserimento, popolando i menu a tendina con i campi e le squadre disponibili dal database.

Attore: Seleziona la Squadra, seleziona il Campo e compila i campi "Data", "Ora di Inizio" e "Ora di Fine".

Attore: Invia il modulo cliccando su Conferma (Richiesta POST).

Sistema: Riceve i dati in salva_allenamento.php ed esegue una query di verifica per controllare se le fasce orarie si intersecano con record già esistenti per quello stesso campo in quella data.

Sistema: Constata l'assenza di sovrapposizioni (esito negativo della query di check).

Sistema: Esegue la query di INSERT INTO allenamenti salvando i dati in modo permanente.

Sistema: Reindirizza l'attore alla Dashboard aggiornata.

4. Flussi Alternativi (Gestione delle Eccezioni)
Il sistema è progettato per gestire in sicurezza eventuali errori dell'utente:

Eccezione 5a: Rilevata Sovrapposizione Oraria (RF5.4)
Se al punto 5 del flusso principale il sistema trova un conflitto temporale:

Sistema: La query di check restituisce num_rows > 0 (il campo è già prenotato in un orario che si accavalla con quello richiesto).

Sistema: Blocca immediatamente l'esecuzione del codice (die()), impedendo la scrittura (INSERT) nel database.

Sistema: Mostra una schermata di errore bloccante con il messaggio "ERRORE DI PIANIFICAZIONE: Sovrapposizione rilevata, il campo selezionato è già occupato in quella fascia oraria".

Attore: Clicca sul pulsante "Torna Indietro".

Sistema: Riporta l'attore al punto 2 del flusso principale, invitandolo a selezionare un orario diverso o una struttura alternativa.