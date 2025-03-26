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

                <div class="mb-3">
                    <label for="inputName" class="form-label"><strong>Title:</strong></label>
                    <input
                        type="text"
                        name="title"
                        class="form-control @error('title') is-invalid @enderror"
                        id="inputName"
                        placeholder="Title">
                    @error('name')
                    <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="inputcontent" class="form-label"><strong>author:</strong></label>
                    <textarea
                        class="form-control @error('author') is-invalid @enderror"
                        style="height:150px"
                        name="author"
                        id="inputauthor"
                        placeholder="author"></textarea>
                    @error('content')
                    <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-success"><i class="fa-solid fa-floppy-disk"></i> Submit</button>
            </form>

        </div>
    </div>
@endsection
