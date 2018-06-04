     <div class='spec_item' id='spec_{{$spec['id']}}' >
         <div style='border:1px solid #e7eaec;padding:10px;margin-bottom: 10px;' >
	<input name="spec_id[]" type="hidden" class="form-control spec_id" value="{{$spec['id']}}"/>
	<div class="form-group">
	<div class="col-sm-12">
			<div class='input-group'>
			<input name="spec_title[{{$spec['id']}}]" type="text" class="form-control  spec_title" value="{{$spec['title']}}" placeholder="规格名称 (比如: 颜色)"/>
			<div class='input-group-btn'>
			<a href="javascript:;" id="add-specitem-{{$spec['id']}}" specid="{{$spec['id']}}" class='btn btn-info add-specitem' onclick="addSpecItem('{{$spec['id']}}')" ><i class="fa fa-plus"></i> 添加规格项</a>
			<a href="javascript:void(0);" class='btn btn-danger' onclick="removeSpec('{{$spec['id']}}')"><i class="fa fa-remove"></i></a>
			</div>
			</div>

		</div>
	</div>
	<div class="form-group">
	<div class="col-md-12">
			<div id='spec_item_{{$spec['id']}}' class='spec_item_items'>
				@foreach($spec['items'] as $specitem)
					@include('admin.good.tpl.spec_item')
				@endforeach
			</div>
		</div>
	</div>  
   </div> 
</div>