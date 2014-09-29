<?php
namespace spa;

class AboutController extends \BaseController {
    public function getArticle($id = null){
        try {
            $articles = array();
            if($id==null) {
                $article = \SpaArticles::where('category', '=', 'about')
                                       ->where('status', '1')
                                       ->orderBy('sort', 'desc')
                                       ->firstOrFail();
                $id = $article->id;
            }
            else
                $article = \SpaArticles::find($id);

            if(\ViewsAdder::views_cookie('about', $id)) {
              $article->views = $article->views + 1;
              $article->save();
            }

            $articleList = \SpaArticles::where('category', '=', 'about')
                                       ->where('status', '1')
                                       ->orderBy('sort', 'desc')
                                       ->get();

            if($article && $articleList)
                return \View::make('spa.about.view_about', array('article'=>$article,
                                                                 'articleList'=>$articleList,
                                                                 'publish'=>array_get($article, 'open_at'),
                                                                 'views'=>array_get($article, 'views')));
        }catch(Exception $e) {
            return \View::make('spa.about.view_about');
        }
    }

}
