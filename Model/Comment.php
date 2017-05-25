<?php

/*
 * This file is part of Mindy Framework.
 * (c) 2017 Maxim Falaleev
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mindy\Bundle\CommentBundle\Model;

use Mindy\Bundle\RatingBundle\Model\Rating;
use Mindy\Bundle\RatingBundle\Rating\RatingOwnerInterface;
use Mindy\Bundle\RatingBundle\Rating\RatingOwnerTrait;
use Mindy\Bundle\UserBundle\Model\User;
use Mindy\Orm\Fields\BooleanField;
use Mindy\Orm\Fields\CharField;
use Mindy\Orm\Fields\DateTimeField;
use Mindy\Orm\Fields\EmailField;
use Mindy\Orm\Fields\ForeignField;
use Mindy\Orm\Fields\IntField;
use Mindy\Orm\Fields\TextField;
use Mindy\Orm\TreeModel;

/**
 * Class Comment
 *
 * @method static \Mindy\Bundle\CommentBundle\Model\CommentManager objects($instance = null);
 *
 * @property string $comment
 * @property string $username
 * @property string $email
 * @property string $phone
 * @property int|null $user_id
 * @property User|null $user
 * @property \DateTime|string $created_at
 * @property int|bool $is_published
 * @property int $object_id
 * @property string $object_type
 */
class Comment extends TreeModel implements RatingOwnerInterface
{
    use RatingOwnerTrait;

    public static function getFields()
    {
        return array_merge(parent::getFields(), [
            'object_type' => [
                'class' => CharField::class,
                'editable' => false,
            ],
            'object_id' => [
                'class' => IntField::class,
                'editable' => false,
            ],
            'comment' => [
                'class' => TextField::class,
            ],
            'username' => [
                'class' => CharField::class,
            ],
            'email' => [
                'class' => EmailField::class,
            ],
            'phone' => [
                'class' => CharField::class,
            ],
            'user' => [
                'class' => ForeignField::class,
                'modelClass' => User::class,
            ],
            'created_at' => [
                'class' => DateTimeField::class,
                'autoNowAdd' => true,
            ],
            'is_published' => [
                'class' => BooleanField::class,
                'default' => false,
            ],
        ]);
    }

    public function __toString()
    {
        return (string) $this->comment;
    }

    public function toTree(array $item)
    {
        $yes = Rating::objects()
            ->forObject($this->getObjectType(), $item['id'])
            ->filter(['vote' => true])
            ->count();

        $no = Rating::objects()
            ->forObject($this->getObjectType(), $item['id'])
            ->filter(['vote' => false])
            ->count();

        if (empty($item['username'])) {
            $username = (string)User::objects()->get(['id' => $item['user_id']]);
        } else {
            $username = $item['username'];
        }

        return array_merge($item, [
            'username' => $username,
            'yes' => $yes,
            'no' => $no
        ]);
    }

    /**
     * @return string
     */
    public function getObjectType()
    {
        return 'comment';
    }

    /**
     * @return int|string
     */
    public function getObjectId()
    {
        return $this->id;
    }
}
