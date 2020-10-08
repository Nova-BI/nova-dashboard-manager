<?php

namespace NovaBi\NovaDashboardManager\Traits;

use function NovaBi\NovaDashboardManager\Helpers\Files\getClassesList;

trait LoadMorphablesTrait
{
    public function loadMorphables($paths)
    {

        foreach ($paths as $path) {

            $classlist = getClassesList(base_path($path));
            $morphables = [];
            foreach ($classlist as $c) {
                $morphables[] = $c->classname;
            }
//dd($classlist);
            usort($morphables, function ($a, $b) {
                if (property_exists($a, 'sort_order')) {
                    return $a::$sort_order > $b::$sort_order;
                } else {
                    return true;
                }
            });
        }
//dd($morphables);
        return $morphables;
    }
}
