<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Zed\ComposerConstrainer\Communication\Console;

use Codeception\Test\Unit;
use SprykerSdk\Shared\ComposerReplace\Transfer\ComposerPackageTransfer;
use SprykerSdk\Shared\ComposerReplace\Transfer\ComposerReplaceResultCollectionTransfer;
use SprykerSdk\Shared\ComposerReplace\Transfer\ComposerReplaceResultTransfer;
use SprykerSdk\Zed\ComposerReplace\Business\ComposerReplaceFacadeInterface;
use SprykerSdk\Zed\ComposerReplace\Communication\Console\ComposerReplaceConsole;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class ComposerReplaceConsoleTest extends Unit
{
    /**
     * @return void
     */
    public function testExecuteReturnsSuccessCodeWhenAllNonSplitModulesListedInComposersReplaceSection(): void
    {
        // Arrange
        $facade = $this->createMock(ComposerReplaceFacadeInterface::class);
        $facade->method('validate')
            ->willReturn(new ComposerReplaceResultCollectionTransfer());

        $composerReplaceConsole = new ComposerReplaceConsole();
        $composerReplaceConsole->setFacade($facade);

        $application = new Application();
        $application->add($composerReplaceConsole);

        $command = $application->find(ComposerReplaceConsole::COMMAND_NAME);
        $commandTester = new CommandTester($command);

        // Act
        $commandTester->execute(['-d' => true]);

        // Assert
        $this->assertSame(ComposerReplaceConsole::SUCCESS, $commandTester->getStatusCode(), 'Expected success result code "0" but got error code "1".');
    }

    /**
     * @return void
     */
    public function testExecuteReturnsErrorCodeWhenOneOrMoreNonSplitModulesNotListedInComposersReplaceSection(): void
    {
        // Arrange
        $composerReplaceResultTransfer = new ComposerReplaceResultTransfer();
        $composerReplaceResultTransfer->addComposerPackage(new ComposerPackageTransfer());
        $composerReplaceResultCollectionTransfer = new ComposerReplaceResultCollectionTransfer();
        $composerReplaceResultCollectionTransfer->addComposerReplaceResult($composerReplaceResultTransfer);

        $facade = $this->createMock(ComposerReplaceFacadeInterface::class);
        $facade->method('validate')
            ->willReturn($composerReplaceResultCollectionTransfer);

        $composerReplaceConsole = new ComposerReplaceConsole();
        $composerReplaceConsole->setFacade($facade);

        $application = new Application();
        $application->add($composerReplaceConsole);

        $command = $application->find(ComposerReplaceConsole::COMMAND_NAME);
        $commandTester = new CommandTester($command);

        // Act
        $commandTester->execute(['-d' => true]);

        // Assert
        $this->assertSame(ComposerReplaceConsole::FAILURE, $commandTester->getStatusCode(), 'Expected error code "1" but got success code "0".');
    }
}
