<head>
    <style>
 #sidebar {
      min-width: 250px;
      max-width: 250px;
      min-height: 100vh;
    }

    #sidebar.active {
      margin-left: -250px;
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
        <h3 style="font-size: 24px">Nore</h3>
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
      <div class="row text-center">
        <div class="col">
          <button type="button" class="btn btn-success btn-sm">
            <img src="" alt="" class="rounded">
            <span class="material-icons" id="wa">
              sms
              </span>
            <p>Whatsapp</p>
          </button>
        </div>
        <div class="col">
          <button type="button" class="btn btn-primary btn-sm" id="btnmail">
            <img src="" alt="" class="rounded">
            <span class="material-icons" id="mail">
              mail
              </span>
            <p>Email</p>
          </button>
        </div>
      </div>
</nav>
</body>