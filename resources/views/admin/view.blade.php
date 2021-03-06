@extends('layout')

@section('content')
    <div class="container">
        <div class="hero is-large">
            <section class="section">
                <h1 class="title is-1 has-text-centered">Administration de lieux</h1>
            </section>
        </div>
        <div class="section">
            <div>
              <button class="button is-success is-pulled-right" title="Télécharger le csv global">
                <a style='color: white' href="{{ route('admin.globalCsv') }}">
                  <span class="icon is-small">
                      <i class="fas fa-file-csv"></i>
                  </span>
                </a>
              </button>
            </div>
            <table class="table is-fullwidth">
                <thead>
                    <tr>
                        <th>Status</th>
                        <th>Nom</th>
                        <th>Page d'administration</th>
                        <th>Administrer</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($list as $place)
                    <tr>
                      <td>
                        <a style='color: black' href="{{ route('admin.publish', ['slug' => $place->getSlug(), 'auth' => $auths[$place->getSlug()]]) }}"
                        @if($place->get('publish'))
                          title="Publier"> <i class="fa fa-eye" style='color:#4CAF50'></i>
                        @else
                          title="Dé-publier"><i class="fas fa-eye-slash" style='color:#e85048'></i>
                        @endif
                        </a>
                      </td>
                        <td>
                            <p class="has-text-weight-bold"><a href="{{ route('place.show', ['slug' => $place->getSlug()]) }}">{{ $place->get('name') }}</a></p>
                            <p class="has-text-grey-dark is-size-7">{{ $place->get('address->city') }} ({{ substr($place->get('address->postalcode'), 0, 2) }})</p>
                        </td>
                        <td>
                          <div class="field has-addons">
                            <p class="control is-expanded">
                              <input class="input is-family-code" id="input-{{ $place->getSlug() }}" readonly type="text" value="{{ route('place.edit', ['slug' => $place->getSlug(), 'auth' => $auths[$place->getSlug()]]) }}">
                            </p>
                            <p class="control">
                              <a class="button button-clipboard" data-input="input-{{ $place->getSlug() }}"><i class="fa fa-clipboard"></i></a>
                            </p>
                          </div>
                        </td>

                        <td>
                          <button class="button" title="Administrer le lieu ">
                            <a target="_blank" href="{{ route('place.edit', ['slug' => $place->getSlug(), 'auth' => $auths[$place->getSlug()]]) }}">
                                <span class="icon is-small">
                                    <i class="fas fa-external-link-alt"></i>
                                </span>
                              </a>
                          </button>
                        </td>
                        <td>
                            <button class="button is-success" title="Télécharger le csv">
                              <a style='color: white' href="{{ route('place.csv', ['slug' => $place->getSlug(), 'auth' => $auths[$place->getSlug()]]) }}">
                                <span class="icon is-small">
                                    <i class="fas fa-download"></i>
                                </span>
                              </a>
                            </button>
                            <button class="button is-warning" disabled title="Renouveller la clé secrète">
                                <span class="icon is-small">
                                    <i class="fas fa-redo"></i>
                                </span>
                            </button>
                            <button class="button is-danger is-outlined" disabled title="Suppression du lieu">
                                <span class="icon is-small">
                                    <i class="fas fa-times"></i>
                                </span>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>


    </div>

@endsection

@section('script_js')
  <script>
    document.addEventListener('click', function(e) {
      for (var target = e.target; target && target != this; target = target.parentNode) {
        if (target.matches('.button-clipboard')) {
          copypaste(target);
          break;
        }
      }
    }, false);

    function copypaste(target) {
      let input_id = target.dataset.input
      let input = document.getElementById(input_id)

      input.focus()
      input.select()
      navigator.clipboard.writeText(input.value)

      changeIcon(target, 'fa-check')
      window.setTimeout(function() {changeIcon(target, 'fa-clipboard')}, 15*1000)
    }

    function changeIcon(target, icon) {
      target.firstElementChild.classList.remove('fa-check', 'fa-clipboard')
      target.firstElementChild.classList.add(icon)
    }
  </script>
@endsection
