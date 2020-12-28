<head>
  <style>
      .dropdownsetting{
        position: relative;
        display:inline-block;
      }

      .setting-list{
        display: none;
        position: absolute;
        overflow: auto;
        background-color: #3EB772;
        z-index: 1;
        width: 100%;
      }

      .setting-list a{
        text-decoration: none;
        display: block;
        line-height: 26px;
        color:#fff;
        padding: 10px 0;
        font-size: 14px;
      }

      .setting-list a:hover{
        font-weight: bold;
        color: #fff;
      }

      .show{
        display: block;

      }


  </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg" style="background-color:#3EB772;  color:#fff;">
  <div class="container">
    <h4 style="padding-top:0.5rem; padding-bottom:0.5rem; font-weight:bold;">@yield('title')</h4>
    <div class="dropdownsetting">
      <button class="navbar-toggler navbar-toggler-right" type="button" id="settingbtn" onclick="settingbutton()">
        <img src="{{ URL::asset('global_assets/images/setting.png') }}" style="height: 25px">
      </button>
    </div>
  </div>
</nav>
  <div class="setting-list" id="setting-list">
    <div class="container">
      <a href="">Ubah Password</a>
      <a href="{{ url('/logout') }}">Sign Out</a>
    </div>
  </div>
<script>
  function settingbutton() {
    document.getElementById("setting-list").classList.toggle("show");
  }

  window.onclick = function(event) {
    if (!event.target.matches('#settingbtn')) {
        var dropdowns = document.getElementById("setting-list");
        var i;
        for (i = 0; i < dropdowns.length; i++) {
        var openDropdown = dropdowns[i];
        if (openDropdown.classList.contains('show')) {
            openDropdown.classList.remove('show');
        }
        }
    }
    }
</script>
</body>