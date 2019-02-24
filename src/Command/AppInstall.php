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

/**
 * Class AppInstall
 * @package App\Command
 */
class AppInstall extends Command
{
    protected static $defaultName = 'app:install';

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @var string
     */
    private $projectDir;

    public function __construct(EntityManagerInterface $em, Filesystem $filesystem, string $projectDir)
    {
        parent::__construct();

        $this->em = $em;
        $this->filesystem = $filesystem;
        $this->projectDir = $projectDir;
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Install Blog');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $siteName = $io->ask('Please enter the site name', 'Foo');
        $gaID = $io->ask('Please enter the google account id');
        $addAdminUser = $io->confirm('Would you like to create an admin user?');

        // Update blog.yaml
        $twigGlobals = [
            'twig' => [
                'globals' => [
                    'appTitle' => '%env(resolve:APP_TITLE)%',
                    'gaID' => '%env(resolve:APP_GA_ID)%'
                ]
            ]
        ];

        $this->filesystem->dumpFile('config/packages/blog.yaml', Yaml::dump($twigGlobals, 4));

        // Update the .env file
        $envFile = file_get_contents($this->projectDir . '/.env');
        $envFile = str_replace(
            [
                'DefaultAppTitle',
                'DefaultAppGaId',
            ],
            [
                '"'.$siteName.'"',
                '"'.$gaID.'"',
            ],
            $envFile
        );
        $this->filesystem->dumpFile('.env', $envFile);

        $outputMessages = ['Your configuration saved to config/packages/blog.yaml.'];

        if ($addAdminUser) {

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