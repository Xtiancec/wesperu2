<?php
//activamos almacenamiento en el buffer
require 'layout/header.php';
require 'layout/navbar.php';
require 'layout/sidebar.php';
?>

<div class="row">
    <div class="col-4">
        <h4>Seleccione el tema</h4>
        <div class="card">
            <div class="card-body">
                <div class="r-panel-body">
                    <ul id="themecolors" class="m-t-20">
                        <li><b>Con el sidebar claro</b></li>
                        <li><a (click)="changeTheme('default')" data-theme="default" class="selector default-theme">1</a></li>
                        <li><a (click)="changeTheme('green')" data-theme="green" class="selector green-theme">2</a></li>
                        <li><a (click)="changeTheme('red')" data-theme="red" class="selector red-theme">3</a></li>
                        <li><a (click)="changeTheme('blue')" data-theme="blue" class="selector blue-theme">4</a></li>
                        <li><a (click)="changeTheme('purple')" data-theme="purple" class="selector purple-theme">5</a></li>
                        <li><a (click)="changeTheme('megna')" data-theme="megna" class="selector megna-theme">6</a></li>

                        <li class="d-block m-t-30"><b>Con el sidebar oscuro</b></li>
                        <li><a (click)="changeTheme('default-dark')" data-theme="default-dark" class="selector default-dark-theme">7</a></li>
                        <li><a (click)="changeTheme('green-dark')" data-theme="green-dark" class="selector green-dark-theme">8</a></li>
                        <li><a (click)="changeTheme('red-dark')" data-theme="red-dark" class="selector red-dark-theme">9</a></li>
                        <li><a (click)="changeTheme('blue-dark')" data-theme="blue-dark" class="selector blue-dark-theme working">10</a></li>
                        <li><a (click)="changeTheme('purple-dark')" data-theme="purple-dark" class="selector purple-dark-theme">11</a></li>
                        <li><a (click)="changeTheme('megna-dark')" data-theme="megna-dark" class="selector megna-dark-theme">12</a></li>
                    </ul>

                </div>
            </div>
        </div>
    </div>
</div>

<?php
require 'layout/footer.php';
?>

