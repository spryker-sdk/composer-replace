<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Zed\ComposerConstrainer\Communication\Console;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\ComposerPackageTransfer;
use Generated\Shared\Transfer\ComposerReplaceResultCollectionTransfer;
use Generated\Shared\Transfer\ComposerReplaceResultTransfer;
use SprykerSdk\Zed\ComposerReplace\Communication\Console\ComposerReplaceConsole;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class ComposerReplaceConsoleTest extends Unit
{
    /**
     * @var \SprykerSdkTest\Zed\ComposerReplace\ComposerReplaceCommunicationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testExecuteReturnsSuccessCodeWhenAllNonSplitModulesListedInComposersReplaceSection(): void
    {
        // Arrange
        $this->tester->mockFacadeMethod('validate', function () {
            return new ComposerReplaceResultCollectionTransfer();
        });

        $composerReplaceConsole = new ComposerReplaceConsole();
        $composerReplaceConsole->setFacade($this->tester->getFacade());

        $application = new Application();
        $application->add($composerReplaceConsole);

        $command = $application->find(ComposerReplaceConsole::COMMAND_NAME);
        $commandTester = new CommandTester($command);

        // Act
        $commandTester->execute(['-d' => true]);

        // Assert
        $this->assertSame(ComposerReplaceConsole::CODE_SUCCESS, $commandTester->getStatusCode(), 'Expected success result code "0" but got error code "1".');
    }

    /**
     * @return void
     */
    public function testExecuteReturnsErrorCodeWhenOneOrMoreNonSplitModulesNotListedInComposersReplaceSection(): void
    {
        // Arrange
        $this->tester->mockFacadeMethod('validate', function () {
            $composerReplaceResultTransfer = new ComposerReplaceResultTransfer();
            $composerReplaceResultTransfer->addComposerPackage(new ComposerPackageTransfer());
            $composerReplaceResultCollectionTransfer = new ComposerReplaceResultCollectionTransfer();
            $composerReplaceResultCollectionTransfer->addComposerReplaceResult($composerReplaceResultTransfer);

            return $composerReplaceResultCollectionTransfer;
        });

        $composerReplaceConsole = new ComposerReplaceConsole();
        $composerReplaceConsole->setFacade($this->tester->getFacade());

        $application = new Application();
        $application->add($composerReplaceConsole);

        $command = $application->find(ComposerReplaceConsole::COMMAND_NAME);
        $commandTester = new CommandTester($command);

        // Act
        $commandTester->execute(['-d' => true]);

        // Assert
        $this->assertSame(ComposerReplaceConsole::CODE_ERROR, $commandTester->getStatusCode(), 'Expected error code "1" but got success code "0".');
    }
}
