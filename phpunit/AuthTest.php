<?php declare(strict_types=1);
require_once __DIR__ . '/../vendor/autoload.php';
use PHPUnit\Framework\TestCase;
use ClubManager\Auth;
use ClubManager\AuthDatabaseInterface;

require_once __DIR__ . '/../src/Auth.php';

class MockAuthDatabase implements AuthDatabaseInterface
{
    public $role = 'Amministratore';

    public function prepare(string $query)
    {
        return new MockAuthStatement($this->role);
    }
}

class MockAuthStatement
{
    private $role;

    public function __construct($role)
    {
        $this->role = $role;
    }

    public function bind_param($types, $param): void
    {
        // Mock
    }

    public function execute(): void
    {
        // Mock
    }

    public function get_result()
    {
        return new MockResult($this->role);
    }
}

class MockResult
{
    private $role;

    public function __construct($role)
    {
        $this->role = $role;
    }

    public function fetch_assoc()
    {
        return ['ruolo' => $this->role];
    }
}

final class AuthTest extends TestCase
{
    // Testa che un utente con ruolo 'Amministratore' sia riconosciuto come admin e non come altri ruoli
    public function testIsAdmin(): void
    {
        $mockDb = new MockAuthDatabase();
        $mockDb->role = 'Amministratore';
        $auth = new Auth($mockDb, 1);

        $this->assertTrue($auth->isAdmin());
        $this->assertFalse($auth->isAllenatore());
        $this->assertFalse($auth->isVisualizzatore());
    }

    // Testa che un utente con ruolo 'Allenatore' sia riconosciuto come allenatore e non come altri ruoli
    public function testIsAllenatore(): void
    {
        $mockDb = new MockAuthDatabase();
        $mockDb->role = 'Allenatore';
        $auth = new Auth($mockDb, 1);

        $this->assertFalse($auth->isAdmin());
        $this->assertTrue($auth->isAllenatore());
        $this->assertFalse($auth->isVisualizzatore());
    }

    // Testa che checkOnlyAdmin non lanci eccezione quando l'utente è admin
    public function testCheckOnlyAdminSuccess(): void
    {
        $mockDb = new MockAuthDatabase();
        $mockDb->role = 'Amministratore';
        $auth = new Auth($mockDb, 1);

        $auth->checkOnlyAdmin(); // Should not throw
        $this->assertTrue(true);
    }

    // Testa che checkOnlyAdmin lanci eccezione quando l'utente non è admin
    public function testCheckOnlyAdminFail(): void
    {
        $mockDb = new MockAuthDatabase();
        $mockDb->role = 'Allenatore';
        $auth = new Auth($mockDb, 1);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Accesso negato");
        $auth->checkOnlyAdmin();
    }

    // Testa che checkOnlyCoachOrAdmin non lanci eccezione quando l'utente è allenatore
    public function testCheckOnlyCoachOrAdminSuccess(): void
    {
        $mockDb = new MockAuthDatabase();
        $mockDb->role = 'Allenatore';
        $auth = new Auth($mockDb, 1);

        $auth->checkOnlyCoachOrAdmin(); // Should not throw
        $this->assertTrue(true);
    }

    // Testa che checkOnlyCoachOrAdmin lanci eccezione quando l'utente è solo visualizzatore
    public function testCheckOnlyCoachOrAdminFail(): void
    {
        $mockDb = new MockAuthDatabase();
        $mockDb->role = 'Visualizzatore';
        $auth = new Auth($mockDb, 1);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Accesso negato");
        $auth->checkOnlyCoachOrAdmin();
    }
}