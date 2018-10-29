<?php
/**
 * Created by PhpStorm.
 * User: gurcan
 * Date: 10/29/18
 * Time: 10:31 AM
 */

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Yaml\Yaml;

class AppInstall extends Command
{

    protected static $defaultName = 'app:install';

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
                    'appTitle' => $siteName,
                    'gaID' => $gaID
                ]
            ]
        ];

        $yaml = Yaml::dump($array);

        $fileSystem = new Filesystem();

        $yamlFile = 'config/packages/blog.yaml';
        if(!$fileSystem->exists($yamlFile)) {
            $fileSystem->touch($yamlFile);
        }
        file_put_contents($yamlFile, $yaml);

        if($addAdminUser) {

            $command = $this->getApplication()->find('app:create-admin-user');

            $arguments = array(
                'command' => 'app:create-admin-user'
            );

            $addAdminUserInput = new ArrayInput($arguments);
            $returnCode = $command->run($addAdminUserInput, $output);

        }

        $io->success('Your configuration saved to config/packages/blog.yaml.');

    }

}