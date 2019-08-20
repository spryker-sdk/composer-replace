<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Zed\ComposerReplace\Communication\Console;

use Generated\Shared\Transfer\ComposerPackageTransfer;
use Generated\Shared\Transfer\ComposerReplaceResultCollectionTransfer;
use Spryker\Zed\Kernel\Communication\Console\Console;
use SprykerSdk\Zed\ComposerReplace\ComposerReplaceConfig;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableCell;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @method \SprykerSdk\Zed\ComposerReplace\Business\ComposerReplaceFacadeInterface getFacade()
 */
class ComposerReplaceConsole extends Console
{
    public const COMMAND_NAME = 'code:composer:replace';
    public const OPTION_DRY_RUN = 'dry-run';
    public const OPTION_DRY_RUN_SHORT = 'd';

    /**
     * @return void
     */
    protected function configure(): void
    {
        $this
            ->setName(static::COMMAND_NAME)
            ->setDescription('Updates Composer replace section with all modules which exist in the core non-split repositories.');

        $this->addOption(static::OPTION_DRY_RUN, static::OPTION_DRY_RUN_SHORT, InputOption::VALUE_NONE, 'Use this option to validate your replace sections.');
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if ($input->getOption(static::OPTION_DRY_RUN)) {
            return $this->runValidation();
        }

        return $this->runUpdate();
    }

    /**
     * @return int
     */
    protected function runValidation(): int
    {
        $composerReplaceResultCollectionTransfer = $this->getFacade()->validate();

        if ($this->isComposerReplaceComplete($composerReplaceResultCollectionTransfer)) {
            return static::CODE_SUCCESS;
        }

        if ($this->output->isVerbose()) {
            $this->outputValidationResult($composerReplaceResultCollectionTransfer);
        }

        return static::CODE_ERROR;
    }

    /**
     * @param \Generated\Shared\Transfer\ComposerReplaceResultCollectionTransfer $composerReplaceResultCollectionTransfer
     *
     * @return bool
     */
    protected function isComposerReplaceComplete(ComposerReplaceResultCollectionTransfer $composerReplaceResultCollectionTransfer): bool
    {
        $isSuccess = true;

        foreach ($composerReplaceResultCollectionTransfer->getComposerReplaceResults() as $composerReplaceResultTransfer) {
            if ($composerReplaceResultTransfer->getComposerPackages()->count() < 0) {
                $isSuccess = false;
            }
        }

        return $isSuccess;
    }

    /**
     * @param \Generated\Shared\Transfer\ComposerReplaceResultCollectionTransfer $composerReplaceResultCollectionTransfer
     *
     * @return void
     */
    protected function outputValidationResult(ComposerReplaceResultCollectionTransfer $composerReplaceResultCollectionTransfer): void
    {
        foreach ($composerReplaceResultCollectionTransfer->getComposerReplaceResults() as $composerReplaceResultTransfer) {
            if ($composerReplaceResultTransfer->getComposerPackages()->count() === 0) {
                continue;
            }

            $table = new Table($this->output);
            $table->setHeaders([new TableCell(sprintf('Validation of Composer replace in %s/composer.json', rtrim($composerReplaceResultTransfer->getPathToRepository(), '/')), ['colspan' => 2])]);

            foreach ($composerReplaceResultTransfer->getComposerPackages() as $composerPackageTransfer) {
                $validationInfo = $this->getValidationInfo($composerPackageTransfer);
                $table->addRow([$composerPackageTransfer->getName(), $validationInfo]);
            }

            $table->render();
        }
    }

    /**
     * @param \Generated\Shared\Transfer\ComposerPackageTransfer $composerPackageTransfer
     *
     * @return string
     */
    protected function getValidationInfo(ComposerPackageTransfer $composerPackageTransfer): string
    {
        if ($composerPackageTransfer->getType() === ComposerReplaceConfig::TYPE_MISSING) {
            return 'Needs to be added to composer.json replace.';
        }

        return 'Can be removed from composer.json replace.';
    }

    /**
     * @return int
     */
    protected function runUpdate(): int
    {
        $composerReplaceResultCollectionTransfer = $this->getFacade()->update();

        if ($this->output->isVerbose()) {
            $this->outputUpdateResult($composerReplaceResultCollectionTransfer);
        }

        return static::CODE_SUCCESS;
    }

    /**
     * @param \Generated\Shared\Transfer\ComposerReplaceResultCollectionTransfer $composerReplaceResultCollectionTransfer
     *
     * @return void
     */
    protected function outputUpdateResult(ComposerReplaceResultCollectionTransfer $composerReplaceResultCollectionTransfer): void
    {
        foreach ($composerReplaceResultCollectionTransfer->getComposerReplaceResults() as $composerReplaceResultTransfer) {
            if ($composerReplaceResultTransfer->getComposerPackages()->count() === 0) {
                continue;
            }

            $table = new Table($this->output);
            $table->setHeaders([new TableCell(sprintf('Updated Composer replace in %s/composer.json', rtrim($composerReplaceResultTransfer->getPathToRepository(), '/')), ['colspan' => 2])]);

            foreach ($composerReplaceResultTransfer->getComposerPackages() as $composerPackageTransfer) {
                $updateInfo = $this->getUpdateInfo($composerPackageTransfer);
                $table->addRow([$composerPackageTransfer->getName(), $updateInfo]);
            }

            $table->render();
        }
    }

    /**
     * @param \Generated\Shared\Transfer\ComposerPackageTransfer $composerPackageTransfer
     *
     * @return string
     */
    protected function getUpdateInfo(ComposerPackageTransfer $composerPackageTransfer): string
    {
        if ($composerPackageTransfer->getType() === ComposerReplaceConfig::TYPE_MISSING) {
            return 'Added to composer.json replace';
        }

        return 'Removed from composer.json replace';
    }
}
