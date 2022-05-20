<?php

declare(strict_types=1);

namespace Modules\Shop\Models\Panels\Actions;

//-------- services --------
use Illuminate\Support\Facades\DB;
use Modules\Food\Models\Location;
use Modules\Food\Models\Restaurant;
use Modules\Geo\Models\Place;
use Modules\Lang\Models\Post;
use Modules\Shop\Models\City;
use Modules\Shop\Models\Shop;
use Modules\Shop\Models\ShopShopCat;
use Modules\Xot\Models\Panels\Actions\XotBasePanelAction;

//-------- bases -----------

/**
 * Class TestAction.
 */
class MigrateFromFoodAction extends XotBasePanelAction {
    public bool $onContainer = false;

    public bool $onItem = true; //onlyContainer

    public string $icon = '<i class="fas fa-vial"></i>';

    /**
     * @return mixed
     */
    public function handle() {
        //return $this->panel->view();

        //$this->fromLocationsToCities();
        //$this->fromRestaurantsToShops();
        $this->shopShopCatTablePopulate();
    }

    public function shopShopCatTablePopulate() {
        $shops = Shop::select('id')->get();

        foreach ($shops as $shop) {
            DB::table('shop_shop_cat')->insert([
                ['shop_id' => $shop->id, 'shop_cat_id' => 1],
            ]);
        }

        /* il modello ShopShopCat l'ho rinominato .old perchè la tabella shop_shop_cat è pivot, quindi non dovrebbe avere modello
        foreach ($shops as $shop) {
            $shop_shop_cat = ShopShopCat::create(['shop_id' => $shop->id, 'shop_cat_id' => 1]);
            $shop_shop_cat->save();
        }
        */
        dddx('fatto');
    }

    public function fromLocationsToCities() {
        /*
        $location = Location::first();
        dddx($location);

        $data = $location->toArray();

        $data['post_id'] = $data['id'];
        unset($data['id'], $data['nearest_street']);

        $place = Place::create($data);
        $city = City::create();
        //dddx(get_class_methods($city->place())); // associate // sync //attach //save
        $data = $location->post->toArray();
        $data['post_id'] = $data['id'];
        unset($data['id']);
        //dddx($data);
        $city->post()->create($data);
        $city->save();
        dddx('fatto');
        */

        $locations = Location::all();
        foreach ($locations as $location) {
            $data = $location->toArray();

            $data['post_id'] = $data['id'];
            unset($data['id'], $data['nearest_street']);

            $place = Place::create($data);
            $city = City::create($data);
            //dddx(get_class_methods($city->place())); // associate // sync //attach //save  //create
            $city->place()->save($place);
            $data = $location->post->toArray();
            $data['post_id'] = $data['id'];
            unset($data['id']);
            //dddx($data);
            $city->post()->create($data);
            $city->save();
        }
        dddx('fatto');

        /*
        $locations = Location::all();
        foreach ($locations as $location) {
            $data = $location->toArray();
            $place = Place::create($data);
            $city = City::create();
            dddx(get_class_methods($city->place())); // associate // sync //attach //save
            $city->post()->create($location->post->toArray());
            $city->save();
        }
        */
    }

    public function fromRestaurantsToShops() {
        /*
        $restaurant = Restaurant::first();
        //dddx($restaurant);
        */

        $restaurants = Restaurant::all();
        foreach ($restaurants as $restaurant) {
            $data = $restaurant->toArray();

            $data['post_id'] = $data['id'];
            unset($data['id']);
            $data['shop_type'] = 'food';

            $place = Place::create($data);
            $shop = Shop::create($data);
            //dddx(get_class_methods($city->place())); // associate // sync //attach //save
            $shop->place()->save($place);
            $data = $restaurant->post->toArray();
            $data['post_id'] = $data['id'];
            unset($data['id']);
            //dddx($data);
            $shop->post()->create($data);
            $shop->save();
        }
        echo 'fatto';
    }
}
