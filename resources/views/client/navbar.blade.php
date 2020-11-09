<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>

/* css bootstrap */

        /*!
 * Start Bootstrap - New Age v5.0.8 (https://startbootstrap.com/themes/new-age)
 * Copyright 2013-2020 Start Bootstrap
 * Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-new-age/blob/master/LICENSE)
 */

        
    html,
    body {
        width: 100%;
        height: 100%;
    }

    #mainNav {
        /* border-color: rgba(34, 34, 34, 0.05); */
        background-color:#3EB772;
        transition: all .35s;
        font-weight: 200;
        /* letter-spacing: 1px; */
    }

    #footer{
      background-color: #ffff;
    }

    #mainNav .navbar-brand {
        color: #ffff;
        font-weight: 200;
        /* letter-spacing: 1px; */
    }

    #mainNav .navbar-brand:hover, #mainNav .navbar-brand:focus {
        color: #fcbd20;
    }

    #mainNav .navbar-toggler {
        font-size: 12px;
        padding: 8px 10px;
    }

    #mainNav .navbar-nav > li > a {
        font-size: 11px;
        letter-spacing: 2px;
    }

    #mainNav .navbar-nav > li > a.active {
    color: #fdcc52 !important;
    background-color: transparent;
    }

    #mainNav .navbar-nav > li > a.active:hover {
    background-color: transparent;
    }

    #mainNav .navbar-nav > li > a,
    #mainNav .navbar-nav > li > a:focus {
    color: #ffff;
    }

    #mainNav .navbar-nav > li > a:hover,
    #mainNav .navbar-nav > li > a:focus:hover {
    color: #fdcc52;
    }

    .md-dark { 
      color:#3EB772 !important; 
    }

    .contact h2{
      padding-bottom: 1em;
    }

@media (min-width: 992px) {
    #mainNav {
        border-color: transparent;
        background-color: transparent;
    }
    #mainNav .navbar-brand {
        color: fade(white, 70%);
    }
    #mainNav .navbar-brand:hover, #mainNav .navbar-brand:focus {
        color: white;
    }
    #mainNav .navbar-nav > li > a,
    #mainNav .navbar-nav > li > a:focus {
        color: rgba(255, 255, 255, 0.7);
    }
    #mainNav .navbar-nav > li > a:hover,
    #mainNav .navbar-nav > li > a:focus:hover {
        color: white;
    }
    #mainNav.navbar-shrink {
        border-color: rgba(34, 34, 34, 0.1);
        background-color: white;
    }
    #mainNav.navbar-shrink .navbar-brand {
        color: #ffff;
    }
    #mainNav.navbar-shrink .navbar-brand:hover, #mainNav.navbar-shrink .navbar-brand:focus {
        color: #fdcc52;
    }
    #mainNav.navbar-shrink .navbar-nav > li > a,
    #mainNav.navbar-shrink .navbar-nav > li > a:focus {
        color: #ffff;
    }
    #mainNav.navbar-shrink .navbar-nav > li > a:hover,
    #mainNav.navbar-shrink .navbar-nav > li > a:focus:hover {
        color: #fdcc52;
    }
    }

    </style>

</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
        <div class="container">
          <a class="navbar-brand js-scroll-trigger" href="#page-top">@yield('title')</a>
          <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
              {{-- <li class="nav-item">
                <img src="{{ URL::to('/assets/img/nore.png') }}" alt="" class="rounded-circle rounded-sm">
              </li> --}}
              <li class="nav-item">
                <a class="nav-link js-scroll-trigger" href="#">Ganti Password</a>
              </li>
              <li class="nav-item">
                <a class="nav-link js-scroll-trigger" href="#">Logout</a>
              </li>
            </ul>
          </div>
        </div>
      </nav>
</body>
</html>