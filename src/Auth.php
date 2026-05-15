<?php declare(strict_types=1);
namespace ClubManager;

interface AuthDatabaseInterface
{
    public function prepare(string $query);
}

class Auth
{
    private AuthDatabaseInterface $db;
    private string $role;

    public function __construct(AuthDatabaseInterface $db, int $userId)
    {
        $this->db = $db;
        $this->loadRole($userId);
    }

    private function loadRole(int $userId): void
    {
        $query = $this->db->prepare(" 
        SELECT ruoli.nome AS ruolo
        FROM utenti
        JOIN ruoli ON utenti.ruolo_id = ruoli.id
        WHERE utenti.id = ?
        ");
        $query->bind_param("i", $userId);
        $query->execute();
        $result = $query->get_result()->fetch_assoc();
        $this->role = $result['ruolo'] ?? '';
    }

    public function isAdmin(): bool
    {
        return $this->role === 'Amministratore';
    }

    public function isAllenatore(): bool
    {
        return $this->role === 'Allenatore';
    }

    public function isVisualizzatore(): bool
    {
        return $this->role === 'Visualizzatore';
    }

    public function checkOnlyAdmin(): void
    {
        if (!$this->isAdmin()) {
            throw new \Exception("Accesso negato");
        }
    }

    public function checkOnlyCoachOrAdmin(): void
    {
        if (!$this->isAdmin() && !$this->isAllenatore()) {
            throw new \Exception("Accesso negato");
        }
    }
}