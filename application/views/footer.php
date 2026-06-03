<footer class="footer py-4  ">
  <div class="container-fluid">
    <div class="row align-items-center justify-content-lg-between">
      <div class="col-lg-6 mb-lg-0 mb-4">
        <div class="copyright text-center text-sm text-muted text-lg-start">
          © <script>
            document.write(new Date().getFullYear())
          </script> by Kelompok 2
        </div>
      </div>
      <div class="col-lg-6">
        <ul class="nav nav-footer justify-content-center justify-content-lg-end">
          <li class="nav-item">
            <a href="javascript:void(0)" class="nav-link text-muted" data-bs-toggle="modal" data-bs-target="#aboutUsModal">About Us</a>
          </li>
          <li class="nav-item">
            <a href="https://www.creative-tim.com" class="nav-link text-muted" target="_blank">Creative Tim</a>
          </li>
        </ul>
      </div>
    </div>
  </div>
</footer>
</div>
</main>

<!-- about us -->
<div class="modal fade" id="aboutUsModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content border-0 shadow">
      <div class="modal-header bg-gradient-dark border-0">
        <h5 class="modal-title text-white font-weight-bold">
          <i class="fas fa-info-circle me-2"></i> About Us
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-4">
        <div class="text-center mb-4">
          <h3 class="font-weight-extrabold text-dark mb-2">
            StudioHead
          </h3>
          <p class="text-sm text-muted mx-auto" style="max-width: 500px;">
            Platform booking studio modern untuk kebutuhan podcast, live streaming, webinar, dan content production Anda.
          </p>
        </div>
        <hr class="horizontal dark my-4">
        <div class="d-flex align-items-center mb-3">
          <h6 class="font-weight-bold text-uppercase text-xs text-secondary letter-spacing-2 mb-0">
            Tim Pengembang
          </h6>
        </div>
        <div class="row g-3">
          <div class="col-md-4">
            <div class="card h-100 border shadow-none bg-gray-100 border-radius-lg text-center p-3">
              <div class="avatar avatar-lg bg-gradient-primary rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center text-white font-weight-bold shadow-sm" style="width: 60px; height: 60px;">
                PM
              </div>
              <h6 class="mb-1 text-dark font-weight-bold text-sm">Dhea Rahmawati S.</h6>
              <p class="text-xs text-muted mb-2">2350085001</p>
              <span class="badge bg-sm bg-gradient-primary border-radius-sm mx-auto">Fullstack Dev</span>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card h-100 border shadow-none bg-gray-100 border-radius-lg text-center p-3">
              <div class="avatar avatar-lg bg-gradient-info rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center text-white font-weight-bold shadow-sm" style="width: 60px; height: 60px;">
                BE
              </div>
              <h6 class="mb-1 text-dark font-weight-bold text-sm">Indra Gemanurlingga</h6>
              <p class="text-xs text-muted mb-2">2350085005</p>
              <span class="badge bg-sm bg-gradient-info border-radius-sm mx-auto">Backend Dev</span>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card h-100 border shadow-none bg-gray-100 border-radius-lg text-center p-3">
              <div class="avatar avatar-lg bg-gradient-success rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center text-white font-weight-bold shadow-sm" style="width: 60px; height: 60px;">
                FE
              </div>
              <h6 class="mb-1 text-dark font-weight-bold text-sm">Rafi Ibrahim</h6>
              <p class="text-xs text-muted mb-2">2350085010</p>
              <span class="badge bg-sm bg-gradient-success border-radius-sm mx-auto">Frontend Dev</span>
            </div>
          </div>
        </div>
        <hr class="horizontal dark my-4">
        <div class="text-center">
          <small class="text-xs text-muted font-weight-bold">
            StudioHead v1.0 • © <?= date('Y') ?> by Kelompok 2
          </small>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- ui -->
<div class="fixed-plugin">
  <a class="fixed-plugin-button text-dark position-fixed px-3 py-2">
    <i class="material-symbols-rounded py-2">settings</i>
  </a>
  <div class="card shadow-lg">
    <div class="card-header pb-0 pt-3">
      <div class="float-start">
        <h5 class="mt-3 mb-0">Material UI Configurator</h5>
        <p>See our dashboard options.</p>
      </div>
      <div class="float-end mt-4">
        <button class="btn btn-link text-dark p-0 fixed-plugin-close-button">
          <i class="material-symbols-rounded">clear</i>
        </button>
      </div>
      <!-- End Toggle Button -->
    </div>
    <hr class="horizontal dark my-1">
    <div class="card-body pt-sm-3 pt-0">
      <!-- Sidebar Backgrounds -->
      <div>
        <h6 class="mb-0">Sidebar Colors</h6>
      </div>
      <a href="javascript:void(0)" class="switch-trigger background-color">
        <div class="badge-colors my-2 text-start">
          <span class="badge filter bg-gradient-primary" data-color="primary" onclick="sidebarColor(this)"></span>
          <span class="badge filter bg-gradient-dark active" data-color="dark" onclick="sidebarColor(this)"></span>
          <span class="badge filter bg-gradient-info" data-color="info" onclick="sidebarColor(this)"></span>
          <span class="badge filter bg-gradient-success" data-color="success" onclick="sidebarColor(this)"></span>
          <span class="badge filter bg-gradient-warning" data-color="warning" onclick="sidebarColor(this)"></span>
          <span class="badge filter bg-gradient-danger" data-color="danger" onclick="sidebarColor(this)"></span>
        </div>
      </a>
      <!-- Sidenav Type -->
      <div class="mt-3">
        <h6 class="mb-0">Sidenav Type</h6>
        <p class="text-sm">Choose between different sidenav types.</p>
      </div>
      <div class="d-flex">
        <button class="btn bg-gradient-dark px-3 mb-2" data-class="bg-gradient-dark" onclick="sidebarType(this)">Dark</button>
        <button class="btn bg-gradient-dark px-3 mb-2 ms-2" data-class="bg-transparent" onclick="sidebarType(this)">Transparent</button>
        <button class="btn bg-gradient-dark px-3 mb-2  active ms-2" data-class="bg-white" onclick="sidebarType(this)">White</button>
      </div>
      <p class="text-sm d-xl-none d-block mt-2">You can change the sidenav type just on desktop view.</p>
      <!-- Navbar Fixed -->
      <div class="mt-3 d-flex">
        <h6 class="mb-0">Navbar Fixed</h6>
        <div class="form-check form-switch ps-0 ms-auto my-auto">
          <input class="form-check-input mt-1 ms-auto" type="checkbox" id="navbarFixed" onclick="navbarFixed(this)">
        </div>
      </div>
      <hr class="horizontal dark my-3">
      <div class="mt-2 d-flex">
        <h6 class="mb-0">Light / Dark</h6>
        <div class="form-check form-switch ps-0 ms-auto my-auto">
          <input class="form-check-input mt-1 ms-auto" type="checkbox" id="dark-version" onclick="darkMode(this)">
        </div>
      </div>
    </div>
  </div>
</div>
<!--   Core JS Files   -->
<script src="<?= base_url('assets/js/core/popper.min.js') ?>"></script>
<script src="<?= base_url('assets/js/core/bootstrap.min.js') ?>"></script>
<script src="<?= base_url('assets/js/plugins/perfect-scrollbar.min.js') ?>"></script>
<script src="<?= base_url('assets/js/plugins/smooth-scrollbar.min.js') ?>"></script>
<script>
  var win = navigator.platform.indexOf('Win') > -1;
  if (win && document.querySelector('#sidenav-scrollbar')) {
    var options = {
      damping: '0.5'
    }
    Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
  }
</script>
<!-- Github buttons -->
<script async defer src="https://buttons.github.io/buttons.js"></script>
<!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
<script src="<?= base_url('assets/js/material-dashboard.min.js?v=3.2.0') ?>"></script>
</body>

</html>