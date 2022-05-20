<?php

namespace Modules\Shop\Models\Panels;

use Illuminate\Http\Request;
//--- Services --

use Modules\Xot\Models\Panels\XotBasePanel;

class InventoryPanel extends XotBasePanel {
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static string $model = 'Modules\Shop\Models\Panels\InventoryPanel';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static string $title = 'title';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = array (
);

    /**
     * The relationships that should be eager loaded on index queries.
     *
     * @var array
     */
    public function with():array {
        return [];
    }

    public function search() :array {

        return [];
    }

    /**
     * on select the option id
     *
     * quando aggiungi un campo select, è il numero della chiave 
     * che viene messo come valore su value="id"
     *
     */
    public function optionId(object $row) {
        return $row->getKey();
    }

    /**
     * on select the option label.
     */
    public function optionLabel(object $row):string {
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
    public static function indexQuery(array $data, $query)
    {
        //return $query->where('user_id', $request->user()->id);
        return $query;
    }



    /**
     * Get the fields displayed by the resource.
     *
     * @return array
        'col_size' => 6,
        'sortable' => 1,
        'rules' => 'required',
        'rules_messages' => ['it'=>['required'=>'Nome Obbligatorio']],
        'value'=>'..',
     */
    public function fields(): array {
        return array (
  0 => 
  (object) array(
     'type' => 'String',
     'name' => 'name',
     'rules' => 'required',
     'comment' => NULL,
  ),
  1 => 
  (object) array(
     'type' => 'String',
     'name' => 'code',
     'rules' => 'required',
     'comment' => NULL,
  ),
  2 => 
  (object) array(
     'type' => 'Text',
     'name' => 'description',
     'comment' => NULL,
  ),
  3 => 
  (object) array(
     'type' => 'String',
     'name' => 'email',
     'rules' => 'required',
     'comment' => NULL,
  ),
  4 => 
  (object) array(
     'type' => 'String',
     'name' => 'phone_number',
     'comment' => NULL,
  ),
  5 => 
  (object) array(
     'type' => 'String',
     'name' => 'street_address',
     'rules' => 'required',
     'comment' => NULL,
  ),
  6 => 
  (object) array(
     'type' => 'String',
     'name' => 'street_address_plus',
     'comment' => NULL,
  ),
  7 => 
  (object) array(
     'type' => 'String',
     'name' => 'zipcode',
     'rules' => 'required',
     'comment' => NULL,
  ),
  8 => 
  (object) array(
     'type' => 'String',
     'name' => 'city',
     'rules' => 'required',
     'comment' => NULL,
  ),
  9 => 
  (object) array(
     'type' => 'Integer',
     'name' => 'priority',
     'rules' => 'required',
     'comment' => NULL,
  ),
  10 => 
  (object) array(
     'type' => 'Decimal',
     'name' => 'longitude',
     'comment' => NULL,
  ),
  11 => 
  (object) array(
     'type' => 'Decimal',
     'name' => 'latitude',
     'comment' => NULL,
  ),
  12 => 
  (object) array(
     'type' => 'Boolean',
     'name' => 'is_default',
     'rules' => 'required',
     'comment' => NULL,
  ),
  13 => 
  (object) array(
     'type' => 'Bigint',
     'name' => 'country_id',
     'comment' => NULL,
  ),
);
    }

    /**
     * Get the tabs available.
     *
     * @return array
     */
    public function tabs():array {
        $tabs_name = [];

        return $tabs_name;
    }

    /**
     * Get the cards available for the request.
     *
     * @return array
     */
    public function cards(Request $request):array {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function filters(Request $request = null):array {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @return array
     */
    public function lenses(Request $request):array {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @return array
     */
    public function actions():array {
        return [];
    }
}
