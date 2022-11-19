<?php
namespace Twitter2\Controllers;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

use Twitter2\Databases\StatusRepository;
use Twitter2\Databases\SQLiteConnection;
use Twitter2\Models\Status;
use Slim\Routing\RouteContext;

class StatusController
{
    private $container;
    private $statusRepository;

    // constructor receives container instance
    public function __construct(ContainerInterface $container)
    {
        //var_dump("here");
        $this->container = $container;

        //TODO: ADD DI
        $conn = new SQLiteConnection();
        $this->statusRepository = new StatusRepository($conn);

    }

    public function getAll(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        // your code to access items in the container... $this->container->get('');
        $response->getBody()->write("Hello from users!");
        return $response;
    }

    public function getSingle(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        // your code to access items in the container... $this->container->get('');

        $routeContext = RouteContext::fromRequest($request);
        $route = $routeContext->getRoute();

        $statusId = $route->getArgument('statusid');

        $resStatus = $this->statusRepository->findStatusById($statusId);

        $payload = json_encode($resStatus); //TODO: ENHANCE THIS PART

        $response->getBody()->write($payload);

        return $response->withHeader('Content-Type', 'application/json');
    }

    public function create(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        // your code to access items in the container... $this->container->get('');

        $routeContext = RouteContext::fromRequest($request);
        $route = $routeContext->getRoute();

        $statusData = $request->getParsedBody();
        //var_dump($userData);

        //TODO: ADD VALIDATION AND SUCH

        $status = new Status();

        $status->userId = $route->getArgument('userid'); //$statusData["userId"]; //TODO: AUTHORIZE ONLY THE OWNER
        $status->statusText = $statusData["statusText"];

        $this->statusRepository->insertStatus($status);

        $response->getBody()->write("Created status!");
        return $response;
    }
}

?>