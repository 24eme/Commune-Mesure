<div class="bloc-note">
  <div class="header-bloc-note">
    <figure class="image">
      <img src="/images/bloc_noteAsset.png">
    </figure>
  </div>
  <div class="bloc-note-body">
    <div class="content">
      @foreach($place->partners->value as $key => $partner)
        @if($partner->names)
          <div>
            <strong>Les acteurs {{ $partner->title }}s : </strong>
            <span class="is-block is-size-7">
              {{ $partner->names }}
              @include('components.modals.modalEdition',['chemin'=>'partners->value['.$key.']->names'])
            </span>
          </div>
        @endif
      @endforeach
      @if($place->partners->value[0]->names || $place->partners->value[1]->names)
        <div class="">
          <strong class="">Nature des partenariats :</strong>
          <div class="is-size-7">
            @foreach($place->partners->value as $key => $partner)
              @if (count($partner->natures))
                <div>{{ ucfirst($partner->title) }} : <span class="font-color-theme">
                    @foreach($partner->natures as $nature)
                      {{ $nature }}@if(! $loop->last), @endif
                    @endforeach
                  </span>
                  @include('components.modals.modalEdition',['chemin'=> 'partners->value[0]->natures'])
                </div>
                @elseif(isset($edit) && $edit)
                  <div>
                    {{ ucfirst($partner->title) }} : @include('components.modals.modalEdition',['chemin'=> 'partners->value['.$key.']->natures'])
                  </div>
                @endif
              @endforeach
          </div>
        </div>
      @endif
    </div>
  </div>
</div>
