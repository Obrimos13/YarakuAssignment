<?php

namespace App\Http\Controllers;


use App\Book;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\BookStoreRequest;
use App\Http\Requests\BookUpdateRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View;
     */
    public function index(bool $sortByTitle = true)  : View
    {
        if ($sortByTitle) {
            $books= DB::table('books')->orderBy('title')->simplePaginate(15);
        } else {
        $books= DB::table('books')->orderBy('author')->simplePaginate(15);
        }

        return view('books.index',compact('books'));
    }

    public function store(BookStoreRequest $request)  : RedirectResponse
    {
        $request->validate($request->rules());

        $book = Book::create($request->all());
        return redirect()->route('books.index')
            ->with('success', 'Book created successfully.');    }
    /**
     * Update the specified resource in storage.
     *
     * @param  BookUpdateRequest $request
     * @param  int  $id
     * @return  RedirectResponse
     */
    public function update(BookUpdateRequest $request, $id) : RedirectResponse
    {
        $request->validate($request->rules());
        $book = Book::find($id);
        $book->update($request->all());
        return redirect()->route('books.index')
            ->with('success', 'Book updated successfully.');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return RedirectResponse
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
     * @return  View
     */
    public function create() : View
    {
        return view('books.create');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return View
     */
    public function show($id) : View
    {
        $book = Book::find($id);
        return view('books.show', compact('book'));
    }
    /**
     * Show the form for editing the specified post.
     *
     * @param  int  $id
     * @return View
     */
    public function edit($id) : View
    {
        $book = Book::find($id);
        return view('books.edit', compact('book'));
    }

}
