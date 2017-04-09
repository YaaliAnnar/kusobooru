<div class="container">
	<div class="row">
		<div class="col-md-3">
			<ul>
				<?php foreach (explode(' ', $tags) as $tag):?>
					<li><a href="/gallery/view/1/<?=$tag?>"><?=$tag?></a></li>
				<?php endforeach;?>
			</ul>
			<form method="POST" action="/image/edit_tags">
					<input name="image_id" type="hidden" value="<?=$image_data['image_id']?>"></input>
					<div class="form-group">
						<textarea rows="10" name="submitted_tags" class="form-control"><?=$tags?></textarea>
					</div>
					<button type="submit" class="btn btn-default">Submit</button>
			</form>	
			<form action="/image/delete/<?=$image_data['image_id']?>">
			    <button type="submit" class="btn btn-default">Delete</button>
			</form>
		</div>
		<div class="col-md-9">
			<img width="800px" src="/static/collections/<?=$image_data['file_name']?>"/>
			<form method="POST" action="update">
				<input name="image_id" type="hidden" value="<?=$image_data['image_id']?>"></input>
			</form>
		</div>
  </div>
</div>