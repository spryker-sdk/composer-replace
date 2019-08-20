<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Zed\ComposerReplace\Business;

use Generated\Shared\Transfer\ComposerReplaceResultCollectionTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @api
 *
 * @method \SprykerSdk\Zed\ComposerReplace\Business\ComposerReplaceBusinessFactory getFactory()
 */
class ComposerReplaceFacade extends AbstractFacade implements ComposerReplaceFacadeInterface
{
    /**
     * {@inheritdoc}
     *
     * @api
     *
     * @return \Generated\Shared\Transfer\ComposerReplaceResultCollectionTransfer
     */
    public function validate(): ComposerReplaceResultCollectionTransfer
    {
        return $this->getFactory()->createComposerReplaceValidator()->validate();
    }

    /**
     * {@inheritdoc}
     *
     * @api
     *
     * @return \Generated\Shared\Transfer\ComposerReplaceResultCollectionTransfer
     */
    public function update(): ComposerReplaceResultCollectionTransfer
    {
        return $this->getFactory()->createComposerReplaceUpdater()->update();
    }
}
