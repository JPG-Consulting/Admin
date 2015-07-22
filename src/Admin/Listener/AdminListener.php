<?php
namespace Admin\Listener;


use Zend\Mvc\Router\Http\RouteMatch;

use Zend\Mvc\MvcEvent;

use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventManagerInterface;

class AdminListener extends AbstractListenerAggregate
{

    /**
     * (non-PHPdoc)
     * @see vendor/zendframework/zendframework/library/Zend/EventManager/Zend\EventManager.ListenerAggregateInterface::attach()
     */
    public function attach(EventManagerInterface $events)
    {
        $this->listeners[] = $events->attach(MvcEvent::EVENT_ROUTE, array($this, 'onRoute'));
        $this->listeners[] = $events->attach(MvcEvent::EVENT_DISPATCH, array($this, 'onDispatch'));
    }
    
	/**
     * Listen to the "route" event
     *
     * @param  MvcEvent $e
     * @return mixed
     */
    public function onRoute(MvcEvent $e)
    {
        $routeMatch       = $e->getRouteMatch();
        $application      = $e->getApplication();
        $serviceManager   = $application->getServiceManager();
        
        $match      = $e->getRouteMatch();
        
        if ( !$match instanceof RouteMatch ) {
            return;
        }
        if (0 !== strcasecmp($match->getMatchedRouteName(), 'admin') && 0 !== strpos($match->getMatchedRouteName(), 'admin/')) {
            return;
        }
        
        // Login is allowed without authentication
        if ((strcasecmp($match->getMatchedRouteName(), 'admin/login') === 0) || (strcasecmp($match->getMatchedRouteName(), 'admin/password_reset') === 0)) {
            return;
        }
        
        $authenticationService = $serviceManager->get("Admin/AuthenticationService");
        if (!$authenticationService->hasIdentity()) {
            $url = $e->getRouter()->assemble(array(), array('name' => 'admin/login'));
            $response=$e->getResponse();
            $response->getHeaders()->addHeaderLine('Location', $url);
            $response->setStatusCode(302);
            $response->sendHeaders();
            
            
            $event->stopPropagation();
            // When an MvcEvent Listener returns a Response object,
            // It automatically short-circuit the Application running 
            // -> true only for Route Event propagation see Zend\Mvc\Application::run

            // To avoid additional processing
            // we can attach a listener for Event Route with a high priority
            //$stopCallBack = function($event) use ($response){
            //    $event->stopPropagation();
            //    return $response;
            //};
            
            return $response;
        }
        
    }
    
    /**
     * Listen to the "dispatch" event
     *
     * @param  MvcEvent $e
     * @return mixed
     */
    public function onDispatch(MvcEvent $e)
    {
        $routeMatch       = $e->getRouteMatch();
        $application      = $e->getApplication();
        $serviceManager   = $application->getServiceManager();
        
        $match      = $e->getRouteMatch();
        if (!$match instanceof RouteMatch) {
            return;
        }
        
        $controller = $e->getTarget();
        if ($controller->getEvent()->getResult()->terminate()) {
            return;
        }
        
        $matchedRouteName = $match->getMatchedRouteName();
        if (strcasecmp($matchedRouteName, 'admin') !== 0 && strpos($match->getMatchedRouteName(), 'admin/') !== 0) {
            return;
        }
        
        // Admin login
        if ((strcasecmp($matchedRouteName, 'admin/login') === 0) || (strcasecmp($matchedRouteName, 'admin/password_reset') === 0)) {
            $controller->layout('layout/admin/empty');
            return;
        }
        
        // For all others
        $controller->layout('layout/admin');
    }
}