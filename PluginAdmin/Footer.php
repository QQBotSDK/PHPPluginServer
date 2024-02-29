
  <!--start switcher-->
  <button class="btn btn-primary position-fixed bottom-0 end-0 m-3 d-flex align-items-center gap-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#staticBackdrop">
    <i class="material-icons-outlined">tune</i>自定义设置
  </button>
  
  <div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="staticBackdrop">
    <div class="offcanvas-header border-bottom h-70">
      <div class="">
        <h5 class="mb-0">自定义主题</h5>
        <p class="mb-0">自定义您的主题</p>
      </div>
      <a href="javascript:;" class="primaery-menu-close" data-bs-dismiss="offcanvas">
        <i class="material-icons-outlined">close</i>
      </a>
    </div>
    <div class="offcanvas-body">
      <div>
        <p>更改主题</p>

        <div class="row g-3">
          <div class="col-12 col-xl-6">
            <input type="radio" class="btn-check" name="theme-options" id="LightTheme" checked>
            <label class="btn btn-outline-secondary d-flex flex-column gap-1 align-items-center justify-content-center p-4" for="LightTheme">
              <span class="material-icons-outlined">light_mode</span>
              <span>日间</span>
            </label>
          </div>
          <div class="col-12 col-xl-6">
            <input type="radio" class="btn-check" name="theme-options" id="DarkTheme">
            <label class="btn btn-outline-secondary d-flex flex-column gap-1 align-items-center justify-content-center p-4" for="DarkTheme">
              <span class="material-icons-outlined">dark_mode</span>
              <span>夜间</span>
            </label>
          </div>
          <div class="col-12 col-xl-6">
            <input type="radio" class="btn-check" name="theme-options" id="SemiDarkTheme">
            <label class="btn btn-outline-secondary d-flex flex-column gap-1 align-items-center justify-content-center p-4" for="SemiDarkTheme">
              <span class="material-icons-outlined">contrast</span>
              <span>半夜间</span>
            </label>
          </div>
          <div class="col-12 col-xl-6">
            <input type="radio" class="btn-check" name="theme-options" id="BoderedTheme">
            <label class="btn btn-outline-secondary d-flex flex-column gap-1 align-items-center justify-content-center p-4" for="BoderedTheme">
              <span class="material-icons-outlined">border_style</span>
              <span>接壤</span>
            </label>
          </div>
        </div><!--end row-->

      </div>
    </div>
  </div>
  <!--start switcher-->
  <!--bootstrap js-->
  <script src="../Assets/Js/bootstrap.bundle.min.js"></script>

  <!--plugins-->
  <script src="../Assets/Js/jquery.min.js"></script>
  <!--plugins-->
  <script src="../Assets/Plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
  <script src="../Assets/Plugins/metismenu/metisMenu.min.js"></script>
  <script src="../Assets/Plugins/apexchart/apexcharts.min.js"></script>
  <script src="../Assets/Js/index.js"></script>
  <script src="../Assets/Plugins/peity/jquery.peity.min.js"></script>
  
  <script src="../Assets/Plugins/bs-stepper/js/bs-stepper.min.js"></script>
	<script src="../Assets/Plugins/bs-stepper/js/main.js"></script>
	
  <!--notification js -->
	<script src="../Assets/Plugins/notifications/js/lobibox.min.js"></script>
	<script src="../Assets/Plugins/notifications/js/notifications.min.js"></script>
  <script src="https://cdn.staticfile.net/select2/4.1.0-rc.0/js/select2.min.js"></script>
	<script src="../Assets/Plugins/select2/js/select2-custom.js"></script>
  <script>
    $(".data-attributes span").peity("donut")
	</script>
    <script>
      $(document).ready(function () {
        $("#show_hide_password a").on('click', function (event) {
          event.preventDefault();
          if ($('#show_hide_password input').attr("type") == "text") {
            $('#show_hide_password input').attr('type', 'password');
            $('#show_hide_password i').addClass("bi-eye-slash-fill");
            $('#show_hide_password i').removeClass("bi-eye-fill");
          } else if ($('#show_hide_password input').attr("type") == "password") {
            $('#show_hide_password input').attr('type', 'text');
            $('#show_hide_password i').removeClass("bi-eye-slash-fill");
            $('#show_hide_password i').addClass("bi-eye-fill");
          }
        });
      });
    </script>
  <script>
		$(function () {
			$('[data-bs-toggle="popover"]').popover();
			$('[data-bs-toggle="tooltip"]').tooltip();
		})
	</script>
  <script src="../Assets/Js/main.js"></script>

</body>

</html>