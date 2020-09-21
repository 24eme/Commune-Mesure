@extends('layout')

@section('head_css')
    @parent
@endsection

@section('script_js')
    @parent
    <script src="https://unpkg.com/rough-viz@1.0.5"></script>
    <script src='https://d3js.org/d3.v4.min.js'></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/d3-cloud/1.2.5/d3.layout.cloud.js" integrity="sha512-UWEnsxiF3PBLuxBEFjpFEHQGZNLwWFqztm66Wok/kXsGSrcOS76CP3ovpEQmwlOmR2Co4iV5FmXrdb7YzP37SA==" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sigma@1.2.1/plugins/sigma.layout.forceAtlas2/supervisor.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sigma@1.2.1/plugins/sigma.layout.forceAtlas2/worker.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sigma@1.2.1/src/renderers/canvas/sigma.canvas.edges.curvedArrow.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sigma@1.2.1/src/renderers/canvas/sigma.canvas.extremities.def.js"></script>
    @include('components.place.chart-place')
    @include('components.place.map-insee-js')
    @include('components.place.sigma-cloud-words-js')
    @include('components.place.d3-cloud-words-js')
    @include('components.place.d3-doughnut-finance-js')
    @include('components.place.insee-chart-js')
    @include('components.place.composition-doughnut-js')
    @include('components.place.amcharts-forced-directed-tree')
@endsection

@section('content')
<div class="columns is-gapless" id="container">
    <div class="column is-2">
        @include('components.place.place-menu')
        {{-- @include('components.place.info-box') --}}
    </div>

    <div class="column">
        <div id="presentation" class="hero is-large anchor">
            <section class="section">
                <h1 class="title is-1 has-text-centered">{{ $place->name }}</h1>
                <div class="has-text-centered"><span class="has-text-grey-light">Tags :
                    @foreach ($place->tags as $tag)
                        <a class="tag tag-css" href="/tag/{{ $tag }}" title="{{ $tag }}">{{ $tag }}</a>
                    @endforeach
                </span></div>
                <div class="has-text-centered">
                  <a class="tag" href="//example.com">Découvrir plus</a>
                </div>
            </section>

            <section>
              <h5 class="ribbon-banner is-5 has-text-centered">Modèle économique</h5>
              <div class="has-text-centered">
                <strong>Nature des partenariats:</strong>
                <ul class="fonfSize0-8em">
                  @foreach($place->partners as $partner)
                  <li>{{ ucfirst($partner->title) }} : <span class="font-color-theme">
                    @foreach($partner->natures as $nature)
                      {{ $nature }}
                      @if(count($partner->natures) > 1)
                        {{ "," }}
                      @endif
                    @endforeach
                  </span></li>
                  @endforeach
                </ul>
              </div>
              <div class="columns is-vcentered is-centered">
                <div class="column" >
                  <div id="budget-value-illustration">
                    <figure class="image illustration-img">
                      <img  src="/images/bloc_note.svg" >
                    </figure>
                    <div class="content" id="description-illustration-detail">
                        <p><strong>{{ $place->name }} c'est quoi ?</strong></p>
                        <p class="description fonfSize0-8em">{{ $place->description }}</p>

                    </div>
                  </div>
                </div>
                <div class="column is-two-fifth">
                  <div class="budget">
                    <figure class="image is25em" style="margin:auto;">
                      <img  src="/images/building_detail.svg" >
                    </figure>
                    <div class="very-small" id="occupant">{{ "150" }} occupants</div>
                    <div class="very-small" id="budget-value">

                    </div>
                    <div class="very-small" id="actor">Gouvernance partagée</div>
                  </div>
                  <div class="has-text-centered">
                    <p class="mb-3 mt-5">
                      <strong>Les differents publics : </strong>
                      <span class="font-color-theme">Tout le monde</span>
                    </p>
                  </div>

                </div>
                <div class="column">
                  <div id="actor-illustration">
                    <figure class="image illustration-img">
                      <img  src="/images/bloc_note.svg" >
                    </figure>
                    <div class="actor content" id="actor-illustration-detail">
                      <ul>
                        @foreach($place->partners as $partner)
                          <li>
                            <strong>Les acteurs {{ $partner->title }}s :</strong>
                            <span class="is-block fonfSize0-8em">
                              {{ $partner->names }}
                            </span>
                          </li>
                        @endforeach


                      <ul>
                    </div>
                  </div>
                </div>
              </div>
              <div class="has-text-centered">
                <div class="columns is-multiline fonfSize0-8em" style="justify-content:center;">
                  <span class="is-block ml-3"><i class="fa fa-wheelchair font-color-theme mr-1"></i>Handicapés</span>
                  <span class="is-block ml-3"><i class="fa fa-child font-color-theme mr-1"></i>Enfants</span>
                  <span class="is-inline-block ml-3"><i class="fa fa-user-graduate font-color-theme mr-1"></i>Étudiants</span>
                  <span class="is-block ml-3"><i class="fa fa-blind font-color-theme mr-1"></i>Parsonnes</span>
                  <span class="is-block ml-3"><i class="fa fa-users font-color-theme mr-1"></i>Famille</span>
                  <span class="is-block ml-3"><i class="fa fa-user-tie font-color-theme mr-1"></i>Personnes visants le site</span>
                  <span class="is-block ml-3"><i class="fa fa-person-booth font-color-theme mr-1"></i>Personnes habitant sur le site</span>
                  <span class="is-block ml-3"><i class="fa fa-user-tag font-color-theme mr-1"></i>Personnes visants le site</span>
                </div>
                <p>
                  <strong>Ouverture:</strong>
                  <span class="font-color-theme">En permanence</span>
                </p>
              </div>
            </section>
            <div class="slide" id="slideValeurs">
            <div class="section" id="nos-valeurs">
              <h2 class="title is has-text-centered" >Nos valeurs </h2>
              <div class="columns" id="slide">
                <div class="column">
                  <div id="sigma" style="width:100%; height:30em;"></div>
              </div>
            </div>
            </div>
            <div class="slide" id="slideValeurs2" style="display:none;">
              <div class="section" id="nos-valeurs">
                <h2 class="ribbon-banner is has-text-centered" >Nos valeurs </h2>
                <div class="" id="slide">
                  <div class="column">
                    <div id="theme-container">

                    </div>
                    <!-- <div id="caption"></div>
                    <div id="container"></div> -->
                    <div id="chartdiv"></div>
                  </div>
                </div>
              </div>
            </div>
            <section class="section" id="finances">
              <div class="">
                  <h5 class="title is-5 has-text-centered">Les financements</h5>
                  <div class="columns">
                    <div class="column has-text-centered">
                      <h5 class="title is-5 has-text-centered">Le budget</h5>
                      <div id="financement-budget-doughnut"></div>
                    </div>
                    <div class="column has-text-centered">
                      <h5 class="title is-5 has-text-centered">Les fonds</h5>
                      <div id="financement-doughnut"></div>
                    </div>
                  </div>
              </div>
            </section>

            <section class="section">
                <h5 class="title is-5 has-text-centered">Badges</h5>
                <div class="columns is-centered">
                    <div class="tags are-large">
                        @foreach ($place->structure->theme as $badge)
                            {{-- <div class="column is-narrow"> --}}
                            {{--     <figure class="image is-128x128"> --}}
                            {{--         <img class="is-rounded" src="https://dummyimage.com/128x128/000/fff" alt="images/badges/{{ $badge }}.png" /> --}}
                            {{--     </figure> --}}
                            {{-- </div> --}}
                            <span class="tag is-primary">{{ $badge->text }}</span>
                        @endforeach
                    </div>
                </div>
              </section>
            </section>
          </div>

            <section class="section has-text-centered " id="composition-lieu">
              <h5 class="title is-5 has-text-centered ">La composition du lieu</h5>
                <section class="section">
                  <div class="has-text-centered">


                    <div class="" >
                      @php ($quantity = $place->data->composition->{1}->nombre/$place->data->composition->{0}->nombre) @endphp

                      <div class="Progress-item is-inline-block"
                      style="width:{{ $quantity*28 }}em; background-color:{{ $place->data->composition->{1}->color }}; border-radius: 1em 0 0 1em;"
                      data-tooltip="{{ $place->data->composition->{1}->title }} : {{ number_format(number_format($quantity,1)*100, 2) }}%"></div>
                      @php ($quantity = $place->data->composition->{2}->nombre/$place->data->composition->{0}->nombre) @endphp

                      <div class="Progress-item is-inline-block"
                      style="width:{{ $quantity*28 }}em; background-color:{{ $place->data->composition->{2}->color }};"
                      data-tooltip="{{ $place->data->composition->{2}->title }} : {{ number_format(number_format($quantity,1)*100, 2) }}%"></div>
                      @php ($quantity = $place->data->composition->{3}->nombre/$place->data->composition->{0}->nombre) @endphp

                      <div class="Progress-item is-inline-block"
                      style="width:{{ $quantity*28 }}em; background-color:{{ $place->data->composition->{3}->color }};"
                      data-tooltip="{{ $place->data->composition->{3}->title }} :{{ number_format(number_format($quantity,1)*100, 2) }}%"></div>
                      @php ($quantity = $place->data->composition->{4}->nombre/$place->data->composition->{0}->nombre) @endphp

                      <div class="Progress-item is-inline-block"
                      style="width:{{ $quantity*28 }}em; background-color:{{ $place->data->composition->{4}->color }}; border-radius: 0 1em 1em 0;"
                      data-tooltip="{{ $place->data->composition->{4}->title }} :{{ number_format(number_format($quantity,1)*100, 2) }}%"></div>
                    </div>

                    <div class="mt-6">
                      <div class="is-inline-block mr-3">
                        <div class="is-circle is-inline-block" style="width: 1em; height:1em; background-color:{{ $place->data->composition->{1}->color }};"></div>
                        <p class="is-inline-block">{{ $place->data->composition->{1}->title }}</p>
                      </div>
                      <div class="is-inline-block mr-3">
                        <div class="is-circle is-inline-block" style="width: 1em; height:1em; background-color:{{ $place->data->composition->{2}->color }};"></div>
                        <p class="is-inline-block">{{ $place->data->composition->{2}->title }}</p>
                      </div>
                      <div class="is-inline-block mr-3">
                        <div class="is-circle is-inline-block" style="width: 1em; height:1em; background-color:{{ $place->data->composition->{3}->color }};"></div>
                        <p class="is-inline-block">{{ $place->data->composition->{3}->title }}</p>
                      </div>
                      <div class="is-inline-block">
                        <div class="is-circle is-inline-block" style="width: 1em; height:1em; background-color:{{ $place->data->composition->{4}->color }};"></div>
                        <p class="is-inline-block">{{ $place->data->composition->{4}->title }}</p>
                      </div>
                    </div>
                  </div>
              </section>
            </section>
          </div>
          <div class="slide" id="slideFinanceCompo2" style="display:none;">
            <div class="columns">
              <div class="column">
                <section class="section has-text-centered" id="finances">
                  <h5 class="title is-5 has-text-centered">Répartition du financement</h5>
                  <section class="section">
                    <div class="has-text-centered">
                      <div id="financement-doughnut2"></div>
                    </div>
                  </section>
                </section>
              </div>
              <div class="column">
                <section class="section has-text-centered" id="finances">
                  <h5 class="title is-5 has-text-centered">La composition du lieu</h5>
                  <section class="section">
                    <div class="has-text-centered">
                      <canvas id="composition-doughnut" width="100" height="100"></canvas>
                    </div>
                  </section>
                </section>
              </div>
            </div>
          </div>
          <div class="" style="text-align:center;">
            <span class="line-slide" onclick="slideFinanceCompo(1)"></span>
            <span class="line-slide" onclick="slideFinanceCompo(2)"></span>
          </div>



        <section class="section anchor" id="donnees-insee">
          <h3 class="title is-3 has-text-centered">Les données INSEE</h3>
          <div class="section">
            <div class="mb-5 has-text-centered">
              <label>Choississez un découpage géographique: </label>
              <div class="select">
                <select id="selectGeo">
                  <option value="region">Région</option>
                  <option value="departement">Département</option>
                  <option value="commune">Commune</option>
                  <option value="iris" selected="selected">Iris</option>
                </select>
              </div>
            </div>
            <div class="columns card is-rounded">
              <div class="column " style="width: 100%;height: auto; z-index:1">
                <div id="map-insee"></div>
              </div>
              <div class="column is-7">
                <div class="columns">
                  <div class="column">

                    <!-- <div class="mt-2">
                      <h4>Actifs</h4>
                      <div class="" style="width:100%">
                        <div class="actifBar myBar is-inline-block" style="background-color:#f07d60;border-radius: 1em 0 0 1em;"></div><div class="actifBar myBar is-inline-block"
                         style="background-color:#F05F3B; border-radius:0;">
                        </div><div class="actifBar myBar is-inline-block"
                        style="background-color:#A5C5C3;border-radius:0;"></div><div class="actifBar myBar is-inline-block"
                        style="background-color:#429F9E;border-radius:0;"></div><div class="actifBar myBar is-inline-block"
                        style="background-color:#007872; border-radius: 0 1em 1em 0;"></div>
                      </div>
                      <div class="mt-2" >
                        <div class="caption-block is-inline-block">
                          <div class="actifCaption is-circle is-inline-block" style="width: 1em; height:1em;"></div>
                          <p class="actifTitle is-inline-block"></p>
                        </div>
                        <div class="caption-block is-inline-block">
                          <div class="actifCaption is-circle is-inline-block" style="width: 1em; height:1em;"></div>
                          <p class="actifTitle is-inline-block"></p>
                        </div>
                        <div class="caption-block is-inline-block">
                          <div class="actifCaption is-circle is-inline-block" style="width: 1em; height:1em;"></div>
                          <p class="actifTitle is-inline-block"></p>
                        </div>
                        <div class="caption-block is-inline-block">
                          <div class="actifCaption is-circle is-inline-block" style="width: 1em; height:1em;"></div>
                          <p class="actifTitle is-inline-block"></p>
                        </div>
                        <div class="caption-block is-inline-block">
                          <div class="actifCaption is-circle is-inline-block" style="width: 1em; height:1em;"></div>
                          <p class="actifTitle is-inline-block"></p>
                        </div>
                      </div>
                    </div>
                    <div class="mt-2" >
                      <h4 >Catégories socioprofessionnelles</h4>
                      <div class="" style="width:100%;">
                        <div class="cspBar myBar is-inline-block"
                        style="background-color: #bf607e; border-radius: 1em 0 0 1em;"></div><div class="cspBar myBar is-inline-block"
                        style="background-color:#ca4a3d;border-radius:0;"></div><div class="cspBar myBar is-inline-block"
                        style="background-color:#e3a7a1;border-radius:0;"></div><div class="cspBar myBar is-inline-block"
                        style="background-color:#fcd2bb;border-radius:0;"></div><div class="cspBar myBar is-inline-block"
                        style="background-color:#c7dfec;color: black; border-radius:0;"></div><div class="cspBar myBar is-inline-block"
                        style="background-color:#81b8d6;border-radius:0;"></div><div class="cspBar myBar is-inline-block"
                        style="background-color:#3680b6;border-radius:0;"></div><div class="cspBar myBar is-inline-block"
                        style="background-color:#1b519c;border-radius: 0 1em 1em 0;"></div>
                      </div>
                      <div class="mt-2">
                        <div class="caption-block is-inline-block">
                          <div class="cspCaption is-circle is-inline-block" style="width: 1em; height:1em;"></div>
                          <p class="cspTitle is-inline-block"></p>
                        </div>
                        <div class="caption-block is-inline-block">
                          <div class="cspCaption is-circle is-inline-block" style="width: 1em; height:1em;"></div>
                          <p class="cspTitle is-inline-block"></p>
                        </div>
                        <div class="caption-block is-inline-block">
                          <div class="cspCaption is-circle is-inline-block" style="width: 1em; height:1em;"></div>
                          <p class="cspTitle is-inline-block"></p>
                        </div>
                        <div class="caption-block is-inline-block">
                          <div class="cspCaption is-circle is-inline-block" style="width: 1em; height:1em;"></div>
                          <p class="cspTitle is-inline-block"></p>
                        </div>
                        <div class="caption-block is-inline-block">
                          <div class="cspCaption is-circle is-inline-block" style="width: 1em; height:1em;"></div>
                          <p class="cspTitle is-inline-block"></p>
                        </div>
                        <div class="caption-block is-inline-block">
                          <div class="cspCaption is-circle is-inline-block" style="width: 1em; height:1em;"></div>
                          <p class="cspTitle is-inline-block"></p>
                        </div>
                        <div class="caption-block is-inline-block">
                          <div class="cspCaption is-circle is-inline-block" style="width: 1em; height:1em;"></div>
                          <p class="cspTitle is-inline-block"></p>
                        </div>
                        <div class="caption-block is-inline-block">
                          <div class="cspCaption is-circle is-inline-block" style="width: 1em; height:1em;"></div>
                          <p class="cspTitle is-inline-block"></p>
                        </div>
                      </div>
                    </div>
                    <div class="mt-2">
                      <h4 >Immobiliers</h4>
                      <div class="" style="width:100%;">
                        <div class="logementBar myBar is-inline-block"
                        style="background-color:#E1E1E1;border-radius: 1em 0 0 1em;"></div><div class="logementBar myBar is-inline-block"
                        style="background-color:#456EB8;border-radius:0;">
                        </div><div class="logementBar myBar is-inline-block"
                        style="background-color:#F3771B;border-radius: 0 1em 1em 0;"></div>
                      </div>
                      <div class="">
                        <div class="caption-block is-inline-block">
                          <div class="logementCaption is-circle is-inline-block" style="width: 1em; height:1em;"></div>
                          <p class="logementTitle is-inline-block"></p>
                        </div>
                        <div class="caption-block is-inline-block">
                          <div class="logementCaption is-circle is-inline-block" style="width: 1em; height:1em;"></div>
                          <p class="logementTitle is-inline-block"></p>
                        </div>
                        <div class="caption-block is-inline-block">
                          <div class="logementCaption is-circle is-inline-block" style="width: 1em; height:1em;"></div>
                          <p class="logementTitle is-inline-block"></p>
                        </div>
                      </div>
                    </div> -->
                    <div id="actifsChart" width="100" height="10"></div>
                    <div id="cateChart" width="100" height="10"></div>
                    <div id="immoChart" width="100" height="10"></div>
                    <input type="checkbox" id="legendCheckbox" name="" value="" onclick="openLegend()" style="margin-right:10px" >Légende

                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
        <section class="section">

            <h5 class="ribbon-banner is-5 has-text-centered">Impact Social</h5>
            <div class="columns is-centered">
                <div class="tags are-large">
                </div>
            </div>
        </section>
        <section class="section">
            <h5 class="title is-5 has-text-centered">Badges</h5>
            <div class="columns is-centered">
                <div class="tags are-large">
                    @foreach ($place->structure->theme as $badge)
                        {{-- <div class="column is-narrow"> --}}
                        {{--     <figure class="image is-128x128"> --}}
                        {{--         <img class="is-rounded" src="https://dummyimage.com/128x128/000/fff" alt="images/badges/{{ $badge }}.png" /> --}}
                        {{--     </figure> --}}
                        {{-- </div> --}}
                        <span class="tag is-primary">{{ $badge->text }}</span>
                    @endforeach
                </div>
            </div>
        </section>
    </div>
</div>
@endsection
