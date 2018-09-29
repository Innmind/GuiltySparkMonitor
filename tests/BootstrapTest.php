<?php
declare(strict_types = 1);

namespace Tests\Innmind\InstallationMonitor;

use function Innmind\InstallationMonitor\bootstrap;
use Innmind\InstallationMonitor\{
    Client\Socket,
    Client\Silence,
    Client,
};
use Innmind\Socket\Address\Unix as Address;
use PHPUnit\Framework\TestCase;

class BootstrapTest extends TestCase
{
    public function testBootstrap()
    {
        $services = bootstrap();

        $this->assertCount(2, $services['client']);
        $this->assertInternalType('callable', $services['client']['socket']);
        $this->assertInstanceOf(Socket::class, $services['client']['socket'](
            new Address('/tmp/foo')
        ));
        $this->assertInternalType('callable', $services['client']['silence']);
        $this->assertInstanceOf(Silence::class, $services['client']['silence'](
            $this->createMock(Client::class)
        ));
    }
}