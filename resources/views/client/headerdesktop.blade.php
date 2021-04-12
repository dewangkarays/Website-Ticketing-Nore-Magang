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
    width: 200px !important;
    background-color: #eee;
    padding: 10px 10px;
    z-index: 1;
    border-radius: 5px;
    border: none;
    margin-top:0.5rem;
    margin-left:120px;
    text-align:center;
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
    <div class="header-desktop" style="display: flex; justify-content: space-between; padding-bottom:3rem;">
        {{-- @include('client.toogle') --}}
        <div class="col"></div>
        <div class="account">
            <div class="dropdown"  style="padding-top:0.5rem;">
                <div class="keterangan" style="display:flex;">
                    <div class="status" style=" margin-right:1rem; padding-top:0.6rem;">
                        @if (@$highproyek->tipe=='80')
                            <p style="background-color: #D4AF37; color:#fff; border-radius:10px; padding:2px 8px;">
                                Pelanggan Premium
                            </p>
                        @elseif(@$highproyek->tipe=='90')
                            <p style="background-color: grey; color:#fff; border-radius:10px; padding:2px 8px;">
                                Pelanggan Prioritas
                            </p>
                        @elseif(@$highproyek->tipe=='99')
                            <p style="background-color:#fafafa; color:black; border-radius:10px; padding:2px 8px;">
                                Pelanggan Simple
                            </p>
                        @else
                            <a style="padding-right:0.5rem; padding-top:0.6rem; color:black;">
                                Belum berlangganan
                            </a>
                        @endif
                    </div>
                    <div class="ket-users" onclick="settingdropdown()" id="buttonsetting" style="display:flex;">
                        <button type="button" class="btn btn-secondary btn-circle btn-xl">
                                <img src="{{ URL::asset('global_assets/images/user-client-1.png') }}" height="34" alt="">
                        </button>
                        <p style="padding-left:0.5rem; padding-top:0.6rem; font-weight:bold; color:black; cursor:pointer;">{{\Auth::user()->nama}}</p>
                    </div>
                </div>
                <div class="setting" id="dropdownlist">
                    <a href="{{url('/settinguser')}}">Pengaturan</a>
                    <a href="{{ url('/logout') }}">Sign Out</a>
                </div>
            </div>
        </div>
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