<?php

namespace App\EventSubscriber;

use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class PasswordEncodeSubscriber implements EventSubscriber
{
    private $userPasswordEncoder;

    public function __construct(UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $this->userPasswordEncoder = $userPasswordEncoder;
    }

    public function getSubscribedEvents(): array
    {
        return [
            'prePersist',
            'preUpdate',
        ];
    }

    public function prePersist(LifecycleEventArgs $args): void
    {
        $this->index($args);
    }

    public function preUpdate(LifecycleEventArgs $args): void
    {
        $this->index($args);
    }

    public function index(LifecycleEventArgs $args): void
    {
        $user = $args->getObject();

        if ($user instanceof User) {

            $plainPassword = $user->getPlainPassword();

            if (null !== $plainPassword && '' !== $plainPassword) {
                $user->setPassword(
                    $this->userPasswordEncoder->encodePassword($user, $plainPassword)
                );
            }
        }
    }
}