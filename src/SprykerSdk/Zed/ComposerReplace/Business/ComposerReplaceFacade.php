<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Zed\ComposerReplace\Business;

use SprykerSdk\Shared\ComposerReplace\Transfer\ComposerReplaceResultCollectionTransfer;

/**
 * @api
 */
class ComposerReplaceFacade implements ComposerReplaceFacadeInterface
{
    /**
     * @var \SprykerSdk\Zed\ComposerReplace\Business\ComposerReplaceBusinessFactory
     */
    protected $factory;

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @return \SprykerSdk\Shared\ComposerReplace\Transfer\ComposerReplaceResultCollectionTransfer
     */
    public function validate(): ComposerReplaceResultCollectionTransfer
    {
        return $this->getFactory()->createComposerReplaceValidator()->validate();
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @return \SprykerSdk\Shared\ComposerReplace\Transfer\ComposerReplaceResultCollectionTransfer
     */
    public function update(): ComposerReplaceResultCollectionTransfer
    {
        return $this->getFactory()->createComposerReplaceUpdater()->update();
    }

    /**
     * @return \SprykerSdk\Zed\ComposerReplace\Business\ComposerReplaceBusinessFactory
     */
    protected function getFactory(): ComposerReplaceBusinessFactory
    {
        if (!$this->factory) {
            $this->factory = new ComposerReplaceBusinessFactory();
        }

        return $this->factory;
    }
}
