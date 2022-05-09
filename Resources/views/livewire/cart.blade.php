{{-- <div >
  nel tuo carrello hai {{ $cart_count }} {{ $test }} 
  <button  class="btn btn-primary" data-toggle="modal" data-target="#modal_cart_list">
    Visualizza cart
  </button>
  @php
  $price_cats = xotModel('PriceCat')::ofProducts($rows)->get();
  @endphp
  <table class="table">
    <thead>
    <tr>
    <th></th>
     @foreach ($price_cats as $cat)
      <th>{{ $cat->title }}</th>
     @endforeach
    </tr>
    <thead>
    
  @foreach ($rows as $product)
  <tr>
    <td>
      {{ $product->title }}
    </td>
    @foreach ($price_cats as $cat)
    @php
      $price=$product->prices->firstWhere('cat_id',$cat->id);
    @endphp
    <td>
        @if (isset($price))
          {{ $price->price }}
          <button wire:click="showProduct({{ $product->id }}, '{{ $product->title}}' ,{{ $price->price }}, '{{ $product->post->txt }}')" class="btn btn-primary" data-toggle="modal" data-target="#modal_show_product">
            Add to cart
          </button>
        @endif
    </td>
    @endforeach
  </tr>
  @endforeach
  </table>

  @include($view.'.modal.list')

    @component('theme::components.modal.simple', ['guid' => 'modal_show_product', 'title' => 'Dettaglio prodotto', 'size' => 'lg'])
    @slot('content')
      <h3>{{ $single_product['title'] }}</h3>
      <div>{{ $single_product['txt'] }} </div>
      [{{ $single_product['id']}}, {{ $single_product['price']}}]
    @endslot
    @slot('btns')

    @endslot
  @endcomponent

</div> --}}
<div class="w-100" style="margin-bottom: 10px;margin-top: 0px; cursor: pointer;">
    <div
        wire:click="addProduct({{ XotModel('post')->where('guid', $params['item0'])->get()->first()->guid }}, clicks)">
        {{-- <a
          href="{{ route('container0.index', ['lang' => App::getLocale(), 'container0' => 'product', 'id' => XotModel('product')::find($productId)->category_id]) }}"> --}}
        <div class="w-25" style="display: inline-block;"></div>
        <div class="w-100"
            style="margin: 0 auto;display: inline-block;background: rgba(24,106,115,0.7);border-radius: 138px;height: 76px;padding-top: 5px;box-shadow: 0px 0px 3px rgb(23,105,111);">
            <h3
                style="text-align: center;color: rgb(255,255,255);padding-top: 5px;font-family: Montserrat, sans-serif;font-weight: bold;margin-top: 4px;font-size: 20px;">
                Aggiungi al carrello</h3>
            <h3 id="prezzo"
                style="text-align: center;color: rgb(255,255,255);/*padding-top: 5px;*/font-family: Montserrat, sans-serif;font-weight: bold;margin-top: 4px;font-size: 15px;">
                € {{ number_format($product['firstPrice'],2,',','') }}</h3>
        </div>
        {{-- </a> --}}
    </div>
</div>

