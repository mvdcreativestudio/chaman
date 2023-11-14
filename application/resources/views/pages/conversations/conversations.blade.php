@extends('layout.wrapper') @section('content')
<!-- main content -->
<div class="container-fluid">

<div class="container-conv">
        <div class="left-side-conv"><h1>left side</h1></div>
        <div class="right-side-conv">
         <!--barra de busqueda -->
         <div class="search-chat-conv">
            <div>
                <input type="text" placeholder="Buscar contactos">
                <i class="ti-search"></i>
            </div>
         </div>
          <!--barra de busqueda -->
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
          
        
    </div>

</div>




    

      
<!--main content -->
@endsection