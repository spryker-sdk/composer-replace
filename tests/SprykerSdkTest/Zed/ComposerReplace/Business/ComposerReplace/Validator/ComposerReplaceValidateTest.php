<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Zed\ComposerReplace\Business\ComposerReplace\Updater;

use Codeception\Test\Unit;
use SprykerSdk\Zed\ComposerReplace\Business\ComposerReplace\Validator\ComposerReplaceValidator;

class ComposerReplaceValidateTest extends Unit
{
    /**
     * @var \SprykerSdkTest\Zed\ComposerReplace\ComposerReplaceBusinessTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testValidateShowMissingComposerPackageName(): void
    {
        // Arrange
        $composerReplaceConfigMock = $this->tester->getConfigMockForMissingComposerPackageReplace();
        $composerReplaceValidator = new ComposerReplaceValidator($composerReplaceConfigMock);

        // Act
        $replaceUpdateResultCollectionTransfer = $composerReplaceValidator->validate();

        // Assert
        $this->assertCount(1, $replaceUpdateResultCollectionTransfer->getComposerReplaceResults()[0]->getComposerPackages());
    }

    /**
     * @return void
     */
    public function testValidateShowObsoleteComposerPackageName(): void
    {
        // Arrange
        $composerReplaceConfigMock = $this->tester->getConfigMockForObsoleteComposerPackageReplace();
        $composerReplaceValidator = new ComposerReplaceValidator($composerReplaceConfigMock);

        // Act
        $replaceUpdateResultCollectionTransfer = $composerReplaceValidator->validate();

        // Assert
        $this->assertCount(1, $replaceUpdateResultCollectionTransfer->getComposerReplaceResults()[0]->getComposerPackages());
    }
}
