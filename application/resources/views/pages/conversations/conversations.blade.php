@extends('layout.wrapper') @section('content')
<div class="container-fluid">

    <div class="row page-titles">

    <!-- Page Title & Bread Crumbs -->
    @include('pages.conversations.misc.crumbs')
    <!--Page Title & Bread Crumbs -->

    </div>

    <div class="general d-flex flex-column flex-lg-row m-0 p-0">
        <div class="izquierda col-xl-9 col-lg-8 m-0 p-0 d-none d-lg-block" id="columnaIzquierda">

            <div class="m-0 p-0">
                <!--header chat -->
            <div class="header-conv">
                <div class="img-text-conv">
                    <!-- Flecha de volver visible solo en dispositivos móviles -->
                    <div class="flecha-volver d-lg-none" style="cursor: pointer;">
                       <i class="ti-arrow-left"></i>
                    </div>
                    <div class="userimg-conv">
                        <img src="public\images\Perfiles chat Chaman\Perfil 5.jpeg" class="cover">
                    </div>
                    <h4>Carla Rodriguez</h4>
                </div>
                <ul class="nav-icons-conv">
                    <li><i class="sl-icon-phone"></i></li>
                    <li><i class="sl-icon-camrecorder"></i></li>
                    <li><i class="sl-icon-options-vertical"></i></li>
                </ul>


                <div class="dropdown-content">
                      
                   <div class="row" style="width: 25%;">
                      <div class="col">
                         <div class="avatar-dropdown">
                            <div class="userimg-drop"><img src="public\images\Perfiles chat Chaman\Perfil 5.jpeg"></div>
                            <h4>Carla Rodriguez</h4>
                            <h5>Administracion Disco</h5>                         
                         </div>
                         
                      </div>
                   </div>

                    <div class="row" style="width: 25%;">
                      <div class="col">
                        <div class="info-dropwdown">
                            <h4>INFORMATION</h4>

                            <ul class="icons-drop">
                                <li><i class="ti-location-pin"></i><h5>Blanes 1133</h5></li>
                                <li><i class="sl-icon-phone"></i><h5>096 780 853</h5></li>
                                <li><i class="ti-email"></i><h5>rod.car@disco.com</h5></li>
                            </ul>

                        </div>
                      </div>
                   </div>

                   <div class="row" style="width: 60%;">

                   
    <div class="col">
        <div class="archivos-drop">
            <h4>ARCHIVOS</h4>

            <div class="files-drop row">
                <!-- Primer archivo -->
                <div class="col-md-6">
                    <div class="files-block">
                        <img src="public\images\Perfiles chat Chaman\ARCHIVO 1.jpg">
                        <div class="files-detail">
                            <h6>diseño2.jpg</h6>
                            <h7>04 Aug 2022 2:00 PM</h7>
                        </div>
                    </div>
                </div>

                <!-- Segundo archivo -->
                <div class="col-md-6">
                    <div class="files-block">
                        <img src="public\images\Perfiles chat Chaman\ARCHIVO 2.jpg">
                        <div class="files-detail">
                            <h6>diseño 1.png</h6>
                            <h7>03 Aug 2022 1:00 PM</h7>
                        </div>
                    </div>
                </div>

                <!-- Tercer archivo -->
                <div class="col-md-6">
                    <div class="files-block">
                        <img src="public\images\Perfiles chat Chaman\ARCHIVO 3.png">
                        <div class="files-detail">
                            <h6>audio2.mp3</h6>
                            <h7>22 Jul 2022 1:00 AM</h7>
                        </div>
                    </div>
                </div>

                <!-- Cuarto archivo -->
                <div class="col-md-6">
                    <div class="files-block">
                        <img src="public\images\Perfiles chat Chaman\ARCHIVO 4.png">
                        <div class="files-detail">
                            <h6>archivo5.rar</h6>
                            <h7>22 Jul 2022 1:00 AM</h7>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
                </div>


            </div>
            <!--header chat -->
            </div>

            <div class="conversacion-abierta m-0 p-0">
                <!--chat box -->
            <div class="chat-box-conv overflow-container">

                <div class="other-message-container d-flex">
                   <div class="userimg-conv">
                       <img src="public\images\Perfiles chat Chaman\Perfil 5.jpeg" class="cover">
                   </div>
                   <div class="message-conv other-message-conv pl-3">                                        
                        <p>Hola quería hacer un pedido, estoy buscando papel higiénico para mi fabrica? 🤔<br><span class="time-chat-act">4:00 PM</span></p>
                   </div>
                </div> 
                   
               
               <div class="message-conv my-message-conv">
                   <p>Carla, Cómo estas? Sí claro, te puedo ofrecer 24 rollos, 36 rollos, 50 rollos. De marca Elite<br><span class="time-chat-act">4:00 PM</span></p>
               </div>


               <div class="other-message-container d-flex">
                   <div class="userimg-conv">
                       <img src="public\images\Perfiles chat Chaman\Perfil 5.jpeg" class="cover">
                   </div>
                   <div class="message-conv other-message-conv pl-3">                                        
                        <p>Mandame 24, porfavor 😃<br><span class="time-chat-act">4:02 PM</span></p>
                   </div>
                </div>
               
                <div class="other-message-container d-flex">
                    <div class="userimg-conv">
                        <img src="public\images\Perfiles chat Chaman\Perfil 5.jpeg" class="cover">
                    </div>
                    <div class="message-conv other-message-conv message-img pl-3"> 
                        <p><img class="imagen-conv" src="public\images\Imagenes chat Chaman\Pago-realizado.png" alt=""><br><span class="time-chat-act">4:02 PM</span></p>                                       

                    </div>
                 </div>
                 
               
           </div>
           
           <!--chat box -->
            </div>

            <div class="escribir-mensaje m-0 p-0">

                <!--chat input -->
                <div class="chatbox-input-conv">
                    <i class="sl-icon-emotsmile"></i>            
                    <input type="text" placeholder="Escribe algo...">
                    <button class="send-button d-lg-block d-none" onclick="">Enviar</button>
                    <i class="ti-control-play d-lg-none"></i>                    
                    <i class="ti-image"></i>
                    <i class="ti-clip"></i>
                    <i class="sl-icon-microphone"></i>
                </div>
            </div>

        </div>



        <div class="derecha col-xl-3 col-lg-4 m-0 p-0">

            <div class="buscar m-0 p-0">
                <!--barra de busqueda -->
         <div class="search-chat-conv">
            <div>
                <input type="text" class="searchPlaceHolder" placeholder="Buscar contactos">
                <i class="ti-search"></i>
            </div>
         </div>
          <!--barra de busqueda -->
            </div>

            <div class="contactos m-0 p-0">
                <!--listado de chats -->
          <div class="chatlist-conv overflow-container">
            <div class="block-conv">
                <div class="imgbox-conv">
                    <img src="public\images\Perfiles chat Chaman\Perfil 1.jpeg" class="cover">
                </div>
                <div class="details-conv">
                    <div class="list-head m-0">
                        <h7 class ="m-0">Romina Simón</h7>
                        <p class="time-conv m-0">4:12 PM</p>
                    </div>
                    <div class="message-p">
                        <p>Tú: Listo te mando</p>
                    </div>
                </div>
            </div>
            <div class="block-conv active">
                <div class="imgbox-conv">
                    <img src="public\images\Perfiles chat Chaman\Perfil 5.jpeg" class="cover">
                </div>
                <div class="details-conv">
                    <div class="list-head m-0">
                        <h7 class ="m-0">Carla Rodriguez</h7>
                        <p class="time-conv m-0">4:02 PM</p>
                    </div>
                    <div class="message-p">
                        <p class="active-text"><i class="ti-image"></i> Imagen</p>
                    </div>
                </div>
            </div>
            <div class="block-conv">
                <div class="imgbox-conv">
                    <img src="public\images\Perfiles chat Chaman\Perfil 2.jpeg" class="cover">
                </div>
                <div class="details-conv">
                    <div class="list-head m-0">
                        <h7 class ="m-0">Lucas Obrien</h7>
                        <p class="time-conv m-0">1 hora</p>
                    </div>
                    <div class="message-p">
                        <p>Necesito 5 litros de limpiador Floral y 5 litros de limpador Armonia</p>
                        <b>1</b>
                    </div>
                </div>
            </div>
            <div class="block-conv">
                <div class="imgbox-conv">
                    <img src="public\images\Perfiles chat Chaman\Perfil 3.jpeg" class="cover">
                </div>
                <div class="details-conv">
                    <div class="list-head m-0">
                        <h7 class ="m-0">Roberto Masla</h7>
                        <p class="time-conv m-0">10 Horas</p>
                    </div>
                    <div class="message-p">
                        <p>Me quedé sin internet</p>
                    </div>
                </div>
          </div>
          <div class="block-conv">
                <div class="imgbox-conv">
                    <img src="public\images\Perfiles chat Chaman\Perfil 4.jpeg" class="cover">
                </div>
                <div class="details-conv">
                    <div class="list-head m-0">
                        <h7 class ="m-0">Fabiana Rial</h7>
                        <p class="time-conv m-0">3 días</p>
                    </div>
                    <div class="message-p">
                        <p>Podemos repetir el pedido de la otra vez por favor?</p>
                        <b>1</b>
                    </div>
                </div>
            </div>
            <div class="block-conv">
                <div class="imgbox-conv">
                    <img src="public\images\Perfiles chat Chaman\Perfil 6.jpeg" class="cover">
                </div>
                <div class="details-conv">
                    <div class="list-head m-0">
                        <h7 class ="m-0">Miguel Rodri</h7>
                        <p class="time-conv m-0">10 dias</p>
                    </div>
                    <div class="message-p">
                        <p>Gracias, hablamos mas tarde</p>
                    </div>
                </div>
          </div>
          <div class="block-conv">
                <div class="imgbox-conv">
                    <img src="public\images\Perfiles chat Chaman\Perfil 7.jpeg" class="cover">
                </div>
                <div class="details-conv">
                    <div class="list-head m-0">
                        <h7 class ="m-0">Cristina Stanley</h7>
                        <p class="time-conv m-0">10 días</p>
                    </div>
                    <div class="message-p">
                        <p>Che me pasas el papel?</p>
                    </div>
                </div>
          </div>
          <div class="block-conv">
                <div class="imgbox-conv">
                    <img src="public\images\Perfiles chat Chaman\Perfil 8.jpeg" class="cover">
                </div>
                <div class="details-conv">
                    <div class="list-head m-0">
                        <h7 class ="m-0">Nahuel Noble</h7>
                        <p class="time-conv m-0">11 días</p>
                    </div>
                    <div class="message-p">
                        <p>Quería pedir jabon de mano Elite perlado Herbal</p>
                    </div>
                </div>
          </div>
          <div class="block-conv">
                <div class="imgbox-conv">
                    <img src="public\images\Perfiles chat Chaman\Perfil 9.jpeg" class="cover">
                </div>
                <div class="details-conv">
                    <div class="list-head m-0">
                        <h7 class ="m-0">Juan Perez</h7>
                        <p class="time-conv m-0">13 días</p>
                    </div>
                    <div class="message-p">
                        <p>Me llamás ahora porfa.</p>
                    </div>
                </div>
          </div>
          <div class="block-conv">
                <div class="imgbox-conv">
                    <img src="public\images\Perfiles chat Chaman\Perfil 10.jpeg" class="cover">
                </div>
                <div class="details-conv">
                    <div class="list-head m-0">
                        <h7 class ="strong m-0">Gerardo Carlo</h7>
                        <p class="time-conv m-0">14 días</p>
                    </div>
                    <div class="message-p">
                        <p>Necesitamos que venga ya, cuanto calculas de demora?</p>
                    </div>
                </div>
          </div>
        <div class="block-conv">
            <div class="imgbox-conv">
                <img src="public\images\Perfiles chat Chaman\Perfil 10.jpeg" class="cover">
            </div>
            <div class="details-conv">
                <div class="list-head m-0">
                    <h7 class="m-0">Gerardo Carlo</h7>
                    <p class="time-conv">14 días</p>
                </div>
                <div class="message-p">
                    <p>Necesitamos que venga ya, cuanto calculas de demora?</p>
                </div>
            </div>
        </div>
          
          <!--listado de chats -->
            </div>

        </div>
    </div>
</div>


<!-- Asegúrate de incluir jQuery -->
<script>
$(document).ready(function() {
    $('.block-conv').on('click', function() {
        // Remueve la clase "active" de todas las instancias de "block-conv"
        $('.block-conv').removeClass('active');
        
        // Agrega la clase "active" solo al elemento clicado
        $(this).addClass('active');
        
        // Verifica si la pantalla es de tamaño móvil
        if ($(window).width() < 992) {
            // Oculta la columna derecha
            $('.derecha').addClass('d-none');
            // Muestra la columna izquierda
            $('.izquierda').removeClass('d-none');
            // Muestra la flecha de volver solo en dispositivos móviles
            $('.flecha-volver').removeClass('d-none');
        }
        
        // Oculta la dropdown-content cuando se hace clic en un elemento de la lista de chats
        $('.dropdown-content').removeClass('visible');
    });

    // Agrega un controlador de clic para la flecha de volver
    $('.flecha-volver').on('click', function() {
        // Oculta la columna izquierda
        $('.izquierda').addClass('d-none');
        // Muestra la columna derecha
        $('.derecha').removeClass('d-none');
        // Oculta la flecha de volver
        $(this).addClass('d-none');
        
        // Remueve la clase "active" al volver a la vista principal en móviles
        $('.block-conv').removeClass('active');
    });

    // Agrega un controlador de clic para la clase header-conv
    $('.header-conv').on('click', function() {
        // Toggle (alternar) la visibilidad de la dropdown-content
        $('.dropdown-content').toggleClass('visible');
    });
});
</script>


      
<!--main content -->
@endsection