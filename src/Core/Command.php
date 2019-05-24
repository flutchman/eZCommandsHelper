<?php

/**
 * @copyright Copyright (C) Flutchman. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
namespace Flutchman\eZCommandsHelper\Core;

use Flutchman\eZCommandsHelper\Configuration\Project as ProjectConfiguration;
use Symfony\Component\Console\Command\Command as BaseCommand;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class Command.
 */
abstract class Command extends BaseCommand
{
    /**
     * @var SymfonyStyle
     */
    protected $io;

    /**
     * @var ProjectConfiguration
     */
    protected $projectConfiguration;

    /**
     * @var string
     */
    protected $appDir;

    /**
     * @var string
     */
    protected $projectPath;

    /** @var OutputInterface */
    protected $output;

    /** @var ProgressBar */
    protected $progressBar;

    /**
     * {@inheritdoc}
     */
    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $this->io = new SymfonyStyle($input, $output);
        $this->output = $output;
        $this->progressBar = new ProgressBar($output);
        $this->progressBar->setFormat('[%bar%]');
        $this->progressBar->setRedrawFrequency(100);
    }

    public function setProjectConfiguration(ProjectConfiguration $configuration)
    {
        $this->projectConfiguration = $configuration;

        return $this;
    }

    /**
     * @param string $appDir
     */
    public function setAppDir($appDir)
    {
        $this->appDir = $appDir;
    }

    /**
     * @return string
     */
    public function getPayloadDir()
    {
        return "{$this->appDir}payload";
    }

    /**
     * @param string $projectPath
     */
    public function setProjectPath($projectPath)
    {
        $this->projectPath = $projectPath;
    }

    /**
     * @return string
     */
    public function getProjectPath()
    {
        return $this->projectPath;
    }

    /**
     * @param int $max
     */
    public function setProgressMax($max)
    {
        $this->progressBar = new ProgressBar($this->output, $max);
        $this->progressBar->setRedrawFrequency($max > 50000 ? 1000 : 1);
    }
}
