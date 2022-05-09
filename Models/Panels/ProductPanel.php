<?php

declare(strict_types=1);

namespace Modules\Shop\Models\Panels;

use Illuminate\Http\Request;
//--- Services --

use Modules\Xot\Models\Panels\XotBasePanel;

class ProductPanel extends XotBasePanel {
    /**
     * The model the resource corresponds to.
     */
    public static string $model = 'Modules\Shop\Models\Panels\ProductPanel';

    /**
     * The single value that should be used to represent the resource when being displayed.
     */
    public static string $title = 'title';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
    ];

    /**
     * The relationships that should be eager loaded on index queries.
     *
     * @var array
     */
    public function with(): array {
        return [];
    }

    public function search(): array {
        return [];
    }

    /**
     * on select the option id.
     *
     * quando aggiungi un campo select, è il numero della chiave
     * che viene messo come valore su value="id"
     */
    public function optionId(object $row) {
        return $row->getKey();
    }

    /**
     * on select the option label.
     */
    public function optionLabel(object $row): string {
        return $row->area_define_name;
    }

    /**
     * index navigation.
     */
    public function indexNav(): ?\Illuminate\Contracts\Support\Renderable {
        return null;
    }

    /**
     * Build an "index" query for the given resource.
     *
     * @param RowsContract $query
     *
     * @return RowsContract
     */
    public static function indexQuery(array $data, $query) {
        //return $query->where('user_id', $request->user()->id);
        return $query;
    }

    public function nameDescrFields(): array {
        return [
            (object) [
                'type' => 'Text',
                'name' => 'name',
                'comment' => 'not in Doctrine',
            ],
            (object) [
                'type' => 'Text',
                'name' => 'description',
                'comment' => 'not in Doctrine',
            ],
        ];
    }

    public function priceFields(): array {
        return [
            (object) [
                'type' => 'Text',
                'name' => 'price_amount',
                'comment' => 'not in Doctrine',
                'col_size' => 6,
            ],
            (object) [
                'type' => 'Text',
                'name' => 'old_price_amount',
                'comment' => 'not in Doctrine',
                'col_size' => 6,
            ],
            (object) [
                'type' => 'Text',
                'name' => 'cost_amount',
                'comment' => 'not in Doctrine',
                'col_size' => 6,
            ],
        ];
    }

    public function inventoryFields(): array {
        return [
            (object) [
                'type' => 'Text',
                'name' => 'sku',
                'comment' => 'not in Doctrine',
                'col_size' => 6,
            ],
            (object) [
                'type' => 'Text',
                'name' => 'barcode',
                'comment' => 'not in Doctrine',
                'col_size' => 6,
            ],
            (object) [
                'type' => 'Text',
                'name' => 'security_stock',
                'comment' => 'not in Doctrine',
                'col_size' => 6,
            ],
        ];
    }

    public function shippingFields(): array {
        return [
            (object) [
                'type' => 'Text',
                'name' => 'backorder',
                'comment' => 'not in Doctrine',
            ],
            (object) [
                'type' => 'Text',
                'name' => 'requires_shipping',
                'comment' => 'not in Doctrine',
            ],
        ];
    }

    public function productStatusFields(): array {
        return [
            (object) [
                'type' => 'Text',
                'name' => 'is_visible',
                'comment' => 'not in Doctrine',
            ],
            (object) [
                'type' => 'Text',
                'name' => 'published_at',
                'comment' => 'not in Doctrine',
            ],
        ];
    }

    public function productAssociationsFields(): array {
        return [
            /*
            (object) [
                'type' => 'Text',
                'name' => 'brand_id',
                'comment' => 'not in Doctrine',
            ],

            (object) [
                'type' => 'Text',
                'label' => 'Categories',
                'name' => 'brand_id',
                'comment' => 'not in Doctrine',
            ],
            (object) [
                'type' => 'Text',
                'label' => 'Collections',
                'name' => 'brand_id',
                'comment' => 'not in Doctrine',
            ],
            */
        ];
    }

    /**
     * Get the fields displayed by the resource.
        'value'=>'..',
     */
    public function fields(): array {
        return [
            (object) [
                'type' => 'Cell',
                'name' => '',
                'fields' => $this->nameDescrFields(),
            ],
            (object) [
                'type' => 'Text',
                'name' => 'image',
                'label' => 'Product Media',
            ],

            (object) [
                'type' => 'Cell',
                'name' => 'Pricing',
                'fields' => $this->priceFields(),
            ],
            (object) [
                'type' => 'Cell',
                'name' => 'Inventory',
                'fields' => $this->inventoryFields(),
            ],

            (object) [
                'type' => 'Cell',
                'name' => 'Shipping',
                'fields' => $this->shippingFields(),
            ],
            (object) [
                'type' => 'Cell',
                'name' => 'Product Status',
                'fields' => $this->productStatusFields(),
            ],
            (object) [
                'type' => 'Cell',
                'name' => 'Product associations',
                'fields' => $this->productAssociationsFields(),
            ],
        ];
    }

    /**
     * Get the tabs available.
     */
    public function tabs(): array {
        $tabs_name = [];

        return $tabs_name;
    }

    /**
     * Get the cards available for the request.
     */
    public function cards(Request $request): array {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function filters(Request $request = null): array {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     */
    public function lenses(Request $request): array {
        return [];
    }

    /**
     * Get the actions available for the resource.
     */
    public function actions(): array {
        return [];
    }
}