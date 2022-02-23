<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Shared\ComposerReplace\Transfer;

class ComposerReplaceResultCollectionTransfer
{
    /**
     * @var array<\SprykerSdk\Shared\ComposerReplace\Transfer\ComposerReplaceResultTransfer>
     */
    protected $composerReplaceResultTransfers = [];

    /**
     * @return array<\SprykerSdk\Shared\ComposerReplace\Transfer\ComposerReplaceResultTransfer>
     */
    public function getComposerReplaceResults(): array
    {
        return $this->composerReplaceResultTransfers;
    }

    /**
     * @param array<\SprykerSdk\Shared\ComposerReplace\Transfer\ComposerReplaceResultTransfer> $composerReplaceResultTransfers
     *
     * @return $this
     */
    public function setComposerReplaceResults(array $composerReplaceResultTransfers)
    {
        $this->composerReplaceResultTransfers = $composerReplaceResultTransfers;

        return $this;
    }

    /**
     * @param \SprykerSdk\Shared\ComposerReplace\Transfer\ComposerReplaceResultTransfer $composerReplaceResultTransfer
     *
     * @return $this
     */
    public function addComposerReplaceResult(ComposerReplaceResultTransfer $composerReplaceResultTransfer)
    {
        $this->composerReplaceResultTransfers[] = $composerReplaceResultTransfer;

        return $this;
    }
}
