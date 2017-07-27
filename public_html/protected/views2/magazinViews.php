
 
 <div id="magazin">


        

            <div id="container">
                <ul id="nav">
                    <li><a href="?gorod">Назад</a></li>
                    <li><a href="?magazin&ruka=1">Левая Рука</a></li>
                    <li><a href="?magazin&ruka=2">Правая Рука</a></li>
                    <li><a href="#">Артифакт</a></li>
                    <li><a href="#">Зелье</a></li>
                </ul>
            </div>



       <!-- <form method="post" action="index.php"></form> -->
        <div id="spisok-inv">

            <ol id="ol" class="rounded-list2">

               <?php if (isset($_GET['ruka'])){
                new magazin($_GET['ruka']);
               } ?>
            </ol>

        </div>

</div>