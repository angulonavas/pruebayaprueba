<?php

namespace AppBundle\Command;

use AppBundle\Entity\Servicio;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class OcultarServiciosCommand extends Command {

    private $em;

    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
        parent::__construct();
    }

    protected function configure() {
    
        $this
        
	        // the name of the command (the part after "bin/console")
	        ->setName('app:ocultar-servicios')

	        // the short description shown while running "php bin/console list"
	        ->setDescription('Ocultando los servicios caducados.')

	        // the full command description shown when running the command with
	        // the "--help" option
	        ->setHelp('Este comando te permite ocultar los servicios caducados')
    	;
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
     	$this->em->getRepository(Servicio::class)->ocultarServicios();
    }
}