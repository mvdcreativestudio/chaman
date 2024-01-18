@extends('layout.wrapper')

@section('content')
<div class="container-fluid">
    <div class="row page-titles">
        <!-- Page Title & Bread Crumbs -->
        @include('pages.conversations.misc.crumbs')
    </div>

    <div class="general d-flex m-0 p-0">
        <!-- Sección Izquierda: Conversación Actual -->
        <div class="izquierda col-12 col-lg-10 col-md-12 row m-0 p-0 d-none d-lg-block">
            <!-- Encabezado del Chat Actual -->
            <div class="usuario col-12 m-0 p-0">
                <div class="header-conv">
                    <div class="img-text-conv">
                        <div class="userimg-conv">
                            <!-- La imagen se actualizará dinámicamente -->
                            <img id="chatImage" src="{{ asset('public/images/defaultuser.webp') }}" class="cover">
                        </div>
                        <!-- El nombre del contacto se actualizará dinámicamente -->
                        <h4 id="chatWith">Selecciona un chat</h4>
                    </div>
                    <ul class="nav-icons-conv">
                        <li><i class="sl-icon-phone"></i></li>
                        <li><i class="sl-icon-camrecorder"></i></li>
                        <li><i class="sl-icon-options-vertical"></i></li>
                    </ul>
                </div>
            </div>


            <!-- Caja de Conversación -->
            <div class="conversacion-abierta col-12 m-0 p-0">
                <div id="chatBox" class="chat-box-conv overflow-container">
                    <!-- Mensajes del chat seleccionado se cargarán aquí -->
                </div>
            </div>

            <!-- Entrada de Mensajes -->
            <div class="escribir-mensaje col-12 m-0 p-0">
                <div class="chatbox-input-conv">
                    <i class="sl-icon-emotsmile"></i>
                    <input id="messageInput" type="text" placeholder="Escribe algo...">
                    <button class="send-button" onclick="sendMessage()">Enviar</button>

                    <!-- Botones para multimedia -->
                    <input type="file" id="mediaInput" style="display: none;" onchange="sendMediaMessage()">
                    <i class="ti-image" onclick="$('#mediaInput').attr('accept', 'image/*').click();"></i>
                    <i class="ti-clip" onclick="$('#mediaInput').attr('accept', 'application/*').click();"></i>
                    <i class="sl-icon-microphone" onclick="$('#mediaInput').attr('accept', 'audio/*').click();"></i>
                </div>
            </div>
        </div>

        <!-- Listado de Chats -->
        <div class="contactos col-12 m-0 p-0">
            <div class="chatlist-conv overflow-container">
                @foreach ($chats as $chat)
                    <div class="block-conv" onclick="onChatSelected('{{ $chat->sender->id }}', '{{ $chat->sender->phone_number_owner }}')">
                        <div class="imgbox-conv">
                            <img src="{{ asset('public/images/defaultuser.webp') }}" class="cover">
                        </div>
                        <div class="details-conv">
                            <div class="list-head">
                                <h7 class="m-0">{{ $chat->sender->phone_number_owner }}</h7>
                                <p class="time-conv m-0">{{ $chat->message_created }}</p>
                            </div>
                            <div class="message-p">
                                @php
                                    $messagePreview = '';
                                    switch ($chat->message_type) {
                                        case 'image':
                                            $messagePreview = '📷 ' . ($chat->message_text ?: 'Imagen');
                                            break;
                                        case 'audio':
                                            $messagePreview = '🔊 ' . ($chat->message_text ?: 'Audio');
                                            break;
                                        case 'document':
                                            $messagePreview = '📄 ' . ($chat->message_text ?: 'Archivo');
                                            break;
                                        case 'video':
                                            $messagePreview = '🎥 ' . ($chat->message_text ?: 'Video');
                                            break;
                                        case 'sticker':
                                            $messagePreview = '🌟 ' . ($chat->message_text ?: 'Sticker');
                                            break;
                                        default:
                                            $messagePreview = $chat->message_text;
                                    }
                                @endphp
                                <p>{{ $messagePreview }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
</div>

<style>
    /* Estilo general para la caja de chat */
    .chat-box-conv {
        padding: 15px;
        background-color: #f9f9f9;
        min-height: 300px;
        overflow-y: auto;
    }

    /* Estilos para tus mensajes */
    .my-message {
        display: flex;
        justify-content: flex-end;
        margin-bottom: 10px;
    }

    .my-message span {
        max-width: 60%;
        background-color: #DCF8C6;
        padding: 10px;
        border-radius: 10px;
        box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
    }

    /* Estilos para mensajes de la otra persona */
    .other-message {
        display: flex;
        justify-content: flex-start;
        margin-bottom: 10px;
    }

    .other-message span {
        max-width: 60%;
        background-color: #ffffff;
        padding: 10px;
        border-radius: 10px;
        box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
    }

    /* Estilo para la hora del mensaje */
    .message-time {
        font-size: 0.75em;
        color: #666;
        margin-left: 5px;
        margin-right: 5px;
        align-self: flex-end;
    }

    /* Estilo para separadores de fecha */
    .date-separator {
        text-align: center;
        margin: 20px 0;
        color: #999;
    }
</style>


<script>
    function getCurrentChatId() {
        return $('#chatBox').data('active-chat');
    }

    function formatDate(date) {
        // Formatea la fecha según tus requisitos
        return date.toLocaleDateString();
    }

    function formatTime(date) {
        // Formatea la hora para mostrar solo horas y minutos
        return date.getHours().toString().padStart(2, '0') + ':' + 
            date.getMinutes().toString().padStart(2, '0');
    }

    function loadChatMessages(phoneNumber, contactName) {
        $.ajax({
            url: '{{ route('conversations.messages') }}',
            method: 'GET',
            data: { phone_number: phoneNumber },
            success: function(response) {
                var chatBox = $('#chatBox');
                chatBox.html('');
                var currentDate = '';
                response.messages.forEach(function(message) {
                    var messageDate = new Date(message.message_created);
                    var messageDateString = formatDate(messageDate);

                    if (currentDate !== messageDateString) {
                        chatBox.append(`<div class='date-separator'>${messageDateString}</div>`);
                        currentDate = messageDateString;
                    }

                    var messageContent;

                    if (message.message_type === 'image') {
                        var imageUrl = "{{ asset('') }}" + message.image_url;
                        messageContent = `<img src="${imageUrl}" alt="Imagen del chat" style="max-width: 100%; height: auto;">`;
                        if (message.message_text) {
                            messageContent += `<hr class="my-2"/>`;
                            messageContent += `<div class="image-caption mt-3">${message.message_text}</div>`;
                        }
                    } else if (message.message_type === 'audio') {
                        var audioUrl = "{{ asset('') }}" + message.audio_url;
                        messageContent = `<audio controls>
                                            <source src="${audioUrl}" type="audio/mpeg">
                                            Tu navegador no soporta la etiqueta de audio.
                                        </audio>`;
                        if (message.message_text) {
                            messageContent += `<hr class="my-2"/>`;
                            messageContent += `<div class="image-caption mt-3">${message.message_text}</div>`;
                        }
                    } else if (message.message_type === 'document') {
                        var documentUrl = "{{ asset('') }}" + message.document_url;
                        var documentName = documentUrl.split('/').pop();
                        messageContent = `<a href="${documentUrl}" target="_blank">📄 ${documentName}</a>`;
                        if (message.message_text) {
                            messageContent += `<hr class="my-2"/>`;
                            messageContent += `<div class="image-caption mt-3">${message.message_text}</div>`
                        }
                    } else if (message.message_type === 'video') {
                        var videoUrl = "{{ asset('') }}" + message.video_url;
                        messageContent = `<video controls>
                                            <source src="${videoUrl}" type="video/mp4">
                                            Tu navegador no soporta la etiqueta de video.
                                        </video>`;
                        if (message.message_text) {
                            messageContent += `<hr class="my-2"/>`;
                            messageContent += `<div class="image-caption mt-3">${message.message_text}</div>`; // Mostrar el subtítulo si está presente
                        }
                    } else if (message.message_type === 'sticker') {
                        var stickerUrl = "{{ asset('') }}" + message.sticker_url;
                        messageContent = `<img src="${stickerUrl}" alt="Sticker" style="max-width: 100%; height: auto;">`;
                    }   else {
                        messageContent = message.message_text;
                    }

                    var messageClass = message.from_phone_id == '{{ auth()->user()->franchise->phoneNumber->id }}' ? 'my-message' : 'other-message';
                    var messageElement = `<div class='${messageClass}'>
                                            <span>${messageContent}</span>
                                            <div class='message-time'>${formatTime(messageDate)}</div>
                                        </div>`;
                    chatBox.append(messageElement);
                });
                $('#chatWith').text(contactName);

                var loadedImages = 0;
                var totalImages = $('img', chatBox).length;

                $('img', chatBox).on('load', function() {
                    loadedImages++;
                    if (loadedImages === totalImages) {
                        chatBox.scrollTop(chatBox.prop("scrollHeight"));
                    }
                });

                if (totalImages === 0) {
                    chatBox.scrollTop(chatBox.prop("scrollHeight"));
                }
            },
            error: function(error) {
                console.log(error);
            }
        });
    }

    function onChatSelected(phoneNumberId, contactName) {
        $('#chatBox').data('active-chat', phoneNumberId);

        loadChatMessages(phoneNumberId, contactName);
    }

    function sendMessage() {
        var message = $('#messageInput').val();
        var phoneNumberId = 'TU_PHONE_NUMBER_ID';
        var to = 'DESTINATARIO'; 

        if (message) {
            $.ajax({
                url: '{{ route('whatsapp.send') }}',
                method: 'POST',
                data: {
                    phone_number_id: phoneNumberId,
                    to: to,
                    message: message,
                    type: 'text'
                },
                success: function(response) {
                    console.log('Mensaje enviado:', response);
                    // Lógica adicional después de enviar el mensaje
                },
                error: function(error) {
                    console.error('Error al enviar el mensaje:', error);
                }
            });
        }
    }

    function sendMediaMessage() {
        var file = $('#mediaInput')[0].files[0];
        var phoneNumberId = 'TU_PHONE_NUMBER_ID';
        var to = 'DESTINATARIO';
        var type = 'image';

        if (file) {
            var formData = new FormData();
            formData.append('media', file);
            formData.append('phone_number_id', phoneNumberId);
            formData.append('to', to);
            formData.append('type', type);

            $.ajax({
                url: '{{ route('whatsapp.sendMedia') }}',
                method: 'POST',
                processData: false,
                contentType: false,
                data: formData,
                success: function(response) {
                    console.log('Mensaje multimedia enviado:', response);
                },
                error: function(error) {
                    console.error('Error al enviar el mensaje multimedia:', error);
                }
            });
        }
    }
</script>


@endsection



