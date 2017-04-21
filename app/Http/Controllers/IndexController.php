<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Page;
use App\People;
use App\Portfolio;
use App\Service;
// в уроке было просто --  use DB;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;


class IndexController extends Controller
{
    //
    public function execute(Request $request) {

        if ($request->isMethod('post')) {

            $messages = [
                'required' => "Поле :attribute обязятельно к заполнению",
                'email' => "Укажите правильный емаил адрес :attribute"
            ];
            $this->validate($request, [
                'name' => 'required|max:255',
                'email' => 'required|email',
                'text' => 'required'
            ], $messages);

            // $data - ! array: ['name'=>'contents field name',...]
            $data = $request->all();

            $result = Mail::send('site.email', ['data'=>$data], function($message) use ($data)  {

                $mail_admin = env('MAIL_ADMIN');
                $message->from($data['email'], $data['name']);
                $message->to($mail_admin, 'Mr. Admin')->subject('Question');
            });

            if (!$result) {
                // вот падшая женщина!!! В уроке было if($result) и работало !!!
                // Наверно в Laravel 5.4 $res = Mail::send() возвращает 0 если все ОК !!!
                return redirect()->route('home')->with('status', 'Email was successfully send');
            }

        }

        $pages = Page::all();
        $peoples = People::take(3)->get();
        $portfolios = Portfolio::get(['name', 'images', 'filter']);
        $services = Service::where('id','<',10)->get();

        //$tags = DB::table('portfolios')->distinct()->get(['filter']);//это работает
        //$tags = DB::table('portfolios')->distinct()->lists('filter');//это в L54 дает ошибку !!!
        $tags = DB::table('portfolios')->distinct()->pluck('filter');//work, and result: array in collection.

        $menu = [];
        foreach ($pages as $page) {
            $item = ['title' => $page->name, 'alias' => $page->alias];
            //array_push($menu, $item);
            $menu[] = $item;
        }

        $item = ['title' => 'Services', 'alias' => 'service'];
        $menu[] = $item;

        $item = ['title' => 'Portfolio', 'alias' => 'Portfolio'];
        $menu[] = $item;

        $item = ['title' => 'Team', 'alias' => 'team'];
        $menu[] = $item;

        $item = ['title' => 'Contact', 'alias' => 'contact'];
        $menu[] = $item;

        return view('site.index', [
            'menu' => $menu,
            'pages' => $pages,
            'services' => $services,
            'portfolios' => $portfolios,
            'peoples' => $peoples,
            'tags' => $tags
        ]);
    }
}
