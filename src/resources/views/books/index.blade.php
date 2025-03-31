@extends('books.layout')

@section('content')


    <div class="card mt-5">
        <h2 class="card-header">Book List</h2>
        <div class="card-body">

            @if(session('success'))
                <div class="alert alert-success" role="alert">{{ session('success') }}</div>
            @endif


                <div  class="d-grid gap-2 d-md-flex justify-content-md-left">
                    <form action="{{ route('books.search', 'title') }}" method="GET">
                        @csrf
                        @method('GET')
                        <input type="text" name="search" placeholder="Search Books">
                        <button type="submit" formaction="{{ route('books.search', 'title') }}" class="btn btn-success btn-sm"><i class="fa fa-search"></i> Search by Title</button>
                        <button type="submit" formaction="{{ route('books.search', 'author') }}"  class="btn btn-success btn-sm"><i class="fa fa-search"></i> Search by Author</button>
                    </form>

                </div>
        <br>
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <a class="btn btn-success btn-sm" href="{{ route('books.create') }}"><i class="fa fa-plus"></i> Create New Book</a>
                    <a class="btn btn-success btn-sm" href="{{ route('books.export') }}"><i class="fa fa-arrow-right"></i>Export</a>
                         </div>
            </div>

            <table class="table table-bordered table-striped mt-4">
                <thead>
                <tr>
                    <th>Title
                            <a class="btn btn-success btn-sm" href="{{ route('books.index', true) }}">Sort<i class="fa fa-sort"></i></a>
                    </th>
                    <th>Author
                        <a class="btn btn-success btn-sm" href="{{ route('books.index', false) }}">Sort<i class="fa fa-sort"></i></a>

                    </th>
                    <th width="250px">Action</th>
                </tr>
                </thead>

                <tbody>
                @forelse ($books as $book)
                    <tr>
                        <td>{{ $book->title }}</td>
                        <td>{{ $book->author }}</td>
                        <td>
                            <form action="{{ route('books.destroy',$book->id) }}" method="POST">
                                <a class="btn btn-primary btn-sm" href="{{ route('books.edit', $book->id) }}"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i> Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">There are no data.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
    {{ $books->links() }}

        </div>


@endsection
