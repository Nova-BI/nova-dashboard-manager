<?php

namespace NovaBi\NovaDashboardManager\Models\Datavisualables\Visuals;


trait Visuable
{

    /**
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public function label(): string
    {
        return 'my label';
    }


    /**
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public function title(): string
    {
        return $this->meta('title');
    }

    public function uriKey(): string
    {
        return $this->meta('uriKey');
    }
}
