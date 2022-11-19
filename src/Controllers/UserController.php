<?php
namespace Twitter2\Controllers;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

use Twitter2\Databases\UserRepository;
use Twitter2\Databases\SQLiteConnection;
use Twitter2\Models\User;

class UserController
{
    private $container;

    // constructor receives container instance
    public function __construct(ContainerInterface $container)
    {
        //var_dump("here");
        $this->container = $container;
    }

    public function get(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        // your code to access items in the container... $this->container->get('');
        $response->getBody()->write("Hello from users!");
        return $response;
    }

    public function create(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        // your code to access items in the container... $this->container->get('');

        $userData = $request->getParsedBody();
        //var_dump($userData);

        //TODO: ADD VALIDATION AND SUCH

        //TODO: ADD DI
        $conn = new SQLiteConnection();
        $userRepository = new UserRepository($conn);

        $user = new User();
        $user->userName = $userData["userName"];
        $user->email = $userData["email"];

        //TODO: HASH THE PASSWORD
        $user->hashedPassword = "1234";

        $userRepository->insertUser($user);

        $response->getBody()->write("Creating Users!");
        return $response;
    }
}

?>