<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Zed\ComposerReplace;

use Codeception\Actor;
use Codeception\Stub;
use SprykerSdk\Zed\ComposerReplace\ComposerReplaceConfig;

/**
 * Inherited Methods
 *
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method void pause()
 *
 * @SuppressWarnings(PHPMD)
 */
class ComposerReplaceBusinessTester extends Actor
{
    use _generated\ComposerReplaceBusinessTesterActions;

    /**
     * @return \SprykerSdk\Zed\ComposerReplace\ComposerReplaceConfig
     */
    public function getConfigMockForMissingComposerPackageReplace(): ComposerReplaceConfig
    {
        $virtualDirectory = $this->getVirtualDirectory();
        $this->mkdirIfNotExists($virtualDirectory);

        $rootComposerJsonContent = '{"name": "spryker/test"}';
        $pathToRootComposerJson = sprintf('%s/composer.json', $virtualDirectory);
        file_put_contents($pathToRootComposerJson, $rootComposerJsonContent);

        $moduleComposerJsonContent = '{"name": "spryker/missing"}';
        $pathToModuleComposerJson = sprintf('%s/Bundles/Missing/composer.json', $virtualDirectory);
        file_put_contents($pathToModuleComposerJson, $moduleComposerJsonContent);

        /** @var \SprykerSdk\Zed\ComposerReplace\ComposerReplaceConfig $configMock */
        $configMock = $this->getConfigMock($virtualDirectory);

        return $configMock;
    }

    /**
     * @return \SprykerSdk\Zed\ComposerReplace\ComposerReplaceConfig
     */
    public function getConfigMockForObsoleteComposerPackageReplace(): ComposerReplaceConfig
    {
        $virtualDirectory = $this->getVirtualDirectory();
        $this->mkdirIfNotExists($virtualDirectory);

        $rootComposerJsonContent = '{"name": "spryker/test", "replace":{"spryker/obsolete": "*", "spryker/missing": "*"}}';
        $pathToRootComposerJson = sprintf('%s/composer.json', $virtualDirectory);
        file_put_contents($pathToRootComposerJson, $rootComposerJsonContent);

        $moduleComposerJsonContent = '{"name": "spryker/missing"}';
        $pathToModuleComposerJson = sprintf('%s/Bundles/Missing/composer.json', $virtualDirectory);
        file_put_contents($pathToModuleComposerJson, $moduleComposerJsonContent);

        /** @var \SprykerSdk\Zed\ComposerReplace\ComposerReplaceConfig $configMock */
        $configMock = $this->getConfigMock($virtualDirectory);

        return $configMock;
    }

    /**
     * @param string $virtualDirectory
     *
     * @return object|\SprykerSdk\Zed\ComposerReplace\ComposerReplaceConfig
     */
    protected function getConfigMock(string $virtualDirectory)
    {
        $configMock = Stub::make(ComposerReplaceConfig::class, [
            'getPathToRepositories' => function () use ($virtualDirectory) {
                return [$virtualDirectory];
            },
        ]);

        return $configMock;
    }

    /**
     * @param string $virtualDirectory
     *
     * @return void
     */
    protected function mkdirIfNotExists(string $virtualDirectory): void
    {
        $directory = sprintf('%s/Bundles/Missing/', $virtualDirectory);

        if (!is_dir($directory)) {
            mkdir($directory, 0777, true);
        }
    }
}
