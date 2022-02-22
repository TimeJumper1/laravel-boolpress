@extends('layouts.dashboard')

@section('content')
    <section>
        <h1>Lista dei post</h1>

            <div class="row row-cols-3">
                @foreach ($blogs as $blog)
                    {{-- Single post --}}
                    <div class="col">
                        <div class="card mt-2">
                            {{-- <img src="..." class="card-img-top" alt="..."> --}}
                            <div class="card-body">
                            <h5 class="card-title">{{ $blog->title }}</h5>
                            <p class="card-text">{{ Str::substr($blog->content, 0, 70) }}...</p>
                            <a href="{{ route('admin.blogs.show', ['blog' => $blog->id]) }}" class="btn btn-primary">Leggi il post</a>
                            </div>
                        </div>
                    </div>
                    {{-- End Single post --}}
                @endforeach
            </div>
    </section>
@endsection