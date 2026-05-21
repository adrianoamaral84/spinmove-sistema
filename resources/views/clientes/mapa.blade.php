@extends('adminlte::page')

@section('title', 'Mapa de Clientes')

@section('content_header')

<h1>

    Mapa de Clientes

</h1>

@stop

@section('content')

<div class="card">

    <div class="card-body">

        <div id="map"
             style="height:700px; border-radius:10px;">

        </div>

    </div>

</div>

@stop

@section('js')

<script>

function initMap() {

    const map = new google.maps.Map(
        document.getElementById("map"),
        {

            zoom: 11,

            center: {

                lat: -25.4284,
                lng: -49.2733

            }

        }
    );

    @foreach($clientes as $cliente)

        const marker{{ $cliente->id }} =
            new google.maps.Marker({

                position: {

                    lat: {{ $cliente->latitude }},
                    lng: {{ $cliente->longitude }}

                },

                map: map,

                title: "{{ $cliente->nome }}"

            });

        const info{{ $cliente->id }} =
            new google.maps.InfoWindow({

                content: `

                    <div style="min-width:220px">

                        <h5>

                            {{ $cliente->nome }}

                        </h5>

                        <p>

                            📞 {{ $cliente->telefone }}

                        </p>

                        <p>

                            📍 {{ $cliente->bairro }}

                        </p>

                    </div>

                `

            });

        marker{{ $cliente->id }}
            .addListener('click', function () {

                info{{ $cliente->id }}
                    .open(map, marker{{ $cliente->id }});

            });

    @endforeach

}

</script>

<script async
src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initMap">

</script>

@stop