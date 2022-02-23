<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Shared\ComposerReplace\Transfer;

class ComposerReplaceResultTransfer
{
    /**
     * @var string
     */
    protected $pathToRepository;

    /**
     * @var array<\SprykerSdk\Shared\ComposerReplace\Transfer\ComposerPackageTransfer>
     */
    protected $composerPackageTransfers = [];

    /**
     * @return string
     */
    public function getPathToRepository(): string
    {
        return $this->pathToRepository;
    }

    /**
     * @return array<\SprykerSdk\Shared\ComposerReplace\Transfer\ComposerPackageTransfer>
     */
    public function getComposerPackages(): array
    {
        return $this->composerPackageTransfers;
    }

    /**
     * @param array<\SprykerSdk\Shared\ComposerReplace\Transfer\ComposerPackageTransfer> $composerPackageTransfers
     *
     * @return $this
     */
    public function setComposerPackages(array $composerPackageTransfers)
    {
        $this->composerPackageTransfers = $composerPackageTransfers;

        return $this;
    }

    /**
     * @param \SprykerSdk\Shared\ComposerReplace\Transfer\ComposerPackageTransfer $composerPackage
     *
     * @return $this
     */
    public function addComposerPackage(ComposerPackageTransfer $composerPackage)
    {
        $this->composerPackageTransfers[] = $composerPackage;

        return $this;
    }

    /**
     * @param string $pathToRepository
     *
     * @return $this
     */
    public function setPathToRepository(string $pathToRepository)
    {
        $this->pathToRepository = $pathToRepository;

        return $this;
    }
}
