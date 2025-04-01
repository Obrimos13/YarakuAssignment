@extends('books.layout')

@section('content')

    <div class="card mt-5">
        <h2 class="card-header">Add New Book</h2>
        <div class="card-body">

            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <a class="btn btn-primary btn-sm" href="{{ route('books.index') }}"><i class="fa fa-arrow-left"></i> Back</a>
            </div>

            <form action="{{ route('books.store') }}" method="POST">
                @csrf
                @method('POST')

                <div class="mb-3">
                    <label for="inputName" class="form-label"><strong>Title:</strong></label>
                    <input
                        type="text"
                        name="title"
                        class="form-control @error('title') is-invalid @enderror"
                        id="title"
                        placeholder="Title">
                    @error('title')
                    <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="inputName" class="form-label"><strong>Author:</strong></label>
                    <input
                        type="text"
                        name="author"
                        class="form-control @error('title') is-invalid @enderror"
                        id="author"
                        placeholder="Author">
                    @error('author')
                    <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-success"><i class="fa-solid fa-floppy-disk"></i> Submit</button>
            </form>

        </div>
    </div>
@endsection
