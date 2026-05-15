<?php declare(strict_types=1);
namespace ClubManager;

interface DatabaseInterface
{
    public function prepare(string $query);
    public function insert_id(): int;
}

class PlayerRepository
{
    private DatabaseInterface $db;

    public function __construct(DatabaseInterface $db)
    {
        $this->db = $db;
    }

    public function save(Player $player): bool
    {
        $stmt = $this->db->prepare("INSERT INTO giocatori (nome, cognome, anno_nascita, ruolo, numero_maglia, codice_fiscale, contatto_genitore, attivo, societa_id) VALUES (?, ?, ?, ?, ?, ?, ?, 1, 1)");
        $stmt->bind_param("ssisiss", $player->getNome(), $player->getCognome(), $player->getAnnoNascita(), $player->getRuolo(), $player->getNumeroMaglia(), $player->getCodiceFiscale(), $player->getContattoGenitore());
        
        if ($stmt->execute()) {
            $player->setId($this->db->insert_id());
            return true;
        }
        return false;
    }

    public function linkToTeam(int $playerId, int $teamId): bool
    {
        $stmt = $this->db->prepare("INSERT INTO squadre_giocatori (squadra_id, giocatore_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $teamId, $playerId);
        return $stmt->execute();
    }
}