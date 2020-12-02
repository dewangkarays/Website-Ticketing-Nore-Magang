<style>
  @media (max-width: 768px) {

      .web{
        display: none;
      }

  }

  @media (min-width: 768px) {
      .mobile{
        display: none;
      }
  }
</style>
<body>
  <div class="web">
    @include('client.layout')
  </div>
  <div class="mobile">
    @include('client.index')
  </div>
</body>