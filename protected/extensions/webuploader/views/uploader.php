<div class="input_image">
    <!--用来存放item-->
    <ul id="warp" class="warps">
        <?php if(isset($images) && !empty($images)){
            $i=0;
                foreach($images as $img){
            ?>
                <li id="<?php echo $img['id'];?>" class="file-item thumbnail">
                <img width="100",height="100" class="img_<?php echo $img['id']; ?>" src="<?php echo $img['src'];?>">
                    <input type='hidden' name='<?php echo $form_name;?>' value='<?php echo $img['src'];?>' />
                    <input type='hidden' name='<?php echo $form_ids;?>' value='<?php echo $img['id']."_2";?>' />
                    <span class="img_delete"  onclick="img_del('<?php echo $img['id'];?>',this)"></span>
                    <?php if($i==0){?>
                        <span class="cover"></span>
                    <?php }?>
                </li>
        <?php }}?>
    </ul>
    <div id="fileList" class="uploader-list"></div>
    <div id="filePicker">上传图片</div>
</div>

<script>
    // 初始化Web Uploader
    var uploader = WebUploader.create({
        // 选完文件后，是否自动上传。
        auto: true,
        // swf文件路径
        swf: '<?php echo $swf;?>',
        // 文件接收服务端。
        server: '<?php echo $uploadUrl;?>',
        // 选择文件的按钮。可选。
        // 内部根据当前运行是创建，可能是input元素，也可能是flash.
        pick: '#filePicker',
        // 只允许选择图片文件。
        accept: {
            title: 'Images',
            extensions: 'gif,jpg,jpeg,bmp,png',
            mimeTypes: 'image/*'
        }
    });
    var thumbnailWidth = 110;
    var thumbnailHeight = 110;
    var defaultFileCount= "<?php echo $file_count;?>";
    var fileCount= "<?php echo $file_count;?>";
    var cover = "<?php echo $cover;?>";

    // 当有文件添加进来的时候
    uploader.on( 'fileQueued', function( file ) {
        if(fileCount==0)
        {

            showTips("最多上传"+defaultFileCount);
            uploader.removeFile( file);
            return false;
        }
        var $li = $(
            '<li id="' + file.id + '" class="file-item thumbnail remove-this">' +
            '<img width="100",height="100" class="img_'+file.id+'">' +
            '</li>'
        ),
            $img = $li.find('img');


        // $list为容器jQuery实例
        //$list.append( $li );
        $("#warp").append( $li );

        // 创建缩略图
        // 如果为非图片文件，可以不用调用此方法。
        // thumbnailWidth x thumbnailHeight 为 100 x 100
        uploader.makeThumb( file, function( error, src ) {
            if ( error ) {
                $img.replaceWith('<span>不能预览</span>');
                return;
            }

            $img.attr( 'src', src );
        }, thumbnailWidth, thumbnailHeight );
    });
    // 文件上传过程中创建进度条实时显示。
    uploader.on( 'uploadProgress', function( file, percentage ) {
        var $li = $( '#'+file.id ),
            $percent = $li.find('.progress span');

        // 避免重复创建
        if ( !$percent.length ) {
            $percent = $('<p class="progress"><span></span></p>')
                .appendTo( $li )
                .find('span');
        }
        $percent.css( 'width', percentage * 100 + '%' );
    });
    // 文件上传成功，给item添加成功class, 用样式标记上传成功。
    uploader.on( 'uploadSuccess', function( file,response ) {
        fileCount--;
        $( '#'+file.id ).addClass('upload-state-done');
        var str = "<input type='hidden' name='<?php echo $form_name;?>' value='"+response.file_url+"' />";
        str += "<input type='hidden' name='<?php echo $form_ids;?>' value='"+response.id+"_1' />";
        str += '<span class="img_delete"  onclick="img_del(\''+response.id+'\',this)"></span>';
        if(cover==true)
        {
            if($('#warp>li').find('.cover').length==0)
            {
                str += '<span class="cover">封面</span>';
            }
        }

        $('#'+file.id).append(str);
        uploader.removeFile( file);
    });
    // 文件上传失败，显示上传出错。
    uploader.on( 'uploadError', function( file ) {
        var $li = $( '#'+file.id ),
            $error = $li.find('div.error');

        // 避免重复创建
        if ( !$error.length ) {
            $error = $('<div class="error"></div>').appendTo( $li );
        }
        howTips('上传失败');
        $error.text('上传失败');
    });

    // 完成上传完了，成功或者失败，先删除进度条。
    uploader.on( 'uploadComplete', function( file ) {
        $( '#'+file.id ).find('.progress').remove();
    });
    function img_del(id,obj)
    {
        fileCount++;
        $(obj).parent().remove();
        var s = $('#warp>li').find('.cover').length;
        if(cover==true) {
            if ($('#warp>li').find('.cover').length == 0) {
                $('#warp>li').eq(0).append('<span class="cover">封面</span>');
            }
        }

    }
</script>