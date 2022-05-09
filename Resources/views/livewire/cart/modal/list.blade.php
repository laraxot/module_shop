  @component('theme::components.modal.simple',['guid'=>'modal_cart_list','title'=>'il tuo carrello', 'size' => 'lg'])
    @slot('content')
      <h3>{{ count($this->cart) }} Items</h3>

        <table class="table">
          <thead>
            <tr>
              <td>Name</td>
              <td>Qty</td>
              <td> price Unit</td>
              <td> price Tot</td>
              <td> Remove </td>
            </tr>
          </thead>
          <tbody>
            @foreach ($cart as $k=>$item)
            <tr>
              <td>{{ $item['title'] }}</td>
              <td>
                <input wire:model="cart.{{ $k }}.qty" type="text" class="form-control" wire:change="updateCart" />
              </td>
              <td>{{ $item['price'] }}</td>
              <td>{{ $item['price']*$item['qty'] }}</td>
              <td >
                  <a href="#" class="btn btn-danger" wire:click="removeToCart({{ $k }})">x</a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
         Total: {{ $cart_total }}
    @endslot
    @slot('btns')

    @endslot
  @endcomponent
