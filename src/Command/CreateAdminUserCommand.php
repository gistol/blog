<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class CreateAdminUserCommand extends Command
{
    protected static $defaultName = 'app:create-admin-user';

    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct();

        $this->em = $em;
    }

    protected function configure()
    {
        $this
            ->setDescription('Create Admin User')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $userRepo = $this->em->getRepository('App:User');

        $user = $userRepo->findOneBy(['username' => 'admin']);

        if (!$user) {
            $user = new User();
            $user
                ->setUsername('admin')
                ->setPlainPassword('admin')
                ->setEmail('admin')
                ->setRoles(['ROLE_ADMIN'])
                ->setIsActive(true);

            $this->em->persist($user);
            $this->em->flush();

            $io->success('OK!');
        } else {
            $io->error('Already exists!');
        }
    }
}
