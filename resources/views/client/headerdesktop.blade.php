<style>
    .btn-circle.btn-xl { 
    width: 50px; 
    height: 50px; 
    border-radius: 35px; 
    font-weight: bold;
    padding:0px 0px;
    font-size:30px;
    text-align: center; 
    } 
    
    /* --dropdown setting-- */
    .dropdown{
    position: relative;
    display: inline-block;
    }

    .setting{
    display: none;
    position: absolute;
    overflow: auto;
    background-color: #eee;
    padding: 10px 10px;
    z-index: 1;
    border-radius: 5px;
    border: none;
    margin-top:0.4rem;
    }

    .setting a{
    font-size: 14px;
    text-decoration: none;
    display: block;
    line-height: 26px;
    }

    .setting a:hover{
    font-weight: bold;
    }

    .show{
    display: block;
    }

    @media (max-width: 768px) {
    .header-desktop{
    display: hide;
    }
    } 
    
</style>
<body>
    <div class="header-desktop" style="display: flex; 
    justify-content: space-between; padding-bottom:3rem;">
        <a href="#" style="margin-left:2rem;">
            @include('client.toogle')
            <div class="account">
                <div class="dropdown"  style="padding-top:0.5rem;">
                    <button onclick="settingdropdown()" type="button" class="btn btn-secondary btn-circle btn-xl" id="buttonsetting">
                    <img src="{{ URL::asset('global_assets/images/user-client-1.png') }}" height="34" alt="">
                    </button>
                    <span style="padding-left:0.5rem; font-weight:bold;">{{\Auth::user()->nama}}</span>
                    <div class="setting" id="dropdownlist">
                    <a href="">Ubah Password</a>
                    <a href="{{ url('/logout') }}">Sign Out</a>
                    </div>
                </div>
            </div>
        </a>
    </div>
</body>
<script>

     // dropdown setting
    function settingdropdown() {
    document.getElementById("dropdownlist").classList.toggle("show");
    }

    window.onclick = function(event) {
    if (!event.target.matches('#buttonsetting')) {
        var dropdowns = document.getElementById("dropdownlist");
        var i;
        for (i = 0; i < dropdowns.length; i++) {
        var openDropdown = dropdowns[i];
        if (openDropdown.classList.contains('show')) {
            openDropdown.classList.remove('show');
        }
        }
    }
    }
      // ---
</script>