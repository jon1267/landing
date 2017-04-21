<?php

namespace App\Http\Controllers;

use App\Page;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Validator;
use Validator;

class PagesAddController extends Controller
{
    public function execute(Request $request) {

        if ($request->isMethod('post')) {
            // $input = $request->all(); //$input - массив !!! не коллекция
            $input = $request->except('_token');

            //если убрать $messages (тут и из $validator) - валидация на англ.
            $messages = [
                'required' => "Поле :attribute обязятельно к заполнению.",
                'unique' => "Поле :attribute должно быть уникальным. Измените значение."
            ];
            $validator = Validator::make($input, [
                'name' => 'required|max:255',
                'alias' => 'required|unique:pages|max:255',
                'text' => 'required'
            ], $messages);

            // если есть ошибки валидации ->fails() врнет TRUE !!!
            if ($validator->fails()) {
                return redirect()->route('pagesAdd')
                    ->withErrors($validator)->withInput();
            }

            if ($request->hasFile('images')) {
                $fileImg = $request->file('images');
                $input['images'] = $fileImg->getClientOriginalName();
                $fileImg->move(public_path().'/assets/img',$input['images']);
            }

            //$page = new Page($input);($input - массив, см 3 стр. комментов ниже)
            $page = new Page();

            // чтоб работало ->fill($input) нада в модели Page указывать
            // protected $fillable = ['name', 'alias', 'text', 'images']
            // все разрешенные к автозаполнению поля. Тогда работает ->fill($input)
            $page->fill($input);
            if ($page->save()) {
                return redirect('admin')->with('status','Страница была успешно добавлена');
            }
            /* а так в модели никаких $fillable = [] не надо
            $page->name = $input['name'];
            $page->alias = $input['alias'];
            $page->images = $input['images'];
            $page->text = $input['text'];
            $page->save();
            return redirect()->route('pages');
            */
        }

        if (view()->exists('admin.pages_add')) {
            $data = ['title' => 'Новая страница'];
            return view('admin.pages_add', $data);
        }
        abort(404);
    }
}
