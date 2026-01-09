<style>
    #widget-chat-aquaflow {
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 9999;
        font-family: sans-serif; 
    }

    #btn-abrir-chat {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background-color: #0d6efd;
        color: white;
        border: none;
        box-shadow: 2px 2px 5px rgba(0,0,0,0.2);
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
    }

    #btn-abrir-chat:hover {
        background-color: #0b5ed7;
    }

    #janela-chat {
        display: none;
        position: absolute;
        bottom: 70px;
        right: 0;
        width: 350px;
        height: 450px;
        background-color: #fff;
        border: 1px solid #ccc;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        flex-direction: column;
        overflow: hidden;
    }

    #janela-chat.aberto {
        display: flex;
    }

    .cabecalho-chat {
        background-color: #0d6efd;
        color: white;
        padding: 10px 15px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-weight: bold;
    }

    .btn-fechar {
        background: none;
        border: none;
        color: white;
        font-size: 18px;
        cursor: pointer;
    }

    #area-mensagens {
        flex: 1;
        padding: 15px;
        overflow-y: auto;
        background-color: #f8f9fa; 
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .mensagem {
        max-width: 80%;
        padding: 8px 12px;
        border-radius: 8px;
        font-size: 14px;
        line-height: 1.4;
    }

    .mensagem.usuario {
        align-self: flex-end;
        background-color: #0d6efd;
        color: white;
    }

    .mensagem.ia {
        align-self: flex-start;
        background-color: #e9ecef; 
        color: #333;
        border: 1px solid #dee2e6;
    }

    .mensagem.ia strong { font-weight: bold; }
    .mensagem.ia ul { padding-left: 20px; margin: 5px 0; }

    .area-input {
        padding: 10px;
        border-top: 1px solid #ccc;
        background-color: white;
        display: flex;
        gap: 5px;
    }

    #input-mensagem {
        flex: 1;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
        outline: none;
    }

    #btn-enviar {
        background-color: #0d6efd;
        color: white;
        border: none;
        padding: 0 15px;
        border-radius: 4px;
        cursor: pointer;
    }

    .digitando {
        font-style: italic;
        color: #666;
        font-size: 12px;
        margin-bottom: 5px;
        padding-left: 10px;
    }
</style>

<div id="widget-chat-aquaflow">
    
    <div id="janela-chat">
        <div class="cabecalho-chat">
            <span>FlowBot</span>
            <button class="btn-fechar" id="btn-fechar">X</button>
        </div>

        <div id="area-mensagens">
            <div class="mensagem ia">
                Olá! Sou o assistente do sistema. Pode perguntar sobre as vendas.
            </div>
        </div>

        <div class="area-input">
            <input type="text" id="input-mensagem" placeholder="Digite sua pergunta..." autocomplete="off">
            <button id="btn-enviar">></button>
        </div>
    </div>

    <button id="btn-abrir-chat">
        <i class="fas fa-comment"></i>
    </button>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        
        const btnAbrir = document.getElementById('btn-abrir-chat');
        const janelaChat = document.getElementById('janela-chat');
        const btnFechar = document.getElementById('btn-fechar');
        const inputMsg = document.getElementById('input-mensagem');
        const btnEnviar = document.getElementById('btn-enviar');
        const areaMensagens = document.getElementById('area-mensagens');

        const urlApi = '<?= base_url("index.php/ai/ask") ?>';

        btnAbrir.addEventListener('click', function() {
            if (janelaChat.classList.contains('aberto')) {
                janelaChat.classList.remove('aberto');
            } else {
                janelaChat.classList.add('aberto');
                inputMsg.focus();
            }
        });

        btnFechar.addEventListener('click', function() {
            janelaChat.classList.remove('aberto');
        });

        function enviarMensagem() {
            let textoUsuario = inputMsg.value.trim();
            
            if (textoUsuario === "") {
                return;
            }

            adicionarSalao(textoUsuario, 'usuario');
            inputMsg.value = '';

            let idCarregando = mostrarDigitando();

            fetch(urlApi, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: 'message=' + encodeURIComponent(textoUsuario)
            })
            .then(resposta => resposta.json())
            .then(dados => {
                removerElemento(idCarregando);

                if (dados.response) {
                    let textoFormatado = formatarMarkdown(dados.response);
                    adicionarSalao(textoFormatado, 'ia');
                } else {
                    adicionarSalao('Erro: A IA não respondeu.', 'ia');
                }
            })
            .catch(erro => {
                console.error('Erro no sistema:', erro);
                removerElemento(idCarregando);
                adicionarSalao('Erro de conexão.', 'ia');
            });
        }

        function adicionarSalao(texto, tipo) {
            let divMensagem = document.createElement('div');
            divMensagem.className = 'mensagem ' + tipo;
            divMensagem.innerHTML = texto;
            
            areaMensagens.appendChild(divMensagem);
            areaMensagens.scrollTop = areaMensagens.scrollHeight;
        }


        function formatarMarkdown(texto) {

            let html = texto.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');
            html = html.replace(/^\* (.*?)$/gm, '<br>• $1');
            html = html.replace(/\n/g, '<br>');
            return html;
        }

        function mostrarDigitando() {
            let id = 'digitando-' + Date.now();
            let div = document.createElement('div');
            div.id = id;
            div.className = 'digitando';
            div.innerText = 'FlowBot está digitando...';
            areaMensagens.appendChild(div);
            areaMensagens.scrollTop = areaMensagens.scrollHeight;
            return id;
        }

        function removerElemento(id) {
            let elemento = document.getElementById(id);
            if (elemento) {
                elemento.remove();
            }
        }

        btnEnviar.addEventListener('click', enviarMensagem);
        
        inputMsg.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                enviarMensagem();
            }
        });
    });
</script>