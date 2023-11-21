@extends('layout.wrapper') @section('content')
<div class="container-fluid">

    <div class="row page-titles">

    <!-- Page Title & Bread Crumbs -->
    @include('pages.conversations.misc.crumbs')
    <!--Page Title & Bread Crumbs -->

    </div>

    <div class="general d-flex m-0 p-0">
        <div class="izquierda col-10 row m-0 p-0">

            <div class="usuario col-12 m-0 p-0">
                <!--header chat -->
            <div class="header-conv">
                <div class="img-text-conv">
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
            </div>
            <!--header chat -->
            </div>

            <div class="conversacion-abierta col-12 m-0 p-0">
                <!--chat box -->
            <div class="chat-box-conv overflow-container">

                <div class="other-message-container d-flex">
                   <div class="userimg-conv">
                       <img src="public\images\Perfiles chat Chaman\Perfil 5.jpeg" class="cover">
                   </div>
                   <div class="message-conv other-message-conv pl-3">                                        
                        <p>Hola quería hacer un pedido, estoy buscando papel higiénico para mi fabrica? 🤔<br><span class="time-chat-act">3:59 PM</span></p>

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

            <div class="escribir-mensaje col-12 m-0 p-0">

                <!--chat input -->
                <div class="chatbox-input-conv">
                    <i class="sl-icon-emotsmile"></i>            
                    <input type="text" placeholder="Escribe algo...">
                    <i class="ti-image"></i>
                    <i class="ti-clip"></i>
                    <i class="sl-icon-microphone"></i>
                </div>
            </div>

        </div>



        <div class="derecha col-2 row m-0 p-0">

            <div class="buscar col-12 m-0 p-0">
                <!--barra de busqueda -->
         <div class="search-chat-conv">
            <div>
                <input type="text" placeholder="Buscar contactos">
                <i class="ti-search"></i>
            </div>
         </div>
          <!--barra de busqueda -->
            </div>

            <div class="contactos col-12 m-0 p-0">
                <!--listado de chats -->
          <div class="chatlist-conv overflow-container">
            <div class="block-conv">
                <div class="imgbox-conv">
                    <img src="public\images\Perfiles chat Chaman\Perfil 1.jpeg" class="cover">
                </div>
                <div class="details-conv">
                    <div class="list-head">
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
                    <div class="list-head">
                        <h7 class ="m-0">Carla Rodriguez</h7>
                        <p class="time-conv m-0 active-text">4:02 PM</p>
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
                    <div class="list-head">
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
                    <div class="list-head">
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
                    <div class="list-head">
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
                    <div class="list-head">
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
                    <div class="list-head">
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
                    <div class="list-head">
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
                    <div class="list-head">
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
                    <div class="list-head">
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
                <div class="list-head">
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



      
<!--main content -->
@endsection