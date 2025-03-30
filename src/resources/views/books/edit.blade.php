@extends('books.layout')

@section('content')

    <div class="card mt-5">
        <h2 class="card-header">Edit Note</h2>
        <div class="card-body">

            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <a class="btn btn-primary btn-sm" href="{{ route('books.index') }}"><i class="fa fa-arrow-left"></i> Back</a>
            </div>

            <form action="{{ route('books.update',$book->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="inputTitle" class="form-label"><strong>Title:</strong></label>
                    <input
                        type="text"
                        Title="Title"
                        value="{{ $book->title??null }}"
                        class="form-control @error('Title') is-invalid @enderror"
                        id="inputTitle"
                        placeholder="Title">
                    @error('Title')
                    <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="inputAuthor" class="form-label"><strong>Author:</strong></label>
                    <input
                        type="text"
                        Title="Author"
                        value="{{ $book->author??null }}"
                        class="form-control @error('Author') is-invalid @enderror"
                        id="inputAuthor"
                        placeholder="Author">
                    @error('Author')
                    <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-success"><i class="fa-solid fa-floppy-disk"></i> Update</button>
            </form>

        </div>
    </div>
@endsection
