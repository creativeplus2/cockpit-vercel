<?php

 // Module ACL definitions.
$this("acl")->addResource('vercel', [
  'manage.view'
]);

if (COCKPIT_ADMIN && !COCKPIT_API_REQUEST) {

    $app->on('admin.init', function(){
        
        $this->bindClass('Vercel\\Controller\\Admin', 'vercel');

        
        $this('admin')->addMenuItem('modules', [
          'label' => 'Vercel',
          'icon' => 'vercel:icon.svg',
          'route' => '/vercel',
          'active' => strpos($this['route'], '/vercel') === 0,
        ]);
        
        

    });

}