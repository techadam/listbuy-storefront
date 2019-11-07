<div class="wrapper border-bottom">
  <div class="container">
      <nav class="bg-default px-3">
          <div class="nav-content py-2">
            <h5><a href="/stores/{{$slug}}" class="text-dark">Listbuy</a></h5>
            <div class="nav-menu">
              <ul class="nav-items pt-2">
                <li>
                  <a href="/" class="text-dark"><i class="fa fa-search"></i> Store finder</a>
                </li>
                <li>
                    <a href="/cart" class="cart-icon"><i class="fa fa-shopping-cart"></i><span class="cart-badge">{{Cart::count()}}</span></a>
                </li>
              </ul>
            </div>
          </div>
      </nav>
  </div>
</div>