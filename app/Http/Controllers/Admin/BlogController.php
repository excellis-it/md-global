<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Traits\ImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{

    use ImageTrait;

    public function categoryIndex()
    {
        $categories = BlogCategory::orderBy('id', 'desc')->get();
        return view('admin.blogs.category.list', compact('categories'));
    }

    public function categoryCreate()
    {
        return view('admin.blogs.category.create');
    }

    public function categoryEdit($id)
    {
        $category = BlogCategory::findOrFail($id);
        return view('admin.blogs.category.edit', compact('category'));
    }

    public function categoryStore(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:blog_categories',
        ]);

        $category = new BlogCategory();
        $category->name = $request->name;
        $category->slug = $request->slug;
        $category->meta_title=$request->meta_title;
        $category->meta_description=$request->meta_description;
        $category->meta_keyword=$request->meta_keyword;
        $category->save();
        return redirect()->route('blogs.categories.index')->with('message', 'Category created successfully');
    }

    public function categoryUpdate(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:blog_categories,slug,' . $request->id,
        ]);

        $category = BlogCategory::findOrFail($request->id);
        $category->name = $request->name;
        $category->slug = $request->slug;
        $category->meta_title=$request->meta_title;
        $category->meta_description=$request->meta_description;
        $category->meta_keyword=$request->meta_keyword;
        $category->save();
        return redirect()->route('blogs.categories.index')->with('message', 'Category updated successfully');
    }

    public function categoryDelete($id)
    {
        $category = BlogCategory::findOrFail($id);
        $category->delete();
        return redirect()->route('blogs.categories.index')->with('error', 'Category deleted successfully');
    }

    public function index()
    {
        // $blogs = Blog::orderBy('id', 'desc')->get();
        return view('admin.blogs.list');
    }

    public function ajaxList(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = Blog::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Blog::select('count(*) as allcount')->count();

        // Fetch records
        $records = Blog::query();
        $columns = ['title', 'slug'];
        foreach ($columns as $column) {
            $records->orWhere($column, 'like', '%' . $searchValue . '%');
        }
        $records->orWhereHas('category', function ($query) use ($searchValue) {
            $query->where('name', 'like', '%' . $searchValue . '%');
        });
        $records->orderBy($columnName, $columnSortOrder);
        $records->skip($start);
        $records->take($rowperpage);

        $records = $records->orderBy('id', 'desc')->get();

        $data_arr = array();

        foreach ($records as $record) {

            $data_arr[] = array(
                'title' => $record->title,
                'category_name' => $record->category->name,
                'slug' => $record->slug,
                'image' => '<img src="' . Storage::url($record->image) . '" width="70px" height="70px" style="border-radius: 50%">',
                'status' => $record->status == 1 ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>',
                "status" => '<div class="button-switch"><input type="checkbox" id="switch-orange" class="switch toggle-class" data-id="' . $record->id . '"' . ($record->status ? 'checked' : '') . '/><label for="switch-orange" class="lbl-off"></label><label for="switch-orange" class="lbl-on"></label></div>',
                "action" => '<a href="' . route('blogs.edit', $record->id) . '"><i class="fas fa-edit"></i></a>&nbsp;&nbsp;<a title="DeleteMedical Staff"  data-route="' . route('blogs.delete', $record->id) . '" href="javascipt:void(0);" id="delete"><i class="fas fa-trash"></i></a>',
            );
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
        );

        return response()->json($response);
    }

    public function create()
    {
        $categories = BlogCategory::orderBy('id', 'desc')->get();
        return view('admin.blogs.create')->with(compact('categories'));
    }

    public function edit($id)
    {
        $blog = Blog::findOrFail($id);
        $categories = BlogCategory::orderBy('id', 'desc')->get();
        return view('admin.blogs.edit')->with(compact('blog', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'blog_category_id' => 'required',
            'slug' => 'required|unique:blogs',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
            'content' => 'required',
            'status' => 'required',
        ]);

        $blog = new Blog();
        $blog->title = $request->title;
        $blog->blog_category_id = $request->blog_category_id;
        $blog->slug = $request->slug;
        $blog->image = $this->imageUpload($request->file('image'), 'blogs');
        $blog->content = $request->content;
        $blog->status = $request->status;
        $blog->meta_title=$request->meta_title;
        $blog->meta_description=$request->meta_description;
        $blog->meta_keyword=$request->meta_keyword;
        $blog->save();
        return redirect()->route('blogs.index')->with('message', 'Blog created successfully');
    }

    public function update(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'blog_category_id' => 'required',
            'slug' => 'required|unique:blogs,slug,' . $request->id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
            'content' => 'required',
            'status' => 'required',
        ]);

        $blog = Blog::findOrFail($request->id);
        $blog->title = $request->title;
        $blog->blog_category_id = $request->blog_category_id;
        $blog->slug = $request->slug;
        if ($request->hasFile('image')) {
            $request->validate([
                'image' => 'image|mimes:jpg,png,jpeg,gif,svg',
            ]);
            if ($blog->image) {
                $currentImageFilename = $blog->image; // get current image name
                Storage::delete('app/' . $currentImageFilename);
            }
            $blog->image = $this->imageUpload($request->file('image'), 'blogs');
        }
        $blog->content = $request->content;
        $blog->status = $request->status;
        $blog->meta_title=$request->meta_title;
        $blog->meta_description=$request->meta_description;
        $blog->meta_keyword=$request->meta_keyword;
        $blog->save();
        return redirect()->route('blogs.index')->with('message', 'Blog updated successfully');
    }

    public function delete($id)
    {
        $blog = Blog::findOrFail($id);
        if ($blog->image) {
            $currentImageFilename = $blog->image; // get current image name
            Storage::delete('app/' . $currentImageFilename);
        }
        $blog->delete();
        return redirect()->route('blogs.index')->with('error', 'Blog deleted successfully');
    }

    public function changeBlogStatus(Request $request)
    {
        $user = Blog::find($request->id);
        $user->status = $request->status;
        $user->save();
        return response()->json(['success' => 'Status change successfully.']);
    }
}
