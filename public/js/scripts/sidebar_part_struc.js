var sidebar = document.getElementById("sidebar");

sidebar.innerHTML = `
<div id="sidebar_content">
    <div class="flex-nowrap">
      <div class="bg-dark">
        <div class=" justify-content-between d-flex flex-column align-items-center px-3 pt-3 text-white min-vh-100">
          <a href="/" class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-white text-decoration-none">
            <div>
              <img class="logo" src="../src/logo.jpg" alt="Logo FitnessP">
            </div>
            <div class="label fs-2 d-none d-sm-inline">FitnessP</div>
          </a>
          <div class="dropdown pb-4">
            <a class="dropdown-item" href="../logout.php">Se déconnecter</a>
          </div>
        </div>
      </div>
    </div>
  </div>`;
