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
    protected string $pathToRepository;

    /**
     * @var \SprykerSdk\Shared\ComposerReplace\Transfer\ComposerPackageTransfer[]
     */
    protected array $composerPackages;

    /**
     * @return string
     */
    public function getPathToRepository(): string
    {
        return $this->pathToRepository;
    }

    /**
     * @return \SprykerSdk\Shared\ComposerReplace\Transfer\ComposerPackageTransfer[]
     */
    public function getComposerPackages(): array
    {
        return $this->composerPackages;
    }

    /**
     * @param \SprykerSdk\Shared\ComposerReplace\Transfer\ComposerPackageTransfer[] $composerPackages
     *
     * @return $this
     */
    public function setComposerPackages(array $composerPackages)
    {
        $this->composerPackages = $composerPackages;

        return $this;
    }

    /**
     * @param \SprykerSdk\Shared\ComposerReplace\Transfer\ComposerPackageTransfer $composerPackages
     *
     * @return $this
     */
    public function addComposerPackage(ComposerPackageTransfer $composerPackage)
    {
        $this->composerPackages[] = $composerPackages;

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
