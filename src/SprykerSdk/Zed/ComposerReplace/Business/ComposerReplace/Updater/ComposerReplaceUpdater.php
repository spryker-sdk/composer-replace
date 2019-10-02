<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Zed\ComposerReplace\Business\ComposerReplace\Updater;

use Generated\Shared\Transfer\ComposerReplaceResultCollectionTransfer;
use Generated\Shared\Transfer\ComposerReplaceResultTransfer;
use SprykerSdk\Zed\ComposerReplace\Business\ComposerReplace\Validator\ComposerReplaceValidatorInterface;
use SprykerSdk\Zed\ComposerReplace\ComposerReplaceConfig;

class ComposerReplaceUpdater implements ComposerReplaceUpdaterInterface
{
    /**
     * @var \SprykerSdk\Zed\ComposerReplace\Business\ComposerReplace\Validator\ComposerReplaceValidatorInterface
     */
    protected $composerReplaceValidator;

    /**
     * @param \SprykerSdk\Zed\ComposerReplace\Business\ComposerReplace\Validator\ComposerReplaceValidatorInterface $composerReplaceValidator
     */
    public function __construct(ComposerReplaceValidatorInterface $composerReplaceValidator)
    {
        $this->composerReplaceValidator = $composerReplaceValidator;
    }

    /**
     * @return \Generated\Shared\Transfer\ComposerReplaceResultCollectionTransfer
     */
    public function update(): ComposerReplaceResultCollectionTransfer
    {
        $composerReplaceResultCollectionTransfer = $this->composerReplaceValidator->validate();

        foreach ($composerReplaceResultCollectionTransfer->getComposerReplaceResults() as $composerReplaceResultTransfer) {
            $this->updateComposerJsonReplace($composerReplaceResultTransfer);
        }

        return $composerReplaceResultCollectionTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\ComposerReplaceResultTransfer $composerReplaceResultTransfer
     *
     * @return void
     */
    protected function updateComposerJsonReplace(ComposerReplaceResultTransfer $composerReplaceResultTransfer): void
    {
        $pathToComposerJson = sprintf('%s/composer.json', rtrim($composerReplaceResultTransfer->getPathToRepository(), DIRECTORY_SEPARATOR));
        $composerJsonArray = json_decode(file_get_contents($pathToComposerJson), true);
        $replace = $composerJsonArray['replace'] ?? [];

        $replace = $this->addComposerPackageToReplace($composerReplaceResultTransfer, $replace);
        $replace = $this->removeComposerPackageFromReplace($composerReplaceResultTransfer, $replace);

        $composerJsonArray['replace'] = $replace;

        $this->writeComposerJson($composerJsonArray, $pathToComposerJson);
    }

    /**
     * @param \Generated\Shared\Transfer\ComposerReplaceResultTransfer $composerReplaceResultTransfer
     * @param array $replace
     *
     * @return array
     */
    protected function addComposerPackageToReplace(ComposerReplaceResultTransfer $composerReplaceResultTransfer, array $replace): array
    {
        foreach ($composerReplaceResultTransfer->getComposerPackages() as $composerPackageTransfer) {
            if ($composerPackageTransfer->getType() === ComposerReplaceConfig::TYPE_MISSING) {
                $replace[$composerPackageTransfer->getName()] = '*';
            }
        }

        return $replace;
    }

    /**
     * @param \Generated\Shared\Transfer\ComposerReplaceResultTransfer $composerReplaceResultTransfer
     * @param array $replace
     *
     * @return array
     */
    protected function removeComposerPackageFromReplace(ComposerReplaceResultTransfer $composerReplaceResultTransfer, array $replace): array
    {
        foreach ($composerReplaceResultTransfer->getComposerPackages() as $composerPackageTransfer) {
            if ($composerPackageTransfer->getType() === ComposerReplaceConfig::TYPE_OBSOLETE) {
                unset($replace[$composerPackageTransfer->getName()]);
            }
        }

        return $replace;
    }

    /**
     * @param array $composerJsonArray
     * @param string $pathToComposerJson
     *
     * @return void
     */
    protected function writeComposerJson(array $composerJsonArray, string $pathToComposerJson): void
    {
        ksort($composerJsonArray['replace']);

        $encodedJson4Spaces = json_encode($composerJsonArray, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        $encodedJson2Spaces = preg_replace('/^(  +?)\\1(?=[^ ])/m', '$1', $encodedJson4Spaces) . "\n";

        file_put_contents($pathToComposerJson, $encodedJson2Spaces);
    }
}
