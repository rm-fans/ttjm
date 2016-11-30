<?php
/**
 * Created by PhpStorm.
 * User: thinkpad
 * Date: 2016/5/11
 * Time: 18:18
 */

?>
<script>
    $(document).ready(function(){
        var html = '<?php echo $content?>';
        showTips(html);
        <?php if($jumpUrl){?>
        setTimeout(function () {
            window.location.href='<?php echo $jumpUrl?>';
        }, 2000);
        <?php }?>
    })
</script>
