<div class="container">
	<h2>Result for: <?=$tags?></h2>

	<div class="paging">
	</div>

	<div id="gallery">
	</div>

	<div class="paging">
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="image-modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-body">
        <div class="row">
        	<a id="edit-button" class="btn btn-default">Edit</a>
        </div>
        <div class="row"><img width="800px" id="current-image"/></div>
      </div>
    </div>
  </div>
</div>

<script>

	var pageData;
	var tags = '<?=$tags?>';
	var currentPage = +'<?=$current_page?>';
	var currentImageIndex = 0;
	
	var imageIndex = 0;
	var openImmediately = false;

	var getData = function(){
		var success = function(data){
			var index = 0;
			data.images.forEach(function(image){
				image.index = index;
				index++;
			});
			pageData = data;
			renderPaging();
			renderGallery();
			if(openImmediately){
				openImmediately=false;
				showImage();
			}
		};
		var url = 'rest/gallery/view/' + tags + '/' + currentPage;
		util.getJson(url,success);
	}

	var setPage = function(page){
		currentPage = page;
		getData();
	}

	var renderPaging = function(){
		var paging = $('<div class="paging"></div>');
		for (var page = 1; page <= pageData.totalPages; page++){
			if(page==pageData.currentPage){
				paging.append('<span class="current-page">'+page+'</span>');				
			} else {
				paging.append('<a href="/gallery/view/'+tags+'/'+page+'">'+page+'</a>');			
			}
		}
		$('.paging').replaceWith(paging);
	}

	var renderGallery = function(){
		var gallery = $('<div id="gallery"></div>');
		pageData.images.forEach(function(image){
			var img = $('<img height="150" src="/static/collections/'+image.fileHash +  "." +  image.extension+'" />');
			img.on('click',showImage.bind(this,image.index));
			gallery.append(img);

		});
		$('#gallery').replaceWith(gallery);
	}

	var showImage = function(index){
		if(index){
			currentImageIndex = index;
		}

		var image = pageData.images[currentImageIndex];
		if(!$('#image-modal').is(':visible')){
			$('#image-modal').modal('show');
		}

		$('#current-image').attr('src','/static/collections/'+image.fileHash +  "." +  image.extension);
		$('#edit-button').attr('href','/image/view/'+ image.imageId);
	}

	window.onkeyup = function(e) {
    	var key = e.keyCode ? e.keyCode : e.which;
    	
    	//right
    	if(key==39){
    		if(currentImageIndex==49){
    			if(currentPage<pageData.totalPages){
	    			setPage(++currentPage);
	    			currentImageIndex = 0;
	    			openImmediately = true;
    			}
    		} else {
	    		currentImageIndex++;
	    		showImage();    			
    		}
    	}

    	if(key==37){
    		if(currentImageIndex==0){
    			if(currentPage>1){
    				setPage(--currentPage);
    				currentImageIndex = 49;
    				openImmediately = true;
    			}
    		} else {
	    		currentImageIndex--;
	    		showImage();
    		}
    	}
    }

    getData();

</script>