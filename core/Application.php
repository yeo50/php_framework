<?php

namespace app\core;

class Application
{
    public static string $ROOT_DIR;
    public string $layout = 'main';
    public string $userClass;
    public Router $router;
    public Request $request;
    public Response $response;
    public Session $session;
    public Database $db;
    public ?Controller $controller = null;
    public ?UserModel $user;
    public View $view;
    public static Application $app;
    public function __construct($rootPath, array $config)
    {
        $this->userClass = $config['userClass'];
        self::$ROOT_DIR = $rootPath;
        self::$app = $this;
        $this->request = new Request();
        $this->response = new Response();
        $this->session = new Session();
        $this->view = new View();
        $this->router = new Router($this->request, $this->response);
        $this->db = new Database($config['db']);
        $primaryValue = $this->session->get('user');
        if ($primaryValue) {
            $primaryKey = $this->userClass::primaryKey();
            $this->user = $this->userClass::findOne([$primaryKey => $primaryValue]);
        } else {
            $this->user = null;
        }
    }
    public function run()
    {
        try {
            echo  $this->router->resolve();
        } catch (\Exception $e) {
            $this->response->setStatusCode($e->getCode());

            echo  $this->view->renderView('_error', ['exception' => $e]);
        }
    }
    public function getController(): Controller
    {
        return $this->controller;
    }
    public function setController(Controller $controller): void
    {
        $this->controller = $controller;
    }
    public function login(UserModel $user)
    {
        $this->user = $user;
        $primaryKey = $user->primaryKey();
        $primaryValue = $user->{$primaryKey};
        $this->session->set('user', $primaryValue);
        return true;
    }
    public static function isGuest()
    {
        return !self::$app->user;
    }
    public function logout()
    {
        $this->user = null;
        $this->session->remove('user');
    }
}
