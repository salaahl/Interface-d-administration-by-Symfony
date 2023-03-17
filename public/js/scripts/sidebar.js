var sidebar = document.getElementById("sidebar");

sidebar.innerHTML = `
<div id="sidebar-content">
    <div class="flex-nowrap">
      <div class="bg-dark">
        <div class="justify-sidebar-content d-flex flex-column align-items-center px-3 pt-3 text-white min-vh-100">
          <a href="/" class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-white text-decoration-none">
            <div>
              <img class="logo" src="../src/logo.jpg" alt="Logo FitnessP">
            </div>
            <div class="label fs-2 d-none d-sm-inline">FitnessP</div>
          </a>
          <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">
            <li class="nav-item">
              <a href="../template/partner_search.php" class="nav-link align-middle px-0">
                <div>
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-search" viewBox="0 0 16 16">
                    <path
                      d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                  </svg>
                </div>
                <div class="nav-text ms-1 d-none d-sm-inline">Recherche</div>
              </a>
            </li>
            <li class="nav-item">
              <a href="../template/partners.php" class="nav-link px-0 align-middle">
                <div>
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-card-list" viewBox="0 0 16 16">
                    <path
                      d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h13zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z" />
                    <path
                      d="M5 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 5 8zm0-2.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm0 5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm-1-5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0zM4 8a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0zm0 2.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0z" />
                  </svg>
                </div>
                <div class="nav-text ms-1 d-none d-sm-inline">Liste de mes partenaires</div>
              </a>
            </li>
          </ul>
          <div class="dropdown pb-4">
            <a class="dropdown-item" href="../logout.php">Se déconnecter</a>
          </div>
        </div>
      </div>
    </div>
  </div>`;
