@extends('layout')

@section('title')
<h1 class="title header-title">
{{ $place->name }}
</h1>
<h2 class="subtitle">
    {{ $place->address->city }}
</h2>
@endsection

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
    @include('components.place.composition-chart')
@endsection

@section('content')
<div class="columns is-gapless" id="container">
    <div class="column is-2">
        @include('components.place.place-menu')
    </div>

    <div class="column">
        <div id="presentation" class="hero is-large anchor">
            <section>
              <h2 class="ribbon-banner is-5 has-text-centered" style="margin-top:30px;">Présentation du lieu</h2>
              <div class="section">
              <div class="columns is-vcentered is-centered">
                <div class="column" >
                  <div id="budget-value-illustration">
                    <figure class="image illustration-img">
                      <img  src="/images/bloc_note.svg" >
                    </figure>
                    <div class="content" id="description-illustration-detail">
                        <p><strong>L'idée fondatrice du lieu</strong></p>
                        <p class="description fontSize0-8em">{{ $place->description }}</p>

                    </div>
                  </div>
                </div>
                <div class="column is-two-fifth">
                  <div class="budget">
                    <figure class="image is25em" style="margin:auto;">
                      <img  src="/images/building_detail.svg" >
                    </figure>
                    <div class="very-small" id="occupant">{{ $place->manager->occupants }} structures occupantes</div>
                    <div class="very-small" id="budget-value">

                    </div>
                    <div class="very-small" id="actor">La gouvernance partagée avec {{ $place->manager->name }}</div>
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
                      <div>
                        @foreach($place->partners as $partner)
                          @if($partner->names)
                          <div>
                            <strong>Les acteurs {{ $partner->title }}s :</strong>
                            <span class="is-block fontSize0-8em">
                              {{ $partner->names }}
                            </span>
                          </div>
                          @endif
                        @endforeach
                      </div>

                      @if($place->partners[0]->names || $place->partners[1]->names)
                      <div class="">
                        <strong class="">Nature des partenariats:</strong>
                        <div class="fontSize0-8em">
                          @php ($nb = 1) @endphp
                          @foreach($place->partners as $partner)
                          <div>{{ ucfirst($partner->title) }} : <span class="font-color-theme">
                            @foreach($partner->natures as $nature)
                              {{ $nature }}
                              @if(count($partner->natures) != $nb)
                                {{ "," }}
                                @php ($nb++) @endphp
                              @endif
                            @endforeach
                            </span>
                          </div>
                          @endforeach
                        </div>
                      </div>
                      @endif
                    </div>
                  </div>
                </div>
              </div>
              <div class="has-text-centered">
                <div class="columns is-multiline fontSize0-8em" style="justify-content:center;">
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
              </div>
            </section>
            <section class="section" id="nos-valeurs">
              <h2 class="ribbon-banner title is-5 has-text-centered" >Nos valeurs</h2>

              <div class="columns">
                <div class="column">
<!--                  <div id="sigma" style="width:100%; height:30em;"></div> -->
<center>		<iframe height="300" width="500" src="/graph/examples/graph.html"></iframe></center>
              </div>
              </div>

            </section>
            <section class="section" id="finances">
              <div class="">
                  <div class="columns">
                    <div class="column has-text-centered">
                      <h2 class="ribbon-banner title is-5 has-text-centered">Le budget d'amorçage</h2>
                      <div class="section">
                      <canvas id="financement-budget-doughnut" ></canvas>
                      </div>
                    </div>
                    <div class="column has-text-centered">
                      <!-- A rendre plus comprehensible avant de reintegrer -->
                      <!-- <h2 class="ribbon-banner title is-5 has-text-centered">Le budget d'amorçage</h2>
                      <div id="financement-budget-doughnut"></div> -->
                      <h2 class="ribbon-banner title is-5 has-text-centered">La composition du lieu</h2>
                      <div class="section">
                      <canvas id="composition-chart-doughnut" ></canvas>
                      </div>
                    </div>
                  </div>
              </div>
            </section>

          </div>
        <section>
            <h2 class="ribbon-banner title is-5 has-text-centered">Impact Social</h2>
        </section>
        <section class="section anchor" id="donnees-insee">
          <h2 class="ribbon-banner title is-5 has-text-centered">Le lieu dans son territoire</h2>
          <div class="section">
            <div class="columns">
              <div class="column">
                <label class="is-pulled-right pt-4">Choississez un découpage géographique: </label>
              </div>
              <div class="column is-pulled-left">
                <div class="mb-5 control has-icons-left">
                  <div class="select">
                    <select id="selectGeo">
                      <option value="iris" selected>Quartier</option>
                      <option value="commune">Commune</option>
                      <option value="departement">Département</option>
                      <option value="region">Région</option>
                    </select>
                  </div>
                  <span class="icon is-large is-left">
                    <i class="fas fa-map"></i>
                  </span>
                </div>
              </div>
            </div>

            <div class="columns card is-rounded">
              <div class="column " style="width: 100%;height: 30em; z-index:1">
                <div id="map-insee"></div>
              </div>
              <div class="column is-7">
                <div class="columns">
                  <div class="column">
                      <div id="actifsChart" width="100" height="10"></div>
                      <div id="cateChart" width="100" height="10"></div>
                      <div id="immoChart" width="100" height="10"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
    </div>
</div>
@endsection
