<div class="container-fluid">
	<div class="row">
		<div class="col-md-9 col-md-offset-3 "> 
			<img id="preview" height="400"/>
		</div>
	</div>

	<form class="form-horizontal" action="/image/submit" enctype="multipart/form-data"  method="POST">

		<div class="form-group">
	    	<label class="col-md-3 control-label">File</label>
		    <div class="col-md-9">
		    	<input name="image_file" type="file" class="form-control"/>
		    </div>
		</div>


		<div class="form-group">
	    	<label class="col-md-3 control-label">Image URL</label>
		    <div class="col-md-9">
		    	<input id="image-url" name="image_url" value="<?=set_value('image_url')?>" type="text" class="form-control"/>
		    </div>
		</div>

		<div class="form-group">
	    	<label class="col-md-3 control-label">Source</label>
		    <div class="col-md-9">
		    	<input name="source" value="<?=set_value('source')?>" type="text" class="form-control"/>
		    </div>
		</div>

		<div class="form-group">
	    	<label class="col-md-3 control-label">Tags</label>
		    <div class="col-md-9">
		    	<textarea name="submitted_tags" type="text" class="form-control"/><?=set_value('submitted_tags')?></textarea>
		    </div>
		</div>

		<button type="submit" class="btn btn-default">Submit</button>

	</form>
</div>

<script>
	var previewImage = $('#preview');
	var imageUrl = $('#image-url');
	imageUrl.on('change',function(){
		previewImage.attr("src", imageUrl.val());
	});
</script>
