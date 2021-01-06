<?php
use YPHP\Model\Media\EntityMedia;

return [
    'doctrine' => [
        'driver' => [
            'YPHP' => [
                'class' => \Doctrine\ORM\Mapping\Driver\AnnotationDriver::class,
                'cache' => 'array',
                'paths' => [
                    0 => 'J:\\app\\quachvanhao2020\\ApiServer\\vendor\\hao\\yphp\\config/../src',
                ],
            ],
            'orm_default' => [
                'drivers' => [
                    'YPHP' => 'YPHP',
                ],
            ],
        ],
    ],
    'router' => [
        'routes' => [
            \YPHP\Api\V1\Rest\Stream\Controller::class => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/streams[/:streams_id]',
                    'defaults' => [
                        'controller' => \YPHP\Api\V1\Rest\Stream\Controller::class,
                    ],
                ],
            ],
        ],
    ],
    'api-tools-versioning' => [
        'uri' => [
            0 => \YPHP\Api\V1\Rest\Stream\Controller::class,
        ],
    ],
    'api-tools-hal' => [
        'metadata_map' => [
            \YPHP\Api\V1\Rest\Stream\Entity::class => [
                'entity_identifier_name' => 'id',
                'route_name' => \YPHP\Api\V1\Rest\Stream\Controller::class,
                'route_identifier_name' => 'streams_id',
                'hydrator' => \Doctrine\Laminas\Hydrator\XDoctrineObject::class,
            ],
            \YPHP\Api\V1\Rest\Stream\Collection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => \YPHP\Api\V1\Rest\Stream\Controller::class,
                'route_identifier_name' => 'streams_id',
                'is_collection' => true,
            ],
        ],
    ],
    'api-tools-rest' => [
        \YPHP\Api\V1\Rest\Stream\Controller::class => [
            'listener' => \YPHP\Api\V1\Rest\Stream\Resource::class,
            'route_name' => \YPHP\Api\V1\Rest\Stream\Controller::class,
            'route_identifier_name' => 'streams_id',
            'collection_name' => 'streams',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'PATCH',
                2 => 'DELETE',
                3 => 'PUT',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
            ],
            'collection_query_whitelist' => [],
            'page_size' => 25,
            'page_size_param' => '50',
            'entity_class' => \YPHP\Api\V1\Rest\Stream\Entity::class,
            'entity_class' => EntityMedia::class,
            'collection_class' => \YPHP\Api\V1\Rest\Stream\Collection::class,
            'service_name' => 'streams',
        ],
    ],
    'api-tools-content-negotiation' => [
        'controllers' => [
            \YPHP\Api\V1\Rest\Stream\Controller::class => 'HalJson',
        ],
        'accept_whitelist' => [
            \YPHP\Api\V1\Rest\Stream\Controller::class => [
                0 => 'application/vnd.user.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
        ],
        'content_type_whitelist' => [
            \YPHP\Api\V1\Rest\Stream\Controller::class => [
                0 => 'application/vnd.user.v1+json',
                1 => 'application/json',
            ],
        ],
    ],
    'api-tools-content-validation' => [
        \YPHP\Api\V1\Rest\Stream\Controller::class => [
            'input_filter' => \YPHP\Api\V1\Rest\Stream\Validator::class,
        ],
    ],
    'input_filter_specs' => [
        \YPHP\Api\V1\Rest\Stream\Validator::class => [
            0 => [
                'name' => 'id',
                'required' => false,
                'filters' => [],
                'validators' => [],
            ],
            1 => [
                'name' => 'class',
                'required' => false,
                'filters' => [],
                'validators' => [],
            ],
            2 => [
                'required' => false,
                'validators' => [],
                'filters' => [],
                'name' => 'dtype',
            ],
            3 => [
                'required' => false,
                'validators' => [],
                'filters' => [],
                'name' => 'src',
            ],
        ],
    ],
    'api-tools-mvc-auth' => [
        'authorization' => [
            \YPHP\Api\V1\Rest\Stream\Controller::class => [
                'collection' => [
                    'GET' => false,
                    'POST' => false,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ],
                'entity' => [
                    'GET' => false,
                    'POST' => false,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ],
            ],
        ],
    ],
    'api-tools' => [
        'db-connected' => [
            \YPHP\Api\V1\Rest\Stream\Resource::class => [
                'adapter_name' => 'sqlite',
                'table_name' => 'streams',
                'hydrator_name' => \Doctrine\Laminas\Hydrator\XDoctrineObject::class,
                'controller_service_name' => \YPHP\Api\V1\Rest\Stream\Controller::class,
                'entity_identifier_name' => 'id',
                'table_service' => 'YPHP\\Api\\V1\\Rest\\Stream\\Resource\\Table',
            ],
        ],
    ],
];
