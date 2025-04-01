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
    public function index($sortKey = true): View
    {
        $books = DB::table('books')->orderBy('id', 'asc')->simplePaginate(10);
        return view('books.index', compact('books'));
    }


    /**
     * Display the results of a search
     * @param Request $request
     * @param string $column
     * @return View;
     */
    public function search(Request $request, string $column = 'title'): View
    {
        $search = $request->input('search');
        $books = DB::table('books')->where("{$column}", 'like', "%{$search}%")->simplePaginate(10);
        return view('books.index', compact('books'));
    }

    public function store(BookStoreRequest $request): RedirectResponse
    {
        $request->validate($request->rules());

        $book = Book::create($request->all());
        return redirect()->route('books.index', true)
            ->with('success', 'Book created successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param BookUpdateRequest $request
     * @param int $id
     * @return  RedirectResponse
     */
    public function update(BookUpdateRequest $request, $id): RedirectResponse
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
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
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
    public function create(): View
    {
        return view('books.create');
    }

    /**
     * Show the form for editing the specified post.
     *
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $book = Book::find($id);
        return view('books.edit', compact('book'));
    }

    /**
     * Display the export view.
     * @return View
     */
    public function export(): View
    {
        return view('books.export');
    }

    public function download(Request $request)
    {


        $columns = array_filter(array(request()->input('title'), request()->input('author')), function ($value) {
            return !empty($value);
        });
        if (empty($columns)) {
            return redirect()->route('books.export')->with('error', 'Please select at least one column to export');
        }
        $books = DB::table('books')->select($columns)->get();

        if (request()->input('filetype') == 'csv') {
            // Write data to CSV
            return BookController::writeDataToCSV($books);

        } else {
            return BookController::writeDataToXML($books, $columns);

        }

    }

    /**
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function writeDataToXML($books, $columns): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        // Write data to XML
        $xw = xmlwriter_open_memory();
        xmlwriter_set_indent($xw, 1);
        $res = xmlwriter_set_indent_string($xw, ' ');

        xmlwriter_start_document($xw, '1.0', 'UTF-8');
        // A first element
        xmlwriter_start_element($xw, 'book-list');
        //book loop
        foreach ($books as $book) {
            xmlwriter_start_element($xw, 'book'); //start book
            foreach ($columns as $column) {
                xmlwriter_write_element($xw, $column, $book->$column);
            }
           xmlwriter_end_element($xw); // close book
        }
        xmlwriter_end_element($xw); //close book list
        xmlwriter_end_document($xw);
        $xml = xmlwriter_output_memory($xw, true);
        $xmlFileName = 'books.xml';
        file_put_contents($xmlFileName, $xml);
        // Download the XML file
        return \Illuminate\Support\Facades\Response::download($xmlFileName, 'exported_book_list.xml', ['Content-Type' => 'application/xml']);
    }

    /**
     * @param \Illuminate\Support\Collection $books
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function writeDataToCSV(\Illuminate\Support\Collection $books): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $csvFileName = 'books.csv';
        $csvFile = fopen($csvFileName, 'w');
        $headers = array_keys((array)$books[0]);
        fputcsv($csvFile, $headers);

        foreach ($books as $row) {
            fputcsv($csvFile, (array)$row);
        }

        fclose($csvFile);
        // Download the CSV file
        return \Illuminate\Support\Facades\Response::download($csvFileName, 'exported_book_list.csv', $headers);
    }

}


