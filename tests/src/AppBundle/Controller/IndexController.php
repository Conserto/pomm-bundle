<?php

namespace AppBundle\Controller;

use \AppBundle\Model\MyDb1\PublicSchema\Config;
use AppBundle\Model\MyDb1\PublicSchema\ConfigModel;
use \AppBundle\Model\MyDb1\PublicSchema\ServiceModel;
use \PommProject\Foundation\Session\Session;
use PommProject\PommBundle\ValueResolver\Attribute\Entity;
use \Symfony\Component\Serializer\Serializer;
use \Symfony\Component\HttpFoundation\Response;
use \Symfony\Component\PropertyInfo\PropertyInfoExtractorInterface;
use Twig\Environment;

class IndexController
{
    public function __construct(
        private Environment $templating,
        private readonly Session $pomm,
        private readonly Serializer $serializer,
        private readonly PropertyInfoExtractorInterface $property,
        private readonly Session $serviceSession,
        private readonly ServiceModel $serviceModel
    ) {
    }

    public function indexAction(): Response
    {
        $this->pomm->getQueryManager()
            ->query('select 1');

        return new Response(
            $this->templating->render('Front/index.html.twig')
        );
    }

    public function getAction(?Config $config = null): Response
    {
        return new Response(
            $this->templating->render('Front/get.html.twig', compact('config'))
        );
    }

    /**
     * Get data with default session
     */
    public function getDefaultSessionAction(
        #[Entity(modelClass: ConfigModel::class)] Config $config
    ): Response {
        return new Response(
            $this->templating->render('Front/get.html.twig', compact('config'))
        );
    }

    /**
     * Get data with session 1
     */
    public function getSessionAction(
        #[Entity('my_db', ConfigModel::class)] Config $config
    ): Response {
        return new Response(
            $this->templating->render('Front/get.html.twig', compact('config'))
        );
    }

    /**
     * Get data with session 2
     */
    public function getSession2Action(
        #[Entity('my_db2', ConfigModel::class)] Config $config
    ): Response {
        return new Response(
            $this->templating->render('Front/get.html.twig', compact('config'))
        );
    }

    public function failAction(): void
    {
        $this->pomm->getQueryManager()
            ->query('select 1 from');
    }

    public function serializeAction(): Response
    {
        $results = $this->pomm->getQueryManager()
            ->query('select point(1,2)');

        return new Response(
            $this->serializer->serialize($results, 'json'),
            Response::HTTP_OK,
            ['Content-Type' => 'application/json']
        );
    }

    public function deserializeAction(): Response
    {
        $json = <<<EOF
{
    "name": "test",
    "value": "ok"
}
EOF;

        $config = $this->serializer->deserialize($json, Config::class, 'json');

        return new Response(
            var_export($config, true),
            Response::HTTP_OK
        );
    }

    public function propertyListAction(): Response
    {
        $info = $this->property->getProperties(Config::class);

        return new Response(
            $this->templating->render('Front/properties.html.twig', compact('info'))
        );
    }

    public function propertyTypeAction(string $property): Response
    {
        $info = $this->property->getTypes(Config::class, $property);

        return new Response(
            $this->templating->render('Front/property.html.twig', compact('info'))
        );
    }

    public function serviceModelAction(): Response
    {
        $model = $this->serviceSession->getModel(ServiceModel::class);

        return new Response('Created model as service. Sum:' . $model->getSum());
    }

    public function serviceContainerAction(): Response
    {
        return new Response('Model from container as service. Sum:' . $this->serviceModel->getSum());
    }
}
