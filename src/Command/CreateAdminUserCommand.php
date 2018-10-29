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

        $username = $io->ask('Please enter a username', 'admin');
        $password = $io->ask('Please enter a password', 'admin');
        $email = $io->ask('Please enter an email address', 'admin@admin.com');

        $userRepo = $this->em->getRepository('App:User');

        $userByUsername = $userRepo->findOneBy(['username' => $username]);
        $userByEmail = $userRepo->findOneBy(['email' => $email]);

        if (!$userByUsername && !$userByEmail) {
            $user = new User();
            $user
                ->setUsername($username)
                ->setPlainPassword($password)
                ->setEmail($email)
                ->setRoles(['ROLE_ADMIN'])
                ->setIsActive(true);

            $this->em->persist($user);
            $this->em->flush();

            $io->success('New admin user has beed added..');

        } else {
            $io->error('Username or email address is already exist.');
        }
    }
}
