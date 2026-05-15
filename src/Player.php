<?php declare(strict_types=1);
namespace ClubManager;

class Player
{
    private int $id;
    private string $nome;
    private string $cognome;
    private int $annoNascita;
    private string $ruolo;
    private ?int $numeroMaglia;
    private string $codiceFiscale;
    private string $contattoGenitore;
    private bool $attivo;
    private ?int $squadraId;

    public function __construct(
        string $nome,
        string $cognome,
        int $annoNascita,
        string $ruolo,
        ?int $numeroMaglia,
        string $codiceFiscale,
        string $contattoGenitore,
        bool $attivo = true,
        ?int $squadraId = null,
        int $id = 0
    ) {
        $this->nome = $nome;
        $this->cognome = $cognome;
        $this->annoNascita = $annoNascita;
        $this->ruolo = $ruolo;
        $this->numeroMaglia = $numeroMaglia;
        $this->codiceFiscale = $codiceFiscale;
        $this->contattoGenitore = $contattoGenitore;
        $this->attivo = $attivo;
        $this->squadraId = $squadraId;
        $this->id = $id;
    }

    // Getters
    public function getId(): int { return $this->id; }
    public function getNome(): string { return $this->nome; }
    public function getCognome(): string { return $this->cognome; }
    public function getAnnoNascita(): int { return $this->annoNascita; }
    public function getRuolo(): string { return $this->ruolo; }
    public function getNumeroMaglia(): ?int { return $this->numeroMaglia; }
    public function getCodiceFiscale(): string { return $this->codiceFiscale; }
    public function getContattoGenitore(): string { return $this->contattoGenitore; }
    public function isAttivo(): bool { return $this->attivo; }
    public function getSquadraId(): ?int { return $this->squadraId; }

    // Setters
    public function setId(int $id): void { $this->id = $id; }
    public function setSquadraId(?int $squadraId): void { $this->squadraId = $squadraId; }
}