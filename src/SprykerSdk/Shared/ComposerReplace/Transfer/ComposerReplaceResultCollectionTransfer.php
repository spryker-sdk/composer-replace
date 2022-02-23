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
    protected $composerReplaceResults = [];

    /**
     * @return array<\SprykerSdk\Shared\ComposerReplace\Transfer\ComposerReplaceResultTransfer>
     */
    public function getComposerReplaceResults(): array
    {
        return $this->composerReplaceResults;
    }

    /**
     * @param array<\SprykerSdk\Shared\ComposerReplace\Transfer\ComposerReplaceResultTransfer> $composerReplaceResults
     *
     * @return $this
     */
    public function setComposerReplaceResults(array $composerReplaceResults)
    {
        $this->composerReplaceResults = $composerReplaceResults;

        return $this;
    }

    /**
     * @param \SprykerSdk\Shared\ComposerReplace\Transfer\ComposerReplaceResultTransfer $composerReplaceResult
     *
     * @return $this
     */
    public function addComposerReplaceResult(ComposerReplaceResultTransfer $composerReplaceResult)
    {
        $this->composerReplaceResults[] = $composerReplaceResult;

        return $this;
    }
}
