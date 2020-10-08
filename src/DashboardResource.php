<?php

namespace NovaBi\NovaDashboardManager;

use DigitalCreative\CollapsibleResourceManager\Resources\AbstractResource;

class DashboardResource extends AbstractResource
{

    /**
     * @var Dashboard
     */
    private $resource;

    /**
     * WidgetResource constructor.
     *
     * @param string $resource
     */
    public function __construct( $resource)
    {
        $this->resource = $resource;
        parent::__construct([]);
    }

    /**
     * Specify data which should be serialized to JSON
     */
    public function jsonSerialize(): array
    {
        return [
            'type' => 'raw_resource',
            'badge' => $this->getBadge(),
            'icon' => $this->getIcon(),
            'label' => $this->getLabel(),
            'router' => [
                'name' => 'nova-dashboard',
                'params' => [
                    'dashboardKey' => $this->resource->resourceUri()
                ],
            ],
        ];
    }
}
