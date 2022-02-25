@extends('layouts.dashboard')

@section('content')
    <section>
        <h2>Modifica post</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.blogs.update', ['blog' => $blog->id] ) }}" method="post">
            @csrf
            @method('PUT')

            <div class="mb-3">
              <label for="title" class="form-label">Title</label>
              <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $blog->title) }}">
            </div>
            <div class="mb-3">
                <label for="category_id" class="form-label">Categoria</label>
                <select class="form-select" name="category_id" id="category_id">
                    <option value="">Nessuna</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $blog->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <h4>Tags</h4>

                @foreach ($tags as $tag)
                    <div class="form-check">
                        @if ($errors->any())

                            <input {{ in_array($tag->id, old('tags', [])) ? 'checked' : '' }} class="form-check-input" type="checkbox" name="tags[]" value="{{ $tag->id }}" id="tag-{{ $tag->id }}">
                        @else
                            
                            <input {{ $blog->tags->contains($tag) ? 'checked' : '' }} class="form-check-input" type="checkbox" name="tags[]" value="{{ $tag->id }}" id="tag-{{ $tag->id }}">
                        @endif
                        
                        <label class="form-check-label" for="tag-{{ $tag->id }}">
                        {{ $tag->name }}
                        </label>
                    </div>
                @endforeach
            </div>
            <div class="mb-3">
                <label for="content" class="form-label">Content</label>
                <textarea class="form-control" name="content" id="content" cols="30" rows="10">{{ old('content', $blog->content) }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
          </form>
    </section>
@endsection