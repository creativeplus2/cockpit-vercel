<?php

namespace Vercel\Controller;

use Cockpit\AuthController;

/**
 * Admin controller class.
 */
class Admin extends AuthController
{

    protected $settings = [];
    
    public function __construct($app) {
        parent::__construct($app);
        $this->settings = $app->config['vercel'];
    }

      /**
       * Default index controller.
       */
    public function index(){
        
        if (!$this->app->module('cockpit')->hasaccess('vercel', 'manage.view')) {
          return false;
        }
    
        $build_hook_url = $this->settings['build_hook_url'];
        $api_url = $this->settings['api_url'];
        $projectid = $this->settings['projectid'];
        $token = $this->settings['token'];

    
        return $this->render('vercel:views/index.php', [
            'build_hook_url' => $build_hook_url,
            'api_url' => $api_url,
            'projectid' => $projectid,
            'token' => $token
        ]);
        
    }

}

