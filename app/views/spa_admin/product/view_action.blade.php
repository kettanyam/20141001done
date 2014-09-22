@extends('spa_admin._layouts.default')

@section('title')
@if($action == 'create')
新增產品項目
@elseif($action == 'edit')
編輯產品項目
@endif

@if($ref == '0')
@elseif($ref_lang != 'tw')
(繁體)
@elseif($ref_lang != 'cn')
(簡體)
@endif
@stop

@section('main')
<form action='{{$write_url}}@if($list_category != '')?category={{$list_category}}@endif' method="post" enctype="multipart/form-data">
	<div class="form-group">
		<label>標題</label>
		<input class="form-control" type="text" name="title" value="@if($action == 'edit'){{$product->title}}@endif"/>
	</div>
	@include('spa_admin._partials.widget_imageUploader', array('options'=>array('elementId'=>'image-main-box', 'title'=>'描述圖片', 'uploadURL'=>fps::getUploadURL(), 'deleteURL'=>fps::getDeleteURL())))
	<!-- image uploader -->
	<div class="form-group">
		<label>所屬分類</label>
		<select class="form-control" name="cat">
			@foreach($category_list as $category)
			<option value="{{$category->id}}" @if($action == 'edit' && $category->id == $product->_parent)selected@endif>{{$category->title}}</option>
			@endforeach
		</select>
	</div>
	<div class="form-group">
		<label>容量</label>
		<input class="form-control" type="text" name="capacity" value="@if($action == 'edit'){{$product->capacity}}@endif"/>
	</div>
	<div class="form-group">
		<label>價格</label>
		<input class="form-control" type="text" name="price" value="@if($action == 'edit'){{$product->price}}@endif"/>
	</div>
	@include('spa_admin._partials.widget_imageUploader', array('options'=>array('elementId'=>'image-box', 'title'=>'圖片', 'uploadURL'=>fps::getUploadURL(), 'deleteURL'=>fps::getDeleteURL())))
	<!-- image uploader -->
	<div class="form-group">
		<label>狀態</label><br/>
		<label class="radio-inline">
			<input type="radio" name="display" value="yes" @if($action == 'edit')@if($product->display == 'yes') checked @endif@endif @if($action=='create')checked@endif/>顯示
		</label>
		<label class="radio-inline">
			<input type="radio" name="display" value="no" @if($action == 'edit')@if($product->display == 'no') checked @endif@endif/>隱藏
		</label>
	</div>
	<div class="form-group">
		<label>語系</label><br/>
		@if($ref == '0')
		<label class="radio-inline">
			<input type="radio" name="lang" value="tw" @if($action == 'edit')@if($product->lang == 'tw') checked @endif@endif @if($action=='create' && $ref == '0')checked@endif />繁體
		</label>
		<label class="radio-inline">
			<input type="radio" name="lang" value="cn" @if($action == 'edit')@if($product->lang == 'cn') checked @endif@endif />簡體
		</label>
		@elseif($ref_lang != 'tw')
		繁體<input type='hidden' name="lang" value="tw"/>
		@elseif($ref_lang != 'cn')
		簡體<input type='hidden' name="lang" value="cn"/>
		@endif
	</div>
	@include('spa_admin._partials.widget_tabs', array('tabs'=>$tab))
	<!-- tabs -->
	<div class="form-group">
		<input type="hidden" name="action" value="{{$action}}"/>
		<input type="hidden" name="ref" value="{{$ref}}"/>
		<a href='javascript:history.back()' type="button" class="btn btn-danger">取消</a>
		<button class="btn btn-primary btn-submit">編輯完成</button>
	</div>
</form>
@stop

@section('head')
    {{ HTML::style(asset('css/admin/widgets/tabs/css_widget_tabs.css')) }}
    {{ HTML::style(asset('css/admin/widgets/imageUploader/css_widget_imageUploader.css')) }}
@stop

@section('bottom')
{{ HTML::script(asset('packages/jquery-file-upload/js/vendor/jquery.ui.widget.js')) }}
{{ HTML::script(asset('packages/jquery-file-upload/js/jquery.iframe-transport.js')) }}
{{ HTML::script(asset('packages/jquery-file-upload/js/jquery.fileupload.js')) }}
{{ HTML::script(asset('packages/jquery-file-upload/js/jquery.fileupload-process.js')) }}
{{ HTML::script(asset('packages/ckeditor/ckeditor.js')) }}
{{ HTML::script(asset('packages/ckeditor/adapters/jquery.js')) }}
{{ HTML::script(asset('js/admin/widgets/labels/js_widget_labels.js')) }}
{{ HTML::script(asset('js/admin/widgets/tabs/js_widget_tabs.js')) }}
{{ HTML::script(asset('js/admin/widgets/imageUploader/js_widget_imageUploader.js')) }}
{{ HTML::script(asset('js/admin/service_faq/js_action.js')) }}
<script type="text/javascript">
    var imgUploaderMain = _imageUploader({
            el: '#image-main-box',
            imageBoxMeta: {photoFieldName: 'main_image[]', descFieldName: 'main_imageDesc[]', delFieldName: 'main_deleteImages[]'},
            isMultiple: false,
            files: <?php echo json_encode($product_mian_img) ?>
        });
    	imgUploader = _imageUploader({
    		el: '#image-box',
    		imageBoxMeta:{photoFieldName: 'images[]', descFieldName: 'imageDesc[]', delFieldName: 'deleteImages[]'},
    		isMultiple: true,
    		files: <?php echo json_encode($product_imgs)?>
    	});
</script>
@stop