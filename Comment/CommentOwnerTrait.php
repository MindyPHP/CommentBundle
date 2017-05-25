<?php

/*
 * This file is part of Mindy Framework.
 * (c) 2017 Maxim Falaleev
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mindy\Bundle\CommentBundle\Comment;

use Mindy\Bundle\CommentBundle\Model\Comment;

/**
 * Class CommentOwnerTrait
 */
trait CommentOwnerTrait
{
    public function getComments()
    {
        return Comment::objects()
            ->published()
            ->forObject($this->getObjectType(), $this->getObjectId())
            ->asTree()
            ->all();
    }

    public function getCommentsCount()
    {
        return Comment::objects()
            ->published()
            ->forObject($this->getObjectType(), $this->getObjectId())
            ->count();
    }
}
