<!DOCTYPE html>
<html>
<head>
<meta charset=utf-8 />
<title>Image preview</title>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js">    
</script>
<script type="text/javascript" src="//code.jquery.com/jquery-1.9.1.js"> 
</script>
<script>
    var blank="http://upload.wikimedia.org/wikipedia/commons/c/c0/Blank.gif";
</script>
<!--[if IE]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<script type="text/javascript">//<![CDATA[ 
$(window).load(function(){
    $('input[type="file"]').change(function () {
       if ($(this).val() !== "") {
        var file = $('#file_select')[0].files[0];
        console.log(file.size);
        //console.log(file.width);
        var reader = new FileReader();
        var img = new Image();
        var _URL = window.URL || window.webkitURL;
        reader.readAsDataURL(file);
        reader.onload = function(_file) {
            // Create a container for image and span X
            $imageItem = $('<div>').addClass('imageItem');
            $(img).appendTo($imageItem);
            $('<span>').html('x').addClass('remover').appendTo($imageItem);
            img.src= _file.target.result;

            // Append the container to panel
            $('#previewPane').append($imageItem);
            //console.log(img.src);
            console.log(img.width);
        } 
    }

    // Deletegate for dynamically created span, so we don't have to register a
    // new event listener each time a new imageContainer is created.
    $('#previewPane').on('click', '.remover', function() {
        $this = $(this);
        $this.parent('.imageItem').remove();
    });
});
});//]]>

</script>
<style>
article, aside, figure, footer, header, hgroup,
    menu, nav, section { display: block; }
    #x { display:none; position:relative; z-index:200; float:right}
    #previewPane { display: inline-block; }
</style>
</head>
<body>
<section>
<input type='file' name="file" id="file_select"/>   
<br/>
<span id="previewPane">
</span>
</section>
</body>
</html>