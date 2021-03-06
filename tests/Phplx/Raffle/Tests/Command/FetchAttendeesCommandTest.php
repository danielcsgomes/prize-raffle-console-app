<?php

namespace Phplx\Raffle\Tests\Command;

use Phplx\Raffle\Command\FetchAttendeesCommand;
use Symfony\Component\Console\Tester\CommandTester;

class FetchAttendeesCommandTest extends BaseCommandTest
{
    public function testFetchAttendees()
    {
        // Set the Provider Mock
        $this->application->getContainer()->setParameter(
            'provider.class',
            'Phplx\Raffle\Tests\MockProvider'
        );
        // Set the DataAdapter Mock
        $this->application->getContainer()->setParameter(
            'data_adapter.class',
            'Phplx\Raffle\Tests\MockDataAdapter'
        );

        $this->application->add(new FetchAttendeesCommand());

        $command = $this->application->find('meetup:attendees:get');
        $commandTester = new CommandTester($command);
        $commandTester->execute(
            array(
                 'command' => $command->getName(),
                 'event_id' => 'test'
            )
        );

        $this->assertContains('Total attendees:1', $commandTester->getDisplay());
        $this->assertContains('You can now start the prizes raffle!', $commandTester->getDisplay());
    }
}
