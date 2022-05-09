<?php

namespace Modules\Shop\Http\Controllers\Ecommerce;

use Modules\Shop\Http\Controllers\ShopperBaseController;
use Modules\Shop\Repositories\Ecommerce\BrandRepository;

class BrandController extends ShopperBaseController
{
    /**
     * Return brands list view.
     *
     * @return \Illuminate\View\View
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('browse_brands');

        return view('shopper::pages.brands.index');
    }

    /**
     * Display Create view.
     *
     * @return \Illuminate\View\View
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('add_brands');

        return view('shopper::pages.brands.create');
    }

    /**
     * Display Edit form.
     *
     * @return \Illuminate\View\View
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(int $id)
    {
        $this->authorize('edit_brands');

        return view('shopper::pages.brands.edit', [
            'brand' => (new BrandRepository())->getById($id),
        ]);
    }
}
