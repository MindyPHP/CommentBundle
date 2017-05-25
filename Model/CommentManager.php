<?php

/*
 * This file is part of Mindy Framework.
 * (c) 2017 Maxim Falaleev
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mindy\Bundle\CommentBundle\Model;

use Mindy\Orm\TreeManager;

class CommentManager extends TreeManager
{
    public function published()
    {
        $this->filter(['is_published' => true]);

        return $this;
    }

    public function forObject($type, $id)
    {
        $this->filter([
            'object_type' => $type,
            'object_id' => $id,
        ]);

        return $this;
    }
}
