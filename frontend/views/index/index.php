<!DOCTYPE html >
<html >
<head>
    <meta charset="utf-8" />
    <style>
        body{
            margin:0;
            padding:0;
            font-size:12px;
        }
        #messagewindow {
            height: 250px;
            border: 1px solid;
            padding: 5px;
            overflow: auto;
        }
        #wrapper {
            margin: auto;
            width: 438px;
        }
    </style>
</head>
<body>

<div id="wrapper">
    <p id="messagewindow"><span id="loading">加载中...</span></p>
    <form id="chatform" action="#">
        姓名： <input type="text" id="author" size="50"/><br />
        内容： <input type="text" id="msg"  size="50"/>   <br />
        <input type="button" class="send" value="发送" /><br />
    </form>
</div>

</body>
</html>
<script>
    $(function(){
        $(".send").click(function(){
            var params = {
                author:$('#author').val(),
                msg:$('#msg').val()
            };
            $.ajax({
                url:'index/index',
                type:"post",
                data:params,
                 dataType:"json",
                 success:function(data){

                }
            })
        })
    });

</script>