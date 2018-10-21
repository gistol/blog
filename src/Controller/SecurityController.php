<?php

namespace App\Controller;

use App\Service\SecurityHelper;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class SecurityController extends AbstractController
{
    use TargetPathTrait;

    /**
     * @Route("/check_login", name="check_login")
     *
     * @param Request $request
     * @param SecurityHelper $securityHelper
     * @param EntityManagerInterface $em
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function checkLogin(
        Request $request,
        SecurityHelper $securityHelper,
        EntityManagerInterface $em
    ): JsonResponse
    {
        $username = $request->request->get('username', '');
        $password = $request->request->get('password', '');

        $userRepo = $em->getRepository('App:User');

        $user = $userRepo->findOneBy(['username' => $username]);

        if ($user) {

            if ($securityHelper->isPasswordValid($user, $password)) {

                if ($user->getIsActive()) {

                    $securityHelper->login($user);

                    $targetPath = $this->getTargetPath($request->getSession(), 'main') ?? '/';
                    $this->removeTargetPath($request->getSession(), 'main');

                    return $this->json(['success' => true, 'targetPath' => $targetPath]);

                }

            }

        }

        return $this->json(['success' => false, 'error' => 'Login failed!']);
    }
}