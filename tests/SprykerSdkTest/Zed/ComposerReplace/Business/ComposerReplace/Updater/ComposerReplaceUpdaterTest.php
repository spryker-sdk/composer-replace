<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Zed\ComposerReplace\Business\ComposerReplace\Updater;

use Codeception\Test\Unit;
use SprykerSdk\Zed\ComposerReplace\Business\ComposerReplace\Updater\ComposerReplaceUpdater;
use SprykerSdk\Zed\ComposerReplace\Business\ComposerReplace\Validator\ComposerReplaceValidator;

class ComposerReplaceUpdaterTest extends Unit
{
    /**
     * @var \SprykerSdkTest\Zed\ComposerReplace\ComposerReplaceBusinessTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testUpdateAddsMissingComposerPackageName(): void
    {
        // Arrange
        $composerReplaceConfigMock = $this->tester->getConfigMockForMissingComposerPackageReplace();
        $composerReplaceValidator = new ComposerReplaceValidator($composerReplaceConfigMock);
        $composerReplaceUpdater = new ComposerReplaceUpdater($composerReplaceValidator);

        // Act
        $replaceUpdateResultTransfer = $composerReplaceUpdater->update();

        // Assert
        $composerJsonReplace = json_decode(file_get_contents($composerReplaceConfigMock->getPathToRepositories()[0] . 'composer.json'), true)['replace'];

        $this->assertCount(1, $replaceUpdateResultTransfer->getComposerReplaceResults()[0]->getComposerPackages());
        $this->assertArrayHasKey('spryker/missing', $composerJsonReplace);
    }

    /**
     * @return void
     */
    public function testUpdateRemovesObsoleteComposerPackageName(): void
    {
        // Arrange
        $composerReplaceConfigMock = $this->tester->getConfigMockForObsoleteComposerPackageReplace();
        $composerReplaceValidator = new ComposerReplaceValidator($composerReplaceConfigMock);
        $composerReplaceUpdater = new ComposerReplaceUpdater($composerReplaceValidator);

        // Act
        $replaceUpdateResultTransfer = $composerReplaceUpdater->update();

        // Assert
        $composerJsonReplace = json_decode(file_get_contents($composerReplaceConfigMock->getPathToRepositories()[0] . 'composer.json'), true)['replace'];

        $this->assertCount(1, $replaceUpdateResultTransfer->getComposerReplaceResults()[0]->getComposerPackages());
        $this->assertArrayHasKey('spryker/missing', $composerJsonReplace);
    }
}
