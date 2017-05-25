<?php

/*
 * This file is part of Mindy Framework.
 * (c) 2017 Maxim Falaleev
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mindy\Bundle\CommentBundle\Controller;

use Mindy\Bundle\CommentBundle\Form\CommentForm;
use Mindy\Bundle\CommentBundle\Model\Comment;
use Mindy\Bundle\MindyBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class CommentController extends Controller
{
    public function listAction(Request $request)
    {
        $objectType = $request->query->get('object_type');
        $objectId = $request->query->get('object_id');

        if (empty($objectId) && empty($objectType)) {
            throw new BadRequestHttpException();
        }

        $qs = Comment::objects()->published()->forObject($objectType, $objectId);

        return $this->render('comment/list.html', [
            'comments' => $qs->asTree()->all(),
        ]);
    }

    public function createAction(Request $request)
    {
        $objectType = $request->query->get('object_type');
        $objectId = $request->query->get('object_id');

        if (empty($objectId) && empty($objectType)) {
            throw new BadRequestHttpException();
        }

        $comment = new Comment([
            'object_type' => $objectType,
            'object_id' => $objectId,
            'user' => $this->getUser(),
        ]);

        $form = $this->createForm(CommentForm::class, $comment, [
            'method' => 'POST',
            'action' => '',
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
            }
        }

        return $this->render('comment/form.html', [
            'form' => $form->createView(),
        ]);
    }
}
