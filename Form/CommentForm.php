<?php

/*
 * This file is part of Mindy Framework.
 * (c) 2017 Maxim Falaleev
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mindy\Bundle\CommentBundle\Form;

use Mindy\Bundle\CommentBundle\Model\Comment;
use Mindy\Orm\ModelInterface;
use Misd\PhoneNumberBundle\Validator\Constraints\PhoneNumber;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Validator\Constraints as Assert;

class CommentForm extends AbstractType
{
    /**
     * @var TokenStorageInterface
     */
    protected $tokenStorage;

    /**
     * CommentForm constructor.
     *
     * @param TokenStorageInterface $tokenStorage
     */
    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * Get a user from the Security Token Storage.
     *
     * @throws \LogicException If SecurityBundle is not available
     *
     * @return mixed
     *
     * @see TokenInterface::getUser()
     */
    protected function getUser()
    {
        if (null === $token = $this->tokenStorage->getToken()) {
            return null;
        }

        if (!is_object($user = $token->getUser())) {
            // e.g. anonymous authentication
            return null;
        }

        return $user;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('parent_id', HiddenType::class);

        $user = $this->getUser();
        if (false === ($user instanceof ModelInterface)) {
            $builder
                ->add('username', TextType::class, [
                    'label' => 'Ваше имя',
                    'constraints' => [
                        new Assert\NotBlank(),
                    ],
                ])
                ->add('phone', TextType::class, [
                    'label' => 'Телефон',
                    'constraints' => [
                        new PhoneNumber([
                            'defaultRegion' => 'RU',
                        ]),
                    ],
                ])
                ->add('email', EmailType::class, [
                    'label' => 'Электронная почта',
                    'constraints' => [
                        new Assert\NotBlank(),
                        new Assert\Email(),
                    ],
                ]);
        }

        $builder
            ->add('comment', TextareaType::class, [
                'label' => 'Комментарий',
                'constraints' => [
                    new Assert\NotBlank(),
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Отправить',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
        ]);
    }
}
