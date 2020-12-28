<head>
  <style>
  #sidebar {
      /* min-width: 250px;
      max-width: 250px; */
      /* min-width: 20%;
      max-width: 20%; */
      width: 250px;
      position: fixed;
      top: 0;
      left: 0;
      height: 100vh;
      /* position: fixed; */
      z-index: 999;
    }

    #sidebar.active {
      margin-left: -250px;
    }

    .container.active{
      margin: 0 auto;
    }

    a, a:hover, a:focus {
      color: inherit;
      text-decoration: none;
      transition: all 0.3s;
    }

    #sidebar {
      background: #3EB772;
      color: #fff;
      transition: all 0.3s;
    }

    #sidebar .sidebar-header {
      padding: 20px;
      background: #3EB772;
    }

    #sidebar ul.components {
      padding: 20px 0;
    }

    #sidebar ul p {
      color: #fff;
      padding: 10px;
    }

    #sidebar ul li a {
      padding: 10px;
      font-size: 1.1em;
      display: block;
    }
    #sidebar ul li a:hover {
      color: #3EB772;
      font-weight: bold;
      background: #fff;
    }

    ul ul a {
      font-size: 0.9em !important;
      padding-left: 30px !important;
      background: #3EB772;
    }
    </style>
</head>
<body>
  <nav id="sidebar" class="sidebar">
    <div class="sidebar-header">
        <img src="{{ URL::asset('global_assets/images/nore_w_1000px.png') }}" alt="" style="width:100px; height:50px">
    </div>
    <ul class="list-unstyled components" style="padding-left:10px">
    <li>
      <a href="/dashboard">Dashboard</a>
    </li>
    <li>
      <a href="/tagihanclient">Tagihan</a>
    </li>
    <li>
      <a href="/payment">Bayar</a>
    </li>
    <li>
      <a href="/taskclient">Task</a>
    </li>
    <li>
      <a href="/antrian">Antrian</a>
    </li>
  </ul>
  <div class="row" style="padding-top:6rem;"></div>
  <h6 style=" font-weight:bold; padding-bottom:1rem; text-align:center;">Pusat Bantuan</h6>
      <div class="row" style="text-align:center">
        <div class="col">
          <a href="https://wa.me/6281335625529">
            <img src="{{ URL::asset('global_assets/images/wanew.png') }}" height="34px">
          </a>
        </div>
        <div class="col">
          <img src="{{ URL::asset('global_assets/images/mailnew.png') }}" height="34px">
        </div>
      </div>
</nav>
</body>