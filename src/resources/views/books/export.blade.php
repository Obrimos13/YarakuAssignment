@extends('books.layout')

@section('content')


    <div class="card mt-5">

        @if(session('success'))
            <div class="alert alert-success" role="alert">{{ session('success') }}</div>
        @endif
        @if(session('error'))
                <div class="alert alert-error" role="alert">{{ session('error') }}</div>
            @endif
        <div class="card-body">

               <div class="d-grid gap-2 d-md-flex justify-content-md-left">
                    <div>
                    <a class="btn btn-primary btn-sm" href="{{ route('books.index') }}"><i class="fa fa-arrow-left"></i> Back</a>
                    </div>
                    <div>
                    <form action="{{ route('books.download') }}" method="GET" enctype="multipart/form-data">
                        @csrf
                        @method('GET')
                        <input type="checkbox" id="title" name="title" value="title" checked>
                        <label for="title">Include Title</label><br>
                        <input type="checkbox" id="author" name="author" value="author">
                        <label for="author">Include Author</label><br>
                        <label for="filetype">Export as:</label>
                        <select name="filetype" id="filetype">
                            <option value="csv">csv</option>
                            <option value="xml">xml</option>
                        </select>
                        <button type="submit"  class="btn btn-success btn-sm"><i class="fa fa-search"></i> Download </button>

                    </form>
                </div>
                </div>





            <br>

        </div>
    </div>
