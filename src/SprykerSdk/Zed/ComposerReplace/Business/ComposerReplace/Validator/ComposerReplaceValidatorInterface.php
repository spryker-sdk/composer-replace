<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Zed\ComposerReplace\Business\ComposerReplace\Validator;

use Generated\Shared\Transfer\ComposerReplaceResultCollectionTransfer;

interface ComposerReplaceValidatorInterface
{
    /**
     * @return \Generated\Shared\Transfer\ComposerReplaceResultCollectionTransfer
     */
    public function validate(): ComposerReplaceResultCollectionTransfer;
}
