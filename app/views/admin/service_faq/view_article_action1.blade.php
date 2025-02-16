@extends('admin._layouts.default')

<?php
	$title = (!isset($article['id']) || $article['id']==null) ? '新增' : '編輯';
	$title .= ($type=='service') ? '服務項目' : '常見問題';
?>

@section('main')
<h2><?php echo $title?>&nbsp;<span class="btn btn-inverse" onclick="window.history.back();">回上一頁</span></h2>
@include('admin._partials.notifications')
<form name="form1" action="<?php echo URL::route('admin.service_faq.article.write', array('type'=>$type))?>" method="post" enctype="multipart/form-data">
<div class="form-group">
	<label class="col-sm-3 control-label" for="title">標題</label>
	<div class="col-sm-5">
		<input type="text" class="form-control" id="title" name="title" size="12" value="<?php echo Arr::get($article, 'title', '')?>">
	</div>
</div>

描述圖片： (300x300以下)
{{--Upload Widget Start--}}
<input type="hidden" name="image_path" value="<?php echo Arr::get($article, 'image', '')?>"/>
@include('admin._partials.upload_single_OneClick')
{{--Upload Widget End--}}

<div class="form-group">
<label class="col-sm-3 control-label" for="link">說明文字</label>
<div class="col-sm-7">
	<textarea class="form-control" name="content"><?php echo Arr::get($article, 'content', '')?></textarea>
</div>
</div>


<div class="form-group">
	<label class="col-sm-3 control-label" for="link">所屬分類</label>
<select name="category">
	<?php foreach ($categories as $category):?>
	<option value="<?php echo $category->id?>" <?php echo (isset($article['_parent']) && $category->id==$article['_parent']) ? 'selected' : '';?>><?php echo $category->title?></option>
	<?php endforeach;?>
</select>
</div>

<div class="form-group">
<label class="radio">
  <input type="radio" name="status" value="Y" <?php echo ($article['status']=='Y')?'checked':''?> />
  顯示
</label>
<label class="radio">
  <input type="radio" name="status" value="N" <?php echo ($article['status']=='N')?'checked':''?>>
  隱藏
</label>
</div>

{{--Images Widget Start--}}
	<script type="text/javascript">
		var images_input_name = "images_path[]";
		var descriptions_input_name = "image_desc[]";
	</script>
	@include('admin._partials.images_upload')
{{--Images Widget End--}}

@include('admin._partials.widget_imageUploader', array('options'=>array('elementId'=>'image-box', 'title'=>'圖片', 'uploadURL'=>fps::getUploadURL(), 'deleteURL'=>fps::getDeleteURL())))

@include('admin._partials.widget_labels', array('label'=>$label))
<!-- labels -->

@include('admin._partials.widget_tabs', array('tabs'=>$tab))
<!-- tabs -->

<input type="hidden" name="id" value="<?php echo Arr::get($article, 'id', null)?>" />
<button class="btn" type="button" onclick="history.back();">取消</button> <button class="btn btn-inverse btn-submit">編輯完成</button>
</form>
@stop


@section('head')
    {{ HTML::style(asset('css/admin/widgets/tabs/css_widget_tabs.css')) }}
    {{ HTML::style(asset('css/admin/widgets/imageUploader/css_widget_imageUploader.css')) }}
@stop

@section('bottom')
    {{ HTML::script(asset('packages/ckeditor/ckeditor.js')) }}
    {{ HTML::script(asset('js/admin/widgets/labels/js_widget_labels.js')) }}
    {{ HTML::script(asset('js/admin/widgets/tabs/js_widget_tabs.js')) }}
    {{ HTML::script(asset('js/admin/widgets/imageUploader/js_widget_imageUploader.js')) }}
	{{ HTML::script(asset('js/admin/service_faq/js_action.js')) }}
    <script type="text/javascript">
        var imgUploader = _imageUploader({
                el: '#image-box',
                imageBoxMeta: {photoFieldName: 'images[]', descFieldName: 'imageDesc[]', delFieldName: 'deleteImages[]'},
                isMultiple: true,
                files: <?php echo json_encode($images) ?>
            });
    </script>
@stop