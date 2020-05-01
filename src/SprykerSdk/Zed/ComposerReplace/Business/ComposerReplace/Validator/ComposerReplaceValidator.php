<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Zed\ComposerReplace\Business\ComposerReplace\Validator;

use Generated\Shared\Transfer\ComposerPackageTransfer;
use Generated\Shared\Transfer\ComposerReplaceResultCollectionTransfer;
use Generated\Shared\Transfer\ComposerReplaceResultTransfer;
use SprykerSdk\Zed\ComposerReplace\ComposerReplaceConfig;
use Symfony\Component\Finder\Finder;

class ComposerReplaceValidator implements ComposerReplaceValidatorInterface
{
    /**
     * @var \SprykerSdk\Zed\ComposerReplace\ComposerReplaceConfig
     */
    protected $config;

    /**
     * @var array
     */
    protected $replacedComposerPackageNames = [];

    /**
     * @var array
     */
    protected $composerPackageNames = [];

    /**
     * @param \SprykerSdk\Zed\ComposerReplace\ComposerReplaceConfig $config
     */
    public function __construct(ComposerReplaceConfig $config)
    {
        $this->config = $config;
    }

    /**
     * @var \Generated\Shared\Transfer\ComposerReplaceResultCollectionTransfer
     */
    protected $replaceValidationResultTransfer;

    /**
     * @return \Generated\Shared\Transfer\ComposerReplaceResultCollectionTransfer
     */
    public function validate(): ComposerReplaceResultCollectionTransfer
    {
        $composerReplaceCollectionResultTransfer = new ComposerReplaceResultCollectionTransfer();
        foreach ($this->config->getPathToRepositories() as $pathToRepository) {
            $composerReplaceCollectionResultTransfer = $this->validateComposerJsonReplace($composerReplaceCollectionResultTransfer, $pathToRepository);
        }

        return $composerReplaceCollectionResultTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\ComposerReplaceResultCollectionTransfer $composerReplaceCollectionResultTransfer
     * @param string $pathToRepository
     *
     * @return \Generated\Shared\Transfer\ComposerReplaceResultCollectionTransfer
     */
    public function validateComposerJsonReplace(
        ComposerReplaceResultCollectionTransfer $composerReplaceCollectionResultTransfer,
        string $pathToRepository
    ): ComposerReplaceResultCollectionTransfer {
        $composerReplaceResultTransfer = new ComposerReplaceResultTransfer();
        $composerReplaceResultTransfer->setPathToRepository($pathToRepository);

        $composerReplaceResultTransfer = $this->addMissingComposerPackages($composerReplaceResultTransfer, $pathToRepository);
        $composerReplaceResultTransfer = $this->addObsoleteComposerPackages($composerReplaceResultTransfer, $pathToRepository);

        $composerReplaceCollectionResultTransfer->addComposerReplaceResult($composerReplaceResultTransfer);

        return $composerReplaceCollectionResultTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\ComposerReplaceResultTransfer $composerReplaceResultTransfer
     * @param string $pathToRepository
     *
     * @return \Generated\Shared\Transfer\ComposerReplaceResultTransfer
     */
    protected function addMissingComposerPackages(
        ComposerReplaceResultTransfer $composerReplaceResultTransfer,
        string $pathToRepository
    ): ComposerReplaceResultTransfer {
        foreach ($this->getMissingComposerPackageNames($pathToRepository) as $missingComposerPackageName) {
            $composerPackageTransfer = new ComposerPackageTransfer();
            $composerPackageTransfer
                ->setName($missingComposerPackageName)
                ->setType(ComposerReplaceConfig::TYPE_MISSING);

            $composerReplaceResultTransfer->addComposerPackage($composerPackageTransfer);
        }

        return $composerReplaceResultTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\ComposerReplaceResultTransfer $composerReplaceResultTransfer
     * @param string $pathToRepository
     *
     * @return \Generated\Shared\Transfer\ComposerReplaceResultTransfer
     */
    protected function addObsoleteComposerPackages(
        ComposerReplaceResultTransfer $composerReplaceResultTransfer,
        string $pathToRepository
    ): ComposerReplaceResultTransfer {
        foreach ($this->getObsoleteComposerPackageNames($pathToRepository) as $obsoleteComposerPackageName) {
            $composerPackageTransfer = new ComposerPackageTransfer();
            $composerPackageTransfer
                ->setName($obsoleteComposerPackageName)
                ->setType(ComposerReplaceConfig::TYPE_OBSOLETE);

            $composerReplaceResultTransfer->addComposerPackage($composerPackageTransfer);
        }

        return $composerReplaceResultTransfer;
    }

    /**
     * @param string $pathToRepository
     *
     * @return array
     */
    protected function getMissingComposerPackageNames(string $pathToRepository): array
    {
        $replacedModuleComposerNames = $this->getReplacedComposerPackages($pathToRepository);
        $composerNamesOfNonSplitModules = $this->getComposerPackages($pathToRepository);

        $missingComposerPackages = [];
        foreach ($composerNamesOfNonSplitModules as $composerNameOfNonSplitModule) {
            if (!isset($replacedModuleComposerNames[$composerNameOfNonSplitModule])) {
                $missingComposerPackages[] = $composerNameOfNonSplitModule;
            }
        }

        return $missingComposerPackages;
    }

    /**
     * @param string $pathToRepository
     *
     * @return array
     */
    protected function getObsoleteComposerPackageNames(string $pathToRepository): array
    {
        $replacedModuleComposerNames = $this->getReplacedComposerPackages($pathToRepository);
        $composerNamesOfNonSplitModules = $this->getComposerPackages($pathToRepository);

        $obsoleteComposerPackages = [];
        foreach (array_keys($replacedModuleComposerNames) as $replacedModuleComposerName) {
            if (!isset($composerNamesOfNonSplitModules[$replacedModuleComposerName])) {
                $obsoleteComposerPackages[] = $replacedModuleComposerName;
            }
        }

        return $obsoleteComposerPackages;
    }

    /**
     * @param string $pathToRepository
     *
     * @return array
     */
    protected function getReplacedComposerPackages(string $pathToRepository): array
    {
        if (!isset($this->replacedComposerPackageNames[$pathToRepository])) {
            $pathToComposerJson = sprintf('%s/composer.json', rtrim($pathToRepository, DIRECTORY_SEPARATOR));
            $composerJsonAsArray = json_decode(file_get_contents($pathToComposerJson), true);

            $this->replacedComposerPackageNames[$pathToRepository] = $composerJsonAsArray['replace'] ?? [];
        }

        return $this->replacedComposerPackageNames[$pathToRepository];
    }

    /**
     * @param string $pathToRepository
     *
     * @return array
     */
    protected function getComposerPackages(string $pathToRepository): array
    {
        if (!isset($this->composerPackageNames[$pathToRepository])) {
            $finder = new Finder();
            $finder->files()->in($pathToRepository)->name('composer.json')->depth(2);

            $composerNames = [];
            foreach ($finder as $splFileInfo) {
                $composerJsonAsArray = json_decode(file_get_contents($splFileInfo->getPathname()), true);

                $composerNames[$composerJsonAsArray['name']] = $composerJsonAsArray['name'];
            }

            $this->composerPackageNames[$pathToRepository] = $composerNames;
        }

        return $this->composerPackageNames[$pathToRepository];
    }
}
