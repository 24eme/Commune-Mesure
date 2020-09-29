<?php

namespace App;

class Place
{
    protected $storage;
    protected $coordinates = [];
    protected $cities = [];
    protected $places = [];
    protected $withPopup = false;

    public function __construct()
    {
        $this->storage = getenv('STORAGE_PATH').'places/';
    }

    public function all()
    {
        $this->build();
        return [$this->coordinates, $this->cities, $this->places];
    }

    public function getOne($place)
    {
        $json = $this->storage.$place.'.json';
        if (! file_exists($json)) {
            return false;
        }

        return $this->getJson($json);
    }

    public function getCities()
    {
        return $this->cities;
    }

    public function getPlaces()
    {
        return $this->places;
    }

    public function getCoordinates()
    {
        return $this->coordinates;
    }

    public function getCompares(){
      $compare_data = [];
      $compare_title = [
        "moyens"=>[],
        'realisations'=>[]
      ];
      foreach ($this->places[0]->data->compare as $key => $value) {
        foreach ($value as $k => $v) {
          $compare_title[$key][$k] = $v->title;
        }
      }
      foreach ($this->places as $place) {

        $compare_data[$place->name] = $place->data->compare;

      }
      $compares= [
        "data" => $compare_data,
        "titles" => $compare_title
    ];
      return $compares;
    }

    public function getResiliences(bool $sorted = true)
    {
        $resiliences = [
            'order' => [],
            'byPlace' => [],
            'places' => []
        ];

        foreach ($this->places as $place) {
            foreach ($place->data->resilience->type as $name => $resilience) {
                if (array_key_exists($name, $resiliences['order']) === false) {
                    $resiliences['order'][$name] = [];
                }

                $resiliences['order'][$name][$place->name] = $resilience->total;
                $resiliences['byPlace'][$place->name][$name] = $resilience->total;
            }

            $resiliences['places'][$place->name] = [
                'total' => $place->data->resilience->total,
                'url' => route('place.show', ['slug' => $place->title])
            ];
        }

        if ($sorted) {
            foreach ($resiliences['order'] as &$resilience) {
                arsort($resilience, SORT_NUMERIC);
            }
            unset($resilience);

            foreach ($resiliences['byPlace'] as &$resilience) {
                arsort($resilience, SORT_NUMERIC);
            }
        }

        return $resiliences;
    }

    public function withPopup()
    {
        $this->withPopup = true;
        return $this;
    }

    public function build()
    {
        // TODO: Cache into files (PSR-16)
        foreach (glob($this->storage.'*.json') as $place) {
            $json = $this->getJson($place);

            $name = basename($place, '.json');
            $title = $json->name;
            $city = $json->address->city;
            $data_chart = $json->data;
            $json->title = $name;

            if ($this->withPopup) {
                $popup = str_replace(["\r\n", "\n", '  '], '',
                    view('components/popup', ['name' => $name, 'title' => $title, 'city' => $city, 'images' => $json->photos])->render()
                );
            }

            $this->places[] = $json;
            $this->coordinates[$name] = ($this->withPopup)
                ? ['geo' => $json->geo, 'popup' => $popup]
                : ['geo' => $json->geo];
            $this->cities[$city][]= [
              "title" => $title,
            "name" => $name,"photo"=> $json->photos,
            "data_chart" => $data_chart
          ];
        }
    }

    public function sortCities()
    {
        ksort($this->cities);
        return $this;
    }

    public function sortPlacesBy(string $what = 'name')
    {
        usort($this->places, function($a, $b) use ($what) {
            if (strcasecmp($a->$what, $b->$what) === 0) {
                return 0;
            }
            return (strcasecmp($a->$what, $b->$what) < 0) ? -1 : 1;
        });
    }

    protected function getJson($place)
    {
        $json = json_decode(file_get_contents($place));

        if ($json === null) {
            throw new \LogicException("Invalid json : $place", 1);
        }

        if (property_exists($json->address, 'city') === false){
            throw new \LogicException("'La ville n'existe pas' in $place", 1);
        }

        if(property_exists($json, 'data') === false){
            throw new \LogicException("'Les données sont inexistantes.' in $place", 1);
        }

        return $json;
    }
}
