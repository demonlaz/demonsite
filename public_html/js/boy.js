//выводит содержимое чата каждые 1.5 сек
setInterval(function(){
   
 $("#boy-res").load("/protected/connect/vivod_boy.php");
     
  
$.ajax({
          url: "/protected/connect/vivodComentov.php", 
          method: 'post',
          data: {nick:$("#user").val() }
        }).done(function(data){
          // Успешное получение ответа
          $("#info2").html(data);        
        });
        
        
        
       //$("#xp-igroka-h2").load("/protected/connect/AjaxHPIgrok.php"); 
       // $("#xp-vragg").load("/protected/connect/AjaxXPVrag.php"); 
        
        
 
},2000);

    // Назначить обработчики события click
    // после загрузки документа
    //реагирует на нажатия кнопки и дабавляет сообшеие в чат
    $(document).ready(function(){
      
        //чат после загрузки
        $.ajax({
          url: "/protected/connect/vivodComentov.php", 
          method: 'post',
          data: {nick:$("#user").val() }
        }).done(function(data){
          // Успешное получение ответа
          $("#info2").html(data);
          
        });
        $("#boy-res").load("/protected/connect/vivod_boy.php");
               $("#xp-igroka-h2").load("/protected/connect/AjaxHPIgrok.php"); 
       $("#xp-vragg").load("/protected/connect/AjaxXPVrag.php"); 
        
        

        
      $("#submit-id").on("click", function(){
        // Проверяем корректность заполнения полей

        if($.trim($("#content").val()) === "")
        {
          alert('Пожалуйста заполните поле "Сообщение"');
          return false;
        }
        // Блокируем кнопку отправки
        $("#submit-id").prop("disabled", true);
        // AJAX-запрос
        $.ajax({
          url: "/protected/connect/comentBD.php",
          method: 'post',
          data: {content: $("#content").val()}
        }).done(function(data){
          // Успешное получение ответа
          
          $("#submit-id").prop("disabled", false);
          $('#content').val('');
        });
      })
      
      
      
      
      
      
      
      
    });
 

//перезагружает страницу
setTimeout(function(){
    location.reload();
}, 300000);
//подгружает список онлайн
			setInterval(function(){
			$("#onlain-spisok").load("/protected/connect/spisok-onlain.php");
			},15000);
           
            //реагирует на нажатия Enter и дабавляет сообшеие в чат
            $(document).ready(function() {
               
                setInterval(function(){
               
                $("#energ2").load("/protected/connect/xpRost.php");
               

			
			},61000);
               
            setInterval(function(){
                
                 var zna4en= $("#energ2").html();
                    
                $("#energ").width(zna4en);
               },1000);
               
               
                $('#content').keyup(function(e) {
            if(e.which == 13) {
                if($.trim($("#content").val()) === "")
        {
          alert('Пожалуйста заполните поле "Сообщение"');
          return false;
        }
        // Блокируем кнопку отправки
        $("#submit-id").prop("disabled", true);
        // AJAX-запрос
        $.ajax({
          url: "/protected/connect/comentBD.php",
          method: 'post',
          data: {content: $("#content").val()}
        }).done(function(data){
          // Успешное получение ответа
          
          $("#submit-id").prop("disabled", false);
          $('#content').val('');
        }); 
               
            }
        });
   });