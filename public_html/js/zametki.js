 <script src="https://code.jquery.com/jquery-3.0.0.min.js"> </script>
  <script type="text/javascript">
    // Назначить обработчики события click
    // после загрузки документа
    $(document).ready(function(){
      $("#submit-id").on("click", function(){
        // Проверяем корректность заполнения полей
        if($.trim($("#nickname").val()) === "")
        {
          alert('Пожалуйста заполните поле "Автор"');
          return false;
        }
        if($.trim($("#content").val()) === "")
        {
          alert('Пожалуйста заполните поле "Сообщение"');
          return false;
        }
        // Блокируем кнопку отправки
        $("#submit-id").prop("disabled", true);
        // AJAX-запрос
        $.ajax({
          url: "index.php",
          method: 'post',
          data: {nickname: $("#nickname").val(),
                 content: $("#content").val()}
        }).done(function(data){
          // Успешное получение ответа
          $("#info").html(data);
          $("#submit-id").prop("disabled", false);
        });
      })
    });
  </script>