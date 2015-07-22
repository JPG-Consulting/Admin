<?php
return array(
    'router' => array(
        'routes' => array(
            'admin' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/admin',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Admin\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                    'login' => array(
                        'type'    => 'Literal',
                        'options' => array(
                            'route'    => '/login',
                            'defaults' => array(
                                'controller'    => 'Authentication',
                        		'action'        => 'login',
                            ),
                        ),
                    ),
                    'logout' => array(
                        'type'    => 'Literal',
                        'options' => array(
                            'route'    => '/logout',
                            'defaults' => array(
                                'controller'    => 'Authentication',
                        		'action'        => 'logout',
                            ),
                        ),
                    ),
                    'password_reset' => array(
                        'type'    => 'Literal',
                        'options' => array(
                            'route'    => '/password_reset',
                            'defaults' => array(
                                'controller'    => 'Authentication',
                        		'action'        => 'reset',
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'navigation' => array(
        'admin' => array(),
    ),
    'service_manager' => array(
        'factories' => array(
            'admin_navigation' => 'Admin\Service\AdminNavigationFactory',
            'Admin/AuthenticationService' => 'Admin\Service\AuthenticationServiceFactory'
        ),
    ),
    'translator' => array(
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Admin\Controller\Index'          => 'Admin\Controller\IndexController',
            'Admin\Controller\Authentication' => 'Admin\Controller\AuthenticationController'
        ),
    ),
    'view_manager' => array(
        'template_map' => array(
            'layout/admin'           => __DIR__ . '/../view/layout/admin.phtml',
            'layout/admin/empty'     => __DIR__ . '/../view/layout/admin-empty.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);