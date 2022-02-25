@extends('layouts.dashboard')

@section('content')
    <section>
        <h1>{{ $blog->title }}</h1>

        <div class="mb-2"><strong>Slug:</strong> {{ $blog->slug }}</div>

        <div class="mb-2"><strong>Categoria:</strong> {{ $blog->category ? $blog->category->name : 'nessuna' }}</div>

        <div class="mb-2"><strong>Tags:</strong>
            @forelse ($blog->tags as $tag)
                {{ $tag->name }}{{ $loop->last ? '' : ', ' }}
            @empty
                nessuno
            @endforelse
        </div>

        <p>{{ $blog->content }}</p>

        <div>
            <a href="{{ route('admin.blogs.edit', ['blog' => $blog->id]) }}">Modifica post</a>
        </div>

        <div>
            <form action="{{ route('admin.blogs.destroy', ['blog' => $blog->id]) }}" method="post">
                @csrf
                @method('DELETE')

                <button class="btn btn-danger" onclick="return confirm('Sei sicuro di voler cancellare?')">Cancella</button>
            </form>
        </div>
    </section>
@endsection