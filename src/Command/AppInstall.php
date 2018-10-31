<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Yaml\Yaml;

class AppInstall extends Command
{

    protected static $defaultName = 'app:install';
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct();

        $this->em = $em;
    }

    protected function configure()
    {
        $this
            ->setDescription('Install Blog')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $io = new SymfonyStyle($input, $output);

        $siteName = $io->ask('Please enter the site name', 'Foo');
        $gaID = $io->ask('Please enter the google account id');
        $addAdminUser = $io->confirm('Would you like to create an admin user?', true);

        $array = [
            'parameters' => [
                'appTitle' => $siteName,
                'gaID' => $gaID
            ],
            'twig' => [
                'globals' => [
                    'appTitle' => '%appTitle%',
                    'gaID' => '%gaID%'
                ]
            ]
        ];

        $yaml = Yaml::dump($array, 4);

        $fileSystem = new Filesystem();

        $yamlFile = 'config/packages/blog.yaml';

        if(!$fileSystem->exists($yamlFile)) {
            $fileSystem->touch($yamlFile);
        }
        $fileSystem->dumpFile($yamlFile, $yaml);

        $outputMessages = ['Your configuration saved to config/packages/blog.yaml.'];

        if($addAdminUser) {

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

                $outputMessages[] = 'New admin user has beed added.';

            } else {
                $outputMessages[] = 'Username or email address is already exist.';
            }

        }

        $io->success($outputMessages);

    }

}