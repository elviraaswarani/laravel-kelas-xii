@extends('templates.index')

@push('style')
<link href="{{ asset('template/css/admin.css') }}" rel="stylesheet" type="text/css" media="all">
@endpush

@section('content')
<main class="admin-dashboard">
  <div class="container">
    <div class="admin-dashboard__heading">
      <div>
        <p class="admin-dashboard__eyebrow">ONE MOVIES / ADMIN</p>
        <h2>Dashboard</h2>
        <p>Selamat datang, {{ Auth::user()->name }}.</p>
      </div>
      <a class="admin-dashboard__visit" href="{{ route('home') }}">Lihat situs <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
    </div>

    <section class="admin-dashboard__metrics" aria-label="Ringkasan">
      <div class="admin-dashboard__metric">
        <span>Total film</span>
        <strong>{{ number_format($filmCount) }}</strong>
        <i class="fa fa-film" aria-hidden="true"></i>
      </div>
      <div class="admin-dashboard__metric">
        <span>Pengguna terdaftar</span>
        <strong>{{ number_format($userCount) }}</strong>
        <i class="fa fa-users" aria-hidden="true"></i>
      </div>
      <div class="admin-dashboard__metric">
        <span>Ulasan</span>
        <strong>{{ number_format($reviewCount) }}</strong>
        <i class="fa fa-comments" aria-hidden="true"></i>
      </div>
    </section>

    <section class="admin-dashboard__films">
      <div class="admin-dashboard__section-heading">
        <div>
          <p class="admin-dashboard__eyebrow">KATALOG</p>
          <h3>Film terbaru</h3>
        </div>
        <a href="{{ route('movies') }}">Buka katalog <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
      </div>

      <div class="table-responsive">
        <table class="admin-dashboard__table">
          <thead>
            <tr>
              <th scope="col">Film</th>
              <th scope="col">Tahun</th>
              <th scope="col">Genre</th>
              <th scope="col">Detail</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($recentFilms as $film)
              <tr>
                <td>
                  <div class="admin-dashboard__film">
                    <img src="{{ $film->poster_url }}" alt="Poster {{ $film->title }}" loading="lazy">
                    <span>{{ $film->title }}</span>
                  </div>
                </td>
                <td>{{ $film->year }}</td>
                <td>{{ $film->genre?->name ?? '-' }}</td>
                <td><a href="{{ route('movies.show', $film) }}" aria-label="Lihat {{ $film->title }}"><i class="fa fa-external-link" aria-hidden="true"></i></a></td>
              </tr>
            @empty
              <tr><td colspan="4" class="admin-dashboard__empty">Belum ada film di katalog.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </section>
  </div>
</main>
@endsection