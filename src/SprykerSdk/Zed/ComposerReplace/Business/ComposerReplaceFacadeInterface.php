<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Zed\ComposerReplace\Business;

use Generated\Shared\Transfer\ComposerReplaceResultCollectionTransfer;

interface ComposerReplaceFacadeInterface
{
    /**
     * Specification:
     * - Validates the composer replace section in the non-split repositories.
     * - Returns a ComposerReplaceResultCollectionTransfer which contains all ComposerPackageTransfer's which are missing.
     *
     * @api
     *
     * @return \Generated\Shared\Transfer\ComposerReplaceResultCollectionTransfer
     */
    public function validate(): ComposerReplaceResultCollectionTransfer;

    /**
     * Specification:
     * - Updates the composer replace section in the non-split repositories.
     * - Returns a ComposerReplaceResultCollectionTransfer which contains all ComposerPackageTransfer's which were added.
     *
     * @api
     *
     * @return \Generated\Shared\Transfer\ComposerReplaceResultCollectionTransfer
     */
    public function update(): ComposerReplaceResultCollectionTransfer;
}
