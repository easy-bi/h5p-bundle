<?php

namespace Studit\H5PBundle\Command;

use Doctrine\DBAL\Exception\TableNotFoundException;
use Oro\Bundle\ConfigBundle\Config\ConfigManager;
use Oro\Component\MessageQueue\Client\MessageProducerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\KernelInterface;
use Studit\H5PBundle\Async\Topics;

class H5pBundleInstallLibraries extends Command
{
    protected static $defaultName = 'h5p-bundle:install-libraries';

    /** @var KernelInterface */
    private $appKernel;

    /** @var MessageProducerInterface */
    private $messageProducer;

    /** @var ConfigManager */
    private $configManager;

    public function __construct(KernelInterface $appKernel, MessageProducerInterface $messageProducer, ConfigManager $configManager)
    {
        $this->appKernel = $appKernel;
        $this->messageProducer = $messageProducer;
        $this->configManager = $configManager;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Install all the libraries.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $libraries = glob($this->appKernel->getProjectDir() . "/vendor/jorisdugue/h5p-bundle/H5P/*.h5p");

        foreach($libraries as $library) {
            $data = array(
                "library" => $library,
                "token" => \H5PCore::createToken('libraryupload'),
                "url" => $this->getConfigValue('base_application_url', 'oro_ui') . "/h5p/ajax/library-upload/"
            );

            $this->messageProducer->send(Topics::INSTALL_LIBRARIES, $data);
        }


        return 0;
    }

    /**
     * @param string $key
     * @param string $namespace
     * @param bool $default
     * @param bool $full
     * @return mixed
     * @noinspection PhpRedundantCatchClauseInspection
     */
    protected function getConfigValue(string $key, string $namespace, bool $default = false, bool $full = false)
    {
        try {
            return $this->configManager->get(sprintf('%s.%s', $namespace, $key), $default, $full);
        } catch (TableNotFoundException $e) {
            return null;
        }
    }
}
