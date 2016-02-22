<?php

namespace App;

use Silex\Application;
use Silex\Provider\HttpCacheServiceProvider;
use Silex\Provider\DoctrineServiceProvider;
use Silex\Provider\MonologServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Carbon\Carbon;

final class Rest
{
    /**
     * @var Application
     */
    private $api;

    /**
     * @var array $dbConfig Database configuration params
     */
    private $dbConfig;

    /**
     * @var array $dbConfig
     */
    public $globalConfig;

    /**
     * Rest constructor.
     *
     * @param string $environment
     */
    public function __construct($environment = 'prod')
    {
        $this->api = new \Silex\Application();
        $this->loadConfig($environment);
        $this->registerApiHandler();

    }

    /**
     * @param string $environment possible values are dev, prod
     */
    public function loadConfig($environment)
    {
        $app = $this->api;

        require __DIR__ . "/../../resources/config/$environment.php";

        $this->dbConfig     = $dbConfig;
        $this->globalConfig = $globalConfig;
    }

    /**
     * Register api
     */
    public function registerApiHandler()
    {
        #handle CORS PREFLIGHT request
        $this->api->before(function (Request $request) {
            if ($request->getMethod() === "OPTIONS") {
                $response = new Response();
                $response->headers->set("Access-Control-Allow-Origin", "*");
                $response->headers->set("Access-Control-Allow-Methods", "GET,POST,PUT,DELETE,OPTIONS");
                $response->headers->set("Access-Control-Allow-Headers", "Content-Type");
                $response->setStatusCode(200);

                return $response->send();
            }
        }, Application::EARLY_EVENT);


        #handling CORS response with right headers
        $this->api->after(function (Request $request, Response $response) {
            $response->headers->set("Access-Control-Allow-Origin", "*");
            $response->headers->set("Access-Control-Allow-Methods", "GET,POST,PUT,DELETE,OPTIONS");
        });

        $this->api->before(function (Request $request) {
            if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
                $data = json_decode($request->getContent(), true);
                $request->request->replace(is_array($data) ? $data : array());
            }
        });

        $this->registerModules();

        $this->api->error(function (\Exception $e, $code) {
            $this->api[ 'monolog' ]->addError($e->getMessage());
            $this->api[ 'monolog' ]->addError($e->getTraceAsString());

            return new JsonResponse(
                array("statusCode" => $code, "message" => $e->getMessage(), "stacktrace" => $e->getTraceAsString())
            );
        });

        $this->registerEndpoints();
    }

    /**
     * Register modules
     */
    public function registerModules()
    {
        $this->api->register(new ServiceControllerServiceProvider());
        $this->api->register(new DoctrineServiceProvider(), $this->dbConfig);

        $this->api->register(
            new HttpCacheServiceProvider(),
            array("http_cache.cache_dir" => ROOT_PATH . "/storage/cache",)
        );

        $this->api->register(new MonologServiceProvider(), array(
            "monolog.logfile" => ROOT_PATH . "/storage/logs/" . Carbon::now(
                    $this->globalConfig[ 'timeZone' ]
                )->format($this->globalConfig[ 'dateFormat' ]) . ".log",
            "monolog.level"   => $this->api[ "log.level" ],
            "monolog.name"    => "application"
        ));

    }

    /**
     * Register endpoints
     */
    public function registerEndpoints()
    {

        //TODO fetch endpoints from database
        /**
         * Register any new services for endpoints, map service name to whatever class names
         */
        $controllerMapping = array(
            'notes'      => 'Notes'
        );

        foreach ($controllerMapping as $service => $mappedClass) {
            $routing = new \App\Routing($this->api, $service, $mappedClass);
            $routing->register();
        }
    }

    /**
     * Run the API
     *
     * @return mixed
     */
    public function run()
    {
        return $this->api[ 'http_cache' ]->run();
    }
}
