<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Zed\ComposerReplace\Helper;

use Codeception\Module;
use Codeception\Stub;
use org\bovigo\vfs\vfsStream;
use SprykerSdk\Zed\ComposerReplace\ComposerReplaceConfig;

class ComposerReplaceHelper extends Module
{
    /**
     * @var \org\bovigo\vfs\vfsStreamDirectory
     */
    protected $virtualDirectory;

    /**
     * @return \SprykerSdk\Zed\ComposerReplace\ComposerReplaceConfig
     */
    public function getConfigMockForMissingComposerPackageReplace(): ComposerReplaceConfig
    {
        $virtualDirectory = $this->getVirtualRootDirectory();
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
        $virtualDirectory = $this->getVirtualRootDirectory();
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
     * @return \SprykerSdk\Zed\ComposerReplace\ComposerReplaceConfig|object
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

    /**
     * @param array $structure
     *
     * @return string
     */
    protected function getVirtualRootDirectory(array $structure = []): string
    {
        if (!$this->virtualDirectory) {
            $this->virtualDirectory = vfsStream::setup('root', null, $structure);
        }

        return $this->virtualDirectory->url() . DIRECTORY_SEPARATOR;
    }
}
