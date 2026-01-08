   <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top" id="menu-principal">
       <div class="container">
           <a class="navbar-brand d-flex align-items-center" href="<?= base_url('login/autenticado') ?>">
               <img src="<?= base_url('assets/imgs/Gemini_Generated_Image_3y2rqt3y2rqt3y2r.png') ?>" width="160" height="100" class="d-inline-block align-text-top me-2">
           </a>
           <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#conteudoNavbar" aria-controls="conteudoNavbar" aria-expanded="false" aria-label="Toggle navigation">
               <span class="navbar-toggler-icon"></span>
           </button>
           <div class="collapse navbar-collapse" id="conteudoNavbar">
               <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                   <li class="nav-item">
                       <a class="nav-link" href="<?= base_url('usuarios') ?>">Usuários</a>
                   </li>
                   <li class="nav-item">
                       <a class="nav-link" href="<?= base_url('funcionarios') ?>">Funcionários</a>
                   </li>
                   <li class="nav-item">
                       <a class="nav-link" href="<?= base_url('produtos') ?>">Produtos</a>
                   </li>
                   <li class="nav-item">
                       <a class="nav-link" href="<?= base_url('metas') ?>">Metas</a>
                   </li>
                   <li class="nav-item">
                       <a class="nav-link" href="<?= base_url('vendas') ?>">Vendas</a>
                   </li>
               </ul>
               <div class="d-flex">
                   <a href="<?= base_url('login/logout') ?>" class="btn btn-outline-danger shadow-sm pt-2 pb-2 ps-3 pe-3 fw-bold rounded-pill">Sair <i class="fa-solid fa-right-from-bracket ms-2"></i></a>
               </div>
           </div>
       </div>
   </nav>