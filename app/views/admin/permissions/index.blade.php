@extends('admin._layouts.default')
 
@section('main')
<h2>權限管理</h2>
<div class="pull-right"><a href="{{ URL::to('admin/permissions/create') }}" class="btn">新增</a></div>
<table class="table table-bordered" ng-controller="permissionsCtrl">
<thead>
                <tr>
                  <th>權限</th>
                  <th>標題</th>
                  <th>狀態</th>
                  <th>功能</th>
                </tr>
              </thead>
<tbody id="sortable">
@foreach ($permissions as $permission)
                <tr id="{{ $permission->id }}">
                  <td>{{ $permission->name }}</td>
                  <td>{{ $permission->title }}</td>
                  <td>{{ $permission->status?'ON':'OFF' }}</td>
                  <td><a href="{{ URL::to('admin/permissions/'.$permission->id.'/edit') }}" class="btn btn-primary">修改</a> <a href ng-click="deletePermission({{ $permission->id }})" class="btn btn-danger">刪除</a></td>
                </tr>
@endforeach
</tbody>
</table>
@stop

@section('bottom')
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
          url: "/admin/permissions/sort",
          data: { sort:sort }
        }).done(function( msg ) {
        });
      }
    });
    $( "#sortable" ).disableSelection();
  });
</script>
@stop
