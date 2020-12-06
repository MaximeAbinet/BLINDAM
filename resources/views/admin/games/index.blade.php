@extends('layouts.admin')

@section('content')

<header class="masthead bg-primary text-white text-center">
    <div class="container d-flex align-items-center flex-column">

      <!-- Masthead Heading -->
      <h1 class="masthead-heading text-uppercase mb-0">Parties</h1>
      <p class="masthead-subheading font-weight-light mb-0">{{ $games->total() }} Parties</p>

    </div>
</header>

<section class="page-section portfolio" id="portfolio">

  <div class="container-fluid">

    <div class="row m-2">

      <div class="col">
            <form method="GET" action="{{ route('admin.games.index') }}">
                <div class="input-group mb-3">
                  <input type="text" class="form-control" value="{{ $search }}" placeholder="Rechercher..." name="search">
                  <div class="input-group-append">
                    <a class="btn btn-secondary" href="{{ route('admin.games.index') }}"><i class="fas fa-times"></i></a>
                    <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                  </div>
                </div>
            </form>
      </div>

      <div class="col">
        {{ $games->links() }}
      </div>

    </div>

    <table class="table table-striped">

      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Titre</th>
          <th scope="col">Publique</th>
          <th scope="col">Tracks</th>
          <th scope="col">Hit</th>
        </tr>
      </thead>

      <tbody>

        @foreach ($games as $game)
          <tr>
            <th scope="row">{{ $game->id }}</th>
            <td><a href="{{ route('admin.games.edit', $game->id) }}">{{ $game->title }}</a></td>
            <td>@if($game->public)<div class="badge badge-info">Publique</div>@else<div class="badge badge-danger">Privée ({{ $game->user->name }})</div>@endif</td>
            <td>{{ $game->tracks->count() }}</td>
            <td>{{ $game->hit }}</td>
          </tr>        
        @endforeach

      </tbody>

    </table>

  </div>


</section>


@endsection