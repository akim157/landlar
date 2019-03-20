<?php

namespace App\Http\Controllers;

use App\Mail\OrderShipped;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Page;
use App\Service;
use App\Portfolio;
use App\People;
use DB;

class IndexController extends Controller
{
    //
    public function execute(Request $request)
    {
        if($request->isMethod('post'))
        {
            $rules = [
                'name'  => 'required|max:255',
                'email' => 'required|email',
                'text'  => 'required',
            ];
            $messages = [
                'required'  => 'Поле :attribute обязательно к заполнению',
                'max'       => 'Поле :attribute максимально количество символов для ввода :max',
                'email'     => 'Поле :attribute должно соотвествовать email адресу',
            ];
            $this->validate($request, $rules, $messages);
            Mail::to(env('MAIL_FROM_ADDRESS'))->send(new OrderShipped($request));
            return redirect()->route('home')->with('status', 'Email is send');
        }

        $pages = Page::all();
        $portfolios = Portfolio::get(['name','filter','images']);
        $services = Service::where('id','<', 20)->get();
        $peoples = People::take(3)->get();

        $tags = DB::table('portfolios')->distinct()->select('filter')->get();

        $menu = [];
        foreach($pages as $page)
        {
            $item = ['title' => $page->name, 'alias' => $page->alias];
            $menu[] = $item;
//          array_push($menu, $item);
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
            'menus'         => $menu,
            'pages'         => $pages,
            'services'      => $services,
            'portfolios'    => $portfolios,
            'peoples'       => $peoples,
            'tags'          => $tags
        ]);
    }
}
