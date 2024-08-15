(function ($) {
  $(document).ready(function () {

	 /** summernote start */
    $(".summernote").summernote({
      lang: 'ko-KR',
      height: 300,
      dialogsInBody : true,
      // toolbar
      toolbar: [
        ['style', ['style']],
        ['font', ['bold', 'italic', 'underline', 'strikethrough', 'clear']],
        ['fontname', ['fontname']],
        ['fontsize', ['fontsize']],
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['table', ['table']],
        ['insert', ['link', 'picture', 'video']],
        ['view', ['fullscreen', 'codeview']],
        ['help', ['help']]
      ],
      callbacks : {
		  onImageUpload: function (files) {
				/** upload start */

				var maxSize = 10 * 1024 * 1024; // limit 1MB  
				// TODO: implements insert image
				var isMaxSize = false; 
				var maxFile = null;
				for (var i = 0; i < files.length; i++) {
				  if (files[i].size > maxSize) {
					isMaxSize = true;
					maxFile = files[i].name; 
					break;   
				  }
				  //sendFile(files[i], this);
				}

				if (isMaxSize) { // 사이즈 제한에 걸렸을 때 
				   alert('[' + maxFile + '] 파일이 업로드 용량(10MB)을 초과하였습니다.');
				} else {
					for(var i = 0; i < files.length; i++) {
						sendFile(files[i], this);
					}
				}
			/** upload end */
		  }
	  }
    });

     /** summernote end */ 
  });
})(jQuery);
