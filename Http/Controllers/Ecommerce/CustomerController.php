<?php

namespace Modules\Shop\Http\Controllers\Ecommerce;

use Modules\Shop\Repositories\UserRepository;
use Modules\Shop\Http\Controllers\ShopperBaseController;

class CustomerController extends ShopperBaseController
{
    /**
     * Return customers list view.
     *
     * @return \Illuminate\View\View
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('browse_customers');

        return view('shopper::pages.customers.index');
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
        $this->authorize('add_customers');

        return view('shopper::pages.customers.create');
    }

    /**
     * Display Show view.
     *
     * @return \Illuminate\View\View
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(int $id)
    {
        $this->authorize('read_customers');

        return view('shopper::pages.customers.show', [
            'customer' => (new UserRepository())->with(['addresses', 'orders'])->getById($id),
        ]);
    }
}
