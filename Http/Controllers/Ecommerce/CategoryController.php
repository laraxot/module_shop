<?php

namespace Modules\Shop\Http\Controllers\Ecommerce;

use Modules\Shop\Http\Controllers\ShopperBaseController;
use Modules\Shop\Repositories\Ecommerce\CategoryRepository;

class CategoryController extends ShopperBaseController
{
    /**
     * Display Categories resource view.
     *
     * @return \Illuminate\View\View
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('browse_categories');

        return view('shopper::pages.categories.index');
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
        $this->authorize('add_categories');

        return view('shopper::pages.categories.create');
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
        $this->authorize('edit_categories');

        return view('shopper::pages.categories.edit', [
            'category' => (new CategoryRepository())->getById($id),
        ]);
    }
}
