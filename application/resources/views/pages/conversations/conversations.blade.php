@extends('layout.wrapper') @section('content')
<!-- main content -->
<div class="container-fluid">

<div class="container-conv">
        <div class="left-side-conv">
            <!--header chat -->
            <div class="header-conv">
                <div class="img-text-conv">
                    <div class="userimg-conv">
                        <img src="public\images\Perfiles chat Chaman\Perfil 5.jpeg" class="cover">
                    </div>
                    <h4>Carla Rodriguez<br><span>online</span></h4>
                </div>
                <ul class="nav-icons-conv">
                    <li><i class="sl-icon-phone"></i></li>
                    <li><i class="sl-icon-camrecorder"></i></li>
                    <li><i class="sl-icon-options-vertical"></i></li>
                </ul>
            </div>
            <!--header chat -->

            <!--chat box -->
            <div class="chat-box-conv">

                 <div class="other-message-container">
                    <div class="userimg-conv">
                        <img src="public\images\Perfiles chat Chaman\Perfil 5.jpeg" class="cover">
                    </div>
                    <div class="message-conv other-message-conv">                                        
                         <p>Hola quería hacer un pedido, estoy buscando papel higiénico para mi fabrica? 🤔</p>
                    </div>
                 </div>   
                    
                
                <div class="message-conv my-message-conv">
                    <p>Carla, Cómo estas? Sí claro, te puedo ofrecer 24 rollos, 36 rollos, 50 rollos. De marca Elite</p>
                </div>
                <div class="other-message-container">
                    <div class="userimg-conv">
                        <img src="public\images\Perfiles chat Chaman\Perfil 5.jpeg" class="cover">
                    </div>
                    <div class="message-conv other-message-conv">                                        
                         <p>Mandame 24, porfavor 😃</p>
                    </div>
                 </div>
                 
                
            </div>
            <!--chat box -->

            <!--chat input -->
            <div class="chatbox-input-conv">
            <i class="sl-icon-emotsmile"></i>            
            <input type="text" placeholder="Escribe algo...">
            <i class="ti-image"></i>
            <i class="ti-clip"></i>
            <i class="sl-icon-microphone"></i>

            </div>

        </div>
        
        <div class="right-side-conv">

         <!--barra de busqueda -->
         <div class="search-chat-conv">
            <div>
                <input type="text" placeholder="Buscar contactos">
                <i class="ti-search"></i>
            </div>
         </div>
          <!--barra de busqueda -->

          <!--listado de chats -->
          <div class="chatlist-conv">
            <div class="block-conv">
                <div class="imgbox-conv">
                    <img src="public\images\Perfiles chat Chaman\Perfil 1.jpeg" class="cover">
                </div>
                <div class="details-conv">
                    <div class="list-head">
                        <h4>Romina Simón</h4>
                        <p class="time-conv">4:12 PM</p>
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
                        <h4>Carla Rodriguez</h4>
                        <p class="time-conv">4:02 PM</p>
                    </div>
                    <div class="message-p">
                        <p><i class="ti-image"></i> Imagen</p>
                    </div>
                </div>
            </div>
            <div class="block-conv unread">
                <div class="imgbox-conv">
                    <img src="public\images\Perfiles chat Chaman\Perfil 2.jpeg" class="cover">
                </div>
                <div class="details-conv">
                    <div class="list-head">
                        <h4>Lucas Obrien</h4>
                        <p class="time-conv">1 hora</p>
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
                        <h4>Roberto Masla</h4>
                        <p class="time-conv">10 Horas</p>
                    </div>
                    <div class="message-p">
                        <p>Me quedé sin internet</p>
                    </div>
                </div>
          </div>
          <div class="block-conv unread">
                <div class="imgbox-conv">
                    <img src="public\images\Perfiles chat Chaman\Perfil 4.jpeg" class="cover">
                </div>
                <div class="details-conv">
                    <div class="list-head">
                        <h4>Fabiana Rial</h4>
                        <p class="time-conv">3 días</p>
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
                        <h4>Miguel Rodri</h4>
                        <p class="time-conv">10 dias</p>
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
                        <h4>Cristina Stanley</h4>
                        <p class="time-conv">10 días</p>
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
                        <h4>Nahuel Noble</h4>
                        <p class="time-conv">11 días</p>
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
                        <h4>Juan Perez</h4>
                        <p class="time-conv">13 días</p>
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
                        <h4>Gerardo Carlo</h4>
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




    

      
<!--main content -->
@endsection