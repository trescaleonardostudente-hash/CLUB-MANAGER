<?php declare(strict_types=1);
require_once __DIR__ . '/../vendor/autoload.php';
use PHPUnit\Framework\TestCase;
use ClubManager\Player;
use ClubManager\PlayerRepository;
use ClubManager\DatabaseInterface;

require_once __DIR__ . '/../src/Player.php';
require_once __DIR__ . '/../src/PlayerRepository.php';

class MockDatabase implements DatabaseInterface
{
    public $queries = [];
    public $lastInsertId = 123;

    public function prepare(string $query)
    {
        $this->queries[] = $query;
        return new MockStatement($this);
    }

    public function insert_id(): int
    {
        return $this->lastInsertId;
    }
}

class MockStatement
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function bind_param($types, ...$params): void
    {
        // Mock
    }

    public function execute(): bool
    {
        return true;
    }
}

final class PlayerRepositoryTest extends TestCase
{
    // Testa il salvataggio di un nuovo giocatore nel database, verificando che l'ID sia impostato e la query sia corretta
    public function testSavePlayer(): void
    {
        $mockDb = new MockDatabase();
        $repo = new PlayerRepository($mockDb);

        $player = new Player('Mario', 'Rossi', 2000, 'Attaccante', 10, 'MRSS00A00A000A', 'mario@rossi.com');

        $result = $repo->save($player);

        $this->assertTrue($result);
        $this->assertEquals(123, $player->getId());
        $this->assertCount(1, $mockDb->queries);
        $this->assertStringContainsString('INSERT INTO giocatori', $mockDb->queries[0]);
    }

    // Testa il collegamento di un giocatore a una squadra, verificando che la query di inserimento sia eseguita
    public function testLinkToTeam(): void
    {
        $mockDb = new MockDatabase();
        $repo = new PlayerRepository($mockDb);

        $result = $repo->linkToTeam(1, 2);

        $this->assertTrue($result);
        $this->assertCount(1, $mockDb->queries);
        $this->assertStringContainsString('INSERT INTO squadre_giocatori', $mockDb->queries[0]);
    }
}