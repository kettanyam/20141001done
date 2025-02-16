@extends('admin._layouts.default')

@section('main')
<h2>文章管理</h2>
<ul class="nav nav-pills">
  @foreach ( helper::article_category() as $key=>$category )
  <li @if (Input::get('category')==$key)class="active" @endif>
    <a href="{{ URL::to('admin/articles?category='.$key) }}">{{ $category }}</a>
  </li>
  @endforeach
</ul>
<div class="pull-right"><a href="{{ URL::to('admin/articles/create?category='.Input::get('category')) }}" class="btn">新增</a></div>
<table class="table table-bordered" ng-controller="articlesCtrl">
<thead>
                <tr>
                  <th>標題</th>
                  <th>分類</th>
                  <th>上架日期</th>
                  <th>狀態</th>
                  <th>瀏覽數</th>
                  <th>功能</th>
                </tr>
              </thead>
<tbody id="sortable">
@foreach ($articles as $article)
                <tr id="{{ $article->id }}">
                  <td>{{ $article->title }}</td>
                  <td>{{ helper::article_category($article->category) }}</td>
                  <td>{{ $article->open_at }}</td>
                  <td>{{ ($article->status=='1')?'<span style="color: #00AA00">顯示</span>':'隱藏' }}</td>
                  <td>{{ $article->views }}</td>
                  <td><a href="{{ URL::to('admin/articles/'.$article->id.'/edit') }}" class="btn btn-primary">修改</a> <a href ng-click="deleteArticle({{ $article->id }})" class="btn btn-danger">刪除</a></td>
                </tr>
@endforeach
</tbody>
</table>
@if(!Input::get('category') || Input::get('category')==3)
{{ $articles->appends(array('category' => Input::get('category')))->links() }}
@endif
@stop

@section('bottom')
@if(Input::get('category')==1 || Input::get('category')==2)
<style>
.table tbody tr
{
  cursor:move;
}
</style>
<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.9.1.js"></script>
<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<script>
  $(function() {
    $( "#sortable" ).sortable({
      helper: function(e, tr) {
        var $originals = tr.children();
        var $helper = tr.clone();
        $helper.children().each(function(index)
        {
          // Set helper cell sizes to match the original sizes
          $(this).width($originals.eq(index).width());
        });
        return $helper;
      },
      update: function( event, ui ) {
        var sort = $(this).sortable("toArray").toString();

        $.ajax({
          type: "POST",
          url: "/admin/articles/sort",
          data: { sort:sort }
        }).done(function( msg ) {
        });
      }
    });
    $( "#sortable" ).disableSelection();
  });
</script>
@endif
@stop
