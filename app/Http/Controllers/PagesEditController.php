<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Page;
use Validator;

class PagesEditController extends Controller
{
    //
    public function execute(Page $page, Request $request) {
        /*$page = Page::find($id); после (Page $page,...) это ненужно */

        if ($request->isMethod('delete')) {
            $page->delete();
            return redirect('admin')->with('status', 'Страница была удалена');
        }

        if ($request->isMethod('post')) {

            // $input (вроде) массив из к-рого исключен _token
            $input = $request->except('_token');

            $validator = Validator::make($input,[
                'name'  => 'required|max:255',
                'alias' => 'required|max:255|unique:pages,alias,'.$input['id'],
                'text'  => 'required'
            ]);

            // если есть ошибки валидации ->fails() врнет TRUE !!!
            if ($validator->fails()) {
                //работает и если ...->route('pagesEdit', $input['id'])...
                return redirect()->route('pagesEdit', ['page' => $input['id']])
                    ->withErrors($validator);
            }

            if ($request->hasFile('images')) {
                $fileImg =  $request->file('images');
                $input['images'] = $fileImg->getClientOriginalName();
                $fileImg->move(public_path().'/assets/img', $input['images']);
            } else {
                $input['images'] = $input['old_images'];
            }
            unset($input['old_images']);

            $page->fill($input);
            if ($page->update()) {
                return redirect('admin')->with('status','Страница была успешно обновлена');
            }

        }

        $old = $page->toArray();
        if (view()->exists('admin.pages_edit')) {
            $data = [
                'title' => 'Редактирование страницы - '.$old['name'],
                'data'  => $old
            ];
            return view('admin.pages_edit',$data);
        }
    }
}
