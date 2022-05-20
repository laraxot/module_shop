 <div>
     <button type="submit" class="btn btn-success" wire:click="showCategories(locality)">Cerca</button>

     @if ($show_categories)

         <h3>prese le categorie</h3>
         <h4>La città è {{ $locality }}</h4>

     @endif

    
 </div>
