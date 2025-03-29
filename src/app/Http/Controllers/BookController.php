<?php

namespace App\Http\Controllers;


use App\Book;
use App\Http\Controllers\Controller;
use  App\Http\Resources\BookResource;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\BookStoreRequest;
use App\Http\Requests\BookUpdateRequest;
use Illuminate\Http\Response;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()  : Response
    {
        $books = Book::all();

        return view('books.index', compact('books'));
    }

    public function store(BookStoreRequest $request)  : RedirectResponse
    {
        $request->validate([
            'title' => 'required|max:255',
            'body' => 'required',
        ]);
        Book::create($request->all());
        return redirect()->route('books.index')
            ->with('success', 'Book created successfully.');
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BookStoreRequest $request, $id) : RedirectResponse
    {
        $request->validate([
            'title' => 'required|max:255',
            'author' => 'required|max:255',
        ]);
        $book = Book::find($id);
        $book->update($request->all());
        return redirect()->route('books.index')
            ->with('success', 'Book updated successfully.');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) : RedirectResponse
    {
        $book = Book::find($id);
        $book->delete();
        return redirect()->route('books.index')
            ->with('success', 'Book deleted successfully');
    }
    // routes functions
    /**
     * Show the form for creating a new post.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() : Response
    {
        return view('books.create');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) : Response
    {
        $book = Book::find($id);
        return view('books.show', compact('book'));
    }
    /**
     * Show the form for editing the specified post.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) : Response
    {
        $book = Book::find($id);
        return view('books.edit', compact('book'));
    }

}
