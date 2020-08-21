<?php
namespace App\Service;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;
use App\Repository\CustomTemplateRepository;
use App\Repository\ConfigRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Config;
use App\Form\ConfigType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Twig\Environment;

class TemplateGenerator
{
    private $templateRepo;
    private $configRepo;
    private $em;
    private $twig;

    public function __construct(ConfigRepository $configRepository,  CustomTemplateRepository $customTemplateRepository, EntityManagerInterface $EntityManagerInterface, Environment $twig)
    {
        $this->configRepo = $configRepository;
        $this->templateRepo = $customTemplateRepository;
        $this->em = $EntityManagerInterface;
        $this->twig = $twig;
    }

    public function generate($template_name, $configs)
    {
        //get previous configs from database
        $template_row = $this->templateRepo->findOneBy(['name' => $template_name]);
        $previous_configs = $this->configRepo->findBy(['template_id' => $template_row->getId()]);
        if($previous_configs == null)
            $previous_configs = array();
        $array_previoys_configs = array();
        foreach($previous_configs as $previous_config){
            $array_previoys_configs[$previous_config->getName()] = $previous_config->getValue();
        }
        $new_configs = array_merge($array_previoys_configs, $configs);

        //delete old configs
        foreach($previous_configs as $previous_config){
            $this->em->remove($previous_config);
            $this->em->flush();
        }
        //insert new configs
        foreach($new_configs as $new_config_name => $new_config_value){
            $new_config = new Config();
            $new_config->setName($new_config_name)
                        ->setValue($new_config_value)
                        ->setTemplateId($template_row->getId());
            $this->em->persist($new_config);
            $this->em->flush();
        }
        //get template and produce new config file
        $template_string = $template_row->getContent();
        $template = $this->twig->createTemplate($template_string);
        $filesystem = new Filesystem();
        if($filesystem->exists($template_row->getFilePath()))
            $filesystem->touch($template_row->getFilePath());
        $filesystem->dumpFile($template_row->getFilePath(), $template->render($new_configs));
        //if need to execute command, will do
        if($template_row->getNeedRestart())
            shell_exec("service " . $template_row->getServiceName() . " restart");
        return true;
    }
}