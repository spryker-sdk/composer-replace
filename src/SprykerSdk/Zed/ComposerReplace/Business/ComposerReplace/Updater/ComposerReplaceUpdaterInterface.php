<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Zed\ComposerReplace\Business\ComposerReplace\Updater;

use SprykerSdk\Shared\ComposerReplace\Transfer\ComposerReplaceResultCollectionTransfer;

interface ComposerReplaceUpdaterInterface
{
    /**
     * @return \SprykerSdk\Shared\ComposerReplace\Transfer\ComposerReplaceResultCollectionTransfer
     */
    public function update(): ComposerReplaceResultCollectionTransfer;
}
