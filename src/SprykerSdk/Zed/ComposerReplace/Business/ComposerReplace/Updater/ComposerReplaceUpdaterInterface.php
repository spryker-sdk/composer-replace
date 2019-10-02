<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Zed\ComposerReplace\Business\ComposerReplace\Updater;

use Generated\Shared\Transfer\ComposerReplaceResultCollectionTransfer;

interface ComposerReplaceUpdaterInterface
{
    /**
     * @return \Generated\Shared\Transfer\ComposerReplaceResultCollectionTransfer
     */
    public function update(): ComposerReplaceResultCollectionTransfer;
}
