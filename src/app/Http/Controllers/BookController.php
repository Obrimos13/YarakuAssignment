<?php

namespace App\Http\Controllers;


use App\Book;
use App\Http\Controllers\Controller;
use http\Client\Response;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\BookStoreRequest;
use App\Http\Requests\BookUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class BookController extends Controller
{

    private $sortKey = 'id';
    /**
     * Display a listing of the resource.
     *
     * @return View;
     */
    public function index($sortKey = true)  : View
    {
       $books = DB::table('books')->orderBy("{$sortKey}", 'asc')->simplePaginate(10);
        return view('books.index',compact('books'));
    }


    /**
     * Display the results of a search
     * @param Request $request
     * @param string $column
     * @return View;
     */
    public function search(Request $request, string $column='title'): View
    {
        $search = $request->input('search');
        $books = DB::table('books')->where("{$column}", 'like', "%{$search}%")->simplePaginate(10);
        return view('books.index', compact('books'));
    }

    public function store(BookStoreRequest $request)  : RedirectResponse
    {
        $request->validate($request->rules());

        $book = Book::create($request->all());
        return redirect()->route('books.index', true)
            ->with('success', 'Book created successfully.');
    }
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
        $book = Book::query()->find($id);
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
    public function destroy(int $id) : RedirectResponse
    {
        $book = Book::find($id);
        $book->delete();
        return redirect()->route('books.index', true)
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
     * Show the form for editing the specified post.
     *
     * @param  int  $id
     * @return View
     */
    public function edit(int $id) : View
    {
        $book = Book::find($id);
        return view('books.edit', compact('book'));
    }

    /**
     * Display the export view.
     * @return View
     */
    public function export() : View {
        return view('books.export');
    }

    public function download(Request $request) : \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $books = DB::table('books')->get();

        // Write data to CSV
        $csvFileName = 'books.csv';
        $csvFile = fopen($csvFileName, 'w');
        $headers = array_keys((array) $books[0]); // Get the column headers from the first row
        fputcsv($csvFile, $headers);

        foreach ($books as $row) {
            fputcsv($csvFile, (array) $row);
        }

        fclose($csvFile);

// Download the CSV file
        return \Illuminate\Support\Facades\Response::download($csvFileName, 'exported_book_list.csv', $headers);

    }

}
