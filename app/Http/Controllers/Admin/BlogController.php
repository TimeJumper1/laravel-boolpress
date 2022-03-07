<?php

namespace App\Http\Controllers\Admin;
use App\Blog;
use App\Category;
use App\Tag;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $blogs = Blog::all();

        $data = [
            'blogs' => $blogs
        ];
        
        return view('admin.blogs.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $categories = Category::all();
        $tags = Tag::all();
        $data = [
            'categories' => $categories,
            'tags' => $tags
        ];
        return view('admin.blogs.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $form_data = $request->all();

        $request->validate($this->getValidationRules());
        $new_blog = new Blog();
        $new_blog->fill($form_data);
        
        $new_blog->slug = Blog::getUniqueSlugFromTitle($form_data['title']);
        if(isset($form_data['image'])) {
            // 1- Mettere l'immagine caricata nella cartella di Storage
            $img_path = Storage::put('post_covers', $form_data['image']);
            // 2- Salvare il path al file nella colonna cover del post
            $new_blog->cover = $img_path;
        }
        $new_blog->save();

        if(isset($form_data['tags'])) {
            $new_blog->tags()->sync($form_data['tags']);
        }

        return redirect()->route('admin.blogs.show', ['blog' => $new_blog->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $blog = Blog::findOrFail($id);

        $data = [
            'blog' => $blog
        ];
        
        return view('admin.blogs.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $blog = Blog::findOrFail($id);
        $categories = Category::all();
        $tags = Tag::all();
        $data = [
            'blog' => $blog,
            'categories' => $categories,
            'tags' => $tags
        ];

        return view('admin.blogs.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $form_data = $request->all();
        $request->validate($this->getValidationRules());

        $blog = Blog::findOrFail($id);
        
       
        if($form_data['title'] != $blog->title) {
            $form_data['slug'] = Blog::getUniqueSlugFromTitle($form_data['title']);
        }
        if($form_data['image']) {
            // Cancello il file vecchio
            if($blog->cover) {
                Storage::delete($blog->cover);
            }

            // Faccio l'upload il nuovo file
            $img_path = Storage::put('post_covers', $form_data['image']);

            // Salvo nella colonna cover il path al nuovo file
            $form_data['cover'] = $img_path;
        }
        $blog->update($form_data);

        if(isset($form_data['tags'])) {
            $blog->tags()->sync($form_data['tags']);
        } else {
            
            $blog->tags()->sync([]);
        }

        return redirect()->route('admin.blogs.show', ['blog' => $blog->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $blog = Blog::findOrFail($id);
        $blog->delete();

        return redirect()->route('admin.blogs.index');
    }
    protected function getValidationRules() {
        return [
            'title' => 'required|max:255',
            'content' => 'required|max:60000',
            'category_id' => 'exists:categories,id|nullable',
            'tags' => 'exists:tags,id',
            'image' => 'image|max:512'
        ];
    }

    
}
