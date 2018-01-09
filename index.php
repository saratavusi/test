<meta http-equiv="Content-Type"
      content="text/html;charset=utf-8"/>
<title>پورتال خبرنامه </title>
sara
<link rel="stylesheet" href="css/news.css">
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>

<script type="text/javascript">
    $(document).ready(function(){
        function loading_show(){
            $('#loading').html("<img src='img/loading.gif'/>").fadeIn('fast');
        }
        function loading_hide(){
            $('#loading').fadeOut('fast');
        }
        function loadData(page){
            loading_show();
            $.ajax
            ({
                type: "POST",
                url: "load_data.php",
                data: "page="+page,
                success: function(msg)
                {
                    $("#container").ajaxComplete(function(event, request, settings)
                    {
                        loading_hide();
                        $("#container").html(msg);
                    });
                }
            });
        }
        loadData(1);  // For first time page load default results
        $('#container .pagination li.active').live('click',function(){
            var page = $(this).attr('p');
            loadData(page);

        });
        $('#go_btn').live('click',function(){
            var page = parseInt($('.goto').val());
            var no_of_pages = parseInt($('.total').attr('a'));
            if(page != 0 && page <= no_of_pages){
                loadData(page);
            }else{
                alert('Enter a PAGE between 1 and '+no_of_pages);
                $('.goto').val("").focus();
                return false;
            }

        });
    });
</script>
<div class="header Byekan">
    <div class="logo">
        <img  style="float: right;margin-top: 5px;" src="img/logo1.png">

    </div>
</div>
<div class="main">
    <div id="container">
        <div class="data" ></div>
        <div class="pagination"></div>
    </div>

</div>

<?php

?>
