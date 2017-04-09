<div class="container">
	<h2>Result for: <?=$tags?></h2>
	<div class="paging">
	</div>
	<div id="gallery">
		<?php foreach ($images as $image):?>
			<a href="/image/view/<?=$image['image_id']?>"><img height="150" src="/static/collections/<?=urlencode($image['file_name'])?>"/></a>
		<?php endforeach;?>
	</div>

	<div class="paging">
	</div>
</div>

<script>
	var totalPages = '<?=$total_pages?>';
	var tags = '<?=$tags?>';
	var currentPage = '<?=$current_page?>';

	var paging = $('<div class="paging"></div>');
	for (var page = 1; page <= totalPages; page++){
		if(page==currentPage){
			paging.append('<span class="current-page">'+page+'</span>');				
		} else {
			paging.append('<a href="/gallery/view/'+page+'/'+tags+'">'+page+'</a>');			
		}
	}
	$('.paging').replaceWith(paging);
	
	//img link


/*

	var images = $('#gallery img');
	images.each(function(index, image){
		image = $(image);
		var height = image.height();
		var width = image.width();
		var longestDimension = Math.max(height, width);
		
		image.height(height/longestDimension*200);
		image.width(width/longestDimension*200);
	});


*/
</script>