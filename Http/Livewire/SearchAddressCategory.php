<?php

declare(strict_types=1);

namespace Modules\Shop\Http\Livewire;

use Illuminate\Contracts\Support\Renderable;
use Livewire\Component;
use Modules\Shop\Models\City;
use Modules\Shop\Models\ShopCat;
use Modules\Xot\Services\PanelService;

class SearchAddressCategory extends Component
{
    public string $type = 'google';
    //public string $type = 'algolia';
    public $place; //lo utilizzo per estrapolare le info che mi servono
    public float $lat = 0;
    public float $lng = 0;
    public string $city = '';
    /*string*/ public $street_number;
    public bool $showCategories = false;
    public array $categories;

    protected $rules = [
        'street_number' => 'required',
    ];

    public function mount(): void
    {
        //$this->address = json_encode([]);

        $this->categories = ShopCat::with('post')->get()->toArray();
    }

    public function render(): Renderable
    {
        if ('algolia' == $this->type) {
            $view = 'shop::livewire.search_address_category.algolia';
        } else {
            //$view = 'shop::livewire.search_address_category.google';
            $view = 'shop::livewire.search_address_category.google2';
        }

        $view_params = [
            'view' => $view,
            'name' => 'address',
            //'class' => 'input home-address-input ng-untouched ng-pristine ng-valid pac-target-input',
            //'class' => '',
            'placeholder' => 'inserisci indirizzo',
            //'rows' =>
        ];

        return view()->make($view, $view_params);
    }

    public function viewCategories(): void
    {
        //$data_address = json_decode(($this->address));

        $this->getParamsFromGoogle();

        $this->validate(); //deve stare dopo getParamsFromGoogle!!!

        $this->setUrlCategoryByCity();

        $this->showCategories = true;
    }

    public function setUrlCategoryByCity()
    {
        //$city_panel = City::with('post')->where($this->city, 'post.title')->first();

        $city = City::whereHas('posts', function ($query) {
            $query->where('title', $this->city);
        })->with('post')->first();

        if (empty($city)) {
            throw new \Exception('Selected city model is not existing, or city table is empty');
        }

        $city_panel = PanelService::make()->get($city);
        // /it/cities/bologna/shop_cats/food?name=shop%3A%3Asearch_address_category
        $food_cat_panel = PanelService::make()->get(ShopCat::find(1))->setParent($city_panel)->url();
        dddx($food_cat_panel);
    }

    public function getParamsFromGoogle(): void
    {
        //google
        //{"value":"Via Orazio Marcellino, Acquaviva delle Fonti, BA, Italia","latlng":{"lat":40.8924348,"lng":16.8457425},"route":"Via Orazio Marcellino","route_short":"Via Orazio Marcellino","locality":"Acquaviva delle Fonti","locality_short":"Acquaviva delle Fonti","administrative_area_level_3":"Acquaviva delle fonti","administrative_area_level_3_short":"Acquaviva delle fonti","administrative_area_level_2":"Città Metropolitana di Bari","administrative_area_level_2_short":"BA","administrative_area_level_1":"Puglia","administrative_area_level_1_short":"Puglia","country":"Italia","country_short":"IT","postal_code":"70021","postal_code_short":"70021"}

        foreach ($this->place['address_components'] as $address_component) {
            //dddx($address_component);
            if ('street_number' == $address_component['types'][0]) {
                $this->street_number = $address_component['long_name'];
            }
        }

        $this->lat = $this->place['geometry']['location']['lat'];
        $this->lng = $this->place['geometry']['location']['lng'];
        $this->city = $this->place['vicinity'];

        /*
        dddx([
            $this->street_number,
            $this->lat,
            $this->lng,
            $this->city,
        ]);
        */
    }

    public function getParamsFromAlgolia(): void
    {
        dddx('da fare');

        //algolia
        //{"name":"Via 5 Episcopo","administrative":"Puglia","county":"Bari","city":"Acquaviva delle Fonti","country":"Italia","countryCode":"it","type":"address","latlng":{"lat":40.8944,"lng":16.8465},"postcode":"70021","value":"Via 5 Episcopo, Acquaviva delle Fonti, Puglia, Italia"}    }
    }
}
