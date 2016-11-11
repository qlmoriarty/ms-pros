<?php

namespace App\Http\Controllers;

use App\Category;
use App\Constant\UniversalConstant;
use App\LastId;
use App\SubCategory;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public $active_list = [];

    public $http_avatar = 'https://s3.amazonaws.com/ms-pros/';

    public function __construct()
    {
        $this->active_list = UniversalConstant::getActiveList();
    }

    public static function sortBySubkey(&$array, $subkey, $sortType = SORT_ASC)
    {
        foreach ($array as $subarray) {
            $keys[] = $subarray[$subkey];
        }
        array_multisort($keys, $sortType, $array);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Category = [];
        foreach (Category::all()->toArray() as $item) {
            $item['sub'] = [];

            $control = [];

            $control[] = '<a href="' . url('/category/create' . '?' . http_build_query(['SubCategoryIs' => true, 'ParentCatID' => $item['CatID']])) . '" class="btn btn-success btn-sm">Add sub </a>';
            $control[] = '<a href="' . url('/category/' . $item['CatID'] . '/edit') . '" class="btn btn-info btn-sm"><i class="fa fa-wrench"></i></a>';
            $control[] = '<a href="#" class="btn btn-danger btn-sm item_destroy_category" data-url="' . url('/category/' . $item['CatID']) . '" data-CatID="' . $item['CatID'] . '"><i class="fa fa-trash"></i></a>';

            $item['control'] = '<div class="control">' . implode('&#160;', $control) . '</div>';

            $Category[$item['CatID']] = $item;
        }

        foreach (SubCategory::all()->toArray() as $item) {
            $control = [];

            $control[] = '<a href="' . url('/category/' . $item['SubCatsID'] . '/edit' . '?' . http_build_query(['SubCategoryIs' => true])) . '" class="btn btn-info btn-sm"><i class="fa fa-wrench"></i></a>';
            $control[] = '<a href="#" class="btn btn-danger btn-sm item_destroy_category" data-destroy="' . url('/category/' . $item['SubCatsID'] . '?' . http_build_query(['SubCategoryIs' => true])) . '"><i class="fa fa-trash"></i></a>';

            $item['control'] = '<div class="control" data-ParentCatID="' . $item['ParentCatID'] . '">' . implode('&#160;', $control) . '</div>';

            if (isset($Category[$item['ParentCatID']])) {
                $Category[$item['ParentCatID']]['sub'][$item['SubCatsID']] = $item;
            }
        }

        $this->sortBySubkey($Category, 'Name');
        foreach ($Category as &$Category_) {
            //$Category_['Name'] .= ' | '.count($Category_['sub']);
            if (count($Category_['sub'])) {
                $this->sortBySubkey($Category_['sub'], 'Name');
            }
        }

        //print 'FILE: ' . __FILE__ . ' | LINE: ' . __LINE__ . ' | $Category = <pre>' . print_r($Category, true) . "</pre><br>\n";

        return view('category.index', compact('Category'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $SubCategoryIs = $request->input('SubCategoryIs', 0);

        $Category = [];
        if ($SubCategoryIs) {
            $Category = Category::all()->pluck('Name', 'CatID');
        }

        return view('category.create', [
            'SubCategoryIs' => $SubCategoryIs,
            'category_list' => $Category,
            'ParentCatID' => $request->input('ParentCatID', 0),
            'active_list' => $this->active_list
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'Avatar' => 'required',
            'Name' => 'required|max:255'
        ]);

        //print 'FILE: ' . __FILE__ . ' | LINE: ' . __LINE__ . ' | $request = <pre>' . print_r($request->all(), true) . "</pre><br>\n";
        //print 'FILE: ' . __FILE__ . ' | LINE: ' . __LINE__ . ' | $request = <pre>' . print_r($request->file(), true) . "</pre><br>\n";

        $SubCategoryIs = $request->input('SubCategoryIs', 0);
        if ($SubCategoryIs == 1) {
            $class = SubCategory::class;
            $avatar_folder = 'sub_categories';
        } else {
            $class = Category::class;
            $avatar_folder = 'categories';
        }

        $Active = ($request->input('Active') == 'true') ? true : false;
        $Name = $request->input('Name');
        $Description = $request->input('Description');
        $MaxUsers = $request->input('MaxUsers');

        $LastId = LastId::get($class);
        //print 'FILE: ' . __FILE__ . ' | LINE: ' . __LINE__ . ' | $LastId  = <pre>' . print_r($LastId->toArray(), true) . "</pre><br>\n";

        if ($class == SubCategory::class) {
            $create = [
                'ParentCatID' => (int)$request->input('ParentCatID'),
                'SubCatsID' => $LastId->id,
            ];
        } else {
            $create = [
                'CatID' => $LastId->id,
            ];
        }
        $create += [
            'Active' => $Active,
            'Name' => $Name,
            'Description' => $Description,
            'MaxUsers' => (int)$MaxUsers,
        ];
        $avatar_path = 'data/' . $avatar_folder . '/' . $LastId->id;

        $category = $class::create($create);
        $LastId->id++;
        $LastId->save();

        $path = $request->file('Avatar')->store($avatar_path, 's3');
        Storage::disk('s3')->setVisibility($path, 'public');
        //print 'FILE: ' . __FILE__ . ' | LINE: ' . __LINE__ . ' | $path = <pre>' . print_r($path, true) . "</pre><br>\n";

        $category->Avatar = $this->http_avatar . $path;
        $category->save();
        //print 'FILE: ' . __FILE__ . ' | LINE: ' . __LINE__ . ' | $category = <pre>' . print_r($category->toArray(), true) . "</pre><br>\n";

        return redirect('/category')->with('status', 'Category add!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect('/category/' . $id . '/edit');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $SubCategoryIs = $request->input('SubCategoryIs', 0);
        if ($SubCategoryIs == 1) {
            $class = SubCategory::class;
            $Category = Category::all()->pluck('Name', 'CatID');
        } else {
            $class = Category::class;
            $Category = [];
        }

        $category = $class::find((int)$id);
//        $category = new Category();
//        $category->find((int)$id);
        return view('category.edit', compact('category') + [
                'SubCategoryIs' => $SubCategoryIs,
                'category_list' => $Category,
                'active_list' => $this->active_list
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'Name' => 'required|max:255'
        ]);

        //print 'FILE: ' . __FILE__ . ' | LINE: ' . __LINE__ . ' | $request = <pre>' . print_r($request->all(), true) . "</pre><br>\n";
        //print 'FILE: ' . __FILE__ . ' | LINE: ' . __LINE__ . ' | $request = <pre>' . print_r($request->file(), true) . "</pre><br>\n";

        $SubCategoryIs = $request->input('SubCategoryIs', 0);
        if ($SubCategoryIs == 1) {
            $class = SubCategory::class;
            $avatar_folder = 'sub_categories';
        } else {
            $class = Category::class;
            $avatar_folder = 'categories';
        }

        $Active = ($request->input('Active') == 'true') ? true : false;
        $Name = $request->input('Name');
        $Description = $request->input('Description');

        //print 'FILE: ' . __FILE__ . ' | LINE: ' . __LINE__ . ' | $class = <pre>' . print_r($class, true) . "</pre><br>\n";
        //print 'FILE: ' . __FILE__ . ' | LINE: ' . __LINE__ . ' | $id = <pre>' . print_r($id, true) . "</pre><br>\n";
        $category = $class::find((int)$id);
        //print 'FILE: ' . __FILE__ . ' | LINE: ' . __LINE__ . ' | $category = <pre>' . print_r($category->toArray(), true) . "</pre><br>\n";exit;
        $category->Active = $Active;
        $category->Name = $Name;
        $category->Description = $Description;
        if ($class == SubCategory::class) {
            $category->ParentCatID = (int)$request->input('ParentCatID', 0);
        }

        if (!empty($request->file('Avatar'))) {
            if ($class == SubCategory::class) {
                $avatar_path = 'data/' . $avatar_folder . '/' . $category->SubCatsID;
            } else {
                $avatar_path = 'data/' . $avatar_folder . '/' . $category->CatID;
            }

            Storage::disk('s3')->delete(str_replace($this->http_avatar, '', $category->Avatar));

            $path = $request->file('Avatar')->store($avatar_path, 's3');
            Storage::disk('s3')->setVisibility($path, 'public');
            //print 'FILE: ' . __FILE__ . ' | LINE: ' . __LINE__ . ' | $path = <pre>' . print_r($path, true) . "</pre><br>\n";

            $category->Avatar = $this->http_avatar . $path;
        }
        $category->save();
        //print 'FILE: ' . __FILE__ . ' | LINE: ' . __LINE__ . ' | $category = <pre>' . print_r($category->toArray(), true) . "</pre><br>\n";

        return redirect('/category')->with('status', 'Category updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $SubCategoryIs = $request->input('SubCategoryIs', 0);
        if ($SubCategoryIs == 1) {
            $class = SubCategory::class;
        } else {
            $class = Category::class;
        }

        $category = $class::find((int)$id);

        if ($class == Category::class) {
            //print 'FILE: ' . __FILE__ . ' | LINE: ' . __LINE__ . ' | $category = <pre>' . print_r($category->toArray(), true) . "</pre><br>\n";
            foreach (SubCategory::where('ParentCatID', '=', (int)$category->CatID)->get() as $subcategory) {
                //print 'FILE: ' . __FILE__ . ' | LINE: ' . __LINE__ . ' | $subcategory = <pre>' . print_r($subcategory->toArray(), true) . "</pre><br>\n";
                Storage::disk('s3')->delete(str_replace($this->http_avatar, '', $subcategory->Avatar));
                $subcategory->delete();
            }
        }

        Storage::disk('s3')->delete(str_replace($this->http_avatar, '', $category->Avatar));
        $category->delete();

        return response()->json(['success' => true]);
    }
}
