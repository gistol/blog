<?php

namespace App\Service;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityHelper
{
    private $tokenStorage;

    private $session;
    /**
     * @var UserPasswordEncoder
     */
    private $userPasswordEncoder;

    /**
     * LoginHelper constructor.
     * @param TokenStorageInterface $tokenStorage
     * @param SessionInterface $session
     * @param UserPasswordEncoderInterface $userPasswordEncoder
     */
    public function __construct(
        TokenStorageInterface $tokenStorage,
        SessionInterface $session,
        UserPasswordEncoderInterface $userPasswordEncoder
    )
    {
        $this->tokenStorage = $tokenStorage;
        $this->session = $session;
        $this->userPasswordEncoder = $userPasswordEncoder;
    }

    /**
     * @param User $user
     *
     * See: https://github.com/EasyCorp/easy-security-bundle#basic-usage
     */
    public function login(User $user): void
    {
        $token = new UsernamePasswordToken($user, $user->getPassword(), 'main', $user->getRoles());

        $this->tokenStorage->setToken($token);
        $this->session->set('_security_main', serialize($token));
        $this->session->save();
    }

    /**
     * @param User $user
     * @param string $plainPassword
     * @return bool
     *
     * See: https://symfony.com/doc/current/components/security/authentication.html
     */
    public function isPasswordValid(User $user, string $plainPassword): bool
    {
        return $this->userPasswordEncoder->isPasswordValid(
            $user,
            $plainPassword
        );
    }
}