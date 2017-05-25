<?php

/*
 * This file is part of Mindy Framework.
 * (c) 2017 Maxim Falaleev
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mindy\Bundle\CommentBundle\EventListener;

use Mindy\Bundle\MailBundle\Helper\Mail;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Class CommentListener
 */
class CommentListener
{
    /**
     * @var Mail
     */
    protected $mail;
    /**
     * @var UrlGeneratorInterface
     */
    protected $urlGenerator;
    /**
     * @var array
     */
    protected $managers = [];

    /**
     * CommentListener constructor.
     *
     * @param Mail                  $mail
     * @param UrlGeneratorInterface $urlGenerator
     * @param array                 $managers
     */
    public function __construct(Mail $mail, UrlGeneratorInterface $urlGenerator, array $managers)
    {
        $this->mail = $mail;
        $this->urlGenerator = $urlGenerator;
        $this->managers = $managers;
    }

    /**
     * @param CommentEvent $event
     */
    public function onComment(CommentEvent $event)
    {
        if (empty($this->managers)) {
            return;
        }

        foreach ($this->managers as $manager) {
            $this->mail->send('Новый комментарий', $manager, 'comment/mail/new', [
                'comment' => $event->getComment(),
                'owner' => $event->getOwner(),
            ]);
        }
    }
}
