<?php

/*
 * This file is part of Mindy Framework.
 * (c) 2017 Maxim Falaleev
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mindy\Bundle\CommentBundle\EventListener;

use Mindy\Bundle\CommentBundle\Comment\CommentOwnerInterface;
use Mindy\Bundle\CommentBundle\Model\Comment;
use Symfony\Component\EventDispatcher\Event;

class CommentEvent extends Event
{
    const EVENT = 'comment_new';

    /**
     * @var CommentOwnerInterface
     */
    protected $owner;
    /**
     * @var Comment
     */
    protected $comment;

    /**
     * CommentEvent constructor.
     * @param CommentOwnerInterface $owner
     * @param Comment $comment
     */
    public function __construct(CommentOwnerInterface $owner, Comment $comment)
    {
        $this->owner = $owner;
        $this->comment = $comment;
    }

    /**
     * @return CommentOwnerInterface
     */
    public function getOwner() : CommentOwnerInterface
    {
        return $this->owner;
    }

    /**
     * @return Comment
     */
    public function getComment() : Comment
    {
        return $this->comment;
    }
}
