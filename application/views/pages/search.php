<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2"> 
			<input type="text" id="tags" class="form-control">
		</div>
		<div class="col-md-2"> 
			<button class="btn" onclick="search()">Search</button>
		</div>
	</div>
	<div class="col-md-8 col-md-offset-2">
		<?php foreach ($tags as $tag):?>
			<a href="/gallery/view/<?=$tag['tag']?>"><?=$tag['tag']?> (<?=$tag['count']?>)</a>
		<?php endforeach;?>
	</div>
</div>

<script>
	var search = function(){
		var tags = $('#tags').val();
		window.open("/gallery/view/1/" + tags,"_self")
	}
</script>