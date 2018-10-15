<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script>
    $(document).on("click", ".delete", function(){
var folder_name = $(this).data("name");
var action = "delete";
if(confirm("Are you sure you want to remove it?"))
{
$.ajax({
url:"action.php",
method:"POST",
data:{folder_name:folder_name, action:action},
success:function(data)
{
load_folder_list();
alert(data);
}
});
}
});
    </script>