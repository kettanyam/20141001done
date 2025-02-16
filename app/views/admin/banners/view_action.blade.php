@extends('admin._layouts.default')

@section('main')
<h2><?=(Arr::get($data, 'bid', null)==null)?'新增':'編輯'?>Banner (<?=$size['text']?>)</h2>
<form action="<?=URL::route('admin.banners.enAction')?>" method="post">
	<div class="form-group">
		<label class="col-sm-3 control-label" for="image">圖片</label>

		<div class="col-sm-5">
			<div class="uploader">
				<img src="" id="thumb"/>
				<div class="toolbar">
					<button type="button" class="btn btn-default btn-select">上傳檔案</button>
					<input id="fileupload" type="file" name="files[]" data-url="<?=fps::getUploadURL()?>" style="display: none;" />
					<div id="progress" class="progress progress-striped">
					    <div class="bar progress-bar progress-bar-success"></div>
					</div>
				</div>
				<input type="hidden" name="image" value="<?=Arr::get($data, 'image', '')?>"/>
			</div>
		</div>
	</div>
	<!-- image uploader -->

	<div class="form-group">
		<label class="col-sm-3 control-label" for="title">標題</label>
		<div class="col-sm-5">
			<input type="text" class="form-control" id="title" name="title" size="64" value="<?=Arr::get($data, 'title', '')?>" placeholder="請輸入標題" />
		</div>
	</div>
	<!-- title -->

	<div class="form-group">
		<label class="col-sm-3 control-label" for="link">連結</label>
		<div class="col-sm-5">
			<input type="text" class="form-control" id="link" name="link" size="12" value="<?=Arr::get($data, 'link', '')?>" placeholder="請輸入連結，預設: #" />
		</div>
	</div>
	<!-- link -->

	<div class="form-group">
		<label class="col-sm-3 control-label" for="link">連結視窗</label>
		<div class="col-sm-5">
			<label class="radio-inline">
				<input type="radio" name="target" id="inlineCheckbox1" value="_self" <?=((Arr::get($data, 'bid', null)==null) || (Arr::get($data, 'target')=='_self')) ? 'checked="checked"' : ''?>> 原視窗
			</label>
			<label class="radio-inline">
				<input type="radio" name="target" id="inlineCheckbox2" value="_blank" <?=(Arr::get($data, 'target', '')=='_blank') ? 'checked="checked"' : ''?>> 另開視窗
			</label>
		</div>
	</div>
	<!-- link -->

	<div class="form-group">
		<label class="col-sm-3 control-label">上線/下線日期</label>
		<div class="input-daterange input-group" id="datepicker">
		    <input type="text" class="input-sm form-control" name="on_time" value="<?=Arr::get($data, 'on_time', '')?>" placeholder="未填入表示不指定時間" />
		    <span class="input-group-addon">to</span>
		    <input type="text" class="input-sm form-control" name="off_time" value="<?=Arr::get($data, 'off_time', '')?>" placeholder="未填入表示不指定時間" />
		</div>
	</div>

	<!-- date -->

	<div class="form-group">
		<label class="col-sm-3 control-label" for="link">狀態</label>
		<div class="col-sm-5">
			<label class="radio-inline">
				<input type="radio" name="status" value="1" <?=(($status=Arr::get($data, 'status', null))=='1' || $status==null) ? 'checked="checked"' : ''?>>顯示
			</label>
			<label class="radio-inline">
				<input type="radio" name="status" value="0" <?=(Arr::get($data, 'status')=='0') ? 'checked="checked"' : ''?>>隱藏
			</label>
		</div>
	</div>
	<!-- status -->

	<div class="form-group">
		<button class="btn" type="button" onclick="history.back();">取消</button> <button class="btn btn-inverse btn-submit">編輯完成</button>
	</div>

	<input type="hidden" name="size" value="<?=$size['value']?>" />
	<input type="hidden" name="bid" value="<?=Arr::get($data, 'bid', 'null')?>" />
	<input type="hidden" name="imglist" value=""/>
</form>
@stop

@section('head')
	{{ HTML::style(asset('css/admin/banners/css_action.css')) }}
	{{ HTML::style(asset('packages/timepicker/css/datepicker.css')) }}
@stop

@section('bottom')
	{{ HTML::script('/packages/jquery-file-upload/js/vendor/jquery.ui.widget.js')}}
	{{ HTML::script('/packages/jquery-file-upload/js/jquery.iframe-transport.js')}}
	{{ HTML::script('/packages/jquery-file-upload/js/jquery.fileupload.js')}}
	{{ HTML::script('/packages/timepicker/js/bootstrap-datepicker.js')}}
	{{ HTML::script(asset('js/admin/banners/js_action.js')) }}
@stop