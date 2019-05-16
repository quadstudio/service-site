<?php

namespace QuadStudio\Service\Site\Repositories;

use QuadStudio\Repo\Eloquent\Repository;
use QuadStudio\Service\Site\Filters\CatalogSearchFilter;
use QuadStudio\Service\Site\Models\Catalog;

class CatalogRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return Catalog::class;
    }

    /**
     * @return array
     */
    public function track(): array
    {
        return [
            CatalogSearchFilter::class
        ];
    }

    /**
     * @return array|mixed
     */
    public function tree()
    {
//        if (config('site::cache.use', true) === true) {
//            $cacheKey = 'equipment_catalog_tree';
//            return cache()->remember($cacheKey, config('site::cache.ttl'), function () {
//                return $this->_tree();
//            });
//        }

        return $this->_tree();

    }

    /**
     * @return array
     */
    private function _tree()
    {
        $refs = array();
        $list = array();
        $items = Catalog::query()
            ->orderBy('catalog_id')
            ->orderBy('sort_order')
            ->get();

        foreach ($items as $key => $row) {

            $r = $row->toArray();

            $ref = &$refs[$r['id']];

            $ref = $r;
            $ref['can'] = [
                'addEquipment' => $row->canAddEquipment(),
                'addCatalog' => $row->canAddCatalog()
            ];
            $ref['equipments'] = $row->equipments->toArray();

            if (is_null($r['catalog_id'])) {
                $list[$r['id']] = &$ref;
            } else {
                $refs[$r['catalog_id']]['children'][$r['id']] = &$ref;
            }
        }
        //dd($list);

        return $list;
    }
}