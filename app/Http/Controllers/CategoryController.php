<?php

namespace App\Http\Controllers;

use App\Item;
use App\Models\Category;
use App\Models\Test;
use App\Models\TestCategory;
use App\Models\Question;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use DB;


class CategoryController extends Controller
{
    public function index()
    {
        if (Auth::user() == null || !Auth::user()->hasRole('assistant')) {
            return redirect()->route('home');
        }
        $categories = Category::all();
        foreach ($categories as $category) {

            if ($category->name == "") {
                $category->delete();
                continue;
            }
            $number_of_questions = 0;

            $category->setAttribute('number_of_questions', $number_of_questions);

            $questions = $category->questions;

            foreach ($questions as $q) {
                $number_of_questions += 1;
            }

            $category->setAttribute('number_of_questions', $number_of_questions);


        }
        return view('categories.index', compact('categories'));
    }

    public function show(Category $category)
    {
        if (Auth::user() == null || !Auth::user()->hasRole('assistant')) {
            return redirect()->route('home');
        }

        $questions = Question::all()->whereIn('category_id',$category->id);
        return view('categories.show', compact('category', 'questions'));
    }

    public function create()
    {
        if (Auth::user() == null || !Auth::user()->hasRole('profesor')) {
            return redirect()->route('home');
        }

        return view('categories.create');
    }

    public function edit(Category $category)
    {
        if (Auth::user() == null || !Auth::user()->hasRole('profesor')) {
            return redirect()->route('home');
        }
        $questions = $category->questions;

        return view('categories.edit', compact('category', 'questions'));
    }

    public function store(Request $request)
    {
        if (Auth::user() == null || !Auth::user()->hasRole('profesor')) {
            return redirect()->route('home');
        }
        $this->validate(
            $request,
            [
                'name' => 'required|unique:categories|max:128',
                'max_points' => 'required|gte:0.001|lte:100'
            ],
        );

        $category = new Category();


        $category->name = $request->name;
        $category->max_points = $request->max_points;

        $category->save();

        Session::flash('message', 'Category created successfully');
        return redirect()->route('categories.edit', $category->id);
    }


    public function search(Request $request)
    {
        if($request->ajax())
        {
            $output="";
            $categories=Category::query()
                ->where('name','LIKE','%'.$request->search."%")
                ->orWhere('max_points','LIKE','%'.$request->search."%")
                ->get();
            if($categories)
            {
                foreach ($categories as $category)
                {
                    if ($category->name == "") {
                        $category->delete();
                        continue;
                    }

                    $questions = $category->questions;
                    $number_of_questions = count($questions);
                    $category->setAttribute('number_of_questions', $number_of_questions);



                    $output.= '<tr>'.
                        '<td style="vertical-align: middle">'.$category->name.'</td>'.
                        '<td style="vertical-align: middle">'.$category->max_points.'</td>'.
                        '<td style="vertical-align: middle">'.$category->number_of_questions.'</td>'.
                        '<td>'.
                            '<div class="d-flex justify-content-end">'.
                                '<a href="'.route('categories.edit', $category->id).'" role="button" class="btn btn-sm btn-success mr-2">Edit</a>'.
                                '<form class="delete" action="'.route('categories.destroy', $category->id).'" method="POST" style="display:inline">'.
                                '<input type="hidden" name="_method" value="DELETE">'.
                                '<button type="submit" onclick="return confirm(\'Are you sure that you want to delete this category?\')" class="btn btn-sm btn-danger">Delete</button>'.
                                    csrf_field().
                                '</form>'.
                            '</div>'.
                        '</td>'.
                        '</tr>';
                }
                return Response($output);
            }
        }
    }

    public function update(Request $request, Category $category)
    {
        if (Auth::user() == null || !Auth::user()->hasRole('profesor')) {
            return redirect()->route('home');
        }

        $this->validate(
            $request,
            [
                'name' => 'required|max:128|unique:categories,name,' . $category->id,
                'max_points' => 'required|gte:1|lte:100'
            ],

        );

        $category->name = $request->name;
        $category->max_points = $request->max_points;

        $category->save();

        Session::flash('message', 'Category updated successfully');
        return redirect()->route('categories');
    }


    public function destroy(Category $category)
    {
        if (Auth::user() == null || !Auth::user()->hasRole('profesor')) {
            return redirect()->route('home');
        }
        $category->delete();
        Session::flash('delete-message', 'Category deleted successfully');
        return redirect()->route('categories');
    }
}
